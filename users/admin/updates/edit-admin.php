<?php //include config

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

<head>

  <meta charset="utf-8">

  <title>Admin - Edit User</title>

  <meta http-equiv="refresh" content="900;url=../../logout.php"/>

  <link rel="stylesheet" href="../../../css/normalise.css">
<link rel="stylesheet" href="../../../css/learn.css">
 <link rel="stylesheet" href="../../../css/users.css">


</head>

<body>



<div class="sidenav">


<?php include('menu.php');?>

</div>

<div id="wrapper">


	<p><a href="users.php">Go Back</a></p>


	<h2>Edit User</h2>

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

			$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

                     $checkPassword =  password_hash($currentPassword, PASSWORD_BCRYPT);
			
                         if (password_verify ($currentPassword, $oldPassword)) { 
			
             if(isset($password)){

			$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

              try {            
					//update into database

					$stmt = $db->prepare('UPDATE users SET username = :username, password = :password WHERE memberID = :memberID') ;

					$stmt->execute(array(

						':username' => $username,

						':password' => $hashedpassword,

						':memberID' => $memberID

					));



				//redirect to users page

				header('Location: users.php?action=updated');

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



			$stmt = $db->prepare('SELECT memberID, username, password, memberType FROM users WHERE memberID = :memberID') ;

			$stmt->execute(array(':memberID' => $_GET['id']));

			$row = $stmt->fetch(); 



		} catch(PDOException $e) {

		    echo $e->getMessage();

		}



	?>



	<form action='' method='post'>

		<input type='hidden' name='memberID' value='<?php echo $row['memberID'];?>'>

                 <input type='hidden' name='oldPassword' value='<?php echo $row['password'];?>'>     


		<p><label>Username</label><br />
		


		<input type='text' readonly name='username' value='<?php echo $row['username'];?>'></p>

		<p><label>Current Password</label><br />

		<input type='password' name='currentPassword' value='<?php if(isset($error)){ echo $_POST['currentPassword'];}?>'></p>


		<p><label>Password (only to change)</label><br />

		<input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'></p>



		<p><label>Confirm Password</label><br />

		<input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'></p>

	

		<p><input type='submit' name='submit' value='Update User'></p>



	</form>



</div>



</body>

</html>	