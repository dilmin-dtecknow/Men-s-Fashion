<?php

session_start();
require('../database/connection.php');

if (isset($_GET['size_name']) || isset($_GET['size_id'])) {
    if (isset($_SESSION['admin'])) {
        // echo 'ok';

        if (empty($_GET['size_name'])) {
            echo 'name empty';
        } else {
            $new_size_name = $_GET['size_name'];
            $size_id = $_GET['size_id'];

            // echo $brand_id;
            // echo $new_brand_name;

            Database::iud("UPDATE size SET size_name='$new_size_name' WHERE size_id='$size_id'");
            echo "success";
        }
    } else {
        echo "unautorized actions";
    }
} else {
    echo 'some thing went wrong';
}


