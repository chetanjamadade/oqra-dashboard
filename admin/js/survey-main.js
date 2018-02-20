jQuery(function(){

	/* ************************************
	* STEP 1 - CHOOSE LANGUAGE
	************************************ */

	jQuery(".survey-lang").click(function(e){
		e.preventDefault();

		jQuery("#language-hidden").val(jQuery(this).attr("data-id"));
		jQuery("#choose-language-form").submit();

	});

	/* ************************************
	* STEP 2 - SEARCH FOR PATIENT
	************************************ */

	function search_patient_by_id( patient_id ){

		data = {
			'ajax_action' : 'ajax_search_patient_by_id',
			'patient_id' : patient_id
		}

		jQuery.post(ajaxurl, data, function(response) {
			if( response == "found" ){
				populate_search_patient_form( "id" );
			}else{
				jQuery(".no-users-with-id").fadeIn("fast", function(){
					jQuery(this).fadeOut(3000);
				});
			}
		});

		
	}

	function search_patient_by_info( first_name, last_name, dob ){
		var found = false;

		data = {
			'ajax_action' : 'ajax_search_patient_by_info',
			'patient_first_name' : first_name,
			'last_name' : last_name,
			'dob' : dob
		}

		jQuery.post(ajaxurl, data, function(response) {
			if( response == "found" ){
				populate_search_patient_form( "info" );
			}else{
				if( jQuery("#first-name").val() == "" || jQuery("#last-name").val() == "" || jQuery("#datepicker").val() == "" ){
					if( jQuery("#first-name").val() == "" ){ jQuery("#first-name").addClass("error-icon"); }
					if( jQuery("#last-name").val() == "" ){ jQuery("#last-name").addClass("error-icon"); }
					if( jQuery("#datepicker").val() == "" ){ jQuery("#datepicker").addClass("error-icon"); }
				}else{
					populate_patient_form();
					submit_add_patient_form();
				}
			}
		});
	}

	jQuery(".patient-search-form .search").click(function(e){
		e.preventDefault();

		jQuery("#first-name, #last-name, #datepicker").removeClass("error-icon");

		var patient_id = jQuery("#patient-id").val();
		var first_name = jQuery("#patient_first_name").val();
		var last_name = jQuery("#last-name").val();
		var dob = jQuery("#datepicker").val();

		if( !patient_id && !first_name && !last_name && !dob ){
			jQuery(".no-search-input").fadeIn("fast", function(){
				jQuery(this).fadeOut(3000);
			});
		}else if( patient_id ){
			search_patient_by_id( patient_id );
		}else if( first_name || last_name || dob ){
			search_patient_by_info( first_name, last_name, dob );
		}

	});

	jQuery(".close-patient-form").click(function(e){
		e.preventDefault();
		close_add_patient_form();
	});

	function open_add_patient_form(){
		jQuery("#add-patient-form").css("display", "block");
	}

	function submit_add_patient_form(){
		jQuery("#quick-add-patient-form").submit();
	}

	function close_add_patient_form(){
		reset_patient_form();
		jQuery("#add-patient-form").css("display", "none");
	}

	function populate_patient_form(){
		jQuery("#add-patient-form [name='first_name']").val(jQuery("#first-name").val());
		jQuery("#add-patient-form [name='last_name']").val(jQuery("#last-name").val());
		jQuery("#add-patient-form [name='dob']").val(jQuery("#datepicker").val());
	}

	function reset_patient_form(){
		jQuery("#add-patient-form [name='first_name']").val("");
		jQuery("#add-patient-form [name='last_name']").val("");
		jQuery("#add-patient-form [name='dob']").val("");
	}

	function populate_search_patient_form( search_by ){
		jQuery("#search-patient-form [name='search_by']").val(search_by);
		jQuery("#search-patient-form [name='first_name']").val(jQuery("#first-name").val());
		jQuery("#search-patient-form [name='last_name']").val(jQuery("#last-name").val());
		jQuery("#search-patient-form [name='dob']").val(jQuery("#datepicker").val());
		jQuery("#search-patient-form [name='patient_id']").val(jQuery("#patient-id").val());
		jQuery("#search-patient-form").submit();
	}


	/* ************************************
	* STEP 3 - SELECT PATIENT
	************************************ */

	jQuery(".select-patient-item").click(function(e){
		e.preventDefault();

		jQuery("#selected_patient_hidden").val(jQuery(this).attr("data-id"));
		jQuery("#select-patient-form").submit();
	});

	/* ************************************
	* STEP 4 - CHOOSE PHYSICIAN
	************************************ */

	jQuery(".choose-physician-item").click(function(e){
		e.preventDefault();

		jQuery("#physician_id_hidden").val(jQuery(this).attr("data-id"));
		jQuery("#choose-physician-form").submit();
	});


	/* ************************************
	* STEP 5 - QUESTIONS
	************************************ */

	jQuery(".answer-button").click(function(e){
		e.preventDefault();

		var a = jQuery(this).attr("href");

		// remove previos answer
		jQuery(this).parent().find(".answer-button").removeClass("active").removeClass("active2").removeClass("active3");

		// add active class

		if( a == 4 || a == 5 ){
			jQuery(this).addClass("active2");
		}else if( a == 3 ){
			jQuery(this).addClass("active3");
		}else if( a == 2 || a == 1 ){
			jQuery(this).addClass("active");
		}

		// get question number
		var b = jQuery(this).parent().attr("data-id");

		// save it in hidden input
		jQuery("#answer_"+b+"_hidden").val( a );

		if( all_question_answered() ){
			jQuery("#answers-form").submit();
		}

		if( jQuery(".questions-part-2").css("display") == 'none' && first_three_answered() ){
			jQuery(".questions-part-1").fadeOut("fast", function(){
				jQuery(".questions-part-2").fadeIn("fast");
			});
		}

	});

	function all_question_answered(){
		var o = true;
		for ( var i = 1; i <= 6; i++ ) {
			if( !( jQuery("#answer_"+i+"_hidden").val() > 0 ) ){
				o = false;
			}
		}
		return o;
	}

	function first_three_answered(){
		var o = true;
		for ( var i = 1; i <= 3; i++ ) {
			if( !( jQuery("#answer_"+i+"_hidden").val() > 0 ) ){
				o = false;
			}
		}
		return o;
	}


	/* ************************************
	* STEP 6 - FEEDBACK
	************************************ */

	jQuery("#survey-comment-submit").click(function(e){
		e.preventDefault();

		jQuery("#survey-comment-form").submit();
	});

	/* ************************************
	* STEP 7 - CONTACT
	************************************ */

	jQuery("#time-to-call a").click(function(e){
		e.preventDefault();
		if( jQuery("#contact-me a.activee").attr("data-id") == 'yes' ){
			jQuery("#time-to-call a").removeClass("activee");
			jQuery(this).addClass("activee");

			jQuery("#call_time_hidden").val( jQuery(this).attr("data-id") );
		}
	});

	jQuery("#contact-me a").click(function(e){
		e.preventDefault();
		jQuery("#contact-me a").removeClass("activee");
		jQuery(this).addClass("activee");

		if( jQuery(this).attr("data-id") == 'no' ){
			jQuery("#time-to-call a").removeClass("activee");
			jQuery("#time-to-call a").css("opacity", '0.2');
			jQuery("input[name='phone']").val("");
			jQuery("input[name='phone']").attr("disabled", 'disabled');
		}else{
			jQuery("#time-to-call a").css("opacity", '1');
			jQuery("input[name='phone']").removeAttr("disabled");
		}

		jQuery("#do_call_hidden").val( jQuery(this).attr("data-id") );
	});

	jQuery("#submit-contact-survey").click(function(e){
		e.preventDefault();

		jQuery("#choose-call-time-alert").css("display", "none");
		jQuery(".bigPhone").css("outline", "none");
		jQuery(".agree_to_toa_p").css("outline", "none");

		if( jQuery("#do_call_hidden").val() == "yes" ){

			// check call time
			if( jQuery("#call_time_hidden").val() != "" ){

				// check phone number
				if( jQuery(".bigPhone").val() != "" ){

					// save phone number in form
					jQuery("#phone_hidden").val(jQuery(".bigPhone").val());

					// check TOA
					if( jQuery("#agree_to_toa_check").is(":checked") ){

						// save TOA into form
						jQuery("#agreed_to_toa_hidden").val("yes");

						// everything ok, submit
						jQuery("#survey-contact-form").submit();

					}else{
						jQuery(".agree_to_toa_p").css("outline", "1px solid red");
					}

				}else{
					jQuery(".bigPhone").css("outline", "1px solid red");
				}

				

			}else{
				jQuery("#choose-call-time-alert").css("display", "block");
			}
		}else{
			// user don't want contact
			jQuery("#survey-contact-form").submit();
		}
	});


	/* ******************************************
	* LOST PASSWORD
	****************************************** */

	function is_valid_email( email ){
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return filter.test(email);
	}

	function send_reset_password_request( email ){
		data = {
			'ajax_action' : 'ajax_lost_password_request',
			'email' : email
		}
		jQuery.post(ajaxurl, data, function(response) {});
	}

	jQuery("#send-lost-password-request").click(function(e){
		e.preventDefault();
		jQuery("#lost-password-email").removeClass("error-icon");
		jQuery("#lost-password-email-not-exists").css("display", "none");
		jQuery("#modal2").css("opacity", '1');


		if( is_valid_email( jQuery("#lost-password-email").val() ) ){
			jQuery("#modal2").css("opacity", '0.4');
			data = {
				'ajax_action' : 'ajax_email_exists',
				'email' : jQuery("#lost-password-email").val()
			}
			jQuery.post(ajaxurl, data, function(response) {
				if( response == "yes" ){
					send_reset_password_request( jQuery("#lost-password-email").val() );
					jQuery("#lost-password-email").css("display", "none");
					jQuery("#lost-password-email-ok").css("display", "block");
					jQuery("#send-lost-password-request").css("display", "none");
					jQuery("#send-lost-password-close").text("Ok");
				}else{
					jQuery("#lost-password-email-not-exists").css("display", "block");
				}
				jQuery("#modal2").css("opacity", '1');
			});
		}else{
			jQuery("#lost-password-email").addClass("error-icon");
		}
	});

});