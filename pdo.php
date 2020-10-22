<?php
$hostname = 'localhost';
$dbname = 'todo';
$username = 'todo';
$password = 'todo';
try
{
	$pdo = new PDO("mysql: host=$hostname; dbname=$dbname", $username, $password);
}
catch(PDOException $pe)
{
	die("Could not connect to the database $dbname: ".$pe->getMessage());
}
?>
