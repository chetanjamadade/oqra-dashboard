<?php

function current_date(){
	return date('Y-m-d H:i:s');
}

function format_date( $date, $format = "d. F Y. G:H:s"){
    if( $date && $date != '0000-00-00' ){
        return date( $format, strtotime( $date ) );
    }else{
        return "";
    }
}

function format_date_for_db( $date ){
    if( $date && $date != '0000/00/00' ){
        return date( 'Y-m-d', strtotime( $date ) );
    }else{
        return "";
    }
}

function format_date_for_output( $date ){
    if( $date && $date != '0000-00-00' && $date != '0000-00-00 00:00:00' ){
        return date( 'm/d/Y', strtotime( $date ) );
    }else{
        return "";
    }
}

function mdy_to_sql( $date ){
    $d = explode('/', $date);
    return $d[2]."-".$d[0]."-".$d[1]." 00:00:00";
}


function user_friendly_date( $date ){
    $time = strtotime( $date );
    $datediff = time() - strtotime( $date );
    $days = ceil( $datediff / ( 60 * 60 * 24 ) );
    if( $time >= strtotime("today") ){
        return 'Today';
    }else if( $time >= strtotime("yesterday") ){
        return 'Yesterday';
    }else if( $days >= 2 && $days < 7 ){
        return $days . ' days ago';
    }else if( $days == 7 ){
        return 'A week ago';
    }else{
        return format_date( $date, "d. F Y." );
    }
}

function valid_timeframes(){
    return array(
        'Today' => 'today',
        'Yesterday' => 'yesterday',
        'This Week' => 'thisweek',
        'Last Week' => 'lastweek',
        'This Month' => 'thismonth',
        'Last 6 months' => 'last6months',
        'Last Year' => 'lastyear',
        'Custom' => 'custom'
        );
}

function is_valid_timeframe( $timeframe ){
    $output = false;
    if( strlen($timeframe) > 0 ){
        if( in_array($timeframe, valid_timeframes()) ){
            $output = true;
        }elseif ( strlen($timeframe) == 28 && substr($timeframe, 0, 6) == 'custom'  ) {
            $output = true;
        }
    }
    return $output;
}

function is_valid_role( $role_id ){
    global $globalapp;
    $output = false;
    if( $role_id > 0 ){
        if( array_key_exists($role_id, $globalapp['roles']) ){
            $output = true;
        }
    }
    return $output;
}

function get_timeframe_search_query( $timeframe ){
    $output = "";
    $from_date = "";
    $to_date = "";
    if( $timeframe == 'today' ){
        $from_date = date('Y-m-d H:i:s ', strtotime("midnight"));
    }elseif( $timeframe == 'yesterday' ){
        $from_date = date('Y-m-d H:i:s ', strtotime("yesterday midnight"));
        $to_date = date('Y-m-d H:i:s ', strtotime("midnight"));
    }elseif( $timeframe == 'thisweek' ){
        $from_date = date('Y-m-d H:i:s ', strtotime('-7 days'));
    }elseif( $timeframe == 'lastweek' ){
        $from_date = date('Y-m-d H:i:s ', strtotime('-14 days'));
        $to_date = date('Y-m-d H:i:s ', strtotime('-7 days'));
    }elseif( $timeframe == 'thismonth' ){
        $from_date = date('Y-m-d H:i:s ', strtotime('-1 months'));
    }elseif( $timeframe == 'last6months' ){
        $from_date = date('Y-m-d H:i:s ', strtotime('-6 months'));
    }elseif( $timeframe == 'lastyear' ){
        $from_date = date('Y-m-d H:i:s ', strtotime('1 years ago'));
    }elseif ( substr($timeframe, 0, 6) == 'custom' ){

        $d = explode('-', $timeframe);
        $d1 = $d[1];
        $d2 = $d[2];

        $from_date = mdy_to_sql($d1);
        $to_date = mdy_to_sql($d2);

    }

    if( $from_date && $from_date != "" ){
        $output .= " AND date > '".$from_date."'";
    }
    if( $to_date && $to_date != "" ){
        $output .= " AND date < '".$to_date."'";
    }

    return $output;

}

function get_call_time_label( $key = "" ){
    if( $key == 'morning' ){
        return 'Morning 9 AM - 12 PM';
    }elseif( $key == 'afternoon' ){
        return 'Afternoon 12 PM - 3 PM';
    }elseif( $key == 'evening' ){
        return 'Evening 3 PM - 6 PM';
    }else{
        return '';
    }
}

function home_url(){
    global $globalapp;
    return $globalapp["url"];
}

function action_url(){
    global $globalapp;
    return home_url() . '/index.php';
}

function error_login(){
    if($_GET["login_error"] = true){
       // return "You entered the wrong password or username";
    }
}

function login_url(){
    return home_url() . '/index.php';
}

function admin_login_url(){
    return home_url().'/';
}

function logout_url(){
    return home_url() . '/logout.php';
}

function dashboard_url(){
    return home_url() . '/front/dashboard.php';
}

function create_client(){
    return home_url() . '/front/add-new-client.php';
}

function root_url(){
    return home_url() . '/front/root-logged.php';
}

function redirect_to( $url ){
    header( "Location: " . $url );
    exit;
}

function go_to_page( $url ){
    header( "Location: " . home_url() . $url );
    exit;
}

function print_ajax_url(){
    echo '<script type="text/javascript">var ajaxurl = "'.home_url().'/admin/inc/ajax.php"; var file_upload_url = "'.home_url().'inc/file-upload.php";</script>';
}


function hidden_action_inputs( $action ){
    $code = md5( time() );
    $code_name = $action . '_code';
    $_SESSION[$code_name] = $code;
    echo '<input type="hidden" name="action" value="' . $action .'">';
    echo '<input type="hidden" name="' . $code_name .'" value="' . $code .'">';
}

function check_code( $action ){
    return ( isset( $_SESSION[$action."_code"] ) && isset( $_POST[$action."_code"] ) && ( $_SESSION[$action."_code"] == $_POST[$action."_code"] ) ) ? true : false;
}

function clean_string( $string ){
    return stripcslashes( $string );
}

function clean_string_na( $string ){
    $a = stripcslashes( $string );
    if( $a ){
        return $a;
    }else{
        return 'N/A';
    }
}

function clean_text( $string ){
    return nl2br( stripcslashes( $string ) );
}
function clean_text_na( $string ){
    $a = stripcslashes( $string );
    if( $a ){
        return $a;
    }else{
        return 'N/A';
    }
}

function clean_attr( $string ){
    return stripcslashes( $string );
}

function clean_textarea( $string ){
    return stripcslashes( $string );
}

function clean_textarea_na( $string ){
    $a = stripcslashes( $string );
    if( $a ){
        return $a;
    }else{
        return 'N/A';
    }
}

function get_thumbnail( $img ){
    return substr($img, 0, strrpos($img, ".")) . '-120.jpg';
}

function show_image( $img = "" ){
    global $uploading;

    if( $img == 'empty' ){
        return 'img/empty.png';
    }

    if( strlen( $img ) > 0 ){
        return home_url() . '/' . $uploading->image_upload_folder . get_thumbnail( $img );
    }else{
        return 'img/default.png';
    }
}

function today_for_html(){
    return date('m/d/Y');
}

function days_before_for_html( $how_many ){
    return date('m/d/Y', strtotime('-'.$how_many.' days'));
}

function array_from_string( $string ){
    if( strlen( $string ) > 0 ){
        $string_arr = explode(',', $string);
        if( is_array($string_arr) && count($string_arr) > 0 ){
            return $string_arr;
        }else{
            return array();
        }
    }else{
        return array();
    }
}

function unserialize_array( $string ){
    $a = unserialize($string);
    return ( is_array($a) ) ? $a : array();
}

function upload_image( $prefix = "" ){
    global $uploading;
    $image = "";
    if( isset($_FILES["file"]) && $_FILES["file"]["size"] > 0 ){
        $image = $uploading->upload_image( $prefix );
    }
    return $image;
}

function upload_image_email( $prefix = "" ){
    global $uploading;
    $image = "";
    if( isset($_FILES["email_image_4_5"]) && $_FILES["email_image_4_5"]["size"] > 0 ){
        $image = $uploading->upload_image( $prefix, 'email_image_4_5' );
    }
    return $image;
}
function upload_image_email_2( $prefix = "" ){
    global $uploading;
    $image = "";
    if( isset($_FILES["email_image_3_under"]) && $_FILES["email_image_3_under"]["size"] > 0 ){
        $image = $uploading->upload_image( $prefix , 'email_image_3_under');
    }
    return $image;
}

function edit_image( $prefix = "" ){
    global $uploading;
    $image = "";
    if( isset($_FILES["file"]) && $_FILES["file"]["size"] > 0  ){
        $image = $uploading->upload_image( $prefix );
    }elseif( isset($_POST["remove-image"]) && $_POST["remove-image"] == 'on' ){
        $image = 'remove';
    }
    return $image;
}

function merge_name( $first_name = "", $middle_name = "", $last_name = "" ){
    $output = $first_name;
    $output .= ( $middle_name ) ? ' ' . $middle_name : "";
    $output .= ( $last_name ) ? ' ' . $last_name : "";
    return $output;
}

function count_text_array( $a ){
    if( strlen($a) > 0 ){
        return count( explode( ',', $a ) );
    }else{
        return 0;
    }
}

function string_to_array( $a ){
    if( strlen($a) > 0 ){
        return explode( ',', $a );
    }else{
        return array();
    }
}

function leading_zero( $a ){
    if( $a > 0 && $a < 10 ){
        return "0" . $a;
    }else{
        return $a;
    }
}
?>