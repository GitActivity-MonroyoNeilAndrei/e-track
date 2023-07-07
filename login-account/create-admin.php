<?php
include '../classes/database.php';
include '../classes/message.php';

$adminExist  = false;
$passwordIncorrect = false;

$admin = new database();

if (isset($_POST['sign-up'])) {

  $username = mysqli_escape_string($admin->mysqli, $_POST['username']);
  $first_name = mysqli_escape_string($admin->mysqli, $_POST['first-name']);
  $last_name = mysqli_escape_string($admin->mysqli, $_POST['last-name']);
  $address = mysqli_escape_string($admin->mysqli, $_POST['address']);
  $contact_no = mysqli_escape_string($admin->mysqli, $_POST['contact-no']);
  $email = mysqli_escape_string($admin->mysqli, $_POST['email']);
  $password = md5($_POST['password']);
  $confirm_password = md5($_POST['confirm-password']);




  if (!$admin->isExisted('admin', ['email'=>$email, 'password'=>$password])) {
    $adminExist = false;

    if ($password == $confirm_password) {

      $admin->insertData('admin', ['username' => $username, 'first_name' => $first_name, 'last_name' => $last_name, 'address' => $address, 'contact_no' => $contact_no, 'email' => $email, 'password' => $password]);

      header("location: login-admin.php?login-success");
    } else {
      $passwordIncorrect = true;
    }
  } else {
    $adminExist = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Admin Account</title>
  <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
  <link rel="stylesheet" href="../css/login-create-account.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/bootstrap.css?<?php echo time(); ?>">
</head>

<body>
  <img src="../images/msc_logo.png" alt="MSC logo">
  <form class="wrapper" method="post">
    <h3 class="text-center">Create Admin Account</h3>
    <?php if ($adminExist) {
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
    <p class="text-center">Already have an Account?<br> <a href="login-admin.php">Login here</a></p>
  </form>
</body>

</html>