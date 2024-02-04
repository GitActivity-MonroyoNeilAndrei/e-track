<?php
include '../classes/database.php';
include '../classes/message.php';
include '../classes/user.php';

session_start();

$admin = new database();


User::ifNotLogin('admin-username', '../login-account/login-user.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id' => $admin_id]), '../logout.php?logout=admin');

$full_name_of_org = "";

$org = $admin->select('student_org', '*', ['name_of_org'=>User::returnValueGet('activeStudentOrg')]);

while ($row = mysqli_fetch_assoc($org)) {
  $full_name_of_org = $row['full_name_of_org'];
}


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

    img {
      width: 100px;
    }



  </style>


</head>

<body>
  <div class="body">

    <div class="header" style="margin-top: 30px;">
      <img src="../images/msc_logo.png" alt="">
      <div>
        <h4 class="text-center" style="line-height: .7rem;">MARINDUQUE STATE COLLEGE</h4>
        <h4 class="text-center"  style="line-height: 1.4rem;"><?php echo $full_name_of_org; ?></h4>
      </div>
    </div>

    <h5 style="text-align: center; margin-top: 1.2rem;">Result of Evaluation of Activities for <?php User::printGet('activeStudentOrg') ?></h5>
    <h5 style="text-align: center;">A.Y. <?php User::printSession('school_year') ?></h5>



    <h6 class="fw-bold">Rating Basis:</h6>
      <p class="ps-1">1 - Strongly Disagree |
          2 - Disagree |
          3 - Agree |
          4 - Strongly Agree |
          5 - Very Strongly Agree 
      </p>


 
          <?php
          $evaluation_reports = $admin->selectDistinct('evaluation_of_activities', 'name_of_activity', ['name_of_org'=>User::returnValueGet('activeStudentOrg'),  'status'=>'deployed', 'status'=>'evaluated', 'draft'=>'']);

          while ($row = mysqli_fetch_assoc($evaluation_reports)) {

            $name_of_activity = $row['name_of_activity'];

          ?>

          <h4 class="text-center">Evaluation for <?php echo $name_of_activity; ?></h4>

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
                  <th>Mean</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $evaluation_questions = $admin->select('evaluation_of_activities', '*', ['name_of_org'=>User::returnValueGet('activeStudentOrg'), 'name_of_activity'=>$name_of_activity, 'status'=>'deployed', 'status'=>'evaluated', 'draft'=>'']);

                  while ($row = mysqli_fetch_assoc($evaluation_questions)) {

                    
                ?>
                <tr>
                  <td><?php echo $row['questionnaire']; ?></td>
                  <td><?php echo $row['five'] ?></td>
                  <td><?php echo $row['four'] ?></td>
                  <td><?php echo $row['three'] ?></td>
                  <td><?php echo $row['two'] ?></td>
                  <td><?php echo $row['one'] ?></td>
                  <td><?php if (($row['five'] + $row['four'] + $row['three'] + $row['two'] + $row['one']) != 0 ) { echo round( (($row['five'] * 5) + ($row['four'] * 4) + ($row['three'] * 3) + ($row['two'] * 2) + ($row['one'] * 1)) / ($row['five'] + $row['four'] + $row['three'] + $row['two'] + $row['one']), 2); }?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>



          <?php }
  
          
          ?>




  </div>

<script defer>
    let activeLink = document.getElementById("<?php User::printGet('activeStudentOrg') ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";


    var activeNav = document.getElementById('monitor-evaluation')
    activeNav.classList.add('bg-dark-gray2');



  </script>
<?php
$evaluation_reports = $admin->selectDistinct('evaluation_of_activities', 'name_of_activity', ['name_of_org'=>User::returnValueGet('activeStudentOrg'), 'draft'=>'']);

while ($row = mysqli_fetch_assoc($evaluation_reports)) {

  $name_of_activity = $row['name_of_activity'];
  $evaluation_questions = $admin->select('evaluation_of_activities', '*', ['name_of_org'=>User::returnValueGet('activeStudentOrg'), 'name_of_activity'=>$name_of_activity, 'status'=>'deployed', 'status'=>'evaluated', 'draft'=>'']);

  while ($row = mysqli_fetch_assoc($evaluation_questions)) {
    $admin->updateData('evaluation_of_activities', ['status'=>'printed'], ['id'=>$row['id']]);
  }

}
?>

<script>
  print();
</script>

</body>

</html>