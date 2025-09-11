<?php
require('database/connection.php');

$product_rs = Database::search("SELECT * FROM product LIMIT 4");
?>
<!-- INNER JOIN product_img ON product.product_id=product_img.product_id -->