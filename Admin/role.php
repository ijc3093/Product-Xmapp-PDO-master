<?php
   //var_dump($_GET);

    include('head.php');

    // $_SESSION = array(); // destroy all session data
    // session_destroy(); // compelte erase session
    include('Controller.php');
    $db = new Controller();

  //delete data from product
    if(isset($_GET['deleteAttendingproduct'])){
        $db->Delete("user_product", $_GET['id'], "product");
    }

  //delete data from session
    if(isset($_GET['deleteAttendingSession'])){
        $db->Delete("user_session", $_GET['id'], "session");
    }

  //delete product
    if(isset($_GET['deleteproduct'])){
        $db->admin_Delete("product", $_GET['id'], "idproduct");
        $db->admin_Delete("session", $_GET['id'], "product");
    }

    //deleteUser
    if(isset($_GET['deleteUser']) && !($_GET['id'] == 1)){
        $db->admin_Delete("user", $_GET['id'], "iduser");
    }

  //delete venue
    if(isset($_GET['deleteVenue']) && ($_GET['id']) == 1){
        $db->admin_Delete("venue", $_GET['id'], "idvenue");
        $db->admin_Delete("product", $_GET['id'], "venue");
    }


    //delete session
    if(isset($_GET['deleteSession'])){
        $db->admin_Delete("session", $_GET['id'], "idsession");
    }

    //attending product
    if(isset($_GET['attendproduct'])){
        $db->attending_product($_GET['id'], $_SESSION['username']);
    }

    //attending session
    if(isset($_GET['attendSession'])){
        $db->attending_Session($_GET['id'], $_SESSION['username']);
    }

    //logout button
    if(isset($_GET['logout'])){
        logout();
    }

    //destory the admin to the login local
    function logout(){
        //$_SESSION = array(); // destroy all venue data
        session_destroy(); // compelte erase venue
        header("location: login.php");
        exit();
    }


    if($_SESSION['userRole'] == "manager" || $_SESSION['userRole'] == "user"){
        echo '<script>window.location.replace("registrations.php");</script>';
    }


    if($_SESSION['userRole'] == 2){
        echo '<script>window.location.replace("registrations.php");</script>';
    }

    // if($_SESSION['userRole'] == 3){
    //     echo '<script>window.location.replace("registrations.php");</script>';
    // }

    if($_SESSION['userRole'] == 4){
        echo '<script>window.location.replace("product.php");</script>';
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
            <h6 class="m-0 font-weight-bold text-primary">Role Table</h6>
        </div>
        <div class="card-body table table-striped table-dark">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">

                    <section class="text-center">
                        <div class="container">
                            <!-- <h1 class="jumbotron-heading">Album example</h1>
                            <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don't simply skip over it entirely.</p>
                             -->
                            <p>
                                <a href="insert_user.php" class="btn btn-primary my-2">Add New Role</a>
                                <a href="#" class="btn btn-secondary my-2">Secondary action</a>
                            </p>

                            
                            <!-- Table Head -->
                            <thead>
                                <?php
                                    if($_SESSION['userRole'] == 4){
                                        echo
                                        '<tr>
                                        <th class="th-sm">Role ID</th>
                                        <th class="th-sm">Image</th>
                                        <th class="th-sm">Full Name</th>
                                        <th class="th-sm">Username</th>
                                        <th class="th-sm">Date</th>
                                        <th class="th-sm">Time</th>
                                        <th class="th-sm">Role</th>
                                        <th class="th-sm">Edit</th>
                                        <th class="th-sm">Delete Date</th></tr>';
                                    }else{
                                        echo
                                        '<tr>
                                        <th class="th-sm">Role ID</th>
                                        <th class="th-sm">Image</th>
                                        <th class="th-sm">Full Name</th>
                                        <th class="th-sm">Username</th>
                                        <th class="th-sm">Date</th>
                                        <th class="th-sm">Time</th>
                                        <th class="th-sm">Role</th>
                                        <th class="th-sm">Edit</th>
                                        <th class="th-sm">Delete Date</th>
                                        </tr>';
                                    }
                                ?>
                            </thead>

                            <!-- Table Footer -->
                            <tfoot>
                                <?php
                                    if($_SESSION['userRole'] == 4){
                                        echo
                                        '<tr>
                                        <th class="th-sm">Role ID</th>
                                        <th class="th-sm">Image</th>
                                        <th class="th-sm">Full Name</th>
                                        <th class="th-sm">Username</th>
                                        <th class="th-sm">Date</th>
                                        <th class="th-sm">Time</th>
                                        <th class="th-sm">Role</th>
                                        <th class="th-sm">Edit</th>
                                        <th class="th-sm">Delete Date</th></tr>';
                                    }else{
                                        echo
                                        '<tr>
                                        <th class="th-sm">Role ID</th>
                                        <th class="th-sm">Image</th>
                                        <th class="th-sm">Full Name</th>
                                        <th class="th-sm">Username</th>
                                        <th class="th-sm">Date</th>
                                        <th class="th-sm">Time</th>
                                        <th class="th-sm">Role</th>
                                        <th class="th-sm">Edit</th>
                                        <th class="th-sm">Delete Date</th>
                                        </tr>';
                                    }
                                ?>
                            </tfoot>

                            <!-- Table Body -->
                            <tbody>
                                    <?php
                                        $result = $db->get_users();
                                        foreach($result as $post){
                                            echo'<tr>
                                                    <td class="pt-3-half" contenteditable="true">'
                                                    . $post["iduser"] . 
                                                    '</td>
            
                                                    <td class="pt-3-half" contenteditable="true">
                                                    <img class="img-profile rounded-circle" src="../Admin/'. $post["upload_image"] . '" width="50" height="50">
                                                    </td>
                                                    
                                                    <td class="pt-3-half" contenteditable="true"> '. $post["fullname"] . '
                                                    </td> 

                                                    <td class="pt-3-half" contenteditable="true"> '. $post["username"] . '
                                                    </td>

                                                    <td class="pt-3-half" contenteditable="true"> '. $post["date"] . '
                                                    </td>
                                                    
                                                    <td class="pt-3-half" contenteditable="true"> '. $post["time"] . '
                                                    </td>';
                                                
                                            echo'
                                                    <td class="pt-3-half">';
                                                        if($post['role'] == 1){
                                                            echo '<input class="form-control" name="role" type="role" value="Admin" />';
                                                        }
                                                        else if($post['role'] == 2){
                                                            echo '<input class="form-control" name="role" type="role" value="Manager" />';
                                                        }
            
                                                        else if($post['role'] == 3){
                                                            echo '<input class="form-control" name="role" type="role" value="NTID" />';
                                                        }
                            
                                                        else{
                                                            echo '<input class="form-control" name="role" type="role" value="user" />';
                                                        }
                                            echo'
                                                    </td>';
            
            
            
            
                                                //Admin's super
                                                if($_SESSION['userRole'] == 1 || $_SESSION['userRole'] == 2 || $_SESSION['userRole'] == 3){
                                                    echo'
                                                        <td>
                                                            <span class="table-remove"><a type="button" class="btn btn-success" href="edit_user.php?id=' 
                                                            .$post["iduser"]. '">Edit</a>&nbsp;</span>
                                                        </td>';
            
                                                    echo'
                                                        <td>
                                                            <span class="table-remove"><a type="button" class="btn btn-danger" href="role.php?deleteUser=true&id=' 
                                                            .$post["iduser"]. 
                                                            '">Delete</a>&nbsp;</span>
                                                        </td>';
                                                        
                                                }else{
                                                    echo'
                                                        <td>
                                                            <span class="table-remove"><a type="button" class="btn btn-success" href="edit_user.php?id=' 
                                                            .$post["iduser"]. 
                                                            '" disabled>Edit</a>&nbsp;</span>
                                                        </td>';
            
            
                                                    echo'
                                                        <td>
                                                            <span class="table-remove"><a type="button" class="btn btn-danger" href="role.php?deleteUser=true&id=' 
                                                            .$post["iduser"]. '
                                                            "disabled>Delete</a>&nbsp;</span>
                                                        </td>';
                                                } 
                                                echo' 
                                                </tr>';
                                        }// close get_products()  
                                    ?>
                            </tbody>
                        </div>
                    </section>
                    
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- foot -->
<?php 
    include('../includes/footer.php');
?>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>