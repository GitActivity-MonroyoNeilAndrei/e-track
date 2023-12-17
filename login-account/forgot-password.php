<?php

include '../classes/database.php';
include '../classes/message.php';
include '../classes/user.php';
session_start();

$student = new database();

User::ifLogin('student_id', '../student/student-vote.php');
User::ifLogin('name-of-org', '../student-org/student-org-homepage.php');
User::ifLogin('admin-username', '../admin/admin-homepage.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$otp;
$email = "";

if(isset($_POST['send'])){

  $otp = mt_rand(100000, 999999); 


  $name = "eTrack: Use OTP To Verify Your Indentity";
  $email = htmlentities($_POST['email']);
  $subject = "Forgot Password";
  $message = "Your eTrack OTP Code is $otp";
  $email2 = 'andreimonroyo0@gmail.com';

  if (
    $student->isExisted('student', ['email'=>$email]) ||
    $student->isExisted('admin', ['email'=>$email]) ||
    $student->isExisted('student_org', ['email'=>$email]) 
  ) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'andreimonroyo0@gmail.com';
    $mail->Password = 'xtwk bnyt spps qtux';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->isHTML(true);
    $mail->setFrom($email, $name);
    $mail->addAddress('andreimonroyo0@gmail.com');
    $mail->Subject = ("$email ($subject)");
    $mail->Body = $message;
    $mail->send();

    $otp = md5($otp);

    header("Location: forgot-password.php?emailSent=$otp&email=$email");
  } else {
    $invalid_email = "Email doesn't exist in the system";
  }

}

if (isset($_POST['verify'])) {
  $user_otp = md5($_POST['otp']);

  if ($_GET['emailSent'] == $user_otp) {
    header("location: forgot-password.php?changePassword&email=$_GET[email]");
  } else {
    $invalid_otp = "Invalid OTP";
  }
}

if (isset($_POST['submit'])) {

  $password = $_POST['new-password'];
  $confirm_password = $_POST['confirm-new-password'];
  if ($password != $confirm_password) {
    $password_doesnt_match = "Password doesn't Match";
  } else {
    $validPassword = User::isValidPassword($password);

    if ($validPassword == "") {
      $invalid_password = "Password should have at least 5 character, uppercase, number and special character";
    } else {
      $password = md5($password);
      if($student->isExisted('student', ['email'=>$_GET['email']])) {
        $student->updateData('student', ['password'=>$password], ['email'=>$_GET['email']]);
      } else if($student->isExisted('student_org', ['email'=>$_GET['email']])) {
        $student->updateData('student_org', ['password'=>$password], ['email'=>$_GET['email']]);
      } else if($student->isExisted('admin', ['email'=>$_GET['email']])) {
        $student->updateData('admin', ['password'=>$password], ['email'=>$_GET['email']]);
      }
      
      header("location: login-user.php");
    }
  }


  

}
?>
<html>
<head>
  <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
  <link rel="stylesheet" href="../css/login-create-account.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/bootstrap/bootstrap.css?<?php echo time(); ?>">
</head>
<body class="center-absolute">
<img src="../images/msc_logo.png" alt="MSC logo">
  <form method="post" class="wrapper <?php if (!isset($_GET['emailSent']) && !isset($_GET['changePassword'])) { echo 'd-block';} else {echo 'd-none';} ?>">
    <h3>Forgot Password</h3>
    <?php if (isset($invalid_email)) {
      echo '
      <div class="alert alert-danger" role="alert">
        '. $invalid_email .'
      </div>
      ';
    } 
    ?>
    <div>
      <label for="password">Email:</label>
      <input class="form-control" type="email" name="email" required>
    </div>
    <input class="btn btn-success" type="submit" value="Send OTP" name="send">
  </form>


  <form method="post" class="wrapper <?php if (isset($_GET['emailSent'])) { echo 'd-block';} else { echo 'd-none';} ?>">
    <h3>Verify OTP</h3>
    <?php if (isset($invalid_otp)) {
      echo '
      <div class="alert alert-danger" role="alert">
        '. $invalid_otp .'
      </div>
      ';
    } 
    ?>
    <div>
      <label for="password">OTP:</label>
      <input class="form-control" type="number" name="otp" required>
    </div>
    <input class="btn btn-success" type="submit" value="Verify" name="verify">
  </form>

  <form method="post" class="wrapper <?php if (isset($_GET['changePassword'])) { echo 'd-block';} else { echo 'd-none';} ?>">
    <h3>New Password</h3>
    <?php if (isset($invalid_password)) {
      echo '
      <div class="alert alert-danger" role="alert">
        '. $invalid_password .'
      </div>
      ';
    } else if (isset($password_doesnt_match)) {
      echo '
      <div class="alert alert-danger" role="alert">
        '. $password_doesnt_match .'
      </div>
      ';
    }
    ?>
    <div>
      <label for="password">New Password:</label>
      <input class="form-control" type="password" name="new-password" required>
    </div>
    <div>
      <label for="password">Confirm New Password:</label>
      <input class="form-control" type="password" name="confirm-new-password" required>
    </div>
    <input class="btn btn-success" type="submit" value="Submit" name="submit">
  </form>

</body>
</html>
