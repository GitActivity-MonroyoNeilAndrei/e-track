<?php
include '../classes/database.php';
include '../classes/message.php';
include '../classes/user.php';
session_start();

$admin = new database();


User::ifNotLogin('admin-username', '../login-account/login-admin.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id' => $admin_id]), '../logout.php?logout=admin');

if (!isset($_GET['activeStudentOrg'])) {
  $result = $admin->selectDistinct('student_org', 'name_of_org');

  $row = mysqli_fetch_assoc($result);
  header("location: admin-list-of-plan-of-activities.php?activeStudentOrg=$row[name_of_org]");
}

$school_year2;

if(isset($_POST['submit'])) {
  $school_year = $_POST['school-year'];

  $school_year2 = $school_year;
} else {
  $result = $admin->selectDistinct('plan_of_activities', 'school_year');
  $row = mysqli_fetch_assoc($result);

  $school_year2 = $row['school_year'];
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
          <a href="#"><i class="fa-solid fa-address-card"></i> My Profile</a>
          <a href="../logout.php?logout=admin"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav style="position: sticky; top: 4vh;">
          <ul>
            <li onclick="window.location.href='admin-homepage.php'">Dashboard</li>
            <li onclick="window.location.href='admin-list-of-users.php'" class="mb-4 border-bottom border-dark">List of Users</li>
            <li onclick="window.location.href='admin-election.php'">Election</li>
            <li onclick="window.location.href='admin-monitor-election-result.php'" class="mb-4 border-bottom border-dark">Monitor Election Result </li>
            <li onclick="window.location.href='admin-student-organization.php'" class="mb-4 border-bottom border-dark">Student Organization</li>
            <li onclick="window.location.href='admin-plan-of-activities.php'">Plan of Activities</li>
            <li onclick="window.location.href='admin-list-of-plan-of-activities.php'" class="bg-dark-gray2">List of Plan of Activities</li>
            <li onclick="window.location.href='admin-monitor-plan-of-activities.php'" class="mb-4 border-bottom border-dark">Monitor Plan of Activities</li>
            <li onclick="window.location.href='admin-accomplishment-report.php'">Accomplishment Report</li>
            <li onclick="window.location.href='admin-list-of-accomplishment-report.php'" class="mb-4 border-bottom border-dark">List of Accomplishment Report</li>
            <li onclick="window.location.href='admin-evaluation-of-activities.php'">Evaluation of Activities</li>
            <li onclick="window.location.href='admin-report-to-ovpsas.php'">Report to OVPSAS</li>
          </ul>
        </nav>
      </div>
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


          <div class="table-responsive">
            <table class="table table-striped">
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
                  $plan_of_activity = $admin->select('plan_of_activities', '*', ['name_of_org'=>User::returnValueGet('activeStudentOrg'), 'status'=>'ongoing', 'school_year'=>$school_year2]);

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

  <script defer>
    let activeLink = document.getElementById("<?php User::printGet('activeStudentOrg') ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";
  </script>

</body>

</html>