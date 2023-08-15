<?php
include '../classes/database.php';
include '../classes/message.php';
include '../classes/user.php';
session_start();

$admin = new database();

User::ifLogin('admin-username', '../admin/admin-homepage.php');


if(isset($_POST['login'])) {
  $email = mysqli_escape_string($admin->mysqli, $_POST['email']);
  $password = md5($_POST['password']);

  if($admin->isExisted('admin', ['email'=>$email, 'password'=>$password])){
    $_SESSION['admin-username'] = $admin->pullLastRowModified('admin', 'username');
    header("location: ../admin/admin-homepage.php");
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin Account</title>
  <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
  <link rel="stylesheet" href="../css/login-create-account.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/bootstrap/bootstrap.css?<?php echo time(); ?>">
</head>
<body>
  <img src="../images/msc_logo.png" alt="MSC logo">
  <form class="wrapper" method="post">
    <h3>Login Admin</h3>
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
    <p class="text-center">Don't have an account?<br> <a href="create-admin.php">Create an Account</a></p>
  </form>
</body>
</html>