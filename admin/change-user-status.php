<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

date_default_timezone_set('Asia/Manila');
$date_time_now = date('Y-m-d') . 'T' . date('H:i');


session_start();

$admin = new database();

User::ifNotLogin('admin-username', '../login-account/login-admin.php');

$admin_id = User::returnValueSession('admin-id');

User::ifDeactivatedReturnTo($admin->select('admin', 'status', ['id'=>$admin_id]), '../logout.php?logout=admin');

$id = User::returnValueGet('id');
$user = User::returnValueGet('user');
$status = User::returnValueGet('status');


	if(isset($_POST['yes'])) {
		if($status == 'activated') {
      $admin->updateData($user, ['status'=>$status], ['id'=>$id]);
			header("location: admin-list-of-users.php?user=$user");
		} else if ($status == 'deactivated') {
      $admin->updateData($user, ['status'=>$status], ['id'=>$id]);
			header("location: admin-list-of-users.php?user=$user");
		}

	}else if (isset($_POST['no'])){
    header("location: admin-list-of-users.php?user=$user");

	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Deactivate Admin</title>
  <link rel="stylesheet" href="../css/bootstrap/bootstrap.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/admin.css?<?php echo time(); ?>">
</head>
<body>
	<form method="post" class="border border-dark mt-5 mx-auto px-5 py-3" style="max-width: 500px;">
		<h4 class="text-center"><?php echo $user; ?> will be <?php echo $status; ?>, Do you want to Continue? </h4>
		<div class="row">
			<input class="btn btn-success mb-2" type="submit" name="yes" value="Yes">
			<input class="btn btn-danger" type="submit" name="no" value="No" >
		</div>
	</form>
</body>
</html>