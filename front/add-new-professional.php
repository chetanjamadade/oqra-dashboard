<?php
$page_name = "add-new-professional.php";
include 'header.php';
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
                  <form action="<?php echo action_url(); ?>" method="POST" enctype="multipart/form-data" id="add-professional-form">
                  <?php hidden_action_inputs( 'add_professional' ); ?>

                <div class="row">

                  <div class="form-horizontal col-md-6">

                    <div class="form-group">
                      <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="full_name">Full Name<span class="requiredRed">*</span></label>
                      <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="text" name="full_name" class="required">
                      </div>
                    </div>
                    <!-- // group  -->                                     

                  </div>
                  <!-- // form left  -->

                  <div class="form-horizontal col-md-6">

                    <div class="form-group">
                      <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="address_professional">Address<span class="requiredRed">*</span></label>
                      <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="text" name="address_professional" class="required">
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
                      <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="email_professional">Email Address<span class="requiredRed">*</span></label>
                      <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="email" name="email_professional" class="required">
                      </div>
                    </div>
                    <!-- // group  -->                                     

                  </div>
                  <!-- // form left  -->

                  <div class="form-horizontal col-md-6">

                    <div class="form-group">
                      <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="phone_professional">Phone<span class="requiredRed">*</span></label>
                      <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="tel" name="phone" class="required phone-input" onkeydown="javascript:backspacerDOWN(this,event);" onkeyup="javascript:backspacerUP(this,event);">
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
                        <select name = 'location[]' class="selectpicker" data-live-search="true" multiple data-placeholder="Locations">
                            <?php echo location_select_box_for_user(); ?>
                      </div>
                    </div>
                    <!-- // group  -->                                     

                  </div>
                  <!-- // form left  -->

                  <div class="form-horizontal col-md-6">

                    <div class="form-group">
                      <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="img_professional">Image</label>
                      <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                          <?php image_upload_element(); ?>
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
                  <button type="submit" class="save-setting-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
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
    prepare_for_validation(['full_name', 'address_professional', 'email_professional', 'phone'], 'add-professional-form');

</script>
