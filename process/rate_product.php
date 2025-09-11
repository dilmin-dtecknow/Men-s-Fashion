<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('../database/connection.php');

    $productId = $_POST['product_id'];
    $rating = $_POST['rating'];

    // echo $productId;
    // echo $rating;

    if (is_numeric($productId) && is_numeric($rating) && $rating >= 1 && $rating <= 5) {
        try {
            // Save or update the rating in the database
            $query = "INSERT INTO product_ratings (product_id, rating) VALUES ('$productId', '$rating') 
            ON DUPLICATE KEY UPDATE rating = '$rating'";
            Database::iud($query);
            echo "Rating submitted successfully";
        } catch (Exception $e) {
            echo $e;
        }
    } else {
        echo "Invalid input.";
    }
} else {
    echo "Invalid request method.";
}
