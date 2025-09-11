<?php
require('../database/connection.php'); // Update this path as needed

$orderId = $_GET['orderId'];
$response = ["success" => false, "items" => [], "items_length" => 0];

// Retrieve order items with product and quantity
// $orderItems_rs = Database::search("SELECT product.product_id,product.product_name, order_item.qty AS quantity, product.price, (order_item.qty * product.price) AS total 
//                                     FROM order_item 
//                                     INNER JOIN product ON order_item.product_id = product.product_id 
//                                     WHERE order_item.orders_id = '$orderId'");

$orderItems_rs = Database::search("SELECT product.product_id, product.product_name, order_item.qty AS quantity, product.price, 
                                   (order_item.qty * product.price) AS total, order_status.name ,order_status.id
                                   FROM order_item 
                                   INNER JOIN product ON order_item.product_id = product.product_id 
                                   INNER JOIN order_status ON order_item.order_status_id = order_status.id 
                                   WHERE order_item.orders_id = '$orderId'");

if ($orderItems_rs->num_rows > 0) {
    $response["success"] = true;
    $response["items_length"] = $orderItems_rs->num_rows;

    // Fetch address to determine city-based shipping charge
    $order_rs = Database::search("SELECT address_id FROM orders WHERE id = '$orderId'");
    $order_row = $order_rs->fetch_assoc();
    $addressId = $order_row['address_id'];
    $address_rs = Database::search("SELECT city_id FROM address WHERE id = '$addressId'");
    $address_row = $address_rs->fetch_assoc();

    // Fetch city shipping charge
    $cityId = $address_row['city_id'];
    $city_rs = Database::search("SELECT shipping_charge FROM city WHERE id = '$cityId'");
    $city_row = $city_rs->fetch_assoc();
    $shippingChargePerItem = $city_row["shipping_charge"];

    // Process each item and add shipping fee
    while ($row = $orderItems_rs->fetch_assoc()) {
        $itemTotalWithShipping = $row['total'] + ($shippingChargePerItem);
        $row['total_with_shipping'] = $itemTotalWithShipping;
        $response["items"][] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($response);

?>
