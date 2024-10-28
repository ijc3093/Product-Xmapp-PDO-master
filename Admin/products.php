<?php
    //var_dump($_GET);

    include('head.php');

   // var_dump($_SESSION);
    
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

        // echo "<script>alert('Delete from product ');</script>";
    }


  //delete venue
    if(isset($_GET['deleteVenue']) && ($_GET['id']) == 1){
        $db->admin_Delete("venue", $_GET['id'], "idvenue");
        $db->admin_Delete("product", $_GET['id'], "venue");
    }


    //delete session
    if(isset($_GET['deleteSession'])){
        //var_dump($_GET);
        $db->admin_Delete("session", $_GET['id'], "idsession");
    }

    // //attending product
    // if(isset($_GET['attendproduct'])){
    //     $db->attending_product($_GET['id'], $_SESSION['username']);
    // }

    // //attending session
    // if(isset($_GET['attendSession'])){
    //     $db->attending_Session($_GET['id'], $_SESSION['username']);
    // }

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
            <h6 class="m-0 font-weight-bold text-primary">product Table</h6>
        </div>
        <div class="card-body table table-striped table-dark">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <section class="text-center">
                        <div class="container">
                        <p>
                            <a href="insert_products.php" class="btn btn-primary my-2">Add New product</a>
                            <a href="#" class="btn btn-secondary my-2">Secondary action</a>
                        </p>
                        <!-- Table Head -->
                            <thead>
                                <?php
                                    if($_SESSION['userRole'] == 4){
                                        echo
                                        '<tr>
                                        <th class="th-sm">product ID</th>
                                        <th class="th-sm">Name</th>
                                        <th class="th-sm">Artist</th>
                                        <th class="th-sm">Year</th>
                                        <th class="th-sm">Role posted</th>
                                        <th class="th-sm">Posted Date</th>
                                        <th class="th-sm">Posted Time</th>
                                        <th class="th-sm">Detail</th></tr>';
                                    }else{
                                        echo
                                        '<tr>
                                        <th class="th-sm">product ID</th>
                                        <th class="th-sm">Name</th>
                                        <th class="th-sm">Artist</th>
                                        <th class="th-sm">Year</th>
                                        <th class="th-sm">Role posted</th>
                                        <th class="th-sm">Posted Date</th>
                                        <th class="th-sm">Posted Time</th>
                                        <th class="th-sm">Detail</th>
                                        <th class="th-sm">Edit</th>
                                        <th class="th-sm">Delete</th>
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
                                        <th>product ID</th>
                                        <th>Name</th>
                                        <th class="th-sm">Artist</th>
                                        <th class="th-sm">Year</th>
                                        <th class="th-sm">Role posted</th>
                                        <th class="th-sm">Posted Date</th>
                                        <th class="th-sm">Posted Time</th>
                                        <th class="th-sm">Detail</th></tr>';
                                    }else{
                                        echo
                                        '<tr>
                                        <th>product ID</th>
                                        <th>Name</th>
                                        <th class="th-sm">Artist</th>
                                        <th class="th-sm">Year</th>
                                        <th class="th-sm">Role posted</th>
                                        <th class="th-sm">Posted Date</th>
                                        <th class="th-sm">Posted Time</th>
                                        <th class="th-sm">Detail</th>
                                        <th class="th-sm">Edit</th>
                                        <th class="th-sm">Delete</th>
                                        </tr>';
                                    }
                                ?>
                            </tfoot>

                            <!-- Table Body -->
                            <tbody>
                                    <?php
                                        // echo 'session data: ';
                                        // var_dump($_SESSION);
                                        if(($_SESSION['userRole'] == 2) || ($_SESSION['userRole'] == 1)){

                                            $result = $db->get_Manager_products($_SESSION['id']);
                                            //var_dump($result);

                                            foreach($result as $post){
                                                
                                                echo'<tr>
                                                    <td>' . $post["idproduct"] . '</td>
                                                    <td>' . $post["name"] . ' </td>
                                                    <td>' . $post["artist"] . ' </td>
                                                    <td>' . $post["year"] . ' </td>
                                                    <td>' . $post["whoisposted"] . ' </td>
                                                    <td>' . $post["datepost"] . ' </td>
                                                    <td>' . $post["time"] . ' </td>';

                                                    
                                                    echo'<td>
                                                    <a type="button" class="btn btn-success" href="detail2.php?id=' . $post["idproduct"] . '">Detail</a>
                                                    </td>';

                                                    //user only that is not allowed to edit or delete this information
                                                    if($_SESSION['userRole'] == 4){
                                                        // echo'
                                                        //     <td>
                                                        //     <span class="table-remove"><label type="button" class="btn btn-success">Edit</label></span>
                                                        //     </td>';
                                                    }
                                                    else{
                                                        echo'
                                                        <td>
                                                        <span class="table-remove"><a type="button" class="btn btn-success" href="edit_product.php?id=' . $post["idproduct"] . '">Edit</a></span>
                                                        </td>';
                                                    }
                                                    if($_SESSION['userRole'] == 4){
                                                        // echo'
                                                        //     <td class="pt-3-half">
                                                        //     <span class="table-remove"><label type="button" class="btn btn-danger btn-rounded btn-sm my-0">Delete</label></span>
                                                        //     </td>';
                                                    }
                                                    else{
                                                        echo'<td class="pt-3-half">
                                                            <span class="table-remove"><a type="button" class="btn btn-danger btn-rounded btn-sm my-0" href="products.php?deleteproduct=true&id= ' . $post["idproduct"] . '">Delete</a></span>
                                                            </td>';
                                                    }
                                                echo'</tr>';
                                            }
                                        }// close get_Manager_products()  
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

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>