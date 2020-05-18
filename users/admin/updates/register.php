<?php

require_once('../../../includes/config.php');
$username =  $_SESSION['username'];


//if not logged in redirect to login page

if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 1) { header('Location: ../../teacher/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }

if(isset($_GET['delpost'])){ 



	$stmt = $db->prepare('DELETE FROM registerInterest WHERE registerID = :registerID') ;

	$stmt->execute(array(':registerID' => $_GET['delpost']));



	header('Location: register.php?action=deleted');

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

	  	window.location.href = 'register.php?delpost=' + id;

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

		echo '<h3>Interest '.$_GET['action'].'.</h3>'; 

	} 

	?>

<h1>Interested Peple</h1>

<p>In this section  you can view the people interested in setting up an account</p>
	<table>

	<tr>

		<th>Name</th>

		<th>Email</th>

		<th>View</th>

	</tr>

	<?php

		try {



			$stmt = $db->query('SELECT registerID, name, email, message FROM registerInterest ORDER BY registerID');

			while($row = $stmt->fetch()){

				

				echo '<tr>';

				echo '<td>'.$row['name'].'</td>';

				echo '<td>'.$row['email'].'</td>';

				?>



				<td>
					<a href="view-register.php?id=<?php echo $row['registerID'];?>">View</a> |

                           <a href="javascript:delpost('<?php echo $row['registerID'];?>','<?php echo $row['name'];?>')">Delete</a>
				</td>

				

				<?php 

				echo '</tr>';



			}



		} catch(PDOException $e) {

		    echo $e->getMessage();

		}

	?>

	</table>

</div>

</body>

</html>