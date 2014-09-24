<?php
require_once 'address_book_code.php';

$newBook = new AddressDataStore('../data/test.csv');
$people = $newBook->read_address_book();

if(!empty($_POST)){
    $newAddress = [
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['address'],
        $_POST['city'],
        $_POST['zip'],
        $_POST['phone']
    ];
$people[] = $newAddress;
$newBook->write_address_book($people);
}

if(isset($_GET['remove'])){
    $keyToRemove=$_GET['remove'];
    unset($people[$keyToRemove]);
    $people = array_values($people);
    $newBook->write_address_book($people);
}
// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['file1']['error'] === UPLOAD_ERR_OK){
    
    $upload = $_FILES['file1'];

    //directing where php will save uploaded file
    $uploadPath = '/vagrant/sites/planner.dev/public/data/address.csv';

    //this ensures that you are only identifying the new file by the name not including the path
    $uploadBasename = basename($_FILES['file1']['name']);

    //names the new file, which was determined by the concatination of the uploaded file and path
    $newFile = $uploadPath . $uploadBasename;

    //This moves the file to the temp folder
    move_uploaded_file($_FILES['file1']['tmp_name'], $newFile);
    $newFile = new AddressDataStore($newFile);
    $upload_items= $newFile->read_address_book();
    $people = array_merge($people, $upload_items);
    $newFile->write_address_book($people);
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
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<style>
.top{
    margin-left: 468px;
}
.row{
    margin-left:91px;
}
</style>
</head>
<body>
    <div class="jumbotron">
        <div class="top">
         <h1>Address Book:</h1><br>
            <ol>
            <? foreach($people as $key => $person):?>
                <li><?= "<a href=". "?remove=$key" .">Remove</a>-".implode($person, "      ");?></li>
            <? endforeach; ?>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class=".col-md-6 .col-md-offset-3">
            <h1>New Entry:</h1>
        <form method="POST" action="/address_book.php">
            <div><label for="first_name">First Name:</label>
        <input id="first_name" name="first_name" type="text" placeholder ="First Name">
        </div>
    <div>
        <label for="last_name">Last Name:</label>
        <input id="last_name" name="last_name" type="text" placeholder ="Last Name">
    </div>

    <div><label for="address">Street Address:</label>
        <input id="address" name="address" type="text" placeholder ="Street Address">
    </div>
    <div>
        <label for="city">City and State:</label>
        <input id="city" name="city" type="text" placeholder ="City, State">
    </div>
    <div>
        <label for="zip">Zip:</label>
        <input id="zip" name="zip" type="text" placeholder ="Zip">
    </div>

        <label for="phone">Phone:</label>
        <input id="phone" name="phone" type="text" placeholder ="000-000-0000">
    <div>
        <input type="submit">
    </div>
</form>

<h1>Add a File:</h1>
        <form name= "additem" enctype="multipart/form-data" method="POST" action="/address_book.php">
            <label for="file1">File to upload: </label>
            <input type="file" id="file1" name="file1"><br>
            <input type="submit" value="Upload">
        </form>
    </div>
</div>
</body>
</html>
