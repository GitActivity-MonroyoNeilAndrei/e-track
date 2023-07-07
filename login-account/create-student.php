<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Student Account</title>
  <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
  <link rel="stylesheet" href="../css/login-create-account.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/bootstrap.css?<?php echo time(); ?>">
</head>
<body>
  <img src="../images/msc_logo.png" alt="MSC logo">
  <div class="wrapper">
    <h3 class="text-center">Create Account</h3>
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
    <div>
      <label for="course">Course:</label>
      <input class="form-control" type="text" name="course" required>
    </div>
    <div>
      <label for="year_and_section">Year & Section:</label>
      <input class="form-control" type="text" name="year_and_section" required>
    </div>
    <div>
      <label for="contact-number">Contact No.:</label>
      <input class="form-control" type="number" name="contact-number" required>
    </div>
    <div>
      <label for="email">Email:</label>
      <input class="form-control" type="email" name="email" required>
    </div>
    <div>
      <label for="password">Password:</label>
      <input class="form-control" type="password" name="password" required>
    </div>
    <div>
      <label for="confirm-password">Confirm Password:</label>
      <input class="form-control" type="password" name="confirm-password" required>
    </div>
    <input class="btn btn-success" type="submit" value="Login" name="sign-up">
    <p class="text-center">Already have an Account?<br> <a href="login-student.php">Login here</a></p>
  </div>
</body>
</html>