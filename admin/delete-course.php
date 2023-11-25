<?php
  include '../classes/database.php';
  include '../classes/message.php';
  include '../classes/user.php';

  $admin = new database();

  $where = 'id =' . User::returnValueGet('candidateId');
  $admin->delete('candidate', $where);

  $student_org = User::returnValueGet('studentOrg');
  header("location: admin-election.php?activeStudentOrg=$student_org&delete=success"); 

  $admin->deleteImage('photoUrl', '../uploads/')

?>