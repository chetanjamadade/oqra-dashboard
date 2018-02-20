<?php
if( isset($_POST["action"]) ){
	$action = $_POST["action"];

	if( $action == "survey_login" && check_code( $action ) ){

		$current_survey->reset();

		if( $user->is_loggedin() ){

			$current_survey->set( "location_id", $_POST["location"] );
			go_to_page( 'choose-language.php' );

		}else{

			if( $user->login( $db->friendly( $_POST["email"] ), $db->friendly( $_POST["password"] ) ) ){
				
				$current_survey->set( "location_id", $_POST["location"] );
				go_to_page( 'choose-language.php' );

			}else{

				redirect_to( home_url() . '?login_error=true' );

			}

		}

	}elseif( $action == "choose_language" && check_code( $action ) ){

		if( $_POST["language"] == "en" || $_POST["language"] == "sp" ){

			$current_survey->set( "language", $_POST["language"] );

			go_to_page( 'patient.php' );
			
		}else{
			go_to_page( 'choose-language.php' );
		}

	}elseif( $action == "quick_add_patient" && check_code( $action ) ){

		if( isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["dob"]) ){

			$p_id = $patient->add( $current_user->id, $patient->generate_id(), $db->friendly( $_POST["first_name"] ), "", $db->friendly( $_POST["last_name"] ), format_date_for_db($db->friendly( $_POST["dob"] )), "", $current_survey->location_id, "", "", current_date() );

			if( $p_id > 0 ){
				$current_survey->set( "patient_id", $p_id );
				$current_survey->set( "patient_name", $patient->get_name($p_id) );
				$current_survey->set( "patient_type", 'generic' );

				go_to_page( 'choose-physician.php' );
			}else{
				go_to_page( 'patient.php' );
			}

		}else{
			go_to_page( 'patient.php' );
		}

	}elseif( $action == "select_patient" && check_code( $action ) ){

		if( isset($_POST["selected_patient"]) && $_POST["selected_patient"] > 0 ){

			$current_survey->set( "patient_id", $_POST["selected_patient"] );
			$current_survey->set( "patient_name", $patient->get_name($_POST["selected_patient"]) );
			$current_survey->set( "patient_type", 'real' );

			go_to_page( 'choose-physician.php' );
			
		}else{
			go_to_page( 'patient.php' );
		}

	}elseif( $action == "choose_physician" && check_code( $action ) ){

		if( isset($_POST["physician_id"]) && $_POST["physician_id"] > 0 ){

			$current_survey->set( "physician_id", $_POST["physician_id"] );

			if( $current_survey->patient_type == 'generic' ){
				$patient->update_data( $current_survey->patient_id, 'physicians', $current_survey->physician_id );
			}

			go_to_page( 'survey.php' );
			
		}else{
			go_to_page( 'choose-physician.php' );
		}

	}elseif( $action == "add_answers" && check_code( $action ) ){

		if( isset($_POST["answer_1"]) && isset($_POST["answer_2"]) && isset($_POST["answer_3"]) && isset($_POST["answer_4"]) && isset($_POST["answer_5"]) && isset($_POST["answer_6"]) ){

			$answ = array(
				'1' => $_POST["answer_1"],
				'2' => $_POST["answer_2"],
				'3' => $_POST["answer_3"],
				'4' => $_POST["answer_4"],
				'5' => $_POST["answer_5"],
				'6' => $_POST["answer_6"]
				);

			$current_survey->set( "answers", $answ );

			if( $current_survey->is_it_bad_review() ){
				go_to_page( 'details.php' );
			}else{
				go_to_page( 'send-feedback.php' );
			}
			
		}else{
			go_to_page( 'survey.php' );
		}

	}elseif( $action == "survey_comment" && check_code( $action ) ){

		$current_survey->set( "comment", $_POST["comment"] );

		if( $current_survey->is_it_bad_review() ){
			go_to_page( 'phone.php' );
		}else{
			go_to_page( 'phone.php' );
		}

	}elseif( $action == "survey_contact" && check_code( $action ) ){

		$current_survey->set( "contact_me", $db->friendly($_POST["do_call"]) );

		if( $_POST["do_call"] == 'yes' ){
			$current_survey->set( "phone", $db->friendly($_POST["phone"]) );
			$current_survey->set( "call_time", $db->friendly($_POST["call_time"]) );

			if( $current_survey->patient_type == 'generic' ){
				$patient->update_data( $current_survey->patient_id, 'phone', $db->friendly( $current_survey->phone ) );
			}
		}
		
		$current_survey->set( "agreed_to_toa", $db->friendly($_POST["agreed_to_toa"]) );

		$current_survey->save();

		go_to_page( 'thanks.php' );

	}

}
?>