<?php
include '../classes/database.php';
include '../classes/message.php';
include '../classes/user.php';
session_start();

$admin = new database();


User::ifNotLogin('admin-username', '../login-account/login-user.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id' => $admin_id]), '../logout.php?logout=admin');

$total_admin_user = $admin->countSelect('admin', 'status', "status = 'activated'");
$total_studentOrg_user = $admin->countSelect('student_org', 'status', "status = 'activated'");
$total_student_user = $admin->countSelect('student', 'status', "status = 'activated'");

$to_validate_plan_of_activities = $admin->countSelect('plan_of_activities', 'status', "status = 'submitted'");
$to_validate_accomplishment_report = $admin->countSelect('accomplishment_reports', 'status', "status = 'submitted'");



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

    .card-darkpink {
      background-color: #C72A49F4;
    }

    .card-darkpink:hover {
      background-color: #C72A49CB;
    }

    .card-darkorange {
      background-color: #D66A2DF4;
    }

    .card-darkorange:hover {
      background-color: #D66A2DCB;
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
        <button class="dropbtn"><i class="fa-solid fa-user"></i> <?php User::printSession('admin-username'); ?></button>
        <div class="dropdown-content">
          <a href="#"><i class="fa-solid fa-address-card"></i> My Profile</a>
          <a href="../logout.php?logout=admin"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav style="position: sticky; top: 4vh;">
          <ul>
            <li onclick="window.location.href='admin-homepage.php'" class="bg-dark-gray2">Dashboard</li>
            <li onclick="window.location.href='admin-list-of-users.php'" class="mb-4 border-bottom border-dark">List of Users</li>
            <li onclick="window.location.href='admin-election.php'">Election</li>
            <li onclick="window.location.href='admin-monitor-election-result.php'" class="mb-4 border-bottom border-dark">Monitor Election Result </li>
            <li onclick="window.location.href='admin-student-organization.php'" class="mb-4 border-bottom border-dark">Student Organization</li>
            <li onclick="window.location.href='admin-plan-of-activities.php'">Plan of Activities</li>
            <li onclick="window.location.href='admin-list-of-plan-of-activities.php'">List of Plan of Activities</li>
            <li onclick="window.location.href='admin-monitor-plan-of-activities.php'" class="mb-4 border-bottom border-dark">Monitor Plan of Activities</li>
            <li onclick="window.location.href='admin-accomplishment-report.php'">Accomplishment Report</li>
            <li onclick="window.location.href='admin-list-of-accomplishment-report.php'" class="mb-4 border-bottom border-dark">List of Accomplishment Report</li>
            <li onclick="window.location.href='admin-evaluation-of-activities.php'">Evaluation of Activities</li>
            <li onclick="window.location.href='admin-report-to-ovpsas.php'">Report to OVPSAS</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Dashboard</h5>
          </div>
          <h3 class="text-center fw-normal" style="color: rgba(0, 0, 0, 0.8.4);">Admin Dashboard</h3>
          <div class="wrapper">
            <a class="wrapper-a" href="admin-list-of-users.php?user=admin">
              <div class="card card-pink">
                <h5 class="fw-semibold card-text">Total Admin User</h5>
                <h3 class="fw-semibold card-text"><?php echo $total_admin_user; ?></h3>
              </div>
            </a>

            <a class="wrapper-a" href="admin-list-of-users.php?user=student_org">
              <div class="card card-bluegreen">
                <h5 class="fw-semibold card-text">Total Student Org. User</h5>
                <h3 class="fw-semibold card-text"><?php echo $total_studentOrg_user; ?></h3>
              </div>
            </a>

            <a class="wrapper-a" href="admin-list-of-users.php?user=student">
              <div class="card card-orange">
                <h5 class="fw-semibold card-text">Total Student User</h5>
                <h3 class="fw-semibold card-text"><?php echo $total_student_user; ?></h3>
              </div>
            </a>

          </div>
          <div class="wrapper">
            <a class="wrapper-a" href="admin-plan-of-activities.php">
              <div class="card card-darkpink">
                <h5 class="fw-semibold card-text">To Validate Plan of Activitiy</h5>
                <h3 class="fw-semibold card-text"><?php echo $to_validate_plan_of_activities; ?></h3>
              </div>
            </a>

            <a class="wrapper-a" href="admin-accomplishment-report.php">
              <div class="card card-darkorange">
                <h5 class="fw-semibold card-text">To Validate Accomplishment Report</h5>
                <h3 class="fw-semibold card-text"><?php echo $to_validate_accomplishment_report; ?></h3>
              </div>
            </a>

          </div>

        </div>
      </div>
    </div>

  </div>
</body>

</html>