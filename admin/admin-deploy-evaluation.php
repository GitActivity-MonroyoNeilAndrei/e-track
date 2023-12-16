

<?php
include '../classes/database.php';
include '../classes/message.php';
include '../classes/user.php';

header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");

session_start();

$admin = new database();

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');

$error_time;


User::ifNotLogin('admin-username', '../login-account/login-user.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id' => $admin_id]), '../logout.php?logout=admin');

if(isset($_POST['deploy'])) {
  $exp_date = mysqli_escape_string($admin->mysqli, $_POST['exp-date']);
  $courses = $_POST['can-vote'];
  $name_of_activity = mysqli_escape_string($admin->mysqli, $_POST['activity']);

  if ($date_time_now > $exp_date) {
    $error_time = "Expiry Date Must be Greater than the Date Now";
  } else {
    $admin->updateData('evaluation_of_activities', ['status'=>'deployed', 'exp_date'=>$exp_date, 'name_of_activity'=>$name_of_activity], ['name_of_org'=>User::returnValueGet('activeStudentOrg')]);
    
    $admin->updateData('accomplishment_reports', ['evaluated'=>'evaluated'], ['planned_activity'=>$name_of_activity]);
    foreach($courses as $course) {
      $admin->updateData('student', ['can_evaluate'=>User::returnValueGet('activeStudentOrg')], ['course'=>$course]);
    }

    $active_student_org = User::returnValueGet('activeStudentOrg');
    header("location: admin-evaluation-of-activities.php?activeStudentOrg=$active_student_org&evaluationDeployed");
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
    form {
      border-radius: 8px;
      background: linear-gradient(179deg, #70BE43 0%, rgba(112, 190, 67, 0.70) 100%);
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      backdrop-filter: blur(20px);
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
            <h5>Deploy Evaluation of Activities</h5>
          </div>


          <form class="d-flex flex-column mx-auto mt-5 p-3 border rounded-3" style="max-width: 15rem; " method="post">
          <h5 class="text-center">Deploy Evaluation for <?php User::printGet('activeStudentOrg') ?></h5>
          <?php
            if (isset($error_time)) {
              echo '
              <div class="alert alert-danger" role="alert">
                ' . $error_time . '
              </div>';
            }
          ?>

            <div style="width: 100%;">
              <label for="activity">Name of Activity:</label>
              <select class="form-select" name="activity"> 
                <?php 
                  $activity = $admin->select('accomplishment_reports', '*', ['evaluated'=>""]);

                  while ($row = mysqli_fetch_assoc($activity)) {
                ?>

                <option value="<?php echo $row['planned_activity']; ?>"><?php echo $row['planned_activity']; ?></option>

              <?php } ?>
              </select>
              <!-- <input class="form-control" type="text" name="course" required> -->
            </div>

          <label class="form-label" for="exp-date">End of Evaluation:</label>
          <input class="form-control" type="datetime-local" name="exp-date" required>

          <label class="form-label" for="can-vote">Who can Vote?:</label>
          <select class="form-select" name="can-vote[]" multiple="multiple">
            <?php 
              $courses = $admin->select('courses', 'course');

              while ($row = mysqli_fetch_assoc($courses)) {
            ?>
              <option value="<?php echo $row['course']; ?>"><?php echo $row['course']; ?></option>
            <?php
              }
            ?>
          </select>

          <!-- <input class="form-control d-none" type="text" name="can-vote" required> -->

          <div class="d-flex justify-content-center align-items-center mt-3">
            <input class="btn btn-success me-3" type="submit" name="deploy" value="Deploy" required>
            <a class="btn btn-danger" href="admin-evaluation-of-activities.php?activeStudentOrg=<?php User::printGet('activeStudentOrg'); ?>">Cancel</a>
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


    var activeNav = document.getElementById('evaluation-of-activities')
    activeNav.classList.add('bg-dark-gray2');



  </script>
</body>

</html>
