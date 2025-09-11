
<?php
// Include database connection
require('../database/connection.php');

// Define the response array
$response = [
    "success" => false,
    "message" => "An error occurred",
    "productList" => []
];

try {
    // Retrieve POST data
    $firstResult = $_POST['firstResult'] ?? 0;
    $category_id = $_POST['category_id'] ?? null;
    $brand_id = $_POST['brand_id'] ?? null;
    $size_id = $_POST['size_id'] ?? null;
    $price_range_start = $_POST['price_range_start'] ?? 0;
    $price_range_end = $_POST['price_range_end'] ?? PHP_INT_MAX;
    $color_id = $_POST['color_id'] ?? null;
    $sort_text = $_POST['sort_text'] ?? 'Name, A to Z';

    // Build the base query
    $query = "SELECT * FROM product WHERE price BETWEEN ? AND ?";
    $params = [$price_range_start, $price_range_end];
    $types = "ii"; // for two integer params (min price and max price)

    // Add filters to the query dynamically based on the input
    if (!empty($category_id)) {
        $query .= " AND catagory_id = ?";
        $params[] = $category_id;
        $types .= "i"; // integer for category_id
    }
    if (!empty($brand_id)) {
        $query .= " AND brand_id = ?";
        $params[] = $brand_id;
        $types .= "i"; // integer for brand_id
    }
    if (!empty($size_id)) {
        $query .= " AND size_id = ?";
        $params[] = $size_id;
        $types .= "i"; // integer for size_id
    }
    if (!empty($color_id)) {
        $query .= " AND color_id = ?";
        $params[] = $color_id;
        $types .= "i"; // integer for color_id
    }

    // Add filters to the query dynamically based on the input
    // if (isset($category_id) && !empty($category_id)) {
    //     $query .= " AND catagory_id = ?";
    //     $params[] = $category_id;
    //     $types .= "i"; // integer for category_id
    // }
    // if (isset($brand_id) && !empty($brand_id)) {
    //     $query .= " AND brand_id = ?";
    //     $params[] = $brand_id;
    //     $types .= "i"; // integer for brand_id
    // }
    // if (isset($size_id) && !empty($size_id)) {
    //     $query .= " AND size_id = ?";
    //     $params[] = $size_id;
    //     $types .= "i"; // integer for size_id
    // }
    // if (isset($color_id) && !empty($color_id)) {
    //     $query .= " AND color_id = ?";
    //     $params[] = $color_id;
    //     $types .= "i"; // integer for color_id
    // }

    // Sort logic
    switch ($sort_text) {
        case 'Price, low to high':
            $query .= " ORDER BY price ASC";
            break;
        case 'Price, high to low':
            $query .= " ORDER BY price DESC";
            break;
        case 'Name, A to Z':
            $query .= " ORDER BY product_name ASC";
            break;
        case 'Name, Z to A':
            $query .= " ORDER BY product_name DESC";
            break;
        default:
            $query .= " ORDER BY product_name ASC";
            break;
    }

    // Add pagination
    $query .= " LIMIT ?, 6";
    $params[] = (int)$firstResult;
    $types .= "i"; // integer for firstResult (pagination)

    // Execute the query with prepared statements
    $result = Database::searchPrepared($query, $params, $types);

    // Check if any products were found
    if ($result->num_rows > 0) {
        $response['success'] = true;
        $response['productList'] = $result->fetch_all(MYSQLI_ASSOC);
        $response['message'] = 'products found';
    } else {
        $response['message'] = 'No products found';
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>