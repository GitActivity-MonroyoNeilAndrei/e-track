<?php
include '../classes/database.php';
include '../classes/message.php';
include '../classes/user.php';
session_start();

$student = new database();

User::ifLogin('student_id', '../student/student-vote.php');


if(isset($_POST['login'])) {
  $student_id = mysqli_escape_string($student->mysqli, $_POST['student-id']);
  $password = md5($_POST['password']);

  if($student->isExisted('student', ['student_id'=>$student_id, 'password'=>$password])){
    $_SESSION['student_id'] = $student->pullLastRowModified('student', 'student_id');
    $_SESSION['student_name'] = $student->pullLastRowModified('student', 'first_name') . ' ' . $student->pullLastRowModified('student', 'last_name');
    $_SESSION['student-course'] = $student->pullLastRowModified('student', 'course');
    header("location: ../student/student-vote.php");
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Student Account</title>
  <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
  <link rel="stylesheet" href="../css/login-create-account.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/bootstrap/bootstrap.css?<?php echo time(); ?>">
</head>
<body>
  <img src="../images/msc_logo.png" alt="MSC logo">
  <form method="post" class="wrapper">
    <h3>Login</h3>
    <?php if(isset($_REQUEST['login-success'])){Message::createAccountSuccess();} ?>
    <div>
      <label for="student-id">Student ID:</label>
      <input class="form-control" type="text" name="student-id" required>
    </div>
    <div>
      <label for="password">Password:</label>
      <input class="form-control" type="password" name="password" required>
    </div>
    <input class="btn btn-success" type="submit" value="Login" name="login">
  </form >
</body>
</html>