<?php
require_once("../../include/project1/helpers.php");
$pdo = connect();
     
if(!$pdo) {
	die("Could not connect");
}

// Start session to get data
session_start(); 
// Retrieve the id from the session array
$id = $_SESSION['id'];


$sql = "select * from users where id=:id";
$statement = $pdo->prepare($sql);
$myarray=array();
$myarray[':id'] =$id;
$statement->execute($myarray);

if ($statement->rowCount()==1) {
	$row=$statement->fetch(PDO::FETCH_ASSOC);
	//var_dump($row);
	$display = $row["first_name"]." ".$row["last_name"];
}

?>

<html>
	<body>
		<h1> Welcome, 
			<?php
				echo $display;
			?>
		</h1> <br>
		
		<a href="login.php">logout</a>
	</body>
</html>
