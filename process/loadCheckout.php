<?php
session_start();
require('../database/connection.php'); // Database connection
header('Content-Type: application/json'); // Set response type to JSON

$response = array();
$response['success'] = false;

if (isset($_SESSION['user'])) {
    $userDTO = $_SESSION['user']; // Assuming 'user' is an associative array containing user data, similar to the User_DTO in Java
    // $response['message'] = $userDTO['email'];
    // Get user from DB
    $email = $userDTO['email']; // Assuming email exists in the user session data
    $userResult = Database::search("SELECT * FROM user WHERE email = '$email'");
    
    if ($userResult->num_rows > 0) {
        $user = $userResult->fetch_assoc(); // Get the user data

        // Get user's last address from DB
        $addressResult = Database::search("SELECT * FROM address WHERE user_id = {$user['id']} ORDER BY id DESC LIMIT 1") ;
        
        if ($addressResult->num_rows > 0) {
            $address = $addressResult->fetch_assoc();
            unset($address['user_id']); // Remove user reference in address
            $response['address'] = $address;
        } else {
            $response['message'] = "Current address not found.";
        }

        // Get cities from DB
        $cityResult = Database::search("SELECT * FROM city ORDER BY name ASC") ;
       
        $cityList = array();
        while ($city = $cityResult->fetch_assoc()) {
            $cityList[] = $city;
        }
        $response['cityList'] = $cityList;

        // Get cart items from DB
        $cartResult = Database::search( "SELECT cart.*, product.*,cart.qty FROM cart 
                      INNER JOIN product ON cart.product_id = product.product_id 
                      WHERE cart.user_id = {$user['id']}");
        
        $cartList = array();
        while ($cart = $cartResult->fetch_assoc()) {
            unset($cart['user_id']); // Remove user reference in cart
            unset($cart['product_user_id']); // Remove user reference in product
            $cartList[] = $cart;
        }
        $response['cartList'] = $cartList;

        // Set success to true
        $response['success'] = true;
    } else {
        $response['message'] = "User not found.";
    }
} else {
    $response['message'] = "Not signed in.";
    
}

echo json_encode($response);
?>
