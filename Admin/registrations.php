<!-- Header -->
<?php 
    session_start();
    //include('validate.php');
    //var_dump($_GET);

    //include('head.php');
    
    //var_dump($_SESSION);
    require('controller.php');
    
    $db = new Controller();

  
    // if(isset($_GET['delete_product'])){
    //   //print_r($_POST);
    //   $db->delete("attendee_product", $_GET['id'], "product");
    // }


    // if(isset($_GET['delete_Session'])){
    //     //print_r($_POST);
    //     $db->delete("attendee_session", $_GET['id'], "session");
    // }

    //logout button
    if(isset($_GET['logout'])){
        logout();
    }

    //destory the admin to the login local
    function logout(){
    //$_SESSION = array(); // destroy all venue data
    session_destroy(); // compelte erase venue
    setcookie("login","",time()-1);//for delete the cookie //destroy the cookie
    header("location: login.php");
    exit();
    }

    //When you want to create new page, make sure that this page of attendee as role need to be next 5. 
    if($_SESSION['userRole'] == 4){
      header("location: products.php");
    }
?>

<!-- Head -->
<?php 
    include('../includes/header.php');
?>
<div class="wrapper">
    <div class="container">

        <div class="wraper">
            <div class="row">
                <div class="col-sm-12">
                    <div class="bg-picture text-center">
                        <div class="bg-picture-overlay"></div>
                        <div class="profile-info-name">
                        <?php
                            $username = $db->userRole();
                        ?>
                        <img src="../Admin/<?php echo htmlentities($result->upload_image);?>" class="rounded-circle avatar-lg img-thumbnail mb-4" alt="profile-image">
                            <h2 class="text-white">Hi, <?php echo htmlentities($_SESSION['username']);?></h2>
                            <h2 class="text-white">Role: 
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
                                        
                                ?>
                            </h2>
                            <a href="change-password.php" class="btn btn-warning">Change Your Password</a>
                            <!-- <h2 class="text-white"><?php echo htmlentities($_SESSION['fname']);?></h2> -->
                        </div>
                    </div>
                    <!--/ meta -->
                </div>
            </div>
            
            
        </div>
        <!-- end container -->
    </div>
    <!-- end wrapper -->
</div>


    </div>

    <!-- Footer -->
<?php 
    include('../includes/footer.php');
?>
