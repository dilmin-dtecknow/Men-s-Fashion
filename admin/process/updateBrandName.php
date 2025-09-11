<?php

session_start();
require('../database/connection.php');

if (isset($_GET['b_name']) || isset($_GET['bid'])) {
    if (isset($_SESSION['admin'])) {
        // echo 'ok';

        if (empty($_GET['b_name'])) {
            echo 'name empty';
        } else {
            $new_brand_name = $_GET['b_name'];
            $brand_id = $_GET['bid'];

            // echo $brand_id;
            // echo $new_brand_name;

            Database::iud("UPDATE brand SET brand_name='$new_brand_name' WHERE brand_id='$brand_id'");
            echo "success";
        }
    } else {
        echo "unautorized actions";
    }
} else {
    echo 'some thing went wrong';
}


