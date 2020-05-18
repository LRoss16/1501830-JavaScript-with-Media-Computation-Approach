<?php //include config

require_once('../../../includes/config.php');



//if not logged in redirect to login page


if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 1) { header('Location: ../../teacher/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }

?>

<!doctype html>

<html lang="en">

<head>

  <meta charset="utf-8">

  <title>Admin - Edit Variables & Operators Page</title>

  <meta http-equiv="refresh" content="900;url=../../logout.php"/>

  <link rel="stylesheet" href="../../css/normalise.css">
<link rel="stylesheet" href="../../../css/learn.css">
  <link rel="stylesheet" href="../../../css/users.css">

    <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>

  <script>

          tinymce.init({

              selector: "textarea",
              extended_valid_elements : "script[src|async|defer|type|charset]", 

              plugins: [

                  "advlist autolink lists link image charmap print preview anchor",

                  "searchreplace visualblocks code fullscreen",

                  "insertdatetime media table contextmenu paste"

              ],

              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

          });

  </script>

</head>

<body>


<div class="sidenav">



	<?php include('menu.php');?>

</div>

<div id="wrapper">


	<p><a href="variables&operators.php">Go Back</a></p>



	<h2>Edit Post</h2>





	<?php



	//if form has been submitted process it

	if(isset($_POST['submit'])){


		//collect form data

		extract($_POST);



		//very basic validation

		if($postID ==''){

			$error[] = 'This post is missing a valid id!.';

		}






		if($postCont ==''){

			$error[] = 'Please enter the content.';

		}



		if(!isset($error)){



			try {



				//insert into database

				$stmt = $db->prepare('UPDATE variablesOperators SET postTitle = :postTitle, postCont = :postCont, postDate = :postDate WHERE postID = :postID') ;

				$stmt->execute(array(

					':postTitle' => $postTitle,

					':postCont' => $postCont,

					':postDate' => date('Y-m-d H:i:s'),

					':postID' => $postID

				));



				//redirect to variables&operators page

				header('Location: variables&operators.php?action=updated');

				exit;



			} catch(PDOException $e) {

			    echo $e->getMessage();

			}



		}



	}



	?>





	<?php

	//check for any errors

	if(isset($error)){

		foreach($error as $error){

			echo $error.'<br />';

		}

	}



		try {



			$stmt = $db->prepare('SELECT postID, postTitle, postCont FROM variablesOperators WHERE postID = :postID') ;

			$stmt->execute(array(':postID' => $_GET['id']));

			$row = $stmt->fetch(); 



		} catch(PDOException $e) {

		    echo $e->getMessage();

		}



	?>



	<form action='' method='post'>

		<input type='hidden' name='postID' value='<?php echo $row['postID'];?>'>



		<p><label>Title</label><br />

		<input type='text' name='postTitle' value='<?php echo $row['postTitle'];?>'></p>





		<p><label>Content</label><br />

		<textarea name='postCont' cols='60' rows='10'><?php echo $row['postCont'];?></textarea></p>



		<p><input type='submit' name='submit' value='Update'></p>



	</form>



</div>



</body>

</html>