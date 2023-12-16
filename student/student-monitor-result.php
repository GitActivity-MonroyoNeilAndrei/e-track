<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();
date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');




$student = new database();


if (!isset($_SESSION['student_id'])) {
  header('location: ../login-account/login-user.php');
}

$student_id = User::returnValueSession('id');


User::ifDeactivatedReturnTo($student->select('student', 'status', ['id'=>$student_id]), '../logout.php?logout=student');


$can_see_result = "";
$can_monitor = "";

$org_can_view_query = $student->select('student', '*', ['id'=>User::returnValueSession('id')]);

while($row = mysqli_fetch_assoc($org_can_view_query)) {
  $can_see_result = $row['can_see_result'];
  $can_monitor = $row['can_monitor'];
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
  <link rel="stylesheet" href="../css/student.css?<?php echo time(); ?>">
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
      <button class="dropbtn"><i class="fa-solid fa-user"></i> <?php User::printSession('student_name'); ?></button>
        <div class="dropdown-content">
          <a href="student-edit-profile.php"><i class="fa-solid fa-address-card"></i> My Profile</a>
          <a href="../logout.php?logout=student"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav style="position: sticky; top: 4vh;">
          <ul>

            <li onclick="window.location.href='student-vote.php'">
              <span>Vote</span>
              <span><i class="fa-solid fa-check-to-slot"></i></span>
            </li>
            <li onclick="window.location.href='student-monitor-result.php'" class="bg-dark-gray2">
              <span>Monitor Election Result</span>
              <span><i class="fa-solid fa-square-poll-horizontal"></i></span>
            </li>
            <li onclick="window.location.href='student-monitor-activities.php'">
              <span>Monitor Activities</span>
              <span><i class="fa-regular fa-file"></i></span>
            </li>
            <li onclick="window.location.href='student-evaluate-activities.php'">
              <span>Evaluate Activities</span>
              <span><i class="fa-regular fa-file"></i></span>
            </li>

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


          $result2 = $student->select('candidate', 'exp_date', ['org_name' => $org['can_monitor']]);
          $exp_date = mysqli_fetch_assoc($result2);

          $date_time_now = date('Y-m-d') . 'T' . date('H:i');


          if ($org['can_monitor'] == NULL || $org['can_monitor'] == "") {
            if($org['can_see_result'] == "" || $org['can_see_result'] == NULL) {
              echo "<h4 class='text-center'>No Voting Result Available</h4>";
            }
          } else if ($exp_date['exp_date'] > $date_time_now) {
          ?>

            <h4 class="text-center fw-semibold">Election Results for <?php echo $org['can_monitor']; ?></h4>
            <?php

            $positions = array();

            $result = $student->selectDistinct('candidate', 'position', ['org_name' => $can_monitor ]);
            $j = 0;
            while ($row = mysqli_fetch_assoc($result)) {
              $positions[$j] = $row['position'];
              $j++;
            }

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
          } else {
            $student->updateData('student', ['can_monitor' => '', 'can_see_result'=> $org['can_monitor']], ['student_id' => User::returnValueSession('student_id')]);
          } ?>








          <!-- diplays the winners of the election, and a button that will officially declare the officers -->

          <?php


          $result4 = $student->select('student', '*', ['id' => User::returnValueSession('id')]);
          $row2 = mysqli_fetch_assoc($result4);



          $result5 = $student->select('candidate', '*', ['org_name' => $row2['can_see_result']]);
          $row3 = mysqli_fetch_assoc($result5);

          if(!$row3){
            //do nothing
          } else if($row2['can_see_result'] == " ") {
            //do nothing
          }else if ($row3['org_name'] != $row2['can_see_result']) {
            
            // do nothing
          } else if ($row3['exp_date'] <= $date_time_now) {
            $limit = 1;
          ?>

            <h4 class="text-center fw-semibold">Final Election Results for <?php echo $row2['can_see_result']; ?></h4>
            <?php

            $candidateTwoWinners = ["", "", "", "", ""];

            $result = $student->selectDistinct('candidate', 'position, max_winners', ['org_name' => "$can_see_result"]);
            $i = 0;
            while ($row = mysqli_fetch_assoc($result)) {
              if($row['max_winners'] >= 2) {
                $candidateTwoWinners[$i] = $row['position'];
                $i++;
              }
            }

            $positions = array();

            $result = $student->selectDistinct('candidate', 'position', ['org_name' => $can_see_result ]);
            $j = 0;
            while ($row = mysqli_fetch_assoc($result)) {
              $positions[$j] = $row['position'];
              $j++;
            }

            foreach ($positions as $position) {
              if (
                $position == $candidateTwoWinners[0]  ||
                $position == $candidateTwoWinners[1] ||
                $position == $candidateTwoWinners[2] ||
                $position == $candidateTwoWinners[3]
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
                    $org_name = $row2['can_see_result'];
                    $sql = "SELECT * FROM candidate WHERE org_name = '$org_name' AND position = '$position' ORDER BY number_of_votes DESC LIMIT $limit";
                    $result3 = $connection->query($sql);

                    // $result3 = $admin->select('candidate', '*', ['org_name' => User::returnValueGet('activeStudentOrg'), 'position' => $position]);

                    $candidate_count = $student->countSelect('candidate', "*", " org_name = '$org_name' && position = '$position'");


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

              <div class="mx-auto" style="width: <?php echo ($candidate_count * 15) + 30; ?>%;">
                <div class="graph mx-auto" id="<?php echo $position; ?>"></div>
              </div>


            <?php } ?>



          <?php } ?>

          <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
          <!-- diplays the winners of the election, and a button that will officially declare the officers -->






        </div>
      </div>
    </div>
  </div>

  <?php
    require 'student-footer.php';
  ?>


  <?php 
    if (empty($row3)) {
      // do nothing
    } else if ($row3['exp_date'] <= $date_time_now) {



    foreach ($positions as $position) {

      $xArray = array();
      $yArray = array();



      $connection = new mysqli('localhost', 'root', '', 'etrack');
      $org_name = $row2['can_see_result'];
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
                "<?php echo $xarr; ?>",

              <?php } ?>
            ],
            y:[
            <?php 
              $first = true;
              foreach ($yArray as $yarr) { 

              ?>
                parseInt(<?php echo $yarr; ?>),

              <?php } ?>
            ],
          orientation: 'v',
          type:"bar"
        }]
        , {title:"<?php echo $position; ?> Graph Representation"});
    </script>

  <?php 
    }

  }
  ?>
  <script>
    window.addEventListener("focus", function() {
      location.reload();
    });
  </script>
</body>

</html>