<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');


session_start();

$student_org = new database();

User::ifNotLogin('name_of_org', '../login-account/login-user.php');

$student_org_id = User::returnValueSession('student-org-id');

User::ifDeactivatedReturnTo($student_org->select('student_org', 'status', ['id'=>$student_org_id]), '../logout.php?logout=student-org');


$current_school_year = mysqli_fetch_assoc($student_org->selectDistinct('admin', 'current_school_year'))['current_school_year'];
$school_year2 = User::returnValueGet('schoolYear');

$school_years = array();

$school_year_accomplishment_report = $student_org->selectDistinct('accomplishment_reports', 'school_year', ['name_of_org'=>User::returnValueSession('name_of_org')]);

while ($row = mysqli_fetch_assoc($school_year_accomplishment_report)) {
  array_push($school_years, $row['school_year']);
}

$school_year_plan_of_activity = $student_org->selectDistinct('plan_of_activities', 'school_year', ['name_of_org'=>User::returnValueSession('name_of_org')]);

while ($row = mysqli_fetch_assoc($school_year_plan_of_activity)) {
  if(!in_array($row['school_year'], $school_years)) {
    array_push($school_years, $row['school_year']);
  }
  
}






if (!isset($_GET['activeStudentOrg'])) {
  $result = $student_org->selectDistinct('student_org', 'name_of_org');

  $row = mysqli_fetch_assoc($result);
  header("location: student-org-generate-report.php?activeStudentOrg=$row[name_of_org]");
} else {
  if(!isset($_GET['schoolYear'])) {
    $result = $student_org->selectDistinct('accomplishment_reports', 'school_year');
    $row = mysqli_fetch_assoc($result);

    $school_year = $row['school_year'];
    if($activeStudentOrg == "") {
      $activeStudentOrg = User::returnValueGet('activeStudentOrg');
      header("location: student-org-generate-report.php?activeStudentOrg=$activeStudentOrg&schoolYear=$school_year");
    } else {
      header("location: student-org-generate-report.php?activeStudentOrg=$activeStudentOrg&schoolYear=$school_year");

    }

  }
}

if(isset($_POST['submit'])) {
  $school_year3 = $_POST['school-year'];
  $activeStudentOrg = User::returnValueSession('name_of_org');

  header("location: student-org-generate-report.php?activeStudentOrg=$activeStudentOrg&schoolYear=$school_year3");

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Generate Report</title>
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
          <a href="../logout.php?logout=studentOrg"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
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
            <h5>Generate Report</h5>
          </div>

          <form method="post" class="mx-auto text-center" style="max-width: 10rem;">
            <select class="form-select" name="school-year">
              
              <?php
                foreach ($school_years as $school_year) {
              ?>
              <option value="<?php echo $school_year ?>" <?php if($current_school_year == $school_year) {echo 'selected';} ?>><?php echo $school_year ?></option>

              <?php } ?>

            </select>
            <input class="btn btn-secondary mt-2" type="submit" name="submit" value="Select">
          </form>

          <h3 class="text-center">Generate Report for <?php User::printGet('activeStudentOrg') ?></h3>

          <?php
            if (isset($_GET['noReport'])) {
              echo '
              <div class="alert alert-danger" role="alert">
                Couldn\'t Generate Report
              </div>
              ';
            } else if (isset($_GET['noReport2'])) {
              echo '
              <div class="alert alert-danger" role="alert">
                Couldn\'t Generate Plan of Activity
              </div>
              ';
            }
          ?>
          <div class="d-flex flex-column  mt-4">
            <!-- <a class="btn btn-primary mx-auto mb-3" href="../generate-report/plan-of-activity-report.php">Plan of Acitivity</a> -->
            <a class="btn btn-primary mx-auto mb-3" href="../generate-report/accomplishment-report.php?activeStudentOrg=<?php User::printSession('name_of_org') ?>&schoolYear=<?php echo $school_year2; ?>">Accomplishment Report</a>
            <a class="btn btn-primary mx-auto mb-3" href="../generate-report/plan-of-activity-report.php?activeStudentOrg=<?php User::printSession('name_of_org') ?>&schoolYear=<?php echo $school_year2; ?>">Plan of Activity</a>
          </div>

        </div>
      </div>
    </div>

    <?php
    require 'student-org-footer.php';
  ?>

  </div>
  <script defer>


    
    var activeNav = document.getElementById('generate-report')
    activeNav.classList.add('bg-dark-gray2');
  

  </script>
</body>

</html>