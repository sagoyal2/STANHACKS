<?php
// INIT
require "config.php";
require "database.php";
$pdoUsers = new Users();
$regPass = true;
$checks = "";

// PROCESS REGISTRATION CHECKS
// YOU MIGHT WANT TO CHANGE SOME OF THE CHEKCS HERE
// E.G. MINUMUM 5 CHARACTERS FOR THE NAME, PASSWORD STRENGTH, ETC...

// NAME
if ($_POST['name']=="") {
	$regPass = false;
	$checks .= "Please enter your name\n";
}

if($_POST['dorm']==""){
    $regPass = false;
    $checks .= "Please choose your dorm";
}
    $allowed = [
        'stanford.edu',
    ];

    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $parts = explode('@', $email);
    // Remove and return the last part, which should be the domain
    $domain = array_pop($parts);
    // Check if the domain is in our list
if ( ! in_array($domain, $allowed))
    {
        // Not allowed
    	$regPass = false;
        $checks .= "Please enter a valid Stanford email\n";
    }
// EMAIL
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
	$regPass = false;
	$parts = explode('@', $email);
    // Remove and return the last part, which should be the domain
    $domain = array_pop($parts);
	$checks .= "Please enter a valid Stanford email\n";
}
// CHECK IF EMAIL IS ALREADY REGISTERED
else {
	if ($pdoUsers->checkReg($_POST['email'])) {
		$regPass = false;
		$checks .= $_POST['email']." is already registered\n";
	}
}

// PASSWORD
// DO YOUR OWN MINIMUM PASSWORD STRENGTH TEST HERE
if ($_POST['password']=="") {
	$regPass = false;
	$checks .= "Please enter a password\n";
}

if ($_POST['cpassword']=="") {
	$regPass = false;
	$checks .= "Please confirm your password\n";
}

// CHECK IF PASSWORDS MATCH
if ($_POST['password']!=$_POST['cpassword']) {
	$regPass = false;
	$checks .= "Passwords do not match\n";
}

// IF CHECKS ARE ALL GREEN - GO FOR ACTUAL DATABASE REGISTRATION
if ($regPass) {
	if (!$pdoUsers->register([$_POST['name'], $_POST['email'], $_POST['password'], $_POST['year'], $_POST['dorm']])) {
		$regPass = false;
		$checks = "Error with registration";
	}
}

// THE RESULTS
echo json_encode([
	"status" => $regPass,
	"message" => $checks
]);
?>
