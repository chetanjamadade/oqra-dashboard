<?php
$survey_app_text = array(
	array( 'en' => "Search By Patient Name", 'sp' => "Buscar por Nombre del Paciente" ),
	array( 'en' => "Patient First Name", 'sp' => "Nombre del paciente" ),
	array( 'en' => "Patient Last Name", 'sp' => "Apellido del paciente" ),
	array( 'en' => "Patient Date of Birth", 'sp' => "Fecha de nacimiento del paciente" ),
	array( 'en' => "OR", 'sp' => "OR" ),
	array( 'en' => "Search By Patient ID", 'sp' => "Buscar por ID de paciente" ),
	array( 'en' => "Patient ID", 'sp' => "Identificación del paciente" ),
	array( 'en' => "Input some search terms", 'sp' => "Entrada algunos términos de búsqueda" ),
	array( 'en' => "There are no users with this ID", 'sp' => "NO EXISTEN USUARIOS CON ESTE ID" ),
	array( 'en' => "Hi", 'sp' => "Holla" ),
	array( 'en' => "Choose Your Physician", 'sp' => "Elija su Médico" ),
	array( 'en' => "Would you like to share any other comments?", 'sp' => "Le gustaria compartir algun otro comentario acerca de su visita el dia de hoy?" ),
	array( 'en' => "Please provide details", 'sp' => "Proporcione detalles" ),
	array( 'en' => "We are very sorry to hear about your experience", 'sp' => "Lo sentimos mucho lo de tu experiencia" ),
	array( 'en' => "Please tell us about your experience", 'sp' => "Háblenos de su experiencia" ),
	array( 'en' => "Can we contact you?", 'sp' => "¿Podemos comunicarnos con usted ?" ),
	array( 'en' => "Can we contact you?", 'sp' => "¿Podemos comunicarnos con usted ?" ),
	array( 'en' => "Yes", 'sp' => "Si" ),
	array( 'en' => "No", 'sp' => "No" ),
	array( 'en' => "What is the best time to call?", 'sp' => "¿Cuál es la mejor hora para llamar ?" ),
	array( 'en' => "Morning", 'sp' => "Mañana" ),
	array( 'en' => "Afternoon", 'sp' => "Tarde" ),
	array( 'en' => "Evening", 'sp' => "Noche" ),
	array( 'en' => "<strong>Warning!</strong> Choose best time to call.", 'sp' => "<strong>¡Advertencia!</strong> Elija el mejor momento para llamar." ),
	array( 'en' => "By clicking Submit button you agree to these", 'sp' => "Al hacer clic en el botón Enviar está de acuerdo con estos" ),
	array( 'en' => "Terms and Conditions", 'sp' => "Términos y condiciones" ),
	array( 'en' => "Close", 'sp' => "Cerca" ),
	array( 'en' => "Enter your phone number", 'sp' => "Introduzca su número de teléfono" ),
	array( 'en' => "Thanks for your feedback.", 'sp' => "Gracias por sus comentarios." ),
	array( 'en' => "Thanks for your feedback.", 'sp' => "Gracias por sus comentarios." ),
	array( 'en' => "Thank you for being our valued patient. <br>We appreciate your feedback.", 'sp' => "Gracias por ser nuestro estimado paciente. <br>Agradecemos sus comentarios." ),
	array( 'en' => "Someone from our office will contact you shortly.", 'sp' => "Alguien de nuestra oficina se pondrá en contacto contigo en breve." ),
	);

$terms_of_conditions_en = "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>";
$terms_of_conditions_sp = "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>";

function print_text( $text, $lang = "en" ){
	global $survey_app_text;
	if( $lang == "sp" ){
		$found = false;
		foreach ( $survey_app_text as $translation ) {
			if( $translation["en"] == $text ){
				$found = true;
				echo $translation["sp"];
				break;
			}
		}
		if( !$found ){
			echo $text;
		}
	}else{
		echo $text;
	}
}

?>