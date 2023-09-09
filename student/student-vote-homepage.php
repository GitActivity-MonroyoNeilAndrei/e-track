<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$student = new database();

$num = 0;

if (!isset($_SESSION['student_id'])) {
  header('location: ../login-account/login-student.php');
}

$student_id = User::returnValueSession('student-id');


User::ifDeactivatedReturnTo($student->select('student', 'status', ['id' => $student_id]), '../logout.php?logout=student');

if (isset($_POST['submit'])) {

  $positions = ['President', 'Vice_President', 'Secretary', 'Treasurer', 'Auditor', 'PIO', 'Project_Manager', 'Sargeant_at_Arms', 'Muse', 'Escort'];

  foreach ($positions as $position) {

    if (isset($_POST["$position"])) {
      $candidates = $_POST["$position"];

      foreach ($candidates as $candidate) {
        $student->incrementData('candidate', 'number_of_votes', ['id' => "$candidate"]);
      }
    }
  }
  $result = $student->updateData('student', ['can_vote' => '', 'can_monitor' => User::returnValueGet('can_vote')], ['student_id' => User::returnValueSession('student_id')]);


  header('location: student-vote.php?voteSuccessfully');
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
  <script src="../js/script.js"></script>
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
          <a href="#"><i class="fa-solid fa-address-card"></i> My Profile</a>
          <a href="../logout.php?logout=student"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
      </div>
    </div>
    <form class="page-content d-flex flex-column p-3" method="post">


    <?php

    $positions = ['President', 'Vice President', 'Secretary', 'Treasurer', 'Auditor', 'PIO', 'Project Manager',  'Sargeant at Arms', 'Muse', 'Escort'];
    foreach ($positions as $position) {
    ?>

    <div class="candidate-container mt-0">
      <div class="candidate-position bg-primary">
        <?php echo $position; ?>
      </div>

      <?php
        $result = $student->select('candidate', '*', ['position' => $position, 'org_name' => User::returnValueGet('can_vote')]);
        while ($row = mysqli_fetch_assoc($result)) {
      ?>

      <div class="candidate-position-border"></div>
      <div class="candidate">
        <div class="candidate-details">
          <div class="candidate-details-image">
            <div><img class="candidate-details-image" src="../uploads/IMG-64d8733b976686.19475466.png" alt=""></div>
          </div>
          <div class="candidate-details-name"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></div>
          <div class="candidate-details-partylist"><?php echo $row['partylist'] . ' Partylist'; ?></div>
        </div>
        <div class="candidate-description">

          <p><?php echo $row['introduce_yourself']; ?></p>
        </div>
      </div>



      <?php } ?>
      
      <div id="<?php echo $position; ?>" class="vote-section">
      <?php
        $candidate = $student->select('candidate', '*', ['position' => $position, 'org_name' => User::returnValueGet('can_vote')]);
        while ($row = mysqli_fetch_assoc($candidate)) {
          $num += 1;
      ?>

        <input name="<?php echo str_replace(" ", "_", "$position"); ?>[]" type="checkbox" class="btn-check" id="<?php echo $num; ?>"  value="<?php echo $row['id']; ?>" autocomplete="off">
        <label class="btn btn-outline-danger m-2" for="<?php echo $num; ?>"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></label>

      <?php } ?>


        
      </div>
      <script>
        onlyTwoCheckBox("<?php echo $position ?>");
      </script>


    </div>
    <?php } ?>

    <input class="btn btn-primary mx-auto mt-4" type="submit" name="submit" value="Submit">



    </form>
  </div>
</body>

</html>