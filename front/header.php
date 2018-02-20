<?php
include '../admin/inc/config.php';
if( !$user->is_loggedin() ){
    redirect_to( admin_login_url() );
}

if( $current_user->role_id != 1 ){
    if( in_array( basename($_SERVER['PHP_SELF']), array(
        'add-new-client.php',
        'add-new-user.php',
        'add-new-professional',
        'edit-professional',
        'add-new-location.php',
        'clients.php',
        'users.php'
    ) ) ){
        redirect_to( dashboard_url() );
    }
}
if( $_SESSION["selected_client_id"] != -1){
    $_SESSION["client"] = $client->get_by_ids($_SESSION["selected_client_id"])[0];
    $_SESSION["logged-user"] = $user->get_user_by_client_id($_SESSION["selected_client_id"])[0];
    $_SESSION["NOP"] = $user ->totals($_SESSION["logged-user"]-> id);

}
else {
    $_SESSION["client"] = $current_user;
    $_SESSION["logged-user"] = $current_user;
}

$sum = 0;
$prod = 0;
$i=5;
$clients = $client->get_ratings_for_client($_SESSION["selected_client_id"]);
foreach ($clients as $clienti) {
    $prod += $i* $clienti->COUNT;
    $i--;
    $sum += $clienti->COUNT;
}

if($sum <> 0){
    $average = round($prod/$sum,2);
}
else $average = 0.00;


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
    <?php print_ajax_url(); ?>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]-->
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
            background-image: url(../admin/img/icon-fail.png);
            background-repeat: no-repeat;
            background-position: right 7px;
        }

        #modal2 .error-icon{
            background-image: url(../admin/img/icon-fail.png);
            background-repeat: no-repeat;
            background-position: right top;
            border: 1px solid red;
        }

    </style>

<!-- Include all compiled plugins and libraries -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="../js/jquery.matchHeight.js" type="text/javascript"></script>
    <script src="../js/bootstrap-select.min.js"></script>
    <script src="../js/custom-dist.js"></script>
    <script src="../admin/js/surveyapp-admin.js"></script>
    <script src="../admin/js/validation.js"></script>
    <script src="../admin/js/survey-main.js"></script>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
   <!-- <script type="text/javascript" src='//maps.google.com/maps/api/js?sensor=false&libraries=places'></script>-->
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>



    <script src="../js/plugin.js"></script>
    <script src="../js/icheck.js"></script>
    <script src="../js/validation.js"></script>
    <script src="../js/Chart.js"></script>




    <!--[endif]-->

</head>

<body id="appPage">

<div id="profile-menu">
    <header>
        <a href="#" class="close-profile-menu"><i class="fa fa-times" aria-hidden="true"></i></a>
        <div class="clearfix"></div>
        <img src="<?php echo(show_image( clean_string( $_SESSION["client"]->logo ) )) ?>" alt="">
        <h5>Hello, <?php echo($_SESSION["logged-user"]->first_name . ' ' . $_SESSION["logged-user"]->last_name) ?></h5>
        <h6>
            <?php
            if($current_user->role_id == 1){
                echo ("Root user");
            }
            ?>
        </h6>
        <a href="../logout.php" class="logout-btn">Log out <i class="fa fa-sign-out" aria-hidden="true"></i></a>
    </header>
    <div class="profile-content">
        <h3>PROFILE DETAILS</h3>

        <span class="profile-label">FIRST NAME:</span>
        <span class="profile-value"><?php echo($_SESSION["logged-user"]->first_name) ?></span>

        <span class="profile-label">PHONE:</span>
        <span class="profile-value"><?php echo($_SESSION["logged-user"]->phone) ?></span>

        <span class="profile-label">EMAIL:</span>
        <span class="profile-value"><a href="#"><?php echo($_SESSION["logged-user"]->email) ?></a></span>

        <a href="settings.php" class="edit-profile-btn">Edit Profile <i class="fa fa-pencil" aria-hidden="true"></i></a>

    </div>
    <!-- // profile details and content  -->
</div>
<!-- // profile menu  -->

<div id="page-wrapper">

    <div id="main-navigation">

        <div class="branding-box">
            <a href="#"><img src="../img/logos/oqra-logo.png" alt=""></a>
        </div>
        <!-- // branding box  -->

        <div class="menu-bar">

            <nav class="navbar">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <?php include 'inc_mainnav.php';?>

            </nav>

        </div>
        <!-- // menu bar -->

    </div>
    <!-- // main navigation  -->

    <div id="dash-content">

        <div id="options-bar">

            <header>
                <a href="#" id="close-option-bar"></a>
            </header>

            <div id="secondary-nav">
                <ul>
                    <li><a href="#"><i class="fa fa-chevron-up" aria-hidden="true"></i>Satisfied</a></li>
                    <li><a href="#"><i class="fa fa-minus" aria-hidden="true"></i>Neutral</a></li>
                    <li><a href="#"><i class="fa fa-chevron-down" aria-hidden="true"></i>Dissatisfied</a></li>
                    <li><a href="#"><i class="fa fa-microphone" aria-hidden="true"></i>Audio Reviews</a></li>
                    <li><a href="#"><i class="fa fa-video-camera" aria-hidden="true"></i>Video Reviews</a></li>
                    <li><a href="#"><i class="fa fa-share-alt-square" aria-hidden="true"></i>Social Shares</a></li>
                </ul>
            </div>
            <!-- // sec nav  -->
            <div class="chart-box">
            <h3><i class="fa fa-pie-chart" aria-hidden="true"></i> Review Chart</h3>
            <canvas id="myChart" name="mycanvas"></canvas>
                <script>
                    new Chart(document.getElementById("myChart"),
                        {"type":"doughnut",
                            "data":
                                {
                                    "labels":["Extremly Satisfied","Very Satisfied","Satisfied", "Dissatisfied", "Very Dissatisfied"],
                                    "datasets":[{"label":"Review Chart",
                                                "data":[<?php echo $clients[0]->COUNT ?>,<?php echo $clients[1]->COUNT ?>,<?php echo $clients[2]->COUNT ?>,<?php echo $clients[3]->COUNT ?>,<?php echo $clients[4]->COUNT ?>],
                                                "backgroundColor":["#00AA8A","#28CDAE","#FFD507", "#E81960","#E50000"]}]
                                },
                            options: {
                                legend: {
                                    display: false
                                },
                                tooltips: {
                                    enabled: true
                                }
                            }
                        });

                </script>

            </div>
            <!-- // review chart  -->

            <div id="accordion" class="statistics-box">

                <h3>Statistics (All Time)</h3>

                <div class="result-box">
                    <span class="total-reviews"><?php echo $sum ?></span>
                    <span class="total-label">Total reviews</span>

                    <ul>
                        <li><a href="#">Extremely satisfied <span><?php echo $clients[0]->COUNT ?></span></a></li>
                        <li><a href="#">Very satisfied <span><?php echo $clients[1]->COUNT ?></span></a></li>
                        <li><a href="#">Satisfied <span><?php echo $clients[2]->COUNT ?></span></a></li>
                        <li><a href="#">Dissatisfied <span><?php echo $clients[3]->COUNT ?></span></a></li>
                        <li><a href="#">Very dissatisfied <span><?php echo $clients[4]->COUNT ?></span></a></li>
                    </ul>

                </div>
                <!-- // results  -->

            </div>
            <!-- // statistics  -->

            <div class="subscription-box">
                <h4>ACTIVE SUBSCRIPTION</h4>
                <h5><i class="fa fa-calendar" aria-hidden="true"></i> 27th july 2017</h5>
                <a href="#">Extend now</a>
            </div>


        </div>


        <!-- // options -->