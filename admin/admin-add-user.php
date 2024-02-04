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

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id' => $admin_id]), '../logout.php?logout=admin');



if (isset($_POST['submit'])) {

  if (isset($_POST['password'])) {
    $password = $_POST['password'];
    $validPassword = User::isValidPassword($password);
    $user = User::returnValueGet('user');

    if ($validPassword == "") {
      header("location: admin-add-user.php?user=$user&invalidPassword");
      exit;
    }
  }


  if (User::returnValueGet('user') == 'admin') {
    $username = $_POST['username'];
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $address = $_POST['address'];
    $contact_no = $_POST['contact-no'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $confirm_password = md5($_POST['confirm-password']);


    if ($password != $confirm_password) {
      $error_password = "Password doesn't Match";
    } else if (strlen($contact_no) != 11) {
      $contact_no_error = "Contact No. Needs to be 11 digits";
    } else {

      if (
        !$admin->isExisted('student_org', ['email' => $email]) &&
        !$admin->isExisted('admin', ['email' => $email])
      ) {
        $admin->insertData('admin', ['username' => $username, 'first_name' => $first_name, 'last_name' => $last_name, 'address' => $address, 'contact_no' => $contact_no, 'email' => $email, 'password' => $password]);

        header('location: admin-list-of-users.php?user=admin&page=all&addSuccessful');
      } else {
        $admin_exist = true;
      }
    }
  } else if (User::returnValueGet('user') == 'student') {
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


    if ($password != $confirm_password) {
      $error_password = "Password doesn't Match";
    } else if (strlen($contact_no) != 11) {
      $contact_no_error = "Contact No. Needs to be 11 digits";
    } else {

      if (
        !$admin->isExisted('student', ['student_id' => $student_id]) &&
        !$admin->isExisted('student', ['email' => $email]) &&
        !$admin->isExisted('student_org', ['email' => $email]) &&
        !$admin->isExisted('admin', ['email' => $email])
      ) {
        $admin->insertData('student', ['first_name' => $first_name, 'last_name' => $last_name, 'address' => $address, 'student_id' => $student_id, 'course' => $course, 'year_and_section' => $year, 'contact_no' => $contact_no, 'email' => $email, 'password' => $password]);

        header('location: admin-list-of-users.php?user=student&page=all&addSuccessful');
      } else {
        $student_exist = true;
      }
    }
  } else if (User::returnValueGet('user') == 'student_org') {
    $name_of_org = $_POST['name-of-org'];
    $full_name_of_org = $_POST['full-name-of-org'];
    $college_of = $_POST['college-of'];
    $adviser = $_POST['adviser'];
    $contact_no = $_POST['contact-no'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $confirm_password = md5($_POST['confirm-password']);


    if ($password != $confirm_password) {
      $error_password = "Password doesn't Match";
    } else if (strlen($contact_no) != 11) {
      $contact_no_error = "Contact No. Needs to be 11 digits";
    } else {

      if (
        !$admin->isExisted('student_org', ['name_of_org' => $name_of_org, 'email' => $email]) &&
        !$admin->isExisted('admin', ['email' => $email]) &&
        !$admin->isExisted('student', ['email' => $email])
      ) {
        $admin->insertData('student_org', ['name_of_org' => $name_of_org, 'full_name_of_org' => $full_name_of_org, 'college_of' => $college_of, 'adviser' => $adviser, 'contact_no' => $contact_no, 'email' => $email, 'password' => $password]);

        header('location: admin-list-of-users.php?user=student_org&page=all&addSuccessful');
      } else {
        $student_org_exist = true;
      }
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
            <h5>List of Users > Edit User</h5>
          </div>
          <form method="post" class="d-flex justify-content-center flex-column mx-auto shadow rounded-2 mt-3 mb-3 <?php if (User::returnValueGet('user') != 'admin') {
                                                                                                                    echo 'd-none';
                                                                                                                  } ?>" style="max-width: 17rem; padding: 1rem 1rem 0;">
            <h4 class="text-center">Add Admin</h4>
            <?php
            if (isset($error_password)) {
              echo "
                  <div class='alert alert-danger' role='alert'>
                    $error_password
                  </div>
                ";
            } else if (isset($contact_no_error)) {
              echo "
                  <div class='alert alert-danger' role='alert'>
                    $contact_no_error
                  </div>
                ";
            } else if (isset($_GET['invalidPassword'])) {
              echo '
                <div class="alert alert-danger" role="alert">
                  Password must have atlease 5 Characters atleast 1 Uppercase, Lowercase, special characters and number;
                </div>
                ';
            } else if (isset($admin_exist)) {
              Message::userAlreadyExist();
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

          <div class="d-flex justify-content-center flex-column mx-auto shadow rounded-2 mt-3 mb-3 <?php if (User::returnValueGet('user') != 'student') {
                                                                                                      echo 'd-none';
                                                                                                    } ?>">
            <h4 class="text-center">Add Student</h4>

            <?php
            if (isset($error_password)) {
              echo "
                <div class='alert alert-danger' role='alert'>
                  $error_password
                </div>
                ";
            } else if (isset($contact_no_error)) {
              echo "
                  <div class='alert alert-danger' role='alert'>
                    $contact_no_error
                  </div>
                ";
            } else if (isset($_GET['invalidPassword'])) {
              echo '
                <div class="alert alert-danger" role="alert">
                  Password must have atlease 5 Characters atleast 1 Uppercase, Lowercase, special characters and number;
                </div>
                ';
            } else if (isset($student_exist)) {
              echo '
                <div class="alert alert-danger" role="alert">
                  Student has been Already Added
                </div>
                ';
            }
            ?>
            <form method="post" class='d-flex justify-content-center flex-row mb-4'>

              <div style="max-width: 17rem; padding: 1rem 1rem 0;">
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
                <select class="form-select" name="year" required>
                  <option value="1st">1st</option>
                  <option value="2nd">2nd</option>
                  <option value="3rd">3rd</option>
                  <option value="4th">4th</option>
                </select>
              </div>

              <div style="max-width: 17rem; padding: 1rem 1rem 0;">
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


              </div>
            </form>
            <h4 class="text-center">Or</h4>
            <form method="post" enctype="multipart/form-data" class="d-flex flex-column justify-content-center border shadow p-2 rounded-3 mx-auto" style="max-width: 20rem;">
              <label for="">Import Students using Excel</label>
              <input class="form-control" type="file" name="excel" required value="">
              <button class="btn btn-secondary" type="submit" name="import">Import</button>
            </form>
          </div>




          <form method="post" class="d-flex justify-content-center flex-column mx-auto shadow rounded-2 mt-3 mb-3 <?php if (User::returnValueGet('user') != 'student_org') {
                                                                                                                    echo 'd-none';
                                                                                                                  } ?>" style="max-width: 17rem; padding: 1rem 1rem 0;">
            <h4 class="text-center">Add Student Org.</h4>
            <?php
            if (isset($error_password)) {
              echo "
                <div class='alert alert-danger' role='alert'>
                  $error_password
                </div>
                ";
            } else if (isset($contact_no_error)) {
              echo "
                  <div class='alert alert-danger' role='alert'>
                    $contact_no_error
                  </div>
                ";
            } else if (isset($_GET['invalidPassword'])) {
              echo '
                <div class="alert alert-danger" role="alert">
                  Password must have atlease 5 Characters atleast 1 Uppercase, Lowercase, special characters and number;
                </div>
                ';
            } else if (isset($student_org_exist)) {
              Message::userAlreadyExist();
            }
            ?>
            <label class="form-label" for="name-of-org">Name of Org "Abbr.":</label>
            <input class="form-control" type="text" name="name-of-org" required>
            <label class="form-label" for="full-name-of-org">Full Name of Org:</label>
            <input class="form-control" type="text" name="full-name-of-org" required>
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

  <?php
  require 'admin-footer.php';
  ?>

  <script>
    var activeNav = document.getElementById('list-of-users')
    activeNav.classList.add('bg-dark-gray2');
  </script>



  <?php
  $conn = mysqli_connect("localhost", "root", "", "etrack");

  if (isset($_POST["import"])) {
    $fileName = $_FILES["excel"]["name"];
    $fileExtension = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExtension));

    $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

    $targetDirectory = "uploads/" . $newFileName;
    move_uploaded_file($_FILES["excel"]["tmp_name"], $targetDirectory);

    error_reporting(0);

    ini_set('display_errors', 0);

    require "excelReader/excel_reader2.php";
    require "excelReader/SpreadsheetReader.php";

    $reader = new SpreadsheetReader($targetDirectory);

    $password = md5('Student@123');

    foreach ($reader as $key => $row) {
      $first_name = $row[0];
      $last_name = $row[1];
      $student_id = $row[2];
      $course = $row[3];

      $email = $row[4];
      $address = $row[5];
      $year = $row[6];
      $contact_no = $row[7];


      mysqli_query($conn, "INSERT INTO student (first_name, last_name, student_id, course, email, address, year_and_section, contact_no, password) VALUES('$first_name', '$last_name', '$student_id', '$course', '$email', '$address', '$year', '$contact_no', '$password')");
    }

    echo
    "
        <script>
          alert('Data Has been Imported');
          documentation.location.href = '';
        </script>
      ";
  }

  $admin->deleteRow('student', "first_name = ''")
  ?>


</body>

</html>