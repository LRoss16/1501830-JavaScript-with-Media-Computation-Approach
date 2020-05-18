<!DOCTYPE html>
<?php
require_once('../../../includes/config.php');
if(!$user->is_logged_in()){ header('Location: ../../login.php'); }
$username =  $_SESSION['username'];
if($_SESSION['memberType'] == 1) { header('Location: ../../teacher/index.php'); }

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
  <a href="introduction.php">Introduction</a>
  <a href="whatIsJavaScript.php"><current-page>What is JavaScript?</current-page></a>
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
			try {

			$stmt = $db->prepare('SELECT teacher FROM users WHERE username= :user') ;

			$stmt->bindParam(':user', $username, PDO::PARAM_STR);
                         $stmt->execute();

			$row = $stmt->fetch(); 
   

              $teacher = $row['teacher'];

			$state = $db->prepare('SELECT postTitle, postCont FROM whatIsJavaScript WHERE editedBy= :teacher') ;
			$state->bindParam(':teacher', $teacher, PDO::PARAM_STR);
                         $state->execute();
			while($content= $state->fetch()) {


               echo '<h1>'.$content['postTitle'].'</h1>';
               echo '<p>'.$content['postCont'].'</p>';
	}		   
		} catch(PDOException $e) {

		    echo $e->getMessage();

		}
		?>
</div>
</body>
</html> 
