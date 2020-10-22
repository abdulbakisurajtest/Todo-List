<?php
require_once("pdo.php");
require_once("function.php");
session_start();

// add task
if(isset($_POST['addNewTask']))
{
	$addNewTask = addNewTask($_POST['task']);
	if($addNewTask!='success')
	{
		$_SESSION['error']=$addNewTask;
	}
	header('Location: index.php');
	return;
}

//complete task
if(isset($_POST['completeTask']))
{
	$completeTask = completeTask($_POST['new_id']);
	header('Location: index.php');
	return;
}

// remove/delete tasks
if(isset($_GET['id']))
{
	$deleteSingle = deleteSingle($_GET['id']);
	header('Location: index.php');
	return;
}
if(isset($_POST['delete']))
{
	$deleteSelected = deleteSelected($_POST['complete']);
	header('Location: index.php');
	return;
}
if(isset($_POST['clear_all']))
{
	$clearAll = clearAll();
	header('Location: index.php');
	return;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<header>
		<h1>Todo List using PHP-MySQL</h1>
	</header>
	<main>
		<h2>Tasks</h2>
		<p style="color: red;"><?php addMessage(); ?></p>
		<form method="post" id="addNewTask" action="index.php" autocomplete="off">
			<input type="text" name="task" placeholder="add new task" />
			<input type="submit" name="addNewTask" value="+" />
		</form>
		<br/>
		<?php displayNew(); ?>
		<h2>Completed</h2>
		<?php displayCompleted(); ?>
	</main>
</body>
</html>