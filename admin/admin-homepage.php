<?php
  include '../classes/database.php';
  include '../classes/message.php';
  include '../classes/user.php';
  session_start();


  User::ifNotLogin('admin-username', '../login-account/login-admin.php')

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Home Page</title>
  <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
  <link rel="stylesheet" href="../css/bootstrap.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">

</head>

<body>
  <div class="body">
    <div class="header bg-green-1">
      <div class="d-flex align-items-center"><img class="header-logo" src="../images/msc_logo.png" alt="msc logo">
        <h3 class=" header-texts">MARINDUQUE STATE COLLEGE</h3>
      </div>
      <div class="dropdown">
        <button class="dropbtn">Surename, First Name</button>
        <div class="dropdown-content">
          <a href="#">My Profile</a>
          <a href="../logout.php?logout=admin">Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav style="position: sticky; top: 4vh;">
          <ul>
          <li onclick="window.location.href='admin-homepage.php'" class="bg-dark-gray2">Dashboard</li>
            <li onclick="window.location.href='admin-election.php'">Election</li>
            <li onclick="window.location.href='admin-student-organization.php'">Student Organization</li>
            <li onclick="window.location.href='admin-plan-of-activities.php'">Plan of Activities</li>
            <li onclick="window.location.href='admin-accomplishment-report.php'">Accomplishment Report</li>
            <li onclick="window.location.href='admin-evaluation-of-activities.php'">Evaluation of Activities</li>
            <li onclick="window.location.href='admin-report-to-ovpsas.php'">Report to OVPSAS</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Monitor Election</h5>
          </div>
          <nav class="org-list-nav">
            <ul>
              <li>SICSSO</li>
              <li>ITSO</li>
              <li>ESO</li>
              <li>SCpES</li>
              <li>ESO</li>
            </ul>
          </nav>


        </div>
      </div>
    </div>

  </div>
</body>

</html>
