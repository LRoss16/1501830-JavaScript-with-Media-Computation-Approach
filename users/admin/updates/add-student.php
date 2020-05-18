<?php //include config

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

  <title>Admin - Add Student </title>

  <meta http-equiv="refresh" content="900;url=../../logout.php"/>

  <link rel="stylesheet" href="../../css/normalise.css">
<link rel="stylesheet" href="../../../css/learn.css">
 <link rel="stylesheet" href="../../../css/users.css">


</head>

<body>



<div class="sidenav">


<?php include('menu.php');?>

</div>

<div id="wrapper">


	<p><a href="users.php">Go Back</a></p>


	<h2>Add Student</h2>


<div align="right">List of available teachers to choose from</div>

<p align="right">

	
	<?php 
	try {



			$stmt = $db->query('SELECT username FROM users WHERE memberType = 1');

			while($row = $stmt->fetch()){

			

				echo $row['username']. "<br><br>";
				
			}


		} catch(PDOException $e) {

		    echo $e->getMessage();

		}
		
	?>



</p>



	<?php


	//if form has been submitted process it

	if(isset($_POST['submit'])){



		//collect form data

		extract($_POST);

		
                       if($name==''){

			$error[] = 'Please enter the name.';

		}



		if($username ==''){

			$error[] = 'Please enter the username.';

		}

		if($email==''){

			$error[] = 'Please enter the email address.';

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

		if($teacher ==''){

			$error[] = 'Please enter the teacher of the student';

		}



		if(!isset($error)){


			//hash password
			$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

			

			$query = $db->prepare( "SELECT `username` FROM `users` WHERE `username` = ?" );

			$query->bindValue( 1, $username );

			$query->execute();



			if( $query->rowCount() > 0 ) { # If rows are found for query

			echo "This username already exists<br>";

		}


			$query = $db->prepare( "SELECT `email` FROM `users` WHERE `email` = ?" );

			$query->bindValue( 1, $email );

			$query->execute();



			if( $query->rowCount() > 0 ) { # If rows are found for query

			echo "An account has already been made using this email address<br>";

			}

			$query = $db->prepare( "SELECT `username` FROM `users` WHERE memberType = 1 AND username = :teacher" );
                        
                           $query->execute(array(

			 ':teacher' => $teacher

                   ));

			if( $query->rowCount() == 0 ) { # If rows are found for query

			echo "There is no teacher with this username, please enter one of the usernames shown on the right<br>";

		}



	else {



			try {



				//insert into database

				$stmt = $db->prepare('INSERT INTO users (name,username,password,email,memberType,teacher,passwordChange) VALUES (:name, :username, :password, :email, :memberType, :teacher, :passwordChange)') ;

				$stmt->execute(array(

					':name' => $name,

					':username' => $username,

					':password' => $hashedpassword,

					':email' => $email,

					':memberType' => 2,

					':teacher' => $teacher,

					':passwordChange' => 1

                     
				));

//email account details to user

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
       <label>Here is your account details:</label>
	   <label>Username: ".$username."</label> <BR />
	   <label>Password: ". $_POST['password']."</label> <BR />
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
 
 
  $mail->setFrom('***********', 'Account');
   $mail->addAddress('*********', 'Lewis');
   $mail->isSMTP();
   $mail->Host = 'smtp.gmail.com';
   $mail->SMTPAuth = TRUE;
   $mail->SMTPSecure = 'tls';
  $mail->Username = '*********';
   $mail->Password = '**********';
   $mail->Port = 587;


       if ($mail->addReplyTo($_POST['email'])) {
        $mail->Subject = 'JSMC Account';
        //keeps it simple
        $mail->isHTML(true);
        // email admin new user info
        $mail->Body = "Account details have been sent to: 
         <br> Their name is: $name
         <br> Their username is: $username 		 
	<br>Their email: $email";


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

				header('Location: users.php?action=added');

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

	?>



	<form action='' method='post'>


		<p><label>Name</label><br />

		<input type='text' name='name' value='<?php if(isset($error)){ echo $_POST['name'];}?>'></p>

		<p><label>Username</label><br />

		<input type='text' name='username' value='<?php if(isset($error)){ echo $_POST['username'];}?>'></p>

		<p><label>Email Address</label><br />

		<input type='email' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'></p>

		<p><label>Password</label><br />

		<input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'></p>



		<p><label>Confirm Password</label><br />

		<input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'></p>

		
		<p><label>Student's Teacher</label><br />

		<input type='teacher' name='teacher' value='<?php if(isset($error)){ echo $_POST['teacher'];}?>'></p>		

		<p><input type='submit' name='submit' value='Add User'></p>


	</form>
