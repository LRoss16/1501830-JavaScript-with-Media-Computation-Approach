<?php

require_once('../../includes/config.php');
$user = $_SESSION['username'];
?>
<html>
<head>
<title>JavaScript Quiz</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
	<h1>Quiz</h1>
	<p>
		Please fill in the details and answer all the questions
	</p>
	<form action="score.php" method="post">
		<div class="form-group">
			<strong>Name*:</strong><br/>
			<input type="text" name="name" value=""/>
		</div>
		<div class="form-group">
			<strong>Email Address:</strong><br/>
			<input type="text" name="email"/>
		</div>

		<div class="form-group">

 <?php
			try {

			$stmt = $db->prepare('SELECT teacher FROM users WHERE username= :user') ;

			$stmt->bindParam(':user', $user, PDO::PARAM_STR);
                         $stmt->execute();

			    $row = $stmt->fetch(); 

                             $teacher = $row['teacher'];

			$state = $db->prepare('SELECT questionID, question, optionA, optionB, optionC, optionD FROM quiz WHERE editedBy= :teacher') ;
			$state->bindParam(':teacher', $teacher, PDO::PARAM_STR);
                         $state->execute();
				while($row = $state->fetch()){
				
					    echo '<h3>'.$row['question'].'</h3>';
					    echo '<ol>';
					    echo '<li>
                                           <input type="radio" name= '.$row['questionID'].' value = '.$row['optionA'].'/> '.$row['optionA'].'</li>';
					    echo '<li>
                                            <input type="radio" name= '.$row['questionID'].'  value = '.$row['optionB'].'/> '.$row['optionB'].'</li>';
					    echo '<li>
                                            <input type="radio" name= '.$row['questionID'].'   value = '.$row['optionC'].'/> '.$row['optionC'].'</li>';
					    echo '<li>
                                            <input type="radio" name= '.$row['questionID'].' value = '.$row['optionD'].'/> '.$row['optionD'].'</li>';
 					    echo '</ol>';
				}

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>
		</div>

           		<p><input type='submit' name='submit' value='Submit'></p>

	</form>
</div>
</body>
</html>