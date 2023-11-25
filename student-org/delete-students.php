<?php
include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";


session_start();

$student_org = new database();

$id = User::returnValueGet('id');

if(isset($_POST['no'])) {
  header('location: student-org-list-of-enrollees.php');
} else if (isset($_POST['yes'])) {
  $student_org->delete('student', "id = $id");
  header('location: student-org-list-of-enrollees.php');
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
		<h4 class="text-center">Are Sure you Want to Delete This Student?</h4>
		<div class="row">
			<input class="btn btn-success mb-2" type="submit" name="yes" value="Yes">
			<input class="btn btn-danger" type="submit" name="no" value="No" >
		</div>
	</form>
</body>
</html>