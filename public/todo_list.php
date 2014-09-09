<!DOCTYPE html>
<?php
//$items= ['Walk the dog', 'Take out the trash', 'Mow the lawn'];
define('FILENAME', 'data/data1.txt');


// update list
   function open_file($file_input = FILENAME){
    $handle = fopen($file_input, 'r');
    $content = trim(fread($handle, filesize($file_input)));
    $new_list = explode("\n", $content);
    fclose($handle);
    return $new_list;
    }


//save list to filename
    function save_to_file($items, $file_path = FILENAME){
        $handle = fopen($file_path, 'w');
        foreach($items as $item){
        fwrite($handle, $item.PHP_EOL);
        }

        fclose($handle);
    }
    $items = [];
    $items = open_file();

?>
<html>
<head>
	<title>To Do List</title>
	<link rel="stylesheet" href="css/todo.css"/>
</head>
<body>
<h1>To Do List:</h1>
    <ul>
    <?php
        if (isset($_POST['new_item'])){
    $items[]= $_POST['new_item'];
    save_to_file($items);
    }
    if(isset($_GET['remove'])){
     $keyToRemove=$_GET['remove'];
     unset($items[$keyToRemove]);
     $items = array_values($items);
     save_to_file($items);
    }

    foreach ($items as $key => $item) {
    echo '<li> <a href=' . "?remove=$key" .'>Complete</a>-'. "$item</li>";
    }
    ?>
    </ul>
<h1>New Item:</h1>
 <form name= "additem" method="POST" action="/todo_list.php">
 <label for="new_item">New Item:</label>
        <input id="new_item" name="new_item" type="text" placeholder ="Enter New Item">

        <input type="submit">
</form>
</body>
</html>
