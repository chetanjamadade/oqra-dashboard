<?php
$page_name = "locations.php";
include 'header.php';
?>

    <div id="main-content">

    <div id="branding-bar">
        <a href="#" id="open-side-menu"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
    </div>
    <!-- // brandig bar  -->

    <header id="main-header">
        <h1>Archived Locations</h1>
        <h2>Reviews summary</h2>
    </header>
    <!-- // main header  -->

    <div id="location-content">
        <div class="container-fluid">
            <div class="row"  id="app-table">

                <div class="col-lg-8 col-xl-9">
                    <div id="locations-data">
                        <div class="ajax-location-table">
                            <?php echo get_locations_table(1,10,0); ?>
                        </div>

                    </div>
                </div>
                <!-- // locations  -->

                <div class="col-lg-4 col-xl-3">
                    <aside id="sidebar-actions">

                        <span class="result-num"><strong><?php echo($location->total)?></strong> Location</span>

                         <a href="locations.php" class="add-new-btn"><i class="fa fa-map-marker" aria-hidden="true"></i> View All Locations</a>

                    </aside>
                </div>
                <!-- // actions  -->

            </div>
            <!-- // row  -->
        </div>

    </div>
    <!-- // app content      -->
<?php print_activate_modal( 'location' ); ?>
<?php print_remove_modal('location'); ?>
<?php include 'footer.php'; ?>