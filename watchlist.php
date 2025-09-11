<?php
session_start();
require('database/connection.php');

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit(); // Stop further script execution
}

$logUserId = $_SESSION["user"]["id"];

// Fetch the logged-in user details
$user_rs = Database::search("SELECT * FROM user WHERE id='$logUserId'");
$user = $user_rs->fetch_assoc();

// If the user is found, fetch the cart items
if ($user != null) {
    $user_id = $user['id'];
    $watchlist_rs = Database::search("SELECT * FROM watchlist WHERE user_id='$user_id'");
    $watchlist_items = $watchlist_rs->num_rows;
} else {
    echo "User not found in the database.";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop|Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

    <link rel="stylesheet" href="css/style.css">

    <!-- Load SweetAlert2 from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<!-- <body onload="loadCartData();"> -->

<body>
    <?php include "header.php"; ?>
    <div class="allp my-5 py-5">
    </div>

    <section>
        <div class="producth1">

        </div>
    </section>


    <!-- cart -->
    <section class="container cart my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bolde">My Watchlist</h2>
            <hr>
            <table class="mt-5 pt-5">
                <tr>
                    <th>Product</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Size</th>
                    <th>Actions</th>
                </tr>

                <?php if ($watchlist_items > 0) {
                    while ($watchlist_item = $watchlist_rs->fetch_assoc()) {
                        $productId = $watchlist_item["product_id"];

                        // Fetch product details
                        $product_rs = Database::search("SELECT * FROM product WHERE product_id='$productId'");
                        $product_data = $product_rs->fetch_assoc();

                        $category_id = $product_data['catagory_id'];

                        $category_rs = Database::search("SELECT * FROM catagory WHERE catagory_id='$category_id'");
                        $category_row =  $category_rs->fetch_assoc();

                        $brand_id = $product_data['brand_id'];

                        $brand_rs = Database::search("SELECT * FROM brand WHERE brand_id='$brand_id'");
                        $brand_row = $brand_rs->fetch_assoc();

                        $size_id = $product_data['size_id'];

                        $size_rs = Database::search("SELECT * FROM size WHERE size_id='$size_id'");
                        $size_row = $size_rs->fetch_assoc();
                ?>

                        <!-- Cart Products  -->
                        <tr>
                            <td>
                                <div class="product-info">
                                    <img src="webImg/productImages/<?php echo $productId ?>/image1.png">
                                    <div>
                                        <p style="word-wrap: break-word; overflow-wrap: break-word;white-space: normal;"><?php echo $product_data['product_name']; ?></p>
                                        <!-- <small><span>Rs.</span>1000</small> -->
                                        <!-- <br> -->
                                        <!-- <button class="remove-btn" onclick="removeCart();">Remove</button> -->
                                    </div>
                                </div>
                            </td>
                            <td style="max-width: 200px;">
                                <p style="word-wrap: break-word; overflow-wrap: break-word;white-space: normal;"><?php echo $product_data['product_name']; ?></p>
                            </td>
                            <td>
                                <p><?php echo $category_row['catagory_name'] ?></p>
                            </td>
                            <td>
                                <p><?php echo $brand_row['brand_name'] ?></p>
                            </td>
                            <td>
                                <p><span>Rs.</span><?php echo $product_data['price']?></p>
                            </td>
                            <td>
                                <p><?php echo $size_row['size_name'] ?></p>
                            </td>
                            <td>
                                <a href="<?php echo "single_product.php?product_id=" . $productId ?>" class="btn btn-primary btn-sm">View</a>
                                <button class="btn btn-danger btn-sm" onclick="addtoWatchlist('<?php echo $productId ?>');">Remove</button>
                            </td>
                        </tr>

                    <?php }
                } else { ?>
                    echo "<tr>
                        <td colspan='3'>No items in your Watchlist. <a href="shop.php">shop now</a></td>
                    </tr>";
                <?php } ?>
            </table>
            <!-- Cart Products  -->




        </div>




    </section>
    <!-- cart -->

    <?php include "footer.php"; ?>

    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>

</html>