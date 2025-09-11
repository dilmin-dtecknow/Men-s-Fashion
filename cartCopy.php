<?php
session_start();
if (isset($_POST['add_to_cart'])) {

    //if this is the update(allready have cart product)
    if (isset($_SESSION['cart'])) {

        $products_array_ids = array_column($_SESSION['cart'], "product_id");

        //if product has allready been added to cart or not
        if (!in_array($_POST['product_id'], $products_array_ids)) {
            $product_id = $_POST['product_id'];
            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_img' => $_POST['product_img'],
                'product_name' => $_POST['product_name'],
                'price' => $_POST['product_price'],
                'product_qty' => $_POST['product_qty']
            );
            //add to session cart item in to array
            $_SESSION['cart'][$product_id] = $product_array;

            //product allready in cart
        } else {

            echo '<script>alert("Product was allready added");</script>';
            // echo '<script>window.location="home.php";</script>';
        }

        //if this is the first product
    } else {

        $product_id = $_POST['product_id'];
        $product_img = $_POST['product_img'];
        $product_name = $_POST['product_name'];
        $price = $_POST['product_price'];
        $product_qty = $_POST['product_qty'];

        $product_array = array(
            'product_id' => $product_id,
            'product_img' => $product_img,
            'product_name' => $product_name,
            'price' => $price,
            'product_qty' => $product_qty
        );
        //add to session cart item in to array
        $_SESSION['cart'][$product_id] = $product_array;
    }
} else if (isset($_POST['remove_product'])) { //remove product

    $product_id = $_POST['product_id'];

    unset($_SESSION['cart'][$product_id]);
} else {
    header('location:home.php');
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
</head>

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
                <!-- Cart Products  -->

                <?php foreach ($_SESSION['cart'] as $key => $value) { ?>

                    <tr>
                        <td>
                            <div class="product-info">
                                <img src=<?php echo $value['product_img']; ?>>
                                <div>
                                    <p><?php echo $value['product_name']; ?></p>
                                    <small><span>Rs.</span><?php echo $value['price']; ?></small>
                                    <br>
                                    <form action="cartCopy.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $value['product_id'] ?>">
                                        <input type="submit" name="remove_product" class="remove-btn" value="remove">
                                    </form>
                                    <!-- <button class="remove-cart" onclick="removeCart(<?php echo $value['product_id'] ?>)">Remove</button> -->
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="number" value="<?php echo $value['product_qty']; ?>" min="1" id="update_qty">
                            <button onclick="updateCart(<?php echo $value['product_id'] ?>);" class="edit-btn">Edit</button>
                        </td>
                        <td>
                            <span>Rs.</span>
                            <span class="product-price">1500</span>
                        </td>
                    </tr>

                <?php } ?>

            </table>
            <!-- Cart Products  -->

            <!-- Total -->
            <div class="cart-total">
                <table>
                    <tr>
                        <td>Subtotal</td>
                        <td>Rs.1500</td>
                    <tr>
                        <td>Total</td>
                        <td>Rs.1500</td>
                    </tr>
                    </tr>
                </table>
            </div>
        </div>

        <div class="checkout-container">
            <button class="btn checkout-btn">CheckOut</button>
        </div>
    </section>
    <!-- cart -->

    <?php include "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="js/script.js"></script>
    <script src="js/cart.js"></script>
</body>

</html>