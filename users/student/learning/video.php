<?php

require_once('../../../includes/config.php');
if(!$user->is_logged_in()){ header('Location: ../../login.php'); }
$username =  $_SESSION['username'];
if($_SESSION['memberType'] == 1) { header('Location: ../../teacher/index.php'); }

if($_SESSION['memberType'] == 0) { header('Location: ../../admin/index.php'); }

?>

<!DOCTYPE html> 
<title>Video/Canvas Demo 2</title> 
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
	
try {
			$stmt = $db->prepare('SELECT teacher FROM users WHERE username= :user') ;

			$stmt->bindParam(':user', $username, PDO::PARAM_STR);
                         $stmt->execute();

			$row = $stmt->fetch(); 
   

              $teacher = $row['teacher'];
              echo $teacher;

			$stmt= $db->prepare('SELECT video, videoTitle FROM videos WHERE editedBy= :teacher AND selected = 0') ;
			$stmt->bindParam(':teacher', $teacher, PDO::PARAM_STR);
                         $stmt->execute();
		while($row = $stmt->fetch()){
                    $video = $row['video'];
		}
			   
		} catch(PDOException $e) {

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