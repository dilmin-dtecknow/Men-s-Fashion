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
if (!isset($_GET['product_id'])) {
    echo 'Product Id Missing';
    exit(); // Stop further script execution
}

$logUserId = $_SESSION["user"]["id"];
$product_id = $_GET['product_id'];

// Fetch the logged-in user details
$user_rs = Database::search("SELECT * FROM user WHERE id='$logUserId'");
$user = $user_rs->fetch_assoc();

// If the user is found, fetch the cart items
if ($user != null) {
    $user_id = $user['id'];
    $product_rs = Database::search("SELECT * FROM product WHERE user_id='$user_id' AND product_id='$product_id'");
    $product_items = $product_rs->num_rows;
    if ($product_items > 0) {
        $product_row = $product_rs->fetch_assoc();

        $pcategory_id = $product_row['catagory_id'];

        $pcategory_rs = Database::search("SELECT * FROM catagory WHERE catagory_id='$pcategory_id'");
        $pcategory_row = $pcategory_rs->fetch_assoc();

        $pbrand_id = $product_row['brand_id'];

        $pbrand_rs = Database::search("SELECT * FROM brand WHERE brand_id='$pbrand_id'");
        $pbrand_row = $pbrand_rs->fetch_assoc();

        $psize_id = $product_row['size_id'];

        $psize_rs = Database::search("SELECT * FROM size WHERE size_id='$psize_id'");
        $psize_row = $psize_rs->fetch_assoc();

        $pcolor_id = $product_row['color_id'];

        $pcolor_rs = Database::search("SELECT * FROM colour WHERE color_id='$pcolor_id'");
        $pcolor_row = $pcolor_rs->fetch_assoc();
    } else {
        echo 'no product Found';
        exit();
    }
} else {
    echo "User not found in the database.";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Products</title>
    <!-- Google Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="registation/product-registation.css">

    <link rel="stylesheet" href="css/updateProduct.css">

    <!-- Load SweetAlert2 from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>

    <div class="container">
        <!-- Sidebar Dashboard -->
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

        <!-- Main Content -->
        <div class="main-content">
            <h2>Update Your Product</h2>
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <!-- Category -->

                    <?php $category_rs = Database::search("SELECT * FROM catagory"); ?>
                    <div class="form-group col-md-6">
                        <label for="productCategory">Quantity:</label>
                        <select required id="productCategory" name="productCategory" disabled>
                            <option selected value="<?php echo $product_row['catagory_id'] ?>"><?php echo $pcategory_row['catagory_name']; ?></option>
                        </select>
                    </div>

                    <!-- Brand -->
                    <?php $brand_rs = Database::search("SELECT * FROM brand"); ?>
                    <div class="form-group col-md-6">
                        <label for="brandSelect">Brand</label>
                        <select id="brandSelect" name="brandSelect" required>
                            <option value="0">Select Brand</option>
                            <?php
                            while ($brand_row = $brand_rs->fetch_assoc()) {
                                $brand_id = $brand_row['brand_id']; // Brand ID
                                $brand_name = $brand_row['brand_name']; // Brand name
                                // Check if this brand is the current one, and set it as selected
                                $selected = ($brand_id == $pbrand_id) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $brand_id; ?>" <?php echo $selected; ?>>
                                    <?php echo $brand_name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- Size -->
                    <?php $size_rs = Database::search("SELECT * FROM size"); ?>
                    <div class="form-group col-md-6">
                        <label for="sizeSelect">Size</label>
                        <select id="sizeSelect" name="sizeSelect" required>
                            <option value="0">Select Size</option>
                            <?php while ($size_row = $size_rs->fetch_assoc()) {
                                $size_id = $size_row['size_id']; // Assuming  have size_id
                                $size_name = $size_row['size_name']; // size name (e.g., 'M')
                                $selected_size = ($size_id == $psize_id) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $size_id; ?>" <?php echo $selected_size; ?>><?php echo $size_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- colour -->
                    <?php $color_rs = Database::search("SELECT * FROM colour"); ?>
                    <div class="form-group col-md-6">
                        <label for="colorSelect">Brand</label>
                        <select id="colorSelect" name="colorSelect" required>
                            <option value="0">Select Colour</option>
                            <?php while ($color_row = $color_rs->fetch_assoc()) {
                                $color_id = $color_row['color_id']; // Assuming  have color_id
                                $color_name = $color_row['color_name']; // Color name (e.g., 'Red')
                                $selected_colur = ($color_id == $pcolor_id) ? 'selected' : '';
                            ?>
                                <div style="background-color: <?php echo $color_name; ?>; height: 15px; width: 15px; border: 1px solid #000; margin-left: 10px;"></div>
                                <option value="<?php echo $color_id; ?>" <?php echo $selected_colur; ?>><?php echo $color_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">

                    <!-- Product Name -->
                    <input type="text" placeholder="Product Name" id="productName" name="productName" value="<?php echo $product_row['product_name'] ?>" required>
                    <!-- Price -->
                    <input type="number" id="productPrice" name="productPrice" step="0.01" placeholder="Price" min="1" value="<?php echo $product_row['price'] ?>" required>

                    <!-- quantity -->
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" min="1" value="<?php echo $product_row['qty'] ?>" required>
                    </div>

                    <!-- Description Field (Textarea) -->
                    <textarea placeholder="Product Description" id="productDescription" name="productDescription" rows="4" required><?php echo $product_row['description'] ?></textarea>

                    <!-- 3 Image Choosers with Preview -->
                    <div class="image-upload">
                        <label for="image1"><i class="fa-solid fa-image"></i>&nbsp;Choose Image 1</label>
                        <input type="file" id="image1" accept="image/*" onchange="previewImage(event, 'imagePreview1')">
                        <!-- Hidden input to hold the current image URL -->
                        <input type="hidden" id="currentImage1" name="currentImage1" value="webImg/productImages/<?php echo $product_row['product_id'] ?>/image1.png">
                        <img id="imagePreview1" class="image-preview" src="webImg/productImages/<?php echo $product_row['product_id'] ?>/image1.png" alt="Image Preview 1">
                    </div>

                    <div class="image-upload">
                        <label for="image2"><i class="fa-solid fa-image"></i>&nbsp;Choose Image 2</label>
                        <input type="file" id="image2" accept="image/*" onchange="previewImage(event, 'imagePreview2')">
                        <input type="hidden" id="currentImage2" name="currentImage2" value="webImg/productImages/<?php echo $product_row['product_id'] ?>/image2.png">
                        <img id="imagePreview2" class="image-preview" src="webImg/productImages/<?php echo $product_row['product_id'] ?>/image2.png" alt="Image Preview 2">
                    </div>

                    <div class="image-upload">
                        <label for="image3"><i class="fa-solid fa-image"></i>&nbsp;Choose Image 3</label>
                        <input type="file" id="image3" accept="image/*" onchange="previewImage(event, 'imagePreview3')">
                        <input type="hidden" id="currentImage3" name="currentImage3" value="webImg/productImages/<?php echo $product_row['product_id'] ?>/image3.png">
                        <img id="imagePreview3" class="image-preview" src="webImg/productImages/<?php echo $product_row['product_id'] ?>/image3.png" alt="Image Preview 3">
                    </div>


                    <!-- Register Button -->
                    <button style="width: 50%; " type="button" onclick="updateProduct('<?php echo $product_row['product_id'] ?>');"><i class="fa-solid fa-cube"></i>&nbsp;&nbsp;Register Product</button>
                </div>
            </form>

            <!-- New Section Under Register Button
            <div class="additional-info">
                <h3>Explore More from Eka Fashion</h3>
                <p>Discover the latest trends in clothes and fashion. Check out our featured products below:</p>
                <div class="product-display">
                    <div class="product-item">
                        <img src="https://th.bing.com/th/id/OIP.ilB9_z9OLjLZJZ7Mi7WVFgHaHa?w=178&h=180&c=7&r=0&o=5&pid=1.7" alt="Trouser">
                        <h3>Trouser</h3>
                        <button class="shop-now-btn">Shop Now</button>
                    </div>
                    <div class="product-item">
                        <img src="https://th.bing.com/th/id/OIP.ZpgL-9LjKksUTspHysxIzwHaJ-?w=148&h=198&c=7&r=0&o=5&pid=1.7" alt="T-shirt">
                        <h3>T-shirt</h3>
                        <button class="shop-now-btn">Shop Now</button>
                    </div>
                    <div class="product-item">
                        <img src="https://th.bing.com/th/id/OIP.ffG_YVJ25yV4GfqOGTPmkAHaMk?w=123&h=210&c=7&r=0&o=5&pid=1.7" alt="Watch">
                        <h3>Watch</h3>
                        <button class="shop-now-btn">Shop Now</button>
                    </div>
                </div>
                <style>
                    .product-display {
                        display: flex;
                        justify-content: space-between;
                        gap: 20px;
                        padding: 20px;
                    }

                    .product-item {
                        text-align: center;
                        width: 300px;
                    }

                    .product-item img {
                        width: 100%;
                        height: auto;
                        border-radius: 8px;
                    }

                    .product-item h3 {
                        margin: 15px 0;
                        font-size: 18px;
                    }

                    .shop-now-btn {
                        background-color: #fa991a;
                        /* Customize button color */
                        color: white;
                        font-size: 16px;
                        padding: 10px 20px;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                        transition: background-color 0.3s ease;
                    }

                    .shop-now-btn:hover {
                        background-color: #d67243;
                        /* Darker shade on hover */
                    }
                </style>
            </div> -->
        </div>
    </div>

    <!-- JavaScript for Image Preview -->
    <script>
        function previewImage(event, previewId) {
            const reader = new FileReader();
            const imagePreview = document.getElementById(previewId);

            reader.onload = function() {
                imagePreview.src = reader.result;
            };

            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <script src="js/updateProducts.js"></script>

</body>

</html>