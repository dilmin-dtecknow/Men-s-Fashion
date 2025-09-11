<?php
    require('../database/connection.php');
    $color_id = $_POST["selectedColor"];
    $p_id = $_POST["product_id"];
    // echo($color_id);
    // echo($p_id);
    // echo "hello";

    $result = Database::search("SELECT product.product_id FROM product 
        WHERE product.product_id='".$p_id."' AND product.color_id='".$color_id."';");

    // Check if a result was returned
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['product_id'];
    } else {
        echo "No barcode found.";
    }
?>