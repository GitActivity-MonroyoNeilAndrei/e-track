<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');


session_start();

$student_org = new database();

User::ifNotLogin('name_of_org', '../login-account/login-student-org.php');

$student_org_id = User::returnValueSession('student-org-id');

User::ifDeactivatedReturnTo($student_org->select('student_org', 'status', ['id'=>$student_org_id]), '../logout.php?logout=student-org');


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
        <button class="dropbtn"><i class="fa-solid fa-user"></i> <?php User::printSession('name_of_org'); ?></button>
        <div class="dropdown-content">
          <a href="#">My Profile</a>
          <a href="../logout.php?logout=student-org">Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav style="position: sticky; top: 4vh;">
          <ul>
            <li onclick="window.location.href='student-org-homepage.php'">Dashboard</li>
            <li onclick="window.location.href='student-org-monitor-election.php'" class="mb-4 border-bottom border-dark">Monitor Election Result </li>
            <li onclick="window.location.href='student-org-plan-of-activities.php'" class="bg-dark-gray2">Plan of Activities</li>
            <li onclick="window.location.href='student-org-accomplishment-report.php'" class="mb-4 border-bottom border-dark">Accomplishment Report</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Submit Plan of Activity</h5>
          </div>
          <h3 class="text-center">Plan of Activities</h3>
          <a class="btn btn-primary mb-3" href="add-plan-of-activity.php"><i class="fa-solid fa-plus"></i> Add Plan</a>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Name of Activity</th>
                  <th>Date</th>
                  <th>Venue</th>
                  <th>Sponsor's/Collaborators</th>
                  <th>Nature of Activity</th>
                  <th>Purpose</th>
                  <th>Beneficiaries</th>
                  <th>Target Output</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $name_of_org = User::returnValueSession('name_of_org');

                $plan_of_activities = $student_org->advanceSelect('plan_of_activities', '*', "name_of_org = '$name_of_org' AND (status = 'draft' OR status = 'returned')");

                 while ($row = mysqli_fetch_assoc($plan_of_activities)) {
                ?>
                <tr>
                  <td><?php echo $row['name_of_activity']; ?></td>
                  <td><?php echo $row['date']; ?></td>
                  <td><?php echo $row['venue']; ?></td>
                  <td><?php echo $row['sponsors']; ?></td>
                  <td><?php echo $row['nature_of_activity']; ?></td>
                  <td><?php echo $row['purpose']; ?></td>
                  <td><?php echo $row['beneficiaries']; ?></td>
                  <td><?php echo $row['target_output']; ?></td>
                  <td><?php echo $row['status']; ?></td>
                  <td>
                    <a class="btn btn-secondary mb-2" href="edit-plan-of-activity.php?id=<?php echo $row['id']; ?>"><i class="fa-regular fa-pen-to-square"></i> Edit</a>
                    <a class="btn btn-success mb-2" href="submit-plan-of-activity.php?id=<?php echo $row['id']; ?>">Submit</a>
                    <a class="btn btn-danger mb-2" href="delete-plan-of-activity.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-trash"></i> Delete</a>
                  </td>
                </tr>

                <?php } ?>
              </tbody>
            </table>
          </div> <!-- table responsive -->

          <div class="d-flex justify-content-center">
            <a class="btn btn-success" href="submit-plan-of-activity.php"><i class="fa-solid fa-arrow-right"></i> Submit All</a>
          </div>

        </div>
      </div>
    </div>

  </div>

  <script defer>
    let activeLink = document.getElementById("<?php User::printGet('user'); ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";
  </script>
</body>

</html>