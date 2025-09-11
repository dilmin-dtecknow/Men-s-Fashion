<?php

session_start();
require('../database/connection.php');

if (isset($_GET['color_name'])) {

    if (isset($_SESSION['admin'])) {
        if (empty($_GET['color_name'])) {
            echo 'name empty';
        } else {
            $color_name = $_GET['color_name'];
            // Convert the brand name to lowercase for comparison
            $color_name_lower = strtolower($color_name);

            $brand_rs = Database::search("SELECT * FROM colour WHERE LOWER(color_name)='$color_name_lower'");
            if ($brand_rs->num_rows != 0) {
                echo 'colour name allready exist!';
            } else {
                Database::iud("INSERT INTO colour (color_name) VALUES('$color_name')");
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
