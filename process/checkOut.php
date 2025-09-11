<?php

session_start();
require('../database/connection.php'); // Database connection
header('Content-Type: application/json');

$response['success'] = false;

try {

    $isCurentAddress = $_POST["isCurentAddressCheckbox"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $city = $_POST["city"];
    $address1 = $_POST["address1"];
    $address2 = $_POST["address2"];
    $postal_code = $_POST["postal_code"];
    $mobile = $_POST["mobile"];

    if (isset($_SESSION['user'])) {
        $user_id = $_SESSION['user']["id"];

        $userResult = Database::search("SELECT * FROM user WHERE id = '$user_id'");

        if ($userResult->num_rows > 0) {
            $user = $userResult->fetch_assoc();
            $userId = $user["id"];
            if ($isCurentAddress == "true") {
                //currentt address found

                // Get user's last address from DB
                $addressResult = Database::search("SELECT * FROM address WHERE user_id = {$user['id']} ORDER BY id DESC LIMIT 1");

                if ($addressResult->num_rows > 0) {
                    $address = $addressResult->fetch_assoc();
                    unset($address['user_id']); // Remove user reference in address
                    $response['address'] = $address;

                    //Save Order
                    completeCheckOut($userId, $address);
                } else {
                    $response['message'] = "Current address not found Create New Address.";
                }
            } else {
                //curren address not found add new address

                if (!$first_name) {
                    $response['message'] = "Can not First name empty!";
                } else if (!$last_name) {
                    $response['message'] = "Can not Last name empty!";
                } else if (!$mobile) {
                    $response['message'] = "Can not Mobile empty!";
                } else if (strlen($mobile) != 10) {
                    $response['message'] = ("Mobile must have 10 characters");
                } else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {
                    $response['message'] = ("Invalid Mobile !!!");
                } else if ($city == 0) {
                    $response['message'] = "Select your country!";
                } else if (!$postal_code) {
                    $response['message'] = "Can not empty Postal/Zip code!";
                } elseif (strlen($postal_code) != 5 || !is_numeric($postal_code) && !intval($postal_code) == $postal_code || !ctype_digit($postal_code)) {
                    $response['message'] = 'Invalid postal code';
                } else if (!$address1) {
                    $response['message'] = "Can not empty Address Line 1!";
                } else if (!$address2) {
                    $response['message'] = "Can not empty Address Line 2!";
                } else {
                    // $response['message'] = $user["id"];

                    $cityResult = Database::search("SELECT * FROM city WHERE id='$city'");

                    if ($cityResult->num_rows > 0) {
                        //city found
                        $cityData = $cityResult->fetch_assoc();
                        $cityId = $cityData['id'];
                        // $userId = $user["id"];
                        //insert new address
                        Database::iud("INSERT INTO `address` (first_name,last_name,line1,line2,postal_code,mobile,user_id,city_id)
                        VALUES('$first_name','$last_name','$address1','$address2','$postal_code','$mobile','$userId','$cityId')");

                        $response['message'] = "New Address adde successful";

                        $addressResult = Database::search("SELECT * FROM address WHERE user_id = {$user['id']} ORDER BY id DESC LIMIT 1");

                        if ($addressResult->num_rows > 0) {
                            $address = $addressResult->fetch_assoc();
                            unset($address['user_id']); // Remove user reference in address
                            $response['address'] = $address;

                            //save order
                            completeCheckOut($userId, $address);
                        } else {
                            $response['message'] = "Current address not found Create New Address.";
                        }
                    } else {
                        $response['message'] = "Invalid city selection!";
                    }
                }
            }
        } else {
            //user not found
            $response['message'] = "notfound";
        }
    } else {
        //user not in session
        $response['message'] = "notfound";
    }
} catch (Exception $e) {
    $response['message'] = 'An error occurred: ' . $e->getMessage();
    echo json_encode($response);
}

echo json_encode($response);

function completeCheckOut($user, $address)
{
    global $response;
    $response['success'] = true;
    $response['address'] = $address;

    $addressId = $address['id'];

    $order_id = Database::iud("INSERT INTO orders (date_time,address_id,user_id)
    VALUES (NOW(),'$addressId','$user')");

    // $response['message'] = $order_id;

    $cartResult = Database::search("SELECT cart.*, product.*,cart.qty AS cart_qty FROM cart 
    INNER JOIN product ON cart.product_id = product.product_id
    WHERE cart.user_id='$user'");

    $totalAmount = 0;
    $items = "";

    while ($cartItem = $cartResult->fetch_assoc()) {
        $totalAmount += $cartItem['cart_qty'] * $cartItem['price'];
        $items .= $cartItem['product_name'] . " x" . $cartItem['cart_qty'] . " ";

        // $response['message'] = $address;
        $city_id = $address['city_id']; // Extract the city_id from the address

        // $response['message'] = $city_id;

        // Query to get the shipping charge based on city or postal code
        $shippingResult = Database::search("SELECT * FROM city WHERE id = '$city_id'");
        $shippingData = $shippingResult->fetch_assoc();
        if ($shippingResult->num_rows > 0) {
            // $shippingData = $shippingResult->fetch_assoc();

            $shippingCharge = $shippingData['shipping_charge'];
            $totalAmount += $shippingCharge; // Add shipping charge to the total amount
            // $response['message'] = $totalAmount;
        } else {
            // Default shipping charge if no specific data found
            $shippingCharge = 0;
            $response['message'] = "Shipping charge not found, setting to 0.";
        }

        $productId = $cartItem["product_id"];
        $cartItemQty = $cartItem['cart_qty'];

        Database::iud("INSERT INTO order_item (qty,product_id,orders_id,order_status_id)
        VALUES('$cartItemQty','$productId','$order_id','1')");

        // Update the product quantity by subtracting the purchased quantity
        $newQty = $cartItem['qty'] - $cartItemQty;

        // Ensure the quantity does not go negative
        if ($newQty < 0) {
            $newQty = 0;
        }

        // Update the product quantity in the database
        Database::iud("UPDATE product SET qty='$newQty' WHERE product_id='$productId'");

        // Optionally, clear the cart for this user after the order is placed
        Database::iud("DELETE FROM cart WHERE user_id='$user'");

        // Optionally return some response or total amount
        // $response['message'] = "Order placed successfully with a total amount of $totalAmount";

        
        
    }
    $fname = $_SESSION["user"]["first_name"];
    $lname = $_SESSION["user"]["last_name"];
    $mobile = $address['mobile'];
    // $user_address = $address;
    $cityName = $shippingData['name'];

    // $response['fname'] = $fname;
    // $response['lname'] = $lname;
    // $response['mobile'] = $mobile;
    $addressDetail = $address['line1'].",".$address['line2'];
    // $response['city'] = $cityName;
    // $response['items'] = $items;

    // // Set payment data
    $merchant_id = "1223369";
    $formattedAmount = number_format($totalAmount, 2, '.', '');
    $currency = "LKR";
    $merchant_secret = "MzI2NTA5ODMxMzQwNDEwNzIwODkxNTQ1NzY4NDg3NDIwMTk0MzY3MA==";

    // $response['formatedAmmount'] = $formattedAmount;
    // $response['order'] = $order_id;



    $hash = strtoupper(
        md5(
            $merchant_id .
                $order_id .
                $formattedAmount .
                $currency .
                strtoupper(md5($merchant_secret))
        )
    );




    // // Create the array with all necessary details
    $paymentDetails = [
        "order" => $order_id,
        "items" => $items,
        "amount" => $totalAmount,
        "fname" => $fname,
        "lname" => $lname,
        "mobile" => $mobile,
        "address" => $addressDetail,
        "city" => $cityName,
        "mail" => $_SESSION["user"]["email"],
        "hash" => $hash
    ];

    // // Set the array to the response

    $response['success'] = true;
    $response['paymentDetails'] = $paymentDetails;
    $response['message'] = "Order placed successfully with a total amount of $totalAmount";
}
