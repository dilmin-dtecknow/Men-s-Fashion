<?php
session_start();
require('database/connection.php');

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit(); // Stop further script execution
}
if ($_SESSION['user']['user_status_id'] == 2) {
    echo 'Your account Temory lock';
    exit(); // Stop further script execution
}

$logUserId = $_SESSION["user"]["id"];

// Fetch the logged-in user details
$user_rs = Database::search("SELECT * FROM user WHERE id='$logUserId'");
$user = $user_rs->fetch_assoc();

// If the user is found, fetch the cart items
if ($user != null) {
    $user_id = $user['id'];
    $cart_rs = Database::search("SELECT * FROM cart WHERE user_id='$user_id'");
    $cart_items = $cart_rs->num_rows;
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
            <h2 class="font-weight-bolde">Your Cart</h2>
            <hr>
            <table class="mt-5 pt-5">
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>SubTotal</th>
                </tr>

                <?php
                // Display cart items if available
                if ($cart_items > 0) {
                    $totalQuantity = 0;
                    $total = 0;
                    while ($cart_item = $cart_rs->fetch_assoc()) {
                        $productId = $cart_item["product_id"];
                        $cartQty = $cart_item["qty"];


                        // Fetch product details
                        $product_rs = Database::search("SELECT * FROM product WHERE product_id='$productId'");
                        $product_data = $product_rs->fetch_assoc();

                        // Fetch product image
                        $productImag_rs = Database::search("SELECT * FROM product_img WHERE product_id='$productId' LIMIT 1");
                        $productImage_data = $productImag_rs->fetch_assoc();

                        $productPrice = $product_data['price'];

                        $itemSubTotal = $productPrice * $cartQty;

                        $totalQuantity += $cartQty;
                        $total += $itemSubTotal;
                ?>

                        <!-- Cart Products  -->
                        <tr>
                            <td>
                                <div class="product-info">
                                    <img src="<?php echo $productImage_data['path']; ?>">
                                    <div>
                                        <p><?php echo $product_data['product_name']; ?></p>
                                        <small><span>Rs.</span><?php echo $product_data['price']; ?></small>
                                        <br>
                                        <button class="remove-btn" onclick="removeCart(<?php echo $productId ?>);">Remove</button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="number" value="<?php echo $cartQty; ?>">
                                <a href="#" class="edit-btn">Edit</a>
                            </td>
                            <td>
                                <span>Rs.</span>
                                <span class="product-price"><?php echo $itemSubTotal; ?></span>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='3'>No items in your cart.</td></tr>";
                }
                ?>

            </table>
            <!-- Cart Products  -->
            <?php if ($cart_items > 0) { ?>

                <!-- Total -->
                <div class="cart-total">
                    <table>
                        <tr>
                            <td>Total Quantity</td>
                            <td><?php echo $totalQuantity; ?></td>
                        <tr>
                            <td>Total</td>
                            <td>Rs.<?php echo $total; ?></td>
                        </tr>
                        </tr>
                    </table>
                </div>

            <?php } else { ?>

                <!-- Total -->
                <div class="cart-total">
                    <table>
                        <tr>
                            <td>Total Quantity</td>
                            <td>00</td>
                        <tr>
                            <td>Total</td>
                            <td>Rs.00</td>
                        </tr>
                        </tr>
                    </table>
                </div>

            <?php } ?>

        </div>

        <?php if ($cart_items > 0) { ?>
            <div class="checkout-container">
                <a href="checkout.php" class="btn checkout-btn">CheckOut</a>
            </div>
        <?php } else { ?>
            <div class="checkout-container">
                <button class="btn checkout-btn" disabled>CheckOut</button>
            </div>
        <?php } ?>


    </section>
    <!-- cart -->

    <?php include "footer.php"; ?>

    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="js/addToCart.js"></script>
    <script src="js/cart.js"></script>
</body>

</html>