<?php
  
  include('head.php');
  

  include('Controller.php');
  $db = new Controller();


  
  if(isset($_POST['insertVenue'])){

    //does  validation first
    $_POST['name'] = sanitize_input($_POST["name"]);
    $_POST['capacity'] = sanitize_input($_POST["capacity"]); 

    $db->insert_Venue($_POST['name'],$_POST['capacity']);
    echo "<script>alert('Data saved');</script>";
  }


  // does sanitization second
  function sanitize_input( $value){
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
  }



  $query = "insert into venue (name, capacity) values(?,?)";
  //logout button
  if(isset($_GET['logout'])){
    logout();
  }

  //destory the session to the login local (index)
  function logout(){
   // session_destory();
    //header("location: http://serenity.ist.rit.edu/~ijc3093/ISTE-341/Project1/login.php");
    header("location: http://127.0.0.1:8080/login.php");
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
            <h6 class="m-0 font-weight-bold text-primary">Add New Venue</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php 
                    $result = $db->get_Venues();
                    //var_dump($result);
                    echo'<form action="insert_venue.php?insertVenue=true" method="post" role="form" id="createAccountFor" > 
                        <div>
                            <label class="col-lg-5 col-form-label form-control-label">Name</label>
                            <div class="col-lg-5">
                                <input class="form-control" type="text" name="name" placeholder="" value="" required /><br>
                            </div>

                            <label class="col-lg-5 col-form-label form-control-label">Capacity</label>
                            <div class="col-lg-5">
                                <input class="form-control" name="capacity" placeholder="" value="" required /><br>
                            </div> 
                        </div>';
                    echo  '<div class="col-lg-5"><button class="btn btn-primary" type="submit" name="insertVenue">Submit</button></div> '; 
                    echo '<hr/></form>';  
                ?>
            </div>
        </div>
    </div>

</div>
<!-- End of Main Content -->

<!-- foot -->
 <!-- /.container-fluid -->
 <?php 
    include('../includes/footer.php');
?>
