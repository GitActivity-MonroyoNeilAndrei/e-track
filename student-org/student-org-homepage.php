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

User::ifDeactivatedReturnTo($student_org->select('student_org', 'status', ['id' => $student_org_id]), '../logout.php?logout=student-org');

$name_of_org = User::returnValueSession('name_of_org');

$drafted_plan_of_activities = $student_org->countSelect('plan_of_activities', 'status', "status = 'draft' AND name_of_org = '$name_of_org'");
$drafted_accomplishment_reports = $student_org->countSelect('accomplishment_reports', 'status', "status = 'draft' AND name_of_org = '$name_of_org'");




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
  <style>
    .wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
    }

    .card {
      width: 18rem;
      height: 8rem;
      border: none;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      padding: .7rem;
    }

    .wrapper-a {
      margin: .8rem .8rem;
    }

    @media (max-width: 900px) {
      .wrapper {
        flex-wrap: wrap;
        margin-bottom: 0;
      }

    }


    .card-text {
      font-family: Arial, Helvetica, sans-serif;
      color: white;
    }

    .card-pink {
      background-color: #DA526DCB;
    }

    .card-pink:hover {
      background-color: #DA526DF4;
    }

    .card-bluegreen {
      background-color: #3A997FCB;
    }

    .card-bluegreen:hover {
      background-color: #3A997FF4;
    }

    .card-orange {
      background-color: #EA8D58CB;
    }

    .card-orange:hover {
      background-color: #EA8D58F4;
    }

  </style>

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
            <h5>Monitor Election</h5>
          </div>

          <h3 class="text-center fw-normal" style="color: rgba(0, 0, 0, 0.8.4);">Student Org. Dashboard</h3>
          <div class="wrapper">
            <a class="wrapper-a" href="student-org-plan-of-activities.php">
              <div class="card card-pink">
                <h5 class="fw-semibold card-text">Drafted Plan of Activities</h5>
                <h3 class="fw-semibold card-text"><?php echo $drafted_plan_of_activities; ?></h3>
              </div>
            </a>

            <a class="wrapper-a" href="student-org-monitor-activities.php">
              <div class="card card-bluegreen">
                <h5 class="fw-semibold card-text">Monitor Plan of Activities</h5>
                <h3 class="fw-semibold card-text"></h3>
              </div>
            </a>

            <a class="wrapper-a" href="student-org-accomplishment-report.php">
              <div class="card card-orange">
                <h5 class="fw-semibold card-text">Drafted Accomplishment Reports</h5>
                <h3 class="fw-semibold card-text"><?php echo $drafted_accomplishment_reports; ?></h3>
              </div>
            </a>

          </div>
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
</body>

</html>