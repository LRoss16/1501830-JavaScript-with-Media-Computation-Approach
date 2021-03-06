<?php

//connect to database
require_once('../../../includes/config.php');
$username =  $_SESSION['username'];
//if not logged in, redirect
if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }

if($_SESSION['memberType'] == 0) { header('Location: ../../admin/index.php'); }

?>

<!DOCTYPE html> 
<title>Video Demo</title> 
<p><a href="videos.php">Go Back</a></p>
<script> 
document.addEventListener('DOMContentLoaded', function(){
	var v = document.getElementById('v');
	var canvas = document.getElementById('c');
	var context = canvas.getContext('2d');
	var back = document.createElement('canvas');
	var backcontext = back.getContext('2d');
 
	var cw,ch;
 
	v.addEventListener('play', function(){
		cw = v.clientWidth;
		ch = v.clientHeight;
		canvas.width = cw;
		canvas.height = ch;
		back.width = cw;
		back.height = ch;
		draw(v,context,backcontext,cw,ch);
	},false);
 
},false);
 
function draw(v,c,bc,w,h) {
	if(v.paused || v.ended)	return false;
	// First, draw it into the backing canvas
	bc.drawImage(v,0,0,w,h);
	// Grab the pixel data from the backing canvas
	var idata = bc.getImageData(0,0,w,h);
	var data = idata.data;
	// Loop through the pixels, turning them grayscale
	for(var i = 0; i < data.length; i+=4) {
		var r = data[i];
		var g = data[i+1];
		var b = data[i+2];
		var brightness = (3*r+4*g+b)>>>3;
		data[i] = brightness;
		data[i+1] = brightness;
		data[i+2] = brightness;
	}
	idata.data = data;
	// Draw the pixels onto the visible canvas
	c.putImageData(idata,0,0);
	// Start over!
	setTimeout(draw,20,v,c,bc,w,h);
}
</script> 
 

 
<video id=v controls loop> 
 <?php
 
 //get video set by teacher
		try {

		$stmt = $db->prepare('SELECT `videoTitle`, `video` FROM `videos` where `editedBy` = :user AND selected = 0');
                $stmt->execute(array(':user' => $username));
		while($row = $stmt->fetch()){
                $video = $row['video'];

		}
	}catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>

	<source src="../../admin/videos/<?php echo $video;?>" type="video/mp4">
</video> 
<canvas id=c></canvas> 
 
<style> 
#c {
	position: absolute;
	top: 50%;
	left: 50%;
	margin: -180px 0 0 20px;
}
 
#v {
	position: absolute;
        height: 500px;
	top: 50%;
	left: 50%;
	margin: -180px 0 0 -500px;
}
</style> 