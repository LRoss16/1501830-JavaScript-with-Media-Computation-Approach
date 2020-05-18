<?php

require_once('../../../includes/config.php');
$username =  $_SESSION['username'];


//if not logged in redirect to login page

if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 1) { header('Location: ../../teacher/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }

if(isset($_GET['delpost'])){ 



	$stmt = $db->prepare('DELETE FROM quiz WHERE questionID = :questionID') ;

	$stmt->execute(array(':questionID' => $_GET['delpost']));



	header('Location: quiz.php?action=deleted');

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

  function delpost(id, title)

  {

	  if (confirm("Are you sure you want to delete '" + title + "'"))

	  {

	  	window.location.href = 'quiz.php?delpost=' + id;

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

		echo '<h3>Question '.$_GET['action'].'.</h3>'; 

	} 

	?>

<h1>Quiz</h1>

<p>In this section you can change the questions and answers on the quiz</p>
	<table>

	<tr>

		<th>Question</th>

		<th>Action</th>

	</tr>

	<?php

		try {



			$stmt = $db->query('SELECT questionID, question, optionA, optionB, optionC, optionD FROM quiz WHERE editedBy = "admin" ORDER BY questionID ');

			while($row = $stmt->fetch()){

				

				echo '<tr>';

				echo '<td>'.$row['question'].'</td>';

				?>



				<td>

					<a href="edit-quiz.php?id=<?php echo $row['questionID'];?>">Edit</a> | 

	                            <a href="javascript:delpost('<?php echo $row['questionID'];?>','<?php echo $row['question'];?>')">Delete</a>

				</td>

				

				<?php 

				echo '</tr>';



			}



		} catch(PDOException $e) {

		    echo $e->getMessage();

		}

	?>

	</table>



	<p><a href='add-quiz.php'>Add Question</a></p>



</div>

</body>

</html>