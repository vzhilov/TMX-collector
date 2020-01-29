<?php

$tmxDir = "/home/";

$tmx_db = mysqli_connect('localhost', 'tmx', 'mypass', 'tmx');

//mysqli_query($tmx_db, 'CREATE TEMPORARY TABLE `table`');

$files = glob($tmxDir.'*.txt');

//var_dump($files);

foreach ($files as $file) {

echo strtolower(substr($file, -7, 3))."\r\n";

}

?>
