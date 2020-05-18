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

  <title>Admin - Add Teacher</title>

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


	<h2>Add Teacher</h2>



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



		if(!isset($error)){


//hash password
			$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

			//check if username has already been taken

			$query = $db->prepare( "SELECT `username` FROM `users` WHERE `username` = ?" );

			$query->bindValue( 1, $username );

			$query->execute();



			if( $query->rowCount() > 0 ) { # If rows are found for query

			echo "This username already exists";

		}

	else {
		
		//check if email has already been used
			$query = $db->prepare( "SELECT `email` FROM `users` WHERE `email` = ?" );

			$query->bindValue( 1, $email );

			$query->execute();



			if( $query->rowCount() > 0 ) { # If rows are found for query

			echo "An account has already been made using this email address";

			}

          else {

			try {



				//insert into database

				$stmt = $db->prepare('INSERT INTO users (name,username,password,email,memberType, passwordChange) VALUES (:name, :username, :password, :email, :memberType, :passwordChange)') ;

				$stmt->execute(array(

					':name' => $name,

					':username' => $username,

					':password' => $hashedpassword,

					':email' => $email,

					':memberType' => 1,

					':passwordChange' => 1

	
                     
				));

			} catch(PDOException $e) {

			    echo $e->getMessage();

			}



//duplicate all content in database where editedBy = admin and changed editedBy to new teacher username
		try {


			$stmt = $db->prepare('SELECT postTitle, postCont, canvasExample FROM introduction WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO introduction(postTitle,postCont,canvasExample,postDate,editedBy) VALUES (:postTitle, :postCont, :canvasExample, :postDate, :editedBy)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':canvasExample' => $row['canvasExample'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username
                  

				));

			$stmt = $db->prepare('SELECT postTitle, postCont FROM about WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO about(postTitle,postCont,postDate,editedBy) VALUES (:postTitle, :postCont, :postDate, :editedBy)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username
                  

				));
			
                         $stmt = $db->prepare('SELECT postTitle, postCont, codeExample FROM arrays WHERE editedBy = "admin" AND structure = 1') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO arrays(postTitle,postCont,codeExample,postDate,editedBy,structure) VALUES (:postTitle, :postCont, :codeExample, :postDate, :editedBy, :structure)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':codeExample' => $row['codeExample'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username,

                                         ':structure' => 1
                  

				));

                         $stmt = $db->prepare('SELECT postTitle, postCont FROM arrays WHERE editedBy = "admin" AND structure = 0') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO arrays(postTitle,postCont,postDate,editedBy,structure) VALUES (:postTitle, :postCont, :postDate, :editedBy, :structure)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username,

					':structure' => 0
                  

				));

                         $stmt = $db->prepare('SELECT postTitle, postCont, codeExample FROM concatenation WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO concatenation(postTitle,postCont,codeExample,postDate,editedBy) VALUES (:postTitle, :postCont, :codeExample, :postDate, :editedBy)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':codeExample' => $row['codeExample'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username
                  

				));

                         $stmt = $db->prepare('SELECT postTitle, postCont, codeExample FROM controlCharacters WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO controlCharacters(postTitle,postCont,codeExample,postDate,editedBy) VALUES (:postTitle, :postCont, :codeExample, :postDate, :editedBy)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':codeExample' => $row['codeExample'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username
                  

				));

                         $stmt = $db->prepare('SELECT postTitle, postCont, codeExample FROM forLoops WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO forLoops(postTitle,postCont,codeExample,postDate,editedBy) VALUES (:postTitle, :postCont, :codeExample, :postDate, :editedBy)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':codeExample' => $row['codeExample'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username
                  

				));

                         $stmt = $db->prepare('SELECT postTitle, postCont, codeExample FROM functions WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO functions(postTitle,postCont,codeExample,postDate,editedBy) VALUES (:postTitle, :postCont, :codeExample, :postDate, :editedBy)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':codeExample' => $row['codeExample'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username
                  

				));

                            $stmt = $db->prepare('SELECT postTitle, postCont, codeExample FROM moreFunctions WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO moreFunctions(postTitle,postCont,codeExample,postDate,editedBy) VALUES (:postTitle, :postCont, :codeExample, :postDate, :editedBy)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':codeExample' => $row['codeExample'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username
                  

				));

                         $stmt = $db->prepare('SELECT postTitle, postCont, codeExample FROM prompting WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO prompting(postTitle,postCont,codeExample,postDate,editedBy) VALUES (:postTitle, :postCont, :codeExample, :postDate, :editedBy)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':codeExample' => $row['codeExample'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username
                  

				));

                         $stmt = $db->prepare('SELECT postTitle, postCont, codeExample FROM strings WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO strings(postTitle,postCont,codeExample,postDate,editedBy) VALUES (:postTitle, :postCont, :codeExample, :postDate, :editedBy)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':codeExample' => $row['codeExample'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username
                  

				));

                         $stmt = $db->prepare('SELECT postTitle, postCont, codeExample, link FROM variablesOperators WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO variablesOperators(postTitle,postCont,codeExample,postDate,editedBy,link) VALUES (:postTitle, :postCont, :codeExample, :postDate, :editedBy, :link)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':codeExample' => $row['codeExample'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username,

				          ':link' => $row['link']
                  

				));


                         $stmt = $db->prepare('SELECT postTitle, postCont FROM whatIsJavaScript WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO whatIsJavaScript(postTitle,postCont,postDate,editedBy) VALUES (:postTitle, :postCont, :postDate, :editedBy)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username
                  

				));

                        $stmt = $db->prepare('SELECT image_title, image FROM images WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO images(image_title,image,editedBy) VALUES (:image_title, :image, :editedBy)') ;

				$stmt->execute(array(

					':image_title' => $row['image_title'],

					':image' => $row['image'],

					':editedBy' => $username
                  

				));

                        $stmt = $db->prepare('SELECT videoTitle, video FROM videos WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO videos(videoTitle,video,editedBy) VALUES (:videoTitle, :video, :editedBy)') ;

				$stmt->execute(array(

					':videoTitle' => $row['videoTitle'],

					':video' => $row['video'],

					':editedBy' => $username
                  

				));



                         $stmt = $db->prepare('SELECT postTitle, postCont FROM video WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO video(postTitle,postCont,postDate,editedBy) VALUES (:postTitle, :postCont, :postDate, :editedBy)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username
                  

				));

                         $stmt = $db->prepare('SELECT postTitle, postCont FROM animations WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO animations(postTitle,postCont,postDate,editedBy) VALUES (:postTitle, :postCont, :postDate, :editedBy)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username
                  

				));

                         $stmt = $db->prepare('SELECT postTitle, postCont FROM imageData WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO imageData(postTitle,postCont,postDate,editedBy) VALUES (:postTitle, :postCont, :postDate, :editedBy)') ;

				$stmt->execute(array(

					':postTitle' => $row['postTitle'],

					':postCont' => $row['postCont'],

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username
                  

				));

                         $stmt = $db->prepare('SELECT question, optionA, optionB, optionC, optionD, answer FROM quiz WHERE editedBy = "admin"') ;

                         $stmt->execute();

			$row = $stmt->fetch(); 


                       	$stmt = $db->prepare('INSERT INTO quiz(question,optionA,optionB,optionC,optionD,answer,editedBy) VALUES (:question, :optionA, :optionB, :optionC, :optionD, :answer, :editedBy)') ;

				$stmt->execute(array(

					':question' => $row['question'],

					':optionA' => $row['optionA'],

					':optionB' => $row['optionB'],

					':optionC' => $row['optionC'],

					':optionD' => $row['optionD'],

					':answer' => $row['answer'],

					':editedBy' => $username
                  

				));


						//if new users email is stored in registerInterest, delete from there
	                      $stmt = $db->prepare('DELETE FROM registerInterest WHERE email = :email') ;
		               $stmt->execute(array(':email' => $email));



//email teacher of their account being created
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
 
 
  $mail->setFrom('*********', 'Account');
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
        $mail->isHTML(true);
        // email new account info to admin
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

				

		<p><input type='submit' name='submit' value='Add User'></p>


	</form>



</div>