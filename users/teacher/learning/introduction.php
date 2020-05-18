<!DOCTYPE html>
<?php
//connect to database
require_once('../../../includes/config.php');
$username =  $_SESSION['username'];
//if not logged in, redirect
if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }

if($_SESSION['memberType'] == 0) { header('Location: ../../admin/index.php'); }
?>
 <script>
document.createElement('current-page');
document.createElement('return-home');
</script>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../../css/learn.css"> 
</head>
<body>

<div class="sidenav">
  <a href="../index.php"><return-home>Return Home</return-home></a>
  <a href="introduction.php"><current-page>Introduction</current-page></a>
  <a href="whatIsJavaScript.php">What is JavaScript?</a>
  <a href="strings.php">Strings</a>
  <a href="concatenation.php">Concatenation</a>
<a href="controlCharacters.php">Control Characters</a>
  <a href="prompting.php">Prompting</a>
  <a href="variables&Operators.php">Variables & Operators</a>
  <a href="forLoops.php">For Loops</a>
  <a href="arrays.php">Arrays</a>
  <a href="functions.php">Functions</a>
  <a href="moreFunctions.php">More Functions</a>
  <a href="animations.php">Animations</a>
  <a href="imageData.php">Image Data</a>
  <a href="videos.php">Videos</a>
</div>

<div class="main">
		<?php

//get content set by teacher

			try {

				$stmt = $db->prepare('SELECT `postTitle`, `postCont` FROM `introduction` where `editedBy` = :user');
                                $stmt->execute(array(':user' => $username));
                                while($row = $stmt->fetch()) {
					echo '<h1>'.$row['postTitle'].'</h1>';
					echo '<p>'.$row['postCont'].'</p>';

                                  }
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
	
		?>
 <canvas id="exampleCanvas" width="500" height="200" style="border:1px solid #d3d3d3;">

</div>

<script>

		<?php

//get canvas example set by teacher
			try {

				$stmt = $db->prepare('SELECT `canvasExample`   FROM `introduction` where `editedBy` = :user');
                                $stmt->execute(array(':user' => $username));
                                while($row = $stmt->fetch()) {
					echo  $row['canvasExample'];

                                  }
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>
</script>


</body>
</html> 
