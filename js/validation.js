if (typeof jQuery === 'undefined') { throw new Error('Validation JavaScript requires jQuery') }

function validate_zip_filed( field ){
	var filter = /^(?!00000)([0-9]{5})+$/;
	return filter.test(field);
}

function validate_phone_filed( field ){
	var filter = /(?:\(?\+\d{2}\)?\s*)?\d+(?:[ -]*\d+)*$/;
	return filter.test(field);
}

function validate_email_field( email ){
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return filter.test(email);
}

function validate_letters_field( field ){
	var filter = /^[A-Za-z]+$/;
	return filter.test(field);
}

function validate_password( password ){
	return password.length > 5;
}

function prepare_for_validation( fields, form_id ){
	for( var i = 0; i < fields.length; i++ ){
		var field = jQuery("[name='"+fields[i]+"']");
		wrap_validation_field( field );

		field.keyup(function(){
			remove_validation_warning( jQuery(this) );
		});
	}

	jQuery("form#"+form_id).on("submit", function(e){
		

		var errors = false;

		for( var i = 0; i < fields.length; i++ ){
			var field = jQuery("[name='"+fields[i]+"']");

			remove_validation_warning( field );

			if( field.hasClass("required") && ( field.val() == "" || field.val() == "0" || field.val() == null ) ){

				errors = true;
				show_validation_warning( field, 'This field is required.' );

			}else if( field.hasClass("zip-input") && field.val() != "" && !validate_zip_filed( field.val() ) ){

				errors = true;
				show_validation_warning( field, 'Wrong ZIP code format.' );

			}else if( field.hasClass("phone-input") && field.val() != "" && !validate_phone_filed( field.val() ) ){

				errors = true;
				show_validation_warning( field, 'Wrong phone number format.' );

			}else if( field.hasClass("email-input") && field.val() != "" && !validate_email_field( field.val() ) ){

				errors = true;
				show_validation_warning( field, 'Wrong email format.' );

			}else if( field.hasClass("email-input") && field.hasClass("required") && !validate_email_field( field.val() ) ){

				errors = true;
				show_validation_warning( field, 'Wrong email format.' );

			}else if( fields[i] == "password" && field.hasClass("required") && !validate_password( field.val() ) ){

				errors = true;
				show_validation_warning( field, 'Password must have at least 6 characters.' );

			}else if( fields[i] == "password" && field.val() != "" && !validate_password( field.val() ) ){

				errors = true;
				show_validation_warning( field, 'Password must have at least 6 characters.' );

			}else if( fields[i] == "password_2" && !(jQuery("[name='password']").val() == field.val()) ){

				errors = true;
				show_validation_warning( field, 'Password doesn\'t match.' );

			}else if( fields[i] == "new-password" && field.val() != "" && !validate_password( field.val() ) ){

				errors = true;
				show_validation_warning( field, 'Password must have at least 6 characters.' );

			}else if( fields[i] == "repeat-new-password" && jQuery("[name='new-password']").val() != "" && !(jQuery("[name='new-password']").val() == field.val()) ){

				errors = true;
				show_validation_warning( field, 'Password doesn\'t match.' );

			}else if( fields[i] == "repeat-new-password" && jQuery("[name='new-password']").val() != "" && (jQuery("[name='new-password']").val() == field.val()) && !validate_password( jQuery("[name='password']").val() ) ){

				errors = true;
				show_validation_warning( jQuery("[name='password']"), 'This field is required for password change.' );

			}
		}

		if( errors ){
			e.preventDefault();
			return false;
		}

	});
}

function show_validation_warning( field, text ){
	field.addClass("error-icon");
	field.parent().prepend("<span class='validation-warning'><span></span>"+text+"</span>");
}


function remove_validation_warning( field ){
	field.removeClass("error-icon");
	field.parent().find(".validation-warning").remove();
}

function wrap_validation_field( field ){
	field.wrap( '<div class="field-wrap" style="position: relative;"></div>' );
}