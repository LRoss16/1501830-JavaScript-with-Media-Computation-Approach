<?php //include config

require_once('../../../includes/config.php');
$username =  $_SESSION['username'];

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

  <title>Teacher - Add Question</title>

  <meta http-equiv="refresh" content="900;url=../../logout.php"/>

  <link rel="stylesheet" href="../../css/normalise.css">
<link rel="stylesheet" href="../../../css/learn.css">
 <link rel="stylesheet" href="../../../css/users.css">
  <link rel="stylesheet" href="../../css/textarea.css">

</head>

<body>



<div class="sidenav">


<?php include('menu.php');?>

</div>

<div id="wrapper">


	<p><a href="quiz.php">Go Back</a></p>


	<h2>Add Question</h2>



	<?php



	//if form has been submitted process it

	if(isset($_POST['submit'])){


		//collect form data

		extract($_POST);



          //validation 
		
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

				$stmt = $db->prepare('INSERT INTO quiz (question,optionA,optionB,optionC,optionD,answer,editedBy) VALUES (:question, :optionA, :optionB, :optionC, :optionD, :answer, :editedBy)') ;

				$stmt->execute(array(

					':question' => $question,

					':optionA' => $optionA,

					':optionB' => $optionB,

					':optionC' => $optionC,
					
                                         ':optionD' => $optionD,

					':answer' => $answer,

					':editedBy' => $username
				));



				//redirect to arrays page

				header('Location: quiz.php?action=added');

				exit;



			} catch(PDOException $e) {

			    echo $e->getMessage();

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


		<p><label>Question</label><br />

		<textarea name='question' cols='30' rows='10'><?php if(isset($error)){ echo $_POST['question'];}?></textarea></p>

		<p><label>Option A </label><br />

		<textarea name='optionA' cols='30' rows='10'><?php if(isset($error)){ echo $_POST['optionA'];}?></textarea></p>

		<p><label>Option B </label><br />

		<textarea name='optionB' cols='30' rows='10'><?php if(isset($error)){ echo $_POST['optionB'];}?></textarea></p>

		<p><label>Option C </label><br />

		<textarea name='optionC' cols='30' rows='10'><?php if(isset($error)){ echo $_POST['optionC'];}?></textarea></p>

		<p><label>Option D </label><br />

		<textarea name='optionD' cols='30' rows='10'><?php if(isset($error)){ echo $_POST['optionD'];}?></textarea></p>

		<p><label>Answer</label><br />

		<textarea name='answer' cols='30' rows='10'><?php if(isset($error)){ echo $_POST['answer'];}?></textarea></p>

		<p><input type='submit' name='submit' value='Submit'></p>


	</form>



</div>