<?php
//This page allows teachers to change their passwords
require_once('../../includes/config.php');
$username =  $_SESSION['username'];

if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

if($_SESSION['memberType'] == 0) { header('Location: ../../admin/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }

?>

<!doctype html>

<html lang="en">

<head>

  <meta charset="utf-8">

  <title>Change Password</title>

  <meta http-equiv="refresh" content="900;url=../../logout.php"/>

  <link rel="stylesheet" href="../../css/normalise.css">
<link rel="stylesheet" href="../../css/learn.css">
 <link rel="stylesheet" href="../../css/users.css">


</head>

<body>


<div id="wrapper">

	<h2 align="center">Change Password</h2>

<p><a href="index.php">Go Back</a></p>

         <h3 align="center">Once you have changed your password, you will be taken back to the login page</h3>

<?php 


	//if form has been submitted process it

	if(isset($_POST['submit'])){
		

		//collect form data

		extract($_POST);


			if($currentPassword ==''){

				$error[] = 'Please enter the current password.';

			}

			if($password ==''){

				$error[] = 'Please enter the password.';

			}



			if($passwordConfirm ==''){

				$error[] = 'Please confirm the password.';

			}



			if($password != $passwordConfirm){

				$error[] = 'Passwords do not match.';

			}

		if(!isset($error)){
			
                  //check if current password field is correct
                         if (password_verify ($currentPassword, $oldPassword)) { 
			
             if(isset($password)){

			//hash new password
			$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

              try {            
					//update into database

					$stmt = $db->prepare('UPDATE users SET username = :username, password = :password, passwordChange = :passwordChange WHERE memberID = :memberID') ;

					$stmt->execute(array(

						':username' => $username,

						':password' => $hashedpassword,

						':passwordChange' => 0,

						':memberID' => $memberID

					));



				//redirect to login page

				header('Location: ../logout.php');

				exit;

			}catch(PDOException $e) {

			    echo $e->getMessage();				   
						
			}		
		}				
						
		} else {
           echo "password is incorrect";   
		}		   
		
		}

		}
	
	

	//check for any errors

	if(isset($error)){

		foreach($error as $error){

			echo '<p class="error">'.$error.'</p>';

		}

	}



		try {

//get the teachers details

			$stmt = $db->prepare('SELECT memberID, username, password, memberType FROM users WHERE username = :username') ;

			$stmt->execute(array(':username' => $username));

			$row = $stmt->fetch(); 



		} catch(PDOException $e) {

		    echo $e->getMessage();

		}



	?>



	<form action='' method='post' align="center">

		<input type='hidden' name='memberID' value='<?php echo $row['memberID'];?>'>

                 <input type='hidden' name='oldPassword' value='<?php echo $row['password'];?>'>     


		<p><label>Username</label><br />
		
		<input type='text' readonly name='username' value='<?php echo $row['username'];?>'></p>

		<p><label>Current Password</label><br />

		<input type='password' name='currentPassword' value='<?php if(isset($error)){ echo $_POST['currentPassword'];}?>'></p>


		<p><label>New Password</label><br />

		<input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'></p>



		<p><label>Confirm Password</label><br />

		<input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'></p>

	

		<p><input type='submit' name='submit' value='Update Account'></p>



	</form>



</div>



</body>

</html>	