<!-- Homeppage of website -->
<!DOCTYPE html>
<?php
//Connect to database
require_once('includes/config.php');
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equipv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JavaScript With Media Computation</title>
<link rel="stylesheet" href="css/footer.css"> 
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
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
padding-top: 200px;
margin-bottom: 100px;
overflow: auto;
}

#about #register  {
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

 #about #register{
height: 20em;
margin-bottom: 1em;
background-color: #efefef;

}

#about p {
text-align: center;
}

#register p {
text-align: center;
}

#registerContent {
margin-bottom: 150px;
}

#registerContent h1{
text-align: center;
}
#submit{
  background-color:   #a6a6a6;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}

		.form-control
		{
		
		width: 90%;
		background:transparent;
		border:none;
		outline:none;
		border-bottom: 1px solid gray;
		color: #030d0f;
		font-size: 18px;
		margin-bottom: 16px;
		text-align: center;
		
		}

</style>
</head>
<body>

<div class="navbar" >
 <script src="js/greeting.js"></script>
<img src ="images/JSMC Logo.png" align="left" width="10%">
<a href="#home">Home</a>
  <a href="#about">About</a>
  <a href="#learn">Learn</a>
<a href="#test ">Test Yourself</a>
<a href="#contact">Contact</a>
<a href="users/login.php">Login</a>
<a href="#register">Register</a>


</div>

<div id="content">
<div id="about">
		<?php
		//grab the content from the about table in the database
		//The content made by the admin is displayed here
			try {

				$stmt = $db->query('SELECT postTitle, postCont  FROM about WHERE editedBy = "admin" ');
				while($row = $stmt->fetch()){
					
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
<div id ="test">
<h3>Ready For a Test?</h3>
<p>Click <a href="test.php">here</a> to test your knowledge</p>
</div>
</div>

<div class="article column3">
<div id="contact">
<h3>Contact Us</h3>
<p><i class="fa fa-envelope fa-fw -xxlarge -margin-right"> </i> Email: <a href = "mailto: l.s.ross@rgu.ac.uk">l.s.ross@rgu.ac.uk</a></p>
</div>
</div>



<div id="registerContent">
<div id="register">
<h1>Register</h1>
<p>If you are a teacher who would like to set up an account, please enter your name, email address and message why you are wanting an account</p>
<p>Please note that only teachers from schools can setup an account with us, from there they can then add their students if they wish</p>
<br><br>
<div class align="center" = "registerForm">
		<input name="name" type="text" id="name" class="form-control" placeholder="Your name" required>
		<br><br>
		<input name="email" type="email" id="emails" class="form-control" placeholder="Your email" required>
		<br><br>		
		<textarea name="userMessage" id="userMessage" class="form-control" placeholder="Message" row="4" required></textarea><br><br>
	<button type="submit" id="submit">Submit</button>
	<div id="result" style="margin-top: 50px;"></div> 
</div>

</div>
</div>


        <!--End Page Content-->
        <footer class="footer">
            <div class="container">
                <p class="text-muted"><p>Lewis Ross 1501830 Honours Project</p>
            </div>

		<script src="https://code.jquery.com/jquery-1.11.3.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	//This script will take the values entered by the user and put them to the file action.php
	//The file will then check whether the email input is correct and if the email has already been used
	//Once the checks have been done a message will be displayed at the bottom of the register form
		$(document).ready(function() {
			$('#emails');
			$('#name');
			$('#userMessage');
			$('#emails').keypress(function(event) {
				var email = $('#emails').val();
			$('#name').keypress(function(event) {
                                var name =$('#name').val();
			$('#userMessage').keypress(function(event) {
                                var userMessage = $('#userMessage').val();
				var keyCode = event.keyCode;
				if (keyCode == 13) {
					$.ajax({
						type: 'POST',
						url: 'action.php',
						data: {email: email,
                                                 name: name,
                                                 userMessage: userMessage},
						success: function(data) {
							$('#result').hide();
							$('#result').html(data);
							$('#result').fadeIn();
						}
					});
				};
			});
			});
			});
			$('#submit').click(function () {
				var email = $('#emails').val();
                                var name =$('#name').val();
                                var userMessage = $('#userMessage').val();
				$.ajax({
					type: 'POST',
					url: 'action.php',
			                         data: {email: email,
                                                 name: name,
                                                 userMessage: userMessage},
					success: function(data) {
						$('#result').hide();
						$('#result').html(data);
						$('#result').fadeIn();
					}
				});
			});
		});
	</script>
  
        </footer>
</body>
</html>