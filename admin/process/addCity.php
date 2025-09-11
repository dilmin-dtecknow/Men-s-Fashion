<?php

session_start();
require('../database/connection.php');

if (isset($_GET['city_name']) && isset($_GET['shiping'])) {

    if (isset($_SESSION['admin'])) {
        if (empty($_GET['city_name'])) {
            echo 'name empty';
        } else if (empty($_GET['shiping'])) {
            echo 'shiping empty';
        } else if ($_GET['shiping'] < 0 || !is_numeric($_GET['shiping'])) {
            echo 'Maximum 0';
        } else {
            $city_name = $_GET['city_name'];
            $shiping = $_GET['shiping'];
            // Convert the brand name to lowercase for comparison
            $city_name_lower = strtolower($city_name);

            $brand_rs = Database::search("SELECT * FROM city WHERE LOWER(name)='$city_name_lower'");
            if ($brand_rs->num_rows != 0) {
                echo 'city name allready exist!';
            } else {
                Database::iud("INSERT INTO city (name,shipping_charge) VALUES('$city_name','$shiping')");
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
