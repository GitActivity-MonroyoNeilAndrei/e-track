<?php
include '../classes/database.php';
include '../classes/message.php';
include '../classes/user.php';

header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");

session_start();

$admin = new database();


$admin_id = User::returnValueSession('admin-id');

$activeStudentOrg = User::returnValueGet('activeStudentOrg');

if (isset($_POST['edit-questionnaire'])) {

  $questionnaire = mysqli_escape_string($admin->mysqli, $_POST['questionnaire']);

  $admin->updateData('evaluation_of_activities', ['questionnaire'=>$questionnaire], ['id'=>User::returnValueGet('id')]);

  header("location: admin-evaluation-of-activities.php?activeStudentOrg=$activeStudentOrg&edited");

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
  <link rel="stylesheet" href="../css/admin.css?<?php echo time(); ?>">
  <script src="https://kit.fontawesome.com/ba2dc1cde9.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="body">
    <div class="header bg-green-1">
      <div class="d-flex align-items-center"><img class="header-logo" src="../images/msc_logo.png" alt="msc logo">
        <h3 class=" header-texts">MARINDUQUE STATE COLLEGE</h3>
      </div>
      <div class="dropdown">
        <button class="dropbtn"><i class="fa-solid fa-user"></i> <?php User::printSession('admin-username'); ?></button>
        <div class="dropdown-content">
          <a href="admin-edit-profile.php"><i class="fa-solid fa-address-card"></i> My Profile</a>
          <a href="../logout.php?logout=admin"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <?php
        require 'admin-navigations.php';
       ?>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Evaluation of Activities</h5>
          </div>


          <?php

            $questionnaire = $admin->select('evaluation_of_activities', '*', ['id'=>User::returnValueGet('id')]);

            while($row = mysqli_fetch_assoc($questionnaire)) {
          ?>
          <form method="post" class="d-flex flex-column align-items-center mx-auto mb-4 border shadow rounded-3" style="max-width: 30rem;">
              <label class="form-label fw-bold" for="">Edit Questionnaire</label>
              <textarea class="form-control mb-3" name="questionnaire" rows="3" required><?php echo $row['questionnaire']; ?></textarea>

              <div>
                <input class="btn btn-primary" type="submit" name="edit-questionnaire" value="Edit">
                <a class="btn btn-danger" href="admin-evaluation-of-activities.php?activeStudentOrg=<?php User::printGet('activeStudentOrg'); ?>">Cancel</a>
              </div>

          </form>
          <?php } ?>

        </div>
      </div>
    </div>

  </div>

  <?php
    require 'admin-footer.php';
  ?>

<script defer>
    let activeLink = document.getElementById("<?php User::printGet('activeStudentOrg') ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";


    var activeNav = document.getElementById('evaluation-of-activities')
    activeNav.classList.add('bg-dark-gray2');



  </script>
</body>

</html>