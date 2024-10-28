<?php
    //var_dump($_GET);
    
    include('head.php');
    

    include('Controller.php');
    $db = new Controller();

    // $_SESSION = array(); // destroy all session data
    // session_destroy(); // compelte erase session


    // if($_SESSION['userRole'] == "user" || !isset($_GET['id'])){
    //     echo '<script>window.location.replace("registrations.php");</script>';
    // }

    
    if($_SESSION['userRole'] == 2 || $_SESSION['userRole'] == 1){
        $result = $db->get_Manager_products(1);
        $allowed = false;
        foreach($result as $post){
            if($post['idproduct'] == $_GET['id']){
                $allowed = true;
            }
        }
        // if($allowed == false){
        //     echo '<script>window.location.replace("products.php");</script>';
        // }
    }

    //edit products
    if(isset($_GET['updated'])){

        //does  validation first
        $_POST['fullname'] = sanitize_input($_POST["fullname"]);
        $_POST['username'] = sanitize_input($_POST["username"]);
        $_POST['role'] = sanitize_input($_POST["role"]);
        $_POST['id'] = sanitize_input($_POST["id"]);

        //Date and Time
        date_default_timezone_set("America/New_York");
        $date = date("Y-m-d");
        $time = date("h:i:sa");

        //Upload Image
        $image_name = $_FILES['file']['name'];
        $file_temp = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        $uploadRegister="uploadRegister/".$image_name;

        if($file_size < 5242880){
            if(move_uploaded_file($file_temp, $uploadRegister)){
                try{
                    $location_image = $uploadRegister;
                }catch(PDOException $e){
                    echo $e->getMessage();
                }
            }
        }else{
            echo "Invalid file extension.";
        }

        //Role assigned by numbers
        if($_POST['role'] == 'Admin'){
            $role = 1;
        }
        else if($_POST['role'] == 'Manager'){
            $role = 2;
        }
        else if($_POST['role'] == 'NTID'){
            $role = 3;
        }
        else{
            $role = 4;
        }

        $hold = $db->update_User( 
            $_POST['username'], 
            $_POST['fullname'], 
            $location_image,
            $role,
            $_POST['id']
        );

        if($hold == true){
            echo "<script>alert('Data updated');</script>";
        }else{
            echo "<script>alert('Data fail to update. " . $hold ." ');</script>";
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
        header("location: http://127.0.0.1:8080/login.php");
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
        header("location: http://127.0.0.1:8080/products.php");
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
            <h6 class="m-0 font-weight-bold text-primary">Edit Role</h6>
        </div>
        <div class="card-body">
            
            <?php
                //Print all products tied to the manager or admin
                //var_dump($username);

                $post = $db->get_user($_GET['id'])[0]; 
                //var_dump($post);
                    //var_dump($post);
                    echo'<form enctype="multipart/form-data" action="edit_user.php?updated=true&id=' . $post["iduser"] . '" method="post" role="form">';
                    echo'<div>';

                    echo'
                    <label class="col-lg-5 col-form-label form-control-label">Role ID</label>
                    <div class="col-lg-5">
                    <input type="text" class="form-control" name="id"  value="' . $_GET["id"] . '" required><br>
                    </div>';

                    echo'
                    <label class="col-lg-5 col-form-label form-control-label">Image</label>
                    <div class="col-lg-5">
                        <img class="img-profile rounded-circle" src="../Admin/'. $post["upload_image"] . '" width="50" height="50">
                        <input type="file" name="file" class="form-control"><br>
                    </div>';

                    echo'
                    <label class="col-lg-5 col-form-label form-control-label">Full Name</label>
                    <div class="col-lg-5">
                    <input type="text" class="form-control" name="fullname" value="' . $post["fullname"] . '" required><br>
                    </div>';

                    echo'
                    <label class="col-lg-5 col-form-label form-control-label">Username</label>
                    <div class="col-lg-5">
                    <input type="text" class="form-control" name="username" value="' . $post["username"] . '" required><br>
                    </div>';

                    echo '<div class="col-lg-9">
                    <label class="col-lg-3 col-form-label form-control-label">Role</label>
                    </div><br>';
                        
                    
                    echo'<div class="col-lg-9">
                    <input class="form-check-input" type="radio" name="role" id="exampleRadios1" value="Admin" checked>';
                    if($post["role"] == 1){
                        echo 'checked';
                    }
                    echo'<label class="form-check-label" for="exampleRadios1">
                        Admin
                    </label>
                    </div>';

                    echo'<div class="col-lg-9">
                    <input class="form-check-input" type="radio" name="role" id="exampleRadios2" value="Manager">';
                    if($post["role"] == 2){
                        echo 'checked';
                    }
                    echo'<label class="form-check-label" for="exampleRadios2">
                        Manager
                    </label>
                    </div>';

                    echo'<div class="col-lg-9">
                    <input class="form-check-input" type="radio" name="role" id="exampleRadios3" value="NTID">';
                    if($post["role"] == 3){
                        echo 'checked';
                    }
                    echo'<label class="form-check-label" for="exampleRadios3">
                        NTID
                    </label></div>';

                    echo'<div class="col-lg-9">
                    <input class="form-check-input" type="radio" name="role" id="exampleRadios4" value="user">';
                    if($post["role"] == 4){
                        echo 'checked';
                    }
                    echo'<label class="form-check-label" for="exampleRadios4">
                        Attendee
                    </label></div>';

                    
                    echo '<div class="col-lg-9">
                    <a href="role.php?back=true" class="btn btn-secondary" class="form-control" value="Cancel" required>Back</a>
                    <input class="btn btn-success" type="submit" name="updated" class="form-control" value="Save Changes" required>&nbsp;';
                    echo'</div>';

                    echo'</div';
                                    
                    echo'<hr></form>';
                ?>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Footer -->
<?php 
    include('../includes/footer.php');
?>