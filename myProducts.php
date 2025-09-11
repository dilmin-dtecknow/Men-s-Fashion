<?php
session_start();
require('database/connection.php');

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit(); // Stop further script execution
}

$user_status_id = $_SESSION["user"]["user_type_id"];

if ($user_status_id != 2) {
    header("Location: home.php");
    exit(); // Stop further script execution
}
$logUserId = $_SESSION["user"]["id"];

// Fetch the logged-in user details
$user_rs = Database::search("SELECT * FROM user WHERE id='$logUserId'");
$user = $user_rs->fetch_assoc();

// If the user is found, fetch the cart items
if ($user != null) {
    $user_id = $user['id'];
    $product_rs = Database::search("SELECT * FROM product WHERE user_id='$user_id'");
    $product_items = $product_rs->num_rows;
} else {
    echo "User not found in the database.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | My Products</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/myproducts.css">

    <!-- Load SweetAlert2 from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom styles for responsiveness -->
    <style>
        /* Responsive Sidebar */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
            color: white;
            transition: 0.3s ease;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li a {
            display: block;
            padding: 15px;
            color: #cfcfcf;
            text-decoration: none;
            font-size: 16px;
            transition: 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #495057;
            color: white;
        }

        .bottom-content {
            position: absolute;
            bottom: 20px;
            width: 100%;
        }

        /* Make sidebar responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
        }

        /* Responsive Table */
        .cart table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart table th,
        .cart table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Make table responsive */
        @media (max-width: 768px) {
            .cart table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            .cart table th,
            .cart table td {
                white-space: nowrap;
            }
        }

        /* Product Info Adjustments */
        .product-info {
            display: flex;
            align-items: center;
        }

        .product-info img {
            width: 60px;
            height: auto;
            margin-right: 15px;
        }

        /* Adjusting Button Styles for Small Screens */
        .btn {
            font-size: 14px;
            padding: 8px 12px;
        }

        /* Adjustments for smaller devices */
        @media (max-width: 480px) {
            .product-info img {
                width: 50px;
            }

            .btn {
                font-size: 12px;
                padding: 6px 10px;
            }
        }
    </style>
</head>

<body>

    <!-- Responsive Sidebar -->
    <div class="sidebar">
        <ul>
            <li><a href="account.php"><i class="fas fa-user"></i> My Profile</a></li>
            <li><a href="product-registation.php"><i class="fas fa-plus"></i> Register Product</a></li>
            <li><a href="#"><i class="fas fa-list"></i> My Orders</a></li>
            <li><a href="myProducts.php"><i class="fas fa-box"></i> My Products</a></li>
            <li><a href="#"><i class="fas fa-edit"></i> Update Products</a></li>
        </ul>
        <div class="bottom-content">
            <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- Cart Section -->
    <section class="container cart my-5 py-5" style="margin-left: 260px;">
        <div class="container mt-5">
            <h2 class="font-weight-bold">My Products</h2>
            <hr>
            <!-- Search Bar -->
            <div class="input-group my-3">
                <input type="text" id="productSearchInput" class="form-control" onkeyup="searchUpdateProduct();" placeholder="Search products by name..." aria-label="Search Products">
                <button class="btn btn-outline-secondary" type="button" onclick="filterProducts()">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <!-- Scrollable Table Container -->
            <div class="table-responsive mt-5 pt-5" style="max-height: 700px; overflow-y: auto;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Size</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="product-results" >
                        <!-- Cart Products -->
                        <?php if ($product_items > 0) {
                            while ($product_row = $product_rs->fetch_assoc()) {

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
                                            <img src="webImg/productImages/<?php echo $product_row['product_id']?>/image1.png" alt="Product Image">
                                            <div>
                                                <p>ID: <?php echo $product_row['product_id']?></p>
                                                <p><?php echo $product_row['product_name']?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="max-width: 200px;">
                                        <p><?php echo $product_row['product_name']?></p>
                                    </td>
                                    <td>
                                        <p><?php echo $category_row['catagory_name']?></p>
                                    </td>
                                    <td>
                                        <p><?php echo $brand_row['brand_name'] ?></p>
                                    </td>
                                    <td>
                                        <p><span>Rs.</span><?php echo $product_row['price']?></p>
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
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="7">No items. <a href="product-registration.php">Register now</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </section>

    <script src="js/script.js"></script>
    <script src="js/myProducts.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>