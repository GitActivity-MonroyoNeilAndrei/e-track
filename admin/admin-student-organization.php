<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$admin = new database();

User::ifNotLogin('admin-username', '../login-account/login-user.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id'=>$admin_id]), '../logout.php?logout=admin');



if (!isset($_GET['activeStudentOrg'])) {
  $result = $admin->selectDistinct('student_org', 'name_of_org');

  $row = mysqli_fetch_assoc($result);
  header("location: admin-student-organization.php?activeStudentOrg=$row[name_of_org]");
}

$org_name = User::returnValueGet('activeStudentOrg');

if(!isset($_GET['school_year'])) {
  $connection = new mysqli('localhost', 'root', '', 'etrack');


  $sql = "SELECT DISTINCT school_year FROM officers WHERE org_name = '$org_name' ORDER BY school_year DESC LIMIT 2;";

  $result = $connection->query($sql);
  $row = mysqli_fetch_assoc($result);

  $latest_school_year = "";
  if($row){
    $latest_school_year = $row['school_year'];
  }

  $activeStudentOrg = User::returnValueGet('activeStudentOrg');

  if($latest_school_year != "") {
    header("location: admin-student-organization.php?activeStudentOrg=$activeStudentOrg&school_year=$latest_school_year");
  }

}

if(isset($_POST['submit'])) {
  $school_year = $_POST['school_year'];

  $activeStudentOrg = User::returnValueGet('activeStudentOrg');

  header("location: admin-student-organization.php?activeStudentOrg=$activeStudentOrg&school_year=$school_year");
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

  <style>
    div.img img {
      width: 100%;
      height: 100%;
    }

    .img {
      border: 1px solid black;
      border-radius: 50%;
      width: 9rem;
      height: 9rem;
      margin-right: 2vw;
      overflow: hidden;
    }

    .candidate-container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      border-radius: 14px;
      padding: 1rem 0;
      margin: 1rem 1.5rem;
      border: 1px solid black;
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
            <h5>List of Student Organization</h5>
          </div>


          <nav class="org-list-nav mb-3">
            <ul>
              <?php
              $result = $admin->selectDistinct('student_org', 'name_of_org');
              while ($row = mysqli_fetch_assoc($result)) {
              ?>

                <li id="<?php echo $row['name_of_org']; ?>" onclick="window.location.href = 'admin-student-organization.php?activeStudentOrg=<?php echo $row['name_of_org'] ?>';"><?php echo $row['name_of_org']; ?></li>

              <?php } ?>
            </ul>
          </nav>

          <h4 class="text-center">Officers of <?php User::printGet('activeStudentOrg') ?></h4>

          <div class="text-center">
            <a class="text-primary" href="admin-student-org-covered.php?studentOrg=<?php User::printGet('activeStudentOrg'); ?>">Course Covered?</a>
          </div>

          <form method="post" class="mx-auto text-center" style="max-width: 10rem;">
            <select name="school_year" class="form-select">
              <?php 
                $sql = "SELECT DISTINCT school_year FROM officers WHERE org_name = '$org_name' ORDER BY school_year DESC";
                $school_years = $admin->mysqli->query($sql);
                
                while($row = mysqli_fetch_assoc($school_years)) {
              ?>
                <option value="<?php echo $row['school_year']; ?>" <?php if($row['school_year'] == User::returnValueGet('school_year')) {echo "selected";} ?>><?php echo $row['school_year']; ?></option>
              <?php
                }
              ?>
            </select>
            <input class="btn btn-primary my-2" type="submit" name="submit" value="Select">
          </form>





          <?php
            $result = $admin->select('officers', '*', ['school_year' => User::returnValueGet('school_year'), 'org_name' => $org_name]);
            while ($row = mysqli_fetch_assoc($result)) {
          ?>
          
          <section class="candidate-container shadow bg-secondary bg-gradient">
            <h3 class="fw-bold"><?php echo $row['position']; ?></h3>
            <div class="d-flex justify-content-center align-items-center">
              <div class="img"><img src="../uploads/<?php echo $row['photo_url']; ?>" alt=""></div>
              <div><h4><?php echo $row['first_name'] . " " . $row['last_name']; ?></h4></div>
            </div>
            
          </section>

          <?php } ?>
          <?php if($admin->isExisted('officers', ['org_name'=>User::returnValueGet('activeStudentOrg')])){ ?>
          <div class="d-flex justify-content-center mt-4 mb-2">
            <a class="btn btn-primary" href="admin-edit-organization.php?studentOrg=<?php User::printGet('activeStudentOrg') ?>&latestSchoolYear=<?php User::printGet('school_year'); ?>">Edit Members</a>

          </div>
          <?php } ?>

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


    var activeNav = document.getElementById('student-organization')
    activeNav.classList.add('bg-dark-gray2');

  </script>
</body>

</html>