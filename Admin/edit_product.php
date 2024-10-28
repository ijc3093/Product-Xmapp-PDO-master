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
        $result = $db->get_Manager_products($_SESSION['id']);
        
        foreach($result as $post){
            if($post['idproduct'] == $_GET['id']){
                $allowed = true;
            }
        }
    }
    else{
        echo 'error: you are not permit to access/modify to this action.';
    }

    //edit events
    if(isset($_POST['edit']) && !empty($_POST['edit'])){
        //does  validation first
        $_POST['name'] = sanitize_input($_POST["name"]);
        $_POST['datestart'] = sanitize_input($_POST["datestart"]);
        $_POST['dateend'] = sanitize_input($_POST["dateend"]);
        $_POST['numberAllowed'] = sanitize_input($_POST["numberAllowed"]);
        $_POST['dropdown'] = sanitize_input($_POST["dropdown"]);
        $_POST['id'] = sanitize_input($_POST["id"]);


        //Date and Time
        $date_post = date("Y-m-d");
        $time_post = date("h:i:sa");

        //Upload Image
        $image_name = $_FILES['file']['name'];
        $file_temp = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        $upload="upload/".$image_name;

        if($file_size < 5242880){
            if(move_uploaded_file($file_temp, $upload)){
                try{
                    $location_image = $upload;
                    if(empty($location_image)) {
                        if(is_null($location_image)) {
                            echo 'The location_image is set to NULL.';
                        } else {
                            echo 'The location_image is probably an empty string.';
                        }
                    }
                }catch(PDOException $e){
                    //echo $e->getMessage();
                    echo "Please require to add image";
                }
            }
        }else{
            echo "Invalid file extension.";
        }

        // Update record
        $hold = $db->update_product(
            $_POST['name'], 
            $_POST['artist'],
            $_POST['year'],
            $date_post,
            $_POST['datestart'], 
            $_POST['dateend'], 
            $_POST['numberAllowed'], 
            $_POST['dropdown'],
            $_POST['description'], 
            $_POST['image'],
            $location_image,
            $time_post,
            $_POST['id']
          );
          if($hold){
            echo "<script>alert('Data updated');</script>";
            }else{
                echo "<script>alert('Data failed to update');</script>";
            }
          //var_dump($result);
    }

    // does sanitization second
    function sanitize_input( $value){
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    //delete event
    if(isset($_GET['deleteEvent'])){
        $db->admin_Delete("event", $_GET['id'], "idproduct");
        $db->admin_Delete("session", $_GET['id'], "event");
        echo '<script>window.location.replace("events.php");</script>';
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

    //logout button
    // if(isset($_GET['back'])){
    //     back();
    // }


    function back(){
        //$_SESSION = array(); // destroy all venue data
        session_destroy(); // compelte erase venue
        header("location: event.php");
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
            <h6 class="m-0 font-weight-bold text-primary">Edit product</h6>
        </div>

        <div class="card-body table table-striped table-dark">
            <div class="card-body">
                    <?php if(isset($error)){	
                        echo $error;
                    }
                    ?>
                <?php
                    //Print all events tied to the manager or admin
                    //var_dump($username);

                    $post = $db->get_product($_GET['id'])[0]; 
                        //var_dump($post);


                    echo'<form enctype="multipart/form-data" action="" method="post" role="form">';
                        echo'<div class="form-group row">';
                            
                                echo'
                                    <label class="col-lg-5 col-form-label form-control-label">ID</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="id"  value="' . $_GET["id"] . ' " required><br>
                                    </div> ';

                                echo'
                                    <label class="col-lg-5 col-form-label form-control-label">Name</label>
                                    <div class="col-lg-5">
                                    <input type="text" class="form-control" name="name" value="' . $post["name"] . '" required><br>
                                    </div> ';
            

                                echo'
                                    <label class="col-lg-5 col-form-label form-control-label">Artist</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="artist" value="' . $post["artist"] . '" required><br>
                                    </div> ';

                                echo'
                                    <label class="col-lg-5 col-form-label form-control-label">Year</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="year" value="' . $post["year"] . '" required><br>
                                    </div> ';

                                echo'
                                    <label class="col-lg-5 col-form-label form-control-label">Start Date</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="datestart" value="' . $post["datestart"] . '" required><br>
                                    </div> ';

                                echo'
                                    <label class="col-lg-5 col-form-label form-control-label">End Date</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="dateend" value="' . $post["dateend"] . '" required><br>
                                    </div>';

                                echo'
                                    <label class="col-lg-5 col-form-label form-control-label">Number Allowed</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="numberAllowed" value="' . $post["numberallowed"] . '" required><br>
                                    </div>';

                                echo'
                                    <label class="col-lg-5 col-form-label form-control-label">Capacity</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="venue" value="' . $post["venue"] . '" required><br>
                                    </div> ';


                                echo'
                                    <label class="col-lg-5 col-form-label form-control-label">Description</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="description" value="' . $post["description"] . '" required><br>
                                    </div>';

                                echo'
                                    <label class="col-lg-5 col-form-label form-control-label">Image</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="image" value="' . $post["image"] . '" required><br>
                                    </div>';

                                echo'
                                    <label class="col-lg-5 col-form-label form-control-label">location_image</label>
                                    <div class="col-lg-5">
                                        <img class="img-profile rounded-circle" src="../Admin/'. $post["location_image"] . '" width="50" height="50">
                                        <input type="file" class="form-control" name="file"><br>
                                    </div>';

                                // echo'
                                //     <label class="col-lg-3 col-form-label form-control-label">Upload Image</label>
                                //     <div class="col-lg-5">
                                //     <input name="file" type="file" type="text" class="form-control" name="location_image" value="' . $post["location_image"] . '" required><br>
                                //     </div> ';

                                // echo'
                                //     <label class="col-lg-3 col-form-label form-control-label">Video</label>
                                //     <div class="col-lg-5">
                                //     <input type="text" class="form-control" name="image" value="' . $post["video"] . '" required><br>
                                //     </div> ';

                                // echo'
                                //     <label class="col-lg-3 col-form-label form-control-label">Upload Image</label>
                                //     <div class="col-lg-5">
                                //     <input name="file" type="file" type="text" class="form-control" name="location_video" value="' . $post["location_video"] . '" required><br>
                                //     </div> ';

                                echo'
                                    <label class="col-lg-5 col-form-label form-control-label">Venue</label>
                                    <div class="col-lg-5">';

                                $result = $db->get_Venues();
                                $venue = ' <select name="dropdown">';
                                foreach($result as $ven){
                                    $venue .= "<option value ='" .$ven['idvenue'] . "'>" . $ven['name'] . "</option>";
                                }
                                $venue .= ' </select>';

                                echo $venue . ' <br><br><a href="products.php?back=true" class="btn btn-secondary" class="form-control" value="Cancel" required>Back</a>
                                                <input class="btn btn-success" type="submit" name="edit" class="form-control" value="Save Changes" required>&nbsp;';
                                echo' </div> ';

                        echo'</div';
                                        
                    echo'<hr></form>';
                ?>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Foot -->
<?php 
    include('../includes/footer.php');
?>