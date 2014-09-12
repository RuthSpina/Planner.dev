<?php

define('FILENAME', 'data/data1.txt');

// update list
function open_file($file_input = FILENAME) {
    $handle = fopen($file_input, 'r');
    $content = trim(fread($handle, filesize($file_input)));
    $new_list = explode("\n", $content);
    fclose($handle);
    return $new_list;
}

//save list to filename
function save_to_file($items, $file_path = FILENAME) {
    $handle = fopen($file_path, 'w');
    foreach($items as $item){
        fwrite($handle, strip_tags($item) . "\n");
    }
    fclose($handle);
}

$items = open_file();
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

//$items = [];


// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['file1']['error'] === UPLOAD_ERR_OK && $_FILES['file1']['type'] === 'text/plain'){
    
    $upload = $_FILES['file1'];

    //directing where php will save uploaded file
    $uploadPath = '/vagrant/sites/planner.dev/public/uploads/';

    //this ensures that you are only identifying the new file by the name not including the path
    $uploadBasename = basename($upload['name']);

    //names the new file, which was determined by the concatination of the uploaded file and path
    $newFile = $uploadPath . $uploadBasename;

    //This moves the file to the temp folder
    move_uploaded_file($upload['tmp_name'], $newFile);

    // grab new items in file converted to array
    $newitems = open_file('uploads/' . $uploadBasename);
    
    // grab new file and convert contents to array
    $items = array_merge($items, $newitems);
    save_to_file($items);
}

// Check if we saved a file
if (isset($saved_filename)) {
    // If we did, show a link to the uploaded file
    echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>To Do List</title>
	<link rel="stylesheet" href="css/todo.css"/>
</head>
<body>
<h1>To Do List:</h1>
    <ul>
    <? foreach($items as $key => $item): ?>
    <li><?= "<a href=". "?remove=$key" .">Complete</a>-".strip_tags("$item");?></li>
    <? endforeach; ?>
    </ul>
<h1>New Item:</h1>
<form method="POST" action="/todo_list.php">
    <label for="new_item">New Item:</label>
    <input id="new_item" name="new_item" type="text" placeholder ="Enter New Item">
    <input type="submit">
</form>

<h1>Add a File:</h1>
<form name= "additem" enctype="multipart/form-data" method="POST" action="/todo_list.php">
    <label for="file1">File to upload: </label>
    <input type="file" id="file1" name="file1"><br>
    <input type="submit" value="Upload">
</form>
</body>
</html>
