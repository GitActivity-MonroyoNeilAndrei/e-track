<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');

$student = new database();

$password;

$result = $student->select('student', '*', ['id'=>User::returnValueSession('id')]);

while ($row = mysqli_fetch_assoc($result)) {
  $password = $row['password'];
}


if (isset($_POST['edit-profile'])) {


  $username = mysqli_escape_string($student->mysqli, $_POST['username']);
  $first_name = mysqli_escape_string($student->mysqli, $_POST['first-name']);
  $last_name = mysqli_escape_string($student->mysqli, $_POST['last-name']);
  $address = mysqli_escape_string($student->mysqli, $_POST['address']);
  $year_and_section = mysqli_escape_string($student->mysqli, $_POST['year-and-section']);
  $contact_no = mysqli_escape_string($student->mysqli, $_POST['contact-no']);
  $email = mysqli_escape_string($student->mysqli, $_POST['email']);


  $student->updateData('student', ['username'=>$username, 'first_name'=>$first_name, 'last_name'=>$last_name, 'address'=>$address, 'year_and_section'=>$year_and_section, 'contact_no'=>$contact_no, 'email'=>$email], ['id'=>User::returnValueSession('id')]);

  header("location: student-edit-profile.php?editSuccessful");
  
}

if  (isset($_POST['edit-password'])) {

  if (isset($_POST['new-password'])) {
    $password1 = $_POST['new-password'];
    $validPassword = User::isValidPassword($password1);
    $user = User::returnValueGet('user');

    if ($validPassword == "") {
      header("location: student-edit-profile.php?invalidPassword");
      exit;
    }
  }

  $old_password = md5($_POST['old-password']);
  $new_password = md5($_POST['new-password']);


  if ($old_password != $password) {
    header("location: student-edit-profile.php?doesntMatch");
  } else if ($old_password == $password) {
    $student->updateData('student', ['password'=>$new_password], ['id'=>User::returnValueSession('id')]);
    
    header("location: student-edit-profile.php?editPasswordSuccessfully");
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
  <link rel="stylesheet" href="../css/student.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/login-create-account.css<?php echo time(); ?>">
  <script src="https://kit.fontawesome.com/ba2dc1cde9.js" crossorigin="anonymous"></script>
  <script src="https://cdn.plot.ly/plotly-2.26.0.min.js" charset="utf-8"></script>
  <style>
    .table-responsive {
      max-width: 35rem;
      margin: auto;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      border-radius: 8px;
    }

    h4 {
      border-radius: 4px;
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
      <button class="dropbtn"><i class="fa-solid fa-user"></i> <?php User::printSession('student_name'); ?></button>
        <div class="dropdown-content">
          <a href="student-edit-profile.php"><i class="fa-solid fa-address-card"></i> My Profile</a>
          <a href="../logout.php?logout=student"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav style="position: sticky; top: 4vh;">
          <ul>

            <li onclick="window.location.href='student-vote.php'">
              <span>Vote</span>
              <span><i class="fa-solid fa-check-to-slot"></i></span>
            </li>
            <li onclick="window.location.href='student-monitor-result.php'">
              <span>Monitor Election Result</span>
              <span><i class="fa-solid fa-square-poll-horizontal"></i></span>
            </li>
            <li onclick="window.location.href='student-monitor-activities.php'">
              <span>Monitor Activities</span>
              <span><i class="fa-regular fa-file"></i></span>
            </li>

          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5 class="text-start">My Profile</h5>
          </div>

            <h4 class="text-center fw-semibold">Edit Profile</h4>

            <form class="d-flex flex-column mx-auto mt-5 p-3 border rounded-3" style="max-width: 35rem; " method="post">


              <?php
              if (isset($_GET['editSuccessful'])) {
                echo '
                <div class="alert alert-success" role="alert">
                  Edit Successfully
                </div>
                ';
              }

                $student = $student->select('student', '*', ['id'=>User::returnValueSession('id')]);

                while ($row = mysqli_fetch_assoc($student)) {
              ?>

              <div class="d-flex flex-row justify-content-between">
                <div>
                  <label class="form-label">Student ID: </label>
                  <input class="form-control" type="text" name="student-id" value="<?php echo $row['student_id']; ?>" disabled>
                  <label class="form-label">UserName: </label>
                  <input class="form-control" type="text" name="username" value="<?php echo $row['username']; ?>" required>
                  <label class="form-label">First Name: </label>
                  <input class="form-control" type="text" name="first-name" value="<?php echo $row['first_name']; ?>" required>
                  <label class="form-label">Last Name</label>
                  <input class="form-control" type="text" name="last-name" value="<?php echo $row['last_name']; ?>" required>
                  <label class="form-label">Address</label>
                  <input class="form-control" type="text" name="address" value="<?php echo $row['address']; ?>" required>
                </div>
                
                <div>
                  <label class="form-label">Course</label>
                  <input class="form-control" type="text" name="course" value="<?php echo $row['course']; ?>" disabled>
                  <label class="form-label">Year and Section:</label>
                  <input class="form-control" type="text" name="year-and-section" value="<?php echo $row['year_and_section']; ?>" required>
                  <label class="form-label">Contact No.:</label>
                  <input class="form-control" type="text" name="contact-no" value="<?php echo $row['contact_no']; ?>" required>
                  <label class="form-label">Email:</label>
                  <input class="form-control" type="text" name="email" value="<?php echo $row['email']; ?>" required>
                </div>
              </div>


              

              <?php } ?>

              <div class="d-flex justify-content-center align-items-center mt-3">
                <input class="btn btn-success me-3" type="submit" name="edit-profile" value="Change" required>
                <a class="btn btn-danger" href="student-vote.php">Cancel</a>
              </div>
            </form>


            <form class="d-flex flex-column mx-auto mt-5 p-3 border rounded-3" style="max-width: 15rem; " method="post">
            

            <?php
              if (isset($_GET['doesntMatch'])) {
                echo '
                <div class="alert alert-success" role="alert">
                  Old Password Doesnt Match
                </div>
                ';
              } else if (isset($_GET['editPasswordSuccessfully'])) {
                echo '
                <div class="alert alert-success" role="alert">
                  Old Password Change
                </div>
                ';
              } 
            ?>

            <label class="form-label">Old Password</label>
            <input class="form-control" type="password" name="old-password" value="" required>

            <?php
              if (isset($_GET['invalidPassword'])) {
                echo '
                <div class="alert alert-danger" role="alert">
                  Password must have atlease 5 Characters atleast 1 Uppercase, Lowercase, special characters and number;
                </div>
                ';
              }
            ?>

            <label class="form-label">New Password</label>
            <input class="form-control" type="password" name="new-password" value="" required>


            <div class="d-flex justify-content-center align-items-center mt-3">
              <input class="btn btn-success me-3" type="submit" name="edit-password" value="Change Password" required>
            </div>
          </form>





        </div>
      </div>
    </div>
  </div>

  <?php
    require 'student-footer.php';
  ?>
</body>

</html>