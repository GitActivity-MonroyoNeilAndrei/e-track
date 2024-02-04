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

$studentOrg = User::returnValueGet('studentOrg');

if(isset($_POST['submit'])) {

  if(!isset($_POST['course'])) {
    $admin->updateData('student_org', ['course_covered'=>''], ['name_of_org'=>$studentOrg]);
    header("location: admin-monitor-plan-of-activities.php?activeStudentOrg=$studentOrg");
  }

  $courses = $_POST['course'];
  $course_covered = '';
  $first_time = true;

  if($courses != null) {
    foreach ($courses as $course) {
    if($first_time){
      $course_covered .= $course;
      $first_time = false;
    } else {
      $course_covered .= ','.$course;
    }
  }
  $admin->updateData('student_org', ['course_covered'=>$course_covered], ['name_of_org'=>$studentOrg]);
  header("location: admin-student-organization.php?activeStudentOrg=$studentOrg");
  }
}



$courses = mysqli_fetch_assoc($admin->select('student_org', '*', ['name_of_org'=>User::returnValueGet('studentOrg')]));

$list_covered = explode(",", $courses['course_covered']);


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
          <a href="admin-edit-profile.php"><i class="fa-solid fa-address-card"></i> My Profile</a>
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
            <h5>Student Organization > Course Covered </h5>
          </div>

          <h4 class="text-center">Select Course that the <?php User::printGet('studentOrg'); ?> Covered</h4>

          <form method="post" role="group" aria-label="Basic checkbox toggle button group">


          <div  class="d-flex justify-content-center flex-column mx-auto mt-5 pt-3" style="padding: 0 4vw; overflow-y: scroll; height:400px; width: 23rem;" >
            <?php 
              $course = $admin->select('courses', '*');

              while ($row = mysqli_fetch_assoc($course)) {
            ?>

              <input type="checkbox" class="btn-check" id="<?php echo $row['course']; ?>" name="course[]" value="<?php echo $row['course']; ?>" autocomplete="off" <?php if (in_array($row['course'], $list_covered)) {echo 'checked';} ?>>
              <label class="btn btn-outline-primary mb-2 mx-2" for="<?php echo $row['course']; ?>"><?php echo $row['course']; ?></label>

            <?php } ?>

          </div>

            <div class="text-center mt-4">
              <input class="btn btn-success" type="submit" name="submit" value="Submit">
              <a class="btn btn-danger" href="admin-student-organization.php?activeStudentOrg=<?php echo $studentOrg;?>">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php
    require 'admin-footer.php';
  ?>

  <script>
    var activeNav = document.getElementById('monitor-plan-of-activities')
    activeNav.classList.add('bg-dark-gray2');
  </script>
</body>
</html>