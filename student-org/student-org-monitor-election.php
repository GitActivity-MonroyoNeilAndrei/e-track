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
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monitor Election</title>
  <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
  <link rel="stylesheet" href="../css/bootstrap/bootstrap.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/admin.css?<?php echo time(); ?>">
  <script src="https://kit.fontawesome.com/ba2dc1cde9.js" crossorigin="anonymous"></script>
  <script src="https://cdn.plot.ly/plotly-2.26.0.min.js" charset="utf-8"></script>
  <style>
    .table-responsive {
      max-width: 35rem;
      margin: auto;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      border-radius: 8px;
    }

    h4 {
      border-radius: 4px;
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
          <a href="../logout.php?logout=student_org"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav style="position: sticky; top: 4vh;">
          <ul>
            <li onclick="window.location.href='student-org-homepage.php'">Dashboard</li>
            <li onclick="window.location.href='student-org-monitor-election.php'" class="mb-4 border-bottom border-dark bg-dark-gray2">Monitor Election Result </li>
            <li onclick="window.location.href='student-org-plan-of-activities.php'">Plan of Activities</li>
            <li onclick="window.location.href='student-org-monitor-activities.php'">Monitor Plan of Activities</li>
            <li onclick="window.location.href='student-org-accomplishment-report.php'" class="mb-4 border-bottom border-dark">Accomplishment Report</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Monitor Election</h5>
          </div>




          <!-- Monitors and Displays the deployed ballot to all users  -->


          <?php

          $positions = ['President', 'Vice President', 'Secretary', 'Treasurer', 'Auditor', 'PIO', 'Project Manager', 'Sargeant at Arms', 'Muse', 'Escort'];

          $result2 = $student_org->select('candidate', '*', ['org_name' => User::returnValueSession('name_of_org')]);
          $row2 = mysqli_fetch_assoc($result2);

          if (empty($row2)) {
            echo "<h2 class='text-center'>Nothing to Show</h2>";
          } else {

            if ($row2['exp_date'] > $date_time_now) {

          ?>
              <h4 class="text-center fw-semibold">Election Results for <?php User::printSession('name_of_org'); ?></h4>
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
                      $result3 = $student_org->select('candidate', '*', ['org_name' => User::returnValueSession('name_of_org'), 'position' => $position]);

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

            <h4 class="text-center fw-semibold">Final Election Results for <?php User::printSession('name_of_org'); ?></h4>
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
                    $org_name = User::returnValueSession('name_of_org');
                    $sql = "SELECT * FROM candidate WHERE org_name = '$org_name' AND position = '$position' ORDER BY number_of_votes DESC LIMIT $limit";
                    $result3 = $connection->query($sql);

                    // $result3 = $student_org->select('candidate', '*', ['org_name' => User::returnValueGet('activeStudentOrg'), 'position' => $position]);

                    while ($row = mysqli_fetch_assoc($result3)) {

                      $student_org->updateData('candidate', ['status'=>'winner'], ['id'=>$row['id']]);

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

              <div class="graph mx-auto" id="<?php echo $position; ?>"></div>


            <?php } ?>

            


          <?php } ?>

          <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
          <!-- diplays the winners of the election, and a button that will officially declare the officers -->


        </div>
      </div>
    </div>

  </div>


  <?php 
    if (empty($row2)) {
      // do nothing
    } else if ($row2['exp_date'] <= $date_time_now) {

    $positions = ['President', 'Vice President', 'Secretary', 'Treasurer', 'Auditor', 'PIO', 'Project Manager', 'Sargeant at Arms', 'Muse', 'Escort'];

    foreach ($positions as $position) {

      $xArray = array();
      $yArray = array();



      $connection = new mysqli('localhost', 'root', '', 'etrack');
      $org_name = User::returnValueSession('name_of_org');
      $sql = "SELECT * FROM candidate WHERE org_name = '$org_name' AND position = '$position' ORDER BY number_of_votes DESC";
      $result3 = $connection->query($sql);

      // $result3 = $admin->select('candidate', '*', ['org_name' => User::returnValueGet('activeStudentOrg'), 'position' => $position]);

      while ($row = mysqli_fetch_assoc($result3)) {
        array_push($xArray, "$row[first_name] $row[last_name]");
        array_push($yArray, "$row[number_of_votes]");


      }
    ?>

    <script>        
        Plotly.newPlot("<?php echo $position; ?>",
        [{
          x:[
            <?php 
              $first = true;
              foreach ($xArray as $xarr) { 
              ?>
                "<?php echo $xarr; ?>" ,
              <?php } ?>
            ],
            y:[
            <?php 
              $first = true;
              foreach ($yArray as $yarr) { 
              ?>
                parseInt(<?php echo $yarr; ?>) ,

              <?php } ?>
            ],
          type:"bar"
        }]
        , {title:"<?php echo $position; ?> Graph Representation"});
    </script>

  <?php 
    }

  }
  ?>
</body>

</html>