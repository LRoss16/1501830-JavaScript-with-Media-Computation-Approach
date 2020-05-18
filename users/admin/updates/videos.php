<?php

require_once('../../../includes/config.php');
$username =  $_SESSION['username'];


//if not logged in redirect to login page

if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 1) { header('Location: ../../teacher/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }

if(isset($_GET['delpost'])){ 



	$stmt = $db->prepare('DELETE FROM videos WHERE videoID= :videoID') ;

	$stmt->execute(array(':videoID' => $_GET['delpost']));



	header('Location: videos.php?action=deleted');

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

	  	window.location.href = 'videos.php?delpost=' + id;

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

		echo '<h3>Video '.$_GET['action'].'.</h3>'; 

	} 

	?>

<h1>Videos</h1>

<p>In this section you can change the videos used on the site</p>
	<table>

	<tr>

		<th>Video Title</th>

		<th>Video</th>

		<th>Action</th>

	</tr>

	<?php

		try {



			$stmt = $db->query('SELECT videoID, video, videoTitle FROM videos WHERE editedBy = "admin" ORDER BY videoID');

			while($row = $stmt->fetch()){

				

				echo '<tr>';

				echo '<td>'.$row['videoTitle'].'</td>';

				echo '<td>'.$row['video'].'</td>';

				?>



				<td>

					<a href="edit-videos.php?id=<?php echo $row['videoID'];?>">Edit</a> | 

					<a href="set-videos.php?id=<?php echo $row['videoID'];?>">Set Video For Example</a> | 

					<a href="javascript:delpost('<?php echo $row['videoID'];?>','<?php echo $row['videoTitle'];?>')">Delete</a>

				</td>

				

				<?php 

				echo '</tr>';



			}



		} catch(PDOException $e) {

		    echo $e->getMessage();

		}

	?>

	</table>



	<p><a href='add-videos.php'>Add Videos</a></p>



</div>

</body>

</html>