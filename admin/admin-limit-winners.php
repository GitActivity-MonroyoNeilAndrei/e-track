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

function changeSpcToUds($x) {
  return str_replace(' ', '_', $x);
}

function changeUdsToSpc($x) {
  return str_replace('_', ' ', $x);
}


if(isset($_POST['set'])) {

  $candidates = $admin->selectDistinct('candidate', 'position', ['org_name'=>User::returnValueGet('studentOrg')]);

  while ($row = mysqli_fetch_assoc($candidates)) {
    $type_of_position = $row['position'];

    echo $type_of_position;

    $limit_winner = mysqli_escape_string($admin->mysqli, $_POST[changeSpcToUds($type_of_position)]);

    $position = $admin->updateData('candidate', ['max_winners'=>$limit_winner], ['position'=>$type_of_position, 'org_name'=>User::returnValueGet('studentOrg')]);

  }

  header("location: admin-election.php?addCandidateSuccess&activeStudentOrg=" . User::returnValueGet('studentOrg'));

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
    <h5 class="text-center">Limit Winners for <?php User::printGet('studentOrg') ?></h5>

    <?php
      $candidates = $admin->selectDistinct('candidate', 'position, max_winners', ['org_name'=>User::returnValueGet('studentOrg')]);
      
      while ($row = mysqli_fetch_assoc($candidates)) {
        $number_of_limit = $row['max_winners'];
      
    ?>

    <div class="d-flex justify-content-start align-items-center mb-1">
      <label class="fs-6 me-3"><?php echo $row['position']; ?></label>
      <select style="width: 4rem;" class="form-select" name="<?php echo changeSpcToUds($row['position']);  ?>">
        <option value="1" <?php echo ($number_of_limit == 1) ? "selected" : ""; ?>>1</option>
        <option value="2" <?php echo ($number_of_limit == 2) ? "selected" : ""; ?>>2</option>
      </select>
    </div>

    <?php
      }
    ?>

    <div class="d-flex justify-content-center align-items-center mt-3">
      <input class="btn btn-success me-3" type="submit" name="set" value="Set" required>
      <a class="btn btn-danger" href="admin-election.php?activeStudentOrg=<?php User::printGet('studentOrg') ?>">Cancel</a>
    </div>
  </form>

</body>
</html>