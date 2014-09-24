<?php
require_once "../inc/filestore.php";

class AddressDataStore extends Filestore {
    
     function read_address_book()
     {
         // TODO: refactor to use new $this->read_csv() method
        return $this->read_csv();
     }

     function write_address_book($addresses_array)
     {
       $this->write_csv($addresses_array);
        // TODO: refactor to use new write_csv() method
     }

 }
 


?>
