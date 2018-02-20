<?php

class User extends BasicElement{
	/**
	* Table "user" columns: id, email, password, first_name, last_name, role, image, comment, status, date
	*/

	public $table_name = 'user';
	public $order_by = "id";
	public $role = 0;
    public $client_id = 0;
	function add( $email, $db_password, $first_name, $last_name, $role, $location, $physicians, $comment, $image, $date ){
		global $db;

		$result = $db->insert( $db->prefix . $this->table_name, array(
			'email' => $email,
			'password' => $db_password,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'role' => '2',
			'location' => $location,
			'physicians' => $physicians,
			'comment' => $comment,
			'image' => $image,
			'status' => '1',
			'date' => $date
			) );
		return ( $result > 0 ) ? $result : false;
	}

	public function update( $id, $email, $first_name, $last_name, $role, $location, $physicians, $comment, $image ){
		global $db;

		$update_array = array(
				'first_name' => $first_name,
				'last_name' => $last_name,
				'email' => $email,
				'role' => $role,
				'location' => $location,
				'physicians' => $physicians,
				'comment' => $comment
			);

		if( $image == 'remove' ){
			$update_array["image"] = '';
		}elseif( $image && strlen($image) > 3 ){
			$update_array["image"] = $image;
		}

		$result = $db->update(
			$db->prefix . $this->table_name,
			$update_array,
			array(
				'id' => $id
			)
		);

		return ( $result > 0 || $result === 0 ) ? true : false;
	}

	function generate_password( $password ){
		return md5( $password );
	}

	function check_password( $email, $password ){
		$output = false;

		$db_password = $this->generate_password( $password );
		if( $this->user_exist( $email, $db_password ) ){
			$output = $this->get_id_by_username_and_pass( $email, $db_password );
		}

		return $output;
	}

	function change_password( $email, $password ){
		global $db;
		$db_password = $this->generate_password( $password );

		$result = $db->update(
			$db->prefix . 'users',
			array(
				'password' => $db_password
				),
			array(
				'email' => $email
			)
		);

		return ( $result > 0 || $result === 0 ) ? true : false;
	}

	function user_exist( $email, $db_password ){
		global $db;
		$sqlQuery = "SELECT * FROM " . $db->prefix . "user WHERE email = '$email' AND password = '$db_password' AND status='1'";
		$result = $db->query( $sqlQuery );
		if(count((array)$result) > 0){
            $this->role = $result[0]->role;
            return true;
        }else{
		    return false;
        }
	}

	function get_id_by_username_and_pass( $email, $db_password ){
		global $db;
		$id = $db->get_data( "SELECT id FROM " . $db->prefix . "user WHERE email = '$email' AND password = '$db_password'" );
		return ( $id > 0 ) ? $id : false;
	}

	function email_exist( $email ){
		global $db;
		$count = $db->get_data( "SELECT COUNT(id) FROM " . $db->prefix . "user WHERE email = '$email'" );
		return ( $count > 0 ) ? true : false;
	}

	function login( $email, $password ){
		$output = false;
		if( $this->check_email_format( $email ) && $this->check_password_format( $password ) ){
			
			if( $user_id = $this->check_password( $email, $password ) ){
				$this->create_user_session( $user_id );
				$output = true;
			}
		}
		return $output;
	}

    function selected_client( $id ){
        $output = false;
        if( $id != null ){
            $this->create_user_session( $id );
            $output = true;
        }
        return $output;
    }

	function logout(){
		unset( $_SESSION["user_id"] );
		session_destroy();
	}

	function create_user_session( $user_id ){
		$_SESSION["user_id"] = $user_id;
		$this->client_id=$this->get_client_by_user($user_id);
	}

	function register( $email, $password, $first_name, $last_name, $role, $location, $physicians, $comment, $image, $date ){
		$success = false;
		if( !$this->email_exist( $email ) && $this->check_email_format( $email ) && $this->check_password_format( $password ) ){
			$db_password = $this->generate_password( $password );
			$success = $this->add( $email, $db_password, $first_name, $last_name, $role, $location, $physicians, $comment, $image, $date );
		}
		return $success;
	}

	function check_email_format( $email ){
		$output = false;
		if( filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		    $output = true;
		}
		return $output;
	}

	function check_password_format( $password ){
		$output = false;
		if( strlen( $password ) >= 6 ){
			$output = true;
		}
		return $output;
	}

	function is_loggedin(){
		return ( isset( $_SESSION["user_id"] ) && $_SESSION["user_id"] > 0 ) ? true : false;
	}

	function get_user_data_from_db( $user_id ){
		global $db;
		return $db->query( "SELECT * FROM " . $db->prefix . "user WHERE id = '$user_id'" );
	}

	function get_user_by_email( $email ){
		global $db;
		return $db->query( "SELECT * FROM " . $db->prefix . "user WHERE email = '$email' LIMIT 1" );
	}

	function get_user( $user_id = 0 ){
		$output = false;
		
		if( $user_id > 0 ){
			$output = $this->get_user_data_from_db( $user_id );
		}

		return $output;
	}

	function current_user_id(){
		return $_SESSION["user_id"];
	}

	function set_profile_image( $image, $user_id = 0 ){
		global $db;
		$user_id = ( $user_id > 0 ) ? $user_id : current_user_id();
		$db->update(
			$db->prefix . 'user',
			array(
				'image' => $image
			),
			array(
				'id' => $user_id
			)
		);
	}
	
	function get_active_users( $page = 1, $per_page = 10 ){
		global $db;

		$from = ( $page - 1 ) * $per_page;
		$to = $page * $per_page;

		return $db->query( "SELECT * FROM " . $db->prefix . "user WHERE status = '1' ORDER BY id DESC LIMIT $from, $to" );
	}

	function get_all_active_users(){
		global $db;
		return $db->query( "SELECT * FROM " . $db->prefix . "user WHERE status = '1' ORDER BY id DESC" );
	}

	public function get_locations_by_user( $user_id = 0 ){
		global $db;
		$result = $db->get_data( "SELECT location FROM " . $db->prefix . $this->table_name . " WHERE id = '$user_id' LIMIT 1" );
		return ( $result > 0 ) ? $result : 0;	
	}


	public function search( $page, $per_page, $status = 1, $name = "", $role = "", $location = "", $timeframe = "" ){
		global $db;

		$from = ( $page - 1 ) * $per_page;
		$to = $page * $per_page;

		$where = " WHERE status = '$status'";

		if( strlen(trim($name)) > 0 ){

			$name = trim($name);
			$name = explode(' ', $name);
			$search = implode('|', $name);

			$where .= " AND CONCAT(first_name, ' ', last_name) REGEXP '$search'";
		}

		if( $role > 0 ){
			$where .= " AND role = '$role'";
		}

		if( $location > 0 ){
			$where .= " AND location = '$location'";
		}

		if( is_valid_timeframe( $timeframe ) ){
			$where .=  get_timeframe_search_query( $timeframe );
		}

		return $db->query( "SELECT * FROM " . $db->prefix . "user $where ORDER BY id DESC LIMIT $from, $to" );
	}

	public function total_search( $status = 1, $name = "", $role = "", $location = "", $timeframe = "" ){
		global $db;

		$where = " WHERE status = '$status'";

		if( strlen(trim($name)) > 0 ){

			$name = trim($name);
			$name = explode(' ', $name);
			$search = implode('|', $name);

			$where .= " AND CONCAT(first_name, ' ', last_name) REGEXP '$search'";
		}

		if( $role > 0 ){
			$where .= " AND role = '$role'";
		}

		if( $location > 0 ){
			$where .= " AND location = '$location'";
		}

		if( is_valid_timeframe( $timeframe ) ){
			$where .=  get_timeframe_search_query( $timeframe );
		}

		return $db->get_data( "SELECT COUNT(id) FROM " . $db->prefix . "user $where ORDER BY id DESC" );
	}

	public function full_name( $id ){
		global $db;
		return $db->get_data( "SELECT CONCAT(first_name, ' ', last_name) FROM " . $db->prefix . "user WHERE id = '$id' LIMIT 1" );
	}

	public function get_client_by_user( $id ){
        global $db;
        return $db->get_data( "SELECT client_id FROM " . $db->prefix . $this->table_name ." WHERE id = '$id' LIMIT 1" );
    }

    public function get_user_by_client_id( $ids ){
        global $db;
        if( $ids == "" ){
            $ids = '0';
        }
        $a = "SELECT * FROM " . $db->prefix . $this->table_name . " WHERE client_id IN($ids)";
        return $db->query( "SELECT * FROM " . $db->prefix . $this->table_name . " WHERE client_id IN($ids)" );
    }

    public function totals($user_id){
        global $db, $user;

        $where = " where p.user_id=$user_id";
        $join = "";


        $sqlQuery = "SELECT COUNT(p.id) FROM professional p" .$join . $where;
        return $db->get_data( $sqlQuery );
    }
}

?>