<?php
function addNewTask($task)
{
	include ("pdo.php");
	if(empty($task))
	{
		return "Please enter a task";
	}
	else
	{
		$sql = "INSERT INTO new (task, completed, new) VALUES (:task, :completed, :new)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':task'=>$task,
			':completed'=>0,
			':new'=>1
		));
		return "success";
	}
}
function addMessage()
{
	if(isset($_SESSION['error']))
	{
		echo $_SESSION['error'];
		unset($_SESSION['error']);
	}
}
function displayNew()
{
	include "pdo.php";
	$sql="SELECT new_id, task FROM new WHERE completed=0 AND new=1";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
	echo "<table>";
	while($data=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		echo '<tr><td>';
		echo '<form method="post" action="index.php">';
		echo '<input type="hidden" name="new_id" value="'.$data['new_id'].'" />';
		echo '<input type="submit" name="completeTask" value="✔" />';
		echo '</form>';
		echo '</td><td>';
		echo $data['task'];
		echo '</td></tr>';
	}
	echo '</table>';
}
function completeTask($new_id)
{
	include ("pdo.php");
	if(empty($new_id))
	{
		return "Please enter a task";
	}
	else
	{
		$sql = "UPDATE new SET completed = :completed, new = :new WHERE new_id = :new_id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':new_id'=>$new_id,
			':completed'=>1,
			':new'=>0
		));
	}
}
function displayCompleted()
{
	include "pdo.php";
	$sql="SELECT new_id, task FROM new WHERE completed=1 AND new=0";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
	echo '<table>';
	echo '<form method="post" action="index.php">';
	echo '<input type="submit" name="clear_all" value="Clear all"/><br/><br/>';
	while($data=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		echo '<tr><td>';
		echo '<input type="checkbox" name="complete[]" value="'.$data['new_id'].'"/>';
		echo '</td><td>';
		echo '<del>'.$data['task'].'</del>';
		echo '</td><td>';
		echo '<a href="index.php?id='.$data['new_id'].'">❌</a>';
		echo '</td></tr>';
	}
	echo '</table>';
	echo '<br/>';
	echo '<input type="submit" name="delete" value="Delete selected"/>';
	echo '</form>';
}
function deleteSelected($list)
{
	include "pdo.php";
	$sql="DELETE FROM new WHERE new_id = :new_id AND completed=:completed";
	for($i=0; $i<count($list); $i++)
	{	
		$stmt=$pdo->prepare($sql);
		$stmt->execute(array(
			':new_id'=>$list[$i],
			':completed'=>1
		));
	}
}
function clearAll()
{
	include "pdo.php";
	$sql="DELETE FROM new WHERE completed=:completed";
	$stmt=$pdo->prepare($sql);
	$stmt->execute(array(
		':completed'=>1
	));
}
function deleteSingle($id)
{
	include "pdo.php";
	$sql="DELETE FROM new WHERE new_id = :new_id";
	$stmt=$pdo->prepare($sql);
	$stmt->execute(array(
		':new_id'=>$id
	));
}
?>