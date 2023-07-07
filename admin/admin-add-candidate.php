<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$admin = new database();

$candidateExist = false;

User::ifGetNotIssetReturnTo('studentOrg', 'admin-election.php');

if(isset($_POST['add-candidate'])) {
  $position = mysqli_escape_string($admin->mysqli, $_POST['position']);
  $first_name = mysqli_escape_string($admin->mysqli, $_POST['first-name']);
  $last_name = mysqli_escape_string($admin->mysqli, $_POST['last-name']);
  $year = mysqli_escape_string($admin->mysqli, $_POST['year']);
  $partylist = mysqli_escape_string($admin->mysqli, $_POST['partylist']);

  if($admin->isExisted('candidate', ['position'=>$position, 'first_name'=>$first_name, 'last_name'=>$last_name, 'year'=>$year, 'partylist'=>$partylist, 'org_name'=>$org_name, 'org_name'=>User::returnValueGet('studentOrg')])) {
    $candidateExist = true;
  }else {
    $admin->insertData('candidate', ['position'=>$position, 'first_name'=>$first_name, 'last_name'=>$last_name, 'year'=>$year, 'partylist'=>$partylist, 'org_name'=>User::returnValueGet('studentOrg')]);
    $admin->insertImage('candidate-image', 'candidate', 'photo_url', 'uploads/');
    header("location: admin-election.php?addCandidateSuccess&activeStudentOrg=". User::returnValueGet('studentOrg'));
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/bootstrap.css?<?php echo time(); ?>">

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

  <form class="d-flex flex-column mx-auto mt-5 p-3 border rounded-3" style="max-width: 15rem; " method="post" enctype="multipart/form-data">
    <h5 class="text-center">Add Candidate for <?php User::printGet('studentOrg') ?></h5>
    <?php if($candidateExist) {Message::userAlreadyExist();} ?>
    <label class="form-label" for="position">Position</label>
    <input class="form-control" type="text" name="position" required>
    <label class="form-label" for="first-name">First Name</label>
    <input class="form-control" type="text" name="first-name" required>
    <label class="form-label" for="last-name">Last Name</label>
    <input class="form-control" type="text" name="last-name" required>
    <label class="form-label" for="year">Year</label>
    <input class="form-control" type="text" name="year" required>
    <label for="">Upload Image</label>
    <div class="input-group mb-1">
      <input type="file" class="form-control" name="candidate-image" required>
    </div>
    <label class="form-label" for="partylist">Partylist</label>
    <input class="form-control" type="text" name="partylist" required>
    <div class="d-flex justify-content-center align-items-center mt-3">
      <input class="btn btn-success me-3" type="submit" name="add-candidate" value="Add" required>
      <a class="btn btn-danger" href="admin-election.php?activeStudentOrg=<?php User::printGet('studentOrg') ?>">Cancel</a>
    </div>
  </form>

</body>

</html>