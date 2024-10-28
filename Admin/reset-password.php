
<?php 
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    // //include('validate.php');
    require('Controller.php');
    include_once './helpers/session_helper.php';
?>
    <h1 class="header">Reset Password</h1>

    <?php flash('reset') ?>

    <form method="post" action="./ResetPasswords.php">
        <input type="hidden" name="type" value="send" />
        <input type="text" name="email" 
        placeholder="Email...">
        <button type="submit" name="submit">Receive Email</button>
    </form>
