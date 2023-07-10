<?php
  include "../classes/database.php";
  include "../classes/message.php";
  include "../classes/user.php";
  
  session_start();
  
  $student = new database();




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

      <div class="vote-section" style="position: sticky; top: 0; height: 100vh;">
        <h4>President</h4>
        <div class="vote-candidate">
          <input class="form-check-input" type="checkbox">
          <label for="">Neil Andrei Monroyo</label>
        </div>
      </div>

      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Voting Ballot</h5>
          </div>
          <h6>Voting will expired in: july 20 2023</h6>
          <div class="container-add-candidate">
            <h2 class="text-center py-1 fw-bold">Vote Responsible</h2>
          </div>
          <?php
            $result = $student->select('candidate', '*', )

          ?>
          
          <div class="candidate-container">
            <h4>President</h4>
            <div class="bg-secondary bg-gradient ">
              <div class="candidate-image">
                <img style="height: 100%; width: 100%;" src="../uploads/michael_iconic_freethrow_dunk.jpg" alt="candidate image">
              </div>
            </div>
            <h4 class="mt-5">Candidate No. 1</h4>
            <h5 class="fw-bold">Neil  Andrei Monroyo</h5>
            <h5>Partylist</h5>
            <p class="candidate-description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, aperiam. Aperiam eius nihil optio accusantium nobis quam. Veritatis, amet animi itaque dignissimos facere harum totam mollitia nihil? Veniam, debitis aliquam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem, consequuntur autem? In dolorem porro hic incidunt, dolor itaque soluta rerum officiis, ipsum molestias odit quas neque, praesentium voluptatum nihil explicabo.</p>
          </div>

          <div class="candidate-container">
            <div class="bg-secondary bg-gradient ">
              <div class="candidate-image">
                <img style="width: 100%; height: 100%;"  src="" alt="candidate image">
              </div>
            </div>
            <h4 class=" mt-5">Candidate No. 2</h4>
            <h5 class=" fw-bold">Neil  Andrei Monroyo</h5>
            <h5 class="">Partylist</h5>
            <p class="candidate-description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, aperiam. Aperiam eius nihil optio accusantium nobis quam. Veritatis, amet animi itaque dignissimos facere harum totam mollitia nihil? Veniam, debitis aliquam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem, consequuntur autem? In dolorem porro hic incidunt, dolor itaque soluta rerum officiis, ipsum molestias odit quas neque, praesentium voluptatum nihil explicabo.</p>

          </div>

        </div>
      </div>
    </div>
  </div>
</body>

</html>