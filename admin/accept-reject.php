<?php
  include "../classes/database.php";
  include "../classes/message.php";
  include "../classes/user.php";

  session_start();

  $admin = new database();

  $activeStudentOrg = User::returnValueGet('activeStudentOrg');

if(isset($_POST['yes'])) {
  if (isset($_GET['acceptActivity'])) {
    $admin->updateData('plan_of_activities', ['status'=>'ongoing'], ['name_of_org'=>User::returnValueGet('activeStudentOrg'), 'status'=>'submitted']);
    header("location: admin-plan-of-activities.php?activeStudentOrg=$activeStudentOrg&acceptAll");
  } else if (isset($_GET['rejectActivity'])) {
    $admin->updateData('plan_of_activities', ['status'=>'returned'], ['name_of_org'=>User::returnValueGet('activeStudentOrg'), 'status'=>'submitted']);
    header("location: admin-plan-of-activities.php?activeStudentOrg=$activeStudentOrg&returnedAll");
  } else if (isset($_GET['acceptReport'])) {
    $admin->updateData('accomplishment_reports', ['status'=>'ongoing'], ['name_of_org'=>User::returnValueGet('activeStudentOrg'), 'status'=>'submitted']);
    header("location: admin-plan-of-activities.php?activeStudentOrg=$activeStudentOrg&acceptAll");
  } else if (isset($_GET['rejectReport'])) {
    $admin->updateData('accomplishment_reports', ['status'=>'returned'], ['name_of_org'=>User::returnValueGet('activeStudentOrg'), 'status'=>'submitted']);
    header("location: admin-plan-of-activities.php?activeStudentOrg=$activeStudentOrg&returnedAll");
  }

}else if (isset($_POST['no'])) {
  header("location: admin-plan-of-activities.php?activeStudentOrg=$activeStudentOrg");
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
			<input class="btn btn-success mb-2" type="submit" name="yes" value="Yes">
			<input class="btn btn-danger" type="submit" name="no" value="No" >
		</div>
	</form>
</body>
</html>