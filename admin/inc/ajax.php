<?php
// header('Access-Control-Allow-Origin: *');
require_once( 'config.php' );

$action = ( isset($_POST["ajax_action"]) && strlen($_POST["ajax_action"]) > 0 ) ? $_POST["ajax_action"] : false;


if( $action ){

	if( $_POST["ajax_action"] == 'ajax_search_patient_by_id' ){

		if( $patient->is_there_patient_with_id( $db->friendly( $_POST["patient_id"] ) ) ){
			echo 'found';
		}else{
			echo 'not_found';
		}

	}elseif( $_POST["ajax_action"] == 'ajax_search_patient_by_info' ){

		if( $patient->is_there_patient_with_info( $db->friendly( $_POST["first_name"] ), $db->friendly( $_POST["last_name"] ), $db->friendly( $_POST["dob"] ) ) ){
			echo 'found';
		}else{
			echo 'not_found';
		}

	}elseif( $_POST["ajax_action"] == 'ajax_change_status' ){

		if( isset($_POST["id"]) && $_POST["id"] > 0 && isset($_POST["status"]) && in_array($_POST["status"], array(0,1) ) ){


			if( $_POST["what"] == "user" ){
				if( $user->change_status( $_POST["id"], $_POST["status"] ) ){ echo "1"; }else{ echo "0"; }
			}elseif( $_POST["what"] == "location" ){
				if( $location->change_status( $_POST["id"], $_POST["status"] ) ){ echo "1"; }else{ echo "0"; }
			}elseif( $_POST["what"] == "client" ){
				if( $client->change_status( $_POST["id"], $_POST["status"] ) ){ echo "1"; }else{ echo "0"; }
			}elseif( $_POST["what"] == "professional" ){
                if( $professional->change_status( $_POST["id"], $_POST["status"] ) ){ echo "1"; }else{ echo "0"; }
            }elseif( $_POST["what"] == "message" ){
				if( $message->change_status( $_POST["id"], $_POST["status"] ) ){ echo "1"; }else{ echo "0"; }
			}
            elseif( $_POST["what"] == "professional" ){
                if( $message->change_status( $_POST["id"], $_POST["status"] ) ){ echo "1"; }else{ echo "0"; }
            }

		}

	}elseif( $_POST["ajax_action"] == 'ajax_delete_forever' ){

		if( isset($_POST["id"]) && $_POST["id"] > 0 && isset($_POST["what"]) ){

			if( $_POST["what"] == "user" ){
				if( $user->delete( $_POST["id"] ) ){ echo "1"; }else{ echo "0"; }
			}elseif( $_POST["what"] == "location" ){
				if( $location->delete( $_POST["id"] ) ){ echo "1"; }else{ echo "0"; }
			}elseif( $_POST["what"] == "physician" ){
				if( $physician->delete( $_POST["id"] ) ){ echo "1"; }else{ echo "0"; }
			}elseif( $_POST["what"] == "patient" ){
				if( $patient->delete( $_POST["id"] ) ){ echo "1"; }else{ echo "0"; }
			}elseif( $_POST["what"] == "message" ){
				if( $message->delete( $_POST["id"] ) ){ echo "1"; }else{ echo "0"; }
			}

		}

	}elseif( $_POST["ajax_action"] == 'ajax_get_user_table' ){

		$page = ( isset($_POST["page"]) && $_POST["page"] > 0 ) ? $_POST["page"] : 1;
		$per_page = ( isset($_POST["per_page"]) && $_POST["per_page"] > 0 ) ? $_POST["per_page"] : 10;
		$status = ( isset($_POST["status"]) && in_array($_POST["status"], array(0, 1)) ) ? $_POST["status"] : 1;
		$timeframe = ( isset($_POST["timeframe"]) && is_valid_timeframe( $_POST["timeframe"] ) ) ? $_POST["timeframe"] : '';
		$location_id = ( isset($_POST["location"]) && $_POST["location"] > 0 ) ? $_POST["location"] : '';
		$role = ( isset($_POST["role"]) && is_valid_role($_POST["role"]) ) ? $_POST["role"] : '';
		$name = ( isset($_POST["name"]) && strlen( $db->friendly( $_POST["name"] ) ) > 0 ) ? $_POST["name"] : "";

		echo get_users_table(  $page, $per_page, $status, $name, $role, $location_id, $timeframe );

	}elseif( $_POST["ajax_action"] == 'ajax_get_professional_table' ){

        $page = ( isset($_POST["page"]) && $_POST["page"] > 0 ) ? $_POST["page"] : 1;
        $per_page = ( isset($_POST["per_page"]) && $_POST["per_page"] > 0 ) ? $_POST["per_page"] : 10;
        $status = ( isset($_POST["status"]) && in_array($_POST["status"], array(0, 1)) ) ? $_POST["status"] : 1;
        $timeframe = ( isset($_POST["timeframe"]) && is_valid_timeframe( $_POST["timeframe"] ) ) ? $_POST["timeframe"] : '';
        $user = ( isset($_POST["user"]) && is_valid_role($_POST["user"]) ) ? $_POST["user"] : '';
        $name = ( isset($_POST["name"]) && strlen( $db->friendly( $_POST["name"] ) ) > 0 ) ? $_POST["name"] : "";

        echo get_professionals_table(  $page, $per_page, $status, $name, $user, $timeframe );

    }	elseif( $_POST["ajax_action"] == 'ajax_get_location_table' ){

		$page = ( isset($_POST["page"]) && $_POST["page"] > 0 ) ? $_POST["page"] : 1;
		$per_page = ( isset($_POST["per_page"]) && $_POST["per_page"] > 0 ) ? $_POST["per_page"] : 10;
		$status = ( isset($_POST["status"]) && in_array($_POST["status"], array(0, 1)) ) ? $_POST["status"] : 1;
		$timeframe = ( isset($_POST["timeframe"]) && is_valid_timeframe( $_POST["timeframe"] ) ) ? $_POST["timeframe"] : '';
		$physician_id = ( isset($_POST["physician"]) && $_POST["physician"] > 0 ) ? $_POST["physician"] : '';
		$user_id = ( isset($_POST["user"]) && $_POST["user"] > 0 ) ? $_POST["user"] : '';
		$name = ( isset($_POST["name"]) && strlen( $db->friendly( $_POST["name"] ) ) > 0 ) ? $_POST["name"] : "";

		echo get_locations_table(  $page, $per_page, $status, $name, $physician_id, $user_id, $timeframe );

	}elseif( $_POST["ajax_action"] == 'ajax_get_physician_table' ){

		$page = ( isset($_POST["page"]) && $_POST["page"] > 0 ) ? $_POST["page"] : 1;
		$per_page = ( isset($_POST["per_page"]) && $_POST["per_page"] > 0 ) ? $_POST["per_page"] : 10;
		$status = ( isset($_POST["status"]) && in_array($_POST["status"], array(0, 1)) ) ? $_POST["status"] : 1;
		$timeframe = ( isset($_POST["timeframe"]) && is_valid_timeframe( $_POST["timeframe"] ) ) ? $_POST["timeframe"] : '';
		$location_id = ( isset($_POST["location"]) && $_POST["location"] > 0 ) ? $_POST["location"] : '';
        $department_id = ( isset($_POST["department"]) && $_POST["department"] > 0 ) ? $_POST["department"] : '';
		$user_id = ( isset($_POST["user"]) && $_POST["user"] > 0 ) ? $_POST["user"] : '';
		$name = ( isset($_POST["name"]) && strlen( $db->friendly( $_POST["name"] ) ) > 0 ) ? $_POST["name"] : "";

		echo get_physicians_table(  $page, $per_page, $status, $name, $location_id, $department_id, $user_id, $timeframe );

	}elseif( $_POST["ajax_action"] == 'ajax_get_patient_table' ){

		$page = ( isset($_POST["page"]) && $_POST["page"] > 0 ) ? $_POST["page"] : 1;
		$per_page = ( isset($_POST["per_page"]) && $_POST["per_page"] > 0 ) ? $_POST["per_page"] : 10;
		$status = ( isset($_POST["status"]) && in_array($_POST["status"], array(0, 1)) ) ? $_POST["status"] : 1;
		$timeframe = ( isset($_POST["timeframe"]) && is_valid_timeframe( $_POST["timeframe"] ) ) ? $_POST["timeframe"] : '';
        $location_id = ( isset($_POST["location"]) && $_POST["location"] > 0 ) ? $_POST["location"] : '';
		$physician_id = ( isset($_POST["physician"]) && $_POST["physician"] > 0 ) ? $_POST["physician"] : '';
		$name = ( isset($_POST["name"]) && strlen( $db->friendly( $_POST["name"] ) ) > 0 ) ? $_POST["name"] : "";

		echo get_patients_table(  $page, $per_page, $status, $name, $location_id, $physician_id, $timeframe );

	}elseif( $_POST["ajax_action"] == 'ajax_get_department_table' ){

        $page = ( isset($_POST["page"]) && $_POST["page"] > 0 ) ? $_POST["page"] : 1;
        $per_page = ( isset($_POST["per_page"]) && $_POST["per_page"] > 0 ) ? $_POST["per_page"] : 10;
        $status = ( isset($_POST["status"]) && in_array($_POST["status"], array(0, 1)) ) ? $_POST["status"] : 1;
        $timeframe = ( isset($_POST["timeframe"]) && is_valid_timeframe( $_POST["timeframe"] ) ) ? $_POST["timeframe"] : '';
        $department_id = ( isset($_POST["department"]) && $_POST["department"] > 0 ) ? $_POST["department"] : '';
        $location_id = ( isset($_POST["location"]) && $_POST["location"] > 0 ) ? $_POST["location"] : '';
        $name = ( isset($_POST["name"]) && strlen( $db->friendly( $_POST["name"] ) ) > 0 ) ? $_POST["name"] : "";

        echo get_departments_table(  $page, $per_page, $status, $name, $location_id, $department_id, $timeframe );
    }
	elseif( $_POST["ajax_action"] == 'ajax_get_report_table' ){

		$page = ( isset($_POST["page"]) && $_POST["page"] > 0 ) ? $_POST["page"] : 1;
		$per_page = ( isset($_POST["per_page"]) && $_POST["per_page"] > 0 ) ? $_POST["per_page"] : 10;
		$timeframe = ( isset($_POST["timeframe"]) && is_valid_timeframe( $_POST["timeframe"] ) ) ? $_POST["timeframe"] : '';

		$physician_id = ( isset($_POST["physician"]) && $_POST["physician"] > 0 ) ? $_POST["physician"] : '';
		$location_id = ( isset($_POST["location"]) && $_POST["location"] > 0 ) ? $_POST["location"] : '';
		$patient_id = ( isset($_POST["patient"]) && $_POST["patient"] > 0 ) ? $_POST["patient"] : '';
		$user_id = ( isset($_POST["user"]) && $_POST["user"] > 0 ) ? $_POST["user"] : '';
		$language = ( isset($_POST["language"]) && ($_POST["language"] == 'en' || $_POST["language"] == 'sp') ) ? $_POST["language"] : '';
		$contact = ( isset($_POST["contact"]) && ($_POST["contact"] == 'yes' || $_POST["contact"] == 'no') ) ? $_POST["contact"] : '';
		$review = ( isset($_POST["review"]) && ($_POST["review"] == 'positive' || $_POST["review"] == 'neutralornegative' || $_POST["review"] == 'negative') ) ? $_POST["review"] : '';
		$patient_type = ( isset($_POST["patient-type"]) && ($_POST["patient-type"] == 'real' || $_POST["patient-type"] == 'generic') ) ? $_POST["patient-type"] : '';

		echo get_surveys_table( $page, $per_page, 0, 0, $language, $contact, $patient_id, $timeframe, $location_id, $user_id, $physician_id, $review, $patient_type );

	}elseif( $_POST["ajax_action"] == 'ajax_get_language_stats_table' ){

		$timeframe = ( isset($_POST["timeframe"]) && is_valid_timeframe( $_POST["timeframe"] ) ) ? $_POST["timeframe"] : '';
		$location_id = ( isset($_POST["location"]) && $_POST["location"] > 0 ) ? $_POST["location"] : '';

		echo get_language_stats_table( $timeframe, $location_id );

	}elseif( $_POST["ajax_action"] == 'ajax_get_contact_stats_table' ){

		$timeframe = ( isset($_POST["timeframe"]) && is_valid_timeframe( $_POST["timeframe"] ) ) ? $_POST["timeframe"] : '';
		$location_id = ( isset($_POST["location"]) && $_POST["location"] > 0 ) ? $_POST["location"] : '';

		echo get_contact_stats_table( $timeframe, $location_id );

	}elseif( $_POST["ajax_action"] == 'ajax_get_location_stats_table' ){

		$page = ( isset($_POST["page"]) && $_POST["page"] > 0 ) ? $_POST["page"] : 1;
		$per_page = ( isset($_POST["per_page"]) && $_POST["per_page"] > 0 ) ? $_POST["per_page"] : 10;
		$timeframe = ( isset($_POST["timeframe"]) && is_valid_timeframe( $_POST["timeframe"] ) ) ? $_POST["timeframe"] : '';
		$physician_id = ( isset($_POST["physician"]) && $_POST["physician"] > 0 ) ? $_POST["physician"] : '';
		$user_id = ( isset($_POST["user"]) && $_POST["user"] > 0 ) ? $_POST["user"] : '';

		echo get_location_stats_table( $page, $per_page, $timeframe, $physician_id, $user_id );

	}elseif( $_POST["ajax_action"] == 'ajax_get_physicians_by_location' ){

        $location_id = ( isset($_POST["location"]) && $_POST["location"] > 0 ) ? $_POST["location"] : '';

        echo get_physicians_by_location( $location_id );

    }elseif( $_POST["ajax_action"] == 'ajax_get_departments_by_location' ){

        $location_id = ( isset($_POST["location"]) && $_POST["location"] > 0 ) ? $_POST["location"] : '';

        echo get_departments_by_location( $location_id );

    }
    elseif( $_POST["ajax_action"] == 'ajax_get_statistic_table' ){

		$timeframe = ( isset($_POST["timeframe"]) && is_valid_timeframe( $_POST["timeframe"] ) ) ? $_POST["timeframe"] : '';
		$physician_id = ( isset($_POST["physician"]) && $_POST["physician"] > 0 ) ? $_POST["physician"] : '';
		$location_id = ( isset($_POST["location"]) && $_POST["location"] > 0 ) ? $_POST["location"] : '';

		echo get_statistic_table( $timeframe, $location_id, $physician_id );

	}elseif( $_POST["ajax_action"] == 'ajax_get_question_table' ){

		$page = ( isset($_POST["page"]) && $_POST["page"] > 0 ) ? $_POST["page"] : 1;
		$per_page = ( isset($_POST["per_page"]) && $_POST["per_page"] > 0 ) ? $_POST["per_page"] : 10;
		$timeframe = ( isset($_POST["timeframe"]) && is_valid_timeframe( $_POST["timeframe"] ) ) ? $_POST["timeframe"] : '';
		$user_id = ( isset($_POST["user"]) && $_POST["user"] > 0 ) ? $_POST["user"] : '';
		$location_id = ( isset($_POST["location"]) && $_POST["location"] > 0 ) ? $_POST["location"] : '';
		$question = ( isset($_POST["question"]) && $_POST["question"] > 0 ) ? $_POST["question"] : 0;
		$answer = ( isset($_POST["answer"]) && $_POST["answer"] > 0 ) ? $_POST["answer"] : 0;

		echo get_surveys_table( $page, $per_page, $question, $answer, "", "", "", $timeframe, $location_id, $user_id );

	}elseif( $_POST["ajax_action"] == 'ajax_get_message_table' ){

		$page = ( isset($_POST["page"]) && $_POST["page"] > 0 ) ? $_POST["page"] : 1;
		$per_page = ( isset($_POST["per_page"]) && $_POST["per_page"] > 0 ) ? $_POST["per_page"] : 10;
		$timeframe = ( isset($_POST["timeframe"]) && is_valid_timeframe( $_POST["timeframe"] ) ) ? $_POST["timeframe"] : '';
		$status = ( isset($_POST["status"]) && in_array($_POST["status"], array(0, 1)) ) ? $_POST["status"] : 1;
		$read = ( isset($_POST["read"]) && ($_POST["read"] =='read' || $_POST["read"] =='unread' ) ) ? $_POST["read"] : '';
		$type = ( isset($_POST["type"]) && ($_POST["type"] =='support' || $_POST["type"] =='forgoten-password' ) ) ? $_POST["type"] : '';

		echo get_message_table( $page, $per_page, $status, $read, $type, $timeframe );

	}elseif( $_POST["ajax_action"] == 'ajax_email_exists' ){
		if( $user->check_email_format( $_POST["email"] ) && $user->email_exist( $db->friendly( $_POST["email"] ) ) ){
			echo 'yes';
		}else{
			echo 'no';
		}
	}elseif( $_POST["ajax_action"] == 'ajax_lost_password_request' ){
		if( $user->check_email_format( $_POST["email"] ) && $user->email_exist( $db->friendly( $_POST["email"] ) ) ){
			$user_data = $user->get_user_by_email( $_POST["email"] );
			if( is_array($user_data) ){
				$user_data = $user_data[0];
				$email->reset_password_request( $user_data->id, $user_data->first_name, $user_data->last_name, $user_data->email );
				$message->send( 'forgoten-password', $user_data->id, 0, 'Forgoten Password', 'User '.$user_data->email.' forgot his password.', "", current_date() );
			}
		}
	}




	die();

}else{
	echo 0;
	die();
}

?>