<?php
//This page is called when someone is trying to login. It will get the details of the user
//connect to database
include('class.password.php');

class User extends Password{

    private $db;

	function __construct($db){
		parent::__construct();

		$this->_db = $db;
	}

	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}else {
		//echo "You do not have access to this page";
		
		}
	}

//Get user's username
	private function get_user_hash($username){

		try {

			$stmt = $this->_db->prepare('SELECT memberID, name, username, email, password, memberType, passwordChange, teacher FROM users WHERE username = :username');
			$stmt->execute(array('username' => $username));

			return $stmt->fetch();

		} catch(PDOException $e) {
		    echo '<p class="error">'.$e->getMessage().'</p>';
		}
	}


	public function login($username,$password){

		$user = $this->get_user_hash($username);

//check whether password is correct
		if($this->password_verify($password,$user['password']) == 1){

//set session variables with user details
		    $_SESSION['loggedin'] = true;
		    $_SESSION['memberID'] = $user['memberID'];
		    $_SESSION['name'] = $user['name'];
		    $_SESSION['username'] = $user['username'];
		    $_SESSION['email'] = $user['email'];
            $_SESSION['memberType'] = $user['memberType'];
            $_SESSION['passwordChange'] = $user['passwordChange'];    
             $_SESSION['teacher'] = $user['teacher'];                            
		    return true;
		}
	}


//logout
	public function logout(){
		session_destroy();
	}

}


?>