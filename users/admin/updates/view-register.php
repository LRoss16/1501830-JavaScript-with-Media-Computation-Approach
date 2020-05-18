<?php //include config

require_once('../../../includes/config.php');



//if not logged in redirect to login page


if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 1) { header('Location: ../../teacher/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }

?>

<!doctype html>

<html lang="en">

<head>

  <meta charset="utf-8">

  <title>Admin - Edit strings Code Example</title>

  <meta http-equiv="refresh" content="900;url=../../logout.php"/>

  <link rel="stylesheet" href="../../../css/normalise.css">
<link rel="stylesheet" href="../../../css/learn.css">
  <link rel="stylesheet" href="../../../css/users.css">
  <link rel="stylesheet" href="../../css/textarea.css">


</head>

<body>


<div class="sidenav">



	<?php include('menu.php');?>

</div>

<div id="wrapper">


	<p><a href="register.php">Go Back</a></p>



	<h2>View Interest</h2>



	<?php

	//check for any errors

	if(isset($error)){

		foreach($error as $error){

			echo $error.'<br />';

		}

	}



		try {



			$stmt = $db->prepare('SELECT registerID, name, message FROM registerInterest WHERE registerID= :registerID') ;

			$stmt->execute(array(':registerID' => $_GET['id']));

			$row = $stmt->fetch(); 



		} catch(PDOException $e) {

		    echo $e->getMessage();

		}



	?>




		<input type='hidden' name='registerID' value='<?php echo $row['registerID'];?>'>

		<p><label>Name</label><br />

		<input type='text' name='name' readonly value='<?php echo $row['name'];?>'>

		<p><label>Message</label><br />

		<textarea name='message' readonly id='message' cols='60' rows='10'><?php echo $row['message'];?></textarea></p>


</div>



</body>

</html>