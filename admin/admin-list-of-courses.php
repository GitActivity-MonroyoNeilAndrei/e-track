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
            <h5>Monitor Election > List of Courses</h5>
          </div>

          <a class="btn btn-danger" href="admin-list-of-users.php">Back</a>

          <h4 class="text-center">List of Courses</h4>


          <div class="text-center mb-3">
            <a class="btn btn-primary text-center" href="add-course.php">Add Course</a>
          </div>

          <table class="table table-striped table-hover mx-auto border shadow" style="max-width: 20rem;">
          <tbody>
          <?php
            $courses = $admin->select('courses', '*');
            
            while ($row = mysqli_fetch_assoc($courses)){
          ?>
            
            <tr>
              <td>
                <h5 style="font-size: 1.2em;"><?php echo $row['course']; ?></h5>
              </td>
              <td>
                <a class="btn btn-danger" href="delete-course.php?id=<?php echo $row['id']; ?>">Delete</a>
              </td>
            </tr>

          <?php }?>
          </tbody>
          </table>

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