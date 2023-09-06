<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');


session_start();

$student_org = new database();

User::ifNotLogin('name_of_org', '../login-account/login-student-org.php');

$student_org_id = User::returnValueSession('student-org-id');

User::ifDeactivatedReturnTo($student_org->select('student_org', 'status', ['id'=>$student_org_id]), '../logout.php?logout=student-org');

$student_org_school_year = User::returnValueSession('school-year');

if(isset($_POST['submit'])) {
  $name_of_activity = mysqli_escape_string($student_org->mysqli, $_POST['name-of-activity']);
  $date = mysqli_escape_string($student_org->mysqli, $_POST['date']);
  $venue = mysqli_escape_string($student_org->mysqli, $_POST['venue']);
  $sponsors = mysqli_escape_string($student_org->mysqli, $_POST['sponsors']);
  $nature_of_activity = mysqli_escape_string($student_org->mysqli, $_POST['nature-of-activity']);
  $purpose = mysqli_escape_string($student_org->mysqli, $_POST['purpose']);
  $beneficiaries = mysqli_escape_string($student_org->mysqli, $_POST['beneficiaries']);
  $target_output = mysqli_escape_string($student_org->mysqli, $_POST['target-output']);

  if($student_org->isExisted('plan_of_activities', ['name_of_activity'=>$name_of_activity, 'date'=>$date, 'venue'=>$venue, 'sponsors'=>$sponsors, 'nature_of_activity'=>$nature_of_activity, 'purpose'=>$purpose, 'beneficiaries'=>$beneficiaries, 'target_output'=>$target_output, 'name_of_org'=>User::returnValueSession('name_of_org')])) {

    $plan_of_activity_exist = 'Plan of Activity already Exist';

  } else {

    $student_org->insertData('plan_of_activities', ['name_of_activity'=>$name_of_activity, 'date'=>$date, 'venue'=>$venue, 'sponsors'=>$sponsors, 'nature_of_activity'=>$nature_of_activity, 'purpose'=>$purpose, 'beneficiaries'=>$beneficiaries, 'target_output'=>$target_output, 'name_of_org'=>User::returnValueSession('name_of_org'), 'school_year'=>$student_org_school_year]);

    header('location: student-org-plan-of-activities.php');

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
        <button class="dropbtn"><i class="fa-solid fa-user"></i> <?php User::printSession('name_of_org'); ?></button>
        <div class="dropdown-content">
          <a href="#"><i class="fa-solid fa-address-card"></i> My Profile</a>
          <a href="../logout.php?logout=student-org"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav style="position: sticky; top: 4vh;">
          <ul>
            <li onclick="window.location.href='student-org-homepage.php'">Dashboard</li>
            <li onclick="window.location.href='student-org-monitor-election.php'" class="mb-4 border-bottom border-dark">Monitor Election Result </li>
            <li onclick="window.location.href='student-org-plan-of-activities.php'" class="bg-dark-gray2">Plan of Activities</li>
            <li onclick="window.location.href='student-org-accomplishment-report.php'" class="mb-4 border-bottom border-dark">Accomplishment Report</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Submit Plan of Activity > Add Plan of Acvitity</h5>
          </div>
          <h3 class="text-center">Add Plan of Activity</h3>

          <form method="post" class="d-flex flex-column border border-dark-subtle shadow p-3 rounded-3 mb-3 mx-auto" style="max-width: 20rem;">
            <?php 
              if(isset($plan_of_activity_exist)) {
                echo "
                <div class='alert alert-danger' role='alert'>
                  $plan_of_activity_exist
                </div>
                ";
              }
            ?>
            <label class="form-label" for="name-of-activity">Name of Activity: </label>
            <input class="form-control" type="text" name="name-of-activity" required>
            <label class="form-label" for="date">Date: </label>
            <input class="form-control" type="date" name="date" required>
            <label class="form-label" for="venue">Venue: </label>
            <input class="form-control" type="text" name="venue" required>
            <label class="form-label" for="sponsors">Sponsors : </label>
            <input class="form-control" type="text" name="sponsors" required>
            <label class="form-label" for="nature-of-activity">Nature of Activity: </label>
            <input class="form-control" type="text" name="nature-of-activity" required>
            <label class="form-label" for="purpose">Purpose : </label>
            <input class="form-control" type="text" name="purpose" required>
            <label class="form-label" for="beneficiaries">Beneficiaries: </label>
            <input class="form-control" type="text" name="beneficiaries" required>
            <label class="form-label" for="target-output">Target Output: </label>
            <input class="form-control" type="text" name="target-output" required>
            <div class="d-flex justify-content-center align-items-center mt-3">
              <input class="btn btn-primary shadow me-2" type="submit" name="submit">
              <a class="btn btn-danger shadow" href="student-org-plan-of-activities.php">Cancel</a>
            </div>
            
          </form>
        </div>
      </div>
    </div>

  </div>

  <script defer>
    let activeLink = document.getElementById("<?php User::printGet('user'); ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";
  </script>
</body>

</html>