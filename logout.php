<?php

@include 'classes/user.php';

// destroy all the data that is being stored in the pages


switch ($_GET['logout']) {
  case 'admin':
    User::logout('admin-username');
    header('location: login-account/login-admin.php');
    break;
  case 'student':
    User::logout('student_id');
    header('location: login-account/login-student.php');
    break;
  case 'student-org':
    User::logout('name_of_org');
    header('location: login-account/login-student-org.php');
    break;
}
