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

  <body class="login-page" id="loginPage">

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
     <form action="<?php echo action_url(); ?>" method="POST"  id="login-form">
         <?php hidden_action_inputs( 'login' ); ?>
      <label for="">E-Mail</label>
      <input type="email" name="email" class="required" placeholder="Enter your email">
      <label for="">Password</label>
      <input type="password" name="password" class="required">

     <label id="errorMessage" style="display:block; color: red">
         <?php echo error_login()?>
     </label>

       <label class='control control--checkbox'>   <span>Remember me on this PC</span>
            <input type="checkbox" />
          <div class="control__indicator"></div>
        </label>

      <input type="submit" value="Login">
     </form>
    </div>
    <!-- // login box  -->
    <div class="login-forgot-box">
      <a href="forgot-password.php">Forgot <strong>username or password?</strong></a>
    </div>
    <!-- // forgot  -->
  </div>
  <!-- // login content  -->


    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <!-- Include all compiled plugins and libraries -->
    <script src="js/custom-dist.js"></script>
  <style>
      .validation-warning{
          position: absolute;
          top: -30px;
          right: 0;
          padding: 4px;
          font-size: 12px;
          background: #000;
          color: #fff;
      }
      .validation-warning span{
          position: absolute;
          bottom: -5px;
          left: 50%;
          margin-left: -3px;
          width: 0;
          height: 0;
          border-left: 6px solid transparent;
          border-right: 6px solid transparent;
          border-top: 6px solid black;
      }
      .form-wrapper input.error-icon,
      .error-icon{
          background-image: url(admin/img/icon-fail.png);
          background-repeat: no-repeat;
          background-position: right 7px;
      }

      #modal2 .error-icon{
          background-image: url(admin/img/icon-fail.png);
          background-repeat: no-repeat;
          background-position: right top;
          border: 1px solid red;
      }
  </style>


  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/plugin.js"></script>
  <script src="js/icheck.js"></script>
  <script src="js/validation.js"></script>
  <script src="js/surveyapp-admin.js"></script>

  <script type="text/javascript">
      prepare_for_validation(['email', 'password'], 'login-form');

  </script>

  </body>
</html>
