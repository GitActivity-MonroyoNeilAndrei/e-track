<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$student_org = new database();

User::ifNotLogin('name_of_org', '../login-account/login-user.php');

$student_org_id = User::returnValueSession('student-org-id');

User::ifDeactivatedReturnTo($student_org->select('student_org', 'status', ['id'=>$student_org_id]), '../logout.php?logout=student-org');

$org_name = User::returnValueSession('name_of_org');

if(!isset($_GET['school_year'])) {
  $current_school_year = $student_org->selectDistinct('admin', 'current_school_year');
  $row = mysqli_fetch_assoc($current_school_year);

  header("location: student-org-list.php?school_year=$row[current_school_year]");


}

if(isset($_POST['submit'])) {
  $school_year = $_POST['school_year'];

  $activeStudentOrg = User::returnValueSession('name_of_org');

  header("location: student-org-list.php?activeStudentOrg=$activeStudentOrg&school_year=$school_year");
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
            <h5>List of Student Organization</h5>
          </div>


          <h4 class="text-center">Officers of <?php User::printSession("name_of_org") ?></h4>


          <form method="post" class="mx-auto text-center" style="max-width: 10rem;">
            <select name="school_year" class="form-select">
              <?php 
                $sql = "SELECT DISTINCT school_year FROM officers WHERE org_name = '$org_name' ORDER BY school_year DESC";
                $school_years = $student_org->mysqli->query($sql);
                
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
            $result = $student_org->select('officers', '*', ['school_year' => User::returnValueGet('school_year'), 'org_name' => User::returnValueSession('name_of_org')]);
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

        </div>
      </div>
    </div>
  </div>

  <?php
    require 'student-org-footer.php';
  ?>

  <script defer>
    let activeLink = document.getElementById("<?php User::printGet('activeStudentOrg') ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";


    var activeNav = document.getElementById('list')
    activeNav.classList.add('bg-dark-gray2');

  </script>
</body>

</html>