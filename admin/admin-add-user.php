<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');


session_start();

$admin = new database();

User::ifNotLogin('admin-username', '../login-account/login-admin.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id'=>$admin_id]), '../logout.php?logout=admin');

if (isset($_POST['submit'])) {
  if(User::returnValueGet('user') == 'admin') {
    $username = $_POST['username'];
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $address = $_POST['address'];
    $contact_no = $_POST['contact-no'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $confirm_password = md5($_POST['confirm-password']);

    if($password != $confirm_password) {
      $error_password = "Password doesn't Match";
    } else {
      $admin->insertData('admin', ['username'=>$username, 'first_name'=>$first_name, 'last_name'=>$last_name, 'address'=>$address, 'contact_no'=>$contact_no, 'email'=>$email, 'password'=>$password]);

      header('location: admin-list-of-users.php?user=admin');
    }




  }else if (User::returnValueGet('user') == 'student') {
    $username = $_POST['username'];
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $address = $_POST['address'];
    $student_id = $_POST['student-id'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $contact_no = $_POST['contact-no'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $confirm_password = md5($_POST['confirm-password']);

    if($password != $confirm_password) {
      $error_password = "Password doesn't Match";
    } else {
      $admin->insertData('student', ['username'=>$username, 'first_name'=>$first_name, 'last_name'=>$last_name, 'address'=>$address, 'student_id'=>$student_id, 'course'=>$course, 'year_and_section'=>$year, 'contact_no'=>$contact_no, 'email'=>$email, 'password'=>$password]);

      header('location: admin-list-of-users.php?user=student');
    }




  }else if (User::returnValueGet('user') == 'student_org') {
    $name_of_org = $_POST['name-of-org'];
    $college_of = $_POST['college-of'];
    $adviser = $_POST['adviser'];
    $contact_no = $_POST['contact-no'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $confirm_password = md5($_POST['confirm-password']);

    if($password != $confirm_password) {
      $error_password = "Password doesn't Match";
    } else {
      $admin->insertData('student_org', ['name_of_org'=>$name_of_org, 'college_of'=>$college_of, 'adviser'=>$adviser, 'contact_no'=>$contact_no, 'email'=>$email, 'password'=>$password]);

      header('location: admin-list-of-users.php?user=student_org');
    }




  }
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

  <style>
    form {
      background-color: #FAF9F6;
    }
  </style>
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
            <li onclick="window.location.href='admin-student-organization.php'" class="mb-4 border-bottom border-dark">Student Organization</li>
            <li onclick="window.location.href='admin-plan-of-activities.php'">Plan of Activities</li>
            <li onclick="window.location.href='admin-list-of-plan-of-activities.php'">List of Plan of Activities</li>
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
            <h5>List of Users > Edit User</h5>
          </div>
          <form method="post" class="d-flex justify-content-center flex-column mx-auto shadow rounded-2 mt-3 mb-3 <?php if(User::returnValueGet('user') != 'admin') {echo 'd-none';} ?>" style="max-width: 17rem; padding: 1rem 1rem 0;">
          <h4 class="text-center">Add Admin</h4>
            <?php
              if(isset($error_password)) {
                echo "
                  <div class='alert alert-danger' role='alert'>
                    $error_password
                  </div>
                ";
              }
            ?>
            <label class="form-label" for="username">Username:</label>
            <input class="form-control" type="text" name="username" required>
            <label class="form-label" for="first-name">First Name:</label>
            <input class="form-control" type="text" name="first-name" required>
            <label class="form-label" for="last-name">Last Name:</label>
            <input class="form-control" type="text" name="last-name" required>
            <label class="form-label" for="address">Address:</label>
            <input class="form-control" type="text" name="address" required>
            <label class="form-label" for="contact-no">Contact No.:</label>
            <input class="form-control" type="number" name="contact-no" required>
            <label class="form-label" for="email">Email:</label>
            <input class="form-control" type="email" name="email" required>
            <label class="form-label" for="password">Password: </label>
            <input class="form-control" type="password" name="password" required>
            <label class="form-label" for="confirm-password">Confirm Password: </label>
            <input class="form-control" type="password" name="confirm-password" required>
            <div class="text-center">
              <input class="btn btn-primary mx-auto mt-3 mb-3" type="submit" name="submit" value="Add">
              <a class="btn btn-danger" href="admin-list-of-users.php?user=<?php User::printGet('user'); ?>">Cancel</a>
            </div>
            
          </form>

          <form method="post" class="d-flex justify-content-center flex-column mx-auto shadow rounded-2 mt-3 mb-3 <?php if(User::returnValueGet('user') != 'student') {echo 'd-none';} ?>" style="max-width: 17rem; padding: 1rem 1rem 0;">
          <h4 class="text-center">Add Student</h4>
            <?php
              if(isset($error_password)) {
                echo "
                <div class='alert alert-danger' role='alert'>
                  $error_password
                </div>
                ";
              }
            ?>
            <label class="form-label" for="username">Username:</label>
            <input class="form-control" type="text" name="username" required>
            <label class="form-label" for="first-name">First Name:</label>
            <input class="form-control" type="text" name="first-name" required>
            <label class="form-label" for="last-name">Last Name:</label>
            <input class="form-control" type="text" name="last-name" required>
            <label class="form-label" for="address">Address:</label>
            <input class="form-control" type="text" name="address" required>
            <label class="form-label" for="student-id">Student ID:</label>
            <input class="form-control" type="text" name="student-id" required>
            <div style="width: 100%;">
              <label for="course">Course:</label>
              <select class="form-select" name="course"> 
                <?php 
                  $course = $admin->select('courses', '*');

                  while ($row = mysqli_fetch_assoc($course)) {
                ?>

                <option value="<?php echo $row['course']; ?>"><?php echo $row['course']; ?></option>

              <?php } ?>
              </select>
              <!-- <input class="form-control" type="text" name="course" required> -->
            </div>
            <label class="form-label" for="year">Year and Section:</label>
            <input class="form-control" type="text" name="year" required>
            <label class="form-label" for="contact-no">Contact No.:</label>
            <input class="form-control" type="number" name="contact-no" required>
            <label class="form-label" for="email">Email:</label>
            <input class="form-control" type="email" name="email" required>
            <label class="form-label" for="password">Password: </label>
            <input class="form-control" type="password" name="password" required>
            <label class="form-label" for="confirm-password">Confirm Password: </label>
            <input class="form-control" type="password" name="confirm-password" required>
            <div class="text-center">
              <input class="btn btn-primary mx-auto mt-3 mb-3" type="submit" name="submit" value="Add">
              <a class="btn btn-danger" href="admin-list-of-users.php?user=<?php User::printGet('user'); ?>">Cancel</a>
            </div>
            
          </form>

          <form method="post" class="d-flex justify-content-center flex-column mx-auto shadow rounded-2 mt-3 mb-3 <?php if(User::returnValueGet('user') != 'student_org') {echo 'd-none';} ?>" style="max-width: 17rem; padding: 1rem 1rem 0;">
          <h4 class="text-center">Add Student Org.</h4>
            <?php
              if(isset($error_password)) {
                echo "
                <div class='alert alert-danger' role='alert'>
                  $error_password
                </div>
                ";
              }
            ?>
            <label class="form-label" for="name-of-org">Name of Org:</label>
            <input class="form-control" type="text" name="name-of-org" required>
            <label class="form-label" for="college-of">College of:</label>
            <input class="form-control" type="text" name="college-of" required>
            <label class="form-label" for="adviser">Adviser:</label>
            <input class="form-control" type="text" name="adviser" required>
            <label class="form-label" for="contact-no">Contact No.:</label>
            <input class="form-control" type="number" name="contact-no" required>
            <label class="form-label" for="email">Email:</label>
            <input class="form-control" type="email" name="email" required>
            <label class="form-label" for="password">Password: </label>
            <input class="form-control" type="password" name="password" required>
            <label class="form-label" for="confirm-password">Confirm Password: </label>
            <input class="form-control" type="password" name="confirm-password" required>
            <div class="text-center">
              <input class="btn btn-primary mx-auto mt-3 mb-3" type="submit" name="submit" value="Add">
              <a class="btn btn-danger" href="admin-list-of-users.php?user=<?php User::printGet('user'); ?>">Cancel</a>
            </div>
            
          </form>


        </div>
      </div>
    </div>

  </div>
</body>

</html>