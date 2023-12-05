<?php

  include '../classes/database.php';
  include '../classes/message.php';
  include '../classes/user.php';
  session_start();
  
  $admin = new database();

  $activeStudentOrg = User::returnValueGet('activeStudentOrg');
  $schoolYear = User::returnValueGet('schoolYear');

  // if($_GET['activeStudentOrg'] == "" || $_GET['schoolYear'] == "" ) {
  //   header("location: ../admin/admin-report-to-ovpsas.php?activeStudentOrg=$activeStudentOrg&schoolYear=$schoolYear&noReport");
  // }

  $accomplishment_reports = $admin->select('accomplishment_reports', '*', ['name_of_org'=>User::returnValueGet('activeStudentOrg'), 'status'=>'ongoing', 'school_year'=>User::returnValueGet('schoolYear')]);

  if (mysqli_num_rows($accomplishment_reports) < 1) {
    header("location: ../admin/admin-report-to-ovpsas.php?activeStudentOrg=$activeStudentOrg&schoolYear=$schoolYear&noReport");

  }


?>


<!DOCTYPE html>
<html>

<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <script defer>
    function generatePDF() {
      const element = document.getElementById('container_content');
      var opt = {
        margin: 0,
        filename: 'chainsaw document.pdf',
        image: {
          type: 'jpeg',
          quality: 0.98
        },
        html2canvas: {
          scale: 2
        },
        jsPDF: {
          unit: 'in',
          format: 'letter',
          orientation: 'portrait'
        }
      };
      // Choose the element that our invoice is rendered in.
      
      html2pdf().set(opt).from(element).outputPdf().get('pdf').then(function (pdfObj) {
        pdfObj.autoPrint();
        window.open(pdfObj.output("bloburl"), "F")
      });

    }

  </script>
  <style>
    h1, h2, h3, h4, h5, h6, p {
      font-family: sans-serif;
      line-height: 0;
    }

    img {
      width: 100px;
      position: absolute;
      left: 180px;
    }

    .header-text h4 {
      text-align: center;
      font-weight: 100;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      margin-bottom: 10px;
    }

    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }

    .footer1 div {
      height: 60px;
      flex-grow: 1;
      line-height: normal;
    }

    .footer div {
      height: 60px;
      flex-grow: 1;
      margin: 0 10px;
      line-height: normal;
      border-top: 1px solid black;
    }
  </style>

</head>

<body>
  <div class="container_content" style="padding: 20px 20px 25px 20px" id="container_content">
    <div class="paper" style="height: 188vh;">
      <div class="header" style="display: flex; justify-content: center;">
        <img src="../images/msc_logo.png" alt="">
        <div class="header-text">
          <h4>MARINDUQUE STATE COLLEGE</h4>
          <h4><?php User::printGet('activeStudentOrg'); ?></h4>
        </div>
      </div>

      <h5 style="text-align: center;">ANNUAL ACCOMPLISHMENT REPORT</h5>
      <h5 style="text-align: center;">A.Y. <?php User::printGet('schoolYear') ?></h5>

      
      <table>
        <thead>
          <tr>
            <th>Planned Activity</th>
            <th>Purpose</th>
            <th>Date Accomplished</th>
            <th>Budget</th>
            <th>Remarks</th>
          </tr>
        </thead>
        <tbody>
        <?php 
          
          $accomplishment_reports = $admin->select('accomplishment_reports', '*', ['name_of_org'=>User::returnValueGet('activeStudentOrg'), 'status'=>'ongoing', 'school_year'=>User::returnValueGet('schoolYear')]);

          while ($row = mysqli_fetch_assoc($accomplishment_reports)) {
          ?>
        <tr>
            <td><?php echo $row['planned_activity']; ?></td>
            <th><?php echo $row['purpose']; ?></th>
            <th><?php echo $row['date_accomplished']; ?></th>
            <th><?php echo $row['budget']; ?></th>
            <th><?php echo $row['remarks']; ?></th>
          </tr>
          <?php } ?>
        </tbody>
      </table>



      <div class="footer1" style="display: flex; justify-content: center;">
        <div>Filed by:</div>
        <div>Attested by:</div>
        <div>Noted by:</div>
      </div>







      <div class="footer" style="display: flex; justify-content: center;">
      <?php 
        $secretary = $admin->select('officers', '*', ['org_name'=>User::returnValueGet('activeStudentOrg'), 'school_year'=>User::returnValueGet('schoolYear'), 'position'=>'Secretary']);
        while($secretary_result = mysqli_fetch_assoc($secretary)) {
      ?>
        <div>
          <h4><?php echo $secretary_result['first_name'] . " " . $secretary_result['last_name'] ?></h4>
          <p>Secretary, <?php User::printGet('activeStudentOrg') ?></p>
        </div>
        <?php }


          $president = $admin->select('officers', '*', ['org_name'=>User::returnValueGet('activeStudentOrg'), 'school_year'=>User::returnValueGet('schoolYear'), 'position'=>'President']);
          while($president_result = mysqli_fetch_assoc($president)) {
        ?>
        <div>
          <h4><?php echo $president_result['first_name'] . " " . $president_result['last_name'] ?></h4>
          <p>President, <?php User::printGet('activeStudentOrg') ?></p>
        </div>
        <?php }
          $adviser = $admin->select('officers', '*', ['org_name'=>User::returnValueGet('activeStudentOrg'), 'school_year'=>User::returnValueGet('schoolYear'), 'position'=>'Adviser']);

          while($adviser_result = mysqli_fetch_assoc($adviser)) {
        ?>
        <div>
          <h4><?php echo $adviser_result['first_name'] . " " . $adviser_result['last_name'] ?></h4>
          <p>Adviser, <?php User::printGet('activeStudentOrg') ?></p>
        </div>
      </div>
      
      <?php } ?>



    </div>
  </div>


<script>generatePDF();</script>

</body>

</html>