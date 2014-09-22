<?php
require_once "../inc/filestore.php";

class TodoDataStore extends Filestore {
     function read_lines()
     {
         // TODO: refactor to use new $this->read_csv() method
        $this->filename;
     }

     function write_lines($items)
     {
         // TODO: refactor to use new write_csv() method
        $this->filename ($items, filename);
     }

 }
 ?>
