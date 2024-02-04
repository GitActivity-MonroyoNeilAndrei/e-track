<?php
include '../classes/database.php';
include '../classes/message.php';
include '../classes/user.php';

session_start();

$admin = new database();


User::ifNotLogin('admin-username', '../login-account/login-user.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id' => $admin_id]), '../logout.php?logout=admin');


if (!isset($_GET['activeStudentOrg'])) {
  $result = $admin->selectDistinct('student_org', 'name_of_org');

  $row = mysqli_fetch_assoc($result);
  header("location: admin-monitor-evaluation.php?activeStudentOrg=$row[name_of_org]");
}

$name_of_activity;
$activity = $admin->select('evaluation_of_activities', '*', ['name_of_org'=>User::returnValueGet('activeStudentOrg')]);

while ($row = mysqli_fetch_assoc($activity)) {
  $name_of_activity = $row['name_of_activity'];
}

$student_org = User::returnValueGet('activeStudentOrg');


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
            <h5>Evaluation of Activities</h5>
          </div>

          <nav class="org-list-nav">
            <ul>
              <?php
              $result = $admin->selectDistinct('student_org', 'name_of_org');
              while ($row = mysqli_fetch_assoc($result)) {
              ?>

                <li id="<?php echo $row['name_of_org']; ?>" onclick="window.location.href = 'admin-monitor-evaluation.php?activeStudentOrg=<?php echo $row['name_of_org'] ?>';"><?php echo $row['name_of_org']; ?></li>

              <?php } ?>
            </ul>
          </nav>



          <?php
          // $evaluation_reports = $admin->selectDistinct('evaluation_of_activities', 'name_of_activity', ['name_of_org'=>User::returnValueGet('activeStudentOrg'), 'status'=>'deployed', 'status'=>'evaluated', 'draft'=>'']);


          $evaluation_reports = $admin->advanceSelectDistinct('evaluation_of_activities', 'name_of_activity', " name_of_org = '$student_org' AND (status = 'deployed' OR status = 'evaluated') AND draft = ''");

          while ($row = mysqli_fetch_assoc($evaluation_reports)) {
          ?>

          <h4 class="text-center">Evaluation for <?php echo $row['name_of_activity']; ?></h4>

          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Questionnaire</th>
                  <th>5</th>
                  <th>4</th>
                  <th>3</th>
                  <th>2</th>
                  <th>1</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  // $evaluation_questions = $admin->select('evaluation_of_activities', '*', ['name_of_org'=>User::returnValueGet('activeStudentOrg'), 'name_of_activity'=>$row['name_of_activity'], 'status'=>'deployed', 'status'=>'evaluated', 'draft'=>'']);


                  $evaluation_questions = $admin->advanceSelect('evaluation_of_activities', '*', " name_of_org = '$student_org' AND name_of_activity = '$row[name_of_activity]' AND (status = 'deployed' OR status = 'evaluated') AND draft = ''");

                  while ($row = mysqli_fetch_assoc($evaluation_questions)) {
                    
                ?>
                <tr>
                  <td><?php echo $row['questionnaire']; ?></td>
                  <td><?php echo $row['five'] ?></td>
                  <td><?php echo $row['four'] ?></td>
                  <td><?php echo $row['three'] ?></td>
                  <td><?php echo $row['two'] ?></td>
                  <td><?php echo $row['one'] ?></td>

                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

          <?php }
          
          
          if ($evaluation_reports->num_rows >= 1 ) {

          ?>

          <div class="text-center">
            <a class="btn btn-primary" href="admin-print-evaluation.php?activeStudentOrg=<?php User::printGet("activeStudentOrg");?>&printEvaluation" target="_blank"><i class="fa-solid fa-print"></i> Print</a>
          </div>

          <?php
          }
          
          ?>




          

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


    var activeNav = document.getElementById('monitor-evaluation')
    activeNav.classList.add('bg-dark-gray2');


      window.addEventListener("focus", function() {
      location.reload();
    });
  


  </script>
</body>

</html>