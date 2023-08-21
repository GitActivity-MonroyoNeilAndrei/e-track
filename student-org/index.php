<?php 
  @include "../classes/user.php";

  session_start();

  User::ifNotLogin('student_org_name', '../login-account/login-student-org.php');
  User::ifLogin('student_org_name', 'student-org-homepage.php');


?>