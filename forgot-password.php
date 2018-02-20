<?php
include 'admin/inc/config.php';
if( $user->is_loggedin() ){
    redirect_to( dashboard_url() );
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>

    <title></title>

    <!-- Import Main CSS -->
    <link rel="stylesheet" href="css/main.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->    

  </head>

  <body class="login-page">

  <div id="login-top-bar">
    <a href="#"><img src="img/logos/oqra-logo.png" alt=""></a>
  </div>
  <!-- // top bar with logo  -->

    <header>
      <h1>Welcome to OQRA Dashboard</h1>
      <p>Please log-in using your credentials</p>
    </header>
    <!-- // header  -->  

  <div id="login-content">
    <div class="login-box">
        <form action="<?php echo action_url(); ?>" method="POST"  id="forgot-password-form">
            <?php hidden_action_inputs( 'forgot-password' ); ?>
            <div class="info-alert-box">
                  <p>Please enter your username or email address. You will receive a link to create a new password via email.</p>
            </div>
            <!-- // alert box  -->

            <label for="">Email Address</label>
            <input type="email" name ="email">

            <input type="submit" value="Reset Password">
        </form>
    </div>
    <!-- // login box  -->
    <div class="back-login-box">
      <a href="index.php">Back to login</a>
    </div>
    <!-- // forgot  -->
  </div>
  <!-- // login content  -->


    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <!-- Include all compiled plugins and libraries -->
    <script src="js/custom-dist.js"></script>   

  </body>
</html>
