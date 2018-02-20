                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                    <li<?php if(basename($_SERVER['PHP_SELF']) == 'dashboard.php') echo ' class="active-menu"';?>>
                    <a href="dashboard.php"><i class="fa fa-list"></i><small>Overview</small></a></li>

                    <li<?php if(basename($_SERVER['PHP_SELF']) == 'locations.php') echo ' class="active-menu"';?>>
                    <a href="locations.php"><i class="fa fa-map-marker"></i><small>Locations</small></a></li>

                        <?php if( $current_user->role_id == 1 ): ?>

                            <li<?php if(basename($_SERVER['PHP_SELF']) == 'clients.php') echo ' class="active-menu"';?>>
                                <a href="clients.php"><i class="fa fa-user"></i><small>Clients</small></a></li>
                        <?php endif; ?>
                        <?php if( $current_user->role_id == 1 or ($current_user ->role_id==2 and $_SESSION["NOP"]>0)): ?>
                        <li<?php if(basename($_SERVER['PHP_SELF']) == 'professionals.php') echo ' class="active-menu"';?>>
                            <a href="professionals.php"><i class="fa fa-users"></i><small>Professionals</small></a></li>
                        <?php endif; ?>
                        <li<?php if(basename($_SERVER['PHP_SELF']) == 'marketing.php') echo ' class="active-menu"';?>>
                            <a href="marketing.php"><i class="fa fa-bar-chart"></i><small>Marketing</small></a></li>

                        <li<?php if(basename($_SERVER['PHP_SELF']) == 'reporting.php') echo ' class="active-menu"';?>>
                            <a href="reporting.php"><i class="fa fa-file-text-o"></i><small>Reporting</small></a></li>

                        <li<?php if(basename($_SERVER['PHP_SELF']) == 'settings.php') echo ' class="active-menu"';?>>
                            <a href="settings.php"><i class="fa fa-cog"></i><small>Settings</small></a></li>

                        <li<?php if(basename($_SERVER['PHP_SELF']) == 'tutorials.php') echo ' class="active-menu"';?>>
                            <a href="tutorials.php"><i class="fa fa-file-video-o"></i><small>Tutorials</small></a></li>

                        <li<?php if(basename($_SERVER['PHP_SELF']) == 'help.php') echo ' class="active-menu"';?>>
                            <a href="help.php"><i class="fa fa-question-circle"></i><small>Help</small></a></li>

                    </ul>
                </div>
                <!-- // main nav  -->