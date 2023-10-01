<?php
include '../classes/database.php';
include '../classes/message.php';

$studentExist  = false;
$passwordIncorrect = false;

$student = new database();

if (isset($_POST['sign-up'])) {

  $username = mysqli_escape_string($student->mysqli, $_POST['username']);
  $first_name = mysqli_escape_string($student->mysqli, $_POST['first-name']);
  $last_name = mysqli_escape_string($student->mysqli, $_POST['last-name']);
  $address = mysqli_escape_string($student->mysqli, $_POST['address']);
  $student_id = mysqli_escape_string($student->mysqli, $_POST['student-id']);
  $course = mysqli_escape_string($student->mysqli, $_POST['course']);
  $year_and_section = mysqli_escape_string($student->mysqli, $_POST['year-and-section']);
  $contact_no = mysqli_escape_string($student->mysqli, $_POST['contact-no']);
  $email = mysqli_escape_string($student->mysqli, $_POST['email']);
  $password = md5($_POST['password']);
  $confirm_password = md5($_POST['confirm-password']);


  if (!$student->isExisted('student', ['student_id' => $student_id, 'email' => $email, 'password' => $password]) &&
      !$student->isExisted('student_org', ['email' => $email, 'password' => $password]) &&
      !$student->isExisted('admin', ['email' => $email, 'password' => $password])

  ) {
    $studentExist = false;

    if ($password == $confirm_password) {

      $student->insertData('student', ['username' => $username, 'first_name' => $first_name, 'last_name' => $last_name, 'address' => $address, 'student_id' => $student_id, 'course' => $course, 'year_and_section' => $year_and_section, 'contact_no' => $contact_no, 'email' => $email, 'password' => $password]);

      header("location: login-student.php?login-success");
    } else {
      $passwordIncorrect = true;
    }
  } else {
    $studentExist = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Student Account</title>
  <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
  <link rel="stylesheet" href="../css/login-create-account.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/bootstrap/bootstrap.css?<?php echo time(); ?>">
</head>

<body>
  <img src="../images/msc_logo.png" alt="MSC logo">
  <form method="post" class="wrapper">
    <h3 class="text-center">Create Account</h3>
    <?php if ($studentExist) {
      Message::userAlreadyExist();
    } ?>
    <div>
      <label for="username">Username:</label>
      <input class="form-control" type="text" name="username" required>
    </div>
    <div>
      <label for="first-name">First Name:</label>
      <input class="form-control" type="text" name="first-name" required>
    </div>
    <div>
      <label for="last-name">Last Name:</label>
      <input class="form-control" type="text" name="last-name" required>
    </div>
    <div>
      <label for="address">Address:</label>
      <input class="form-control" type="text" name="address" required>
    </div>
    <div>
      <label for="student-id">Student ID:</label>
      <input class="form-control" type="text" name="student-id" required>
    </div>
    <div style="width: 100%;">
      <label for="course">Course:</label>
      <select class="form-select" name="course">
        <?php 
          $course = $student->select('courses', '*');

          while ($row = mysqli_fetch_assoc($course)) {
        ?>
      

        <option value="<?php echo $row['course']; ?>"><?php echo $row['course']; ?></option>

      <?php } ?>
      </select>
      <!-- <input class="form-control" type="text" name="course" required> -->
    </div>
    <div style="width: 100%;">
      <label class="form-label" for="year-and-section">Year</label>
      <select class="form-select " name="year-and-section">
        <option selected value="first">1st</option>
        <option value="second">2nd</option>
        <option value="third">3rd</option>
        <option value="fourth">4th</option>
      </select>
    </div>
    <div>
      <label for="contact-number">Contact No.:</label>
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
    <p class="text-center">Already have an Account?<br> <a href="login-user.php">Login here</a></p>
  </form>
</body>

</html>