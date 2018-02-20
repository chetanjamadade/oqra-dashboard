<?php
if( isset($_POST["action"]) ){
	$action = $_POST["action"];

	if( $action == "login" && check_code( $action ) ){

		if( $user->login( $db->friendly( $_POST["email"] ), $db->friendly( $_POST["password"] ) ) ){
		    if($user->role == 1) {
		        $_SESSION["selected_client_id"] = -1;
                redirect_to(root_url());
            } else{
                $_SESSION["selected_client_id"] = $user->client_id;
                redirect_to(dashboard_url());
            }
		}else{
			redirect_to( login_url() . '?login_error=true' );
		}
	}
    else if( $action == "select-client" && check_code( $action ) ){
	    $selected_user_id = $_POST["selected_client_id"];
        $selected_client_id = $user->get_client_by_user($selected_user_id);
	    if($selected_client_id != null) {

            $_SESSION["selected_client_id"] = $selected_client_id;

            redirect_to(dashboard_url());
        }else{
            redirect_to(create_client());
        }
    }elseif( $action == "add_user" && check_code( $action ) ){

		if( $_POST["password"] == $_POST["password_2"] && $user->check_email_format( $_POST["email"] ) && !$user->email_exist( $_POST["email"] ) && $user->check_password_format( $_POST["password"] ) ){

			$image = upload_image( 'user-' );
            $db_password = $user->generate_password( $db->friendly( $_POST["password"] ) );

			$new_id = $user->register( $db->friendly( $_POST["email"] ), $db_password , $db->friendly( $_POST["first_name"] ), $db->friendly( $_POST["last_name"] ), $db->friendly( $_POST["role"] ), $db->friendly( $_POST["location"] ), implode( ',', $_POST["physicians"] ), $db->friendly( $_POST["comment"] ), $image, current_date() );

			if( $new_id ){

				if( isset($_POST["send-email"]) ){
					$email->new_user_mail( $new_id, $db->friendly( $_POST["first_name"] ), $db->friendly( $_POST["last_name"] ),$db->friendly( $_POST["email"] ), $db->friendly( $_POST["password"] ) );
				}
				redirect_to( 'users.php?new_added=true' );
			}else{
				redirect_to( dashboard_url() . '?error=true' );
			}
		}

	}elseif( $action == "edit_user" && check_code( $action ) ){
		$update_msgs = "&updated=true";

		if( isset($_POST["user_id"]) && $_POST["user_id"] > 0 && $user->exists( $_POST["user_id"] ) ){

			$u = $user->get_one( $_POST["user_id"] );

			$em = $_POST["email"];

			if( $_POST["email"] != $u->email ){
				if( $user->check_email_format( $_POST["email"] ) && !$user->email_exist( $_POST["email"] ) ){
					$em = $_POST["email"];
				}else{
					$update_msgs .= "&error_email=true";
					$em = $u->email;
				}
			}

			$image = edit_image( 'user-' );

			if( isset($_POST["new-password"]) && isset($_POST["repeat-new-password"]) && $user->check_password_format( $_POST["new-password"] ) && $user->check_password_format( $_POST["repeat-new-password"] ) ){
				$success2 = $user->change_password( $db->friendly( $_POST["email"] ), $db->friendly( $_POST["new-password"] ) );
				if( $success2 ){
					$update_msgs .= "&password_changed=true";
				}else{
					$update_msgs .= "&password_error=true";
				}
			}

			if( $user->update( $_POST["user_id"], $db->friendly( $em ), $db->friendly( $_POST["first_name"] ), $db->friendly( $_POST["last_name"] ), $db->friendly( $_POST["role"] ), $db->friendly( $_POST["location"] ), implode( ',', $_POST["physicians"] ), $db->friendly( $_POST["comment"] ), $image ) ){

				redirect_to( 'user-details.php?id='.$_POST["user_id"].$update_msgs );
			}else{
				redirect_to( 'users.php?error=true' );
			}
		}else{
			redirect_to( 'users.php?error=true' );
		}

	}elseif( $action == "add_client" && check_code( $action ) ){

        $image = upload_image( 'client-' );
        $user_password = $user->generate_password($db->friendly( $_POST["password"] ));
        $user_id = $_SESSION["user_id"];

        if( $client->add( $db->friendly( $_POST["name"] ), $db->friendly( $_POST["email"] ), $db->friendly( $_POST["url"] ),
            $image, $db->friendly( $_POST["terms"] ),$db->friendly( $_POST["not_found_message"] ),$db->friendly( $_POST["exists_message"] ),
            $db->friendly( $_POST["question"] ),$db->friendly( $_POST["first_name"] ),$db->friendly( $_POST["last_name"] ),
            $user_password,$db->friendly( $_POST["user_email"] ),$db->friendly( $_POST["phone"]), $user_id ) ){
            redirect_to( 'front/clients.php?new_added=true' );
        }else{
            redirect_to( dashboard_url() . '?error=true' );
        }

    }elseif( $action == "add_professional" && check_code( $action ) ){

        $image = upload_image( 'professional-' );
        $user_id = $_SESSION["logged-user"]->id;

        if($professional->add( $db->friendly( $_POST["full_name"] ), $db->friendly( $_POST["address_professional"] ), $db->friendly( $_POST["email_professional"] ), $db->friendly( $_POST["phone"]), $image,implode( ',', $_POST["location"] ), $user_id))
        {
            redirect_to('front/professionals.php?new_added=true');
        }else{
            redirect_to( dashboard_url() . '?error=true' );
        }
    }
    elseif( $action == "edit_professional" && check_code( $action ) ){

        if( isset($_POST["professional_id"]) && $_POST["professional_id"] > 0 && $professional->exists( $_POST["professional_id"] ) ){

            $image = edit_image( 'professional-' );
            $user_id = $_SESSION["user_id"];

            if( $professional->update( $_POST["professional_id"], $db->friendly( $_POST["full_name"] ), $db->friendly( $_POST["address_professional"] ), $db->friendly( $_POST["email_professional"] ), $db->friendly($_POST["phone_professional"]), $image, implode(',', $_POST["location"] ), $user_id) ){
                redirect_to( 'front/professionals.php?updated=true&update_id='.$_POST["id"] );
            }else{
                redirect_to( 'front/professionals.php?error=true' );
            }
        }else{
            redirect_to( 'front/professionals.php?error=true' );
        }

    }
    elseif( $action == "edit_client" && check_code( $action ) ){
        if ($_POST["setting"] > 0){
            if( isset($_POST["client_id"]) && $_POST["client_id"] > 0 && $client->exists( $_POST["client_id"] ) ){

                $image = edit_image( 'client-' );
                if ($_POST["password"] != ""){
                    $user_password = $user->generate_password($_POST["password"]);
                }
                else $user_password =  $_POST["old_password"];

                if( $client->update( $_POST["client_id"], $db->friendly( $_POST["name"] ), $db->friendly( $_POST["email"] ), $db->friendly( $_POST["url"] ), $image ,$db->friendly($_POST["client_conf_id"]), $db->friendly( $_POST["terms"] ),$db->friendly( $_POST["not_found_message"] ),$db->friendly( $_POST["exists_message"] ),$db->friendly( $_POST["question"] ), $db->friendly( $_POST["user_id"] ), $db->friendly( $_POST["first_name"] ),$db->friendly( $_POST["last_name"] ),$user_password,$db->friendly( $_POST["user_email"] ),$db->friendly( $_POST["user_phone"] ) ) ){
                    redirect_to( 'front/dashboard.php?updated=true&update_id='.$_POST["client_id"] );
                }else{
                    redirect_to( 'front/dashboard.php?error=true' );
                }
            }else{
                redirect_to( 'front/dashboard.php?error=true' );
            }
        }
        else{
            if( isset($_POST["client_id"]) && $_POST["client_id"] > 0 && $client->exists( $_POST["client_id"] ) ){

                $image = edit_image( 'client-' );
                if ($_POST["password"] != ""){
                    $user_password = $user->generate_password($_POST["password"]);
                }
                else $user_password =  $_POST["old_password"];

                if( $client->update( $_POST["client_id"], $db->friendly( $_POST["name"] ), $db->friendly( $_POST["email"] ), $db->friendly( $_POST["url"] ), $image,$db->friendly($_POST["client_conf_id"]), $db->friendly( $_POST["terms"] ),$db->friendly( $_POST["not_found_message"] ),$db->friendly( $_POST["exists_message"] ),$db->friendly( $_POST["question"] ), $db->friendly( $_POST["user_id"] ), $db->friendly( $_POST["first_name"] ),$db->friendly( $_POST["last_name"] ),$user_password,$db->friendly( $_POST["user_email"] ),$db->friendly( $_POST["user_phone"] ) ) ){
                    redirect_to( 'front/clients.php?updated=true&update_id='.$_POST["client_id"] );
                }else{
                    redirect_to( 'front/clients.php?error=true' );
                }
            }else{
                redirect_to( 'front/clients.php?error=true' );
            }
        }
    }


    elseif( $action == "add_location" && check_code( $action ) ){

		$image1 = upload_image_email( 'location-' );
        $image2 = upload_image_email_2( 'location-' );
        $user_id = $_SESSION["logged-user"]->id;
        $longitude = $db->friendly( $_POST["longitude"] );
        $latitude = $db->friendly( $_POST["latitude"] );
		if( $location->add( $db->friendly( $_POST["street"] ), $db->friendly( $_POST["zip_code"] ), $db->friendly( $_POST["location_name"] ), $db->friendly( $_POST["city"] ), $db->friendly( $_POST["state"] ),$db->friendly( $_POST["latitude"] ),$db->friendly( $_POST["longitude"] ),
            $db->friendly( $_POST["ex_satisfied_txt"] ), $db->friendly( $_POST["very_satisfied_text"] ), $db->friendly( $_POST["satisfied_text"] ), $db->friendly( $_POST["dissatisfied_text"] ),
            $db->friendly( $_POST["very_dissat_text"] ),$db->friendly( $_POST["thank_you"] ),$db->friendly( $_POST["voice_text"] ),
            $db->friendly( $_POST["video_text"] ), $image1, $image2,$db->friendly( $_POST["email_4_5"] ),$db->friendly( $_POST["email_3_under"] ),
            $db->friendly( $_POST["email_address_4_5"] ),$db->friendly( $_POST["email_address_3_under"] ),
            $db->friendly( $_POST["sms_4_5"] ),$db->friendly( $_POST["sms_3_under"] ),$db->friendly( $_POST["admin_email"] ),
            $db->friendly( $_POST["ap_enabled"] ),$db->friendly( $_POST["ap_text"] ),$db->friendly( $_POST["ap_url"] ),
            $db->friendly( $_POST["link_fb"] ),$db->friendly( $_POST["active_fb"] ),$db->friendly( $_POST["link_twitter"] ),
            $db->friendly( $_POST["desc_twitter"] ),$db->friendly( $_POST["active_twitter"] ),$db->friendly( $_POST["link_pinterest"] ),
            $db->friendly( $_POST["desc_pinterest"] ),$db->friendly( $_POST["active_pinterest"] ), $db->friendly( $_POST["link_yelp"] ),
            $db->friendly( $_POST["active_yelp"] ),$db->friendly( $_POST["link_google"] ),
            $db->friendly( $_POST["active_google"] ), $user_id, $db->friendly( $_POST["client_id"] ) ) ){
			redirect_to( 'front/locations.php?new_added=true' );
		}else{
			redirect_to( dashboard_url() . '?error=true' );
		}

	}elseif( $action == "edit_location" && check_code( $action ) ){

		if( isset($_POST["location_id"]) && $_POST["client_id"] > 0 && $location->exists( $_POST["location_id"] ) ){

			$image = edit_image( 'location-' );
            $image1 = upload_image_email( 'location-' );
            $image2 = upload_image_email_2( 'location-' );
            $user_id = $_SESSION["logged-user"]->id;
            $longitude = $db->friendly( $_POST["longitude"] );
            $latitude = $db->friendly( $_POST["latitude"] );

			if( $location->update( $db->friendly($_POST["location_id"]),$db->friendly( $_POST["street"] ), $db->friendly( $_POST["zip_code"] ), $db->friendly( $_POST["location_name"] ), $db->friendly( $_POST["city"] ), $db->friendly( $_POST["state"] ),$latitude,$longitude,
                $db->friendly( $_POST["lc_id"] ),$db->friendly( $_POST["ex_satisfied_txt"] ), $db->friendly( $_POST["very_satisfied_text"] ), $db->friendly( $_POST["satisfied_text"] ), $db->friendly( $_POST["dissatisfied_text"] ),
                $db->friendly( $_POST["very_dissat_text"] ),$db->friendly( $_POST["thank_you"] ),$db->friendly( $_POST["voice_text"] ),
                $db->friendly( $_POST["video_text"] ),$image1, $image2,$db->friendly( $_POST["email_4_5"] ),$db->friendly( $_POST["email_3_under"] ),
                $db->friendly( $_POST["email_address_4_5"] ),$db->friendly( $_POST["email_address_3_under"] ),
                $db->friendly( $_POST["sms_4_5"] ),$db->friendly( $_POST["sms_3_under"] ),$db->friendly( $_POST["admin_email"] ),
                $db->friendly( $_POST["ap_enabled"] ),$db->friendly( $_POST["ap_text"] ),$db->friendly( $_POST["ap_url"] ),
                $db->friendly( $_POST["link_fb"] ),$db->friendly( $_POST["active_fb"] ),$db->friendly( $_POST["link_twitter"] ),
                $db->friendly( $_POST["desc_twitter"] ),$db->friendly( $_POST["active_twitter"] ),$db->friendly( $_POST["link_pinterest"] ),
                $db->friendly( $_POST["desc_pinterest"] ),$db->friendly( $_POST["active_pinterest"] ), $db->friendly( $_POST["link_yelp"] ),
                $db->friendly( $_POST["active_yelp"] ),$db->friendly( $_POST["link_google"] ),
                $db->friendly( $_POST["active_google"] ), $user_id, $db->friendly( $_POST["client_id"] ) ) ){
				redirect_to( 'front/locations.php?updated=true&update_id='.$_POST["location_id"] );
			}else{
				redirect_to( 'front/locations.php?error=true' );
			}
		}else{
			redirect_to( 'front/locations.php?error=true' );
		}	

	}
	elseif( $action == "support_message" && check_code( $action ) ){


		if( $message->send( 'support', $current_user->id, 0, $db->friendly($_POST["subject"]), $db->friendly($_POST["message"]), "", current_date() ) ){
			redirect_to( 'support.php?message_sent=success' );
		}else{
			redirect_to( 'support.php?message_sent=error' );
		}
	}
    elseif( $action == "forgot-password" && check_code( $action ) ){
        if( $user->check_email_format( $_POST["email"] ) && $user->email_exist( $db->friendly( $_POST["email"] ) ) ){
            $user_data = $user->get_user_by_email( $_POST["email"] );
            if( is_array($user_data) ){
                $user_data = $user_data[0];
                $email->reset_password_request( $user_data->id, $user_data->first_name, $user_data->last_name, $user_data->email );
                $message->send( 'forgoten-password', $user_data->id, 0, 'Forgoten Password', 'User '.$user_data->email.' forgot his password.', "", current_date() );
            }
            redirect_to( 'index.php?message_sent=success' );
        }
        else redirect_to('forgot-password.php?message_sent=failed');
    }

}
?>