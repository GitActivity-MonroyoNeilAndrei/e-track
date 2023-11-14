<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$admin = new database();

User::ifNotLogin('admin-username', '../login-account/login-user.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id'=>$admin_id]), '../logout.php?logout=admin');



if (!isset($_GET['activeStudentOrg'])) {
  $result = $admin->selectDistinct('student_org', 'name_of_org');

  $row = mysqli_fetch_assoc($result);
  header("location: admin-student-organization.php?activeStudentOrg=$row[name_of_org]");
}

$org_name = User::returnValueGet('activeStudentOrg');

if(!isset($_GET['school_year'])) {
  $connection = new mysqli('localhost', 'root', '', 'etrack');


  $sql = "SELECT DISTINCT school_year FROM officers WHERE org_name = '$org_name' ORDER BY school_year DESC LIMIT 2;";

  $result = $connection->query($sql);
  $row = mysqli_fetch_assoc($result);

  $latest_school_year = "";
  if($row){
    $latest_school_year = $row['school_year'];
  }

  $activeStudentOrg = User::returnValueGet('activeStudentOrg');

  if($latest_school_year != "") {
    header("location: admin-student-organization.php?activeStudentOrg=$activeStudentOrg&school_year=$latest_school_year");
  }

}

if(isset($_POST['submit'])) {
  $school_year = $_POST['school_year'];

  $activeStudentOrg = User::returnValueGet('activeStudentOrg');

  header("location: admin-student-organization.php?activeStudentOrg=$activeStudentOrg&school_year=$school_year");
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

  <style>
    .candidate-image {
      height: 100%;
      width: 100%;
    }

    .candidate-container {
      border: 1px solid #888888;
      width: 5rem;
      height: 5rem;
      border-radius: 35%;
      overflow: hidden;
      margin-bottom: .3rem;
      box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .container h5 {
      text-align: center;
      line-height: 1rem;
    }

    h6,
    h5 {
      line-height: .7rem;
    }

    .candidate-row {
      display: flex;
      justify-content: space-evenly;
      max-width: 50rem;
      margin: auto;
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
            <li onclick="window.location.href='admin-homepage.php'">
              <span>Dashboard</span>
              <span><i class="fa-solid fa-bars"></i></span>
            </li>
            <li onclick="window.location.href='admin-list-of-users.php'" class="mb-4 border-bottom border-dark">
              <span>List of Users</span>
              <span><i class="fa-solid fa-users"></i></span>
            </li>
            <li onclick="window.location.href='admin-election.php'">
              <span>Election</span>
              <span><i class="fa-solid fa-envelope-open-text"></i></span>
            </li>
            <li onclick="window.location.href='admin-monitor-election-result.php'" class="mb-4 border-bottom border-dark">
              <span>Monitor Election Result</span>
              <span><i class="fa-solid fa-square-poll-horizontal"></i></span>
            </li>
            <li onclick="window.location.href='admin-student-organization.php'" class="mb-4 border-bottom border-dark bg-dark-gray2">
              <span>Student Organization</span>
              <span><i class="fa-solid fa-sitemap"></i></span>
            </li>
            <li onclick="window.location.href='admin-plan-of-activities.php'">
              <span>Plan of Activities</span>
              <span><i class="fa-solid fa-check-to-slot"></i></span>
            </li>
            <li onclick="window.location.href='admin-list-of-plan-of-activities.php'">
              <span>List of Plan of Activities</span>
              <span><i class="fa-solid fa-list-ul"></i></span>
            </li>
            <li onclick="window.location.href='admin-monitor-plan-of-activities.php'" class="mb-4 border-bottom border-dark">
              <span>Monitor Plan of Activities</span>
              <span><i class="fa-solid fa-tv"></i></span>
            </li>
            <li onclick="window.location.href='admin-accomplishment-report.php'">
              <span>Accomplishment Report</span>
              <span><i class="fa-solid fa-check-to-slot"></i></span>
            </li>
            <li onclick="window.location.href='admin-list-of-accomplishment-report.php'" class="mb-4 border-bottom border-dark">
              <span>List of Accomplishment Report</span>
              <span><i class="fa-solid fa-list-ul"></i></span>
            </li>
            <li onclick="window.location.href='admin-evaluation-of-activities.php'">
              <span>Evaluation of Activities</span>
              <span><i class="fa-solid fa-clipboard-check"></i></span>
            </li>
            <li onclick="window.location.href='admin-report-to-ovpsas.php'">
              <span>Report to OVPSAS</span>
              <span><i class="fa-solid fa-envelope-circle-check"></i></span>
            </li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>List of Student Organization</h5>
          </div>


          <nav class="org-list-nav mb-3">
            <ul>
              <?php
              $result = $admin->selectDistinct('student_org', 'name_of_org');
              while ($row = mysqli_fetch_assoc($result)) {
              ?>

                <li id="<?php echo $row['name_of_org']; ?>" onclick="window.location.href = 'admin-student-organization.php?activeStudentOrg=<?php echo $row['name_of_org'] ?>';"><?php echo $row['name_of_org']; ?></li>

              <?php } ?>
            </ul>
          </nav>

          <h4 class="text-center">Officers of <?php User::printGet('activeStudentOrg') ?></h4>


          <form method="post" class="mx-auto text-center" style="max-width: 10rem;">
            <select name="school_year" class="form-select">
              <?php 
                $sql = "SELECT DISTINCT school_year FROM officers WHERE org_name = '$org_name' ORDER BY school_year DESC";
                $school_years = $admin->mysqli->query($sql);
                
                while($row = mysqli_fetch_assoc($school_years)) {
              ?>
                <option value="<?php echo $row['school_year']; ?>" <?php if($row['school_year'] == User::returnValueGet('school_year')) {echo "selected";} ?>><?php echo $row['school_year']; ?></option>
              <?php
                }
              ?>
            </select>
            <input class="btn btn-primary my-2" type="submit" name="submit" value="Select">
          </form>

          



          <?php
          $result = $admin->select('officers', '*', ['school_year' => User::returnValueGet('school_year'), 'org_name' => $org_name]);

          $officers = array();
          $images = array();

          $PIO = 0;
          $project_manager = 0;
          $sargeant_at_arms = 0;

          while ($row = mysqli_fetch_assoc($result)) {


            if ($row['position'] == 'PIO') {
              $PIO += 1;

              $full_name = "$row[first_name]" . " " . "$row[last_name]";

              $officers += ["$row[position]" . $PIO => $full_name];
              $images += ["$row[position]" . $PIO => $row['photo_url']];
            } else if ($row['position'] == 'Project Manager') {
              $project_manager += 1;

              $full_name = "$row[first_name]" . " " . "$row[last_name]";

              $officers += ["$row[position]" . $project_manager => $full_name];
              $images += ["$row[position]" . $project_manager => $row['photo_url']];
            } else if ($row['position'] == 'Sargeant at Arms') {
              $sargeant_at_arms += 1;

              $full_name = "$row[first_name]" . " " . "$row[last_name]";

              $officers += ["$row[position]" . $sargeant_at_arms => $full_name];
              $images += ["$row[position]" . $sargeant_at_arms => $row['photo_url']];
            } else {
              $full_name = "$row[first_name]" . " " . "$row[last_name]";

              $officers += ["$row[position]" => $full_name];
              $images += ["$row[position]" => $row['photo_url']];
            }
          }

          ?>
          <div class="candidate-row">
            <div class="container">

              <?php

              if (array_key_exists("President", $officers)) {
              ?>


                <div class="candidate-container">
                  <a href="../view-image.php?path=uploads/&imageUrl=<?php echo $images['President']; ?>"><img class="candidate-image" src="../uploads/<?php echo $images['President']; ?>" alt=""></a>
                </div>

                <h5 class="fw-medium"><?php echo $officers['President']; ?></h5>
                <h6 class="fst-italic">President</h6>

              <?php } else { ?>

                <div class="candidate-container">
                  <img class="candidate-image" src="" alt="">
                </div>

                <h5 class="fw-medium"></h5>
                <h6 class="fst-italic">President</h6>

              <?php } ?>

            </div>
          </div>
          <div class="candidate-row">
            <div class="container">
              <?php

              if (array_key_exists("Secretary", $officers)) {
              ?>


                <div class="candidate-container">
                  <a href="../view-image.php?path=uploads/&imageUrl=<?php echo $images['Secretary']; ?>"><img class="candidate-image" src="../uploads/<?php echo $images['Secretary']; ?>" alt=""></a>
                </div>

                <h5 class="fw-medium"><?php echo $officers['Secretary']; ?></h5>
                <h6 class="fst-italic">Secretary</h6>

              <?php } else { ?>

                <div class="candidate-container">
                  <img class="candidate-image" src="" alt="">
                </div>

                <h5 class="fw-medium"></h5>
                <h6 class="fst-italic">Secretary</h6>

              <?php } ?>
            </div>
            <div class="container">
              <?php

              if (array_key_exists("Vice President", $officers)) {
              ?>


                <div class="candidate-container">
                  <a href="../view-image.php?path=uploads/&imageUrl=<?php echo $images['Vice President']; ?>"><img class="candidate-image" src="../uploads/<?php echo $images['Vice President']; ?>" alt=""></a>
                </div>

                <h5 class="fw-medium"><?php echo $officers['Vice President']; ?></h5>
                <h6 class="fst-italic">Vice President</h6>

              <?php } else { ?>

                <div class="candidate-container">
                  <img class="candidate-image" src="" alt="">
                </div>

                <h5 class="fw-medium"></h5>
                <h6 class="fst-italic">Vice President</h6>

              <?php } ?>
            </div>
            <div class="container">
              <?php

              if (array_key_exists("Treasurer", $officers)) {
              ?>


                <div class="candidate-container">
                  <a href="../view-image.php?path=uploads/&imageUrl=<?php echo $images['Treasurer']; ?>"><img class="candidate-image" src="../uploads/<?php echo $images['Treasurer']; ?>" alt=""></a>
                </div>

                <h5 class="fw-medium"><?php echo $officers['Treasurer']; ?></h5>
                <h6 class="fst-italic">Treasurer</h6>

              <?php } else { ?>

                <div class="candidate-container">
                  <img class="candidate-image" src="" alt="">
                </div>

                <h5 class="fw-medium"></h5>
                <h6 class="fst-italic">Treasurer</h6>

              <?php } ?>
            </div>
          </div>
          <div class="candidate-row">
            <div class="container">
              <?php

              if (array_key_exists("Project Manager1", $officers)) {
              ?>


                <div class="candidate-container">
                  <a href="../view-image.php?path=uploads/&imageUrl=<?php echo $images['Project Manager1']; ?>"><img class="candidate-image" src="../uploads/<?php echo $images['Project Manager1']; ?>" alt=""></a>
                </div>

                <h5 class="fw-medium"><?php echo $officers['Project Manager1']; ?></h5>
                <h6 class="fst-italic">Project Manager</h6>

              <?php } else { ?>

                <div class="candidate-container">
                  <img class="candidate-image" src="" alt="">
                </div>

                <h5 class="fw-medium"></h5>
                <h6 class="fst-italic">Project Manager</h6>

              <?php } ?>
            </div>
            <div class="container">
              <?php

              if (array_key_exists("PIO1", $officers)) {
              ?>


                <div class="candidate-container">
                  <a href="../view-image.php?path=uploads/&imageUrl=<?php echo $images['PIO1']; ?>"><img class="candidate-image" src="../uploads/<?php echo $images['PIO1']; ?>" alt=""></a>
                </div>

                <h5 class="fw-medium"><?php echo $officers['PIO1']; ?></h5>
                <h6 class="fst-italic">PIO</h6>

              <?php } else { ?>

                <div class="candidate-container">
                  <img class="candidate-image" src="" alt="">
                </div>

                <h5 class="fw-medium"></h5>
                <h6 class="fst-italic">PIO</h6>

              <?php } ?>
            </div>
            <div class="container">
              <?php

              if (array_key_exists("Auditor", $officers)) {
              ?>


                <div class="candidate-container">
                  <a href="../view-image.php?path=uploads/&imageUrl=<?php echo $images['Auditor']; ?>"><img class="candidate-image" src="../uploads/<?php echo $images['Auditor']; ?>" alt=""></a>
                </div>

                <h5 class="fw-medium"><?php echo $officers['Auditor']; ?></h5>
                <h6 class="fst-italic">Auditor</h6>

              <?php } else { ?>

                <div class="candidate-container">
                  <img class="candidate-image" src="" alt="">
                </div>

                <h5 class="fw-medium"></h5>
                <h6 class="fst-italic">Auditor</h6>

              <?php } ?>
            </div>
            <div class="container">
              <?php

              if (array_key_exists("PIO2", $officers)) {
              ?>


                <div class="candidate-container">
                  <a href="../view-image.php?path=uploads/&imageUrl=<?php echo $images['PIO2']; ?>"><img class="candidate-image" src="../uploads/<?php echo $images['PIO2']; ?>" alt=""></a>
                </div>

                <h5 class="fw-medium"><?php echo $officers['PIO2']; ?></h5>
                <h6 class="fst-italic">PIO</h6>

              <?php } else { ?>

                <div class="candidate-container">
                  <img class="candidate-image" src="" alt="">
                </div>

                <h5 class="fw-medium"></h5>
                <h6 class="fst-italic">PIO</h6>

              <?php } ?>
            </div>
            <div class="container">
              <?php

              if (array_key_exists("Project Manager2", $officers)) {
              ?>


                <div class="candidate-container">
                  <a href="../view-image.php?path=uploads/&imageUrl=<?php echo $images['Project Manager2']; ?>"><img class="candidate-image" src="../uploads/<?php echo $images['Project Manager2']; ?>" alt=""></a>
                </div>

                <h5 class="fw-medium"><?php echo $officers['Project Manager2']; ?></h5>
                <h6 class="fst-italic">Project Manager</h6>

              <?php } else { ?>

                <div class="candidate-container">
                  <img class="candidate-image" src="" alt="">
                </div>

                <h5 class="fw-medium"></h5>
                <h6 class="fst-italic">Project Manager</h6>

              <?php } ?>
            </div>
          </div>
          <div class="candidate-row">
            <div class="container">
              <?php

              if (array_key_exists("Sargeant at Arms1", $officers)) {
              ?>


                <div class="candidate-container">
                  <a href="../view-image.php?path=uploads/&imageUrl=<?php echo $images['Sargeant at Arms1']; ?>"><img class="candidate-image" src="../uploads/<?php echo $images['Sargeant at Arms1']; ?>" alt=""></a>
                </div>

                <h5 class="fw-medium"><?php echo $officers['Sargeant at Arms1']; ?></h5>
                <h6 class="fst-italic">Sargeant at Arms</h6>

              <?php } else { ?>

                <div class="candidate-container">
                  <img class="candidate-image" src="" alt="">
                </div>

                <h5 class="fw-medium"></h5>
                <h6 class="fst-italic">Sargeant at Arms</h6>

              <?php } ?>
            </div>
            <div class="container">
              <?php

              if (array_key_exists("Muse", $officers)) {
              ?>


                <div class="candidate-container">
                  <a href="../view-image.php?path=uploads/&imageUrl=<?php echo $images['Muse']; ?>"><img class="candidate-image" src="../uploads/<?php echo $images['Muse']; ?>" alt=""></a>
                </div>

                <h5 class="fw-medium"><?php echo $officers['Muse']; ?></h5>
                <h6 class="fst-italic">Muse</h6>

              <?php } else { ?>

                <div class="candidate-container">
                  <img class="candidate-image" src="" alt="">
                </div>

                <h5 class="fw-medium"></h5>
                <h6 class="fst-italic">Muse</h6>

              <?php } ?>
            </div>
            <div class="container">
              <?php

              if (array_key_exists("Escort", $officers)) {
              ?>


                <div class="candidate-container">
                  <a href="../view-image.php?path=uploads/&imageUrl=<?php echo $images['Escort']; ?>"><img class="candidate-image" src="../uploads/<?php echo $images['Escort']; ?>" alt=""></a>
                </div>

                <h5 class="fw-medium"><?php echo $officers['Escort']; ?></h5>
                <h6 class="fst-italic">Escort</h6>

              <?php } else { ?>

                <div class="candidate-container">
                  <img class="candidate-image" src="" alt="">
                </div>

                <h5 class="fw-medium"></h5>
                <h6 class="fst-italic">Escort</h6>

              <?php } ?>
            </div>
            <div class="container">
              <?php

              if (array_key_exists("Sargeant at Arms2", $officers)) {
              ?>


                <div class="candidate-container">
                  <a href="../view-image.php?path=uploads/&imageUrl=<?php echo $images['Sargeant at Arms2']; ?>"><img class="candidate-image" src="../uploads/<?php echo $images['Sargeant at Arms2']; ?>" alt=""></a>
                </div>

                <h5 class="fw-medium"><?php echo $officers['Sargeant at Arms2']; ?></h5>
                <h6 class="fst-italic">Sargeant at Arms</h6>

              <?php } else { ?>

                <div class="candidate-container">
                  <img class="candidate-image" src="" alt="">
                </div>

                <h5 class="fw-medium"></h5>
                <h6 class="fst-italic">Sargeant at Arms</h6>

              <?php } ?>
            </div>
          </div>

          <div class="candidate-row">
            <div class="container">
              <!-- <div class="candidate-container">
                <img class="candidate-image" src="" alt="">
              </div> -->
              <h5 class="fw-medium">tanga ka</h5>
              <h6 class="fst-italic">Adviser</h6>
            </div>
          </div>

          <?php if($admin->isExisted('officers', ['org_name'=>User::returnValueGet('activeStudentOrg')])){ ?>
          <div class="d-flex justify-content-center mt-4 mb-2">
            <a class="btn btn-primary" href="admin-edit-organization.php?studentOrg=<?php User::printGet('activeStudentOrg') ?>&latestSchoolYear=<?php User::printGet('school_year'); ?>">Edit Members</a>

          </div>
          <?php } ?>

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