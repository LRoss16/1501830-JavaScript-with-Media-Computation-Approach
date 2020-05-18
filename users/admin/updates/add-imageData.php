<?php //include config

require_once('../../../includes/config.php');
$username =  $_SESSION['username'];

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

  <title>Admin - Add Post</title>

  <meta http-equiv="refresh" content="900;url=../../logout.php"/>

  <link rel="stylesheet" href="../../css/normalise.css">
<link rel="stylesheet" href="../../../css/learn.css">
 <link rel="stylesheet" href="../../../css/users.css">

  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

  <script>

          tinymce.init({

              selector: "textarea",

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


	<p><a href="imageData.php">Go Back</a></p>


	<h2>Add Post</h2>



	<?php



	//if form has been submitted process it

	if(isset($_POST['submit'])){


		//collect form data

		extract($_POST);



          //validation 
		if($postCont ==''){

			$error[] = 'Please enter the content.';

		}



		if(!isset($error)){



			try {



				//insert into database

				$stmt = $db->prepare('INSERT INTO imageData(postTitle,postCont,postDate,editedBy) VALUES (:postTitle, :postCont, :postDate, :editedBy)') ;

				$stmt->execute(array(

					':postTitle' => $postTitle,

					':postCont' => $postCont,

					':postDate' => date('Y-m-d H:i:s'),

					':editedBy' => $username
                  

				));



				//redirect to index page

				header('Location: imageData.php?action=added');

				exit;



			} catch(PDOException $e) {

			    echo $e->getMessage();

			}



		}



	}



	//check for any errors

	if(isset($error)){

		foreach($error as $error){

			echo '<p class="error">'.$error.'</p>';

		}

	}

	?>



	<form action='' method='post'>



		<p><label>Title</label><br />

		<input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>



		<p><label>Content</label><br />

		<textarea name='postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>



		<p><input type='submit' name='submit' value='Submit'></p>



	</form>



</div>