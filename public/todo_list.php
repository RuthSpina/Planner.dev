<!DOCTYPE html>
<html>

<head>
	<title>To Do List</title>
	<link rel="stylesheet" href="css/todo.css"/>
</head>
<body>
<div id = "header">	
<h3>Post Data:</h3>	
<?php var_dump($_POST); ?>
<br>
<h3>Get Data:</h3>
<?php var_dump($_GET); ?>
<br>
</div>
<hr>
<h1>To Do List:</h1>
<table>
	<ul>
		<li>Walk the dog.</li>
		<li>Take out the trash.</li>
		<li>Mow the lawn.</li>		
	</ul>
</table>


<form>

<h1>To Do List Entry Form:</h1>
 <form method="POST" action="todo_list.php">

 <label for="new_item">New Item:</label>
        <input id="new_item" name="new_item" type="text" placeholder ="Enter New Item"><br><br>

        <input type="submit">

</form>		
</body>
</html>	