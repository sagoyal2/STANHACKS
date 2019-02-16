<?php

class Users{
	private $pdo = null;

	function __construct(){
	// Auto-connect to database on creating object

		$this->pdo = new PDO(
			"mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASSWORD,
			[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false]
		);
	}

	function __destruct() {
        $this->pdo = null;
    }

	function get($email=""){
	// get() : get user by email

		$stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `user_email`=?");
		$stmt->execute(array($email));
		return $stmt->fetch();
	}

	function getID($id=""){
	// getID() : get user by ID

		$stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `id`=?");
		$stmt->execute(array($id));
		return $stmt->fetch();
	}

	function checkReg($email){
	// check() : check if given email is already registered

		// RETURNS TRUE IF EMPTY, FALSE IF ALREADY REGISTERED
		return !empty($this->get($email));
	}

	function register($data){
	// register() : register a new user
	// DO YOUR FORM CHECKS SOMEWHERE ELSE FIRST!
	// $data must be an array in the format of name, email, password

		// THIS IS RAW BASIC PROTECTION FOR THE PASSWORD
		// DO YOUR OWN ADVANCED ENCRYPTION
		$data['2'] = md5($data['2']);

		// USING THE DATA FIELD AS A RANDOM CONFIRMATION KEY
		$data['5'] = password_hash($data[5], PASSWORD_DEFAULT);;

		// INSERT INTO DATABASE
		$stmt = $this->pdo->prepare("INSERT INTO `users` (`user_name`, `user_email`, `user_password`, `user_year`, `user_dorm`, `user_data`) VALUES (?, ?, ?, ?, ?, ?)");
		$pass = $stmt->execute($data);


		// SEND COINFIRMATION EMAIL IF PASS
		if ($pass) {
		    $headers = 'From: Verum Admin<suverum@gmail.com>' . "\r\n" .
                'Reply-To: suverum@gmail.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
		    // CHANGE YOUR URL & MESSAGE HERE
			$msg = "Welcome to the Verum for students at Stanford University!\r\n \r\nThe Verum is a platform to facilitate engaging discussion among your peers. By signing up you're helping to enrich the discussion in your community! All that's left for you to do is to click the following link to confirm your registration!- \r\n http://www.suverum.com/3-confirm.php?id=".$this->pdo->lastInsertId()."&h=".$data['5'];

			// SEND EMAIL
			@mail($data['1'], "Welcome to the Verum - Confirm your email", $msg, $headers);
		}

		return $pass;
	}

	function verify($id, $hash){
	// verify() : verify given id and hash

		// GET THE USER
		$user = $this->getID($id);

		// NOT FOUND
		if (empty($user)) { return false;}

		// HASH NOT MATCH
		if ($user['user_data'] != $hash) { return false;}

		// IF ALL ELSE PASS, ACTIVATE ACCOUNT
		$stmt = $this->pdo->prepare("UPDATE `users` SET `user_status`='A' WHERE `id`=?");
		$pass = $stmt->execute([$id]);

		// SEND A WELCOME EMAIL IF YOU WANT...
		return $pass;
	}
}
?>
