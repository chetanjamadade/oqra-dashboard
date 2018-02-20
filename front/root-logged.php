<?php
include '../admin/inc/config.php';
if( !$user->is_loggedin() ){
    redirect_to( admin_login_url() );
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
    <link rel="stylesheet" href="../css/main.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->    

  </head>

  <body class="login-page">

  <div id="login-top-bar">
    <a href="#"><img src="../img/logos/oqra-logo.png" alt=""></a>
  </div>
  <!-- // top bar with logo  -->

    <header>
      <h1>Welcome to OQRA Dashboard</h1>
      <p>Select client to LOGIN with Root privileges or create new one</p>
    </header>
    <!-- // header  -->  

   
    <div class="container" id="root-screen-1">
      <div class="row">
        <div class="col-xs-12 col-sm-4 col-sm-offset-4">
          <div class="all-users">
              <form action="<?php echo action_url(); ?>" method="POST" enctype="multipart/form-data" id="select-client-form">
                  <?php hidden_action_inputs( 'select-client' ); ?>
            <label>Select user to login with ROOT privileges</label>
                <?php echo user_search_box( 'selected_client_id' );?>

            <button id="sub-btn" type="submit">Login</button>
            </form>
          </div>
          <div id="sidebar-actions">
              <p class="ocn">Or create new client</p>
              <a href="add-new-client.php" class="add-new-btn">Create new client</a> <!--Ovde ubaci link koji te vodi na dodavanje novog klijenta -->
          </div>
        </div>
      </div>
    </div>


    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <!-- Include all compiled plugins and libraries -->
    <script src="../js/custom-dist.js"></script>

  </body>
</html>
