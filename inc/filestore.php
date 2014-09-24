<?php

class Filestore {

    public $filename = '';

    function __construct($filename = '') 
    {
        $this->filename = $filename;
        if (substr($filename, -3) == 'txt') {
            $this->is_csv = false;
        } elseif (substr($filename, -3) == 'csv') {
            $this->is_csv = true;
        }

    }

    /**
     * Returns array of lines in $this->filename
     */
    private function read_lines()
    {
        $handle = fopen($this->filename, "r");
        $contents = fread($handle, filesize($this->filename));
        $array = explode("\n", $contents);
        fclose($handle);
        return $array;
    }

    /**
     * Writes each element in $array to a new line in $this->filename
     */
    private function write_lines($array)
    {
        $handle = fopen($this->filename, "w+");
        foreach ($array as $key => $data) {
            if ($key == count($array)) {
                fwrite($handle, $data);
            } else {
                fwrite($handle, $data . PHP_EOL);
            }
        }
        echo "Save Complete!\n";
        fclose($handle);
    }

    /**
     * Reads contents of csv $this->filename, returns an array
     */
    private function read_csv()
    {
        $handle = fopen($this->filename, "r");
        if (filesize($this->filename) == 0) {
            $array = [];
        } else {
            while (!feof($handle)) {
                $array[] = fgetcsv($handle);
            }
            foreach ($array as $key => $value) {
                if ($value == false) {
                    unset($array[$key]);
                }
            }
        }
        fclose($handle);
        return $array;
    }

    /**
     * Writes contents of $array to csv $this->filename
     */
    private function write_csv($array)
    {
        $handle = fopen($this->filename, "w+");
        foreach($array as $data) {
            fputcsv($handle, $data);
        }
        fclose($handle);
    }

    function read () {
        if ($this->is_csv) {
            return $this->read_csv();
        } else {
            return $this->read_lines();
        }
    }  
    function write ($array) {
        if ($this->is_csv) {
            $this->write_csv($array);
        } else {
            $this->write_lines($array);
        }
    }

}
