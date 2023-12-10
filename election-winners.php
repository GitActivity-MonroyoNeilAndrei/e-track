<?php
include "classes/database.php";
include "classes/message.php";
include "classes/user.php";

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');

session_start();

$admin = new database();

$school_year = mysqli_fetch_assoc($admin->select('candidate', '*', ['org_name'=>User::returnValueGet('studentOrg')]));

$full_name_of_org = "";

$org = $admin->select('student_org', '*', ['name_of_org'=>User::returnValueGet('activeStudentOrg')]);

while ($row = mysqli_fetch_assoc($org)) {
  $full_name_of_org = $row['full_name_of_org'];
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
  <link rel="stylesheet" href="css/bootstrap/bootstrap.css?<?php echo time(); ?>">
  <!-- <link rel="stylesheet" href="css/admin.css?<?php echo time(); ?>"> -->
  <script src="https://kit.fontawesome.com/ba2dc1cde9.js" crossorigin="anonymous"></script>
  <script src="https://cdn.plot.ly/plotly-2.26.0.min.js" charset="utf-8"></script>
  <style>
    .table-responsive {
      max-width: 35rem;
      margin: auto;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      border-radius: 8px;
    }

    h1, h2, h3, h4, h5, h6, p {
      font-family: sans-serif;
    }

    img {
      width: 100px;
    }

    .header-text h4 {
      text-align: center;
      font-weight: 100;
    }

    .header {
      margin: auto;
      position: relative;
      left: -10px;
      width: 80%;
    }
  </style>
</head>

<body>
  <div class=" d-flex justify-content-center">
    <div style="width: 100%;">
      <div class="content">
        <div class="header pb-4" style="display: flex; justify-content: center;">
          <img src="images/msc_logo.png" alt="">
          <div class="header-text">
            <h4>MARINDUQUE STATE COLLEGE</h4>
            <h4><?php echo $full_name_of_org; ?></h4>
          </div>
        </div>




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
              <h4 class="text-center fw-semibold">Election Results for <?php User::printGet('activeStudentOrg'); ?> </h4>
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

            <h4 class="text-center fw-semibold"> Election of <?php User::printGet('activeStudentOrg'); ?> A.Y. <?php echo $school_year['school_year']; ?></h4>
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
                        <h4 class="fw-medium"><?php echo $position; ?></h4>
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
              
              
              <div class="mx-auto" style="width: <?php echo ($candidate_count * 15) + 25; ?>%;">
                <div class="graph mx-auto" id="<?php echo $position; ?>"></div>
              </div>

            <?php } ?>

            


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
    print();
  </script>
</body>

</html>



<?php
$user = new database();


$studentOrg = User::returnValueGet('studentOrg');

// selects tha winners in the candidate table
$officers1 = $user->select('candidate', '*', ['org_name'=>$studentOrg, 'status'=>'winner']);

$row1 = mysqli_fetch_assoc($officers1);

$user->deleteRow('officers', "org_name = '$studentOrg' AND school_year = '$row1[school_year]'");

$officers2 = $user->select('candidate', '*', ['org_name'=>$studentOrg, 'status'=>'winner']);


// insert to the officers table the winners
while($row = mysqli_fetch_assoc($officers2)) {


  $user->insertData('officers', ['position'=>$row['position'], 'first_name'=>$row['first_name'], 'last_name'=>$row['last_name'], 'year'=>$row['year'], 'photo_url'=>$row['photo_url'], 'partylist'=>$row['partylist'], 'org_name'=>$row['org_name'], 'school_year'=>$row['school_year']]);
}

// select the candidates in the candidates table
$delete_candidate = $user->select('candidate', '*', ['org_name'=>$studentOrg]);

// then delete them
while($row = mysqli_fetch_assoc($delete_candidate)) {
  $user->delete('candidate', "id = $row[id]");
}

// redirect to the admin-monitor-election-result page
// header("location: admin/admin-monitor-election-result.php?activeStudentOrg=$studentOrg&resultReleased");

?>