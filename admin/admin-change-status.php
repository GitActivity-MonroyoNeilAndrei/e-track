<?php 

include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$admin = new database();

User::ifNotLogin('admin-username', '../login-account/login-user.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id'=>$admin_id]), '../logout.php?logout=admin');

$id = User::returnValueGet('id');
$status = User::returnValueGet('status');
$name_of_org = User::returnValueGet('studentOrg');
$path = User::returnValueGet('path');

if(isset($_POST['yes'])) {

	if(isset($_POST['remark'])) {
		$admin->updateData(User::returnValueGet('type'), ['status'=>$status, 'remark'=>$_POST['remark']], ['id'=>$id, 'name_of_org'=>$name_of_org]);
	} else {
		$admin->updateData(User::returnValueGet('type'), ['status'=>$status], ['id'=>$id, 'name_of_org'=>$name_of_org]);
	}


	if ($path == "admin-plan-of-activities.php" || $path == "admin-accomplishment-report.php") {
		if ($status == "ongoing") {
		  header("location: $path?activeStudentOrg=$name_of_org&accept");
		} else if ($status = "returned") {
  		header("location: $path?activeStudentOrg=$name_of_org&reject");
		}
	} else {
		header("location: $path?activeStudentOrg=$name_of_org");
	}

} else if (isset($_POST['no'])) {
  header("location: $path?activeStudentOrg=$name_of_org");
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
	<form method="post" class="border border-dark rounded-3 shadow mt-5 mx-auto px-5 py-3" style="max-width: 500px;">
		<h4 class="text-center">Are You Sure You want to change status of Plan Activity?</h4>
		<div class="row">
			<?php
				if ($_GET['status'] == 'returned') {
					echo '
						<label class="form-label">Remarks:</label>
						<input class="form-control mb-3" type="text" name="remark" required>
					';
				}
			?>
			

			<input class="btn btn-success mb-2" type="submit" name="yes" value="Yes">
			<input class="btn btn-danger" type="submit" name="no" value="No" >
		</div>
	</form>
</body>
</html>