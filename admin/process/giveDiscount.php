<?php

require('../database/connection.php');
$discount = $_GET['discount'];


// echo "hello discount" . $discount . "product" . $product_id;

if (isset($_GET['pid'])) {
    $product_id = $_GET['pid'];

    if ($discount == '') {
        echo 'Please enter discount';
    } else if (!is_numeric($discount) || $discount < 0) {
        echo 'miinimum discount value is 0';
    } else {

        // Update the discount in the database
        $update_query = "UPDATE product SET discount='$discount' WHERE product_id='$product_id'";
        if (Database::search($update_query)) {
            echo 'success';
        } else {
            echo 'Failed to update discount';
        }
    }
} else {
    echo 'Somthing Went wrong';
}
