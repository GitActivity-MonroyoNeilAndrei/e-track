<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$student = new database();

if (!isset($_SESSION['student_id'])) {
  header('location: ../login-account/login-student.php');
}

$student_id = User::returnValueSession('student-id');


User::ifDeactivatedReturnTo($student->select('student', 'status', ['id'=>$student_id]), '../logout.php?logout=student');

if (isset($_POST['submit'])) {

  $positions = ['President', 'Vice_President', 'Secretary', 'Treasurer', 'Auditor', 'PIO', 'Project_Manager', 'Sargeant_at_Arms', 'Muse', 'Escort'];

  foreach ($positions as $position) {

    if (isset($_POST["$position"])) {
      $candidates = $_POST["$position"];

      foreach ($candidates as $candidate) {
        $student->incrementData('candidate', 'number_of_votes', ['id'=>"$candidate"]);
      }
    }
  }
  $result = $student->updateData('student', ['can_vote'=>'', 'can_monitor'=>User::returnValueGet('can_vote')], ['student_id'=>User::returnValueSession('student_id')]);


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
    <div class="page-content">

      <div class="vote-section">
        <form class="vote-section-content" style="position: sticky; top: 0; height: 100vh;" method="post">

          <?php
          $positions = ['President', 'Vice President', 'Secretary', 'Treasurer', 'Auditor', 'PIO', 'Project Manager', 'Sargeant at Arms', 'Muse', 'Escort'];
          foreach ($positions as $position) {
          ?>
            <div id="<?php echo $position; ?>">


              <h4 class="mt-5"><?php echo $position; ?></h4>
              <?php
              $candidate = $student->select('candidate', '*', ['position' => $position, 'org_name' => User::returnValueGet('can_vote')]);
              while ($row = mysqli_fetch_assoc($candidate)) {
              ?>
                <div class="vote-candidate ps-2">
                  <input name="<?php echo str_replace(" ", "_", "$position"); ?>[]" class="form-check-input" type="checkbox" value="<?php echo $row['id']; ?>">

                  <label for="<?php echo $position; ?>"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></label>
                </div>
              <?php } ?>
            </div>
            <script>
              onlyTwoCheckBox("<?php echo $position ?>");
            </script>
          <?php } ?>

          <input class="btn btn-primary mx-auto mt-4" type="submit" name="submit" value="Submit">
        </form>
      </div>


      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5 class="text-start">Voting Ballot</h5>
          </div>
          <h6>Voting will expired in: july 20 2023</h6>
          <div class="container-add-candidate">
            <h2 class="text-center py-1 fw-bold">Vote Responsibly</h2>
          </div>

          <?php

          $positions = ['President', 'Vice President', 'Secretary', 'Treasurer', 'Auditor', 'PIO', 'Project Manager',  'Sargeant at Arms', 'Muse', 'Escort'];
          foreach ($positions as $position) {

          ?>
            <h3 class="text-center fw-bold"><?php echo $position; ?></h3>
            <!-- Candidates -->
            <?php
            $result = $student->select('candidate', '*', ['position' => $position, 'org_name' => User::returnValueGet('can_vote')]);
            while ($row = mysqli_fetch_assoc($result)) {
            ?>

              <div class="candidate-container">
                <div class="bg-secondary bg-gradient ">
                  <div class="candidate-image">
                    <img style="height: 100%; width: 100%;" src="../uploads/<?php echo $row['photo_url'] ?>" alt="candidate image">
                  </div>
                </div>
                <h4 class="mt-5">Candidate No. 1</h4>
                <h5 class="fw-bold"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></h5>
                <h5><?php echo $row['partylist'] . ' Partylist'; ?></h5>
                <p class="candidate-description"><?php echo $row['introduce_yourself']; ?></p>
              </div>
            <?php } ?>

            <div style="margin-bottom: 5rem ;border-bottom: 8px solid green;"></div>
          <?php } ?>

        </div>
      </div>
    </div>
  </div>
</body>

</html>