
<?php
include '../classes/database.php';
include '../classes/message.php';
include '../classes/user.php';

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');

session_start();

$admin = new database();


User::ifNotLogin('admin-username', '../login-account/login-user.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id' => $admin_id]), '../logout.php?logout=admin');

if (!isset($_GET['activeStudentOrg'])) {
  $result = $admin->selectDistinct('student_org', 'name_of_org');

  $row = mysqli_fetch_assoc($result);
  header("location: admin-evaluation-of-activities.php?activeStudentOrg=$row[name_of_org]");
}

$successfully_added;
$unsuccessfully_added;
$deleted;

if (isset($_POST['add-questionnaire'])) {
  $questionnaire = mysqli_escape_string($admin->mysqli, $_POST['questionnaire']);

  if ($admin->isExisted('evaluation_of_activities', ['questionnaire'=>$questionnaire])) {
    $unsuccessfully_added = "Questionnaire Already Exist";
  } else {
    $admin->insertData('evaluation_of_activities', ['questionnaire'=>$questionnaire, 'name_of_org'=>User::returnValueGet('activeStudentOrg')]);

    $successfully_added = "Questionnaire Successfully Added";
  }
} else if (isset($_GET['deleted']) && isset($_GET['id'])) {

  $id = User::returnValueGet('id');

  $admin->deleteRow('evaluation_of_activities', "id =  $id");

  $deleted = "Questionnaire Deleted";
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
    .disabled {
      pointer-events: none;
      color: gray;
      text-decoration: none;
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
            <h5>Evaluation of Activities</h5>
          </div>

          <nav class="org-list-nav">
            <ul>
              <?php
              $result = $admin->selectDistinct('student_org', 'name_of_org');
              while ($row = mysqli_fetch_assoc($result)) {
              ?>

                <li id="<?php echo $row['name_of_org']; ?>" onclick="window.location.href = 'admin-evaluation-of-activities.php?activeStudentOrg=<?php echo $row['name_of_org'] ?>';"><?php echo $row['name_of_org']; ?></li>

              <?php } ?>
            </ul>
          </nav>

          <form method="post" class="d-flex flex-column align-items-center mx-auto mb-4 border shadow rounded-3" style="max-width: 30rem;">
              <label class="form-label fw-bold" for="">Add Questionnaire</label>
              <textarea class="form-control mb-3" name="questionnaire" rows="3" required></textarea>

              <input class="btn btn-primary" type="submit" name="add-questionnaire" value="Add">
          </form>

          <?php
            if (isset($successfully_added)) {
              echo '
              <div class="alert alert-success" role="alert">
                '. $successfully_added .'
              </div>';
            } else if (isset($unsuccessfully_added)) {
              echo '
              <div class="alert alert-danger" role="alert">
                '. $unsuccessfully_added .'
              </div>';
            }  else if (isset($deleted)) {
              echo '
              <div class="alert alert-danger" role="alert">
                '. $deleted .'
              </div>';
            } else if (isset($_GET['edited'])) {
              echo '
              <div class="alert alert-success" role="alert">
                Questionnaire Edited Successfully
              </div>';
            } else if (isset($_GET['evaluationDeployed'])) {
              echo '
              <div class="alert alert-success" role="alert">
                Evaluation Deployed
              </div>';
            }
          ?>

          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Questionnaire</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $evaluation_questions = $admin->select('evaluation_of_activities', '*', ['name_of_org'=>User::returnValueGet('activeStudentOrg')]);

                  while ($row = mysqli_fetch_assoc($evaluation_questions)) {
                ?>
                <tr>
                  <td><?php echo $row['questionnaire']; ?></td>
                  <td>
                    <a class="btn btn-secondary <?php if($row['exp_date'] > $date_time_now){ echo 'disabled';} ?> " href="edit-questionnaire.php?id=<?php echo $row['id']; ?>&activeStudentOrg=<?php User::printGet('activeStudentOrg'); ?>">Edit</a>
                    <a class="btn btn-danger <?php if($row['exp_date'] > $date_time_now){ echo 'disabled';} ?> " href="admin-evaluation-of-activities.php?activeStudentOrg=<?php User::printGet('activeStudentOrg'); ?>&deleted&id=<?php echo $row['id']; ?>">Delete</a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

          <div class="d-flex justify-content-center">
            <a class="btn btn-outline-primary my-4" href="admin-deploy-evaluation.php?activeStudentOrg=<?php User::printGet('activeStudentOrg'); ?>">Deploy Evaluation Form</a>
          </div>

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


    var activeNav = document.getElementById('evaluation-of-activities')
    activeNav.classList.add('bg-dark-gray2');



  </script>
</body>

</html>


