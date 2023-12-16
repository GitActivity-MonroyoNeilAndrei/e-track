<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');


session_start();

$admin = new database();

User::ifNotLogin('admin-username', '../login-account/login-user.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id'=>$admin_id]), '../logout.php?logout=admin');


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

          <?php
            if (isset($_GET['resultReleased'])) {
              echo '
              <div class="alert alert-success" role="alert">
                Election Result has been Released
              </div>
              ';
            }
          ?>


          <!-- Monitors and Displays the deployed ballot to all users  -->


          <?php


          $result2 = $admin->select('candidate', '*', ['org_name' => User::returnValueGet('activeStudentOrg')]);
          $row2 = mysqli_fetch_assoc($result2);

          if (empty($row2)) {
            echo "<h2 class='text-center'>Nothing to Show</h2>";
          } else {

            if ($row2['exp_date'] > $date_time_now) {

          ?>
              <h4 class="text-center fw-semibold">Election Results for <?php User::printGet('activeStudentOrg'); ?></h4>
              <?php


              $positions = array();

              $result = $admin->selectDistinct('candidate', 'position', ['org_name' => User::returnValueGet('activeStudentOrg') ]);
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

            $candidateTwoWinners = ["", "", "", "", ""];

            $result = $admin->selectDistinct('candidate', 'position, max_winners', ['org_name' => User::returnValueGet('activeStudentOrg')]);
            $i = 0;
            while ($row = mysqli_fetch_assoc($result)) {
              if($row['max_winners'] >= 2) {
                $candidateTwoWinners[$i] = $row['position'];
                $i++;
              }
            }

            $positions = array();

            $result = $admin->selectDistinct('candidate', 'position', ['org_name' => User::returnValueGet('activeStudentOrg') ]);
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
                    $org_name = User::returnValueGet('activeStudentOrg');
                    $sql = "SELECT * FROM candidate WHERE org_name = '$org_name' AND position = '$position' ORDER BY number_of_votes DESC LIMIT $limit";
                    $result3 = $connection->query($sql);

                    // $result3 = $admin->select('candidate', '*', ['org_name' => User::returnValueGet('activeStudentOrg'), 'position' => $position]);

                    $candidate_count = $admin->countSelect('candidate', "*", " org_name = '$org_name' && position = '$position'");


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

              <div class="mx-auto" style="width: <?php echo ($candidate_count * 15) + 30; ?>%;">
                <div class="graph mx-auto" id="<?php echo $position; ?>"></div>
              </div>

            <?php } ?>

            <div class="text-center">
              <a target="_blank" class="btn btn-success" href="../election-winners.php?studentOrg=<?php User::printGet('activeStudentOrg'); ?>&activeStudentOrg=<?php User::printGet('activeStudentOrg'); ?>"> <i class="fa-solid fa-arrow-up"></i> Release & Print</a>
              <a class="btn btn-secondary" href="admin-deploy-ballot.php?orgName=<?php User::printGet('activeStudentOrg'); ?>">Extend Election</a>
            </div>
            


          <?php } ?>

          <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
          <!-- diplays the winners of the election, and a button that will officially declare the officers -->


        </div>
      </div>
    </div>

  </div>

  <?php
    require 'admin-footer.php';
  ?>

  <script defer>
    let activeLink = document.getElementById("<?php User::printGet('activeStudentOrg') ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";
  </script>



  <?php 
    if (empty($row2)) {
      // do nothing
    } else if ($row2['exp_date'] <= $date_time_now) {



    foreach ($positions as $position) {

      $xArray = array();
      $yArray = array();



      $connection = new mysqli('localhost', 'root', '', 'etrack');
      $org_name = User::returnValueGet('activeStudentOrg');
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
    var activeNav = document.getElementById('monitor-election-result')
    activeNav.classList.add('bg-dark-gray2');

    window.addEventListener("focus", function() {
      location.reload();
    });
  </script>
</body>

</html>