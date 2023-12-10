<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";


session_start();
date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');

$student_org= new database();


User::ifNotLogin('name_of_org', '../login-account/login-user.php');


$student_org_id = User::returnValueSession('student-org-id');

User::ifDeactivatedReturnTo($student_org->select('student_org', 'status', ['id'=>$student_org_id]), '../logout.php?logout=student');


function returnDate() {
  $admin = new database();

  $name_of_org = User::returnValueSession('name_of_org');

  $activity_date = $admin->advanceSelect('plan_of_activities', '*', "status = 'ongoing' AND name_of_org = '$name_of_org'");

  $date = "";

  $first_time = true;
  while($row = mysqli_fetch_assoc($activity_date)) {
    if($first_time) {
      $date .= "$row[date]";
      $first_time = false;
    }else {
    $date .= ",$row[date]";
    }
  }
  return $date;
}

function returnNameOfAct() {
  $admin = new database();

  $name_of_org = User::returnValueSession('name_of_org');

  $activity_date = $admin->advanceSelect('plan_of_activities', '*', "status = 'ongoing' AND name_of_org = '$name_of_org'");

  $nameOfAct = "";

  $first_time = true;

  while($row = mysqli_fetch_assoc($activity_date)) {
    if($first_time) {
    $nameOfAct .= "$row[name_of_activity]";
    $first_time = false;
    }else {
    $nameOfAct .= ",$row[name_of_activity]";

    }
  }
  return $nameOfAct;

}

$date = returnDate();
$nameOfAct = returnNameOfAct();

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
  <link rel="stylesheet" href="../css/student.css?<?php echo time(); ?>">
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
          <a href="student-org-edit-profile.php"><i class="fa-solid fa-address-card"></i> My Profile</a>
          <a href="../logout.php?logout=student"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
    <?php
      require 'student-org-navigations.php';
    ?>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h5>Monitor Plan of Activities</h5>
          </div>
          <nav class="org-list-nav">
            <ul>

            </ul>
          </nav>

          <div class="calendar-container mx-auto">
            <header class="calendar-header">
              <p class="calendar-current-date"></p>
              <div class="calendar-navigation">
                <span id="calendar-prev"
                  class="material-symbols-rounded">
                  <i class="fa-solid fa-arrow-left"></i>
                </span>
                <span id="calendar-next"
                  class="material-symbols-rounded">
                  <i class="fa-solid fa-arrow-right"></i>
                </span>
              </div>
            </header>

            <div class="calendar-body">
              <ul class="calendar-weekdays mx-2 mb-0">
                <li>Sun</li>
                <li>Mon</li>
                <li>Tue</li>
                <li>Wed</li>
                <li>Thu</li>
                <li>Fri</li>
                <li>Sat</li>
              </ul>
              <ul class="calendar-dates mx-2 mb-3"></ul>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <?php
    require 'student-org-footer.php';
  ?>
  
  <script>
    let date = new Date();
    let year = date.getFullYear();
    let month = date.getMonth();

    var activeNav = document.getElementById('monitor-activity')
    activeNav.classList.add('bg-dark-gray2');

    function addZeroToNum(month) {
      if(month <= 9){
        return '0' + month.toString();
      } else {
        return month;
      }
    }

    const day = document.querySelector(".calendar-dates");

    const currdate = document.querySelector(".calendar-current-date");

    const prenexIcons = document.querySelectorAll(".calendar-navigation span");

    // Array of month names
    const months = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];

    // Function to generate the calendar
    const manipulate = () => {
      // Get the first day of the month
      let dayone = new Date(year, month, 1).getDay(); // value 2

      // Get the last date of the month
      let lastdate = new Date(year, month + 1, 0).getDate(); // value 31

      // Get the day of the last date of the month
      let dayend = new Date(year, month, lastdate).getDay(); // value: 4

      // Get the last date of the previous month
      let monthlastdate = new Date(year, month, 0).getDate(); // value: 31



      var calendarDate = decodeURIComponent("<?php echo rawurlencode($date); ?>");
      var nameOfAct = decodeURIComponent("<?php echo rawurlencode($nameOfAct); ?>");

      calendarDate = calendarDate.split(",");
      nameOfAct = nameOfAct.split(",");



      // Variable to store the generated calendar HTML
      let lit = "";

      // Loop to add the last dates of the previous month
      for (let i = dayone; i > 0; i--) {
        lit += `<li class="inactive">${monthlastdate - i + 1}</li>`;
      }

      // Loop to add the dates of the current month
      for (let i = 1; i <= lastdate; i++) {
        // Check if the current date is today
        let isToday =
          i === date.getDate() &&
          month === new Date().getMonth() &&
          year === new Date().getFullYear()
            ? "active"
            : "";

        var currentDate = `${year}-${addZeroToNum(month+1) }-${addZeroToNum(i)}`;
        
        var first_time = true;
        var eventNotAdded = true;
        

        for(let x = 0; x < calendarDate.length; x++) {
          if(currentDate == calendarDate[x] && first_time) {
            lit += `<li class="${isToday}">${i}
              <div>${nameOfAct[x]}</div>`

            eventNotAdded = false;
            first_time = false;
          } else if(currentDate == calendarDate[x]) {
            lit += `<div>${nameOfAct[x]}</div>`;
          }
        }

        if (eventNotAdded) {
          lit += `<li class="${isToday}">${i}</li>`;
          first_time = false;
        } else {
          lit += `</li>`;
        }
      }

      // Loop to add the first dates of the next month
      for (let i = dayend; i < 6; i++) {
        lit += `<li class="inactive">${i - dayend + 1}</li>`;
      }

      // Update the text of the current date element
      // with the formatted current month and year
      currdate.innerText = `${months[month]} ${year}`;

      // update the HTML of the dates element
      // with the generated calendar
      day.innerHTML = lit;
    };

    manipulate();

    // Attach a click event listener to each icon
    prenexIcons.forEach((icon) => {
      // When an icon is clicked
      icon.addEventListener("click", () => {
        // Check if the icon is "calendar-prev"
        // or "calendar-next"
        month = icon.id === "calendar-prev" ? month - 1 : month + 1;

        // Check if the month is out of range
        if (month < 0 || month > 11) {
          // Set the date to the first day of the
          // month with the new year
          date = new Date(year, month, new Date().getDate());

          // Set the year to the new year
          year = date.getFullYear();

          // Set the month to the new month
          month = date.getMonth();
        } else {
          // Set the date to the current date
          date = new Date();
        }

        // Call the manipulate function to
        // update the calendar display
        manipulate();
      });
    });

  </script>
  <link rel="stylesheet" href="../css/calendar.css?<?php echo time(); ?>">

  <script>
    var activeNav = document.getElementById('monitor-activity')
    activeNav.classList.add('bg-dark-gray2');
  </script>
</body>

</html>