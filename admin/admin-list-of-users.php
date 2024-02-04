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

if(!isset($_GET['user'])){
  header('location: admin-list-of-users.php?user=admin&page=all');
}else if ($_GET['user'] == '') {
  header('location: admin-list-of-users.php?user=admin&page=all');
}

$user = User::returnValueGet('user');


if (!isset($_GET['page'])) {
  header("location: admin-list-of-users.php?user=$user&page=all");
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
            <h5>Monitor Election</h5>
          </div>
          <nav class="org-list-nav">
            <ul>
              <li id="admin" onclick="window.location.href='admin-list-of-users.php?user=admin'">Admin</li>
              <li id="student_org" onclick="window.location.href='admin-list-of-users.php?user=student_org'">Student Org.</li>
              <li id="student" onclick="window.location.href='admin-list-of-users.php?user=student'">Students</li>
            </ul>
          </nav>
          <nav class="org-list-nav">
            <ul>
              <li onclick="window.location.href='admin-list-of-courses.php'">Available Courses</li>
            </ul>
          </nav>

          <div class="button-search-wrapper">
            <a class="btn btn-primary mb-2 <?php if(User::returnValueGet('user') != 'admin') {echo 'd-none';} ?>" href="admin-add-user.php?user=<?php echo 'admin'; ?>"><i class="fa-solid fa-plus"></i> Add Admin</a>
            <a class="btn btn-primary mb-2 <?php if(User::returnValueGet('user') != 'student') {echo 'd-none';} ?>" href="admin-add-user.php?user=<?php echo 'student'; ?>"><i class="fa-solid fa-plus"></i> Add Student</a>
            <a class="btn btn-primary mb-2 <?php if(User::returnValueGet('user') != 'student_org') {echo 'd-none';} ?>" href="admin-add-user.php?user=<?php echo 'student_org'; ?>"><i class="fa-solid fa-plus"></i> Add Student Org.</a>

            <form method="post" class="d-flex" role="search">
              <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit" name="submit">Search</button>
            </form>

            <form method="post" class="d-flex flex-row <?php if(User::returnValueGet('user') != 'student') {echo 'd-none';} ?>" >
              <select class="form-select" name="course">
                <?php
                  $courses = $admin->selectDistinct('student', 'course');
                  while ($row = mysqli_fetch_assoc($courses)) {
                ?>

                    <option value="<?php echo $row['course']; ?>"><?php echo $row['course']; ?></option>

                <?php } ?>
              </select>
              <input class="btn btn-secondary" type="submit" name="filter-course" value="Filter">
            </form>
          </div>
          
          <?php
            if (isset($_GET['addSuccessful'])) {
              echo '
              <div class="alert alert-success" role="alert">
                User Added Successfully
              </div>
              ';
            }
          ?>

          <nav class="mt-3">
            <ul class="pagination d-flex justify-content-center">
              <li class="page-item"><a class="page-link" href="admin-list-of-users.php?user=<?php echo $user; ?>&page=<?php echo 'all'; ?>" id="<?php echo 'all'; ?>">all</a></li>
              <?php
                $sql = "SELECT COUNT(id) FROM $user;";
                $result = $admin->mysqli->query($sql);

                $count = $result->fetch_assoc();

                $num = $count['COUNT(id)'] / 10;
                $num_of_page = ceil($num);
                
                for ($i = 1; $i <= $num_of_page; $i++){
                
              ?>
                <li class="page-item"><a class="page-link" href="admin-list-of-users.php?user=<?php echo $user; ?>&page=<?php echo $i; ?>" id="<?php echo $i; ?>"><?php echo $i; ?></a></li>

              <?php } ?>
            </ul>
          </nav>

          <div class="table-responsive">
            <table class="table table-striped table-hover">
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
                  <th>Enrolled Students</th>
                  <th>status</th>
                  <th>Action</th>
                </tr>

              </thead>
              <tbody>
                <tbody>

                <?php

                  if(isset($_POST['submit'])) {
                    $search = $_POST['search'];
                    if($user == 'student_org'){
                      $result = $admin->search($user, 'name_of_org', 'college_of', $search);
                    } else if ($user == 'student') {

                      $result = $admin->advanceSelect($user, '*', " first_name LIKE '%$search%' OR  last_name LIKE '%$search%' OR  student_id LIKE '%$search%' ");

                      // $result = $admin->search($user, 'first_name', 'last_name', $search);
                    } else {
                      $result = $admin->search($user, 'first_name', 'last_name', $search);
                    }
                    
                  }else {
                  if($_GET['page'] == 'all'){
                    $result = $admin->limitSelectAll($user);
                  }else {
                    $num = ((int)$_GET['page']) - 1;
                    $offset = (string)$num . '0';

                    $result = $admin->limitSelectAll($user, 10, (int)$offset);
                  }
                  }


                  if (isset($_POST['filter-course'])) {
                    $result = $admin->select('student', '*', ['course'=>$_POST['course']]);
                  }

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
                      <a class="btn btn-success mb-3" href="admin-edit-users.php?id=<?php echo $row['id']; ?>&user=<?php User::printGet('user'); ?>">Edit</a>
                      <a class="btn btn-secondary mb-3 <?php if($row['status'] == 'activated') {echo 'd-none';} ?>" href="change-user-status.php?id=<?php echo $row['id'] ?>&user=<?php echo User::returnValueGet('user'); ?> &status=<?php echo 'activated'; ?>">Activate</a>
                      <a class="btn btn-danger mb-3 <?php if($row['status'] == 'deactivated') {echo 'd-none';} ?>" href="change-user-status.php?id=<?php echo $row['id'] ?>&user=<?php echo User::returnValueGet('user'); ?> &status=<?php echo 'deactivated'; ?>">Deactivate</a>
                    </td>
                  </tr>

                  <tr class="<?php if (User::returnValueGet('user') != 'student') { echo 'd-none' ;}  ?>">
                    <td><?php echo $row['first_name'] .' '.  $row['last_name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['student_id']; ?></td>
                    <td><?php echo $row['course']; ?></td>
                    <td><?php echo $row['year_and_section']; ?></td>
                    <td><?php echo $row['contact_no']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['status'] ?></td>
                    <td>
                      <a class="btn btn-success mb-3" href="admin-edit-users.php?id=<?php echo $row['id']; ?>&user=<?php User::printGet('user'); ?>"> Edit</a>
                      <a class="btn btn-secondary mb-3 <?php if($row['status'] == 'activated') {echo 'd-none';} ?>" href="change-user-status.php?id=<?php echo $row['id'] ?>&user=<?php echo User::returnValueGet('user'); ?> &status=<?php echo 'activated'; ?>">Activate</a>
                      <a class="btn btn-danger mb-3 <?php if($row['status'] == 'deactivated') {echo 'd-none';} ?>" href="change-user-status.php?id=<?php echo $row['id'] ?>&user=<?php echo User::returnValueGet('user'); ?> &status=<?php echo 'deactivated'; ?>">Deactivate</a>
                    </td>
                  </tr>

                  <tr class="<?php if (User::returnValueGet('user') != 'student_org') { echo 'd-none' ;}  ?>">
                    <td><?php echo $row['name_of_org']; ?></td>
                    <td><?php echo $row['college_of']; ?></td>
                    <td><?php echo $row['adviser']; ?></td>
                    <td><?php echo $row['contact_no']; ?></td>
                    <td><?php echo $row['email']; ?></td>

                    <?php
                    if (User::returnValueGet('user') == 'student_org')
                    {
                      $course_covered = explode(",", $row['course_covered']);

                      array_push($course_covered, "");
                      array_push($course_covered, "");
                      array_push($course_covered, "");
                      array_push($course_covered, "");

                      $number_of_enrollees = $admin->countSelect('student', "*", "course = '$course_covered[0]' OR course = '$course_covered[1]' OR course = '$course_covered[2]' OR course = '$course_covered[3]' OR course = '$course_covered[4]'");
                    }

                    ?>



                    <td><?php echo $number_of_enrollees ?></td>
                    <td><?php echo $row['status'] ?></td>
                    <td>
                      <a class="btn btn-success mb-3" href="admin-edit-users.php?id=<?php echo $row['id']; ?>&user=<?php User::printGet('user'); ?>"> Edit</a>
                      <a class="btn btn-secondary mb-3 <?php if($row['status'] == 'activated') {echo 'd-none';} ?>" href="change-user-status.php?id=<?php echo $row['id'] ?>&user=<?php echo User::returnValueGet('user'); ?> &status=<?php echo 'activated'; ?>">Activate</a>
                      <a class="btn btn-danger mb-3 <?php if($row['status'] == 'deactivated') {echo 'd-none';} ?>" href="change-user-status.php?id=<?php echo $row['id'] ?>&user=<?php echo User::returnValueGet('user'); ?> &status=<?php echo 'deactivated'; ?>">Deactivate</a>
                    </td>
                  </tr>

                <?php } ?>

                </tbody>
              </tbody>
            </table>
          </div> <!-- div responsive table -->

          <nav class="mt-3">
            <ul class="pagination d-flex justify-content-center">
              <li class="page-item"><a class="page-link" href="admin-list-of-users.php?user=<?php echo $user; ?>&page=<?php echo 'all'; ?>" id="<?php echo 'all'; ?>">all</a></li>
              <?php
                $sql = "SELECT COUNT(id) FROM $user;";
                $result = $admin->mysqli->query($sql);

                $count = $result->fetch_assoc();

                $num = $count['COUNT(id)'] / 10;
                $num_of_page = ceil($num);
                
                for ($i = 1; $i <= $num_of_page; $i++){
                
              ?>
                <li class="page-item"><a class="page-link" href="admin-list-of-users.php?user=<?php echo $user; ?>&page=<?php echo $i; ?>" id="<?php echo $i; ?>"><?php echo $i; ?></a></li>

              <?php } ?>
            </ul>
          </nav>

        </div>
      </div>
    </div>

  </div>

  <?php
    require 'admin-footer.php';
  ?>

  <script defer>
    let activeLink = document.getElementById("<?php User::printGet('user'); ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";

    let activePage = document.getElementById("<?php User::printGet('page'); ?>");
    activePage.classList.add('active');

    
    var activeNav = document.getElementById('list-of-users')
    activeNav.classList.add('bg-dark-gray2');

    window.addEventListener("focus", function() {
      location.reload();
    });
    
  </script>
</body>

</html>