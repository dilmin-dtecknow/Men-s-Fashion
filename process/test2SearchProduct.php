<?php
// Include the database connection class
require('../database/connection.php'); 

// Get the request body if it's sent as JSON
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

// Extract values from the request
$firstResult = $data['firstResult'] ?? 0;
$categoryId = $data['category_id'] ?? null;
$brandId = $data['brand_id'] ?? null;
$sizeId = $data['size_id'] ?? null;
$colorId = $data['color_id'] ?? null;
$minPrice = $data['price_range_start'] ?? null;
$maxPrice = $data['price_range_end'] ?? null;
$sortText = $data['sort_text'] ?? '';

$response = array();
// Initialize the SQL query with dynamic filtering
$query = "SELECT * FROM product WHERE 1 = 1"; // Base query
$params = [];
$types = ''; // Bind parameter types for MySQLi prepared statements

// Add filters to the query and corresponding parameters
if ($categoryId) {
    $query .= " AND catagory_id = ?";
    $params[] = $categoryId;
    $types .= 'i'; // 'i' for integer type
}
if ($brandId) {
    $query .= " AND brand_id = ?";
    $params[] = $brandId;
    $types .= 'i';
}
if ($sizeId) {
    $query .= " AND size_id = ?";
    $params[] = $sizeId;
    $types .= 'i';
}
if ($colorId) {
    $query .= " AND color_id = ?";
    $params[] = $colorId;
    $types .= 'i';
}
if ($minPrice && $maxPrice) {
    $query .= " AND price BETWEEN ? AND ?";
    $params[] = $minPrice;
    $params[] = $maxPrice;
    $types .= 'ii'; // 'ii' for two integer parameters
}

// Sorting logic
switch ($sortText) {
    case 'Price, low to high':
        $query .= " ORDER BY price ASC";
        break;
    case 'Price, high to low':
        $query .= " ORDER BY price DESC";
        break;
    case 'Product, New to Old':
        $query .= " ORDER BY product_id ASC";
        break;
    case 'Product, Old to New':
        $query .= " ORDER BY product_id DESC";
        break;
    case 'Name, Z to A':
        $query .= " ORDER BY product_name DESC";
        break;
    default:
        $query .= " ORDER BY product_name ASC"; // Default sorting by product name
        break;
}

// Pagination: limit results and offset for loading more products
$query .= " LIMIT ?, 10";
$params[] = $firstResult;
$types .= 'i'; // 'i' for integer (firstResult)

// Execute the query using prepared statements
$result = Database::searchPrepared($query, $params, $types);

// Fetch the results and return as JSON
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$response['productList'] = $products;

header('Content-Type: application/json');
echo json_encode($response);
?>
