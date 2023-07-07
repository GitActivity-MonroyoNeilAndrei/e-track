<?php
include "classes/user.php";

session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/bootstrap.css?<?php echo time(); ?>">
</head>
<body>
  <button class="btn btn-danger" style="position: fixed; top: 1rem; left: 1rem; font-size: 1.5vw;" onclick="history.back();">Back</button>
  <img class="d-block mx-auto" style="max-width: 90vw;" src="<?php  User::printGet('path') . User::printGet('imageUrl'); ?>" alt="Image">
</body>
</html>