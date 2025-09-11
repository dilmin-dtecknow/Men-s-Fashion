<?php
require('../database/connection.php'); //  database connection script

// Prepare the JSON response array
$response = array();
$response['success'] = false;

try {
    // Get total product count
    $allProductsResult = Database::search("SELECT COUNT(*) AS allProductCount FROM product");
    $allProductCount = $allProductsResult->fetch_assoc()['allProductCount'];
    $response['allProductCount'] = $allProductCount;

    // Fetch paginated products
    $start = 0; // Adjust based on current page
    $limit = 6; // Number of products to display

    // Prepared query for product selection with pagination
    $productsQuery = "SELECT * FROM product ORDER BY product_id DESC LIMIT ?, ?";
    $productResults = Database::searchPrepared($productsQuery, [$start, $limit], "ii");

    $productList = array();

    // Loop through and prepare the product data
    while ($row = $productResults->fetch_assoc()) {
        // Remove sensitive information like 'user_id'
        unset($row['user_id']);
        $productList[] = $row;
    }

    $response['productList'] = $productList;
    $response['success'] = true;
} catch (Exception $e) {
    // Handle any errors
    $response['error'] = "Error fetching products: " . $e->getMessage();
}

// Set the header to return JSON and output the response
header('Content-Type: application/json');
echo json_encode($response);
