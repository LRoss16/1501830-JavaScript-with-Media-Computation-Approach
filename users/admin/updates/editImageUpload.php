<?php

require_once('../../../includes/config.php');

//if not logged in redirect to login page


if(!$user->is_logged_in()){ header('Location: ../../login.php'); }

//If not got access redirect user

if($_SESSION['memberType'] == 1) { header('Location: ../../teacher/index.php'); }

if($_SESSION['memberType'] == 2) { header('Location: ../../student/index.php'); }

$target_dir = "../images/";

$target_file = $target_dir . basename($_FILES["image"]["name"]);

$uploadOk = 1;

$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image

if(isset($_POST["submit"])) {

	

			//collect form data

		extract($_POST);

		

    $check = getimagesize($_FILES["image"]["tmp_name"]);

    if($check !== false) {

        echo "File is an image - " . $check["mime"] . ".";

        $uploadOk = 1;

    } else {

        echo "File is not an image.";

        $uploadOk = 0;

    }

}

// Check if file already exists

if (file_exists($target_file)) {

    echo "Sorry, file already exists.";

    $uploadOk = 0;

}

// Check file size

if ($_FILES["image"]["size"] > 2000000) {

    echo "Sorry, your file is too large.";

    $uploadOk = 0;

}

// Allow certain file formats

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"

&& $imageFileType != "gif" ) {

    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

    $uploadOk = 0;

}

// Check if $uploadOk is set to 0 by an error

if ($uploadOk == 0) {

    echo "Sorry, your file was not uploaded.";

// if everything is ok, try to upload file

} else {

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

        echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";

    } else {

        echo "Sorry, there was an error uploading your file.";

    }

}

		$upload =  basename( $_FILES["image"]["name"]);



			try {



				//update database

				$stmt = $db->prepare('UPDATE images SET image_title = :image_title, image = :image WHERE imageID = :imageID') ;

				$stmt->execute(array(

					':image_title' => $image_title,

					':image' => $upload,

					':imageID' => $id

				));



				//redirect to images page

				header('Location: images.php?action=added');

				exit;



			} catch(PDOException $e) {

			    echo $e->getMessage();

			}

?>