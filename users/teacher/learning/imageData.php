<!DOCTYPE html>
<?php
require_once('../../../includes/config.php');
$user =  $_SESSION['username'];
?>
 <script>
document.createElement('current-page');
document.createElement('return-home');
</script>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../../css/learn.css"> 
<link rel="stylesheet" href="../../../css/runCode.css"> 
<style>
.move-down
{
    margin-top:500px;
}

</style>
</head>
<body>

<div class="sidenav">
  <a href="../index.php"><return-home>Return Home</return-home></a>
  <a href="introduction.php">Introduction</a>
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
  <a href="imageData.php"><current-page>Image Data</current-page></a>
  <a href="videos.php">Videos</a>
</div>

<div class="main">
 
 <?php
			try {

				$stmt = $db->prepare('SELECT `postTitle`, `postCont` FROM `imageData` where `editedBy` = :user ');
                                $stmt->execute(array(':user' => $user));
                                while($row = $stmt->fetch()) {
					echo '<h1>'.$row['postTitle'].'</h1>';
					echo '<p>'.$row['postCont'].'</p>';

                                  }
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>


<p>Click <a href="../../../examples/imageData.html" target="_blank">here</a> to try out the example </p>
</div>

</body>
</html> 