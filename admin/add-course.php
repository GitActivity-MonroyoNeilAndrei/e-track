<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');


session_start();

$admin = new database();

User::ifNotLogin('admin-username', '../login-account/login-user.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id'=>$admin_id]), '../logout.php?logout=admin');

if (isset($_POST['submit'])) {
  $course = mysqli_escape_string($admin->mysqli, $_POST['course']);

  if(!$admin->isExisted('courses', ['course'=>$course])) {
    $admin->insertData('courses', ['course'=>$course]);
    header('location: admin-list-of-courses.php');
  } else {
    header('location: add-course.php?error=alreadyExist');
  }

}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Home Page</title>
  <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
  <link rel="stylesheet" href="../css/bootstrap/bootstrap.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/admin.css?<?php echo time(); ?>">
  <script src="https://kit.fontawesome.com/ba2dc1cde9.js" crossorigin="anonymous"></script>

</head>

<body>
  <div class="body">
    <div class="header bg-green-1">
      <div class="d-flex align-items-center"><img class="header-logo" src="../images/msc_logo.png" alt="msc logo">
        <h3 class=" header-texts">MARINDUQUE STATE COLLEGE</h3>
      </div>
      <div class="dropdown">
        <button class="dropbtn"><i class="fa-solid fa-user"></i> <?php User::printSession('admin-username'); ?></button>
        <div class="dropdown-content">
          <a href="#"><i class="fa-solid fa-address-card"></i> My Profile</a>
          <a href="../logout.php?logout=admin"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <?php
        require 'admin-navigations.php';
       ?>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Monitor Election > Add Course</h5>
          </div>

          <h4 class="text-center">Add Course</h4>


          <form method="post" class="mx-auto mt-4 border shadow p-3 rounded-3" style="max-width: 20rem;">
          <?php
            if(isset($_GET['error'])) {
              Message::userAlreadyExist();
            }
          ?>
            <label class="form-label" for="">Name of Course</label>
            <input class="form-control" type="text" name="course" focus required>

            <div class="text-center mt-3">
              <input class="btn btn-success mx-auto" type="submit" name="submit" value="Add">
              <a class="btn btn-danger" href="admin-list-of-courses.php">Cancel</a>
            </div>
          </form>

        </div>
      </div>
    </div>

  </div>

  <script>
    var activeNav = document.getElementById('list-of-users')
    activeNav.classList.add('bg-dark-gray2');
  </script>
</body>

</html>