<?php

require_once('../../../includes/config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';

//if not logged in redirect to login page

if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 1) { header('Location: ../../teacher/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }

if(isset($_GET['deluser'])){ 


//Delete user from database
//If teacher delete all their students and all thei content from the databse tables
                 $stmt = $db->prepare('SELECT username, email FROM users WHERE memberID= :memberID') ;
		$stmt->execute(array(':memberID' => $_GET['deluser']));

			$row = $stmt->fetch(); 
			$teacherUsername = $row['username'];
			$teacherEmail = $row['email'];    

		$stmt = $db->prepare('DELETE FROM users WHERE memberID = :memberID') ;

		$stmt->execute(array(':memberID' => $_GET['deluser']));

	 $stmt = $db->prepare('DELETE FROM about WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	 $stmt = $db->prepare('DELETE FROM introduction WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM arrays WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM concatenation WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM controlCharacters WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM forLoops WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM functions WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM moreFunctions WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM prompting WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM strings WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM variablesOperators WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM whatIsJavaScript WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM images WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM videos WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM video WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM imageData WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM animations WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

	$stmt = $db->prepare('DELETE FROM quiz WHERE editedBy= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

        	$stmt = $db->prepare('SELECT username, email FROM users WHERE teacher= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

			$row = $stmt->fetch(); 
			$studentUsername = $row['username'];
			$studentEmail = $row['email'];

	$stmt = $db->prepare('DELETE FROM users WHERE teacher= :username') ;
		$stmt->execute(array(':username' => $teacherUsername));

//send email to user informing them of their account being deleted
              $message  = "<html><body>";


   
$message .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";
   
$message .= "<tr><td>";
   
$message .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:650px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";
    
$message .= "<thead>
  <tr height='80'>
  <th colspan='4' style='background-color:#f5f5f5; border-bottom:solid 1px #bdbdbd; font-family:Verdana, Geneva, sans-serif; color:#000000; font-size: 27px;' >Deleted Account</th>

  </tr>
             </thead>";
    
$message .= "<tbody>
       <tr height='80'>
       <td colspan='4' align='center' style='background-color:#f5f5f5; border-bottom:solid 1px #bdbdbd; font-size: 18px; '>
	   <label>Your account has now been deleted</label> <BR />
	   <label>We are sorry to see you go<BR />

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
   $mail->addAddress('******', 'Lewis');
   $mail->isSMTP();
   $mail->Host = 'smtp.gmail.com';
   $mail->SMTPAuth = TRUE;
   $mail->SMTPSecure = 'tls';
  $mail->Username = '*****';
   $mail->Password = '******';
   $mail->Port = 587;


       if ($mail->addReplyTo('*******')) {
        $mail->Subject = 'JSMC Account';
        $mail->isHTML(true);
//send email depending on who it is that is being deleted
if($teacherEmail != NULL) {
        $mail->Body = "Account details have been deleted: 
         <br> The username was: $teacherUsername
	<br>Their email: $teacherEmail";
}

if($studentEmail != NULL && $teacherEmail == NULL)  {
        $mail->Body = "Account details have been deleted: 
         <br> The username was: $studentUsername
	<br>Their email: $studentEmail";
}

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
	
if($teacherEmail != NULL) {
			
			$mail->ClearAddresses();
			$mail->AddAddress($teacherEmail);
			$mail->Body = $message;
			$mail->send();
}

if ($teacherEmail != NULL && $studentEmail != NULL) {
			$mail->ClearAddresses();
			$mail->AddAddress('l.s.ross@rgu.ac.uk', 'Lewis');
                        $mail->Body = "Account details have been deleted: 
                       <br> The username was: $studentUsername
	               <br>Their email: $studentEmail";
			$mail->send();

			$mail->ClearAddresses();
			$mail->AddAddress($studentEmail);
			$mail->Body = $message;
			$mail->send();
}
   
   
   /* Enable SMTP debug output. */
   $mail->SMTPDebug = 4;
   
  // $mail->send();
  


		header('Location: users.php?action=deleted');

		exit;

} 



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

  <script language="JavaScript" type="text/javascript">

  function deluser(id, username)

  {

	  if (confirm("Are you sure you want to delete '" + username+ "'"))

	  {

	  	window.location.href = 'users.php?deluser=' + id;

	  }

  }

  </script>

</head>

<body>


<div class="sidenav">

<?php include('menu.php');?>
</div>


	<div id="wrapper">
	<?php 

	//show message from add / edit page

	if(isset($_GET['action'])){ 

		echo '<h3>User '.$_GET['action'].'.</h3>'; 

	} 

	?>

<h1>users</h1>

<p>In this section you can update the users</p>
<p>For member type: 1 = teacher and 2 = student </p>
	<table>

	<tr>

		<th>Username</th>
                
        <th>Email</th>

		<th>Member Type</th>

		<th>Action</th>

	</tr>

	<?php

		try {

//display users from database

			$stmt = $db->query('SELECT memberID, username, email, memberType FROM users ORDER BY memberID');

			while($row = $stmt->fetch()){

				

				echo '<tr>';

				echo '<td>'.$row['username'].'</td>';

				echo '<td>'.$row['email'].'</td>';

				echo '<td>'.$row['memberType'].'</td>';



				?>



				<td>

					<?php if ($row['memberType'] == 0) {?><a href="edit-admin.php?id=<?php echo $row['memberID'];?>">Edit</a><?php } ?>


				<?php if ($row['memberType'] != 0) {?><a href="edit-users.php?id=<?php echo $row['memberID'];?>">Edit</a> | <?php } ?>


				<?php if ($row['memberType'] != 0) {?><a href="javascript:deluser('<?php echo $row['memberID'];?>','<?php echo $row['username'];?>')">Delete</a><?php } ?>

				</td>

				

				<?php 

				echo '</tr>';



			}



		} catch(PDOException $e) {

		    echo $e->getMessage();

		}

	?>

	</table>

	<p><a href='add-teacher.php'>Add Teacher</a></p>

	<p><a href='add-student.php'>Add Student</a></p>



</div>

</body>

</html>