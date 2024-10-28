<?php

  include('head.php');

  include('Controller.php');
  
  $db = new Controller();
  
  date_default_timezone_set("America/New_York");
  //Do not delete this....
//   if(isset($_POST['insertproduct'])){
//     $maxsize = 5929344; // 5MB        
//     //$maxsize = 5929344;                   

//     $file_name_video = $_FILES['file']['name'];
//     $name = $_FILES['file']['name'];
//     $location_image = "videos/".$file_name_video;
//     $location_video = "videos/".$file_name_video;
//     $date_post = date("Y-m-d");
//     $time_post = date("h:i:sa");
//     // Select file type
//     $videoFileType = strtolower(pathinfo($location_video,PATHINFO_EXTENSION));

//     // Valid file extensions
//     $extensions_arr = array("mp4","avi","3gp","mov","mpeg");

//     // Check extension
//     if( in_array($videoFileType,$extensions_arr) ){
        
//         // Check file size
//         if(($_FILES["file"]["size"] = 0) || ($_FILES['file']['size'] >= $maxsize)) {
//             echo "File too large. File must be less than 5MB.";
//         }else{
//             // Upload
//             if(move_uploaded_file($_FILES['file']['tmp_name'],$location_video)){
//                 // Insert record
//                 $result = $db->insert_product(
//                   $_POST['name'], 
//                   $_POST['artist'],
//                   $_POST['year'],
//                   $date_post,
//                   $_POST['datestart'], 
//                   $_POST['dateend'], 
//                   $_POST['NumberAllowed'], 
//                   $_POST['dropdown'],
//                   $_POST['description'], 
//                   $_POST['image'], 
//                   $location_image,
//                   $_POST['video'],
//                   $location_video,
//                   $time_post,
//                   $_SESSION['id']
//                 );
//                 var_dump($result);
//             }
//         }

//     }else{
//         echo "Invalid file extension.";
//     }
//   }


    if(ISSET($_POST['insertproduct'])){
        //Date and Time
        $date_post = date("Y-m-d");
        $time_post = date("h:i:sa");

        //Upload Image
        $image_name = $_FILES['file']['name'];
        $file_temp = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        $location_image="upload/".$image_name;

        if($file_size < 5242880){
            if(move_uploaded_file($file_temp, $location_image)){
                try{
                    // Insert data
                    //$last_id = $db->$stmt1;
                    $qrCodeImage = 'http://localhost/Product/Admin/detail2.php?id=';
                    $whoisposted = htmlentities($_SESSION['username']);

                    $result = $db->insert_product(
                        $_POST['name'], 
                        $_POST['artist'],
                        $_POST['year'],
                        $date_post,
                        $_POST['datestart'], 
                        $_POST['dateend'], 
                        $_POST['NumberAllowed'], 
                        $_POST['dropdown'],
                        $_POST['description'], 
                        $_POST['image'], 
                        $location_image,
                        $_POST['video'],
                        $_POST['video'],
                        $time_post,
                        $qrCodeImage,
                        $whoisposted,
                        $_SESSION['id']
                    );
                    var_dump($result);
                }catch(PDOException $e){
                    echo $e->getMessage();
                }
            }
        }else{
            echo "Invalid file extension.";
        }
    echo "<script>alert('Data saved');</script>";
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
            <h6 class="m-0 font-weight-bold text-primary">Add New product</h6>
        </div>
        <div class="card-body table table-striped table-dark">
            <div class="card-body">
                <div>
                <?php 
                        $result = $db->get_Venues();
                        //var_dump($result);
                        echo'<form enctype="multipart/form-data" action="insert_products.php" method="post" role="form" id="createAccountFor" > 
                        <div class="form-group row">';
                            // Name
                            echo'<label class="col-lg-5 col-form-label form-control-label">Name</label>
                            <div class="col-lg-5">
                                <input class="form-control" type="text" name="name" placeholder="" value="" required /><br>
                            </div>';
                            
                            //Artist
                            echo'
                            <label class="col-lg-5 col-form-label form-control-label">Artist</label>
                            <div class="col-lg-5">
                                <input class="form-control" name="artist" placeholder="" value="" required /><br>
                            </div>';

                            //Year
                            echo'
                            <label class="col-lg-5 col-form-label form-control-label">Year</label>
                            <div class="col-lg-5">
                                <input type="year"class="form-control" name="year" placeholder="" value="" required /><br>
                            </div>';

                            //Start Date
                            echo'
                            <label class="col-lg-5 col-form-label form-control-label">Start Date</label>
                            <div class="col-lg-5">
                                <input type="datetime-local" class="form-control" name="datestart" placeholder="" value="" required /><br>
                            </div>';


                            //End Date
                            echo'<label class="col-lg-5 col-form-label form-control-label">End Date</label>
                            <div class="col-lg-5">
                                <input type="datetime-local" class="form-control" name="dateend" placeholder="" value="" required /><br>
                            </div>';


                            //Number Allowed
                            echo'<label class="col-lg-5 col-form-label form-control-label">Number Allowed</label>
                            <div class="col-lg-5">
                                <input type="number" class="form-control" name="NumberAllowed" placeholder="" value="" required/><br>
                            </div>';


                            //Description
                            echo'<label class="col-lg-5 col-form-label form-control-label">Description</label>
                            <div class="col-lg-5">
                                <textarea class="form-control" name="description" rows="10" cols="70" placeholder="Writing Somethings...." value="" required>
                                </textarea><br>
                            </div>';

                            //Capacity
                            echo'<label class="col-lg-5 col-form-label form-control-label">Capacity</label>
                            <div class="col-lg-5">
                                <input type="number" class="form-control" name="capacity" placeholder="" value="" required/><br>
                            </div>';

                            //Image
                            echo'<label class="col-lg-5 col-form-label form-control-label">Image</label>
                            <div class="col-lg-5">
                                <input class="form-control" name="image" placeholder="" value="" required/><br>
                            </div>';

                            //Upload Image
                            echo'<label class="col-lg-5 col-form-label form-control-label">Upload Image</label>
                            <div class="col-lg-5">
                                <input name="file" type="file"  required="required" class="form-control"/><br>
                            </div>';

                            //Full Video Url (Vimeo)
                            echo'<label class="col-lg-5 col-form-label form-control-label">Full Video Url (Vimeo)</label>
                            <div class="col-lg-5">
                                <input class="form-control" name="video" placeholder="" value="" required/><br>
                            </div>';

                            //Video Number (Vimeo)
                            echo'<label class="col-lg-5 col-form-label form-control-label">Video Number (Vimeo)</label>
                            <div class="col-lg-5">
                                <input class="form-control" name="video" placeholder="Only copy last number in the url path." value="" required/><br>
                            </div>';

                            echo'<label class="col-lg-5 col-form-label form-control-label">Venue</label>
                                <div class="col-lg-5">';
                                $venue = '<select name="dropdown">';
                                foreach($result as $post){
                                    $venue .= "<option value ='" .$post['idvenue'] . "'>" . $post['name'] . "</option>";
                                }
                                $venue .= '</select>';
                                echo $venue;
                        echo'</div><br>';
                        // echo  '<button class="btn btn-primary btn-lg btn-block" type="submit" name="insertproduct">Save</button>
                        // <hr class="mb-4">';  
                            
                        echo  '<div class="col-lg-5"><button class="btn btn-primary" type="submit" name="insertproduct">Submit</button></div>'; 
                        echo '<hr/></form>';  
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- foot -->
<?php 
    include('../includes/footer.php');
?>
