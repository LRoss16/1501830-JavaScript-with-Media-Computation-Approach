<?php //include config

require_once('../../../includes/config.php');



//if not logged in redirect to login page


if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 0) { header('Location: ../../admin/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }

?>

<!doctype html>

<html lang="en">

<head>

  <meta charset="utf-8">

  <title>Admin - Edit Quiz Question </title>

  <meta http-equiv="refresh" content="900;url=../../logout.php"/>

  <link rel="stylesheet" href="../../../css/normalise.css">
<link rel="stylesheet" href="../../../css/learn.css">
  <link rel="stylesheet" href="../../../css/users.css">
  <link rel="stylesheet" href="../../css/textarea.css">


    <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>

  <script>


  </script>

</head>

<body>


<div class="sidenav">



	<?php include('menu.php');?>

</div>

<div id="wrapper">


	<p><a href="quiz.php">Go Back</a></p>



	<h2>Edit Post</h2>





	<?php



	//if form has been submitted process it

	if(isset($_POST['submit'])){


		//collect form data

		extract($_POST);


          if($question ==''){

			$error[] = 'Please enter the question.';

		}

                     if($optionA==''){

			$error[] = 'Please enter option A.';

		}

                     if($optionB==''){

			$error[] = 'Please enter option B.';

		}

                     if($optionC==''){

			$error[] = 'Please enter option C.';

		}

                     if($optionD==''){

			$error[] = 'Please enter option D.';

		}

                     if($answer==''){

			$error[] = 'Please enter the answer.';

		}

		if(!isset($error)){



			try {



				//insert into database

				$stmt = $db->prepare('UPDATE quiz SET question= :question, optionA= :optionA, optionB= :optionB, optionC= :optionC, optionD= :optionD, answer = :answer WHERE questionID= :questionID') ;

				$stmt->execute(array(
           
	                               ':question' => $question,

					':optionA' => $optionA,

					':optionB' => $optionB,

					':optionC' => $optionC,
					
                                         ':optionD' => $optionD,

					':answer' => $answer,

					':questionID' => $questionID



				));


				//redirect to index page

				header('Location: quiz.php?action=updated');

				exit;



			} catch(PDOException $e) {

			    echo $e->getMessage();

			}



		}



	}



	?>





	<?php

	//check for any errors

	if(isset($error)){

		foreach($error as $error){

			echo $error.'<br />';

		}

	}



		try {



			$stmt = $db->prepare('SELECT questionID, question, optionA, optionB, optionC, optionD, answer FROM quiz WHERE questionID= :questionID') ;

			$stmt->execute(array(':questionID' => $_GET['id']));

			$row = $stmt->fetch(); 



		} catch(PDOException $e) {

		    echo $e->getMessage();

		}



	?>



	<form action='' method='post'>

		<input type='hidden' name='questionID' value='<?php echo $row['questionID'];?>'>


		<p><label>Question</label><br />

		<textarea name='question' id='question' cols='60' rows='10'><?php echo $row['question'];?></textarea></p>

		<p><label>Option A</label><br />

		<textarea name='optionA' id='optionA' cols='60' rows='10'><?php echo $row['optionA'];?></textarea></p>

		<p><label>Option B</label><br />

		<textarea name='optionB' id='optionB' cols='60' rows='10'><?php echo $row['optionB'];?></textarea></p>

		<p><label>Option C</label><br />

		<textarea name='optionC' id='optionC' cols='60' rows='10'><?php echo $row['optionC'];?></textarea></p>

		<p><label>Option D</label><br />

		<textarea name='optionD' id='optionD' cols='60' rows='10'><?php echo $row['optionD'];?></textarea></p>

		<p><label>Answer</label><br />

		<textarea name='answer' id='answer' cols='60' rows='10'><?php echo $row['answer'];?></textarea></p>



		<p><input type='submit' name='submit' value='Update'></p>



	</form>



</div>



</body>

</html>