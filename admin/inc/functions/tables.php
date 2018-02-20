<?php
function get_table( $name, $headers = array(), $data = array() ){
	global $location, $user, $current_user, $patient, $department, $physician, $survey;
	$output = '<table class="table">';

	if( is_array($headers) ){
		$output .= '<tr>';
		foreach( $headers as $key => $value ){
			$output .= '<th'.( $key == "Action" ? ' class="text-center"' : '' ).'>'.$key.'</th>';
		}
		$output .= '</tr>';
	}

	if( is_array($data) ){
		foreach( $data as $item ){
			if( property_exists($item, 'id')){
				$output .= '<tr id="'.$name.'-tr-'.$item->id.'">';
			}else{
				$output .= '<tr id="'.$name.'-tr">';
			}


			foreach( $headers as $key => $value ){

				if( $value == 'location_stats_action' || $value == 'total' || $value== 'details_link' || $value== 'details_actions' ){
					$output .= '<td style="width: 10%;" class="action-td text-center">';
				}elseif( $value== 'flag' ){
					$output .= '<td style="width: 10%;" >';
				}else{
					$output .= '<td'.( $key == "Action" ? ' class="action-td text-center"' : '' ).'>';
				}



				if( $value == 'first_name_img' ){

					$output .= '<strong><a href="'.$name.'-details.php?id='.$item->id.'" data-toggle="popover" data-trigger="focus" data-placement="top" data-img="'.show_image( clean_string( $item->image ) ).'">'.clean_string( $item->first_name ).'</a></strong>';


				}elseif( $value == 'last_name_img' ){

					$output .= '<strong><a href="'.$name.'-details.php?id='.$item->id.'" data-toggle="popover" data-trigger="focus" data-placement="top" data-img="'.show_image( clean_string( $item->image ) ).'">'.clean_string( $item->last_name ).'</a></strong>';

				}elseif( $value == 'from_id' ){

					if( $item->from_id > 0 && $user->exists( $item->from_id ) ){
						$u = $user->get_one( $item->from_id );

						if( $u ){
							$output .= '<strong><a href="#" data-toggle="popover" data-trigger="focus" data-placement="top" data-img="'.show_image( clean_string( $u->image ) ).'">'.merge_name( clean_string( $u->first_name ), clean_string( $u->last_name ) ).'</a></strong>';
						}else{
							$output .= 'Unknown';
						}
					}else{
						$output .= 'No sender';
					}

				}elseif( $value == 'name_img' ){

					$output .= '<strong><a href="#" data-toggle="popover" data-trigger="focus" data-placement="top" data-img="'.show_image( clean_string( $item->image ) ).'">'.clean_string( $item->name ).'</a></strong>';

				}elseif( $value == 'image' ){

					$output .= '<a href="'.$name.'-details.php?id='.$item->id.'" data-toggle="popover" data-trigger="focus" data-placement="top" data-img="'.show_image( clean_string( $item->image ) ).'"><img src="'.show_image( clean_string( $item->image ) ).'" class="profile-thumb" alt=""></a>';

				}elseif( $value == 'dob' ){

					$output .= format_date_for_output($item->dob);

				}elseif( $value == 'total' ){

					$output .= '<small class="sum-info">'.$item->total.'</small>';

				}elseif( $value == 'date' ){

					$output .= format_date_for_output($item->date);

				}elseif( $value == 'location' && $item->location > 0 ){

					$location_data = $location->get_location( $item->location );
					if( $location_data ){
						$output .= '<a href="#" data-toggle="popover" data-trigger="focus" data-placement="top" data-img="'.show_image( clean_string( $location_data->image ) ).'">'.clean_string($location_data->location_name).'</a>';
					}

				}elseif( $value == 'role' ){

					$output .= role_name_by_id( $item->role );

				}elseif( $value == 'active_actions' ){

					// $output .= '<a href="'.$name.'-details.php?id='.$item->id.'" data-toggle="tooltip" data-placement="top" title="View '.ucfirst($name).'"><i class="fa fa-info-circle"></i></a>';

                    if( $name != 'message' && $name != 'department'){
                    	$output .= '<a class="action-edit-btn" href="edit-'.$name.'.php?id='.$item->id.'" data-toggle="tooltip" data-placement="top" title="Edit '.ucfirst($name).'"><i class="fa fa-pencil"></i></a>';
                    }
                    $output .= '<span class="add-to-archive" data-toggle="modal" data-target="#myModal2" data-id="'.$item->id.'">
                    <a href="#"  class="action-del-btn" data-toggle="tooltip" data-placement="top" title="Archive '.ucfirst($name).'"><i class="fa fa-archive"></i></a>
                    </span>';

				}
                elseif( $value == 'location_action' ){

                    // $output .= '<a href="'.$name.'-details.php?id='.$item->id.'" data-toggle="tooltip" data-placement="top" title="View '.ucfirst($name).'"><i class="fa fa-info-circle"></i></a>';

                    $output .= '<a class="action-edit-btn" href="edit-'.$name.'.php?id='.$item->id.'" data-toggle="tooltip" data-placement="top" title="Edit '.ucfirst($name).'"><i class="fa fa-pencil"></i></a><a href="#"  class="action-del-btn" data-toggle="tooltip" data-placement="top" title="Archive '.ucfirst($name).'"><i class="fa fa-archive"></i></a>';

                }elseif( $value == 'archived_actions' ){

					$output .= '<a class="action-edit-btn" href="'.$name.'-details.php?id='.$item->id.'" data-toggle="tooltip" data-placement="top" title="View '.ucfirst($name).'"><i class="fa fa-info-circle"></i></a>';

                    $output .= '<span class="remove-forever" data-toggle="modal" data-target="#myModal3" data-id="'.$item->id.'"><a class="add-to-archive" href="#" data-toggle="tooltip" data-placement="top" title="Remove Forever"><i class="fa fa-pencil"></i></a></span>';

                    $output .= '<span class="reactivate-this" data-toggle="modal" data-target="#myModal2" data-id="'.$item->id.'">
                    <a href="#" data-toggle="tooltip" data-placement="top" title="Activate '.ucfirst($name).'"><i class="fa fa-play"></i></a>
                    </span>';

				}elseif( $value == 'details_actions' ){

					$output .= '<a href="'.$name.'-details.php?id='.$item->id.'" data-toggle="tooltip" data-placement="top" title="View '.ucfirst($name).'"><i class="fa fa-info-circle"></i></a>';

				}elseif( $value == 'location_stats_action' ){

					$output .= '<a href="location.php?id='.$item->id.'" data-toggle="tooltip" data-placement="top" title="View Reviews"><i class="fa fa-info-circle"></i></a>
                                <a href="location-details.php?id='.$item->id.'" data-toggle="tooltip" data-placement="top" title="View Location Details"><i class="fa fa-map-marker"></i></a>';

				}elseif( $value == 'review' ){
					$output .= $survey->get_review( $item->id );
				}elseif( $value == 'survey_physician_name' ){
					$output .= '<a href="physician-details.php?id='.$item->physician.'">'.clean_string( $physician->get_name( $item->physician ) ).'</a>';
				}elseif( $value == 'survey_patient_name' ){
					$output .= '<a href="patient-details.php?id='.$item->patient.'">'.clean_string( $patient->get_name( $item->patient ) ).'</a>';
				}elseif( $value == 'survey_patient_id' ){
					$output .= clean_string( $patient->get_value( $item->patient, 'patient_id' ) );
				}else{
					$output .= clean_string( $item->$value );
				}

				$output .= '</td>';
			}

			$output .= '</tr>';
		}
	}

	$output .= '</table>';



	return $output;
}

function search_exists( $elements = array() ){
	$output = false;
	foreach ( $elements as $element ) {
		if( strlen($element) > 0 ){
			$output = true;
		}
	}
	return $output;
}

function permision_warning_mgs(){
	return '<div class="alert alert-danger alert-dismissible" role="alert">You don\'t have permition to see this data.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
}

function no_search_results_mgs( $for = "data" ){
	return '<div class="alert alert-danger alert-dismissible" role="alert">0 results found.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
}

function no_data_found_mgs( $for = "data" ){
	return '<div class="alert alert-danger alert-dismissible" role="alert">0 results found.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
}

function get_users_table(  $page = 1, $per_page = 10, $status = 1, $name = "", $role = "", $location = "", $timeframe = "" ){
	global $user, $current_user;

	$output = "";

	if( true ){

		$headers = array(
			'First Name' => 'first_name_img',
			'Last Name' => 'last_name_img',
			'Location' => 'location',
			'Role' => 'role',
			'Action' => 'active_actions'
			);

		if( $status == 0 ){
			$headers["Action"] = 'archived_actions';
		}

		$data = $user->search( $page, $per_page, $status, $name, $role, $location, $timeframe );
		$total = $user->total_search( $status, $name, $role, $location, $timeframe );

		if( $total > 0 ){
			$output .= get_table( 'user', $headers, $data );
			$output .= pagination( $total, $per_page, $page, "", true, "user" );
		}else{
			if( search_exists( array( $name, $role, $location, $timeframe ) ) ){
				$output .= no_search_results_mgs("users");
			}else{
				$output .= no_data_found_mgs("users");
			}
		}

	}else{
		$output .= permision_warning_mgs();
	}

	return $output;

}

function get_clients_table(  $page = 1, $per_page = 10, $status = 1, $name = "", $physician = "", $user = "", $timeframe = "" ){
    global $client, $current_user;

    $output = "";

    if( true ){

        $headers = array(
            'Client Name' => 'name',
            'Email address' => 'email',
            'Is active' => 'status',
            'Action' => 'active_actions'
        );

        if( $status == 0 ){
            $headers["Action"] = 'archived_actions';
        }

        $data = $client->search( $page, $per_page, $status, $name, $user, $timeframe );
        $total = $client->total = $client->total_search( $status, $name, $user, $timeframe );

        if( $total > 0 ){
            $output .= get_table( 'client', $headers, $data );
            $output .= pagination( $total, $per_page, $page, "", true, "client" );
        }else{
            if( search_exists( array( $name, $physician, $user, $timeframe ) ) ){
                $output .= no_search_results_mgs("locations");
            }else{
                $output .= no_data_found_mgs("locations");
            }
        }

    }else{
        $output .= permision_warning_mgs();
    }

    return $output;

}

function get_professionals_table(  $page = 1, $per_page = 10, $status = 1, $name = "",  $user = "", $timeframe = "" ){
    global $professional, $current_user;

    $output = "";

    if( true ){

        $headers = array(
            'Professional Name' => 'name',
            'Email' => 'email',
            'Location' => 'location_name',
            'Action' => 'active_actions'
        );

        if( $status == 0 ){
            $headers["Action"] = 'archived_actions';
        }

        $data = $professional ->search( $page, $per_page, $status, $name, $user, $timeframe );
        $total =  $professional->total = $professional->total_search($status,$name, $user, $timeframe );

        if( $total > 0 ){
            $output .= get_table( 'professional', $headers, $data );
            $output .= pagination( $total, $per_page, $page, "", true, "professional" );
        }//else{
        // if( search_exists( array( $name, $professional, $user, $timeframe ) ) ){
        //   $output .= no_search_results_mgs("professional");
        //}else{
                //$output .= no_data_found_mgs("professional");
             //}
        //}

    }else{
        $output .= permision_warning_mgs();
    }

    return $output;

}





function get_locations_table(  $page = 1, $per_page = 10, $status = 1, $name = "", $user = "", $timeframe = "" ){
	global $location, $current_user;

	$output = "";

	if( true ){

		$headers = array(
			'Location Name' => 'location_name',
			'Address' => 'street',
			'City' => 'city',
			'State' => 'state',
			'Is active' => 'status',
			'Action' => 'location_action'
			);

		if( $status == 0 ){
			$headers["Action"] = 'archived_actions';
		}

		$data = $location->search( $page, $per_page, $status, $name, $user, $timeframe );
		$total = $location->total = $location->total_search( $status, $name, $user, $timeframe );

		if( $total > 0 ){
			$output .= get_table( 'location', $headers, $data );
			$output .= pagination( $total, $per_page, $page, "", true, "location" );
		}else{
			if( search_exists( array( $name, $user, $timeframe ) ) ){
				$output .= no_search_results_mgs("locations");
			}else{
				$output .= no_data_found_mgs("locations");
			}
		}

	}else{
		$output .= permision_warning_mgs();
	}

	return $output;

}

function get_message_table(  $page = 1, $per_page = 10, $status = 1, $read = "", $type = "", $timeframe = "" ){
	global $message, $current_user;

	$output = "";

	if( true ){

		$headers = array(
			'From' => 'from_id',
			'Type' => 'type',
			'Subject' => 'subject',
			'Date' => 'date',
			'Action' => 'active_actions'
			);

		if( $status == 0 ){
			$headers["Action"] = 'archived_actions';
		}

		$data = $message->search( $page, $per_page, $status, $current_user->id, $read, $type, $timeframe );
		$total = $message->total_search( $status, $current_user->id, $read, $type, $timeframe );

		if( $data && $total > 0 ){
			$output .= get_table( 'message', $headers, $data );
			$output .= pagination( $total, $per_page, $page, "", true, "message" );
		}else{
			if( search_exists( array( $read, $timeframe ) ) ){
				$output .= no_search_results_mgs("message");
			}else{
				$output .= no_data_found_mgs("message");
			}
		}

	}else{
		$output .= permision_warning_mgs();
	}

	return $output;

}






function get_language_stats_table( $timeframe = "", $location_id = 0 ){
	global $survey, $current_user;

	$output = "";

	$headers = array(
			'Flag' => 'flag',
			'Language' => 'language',
			'Total' => 'total',
			'Details' => 'details_link'
			);

	$data = array();
	$lang_item = array(
		'id' => 1,
		'flag' => '<i class="en-flag"></i>',
		'language' => 'English',
		'total' => $survey->total_for_lang("en", $timeframe, $location_id),
		'details_link' => '<a href="language.php?lang=en" data-toggle="tooltip" data-placement="top" title="View English Reviews"><i class="fa fa-info-circle"></i></a>'
		);
	$data[] = (object)$lang_item;

	$lang_item = array(
		'id' => 2,
		'flag' => '<i class="sp-flag"></i>',
		'language' => 'Spanish',
		'total' => $survey->total_for_lang("sp", $timeframe, $location_id),
		'details_link' => '<a href="language.php?lang=sp" data-toggle="tooltip" data-placement="top" title="View Spanish Reviews"><i class="fa fa-info-circle"></i></a>'
		);
	$data[] = (object)$lang_item;


	$total = 2;

	if( $data && $total > 0 ){
		$output .= get_table( 'language_stats', $headers, $data );
	}

	return $output;
}

function get_contact_stats_table( $timeframe = "", $location_id = 0 ){
	global $survey, $current_user;

	$output = "";

	$headers = array(
			'Contact' => 'yesorno',
			'Total' => 'total',
			'Details' => 'details_link'
			);

	$data = array();
	$item = array(
		'id' => 1,
		'yesorno' => 'Yes',
		'total' => $survey->total_for_contact( 'yes', $timeframe, $location_id ),
		'details_link' => '<a href="contact.php?docontact=yes" data-toggle="tooltip" data-placement="top" title="View Contact Yes Reviews"><i class="fa fa-info-circle"></i></a>'
		);
	$data[] = (object)$item;

	$item = array(
		'id' => 2,
		'yesorno' => 'No',
		'total' => $survey->total_for_contact( 'no', $timeframe, $location_id ),
		'details_link' => '<a href="contact.php?docontact=no" data-toggle="tooltip" data-placement="top" title="View Contact No Reviews"><i class="fa fa-info-circle"></i></a>'
		);
	$data[] = (object)$item;


	$total = 2;

	if( $data && $total > 0 ){
		$output .= get_table( 'contact_stats', $headers, $data );
	}

	return $output;
}

function get_location_stats_table( $page = 1, $per_page = 10, $timeframe = "", $physician = 0, $user = 0 ){
	global $survey, $current_user;

	$output = "";

	if( true ){

		$headers = array(
			'Location' => 'location',
			'Stats' => 'total',
			'Action' => 'location_stats_action'
			);

		$survey->order_by = 'location';

		$data = $survey->location_stats_search( $page, $per_page, $timeframe, $physician, $user );
		$total = $survey->total_location_stats_search( $timeframe, $physician, $user );

		if( $data && $total > 0 ){
			$output .= get_table( 'location_stats', $headers, $data );
			$output .= pagination( $total, $per_page, $page, "", true, "location_stats" );
		}else{
			if( search_exists( array( $timeframe, $physician, $user ) ) ){
				$output .= no_search_results_mgs("Location Stats");
			}else{
				$output .= no_data_found_mgs("Location Stats");
			}
		}

	}else{
		$output .= permision_warning_mgs();
	}

	return $output;
}

function get_statistic_table( $timeframe = "", $location = 0, $physician = 0 ){
	global $survey, $current_user, $en_questions, $en_answers;

	$output = "";

	if( true ){

		$stats = $survey->get_statistic( $timeframe, $location, $physician );
		$output .= '<table class="table">';
		$output .= '<tr><th>Question</th>';

		foreach ( $en_answers as $answer ):
			$output .= '<th class="text-center">'.strip_tags($answer).'</th>';
		endforeach;

		foreach ( $en_questions as $q_id => $q_text ):
			$output .= '<tr>';
			$output .= '<td><strong><a href="question.php?question='.$q_id.'&answer=1">'.$q_text.'</a></strong></td>';
			$output .= '<td class="text-center"><small class="sum-info"><a href="question.php?question='.$q_id.'&answer=1">'.$stats[$q_id][1].'</a></small></td>';
			$output .= '<td class="text-center"><small class="sum-info"><a href="question.php?question='.$q_id.'&answer=2">'.$stats[$q_id][2].'</a></small></td>';
			$output .= '<td class="text-center"><small class="sum-info"><a href="question.php?question='.$q_id.'&answer=3">'.$stats[$q_id][3].'</a></small></td>';
			$output .= '<td class="text-center"><small class="sum-info"><a href="question.php?question='.$q_id.'&answer=4">'.$stats[$q_id][4].'</a></small></td>';
			$output .= '<td class="text-center"><small class="sum-info"><a href="question.php?question='.$q_id.'&answer=5">'.$stats[$q_id][5].'</a></small></td>';
			$output .= '</tr>';
		endforeach;

		$output .= '<tr>';
		$output .= '<td><div id="note-result"><small class="bg-warning">* <strong>'.$survey->total_search().'</strong> Reviews</small></div></td>';
		$output .= '<td class="text-center"><span class="strongly-agree-btn">'.$stats[0][1].'</span></td>';
		$output .= '<td class="text-center"><span class="strongly-agree-btn">'.$stats[0][2].'</span></td>';
		$output .= '<td class="text-center"><span class="neitheragree-btn">'.$stats[0][3].'</span></td>';
		$output .= '<td class="text-center"><span class="strongly-disagree-btn">'.$stats[0][4].'</span></td>';
		$output .= '<td class="text-center"><span class="strongly-disagree-btn">'.$stats[0][5].'</span></td>';
		$output .= '</tr>';

		$output .= '</table>';

	}

	return $output;

}

function show_table_total( $total ){
	$text = ( $total == 1 ) ? '1 Result' : $total . " Results";

	return '<div class="row">
        <div class="col-md-6" id="note-result">
            <small>* '.$text.'</small>
        </div>
    </div>';
}


function get_tab_table_locations( $locations ){
	global $location;

	$output = "";

	$headers = array(
		'Location Name' => 'location_name',
		'Address' => 'address_1',
		'City' => 'city',
		'State' => 'state',
		'Action' => 'details_actions'
		);

	$data = $location->get_by_ids( $locations );
	$total = $location->total_by_ids( $locations );

	if( $data && $total > 0 ){
		$output .= get_table( 'location', $headers, $data );
		$output .= show_table_total( $total );
	}else{
		$output .= no_data_found_mgs("Location");
	}

	return $output;
}

function get_tab_table_physicians( $physicians ){
	global $physician;

	$output = "";

	$headers = array(
		'Image' => 'image',
		'First Name' => 'first_name',
		'Last Name' => 'last_name',
		'Location' => 'location_name',
		'Phone' => 'physician_phone',
		'Email' => 'physician_email',
		'Action' => 'details_actions'
		);

	$data = $physician->get_by_id( $physicians );
	$total = $physician->total_by_id( $physicians );

	if( $data && $total > 0 ){
        foreach ($data as $d) {
            $d->id = $d->physician_id;
        }
		$output .= get_table( 'physician', $headers, $data );
		$output .= show_table_total( $total );
	}else{
		$output .= no_data_found_mgs("Physician");
	}

	return $output;
}

function get_tab_table_users( $users ){
	global $user;

	$output = "";

	$headers = array(
		'Image' => 'image',
		'First Name' => 'first_name',
		'Last Name' => 'last_name',
		'Location' => 'location',
		'Email' => 'email',
		'Action' => 'details_actions'
		);

	$data = $user->get_by_ids( $users );
	$total = $user->total_by_ids( $users );

	if( $data && $total > 0 ){
		$output .= get_table( 'user', $headers, $data );
		$output .= show_table_total( $total );
	}else{
		$output .= no_data_found_mgs("User");
	}

	return $output;
}

function get_tab_table_patients( $patients ){
	global $patient;

	$output = "";

	$headers = array(
		'First Name' => 'first_name',
		'Last Name' => 'last_name',
		'Location' => 'location_name',
		'DOB' => 'dob',
		'Phone' => 'phone',
		'Email' => 'email',
		'Action' => 'details_actions'
		);

	$data = $patient->get_by_id( $patients );
	$total = $patient->total_by_id( $patients );

	if( $data && $total > 0 ){
		$output .= get_table( 'patient', $headers, $data );
		$output .= show_table_total( $total );
	}else{
		$output .= no_data_found_mgs("Patient");
	}

	return $output;
}

function get_table_patients_by_physicians( $physician_id ){
    global $patient;

    $output = "";

    $headers = array(
        'First Name' => 'patient_first_name',
        'Last Name' => 'last_name',
        'Location' => 'location_name',
        'DOB' => 'dob',
        'Phone' => 'phone',
        'Email' => 'email',
        'Action' => 'details_actions'
    );

    $data = $patient->get_patients_of_physician( $physician_id );
    $total = $patient->total_get_patients_of_physician( $physician_id );

    if( $data && $total > 0 ){
        $output .= get_table( 'patient', $headers, $data );
        $output .= show_table_total( $total);
    }else{
        $output .= no_data_found_mgs("Patient");
    }

    return $output;
}





function get_tab_table_surveys( $surveys ){
	global $survey;

	$output = "";

	$headers = array(
		'Date Created' => 'date',
		'Physician Name' => 'survey_physician_name',
		'Location' => 'location',
		'Review' => 'review',
		'Action' => 'details_actions'
		);

	$data = $survey->get_by_ids( $surveys );
	$total = $survey->total_by_ids( $surveys );

	if( $data && $total > 0 ){
		$output .= get_table( 'survey', $headers, $data );
		$output .= show_table_total( $total );
	}else{
		$output .= no_data_found_mgs("Survey");
	}

	return $output;
}

function get_tab_table_physicians_by_patient($patient_id){
    global $physician;

    $output = "";

    $headers = array(
        'Image' => 'image',
        'First Name' => 'first_name',
        'Last Name' => 'last_name',
        'Location' => 'location_name',
        'Phone' => 'physician_phone',
        'Email' => 'physician_email',
        'Action' => 'details_actions'
    );

    $data = $physician->physicians_by_patient( $patient_id );
    $total = $physician->total_physicians_by_patient( $patient_id );

    if( $data && $total > 0 ){
        foreach ($data as $d) {
            $d->id = $d->physician_id;
        }
        $output .= get_table( 'physician', $headers, $data );
        $output .= show_table_total( $total );
    }else{
        $output .= no_data_found_mgs("Physician");
    }

    return $output;
}

function get_tab_table_locations_by_patient($patient_id){
    global $location;

    $output = "";

    $headers = array(
        'Location Name' => 'location_name',
        'Address' => 'address_1',
        'City' => 'city',
        'State' => 'state',
        'Action' => 'details_actions'
    );

    $data = $location-> locations_by_patient( $patient_id );
    $total = $location-> total_locations_by_patient( $patient_id );

    if( $data && $total > 0 ){
        $output .= get_table( 'location', $headers, $data );
        $output .= show_table_total( $total );
    }else{
        $output .= no_data_found_mgs("Location");
    }

    return $output;
}

?>