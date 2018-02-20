<?php
$page_name = "add-new-client.php";
include 'header.php';
?>

<div id="main-content">

    <div id="branding-bar">
        <a href="#" id="open-side-menu"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
    </div>
    <!-- // brandig bar  -->

    <header id="main-header">
        <h1>Add New Client</h1>
    </header>
    <!-- // main header  -->
    <form action="<?php echo action_url(); ?>" method="POST" enctype="multipart/form-data" id="add-new-client">

        <?php hidden_action_inputs( 'add_client' ); ?>

    <div id="clients-content">

        <div id="accordion-form">

            <h3>Add New Client</h3>

            <div class="form-content">


                    <div class="row">

                        <div class="form-horizontal col-md-12 col-lg-10 col-xl-7">
                            <div class="form-group">
                                <label class="control-label col-sm-5 col-md-4 col-lg-4 col-xl-3" for="name">CLIENT NAME<small class="required-btn">*</small></label>
                                <div class="col-sm-7 col-md-8 col-lg-7 col-xl-8">
                                    <input type="text" name="name" id="name" class="required">
                                </div>
                            </div>
                            <!-- // group  -->
                            <div class="form-group">
                                <label class="control-label col-sm-5 col-md-4 col-lg-4 col-xl-3" for="email">CLIENT EMAIL ADDRESS<small class="required-btn">*</small></label>
                                <div class="col-sm-7 col-md-8 col-lg-7 col-xl-8"">
                                <input type="email" name="email" id="email" class="required email-input" >
                            </div>
                        </div>
                        <!-- // group  -->
                        <div class="form-group">
                            <label class="control-label col-sm-5 col-md-4 col-lg-4 col-xl-3" for="url">URL<small class="required-btn">*</small></label>
                            <div class="col-sm-7 col-md-8 col-lg-7 col-xl-8"">
                            <input type="text" name="url" id="url" class="required" >
                        </div>
                    </div>
                    <!-- // group  -->
                    <div class="form-group">
                        <label class="control-label col-sm-5 col-md-4 col-lg-4 col-xl-3" for="logo">LOGO</label>
                        <div class="col-sm-7 col-md-8 col-lg-7 col-xl-8">
                            <?php image_upload_element() ?>
                        </div>
                    </div>
                    <!-- // group  -->

            </div>
            <!-- // col form  -->
        </div>
        <!-- // row   -->

    </div>
    <!-- // form content  -->

    <h3>Text configuration for this client</h3>
    <div class="form-content">


        <div class="row">


            <div class="form-horizontal col-md-6">

                <div class="form-group">
                    <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="terms">TERMS<span class="requiredRed">*</span></label>
                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <textarea name="terms" id="terms" class="required" ></textarea>
                    </div>
                </div>
                <!-- // group  -->

            </div>
            <!-- // form left  -->

            <div class="form-horizontal col-md-6">

                <div class="form-group">
                    <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="not_found_message">NOT FOUND MESSAGE<small class="required-btn">*</small></label>
                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <textarea name="not_found_message"  class="required" id="not_found_message" ></textarea>
                    </div>
                </div>
                <!-- // group  -->
            </div>
            <!-- // form right  -->

        </div>
        <!-- // row -->

        <hr>

        <div class="row">

            <div class="form-horizontal col-md-6">

                <div class="form-group">
                    <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="exists_message">EXISTS MESSAGE<small class="required-btn">*</small></label>
                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <textarea name="exists_message" class="required" id="exists_message" ></textarea>
                    </div>
                </div>
                <!-- // group  -->

            </div>
            <!-- // form left  -->

            <div class="form-horizontal col-md-6">

                <div class="form-group">
                    <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="question">QUESTION<small class="required-btn">*</small></label>
                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <textarea name="question" id="question" class="required" ></textarea>
                    </div>
                </div>
                <!-- // group  -->
            </div>
            <!-- // form right  -->

        </div>
        <!-- // row -->

    </div>
    <!-- // form content  -->

    <h3>Admin user for this client</h3>
    <div class="form-content">

        <div class="row">

            <div class="form-horizontal col-md-6">

                <div class="form-group">
                    <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="first_name">First Name<small class="required-btn">*</small></label>
                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="text" name="first_name" id="first_name" class="required" >
                    </div>
                </div>
                <!-- // group  -->

            </div>
            <!-- // form left  -->

            <div class="form-horizontal col-md-6">

                <div class="form-group">
                    <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="last_name">Last Name</label>
                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="text" name="last_name" id="last_name" class="required" >
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
                    <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="password">Password</label>
                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="password" name="password" id="password" class="required">
                    </div>
                </div>
                <!-- // group  -->

            </div>
            <!-- // form left  -->

            <div class="form-horizontal col-md-6">

                <div class="form-group">
                    <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="confirm_password">Confirm Password</label>
                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="password" name="password_2" class="required" id="password_2" >
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
                    <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="user_email">Email Address</label>
                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="email" name="user_email" id="user_email" class="required email-input" >
                    </div>
                </div>
                <!-- // group  -->

            </div>
            <!-- // form left  -->

            <div class="form-horizontal col-md-6">

                <div class="form-group">
                    <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="user_phone">Phone</label>
                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="tel" name="phone" id="phone" onkeydown="javascript:backspacerDOWN(this,event);" onkeyup="javascript:backspacerUP(this,event);" class="required phone-input" >
                    </div>
                </div>
                <!-- // group  -->
            </div>
            <!-- // form right  -->

        </div>
        <!-- // row -->
    </div>
    <!-- // form content  -->

</div>
<!-- // accordion  -->

<div class="row" id="action-area">
    <div class="col-md-6">
        <button type="submit" class="save-setting-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
    </div>
    <div class="col-md-6">

    </div>
</div>
<!-- // action area -->

</form>
</div>
<!-- // app content   -->

<?php include 'footer.php'; ?>
<script type="text/javascript">
    prepare_for_validation(['name', 'email', 'url','terms','not_found_message','exists_message','question','first_name', 'last_name', 'password', 'password_2', 'user_email','phone'], 'add-new-client');
</script>