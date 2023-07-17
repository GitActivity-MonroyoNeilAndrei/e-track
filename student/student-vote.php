<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$student = new database();

if (!isset($_SESSION['student_id'])) {
  header('login-student.php');
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
  <link rel="stylesheet" href="../css/bootstrap.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/student.css?<?php echo time(); ?>">
</head>

<body>
  <div class="body">
    <div class="header bg-green-1">
      <div class="d-flex align-items-center"><img class="header-logo" src="../images/msc_logo.png" alt="msc logo">
        <h3 class=" header-texts">MARINDUQUE STATE COLLEGE</h3>
      </div>
      <div class="dropdown">
        <button class="dropbtn"></button>
        <div class="dropdown-content">
          <a href="#">My Profile</a>
          <a href="../logout.php?logout=student">Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav style="position: sticky; top: 4vh;">
          <ul>
            <li onclick="window.location.href='student-vote.php'" class="bg-dark-gray2">Vote</li>
            <li onclick="window.location.href='student-view-results.php'">View Election Results</li>
            <li onclick="window.location.href='student-monitor-activities.php'">Monitor Activities</li>

          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5 class="text-start">Vote</h5>
          </div>
          <nav class="org-list-nav">
            <ul>

            </ul>
          </nav>

          <div class="container-add-candidate">
            <h5 class="text-center fw-bold py-1">Available Election</h5>
          </div>

          <?php if(isset($_REQUEST['voteSuccessfully'])) {Message::voteSuccessfully();} ?>

          <div class="table-responsive m-auto" style="max-width: 30rem;">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Organization Name</th>
                  <th>Expiration Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $result = $student->select('student', '*', ['student_id' => User::returnValueSession('student_id')]);

                $row = mysqli_fetch_assoc($result);
                // var_dump($row);
                if ($row['can_vote'] == NULL || $row['can_vote'] == "") {
                  echo "<h4 class='text-center'>No Election Available</h4>";
                }else {
                ?>

                <td><?php echo $row['can_vote']; ?></td>
                <td>Expiry Date</td>
                <td><a href="student-vote-homepage.php?can_vote=<?php echo $row['can_vote']; ?>" class="btn btn-primary">Vote</a></td>
                  
                <?php } ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</body>

</html>