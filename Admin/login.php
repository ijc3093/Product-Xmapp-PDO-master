<?php
  session_start();
  include('controller.php');

  //Validate form
  if(isset($_POST['username']) && isset($_POST['password'])){
    $db = new Controller();
    $post  = $db->login($_POST['username'], $_POST['password']);
    if( $post != -1 ){
      // echo 'successs';
      if(isset($_REQUEST["remember"]) && $_REQUEST["remember"]==1){
          setcookie("login","1",time()+60);// second on page time
      }
    
      else{
          setcookie("login","1");
          $_SESSION['username']=$_POST['username'];
          echo '<script>window.location.replace("registrations.php");</script>';
      }
      
    }else{
      echo '<script>alert("Login failed! or have you registered?");</script>';
      //$msg="Login failed! or have you registered?";
    }
  }
?>

<!-- Head -->
<?php 
    include('../includes/user-account/header.php');
?>
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
            <div class="card-body">
              <h1>Login</h1>

              <p style="color:red;">
                  <?php 
                    // if(isset($msg)){	
                    //   echo $msg;
                    // }
                  ?>
              </p>

              <p class="text-muted">Sign In to your account</p>
              <form class="user" method="post">
                <div class="input-group mb-3">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username" required autofocus>
                </div>
                <div class="input-group mb-4">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autofocus>
                </div>
                <div class="row">
                  <div class="col-6">
                    <button type="submit" class="btn btn-primary px-4">Login</button>
                  </div>
                  <div class="col-6 text-right">
                  <a href="reset-password.php" class="btn btn-link px-0">Forgot password?</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div>
                <h2>Sign up</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <a href="register.php" class="btn btn-primary active mt-3">Register Now!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
<?php 
    include('../includes/user-account/footer.php');
?>