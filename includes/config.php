<?php
//This page is where the conenction of the database takes place
ob_start();
session_start();

//database credentials
define('DBHOST','localhost');
define('DBUSER','********');
define('DBPASS','********');
define('DBNAME','********');

$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//echo password_hash("admin", PASSWORD_BCRYPT);

//set timezone
date_default_timezone_set('Europe/London');

//load classes as needed
spl_autoload_register(function ($class) {
   
   $class = strtolower($class);

	//if call from within first folder adjust the path
   $classpath = 'classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	} 	
	
	//if call from within users adjust the path
   $classpath = '../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	}
	
	//if call from within users adjust the path
   $classpath = '../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	} 	
	//if call from within admin/student/teacher adjust the path
   $classpath = '../../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	} 		
	
	//if call from within admin/teacher updates adjust the path
	   $classpath = '../../../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	} 
	 
});

$user = new User($db); 
?>