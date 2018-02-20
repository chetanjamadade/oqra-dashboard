<?php

Header('Access-Control-Allow-Origin: *');
require_once( "../config.php" );
require_once ("../vendor/swiftmailer/swiftmailer/lib/swift_required.php");

//send_email('nikola.fh@gmail.com','Test','Text poruke','peraapp.dms@gmail.com', "OKRA EO", $mobile = false);

$query = array();

error_reporting(0);
ini_set('display_error','Off');

$sid = 'AC757ca2e4dd9cba61ac6b138785ea6405';
$token = 'e905c5307d4beffb60ff3409330e4a48';


if( isset($_POST["action"]) ) {

}
else if ( isset($_GET['route']) ){
    global $globalapp;
    switch ($_GET['route']){
        case 'login': login($globalapp,$query); break;
        case 'err': err($globalapp,$query); break;
        case 'closest': closest($globalapp,$query); break;
        case 'fallbackgps': fallbackgps($globalapp,$query); break;
        case 'dissatisfied': dissatisfied($globalapp,$query); break;
        case 'rateit': rateit($globalapp,$query); break;
        case 'logshare': logshare($globalapp,$query); break;
        case 'sendsocialsms': sendsocialsms($globalapp,$query); break;
        case 'sendsms': sendsmsFunc($globalapp,$query); break;
        case 'submitreview': submitreview($globalapp,$query); break;
        case 'loadurl': loadurl($globalapp,$query); break;
        case 'loadlocationconf': loadlocationconf($globalapp,$query); break;
        case 'loadprofessional': loadprofessional($globalapp,$query); break;
        case 'finish': finish($globalapp,$query); break;
        case 'search': search($globalapp,$query); break;
        case 'uploadvoice': uploadvoice($globalapp,$query); break;
        case 'new': newUser($globalapp,$query); break;
    }
}

function login($globalapp,$query,$config){
    global $user, $db,$globalapp;
    $data = json_decode(file_get_contents("php://input"),true);
    $email = $data['data']['Email'];
    $password = $data['data']['Password'];

    if( $user->login( $db->friendly($email ), $db->friendly( $password ) ) ){
        $sql_query = "SELECT u.client_id, u.id FROM client c join user u on c.id = u.client_id where u.email = '" . $email ."'";
        $r = $db->query($sql_query)[0];
        echo json_encode(array('status'=>true, 'client_id'=>$r->client_id, 'user_id'=>$r->id));
    }else{
        echo json_encode(array('status'=>false,'msg'=>'No client found!'));
    }
}

function err($globalapp,$query){
    $data = json_decode(file_get_contents("php://input"),true);
    $err = $data['data'];
    $myfile = fopen("testfile.txt", "a");
    fwrite($myfile,"DEBUG: $err\r\n");
    fclose($myfile);
}

function closest($globalapp,$query){
    global $db;
    $data = json_decode(file_get_contents("php://input"),true);
    $origLon = $data['data']['lon'];
    $origLat = $data['data']['lat'];
    $client_id = $data['data']['client_id'];

    $dist = 50000; // miles
    $query = "SELECT id, location_name, address, city, zip_code, state, latitude, longitude, 3956 * 2 * ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)+COS($origLat*pi()/180 )*COS(latitude*pi()/180)*POWER(SIN(($origLon-longitude)*pi()/180/2),2))) as distance FROM location WHERE client_id = ".$client_id." AND longitude between ($origLon-$dist/cos(radians($origLat))*69) and ($origLon+$dist/cos(radians($origLat))*69) and latitude between ($origLat-($dist/69)) and ($origLat+($dist/69)) having distance < $dist ORDER BY distance limit 3";

    $q = $db->query($query);

    if (!$q) {
        $sql_query_select_location = "SELECT * FROM location WHERE client_id = ".$client_id." ORDER BY id ASC";;
        $res = $db->query($sql_query_select_location);
        echo json_encode(array('status'=>false,'msg'=>'No locations found within radius of ' . $dist . ' miles from your current location. Sorry, we can\'t continue.','results'=>$res));
    } else {
        $final = array();
        foreach ($q as $r) {
            $final[] = array('id'=>$r->id,'name'=>$r->location_name,'address'=>$r->address,'city'=>$r->city,'zip'=>$r->zip_code,'state'=>$r->state);
        }
        echo json_encode(array('status'=>true,'dist'=>$dist,'results'=>$final));
    }
    exit;
}

function fallbackgps($globalapp,$query){
    global $db;
    $data = json_decode(file_get_contents("php://input"),true);
    $client_id = $data['data']['client_id'];

    $sql_query_select_location = "SELECT * FROM location WHERE client_id = ".$client_id." ORDER BY id ASC";
    $q = $db->query($sql_query_select_location);

    if (!$q) {
        echo json_encode(array('status'=>false,'msg'=>'No locations found. Sorry, we can\'t continue.','results'=>$q[0]));
    } else {
        $final = array();
        foreach ($q as $r) {
            $final[] = array('id'=>$r->id,'name'=>$r->location_name,'address'=>$r->address,'city'=>$r->city,'zip'=>$r->zip_code,'state'=>$r->state);
        }
        echo (json_encode(array('status'=>true,'results'=>$final)));
    }
}

function newUser($globalapp,$query){
    global $db;
    $data = json_decode(file_get_contents("php://input"),true);
    $firstname = $data['data']['Firstname'];
    $lastname = $data['data']['Lastname'];
    $email = $data['data']['Email'];
    $cell = $data['data']['Cell'];
    $client_id = $data['data']['client_id'];

    $check = $db->query("SELECT 1 FROM guest WHERE phone_guest = '$cell' AND client_id = ". $client_id);
    if ($check) {
        /** Already exists message **/
        $sql_query_select_client_with_conf = "SELECT * FROM client c join client_configuration cc on c.id=cc.client_id where c.id= ".$client_id;
        $result = $db->query($sql_query_select_client_with_conf)[0];
        $result = ($result->exists_message == '') ? $result = 'This number already exits. Do you want to make a search?' : $result->exists_message;
        echo json_encode(array('status'=>false,'msg'=>$result));
    }else {
        $sql_query_user_into = "INSERT INTO guest (first_name_guest,last_name_guest,email_guest,phone_guest,client_id) VALUES ('$firstname','$lastname','$email','$cell','$client_id')";
        $db->query($sql_query_user_into);

        $id = $db->insert_id;
        if($id==0){
            echo json_encode(array('status' => false, 'msg' => 'Can not insert data!'));
        }else{
            echo json_encode(array('status' => true, 'id' => $id));
        }
    }
}

function dissatisfied($globalapp,$query){
    $data = json_decode(file_get_contents("php://input"),true);
    $userid = $data['data']['userid'];
    $rate = $data['data']['rate'];
    $title = $data['data']['title'];
    $desc = $data['data']['desc'];
    $location = $data['data']['location'];
    $date = date('Y-m-d H:i:s');
    $session_id = md5(time());
    $rating_id = $data['data']['ratingid'];
    echo json_encode(array('status'=>true));
}

function rateit($globalapp,$query){
    global $db;
    $data = json_decode(file_get_contents("php://input"),true);
    $userid = $data['data']['userid'];
    $rate = $data['data']['rate'];
    $date = date('Y-m-d H:i:s');
    $session_id = md5(time());
    $rating_id = $data['data']['ratingid'];
    $client_id = $data['data']['client_id'];

    $sql_query_insert_rating = "INSERT INTO rating (user_id,rating,session_id,is_delete,client_id) VALUES ('$userid','$rate','$session_id','0','$client_id')";
    $db->query($sql_query_insert_rating);

    $rating_id = $db->insert_id;

    echo json_encode(array('status'=>true,'id'=>$rating_id,'session'=>$session_id));
}

function logshare($globalapp,$query){
    global $db;
    $data = json_decode(file_get_contents("php://input"),true);
    $userid = $data['data']['userid'];
    $rate = $data['data']['rate'];
    $type = $data['data']['type'];
    $location = $data['data']['location'];
    $date = date('Y-m-d H:i:s');
    $client_id = $data['data']['client_id'];

    $sql_query_socialshare_insert = "INSERT INTO socialshare (user_id,social_type,rating,location_id,client_id) VALUES ('$userid','$type','$rate','$location','$client_id')";
    $db->query($sql_query_socialshare_insert);

    echo json_encode(array('status'=>true));
}

function sendsocialsms($globalapp,$query){
    //send sms to guest
    global $db;
    $data = json_decode(file_get_contents("php://input"),true);
    $userid = $data['data']['userid'];
    $rate = $data['data']['rate'];
    $location = $data['data']['location'];
    $network = $data['data']['network'];
    $date = date('Y-m-d H:i:s');
    $client_id = $data['data']['client_id'];
    $guest_id = $data['data']['guest_id'];
    $sql_query_insert_social_share = "INSERT INTO socialshare (user_id,social_type,rating,location_id,client_id) VALUES ('$userid','$network','$rate','$location','$client_id')";
    $db->query($sql_query_insert_social_share);

    $send = false;
    $sql_query_select_quest = "SELECT * FROM guest WHERE client_id = $client_id AND id = $guest_id";
    $cnum = $db->query($sql_query_select_quest)[0];

    /** Get client phone number **/
    $clientData = clientPhoneNumberReview($client_id, $userid, $location,$cnum, $send);

    $textReview = $clientData["textReview"];
    $send = $clientData["send"];
    /** Gplus link **/
    gplusLink($client_id, $location, $send, $cnum, $textReview);

    echo json_encode(array('status'=>true));
}

function clientPhoneNumberReview($client_id, $userid, $location, $cnum, $send){
    global $db;
    $textReview = '';
    $data = array();
    if ($cnum) {
        /** Get review **/
        $sql_select_review = "SELECT review,rating_id FROM review WHERE client_id = $client_id AND location_id = $location AND user_id = $userid ORDER BY id DESC LIMIT 1";
        $review = $db->query($sql_select_review)[0];
        if ($review) {
            if ($review->review == 'Upload') {
                $sql_select_file_review = "SELECT file FROM review WHERE client_id = $client_id AND user_id = $userid AND rating_id = " . $review->rating_id . " ORDER BY id LIMIT 1";
                $c = $db->query($sql_select_file_review)[0];
                if ($c) {
                    if (strpos($c->file,'MOV') !== false) {
                        $textReview = 'http://fluohead.com/oqra-dashboard/mobile-oqra/uploads' . $c->file;
                    } else if (strpos($c->file,'mp4') !== false) {
                        $tm = basename($c->file);
                        $textReview = 'http://fluohead.com/oqra-dashboard/mobile-oqra/uploads' . $tm;
                    } else {
                        $textReview = 'http://fluohead.com/oqra-dashboard/mobile-oqra/www/audioDownload.php?name=' . basename($c->file) . '.mp3';
                    }
                    $send = true;
                }
            } else {
                $sql_query_select_review = "SELECT review FROM review WHERE user_id = $userid AND client_id = $client_id AND location_id = $location ORDER BY id DESC LIMIT 1";
                $textReview = $db->query($sql_query_select_review)[0];
                if ($textReview) {
                    $textReview = $textReview->review;
                    $send = true;
                }
            }
        }
    }
    $data["send"] = $send;
    $data["textReview"] = $textReview;
    return $data;
}

function gplusLink($client_id, $location, $send, $cnum, $textReview){
    global $db;
    /** Gplus link **/
    $sql_query_link = "SELECT * FROM location_configuration lc join location l on lc.location_id = l.id join client c on l.client_id= c.id WHERE c.id = $client_id AND l.id = $location AND l.status = 1 LIMIT 1";
    $glink = $db->query($sql_query_link)[0]->link_google;
    if ($glink && $send) {
        $gpluslink = $glink->link;
        //phone guest, textreview moze biti audio, video, write review
        sendSms($client_id, $cnum->phone_guest,"Thanks for your review.\n\nPlease COPY your review:\n$textReview\n\nCLICK & PASTE below:\n$gpluslink",true);
    }
}

function sendsmsFunc($globalapp,$query){
    global $db;
    $data = json_decode(file_get_contents("php://input"),true);
    $userid = $data['data']['userid'];
    $rate = $data['data']['rate'];
    $location = $data['data']['location'];
    $date = date('Y-m-d H:i:s');
    $client_id = $data['data']['client_id'];
    $sql_query_insert_socialshare = "INSERT INTO socialshare (user_id,social_type,rating,location_id,client_id) VALUES ('$userid','google','$rate','$location','$client_id')";
    $db->query($sql_query_insert_socialshare);

    $send = false;
    $sql_query_select_user = "SELECT phone FROM user WHERE client_id = $client_id AND id = $userid";
    $cnum = $db->query($sql_query_select_user)[0];

    /** Get client phone number **/
    $clientData = clientPhoneNumberReview($client_id, $userid, $location,$cnum, $send);

    $textReview = $clientData["textReview"];
    $send = $clientData["send"];

    /** Gplus link **/
    gplusLink($client_id, $location, $send, $cnum, $textReview);

    echo json_encode(array('status'=>true));
}

function submitreview($globalapp,$query){
    global $db;
    $data = json_decode(file_get_contents("php://input"),true);
    $userid = $data['data']['userid'];
    $rate = $data['data']['your_rate'];
    $review = $data['data']['comment'];
    $location_id = $data['data']['location'];
    $professional_id = $data['data']['professional'];
    $session_id = md5(time() + rand(1,1111111));
    $client_id = $data['data']['client_id'];
    $guest_id = $data['data']['guest_id'];
    //sql query for logo
    $sql_query_select_logo_client = "SELECT logo FROM client WHERE client_id = ". $client_id;
    $clogo = $db->query($sql_query_select_logo_client);
    //sql query for location cofinguration
    $sql_query_select_location_conf = "SELECT * FROM location_configuration lc WHERE lc.status = 1 and lc.location_id = $location_id";

    /** Get data of guest **/
    $sql_query_select_guest = "SELECT * FROM guest WHERE id =  $guest_id";
    $guest_conf = $db->query( $sql_query_select_guest )[0];

    //if professional_id is != null, than get location_id for this professional
    if($professional_id != null){
        $sql_query_select_location_id = "select * from professional where id= $professional_id";
        $location_id = $db->query($sql_query_select_location_id)[0]->location_id;
     }else {
        $professional_id = "NULL";
    }

    if ($userid == '' || $rate == '' || $review == '') {
        echo json_encode(array('status'=>false));
        exit;
    }
    if ($review == 'Upload') {
        echo json_encode(array('status'=>false));
        exit;
    }

    /** Insert rating data **/
    $sql_query_insert_rating = "INSERT INTO rating (rating,session_id,is_delete,location_id,client_id,professional_id) VALUES ('$rate','$session_id','0','$location_id','$client_id',$professional_id)";
    $db->query( $sql_query_insert_rating);
    $rating_id = $db->insert_id;

    /** Set status for stars **/
    $status = ($rate < 4) ? 0 : 1;

    /** Insert review data **/
    $sql_query_insert_review = "INSERT INTO review (review,rating_id,status,location_id,client_id,professional_id, guest_id) VALUES ('$review','$rating_id','$status','$location_id','$client_id', $professional_id, $guest_id)";
    $db->query( $sql_query_insert_review );

    /** Get location conf **/
    $loc_conf = $db->query( $sql_query_select_location_conf )[0];
    //$email = $loc_conf->admin_email;


    //if rate is less than 4 stars
    if ($rate <= 3) {
        $text_3_under = helperText($guest_conf, $rate, $loc_conf->email_3_under);
        $text_f = str_replace('%t',nl2br($review),$text_3_under);
        $text_f = nl2br($text_f);
        $file = file_get_contents('templates/3under.php');
        $file = str_replace('%text',$text_f,$file);

        $file_c = helperFile($clogo, $file);
        if($file_c != null){
            $file = $file_c;
        }

        /** Text messaging **/
        $revCopy = str_replace('\n',' ',$review);
        $smsText = str_replace('%t',$revCopy,$text_3_under);

        sendSms($client_id, $loc_conf->sms_3_under,$smsText);

        /** Mobile text **/
        $mobile = str_replace('%t',$review,$text_3_under);

        /** Check image **/
        $file = helperImg($loc_conf->email_image_3_under, $file);

        /** Send emails for 3 and under **/
        $conf_mail_3_under = $loc_conf->email_address_3_under;
        sendMobileEmail($conf_mail_3_under, $loc_conf->email_address_3_under, $mobile, $file);
    } else {
        $text_for_admin = $guest_conf->first_name_guest . ' has reviewed your company with ' . $rate . ' stars. <br />Email: ' . $guest_conf->email_guest . '<br />Phone: ' . $guest_conf->phone_guest . '<br />Review:<br />'.nl2br($review);
        ob_start();
        include "templates/template.php";
        $file1 = ob_get_clean();
        $file1 = str_replace('%text',$text_for_admin,$file1);

        $file_c = helperFile($clogo, $file1);
        if($file_c != null){
            $file1 = $file_c;
        }

        $text_4_5 = helperText($guest_conf, $rate, $loc_conf->email_4_5);
        $text = str_replace('%t',nl2br($review),$text_4_5);
        $text = nl2br($text);

        ob_start();
        include "templates/template.php";
        $file = ob_get_clean();
        $file = str_replace('%text',$text,$file);

        $file_c = helperFile($clogo, $file);
        if($file_c != null){
            $file = $file_c;
        }
        /** Text messaging **/
        $txt_msg_4_5 = "Hello,\n" . $guest_conf->first_name_guest . " submitted new review.\n\nRate $rate stars\n\nPhone: " . $loc_conf->sms_4_5 . "\n\nReview:\n\n$review";
        sendSms($client_id, $loc_conf->sms_4_5,$txt_msg_4_5);

        /** Mobile text **/
        $mobile = str_replace('%t',$review,$text_4_5);

        /** Check image **/
        $file = helperImg($loc_conf->email_image_4_5, $file);

        send_email($guest_conf->email,'Thank you for your review',$file,$loc_conf->sender_email,$guest_conf->first_name_guest);

        $conf_mail_4_5 = $loc_conf->email_address_4_5;
        sendMobileEmail($conf_mail_4_5, $loc_conf, $mobile, $file1);
    }

    echo json_encode(array('status'=>true));
}

function helperText($guest_conf, $rate, $text_three){
    $text = str_replace('%s',$guest_conf->first_name_guest,$text_three);
    $text = str_replace('%r',$rate,$text);
    if ($guest_conf->email_guest != '') {
        $text = str_replace('%e',$guest_conf->email_guest,$text);
    } else {
        $text = str_replace('%e','No email address entered',$text);
    }
    $text = str_replace('%p',$guest_conf->phone_guest,$text);
    $text = str_replace('%l',$guest_conf->last_name_guest,$text);
    return $text;
}

function helperFile($clogo, $file){
    if ($clogo) {
        $cl = 'http://fluohead.com/oqra-dashboard/mobile-oqra/www/logos/' . $clogo->logo;
        $file = str_replace('%sitelogo',$cl,$file);
        return $file;
    }
}

function helperImg($email_img, $file){
    if ($email_img != '') {
        $image = "<div class='image' style='font-size: 12px;mso-line-height-rule: at-least;font-style: normal;font-weight: 400;Margin-bottom: 0;Margin-top: 0;font-family: 'Open Sans',sans-serif;color: #60666d;' align='center'>
              <img class='gnd-corner-image gnd-corner-image-center gnd-corner-image-top' style='border: 0;-ms-interpolation-mode: bicubic;display: block;max-width: 900px;' src='".$email_img."' alt='' width='600' height='156' />
            </div>";
        $file = str_replace('%image',$image,$file);
    } else {
        $file = str_replace('%image','',$file);
    }
    return $file;
}

function sendMobileEmail($conf_mail, $email, $mobile, $file){
    foreach ($conf_mail as $mail) {
        if (strpos($mail,'mms.att') !== false || strpos($mail,'vtext.com') !== false || strpos($mail,'txt.att') !== false || strpos($mail,'tmomail.net') !== false) {
            sendMobile($mail,$mobile,'Reviews');
        } else {
            send_email($mail,'New Review for company',$file,$email,'OQRA EO');
        }
    }
}

function sendEmail($conf_mail, $loc_conf, $guest_conf, $rate, $file)
{
    foreach ($conf_mail as $mail) {
        if (strpos($mail,'mms.att') !== false || strpos($mail,'vtext.com') !== false || strpos($mail,'txt.att') !== false || strpos($mail,'tmomail.net') !== false) {
            debugf("Sent textual message to mms / sms $mail");
            $textsms = 'New review has been submitted. ' . $guest_conf->first_name_guest . ' ' . $guest_conf->last_name_guest . ' gave you ' . $rate . ' star(s). Phone number is ' . $guest_conf->phone_guest;
            send_email($mail,'New Review for company',$textsms,$loc_conf->sender_mail,'OQRA EO',true);
        } else {
            send_email($mail,'New Review for company',$file,$loc_conf->sender_mail,'OQRA EO');
        }
    }
}

function loadurl($globalapp,$query){
    global $db;
    $data = json_decode(file_get_contents("php://input"),true);
    $network = $data['data']['type'];
    $client_id = $data['data']['client_id'];

    if (isset($_GET['lid']) && $_GET['lid'] != '') {
        $loc_id = (int)$_GET['lid'];
    } else {
        $sql_query_id_location = "SELECT id FROM location WHERE client_id = $client_id ORDER BY id ASC LIMIT 1";
        $q = $db->query($sql_query_id_location)[0];
        $loc_id = $q->id;
    }

    $sql_query_social = "SELECT * FROM location_configuration lc join location l on lc.location_id = l.id join client c on l.client_id= c.id WHERE c.id = $client_id AND l.id = $loc_id AND l.status = 1 LIMIT 1";
    $q = $db->query($sql_query_social)[0];
    if ($q) {
        if ($network == 'facebook') {
            $link = 'http://www.facebook.com/sharer/sharer.php?s=100&&p[url]=' . urlencode($q->link_fb);
            echo json_encode(array('status'=>true,'link'=>$link));
        } else if ($network == 'yelp') {
            echo json_encode(array('status'=>true,'link'=>$q->link_yelp));
        } else if ($network == 'pinterest') {
            if ($q->logo == '') {
                echo json_encode(array('status'=>false));
            }else {
                $link = 'http://www.pinterest.com/pin/create/button/?url=' . urlencode($q->link_pinterest) . '&media=' . urlencode($q->logo) . '&description=' . urlencode($q->description);
                echo json_encode(array('status' => true, 'link' => $link));
            }
        } else if ($network == 'twitter') {
            $link = 'https://www.twitter.com/share?text=' . urlencode($q->description) . '&url=' . urlencode($q->link_twitter);
            echo json_encode(array('status'=>true,'link'=>$link));
        }else{
            echo json_encode(array('status'=>false));
        }
    }else {
        echo json_encode(array('status' => false));
    }
}

function loadlocationconf($globalapp,$query){
    global $db;
    $data = json_decode(file_get_contents("php://input"),true);
    $client_id = $data['data']['client_id'];
    if (isset($_GET['lid']) && $_GET['lid'] != '') {
        $loc_id = (int)$_GET['lid'];
    } else {
        /** Get first location **/
        $sql_query_select_id_location = "SELECT id FROM location WHERE client_id = ". $client_id ." ORDER BY id ASC LIMIT 1";
        $q = $db->query($sql_query_select_id_location);
        $loc_id = $q->id;
    }

    /** Get timeout **/
    $sql_query_select_timeout_client = "SELECT timeout FROM client WHERE id = ".$client_id;
    $timeOut = $db->query($sql_query_select_timeout_client)[0];
    $timeOut = ($timeOut->timeout == '') ? 0 : ($timeOut->timeout * 60);

    /** Get question **/
    $sql_query_select_question_client = "SELECT question FROM client WHERE id = ". $client_id;
    $question = $db->query($sql_query_select_question_client)[0];
    $question = ($question->question == '') ? 'How did you find your experience today?' : $question->question;

    $sql_query_select_professional = "select * from professional where location_id = $loc_id";
    $professionals = $db->query($sql_query_select_professional);

    $sql_query_select_location_conf = "SELECT * FROM location_configuration lc WHERE status = 1 and lc.location_id = $loc_id";
    $config = $db->query($sql_query_select_location_conf);
    $sql_query_select_count_location = "SELECT COUNT(*) AS total, id FROM location WHERE client_id = ". $client_id;
    $q = $db->query($sql_query_select_count_location)[0];

    $type = "";

    //check if professional exists for this location
    if(count($professionals) > 0){
        //exists
        $type = "professional";
    }else {
        //not exists
        $type = "location";
    }
        $social = array();
        $google = false;
        $twitter = false;
        $pinterest = false;
        $yelp = false;
        $fb = false;
        if ($config > 0) {
            foreach ($config as $r){
                if ($r->active_fb == '1') {
                    $fb = true;
                    array_push($social, "facebook");
                }
                if ($r->active_twitter == '1') {
                    $twitter = true;
                    array_push($social, "twitter");
                }
                if ($r->active_pinterest == '1') {
                    $pinterest = true;
                    array_push($social, "pinterest");
                }
                if ($r->active_yelp == '1') {
                    $yelp = true;
                    array_push($social, "yelp");
                }
                if ($r->active_google == '1') {
                    $google = true;
                    array_push($social, "google");
                }
            }


        if ($q->total == 1) {
            $total = 1;
            $id = $q->id;
        } else {
            $total = $q->total;
            $id = false;
        }

    }
    echo json_encode(array('status'=>true,'google'=>$google,'timeout'=>$timeOut,'question'=>$question,'data'=>$config[0],'social'=>$social,'url'=>'localhost/mobileOqra','total'=>$total,'location_id'=>$id, 'type'=>$type));
}

function loadprofessional($globalapp,$query){
    global $db;
    $data = json_decode(file_get_contents("php://input"),true);
    $client_id = $data['data']['client_id'];
    $loc_id = $_GET['lid'];

    $sql_query_select_professional = "select * from professional where location_id = $loc_id";
    $professionals = $db->query($sql_query_select_professional);
    if($professionals>0) {
        echo json_encode(array('status' => true, 'results' => $professionals));
    }else{
        echo json_encode(array('status' => false, 'msg' => 'No professionals found!'));
    }
}

function finish($globalapp,$query){
    global $db;
    $data = json_decode(file_get_contents("php://input"),true);
    $file = $data['data']['file'];
    $rate = $data['data']['your_rate'];
    $location_id = $data['data']['location'];
    $professional_id = $data['data']['professional'];
    $session_id = md5(time() + rand(1,1111111));
    $client_id = $data['data']['client_id'];
    $guest_id = $data['data']['guest_id'];
    //sql query for logo
    $sql_query_select_logo_client = "SELECT logo FROM client WHERE client_id = ". $client_id;
    $clogo = $db->query($sql_query_select_logo_client);
    //sql query for location cofinguration
    $sql_query_select_location_conf = "SELECT * FROM location_configuration lc WHERE lc.status = 1 and lc.location_id = $location_id";

    /** Get data of guest **/
    $sql_query_select_guest = "SELECT * FROM guest WHERE id =  $guest_id";
    $guest_conf = $db->query( $sql_query_select_guest )[0];

    $back = $file;
    $fileinfo = pathinfo($back);
    $ext = $fileinfo['extension'];

    $temp = explode('/',$file);
    if ($temp[1] == 'private') {
        $file = end($temp);
        if ($file == 'capturedvideo.MOV') {
            $file = rand(1,10000).'_'.time().'.MOV';
            @rename('../../../mobile-oqra/uploads/capturedvideo.MOV','../../../mobile-oqra/uploads/'.$file);
        }
    }

    /** Get extension of the file **/

    if ($ext == 'MOV') {
        $link = 'http://fluohead.com/oqra-dashboard/mobile-oqra/uploads' . basename($file);
    } elseif ($ext == 'm4a') {
        $link = 'http://fluohead.com/oqra-dashboard/mobile-oqra/www/audioDownload.php?name=' . basename($back) . '.mp3';
    } elseif ($ext == '3gp') {
        $link = 'http://fluohead.com/oqra-dashboard/mobile-oqra/www/done/' . basename($back) . '.mp4';
    } elseif ($ext == 'mp4') {
        $link = 'http://fluohead.com/oqra-dashboard/mobile-oqra/uploads' . basename($back);
    }

    /** Insert data **/
    $sql_query_insert_rating = "INSERT INTO rating (rating,session_id,is_delete,location_id,client_id,professional_id) VALUES ('$rate','$session_id','0','$location_id','$client_id',$professional_id)";
    $db->query( $sql_query_insert_rating);
    $rating_id = $db->insert_id;

    /** Insert rating **/
    $status = ($rate < 4) ? 0 : 1;

    $sql_query_insert_review = "INSERT INTO review (review,rating_id,status,location,client_id,professional_id, guest_id, file) VALUES ('Upload','$rating_id',$status','$location_id','$client_id',$professional_id, $guest_id, $file)";
    $db->query($sql_query_insert_review);

    /*$sql_query_insert_reviews = "INSERT INTO sr_reviews (user_id,file,date,rating_id,client_id) VALUES ('$userid','$file','$date1','$rating_id',".$client_id.")";
    mysqli_query($this->db->connection,$sql_query_insert_reviews);*/

      /** Get location conf **/
    $loc_conf = $db->query( $sql_query_select_location_conf )[0];
    //$email = $loc_conf->admin_email;


    if ($rate <= 3) {
        $text_3_under = helperText($guest_conf, $rate, $loc_conf->email_3_under);
        $text = str_replace('%t',$link,$text_3_under);
        $text = nl2br($text);
        ob_start();
        include "templates/3under.php";
        $file = ob_get_clean();
        $file = str_replace('%text',$text,$file);

        $file_c = helperFile($clogo, $file);
        if($file_c != null){
            $file = $file_c;
        }

        /** Text messaging **/
        $smsText = str_replace('%t',$link,$text_3_under);

        sendSms($client_id, $loc_conf->sms_3_under,$smsText);

        /** Check image **/
        $file = helperImg($loc_conf->email_image_3_under, $file);

         /** Send emails for 3 and under **/
        $conf_mail_3_under = $loc_conf->email_address_3_under;
        sendEmail($conf_mail_3_under, $loc_conf, $guest_conf, $rate, $file);
    } else {
         $text_for_admin = $guest_conf->first_name_guest . ' has reviewed your company with ' . $rate . ' stars. <br />Email: ' . $guest_conf->email_guest . '<br />Phone: ' . $guest_conf->phone_guest . '<br />Review:<br />'.$link;
        ob_start();
        include "templates/template.php";
        $file1 = ob_get_clean();
        $file1 = str_replace('%text',$text_for_admin,$file1);

        $file_c = helperFile($clogo, $file1);
        if($file_c != null){
            $file1 = $file_c;
        }

        $text_4_5 = helperText($guest_conf, $rate, $loc_conf->email_4_5);
        $text = str_replace('%t',$link,$text_4_5);
        $text = nl2br($text);
        ob_start();
        include "templates/template.php";
        $file = ob_get_clean();
        $file = str_replace('%text',$text,$file);

        $file_c = helperFile($clogo, $file);
        if($file_c != null){
            $file = $file_c;
        }

        /** Text messaging **/
        $txt_msg_4_5 = "Hello,\n" . $guest_conf->first_name_guest . " submitted new review.\n\nRate $rate stars\n\nPhone: " . $loc_conf->sms_4_5 . "\n\nReview:\n\n$review";
        sendSms($client_id, $loc_conf->sms_4_5,$txt_msg_4_5);

        /** Check image **/
        $file = helperImg($loc_conf->email_image_4_5, $file);

        send_email($guest_conf->email,'Thank you for your review',$file,$loc_conf->sender_email,$guest_conf->first_name_guest);

        /** Send emails for 4 and 5 stars **/
        $conf_mail_4_5 = $loc_conf->email_address_4_5;
        sendEmail($conf_mail_4_5, $loc_conf, $guest_conf, $rate, $file1);
    }


    echo json_encode(array('status'=>true));
}


function search($globalapp,$query,$config){
    global $db;
    $data = json_decode(file_get_contents("php://input"),true);
    $email = $data['data']['mail'];
    $phone = $data['data']['phone'];
    $client_id = $data['data']['client_id'];

    if ($phone != '') {
        $sql_query_select_guest = "SELECT * FROM guest WHERE phone_guest = '$phone' and client_id = $client_id LIMIT 1";
        $q = $db->query($sql_query_select_guest)[0];
        if (!$q) {
            /** Get not found message **/
            $sql_query_select_client_with_conf = "SELECT * FROM client c join client_configuration cc on c.id=cc.client_id where c.id= ".$client_id;
            $result = $db->query($sql_query_select_client_with_conf)[0];
            $result = ($result->not_found_message == '') ? $result = 'We could not find your number' : $result->not_found_message;
            error($result);
        } else {
            echo json_encode(array('status'=>true,'id'=>$q->id,'firstname'=>$q->first_name_guest,'lastname'=>$q->last_name_guest));
        }
    }
}

function uploadvoice($globalapp,$query){
    $data = json_decode(file_get_contents("php://input"),true);
    print_r($data);
}

function send_email($to,$subject,$text,$from,$name = "Review", $mobile = false) {
    if ($to == '') return false;

    $transport = Swift_SmtpTransport::newInstance('mtserverde.mtgdns.info', 465, "ssl")
        ->setUsername('nikola@fluohead.com')
        ->setPassword('hijeroglif1989');
    $mailer = Swift_Mailer::newInstance($transport);

    if (!$mobile) {
        $message = Swift_Message::newInstance($subject)
            ->setFrom(array('nikola@fluohead.com' => $name))
            ->setTo(array($to))
            ->setReplyTo(array('no-reply@1qreputation.com' => '1qreputation.com'))
            ->setContentType("text/html")
            ->setBody($text);

    } else {
        $message = Swift_Message::newInstance($subject)
            ->setFrom(array('nikola@fluohead.com' => 'Review'))
            ->setTo(array($to))
            ->setBody($text);
    }
    $headers = $message->getHeaders();

    $headers->addTextHeader('X-Mailer', 'SwiftMailer 5.4.3');
    /*
    foreach ($headers->getAll() as $header) {
      echo var_dump($header->toString());
    }
    die;
    */
    $result = $mailer->send($message);


    /*
    $mail = new SimpleMail();

    if (!$mobile) {
        $mail->setTo($to, $name)
             ->setSubject($subject)
             ->setFrom('reviews@1qreputation.com', 'Review')
             ->addMailHeader('Reply-To', 'no-reply@1qreputation.com', '1qreputation.com')
             ->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
             ->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
             ->setMessage($text);
        $send = $mail->send();
    } else {
        $mail->setTo($to, $name)
             ->setSubject($subject)
             ->setFrom('reviews@1qreputation.com', 'Review')
             ->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
             ->setMessage($text);
        $send = $mail->send();
    }
    */
}

function sendMobile($to,$text,$name = "Review") {
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    mail($to, "New Review", $text, "From: Review <reviews@1qreputation.com>\r\n$headers");

    $transport = Swift_SmtpTransport::newInstance('mtserverde.mtgdns.info', 465, "ssl")
        ->setUsername('nikola@fluohead.com')
        ->setPassword('hijeroglif1989');
    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance('New Review')
        ->setFrom(array('nikola@fluohead.com' => $name))
        ->setTo(array($to))
        ->setBody($text);
}

function sendSms($client_id, $to = '',$msg = '', $single = false) {
    //salje se sms broju iz location_conf, izvlaci ili texta number zax 4 i 5 ili text number za 3 and under
    global $db;
    if ($to == '' && empty($msg)) return false;

    require_once('../sms/Twilio.php');
    global $sid,$token;
    $client = new Services_Twilio($sid, $token);

    $sql_query_app_configuration = "select * from app_configuration where client_id = " .$client_id;
    $prefix_number = $db->query( $sql_query_app_configuration )[0]->prefix_number;

    if ($single) {
        if (strpos($to,'+') === false) {
            $to = $prefix_number . $to;
        }
        $to = str_replace(array('(',')','-',' '),'',$to);
        //  debugf("Sending single notification message to $to | Message: $msg");
        $message = $client->account->messages->sendMessage(
            '18317776772',
            $to,
            $msg
        );
        if ($message->sid) {
            debugf("Sent sms to $to SID " . $message->sid);
        } else {
            debugf("SMS sending failed for $to");
        }
        return;
    }

    $numbers = explode(',',$to);
    if (count($numbers) == 0) return;
    foreach ($numbers as $number) {
        if (strpos($number,'+') === false) {
            $number = $prefix_number . $number;
        }
        $number = str_replace(array('(',')','-',' '),'',$number);
        try {
            $message = $client->account->messages->sendMessage(
                '18317776772',
                $number,
                $msg
            );
        }catch(Exception $e){
            $e->getMessage();
        }
       /* if ($message->sid) {
            debugf("Sent sms to $number SID " . $message->sid);
        } else {
            debugf("SMS sending failed for $number");
        }*/
    }
}

/** Error function **/
function error($msg) {
    echo json_encode(array('status'=>false,'msg'=>$msg));
    exit;
}


die();

?>