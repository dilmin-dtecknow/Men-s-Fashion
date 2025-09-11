<?php

session_start();
require('../database/connection.php');

if (isset($_GET['colour_name']) || isset($_GET['colour_id'])) {
    if (isset($_SESSION['admin'])) {
        // echo 'ok';

        if (empty($_GET['colour_name'])) {
            echo 'name empty';
        } else {
            $new_colour_name = $_GET['colour_name'];
            $colour_id = $_GET['colour_id'];

            // echo $brand_id;
            // echo $new_brand_name;

            Database::iud("UPDATE colour SET color_name='$new_colour_name' WHERE color_id='$colour_id'");
            echo "success";
        }
    } else {
        echo "unautorized actions";
    }
} else {
    echo 'some thing went wrong';
}
