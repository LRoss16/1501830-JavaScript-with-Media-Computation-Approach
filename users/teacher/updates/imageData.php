<?php

require_once('../../../includes/config.php');
$username =  $_SESSION['username'];


//if not logged in redirect to login page

if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 0) { header('Location: ../../admin/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }

if(isset($_GET['delpost'])){ 



	$stmt = $db->prepare('DELETE FROM imageData WHERE postID = :postID') ;

	$stmt->execute(array(':postID' => $_GET['delpost']));



	header('Location: imageData.php?action=deleted');

	exit;

} 

?>

<!doctype html>

<html lang="en">

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta http-equiv="refresh" content="900;url=../../logout.php"/>

<head>

  <meta charset="utf-8">

  <title>Admin</title>

  <link rel="stylesheet" href="../../../css/normalise.css">
  <link rel="stylesheet" href="../../../css/learn.css">
  <link rel="stylesheet" href="../../../css/users.css">

  <script language="JavaScript" type="text/javascript">

  function delpost(id, title)

  {

	  if (confirm("Are you sure you want to delete '" + title + "'"))

	  {

	  	window.location.href = 'imageData.php?delpost=' + id;

	  }

  }

  </script>

</head>

<body>


<div class="sidenav">

<?php include('menu.php');?>
</div>


	<div id="wrapper">
	<?php 

	//show message from add / edit page

	if(isset($_GET['action'])){ 

		echo '<h3>Post '.$_GET['action'].'.</h3>'; 

	} 

	?>

<h1>Image Data section </h1>

<p>In this section you can change what is displayed on the image data page of the learning section</p>
	<table>

	<tr>

		<th>Heading</th>

		<th>Date Updated</th>

		<th>Action</th>

	</tr>

	<?php

		try {



				$stmt = $db->prepare('SELECT `postID`, `postTitle`, `postCont`, `postDate` FROM `imageData` where `editedBy` = :user');
                                $stmt->execute(array(':user' => $username));

			while($row = $stmt->fetch()){

				

				echo '<tr>';

				echo '<td>'.$row['postTitle'].'</td>';

				echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';

				?>



				<td>

					<a href="edit-imageData.php?id=<?php echo $row['postID'];?>">Edit</a> | 

					<a href="javascript:delpost('<?php echo $row['postID'];?>','<?php echo $row['postTitle'];?>')">Delete</a>

				</td>

				

				<?php 

				echo '</tr>';



			}



		} catch(PDOException $e) {

		    echo $e->getMessage();

		}

	?>

	</table>



	<p><a href='add-imageData.php'>Add Post</a></p>



</div>

</body>

</html>
