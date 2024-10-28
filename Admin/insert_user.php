<?php
    
    include('head.php');

    require('Controller.php');
   
    $db = new Controller();


    if(isset($_GET['nextLogin'])){

       //does  validation first
       $_POST['username'] = sanitize_input($_POST["username"]);
       $_POST['password'] = sanitize_input($_POST["password"]);
       $_POST['id'] = sanitize_input($_POST["id"]);


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
        echo "saving data";

        // var_dump($db);

        //Insert all data into database system
        $result = $db->insertRegister_User(
            $_POST['username'], 
            $_POST['password'], 
            $_POST['fullname'], 
            $location_image,
            $date,
            $time,
            $role,
            $_POST['email']
        );

        // var_dump($result);
        // exit(0);
        if( $result == 1 ){
          header("location: login.php");
        }
        else{
          echo 'failed';
        }
    }


    // does sanitization second
    function sanitize_input( $value){
      $value = trim($value);
      $value = stripslashes($value);
      $value = htmlspecialchars($value);
      return $value;
    }

    //logout button
    if(isset($_GET['logout'])){
        logout();
    }

    //destory the session to the login local (index)
    function logout(){
        //session_destory();
        header("location: login.php");
        exit();
    }

?>

<!-- Head -->
<?php 
    include('../includes/header.php');
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add New Role</h6>
            </div>
            <div class="card-body table table-striped table-dark">
            <div class="card-body">
                <div class="table-responsive">
                <?php
                    //Role and Password
                    echo'<form enctype="multipart/form-data" class="user" id="createAccountFor" action="register.php?nextLogin=true" class="form-signin" method="post">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="username" class="form-control form-control-user" id="username" name="username" placeholder="Username" required autofocus>
                        </div>
                        <div class="col-sm-6">
                            <input type="password" id="password" class="form-control form-control-user" name="password" placeholder="Password" required">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <input type="text" class="form-control form-control-user" id="fullname" name="fullname" placeholder="Full Name" required autofocus>
                        </div>

                        <div class="col-sm-6">
                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Email" required autofocus>
                        </div>
                    </div>';

                    // //Email Address
                    // echo'
                    // <div class="form-group">
                    //     <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                    //         placeholder="Email Address">
                    // </div>';

                    // //Password
                    // echo'
                    // <div class="form-group row">
                    //     <div class="col-sm-6 mb-3 mb-sm-0">
                    //         <input type="password" class="form-control form-control-user"
                    //             id="exampleInputPassword" placeholder="Password">
                    //     </div>
                    //     <div class="col-sm-6">
                    //         <input type="password" class="form-control form-control-user"
                    //             id="exampleRepeatPassword" placeholder="Repeat Password">
                    //     </div>
                    // </div>
                    // ';

                    //form Checker
                    echo '<div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="exampleRadios1" value="Admin" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        Admin
                    </label>
                    </div>

                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="exampleRadios2" value="Manager">
                    <label class="form-check-label" for="exampleRadios2">
                        Manager
                    </label>
                    </div>

                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="exampleRadios3" value="NTID">
                    <label class="form-check-label" for="exampleRadios3">
                        NTID
                    </label>
                    </div>

                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="exampleRadios4" value="Attendee">
                    <label class="form-check-label" for="exampleRadios4">
                        Attendee
                    </label>
                    
                    </div><br>';


                    //Upload Image
                    echo'<div class="form-group row">
                    <div class="col-sm-6">
                    <input type="file" name="file" required="required"/><br>
                    </div>
                    </div>';

                    //Create New Role
                    echo '<button class="btn btn-primary btn-user btn-block" type="submit"value="Register">Create New Role</button></br></form>';
                ?>
                </div>
            </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
<!-- /.container-fluid -->

<!-- foot -->
<?php 
    include('../includes/footer.php');
?>