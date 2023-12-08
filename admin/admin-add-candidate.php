<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$admin = new database();

$candidateExist = false;

User::ifGetNotIssetReturnTo('studentOrg', 'admin-election.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id'=>$admin_id]), '../logout.php?logout=admin');

if (isset($_POST['add-candidate'])) {
  $position = mysqli_escape_string($admin->mysqli, $_POST['position']);
  $first_name = mysqli_escape_string($admin->mysqli, $_POST['first-name']);
  $last_name = mysqli_escape_string($admin->mysqli, $_POST['last-name']);
  $year = mysqli_escape_string($admin->mysqli, $_POST['year']);
  $partylist = mysqli_escape_string($admin->mysqli, $_POST['partylist']);
  $introduce_yourself = mysqli_escape_string($admin->mysqli, $_POST['introduce-yourself']);


  if ($admin->isExisted('candidate', ['first_name' => $first_name, 'last_name' => $last_name, 'year' => $year, 'org_name' => User::returnValueGet('studentOrg'),])) {
    $candidateExist = true;
  } else {

    $admin->insertData('candidate', ['position' => $position, 'first_name' => $first_name, 'last_name' => $last_name, 'year' => $year, 'partylist' => $partylist, 'introduce_yourself' => $introduce_yourself, 'org_name' => User::returnValueGet('studentOrg')]);

    if ($admin->insertImage('candidate-image', 'candidate', 'photo_url', '../uploads/')) {
      header("location: admin-election.php?addCandidateSuccess&activeStudentOrg=" . User::returnValueGet('studentOrg') . "&addSuccessful");
    } else {
      $wrong_file = "jpg, jpeg and png files only";
    }
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

  <form class="d-flex flex-column mx-auto mt-5 p-3 border rounded-3" style="max-width: 15rem; " method="post" enctype="multipart/form-data">
    <h5 class="text-center">Add Candidate for <?php User::printGet('studentOrg') ?></h5>
    <?php if ($candidateExist) {
      echo '
      <div class="alert alert-danger" role="alert">
        Candidate Already Exist
      </div>
      ';
    } ?>

    <label class="form-label">Position</label>
    <input class="form-control" list="datalistOptions" id="exampleDataList" name="position">
    <datalist id="datalistOptions">
    <option selected value="President">President</option>
      <option value="Vice President">Vice President</option>
      <option value="Secretary">Secretary</option>
      <option value="Treasurer">Treasurer</option>
      <option value="Auditor">Auditor</option>
      <option value="PIO">PIO</option>
      <option value="Project Manager">Project Manager</option>
      <option value="Sargeant at Arms">Sargeant at Arms</option>
      <option value="Muse">Muse</option>
      <option value="Escort">Escort</option>
    </datalist>


    <label class="form-label" for="first-name">First Name</label>
    <input class="form-control" type="text" name="first-name" required>
    <label class="form-label" for="last-name">Last Name</label>
    <input class="form-control" type="text" name="last-name" required>

    <label class="form-label" for="year">Year</label>
    <select class="form-select" name="year">
      <option selected value="first">1st</option>
      <option value="second">2nd</option>
      <option value="third">3rd</option>
      <option value="fourth">4th</option>
    </select>
    <?php if (isset($wrong_file)) {
      Message::invalidFile();
    } ?>
    <label for="">Upload Image</label>
    <div class="input-group mb-1">
      <input type="file" class="form-control" name="candidate-image" required>
    </div>
    <label class="form-label" for="partylist">Partylist</label>
    <input class="form-control" type="text" name="partylist" required>

    <label class="form-label" for="introduce-yourself">Description</label>
    <textarea class="form-control" style="font-size: .85rem;" type="text" name="introduce-yourself" rows="6"> </textarea>

    <div class="d-flex justify-content-center align-items-center mt-3">
      <input class="btn btn-success me-3" type="submit" name="add-candidate" value="Add" required>
      <a class="btn btn-danger" href="admin-election.php?activeStudentOrg=<?php User::printGet('studentOrg') ?>">Cancel</a>
    </div>
  </form>

</body>

</html>