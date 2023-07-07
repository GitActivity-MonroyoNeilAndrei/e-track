<?php

@include 'classes/user.php';

// destroy all the data that is being stored in the pages


switch ($_GET['logout']) {
  case 'admin':
    User::logout();
    header('location: login-account/login-admin.php');
    break;
  case 'student':
    User::logout();
    header('location: login-account/login-student.php');
    break;
  case 'student-org':
    User::logout();
    header('location: login-account/login-student-org.php');
    break;
}
