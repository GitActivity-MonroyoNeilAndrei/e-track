<?php 

include "../classes/database.php";
include "../classes/message.php";
include "../classes/user.php";

session_start();

$student_org = new database();


$id = User::returnValueGet('id');
$status = User::returnValueGet('status');
$name_of_org = User::returnValueSession('name_of_org');

if(isset($_POST['yes'])) {

		if($status == 'deactivated') {
			$student_org->updateData('student', ['status'=>'deactivated'], ['id'=>$id]);
		} else if ($status == 'activated') {
			$student_org->updateData('student', ['status'=>'activated'], ['id'=>$id]);
		}

		header("location: student-org-list-of-enrollees.php");


} else if (isset($_POST['no'])) {
  header("location: student-org-list-of-enrollees.php");
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