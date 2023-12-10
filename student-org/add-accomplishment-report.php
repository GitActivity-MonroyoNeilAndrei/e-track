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



// new code
if(isset($_POST['submit'])) {

  if(!$student_org->checkIfPDF('liquidation')) {
    $error_file = "Upload PDF file only";
  } else {
    $plan_of_activity_id = $_POST['planned_of_activity'];
    $budget = $_POST['budget'];
    $remarks = $_POST['remarks'];

    $name_of_acitvity = "";
    $venue = "";
    $sponsors = "";
    $nature_of_activity = "";
    $beneficiaries = "";
    $target_output = "";
    $purpose = "";
    $date_accomplished = "";

    $planned_activity = $student_org->select('plan_of_activities', '*', ['id'=>$plan_of_activity_id]);

    while($row = mysqli_fetch_assoc($planned_activity)){
      $name_of_acitvity = $row['name_of_activity'];
      $venue = $row['venue'];
      $sponsors = $row['sponsors'];
      $nature_of_activity = $row["nature_of_activity"];
      $beneficiaries = $row['beneficiaries'];
      $target_output = $row['target_output'];
      $purpose = $row['purpose'];
      $date_accomplished = $row['date'];
    }
    


    $student_org->insertData('accomplishment_reports', ['planned_activity'=>$name_of_acitvity, 'purpose'=>$purpose, 'date_accomplished'=>$date_accomplished, 'budget'=>$budget, 'remarks'=>$remarks, 'name_of_org'=>User::returnValueSession('name_of_org'), 'date_submitted'=>$date_now, 'school_year'=>$student_org_school_year, 'status'=>'draft', 'venue'=>$venue, 'sponsors'=>$sponsors, 'nature_of_activity'=>$nature_of_activity, 'beneficiaries'=>$beneficiaries, 'target_output'=>$target_output]);

    $student_org->insertPDF('liquidation', 'accomplishment_reports', 'liquidations', '../uploads/');

    $student_org->updateData('plan_of_activities', ['status'=>'accomplished'], ['id'=>$plan_of_activity_id]);

    header('location: student-org-accomplishment-report.php');
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
            <select name="planned_of_activity" class="form-select" required>
              <?php 
                $planned_activity = $student_org->select('plan_of_activities', '*', ['name_of_org'=>User::returnValueSession('name_of_org'), 'school_year'=>$student_org_school_year, 'status'=>'ongoing']);

                while ($row = mysqli_fetch_assoc($planned_activity)) {
              ?>
                <option value="<?php echo $row['id'] ?>"><?php echo $row['name_of_activity'] ?></option>

              <?php
                }
              ?>
            </select>


            <label class="form-label" for="budget">Budget: </label>
            <input class="form-control" type="number" name="budget" required>
            <label class="form-label" for="liquidation">Reports & Liquidation</label>
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

  <?php
    require 'student-org-footer.php';
  ?>

  <script defer>
    let activeLink = document.getElementById("<?php User::printGet('user'); ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";
  </script>

  <script>
    var activeNav = document.getElementById('accomplishment-report')
    activeNav.classList.add('bg-dark-gray2');
  </script>
</body>

</html>