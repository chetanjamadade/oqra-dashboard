<?php

session_start();

$globalapp = array();

//Database informations
$globalapp["url"] = 'http://fluohead.com/oqra-dashboard';
$globalapp['db_server'] = 'localhost';
$globalapp['db_user'] = 'fluohead_admin';
$globalapp['db_password'] = 'hijeroglif1989';
$globalapp['db_name'] = 'fluohead_oqra';
$globalapp['table_prefix'] = '';

$globalapp["site_title"] = 'Oqra App';
$globalapp["contact_email"] = 'tekosds@gmail.com';
$globalapp["facebook"] = 'http://facebook.com';
$globalapp["twitter"] = 'http://twitter.com';
$globalapp["address"] = 'Address';

$globalapp['folder_classes'] ='classes';
$globalapp['folder_functions'] ='functions';
$globalapp['upload_folder'] ='upload';

$globalapp['default_user_image'] ='img/default-user.png';

$globalapp['roles'] = array(
    '1' => 'Superuser',
    '2' => 'User/POD'
);


// Set timezone for date and time adjustments
// date_default_timezone_set('Europe/Belgrade');

// Load classes and make objects if needed

require_once( $globalapp['folder_functions'] . "/global.php" );

// database
require_once( $globalapp['folder_classes'] . "/database.class.php" );
$db = new Database( $globalapp['db_server'], $globalapp['db_user'], $globalapp['db_password'], $globalapp['db_name'], $globalapp['table_prefix'] );

require_once( $globalapp['folder_classes'] . "/basic-element.class.php" );

// Uploading
require_once( $globalapp['folder_classes'] . "/uploading.class.php" );
$uploading = new Uploading;

// Messages
require_once( $globalapp['folder_classes'] . "/message.class.php" );
$message = new Message;

// Emails
require_once( $globalapp['folder_classes'] . "/email.class.php" );
$email = new Email($globalapp["contact_email"], $globalapp["site_title"]);

// User
require_once( $globalapp['folder_classes'] . "/user.class.php" );
$user = new User;

// Location
require_once( $globalapp['folder_classes'] . "/location.class.php" );
$location = new Location;

// Client
require_once( $globalapp['folder_classes'] . "/client.class.php" );
$client = new Client;


// Professional
require_once( $globalapp['folder_classes'] . "/professional.class.php" );
$professional = new Professional;


// Current user
require_once( $globalapp['folder_classes'] . "/current-user.class.php" );
if( $user->is_loggedin() ){
    $current_user = new Current_User;
}

// Current client
require_once( $globalapp['folder_classes'] . "/current-user.class.php" );
if( $user->is_loggedin() ){
    $current_client = new Current_User;
}

// load functions

require_once( $globalapp['folder_functions'] . "/elements.php" );
require_once( $globalapp['folder_functions'] . "/tables.php" );
require_once( $globalapp['folder_functions'] . "/questions.php" );
require_once( $globalapp['folder_functions'] . "/translations.php" );

// ACTIONS
require_once( $globalapp['folder_functions'] . "/actions.php" );
require_once( $globalapp['folder_functions'] . "/actions-app.php" );
?>