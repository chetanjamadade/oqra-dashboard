<?php
function pagination( $total, $per_page, $current, $base = "", $ajax = false, $what = "" ){
	$output = "";
	$current = ( $current > 0 ) ? $current : 1;

	if( $total > $per_page ){
		$pages = ceil( $total / $per_page );
		$current = ( $current > $pages ) ? 1 : $current;

		$output .= '<div class="row">';
		$output .= '<div class="col-md-6" id="note-result"><small class="bg-warning">* <strong>'.$per_page.'</strong> Results per Page</small></div>';
		$output .= '<div class="col-md-6" id="pagi-wrapper">';

		$output .= '<nav><ul class="pagination'.( $ajax ? ' ajax-nav' : '' ).'"'.( $ajax ? ' data-name="'.$what.'" data-id="'.$per_page.'"' : '' ).'>';

		if( $current > 1 ){
			$output .= '<li><a href="'.$base.'1" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
		}


		for ( $i=1; $i <= $pages; $i++) { 
			$output .= '<li><a href="'.$base.$i.'">'.$i.'</a></li>';
		}
			

		if( $current != $pages ){
			$output .= '<li><a href="'.$base.$pages.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
		}

        $output .= '</ul></nav>';

        $output .= '</div></div>';
	}

	return $output;
}

function get_state_array(){
	return array(
		'AL' => 'Alabama',
		'AK' => 'Alaska',
		'AZ' => 'Arizona',
		'AR' => 'Arkansas',
		'CA' => 'California',
		'CO' => 'Colorado',
		'CT' => 'Connecticut',
		'DE' => 'Delaware',
		'DC' => 'District Of Columbia',
		'FL' => 'Florida',
		'GA' => 'Georgia',
		'HI' => 'Hawaii',
		'ID' => 'Idaho',
		'IL' => 'Illinois',
		'IA' => 'Indiana',
		'KS' => 'Kansas',
		'KY' => 'Kentucky',
		'LA' => 'Louisiana',
		'ME' => 'Maine',
		'MD' => 'Maryland',
		'MA' => 'Massachusetts',
		'MI' => 'Michigan',
		'MN' => 'Minnesota',
		'MS' => 'Mississippi',
		'MO' => 'Missouri',
		'MT' => 'Montana',
		'NE' => 'Nebraska',
		'NV' => 'Nevada',
		'NH' => 'New Hampshire',
		'NJ' => 'New Jersey',
		'NM' => 'New Mexico',
		'NY' => 'New York',
		'NC' => 'North Carolina',
		'ND' => 'North Dakota',
		'OH' => 'Ohio',
		'OK' => 'Oklahoma',
		'OR' => 'Oregon',
		'PA' => 'Pennsylvania',
		'RI' => 'Rhode Island',
		'SC' => 'South Carolina',
		'SD' => 'South Dakota',
		'TN' => 'Tennessee',
		'TX' => 'Texas',
		'UT' => 'Utah',
		'VT' => 'Vermont',
		'VA' => 'Virginia',
		'WA' => 'Washington',
		'WV' => 'West Virginia',
		'WI' => 'Wisconsin',
		'WY' => 'Wyoming'
		);
}

function state_name_by_id( $id ){
	$states = get_state_array();
	return $states[$id];
}

function state_select_box( $selected = "TX", $required = true ){
	$states = get_state_array();
	$selected = ( $selected != "" ) ? $selected : "TX";
	$output = '<select name="state" class="chosen-select-width'.( $required ? ' required' : '' ).'" data-placeholder="State">';
		foreach ( $states as $key => $value ) {
			$output .= '<option value="'.$key.'"'.( ($selected == $key) ? 'selected' : '' ).'>' . $value . '</option>';
		}
  	$output .= '</select>';

  	return $output;
}

function client_search_box($name="selected_client_id", $selected = 0){
    $client = new Client();
    $clients = $client->get_all_active();
    $output =  '<select name="'.$name.'" id="'.$name.'" class="selectpicker" data-live-search="true" id="search-box-client">';
    $output .= '<option value=""> </option>';
    if( is_array($clients) ){
        foreach ( $clients as $c ) {
            $output .= '<option value="' . $c->id . '"'.( $c->id == $selected ? 'selected' : '' ).'>' . $c->name . '</option>';
        }
    }
    $output .= '</select>';

    echo $output;
}


function image_upload_element(){
	?>
	<input type="file" name="file"><small class="help-text">Supported Formats: JPG, PNG, GIF</small>
	<?php
}

function edit_image_box( $image ){
	?>
	<div class="userProfileImage image-to-remove">
		<img src="<?php echo show_image($image); ?>" alt="" class="img-responsive">
	</div>

	<?php if( strlen( $image ) > 0 ){ echo '<input type="checkbox" name="remove-image" value="on"> Remove image'; } ?>

	<div class="form-group">
		<label><?php if( strlen( $image ) > 0 ){ echo 'New Photo';}else{ echo 'Photo'; } ?></label>
		<input type="file" name="file" accept="image/*">
	</div>
	<?php
}

function edit_image_4_5_box( $image ){
    ?>
    <div class="userProfileImage image-to-remove">
        <img src="<?php echo show_image($image); ?>" alt="" class="img-responsive">
    </div>

    <?php if( strlen( $image ) > 0 ){ echo '<input type="checkbox" name="remove-image" value="on"> Remove image'; } ?>

    <div class="form-group">
        <label><?php if( strlen( $image ) > 0 ){ echo 'New Photo';}else{ echo 'Photo'; } ?></label>
        <input type="file" name="email_image_4_5" accept="image/*">
    </div>
    <?php
}
function edit_image_3_under_box( $image ){
    ?>
    <div class="userProfileImage image-to-remove">
        <img src="<?php echo show_image($image); ?>" alt="" class="img-responsive">
    </div>

    <?php if( strlen( $image ) > 0 ){ echo '<input type="checkbox" name="remove-image" value="on"> Remove image'; } ?>

    <div class="form-group">
        <label><?php if( strlen( $image ) > 0 ){ echo 'New Photo';}else{ echo 'Photo'; } ?></label>
        <input type="file" name="email_image_3_under" accept="image/*">
    </div>
    <?php
}

function role_name_by_id( $id ){
	global $surveyapp;
	return $surveyapp['roles'][$id];
}

function role_select_box( $required = true, $add_none = true, $selected = 0 ){
	global $surveyapp;
	$output = '<select name="role" class="chosen-select-width'.( $required ? ' required' : '' ).'" data-placeholder="Role">';
	if( $add_none ){
		$output .= '<option value=""> </option>';
	}
	foreach ( $surveyapp["roles"] as $id => $label ) {
		$output .= '<option value="' . $id . '"'.( $id == $selected ? 'selected' : '' ).'>' . $label . '</option>';
	}
	$output .= '</select>';

	return $output;
}



function location_select_box( $required = true, $add_none = true, $selected = 0 ){
	global $location;
	$locations = $location->get_all_active();
    $locations_selected = $location->get_all_by_id($selected);
	$output = '';
    if( $add_none ){
        $output .= '<option value=""> </option>';
    }
	if( is_array($locations) ){
		foreach ( $locations as $l ) {
		    $sel = "";
            foreach ( $locations_selected as $ls ) {
                if($l->id==$ls->id){
                    $sel = "selected";
                }
            }
			$output .= '<option value="' . $l->id . '"'.$sel.'>' . $l->location_name . '</option>';
		}
	}
	$output .= '';

	return $output;
}

function location_select_box_for_user( $required = true, $add_none = true, $selected = 0 ){
    global $location;
    $user_id = $_SESSION["logged-user"]->id;
    $locations = $location->get_all_active_for_user($user_id);
    $locations_selected = $location->get_all_by_id($selected);
    $output = '';
    if( $add_none ){
        $output .= '<option value=""> </option>';
    }
    if( is_array($locations) ){
        foreach ( $locations as $l ) {
            $sel = "";
            foreach ( $locations_selected as $ls ) {
                if($l->id==$ls->id){
                    $sel = "selected";
                }
            }
            $output .= '<option value="' . $l->id . '"'.$sel.'>' . $l->location_name . '</option>';
        }
    }
    $output .= '';

    return $output;
}

function locations_select_box( $required = true, $add_none = true, $selected = 0 ){
    global $location;
    $locations = $location->get_all_active();
    $output = '<select name="locations[]" class="chosen-select-width'.( $required ? ' required' : '' ).'"multiple data-placeholder="Locations">';
    if( $add_none ){
        $output .= '<option value=""> </option>';
    }
    if( is_array($locations) ){
        foreach ( $locations as $l ) {
            $output .= '<option value="' . $l->id . '"'.( $l->id == $selected ? 'selected' : '' ).'>' . $l->location_name . '</option>';
        }
    }
    $output .= '</select>';

    return $output;
}



function physicians_select_box( $required = true, $add_none = true, $selected = array() ){
	global $physician;
	$physicians = $physician->get_all_active();
	$output = '<select name="physicians[]" class="chosen-select-width'.( $required ? ' required' : '' ).'" multiple data-placeholder="Physicians">';
	if( $add_none ){
		$output .= '<option value=""> </option>';
	}
	if( is_array($physicians) ){
		foreach ( $physicians as $p ) {
			$output .= '<option value="' . $p->id . '"'.( in_array($p->id, $selected) ? 'selected' : '' ).'>' . merge_name( $p->first_name, $p->middle_name, $p->last_name ) . '</option>';
		}
	}
	$output .= '</select>';

	return $output;
}

function location_search_box( $name = "search-by-location", $selected = 0 ){
	global $location;
	$locations = $location->get_all_active();
	$output = '<select name="'.$name.'" id="'.$name.'" class="chosen-select-width" data-placeholder="By Location">';

	$output .= '<option value=""> </option>';
	$output .= '<option value="">All</option>';

	foreach ( $locations as $l ) {
		$output .= '<option value="' . $l->id . '"'.( $l->id == $selected ? 'selected' : '' ).'>' . $l->location_name . '</option>';
	}
	$output .= '</select>';

	echo $output;
}

function role_search_box( $name = "search-user-by-role" ){
	global $surveyapp;
	$output = '<select name="'.$name.'" id="'.$name.'" class="chosen-select-width" data-placeholder="By Role">';
	$output .= '<option value=""> </option>';
	$output .= '<option value="">All</option>';
	foreach ( $surveyapp["roles"] as $id => $label ) {
		$output .= '<option value="' . $id . '">' . $label . '</option>';
	}
	$output .= '</select>';

	echo $output;
}

function physician_search_box( $name = "search-by-physician" ){
	global $physician;
	$physicians = $physician->get_all_active();
	$output = '<select name="'.$name.'" id="'.$name.'" class="chosen-select-width" data-placeholder="By Physician">';
	$output .= '<option value=""> </option>';
	$output .= '<option value="">All</option>';
	if( is_array($physicians) ){
		foreach ( $physicians as $p ) {
			$output .= '<option value="' . $p->id . '">' . merge_name( $p->first_name, $p->middle_name, $p->last_name ) . '</option>';
		}
	}
	$output .= '</select>';

	echo $output;
}

function physicians_by_location_select_box( $id= "populated-physicians-by-location", $required = true, $add_none = true, $selected = array() ){
    global $physician;
    $physicians = $physician->physicians_by_location();
    $output = '<select name="physicians[]" id="'.$id.'" class="chosen-select-width'.( $required ? ' required' : '' ).'" multiple data-placeholder="Physicians">';
    if( $add_none ){
        $output .= '<option value=""> </option>';
    }
    if( is_array($physicians) ){

        foreach ( $physicians as $p ) {
            $output .= '<option value="' . $p->physician_id . '"'.( in_array($p->physician_id, $selected) ? 'selected' : '' ).'>' . $p->first_name . '</option>';
        }
    }
    $output .= '</select>';

    return $output;
}

function department_by_location_select_box( $id= "populated-departments-by-location", $required = true, $add_none = true, $selected = array() ){
    global $department;
    $departments = $department->departments_by_location();
    $output = '<select name="departments[]" id="'.$id.'" class="chosen-select-width'.( $required ? ' required' : '' ).'" multiple data-placeholder="Departments">';
    if( $add_none ){
        $output .= '<option value=""> </option>';
    }
    if( is_array($departments) ){

        foreach ( $departments as $d ) {
            $output .= '<option value="' . $d->id . '"'.( in_array($d->id, $selected) ? 'selected' : '' ).'>' . $d->first_name . '</option>';
        }
    }
    $output .= '</select>';

    return $output;
}

function department_search_box( $name = "search-by-department" ){
    global $department;
    $departments = $department->get_all_active();
    $output = '<select name="'.$name.'" id="'.$name.'" class="chosen-select-width" data-placeholder="By Department">';
    $output .= '<option value=""> </option>';
    $output .= '<option value="">All</option>';
    if( is_array($departments) ){
        foreach ( $departments as $d ) {
            $output .= '<option value="' . $d->id . '">' . merge_name( $d->department_name ) . '</option>';
        }
    }
    $output .= '</select>';

    echo $output;
}

function department_select_box( $required = true, $add_none = true, $selected = array() ){
    global $department;
    $departments = $department->get_all_active();
    $output = '<select name="department" class="chosen-select-width'.( $required ? ' required' : '' ).'"data-placeholder="Departments">';
    if( $add_none ){
        $output .= '<option value=""> </option>';
    }
    if( is_array($departments) ){
        foreach ( $departments as $d ) {
            $output .= '<option value="' . $d->id . '"'.( in_array($d->id, $selected) ? 'selected' : '' ).'>' . $d->department_name . '</option>';
        }
    }
    $output .= '</select>';

    return $output;
}

function departments_select_box( $required = true, $add_none = true, $selected = array() ){
    global $location;
    $locations = $location->get_all_active();
    $output = '<select name="locations[]" class="chosen-select-width'.( $required ? ' required' : '' ).'" multiple data-placeholder="Locations">';
    if( $add_none ){
        $output .= '<option value=""> </option>';
    }
    if( is_array($locations) ){
        foreach ( $locations as $d ) {
            $output .= '<option value="' . $d->id . '"'.( in_array($d->id, $selected) ? 'selected' : '' ).'>' . $d->location_name . '</option>';
        }
    }
    $output .= '</select>';

    return $output;
}

function user_search_box_custom( $name = "search-by-user" )
{
    global $user;
    $users = $user->get_all_active_users();
    $output = '<select name="' . $name . '" id="' . $name . '" class="chosen-select-width" data-placeholder="By User">';
    $output .= '<option value=""> </option>';
    $output .= '<option value="">All</option>';
    if (is_array($users)) {
        foreach ($users as $u) {
            $output .= '<option value="' . $u->id . '">' . $u->first_name . " " . $u->last_name . '</option>';
        }
    }
    $output .= '</select>';

    echo $output;

}

function user_search_box( $name = "search-by-user" ){
    global $user;
    $users = $user->get_all_active_users();
    $output = '<select name="'.$name.'" id="'.$name.'" class="selectpicker" data-live-search="true" id="search-box-client">';
    $output .= '<option value=""> </option>';
    $output .= '<option value="">All</option>';
    if( is_array($users) ){
        foreach ( $users as $u ) {
            $output .= '<option value="' . $u->id . '">' . $u->first_name." ".$u->last_name . '</option>';
        }
    }
    $output .= '</select>';

    echo $output;
}
function language_search_box( $name = "search-by-language" ){

	echo simple_search_box( $name, array( "en" => 'English', "sp" => "Spanish" ), "By Language" );

}

function contact_search_box( $name = "search-by-contact" ){

	echo simple_search_box( $name, array( "yes" => 'Yes', "no" => "No" ), "By Contact" );

}

function review_search_box( $name = "search-by-review" ){

	echo simple_search_box( $name, array( "positive" => 'Positive', "neutralornegative" => "Neutral or Negative" ), "By Review" );

}

function patient_type_search_box( $name = "search-by-patient-type" ){

	echo simple_search_box( $name, array( "real" => 'Existing Patients', "generic" => "Inserted Patients" ), "By Patient type" );

}

function read_search_box( $name = "search-by-read" ){

	echo simple_search_box( $name, array( "read" => 'Read', "unread" => "Unread" ), "Read or Unread" );

}

function message_type_search_box( $name = "search-by-type" ){

	echo simple_search_box( $name, array( "forgoten-password" => 'Forgoten Password', "support" => "Support" ), "By Type" );

}

function simple_search_box( $name = "", $options = array(), $placeholder = "" ){
	$output = '<select name="'.$name.'" id="'.$name.'" class="chosen-select-width" data-placeholder="'.$placeholder.'">';
	$output .= '<option value=""> </option>';
	$output .= '<option value="">All</option>';
	foreach ( $options as $key => $value ) {
		$output .= '<option value="'.$key.'">'.$value.'</option>';
	}
	
	$output .= '</select>';

	return $output;
}

function timeframe_search_box( $name = "search-by-timeframe", $selected = "" ){
	echo '<select name="'.$name.'" id="'.$name.'" data-placeholder="Timeframe" class="chosen-select-width timeframe-select" tabindex="2">';
	echo '<option value=""></option>';
	echo '<option value="">All</option>';
	foreach ( valid_timeframes() as $label => $value ) {
		echo '<option value="'.$value.'"'.( $value == $selected ? 'selected' : '' ).'>'.$label.'</option>';
	}
	echo '<select>
	<div class="timeframe-custom">
	<input type="text" id="datepicker3" placeholder="Start date" value="'.date("m/d/Y").'">
	<input type="text" id="datepicker4" placeholder="End date" value="'.date("m/d/Y").'">
	</div>
	';
}

function print_archive_modal( $what ){
	?>
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title" id="myModalLabel">Warning</h4>
	            </div>
	            <div class="modal-body">
	                <p>WARNING: Are you sure that you want to <strong>Archive <?php echo ucfirst($what); ?></strong>? You can't undo that action.</p>
	            </div>
	            <div class="modal-footer">
	                <a id="deletelink" href="#" class="btn btn-primary ajax-add-to-archive" data-id="0" data-name="<?php echo $what; ?>">Archive <?php echo ucfirst($what); ?></a>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
	        </div>
	    </div>
	</div>   
	<?php
}

function print_remove_modal( $what ){
	?>
	<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title" id="myModalLabel">Warning</h4>
	            </div>
	            <div class="modal-body">
	                <p>WARNING: Are you sure that you want to <strong>remove <?php echo ucfirst($what); ?> forever</strong>? You can't undo that action.</p>
	            </div>
	            <div class="modal-footer">
	                <a id="deletelink" href="#" class="btn btn-primary ajax-remove-forever" data-id="0" data-name="<?php echo $what; ?>">Remove <?php echo ucfirst($what); ?></a>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
	        </div>
	    </div>
	</div>   
	<?php
}

function print_activate_modal( $what ){
	?>
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title" id="myModalLabel">Warning</h4>
	            </div>
	            <div class="modal-body">
	                <p>WARNING: Are you sure that you want to <strong>Activate <?php echo ucfirst($what); ?></strong>? You can't undo that action.</p>
	            </div>
	            <div class="modal-footer">
	                <a id="deletelink" href="#" class="btn btn-primary ajax-reactivate-this" data-id="0" data-name="<?php echo $what; ?>">Activate <?php echo ucfirst($what); ?></a>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
	        </div>
	    </div>
	</div>   
	<?php
}

function print_alert_success( $text ){
	?>
	<div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Well done!</strong> <?php echo $text ?>
    </div>
	<?php
}

function print_alert_error( $text ){
	?>
	<div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Error!</strong> <?php echo $text ?>
    </div>
	<?php
}

function print_warning_error( $text ){
	?>
	<div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong></strong> <?php echo $text ?>
    </div>
	<?php
}

function print_update_messages( $what ){
	if( isset($_GET["new_added"]) && $_GET["new_added"] == 'true' ){
    	print_alert_success( "You successfully added new ".$what."." );
    }

    if( isset($_GET["updated"]) && $_GET["updated"] == 'true' ){
    	print_alert_success( "You've successfully updated ".$what."." );
    }

    if( isset($_GET["error"]) && $_GET["error"] == 'true' ){
    	print_alert_error( "Error." );
    }
}

function print_survey_search_form(){
	?>
	<form action="" method="POST" id="survey-search-form">
		<input type="hidden" id="timeframe-hidden" name="timeframe" value="">
		<input type="hidden" id="physician-hidden" name="physician"value="">
		<input type="hidden" id="location-hidden" name="location"value="">
		<input type="hidden" id="user-hidden" name="user"value="">
		<input type="hidden" id="language-hidden" name="language"value="">
		<input type="hidden" id="contact-hidden" name="contact"value="">
		<input type="hidden" id="review-hidden" name="review" value="">
		<input type="hidden" id="patient-type-hidden" name="patient-type"value="">
		<input type="hidden" id="order-hidden" name="order"value="">
		<input type="hidden" id="order-by-hidden" name="order-by"value="">
	</form>
	<?php
}
?>