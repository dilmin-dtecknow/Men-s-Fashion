<?php
require('database/connection.php');

$category_rs = Database::search("SELECT * FROM catagory");

$color_rs = Database::search("SELECT * FROM colour");

$size_rs= Database::search("SELECT * FROM size");

$brand_rs= Database::search("SELECT * FROM brand");
?>

