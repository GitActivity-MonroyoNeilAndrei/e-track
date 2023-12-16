<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";


date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');

session_start();

$student = new database();

if (!isset($_SESSION['student_id'])) {
  header('location: ../login-account/login-user.php');
}

$student_id = User::returnValueSession('id');

User::ifDeactivatedReturnTo($student->select('student', 'status', ['id'=>$student_id]), '../logout.php?logout=student');


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
            <li onclick="window.location.href='student-monitor-result.php'">
              <span>Monitor Election Result</span>
              <span><i class="fa-solid fa-square-poll-horizontal"></i></span>
            </li>
            <li onclick="window.location.href='student-monitor-activities.php'">
              <span>Monitor Activities</span>
              <span><i class="fa-regular fa-file"></i></span>
            </li>
            <li onclick="window.location.href='student-evaluate-activities.php'" class="bg-dark-gray2">
              <span>Evaluate Activities</span>
              <span><i class="fa-regular fa-file"></i></span>
            </li>

          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5 class="text-start">Vote</h5>
          </div>
          <nav class="org-list-nav">
            <ul>

            </ul>
          </nav>

          <div class="container-add-candidate">
            <h5 class="text-center fw-bold py-1">Available Evaluation</h5>
          </div>

          <?php
          
          if(isset($_GET['evaluated'])) {
            echo '
            <div class="alert alert-success" role="alert">
              Evaluated Successfully
            </div>
            ';
          }

          
          if(isset($_REQUEST['voteSuccessfully'])) {Message::voteSuccessfully();} 
          ?>


          

          <div class="table-responsive m-auto" style="max-width: 30rem;">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Organization Name</th>
                  <th>Name of Activity</th>
                  <th>End of Evaluation</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $result = $student->select('student', '*', ['student_id' => User::returnValueSession('student_id')]);
                $row = mysqli_fetch_assoc($result);

                $result2 = $student->select('evaluation_of_activities', '*', ['name_of_org'=>$row['can_evaluate']]);
                $row2 = mysqli_fetch_assoc($result2);

                if ($row['can_evaluate'] == NULL || $row['can_evaluate'] == "") {
                  echo "<h4 class='text-center'>No Evaluation Available</h4>";
                }else if ($row2) {

                  if($row2['exp_date'] > $date_time_now) {

                ?>

                <td><?php echo $row['can_evaluate']; ?></td>
                <td><?php echo $row2['name_of_activity']; ?></td>
                <td><?php echo $row2['exp_date']; ?></td>

                <td><a href="student-evaluate-activities-homepage.php?can_evaluate=<?php echo $row['can_evaluate']; ?>" class="btn btn-primary"><i class="fa-solid fa-file-import"></i> Evaluate</a></td>
                  
                <?php } else {
                  $student->updateData('student', ['can_evaluate'=>""], ['course'=>User::returnValueSession('student-course')]);

                }

                } ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>

  <?php
    require 'student-footer.php';
  ?>

<script>
    window.addEventListener("focus", function() {
      location.reload();
    });
</script>

</body>

</html>