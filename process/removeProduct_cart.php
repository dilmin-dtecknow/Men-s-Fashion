<?php
session_start();
require('../database/connection.php');
// echo ($_GET['id']);
if (isset($_SESSION['user'])) {

    $logUserId = $_SESSION["user"]["id"];
    $user_rs = Database::search("SELECT * FROM user WHERE id='$logUserId'");
    $user = $user_rs->fetch_assoc();

    if ($user != null) {
        if (isset($_GET['id'])) {

            $product_id = $_GET['id'];

            // unset($_SESSION['cart'][$product_id]);
            // Check if the product exists in the user's cart
            $cart_rs = Database::search("SELECT * FROM cart WHERE user_id='$logUserId' AND product_id='$product_id'");

            // echo ($product_id);
            // echo ($_SESSION["user"]["first_name"]);

            if ($cart_rs->num_rows > 0) {
                // Delete the product from the cart
                Database::iud("DELETE FROM cart WHERE user_id='$logUserId' AND product_id='$product_id'");
                echo "Product removed from cart";

                // // Redirect to the cart page after deletion
                // header("Location: ../cart.php");
                // exit();
            } else {
                echo "Product not found in your cart.";
            }
        } else {
            echo "No product ID provided.";
        }
    }
} else {
    echo "Please login first to delete a product from your cart.";
}
