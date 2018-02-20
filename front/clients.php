<?php
    $page_name = "clients.php";
    include 'header.php';
?>

      <div id="main-content">

        <div id="branding-bar">
          <a href="#" id="open-side-menu"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
        </div>
        <!-- // brandig bar  -->

        <header id="main-header">
          <h1>Clients</h1>
          <h2>List of OQRA clients</h2>
        </header>
        <!-- // main header  -->
        
        <div id="clients-content">
        <div class="container-fluid">
          <div class="row"  id="app-table">

            <div class="col-lg-8 col-xl-9">
              <div id="clients-data">

                <div class="ajax-location-table">
                   <?php echo get_clients_table(); ?>
                </div>
                
              </div>
            </div>
            <!-- // locations  -->

            <div class="col-lg-4 col-xl-3">
              <aside id="sidebar-actions">

                <span class="result-num"><strong><?php echo($client->total)?></strong> Clients</span>

                <a href="add-new-client.php" class="add-new-btn"><i class="fa fa-user-plus" aria-hidden="true"></i> Add New Client</a>
                  <a href="archived-clients.php" class="add-new-btn"><i class="fa fa-user-plus" aria-hidden="true"></i> Archived Clients</a>
                
              </aside>
            </div>
            <!-- // actions  -->

          </div>
          <!-- // row  -->
          </div>

        </div>
        <!-- // app content      -->
          <?php print_archive_modal( 'client' ); ?>
          <?php include 'footer.php'; ?>

