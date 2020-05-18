<?php //include config

require_once('../../../includes/config.php');



//if not logged in redirect to login page


if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 1) { header('Location: ../../teacher/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }



		try {


//find video with the id of the selected choice by user and set selected to 0 
			$stmt = $db->prepare('SELECT videoID, selected FROM videos WHERE videoID= :videoID') ;

			$stmt->execute(array(':videoID' => $_GET['id']));


			$row = $stmt->fetch(); 
                          $chosen = $row['videoID'];

         $stmt = $db->prepare('UPDATE videos SET selected= :selected WHERE videoID= :videoID') ;

				$stmt->execute(array(

					':selected' => 0,

					':videoID' => $chosen

				));


//fnd all videos where the id does not match the selected video and set selected to 1
         $stmt = $db->prepare('UPDATE videos SET selected= :selected WHERE videoID!= :videoID') ;

				$stmt->execute(array(

					':selected' => 1,

					':videoID' => $chosen

				));


				//redirect to videos page

				header('Location: videos.php?action=selected');

				exit;



			} catch(PDOException $e) {

			    echo $e->getMessage();

			}



	?>



