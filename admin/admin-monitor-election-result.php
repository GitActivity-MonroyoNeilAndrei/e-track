<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');


session_start();

$admin = new database();

User::ifNotLogin('admin-username', '../login-account/login-admin.php');


if (!isset($_GET['activeStudentOrg'])) {
  $result = $admin->selectDistinct('student_org', 'name_of_org');

  $row = mysqli_fetch_assoc($result);
  header("location: admin-monitor-election-result.php?activeStudentOrg=$row[name_of_org]");
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
          <a href="#">My Profile</a>
          <a href="../logout.php?logout=admin">Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav style="position: sticky; top: 4vh;">
          <ul>
          <li onclick="window.location.href='admin-homepage.php'">Dashboard</li>
            <li onclick="window.location.href='admin-list-of-users.php'" class="mb-4 border-bottom border-dark">List of Users</li>
            <li onclick="window.location.href='admin-election.php'">Election</li>
            <li onclick="window.location.href='admin-monitor-election-result.php'" class="mb-4 border-bottom border-dark bg-dark-gray2">Monitor Election Result </li>
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
            <h5>Monitor Election</h5>
          </div>
          <nav class="org-list-nav">
            <ul>
              <?php
              $result = $admin->selectDistinct('student_org', 'name_of_org');
              while ($row = mysqli_fetch_assoc($result)) {
              ?>

                <li id="<?php echo $row['name_of_org']; ?>" onclick="window.location.href = 'admin-monitor-election-result.php?activeStudentOrg=<?php echo $row['name_of_org'] ?>';"><?php echo $row['name_of_org']; ?></li>

              <?php } ?>
            </ul>
          </nav>




          <!-- Monitors and Displays the deployed ballot to all users  -->


          <?php

          $positions = ['President', 'Vice President', 'Secretary', 'Treasurer', 'Auditor', 'PIO', 'Project Manager', 'Sargeant at Arms', 'Muse', 'Escort'];

          $result2 = $admin->select('candidate', '*', ['org_name' => User::returnValueGet('activeStudentOrg')]);
          $row2 = mysqli_fetch_assoc($result2);

          if (empty($row2)) {
            echo "<h2 class='text-center'>Nothing to Show</h2>";
          } else {

            if ($row2['exp_date'] > $date_time_now) {

          ?>
              <h4 class="text-center fw-semibold">Election Results for <?php User::printGet('activeStudentOrg'); ?></h4>
              <?php
              $positions = ['President', 'Vice President', 'Secretary', 'Treasurer', 'Auditor', 'PIO', 'Project Manager', 'Sargeant at Arms', 'Muse', 'Escort'];

              foreach ($positions as $position) {
              ?>

                <div class="table-responsive mb-4">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th class="text-center" colspan="4">
                          <h4 class="fw-medium bg-success-subtle"><?php echo $position; ?></h4>
                        </th>
                      </tr>
                      <tr>
                        <th>Name</th>
                        <th>Partylist</th>
                        <th>Vote Count</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $result3 = $admin->select('candidate', '*', ['org_name' => User::returnValueGet('activeStudentOrg'), 'position' => $position]);

                      while ($row = mysqli_fetch_assoc($result3)) {

                      ?>
                        <tr>
                          <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                          <td><?php echo $row['partylist']; ?></td>
                          <td><?php echo $row['number_of_votes']; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>

          <?php }
            }
          } ?>

          <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
          <!-- Monitors and Displays the deployed ballot to all users  -->



          <!-- diplays the winners of the election, and a button that will officially declare the officers -->

          <?php

          if (empty($row2)) {
            // do nothing
          } else if ($row2['exp_date'] <= $date_time_now) {
            $limit = 1;
          ?>

            <h4 class="text-center fw-semibold">Final Election Results for <?php User::printGet('activeStudentOrg'); ?></h4>
            <?php
            $positions = ['President', 'Vice President', 'Secretary', 'Treasurer', 'Auditor', 'PIO', 'Project Manager', 'Sargeant at Arms', 'Muse', 'Escort'];

            foreach ($positions as $position) {
              if (
                $position == 'PIO' ||
                $position == 'Project Manager' ||
                $position == 'Sargeant at Arms'
              ) {
                $limit = 2;
              }
            ?>
              <div class="table-responsive mb-4">
                <table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th class="text-center" colspan="4">
                        <h4 class="fw-medium bg-info"><?php echo $position; ?></h4>
                      </th>
                    </tr>
                    <tr>
                      <th>Name</th>
                      <th>Partylist</th>
                      <th>Vote Count</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    $connection = new mysqli('localhost', 'root', '', 'etrack');
                    $org_name = User::returnValueGet('activeStudentOrg');
                    $sql = "SELECT * FROM candidate WHERE org_name = '$org_name' AND position = '$position' ORDER BY number_of_votes DESC LIMIT $limit";
                    $result3 = $connection->query($sql);

                    // $result3 = $admin->select('candidate', '*', ['org_name' => User::returnValueGet('activeStudentOrg'), 'position' => $position]);

                    while ($row = mysqli_fetch_assoc($result3)) {

                      $admin->updateData('candidate', ['status'=>'winner'], ['id'=>$row['id']]);

                    ?>
                      <tr>
                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                        <td><?php echo $row['partylist']; ?></td>
                        <td><?php echo $row['number_of_votes']; ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>


            <?php } ?>

            <div class="text-center">
              <a class="btn btn-success" href="../election-winners.php?studentOrg=<?php User::printGet('activeStudentOrg'); ?>">Release</a>
            </div>
            


          <?php } ?>

          <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
          <!-- diplays the winners of the election, and a button that will officially declare the officers -->


        </div>
      </div>
    </div>

  </div>

  <script defer>
    let activeLink = document.getElementById("<?php User::printGet('activeStudentOrg') ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";
  </script>
</body>

</html>