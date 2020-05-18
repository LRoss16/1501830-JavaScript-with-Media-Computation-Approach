<?php

require_once('../../../includes/config.php');
$username =  $_SESSION['username'];

//if not logged in redirect to login page


if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 0) { header('Location: ../../admin/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }
?>


<ul id='usermenu'>

	<li><?php if ($_SESSION['memberType'] == 1) {?><a href='about.php'>About Section</a></li><?php } ?>

	<li><?php if ($_SESSION['memberType'] == 1) {?><a href='introduction.php'>Introduction</a></li><?php } ?>

	<li><?php if ($_SESSION['memberType'] == 1){?><a href='whatIsJavaScript.php'>What is JavaScript?</a></li><?php } ?>

	<li><?php if ($_SESSION['memberType'] == 1) {?><a href='strings.php'>Strings</a></li><?php } ?>

	<li><?php if ($_SESSION['memberType'] == 1) {?><a href='concatenation.php'>Concatenation</a></li><?php } ?>

	<li><?php if ($_SESSION['memberType'] == 1) {?><a href='controlCharacters.php'>Control Characters</a></li><?php } ?>

	<li><?php if ($_SESSION['memberType'] == 1) {?><a href='prompting.php'>Prompting</a></li><?php } ?>

	<li><?php if ($_SESSION['memberType'] == 1){?><a href='variables&operators.php'>Variables & Operators</a></li><?php } ?>

	<li><?php if ($_SESSION['memberType'] == 1) {?><a href='forLoops.php'>For Loops</a></li><?php } ?>

	<li><?php if ($_SESSION['memberType'] == 1) {?><a href='arrays.php'>Arrays</a></li><?php } ?>

	<li><?php if ($_SESSION['memberType'] == 1) {?><a href='functions.php'>Functions</a></li><?php } ?>

	<li><?php if ($_SESSION['memberType'] == 1) {?><a href='moreFunctions.php'>More Functions</a></li><?php } ?>

        <li><?php if ($_SESSION['memberType'] == 1) {?><a href='animations.php'>Animations</a></li><?php } ?>
       
        <li><?php if ($_SESSION['memberType'] == 1) {?><a href='imageData.php'>Image Data</a></li><?php } ?>

        <li><?php if ($_SESSION['memberType'] == 1){?><a href='images.php'>Upload Images</a></li><?php } ?>

        <li><?php if ($_SESSION['memberType'] == 1) {?><a href='video.php'>Video</a></li><?php } ?>

        <li><?php if ($_SESSION['memberType'] == 1) {?><a href='videos.php'>Upload Videos</a></li><?php } ?>

        <li><?php if ($_SESSION['memberType'] == 1) {?><a href='users.php'>Students</a></li><?php } ?>

       <li><?php if ($_SESSION['memberType'] == 1) {?><a href='quiz.php'>Quiz</a></li><?php } ?>

       <li><?php if ($_SESSION['memberType'] == 1) {?><a href='../index.php' target="_blank">View Your Site</a></li><?php } ?>


	<li><a href='../../logout.php'>Logout</a></li>

</ul>

