<?php

session_start();
require('../database/connection.php');

if (isset($_GET['city_name']) || isset($_GET['city_id']) || isset($_GET['shipping'])) {
    if (isset($_SESSION['admin'])) {
        // echo 'ok';

        if (empty($_GET['city_name'])) {
            echo 'name empty';
        } else if (empty($_GET['shipping'])) {
            echo 'shiping empty';
        } else if ($_GET['shipping'] < 0 || !is_numeric($_GET['shipping'])) {
            echo 'Maximum 0';
        } else {
            $new_city_name = $_GET['city_name'];
            $new_shipping = $_GET['shipping'];
            $city_id = $_GET['city_id'];

            // echo $brand_id;
            // echo $new_brand_name;

            Database::iud("UPDATE city SET name='$new_city_name',shipping_charge='$new_shipping' WHERE id='$city_id'");
            echo "success";
        }
    } else {
        echo "unautorized actions";
    }
} else {
    echo 'some thing went wrong';
}


