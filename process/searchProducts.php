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

// Initialize the SQL query for counting products
$countQuery = "SELECT COUNT(*) as total FROM product WHERE 1 = 1"; // Base count query
$countParams = [];
$countTypes = ''; // Bind parameter types for MySQLi prepared statements

// Add filters to the count query and corresponding parameters
if ($categoryId) {
    $countQuery .= " AND catagory_id = ?";
    $countParams[] = $categoryId;
    $countTypes .= 'i'; // 'i' for integer type
}
if ($brandId) {
    $countQuery .= " AND brand_id = ?";
    $countParams[] = $brandId;
    $countTypes .= 'i';
}
if ($sizeId) {
    $countQuery .= " AND size_id = ?";
    $countParams[] = $sizeId;
    $countTypes .= 'i';
}
if ($colorId) {
    $countQuery .= " AND color_id = ?";
    $countParams[] = $colorId;
    $countTypes .= 'i';
}
if ($minPrice && $maxPrice) {
    $countQuery .= " AND price BETWEEN ? AND ?";
    $countParams[] = $minPrice;
    $countParams[] = $maxPrice;
    $countTypes .= 'ii'; // 'ii' for two integer parameters
}

// // Execute the count query using prepared statements
// $countResult = Database::searchPrepared($countQuery, $countParams, $countTypes);
// $totalProducts = 0; // Default total product count
// if ($countResult->num_rows > 0) {
//     $countRow = $countResult->fetch_assoc();
//     $totalProducts = $countRow['total'];
// }


// Execute the count query using prepared statements or regular query based on parameters
if (!empty($countParams)) {
    $countResult = Database::searchPrepared($countQuery, $countParams, $countTypes);
} else {
    $countResult = Database::search($countQuery);  // No parameters, so run the query directly
}

$totalProducts = 0; // Default total product count
if ($countResult->num_rows > 0) {
    $countRow = $countResult->fetch_assoc();
    $totalProducts = $countRow['total'];
}


// Initialize the SQL query with dynamic filtering for product retrieval
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
        $query .= " ORDER BY product_id DESC"; // Order by product_id descending for new products first
        break;
    case 'Product, Old to New':
        $query .= " ORDER BY product_id ASC"; // Order by product_id ascending for old products first
        break;
    case 'Name, Z to A':
        $query .= " ORDER BY product_name DESC";
        break;
    default:
        $query .= " ORDER BY product_name ASC"; // Default sorting by product name
        break;
}

// Pagination: limit results and offset for loading more products
$query .= " LIMIT ?, 6";
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

// Include total products in the response
$response['allProductCount'] = $totalProducts; // Add total product count to response
$response['productList'] = $products;

header('Content-Type: application/json');
echo json_encode($response);
?>
