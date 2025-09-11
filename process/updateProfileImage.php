<?php
session_start();
require('../database/connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    echo 'User not logged in';
    exit();
}

$logUserId = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['profile_image'])) {
        $image = $_FILES['profile_image'];
        $imageName = 'image.png'; // Name the image file
        $uploadDirectory = "../webImg/usersImage/" . $logUserId . "/";

        // Create directory if it doesn't exist
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        $imagePath = $uploadDirectory . $imageName;

        // Move the uploaded image to the desired directory
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            // Update the database with the new image path if needed
            // Database::iud("UPDATE user SET profile_image='$imagePath' WHERE id='$logUserId'");

            echo 'success';
        } else {
            echo 'Failed to upload image';
        }
    } else {
        echo 'No image file uploaded';
    }
} else {
    echo 'Invalid request';
}
?>
