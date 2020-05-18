<!--This page was meant to be a quiz for allowing people to test their knowledge of JavaScript -->
<?php
//connect to database
require_once('includes/config.php');
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
			<input type="text" name="name" required value=""/>
		</div>
		<div class="form-group">
			<strong>Email Address:</strong><br/>
			<input type="text" name="email" required/>
		</div>

		<div class="form-group">

 <?php
 
 //Get questions down from database
			try {

				$stmt = $db->query('SELECT questionID, question, optionA, optionB, optionC, optionD FROM quiz WHERE editedBy = "admin" ORDER BY questionID ');
				while($row = $stmt->fetch()){
				
					    echo '<h3>'.$row['question'].'</h3>';
					    echo '<ol>';
					    echo '<li>
                                           <input type="radio" name= '.$row['questionID'].' value = '.$row['optionA'].'> '.$row['optionA'].' required</li>';
					    echo '<li>
                                            <input type="radio" name= '.$row['questionID'].'  value = '.$row['optionB'].'> '.$row['optionB'].'</li>';
					    echo '<li>
                                            <input type="radio" name= '.$row['questionID'].'   value = '.$row['optionC'].'> '.$row['optionC'].'</li>';
					    echo '<li>
                                            <input type="radio" name= '.$row['questionID'].' value = '.$row['optionD'].'> '.$row['optionD'].'</li>';
					    echo '
                                            <input type="hidden" name= "question" value = '.$row['questionID'].'>';

	                              
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