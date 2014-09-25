<!DOCTYPE=HTML>

<?php

require_once("address_book_code.php");
require '../dbconnection_address.php';

function new_array($items) {
    $new_items = [];
    foreach ($items as $key => $data) {
        $new_items[] = $data;
    }
    return $new_items;
}

class InvalidInputException extends Filestore {}

function checkLength($string) {
    $good = true;
    if (strlen($string) > 125) {
        throw new InvalidInputException ('ERROR: String length must be shorter than 125 characters.');
        $good = false;
    }
    return $good;
}

$book = new AddressDataStore('data/test.csv');
$book_array = $book->read();

if (!empty($_POST['name']) && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['state']) && !empty($_POST['zip']) && !empty($_POST['phone'])){
    // Define new entry to the array
    try {
        if (checkLength($_POST['name']) && checkLength($_POST['address']) && checkLength($_POST['city']) && checkLength($_POST['state']) && checkLength( $_POST['zip']) && checkLength( $_POST['phone'])){
            $newEntry = [$_POST['name'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['zip'], $_POST['phone']];
            array_push($book_array, $newEntry);
            // Write new array new file
            $book_array = new_array(array_values($book_array));
            $book->write($book_array);
        }
    } catch (Exception $e) {
        echo "ERROR: try again.";
    }
} elseif (isset($_POST['submit'])) {
    $error = "ERROR: One or more fields were empty";
} elseif (isset($_GET['key'])) {
    foreach ($book_array as $key => $data) {
        if ($_GET['key'] == $key) {
            unset($book_array[$key]);
            $book_array = new_array(array_values($book_array));
        }
        $book->write($book_array);
    }
}

if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {
    // Set the destination directory for uploads
    $upload_dir = '/vagrant/sites/planner.dev/public/data/address.csv';
    // Grab the filename from the uploaded file by using basename
    $filename = basename($_FILES['file1']['name']);
    // Create the saved filename using the file's original name and our upload directory
    $saved_filename = $upload_dir . $filename;
    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);

    $newBook = new AddressDataStore($saved_filename);

    $new = $newBook->read();

    if(isset($_POST['overwrite'])) {
    $book_array = $new;
    } else {
        foreach ($new as $key => $data) {
            array_push($book_array, $new[$key]);
        }
        $book_array = new_array($book_array);
    }

    $book->write($book_array);
}

?>
<html>
<head>
    <title>Address Book</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <style>
        table,th {
            border-collapse: collapse;
            padding: 15px;
            margin-top: 15px;
            margin-bottom: 15px;
            margin-left: auto;
            margin-right: auto;
            border-radius: 5px;
        }
        td {
            padding: 10px;
            border-radius: 5px;
        }
        #mainPage {
            margin-top: 15px;
            background-color: light gray;
            border-radius: 5px;
        }
       h1{
            text-align: center;
            margin: auto;
        }
        form {
            padding: 15px;
            margin: 15px;
        }
    </style>
</head>
<body>
    
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3" id="mainPage">
            <h1>Address Book</h1>
            <table>
                <tr>
                    <th>NAME</th><th>ADDRESS</th><th>CITY</th><th>STATE</th><th>ZIP</th><th>PHONE</th><th></th>
                </tr>
                <? foreach($book_array as $key => $address): ?>
                    <tr>
                        <? foreach($address as $data): ?>
                            <td><?= htmlspecialchars(strip_tags("{$data}")) ?></td>
                        <? endforeach; ?>
                        <td><?="<a class='btn btn-warning btn-xs' id='remove' name='remove' href='address.php?key=$key'> Remove &raquo;</a>" ?></td>
                    </tr>
                <? endforeach; ?>
            </table>
        </div>
    </div>

    <div class="container">
        <div class="col-xs-12" id="mainPage">
            <form method="POST">
                <p>
                    <label for="name">Name:</label>
                    <input id="name" name="name" type="text" value="<?if(isset($_POST['name']) && isset($error)){echo htmlspecialchars($_POST['name'], ENT_QUOTES);}?>">

                    <label for="address">Address:</label>
                    <input id="address" name="address" type="text" value="<?if(isset($_POST['address']) && isset($error)){echo htmlspecialchars($_POST['address'], ENT_QUOTES);}?>">

                    <label for="city">City:</label>
                    <input id="city" name="city" type="text" value="<?if(isset($_POST['city']) && isset($error)){echo htmlspecialchars($_POST['city'], ENT_QUOTES);}?>">

                    <label for="state">State:</label>
                    <input id="state" name="state" type="text" value="<?if(isset($_POST['state']) && isset($error)){echo htmlspecialchars($_POST['state'], ENT_QUOTES);}?>">

                    <label for="zip">Zip:</label>
                    <input id="zip" name="zip" type="text" value="<?if(isset($_POST['zip']) && isset($error)){echo htmlspecialchars($_POST['zip'], ENT_QUOTES);}?>">
                    
                    <label for="phone">Phone:</label>
                    <input id="phone" name="phone" type="text" value="<?if(isset($_POST['phone']) && isset($error)){echo htmlspecialchars($_POST['phone'], ENT_QUOTES);}?>">
                </p>
                <p id="button">
                    <button class="btn btn-success btn-md" type="submit" id="submit" name="submit">Submit</button>
                </p>
                <? if(isset($error)): ?>
                    <p>
                        <?= "{$error}" ?>
                    </p>
                <? endif; ?>
            </form>
        </div>
    </div>
    <div class="col-xs-4 col-xs-offset-4" id="mainpage">
        <form method="POST" enctype="multipart/form-data" action="address.php">
            <p>
                <label for="file1"><h2>File to upload: </h2></label>
                <input type="file" id="file1" name="file1">
            </p>
            <p>
                <input class="btn btn-success btn-md" type="submit" value="Upload">
                <!-- <form method="POST">
                <label><input type="checkbox" name="overwrite" id="overwrite" value="yes">Overwrite Current List</label>
                </form> -->
            </p>
        </form>
    </div>


</body>
</html>
