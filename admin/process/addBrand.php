<?php

session_start();
require('../database/connection.php');

if (isset($_GET['b_name'])) {

    if (isset($_SESSION['admin'])) {
        if (empty($_GET['b_name'])) {
            echo 'name empty';
        } else {
            $brand_name = $_GET['b_name'];
            // Convert the brand name to lowercase for comparison
            $brand_name_lower = strtolower($brand_name);

            $brand_rs = Database::search("SELECT * FROM brand WHERE LOWER(brand_name)='$brand_name_lower'");
            if ($brand_rs->num_rows != 0) {
                echo 'brand name allready exist!';
            } else {
                Database::iud("INSERT INTO brand (brand_name) VALUES('$brand_name')");
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
