<?php

session_start();
require('../database/connection.php');

if (isset($_SESSION['user'])) {
    $logUserId = $_SESSION["user"]["id"];

    echo ($_SESSION["user"]["first_name"]);

    $user_rs = Database::search("SELECT * FROM user WHERE id='$logUserId'");
    $user = $user_rs->fetch_assoc();

    if ($user != null) {
        $user_id = $user['id'];
        $cart_rs = Database::search("SELECT * FROM cart WHERE user_id='$user_id'");
        $cart_items = $cart_rs->num_rows;

        // Check if there are items in the cart
        if ($cart_rs->num_rows > 0) {
            // Loop through each cart item
            for ($x = 0; $x < $cart_rs->num_rows; $x++) {
                $cart_item = $cart_rs->fetch_assoc();
                $productId = $cart_item["product_id"];
                $cartQty = $cart_item["qty"];

                // Fetch product details
                $product_rs = Database::search("SELECT * FROM product WHERE product_id='$productId'");
                $product_data = $product_rs->fetch_assoc();

               $productImag_rs = Database::search("SELECT * FROM product_img WHERE product_id='$productId' LIMIT 1");
                $productImage_data = $productImag_rs->fetch_assoc();


                // Display cart and product information
                echo "Product ID: " . $product_data["product_id"] . "<br>";
                echo "Product Name: " . $product_data["product_name"] . "<br>";
                echo "Product Price: " . $product_data["price"] . "<br>";
                echo "Product Image: " . $productImage_data["path"] . "<br>";
                echo "Quantity in Cart: " . $cartQty . "<br><hr>";
            }
        } else {
            echo "No items in your cart.";
        }
    } else {
        echo ('user not found in db');
    }
} else {
    echo "Please login first";
}
