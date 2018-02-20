<?php
$page_name = "edit-professional.php";
include 'header.php';

$edit_id = ( isset($_GET["id"]) && $_GET["id"] > 0 ) ? $_GET["id"] : 0;

if( $edit_id > 0 && $professional->exists( $edit_id ) ) {

    $professional_data = $professional->get_by_id($edit_id)[0];

}
?>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">


    <div id="main-content">

        <div id="branding-bar">
            <a href="#" id="open-side-menu"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
        </div>
        <!-- // brandig bar  -->

        <header id="main-header">
            <h1>Add New Professional</h1>
            <h2>Add new OQRA Professional</h2>
        </header>
        <!-- // main header  -->

        <div id="clients-content">

            <div id="accordion-form">


                <h3>Professional details</h3>
                <div class="form-content">
                    <form action="<?php echo action_url(); ?>" method="POST" enctype="multipart/form-data" id="edit-professional-form">
                        <?php hidden_action_inputs( 'edit_professional' ); ?>

                        <input type="hidden" name="professional_id" value="<?php echo $professional_data->id; ?>">

                        <div class="row">

                            <div class="form-horizontal col-md-6">

                                <div class="form-group">
                                    <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="full_name">Full Name</label>
                                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                                        <input type="text" class="required" name="full_name" value="<?php echo $professional_data->name; ?>">
                                    </div>
                                </div>
                                <!-- // group  -->

                            </div>
                            <!-- // form left  -->

                            <div class="form-horizontal col-md-6">

                                <div class="form-group">
                                    <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="address_professional">Address</label>
                                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                                        <input type="text" class="required" name="address_professional" value="<?php echo $professional_data->adress; ?>">
                                    </div>
                                </div>
                                <!-- // group  -->
                            </div>
                            <!-- // form right  -->

                        </div>
                        <!-- // row -->


                        <div class="row">

                            <div class="form-horizontal col-md-6">

                                <div class="form-group">
                                    <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="email_professional">Email Address</label>
                                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                                        <input type="email" class="required email-input" name="email_professional" value="<?php echo $professional_data->email; ?>">
                                    </div>
                                </div>
                                <!-- // group  -->

                            </div>
                            <!-- // form left  -->

                            <div class="form-horizontal col-md-6">

                                <div class="form-group">
                                    <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="phone_professional">Phone</label>
                                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                                        <input type="tel" class="required" name="phone_professional" value="<?php echo $professional_data->phone; ?>">
                                    </div>
                                </div>
                                <!-- // group  -->
                            </div>
                            <!-- // form right  -->

                        </div>
                        <!-- // row -->

                        <div class="row"> <!--Multiple location select-->

                            <div class="form-horizontal col-md-6">

                                <div class="form-group">
                                    <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" >Location</label>
                                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                                        <select  name = 'location[]' class="selectpicker" data-live-search="true" multiple data-placeholder="Locations">
                                            <?php echo location_select_box( true, false, $professional_data->location_id );; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- // group  -->

                            </div>
                            <!-- // form left  -->

                            <div class="form-horizontal col-md-6">

                                <div class="form-group">
                                    <label class="control-label col-sm-5 col-md-4 col-lg-4 col-xl-3" for="logo">LOGO</label>
                                    <div class="col-sm-7 col-md-8 col-lg-7 col-xl-8">
                                        <?php edit_image_box($professional_data->image) ?>
                                    </div>
                                </div>
                                <!-- // group  -->
                            </div>
                            <!-- // form right  -->

                        </div> <!--Multiple location -->

                </div>

                <!-- // form content  -->

            </div>
            <!-- // accordion  -->

            <div class="row" id="action-area">
                <div class="col-md-6">
                    <button type="submit" class="save-setting-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Update</button>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <!-- // action area -->

        </div>
        <!-- // app content   -->

        <div id="dash-footer">
            <small> Copyright by DMS. All Rights Reserved. </small>
            <img src="img/logos/oqra-logo.png" alt="">
            <div class="clearfix"></div>
        </div>
        <!-- // footer    -->

    </div>
    <!-- // main content  -->

    </div>
    <!-- // app content  -->

    </div>
    <!-- // page wrapper  -->



 <?php include 'footer.php'; ?>
<script type="text/javascript">
    prepare_for_validation(['full_name', 'address_professional', 'email_professional', 'phone_professional'], 'add-professional-form');

</script>
