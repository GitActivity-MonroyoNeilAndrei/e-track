<?php
  include "../classes/database.php";
  include "../classes/message.php";
  include "../classes/user.php";
  
  session_start();
  
  $admin = new database();

  date_default_timezone_set('Asia/Manila');
  $date_time_now = date('Y-m-d') . 'T' . date('H:i');

  $error_time;

  if(isset($_POST['deploy'])) {
    $school_year = mysqli_escape_string($admin->mysqli, $_POST['school-year']);
    $exp_date = mysqli_escape_string($admin->mysqli, $_POST['exp-date']);
    $can_vote = mysqli_escape_string($admin->mysqli, $_POST['can-vote']);

    if ($date_time_now > $exp_date) {
      $error_time = "Expiry Date Must be Greater than the Date Now";
    } else {
      $admin->updateData('candidate', ['school_year'=>$school_year, 'status'=>'deployed', 'exp_date'=>$exp_date], ['org_name'=>User::returnValueGet('orgName')]);
      
      $courses = explode(' ', $can_vote);

      foreach($courses as $course) {
        $admin->updateData('student', ['can_vote'=>User::returnValueGet('orgName')], ['course'=>$course]);
      }

      $active_student_org = User::returnValueGet('orgName');
      header("location: admin-election.php?activeStudentOrg=$active_student_org&ballotDeployed");
    }

  }

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/bootstrap/bootstrap.css?<?php echo time(); ?>">

  <style>
    form {
      border-radius: 8px;
      background: linear-gradient(179deg, #70BE43 0%, rgba(112, 190, 67, 0.70) 100%);
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      backdrop-filter: blur(20px);
    }
  </style>
</head>

<body style="background-color: #EEEEEE;">
  <form class="d-flex flex-column mx-auto mt-5 p-3 border rounded-3" style="max-width: 15rem; " method="post">
    <h5 class="text-center">Deploy Ballot for <?php User::printGet('orgName') ?></h5>
    <?php
      if (isset($error_time)) {
        echo '
        <div class="alert alert-danger" role="alert">
          ' . $error_time . '
        </div>';
      }
    ?>
    <label class="form-label" for="school-year">School Year:</label>
    <input class="form-control" type="text" name="school-year" required>
    <label class="form-label" for="exp-date">End of Election:</label>
    <input class="form-control" type="datetime-local" name="exp-date" required>

    <label class="form-label" for="can-vote">Who can Vote?:</label>
    <input class="form-control" type="text" name="can-vote" required>
    <div class="d-flex justify-content-center align-items-center mt-3">
      <input class="btn btn-success me-3" type="submit" name="deploy" value="Deploy" required>
      <a class="btn btn-danger" href="admin-election.php?activeStudentOrg=<?php User::printGet('orgName'); ?>">Cancel</a>
    </div>
  </form>

</body>

</html>