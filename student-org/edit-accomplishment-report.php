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



$id = User::returnValueGet('id');

if($_SERVER['REQUEST_METHOD'] == 'GET') {
  $accomplishment_report = $student_org->select('accomplishment_reports', '*', ['id'=>$id]);
  $row = mysqli_fetch_assoc($accomplishment_report);

  $planned_activity = $row['planned_activity'];
  $purpose = $row['purpose'];
  $date_accomplished = $row['date_accomplished'];
  $budget = $row['budget'];
  $remarks = $row['remarks'];

}else if(isset($_POST['submit'])) {
  if($student_org->isExisted('accomplishment_reports', ['planned_activity'=>$planned_activity, 'purpose'=>$purpose, 'date_accomplished'=>$date_accomplished, 'budget'=>$budget, 'remarks'=>$remarks, 'name_of_org'=>User::returnValueSession('name_of_org')])) {
    $accomplishment_report_exist = 'Accomplishment Report already Exist';
    
  }

  $planned_activity = $_POST['planned-activity'];
  $purpose = $_POST['purpose'];
  $date_accomplished = $_POST['date-accomplished'];
  $budget = $_POST['budget'];
  $remarks = $_POST['remarks'];


  $student_org->updateData('accomplishment_reports', ['planned_activity'=>$planned_activity, 'purpose'=>$purpose, 'date_accomplished'=>$date_accomplished, 'budget'=>$budget, 'remarks'=>$remarks, 'name_of_org'=>User::returnValueSession('name_of_org')], ['id'=>$id]);

  header('location: student-org-accomplishment-report.php');
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
    <?php
      require 'student-org-navigations.php';
    ?>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Submit AccomplishmentReport > Edit Accomplishment Report</h5>
          </div>
          <h3 class="text-center">Edit Accomplishment Report</h3>

          <form method="post" class="d-flex flex-column border border-dark-subtle shadow p-3 rounded-3 mb-3 mx-auto" style="max-width: 20rem;">
            <?php 
              if(isset($accomplishment_report_exist)) {
                echo "
                <div class='alert alert-danger' role='alert'>
                  $accomplishment_report_exist
                </div>
                ";
              }
            ?>
            <label class="form-label" for="planned-activity">Planned Activity: </label>
            <input class="form-control" type="text" name="planned-activity" value="<?php echo $planned_activity; ?>" required>
            <label class="form-label" for="purpose">purpose: </label>
            <input class="form-control" type="text" name="purpose" value="<?php echo $purpose; ?>" required>
            <label class="form-label" for="date-accomplished">Date accomplished: </label>
            <input class="form-control" type="date" name="date-accomplished" value="<?php echo $date_accomplished; ?>" required>
            <label class="form-label" for="budget">Budget: </label>
            <input class="form-control" type="text" name="budget" value="<?php echo $budget; ?>">
            <label class="form-label" for="remarks">Remarks: </label>
            <input class="form-control" type="text" name="remarks" value="<?php echo $remarks; ?>" required>
            <div class="d-flex justify-content-center align-items-center mt-3">
              <input class="btn btn-primary shadow me-2" type="submit" name="submit" value="Edit">
              <a class="btn btn-danger" href="student-org-plan-of-activities.php">Cancel</a>
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