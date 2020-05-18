<?php

require_once('../../../includes/config.php');
$username =  $_SESSION['username'];


//if not logged in redirect to login page

if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 1) { header('Location: ../../teacher/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }

if(isset($_GET['delpost'])){ 



	$stmt = $db->prepare('DELETE FROM images WHERE imageID= :imageID') ;

	$stmt->execute(array(':imageID' => $_GET['delpost']));



	header('Location: images.php?action=deleted');

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

	  	window.location.href = 'images.php?delpost=' + id;

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

		echo '<h3>Image '.$_GET['action'].'.</h3>'; 

	} 

	?>

<h1>Images</h1>

<p>In this section you can change the images used on the site</p>
	<table>

	<tr>

		<th>Image Title</th>

		<th>Image</th>

		<th>Action</th>

	</tr>

	<?php

		try {



			$stmt = $db->query('SELECT imageID, image, image_title FROM images WHERE editedBy = "admin" ORDER BY imageID');

			while($row = $stmt->fetch()){

				

				echo '<tr>';

				echo '<td>'.$row['image_title'].'</td>';

				echo "<td><img src='../images/".$row['image']."'height='100px'</td>";

				?>



				<td>

					<a href="edit-images.php?id=<?php echo $row['imageID'];?>">Edit</a> | 

					<a href="javascript:delpost('<?php echo $row['imageID'];?>','<?php echo $row['image_title'];?>')">Delete</a>

				</td>

				

				<?php 

				echo '</tr>';



			}



		} catch(PDOException $e) {

		    echo $e->getMessage();

		}

	?>

	</table>



	<p><a href='add-images.php'>Add Image</a></p>



</div>

</body>

</html>