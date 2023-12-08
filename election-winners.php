<?php
include "classes/database.php";
include "classes/message.php";
include "classes/user.php";

session_start();

$user = new database();

$studentOrg = User::returnValueGet('studentOrg');

// selects tha winners in the candidate table
$officers1 = $user->select('candidate', '*', ['org_name'=>$studentOrg, 'status'=>'winner']);

$row1 = mysqli_fetch_assoc($officers1);

$user->deleteRow('officers', "org_name = '$studentOrg' AND school_year = '$row1[school_year]'");

$officers2 = $user->select('candidate', '*', ['org_name'=>$studentOrg, 'status'=>'winner']);


// insert to the officers table the winners
while($row = mysqli_fetch_assoc($officers2)) {


  $user->insertData('officers', ['position'=>$row['position'], 'first_name'=>$row['first_name'], 'last_name'=>$row['last_name'], 'year'=>$row['year'], 'photo_url'=>$row['photo_url'], 'partylist'=>$row['partylist'], 'org_name'=>$row['org_name'], 'school_year'=>$row['school_year']]);
}

// select the candidates in the candidates table
$delete_candidate = $user->select('candidate', '*', ['org_name'=>$studentOrg]);

// then delete them
while($row = mysqli_fetch_assoc($delete_candidate)) {
  $user->delete('candidate', "id = $row[id]");
}


// redirect to the admin-monitor-election-result page
header("location: admin/admin-monitor-election-result.php?activeStudentOrg=$studentOrg&resultReleased");

?>