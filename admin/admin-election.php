<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$admin = new database();

User::ifNotLogin('admin-username', '../login-account/login-user.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id'=>$admin_id]), '../logout.php?logout=admin');


if (!isset($_GET['activeStudentOrg'])) {
  $result = $admin->selectDistinct('student_org', 'name_of_org');

  $row = mysqli_fetch_assoc($result);
  header("location: admin-election.php?activeStudentOrg=$row[name_of_org]");
}

$status;
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
            <div class="d-flex justify-content-start flex-wrap">
              <a class="btn btn-success" href="admin-add-candidate.php?studentOrg=<?php User::printGet('activeStudentOrg'); ?>"><i class="fa-solid fa-plus"></i> Add Candidate</a>

              <a class="btn btn-outline-primary ms-2" href="admin-limit-winners.php?studentOrg=<?php User::printGet('activeStudentOrg'); ?>">Limit Candidate Winner</a>
            </div>

            <h5 class="text-center py-1">List of Candidate</h5>
          </div>

          <?php
            if (isset($_GET['ballotDeployed'])) {
              echo '
              <div class="alert alert-success" role="alert">
                Ballot Deployed
              </div>
              ';
            }
          ?>


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
                <?php
                $result = $admin->select('candidate', '*', ['org_name' => User::returnValueGet('activeStudentOrg')]);

                if ($result->num_rows == 0 ) {
                  echo '
                    <tr>
                      <td colspan="7">
                        <h3 class="text-center">No Candidate has been Added</h3>
                      </td>
                    </tr>
                  ';
                }


                while ($row = mysqli_fetch_assoc($result)) {
                  $status = $row['status'];
                ?>

                  <tr>
                    <td><?php echo $row['position']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['year']; ?></td>
                    <td><a class="btn btn-secondary" href="../view-image.php?path=uploads/&imageUrl=<?php echo $row['photo_url']; ?>"> View</a></td>
                    <td><?php echo $row['partylist']; ?></td>
                    <td>
                      <a class="btn btn-success <?php if ($row['status'] == 'deployed' || $row['status'] == "winner") {echo 'disabled';} ?>" href="admin-edit-candidate.php?studentOrg=<?php echo User::printGet('activeStudentOrg'); ?>&candidateId=<?php echo $row['id']; ?>"> Edit</a>
                      <a class="btn btn-danger <?php if ($row['status'] == 'deployed' || $row['status' == "winner"]) {echo 'disabled';} ?>" href="admin-delete-candidate.php?studentOrg=<?php echo User::printGet('activeStudentOrg'); ?>&candidateId=<?php echo $row['id']; ?>&photoUrl=<?php echo $row['photo_url']; ?>">Delete</a>

                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <button class="btn btn-primary d-block mx-auto <?php if ($status == 'deployed' || $status == "winner") {echo 'disabled';} ?> " onclick="window.location.href='admin-deploy-ballot.php?orgName=<?php User::printGet('activeStudentOrg') ?>'">Deploy Ballot</button>
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


    var activeNav = document.getElementById('election')
    activeNav.classList.add('bg-dark-gray2');


  </script>
</body>

</html>