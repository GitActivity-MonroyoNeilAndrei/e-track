<?php
include '../classes/database.php';
include '../classes/message.php';

$studentOrgExist  = false;
$passwordIncorrect = false;

$student_org = new database();

if (isset($_POST['sign-up'])) {

  $name_of_org = mysqli_escape_string($student_org->mysqli, $_POST['name-of-org']);
  $college_of = mysqli_escape_string($student_org->mysqli, $_POST['college-of']);
  $adviser = mysqli_escape_string($student_org->mysqli, $_POST['adviser']);
  $contact_no = mysqli_escape_string($student_org->mysqli, $_POST['contact-no']);
  $email = mysqli_escape_string($student_org->mysqli, $_POST['email']);
  $password = md5($_POST['password']);
  $confirm_password = md5($_POST['confirm-password']);


  if (!$student_org->isExisted('student_org', ['name_of_org'=>$name_of_org, 'password'=>$password])) {
    $studentOrgExist = false;

    if ($password == $confirm_password) {

      $student_org->insertData('student_org', ['name_of_org' => $name_of_org, 'college_of' => $college_of, 'adviser' => $adviser, 'contact_no' => $contact_no, 'email' => $email, 'password' => $password]);

      header("location: login-student-org.php?login-success");
    } else {
      $passwordIncorrect = true;
    }
  } else {
    $studentOrgExist = true;
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Student Organization Account</title>
  <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
  <link rel="stylesheet" href="../css/login-create-account.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/bootstrap/bootstrap.css?<?php echo time(); ?>">
</head>
<body>
  <img src="../images/msc_logo.png" alt="MSC logo">
  <form class="wrapper" method="post">
    <h3 class="text-center">Create Student Org. Account</h3>
    <?php if ($studentOrgExist) {
      Message::userAlreadyExist();
    } ?>
    <div>
      <label for="name-of-org">Name of Org.:</label>
      <input class="form-control" type="text" name="name-of-org" required>
    </div>
    <div>
      <label for="college-of">College of:</label>
      <input class="form-control" type="text" name="college-of" required>
    </div>
    <div>
      <label for="adviser">Adviser:</label>
      <input class="form-control" type="text" name="adviser" required>
    </div>
    <div>
      <label for="contact-no">Contact No.:</label>
      <input class="form-control" type="number" name="contact-no" required>
    </div>
    <div>
      <label for="email">Email:</label>
      <input class="form-control" type="email" name="email" required>
    </div>
    <div>
    <?php if ($passwordIncorrect) {
        Message::passwordDontMatch();
      } ?>
      <label for="password">Password:</label>
      <input class="form-control" type="password" name="password" required>
    </div>
    <div>
      <label for="confirm-password">Confirm Password:</label>
      <input class="form-control" type="password" name="confirm-password" required>
    </div>
    <input class="btn btn-success" type="submit" value="Sign Up" name="sign-up">
    <p class="text-center">Already have an Account?<br> <a href="login-student-org.php">Login here</a></p>
  </form>
</body>
</html>