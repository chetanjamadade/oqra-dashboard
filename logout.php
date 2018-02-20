<?php
require_once("admin/inc/config.php");
$user->logout();
redirect_to( login_url() );
?>