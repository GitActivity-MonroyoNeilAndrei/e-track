<?php

include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$admin = new database();

$error;
$adviser_name = "";

$updated;
$added;


$studentOrg = User::returnValueGet('studentOrg');
$schoolYear = User::returnValueGet('latestSchoolYear');

if (isset($_POST['add-edit-adviser'])) {
  $adviser = $_POST['adviser'];



  if ($adviser == "") {
    $error = "input empty";
  } else if ($admin->isExisted('officers', ['position'=>'Adviser', 'org_name' => User::returnValueGet('studentOrg'), 'school_year'=> User::returnValueGet('latestSchoolYear')])) {
    $admin->updateData('officers', ['first_name' => $adviser], ['id' => $admin->last_id]);
    $updated = "Adviser Successfully Updated";
  } else {
    $admin->insertData('officers', ['position' => 'Adviser', 'first_name' => $adviser, 'org_name' => User::returnValueGet('studentOrg'), 'school_year' => User::returnValueGet('latestSchoolYear')]);
    $added = "Adviser Successfully Added";

  }
}

$adviser_result = $admin->select('officers', '*', ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg'), 'position'=>'Adviser']);

while ($row = mysqli_fetch_assoc($adviser_result)) {
  $adviser_name = $row['first_name'];
}




$result = $admin->select('officers', '*', ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg')]);

if (isset($_POST['edit'])) {

while ($row = mysqli_fetch_assoc($result)) {
  $id = $row['id'];

  $first = $id . "first";
  $last = $id . "last";
  $image = $id . "image";

  
  $first_name = mysqli_escape_string($admin->mysqli, $_POST["$first"]);
  $last_name = mysqli_escape_string($admin->mysqli, $_POST["$last"]);
  

  $admin->updateData('officers', ['first_name'=>$first_name, 'last_name'=>$last_name], ['id'=>$id]);


  $admin->updateImage("$image", 'officers', 'photo_url', '../uploads/');
  
}
 header("location: admin-student-organization.php?activeStudentOrg=$studentOrg&school_year=$schoolYear");

}









?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Admin Account</title>
  <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
  <link rel="stylesheet" href="../css/login-create-account.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/bootstrap/bootstrap.css?<?php echo time(); ?>">
</head>

<body>
  <img src="../images/msc_logo.png" alt="MSC logo">
  <div class="wrapper" style="max-width: 22rem;">
    <h3 class="text-center">Edit Members</h3>

    <form method="post">
      <?php
        if (isset($updated)) {
          echo '
          <div class="alert alert-success" role="alert">
            '.$updated.'
          </div>
          ';
        } else if (isset($added)) {
          echo '
          <div class="alert alert-success" role="alert">
            '.$added.'
          </div>
          ';
        }
      ?>
      <div>
        <?php if (isset($error)) {
          echo "<div class='alert alert-danger' role='alert'>
            $error
          </div>";
        } ?>
        <label for="adviser">Adviser:</label>
        <input class="form-control" type="text" name="adviser" value="<?php echo $adviser_name; ?>">
      </div>
      <div class="d-flex text">
        <input class="btn btn-primary" style="font-size: .9em;" type="submit" name="add-edit-adviser" value="add-adviser">
      </div>
    </form>


    <form method="post" enctype="multipart/form-data">
    <?php
      $result = $admin->select('officers', '*', ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg')]);

      while ($row = mysqli_fetch_assoc($result)) {
      if ($row['position'] == "Adviser") {
        
      } else {

      
      $id = $row['id'];
    ?>
      <div>
        <label for="escort"><?php echo $row['position']; ?>:</label>
        <div class="d-flex">
          <input class="form-control" type="text" name="<?php echo $id . "first"; ?>" value="<?php echo $row['first_name']; ?>" required>
          <input class="form-control" type="text" name="<?php echo $id . "last"; ?>" value="<?php echo $row['last_name']; ?>" required>
          <input class="form-control" type="file" name="<?php echo $id . "image"; ?>">
        </div>
      </div>

    <?php } } ?>

      <div class="text-center">
        <input class="btn btn-success" type="submit" value="Edit" name="edit">
        <a class="btn btn-danger mt-1" href="admin-student-organization.php?activeStudentOrg=<?php User::printGet('studentOrg'); ?>">Cancel</a>
      </div>
    </form>


  </div>
</body>

</html>