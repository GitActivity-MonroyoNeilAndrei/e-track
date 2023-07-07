<?php 


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Student Account</title>
  <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
  <link rel="stylesheet" href="../css/login-create-account.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/bootstrap.css?<?php echo time(); ?>">
</head>
<body>
  <img src="../images/msc_logo.png" alt="MSC logo">
  <div class="wrapper">
    <h3>Login</h3>
    <div>
      <label for="student-id">Student ID:</label>
      <input class="form-control" type="text" name="student-id" required>
    </div>
    <div>
      <label for="password">Password:</label>
      <input class="form-control" type="password" name="password" required>
    </div>
    <input class="btn btn-success" type="submit" value="Login" name="login">
    <p class="text-center">Don't have an account?<br> <a href="create-student.php">Create an Account</a></p>
  </div>
</body>
</html>