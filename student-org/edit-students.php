<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');


session_start();

$student_org = new database();

$id = User::returnValueGet('id');

User::ifNotLogin('name_of_org', '../login-account/login-user.php');

$student_org_id = User::returnValueSession('student-org-id');

User::ifDeactivatedReturnTo($student_org->select('student_org', 'status', ['id' => $student_org_id]), '../logout.php?logout=student-org');

$name_of_org = User::returnValueSession('name_of_org');

$drafted_plan_of_activities = $student_org->countSelect('plan_of_activities', 'status', "status = 'draft' AND name_of_org = '$name_of_org'");
$drafted_accomplishment_reports = $student_org->countSelect('accomplishment_reports', 'status', "status = 'draft' AND name_of_org = '$name_of_org'");

$course_covered = ["", "", "", "", "", "", ""];

$course_covered_query = $student_org->select('student_org', '*', ['name_of_org'=>$name_of_org]);

while($row = mysqli_fetch_assoc($course_covered_query)) {
  $courses = explode(",", $row['course_covered']);

  for ($i = 0; $i < count($courses); $i++) {
    $course_covered[$i] = $courses[$i];
  }
}


if(isset($_POST['submit'])) {

  $student_id = mysqli_escape_string($student_org->mysqli, $_POST['student-id']);
  $student_first = mysqli_escape_string($student_org->mysqli, $_POST['first-name']);
  $student_last = mysqli_escape_string($student_org->mysqli, $_POST['last-name']);
  $student_course = mysqli_escape_string($student_org->mysqli, $_POST['student-course']);

  $student_password = md5(str_replace(' ', '', $student_first . $student_last));


  $student_org->updateData('student', ['student_id'=>$student_id, 'first_name'=>$student_first, 'last_name'=>$student_last, 'course'=> $student_course, 'password'=>$student_password], ['id'=>$id]);
   
  header("location: student-org-list-of-enrollees.php");
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
        <button class="dropbtn"><i class="fa-solid fa-user"></i> <?php User::printSession('name_of_org'); ?></button>
        <div class="dropdown-content">
          <a href="student-org-edit-profile.php"><i class="fa-solid fa-address-card"></i> My Profile</a>
          <a href="../logout.php?logout=student-org"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
    <?php
      require 'student-org-navigations.php';
    ?>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Monitor Election</h5>
          </div>



          <form method="post" class="d-flex justify-content-center flex-column mx-auto shadow rounded-2 mt-3 mb-3" style="max-width: 17rem; padding: 1rem 1rem 0;">
            <h4 class="text-center">Change Student Details</h4>
            <?php
              $student_details = $student_org->select('student', '*', ['id'=>$id]);

              while ($row = mysqli_fetch_assoc($student_details)) {
            ?>
            <label class="form-label" for="student-id">Student ID:</label>
            <input class="form-control" type="text" name="student-id" value="<?php echo $row['student_id']; ?>" required>
            <label class="form-label" for="first-name">First Name:</label>
            <input class="form-control" type="text" name="first-name" value="<?php echo $row['first_name']; ?>" required>
            <label class="form-label" for="last-name">Last Name:</label>
            <input class="form-control" type="text" name="last-name" value="<?php echo $row['last_name']; ?>" required>
            <label class="form-label" for="student-course">Course:</label>
            <select name="student-course" class="form-select" required>
              <?php 
                foreach ($course_covered as $course) {
                  if ($course == "") {break;}
              ?>
                <option value="<?php echo $course ?>" <?php if($course == $row['course']) { echo 'selected'; } ?>><?php echo $course; ?></option>

              <?php
                }
              ?>
            </select>
            <div class="text-center">
              <input class="btn btn-primary mx-auto mt-3 mb-3" type="submit" name="submit" value="Edit">
              <a class="btn btn-danger" href="student-org-list-of-enrollees.php">Cancel</a>
            </div>

            <?php } ?>
            
          </form>



        </div>
      </div>
    </div>

  </div>

  <?php
    require 'student-org-footer.php';
  ?>

  <script defer>
    let activeLink = document.getElementById("<?php User::printGet('user'); ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";
  </script>

<script>
    var activeNav = document.getElementById('list-of-enrollees')
    activeNav.classList.add('bg-dark-gray2');
  </script>
</body>

</html>