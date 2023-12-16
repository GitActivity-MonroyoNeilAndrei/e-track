<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');


session_start();

$student_org = new database();

User::ifNotLogin('name_of_org', '../login-account/login-user.php');

$student_org_id = User::returnValueSession('student-org-id');

User::ifDeactivatedReturnTo($student_org->select('student_org', 'status', ['id' => $student_org_id]), '../logout.php?logout=student-org');

$name_of_org = User::returnValueSession('name_of_org');

$drafted_plan_of_activities = $student_org->countSelect('plan_of_activities', 'status', "status = 'draft' AND name_of_org = '$name_of_org'");
$drafted_accomplishment_reports = $student_org->countSelect('accomplishment_reports', 'status', "status = 'draft' AND name_of_org = '$name_of_org'");

$student_add_success;
$student_add_fail;

$course_covered = ["", "", "", "", "", "", "", "", "", ""];

$course_covered_query = $student_org->select('student_org', '*', ['name_of_org'=>$name_of_org]);

while($row = mysqli_fetch_assoc($course_covered_query)) {
  $courses = explode(",", $row['course_covered']);

  for ($i = 0; $i < count($courses); $i++) {
    $course_covered[$i] = $courses[$i];
  }
}




if(isset($_POST['add-student'])) {
  $student_id = mysqli_escape_string($student_org->mysqli, $_POST['student-id']);
  $student_first_name = mysqli_escape_string($student_org->mysqli, $_POST['student-first-name']);
  $student_last_name = mysqli_escape_string($student_org->mysqli, $_POST['student-last-name']);
  $student_course = mysqli_escape_string($student_org->mysqli, $_POST['student-course']);
  $student_year = $_POST['year'];

  $student_password = md5(str_replace(' ', '', $student_first_name . $student_last_name));

  if($student_org->isExisted('student', ['student_id'=>$student_id])) {
    $student_add_fail = "Student Already Added!";
  } else {
    $student_org->insertData('student', ['username'=>$student_first_name, 'first_name'=>$student_first_name, 'last_name'=>$student_last_name, 'student_id'=>$student_id, 'status'=>'activated', 'course'=>$student_course, 'password'=>$student_password, 'year_and_section'=>$student_year]);

    $student_add_success = $student_first_name;
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
  <script src="https://kit.fontawesome.com/ba2dc1cde9.js" crossorigin="anonymous"></script>
</head>

<body>
  <?php
    echo $course_covered[3];
  ?>
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
            <h5>List of Enrollees</h5>
          </div>



          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <form class="border shadow m-3" method="post">
                    <td><input class="form-control" type="text" placeholder="Student ID..." name="student-id" required></td>
                    <td><input class="form-control" type="text" placeholder="First Name..." name="student-first-name" required></td>
                    <td><input class="form-control" type="text" placeholder="Last Name..." name="student-last-name" required></td>
                    <td>
                      <select class="form-select" name="year">
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                      </select>
                    </td>
                    <td>
                      <select name="student-course" class="form-select" required>
                        <?php 
                          foreach ($course_covered as $course) {

                            if ($course == "") {break;}

                        ?>
                          <option value="<?php echo $course ?>"><?php echo $course; ?></option>

                        <?php
                          }
                        ?>
                      </select>
                    </td>

                    

                    <td><input class="btn btn-primary" type="submit" name="add-student" value="Add"></td>
                  </form>
                </tr>
                <?php
                  if (isset($student_add_success)) {
                ?>
                  <div class="alert alert-success" role="alert">
                     <?php echo $student_add_success ?> successfully added!
                  </div>
                <?php } else if (isset($student_add_fail)) {?>

                  <div class="alert alert-danger" role="alert">
                     <?php echo $student_add_fail ?>
                  </div>
                <?php } ?>
                <tr>
                  <th class="bg-primary-subtle text-center" colspan="6">Search</th>
                </tr>

                <tr>
                  <form method="post">
                    <th><input class="form-control" type="text" name="student-id" placeholder="Student ID"></th>
                    <th><input class="form-control" type="text" name="first-name" placeholder="First Name"></th>
                    <th><input class="form-control" type="text" name="last-name" placeholder="Last Name"></th>
                    <th>
                      <select class="form-select" name="year">
                        <option value=""></option>
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                      </select>
                    </th>
                    <th>
                      <select name="course" class="form-select">
                        <?php 
                          $first_time = true;
                          foreach ($course_covered as $course) {
                            if ($course == "") {break;}
                            if($first_time) {
                              echo '
                              <option value=""></option>
                              ';
                              $first_time = false;
                            }
                        ?>
                          <option value="<?php echo $course ?>"><?php echo $course; ?></option>

                        <?php
                          }
                        ?>
                      </select>
                    </th>
                    <th><input style="font-size: .8em; padding: 2px 4px;" class="btn btn-primary" type="submit" name="search" value="Search"></th>
                  </form>
                </tr>

                <tr>
                  <th>Student ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Year</th>
                  <th>Course</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>

              <?php
                $result;
                if (isset($_POST['search'])) {
                  $student_id = $_POST['student-id'];
                  $first_name = $_POST['first-name'];
                  $last_name = $_POST['last-name'];
                  $year = $_POST['year'];
                  $course = $_POST['course'];

                  $result = $student_org->advanceSelect('student', '*', " course IN ('$course_covered[0]', '$course_covered[1]', '$course_covered[2]', '$course_covered[3]', '$course_covered[4]', '$course_covered[5]', '$course_covered[6]') AND student_id LIKE '%$student_id%' AND first_name LIKE '%$first_name%' AND last_name LIKE '%$last_name%' AND year_and_section LIKE '%$year%' AND course LIKE '%$course%' ORDER BY id DESC");



                } else {
                  $result = $student_org->advanceSelect('student', '*', " course IN ('$course_covered[0]', '$course_covered[1]', '$course_covered[2]', '$course_covered[3]', '$course_covered[4]', '$course_covered[5]', '$course_covered[6]') ORDER BY id DESC");
                }
                

                while ($row = mysqli_fetch_assoc($result)) {
              ?>
                <tr>
                  <td><?php echo $row['student_id'] ?></td>
                  <td><?php echo $row['first_name'] ?></td>
                  <td><?php echo $row['last_name'] ?></td>
                  <td><?php echo $row['year_and_section'] ?></td>
                  <td><?php echo $row['course'] ?></td>
                  <td>
                    <a class="btn btn-secondary" href="edit-students.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a class="btn btn-danger" href="delete-students.php?id=<?php echo $row['id']; ?>">Delete</a>
                  </td>
                </tr>
                

              <?php } ?>

              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>

  </div>

  <?php
    require 'student-org-footer.php';
  ?>

  <script defer>
    let activeLink = document.getElementById("<?php User::printGet('user'); ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";
  </script>

<script>
    var activeNav = document.getElementById('list-of-enrollees')
    activeNav.classList.add('bg-dark-gray2');
  </script>
</body>

</html>