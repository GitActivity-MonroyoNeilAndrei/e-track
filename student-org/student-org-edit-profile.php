<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');

$student_org = new database();

$password;

$result = $student_org->select('student_org', '*', ['id'=>User::returnValueSession('student-org-id')]);

while ($row = mysqli_fetch_assoc($result)) {
  $password = $row['password'];
}


if (isset($_POST['edit-profile'])) {


  $adviser = mysqli_escape_string($student_org->mysqli, $_POST['adviser']);
  $contact_no = mysqli_escape_string($student_org->mysqli, $_POST['contact-no']);
  $email = mysqli_escape_string($student_org->mysqli, $_POST['email']);


  $student_org->updateData('student_org', ['adviser'=>$adviser, 'contact_no'=>$contact_no, 'email'=>$email], ['id'=>User::returnValueSession('student-org-id')]);

  header("location: student-org-edit-profile.php?editSuccessful");
  
}

if  (isset($_POST['edit-password'])) {

  if (isset($_POST['new-password'])) {
    $password1 = $_POST['new-password'];
    $validPassword = User::isValidPassword($password1);
    $user = User::returnValueGet('user');

    if ($validPassword == "") {
      header("location: student-org-edit-profile.php?invalidPassword");
      exit;
    }
  }

  $old_password = md5($_POST['old-password']);
  $new_password = md5($_POST['new-password']);


  if ($old_password != $password) {
    header("location: student-org-edit-profile.php?doesntMatch");
  } else if ($old_password == $password) {
    $student_org->updateData('student_org', ['password'=>$new_password], ['id'=>User::returnValueSession('student-org-id')]);
    
    header("location: student-org-edit-profile.php?editPasswordSuccessfully");
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
      <button class="dropbtn"><i class="fa-solid fa-user"></i> <?php User::printSession('name_of_org'); ?></button>
        <div class="dropdown-content">
          <a href="student-org-edit-profile.php"><i class="fa-solid fa-address-card"></i> My Profile</a>
          <a href="../logout.php?logout=student-org"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
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

                $student_org_result = $student_org->select('student_org', '*', ['id'=>User::returnValueSession('student-org-id')]);

                while ($row = mysqli_fetch_assoc($student_org_result)) {
              ?>

              <div class="d-flex flex-row justify-content-between">

              <!-- name_of_org
              college_of
              adviser
              contact_no
              email -->


                <div>
                  <label class="form-label">Name of Org: </label>
                  <input class="form-control" type="text" name="name-of-org" value="<?php echo $row['name_of_org']; ?>" disabled>
                  <label class="form-label">College of: </label>
                  <input class="form-control" type="text" name="college-of" value="<?php echo $row['college_of']; ?>" disabled>
                  <label class="form-label">adviser: </label>
                  <input class="form-control" type="text" name="adviser" value="<?php echo $row['adviser']; ?>" required>

                </div>

                <div>
                  <label class="form-label">Contact No.</label>
                  <input class="form-control" type="text" name="contact-no" value="<?php echo $row['contact_no']; ?>" required>
                  <label class="form-label">email</label>
                  <input class="form-control" type="text" name="email" value="<?php echo $row['email']; ?>" required>
                </div>
              </div>




              

              <?php } ?>

              <div class="d-flex justify-content-center align-items-center mt-3">
                <input class="btn btn-success me-3" type="submit" name="edit-profile" value="Change" required>
                <a class="btn btn-danger" href="student-org-homepage.php">Cancel</a>
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
    require 'student-org-footer.php';
  ?>
  <script>
    var activeNav = document.getElementById('dashboard')
    activeNav.classList.add('bg-dark-gray2');
  </script>
</body>

</html>