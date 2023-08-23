<?php 

include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

date_default_timezone_set('Asia/Manila');
$date_now = date('Y-m-d');

$student_org = new database();

User::ifNotLogin('name_of_org', '../login-account/login-student-org.php');

$id = User::returnValueGet('id');
$name_of_org = User::returnValueSession('name_of_org');
if(isset($_POST['yes'])) {
	if(isset($_GET['id'])){
		$student_org->updateData('plan_of_activities',['status'=>'submitted', 'date_submitted'=>$date_now], ['id'=>$id] );
  	header('location: student-org-plan-of-activities.php');
	} else {
		$student_org->advanceUpdateData('plan_of_activities',['status'=>'submitted', 'date_submitted'=>$date_now], "name_of_org = '$name_of_org' AND (status = 'draft' OR status = 'returned') ");
  	header('location: student-org-plan-of-activities.php');
	}
  
} else if (isset($_POST['no'])) {
  header('location: student-org-plan-of-activities.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Delete Chainsaw Store</title>
  <link rel="stylesheet" href="../css/bootstrap/bootstrap.css?<?php echo time();?>">
</head>
<body>
	<form method="post" class="border border-dark mt-5 mx-auto px-5 py-3" style="max-width: 500px;">
		<h4 class="text-center">Are You Sure You want to Submit this Plan of Activity?</h4>
		<div class="row">
			<input class="btn btn-success mb-2" type="submit" name="yes" value="Yes">
			<input class="btn btn-danger" type="submit" name="no" value="No" >
		</div>
	</form>
</body>
</html>