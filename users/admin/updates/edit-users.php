<?php

//this page allows the admin to edit the user details
 //include config
require_once('../../../includes/config.php');
$username =  $_SESSION['username'];

//if not logged in redirect to login page

if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 1) { header('Location: ../../teacher/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';

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

		try {

//get the user's details

			$stmt = $db->prepare('SELECT memberID, username, memberType, teacher FROM users WHERE memberID = :memberID') ;

			$stmt->execute(array(':memberID' => $_GET['id']));

			$row = $stmt->fetch(); 



		} catch(PDOException $e) {

		    echo $e->getMessage();

		}

//if editing student display the teachers they could have
if ($row['memberType'] == 2) {?>

<div align="right">List of available teachers to choose from</div>

<p align="right">
<?php } ?>

	
	<?php 

if ($row['memberType'] == 2) {



	try {



			$stmt = $db->query('SELECT username FROM users WHERE memberType = 1');

			while($row = $stmt->fetch()){

			

				echo $row['username']. "<br><br>";
				$teacher = $row['username'];
				
			}



		} catch(PDOException $e) {

		    echo $e->getMessage();

		}

}
		
	?>



</p>


<?php

		try {


//get user details
			$stmt = $db->prepare('SELECT memberID, username, memberType, teacher FROM users WHERE memberID = :memberID') ;

			$stmt->execute(array(':memberID' => $_GET['id']));

			$row = $stmt->fetch(); 



		} catch(PDOException $e) {

		    echo $e->getMessage();

		}


	//if form has been submitted process it

	if(isset($_POST['submit'])){



		//collect form data

		extract($_POST);



		if($username ==''){

			$error[] = 'Please enter the username.';

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

		if ($row['memberType'] == 2) {				

		if($teacher==''){

		$error[] = 'Please enter the teacher username for the student.';

		}
}


		if(!isset($error)){

		if ($row['memberType'] == 2) {	

			$query = $db->prepare( "SELECT `username` FROM `users` WHERE memberType = 1 AND username = :teacher" );
                        
                           $query->execute(array(

			 ':teacher' => $teacher

                   ));

			if( $query->rowCount() == 0 ) { # If rows are found for query

			echo "There is no teacher with this username, please enter one of the usernames shown on the right";

		}


	else {

          
		 try {

 

				if(isset($password)){

			//hash password

					$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);



					//update into database

					$stmt = $db->prepare('UPDATE users SET username = :username, password = :password, teacher = :teacher, passwordChange = :passwordChange WHERE memberID = :memberID') ;

					$stmt->execute(array(

						':username' => $username,

						':password' => $hashedpassword,
						
						':teacher' => $teacher,

						':passwordChange' => 1,

						':memberID' => $memberID

					));


				} 

//inform user of password being changed


              $message  = "<html><body>";


   
$message .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";
   
$message .= "<tr><td>";
   
$message .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:650px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";
    
$message .= "<thead>
  <tr height='80'>
  <th colspan='4' style='background-color:#f5f5f5; border-bottom:solid 1px #bdbdbd; font-family:Verdana, Geneva, sans-serif; color:#000000; font-size: 27px;' >Your Account</th>

  </tr>
             </thead>";
    
$message .= "<tbody>
       <tr height='80'>
       <td colspan='4' align='center' style='background-color:#f5f5f5; border-bottom:solid 1px #bdbdbd; font-size: 18px; '>
       <label>Your password has been reset</label> <BR />
	   <label>Your new password is: ". $_POST['password']."</label> <BR />
	   <label>You will need to change your password when you first login</label> <BR />
	   <label>Any issues do not hesitate to get in touch</label>


</td>
</tr>


       </tr>
	   
	    <tr height='20'>
       <td colspan='4' align='center' style='background-color:#f5f5f5;'>
      
       
       </td>
       </tr>
      
      
              </tbody>";
    
$message .= "</table>";
   
$message .= "</td></tr>";
$message .= "</table>";
   
$message .= "</body></html>";


 
 $mail = new PHPMailer(TRUE);
 
 
  $mail->setFrom('*******', 'Account');
   $mail->addAddress('********', 'Lewis');
   $mail->isSMTP();
   $mail->Host = 'smtp.gmail.com';
   $mail->SMTPAuth = TRUE;
   $mail->SMTPSecure = 'tls';
  $mail->Username = '***********';
   $mail->Password = '**********';
   $mail->Port = 587;


       if ($mail->addReplyTo($_POST['email'])) {
        $mail->Subject = 'JSMC Account';
        
        $mail->isHTML(true);
        // email admin details of the account being changed
        $mail->Body = "Account details have changed for a user: 
         <br> Their username is: $username"; 		 



        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
        
            $msg = 'Sorry, something went wrong. Please try again later.';
        } else {
            $msg = 'Mail successfully sent';

        }
    } else {
        $msg = 'Invalid email address, message ignored.';
    }
	

			
			$mail->ClearAddresses();
			$mail->AddAddress($email);
			$mail->Body = $message;
			$mail->send();
   
   
   /* Enable SMTP debug output. */
   $mail->SMTPDebug = 4;
   
  // $mail->send();

				//redirect to users page

				header('Location: users.php?action=updated');

				exit;



			} catch(PDOException $e) {

			    echo $e->getMessage();

			}
		  
	}


	}
	
	           if ($row['memberType'] == 1) {

		 try {

 

				if(isset($password)){



					$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);



					//update into database

					$stmt = $db->prepare('UPDATE users SET username = :username, password = :password, passwordChange = :passwordChange WHERE memberID = :memberID') ;

					$stmt->execute(array(

						':username' => $username,

						':password' => $hashedpassword,

						':passwordChange' => 1,

						':memberID' => $memberID

					));





				} 

//inform user of password being changed


              $message  = "<html><body>";


   
$message .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";
   
$message .= "<tr><td>";
   
$message .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:650px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";
    
$message .= "<thead>
  <tr height='80'>
  <th colspan='4' style='background-color:#f5f5f5; border-bottom:solid 1px #bdbdbd; font-family:Verdana, Geneva, sans-serif; color:#000000; font-size: 27px;' >Your Account</th>

  </tr>
             </thead>";
    
$message .= "<tbody>
       <tr height='80'>
       <td colspan='4' align='center' style='background-color:#f5f5f5; border-bottom:solid 1px #bdbdbd; font-size: 18px; '>
       <label>Your password has been reset</label> <BR />
	   <label>Your new password is: ". $_POST['password']."</label> <BR />
	   <label>You will need to change your password when you first login</label> <BR />
	   <label>Any issues do not hesitate to get in touch</label>


</td>
</tr>


       </tr>
	   
	    <tr height='20'>
       <td colspan='4' align='center' style='background-color:#f5f5f5;'>
      
       
       </td>
       </tr>
      
      
              </tbody>";
    
$message .= "</table>";
   
$message .= "</td></tr>";
$message .= "</table>";
   
$message .= "</body></html>";


 
 $mail = new PHPMailer(TRUE);
 
 
  $mail->setFrom('**********', 'Account');
   $mail->addAddress('*********', 'Lewis');
   $mail->isSMTP();
   $mail->Host = 'smtp.gmail.com';
   $mail->SMTPAuth = TRUE;
   $mail->SMTPSecure = 'tls';
  $mail->Username = '***********';
   $mail->Password = '********';
   $mail->Port = 587;


       if ($mail->addReplyTo($_POST['email'])) {
        $mail->Subject = 'JSMC Account';
  
        $mail->isHTML(true);
        // email admin of the account details being changed
        $mail->Body = "Account details have changed for a user: 
         <br> Their username is: $username"; 		 



        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
        
            $msg = 'Sorry, something went wrong. Please try again later.';
        } else {
            $msg = 'Mail successfully sent';

        }
    } else {
        $msg = 'Invalid email address, message ignored.';
    }
	

			
			$mail->ClearAddresses();
			$mail->AddAddress($email);
			$mail->Body = $message;
			$mail->send();
   
   
   /* Enable SMTP debug output. */
   $mail->SMTPDebug = 4;
   
  // $mail->send();



				//redirect to users page

				header('Location: users.php?action=updated');

				exit;



			} catch(PDOException $e) {

			    echo $e->getMessage();

			}				   
						
						
						
						
						
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



			$stmt = $db->prepare('SELECT memberID, username, email, memberType, teacher FROM users WHERE memberID = :memberID') ;

			$stmt->execute(array(':memberID' => $_GET['id']));

			$row = $stmt->fetch(); 



		} catch(PDOException $e) {

		    echo $e->getMessage();

		}



	?>



	<form action='' method='post'>

		<input type='hidden' name='memberID' value='<?php echo $row['memberID'];?>'>



		<p><label>Username</label><br />
		


		<input type='text' readonly name='username' value='<?php echo $row['username'];?>'></p>

		<input type='hidden' readonly name='email' value='<?php echo $row['email'];?>'></p>

		<p><label>Password (only to change)</label><br />

		<input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'></p>



		<p><label>Confirm Password</label><br />

		<input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'></p>

		

		<?php if ($row['memberType'] == 2) {?>

		<p><label>Student's Teacher</label><br />

		<input type='text' name='teacher' value='<?php echo $row['teacher'];?>'></p>

		<?php }?>


		<p><input type='submit' name='submit' value='Update User'></p>



	</form>



</div>



</body>

</html>	

