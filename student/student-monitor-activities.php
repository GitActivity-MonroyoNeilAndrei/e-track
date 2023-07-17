<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Home Page</title>
  <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
  <link rel="stylesheet" href="../css/bootstrap.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/student.css?<?php echo time(); ?>">
</head>

<body>
  <div class="body">
    <div class="header bg-green-1">
      <div class="d-flex align-items-center"><img class="header-logo" src="../images/msc_logo.png" alt="msc logo">
        <h3 class=" header-texts">MARINDUQUE STATE COLLEGE</h3>
      </div>
      <div class="dropdown">
        <button class="dropbtn"></button>
        <div class="dropdown-content">
          <a href="#">My Profile</a>
          <a href="../logout.php?logout=student">Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav style="position: sticky; top: 4vh;">
          <ul>
            <li onclick="window.location.href='student-vote.php'">Vote</li>
            <li onclick="window.location.href='student-view-results.php'">View Election Results</li>
            <li onclick="window.location.href='student-monitor-activities.php'" class="bg-dark-gray2">Monitor Activities</li>

          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Deploy Ballot</h5>
          </div>
          <nav class="org-list-nav">
            <ul>

            </ul>
          </nav>

          <div class="container-add-candidate">
            <h5 class="text-center py-1">THIS IS THE MONITOR ACTIVITIES PAGE</h5>
          </div>

        </div>
      </div>
    </div>
  </div>
</body>

</html>