<?php

session_start();
require('../database/connection.php');

$productId = $_GET['pid'];

// echo "server" . $productId;
$product_rs = Database::search("SELECT * FROM product WHERE product_id='" . $productId . "'");
$product = $product_rs->fetch_assoc();
if ($product != null) {
    if (isset($_SESSION["user"])) {

        //user found in session
        $logUserId = $_SESSION["user"]["id"];

        $user_rs = Database::search("SELECT * FROM user WHERE id='$logUserId'");
        $user = $user_rs->fetch_assoc();

        if ($user != null) {
            // echo ('User found in db');

            $user_id = $user['id'];
            $product_id = $product['product_id'];

            $watchlist_rs = Database::search("SELECT * FROM watchlist WHERE user_id='$user_id' AND product_id='$product_id'");

            if ($watchlist_rs->num_rows != 1) {
                Database::iud("INSERT INTO `watchlist`(`user_id`,`product_id`) VALUES ('$user_id','$product_id')");
                echo ("Added");
            } else {
               $watchlist_row = $watchlist_rs->fetch_assoc();
               $wathlist_id = $watchlist_row['w_id'];

                Database::iud("DELETE FROM `watchlist` WHERE `w_id`=' $wathlist_id '");
                echo ("Removed");
            }
        } else {
            echo ('user not found in db');
        }
    } else {
        echo ("Please login or SignUp!");
    }
} else {
    echo ("Product not found");
}
