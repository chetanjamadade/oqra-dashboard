<?php
$page_name = "users.php";
include '../header.php';
?>

      <div id="main-content">

        <div id="branding-bar">
          <a href="#" id="open-side-menu"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
        </div>
        <!-- // brandig bar  -->

        <header id="main-header">
          <h1>Users</h1>
          <h2>List of OQRA users</h2>
        </header>
        <!-- // main header  -->
        
        <div id="users-content">
        <div class="container-fluid">
          <div class="row">

            <div class="col-lg-8 col-xl-9">
              <div id="users-data">

                <table width="100%">
                  <tr>
                    <th>First Name</th>
                    <th>Last Name </th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th></th>
                    <th class="text-center" width="130px">Action</th>
                  </tr>

                  <tr>
                    <td><p>Reynaldo</p></td>
                    <td><p>Diaz</p></td>
                    <td><small>(210)224-1000</small></td>
                    <td><small>office@reydiazlaw.com</small></td>
                    <td><small>Admin</small></td>
                    <td class="text-center">
                      <a href="#" class="action-view-btn" data-toggle="tooltip" title="View User"><i class="fa fa-eye" aria-hidden="true"></i></a>
                      <a href="#" class="action-edit-btn" data-toggle="tooltip" title="Edit User"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    </td>
                  </tr>

                  <tr>
                    <td><p>Reynaldo</p></td>
                    <td><p>Diaz</p></td>
                    <td><small>(210)224-1000</small></td>
                    <td><small>office@reydiazlaw.com</small></td>
                    <td><small>Admin</small></td>
                    <td class="text-center">
                      <a href="#" class="action-view-btn" data-toggle="tooltip" title="View User"><i class="fa fa-eye" aria-hidden="true"></i></a>
                      <a href="#" class="action-edit-btn" data-toggle="tooltip" title="Edit User"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    </td>
                  </tr>

                  <tr>
                    <td><p>Reynaldo</p></td>
                    <td><p>Diaz</p></td>
                    <td><small>(210)224-1000</small></td>
                    <td><small>office@reydiazlaw.com</small></td>
                    <td><small>Admin</small></td>
                    <td class="text-center">
                      <a href="#" class="action-view-btn" data-toggle="tooltip" title="View User"><i class="fa fa-eye" aria-hidden="true"></i></a>
                      <a href="#" class="action-edit-btn" data-toggle="tooltip" title="Edit User"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    </td>
                  </tr>

                  <tr>
                    <td><p>Reynaldo</p></td>
                    <td><p>Diaz</p></td>
                    <td><small>(210)224-1000</small></td>
                    <td><small>office@reydiazlaw.com</small></td>
                    <td><small>Admin</small></td>
                    <td class="text-center">
                      <a href="#" class="action-view-btn" data-toggle="tooltip" title="View User"><i class="fa fa-eye" aria-hidden="true"></i></a>
                      <a href="#" class="action-edit-btn" data-toggle="tooltip" title="Edit User"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    </td>
                  </tr>

                  <tr>
                    <td><p>Reynaldo</p></td>
                    <td><p>Diaz</p></td>
                    <td><small>(210)224-1000</small></td>
                    <td><small>office@reydiazlaw.com</small></td>
                    <td><small>Admin</small></td>
                    <td class="text-center">
                      <a href="#" class="action-view-btn" data-toggle="tooltip" title="View User"><i class="fa fa-eye" aria-hidden="true"></i></a>
                      <a href="#" class="action-edit-btn" data-toggle="tooltip" title="Edit User"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    </td>
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
              <aside id="sidebar-actions">

                <div id="filter-box">
                  <header>
                    <h4><i class="fa fa-search" aria-hidden="true"></i> <strong>Filter</strong> users</h4>
                  </header>
                  <div class="filter-content">

                    <select name="" id="" class="selectpicker">
                      <option value="">User Type</option>
                      <option value="">All</option>
                      <option value="">Admin</option>
                      <option value="">Marketeer</option>
                    </select>

                    <input type="submit" value="Get Results">
                  </div>
                </div>
                <!-- // filter box  -->              

                <span class="result-num"><strong>21</strong> Users</span>

                <a href="#" class="add-new-btn"><i class="fa fa-user-plus" aria-hidden="true"></i> Add New User</a>
                
              </aside>
            </div>
            <!-- // actions  -->

          </div>
          <!-- // row  -->
          </div>

        </div>
        <!-- // app content      -->

<?php include '../footer.php'; ?>