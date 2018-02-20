<?php

class Uploading{

	private $thumbnail_widths = array( 120 );
	public $image_upload_folder = 'uploads/images/';
	public $files_upload_folder = '../uploads/files/';

	public function add( $user_id, $title, $url, $info, $date ){
		global $db;

		$result = $db->insert( $db->prefix.'uploads', array(
			'user_id' => $user_id,
			'title' => $title,
			'url' => $url,
			'info' => $info,
			'date' => $date
			) );

		return ( $result > 0 ) ? $result : false;

	}

	public function get_attached_files( $ids ){
		global $db;

		return $db->query("SELECT * FROM ".$db->prefix."uploads WHERE id IN($ids) ORDER BY id DESC");
	}

	function make_upload_folder( $dir_name ){
		$oldumask = umask(0);
		mkdir( $dir_name, 0775 );
		umask( $oldumask );
	}

	function get_image_upload_subfolder(){
		$upload_folder = $this->image_upload_folder;
		$year = date("Y");
		$month = date("m");
		$year_dir = $upload_folder . $year;
		$month_dir = $year_dir . "/" . $month;
		if ( !is_dir( $year_dir ) ) {
			$this->make_upload_folder( $year_dir );
		}
		if ( !is_dir( $month_dir ) ) {
			$this->make_upload_folder( $month_dir );
		}
		return $year . "/" . $month;
	}

	function get_files_upload_subfolder(){
		$upload_folder = $this->files_upload_folder;
		$year = date("Y");
		$month = date("m");
		$year_dir = $upload_folder . $year;
		$month_dir = $year_dir . "/" . $month;
		if ( !is_dir( $year_dir ) ) {
			$this->make_upload_folder( $year_dir );
		}
		if ( !is_dir( $month_dir ) ) {
			$this->make_upload_folder( $month_dir );
		}
		return $year . "/" . $month;
	}

	function get_extension( $file_name ){
		$temp = explode(".", $file_name );
		return end( $temp );
	}

	function generate_image_name( $prefix = "" ){
		return $prefix . time();
	}

	function generate_file_name( $prefix = "" ){
		return $prefix . time();
	}

	function thumbnail_image_name( $basename, $thumbnail_width ){
		return $basename . "-" . $thumbnail_width . ".jpg";
	}

	function make_thumbnails( $uploaded_folder, $image_name, $extension ){
		$thumbnail_widths = $this->thumbnail_widths;
		$uploadedfile = $uploaded_folder . "/" . $image_name . "." . $extension;

		/* Image creating */
		if( $extension == "jpg" || $extension == "jpeg" ){
			$src = imagecreatefromjpeg( $uploadedfile );
		}else if( $extension == "png" ){
			$src = imagecreatefrompng( $uploadedfile );
		}else{
			$src = imagecreatefromgif( $uploadedfile );
		}

		list( $width, $height ) = getimagesize( $uploadedfile );

		foreach ( $thumbnail_widths as $thumbnail_width ) {
            $new_height = ( $height / $width ) * $thumbnail_width;
            $tmp = imagecreatetruecolor( $thumbnail_width, $new_height );
            imagecopyresampled( $tmp, $src, 0, 0, 0, 0, $thumbnail_width, $new_height, $width, $height );
			$filename = $this->thumbnail_image_name( $uploaded_folder . "/" . $image_name, $thumbnail_width );
			imagejpeg( $tmp, $filename, 100 );
			imagedestroy($tmp);
		}
		imagedestroy($src);
	}

	function remove_extension( $filename ){
		return preg_replace( "/\\.[^.\\s]{3,4}$/", "", $filename );
	}

	function delete_image_thumbnails( $file ){
		$extension = $this->get_extension( $file );
		$thumbnail_widths = $this->thumbnail_widths;
		$filename = $this->remove_extension( $file );
		foreach ( $thumbnail_widths as $thumbnail_width ){
			$this->delete_file_physically( $this->thumbnail_image_name( $filename, $thumbnail_width ) );
		}
	}

	function delete_file_physically( $file ){
		if( file_exists( $file ) ){
			unlink( $file );
		}
	}

	function upload_image( $prefix = '', $index = "file" ){
		$success = false;
		$error_msg = "";
		$error = 0;
		if ( $_FILES[$index]["error"] > 0 ){
			$error = 1;
			$error_msg = $_FILES[$index]["error"];
		}else{
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$extension = $this->get_extension( $_FILES[$index]["name"] );
			if ((($_FILES[$index]["type"] == "image/gif")
			|| ($_FILES[$index]["type"] == "image/jpeg")
			|| ($_FILES[$index]["type"] == "image/jpg")
			|| ($_FILES[$index]["type"] == "image/pjpeg")
			|| ($_FILES[$index]["type"] == "image/x-png")
			|| ($_FILES[$index]["type"] == "image/png"))
			&& ($_FILES[$index]["size"] < ( 3 * 1000 * 1024 ) )
			&& in_array( $extension, $allowedExts ) ){

				// All ok, save image
				$image_name = $this->generate_image_name( $prefix );
				$full_name = $image_name . "." . $extension;
				$upload_subfolder = $this->get_image_upload_subfolder();

				if( move_uploaded_file( $_FILES[$index]["tmp_name"], $this->image_upload_folder . $upload_subfolder . "/" . $full_name ) ){
					$success = true;

					// create thumbnails
					$this->make_thumbnails( $this->image_upload_folder . $upload_subfolder, $image_name, $extension );
				}

			}else{
				$error = 1;
				$error_msg = "Wrong file type.";
			}
		}

		if( $success ){
			return $upload_subfolder . "/" . $full_name;
		}else{
			return false;
		}
	}

	function upload_file(){
		global $current_user, $db;
		$allowed = array( 'tiff', 'gif', 'jpg', 'jpeg', 'png', 'doc', 'docx', 'pdf', 'csv' );

		if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

			$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

			if(!in_array(strtolower($extension), $allowed)){
		        echo '{"status":"error"}';
		        exit;
		    }

		    $file_name = $this->generate_file_name( "file-" );
			$full_name = $file_name . "." . $extension;
		    $upload_subfolder = $this->get_files_upload_subfolder();

		    if(move_uploaded_file($_FILES['upl']['tmp_name'], $this->files_upload_folder . $upload_subfolder . "/" . $full_name)){
		    	$upload_id = $this->add( $current_user->id, $db->friendly( $_FILES['upl']['name'] ), $upload_subfolder . "/" . $full_name, '', date('Y-m-d H:i:s') );
		        if( $upload_id > 0 ){
		        	echo '{"status":"success", "id":"'.$upload_id.'"}';
		        }else{
		        	echo '{"status":"error"}';
		        }
		        
		        exit;
		    }

		}

		echo '{"status":"error"}';
		exit;
	}
}

?>