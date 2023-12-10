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

$name_of_activity = '';
$date = '';
$venue = '';
$sponsors = '';
$nature_of_activity = '';
$purpose = '';
$beneficiaries = '';
$target_output = '';

$id = User::returnValueGet('id');

if($_SERVER['REQUEST_METHOD'] == 'GET') {
  $plan_of_activity = $student_org->select('plan_of_activities', '*', ['id'=>$id]);
  $row = mysqli_fetch_assoc($plan_of_activity);

  $name_of_activity = $row['name_of_activity'];
  $date = $row['date'];
  $venue = $row['venue'];
  $sponsors = $row['sponsors'];
  $nature_of_activity = $row['nature_of_activity'];
  $purpose = $row['purpose'];
  $beneficiaries = $row['beneficiaries'];
  $target_output = $row['target_output'];

}else if(isset($_POST['submit'])) {
  if($student_org->isExisted('plan_of_activities', ['name_of_activity'=>$name_of_activity, 'date'=>$date, 'venue'=>$venue, 'sponsors'=>$sponsors, 'nature_of_activity'=>$nature_of_activity, 'purpose'=>$purpose, 'beneficiaries'=>$beneficiaries, 'target_output'=>$target_output, 'name_of_org'=>User::returnValueSession('name_of_org')])) {
    $plan_of_activity_exist = 'Plan of Activity already Exist';
    
  }

  $name_of_activity = $_POST['name-of-activity'];
  $date = $_POST['date'];
  $venue = $_POST['venue'];
  $sponsors = $_POST['sponsors'];
  $nature_of_activity = $_POST['nature-of-activity'];
  $purpose = $_POST['purpose'];
  $beneficiaries = $_POST['beneficiaries'];
  $target_output = $_POST['target-output'];

  $student_org->updateData('plan_of_activities', ['name_of_activity'=>$name_of_activity, 'date'=>$date, 'venue'=>$venue, 'sponsors'=>$sponsors, 'nature_of_activity'=>$nature_of_activity, 'purpose'=>$purpose, 'beneficiaries'=>$beneficiaries, 'target_output'=>$target_output, 'name_of_org'=>User::returnValueSession('name_of_org')], ['id'=>$id]);

  header('location: student-org-plan-of-activities.php');
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
            <h5>Submit Plan of Activity > Edit Plan of Acvitity</h5>
          </div>
          <h3 class="text-center">Edit Plan of Activity</h3>

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
            <input class="form-control" type="text" name="name-of-activity" value="<?php echo $name_of_activity; ?>" required>
            <label class="form-label" for="date">Date: </label>
            <input class="form-control" type="date" name="date" value="<?php echo $date; ?>" required>
            <label class="form-label" for="venue">Venue: </label>
            <input class="form-control" type="text" name="venue" value="<?php echo $venue; ?>" required>
            <label class="form-label" for="sponsors">Sponsors : </label>
            <input class="form-control" type="text" name="sponsors" value="<?php echo $sponsors; ?>">
            <label class="form-label" for="nature-of-activity">Nature of Activity: </label>
            <input class="form-control" type="text" name="nature-of-activity" value="<?php echo $nature_of_activity; ?>" required>
            <label class="form-label" for="purpose">Purpose : </label>
            <input class="form-control" type="text" name="purpose" value="<?php echo $purpose; ?>" required>
            <label class="form-label" for="beneficiaries">Beneficiaries: </label>
            <input class="form-control" type="text" name="beneficiaries" value="<?php echo $beneficiaries; ?>" required>
            <label class="form-label" for="target-output">Target Output: </label>
            <input class="form-control" type="text" name="target-output" value="<?php echo $target_output; ?>" required>
            <div class="d-flex justify-content-center align-items-center mt-3">
              <input class="btn btn-primary shadow me-2" type="submit" name="submit" value="Edit">
              <a class="btn btn-danger" href="student-org-plan-of-activities.php">Cancel</a>
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
    var activeNav = document.getElementById('plan-of-activity')
    activeNav.classList.add('bg-dark-gray2');
  </script>
</body>

</html>