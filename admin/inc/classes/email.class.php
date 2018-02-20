<?php

class Email{

	public $from;
	public $from_name;
	public $show_button = false;
	public $button_text = "";
	public $button_link = "";
	public $header_mgs = "Welcome to ";
	public $title = "";
	public $msg_title = "";
	public $msg_text = "";
	public $before_signature = "";
	public $signature = "";
	public $facebook_url = "";
	public $twitter_url = "";
	public $company_name = "";
	public $company_address = "";
	public $contact_email = "";


	public function __construct( $from = "", $from_name = "" ){
		global $globalapp;
		if( $from ){
			$this->set_from( $from, $from_name );
		}
		$this->title = $globalapp["site_title"];
		$this->facebook_url = $globalapp["facebook"];
		$this->twitter_url = $globalapp["twitter"];
		$this->company_name = $globalapp["site_title"];
		$this->company_address = $globalapp["address"];
		$this->contact_email = $globalapp["contact_email"];
	}

	public function set_from( $from, $from_name ){
		if( $from_name ){
			$this->from = $from_name . ' <' . $from . '>';
		}
		$this->from = $from;
	}

	public function get_template(){
		ob_start();
		$show_button = $this->show_button;
		$button_text = $this->button_text;
		$button_link = $this->button_link;
		$header_mgs = $this->header_mgs;
		$title = $this->title;
		$msg_title = $this->msg_title;
		$msg_text = $this->msg_text;
		$before_signature = $this->before_signature;
		$signature = $this->signature;
		$img_url = home_url() . "inc/mail-templates/light-blue/";
		$facebook_url = $this->facebook_url;
		$twitter_url = $this->twitter_url;
		$company_name = $this->company_name;
		$company_address = $this->company_address;
		$contact_email = $this->contact_email;
		$support_page = home_url() . 'support.php';
		include 'inc/mail-templates/light-blue/index.php';
		return ob_get_clean();
	}

	public function show_template(){
		echo $this->get_template();
	}

	function get_headers(){

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$this->from . "\r\n";
		$headers .= 'Reply-To: '.$this->from . "\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion();

		return $headers;
	}

	function send( $to, $subject ){

		return mail( $to, $subject, $this->get_template(), $this->get_headers() );

	}

	function send_new_account_email( $first_name, $last_name, $email, $password, $role ){
		global $globalapp;

		$this->header_mgs = 'Welcome ';
		$this->title = $first_name . ' '.$last_name;
		$this->msg_title = $globalapp["site_title"] . ' created account for you ';
		$this->msg_text = 'You can login using following data:';
		$this->msg_text .= '<br><br>Email: <strong>'.$email.'</strong>';
		$this->msg_text .= '<br>Password: <strong>'.$password.'</strong>';
		$this->msg_text .= '<br><br>Your role is '.$role;
		$this->signature = $globalapp["site_title"];
		$this->show_button = true;
		$this->button_text = "Login";
		$this->button_link = home_url();


		return $this->send($email, $globalapp["site_title"].' '."Account");
	}

	function reset_password_request( $id, $first_name, $last_name, $email ){
		global $globalapp;
		//return mail($globalapp["contact_email"], 'My Subject', $this->get_template(), $this->get_headers());
		$this->header_mgs = 'Reset password for ';
		$this->title = $email;
		$this->msg_title = 'User ' . $first_name.' '.$last_name.' required password reset';
		$this->msg_text = 'Click button to see profile of this user';
		$this->signature = $globalapp["site_title"];
		$this->show_button = true;
		$this->button_text = "Profile of ". $first_name.' '.$last_name;
		$this->button_link = home_url().'admin/user-details.php?id='.$id;

		return $this->send($globalapp["contact_email"], 'Survey App Reset password');
	}

	function new_user_mail( $id, $first_name, $last_name, $email, $password ){
		global $globalapp;
		//return mail($globalapp["contact_email"], 'My Subject', $this->get_template(), $this->get_headers());
		$this->header_mgs = 'Survey App account';
		$this->title = $email;
		$this->msg_title = 'Welcome ' . $first_name.' '.$last_name.' to survey app';
		$this->msg_text = 'New account is created for you. You can login using following information.<br>Email: '.$email.'<br>Password: '.$password.'<br>';
		$this->signature = $globalapp["site_title"];
		$this->show_button = true;
		$this->button_text = "Login";
		$this->button_link = home_url().'admin/';

		return $this->send($email, 'Survey App Account');
	}

}

?>