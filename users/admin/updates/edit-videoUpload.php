<?php

require_once('../../../includes/config.php');

//if not logged in redirect to login page


if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 1) { header('Location: ../../teacher/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }

    if(isset($_POST["submit"])) {


    //collect form data

    extract($_POST);


    $allowedExts = array("ogg", "mp4", "wma");
    $extension = pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);

    if ((($_FILES["video"]["type"] == "video/mp4")
        || ($_FILES["video"]["type"] == "video/ogg")
        || ($_FILES["video"]["type"] == "video/wma")

        && ($_FILES["video"]["size"] < 16000000 )
        && in_array($extension, $allowedExts))){ //comma missing


        if ($_FILES["video"]["error"] > 0)
        {
            echo "Return Code: " . $_FILES["video"]["error"] . "<br />";
        }


        else
        {
            echo "Upload: " . $_FILES["video"]["name"] . "<br />";
            echo "Type: " . $_FILES["video"]["type"] . "<br />";
            echo "Size: " . ($_FILES["video"]["size"] / 1024) . " Kb<br />";
            echo "Temp file: " . $_FILES["video"]["tmp_name"] . "<br />";
           $upload =  $_FILES["video"]["name"];

            if (file_exists("../videos/" . $_FILES["video"]["name"]))
            {
                echo $_FILES["video"]["name"] . " already exists. ";
            }
            else
            {
                move_uploaded_file($_FILES["video"]["tmp_name"],
                    "../videos/" . $_FILES["video"]["name"]);
                echo "Stored in: " . "../videos/" . $_FILES["video"]["name"];
            }
        }

    }else{
        echo "Invalid file";
    }

			try {


                             //update database
			
				$stmt = $db->prepare('UPDATE videos SET videoTitle= :videoTitle, video= :video WHERE videoID= :videoID') ;

				$stmt->execute(array(

					':videoTitle' => $videoTitle,

					':video' => $upload,

					':videoID' => $id

				));



				//redirect to videos page

				header('Location: videos.php?action=edited');

				exit;



			} catch(PDOException $e) {

			    echo $e->getMessage();

			}

}
?>