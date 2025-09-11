<?php
session_start();
// require('database/connection.php');

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit(); // Stop further script execution
}

$user_status_id = $_SESSION["user"]["user_type_id"];

// // Fetch the logged-in user details
// $user_rs = Database::search("SELECT * FROM user WHERE id='$logUserId'");
// $user = $user_rs->fetch_assoc();

// // If the user is found, fetch the cart items
// if ($user != null) {
//     // $user_id = $user['id'];
//     $user_status_id = $user['user_type_id'];
    if ($user_status_id != 2) {
        header("Location: home.php");
        exit(); // Stop further script execution
    }
// } else {
//     header("Location: register.php");
//     exit(); // Stop further script execution
// }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Seller Product Registration with Image Preview</title>
    <!-- Google Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="registation/product-registation.css">

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
                <li><a href=""><i class="fas fa-plus"></i> Register Product</a></li>
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
            <h2>Register Your Product</h2>
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <!-- Category -->

                    <?php include('process/get_filters.php'); ?>
                    <select required id="productCategory" name="productCategory">
                        <option value="0">Select Category</option>
                        <?php while ($category_row = $category_rs->fetch_assoc()) {
                            // Use the category name or ID to make each checkbox unique
                            $category_id = $category_row['catagory_id']; // Assuming you have category_id
                        ?>
                            <option value="<?php echo $category_id ?>"><?php echo $category_row['catagory_name']; ?></option>
                        <?php } ?>

                    </select>
                    <!-- Brand -->
                    <select id="brandSelect" name="option1" required>
                        <option value="0">Select Brand</option>
                        <?php while ($brand_row = $brand_rs->fetch_assoc()) {
                            $brand_id = $brand_row['brand_id']; // Assuming  have size_id
                            $brand_name = $brand_row['brand_name']; // size name (e.g., 'M')
                        ?>
                            <option value="<?php echo $brand_id ?>"><?php echo $brand_name ?></option>
                        <?php } ?>
                    </select>

                    <!-- Size -->
                    <select id="sizeSelect" name="option2" required>
                        <option value="0">Select Size</option>
                        <?php while ($size_row = $size_rs->fetch_assoc()) {
                            $size_id = $size_row['size_id']; // Assuming  have size_id
                            $size_name = $size_row['size_name']; // size name (e.g., 'M')
                        ?>
                            <option value="<?php echo $size_id; ?>"><?php echo $size_name; ?></option>
                        <?php } ?>
                    </select>

                    <!-- colour -->
                    <select id="colorSelect" name="option3" required>
                        <option value="0">Select Colour</option>
                        <?php while ($color_row = $color_rs->fetch_assoc()) {
                            $color_id = $color_row['color_id']; // Assuming  have color_id
                            $color_name = $color_row['color_name']; // Color name (e.g., 'Red')
                        ?>
                            <div style="background-color: <?php echo $color_name; ?>; height: 15px; width: 15px; border: 1px solid #000; margin-left: 10px;"></div>
                            <option value="<?php echo $color_id; ?>"><?php echo $color_name; ?></option>
                        <?php } ?>
                    </select>

                    <!-- Custom Color Dropdown -->
                    <!-- <div class="custom-color-dropdown">
                        <select id="colorSelect" name="option3" required>
                            <option value="0">Select Colour</option>
                            <?php while ($color_row = $color_rs->fetch_assoc()) {
                                $color_id = $color_row['color_id']; // Assuming you have color_id
                                $color_name = $color_row['color_name']; // Color name (e.g., 'Red')
                                $color_code = $color_row['color_code']; // Hex color code or valid CSS color name
                            ?>
                                <option value="<?php echo $color_id; ?>" data-color="<?php echo $color_code; ?>">
                                    <?php echo $color_name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div> -->


                    <!-- <style>
                        .custom-color-dropdown select {
                            width: 200px;
                            padding: 10px;
                            border: 1px solid #ccc;
                            border-radius: 5px;
                            appearance: none;
                            -moz-appearance: none;
                            -webkit-appearance: none;
                            background-color: #fff;
                            position: relative;
                        }

                        .custom-color-dropdown {
                            position: relative;
                            display: inline-block;
                        }

                        .custom-color-dropdown::before {
                            content: '';
                            position: absolute;
                            right: 10px;
                            top: 50%;
                            transform: translateY(-50%);
                            border: 6px solid transparent;
                            border-top-color: #000;
                        }

                        .color-sample {
                            display: inline-block;
                            width: 15px;
                            height: 15px;
                            border-radius: 50%;
                            margin-right: 10px;
                            vertical-align: middle;
                        }
                    </style> -->


                    <!-- Product Name -->
                    <input type="text" placeholder="Product Name" id="productName" name="productName" required>
                    <!-- Price -->
                    <input type="number" id="productPrice" name="productPrice" step="0.01" placeholder="Price" min="1" required>

                    <!-- quantity -->
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" min="1" value="1" required>
                    </div>

                    <!-- Description Field (Textarea) -->
                    <textarea placeholder="Product Description" id="productDescription" name="productDescription" rows="4" required></textarea>

                    <!-- 3 Image Choosers with Preview -->
                    <div class="image-upload">
                        <label for="image1"><i class="fa-solid fa-image"></i>&nbsp;Choose Image 1</label>
                        <input type="file" id="image1" accept="image/*" onchange="previewImage(event, 'imagePreview1')">
                        <img id="imagePreview1" class="image-preview" src="" alt="Image Preview 1">
                    </div>

                    <div class="image-upload">
                        <label for="image2"><i class="fa-solid fa-image"></i>&nbsp;Choose Image 2</label>
                        <input type="file" id="image2" accept="image/*" onchange="previewImage(event, 'imagePreview2')">
                        <img id="imagePreview2" class="image-preview" src="" alt="Image Preview 2">
                    </div>

                    <div class="image-upload">
                        <label for="image3"><i class="fa-solid fa-image"></i>&nbsp;Choose Image 3</label>
                        <input type="file" id="image3" accept="image/*" onchange="previewImage(event, 'imagePreview3')">
                        <img id="imagePreview3" class="image-preview" src="" alt="Image Preview 3">
                    </div>

                    <!-- Register Button -->
                    <button style="width: 50%; " type="button" onclick="registerProduct();"><i class="fa-solid fa-cube"></i>&nbsp;&nbsp;Register Product</button>
                </div>
            </form>

            <!-- New Section Under Register Button -->
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
            </div>
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
    <script src="js/productRegistation.js"></script>

</body>

</html>