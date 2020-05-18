<!DOCTYPE html>
<?php
require_once('../../../includes/config.php');
$username =  $_SESSION['username'];
if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

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
  <a href="arrays.php"><current-page>Arrays</current-page></a>
  <a href="functions.php">Functions</a>
  <a href="moreFunctions.php">More Functions</a>
  <a href="animations.php">Animations</a>
  <a href="imageData.php">Image Data</a>
  <a href="videos.php">Videos</a>
</div>

<div class="main">
 
 <?php
 //get content set up by students teacher

			try {

			$stmt = $db->prepare('SELECT teacher FROM users WHERE username= :user') ;

			$stmt->bindParam(':user', $username, PDO::PARAM_STR);
                         $stmt->execute();

			$row = $stmt->fetch(); 
   

              $teacher = $row['teacher'];

			$state = $db->prepare('SELECT postTitle, postCont FROM arrays WHERE editedBy= :teacher and structure =1') ;
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

<button class="button" onclick="putcode(code.value)">Run Code</button>
  <textarea id="code"rows="20"  cols="50" align="left" >
<script>
 <?php
 
 //get code example set up by students teacher

			try {

			$stmt = $db->prepare('SELECT teacher FROM users WHERE username= :user') ;

			$stmt->bindParam(':user', $username, PDO::PARAM_STR);
                         $stmt->execute();

			$row = $stmt->fetch(); 
   

              $teacher = $row['teacher'];

			$state = $db->prepare('SELECT codeExample FROM arrays WHERE editedBy= :teacher') ;
			$state->bindParam(':teacher', $teacher, PDO::PARAM_STR);
                         $state->execute();
			while($content= $state->fetch()) {


               echo  $content['codeExample'];
	}		   
		} catch(PDOException $e) {

		    echo $e->getMessage();

		}
		?>
</script>
  </textarea>
  <iframe frameborder="0" width="300" height="300" align="right" ></iframe>


 <?php
 
 //get content set up by students teacher

			try {

			$stmt = $db->prepare('SELECT teacher FROM users WHERE username= :user') ;

			$stmt->bindParam(':user', $username, PDO::PARAM_STR);
                         $stmt->execute();

			$row = $stmt->fetch(); 
   

              $teacher = $row['teacher'];

			$state = $db->prepare('SELECT postTitle, postCont FROM arrays WHERE editedBy= :teacher AND structure = 0') ;
			$state->bindParam(':teacher', $teacher, PDO::PARAM_STR);
                         $state->execute();
			while($content= $state->fetch()) {

               echo '<p>'.$content['postCont'].'</p>';
		}	   
		} catch(PDOException $e) {

		    echo $e->getMessage();

		}
		?>


<p>Click <a href="../../../examples/arrays.html" target="_blank">here</a> to try out the example </p>
</div>
  <script>
    var studentCode;
    function putcode(studentCode){
      document.querySelector("iframe").srcdoc=studentCode;
    }
  </script>
</body>
</html> 