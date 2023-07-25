<?php
include "classes/database.php";
include "classes/message.php";
include "classes/user.php";

session_start();

$user = new database();

$officers = $user->select('candidate', '*', ['org_name'=>User::returnValueGet('studentOrg'), 'status'=>'winner']);

while($row = mysqli_fetch_assoc($officers)) {
  $user->insertData('officers', ['position'=>$row['position'], 'first_name'=>$row['first_name'], 'last_name'=>$row['last_name'], 'year'=>$row['year'], 'photo_url'=>$row['photo_url'], 'partylist'=>$row['partylist'], 'org_name'=>$row['org_name'], 'school_year'=>$row['school_year']]);
}

$delete_candidate = $user->select('candidate', '*', ['org_name'=>User::returnValueGet('studentOrg')]);

while($row = mysqli_fetch_assoc($delete_candidate)) {
  $user->delete('candidate', "id = $row[id]");
}


$studentOrg = User::returnValueGet('studentOrg');
header("location: admin/admin-monitor-election-result.php?activeStudentOrg=$studentOrg");

?>