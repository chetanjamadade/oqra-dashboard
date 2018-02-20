<?php

class Location extends BasicElement{

	public $table_name = "location";
	public $order_by = "location_name";
	public $total = 0;

	function add( $street, $zip, $name, $city, $state,$latitude,$longitude,
                  $ex_satisfied_txt, $very_satisfied_text, $satisfied_text, $dissatisfied_text,
                  $very_dissat_text, $thank_you, $voice_text,
                  $video_text , $email_image_4_5, $email_image_3_under,$email_4_5, $email_3_under,
                  $email_address_4_5, $email_address_3_under,
                  $sms_4_5, $sms_3_under, $admin_email,
                  $ap_enabled, $ap_text, $ap_url,
                  $link_fb, $active_fb, $link_twitter,
                  $desc_twitter, $active_twitter, $link_pinterest,
                  $desc_pinterest, $active_pinterest, $link_yelp,
                  $active_yelp, $link_google,
                  $active_google, $current_user, $client_id )
    {
        global $db;

        $result = $db->insert($db->prefix . 'location', array(
            'state' => $state,
            'street' => $street,
            'zip_code' => $zip,
            'location_name' => $name,
            'city' => $city,
            'status' => '1',
            'client_id' => $client_id,
            'user_id' => $current_user,
            'latitude' => $latitude,
            'longitude'=>$longitude
        ));
        //return ( $result > 0 ) ? $result : false;
        if ($result > 0) {
            $location_id = $db->insert_id;
            $result_conf = false;
            $result_conf = $db->insert($db->prefix . 'location_configuration', array(
                'location_id' => $location_id,
                'ex_satisfied_txt' => $ex_satisfied_txt,
                'very_satisfied_text' => $very_satisfied_text,
                'satisfied_text' => $satisfied_text,
                'dissatisfied_text' => $dissatisfied_text,
                'very_dissat_text' => $very_dissat_text,
                'thank_you' => $thank_you,
                'voice_text' => $voice_text,
                'video_text' => $video_text,
                'email_image_4_5' => $email_image_4_5,
                'email_image_3_under' => $email_image_3_under,
                'email_4_5' => $email_4_5,
                'email_3_under' => $email_3_under,
                'email_address_4_5' => $email_address_4_5,
                'email_address_3_under' => $email_address_3_under,
                'sms_4_5' => $sms_4_5,
                'sms_3_under' => $sms_3_under,
                'admin_email' => $admin_email,
                'ap_enabled' => $ap_enabled,
                'ap_text' => $ap_text,
                'ap_url' => $ap_url,
                'link_fb' => $link_fb,
                'active_fb' => $active_fb,
                'link_twitter' => $link_twitter,
                'desc_twitter' => $desc_twitter,
                'active_twitter' => $active_twitter,
                'link_pinterest' => $link_pinterest,
                'desc_pinterest' => $desc_pinterest,
                'active_pinterest' => $active_pinterest,
                'link_yelp' => $link_yelp,
                'active_yelp' => $active_yelp,
                'link_google' => $link_google,
                'active_google' => $active_google,
                'status' => '1',
                'user_id' => $current_user
            ));
            return ( $result_conf > 0 ) ? $result_conf : false;
        }
        else
        {
            return false;
        }
    }

	public function update( $id, $street, $zip, $name, $city, $state, $latitude, $longitude, $lc_id,
                            $ex_satisfied_txt, $very_satisfied_text, $satisfied_text, $dissatisfied_text,
                            $very_dissat_text, $thank_you, $voice_text,
                            $video_text, $image_4_5, $image_3_under ,$email_4_5, $email_3_under,
                            $email_address_4_5, $email_address_3_under,
                            $sms_4_5, $sms_3_under, $admin_email,
                            $ap_enabled, $ap_text, $ap_url,
                            $link_fb, $active_fb, $link_twitter,
                            $desc_twitter, $active_twitter, $link_pinterest,
                            $desc_pinterest, $active_pinterest, $link_yelp,
                            $active_yelp, $link_google,
                            $active_google, $current_user, $client_id ){
		global $db;

		$update_array = array(
            'state' => $state,
            'street' => $street,
            'zip_code' => $zip,
            'location_name' => $name,
            'city' => $city,
            'status' => '1',
            'latitude' => $latitude,
            'longitude' => $longitude,
            'client_id' => $client_id,
            'user_id' => $current_user
			);

	/*	if( $image == 'remove' ){
			$update_array["image"] = '';
		}elseif( $image && strlen($image) > 3 ){
			$update_array["image"] = $image;
		}*/

		$result = $db->update(
			$db->prefix . $this->table_name,
			$update_array,
			array(
				'id' => $id
			)
		);
        if($result > 0 || $result === 0){
            $update_array = array(
                'ex_satisfied_txt' => $ex_satisfied_txt,
                'very_satisfied_text' => $very_satisfied_text,
                'satisfied_text' => $satisfied_text,
                'dissatisfied_text' => $dissatisfied_text,
                'very_dissat_text' => $very_dissat_text,
                'thank_you' => $thank_you,
                'voice_text' => $voice_text,
                'video_text' => $video_text,
                'email_4_5' => $email_4_5,
                'email_3_under' => $email_3_under,
                'email_address_4_5' => $email_address_4_5,
                'email_address_3_under' => $email_address_3_under,
                'sms_4_5' => $sms_4_5,
                'sms_3_under' => $sms_3_under,
                'admin_email' => $admin_email,
                'ap_enabled' => $ap_enabled,
                'ap_text' => $ap_text,
                'ap_url' => $ap_url,
                'link_fb' => $link_fb,
                'active_fb' => $active_fb,
                'link_twitter' => $link_twitter,
                'desc_twitter' => $desc_twitter,
                'active_twitter' => $active_twitter,
                'link_pinterest' => $link_pinterest,
                'desc_pinterest' => $desc_pinterest,
                'active_pinterest' => $active_pinterest,
                'link_yelp' => $link_yelp,
                'active_yelp' => $active_yelp,
                'link_google' => $link_google,
                'active_google' => $active_google,
                'status' => '1',
                'user_id' => $current_user
            );

            if( $image_4_5 == 'remove' ){
                $update_array["email_image_4_5"] = '';
            }elseif( $image_4_5 && strlen($image_4_5) > 3 ){
                $update_array["email_image_4_5"] = $image_4_5;
            }

            if( $image_3_under == 'remove' ){
                $update_array["email_image_3_under"] = '';
            }elseif( $image_3_under && strlen($image_3_under) > 3 ){
                $update_array["email_image_3_under"] = $image_3_under;
            }

            $result = $db->update(
                "location_configuration",
                $update_array,
                array(
                    'id' => $lc_id
                )
            );
            return ( $result > 0 || $result === 0 ) ? true : false;
        }else{
            return false;
        }
	}


	public function get_all_active(){
		global $db;
		$sqlQuery = "SELECT * FROM " . $db->prefix . "location WHERE status = '1' ORDER BY location_name DESC";
		return $db->query( $sqlQuery );
	}

    public function get_all_active_for_user($user_id){
        global $db;
        $sqlQuery = "SELECT * FROM " . $db->prefix . "location WHERE status = '1' and user_id =" .$user_id ." ORDER BY location_name DESC";
        return $db->query( $sqlQuery );
    }

    public function get_all_by_id( $locations ){
        global $db;
        $sqlQuery = "SELECT * FROM " . $db->prefix . "location WHERE status = '1' and id in($locations) ORDER BY location_name DESC";
        return $db->query( $sqlQuery );
    }

	public function get_location( $id ){
		global $db;
		$l = $db->query( "SELECT * FROM " . $db->prefix . "locations WHERE id='$id' LIMIT 1" );
		return ( is_array($l) && count($l) == 1 ) ? $l[0] : false;
	}

	public function search( $page, $per_page, $status = 1, $name = "", $user_id = "", $timeframe = "" ){
		global $db, $user;
        $client = $_SESSION["client"];

		$from = ( $page - 1 ) * $per_page;
		$to = $page * $per_page;

		$where = " WHERE status = '$status'";
		$join = "";

		if($user_id>0){
		    $where .= " and client_id = '$user_id'";
        }

        $sqlQuery = "SELECT * FROM " . $db->prefix . $this->table_name.$join . $where . " ORDER BY location_name DESC LIMIT $from, $to";
		return $db->query( $sqlQuery );
	}

	public function total_search( $status = 1, $name = "", $user_id = "", $timeframe = "" ){
		global $db, $user;

		$where = " WHERE status = '$status'";
        $join = "";

		if( strlen(trim($name)) > 0 ){

			$where .= " AND location_name LIKE '%$name%'";
		}

        if($user_id>0){
            $where .= " and client_id = '$user_id'";
        }
        $sqlQuery = "SELECT COUNT(id) FROM " . $db->prefix .$this->table_name.$join . $where;
		return $db->get_data( $sqlQuery );
	}
}
?>