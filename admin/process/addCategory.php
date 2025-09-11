<?php

session_start();
require('../database/connection.php');

if (isset($_GET['category_name'])) {

    if (isset($_SESSION['admin'])) {
        if (empty($_GET['category_name'])) {
            echo 'name empty';
        } else {
            $category_name = $_GET['category_name'];
            // Convert the brand name to lowercase for comparison
            $category_name_lower = strtolower($category_name);

            $brand_rs = Database::search("SELECT * FROM catagory WHERE LOWER(catagory_name)='$category_name_lower'");
            if ($brand_rs->num_rows != 0) {
                echo 'brand name allready exist!';
            } else {
                Database::iud("INSERT INTO catagory (catagory_name) VALUES('$category_name')");
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
