<?php
require_once 'address_book_code.php';
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
