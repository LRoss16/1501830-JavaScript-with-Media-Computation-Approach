<?php
//connect to database
require_once('includes/config.php');



//create the body to the email that will be sent to the user
$message  = "<html><body>";


   
$message .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";
   
$message .= "<tr><td>";
   
$message .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:650px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";
    
$message .= "<thead>
  <tr height='80'>
  <th colspan='4' style='background-color:#f5f5f5; border-bottom:solid 1px #bdbdbd; font-family:Verdana, Geneva, sans-serif; color:#000000; font-size: 27px;' >Thank you for your interest in registering  </th>

  </tr>
             </thead>";
    
$message .= "<tbody>
       <tr height='80'>
       <td colspan='4' align='center' style='background-color:#f5f5f5; border-bottom:solid 1px #bdbdbd; font-size: 18px; '>
       <label>We aim to be in touch within 24 hours</label>
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

   $name = $_POST['name'];
   $email = $_POST['email'];
  $content= $_POST['userMessage'];


//connect to PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';
 
 
 
$mail = new PHPMailer(TRUE);

if (isset($_POST['email'])) {
	$emails = $_POST['email'];
	//check input for email is in correct format
	if (filter_var($emails, FILTER_VALIDATE_EMAIL)) {
		//check if email already been used for registering interest
		$query = $db->prepare( "SELECT `email` FROM `registerInterest` WHERE `email` = ?" );
		$query->bindValue( 1, $email );
		$query->execute();

		if( $query->rowCount() > 0 ) { # If rows are found for query
		echo "You have already submitted a message stating your interest. We will be in touch soon";
		}
	else {
			try {
				
				//insert into database
				$stmt = $db->prepare('INSERT INTO registerInterest (name,email,message) VALUES (:name,:email,:message)') ;
				$stmt->execute(array(
					':name' => $name,
					':email' => $email,
					':message' => $content
					
				));
				
				
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
     echo "Thank you for your interest. We will be in touch soon";	
try {
	

    $mail->setFrom('*********', 'Register');
   $mail->addAddress('**********', 'Lewis');
   $mail->isSMTP();
   $mail->Host = 'smtp.gmail.com';
   $mail->SMTPAuth = TRUE;
   $mail->SMTPSecure = 'tls';
  $mail->Username = '***********';
   $mail->Password = '**********';
   $mail->Port = 587;
   $name = $_POST['name'];
   $email = $_POST['email'];
  $content= $_POST['userMessage'];

   
       if ($mail->addReplyTo($_POST['email'])) {
        $mail->Subject = 'JSMC Registering';
        $mail->isHTML(true);
        // email to admin to inform them of person interested in registering an account
        $mail->Body = "Someone is interested in setting up an account: 
         <br> There name is: $name 
	<br>This is their message: $content
	<br>Please respond to them here: $email";


        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
        
            $msg = 'Sorry, something went wrong. Please try again later.';
        } else {
            $msg = 'Thanks for subscribing!.';
			//header("Refresh:3; url=index.php#register");
		//	echo "Your message was successfully sent";
        }
    } else {
        $msg = 'Invalid email address, message ignored.';
    }
	
			//email to user to let them know that the message has been recieved and someone will be in touch
			
			$mail->ClearAddresses();
			$mail->AddAddress($email);
			$mail->Body = $message;
			$mail->send();
   
   
   /* Enable SMTP debug output. */
   $mail->SMTPDebug = 4;
   
  // $mail->send();
  
 
}
		
catch (Exception $e)
{
  echo $e->errorMessage();
}
	}
}  else {
		echo "Please enter a valid email...";
	}
}