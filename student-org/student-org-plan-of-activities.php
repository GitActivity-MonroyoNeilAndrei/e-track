<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');


session_start();

$student_org = new database();

// User::ifNotLogin('name_of_org', '../login-account/login-user.php');

$student_org_id = User::returnValueSession('student-org-id');

User::ifDeactivatedReturnTo($student_org->select('student_org', 'status', ['id'=>$student_org_id]), '../logout.php?logout=student-org');



if (isset($_GET['archive'])){
  if(isset($_GET['id'])) {
    $student_org->updateData('plan_of_activities', ['status'=>'archive'], ['id'=>User::returnValueGet('id')]);
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

  <style>
        .disabled {
            pointer-events: none;
            color: gray;
            text-decoration: none;
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
          <a href="student-org-edit-profile.php"><i class="fa-solid fa-address-card"></i> My Profile</a>
          <a href="../logout.php?logout=student-org"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
    <?php
      require 'student-org-navigations.php';
    ?>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Submit Plan of Activity</h5>
          </div>
          <h3 class="text-center">Plan of Activities</h3>

          <div class="d-flex justify-content-between">
            <a class="btn btn-primary mb-3" href="add-plan-of-activity.php"><i class="fa-solid fa-plus"></i> Add Plan</a>
          </div>


          <?php
            if(isset($_GET['archive'])) {
              echo '
              <div class="alert alert-success" role="alert">
                Accomplishment Report Succesfully Added to Archive
              </div>
              ';
            } else if (isset($_GET['success'])) {
              echo '
              <div class="alert alert-success" role="alert">
                Plan of Activity Added Succcessfully
              </div>
              ';
            }
          ?>

          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Activity Code</th>
                  <th>Name of Activity</th>
                  <th>Date</th>
                  <th>Venue</th>
                  <th>Sponsors</th>
                  <th>Nature of Activity</th>
                  <th>Purpose</th>
                  <th>Beneficiaries</th>
                  <th>Target Output</th>
                  <th>Budget</th>
                  <th>Status</th>
                  <th>Remark</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $name_of_org = User::returnValueSession('name_of_org');

                $plan_of_activities = $student_org->advanceSelect('plan_of_activities', '*', " name_of_org = '$name_of_org' AND (status = 'draft' OR status = 'returned' OR status = 'submitted') ORDER BY id DESC");

                if ($plan_of_activities->num_rows == 0 ) {
                  echo '
                    <tr>
                      <td colspan="11">
                        <h3 class="text-center">No Activities has been Uploaded</h3>
                      </td>
                    </tr>
                  ';
                }


                 while ($row = mysqli_fetch_assoc($plan_of_activities)) {
                ?>
                <tr>
                  <td><?php echo $row['activity_code']; ?></td>
                  <td><?php echo $row['name_of_activity']; ?></td>
                  <td><?php echo $row['date']; ?></td>
                  <td><?php echo $row['venue']; ?></td>
                  <td><?php echo $row['sponsors']; ?></td>
                  <td><?php echo $row['nature_of_activity']; ?></td>
                  <td><?php echo $row['purpose']; ?></td>
                  <td><?php echo $row['beneficiaries']; ?></td>
                  <td><?php echo $row['target_output']; ?></td>
                  <td><?php echo $row['budget']; ?></td>
                  <td><?php echo $row['status']; ?></td>
                  <td><?php echo $row['remark']; ?></td>
                  <td>
                    <a class="btn btn-secondary mb-2 <?php if($row['status'] == 'submitted'){ echo 'disabled';} ?> " href="edit-plan-of-activity.php?id=<?php echo $row['id']; ?>"> Edit</a>



                    <a class="btn btn-danger mb-2 <?php if($row['status'] == 'submitted'){ echo 'disabled';} ?> " href="delete-plan-of-activity.php?id=<?php  echo $row['id']; ?>">Delete</a>
                  </td>
                </tr>

                <?php } ?>
              </tbody>
            </table>
          </div> <!-- table responsive -->

          <div class="d-flex justify-content-center">
            <a class="btn btn-success" href="submit-plan-of-activity.php"><i class="fa-solid fa-arrow-right"></i> Submit All</a>
          </div>

        </div>
      </div>
    </div>

  </div>

  <?php
    require 'student-org-footer.php';
  ?>

  <script defer>
    let activeLink = document.getElementById("<?php User::printGet('user'); ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";

    window.addEventListener("focus", function() {
      location.reload();
    });
  </script>
  <script>
    var activeNav = document.getElementById('plan-of-activity')
    activeNav.classList.add('bg-dark-gray2');
  </script>
</body>

</html>