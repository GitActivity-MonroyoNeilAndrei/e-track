<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');

$admin = new database();

$password;

$result = $admin->select('admin', '*', ['id'=>User::returnValueSession('admin-id')]);

while ($row = mysqli_fetch_assoc($result)) {
  $password = $row['password'];
}


if (isset($_POST['edit-profile'])) {


  $username = mysqli_escape_string($admin->mysqli, $_POST['username']);
  $first_name = mysqli_escape_string($admin->mysqli, $_POST['first-name']);
  $last_name = mysqli_escape_string($admin->mysqli, $_POST['last-name']);
  $address = mysqli_escape_string($admin->mysqli, $_POST['address']);
  $contact_no = mysqli_escape_string($admin->mysqli, $_POST['contact-no']);
  $email = mysqli_escape_string($admin->mysqli, $_POST['email']);


  $admin->updateData('admin', ['username'=>$username, 'first_name'=>$first_name, 'last_name'=>$last_name, 'address'=>$address, 'contact_no'=>$contact_no, 'email'=>$email], ['id'=>User::returnValueSession('admin-id')]);

  header("location: admin-edit-profile.php?editSuccessful");
  
}

if  (isset($_POST['edit-password'])) {

  if (isset($_POST['new-password'])) {
    $password1 = $_POST['new-password'];
    $validPassword = User::isValidPassword($password1);
    $user = User::returnValueGet('user');

    if ($validPassword == "") {
      header("location: admin-edit-profile.php?invalidPassword");
      exit;
    }
  }

  $old_password = md5($_POST['old-password']);
  $new_password = md5($_POST['new-password']);


  if ($old_password != $password) {
    header("location: admin-edit-profile.php?doesntMatch");
  } else if ($old_password == $password) {
    $admin->updateData('admin', ['password'=>$new_password], ['id'=>User::returnValueSession('admin-id')]);
    
    header("location: admin-edit-profile.php?editPasswordSuccessfully");
  }
  
} else if (isset($_POST['set-school-year'])){
  
  $current_school_year = $_POST['current-school-year'];

  $admin->updateData('admin', ['current_school_year'=>$current_school_year]);

  $school_year_set = "School Year Set";

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
      <button class="dropbtn"><i class="fa-solid fa-user"></i> <?php User::printSession('admin_name'); ?></button>
        <div class="dropdown-content">
          <a href="admin-edit-profile.php"><i class="fa-solid fa-address-card"></i> My Profile</a>
          <a href="../logout.php?logout=admin"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
      
      <?php
        require 'admin-navigations.php';
       ?>

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

                $admin_user = $admin->select('admin', '*', ['id'=>User::returnValueSession('admin-id')]);

                while ($row = mysqli_fetch_assoc($admin_user)) {
              ?>

              <div class="d-flex flex-row justify-content-between">
                <div>
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
                  <label class="form-label">Contact No.:</label>
                  <input class="form-control" type="text" name="contact-no" value="<?php echo $row['contact_no']; ?>" required>
                  <label class="form-label">Email:</label>
                  <input class="form-control" type="text" name="email" value="<?php echo $row['email']; ?>" required>
                </div>
              </div>


              

              <?php } ?>

              <div class="d-flex justify-content-center align-items-center mt-3">
                <input class="btn btn-success me-3" type="submit" name="edit-profile" value="Change" required>
                <a class="btn btn-danger" href="admin-homepage.php">Cancel</a>
              </div>
            </form>


            <div class="d-flex flex-row m-auto" style="max-width: 40rem;">

            
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

          <form class="d-flex flex-column mx-auto mt-5 p-3 border rounded-3" style="max-width: 15rem; "  method="post">
            <h4>Set School Year</h4>

            <?php
              if (isset($school_year_set)) {
                echo '
                <div class="alert alert-success" role="alert">
                  '. $school_year_set .'
                </div>
                ';
              }

            ?>

            <label class="form-label">School Year:</label>
            <?php
              $current_school_year = $admin->selectDistinct('admin', 'current_school_year');
              
              while($row = mysqli_fetch_assoc($current_school_year)) {
            ?>
            <input class="form-control" type="text" name="current-school-year" value="<?php echo $row['current_school_year']; ?>">

            <?php } ?>
            <input class="btn btn-primary mt-2 mx-auto" type="submit" name="set-school-year" value="Set">
          </form>

          </div>



        </div>
      </div>
    </div>
  </div>

  <?php
    require 'admin-footer.php';
  ?>
</body>

</html>