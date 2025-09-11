<?php

session_start();
require('../database/connection.php');

if (isset($_GET['size_name'])) {

    if (isset($_SESSION['admin'])) {
        if (empty($_GET['size_name'])) {
            echo 'name empty';
        } else {
            $size_name = $_GET['size_name'];
            // Convert the brand name to lowercase for comparison
            $size_name_lower = strtolower($size_name);

            $brand_rs = Database::search("SELECT * FROM size WHERE LOWER(size_name)='$size_name_lower'");
            if ($brand_rs->num_rows != 0) {
                echo 'brand name allready exist!';
            } else {
                Database::iud("INSERT INTO size (size_name) VALUES('$size_name')");
                echo 'success';
            }
        }
    } else {
        echo "unautorized actions";
    }
} else {
    echo 'some thing went wrong';
}

// echo 'server';
