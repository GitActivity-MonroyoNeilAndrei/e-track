<?php
include '../classes/database.php';
include '../classes/message.php';
include '../classes/user.php';
session_start();

$student = new database();

User::ifLogin('student_id', '../student/student-vote.php');
User::ifLogin('name-of-org', '../student-org/student-org-homepage.php');
User::ifLogin('admin-username', '../admin/admin-homepage.php');


function getSchoolYear($orgName) {
  $student = new database();

  $sql = " SELECT school_year FROM officers WHERE org_name = '$orgName' ORDER BY school_year DESC";
  $select = $student->mysqli->query($sql);

  $row = mysqli_fetch_assoc($select);

  return $row['school_year'];
}


if (isset($_POST['login'])) {
  $email_student_id = mysqli_escape_string($student->mysqli, $_POST['email-student-id']);
  $password = md5($_POST['password']);

  if(strpos($email_student_id, '@') !== false){

    if ($student->isExisted('admin', ['email' => $email_student_id, 'password' => $password])) {
      if (User::ifDeactivated($student->select('admin', 'status', ['email' => $email_student_id, 'password' => $password]))) {
        $deactivated = "Your Account Had Been Deactivate";
      } else {
        $_SESSION['admin-username'] = $student->pullLastRowModified('admin', 'username');
        $_SESSION['admin-id'] = $student->pullLastRowModified('admin', 'id');
        header("location: ../admin/admin-homepage.php");
      }
    } else if ($student->isExisted('student_org', ['email' => $email_student_id, 'password' => $password])) {
        if (User::ifDeactivated($student->select('student_org', 'status', ['email' => $email_student_id, 'password' => $password]))) {
          $deactivated = "Your Account Had Been Deactivate";
        } else {
          $_SESSION['name_of_org'] = $student->pullLastRowModified('student_org', 'name_of_org');
          $_SESSION['student-org-id'] = $student->pullLastRowModified('student_org', 'id');
          $_SESSION['school-year'] = getSchoolYear($student->pullLastRowModified('student_org', 'name_of_org'));
          header("location: ../student-org/student-org-homepage.php");
        }
    } else if ($student->isExisted('student', ['email' => $email_student_id, 'password' => $password])) {

      if (User::ifDeactivated($student->select('student', 'status', ['email' => $email_student_id, 'password' => $password]))) {
        $deactivated = "Your Account Had Been Deactivate";
      } else {
        $_SESSION['student_id'] = $student->pullLastRowModified('student', 'student_id');
        $_SESSION['student_name'] = $student->pullLastRowModified('student', 'first_name') . ' ' . $student->pullLastRowModified('student', 'last_name');
        $_SESSION['student-course'] = $student->pullLastRowModified('student', 'course');
        $_SESSION['student-id'] = $student->pullLastRowModified('student', 'id');
  
        header("location: ../student/student-vote.php");
      }
    } else {
      $incorrect_inputs = "Incorrect Inputs";
    }
  } else if ($student->isExisted('student', ['student_id' => $email_student_id, 'password' => $password])) {

    if (User::ifDeactivated($student->select('student', 'status', ['student_id' => $email_student_id, 'password' => $password]))) {
      $deactivated = "Your Account Had Been Deactivate";
    } else {
      $_SESSION['student_id'] = $student->pullLastRowModified('student', 'student_id');
      $_SESSION['student_name'] = $student->pullLastRowModified('student', 'first_name') . ' ' . $student->pullLastRowModified('student', 'last_name');
      $_SESSION['student-course'] = $student->pullLastRowModified('student', 'course');
      $_SESSION['student-id'] = $student->pullLastRowModified('student', 'id');

      header("location: ../student/student-vote.php");
    }
  }else {
    $incorrect_inputs = "Incorrect Inputs";
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
    <?php if (isset($_REQUEST['login-success'])) {
      Message::createAccountSuccess();
    } ?>
    <?php if (isset($deactivated)) {
      Message::accountDeactivated($deactivated);
    } ?>
    <?php if (isset($incorrect_inputs)) {
      Message::incorrectInputs($incorrect_inputs);
    } ?>
    <div>
      <label for="student-id">Email or Student ID:</label>
      <input class="form-control" type="text" name="email-student-id" required>
    </div>
    <div>
      <label for="password">Password:</label>
      <input class="form-control" type="password" name="password" required>
    </div>
    <input class="btn btn-success" type="submit" value="Login" name="login">
    <p class="text-center">Don't have an Account? <br>Create <a href="create-student.php">here</a></p>
  </form>
</body>

</html>