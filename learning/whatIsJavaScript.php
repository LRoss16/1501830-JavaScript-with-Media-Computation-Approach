<!--This page will display the content for what is javascript  -->
<!DOCTYPE html>
<?php
//connect to database
require_once('../includes/config.php');
?>
 <script>
document.createElement('current-page');
document.createElement('return-home');
</script>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/learn.css"> 
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
		//get content from database
			try {

				$stmt = $db->query('SELECT postTitle, postCont  FROM whatIsJavaScript WHERE editedBy = "admin" ');
				while($row = $stmt->fetch()){
					
						echo $row['postTitle'];
						echo $row['postCont'];								

				}

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>
</div>
</body>
</html> 
