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


if (isset($_POST['submit'])) {

  $questionnaires = $student->select('evaluation_of_activities', '*', ['name_of_org'=>User::returnValueGet('can_evaluate')]);

  while ($row = mysqli_fetch_assoc($questionnaires)) {
    $student->updateData('evaluation_of_activities', ['comment'=>$_POST['commentid']], ['id'=>$row['id']]);
    if (isset($_POST["$row[id]"])) {


      switch ($_POST["$row[id]"]) {
        case 5:
            $student->incrementData('evaluation_of_activities', "five", ['id'=>$row['id']]);
          break;
        case 4:
          $student->incrementData('evaluation_of_activities', "four", ['id'=>$row['id']]);
          break;
        case 3:
          $student->incrementData('evaluation_of_activities', "three", ['id'=>$row['id']]);
          break;
        case 2:
          $student->incrementData('evaluation_of_activities', "two", ['id'=>$row['id']]);
          break;
        case 1:
          $student->incrementData('evaluation_of_activities', "one", ['id'=>$row['id']]);
          break;
    }
    }
  }

  $student->updateData('student', ['can_evaluate'=>"", ], ['id'=>$student_id]);

  header("location: student-evaluate-activities.php?evaluated");
}

$name_of_activity;
$activity = $student->select('evaluation_of_activities', '*', ['name_of_org'=>User::returnValueGet('can_evaluate')]);

while ($row = mysqli_fetch_assoc($activity)) {
  $name_of_activity = $row['name_of_activity'];
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


</head>

<body>
<div class="body">
  <div class="header bg-green-1">
    <div class="d-flex align-items-center"><img class="header-logo" src="../images/msc_logo.png" alt="msc logo">
      <h3 class=" header-texts">MARINDUQUE STATE COLLEGE</h3>
    </div>

  </div>

  <div class="content border border-primary">
      <div class="content-container">
        <div class="content-header">
          <h5 class="text-start">Evaluate Activity</h5>
        </div>

        <div class="container-add-candidate">
          <h5 class="text-center fw-bold py-1">Evaluation for <?php echo $name_of_activity; ?></h5>
        </div>

        <form method="post">    


        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Questionnaire</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>Comment</th>
                
              </tr>
            </thead>

            <tbody>

          <?php
            $questionnaires = $student->select('evaluation_of_activities', '*', ['name_of_org'=>User::returnValueGet('can_evaluate')]);

            while ($row = mysqli_fetch_assoc($questionnaires)) {
          ?>
            <tr>
              <td><?php echo $row['questionnaire']; ?></td>
              <td><input class="form-check-input" type="radio" name="<?php echo $row['id']; ?>" value="1"></td>
              <td><input class="form-check-input" type="radio" name="<?php echo $row['id']; ?>" value="2"></td>
              <td><input class="form-check-input" type="radio" name="<?php echo $row['id']; ?>" value="3"></td>
              <td><input class="form-check-input" type="radio" name="<?php echo $row['id']; ?>" value="4"></td>
              <td><input class="form-check-input" type="radio" name="<?php echo $row['id']; ?>" value="5"></td>
              <td><input class="form-control" type="text" name="<?php echo 'comment'.$row['id']; ?>"></td>
            </tr>
          

          <?php } ?>
          </tbody>

          </table>

        </div>

        <div class="d-flex justify-content-center my-3">
          <input class="btn btn-primary" type="submit" name="submit">
        </div>
        </form>
        </div>

    </div>





</div>
</body>

</html>