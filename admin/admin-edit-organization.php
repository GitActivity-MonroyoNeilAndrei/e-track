<?php

include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$admin = new database();


$officers = array();
$images = array();

$PIO = 0;
$project_manager = 0;
$sargeant_at_arms = 0;


$result = $admin->select('officers', '*', ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg')]);

while ($row = mysqli_fetch_assoc($result)) {


  if ($row['position'] == 'PIO') {
    $PIO += 1;

    $details = [$row['first_name'], $row['last_name'], $row['id']];

    $officers += ["$row[position]" . $PIO => $details];
  } else if ($row['position'] == 'Project Manager') {
    $project_manager += 1;

    $details = [$row['first_name'], $row['last_name'], $row['id']];

    $officers += ["$row[position]" . $project_manager => $details];
  } else if ($row['position'] == 'Sargeant at Arms') {
    $sargeant_at_arms += 1;

    $details = [$row['first_name'], $row['last_name'], $row['id']];

    $officers += ["$row[position]" . $sargeant_at_arms => $details];
  } else if ($row['position'] == 'Adviser') {
    $details = [$row['first_name'], $row['id']];
    $officers += ["$row[position]" => $details];
  } else {
    $details = [$row['first_name'], $row['last_name'], $row['id']];

    $officers += ["$row[position]" => $details];
  }
}
if (isset($_POST['edit'])) {

  $president_first_name = $_POST["president-first-name"];
  $president_last_name = $_POST["president-last-name"];
  $vice_president_first_name = $_POST["vice-president-first-name"];
  $vice_president_last_name = $_POST["vice-president-last-name"];
  $secretary_first_name = $_POST["secretary-first-name"];
  $secretary_last_name = $_POST["secretary-last-name"];
  $treasurer_first_name = $_POST["treasurer-first-name"];
  $treasurer_last_name = $_POST["treasurer-last-name"];
  $auditor_first_name = $_POST["auditor-first-name"];
  $auditor_last_name = $_POST["auditor-last-name"];
  $pio1_first_name = $_POST["pio1-first-name"];
  $pio1_last_name = $_POST["pio1-last-name"];
  $pio2_first_name = $_POST["pio2-first-name"];
  $pio2_last_name = $_POST["pio2-last-name"];
  $project_manager1_first_name = $_POST["project-manager1-first-name"];
  $project_manager1_last_name = $_POST["project-manager1-last-name"];
  $project_manager2_first_name = $_POST["project-manager2-first-name"];
  $project_manager2_last_name = $_POST["project-manager2-last-name"];
  $sargeant_at_arms1_first_name = $_POST["sargeant-at-arms1-first-name"];
  $sargeant_at_arms1_last_name = $_POST["sargeant-at-arms1-last-name"];
  $sargeant_at_arms2_first_name = $_POST["sargeant-at-arms2-first-name"];
  $sargeant_at_arms2_last_name = $_POST["sargeant-at-arms2-last-name"];
  $muse_first_name = $_POST["muse-first-name"];
  $muse_last_name = $_POST["muse-last-name"];
  $escort_first_name = $_POST["escort-first-name"];
  $escort_last_name = $_POST["escort-last-name"];



  $admin->updateData('officers', ['first_name' => $president_first_name, 'last_name' => $president_last_name], ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg'), 'id' => $officers['President'][2]]);
  $admin->updateImage('president-image', 'officers', 'photo_url', '../uploads/');

  $admin->updateData('officers', ['first_name' => $vice_president_first_name, 'last_name' => $vice_president_last_name], ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg'), 'id' => $officers['Vice President'][2]]);
  $admin->updateImage('vice-president-image', 'officers', 'photo_url', '../uploads/');

  $admin->updateData('officers', ['first_name' => $secretary_first_name, 'last_name' => $secretary_last_name], ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg'), 'id' => $officers['Secretary'][2]]);
  $admin->updateImage('secretary-image', 'officers', 'photo_url', '../uploads/');

  $admin->updateData('officers', ['first_name' => $treasurer_first_name, 'last_name' => $treasurer_last_name], ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg'), 'id' => $officers['Treasurer'][2]]);
  $admin->updateImage('treasurer-image', 'officers', 'photo_url', '../uploads/');

  $admin->updateData('officers', ['first_name' => $auditor_first_name, 'last_name' => $auditor_last_name], ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg'), 'id' => $officers['Auditor'][2]]);
  $admin->updateImage('auditor-image', 'officers', 'photo_url', '../uploads/');

  $admin->updateData('officers', ['first_name' => $pio1_first_name, 'last_name' => $pio1_last_name], ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg'), 'id' => $officers['PIO1'][2]]);
  $admin->updateImage('pio-image', 'officers', 'photo_url', '../uploads/');

  $admin->updateData('officers', ['first_name' => $pio2_first_name, 'last_name' => $pio2_last_name], ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg'), 'id' => $officers['PIO2'][2]]);
  $admin->updateImage('pio2-image', 'officers', 'photo_url', '../uploads/');

  $admin->updateData('officers', ['first_name' => $project_manager1_first_name, 'last_name' => $project_manager1_last_name], ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg'), 'id' => $officers['Project Manager1'][2]]);
  $admin->updateImage('project-manager-image', 'officers', 'photo_url', '../uploads/');

  $admin->updateData('officers', ['first_name' => $project_manager2_first_name, 'last_name' => $project_manager2_last_name], ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg'), 'id' => $officers['Project Manager2'][2]]);
  $admin->updateImage('project-manager2-image', 'officers', 'photo_url', '../uploads/');

  $admin->updateData('officers', ['first_name' => $sargeant_at_arms1_first_name, 'last_name' => $sargeant_at_arms1_last_name], ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg'), 'id' => $officers['Sargeant at Arms1'][2]]);
  $admin->updateImage('sargeant-at-arms-image', 'officers', 'photo_url', '../uploads/');

  $admin->updateData('officers', ['first_name' => $sargeant_at_arms2_first_name, 'last_name' => $sargeant_at_arms2_last_name], ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg'), 'id' => $officers['Sargeant at Arms2'][2]]);
  $admin->updateImage('sargeant-at-arms2-image', 'officers', 'photo_url', '../uploads/');

  $admin->updateData('officers', ['first_name' => $muse_first_name, 'last_name' => $muse_last_name], ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg'), 'id' => $officers['Muse'][2]]);
  $admin->updateImage('muse-image', 'officers', 'photo_url', '../uploads/');

  $admin->updateData('officers', ['first_name' => $escort_first_name, 'last_name' => $escort_last_name], ['school_year' => User::returnValueGet('latestSchoolYear'), 'org_name' => User::returnValueGet('studentOrg'), 'id' => $officers['Escort'][2]]);
  $admin->updateImage('escort-image', 'officers', 'photo_url', '../uploads/');

  $org_name = User::returnValueGet('studentOrg');
  header("location: admin-student-organization.php?activeStudentOrg=$org_name");
} else if (isset($_POST['add-edit-adviser'])) {
  $adviser = $_POST['adviser'];


  if ($adviser == "") {
    $error = "input empty";
  } else if ($admin->isExisted('officers', ['position'=>'Adviser', 'org_name' => User::returnValueGet('studentOrg'), 'school_year' => User::returnValueGet('latestSchoolYear')])) {
    $admin->updateData('officers', ['first_name' => $adviser], ['id' => $admin->last_id]);
  } else {
    $admin->insertData('officers', ['position' => 'Adviser', 'first_name' => $adviser, 'org_name' => User::returnValueGet('studentOrg'), 'school_year' => User::returnValueGet('latestSchoolYear')]);
  }





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
      <div>
        <?php if (isset($error)) {
          echo "<div class='alert alert-danger' role='alert'>
                                          $error
                                       </div>";
        } ?>
        <label for="adviser">Adviser:</label>
        <input class="form-control" type="text" name="adviser" value="<?php if (array_key_exists("Adviser", $officers)) { echo $officers['Adviser'][0];} ?>">
      </div>
      <div class="d-flex text">
        <input class="btn btn-primary" style="font-size: .9em;" type="submit" name="add-edit-adviser" value="edit-adviser">
      </div>
    </form>

    <form method="post" enctype="multipart/form-data">
      <div>
        <label for="president">President:</label>
        <div class="d-flex">
          <input class="form-control" type="text" name="president-first-name" value="<?php if (array_key_exists("President", $officers)) { echo $officers['President'][0];} ?>" required>
          <input class="form-control" type="text" name="president-last-name" value="<?php if (array_key_exists("President", $officers)) { echo $officers['President'][1];} ?>" required>
          <input class="form-control" type="file" name="president-image">
        </div>
      </div>
      <div>
        <label for="vice-president">Vice President:</label>
        <div class="d-flex">
          <input class="form-control" type="text" name="vice-president-first-name" value="<?php echo $officers['Vice President'][0]; ?>" required>
          <input class="form-control" type="text" name="vice-president-last-name" value="<?php echo $officers['Vice President'][1]; ?>" required>
          <input class="form-control" type="file" name="vice-president-image">
        </div>
      </div>
      <div>
        <label for="secretary">Secretary:</label>
        <div class="d-flex">
          <input class="form-control" type="text" name="secretary-first-name" value="<?php if (array_key_exists("Secretary", $officers)) { echo $officers['Secretary'][0];} ?>" required>
          <input class="form-control" type="text" name="secretary-last-name" value="<?php if (array_key_exists("Secretary", $officers)) { echo $officers['Secretary'][1];} ?>" required>
          <input class="form-control" type="file" name="secretary-image">
        </div>
      </div>
      <div>
        <label for="treasurer">Treasurer:</label>
        <div class="d-flex">
          <input class="form-control" type="text" name="treasurer-first-name" value="<?php if (array_key_exists("Treasurer", $officers)) { echo $officers['Treasurer'][0];} ?>" required>
          <input class="form-control" type="text" name="treasurer-last-name" value="<?php if (array_key_exists("Treasurer", $officers)) { echo $officers['Treasurer'][1];} ?>" required>
          <input class="form-control" type="file" name="treasurer-image">
        </div>
      </div>
      <div>
        <label for="auditor">Auditor:</label>
        <div class="d-flex">
          <input class="form-control" type="text" name="auditor-first-name" value="<?php if (array_key_exists("Auditor", $officers)) { echo $officers['Auditor'][0];} ?>" required>
          <input class="form-control" type="text" name="auditor-last-name" value="<?php if (array_key_exists("Auditor", $officers)) { echo $officers['Auditor'][1];} ?>" required>
          <input class="form-control" type="file" name="auditor-image">
        </div>
      </div>
      <div>
        <label for="pio">PIO:</label>
        <div class="d-flex">
          <input class="form-control" type="text" name="pio1-first-name" value="<?php if (array_key_exists("PIO1", $officers)) { echo $officers['PIO1'][0];} ?>" required>
          <input class="form-control" type="text" name="pio1-last-name" value="<?php if (array_key_exists("PIO1", $officers)) { echo $officers['PIO1'][1];} ?>" required>
          <input class="form-control" type="file" name="pio-image">
        </div>
        <div>
          <label for="pio2">PIO 2:</label>
          <div class="d-flex">
            <input class="form-control" type="text" name="pio2-first-name" value="<?php if (array_key_exists("PIO2", $officers)) { echo $officers['PIO2'][0];} ?>" required>
            <input class="form-control" type="text" name="pio2-last-name" value="<?php if (array_key_exists("PIO2", $officers)) { echo $officers['PIO2'][1];} ?>" required>
            <input class="form-control" type="file" name="pio2-image">
          </div>
          <div>
            <label for="project-manager">Project Manager:</label>
            <div class="d-flex">
              <input class="form-control" type="text" name="project-manager1-first-name" value="<?php if (array_key_exists("Project Manager1", $officers)) { echo $officers['Project Manager1'][0];} ?>" required>
              <input class="form-control" type="text" name="project-manager1-last-name" value="<?php if (array_key_exists("Project Manager1", $officers)) { echo $officers['Project Manager1'][1];} ?>" required>
              <input class="form-control" type="file" name="project-manager-image">
            </div>
          </div>
          <div>
            <label for="project-manager2">Project Manager 2:</label>
            <div class="d-flex">
              <input class="form-control" type="text" name="project-manager2-first-name" value="<?php if (array_key_exists("Project Manager2", $officers)) { echo $officers['Project Manager2'][0];} ?>" required>
              <input class="form-control" type="text" name="project-manager2-last-name" value="<?php if (array_key_exists("Project Manager2", $officers)) { echo $officers['Project Manager2'][1];} ?>" required>
              <input class="form-control" type="file" name="project-manager2-image">
            </div>
          </div>
          <div>
            <label for="sargeant-at-arms">Sargeant at Arms:</label>
            <div class="d-flex">
              <input class="form-control" type="text" name="sargeant-at-arms1-first-name" value="<?php if (array_key_exists("Sargeant at Arms1", $officers)) { echo $officers['Sargeant at Arms1'][0];} ?>" required>
              <input class="form-control" type="text" name="sargeant-at-arms1-last-name" value="<?php if (array_key_exists("Sargeant at Arms1", $officers)) { echo $officers['Sargeant at Arms1'][0];} ?>" required>
              <input class="form-control" type="file" name="sargeant-at-arms-image">
            </div>
          </div>
          <div>
            <label for="sargeant-at-arms2">Sargeant at Arms 2:</label>
            <div class="d-flex">
              <input class="form-control" type="text" name="sargeant-at-arms2-first-name" value="<?php if (array_key_exists("Sargeant at Arms2", $officers)) { echo $officers['Sargeant at Arms2'][0];} ?>" required>
              <input class="form-control" type="text" name="sargeant-at-arms2-last-name" value="<?php if (array_key_exists("Sargeant at Arms2", $officers)) { echo $officers['Sargeant at Arms2'][1];} ?>" required>
              <input class="form-control" type="file" name="sargeant-at-arms2-image">
            </div>
          </div>
          <div>
            <label for="muse">Muse:</label>
            <div class="d-flex">
              <input class="form-control" type="text" name="muse-first-name" value="<?php if (array_key_exists("Muse", $officers)) { echo $officers['Muse'][0];} ?>" required>
              <input class="form-control" type="text" name="muse-last-name" value="<?php if (array_key_exists("Muse", $officers)) { echo $officers['Muse'][1];} ?>" required>
              <input class="form-control" type="file" name="muse-image">
            </div>
          </div>
          <div>
            <label for="escort">Escort:</label>
            <div class="d-flex">
              <input class="form-control" type="text" name="escort-first-name" value="<?php if (array_key_exists("Escort", $officers)) { echo $officers['Escort'][0];} ?>" required>
              <input class="form-control" type="text" name="escort-last-name" value="<?php if (array_key_exists("Escort", $officers)) { echo $officers['Escort'][1];} ?>" required>
              <input class="form-control" type="file" name="escort-image">
            </div>
          </div>

          <div class="text-center">
            <input class="btn btn-success" type="submit" value="Edit" name="edit">
            <a class="btn btn-danger mt-1" href="admin-student-organization.php?activeStudentOrg=<?php User::printGet('studentOrg'); ?>">Cancel</a>
          </div>
    </form>


  </div>
</body>

</html>