<?php
include '../classes/database.php';
include '../classes/message.php';
include '../classes/user.php';
session_start();

$student_org = new database();


User::ifLogin('name-of-org', '../student-org/student-org-homepage.php');


if(isset($_POST['login'])) {
  $email = mysqli_escape_string($student_org->mysqli, $_POST['email']);
  $password = md5($_POST['password']);

  if($student_org->isExisted('student_org', ['email'=>$email, 'password'=>$password])){
    $_SESSION['name_of_org'] = $student_org->pullLastRowModified('student_org', 'name_of_org');
    header("location: ../student-org/student-org-homepage.php");
  }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Student Organization Account</title>
  <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
  <link rel="stylesheet" href="../css/login-create-account.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/bootstrap/bootstrap.css?<?php echo time(); ?>">
</head>
<body>
  <img src="../images/msc_logo.png" alt="MSC logo">
  <form class="wrapper" method="post">
    <h3>Login Student Org.</h3>
    <?php if(isset($_REQUEST['login-success'])){Message::createAccountSuccess();} ?>
    <div>
      <label for="email">Email:</label>
      <input class="form-control" type="email" name="email" required>
    </div>
    <div>
      <label for="password">Password:</label>
      <input class="form-control" type="password" name="password" required>
    </div>
    <input class="btn btn-success" type="submit" value="Login" name="login">
  </form>
</body>
</html>