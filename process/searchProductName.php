<?php
require('../database/connection.php'); // Make sure to include your database connection file

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Sanitize the input
    $searchTerm = htmlspecialchars($query, ENT_QUOTES, 'UTF-8');

    // Properly format the SQL query for the LIKE statement
    $products_rs = Database::search("SELECT * FROM product WHERE product_name LIKE '%" . $searchTerm . "%'");

    // Check if any products are found
    if ($products_rs->num_rows > 0) {
        while ($product = $products_rs->fetch_assoc()) {
            // echo '<div class="product-item">';
            // echo '<h4>' . htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8') . '</h4>';
            // echo '<p>' . htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8') . '</p>';
            // echo '<p>Price: $' . htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8') . '</p>';
            // echo '</div>';
?>
            <dive class="products text-center col-lg-3 col-md-4 col-sm-12">
                <?php $image_rs = Database::search("SELECT * FROM product_img WHERE product_id='" . $product['product_id'] . "'");
                $image_data = $image_rs->fetch_assoc();
                ?>
                <img src="<?php echo $image_data['path'] ?>" class="img-fluid mb-3" />
                <div class="star">

                    <?php for ($i = 0; $i <= 4; $i++) { ?>
                        <i class="fas fa-star"></i>
                    <?php } ?>

                </div>
                <h5 class="p-name"><?php echo $product['product_name'] ?></h5>
                <h4 class="p-price">Rs.<?php echo $product['price'] ?></h4>

                <?php if ($product['qty'] > 0) { ?>
                    <h4><?php echo $product['qty'] ?> &nbsp; <span style="color: green;">Itemes Available</span> </h4>
                    <a href="<?php echo "single_product.php?product_id=" . $product['product_id'] ?>"><button class="buy-now-btn btn btn-outline-secondary">Buy Now</button></a>

                <?php } else { ?>
                    <h4 class="text-danger">Out of Stock</h4>
                    <button class="buy-now-btn btn btn-outline-secondary disabled">Buy Now</button>
                <?php } ?>
                <button class="buy-now-btn btn btn-outline-secondary" onclick="addtoWatchlist('<?php echo $product['product_id'] ?>');"><i class="fa fa-heart" aria-hidden="true" id='heart<?php echo $product['product_id'] ?>'></i></button>
            </dive>
<?php
        }
    } else {
        echo '<p>No products found.</p>';
        echo '<meta http-equiv="refresh" content="0">';
    }
} else {
    echo '<meta http-equiv="refresh" content="0">';
}
?>