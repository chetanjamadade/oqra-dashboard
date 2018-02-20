<?php
$page_name = "logs.php";
include 'header.php';
?>

      <div id="main-content">

        <div id="branding-bar">
          <a href="#" id="open-side-menu"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
        </div>
        <!-- // brandig bar  -->

        <header id="main-header">
          <h1>Locations</h1>
          <h2>Reviews summary</h2>
        </header>
        <!-- // main header  -->
        
        <div id="logs-content">
        <div class="container-fluid">
          <div class="row">

            <div class="col-lg-8 col-xl-9">
              <div id="logs-data">

                <table width="100%">
                  <tr>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Ip Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Country</th>
                    <th class="text-center">Action</th>
                  </tr>
                  <tr>
                    <td><p><a href="#">root@dmsapiens.com </a></p></td>
                    <td><small>05/15/2016 09:05:AM</small></td>
                    <td><small>178.149.177.155 </small></td>
                    <td><small>Sabac</small></td>
                    <td><small>N/A</small></td>
                    <td><small>Serbia</small></td>
                    <td class="text-center"><a href="#" class="action-view-btn" data-toggle="tooltip" title="View Log"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                  </tr>

                  <tr>
                    <td><p><a href="#">root@dmsapiens.com </a></p></td>
                    <td><small>05/15/2016 09:05:AM</small></td>
                    <td><small>178.149.177.155 </small></td>
                    <td><small>Sabac</small></td>
                    <td><small>N/A</small></td>
                    <td><small>Serbia</small></td>
                    <td class="text-center"><a href="#" class="action-view-btn" data-toggle="tooltip" title="View Log"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                  </tr>

                  <tr>
                    <td><p><a href="#">root@dmsapiens.com </a></p></td>
                    <td><small>05/15/2016 09:05:AM</small></td>
                    <td><small>178.149.177.155 </small></td>
                    <td><small>Sabac</small></td>
                    <td><small>N/A</small></td>
                    <td><small>Serbia</small></td>
                    <td class="text-center"><a href="#" class="action-view-btn" data-toggle="tooltip" title="View Log"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                  </tr>

                  <tr>
                    <td><p><a href="#">root@dmsapiens.com </a></p></td>
                    <td><small>05/15/2016 09:05:AM</small></td>
                    <td><small>178.149.177.155 </small></td>
                    <td><small>Sabac</small></td>
                    <td><small>N/A</small></td>
                    <td><small>Serbia</small></td>
                    <td class="text-center"><a href="#" class="action-view-btn" data-toggle="tooltip" title="View Log"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                  </tr>

                  <tr>
                    <td><p><a href="#">root@dmsapiens.com </a></p></td>
                    <td><small>05/15/2016 09:05:AM</small></td>
                    <td><small>178.149.177.155 </small></td>
                    <td><small>Sabac</small></td>
                    <td><small>N/A</small></td>
                    <td><small>Serbia</small></td>
                    <td class="text-center"><a href="#" class="action-view-btn" data-toggle="tooltip" title="View Log"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                  </tr>                                                                        
                                                                      
                </table>

                <div id="pagination-block">
                  <ul>
                    <li><a href="#" class="prev"><<</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#" class="current">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#" class="next">>></a></li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <!-- // pagi block  -->
                
              </div>
            </div>
            <!-- // locations  -->

            <div class="col-lg-4 col-xl-3">
              <aside id="logs-actions">

                <div id="filter-box">
                  <header>
                    <h4><i class="fa fa-search" aria-hidden="true"></i> <strong>Filter</strong> logins</h4>
                  </header>
                  <div class="filter-content">

                    <select name="" id="" class="selectpicker">
                      <option value="">Select country</option>
                      <option value="">USA</option>
                      <option value="">AUE</option>
                      <option value="">France</option>
                    </select>

                    <select name="" id="" class="selectpicker">
                      <option value="">Select Client</option>
                      <option value="">IFWH</option>
                      <option value="">Gonzaba</option>
                      <option value="">Dr Koneru</option>
                    </select>

                    <input type="date" placeholder="Select Date">
                    <input type="submit" value="List logs">
                  </div>
                </div>
                <!-- // filter box  -->
                
              </aside>
            </div>
            <!-- // actions  -->

          </div>
          <!-- // row  -->
          </div>

        </div>
        <!-- // app content      -->

<?php include 'footer.php'; ?>