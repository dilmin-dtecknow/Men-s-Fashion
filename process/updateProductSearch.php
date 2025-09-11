<?php
session_start();
require('../database/connection.php'); // Make sure to include your database connection file

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Sanitize the input
    $searchTerm = htmlspecialchars($query, ENT_QUOTES, 'UTF-8');

    // Properly format the SQL query for the LIKE statement
    $products_rs = Database::search("SELECT * FROM product WHERE product_name LIKE '%" . $searchTerm . "%' AND user_id='".$_SESSION['user']['id']."'");

    // Check if any products are found
    if ($products_rs->num_rows > 0) {
        while ($product_row = $products_rs->fetch_assoc()) {
            $category_id = $product_row['catagory_id'];

            $category_rs = Database::search("SELECT * FROM catagory WHERE catagory_id='$category_id'");
            $category_row = $category_rs->fetch_assoc();

            $brand_id = $product_row['brand_id'];

            $brand_rs = Database::search("SELECT * FROM brand WHERE brand_id='$brand_id'");
            $brand_row = $brand_rs->fetch_assoc();

            $size_id = $product_row['size_id'];

            $size_rs = Database::search("SELECT * FROM size WHERE size_id='$size_id'");
            $size_row = $size_rs->fetch_assoc();
?>
            <tr>
                <td>
                    <div class="product-info">
                        <img src="webImg/productImages/<?php echo $product_row['product_id'] ?>/image1.png" alt="Product Image">
                        <div>
                            <p>ID: <?php echo $product_row['product_id'] ?></p>
                            <p><?php echo $product_row['product_name'] ?></p>
                        </div>
                    </div>
                </td>
                <td style="max-width: 200px;">
                    <p><?php echo $product_row['product_name'] ?></p>
                </td>
                <td>
                    <p><?php echo $category_row['catagory_name'] ?></p>
                </td>
                <td>
                    <p><?php echo $brand_row['brand_name'] ?></p>
                </td>
                <td>
                    <p><span>Rs.</span><?php echo $product_row['price'] ?></p>
                </td>
                <td>
                    <p><?php echo $size_row['size_name'] ?></p>
                </td>
                <td>
                    <a href="updateProductsDetails.php?product_id=<?php echo $product_row['product_id'] ?>" class="btn btn-primary btn-sm">Update</a>
                    <!-- <button class="btn btn-danger btn-sm">Remove</button> -->
                </td>
            </tr>
            <!-- End of Cart Products -->
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