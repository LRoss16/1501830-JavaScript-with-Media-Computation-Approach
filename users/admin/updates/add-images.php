<?php

require_once('../../../includes/config.php');
$username =  $_SESSION['username'];


//if not logged in redirect to login page

if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 1) { header('Location: ../../teacher/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }


?>

<!doctype html>

<html lang="en">

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta http-equiv="refresh" content="900;url=../../logout.php"/>

<head>

  <meta charset="utf-8">

  <title>Admin</title>

  <link rel="stylesheet" href="../../../css/normalise.css">
  <link rel="stylesheet" href="../../../css/learn.css">
  <link rel="stylesheet" href="../../../css/users.css">


</head>

<body>


<div class="sidenav">

<?php include('menu.php');?>
</div>


	<div id="wrapper">


	<p><a href="images.php">Go Back</a></p>

	<h1>Add Image</h1>


            <form action='imageUpload.php' method='post' enctype="multipart/form-data">

	

	<input type='hidden' name='id' value='<?php echo $row['imageID'];?>'>



		<p><label>Title</label><br />

		<input type='text' name='image_title' required value='<?php if(isset($error)){ echo $_POST['image_title'];}?>'></p>



		<p><label>Image</label><br />

		<input type="file" name='image' id="image" required value='<?php if(isset($error)){ echo $_POST['image'];}?>'></p>



		<p><input type='submit' name='submit' value='Submit'></p>



	</form>

</div>

</body>

</html>