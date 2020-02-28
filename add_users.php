<?php
/* A file to add people to the project1_db */
require_once('../include/project1/helpers.php');
add_user('Jane','Doe','janedoe@gmail.com','janey');
add_user('John','Doe','johndoe@gmail.com','john');
add_user('Bill','Gates','billg@hotmail.com','windows');

$id=check_id('johndoe@gmail.com', 'john');
echo $id."\n";
$id=check_id('janedoe@gmail.com', 'janey');
echo $id."\n";
$id=check_id('billg@hotmail.com', 'janey');
echo $id."\n";
?>
