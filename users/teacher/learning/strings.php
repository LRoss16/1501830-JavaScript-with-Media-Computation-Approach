<!DOCTYPE html>
<?php
require_once('../../../includes/config.php');
$user =  $_SESSION['username'];
?>
 <script>
document.createElement('current-page');
</script>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../../css/learn.css">
<link rel="stylesheet" href="../../../css/runCode.css">  
</head>

<body>

<div class="sidenav">
  <a href="../index.php"><return-home>Return Home</return-home></a>
  <a href="introduction.php">Introduction</a>
  <a href="whatIsJavaScript.php">What is JavaScript?</a>
  <a href="strings.php"><current-page>Strings</current-page></a>
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


				$stmt = $db->prepare('SELECT `postTitle`, `postCont` FROM `strings` where `editedBy` = :user');
                                $stmt->execute(array(':user' => $user));
                                while($row = $stmt->fetch()) {
					echo '<h1>'.$row['postTitle'].'</h1>';
					echo '<p>'.$row['postCont'].'</p>';

                                  }
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>
<button class="button" onclick="putcode(code.value)">Run Code</button>
  <textarea id="code"rows="20"  cols="50" align="left" >
<script>
 <?php
			try {

				$stmt = $db->prepare('SELECT `codeExample`   FROM `strings` where `editedBy` = :user');
                                $stmt->execute(array(':user' => $user));
                                while($row = $stmt->fetch()) {
					echo  $row['codeExample'];

                                  }
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>

</script>
  </textarea>
  <iframe frameborder="0" width="200" height="200" align="right" ></iframe>

</div>
  <script>
    var studentCode;
    function putcode(studentCode){
      document.querySelector("iframe").srcdoc=studentCode;
    }
  </script>


</body>
</html> 
