<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

date_default_timezone_set('Asia/Manila');
$date_now = date('Y-m-d');


session_start();

$student_org = new database();

User::ifNotLogin('name_of_org', '../login-account/login-user.php');

$student_org_id = User::returnValueSession('student-org-id');

User::ifDeactivatedReturnTo($student_org->select('student_org', 'status', ['id'=>$student_org_id]), '../logout.php?logout=student-org');


$student_org_school_year = User::returnValueSession('school-year');

if(isset($_POST['submit'])) {
  $planned_activity = $_POST['planned-activity'];
  $purpose = $_POST['purpose'];
  $date_accomplished = $_POST['date-accomplished'];
  $budget = $_POST['budget'];
  $remarks = $_POST['remarks'];

  if($student_org->isExisted('accomplishment_reports', ['planned_activity'=>$planned_activity, 'purpose'=>$purpose, 'date_accomplished'=>$date_accomplished, 'budget'=>$budget, 'remarks'=>$remarks, 'name_of_org'=>User::returnValueSession('name_of_org')])) {

    $accomplishment_report_exist = 'Accomplishment Report already Exist';
  } else {
    if(!$student_org->checkIfPDF('liquidation')) {
      $error_file = "Upload PDF file only";
    }else {
    $student_org->insertData('accomplishment_reports', ['planned_activity'=>$planned_activity, 'purpose'=>$purpose, 'date_accomplished'=>$date_accomplished, 'budget'=>$budget, 'remarks'=>$remarks, 'name_of_org'=>User::returnValueSession('name_of_org'), 'date_submitted'=>$date_now, 'school_year'=>$student_org_school_year]);

    $student_org->insertPDF('liquidation', 'accomplishment_reports', 'liquidations', '../uploads/');

    header('location: student-org-accomplishment-report.php');
    }
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
            <li onclick="window.location.href='student-org-monitor-activities.php'">Monitor Plan of Activities</li>
            <li onclick="window.location.href='student-org-accomplishment-report.php'" class="mb-4 border-bottom border-dark">Accomplishment Report</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Submit Accomplishment Report > Add Accomplishment Report</h5>
          </div>
          <h3 class="text-center">Add Accomplishment Report</h3>

          <form method="post" enctype="multipart/form-data" class="d-flex flex-column border border-dark-subtle shadow p-3 rounded-3 mb-3 mx-auto" style="max-width: 20rem;">
            <?php 
              if(isset($accomplishment_report_exist)) {
                echo "
                <div class='alert alert-danger' role='alert'>
                  $accomplishment_report_exist
                </div>
                ";
              }

              if(isset($error_file)){
                echo "
                <div class='alert alert-danger' role='alert'>
                  $error_file
                </div>
                ";
              }
            ?>
            <label class="form-label" for="planned-activity">Planned Activity: </label>
            <input class="form-control" type="text" name="planned-activity" required>
            <label class="form-label" for="purpose">Purpose: </label>
            <input class="form-control" type="text" name="purpose" required>
            <label class="form-label" for="date-accomplished">Date Accomplished: </label>
            <input class="form-control" type="date" name="date-accomplished" required>
            <label class="form-label" for="budget">Budget: </label>
            <input class="form-control" type="number" name="budget" required>
            <label class="form-label" for="liquidation">Liquidation</label>
            <input class="form-control" type="file" name="liquidation" required>
            <label class="form-label" for="remarks">Remarks: </label>
            <input class="form-control" type="text" name="remarks" required>
            <div class="d-flex justify-content-center align-items-center mt-3">
              <input class="btn btn-primary shadow me-2" type="submit" name="submit">
              <a class="btn btn-danger shadow" href="student-org-accomplishment-report.php">Cancel</a>
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