<?php
    session_start();
    //include('validate.php');
    include('controller.php');
    //require('./Controller.php');
    require('../Admin/helpers/session_helper.php');
    
    $userModel = new Controller();

    class Users {

        private $userModel;
        
        public function __construct(){
            $this->userModel = new Controller;
        }

        public function register(){

            flash('register');

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


            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //Init data
            $data = [
                'fullname' => trim($_POST['fullname']),
                'email' => trim($_POST['email']),
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'pwdRepeat' => trim($_POST['pwdRepeat']),
                'upload_image' => trim($location_image),
                'date' => trim($date),
                'time' => trim($time),
                'role' => trim($role)
            ];


            //Validate inputs
            if(empty($data['fullname']) || empty($data['email']) || empty($data['username']) || 
            empty($data['password']) || empty($data['pwdRepeat'])){
                flash("register", "Please fill out all inputs");
                redirect("./register.php");
            }

            if(!preg_match("/^[a-zA-Z0-9]*$/", $data['username'])){
                flash("register", "Invalid username");
                redirect("./register.php");
            }

            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                flash("register", "Invalid email");
                redirect("./register.php");
            }

            if(strlen($data['password']) < 6){
                flash("register", "Invalid password, please at least 6");
                redirect("./register.php");
            } else if($data['password'] !== $data['pwdRepeat']){
                flash("register", "Passwords do not match");
                redirect("./register.php");
            }

            //User with the same email or password already exists
            if($this->userModel->findUserByEmailOrUsername($data['email'], $data['email'], $data['fullname'])){
                flash("register", "Username or email already taken");
                redirect("./register.php");
            }

            //Passed all validation checks.
            //Now going to hash password
            //$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT); 
            $data['password'] = hash("sha256", $data['password']);
            //Register User
            if($this->userModel->register($data)){
                redirect("./login.php");
            }else{
                die("Something went wrong");
            }
            
            $_SESSION['fname']=$_POST['fullname']; //$_SESSION['fname'] should in insert_museai.php
            $_SESSION['image']=$location_image; //$_SESSION['image'] should in header.php
            //session connected to the location as role
            if( $this->userModel->register($data)){
                $_SESSION['fname']=$_POST['fullname']; //$_SESSION['fname'] should in insert_museai.php
                $_SESSION['image']=$location_image; //$_SESSION['image'] should in header.php
                // var_dump($db);
                echo "<script>alert('Data registered');</script>";
                //header("location: ../login.php");
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
  
        public function createUserSession($user){
            $_SESSION['username'] = $user->usersId;
            $_SESSION['fullname'] = $user->usersName;
            $_SESSION['email'] = $user->usersEmail;
            redirect("./login.php");
        }

        //destory the session to the login local (index)
        function logout(){
            //session_destory();
            unset($_SESSION['username']);
            unset($_SESSION['fullname']);
            unset($_SESSION['email']);
            session_destroy();
            redirect("./login.php");
            //header("location: login.php");
            exit();
        } 
    }

    //logout button
    // if(isset($_GET['logout'])){
    //     logout();
    // }


    $init = new Users;

    //Ensure that user is sending a post request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        switch($_POST['type']){
            case 'register':
                $init->register();
                break;
            default:
        }
        
    }
?>

<!-- Header -->
<?php 
    include('../includes/user-account/header.php');
?>
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
            <div class="card-body">
              <h1>Register</h1>
              <p class="text-muted">Sign In to your new account</p>

              <!-- flash() -->
              <?php flash('register') ?>

              <?php 
                //Form
                echo'<form enctype="multipart/form-data" id="createAccountFor" action="./register.php" method="post">';

                //Username
                echo'<div class="input-group mb-3">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="hidden" name="type" value="register">
                    <input type="username" class="form-control" id="username" name="username" placeholder="Username" required autofocus>
                    </div>';

                //Password
                echo'<div class="input-group mb-4">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="hidden" name="type" value="register">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autofocus>
                    </div>';

                //Re-Password
                echo'<div class="input-group mb-4">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="hidden" name="type" value="register">
                    <input type="password" class="form-control" id="password" name="pwdRepeat" placeholder="Re-Password" required autofocus>
                    </div>';

                //Full Name
                echo'<div class="input-group mb-4">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="hidden" name="type" value="register">
                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name" required autofocus>
                    </div>';
                
                //Email
                echo'<div class="input-group mb-4">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="hidden" name="type" value="register">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required autofocus>
                    </div>';

                //Radio form
                echo'<div class="input-group mb-4">
                    <input type="radio" name="role" id="exampleRadios1" value="Admin" checked>
                    <label label class="form-check-label" for="exampleRadios1">Admin</i></label>
                    </div>
                    
                    <div class="input-group mb-4">
                    <input type="radio" name="role" id="exampleRadios2" value="Manager">
                    <label label class="form-check-label" for="exampleRadios2">Manager</i></label>
                    </div>

                    <div class="input-group mb-4">
                    <input type="radio" name="role" id="exampleRadios3" value="NTID">
                    <label label class="form-check-label" for="exampleRadios3">NTID</i></label>
                    </div>

                    <div class="input-group mb-4">
                    <input type="radio" name="role" id="exampleRadios4" value="Attendee">
                    <label label class="form-check-label" for="exampleRadios4">Attendee</i></label>
                    </div>
                ';

                //Upload Image
                echo'<div class="input-group mb-4">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="file" class="form-control" name="file" required autofocus>
                    </div>';

                //Submit
                echo'<div class="row">
                <div class="col-6">
                  <button class="btn btn-primary px-4" type="submit" value="Register">Create Now</button>
                </div>';

                //Forgot password?
                echo'
                <div class="col-6 text-right">
                  <a href="forget-password.php" class="btn btn-link px-0">Forgot password?</a>
                </div>
                </div>';

                echo'</form>';
              
              ?>
            </div>
          </div>
          <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div>
                <h2>Already have an account? Login!</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <a href="login.php" class="btn btn-primary active mt-3">Login Now!</a>
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