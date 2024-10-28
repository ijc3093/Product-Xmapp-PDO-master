<?php
    //var_dump($_GET);

    include('head.php');
    

    include('Controller.php');
    $db = new Controller();

    // $_SESSION = array(); // destroy all session data
    // session_destroy(); // compelte erase session


    // if($_SESSION['userRole'] == "attendee" || !isset($_GET['id'])){
    //     echo '<script>window.location.replace("registrations.php");</script>';
    // }

    
    $allowed = false;
    if($_SESSION['userRole'] == 2 || $_SESSION['userRole'] == 1){
        $result = $db->get_Manager_products($_SESSION['userRole']);
        
        foreach($result as $post){
            if($post['idproduct'] == $_GET['id']){
                $allowed = true;
                break;
            }
        }
        
    }

    //edit venue
    if(isset($_POST['edit'])){

        //does  validation first
        $_POST['name'] = sanitize_input($_POST["name"]);
        $_POST['product'] = sanitize_input($_POST["product"]);
        $_POST['id'] = sanitize_input($_POST["id"]);

        $hold = $db->update_Venue(
            $_POST['name'], 
            $_POST['product'], 
            $_POST['id']
        );
        if($hold == true){
            echo "<script>alert('Data updated');</script>";
        }else{
            echo "<script>alert('Data failed to update');</script>";
        }
        //var_dump($_POST);
    }

    // does sanitization second
    function sanitize_input( $value){
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    //delete product
    if(isset($_GET['deleteproduct'])){
        $db->admin_Delete("product", $_GET['id'], "idproduct");
        $db->admin_Delete("session", $_GET['id'], "product");
        echo '<script>window.location.replace("products.php");</script>';
    }

  
    //logout button
    if(isset($_GET['logout'])){
        logout();
    }

    //destory the admin to the login local
    function logout(){
        //$_SESSION = array(); // destroy all venue data
        session_destroy(); // compelte erase venue
        //header("location: http://serenity.ist.rit.edu/~ijc3093/ISTE-341/Project1/login.php");
        header("location: login.php");
        exit();
    }

    //logout button
    if(isset($_GET['back'])){
        back();
    }


    function back(){
        //$_SESSION = array(); // destroy all venue data
        session_destroy(); // compelte erase venue
        //header("location: http://serenity.ist.rit.edu/~ijc3093/ISTE-341/Project1/product.php");
        header("location: venue.php");
        exit();
    }
?>

<!-- Header -->
<?php 
    include('../includes/header.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Venue</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php
                    //Print all products tied to the manager or admin
                    //var_dump($username);

                    $post = $db->get_Venue($_GET['id']); 

                    echo'<form action="" method="post" role="form">';

                        echo'<div>';
                            
                                echo'
                                <label class="col-lg-5 col-form-label form-control-label">ID</label>
                                <div class="col-lg-5">
                                <input type="text" class="form-control" name="id"  value="' . $_GET["id"] . ' " required><br>
                                </div> ';

                                echo'
                                <label class="col-lg-5 col-form-label form-control-label">Name</label>
                                <div class="col-lg-5">
                                <input type="text" class="form-control" name="name" value="' . $post["name"] . '" required><br>
                                </div>';
            

                                echo'
                                <label class="col-lg-5 col-form-label form-control-label">Capacity</label>
                                <div class="col-lg-5">
                                <input type="text" class="form-control" name="product" value="' . $post["capacity"] . '" required><br>
                                </div>';

                                
                                echo '<div class="col-lg-5">
                                <a href="venue.php?back=true" class="btn btn-secondary" class="form-control" value="Cancel" required>Back</a></div>
                                <div class="col-lg-5">
                                <input class="btn btn-success" href="products.php?back=true" type="submit" name="edit" class="form-control" value="Save Changes" required>&nbsp;';
                                echo'</div>';

                        echo'</div';
                                    
                    echo'<hr></form>';
                ?>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Footer -->
<?php 
    include('../includes/footer.php');
?>