<?php
/* this file contains PHP functions to help with project1
*/
function connect() {
	$pdoString = "pgsql:host=172.18.0.1 dbname=project1_db   user=bob " .
      " password=somepass";
	$pdo =new PDO($pdoString);
	return $pdo;
}
/*
echo "hello"."\n";

$hashedvalue = hash('sha512',"hello");

echo $hashedvalue."\n";

echo "time is ".time()."\n";

$salt = hash('sha512',time()."hello");

echo $salt."\n";

$enc_pass = hash('sha512',$salt."hello");
echo $enc_pass."\n";

$new_enc_pass = hash('sha512',$salt."hello");
echo $new_enc_pass."\n";
*/
function make_salt($text) {
	$salt = hash('sha512',time().$text);
	return $salt;
}

function make_enc_pass($salt,$text) {
	$enc_pass = hash('sha512',$salt.$text);
	return $enc_pass;
}

/*sleep(5);
$salt = make_salt("hello");
$enc_pass = make_enc_pass($salt,"hello");
echo "Function value ".$enc_pass."\n";
*/
/* Takes users first name, last name, email and password
 * as input and inserts it into the users table of project1_db 
 * Computes the salt and enc_pass for the provided plain text password
*/
function add_user($fn,$ln,$email,$password) {
	// Establish connection with project1_db
	$pdo = connect();
	if(!$pdo) {
		die("Could not connect.");
	}
	$salt = make_salt($password);
	$enc_pass = make_enc_pass($salt,$password);
	// Create an SQL string
	$sql = "insert into users(first_name,last_name,e_mail,salt,enc_pass) ".
			" values(:fname,:lname,:email,:salt,:enc_pass)";
	$statement = $pdo->prepare($sql);
	$myarray = array();
	$myarray[':fname']= $fn;
	$myarray[':lname']= $ln;
	$myarray[':email']= $email;
	$myarray[':salt']= $salt;
	$myarray[':enc_pass']= $enc_pass;
	$statement->execute($myarray);
}

/* A function that takes username and password as input
 * and returns the id number of user is valid
 * otherwise returns negative numbers
 */
 
function check_id($email,$password) {
	//Establish connection to database
	$pdo = connect();
	if(!$pdo) {
		die("Could not connect.");
	}
	$sql = "select * from users where e_mail=:email";
	$statement = $pdo->prepare($sql);
	$myarray=array();
	$myarray[':email'] =$email;
	$statement->execute($myarray);
	
	if($statement->rowCount()==0) {
		//echo "Invalid username\n";
		return -1;
	}
	else {
		//echo "Valid username\n";
		$row=$statement->fetch(PDO::FETCH_ASSOC);
		//var_dump($row);
		$id = $row['id'];
		$salt = $row['salt'];
		$enc_pass = $row['enc_pass'];
		$e_prime = make_enc_pass($salt,$password);
		if($e_prime==$enc_pass) {
			//echo "Password validated\n";
			return $id;
		}
		else {
			//echo "Password unaccepted\n";
			return -2;
		}
		
	}
} 


?>
