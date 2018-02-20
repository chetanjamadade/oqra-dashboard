<?php
$page_name = "dashboard.php";
include 'header.php';
$id = ( isset($_SESSION["selected_client_id"]) && $_SESSION["selected_client_id"] > 0 ) ? $_SESSION["selected_client_id"] : 0;

if( $id > 0 && $client->exists( $id ) ) {

    $top_sattisfied_data = $client->get_top_sattisfied($id);
    $top_disatisfied_data = $client->get_top_disatisfied($id);
    $nor = $client->get_nor($id);

}
?>
      <div id="main-content">

        <div id="branding-bar">
          <a href="#" id="open-side-menu"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
        </div>
        <!-- // brandig bar  -->

        <header id="main-header">
          <h1>Overview</h1>
          <h2>Reviews summary</h2>
        </header>
        <!-- // main header  -->

        <div id="result-block">

            <div class="result-box">
              <a href="#">
                <span class="value"><?php echo $clients[0]->COUNT?></span>
                <p>Extremly <br> Sattisfied</p>
              </a>
            </div>
            <!-- // result box  -->

            <div class="result-box">
              <a href="#">
                <span class="value"><?php echo $clients[1]->COUNT?></span>
                <p>Very <br> Sattisfied</p>
              </a>
            </div>
            <!-- // result box  -->

            <div class="result-box">
              <a href="#">
                <span class="value"><?php echo $clients[2]->COUNT?></span>
                <p>Sattisfied</p>
              </a>
            </div>
            <!-- // result box  -->

            <div class="result-box">
              <a href="#">
                <span class="value"><?php echo $clients[3]->COUNT?></span>
                <p>Disatisfied</p>
              </a>
            </div>
            <!-- // result box  -->

            <div class="result-box">
              <a href="#">
                <span class="value"><?php echo $clients[4]->COUNT?></span>
                <p>Very <br> Disatisfied</p>
              </a>
            </div>
            <!-- // result box  -->        

            <div class="customer-score">
              <div class="customer-left">
                <p>Customer Satisfaction Score</p>
              </div>
              <!-- // left title  -->
              <div class="customer-right">
                <span class="total-score"><?php echo  $average ?></span>
                <small>based on <br> <strong><?php echo  $sum ?></strong></small>
              </div>
              <!-- // score  -->
              <div class="clearfix"></div>
            </div>
            <!-- // customer score  -->

            <div class="clearfix"></div>

        </div>
        <!-- // result block  -->

        <div class="clearfix"></div>

        <div class="top-results-box">
          <h4><img src="../img/ico/satisfied.png" alt=""><strong>Top 5 Satisfied </strong>Reviews</h4>

          <table width="100%" cellpadding="10" cellspacing="10">
            <tr>
              <th>Type</th>
              <th>Full Name</th>
              <th>Phone</th>
              <th>Rating</th>
              <th>Location</th>
              <th width="12%">Action</th>
            </tr>
              <?php if (is_array($top_sattisfied_data)){ ?>
              <?php foreach ($top_sattisfied_data as $top): ?>
            <tr>
              <td><a href="#" class="action-play"  data-toggle="tooltip" title="View"><i class="fa fa-play-circle" aria-hidden="true"></i></a></td>
              <td><p><?php echo $top->first_name_guest . $top->last_name_guest ?></p></td>
              <td><small><a href="#"><?php echo $top->phone_guest ?></a></small></td>
              <td><span class="rating-value <?php echo $top->icon ?>"><?php echo $top->rating ?></span></td>
              <td><span class="location-name"><?php echo $top->location_name ?></span></td>
              <td>
              <a href="#" class="action-view-btn" data-toggle="tooltip" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
              <a href="#" class="action-archive-btn" data-toggle="tooltip" title="Archive"><i class="fa fa-folder-open-o" aria-hidden="true"></i></a>
              </td>
            </tr>
              <?php endforeach;  ?>
              <?php } ?>
          </table>

          <footer>
            <a href="#" class="view-all-btn">View all</a>
            <small>No. of Reviews for Last Month <strong><?php echo $nor[0]->nor?></strong></small>
          </footer>

        </div>
        <!-- // top results box  -->

        <div class="top-results-box">
          <h4><img src="../img/ico/disatisfied.png" alt=""><strong>Top 5 Disatisfied </strong>Reviews</h4>

          <table width="100%" cellpadding="10" cellspacing="10">
            <tr>
              <th>Type</th>
              <th>Full Name</th>
              <th>Phone</th>
              <th>Rating</th>
              <th>Location</th>
              <th width="10%">Action</th>
            </tr>
              <?php if (is_array($top_disatisfied_data)){ ?>
              <?php foreach ($top_disatisfied_data as $top): ?>
                  <tr>
                      <td><a href="#" class="action-play"  data-toggle="tooltip" title="View"><i class="fa fa-play-circle" aria-hidden="true"></i></a></td>
                      <td><p><?php echo $top->first_name_guest . $top->last_name_guest ?></p></td>
                      <td><small><a href="#"><?php echo $top->phone_guest ?></a></small></td>
                      <td><span class="rating-value <?php echo $top->icon ?>"><?php echo $top->rating ?></span></td>
                      <td><span class="location-name"><?php echo $top->location_name ?></span></td>
                      <td>
                          <a href="#" class="action-view-btn" data-toggle="tooltip" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                          <a href="#" class="action-archive-btn" data-toggle="tooltip" title="Archive"><i class="fa fa-folder-open-o" aria-hidden="true"></i></a>
                      </td>
                  </tr>
              <?php endforeach;  ?>
              <?php }  ?>
          </table>

          <footer>
            <a href="#" class="view-all-btn">View all</a>
            <small>No. of Reviews for Last Month <strong><?php echo $nor[0]->nor ?></strong></small>
          </footer>

        </div>
        <!-- // top results box  -->

          <?php include 'footer.php'; ?>
