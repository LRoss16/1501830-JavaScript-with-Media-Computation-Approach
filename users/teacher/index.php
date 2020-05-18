<?php
//This page is the homepage for logged in teachers

//connect to database
require_once('../../includes/config.php');
$username =  $_SESSION['username'];

//if not logged in, redirect
if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//if not got access, redirect
if($_SESSION['memberType'] == 0) { header('Location: ../admin/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../student/index.php'); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equipv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JavaScript With Media Computation</title>
<link rel="stylesheet" href="../../css/footer.css"> 
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
   <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384- GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel ="stylesheet" href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
   <style>
   

 body {
width: 100%;
  margin:0;
  padding:0;
font-family: "Raleway", sans-serif;
background-color:  #ffffff

}

.navbar {
background-color: #ffffff;
position: fixed;
width: 100%;
 overflow: hidden;
}

.navbar a {
  float: left;
  display: block;
  color: #000000;
  text-align: center;
  font-weight: bold;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
padding-left: 200px;

}

.navbar a:hover {
  background: #ddd;
  color: black;
}

#content h1{
text-align: center;
}

#content h3{
text-align: center;
}


#content {
padding-top: 280px;
margin-bottom: 100px;
overflow: auto;
}

#about  {
height: 20em;
}

.column1, .column2, .column3 {
width: 31.3%;
float: left;
margin: 1%; 
overflow: overlay;  
}

.column3 {
margin-right: 0%;
}


#footer {
background-color: #efefef;
padding: 0.5em 0;

}

 .article {
height: 10em;
margin-bottom: 1em;
background-color: #efefef;

}

.article p {
text-align: center;
}

 #about{
height: 20em;
margin-bottom: 1em;
background-color: #efefef;

}

#about p {
text-align: center;
}



</style>
</head>
<body>

<div class="navbar" >
 <script src="../../../js/greeting.js"></script>
<h3>Welcome <?php echo $_SESSION['username'] ?></h3>
<p>This is the content your students will see</p>
<img src ="../../images/JSMC Logo.png" align="left" width="10%">
<a href="#home">Home</a>
  <a href="#about">About</a>
  <a href="#learn">Learn</a>
<a href="#test ">Test Yourself</a>
<a href="#contact">Contact</a>
<a href="updates/about.php">Edit Content</a>
<a href="changePassword.php">Change Password</a>
<a href="../logout.php">Logout</a>

</div>

<div id="content">
<div id="about">
		<?php
			try {
				
				//get the content where editedBy = the teachers username

				$stmt = $db->prepare('SELECT `postTitle`, `postCont` FROM `about` where `editedBy` = :user');
                                $stmt->execute(array(':user' => $username));
                                while($row = $stmt->fetch()) {
						echo '<h1>'.$row['postTitle'].'</h1>';
						echo '<p>'.$row['postCont'].'</p>';

}
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>
</div>
</div>

<div class="article column1">
<div id ="learn">
<h3>Want to learn?</h3>
<p>Click <a href="learning/introduction.php">here</a> to start learning JavaScript</p>
</div>
</div>
<div class="article column2">
<div id = "test">
<h3>Ready For a Test?</h3>
<p>Click <a href="test.php">here</a> to test your knowledge</p>
</div>
</div>

<div class="article column3">
<div id = "contact">
<h3>Contact Us</h3>
<p><i class="fa fa-envelope fa-fw -xxlarge -margin-right"> </i> Email: <a href = "mailto: l.s.ross@rgu.ac.uk">l.s.ross@rgu.ac.uk</a></p>
</div>
</div>




</div>


        <!--End Page Content-->
        <footer class="footer">
            <div class="container">
                <p class="text-muted"><p>Lewis Ross 1501830 Honours Project</p>
            </div>


  
        </footer>
</body>
</html>