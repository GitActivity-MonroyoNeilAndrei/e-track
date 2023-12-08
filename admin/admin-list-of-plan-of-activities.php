<?php
include '../classes/database.php';
include '../classes/message.php';
include '../classes/user.php';
session_start();

$admin = new database();


User::ifNotLogin('admin-username', '../login-account/login-user.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id' => $admin_id]), '../logout.php?logout=admin');

$activeStudentOrg = "";

if (!isset($_GET['activeStudentOrg'])) {
  $result = $admin->selectDistinct('student_org', 'name_of_org');

  $row = mysqli_fetch_assoc($result);
  $activeStudentOrg = $row['name_of_org'];

  header("location: admin-list-of-plan-of-activities.php?activeStudentOrg=$row[name_of_org]");
}

$school_year2 = User::returnValueGet('schoolYear');


if(isset($_POST['submit'])) {
  $school_year = $_POST['school-year'];
  if($activeStudentOrg == ""){
    $activeStudentOrg = User::returnValueGet('activeStudentOrg');
    header("location: admin-list-of-plan-of-activities.php?activeStudentOrg=$activeStudentOrg&schoolYear=$school_year");
  } else {
    header("location: admin-list-of-plan-of-activities.php?activeStudentOrg=$activeStudentOrg&schoolYear=$school_year");
  }

} else {
  if(!isset($_GET['schoolYear'])) {
    $result = $admin->selectDistinct('plan_of_activities', 'school_year');
    $row = mysqli_fetch_assoc($result);

    $school_year = $row['school_year'];
    if($activeStudentOrg == "") {
      $activeStudentOrg = User::returnValueGet('activeStudentOrg');
      header("location: admin-list-of-plan-of-activities.php?activeStudentOrg=$activeStudentOrg&schoolYear=$school_year");
    } else {
      header("location: admin-list-of-plan-of-activities.php?activeStudentOrg=$activeStudentOrg&schoolYear=$school_year");

    }

  }
}

if(isset($_POST['search_submit'])) {
  $search = mysqli_escape_string($admin->mysqli, $_POST['search']);

  $activeStudentOrg = User::returnValueGet('activeStudentOrg');
  $school_year1 = User::returnValueGet('schoolYear');

  header("location: admin-list-of-plan-of-activities.php?activeStudentOrg=$activeStudentOrg&schoolYear=$school_year1&search=$search");


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
            <h5>List of Plan of Activities</h5>
          </div>

          <nav class="org-list-nav">
            <ul>
              <?php
              $result = $admin->selectDistinct('student_org', 'name_of_org');
              while ($row = mysqli_fetch_assoc($result)) {
              ?>

                <li id="<?php echo $row['name_of_org']; ?>" onclick="window.location.href = 'admin-list-of-plan-of-activities.php?activeStudentOrg=<?php echo $row['name_of_org'] ?>';"><?php echo $row['name_of_org']; ?></li>

              <?php } ?>
            </ul>
          </nav>
          <form method="post" class="mx-auto text-center" style="max-width: 10rem;">
            <select class="form-select" name="school-year">
              <?php 
                $school_year = $admin->selectDistinct('plan_of_activities', 'school_year', ['name_of_org'=>User::returnValueGet('activeStudentOrg')]);

                while ($row = mysqli_fetch_assoc($school_year)) {
              ?>

              <option value="<?php echo $row['school_year'] ?>" <?php if($school_year2 == $row['school_year']) {echo 'selected';} ?>><?php echo $row['school_year'] ?></option>

              <?php } ?>
            </select>
            <input class="btn btn-primary mt-2" type="submit" name="submit" value="Select">
          </form>

          <form method="post" class="d-flex mx-auto mt-3" role="search" style="max-width: 20rem;">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
            <button class="btn btn-outline-success" name="search_submit" type="submit">Search</button>
          </form>


          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Name of Activity</th>
                  <th>Date</th>
                  <th>Venue</th>
                  <th>Sponsor's/Collaborators</th>
                  <th>Nature of Activity</th>
                  <th>Purpose</th>
                  <th>Beneficiaries</th>
                  <th>Target Output</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $school_year2 = User::returnValueGet('schoolYear');

                  if(!isset($_GET['search'])) {
                    $plan_of_activity = $admin->select('plan_of_activities', '*', ['name_of_org'=>User::returnValueGet('activeStudentOrg'), 'status'=>'ongoing', 'school_year'=>$school_year2]);
                  } else if (isset($_GET['search'])) {
                    if($_GET['search'] == "") {
                      $plan_of_activity = $admin->select('plan_of_activities', '*', ['name_of_org'=>User::returnValueGet('activeStudentOrg'), 'status'=>'ongoing', 'school_year'=>$school_year2]);
                    }
                  }

                  if (isset($_GET['search'])) {
                    if($_GET != '') {
                      $name_of_org = User::returnValueGet('activeStudentOrg');
                      $search = User::returnValueGet('search');

                      

                      $plan_of_activity = $admin->modifiedSearch('plan_of_activities', "name_of_org = '$name_of_org' AND status = 'ongoing' AND school_year = '$school_year2'", "name_of_activity", $search);
                    }
                  }
                    

                  while ($row = mysqli_fetch_assoc($plan_of_activity)) {

                ?>
                <tr>
                  <td><?php echo $row['name_of_activity']; ?></td>
                  <td><?php echo $row['date']; ?></td>
                  <td><?php echo $row['venue']; ?></td>
                  <td><?php echo $row['sponsors']; ?></td>
                  <td><?php echo $row['nature_of_activity']; ?></td>
                  <td><?php echo $row['purpose']; ?></td>
                  <td><?php echo $row['beneficiaries']; ?></td>
                  <td><?php echo $row['target_output']; ?></td>

                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          



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


    var activeNav = document.getElementById('list-of-plan-of-activities')
    activeNav.classList.add('bg-dark-gray2');
  
  </script>

</body>

</html>