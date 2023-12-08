<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');


session_start();

$admin = new database();

User::ifNotLogin('admin-username', '../login-account/login-user.php');

$school_year2 = User::returnValueGet('schoolYear');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id'=>$admin_id]), '../logout.php?logout=admin');


if (!isset($_GET['activeStudentOrg'])) {
  $result = $admin->selectDistinct('student_org', 'name_of_org');

  $row = mysqli_fetch_assoc($result);
  header("location: admin-report-to-ovpsas.php?activeStudentOrg=$row[name_of_org]");
} else {
  if(!isset($_GET['schoolYear'])) {
    $result = $admin->selectDistinct('accomplishment_reports', 'school_year');
    $row = mysqli_fetch_assoc($result);

    $school_year = $row['school_year'];
    if($activeStudentOrg == "") {
      $activeStudentOrg = User::returnValueGet('activeStudentOrg');
      header("location: admin-report-to-ovpsas.php?activeStudentOrg=$activeStudentOrg&schoolYear=$school_year");
    } else {
      header("location: admin-report-to-ovpsas.php?activeStudentOrg=$activeStudentOrg&schoolYear=$school_year");

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
            <h5>Generate Report</h5>
          </div>

          <nav class="org-list-nav">
            <ul>
              <?php
              $result = $admin->selectDistinct('student_org', 'name_of_org');
              while ($row = mysqli_fetch_assoc($result)) {
              ?>

                <li id="<?php echo $row['name_of_org']; ?>" onclick="window.location.href = 'admin-report-to-ovpsas.php?activeStudentOrg=<?php echo $row['name_of_org'] ?>';"><?php echo $row['name_of_org']; ?></li>

              <?php } ?>
            </ul>
          </nav>

          <form method="post" class="mx-auto text-center" style="max-width: 10rem;">
            <select class="form-select" name="school-year">
              <?php 
                $school_year = $admin->selectDistinct('accomplishment_reports', 'school_year', ['name_of_org'=>User::returnValueGet('activeStudentOrg')]);

                while ($row = mysqli_fetch_assoc($school_year)) {
              ?>

              <option value="<?php echo $row['school_year'] ?>" <?php if($school_year2 == $row['school_year']) {echo 'selected';} ?>><?php echo $row['school_year'] ?></option>

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
            }
          ?>
          <div class="d-flex flex-column  mt-4">
            <!-- <a class="btn btn-primary mx-auto mb-3" href="../generate-report/plan-of-activity-report.php">Plan of Acitivity</a> -->
            <a class="btn btn-primary mx-auto mb-3" href="../generate-report/accomplishment-report.php?activeStudentOrg=<?php User::printGet('activeStudentOrg') ?>&schoolYear=<?php echo $school_year2; ?>">Accomplishment Report</a>
          </div>

        </div>
      </div>
    </div>

    <?php
    require 'admin-footer.php';
  ?>

  </div>
  <script defer>
    let activeLink = document.getElementById("<?php User::printGet('activeStudentOrg') ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";

    
    var activeNav = document.getElementById('report-to-ovpsas')
    activeNav.classList.add('bg-dark-gray2');
  

  </script>
</body>

</html>