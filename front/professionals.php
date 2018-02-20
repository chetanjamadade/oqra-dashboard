<?php
$page_name = "professionals.php";
include 'header.php';
?>


      <div id="main-content">

        <div id="branding-bar">
          <a href="#" id="open-side-menu"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
        </div>
        <!-- // brandig bar  -->

        <header id="main-header">
          <h1>Professionals</h1>
          <h2>List of OQRA professionals</h2>
        </header>
        <!-- // main header  -->
        
        <div id="clients-content">
        <div class="container-fluid">
          <div class="row">

            <div class="col-lg-8 col-xl-9">
              <div id="clients-data">

                  <div class="ajax-professional-table">
                      <?php echo get_professionals_table(1,10,1,"",$_SESSION["logged-user"]->id); ?>
                  </div>
              </div>
            </div>
            <!-- // locations  -->

            <div class="col-lg-4 col-xl-3">
              <aside id="sidebar-actions">

                <span class="result-num"><strong> <?php echo $professional->total ?></strong> Professionals</span>

                  <?php if($current_user->role_id == 1 ):?>
                    <a href="add-new-professional.php" class="add-new-btn"><i class="fa fa-user-plus" aria-hidden="true"></i> Add New Professional</a>
                  <?php endif; ?>
                  <a href="archived-professionals.php" class="add-new-btn"><i class="fa fa-user-plus" aria-hidden="true"></i> Archived Professionals</a>

              </aside>
            </div>
            <!-- // actions  -->

          </div>
          <!-- // row  -->
          </div>

        </div>
        <!-- // app content      -->

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



    <?php print_archive_modal( 'professional' ); ?>

    <?php include 'footer.php'; ?>