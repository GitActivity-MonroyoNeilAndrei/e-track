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
  header("location: admin-accomplishment-report.php?activeStudentOrg=$row[name_of_org]");
}

if (isset($_POST['acceptAll'])) {
  $selectedActivities = $_POST['activities'];

  foreach ($selectedActivities as $activity) {
      $admin->updateData("accomplishment_reports", ['status'=>'ongoing'], ['id'=>$activity, 'name_of_org'=>User::returnValueGet('activeStudentOrg')]);
  }
} else if (isset($_POST['rejectAll'])) {
  $selectedActivities = $_POST['activities'];

  foreach ($selectedActivities as $activity) {
      $admin->updateData("accomplishment_reports", ['status'=>'returned'], ['id'=>$activity, 'name_of_org'=>User::returnValueGet('activeStudentOrg')]);
  }
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
            <h5>Accomplishment Reports</h5>
          </div>
          <nav class="org-list-nav">
            <ul>
              <?php
              $result = $admin->selectDistinct('student_org', 'name_of_org');
              while ($row = mysqli_fetch_assoc($result)) {
              ?>

                <li id="<?php echo $row['name_of_org']; ?>" onclick="window.location.href = 'admin-accomplishment-report.php?activeStudentOrg=<?php echo $row['name_of_org'] ?>';"><?php echo $row['name_of_org']; ?></li>

              <?php } ?>
            </ul>
          </nav>

          <?php
            if (isset($_GET['accept'])) {
              echo '
              <div class="alert alert-success" role="alert">
                Accept Successfully
              </div>';
            } else if (isset($_GET['reject'])) {
              echo'
              <div class="alert alert-success" role="alert">
                Returned Successfully
              </div>
              ';
            } else if (isset($_GET['returnedAll'])) {
              echo'
              <div class="alert alert-success" role="alert">
                All Returned Successfully
              </div>
              ';
            }  else if (isset($_GET['acceptAll'])) {
              echo'
              <div class="alert alert-success" role="alert">
                All Accepted Successfully
              </div>
              ';
            } 
          ?>
          <form method="post">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th></th>
                  <th>Planned Activity</th>
                  <th>Purpose</th>
                  <th>Date Accomplished</th>
                  <th>Budget</th>
                  <th>Remarks</th>
                  <th>Reports & Liquidations</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $accomplishment_report = $admin->select('accomplishment_reports', '*', ['name_of_org'=>User::returnValueGet('activeStudentOrg'), 'status'=>'submitted']);

                  if ($accomplishment_report->num_rows == 0 ) {
                    echo '
                      <tr>
                        <td colspan="8">
                          <h3 class="text-center">No Activities has been Submitted</h3>
                        </td>
                      </tr>
                    ';
                  }


                  while ($row = mysqli_fetch_assoc($accomplishment_report)) {
                ?>
                <tr>
                  <td><input class="form-check-input" type="checkbox" name="activities[]" value="<?php echo $row['id']; ?>"></td>
                  <td><?php echo $row['planned_activity']; ?></td>
                  <td><?php echo $row['purpose']; ?></td>
                  <td><?php echo $row['date_accomplished']; ?></td>
                  <td><?php echo $row['budget']; ?></td>
                  <td><?php echo $row['remarks']; ?></td>
                  <td><a class="btn btn-outline-secondary" target="_blank" href="../uploads/<?php echo $row['liquidations']; ?>">Open</a></td>
                  <td>Pending</td>
                  <td>
                    <a class="btn btn-success mb-2" href="admin-change-status.php?id=<?php echo $row['id']; ?>&status=ongoing&studentOrg=<?php User::printGet('activeStudentOrg') ?>&type=accomplishment_reports&path=admin-accomplishment-report.php"> Accept</a>
                    <a class="btn btn-danger mb-2" href="admin-change-status.php?id=<?php echo $row['id']; ?>&status=returned&studentOrg=<?php User::printGet('activeStudentOrg') ?>&type=accomplishment_reports&path=admin-accomplishment-report.php"> Reject</a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

          <div class="text-center">
            <!-- <a class="btn btn-success" href="accept-reject.php?acceptReport&activeStudentOrg=<?php User::printGet('activeStudentOrg'); ?>">Accept All</a>
            <a class="btn btn-danger" href="accept-reject.php?rejectReport&activeStudentOrg=<?php User::printGet('activeStudentOrg'); ?>">Reject All</a> -->

            <input class="btn btn-success" type="submit" name="acceptAll" value="Accept All">
            <input class="btn btn-danger" type="submit" name="rejectAll" value="Reject All">

          </div>
          </form>


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


    var activeNav = document.getElementById('accomplishment-report')
    activeNav.classList.add('bg-dark-gray2');

    window.addEventListener("focus", function() {
      location.reload();
    });


  </script>
</body>

</html>
