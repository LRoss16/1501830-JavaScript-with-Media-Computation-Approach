<!--This page will display the content for learning of arrays -->
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
<link rel="stylesheet" href="../css/runCode.css"> 
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
  <a href="arrays.php"><current-page>Arrays</current-page></a>
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

				$stmt = $db->query('SELECT postTitle, postCont  FROM arrays WHERE editedBy = "admin" AND structure = 1 ');
				while($row = $stmt->fetch()){
				
						echo $row['postTitle'];
						echo $row['postCont'];								

				}

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>

<button class="button" onclick="putcode(code.value)">Run Code</button>
  <textarea id="code"rows="20"  cols="50" align="left" >
<script>
 <?php
 
 //get code example from database
			try {

				$stmt = $db->query('SELECT codeExample  FROM arrays WHERE editedBy = "admin" ');
				while($row = $stmt->fetch()){
					
						echo $row['codeExample'];						

				}

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>
</script>
  </textarea>
  <iframe frameborder="0" width="300" height="300" align="right" ></iframe>


 <?php
 
 //get the rest of the content from the database
			try {

				$stmt = $db->query('SELECT  postCont  FROM arrays WHERE editedBy = "admin" AND structure = 0 ');
				while($row = $stmt->fetch()){
				
						echo $row['postCont'];								

				}

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>

<p>Click <a href="../examples/arrays.html" target="_blank">here</a> to try out the example </p>
</div>
  <script>
    var studentCode;
    function putcode(studentCode){
      document.querySelector("iframe").srcdoc=studentCode;
    }
  </script>
</body>
</html> 