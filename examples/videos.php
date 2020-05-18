<!-- this page will display the video example -->
<?php
//Connect to database
require_once('../includes/config.php');

?>

<!DOCTYPE html> 
<title>Video Demo</title> 
<p><a href="../learning/videos.php">Go Back</a></p>
<script> 
//check for when video is being played and then copy onto canvas
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
	// start again
	setTimeout(draw,20,v,c,bc,w,h);
}
</script> 
 

 
<video id=v controls loop> 
 <?php
 //Get the video which has been selected by the admin to be used
		try {
		$stmt = $db->query('SELECT video, videoTitle FROM videos WHERE editedBy = "admin" AND selected = 0');
		while($row = $stmt->fetch()){
                $video = $row['video'];
		}
	}catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>

	<source src="../users/admin/videos/<?php echo $video;?>" type="video/mp4">
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