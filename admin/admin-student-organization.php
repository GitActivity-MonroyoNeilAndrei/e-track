<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$admin = new database();


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
  <link rel="stylesheet" href="../css/admin.css?<?php echo time(); ?>">
  <style>
    .candidate-image {
      height: 100%;
      width: 100%;
    }

    .candidate-container {
      border: 1px solid black;
      width: 5rem;
      height: 5rem;
      border-radius: 35%;
      overflow: hidden;
      margin-bottom: .3rem;
    }

    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    h6,
    h5 {
      line-height: .7rem;
    }

    .candidate-row {
      display: flex;
      justify-content: space-evenly;
      max-width: 50rem;
      margin: auto;
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
        <button class="dropbtn"><?php User::printSession('admin-username'); ?></button>
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
            <li onclick="window.location.href='admin-dashboard.php'">Dashboard</li>
            <li onclick="window.location.href='admin-election.php'">Election</li>
            <li onclick="window.location.href='admin-monitor-election-result.php'" class="mb-4 border-bottom border-dark">Monitor Election Result </li>
            <li onclick="window.location.href='admin-student-organization.php'" class="bg-dark-gray2">Student Organization</li>
            <li onclick="window.location.href='admin-plan-of-activities.php'">Plan of Activities</li>
            <li onclick="window.location.href='admin-accomplishment-report.php'" class="mb-4 border-bottom border-dark">Accomplishment Report</li>
            <li onclick="window.location.href='admin-evaluation-of-activities.php'">Evaluation of Activities</li>
            <li onclick="window.location.href='admin-report-to-ovpsas.php'">Report to OVPSAS</li>
          </ul>
        </nav>
      </div>
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
          <h5 class="text-center mb-3">2023-2024</h5>



          

          <div class="candidate-row">
            <div class="container">
              <div class="candidate-container">
                <img class="candidate-image" src="" alt="">
              </div>
              <h5 class="fw-medium">tanga ka</h5>
              <h6 class="fst-italic">Adviser</h6>
            </div>
          </div>
          <div class="candidate-row">
            <div class="container">
              <div class="candidate-container">
                <img class="candidate-image" src="" alt="">
              </div>
              <h5 class="fw-medium">tanga ka</h5>
              <h6 class="fst-italic">President</h6>
            </div>
          </div>
          <div class="candidate-row">
            <div class="container">
              <div class="candidate-container">
                <img class="candidate-image" src="" alt="">
              </div>
              <h5 class="fw-medium">tanga ka</h5>
              <h6 class="fst-italic">Secretary</h6>
            </div>
            <div class="container">
              <div class="candidate-container">
                <img class="candidate-image" src="" alt="">
              </div>
              <h5 class="fw-medium">tanga ka</h5>
              <h6 class="fst-italic">Vice President</h6>
            </div>
            <div class="container">
              <div class="candidate-container">
                <img class="candidate-image" src="" alt="">
              </div>
              <h5 class="fw-medium">tanga ka</h5>
              <h6 class="fst-italic">Treasurer</h6>
            </div>
          </div>
          <div class="candidate-row">
            <div class="container">
              <div class="candidate-container">
                <img class="candidate-image" src="" alt="">
              </div>
              <h5 class="fw-medium">tanga ka</h5>
              <h6 class="fst-italic">Project Manager</h6>
            </div>
            <div class="container">
              <div class="candidate-container">
                <img class="candidate-image" src="" alt="">
              </div>
              <h5 class="fw-medium">tanga ka</h5>
              <h6 class="fst-italic">P.I.O.</h6>
            </div>
            <div class="container">
              <div class="candidate-container">
                <img class="candidate-image" src="" alt="">
              </div>
              <h5 class="fw-medium">tanga ka</h5>
              <h6 class="fst-italic">Auditor</h6>
            </div>
            <div class="container">
              <div class="candidate-container">
                <img class="candidate-image" src="" alt="">
              </div>
              <h5 class="fw-medium">tanga ka</h5>
              <h6 class="fst-italic">P.I.O.</h6>
            </div>
            <div class="container">
              <div class="candidate-container">
                <img class="candidate-image" src="" alt="">
              </div>
              <h5 class="fw-medium">tanga ka</h5>
              <h6 class="fst-italic">Project Manager</h6>
            </div>
          </div>
          <div class="candidate-row">
            <div class="container">
              <div class="candidate-container">
                <img class="candidate-image" src="" alt="">
              </div>
              <h5 class="fw-medium">tanga ka</h5>
              <h6 class="fst-italic">Sargeant at Arms</h6>
            </div>
            <div class="container">
              <div class="candidate-container">
                <img class="candidate-image" src="" alt="">
              </div>
              <h5 class="fw-medium">tanga ka</h5>
              <h6 class="fst-italic">Muse</h6>
            </div>
            <div class="container">
              <div class="candidate-container">
                <img class="candidate-image" src="" alt="">
              </div>
              <h5 class="fw-medium">tanga ka</h5>
              <h6 class="fst-italic">Escort</h6>
            </div>
            <div class="container">
              <div class="candidate-container">
                <img class="candidate-image" src="" alt="">
              </div>
              <h5 class="fw-medium">tanga ka</h5>
              <h6 class="fst-italic">Sargeant at Arms</h6>
            </div>
          </div>
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