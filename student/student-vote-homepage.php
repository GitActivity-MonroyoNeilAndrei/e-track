<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$student = new database();

$num = 0;

if (!isset($_SESSION['student_id'])) {
  header('location: ../login-account/login-user.php');
}

$student_id = User::returnValueSession('id');


User::ifDeactivatedReturnTo($student->select('student', 'status', ['id' => $student_id]), '../logout.php?logout=student');

$candidateTwoWinners = ["", "", "", "", ""];

$positions = array();

$result = $student->selectDistinct('candidate', 'position', ['org_name' => User::returnValueGet('can_vote')]);
$j = 0;
while ($row = mysqli_fetch_assoc($result)) {
  $positions[$j] = $row['position'];
  $j++;
}

$result = $student->selectDistinct('candidate', 'position, max_winners', ['org_name' => User::returnValueGet('can_vote')]);
$i = 0;
while ($row = mysqli_fetch_assoc($result)) {
  if($row['max_winners'] >= 2) {
    $candidateTwoWinners[$i] = $row['position'];
    $i++;
  }
}




if (isset($_POST['submit'])) {

  $positions1 = array();

  $result = $student->selectDistinct('candidate', 'position', ['org_name' => User::returnValueGet('can_vote')]);
  $j = 0;
  while ($row = mysqli_fetch_assoc($result)) {
    echo $row['position'];
    $positions1[$j] = $row['position'];
    $j++;
  }

  foreach ($positions1 as $position) {

    $position = str_replace(" ", "_", "$position");

    if (isset($_POST["$position"])) {
      $candidates = $_POST["$position"];

      foreach ($candidates as $candidate) {
        $student->incrementData('candidate', 'number_of_votes', ['id' => "$candidate"]);
      }
    }
  }
  $result = $student->updateData('student', ['can_vote' => '', 'voted'=>User::returnValueGet('can_vote'), 'can_monitor' => User::returnValueGet('can_vote')], ['student_id' => User::returnValueSession('student_id')]);


  header('location: student-vote.php?voteSuccessfully');
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <title>Admin Home Page</title> -->
  <title></title>
  <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
  <link rel="stylesheet" href="../css/bootstrap/bootstrap.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/student.css?<?php echo time(); ?>">
  <!-- <script src="../js/script.js"></script> -->
  <script src="https://kit.fontawesome.com/ba2dc1cde9.js" crossorigin="anonymous"></script>


  <script>
    function onlyTwoCheckBox(div_id) {
    var limit = 1;
    if(div_id == "<?php echo $candidateTwoWinners[0]; ?>" ||
     div_id == "<?php echo $candidateTwoWinners[1]; ?>" ||
     div_id == "<?php echo $candidateTwoWinners[2]; ?>" ||
     div_id == "<?php echo $candidateTwoWinners[3]; ?>") 
    {
      limit = 2;
    }

    console.log(limit);

    // gets the 2 inputs on/off
    var checkboxgroup = document.getElementById(div_id).getElementsByTagName("input");
    // for loop to iterate to the inputs, in our case just 2 inputs
    for (var i = 0; i < checkboxgroup.length; i++) {
      checkboxgroup[i].onclick = function() {
        var checkedcount = 0;
        // increment the value of checkedcount if we check something in the checkbox input
        for (var i = 0; i < checkboxgroup.length; i++) {
          checkedcount += (checkboxgroup[i].checked) ? 1 : 0;
        }
        // if the limit is reach, we must throw an alert message saying that the user reach their limit checks
        if (checkedcount > limit) {
          console.log("You can select maximum of " + limit);
          alert("You can select maximum of " + limit );
          this.checked = false;
        }
      }
    }
  }
  </script>


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
    <form class="page-content d-flex flex-column p-3" method="post">


    <?php


    foreach ($positions as $position) {
    ?>

    <div class="candidate-container">
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
          <div class="candidate-details-image shadow-lg">
            <div><img class="candidate-details-image" src="../uploads/<?php echo $row['photo_url']; ?>" alt=""></div>
          </div>
          <div class="candidate-details-name"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></div>
          <div class="candidate-details-partylist"><?php echo $row['partylist'] . ' Partylist'; ?></div>
        </div>
        <div class="candidate-description shadow">

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

    <input class="btn btn-primary mx-auto mt-1" type="submit" name="submit" value="Submit">



    </form>
  </div>
  <style>
    form div.candidate-container {
      margin: 0 !important;
    }
  </style>



</body>

</html>