<?php
$page_name = "add-new-user.php";
include 'header.php';
?>

      <div id="main-content">

        <div id="branding-bar">
          <a href="#" id="open-side-menu"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
        </div>
        <!-- // brandig bar  -->

        <header id="main-header">
          <h1>Add New User</h1>
          <h2>Add new system user</h2>
        </header>
        <!-- // main header  -->
        
        <div id="clients-content">

            <div id="accordion-form">
              


              <h3>User Details</h3>
              <div class="form-content">

                <div class="row">

                  <div class="form-horizontal col-md-6">

                    <div class="form-group">
                      <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="email">First Name</label>
                      <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="text">
                      </div>
                    </div>
                    <!-- // group  -->                                     

                  </div>
                  <!-- // form left  -->

                  <div class="form-horizontal col-md-6">

                    <div class="form-group">
                      <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="email">Last Name</label>
                      <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="text">
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
                      <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="email">Password</label>
                      <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="password">
                      </div>
                    </div>
                    <!-- // group  -->                                     

                  </div>
                  <!-- // form left  -->

                  <div class="form-horizontal col-md-6">

                    <div class="form-group">
                      <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="email">Confirm Password</label>
                      <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="text">
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
                      <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="email">Email Address</label>
                      <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="email">
                      </div>
                    </div>
                    <!-- // group  -->                                     

                  </div>
                  <!-- // form left  -->

                  <div class="form-horizontal col-md-6">

                    <div class="form-group">
                      <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="email">Phone</label>
                      <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <input type="tel">
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
                      <label class="control-label col-sm-12 col-md-12 col-lg-3 col-xl-3" for="email">ROLE</label>
                      <div class="col-sm-12 col-md-12 col-lg-9 col-xl-8">
                        <select name="" id="" class="selectpicker">
                          <option value="">Select Role</option>
                          <option value="">Admin</option>
                          <option value="">Markeeter</option>
                          <option value="">Moderator</option>
                        </select>                        
                      </div>
                    </div>
                    <!-- // group  -->                                     

                  </div>
                  <!-- // form left  -->

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

        </div>
        <!-- // app content   -->

          <?php include 'footer.php'; ?>
          <script type="text/javascript">
              prepare_for_validation(['name', 'email', 'url' ], 'add-user-form');
          </script>