jQuery(function(){


	/* ******************************************
	* ADD TO ARCHIVE GLOBAL
	****************************************** */

	function hide_tr( what, id ){
		jQuery("#"+what+"-tr-"+id).fadeOut("slow");
	}

	function dim_tr( what, id ){
		jQuery("#"+what+"-tr-"+id).css("opacity", "0.4");
	}

	function display_tr_with_error( what, id ){
		jQuery("#"+what+"-tr-"+id).css("opacity", "1");
	}

	function ajax_change_status( what, id, status ){
		data = {
			'ajax_action' : 'ajax_change_status',
			'what' : what,
			'id' : id,
			'status' : status
		}

		dim_tr( what, id );

		jQuery.post(ajaxurl, data, function(response) {
			if( response == 1 ){
				hide_tr( what, id );
			}else{
				display_tr_with_error( what, id );
			}
		});
	}

	// Add to archive 

	jQuery("#appPage").on("click", ".add-to-archive",function(e){
		e.preventDefault();
		jQuery("a.ajax-add-to-archive").attr("data-id", jQuery(this).attr("data-id"));
	});

	jQuery("a.ajax-add-to-archive").click(function(e){
		e.preventDefault();
		var id = jQuery(this).attr("data-id");
		var what = jQuery(this).attr("data-name");
		if( id > 0 ){
			jQuery("#myModal2").modal("toggle");
			ajax_change_status( what, id, 0 );
		}
	});

	// Reactivate

	jQuery("#appPage").on("click", ".reactivate-this", function(e){
		e.preventDefault();
		jQuery("a.ajax-reactivate-this").attr("data-id", jQuery(this).attr("data-id"));
	});

	jQuery("a.ajax-reactivate-this").click(function(e){
		e.preventDefault();
		var id = jQuery(this).attr("data-id");
		var what = jQuery(this).attr("data-name");
		if( id > 0 ){
			jQuery("#myModal2").modal("toggle");
			ajax_change_status( what, id, 1 );
		}
	});

	// Remove forever

	function ajax_delete_forever( what, id ){
		data = {
			'ajax_action' : 'ajax_delete_forever',
			'what' : what,
			'id' : id
		}

		dim_tr( what, id );

		jQuery.post(ajaxurl, data, function(response) {
			if( response == 1 ){
				hide_tr( what, id );
			}else{
				// fix this
				// display_tr_with_error( what, id );
				hide_tr( what, id );
			}
		});
	}

	jQuery("#appPage").on("click", ".remove-forever", function(e){
		e.preventDefault();
		jQuery("a.ajax-remove-forever").attr("data-id", jQuery(this).attr("data-id"));
	});

	jQuery("a.ajax-remove-forever").click(function(e){
		e.preventDefault();
		var id = jQuery(this).attr("data-id");
		var what = jQuery(this).attr("data-name");
		if( id > 0 ){
			jQuery("#myModal3").modal("toggle");
			ajax_delete_forever( what, id );
		}
	});

	jQuery("input[name='remove-image']").change(function(){
		console.log("remove image");
		if( jQuery(this).is(":cheched") ){
			jQuery(".image-to-remove").css("opacity", "0.4");
		}else{
			jQuery(".image-to-remove").css("opacity", "1");
		}
	});

	jQuery(".add-to-archive-button").click(function(e){
		e.preventDefault();
		jQuery("a.ajax-button-add-to-archive").attr("data-id", jQuery(this).attr("data-id"));
	});

	jQuery("a.ajax-button-add-to-archive").click(function(e){
		e.preventDefault();
		var id = jQuery(this).attr("data-id");
		var what = jQuery(this).attr("data-name");
		if( id > 0 ){
			jQuery("#myModal2").modal("toggle");
			ajax_change_status_and_reload( what, id, 0 );
		}
	});

	jQuery(".reactivate-button").click(function(e){
		e.preventDefault();
		jQuery("a.ajax-button-reactivate").attr("data-id", jQuery(this).attr("data-id"));
	});

	jQuery("a.ajax-button-reactivate").click(function(e){
		e.preventDefault();
		var id = jQuery(this).attr("data-id");
		var what = jQuery(this).attr("data-name");
		if( id > 0 ){
			jQuery("#myModal3").modal("toggle");
			ajax_change_status_and_reload( what, id, 1 );
		}
	});


	/* ******************************************
	* SEARCH
	****************************************** */

	function get_ajax_table( data, selector ){
		jQuery(selector).css("opacity", '0.4');

		jQuery.post(ajaxurl, data, function(response) {
			if( response ){
				jQuery(selector).html(response);
				jQuery(selector).css("opacity", '1');
			}else{
				jQuery(selector).css("opacity", '1');
			}
		});
	}

	function get_user_table( page, per_page, status, timeframe, location, role, name ){
		data = {
			'ajax_action' : 'ajax_get_user_table',
			'page' : page,
			'per_page' : per_page,
			'status' : status,
			'timeframe' : timeframe,
			'location' : location,
			'role' : role,
			'name' : name
		}

		var selector = ( status == 1 ) ? '.ajax-user-table' : '.ajax-archived-user-table';
		get_ajax_table( data, selector );
	}

	function get_location_table( page, per_page, status, name, physician, user, timeframe ){
		data = {
			'ajax_action' : 'ajax_get_location_table',
			'page' : page,
			'per_page' : per_page,
			'status' : status,
			'name' : name,
			'physician' : physician,
			'user' : user,
			'timeframe' : timeframe
		}

		var selector = ( status == 1 ) ? '.ajax-location-table' : '.ajax-archived-location-table';
		get_ajax_table( data, selector );
	}

	function get_physician_table( page, per_page, status, name, location, department, user, timeframe ){
		data = {
			'ajax_action' : 'ajax_get_physician_table',
			'page' : page,
			'per_page' : per_page,
			'status' : status,
			'name' : name,
			'location' : location,
            'department' : department,
			'user' : user,
			'timeframe' : timeframe
		}

		var selector = ( status == 1 ) ? '.ajax-physician-table' : '.ajax-archived-physician-table';
		get_ajax_table( data, selector );
	}

	function get_patient_table( page, per_page, status, name, location, physician, timeframe ){
		data = {
			'ajax_action' : 'ajax_get_patient_table',
			'page' : page,
			'per_page' : per_page,
			'status' : status,
			'name' : name,
			'location' : location,
			'physician' : physician,
			'timeframe' : timeframe
		}

		var selector = ( status == 1 ) ? '.ajax-patient-table' : '.ajax-archived-patient-table';
		get_ajax_table( data, selector );
	}


    function get_department_table( page, per_page, status, name, location, timeframe ){
        data = {
            'ajax_action' : 'ajax_get_department_table',
            'page' : page,
            'per_page' : per_page,
            'status' : status,
            'name' : name,
            'location' : location
        }

        var selector = ( status == 1 ) ? '.ajax-department-table' : '.ajax-archived-department-table';
        get_ajax_table( data, selector );
    }

	function get_message_table( page, per_page, status, read, type, timeframe ){
		data = {
			'ajax_action' : 'ajax_get_message_table',
			'page' : page,
			'per_page' : per_page,
			'status' : status,
			'read' : read,
			'type' : type,
			'timeframe' : timeframe
		}

		var selector = ( status == 1 ) ? '.ajax-message-table' : '.ajax-archived-message-table';
		get_ajax_table( data, selector );
	}

	function search_users( page, per_page ){
		var page = ( page > 0 ) ? page : 1;
		var per_page = ( per_page > 0 ) ? per_page : 10;
		var status = 1;
		var timeframe = jQuery("#search-user-by-timeframe").val();
		var location = jQuery("#search-user-by-location").val();
		var role = jQuery("#search-user-by-role").val();
		var name = jQuery("#search-user-by-name").val();
		
		get_user_table( page, per_page, status, timeframe, location, role, name );
	}

	function search_archived_users( page, per_page ){
		var page = ( page > 0 ) ? page : 1;
		var per_page = ( per_page > 0 ) ? per_page : 10;
		var status = 0;
		var timeframe = jQuery("#search-archived-user-by-timeframe").val();
		var location = jQuery("#search-archived-user-by-location").val();
		var role = jQuery("#search-archived-user-by-role").val();
		var name = jQuery("#search-archived-user-by-name").val();
		
		get_user_table( page, per_page, status, timeframe, location, role, name );
	}

	function search_locations( page, per_page ){
		var page = ( page > 0 ) ? page : 1;
		var per_page = ( per_page > 0 ) ? per_page : 10;
		var status = 1;
		var timeframe = jQuery("#search-location-by-timeframe").val();
		var physician = jQuery("#search-location-by-physician").val();
		var user = jQuery("#search-location-by-user").val();
		var name = jQuery("#search-location-by-name").val();
		
		get_location_table( page, per_page, status, name, physician, user, timeframe );
	}

	function search_archived_locations( page, per_page ){
		var page = ( page > 0 ) ? page : 1;
		var per_page = ( per_page > 0 ) ? per_page : 10;
		var status = 0;
		var timeframe = jQuery("#search-archived-location-by-timeframe").val();
		var physician = jQuery("#search-archived-location-by-physician").val();
		var user = jQuery("#search-archived-location-by-user").val();
		var name = jQuery("#search-archived-location-by-name").val();
		
		get_location_table( page, per_page, status, name, physician, user, timeframe );
	}

	function search_physicians( page, per_page ){
		var page = ( page > 0 ) ? page : 1;
		var per_page = ( per_page > 0 ) ? per_page : 10;
		var status = 1;
		var timeframe = jQuery("#search-physician-by-timeframe").val();
		var location = jQuery("#search-physician-by-location").val();
        var department = jQuery("#search-physician-by-department").val();
		var user = jQuery("#search-physician-by-user").val();
		var name = jQuery("#search-physician-by-name").val();
		
		get_physician_table( page, per_page, status, name, location, department, user, timeframe );
	}

	function search_archived_physicians( page, per_page ){
		var page = ( page > 0 ) ? page : 1;
		var per_page = ( per_page > 0 ) ? per_page : 10;
		var status = 0;
		var timeframe = jQuery("#search-archived-physician-by-timeframe").val();
		var location = jQuery("#search-archived-physician-by-location").val();
        var department = jQuery("#search-archived-physician-by-department").val();
		var user = jQuery("#search-archived-physician-by-user").val();
		var name = jQuery("#search-archived-physician-by-name").val();
		
		get_physician_table( page, per_page, status, name, location, department, user, timeframe );
	}

    function search_departments( page, per_page ){
        var page = ( page > 0 ) ? page : 1;
        var per_page = ( per_page > 0 ) ? per_page : 10;
        var status = 1;
        var timeframe = jQuery("#search-department-by-timeframe").val();
        var location = jQuery("#search-department-by-location").val();
        var name = jQuery("#search-department-by-name").val();

        get_department_table( page, per_page, status, name, location, "", timeframe );
    }

    function search_archived_departments( page, per_page ){
        var page = ( page > 0 ) ? page : 1;
        var per_page = ( per_page > 0 ) ? per_page : 10;
        var status = 0;
        var timeframe = jQuery("#search-department-by-timeframe").val();
        var name = jQuery("#search-archived-department-by-name").val();

        get_department_table( page, per_page, status, name, "", "", timeframe );
    }

	function search_patients( page, per_page ){
		var page = ( page > 0 ) ? page : 1;
		var per_page = ( per_page > 0 ) ? per_page : 10;
		var status = 1;
		var timeframe = jQuery("#search-patient-by-timeframe").val();
		var location = jQuery("#search-patient-by-location").val();
		var physician = jQuery("#search-patient-by-physician").val();
		var name = jQuery("#search-patient-by-name").val();
		
		get_patient_table( page, per_page, status, name, location, physician, timeframe );
	}

    function populate_physicians(){
        var status = 1;
        var location = jQuery("#location").val();
        get_physicians_by_location( location );
    }


    function get_physicians_by_location( location ){
        data = {
            'ajax_action' : 'ajax_get_physicians_by_location',
            'location' : location,
        }
        jQuery.post(ajaxurl, data, function(response) {
            if( response ){
                populate_physicians_select_box( response );
            }
        });

    }

    function populate_physicians_select_box (data){
        var options = $("#physicians_by_location_div");
        options.empty();
        options.append(data);
    }

    function populate_departments(){
        var status = 1;
        var location = jQuery("#location").val();
        get_departments_by_location( location );
    }

    function get_departments_by_location( location ){
        data = {
            'ajax_action' : 'ajax_get_departments_by_location',
            'location' : location,
        }
        jQuery.post(ajaxurl, data, function(response) {
            if( response ){
                populate_departments_select_box( response );
            }
        });

    }

    function populate_departments_select_box (data){
        var options = $("#departments_by_location_div");
        options.empty();
        options.append(data);
    }

	function search_archived_patients( page, per_page ){
		var page = ( page > 0 ) ? page : 1;
		var per_page = ( per_page > 0 ) ? per_page : 10;
		var status = 1;
		var timeframe = jQuery("#search-archived-patient-by-timeframe").val();
		var location = jQuery("#search-archived-patient-by-location").val();
		var physician = jQuery("#search-archived-patient-by-physician").val();
		var name = jQuery("#search-archived-patient-by-name").val();
		
		get_patient_table( page, per_page, status, name, location, physician, timeframe );
	}

	function search_language( page, per_page ){
		var page = ( page > 0 ) ? page : 1;
		var per_page = ( per_page > 0 ) ? per_page : 10;
		var timeframe = jQuery("#search-language-by-timeframe").val();
		var location = jQuery("#search-language-by-location").val();
		var language = jQuery(".ajax-language-table").attr("data-id") == 'sp' ? 'sp' : 'en';

		data = {
			'ajax_action' : 'ajax_get_report_table',
			'page' : page,
			'per_page' : per_page,
			'language' : language,
			'location' : location,
			'timeframe' : timeframe
		}

		get_ajax_table( data, '.ajax-language-table' );
	}

	function search_contact( page, per_page ){
		var page = ( page > 0 ) ? page : 1;
		var per_page = ( per_page > 0 ) ? per_page : 10;
		var timeframe = jQuery("#search-contact-by-timeframe").val();
		var location = jQuery("#search-contact-by-location").val();
		var contact = jQuery(".ajax-contact-table").attr("data-id") == 'no' ? 'no' : 'yes';

		data = {
			'ajax_action' : 'ajax_get_report_table',
			'page' : page,
			'per_page' : per_page,
			'contact' : contact,
			'location' : location,
			'timeframe' : timeframe
		}

		get_ajax_table( data, '.ajax-contact-table' );
	}

	function search_loc( page, per_page ){
		var page = ( page > 0 ) ? page : 1;
		var per_page = ( per_page > 0 ) ? per_page : 10;
		var timeframe = jQuery("#search-loc-by-timeframe").val();
		var physician = jQuery("#search-loc-by-physician").val();
		var user = jQuery("#search-loc-by-user").val();
		var location =  jQuery(".ajax-loc-table").attr("data-id");

		data = {
			'ajax_action' : 'ajax_get_report_table',
			'page' : page,
			'per_page' : per_page,
			'user' : user,
			'location' : location,
			'physician' : physician,
			'timeframe' : timeframe
		}

		get_ajax_table( data, '.ajax-loc-table' );
	}

	function search_language_stats(){
		
		var timeframe = jQuery("#search-language-stats-by-timeframe").val();
		var location = jQuery("#search-language-stats-by-location").val();

		data = {
			'ajax_action' : 'ajax_get_language_stats_table',
			'location' : location,
			'timeframe' : timeframe
		}

		get_ajax_table( data, '.ajax-language-stats-table' );
	}

	function search_contact_stats(){
		
		var timeframe = jQuery("#search-contact-stats-by-timeframe").val();
		var location = jQuery("#search-contact-stats-by-location").val();

		data = {
			'ajax_action' : 'ajax_get_contact_stats_table',
			'location' : location,
			'timeframe' : timeframe
		}

		get_ajax_table( data, '.ajax-contact-stats-table' );
	}

	function search_location_stats( page, per_page ){
		var page = ( page > 0 ) ? page : 1;
		var per_page = ( per_page > 0 ) ? per_page : 10;
		var timeframe = jQuery("#search-location-stats-by-timeframe").val();
		var physician = jQuery("#search-location-stats-by-physician").val();
		var user = jQuery("#search-location-stats-by-user").val();

		data = {
			'ajax_action' : 'ajax_get_location_stats_table',
			'page' : page,
			'per_page' : per_page,
			'user' : user,
			'physician' : physician,
			'timeframe' : timeframe
		}

		get_ajax_table( data, '.ajax-location-stats-table' );
	}

	function get_statistic(){
		var timeframe = jQuery("#search-statistic-by-timeframe").val();
		var physician = jQuery("#search-statistic-by-physician").val();
		var location = jQuery("#search-statisticc-by-location").val();

		data = {
			'ajax_action' : 'ajax_get_statistic_table',
			'user' : location,
			'physician' : physician,
			'timeframe' : timeframe
		}

		get_ajax_table( data, '.ajax-statistic-table' );
	}

	function search_question( page, per_page ){
		var page = ( page > 0 ) ? page : 1;
		var per_page = ( per_page > 0 ) ? per_page : 10;
		var timeframe = jQuery("#search-question-by-timeframe").val();
		var location = jQuery("#search-question-by-location").val();
		var user = jQuery("#search-question-by-user").val();
		var question = jQuery(".ajax-question-table").attr("data-id");
		var answer = jQuery(".ajax-question-table").attr("data-name");

		data = {
			'ajax_action' : 'ajax_get_question_table',
			'page' : page,
			'per_page' : per_page,
			'question' : question,
			'answer' : answer,
			'user' : user,
			'location' : location,
			'timeframe' : timeframe
		}

		get_ajax_table( data, '.ajax-question-table' );
	}

	/* USERS */

	jQuery("#search-message-by-timeframe, #search-message-by-read, #search-message-by-type").change(function(){
		get_message_table( 1, 10, 1, jQuery("#search-message-by-read").val(), jQuery("#search-message-by-type").val(), jQuery("#search-message-by-timeframe").val() );
	});

	jQuery("#search-archived-message-by-timeframe, #search-archived-message-by-read, #search-archived-message-by-type").change(function(){
		get_message_table( 1, 10, 0, jQuery("#search-archived-message-by-read").val(), jQuery("#search-archived-message-by-type").val(), jQuery("#search-archived-message-by-timeframe").val() );
	});

	jQuery("#search-archived-message-by-timeframe, #search-archived-message-by-read, #search-archived-message-by-type").change(function(){
		get_message_table( 1, 10, 1, jQuery("#search-archived-message-by-read").val(), jQuery("#search-archived-message-by-type").val(), jQuery("#search-archived-message-by-timeframe").val() );
	});

	jQuery("#search-user-by-timeframe, #search-user-by-location, #search-user-by-role").change(function(){
		search_users();
	});

	jQuery("#search-user-by-name").keyup(function(){
		search_users();
	});

	jQuery("#search-archived-user-by-timeframe, #search-archived-user-by-location, #search-archived-user-by-role").change(function(){
		search_archived_users();
	});

	jQuery("#search-archived-user-by-name").keyup(function(){
		search_archived_users();
	});

	/* LOCATIONS */

	jQuery("#search-location-by-timeframe, #search-location-by-physician, #search-location-by-user").change(function(){
		search_locations();
	});


	jQuery("#search-location-by-name").keyup(function(){
		search_locations();
	});

	jQuery("#search-archived-location-by-timeframe, #search-archived-location-by-physician, #search-archived-location-by-user").change(function(){
		search_archived_locations();
	});

	jQuery("#search-archived-location-by-name").keyup(function(){
		search_archived_locations();
	});

	/* DEPARTMENT */

    jQuery("#search-department-by-timeframe").change(function(){
        search_departments();
    });

    jQuery("#search-department-by-name").keyup(function(){
        search_departments();
    });

    jQuery("#search-archived-department-by-timeframe").change(function(){
        search_archived_departments();
    });

    jQuery("#search-archived-department-by-name").keyup(function(){
        search_archived_departments();
    });


	/* PHYSICIANS */

    jQuery("#location_departments").change(function(){
        populate_departments();
    });

	jQuery("#search-physician-by-timeframe, #search-physician-by-location, #search-physician-by-department, #search-physician-by-user").change(function(){
		search_physicians();
	});

	jQuery("#search-physician-by-name").keyup(function(){
		search_physicians();
	});

	jQuery("#search-archived-physician-by-timeframe, #search-archived-physician-by-location, #search-archived-physician-by-user").change(function(){
		search_archived_physicians();
	});

	jQuery("#search-archived-physician-by-name").keyup(function(){
		search_archived_physicians();
	});


	/* PATIENTS */

    jQuery("#location").change(function(){
        populate_physicians();
    });

    jQuery("#search-patient-by-timeframe, #search-patient-by-location, #search-patient-by-physician").change(function(){
        search_patients();
    });

	jQuery("#search-patient-by-name").keyup(function(){
		search_patients();
	});

	jQuery("#search-archived-patient-by-timeframe, #search-archived-patient-by-location, #search-archived-patient-by-physician").change(function(){
		search_archived_patients();
	});

	jQuery("#search-archived-patient-by-name").keyup(function(){
		search_archived_patients();
	});

	jQuery("#search-language-by-timeframe, #search-language-by-location").change(function(){
		search_language(1, 10);
	});

	jQuery("#search-contact-by-timeframe, #search-contact-by-location").change(function(){
		search_contact(1, 10);
	});

	jQuery("#search-loc-by-timeframe, #search-loc-by-physician, #search-loc-by-user").change(function(){
		search_loc(1, 10);
	});


	jQuery("#search-language-stats-by-timeframe, #search-language-stats-by-location").change(function(){
		search_language_stats();
	});

	jQuery("#search-contact-stats-by-timeframe, #search-contact-stats-by-location").change(function(){
		search_contact_stats();
	});

	jQuery("#search-location-stats-by-timeframe, #search-location-stats-by-physician, #search-location-stats-by-user").change(function(){
		search_location_stats();
	});

	jQuery("#search-statistic-by-timeframe, #search-statistic-by-physician, #search-statistic-by-location").change(function(){
		get_statistic();
	});

	jQuery("#search-question-by-timeframe, #search-question-by-user, #search-question-by-location").change(function(){
		search_question();
	});



	jQuery("#search-dashboard-by-timeframe, #search-dashboard-by-location").change(function(){
		var timeframe = jQuery("#search-dashboard-by-timeframe").val();
		var location = jQuery("#search-dashboard-by-location").val();
		var url = 'dashboard.php';
		if( timeframe && location > 0 ){
			url +='?timeframe='+timeframe+'&location='+location;
		}else if( timeframe ){
			url +='?timeframe='+timeframe;
		}else if( location > 0 ){
			url +='?location='+location;
		}

		window.location = url;
	});

	
	/* REPORTS */

	function get_search_value_if_exists( selector ){
		var output = "";
		if( jQuery(selector).length > 0 ){
			if( jQuery(selector).val() != "" && jQuery(selector).val() != "all" ){
				output = jQuery(selector).val();
			}
		}
		return output;
	}

	jQuery("#search-reports-by-timeframe, #search-reports-by-physician, #search-reports-by-location, #search-reports-by-user, #search-reports-by-language, #search-reports-by-contact, #search-reports-by-review, #search-reports-by-patient-type").change(function(){
		
		jQuery("#timeframe-hidden").val(get_search_value_if_exists( "#search-reports-by-timeframe" ));
		jQuery("#physician-hidden").val(get_search_value_if_exists( "#search-reports-by-physician" ));
		jQuery("#location-hidden").val(get_search_value_if_exists( "#search-reports-by-location" ));
		jQuery("#user-hidden").val(get_search_value_if_exists( "#search-reports-by-user" ));
		jQuery("#language-hidden").val(get_search_value_if_exists( "#search-reports-by-language" ));
		jQuery("#contact-hidden").val(get_search_value_if_exists( "#search-reports-by-contact" ));
		jQuery("#review-hidden").val(get_search_value_if_exists( "#search-reports-by-review" ));
		jQuery("#patient-type-hidden").val(get_search_value_if_exists( "#search-reports-by-patient-type" ));

	});

	jQuery("#reset-report-filters").click(function(e){
		e.preventDefault();

		window.location.reload();

	});


	function get_report_table( page, per_page ){
		var page = ( page > 0 ) ? page : 1;
		var per_page = ( per_page > 0 ) ? per_page : 10;

		data = {
			'ajax_action' : 'ajax_get_report_table',
			'page' : page,
			'per_page' : per_page,
			'timeframe' : jQuery("#timeframe-hidden").val(),
			'physician' : jQuery("#physician-hidden").val(),
			'location' : jQuery("#location-hidden").val(),
			'user' : jQuery("#user-hidden").val(),
			'language' : jQuery("#language-hidden").val(),
			'contact' : jQuery("#contact-hidden").val(),
			'review' : jQuery("#review-hidden").val(),
			'patient-type' : jQuery("#patient-type-hidden").val()
		}

		get_ajax_table( data, '.ajax-report-table' );
	}

	jQuery(".generate-btn").click(function(e){
		e.preventDefault();
		jQuery("#app-table").css("display", "block");
		get_report_table( 1, 10 );
	});


	/* ******************************************
	* NAVIGATION
	****************************************** */


	jQuery(".ajax-user-table, .ajax-locatin-table, .ajax-physician-table, .ajax-patient-table, .ajax-department-table, .ajax-message-table").on("click", ".ajax-nav a", function(e){
		e.preventDefault();
		var page = jQuery(this).attr("href");
		var what = jQuery(this).closest("ul.ajax-nav").attr("data-name");
		var per_page = jQuery(this).closest("ul.ajax-nav").attr("data-id");
		
		if( what == 'user' ){
			search_users( page, per_page );
		}else if( what == 'location' ){
			search_locations( page, per_page );
		}else if( what == 'physician' ){
			search_physicians( page, per_page );
		}else if( what == 'department' ) {
            search_departments(page, per_page);
        }else if( what == 'patient' ){
			search_patients( page, per_page );
		}else if( what == 'message' ){
			get_message_table( 1, 10, 1, jQuery("#search-message-by-read").val(), jQuery("#search-message-by-type").val(), jQuery("#search-message-by-timeframe").val() );
		}
	});

	jQuery(".ajax-archived-user-table, .ajax-archived-locatin-table, .ajax-archived-physician-table, .ajax-archived-patient-table, .ajax-archived-message-table").on("click", ".ajax-nav a", function(e){
		e.preventDefault();
		var page = jQuery(this).attr("href");
		var what = jQuery(this).closest("ul.ajax-nav").attr("data-name");
		var per_page = jQuery(this).closest("ul.ajax-nav").attr("data-id");
		
		if( what == 'user' ){
			search_archived_users( page, per_page );
		}else if( what == 'location' ){
			search_archived_locations( page, per_page );
		}else if( what == 'physician' ){
			search_archived_physicians( page, per_page );
		}else if( what == 'patient' ){
			search_archived_patients( page, per_page );
		}else if( what == 'message' ){
			get_message_table( 1, 10, 1, jQuery("#search-archived-message-by-read").val(), jQuery("#search-archived-message-by-type").val(), jQuery("#search-archived-message-by-timeframe").val() );
		}
	});

	jQuery(".ajax-report-table").on("click", ".ajax-nav a", function(e){
		e.preventDefault();
		var page = jQuery(this).attr("href");
		var per_page = jQuery(this).closest("ul.ajax-nav").attr("data-id");
		
		get_report_table( page, per_page );
	});

	jQuery(".ajax-language-table").on("click", ".ajax-nav a", function(e){
		e.preventDefault();
		var page = jQuery(this).attr("href");
		var per_page = jQuery(this).closest("ul.ajax-nav").attr("data-id");
		
		search_language( page, per_page );
	});

	jQuery(".ajax-loc-table").on("click", ".ajax-nav a", function(e){
		e.preventDefault();
		var page = jQuery(this).attr("href");
		var per_page = jQuery(this).closest("ul.ajax-nav").attr("data-id");
		
		search_loc( page, per_page );
	});

	jQuery(".ajax-contact-table").on("click", ".ajax-nav a", function(e){
		e.preventDefault();
		var page = jQuery(this).attr("href");
		var per_page = jQuery(this).closest("ul.ajax-nav").attr("data-id");
		
		search_contact( page, per_page );
	});


	/* ******************************************
	* EXPORT
	****************************************** */

	jQuery("#download-as-pdf").click(function(e){
		e.preventDefault();
		jQuery("#survey-search-form").attr("action", 'export-pdf.php').submit();
	});

	jQuery("#download-as-xls").click(function(e){
		e.preventDefault();
		jQuery("#survey-search-form").attr("action", 'export-xls.php').submit();
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


	jQuery(".timeframe-select").change(function(){
		var v = ( jQuery(this).val() ) ? jQuery(this).val() : "";
		console.log(v);
		if( v == 'custom' || ( typeof v == "string" && v.slice(0, 6) == "custom" ) ){
			jQuery(".timeframe-custom").css("display", "block");
		}else{
			jQuery(".timeframe-custom").css("display", "none");
		}
	});

	jQuery("#datepicker3, #datepicker4").change(function(){
		if( jQuery("#datepicker3").val() != '' && jQuery("#datepicker4").val() != '' ){
			jQuery(".timeframe-select").find(".custom-time-option").remove();
			var a = "custom-"+jQuery("#datepicker3").val()+"-"+jQuery("#datepicker4").val();
			jQuery(".timeframe-select").append('<option class="custom-time-option" value="'+a+'">'+a+'</option>');
			jQuery(".timeframe-select").val(a);
			jQuery(".timeframe-select").trigger("change");
		}
	});

});