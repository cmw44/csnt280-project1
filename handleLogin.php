<?php
	require_once("../../include/project1/helpers.php");
	$pdo = connect();
     
	if(!$pdo) {
		die("Could not connect");
	}
	//Start a session to store data
	session_start();
	
	//echo "Connected.<br>";
	//var_dump($_POST);
	$email = $_POST['username'];
	$password = $_POST['password'];
	$id = check_id($email,$password);
	// Valid username and password
	if($id > 0) {
		// Store the id in $_SESSION global array
		$_SESSION['id'] = $id;
		
		header("Location: home.php");
		exit();
	}
	else {
		header("Location: login.php");
		exit();
	}
?>
