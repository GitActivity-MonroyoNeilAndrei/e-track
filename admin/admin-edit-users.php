<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');


session_start();

$admin = new database();

User::ifNotLogin('admin-username', '../login-account/login-user.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id'=>$admin_id]), '../logout.php?logout=admin');

$username = '';
$first_name = '';
$last_name = '';
$address = '';
$contact_no = '';
$email = '';
$student_id = '';
$course = '';
$year = '';
$name_of_org = '';
$college_of = '';
$adviser = '';


if($_SERVER['REQUEST_METHOD'] == 'GET') {
  if(User::returnValueGet('user') == 'admin') {
    $user = $admin->select('admin', '*', ['id'=>User::returnValueGet('id')]);
    $row = mysqli_fetch_assoc($user);

    $username = $row['username'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $address = $row['address'];
    $contact_no = $row['contact_no'];
    $email = $row['email'];

  } else if (User::returnValueGet('user') == 'student') {
    $user = $admin->select('student', '*', ['id'=>User::returnValueGet('id')]);
    $row = mysqli_fetch_assoc($user);

    $username = $row['username'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $address = $row['address'];
    $student_id = $row['student_id'];
    $course = $row['course'];
    $year = $row['year_and_section'];
    $contact_no = $row['contact_no'];
    $email = $row['email'];

  } else if (User::returnValueGet('user') == 'student_org') {
    $user = $admin->select('student_org', '*', ['id'=>User::returnValueGet('id')]);
    $row = mysqli_fetch_assoc($user);

    $name_of_org = $row['name_of_org'];
    $college_of = $row['college_of'];
    $adviser = $row['adviser'];
    $contact_no = $row['contact_no'];
    $email = $row['email'];
  }
 } else if (isset($_POST['submit'])) {
  if(User::returnValueGet('user') == 'admin') {
    $username = $_POST['username'];
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $address = $_POST['address'];
    $contact_no = $_POST['contact-no'];
    $email = $_POST['email'];

    $admin->updateData('admin', ['username'=>$username, 'first_name'=>$first_name, 'last_name'=>$last_name, 'address'=>$address, 'contact_no'=>$contact_no, 'email'=>$email], ['id'=>User::returnValueGet('id')]);

    header('location: admin-list-of-users.php?user=admin');


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

    $admin->updateData('student', ['username'=>$username, 'first_name'=>$first_name, 'last_name'=>$last_name, 'address'=>$address, 'student_id'=>$student_id, 'course'=>$course, 'year_and_section'=>$year, 'contact_no'=>$contact_no, 'email'=>$email], ['id'=>User::returnValueGet('id')]);

    header('location: admin-list-of-users.php?user=student');


  }else if (User::returnValueGet('user') == 'student_org') {
    $name_of_org = $_POST['name-of-org'];
    $college_of = $_POST['college-of'];
    $adviser = $_POST['adviser'];
    $contact_no = $_POST['contact-no'];
    $email = $_POST['email'];

    $admin->updateData('student_org', ['name_of_org'=>$name_of_org, 'college_of'=>$college_of, 'adviser'=>$adviser, 'contact_no'=>$contact_no, 'email'=>$email], ['id'=>User::returnValueGet('id')]);

    header('location: admin-list-of-users.php?user=student_org');


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
          <a href="#"><i class="fa-solid fa-address-card"></i> My Profile</a>
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
            <h5>List of Users > Edit User</h5>
          </div>
          <form method="post" class="d-flex justify-content-center flex-column mx-auto shadow rounded-2 mt-3 mb-3 <?php if(User::returnValueGet('user') != 'admin') {echo 'd-none';} ?>" style="max-width: 17rem; padding: 1rem 1rem 0;">
          <h4 class="text-center">Change Admin Details</h4>
            <label class="form-label" for="username">Username:</label>
            <input class="form-control" type="text" name="username" value="<?php echo $username; ?>" required>
            <label class="form-label" for="first-name">First Name:</label>
            <input class="form-control" type="text" name="first-name" value="<?php echo $first_name; ?>" required>
            <label class="form-label" for="last-name">Last Name:</label>
            <input class="form-control" type="text" name="last-name" value="<?php echo $last_name; ?>" required>
            <label class="form-label" for="address">Address:</label>
            <input class="form-control" type="text" name="address" value="<?php echo $address; ?>" required>
            <label class="form-label" for="contact-no">Contact No.:</label>
            <input class="form-control" type="number" name="contact-no" value="<?php echo $contact_no; ?>" required>
            <label class="form-label" for="email">Email:</label>
            <input class="form-control" type="email" name="email" value="<?php echo $email; ?>" required>
            <input class="btn btn-primary mx-auto mt-3 mb-3" type="submit" name="submit" value="Edit">
          </form>

          <form method="post" class="d-flex justify-content-center flex-column mx-auto shadow rounded-2 mt-3 mb-3 <?php if(User::returnValueGet('user') != 'student') {echo 'd-none';} ?>" style="max-width: 17rem; padding: 1rem 1rem 0;">
          <h4 class="text-center">Change Student Details</h4>
            <label class="form-label" for="username">Username:</label>
            <input class="form-control" type="text" name="username" value="<?php echo $username; ?>" required>
            <label class="form-label" for="first-name">First Name:</label>
            <input class="form-control" type="text" name="first-name" value="<?php echo $first_name; ?>" required>
            <label class="form-label" for="last-name">Last Name:</label>
            <input class="form-control" type="text" name="last-name" value="<?php echo $last_name; ?>" required>
            <label class="form-label" for="address">Address:</label>
            <input class="form-control" type="text" name="address" value="<?php echo $address; ?>" required>
            <label class="form-label" for="student-id">Student ID:</label>
            <input class="form-control" type="text" name="student-id" value="<?php echo $student_id; ?>" required>
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
            <label class="form-label" for="year-and-section">Year and Section:</label>
            <input class="form-control" type="text" name="year" value="<?php echo $year; ?>" required>
            <label class="form-label" for="contact-no">Contact No.:</label>
            <input class="form-control" type="number" name="contact-no" value="<?php echo $contact_no; ?>" required>
            <label class="form-label" for="email">Email:</label>
            <input class="form-control" type="email" name="email" value="<?php echo $email; ?>" required>
            <input class="btn btn-primary mx-auto mt-3 mb-3" type="submit" name="submit" value="Edit">
          </form>

          <form method="post" class="d-flex justify-content-center flex-column mx-auto shadow rounded-2 mt-3 mb-3 <?php if(User::returnValueGet('user') != 'student_org') {echo 'd-none';} ?>" style="max-width: 17rem; padding: 1rem 1rem 0;">
          <h4 class="text-center">Change Student Org. Details</h4>
            <label class="form-label" for="name-of-org">Name of Org:</label>
            <input class="form-control" type="text" name="name-of-org" value="<?php echo $name_of_org; ?>" required>
            <label class="form-label" for="college-of">College of:</label>
            <input class="form-control" type="text" name="college-of" value="<?php echo $college_of; ?>" required>
            <label class="form-label" for="adviser">Adviser:</label>
            <input class="form-control" type="text" name="adviser" value="<?php echo $adviser; ?>" required>
            <label class="form-label" for="contact-no">Contact No.:</label>
            <input class="form-control" type="number" name="contact-no" value="<?php echo $contact_no; ?>" required>
            <label class="form-label" for="email">Email:</label>
            <input class="form-control" type="email" name="email" value="<?php echo $email; ?>" required>
            <input class="btn btn-primary mx-auto mt-3 mb-3" type="submit" name="submit" value="Edit">
          </form>


        </div>
      </div>
    </div>

  </div>
</body>

</html>