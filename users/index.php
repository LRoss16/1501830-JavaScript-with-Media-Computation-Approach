<?php
//connect to database
require_once('../includes/config.php');

//stop people accessing page when not logged in
if(!$user->is_logged_in()){ header('Location: login.php'); }

//direct user to reset password if password change value = 1
if($_SESSION['passwordChange'] == 1) { header('Location: resetPassword.php'); 


} else {

//redirect users based on member type
if($_SESSION['memberType'] == 0 && $_SESSION['passwordChange'] == 0) { header('Location: admin/updates/index.php'); }

if($_SESSION['memberType'] == 1 && $_SESSION['passwordChange'] == 0) { header('Location: teacher/index.php'); }

if($_SESSION['memberType'] == 2 && $_SESSION['passwordChange'] == 0) { header('Location: student/index.php'); }

}

?>
