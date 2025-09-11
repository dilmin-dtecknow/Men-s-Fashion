<?php
session_start();
require('../database/connection.php');

$productId = $_GET["id"];
$addQty = $_GET["qty"];
// echo ($productId);
// echo ($addQty);

// $response = []; // Initialize an empty response array
// $response["success"] = false;

try {

    if ($addQty <= 0) {
        //Quantity must be greter than 0
        echo ("Quantity must be greter than 0");
        // $response["message"] = "Quantity must be greater than 0";
    } else {
        $product_rs = Database::search("SELECT * FROM product WHERE product_id='" . $productId . "'");
        $product = $product_rs->fetch_assoc();
        if ($product != null) {
            //product found in db
            // echo ("Product Found");

            if (isset($_SESSION["user"])) {
                //user found in session
                $logUserId = $_SESSION["user"]["id"];

                // echo ($logUserId);
                // echo ($_SESSION["user"]["first_name"]);

                $user_rs = Database::search("SELECT * FROM user WHERE id='$logUserId'");
                $user = $user_rs->fetch_assoc();

                if ($user != null) {
                    // echo ('User found in db');

                    $user_id = $user['id'];
                    $product_id = $product['product_id'];

                    $cart_rs = Database::search("SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'");

                    if ($cart_rs->num_rows > 0) {
                        // Product already exists in the cart
                        // echo ("Product already in cart");

                        // Get the cart item details
                        $cartItem = $cart_rs->fetch_assoc();

                        // Check if the total quantity (existing cart quantity + new quantity) is less than or equal to available stock
                        if (($cartItem['qty'] + $addQty) <= $product['qty']) {
                            // Update the quantity in the cart
                            $newQty = $cartItem['qty'] + $addQty;

                            // Update query to change the quantity in the cart
                            Database::iud("UPDATE cart SET qty='$newQty' WHERE user_id='$user_id' AND product_id='$product_id'");

                            echo "Product quantity updated in cart";
                            // $response["success"] = true;
                            // $response["message"] = "Product quantity updated in cart";
                        } else {
                            // Not enough stock to update the cart
                            echo "Cannot update cart. Quantity exceeds available stock.";
                            // $response["message"] = "Cannot update cart. Quantity exceeds available stock.";
                        }
                    } else {
                        // Cart is empty for this user and product
                        // echo "Cart is empty for this product, adding now";

                        if ($addQty <= $product["qty"]) {
                            // echo "quantity available Can add To cart";

                            // Code to add the product to the cart
                            Database::iud("INSERT INTO cart (user_id, product_id, qty) VALUES ('$user_id', '$product_id', '$addQty')");
                            echo "Product added to cart";
                            // $response["success"] = true;
                            // $response["message"] = "Product added to cart";
                        } else {
                            echo "quantity not available";
                            // $response["message"] = "Quantity not available.";
                        }
                    }
                } else {
                    echo ('user not found in db');
                    // $response["message"] = "User not found in the database";
                }
            } else {
                echo ("Please login or SignUp!");
                // $response["message"] = "Please login or SignUp!";
            }
        } else {
            echo ("Product not found");
            // $response["message"] = "Product not found";
        }
    }
} catch (Exception $e) {
    echo ($e->getMessage());
    // $response["message"] = $e->getMessage();
}

// Return JSON response
// header('Content-Type: application/json');
// echo json_encode($response);
// exit;
