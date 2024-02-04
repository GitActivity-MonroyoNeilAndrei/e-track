<?php
include '../classes/database.php';
include '../classes/message.php';
include '../classes/user.php';
session_start();

$student_org = new database();

User::ifNotLogin('name_of_org', '../login-account/login-user.php');

$student_org_id = User::returnValueSession('student-org-id');

User::ifDeactivatedReturnTo($student_org->select('student_org', 'status', ['id'=>$student_org_id]), '../logout.php?logout=student-org');


$school_year2 = User::returnValueGet('schoolYear');


if(isset($_POST['submit'])) {
  $school_year = $_POST['school-year'];
  if($activeStudentOrg == ""){
    $activeStudentOrg = User::returnValueSession('name_of_org');
    header("location: student-org-list-of-plan-of-activities.php?activeStudentOrg=$activeStudentOrg&schoolYear=$school_year");
  } else {
    header("location: student-org-list-of-plan-of-activities.php?activeStudentOrg=$activeStudentOrg&schoolYear=$school_year");
  }

} else {
  if(!isset($_GET['schoolYear'])) {
    $result = $student_org->selectDistinct('plan_of_activities', 'school_year');
    $row = mysqli_fetch_assoc($result);

    $school_year = $row['school_year'];
    if($activeStudentOrg == "") {
      $activeStudentOrg = User::returnValueSession('name_of_org');
      header("location: student-org-list-of-plan-of-activities.php?activeStudentOrg=$activeStudentOrg&schoolYear=$school_year");
    } else {
      header("location: student-org-list-of-plan-of-activities.php?activeStudentOrg=$activeStudentOrg&schoolYear=$school_year");

    }

  }
}

if(isset($_POST['search_submit'])) {
  $search = mysqli_escape_string($student_org->mysqli, $_POST['search']);

  $activeStudentOrg = User::returnValueGet('activeStudentOrg');
  $school_year1 = User::returnValueGet('schoolYear');

  header("location: student-org-list-of-plan-of-activities.php?activeStudentOrg=$activeStudentOrg&schoolYear=$school_year1&search=$search");


}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Org List of Activities</title>
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
        <button class="dropbtn"><i class="fa-solid fa-user"></i> <?php User::printSession('name_of_org'); ?></button>
        <div class="dropdown-content">
          <a href="student-org-edit-profile.php"><i class="fa-solid fa-address-card"></i> My Profile</a>
          <a href="../logout.php?logout=studentOrg"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <?php
        require 'student-org-navigations.php';
       ?>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>List of Plan of Activities</h5>
          </div>

          <form method="post" class="mx-auto text-center" style="max-width: 10rem;">
            <select class="form-select" name="school-year">
              <?php 
                $school_year = $student_org->selectDistinct('plan_of_activities', 'school_year', ['name_of_org'=>User::returnValueSession('name_of_org')]);

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
                  <th>Activity Code</th>
                  <th>Name of Activity</th>
                  <th>Date</th>
                  <th>Venue</th>
                  <th>Sponsor's/Collaborators</th>
                  <th>Nature of Activity</th>
                  <th>Purpose</th>
                  <th>Beneficiaries</th>
                  <th>Target Output</th>
                  <th>Budget</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $school_year2 = User::returnValueGet('schoolYear');

                  if(!isset($_GET['search'])) {
                    $plan_of_activity = $student_org->select('plan_of_activities', '*', ['name_of_org'=>User::returnValueSession('name_of_org'), 'status'=>'ongoing', 'status'=>'accomplished', 'status'=>'accomplished', 'school_year'=>$school_year2]);
                  } else if (isset($_GET['search'])) {
                    if($_GET['search'] == "") {
                      $plan_of_activity = $student_org->select('plan_of_activities', '*', ['name_of_org'=>User::returnValueSession('name_of_org'), 'status'=>'ongoing', 'status'=>'accomplished', 'status'=>'accomplished', 'school_year'=>$school_year2]);
                    }
                  }

                  if (isset($_GET['search'])) {
                    if($_GET != '') {
                      $name_of_org = User::returnValueSession('name_of_org');
                      $search = User::returnValueGet('search');

                      

                      $plan_of_activity = $student_org->modifiedSearch('plan_of_activities', "name_of_org = '$name_of_org' AND status = 'ongoing' OR status = 'accomplished' AND school_year = '$school_year2'", "name_of_activity", $search);
                    }
                  }
                    

                  while ($row = mysqli_fetch_assoc($plan_of_activity)) {

                ?>
                <tr>
                  <td><?php echo $row['activity_code']; ?></td>
                  <td><?php echo $row['name_of_activity']; ?></td>
                  <td><?php echo $row['date']; ?></td>
                  <td><?php echo $row['venue']; ?></td>
                  <td><?php echo $row['sponsors']; ?></td>
                  <td><?php echo $row['nature_of_activity']; ?></td>
                  <td><?php echo $row['purpose']; ?></td>
                  <td><?php echo $row['beneficiaries']; ?></td>
                  <td><?php echo $row['target_output']; ?></td>
                  <td><?php echo $row['budget']; ?></td>

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
    require 'student-org-footer.php';
  ?>

  <script defer>


    var activeNav = document.getElementById('list-of-plan-of-activity')
    activeNav.classList.add('bg-dark-gray2');
  
  </script>

</body>

</html>