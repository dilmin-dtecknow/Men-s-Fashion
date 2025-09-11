<?php

session_start();
require('../database/connection.php');

if (isset($_GET['category_name']) || isset($_GET['category_id'])) {
    if (isset($_SESSION['admin'])) {
        // echo 'ok';

        if (empty($_GET['category_name'])) {
            echo 'name empty';
        } else {
            $new_category_name = $_GET['category_name'];
            $category_id = $_GET['category_id'];

            // echo $brand_id;
            // echo $new_brand_name;

            Database::iud("UPDATE catagory SET catagory_name='$new_category_name' WHERE catagory_id='$category_id'");
            echo "success";
        }
    } else {
        echo "unautorized actions";
    }
} else {
    echo 'some thing went wrong';
}


