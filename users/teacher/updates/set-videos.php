<?php //include config

require_once('../../../includes/config.php');



//if not logged in redirect to login page


if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 0) { header('Location: ../../admin/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }



		try {



			$stmt = $db->prepare('SELECT videoID, selected FROM videos WHERE videoID= :videoID') ;

			$stmt->execute(array(':videoID' => $_GET['id']));


			$row = $stmt->fetch(); 
                          $chosen = $row['videoID'];

         $stmt = $db->prepare('UPDATE videos SET selected= :selected WHERE videoID= :videoID') ;

				$stmt->execute(array(

					':selected' => 0,

					':videoID' => $chosen

				));


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



