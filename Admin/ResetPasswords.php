<?php

use PHPMailer\PHPMailer\PHPMailer;

//Import
require_once './Controller.php';
require_once './helpers/session_helper.php';

//Require PHP Mailer
require_once './PHPMailer/src/PHPMailer.php';
require_once './PHPMailer/src/Exception.php';
require_once './PHPMailer/src/SMTP.php';

//Class Reset Password for reset-password.php and create-new-password.php
class ResetPasswords{
    private $resetModel;
    private $userModel;
    private $mail;
    
    //Access Database class
    public function __construct(){
        $this->resetModel = new Controller;
        $this->userModel = new Controller;
        
        //Setup PHPMailer
        $this->mail = new PHPMailer(true);
    }

    //Send the email
    public function sendEmail(){
        try{
            //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $usersEmail = trim($_POST['email']);

        if(empty($usersEmail)){
            flash("reset", "Please input email");
            redirect("../Admin/reset-password.php");
        }

        if(!filter_var($usersEmail, FILTER_VALIDATE_EMAIL)){
            flash("reset", "Invalid email");
            redirect("../Admin/reset-password.php");
        }

        //Will be used to query the user from the database
        $selector = bin2hex(random_bytes(8));

        //Will be used for confirmation once the database entry has been matched
        $token = random_bytes(32);

        //URL will vary depending on where the website is being hosted from
        $url = 'http://localhost/Product/Admin/create-new-password.php?selector='.$selector.'&validator='.bin2hex($token);
        
        
        //Expiration date will last for half an hour
        $expires = date("U") + 1800;

        //Delete the old password
        if(!$this->resetModel->deleteEmail($usersEmail)){
            die("There was an error");
        }

        //Hash Password
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        if(!$this->resetModel->insertToken($usersEmail, $selector, $hashedToken, $expires)){
            die("There was an error");
        }
        
        //This can Send Email Now
        $this->mail->SMTPDebug = 0;
        $this->mail->isSMTP();
        //$this->mail->Host = 'smtp.mailtrap.io';
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        //$this->mail->Port = 2525;
        $this->mail->Port = 465;
        $this->mail->Username = 'isaaccuma3093@gmail.com';
        $this->mail->Password = 'Merciful#100';
        $this->mail->SMTPSecure = 'ssl';

        $subject = "Reset your password";
        $message = "<p>We recieved a password reset request.</p>";
        $message .= "<p>Here is your password reset link: </p>";
        $message .= "<a href='".$url."'>".$url."</a>";

        // to solve a problem 
        $this->mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );

        $this->mail->setFrom('isaaccuma3093@gmail.com', 'Museai');
        $this->mail->isHTML(true);
        $this->mail->Subject = $subject;
        $this->mail->Body = $message;
        $this->mail->addAddress($usersEmail, 'Museai');
        $this->mail->addReplyTo('no-replay@example.com', 'No Replay');
        $this->mail->send();

        flash("reset", "Check your email", 'form-message form-message-green');
        redirect("../Admin/reset-password.php");
        }catch(Exception $e){
            echo 'Message could not be sent. Mailer Error: ', $this->mail->ErrorInfo;
        }
        exit(); // to stop user from submitting more than once
    }

    public function resetPassword(){

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
            'selector' => trim($_POST['selector']),
            'validator' => trim($_POST['validator']),
            'pwd' => trim($_POST['pwd']),
            'pwd-repeat' => trim($_POST['pwd-repeat'])
        ];

        //Url with secure
        $url = '../Admin/create-new-password.php?selector='.$data['selector'].'&validator='.$data['validator'];

        if(empty($_POST['pwd'] || $_POST['pwd-repeat'])){
            //Please fill out all fields
            flash("newReset", "Please fill out all fields");
            redirect($url);
        }else if($data['pwd'] != $data['pwd-repeat']){
            //Passwords do not match
            flash("newReset", "Passwords do not match");
            redirect($url);
        }else if(strlen($data['pwd']) < 6){
            //Invalid password: Must be at least 6
            flash("newReset", "Invalid password: Please be at least 6");
            redirect($url);
        }

        //The link is no loner valid
        $currentDate = date("U");
        if(!$row = $this->resetModel->resetPasswords($data['selector'], $currentDate)){
            flash("newReset", "Sorry. The link is no longer valid");
            redirect($url);
        }

        //Password must be valid
        $tokenBin = hex2bin($data['validator']);
        $tokenCheck = password_verify($tokenBin, $row->pwdResetToken);
        if(!$tokenCheck){
            flash("newReset", "You need to re-Submit your reset request");
            redirect($url);
        }

        //The email is not found in database system
        $tokenEmail = $row->pwdResetEmail;
        if(!$this->userModel->findUserByEmailOrUsername($tokenEmail, $tokenEmail)){
            flash("newReset", "There was an error: The email is not found in database system");
            redirect($url);
        }

        
        //Password must be hashed
        $newPwdHash = hash("sha256", $data['pwd']);
        if(!$this->userModel->resetPassword($newPwdHash, $tokenEmail)){
            flash("newReset", "There was an error");
            redirect($url);
        }

        //Delete old the email
        if(!$this->resetModel->deleteEmail($tokenEmail)){
            flash("newReset", "The email is not found.");
            redirect($url);
        }

        flash("newReset", "Password Updated", 'form-message form-message-green');
        redirect($url);
    }
}

$init = new ResetPasswords;

//Ensure that user is sending a post request
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    switch($_POST['type']){
        case 'send':
            $init->sendEmail();
            break;
        case 'reset':
            $init->resetPassword();
            break;
        default:
        header("location: ../login.php");
    }
}else{
    header("location: ../login.php");
}