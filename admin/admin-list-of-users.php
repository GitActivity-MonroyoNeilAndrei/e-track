<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');


session_start();

$admin = new database();

User::ifNotLogin('admin-username', '../login-account/login-admin.php');

if(!isset($_GET['user'])){
  header('location: admin-list-of-users.php?user=admin');
}


if (!isset($_GET['activeStudentOrg'])) {
  $result = $admin->selectDistinct('student_org', 'name_of_org');

  $row = mysqli_fetch_assoc($result);
  // header("location: admin-monitor-election-result.php?activeStudentOrg=$row[name_of_org]");
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
          <a href="#">My Profile</a>
          <a href="../logout.php?logout=admin">Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav style="position: sticky; top: 4vh;">
          <ul>
            <li onclick="window.location.href='admin-homepage.php'">Dashboard</li>
            <li onclick="window.location.href='admin-list-of-users.php'" class="mb-4 border-bottom border-dark bg-dark-gray2">List of Users</li>
            <li onclick="window.location.href='admin-election.php'">Election</li>
            <li onclick="window.location.href='admin-monitor-election-result.php'" class="mb-4 border-bottom border-dark">Monitor Election Result </li>
            <li onclick="window.location.href='admin-student-organization.php'">Student Organization</li>
            <li onclick="window.location.href='admin-plan-of-activities.php'">Plan of Activities</li>
            <li onclick="window.location.href='admin-monitor-plan-of-activities.php'">Monitor Plan of Activities</li>
            <li onclick="window.location.href='admin-accomplishment-report.php'" class="mb-4 border-bottom border-dark">Accomplishment Report</li>
            <li onclick="window.location.href='admin-evaluation-of-activities.php'">Evaluation of Activities</li>
            <li onclick="window.location.href='admin-report-to-ovpsas.php'">Report to OVPSAS</li>
          </ul> 
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Monitor Election</h5>
          </div>
          <nav class="org-list-nav">
            <ul>
              <li id="admin" onclick="window.location.href='admin-list-of-users.php?user=admin'">Admin</li>
              <li id="student_org" onclick="window.location.href='admin-list-of-users.php?user=student_org'">Student Org.</li>
              <li id="student" onclick="window.location.href='admin-list-of-users.php?user=student'">Students</li>
            </ul>
          </nav>

          <a class="btn btn-primary <?php if(User::returnValueGet('user') != 'admin') {echo 'd-none';} ?>" href="admin-add-user.php?user=<?php echo 'admin'; ?>"><i class="fa-solid fa-plus"></i> Add Admin</a>
          <a class="btn btn-primary <?php if(User::returnValueGet('user') != 'student') {echo 'd-none';} ?>" href="admin-add-user.php?user=<?php echo 'student'; ?>"><i class="fa-solid fa-plus"></i> Add Student</a>
          <a class="btn btn-primary <?php if(User::returnValueGet('user') != 'student_org') {echo 'd-none';} ?>" href="admin-add-user.php?user=<?php echo 'student_org'; ?>"><i class="fa-solid fa-plus"></i> Add Student Org.</a>

          <div class="table-responsive">
            <table class="table">
              <thead>
                  
                <tr class="<?php if(User::returnValueGet('user') != 'admin') {echo 'd-none';} ?>">
                  <th>Username</th>
                  <th>Full Name</th>
                  <th>Address</th>
                  <th>Contact Number</th>
                  <th>Email</th>
                  <th>status</th>
                  <th>Action</th>
                </tr>

                <tr class="<?php if(User::returnValueGet('user') != 'student') {echo 'd-none';} ?>">
                  <th>Username</th>
                  <th>Full Name</th>
                  <th>Address</th>
                  <th>Student ID</th>
                  <th>Course</th>
                  <th>Year</th>
                  <th>Contact Number</th>
                  <th>Email</th>
                  <th>status</th>
                  <th>Action</th>
                </tr>

                <tr class="<?php if(User::returnValueGet('user') != 'student_org') {echo 'd-none';} ?>">
                  <th>Name of Org</th>
                  <th>College Of</th>
                  <th>Adviser</th>
                  <th>Contact Number</th>
                  <th>Email</th>
                  <th>status</th>
                  <th>Action</th>
                </tr>

              </thead>
              <tbody>
                <tbody>

                <?php 

                  $user = User::returnValueGet('user');
                  $result = $admin->select($user, '*');



                  while($row = mysqli_fetch_assoc($result)) {

                ?>

                  <tr class="<?php if (User::returnValueGet('user') != 'admin') { echo 'd-none' ;}  ?>">
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['first_name'] .' '.  $row['last_name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['contact_no']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['status'] ?></td>
                    <td>
                      <a class="btn btn-success mb-3" href="admin-edit-users.php?id=<?php echo $row['id']; ?>&user=<?php User::printGet('user'); ?>"><i class="fa-regular fa-pen-to-square"></i> Edit</a>
                      <a class="btn btn-secondary mb-3 <?php if($row['status'] == 'activated') {echo 'd-none';} ?>" href="change-user-status.php?id=<?php echo $row['id'] ?>&user=<?php echo User::returnValueGet('user'); ?> &status=<?php echo 'activated'; ?>"><i class="fa-solid fa-user"></i> Activate</a>
                      <a class="btn btn-danger mb-3 <?php if($row['status'] == 'deactivated') {echo 'd-none';} ?>" href="change-user-status.php?id=<?php echo $row['id'] ?>&user=<?php echo User::returnValueGet('user'); ?> &status=<?php echo 'deactivated'; ?>"><i class="fa-solid fa-user-slash"></i> Deactivate</a>
                    </td>
                  </tr>

                  <tr class="<?php if (User::returnValueGet('user') != 'student') { echo 'd-none' ;}  ?>">
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['first_name'] .' '.  $row['last_name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['student_id']; ?></td>
                    <td><?php echo $row['course']; ?></td>
                    <td><?php echo $row['year_and_section']; ?></td>
                    <td><?php echo $row['contact_no']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['status'] ?></td>
                    <td>
                      <a class="btn btn-success mb-3" href="admin-edit-users.php?id=<?php echo $row['id']; ?>&user=<?php User::printGet('user'); ?>"><i class="fa-regular fa-pen-to-square"></i> Edit</a>
                      <a class="btn btn-secondary mb-3 <?php if($row['status'] == 'activated') {echo 'd-none';} ?>" href="change-user-status.php?id=<?php echo $row['id'] ?>&user=<?php echo User::returnValueGet('user'); ?> &status=<?php echo 'activated'; ?>"><i class="fa-solid fa-user"></i> Activate</a>
                      <a class="btn btn-danger mb-3 <?php if($row['status'] == 'deactivated') {echo 'd-none';} ?>" href="change-user-status.php?id=<?php echo $row['id'] ?>&user=<?php echo User::returnValueGet('user'); ?> &status=<?php echo 'deactivated'; ?>"><i class="fa-solid fa-user-slash"></i> Deactivate</a>
                    </td>
                  </tr>

                  <tr class="<?php if (User::returnValueGet('user') != 'student_org') { echo 'd-none' ;}  ?>">
                    <td><?php echo $row['name_of_org']; ?></td>
                    <td><?php echo $row['college_of']; ?></td>
                    <td><?php echo $row['adviser']; ?></td>
                    <td><?php echo $row['contact_no']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['status'] ?></td>
                    <td>
                      <a class="btn btn-success mb-3" href="admin-edit-users.php?id=<?php echo $row['id']; ?>&user=<?php User::printGet('user'); ?>"><i class="fa-regular fa-pen-to-square"></i> Edit</a>
                      <a class="btn btn-secondary mb-3 <?php if($row['status'] == 'activated') {echo 'd-none';} ?>" href="change-user-status.php?id=<?php echo $row['id'] ?>&user=<?php echo User::returnValueGet('user'); ?> &status=<?php echo 'activated'; ?>"><i class="fa-solid fa-user"></i> Activate</a>
                      <a class="btn btn-danger mb-3 <?php if($row['status'] == 'deactivated') {echo 'd-none';} ?>" href="change-user-status.php?id=<?php echo $row['id'] ?>&user=<?php echo User::returnValueGet('user'); ?> &status=<?php echo 'deactivated'; ?>"><i class="fa-solid fa-user-slash"></i> Deactivate</a>
                    </td>
                  </tr>

                <?php } ?>

                </tbody>
              </tbody>
            </table>
          </div> <!-- div responsive table -->

        </div>
      </div>
    </div>

  </div>

  <script defer>
    let activeLink = document.getElementById("<?php User::printGet('user'); ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";
  </script>
</body>

</html>