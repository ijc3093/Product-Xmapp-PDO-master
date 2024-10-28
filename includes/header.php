<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>Sidebar left menu - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="../includes/style.css" rel="stylesheet">
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>


<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div id="wrapper" class="wrapper-content">
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li>
                <h1>
                    <a href="#">
                        Shopping 
                    </a>
                </h1>
            </li>
         
            <!-- general.php -->
            <li class="nav-item">
                <a class="nav-link" href="general.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>General</span></a>
            </li>

            <!-- list.php -->
            <li class="nav-item">
                <a class="nav-link" href="list.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>List</span></a>
            </li>

            <?php
                $userRole = $_SESSION['userRole'];
                if( empty($userRole) ){
                    echo "<script>alert('User Role is empty');</script>";
                }    

                //Admin
                //Notice that #1 is not in $_SESSION[...] and why? because if #1 is not there, it meant that #1 as Admin can access all nav in the left.
                //Notice that #2, 3, 4 are still in $_SESSION[...] and why? because that admin is not all any of the # to be access admin's page.
                if($userRole == 2 || $userRole == 3 || $userRole == 4){
                    // echo '<li class="nav-item">
                    // <label class="nav-link" href="admin.php">
                    // <span data-feather="file"></span>
                    // Admin 
                    // </label>
                    // </li>';
                }else{
                    // <!-- Divider -->
                    echo'
                    <hr class="sidebar-divider my-0">

                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Admin</span></a>
                    </li>';

                    //Nav Item - Pages Collapse Menu
                    echo'
                        <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                            aria-expanded="true" aria-controls="collapseTwo">
                            <i class="fas fa-fw fa-cog"></i>
                            <span>Authority Only</span>
                        </a>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="User/dashboard.php">Dashboard</a>
                                <a class="collapse-item" href="User/userlist.php">Users</a>
                                <a class="collapse-item" href="User/notification.php">Notification</a>
                            </div>
                        </div>
                        </li>';

                    // Nav Item - Utilities Collapse Menu 
                    echo'
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                                aria-expanded="true" aria-controls="collapseUtilities">
                                <i class="fas fa-fw fa-wrench"></i>
                                <span>Utilities</span>
                            </a>
                            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                                data-parent="#accordionSidebar">
                                <div class="bg-white py-2 collapse-inner rounded">
                                    <h6 class="collapse-header">Custom Utilities:</h6>
                                    <a class="collapse-item" href="utilities-color.html">Colors</a>
                                    <a class="collapse-item" href="utilities-border.html">Borders</a>
                                    <a class="collapse-item" href="utilities-animation.html">Animations</a>
                                    <a class="collapse-item" href="utilities-other.html">Other</a>
                                </div>
                            </div>
                        </li>';
                   

                    //Nav Item - Pages Collapse Menu
                    echo'
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                            aria-expanded="true" aria-controls="collapsePages">
                            <i class="fas fa-fw fa-folder"></i>
                            <span>Settings</span>
                        </a>
                        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Screens:</h6>
                                <a class="collapse-item" href="role.php">Role</a>
                                <a class="collapse-item" href="venue.php">Venue Location</a>
                                <a class="collapse-item" href="forgot-password.php">Forgot Password</a>
                                <div class="collapse-divider"></div>
                                <h6 class="collapse-header">Other Pages:</h6>
                                <a class="collapse-item" href="404.php">404 Page</a>
                                <a class="collapse-item" href="blank.php">Blank Page</a>
                            </div>
                        </div>
                    </li>';

                    //Nav Item - Charts
                    echo'
                        <li class="nav-item">
                            <a class="nav-link" href="charts.html">
                                <i class="fas fa-fw fa-chart-area"></i>
                                <span>Charts</span></a>
                        </li>';
                }

                //manager 
                //products.php
                if($userRole == 3 || $userRole == 4){
                    // echo '<li class="nav-item">
                    // <label class="nav-link" href="products.php">
                    // <span data-feather="shopping-cart"></span>
                    // products
                    // </label>
                    // </li>';
                }else{
                    echo '
                    <!-- Nav Item - Manager -->
                    <li class="nav-item">
                    <a class="nav-link" href="products.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Manager</span></a>
                    </li>';
                }


                //ntid
                //ntid.php
                if($userRole == 2 || $userRole == 4){
                // echo '<li class="nav-item">
                // <label class="nav-link" href="products.php">
                // <span data-feather="shopping-cart"></span>
                // products
                // </label>
                // </li>';
                }else{
                    echo '<!-- Nav Item - NTID -->
                    <li class="nav-item">
                    <a class="nav-link" href="ntid.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>NTID</span></a>
                    </li>';
                }

                //Registration
                //registrations.php
                if($userRole == 4){
                    // echo'<li class="nav-item">
                    // <label class="nav-link" href="registrations.php">
                    // <span data-feather="users"></span>
                    // Registrations 
                    // </label>
                    // </li>';
                }else{
                echo '<!-- Nav Item - Registrations -->
                <li class="nav-item">
                    <a class="nav-link" href="registrations.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Registrations</span></a>
                    </li>';
                }
            ?>

            <li class="nav-item">
                <a class="nav-link" href="login.php?logout=true">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Logout</span></a>
            </li>
        </ul>
    </div>


    <div id="page-content-wrapper">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button class="btn-menu btn btn-success btn-toggle-menu" type="button">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="ti-panel"></i>
        						<p>Stats</p>
                            </a>
                        </li>
        				<li>
                            <a href="#">
        						<i class="ti-settings"></i>
        						<p>Settings</p>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                            <p>
                                <?php 
                                    
                                    if($_SESSION['userRole'] == 1){
                                        echo "Admin";
                                    }
                                    else if($_SESSION['userRole'] == 2){
                                        echo "Manager";
                                    }

                                    else if($_SESSION['userRole'] == 3){
                                        echo "NTID";
                                    }
        
                                    else{
                                        echo "Attendee";
                                    }
                                        
                                ?>, 
                                <?php echo htmlentities($_SESSION['username']); ?>
                            </p>
                            </a>
                        </li>

                        <?php
                            $username = $_SESSION['username'];
                            $sql = "SELECT * from user where username = (:username);";
                            $query = $dbh -> prepare($sql);
                            $query-> bindParam(':username', $username, PDO::PARAM_STR);
                            $query->execute();
                            $result=$query->fetch(PDO::FETCH_OBJ);
                            $cnt=1;	
                        ?>
                        <img src="../Admin/<?php echo htmlentities($result->upload_image);?>" class="rounded-circle avatar-lg2 img-thumbnail2 mb-4" alt="profile-image">
                            
                    </ul>
        
                </div>
            </div>
        </nav>

    
    