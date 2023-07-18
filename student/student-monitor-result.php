<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();
date_default_timezone_set('Asia/Manila');

$student = new database();


if (!isset($_SESSION['student_id'])) {
  header('login-student.php');
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
        <button class="dropbtn"><?php User::printSession('student_name') ?></button>
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
            <li onclick="window.location.href='student-monitor-result.php'" class="bg-dark-gray2">Monitor Election Result</li>
            <li onclick="window.location.href='student-monitor-activities.php'">Monitor Activities</li>

          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5 class="text-start">Monitor Election Results</h5>
          </div>

          <?php

          $result = $student->select('student', '*', ['student_id' => User::returnValueSession('student_id')]);
          $org = mysqli_fetch_assoc($result);


          $result2 = $student->select('candidate', 'exp_date', ['org_name'=>$org['can_monitor']]);
          $exp_date = mysqli_fetch_assoc($result2);

          $date_time_now = date('Y-m-d') . 'T' . date('H:i');


          if ($org['can_monitor'] == NULL || $org['can_monitor'] == "") {
            echo "<h4 class='text-center'>No Voting Result Available</h4>";
          } else if ($exp_date['exp_date'] > $date_time_now) {
          ?>

            <h4 class="text-center fw-semibold">Election Results for <?php echo $org['can_monitor']; ?></h4>
            <?php
            $positions = ['President', 'Vice President', 'Secretary', 'Treasurer', 'Auditor', 'PIO', 'Project Manager', 'Sargeant at Arms', 'Muse', 'Escort'];

            foreach ($positions as $position) {

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
                    $result3 = $student->select('candidate', '*', ['org_name' => $org['can_monitor'], 'position' => $position]);

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
          }else {
            $student->updateData('student', ['can_monitor'=>''], ['student_id'=>User::returnValueSession('student_id')]);
          } ?>

        </div>
      </div>
    </div>
  </div>
</body>

</html>