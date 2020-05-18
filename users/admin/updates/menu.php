<?php
//This page is the menu that is displayed on the admin pages
require_once('../../../includes/config.php');
$username =  $_SESSION['username'];

//if not logged in redirect to login page


if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 1) { header('Location: ../../teacher/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }
?>


<ul id='usermenu'>

	<li><?php if ($_SESSION['username'] == 'admin') {?><a href='index.php'>Index</a></li><?php } ?>

	<li><?php if ($_SESSION['username'] == 'admin') {?><a href='about.php'>About Section</a></li><?php } ?>

	<li><?php if ($_SESSION['username'] == 'admin') {?><a href='introduction.php'>Introduction</a></li><?php } ?>

	<li><?php if ($_SESSION['username'] == 'admin') {?><a href='whatIsJavaScript.php'>What is JavaScript?</a></li><?php } ?>

	<li><?php if ($_SESSION['username'] == 'admin') {?><a href='strings.php'>Strings</a></li><?php } ?>

	<li><?php if ($_SESSION['username'] == 'admin') {?><a href='concatenation.php'>Concatenation</a></li><?php } ?>

	<li><?php if ($_SESSION['username'] == 'admin') {?><a href='controlCharacters.php'>Control Characters</a></li><?php } ?>

	<li><?php if ($_SESSION['username'] == 'admin') {?><a href='prompting.php'>Prompting</a></li><?php } ?>

	<li><?php if ($_SESSION['username'] == 'admin') {?><a href='variables&operators.php'>Variables & Operators</a></li><?php } ?>

	<li><?php if ($_SESSION['username'] == 'admin') {?><a href='forLoops.php'>For Loops</a></li><?php } ?>

	<li><?php if ($_SESSION['username'] == 'admin') {?><a href='arrays.php'>Arrays</a></li><?php } ?>

	<li><?php if ($_SESSION['username'] == 'admin') {?><a href='functions.php'>Functions</a></li><?php } ?>

	<li><?php if ($_SESSION['username'] == 'admin') {?><a href='moreFunctions.php'>More Functions</a></li><?php } ?>

        <li><?php if ($_SESSION['username'] == 'admin') {?><a href='animations.php'>Animations</a></li><?php } ?>
       
        <li><?php if ($_SESSION['username'] == 'admin') {?><a href='imageData.php'>Image Data</a></li><?php } ?>

        <li><?php if ($_SESSION['username'] == 'admin') {?><a href='images.php'>Upload Images</a></li><?php } ?>

        <li><?php if ($_SESSION['username'] == 'admin') {?><a href='video.php'>Video</a></li><?php } ?>

        <li><?php if ($_SESSION['username'] == 'admin') {?><a href='videos.php'>Upload Videos</a></li><?php } ?>

        <li><?php if ($_SESSION['username'] == 'admin') {?><a href='users.php'>Users</a></li><?php } ?>

        <li><?php if ($_SESSION['username'] == 'admin') {?><a href='register.php'>Interested People</a></li><?php } ?>

        <li><?php if ($_SESSION['username'] == 'admin') {?><a href='quiz.php'>Quiz</a></li><?php } ?>


	<li><a href="../../../index.php" target="_blank">View Website</a></li>

	<li><a href='../../logout.php'>Logout</a></li>

</ul>

