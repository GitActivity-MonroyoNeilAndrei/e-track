<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$admin = new database();

User::ifNotLogin('admin-username', '../login-account/login-admin.php');


if (!isset($_GET['activeStudentOrg'])) {
  $result = $admin->selectDistinct('student_org', 'name_of_org');

  $row = mysqli_fetch_assoc($result);
  header("location: admin-election.php?activeStudentOrg=$row[name_of_org]");
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
          <a href="#">My Profile</a>
          <a href="../logout.php?logout=admin">Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav style="position: sticky; top: 4vh;">
          <ul>
            <li onclick="window.location.href='admin-homepage.php'">Dashboard</li>
            <li onclick="window.location.href='admin-list-of-users.php'" class="mb-4 border-bottom border-dark">List of Users</li>
            <li onclick="window.location.href='admin-election.php'" class="bg-dark-gray2">Election</li>
            <li onclick="window.location.href='admin-monitor-election-result.php'" class="mb-4 border-bottom border-dark">Monitor Election Result </li>
            <li onclick="window.location.href='admin-student-organization.php'">Student Organization</li>
            <li onclick="window.location.href='admin-plan-of-activities.php'">Plan of Activities</li>
            <li onclick="window.location.href='admin-monitor-plan-of-activities.php'">Monitor Plan of Activities</li>
            <li onclick="window.location.href='admin-accomplishment-report.php'" class="mb-4 border-bottom border-dark">Accomplishment Report</li>
            <li onclick="window.location.href='admin-evaluation-of-activities.php'">Evaluation of Activities</li>
            <li onclick="window.location.href='admin-report-to-ovpsas.php'">Report to OVPSAS</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Deploy Ballot</h5>
          </div>
          <nav class="org-list-nav">
            <ul>
              <?php
              $result = $admin->selectDistinct('student_org', 'name_of_org');
              while ($row = mysqli_fetch_assoc($result)) {
              ?>

                <li id="<?php echo $row['name_of_org']; ?>" onclick="window.location.href = 'admin-election.php?activeStudentOrg=<?php echo $row['name_of_org'] ?>';"><?php echo $row['name_of_org']; ?></li>

              <?php } ?>
            </ul>
          </nav>
          <?php if (isset($_REQUEST['addCandidateSuccess'])) {
            Message::candidateAdded();
          } else if (isset($_REQUEST['editCandidateSuccess'])) {
            Message::candidateEdited();
          } ?>
          <div class="container-add-candidate">
            <a class="add-candidate-btn" href="admin-add-candidate.php?studentOrg=<?php User::printGet('activeStudentOrg'); ?>"><i class="fa-solid fa-plus"></i> Add Candidate</a>
            <h5 class="text-center py-1">School Year: 2023-2024</h5>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Position</td>
                  <th>First_name</td>
                  <th>Last_name</td>
                  <th>Year</td>
                  <th>Photo</td>
                  <th>Partylist</td>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $result = $admin->select('candidate', '*', ['org_name' => User::returnValueGet('activeStudentOrg')]);

                while ($row = mysqli_fetch_assoc($result)) {
                ?>

                  <tr>
                    <td><?php echo $row['position']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['year']; ?></td>
                    <td><a class="btn btn-secondary" href="../view-image.php?path=uploads/&imageUrl=<?php echo $row['photo_url']; ?>"><i class="fa-regular fa-eye"></i> View</a></td>
                    <td><?php echo $row['partylist']; ?></td>
                    <td>
                      <a class="btn btn-success" href="admin-edit-candidate.php?studentOrg=<?php echo User::printGet('activeStudentOrg'); ?>&candidateId=<?php echo $row['id']; ?>"><i class="fa-regular fa-pen-to-square"></i> Edit</a>
                      <a class="btn btn-danger" href="admin-delete-candidate.php?studentOrg=<?php echo User::printGet('activeStudentOrg'); ?>&candidateId=<?php echo $row['id']; ?>&photoUrl=<?php echo $row['photo_url']; ?>"><i class="fa-solid fa-user-minus"></i>
 Delete</a>

                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <button class="btn btn-primary d-block mx-auto" onclick="window.location.href='admin-deploy-ballot.php?orgName=<?php User::printGet('activeStudentOrg') ?>'">Deploy Ballot</button>
        </div>
      </div>
    </div>
  </div>


  <script defer>
    let activeLink = document.getElementById("<?php User::printGet('activeStudentOrg') ?>");
    activeLink.style.backgroundColor = "#3C9811";
    activeLink.style.color = "white";
  </script>
</body>

</html>