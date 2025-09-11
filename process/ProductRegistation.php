<?php
session_start();
require('../database/connection.php');

if (isset($_SESSION["user"])) {
    //user found in session
    $logUserId = $_SESSION["user"]["id"];

    // echo ($logUserId);
    // echo ($_SESSION["user"]["first_name"]);

    $user_rs = Database::search("SELECT * FROM user WHERE id='$logUserId'");
    $user = $user_rs->fetch_assoc();
    if ($user != null) {
        // echo ('User found in db');

        $user_id = $user['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Retrieve form data
            $mainCategoryId = $_POST['mainCategoryId'];
            $productName = $_POST['productName'];
            $productDescription = $_POST['productDescription'];
            $productPrice = $_POST['productPrice'];
            $brandId = $_POST['brandId'];
            $sizeId = $_POST['sizeId'];
            $colorId = $_POST['colorId'];
            $quantity = $_POST['quantity'];

            if ($mainCategoryId == 0) {
                echo "Please Select category!";
            } else if ($brandId == 0) {
                echo "Please Select brand!";
            } else if ($sizeId == 0) {
                echo "Please Select size!";
            } else if ($colorId == 0) {
                echo "Please Select colour!";
            } else if (empty($productName)) {
                echo 'Please Enter Product Name/Title!';
            } elseif (empty($productPrice)) {
                echo 'Please Enter Product Price!';
            } else if (!is_numeric($productPrice) || (float)$productPrice <= 0) {
                echo 'Invalid Price!';
            } elseif (empty($quantity)) {
                echo 'Please Enter Product quantity!';
            } else if (!is_numeric($quantity) || $quantity <= 0) {
                echo 'Invalid quantity!';
            } elseif (empty($productDescription)) {
                echo 'Please Enter Product Description!';
            } else {
                // echo 'success';

                $category_rs =  Database::search("SELECT * FROM catagory WHERE catagory_id='$mainCategoryId'");

                if ($category_rs->num_rows == 0) {
                    echo "Invalide Category Select!";
                } else {
                    //category id ok
                    $brand_rs = Database::search("SELECT * FROM brand WHERE brand_id='$brandId'");
                    if ($brand_rs->num_rows == 0) {
                        echo 'Invalide Brand Select!';
                    } else {
                        //brand id ok 
                        $size_rs = Database::search("SELECT * FROM size WHERE size_id='$sizeId'");
                        if ($size_rs->num_rows == 0) {
                            echo 'Invalide Size select!';
                        } else {
                            //size id ok
                            $color_rs = Database::search("SELECT * FROM colour WHERE color_id='$colorId'");
                            if ($color_rs->num_rows == 0) {
                                echo 'Invalide colour id select!';
                            } else {
                                //all done
                                // echo "All doneS";
                                // echo "Main Category ID: " . $mainCategoryId . "<br>";
                                // echo "Product Name: " . $productName . "<br>";
                                // echo "Product Description: " . $productDescription . "<br>";
                                // echo "Product Price: " . $productPrice . "<br>";
                                // echo "Brand ID: " . $brandId . "<br>";
                                // echo "Size ID: " . $sizeId . "<br>";
                                // echo "Color ID: " . $colorId . "<br>";
                                // echo "Quantity: " . $quantity . "<br>";

                                // echo $product_id;
                                if (
                                    isset($_FILES['image1']) && $_FILES['image1']['error'] == 0 &&
                                    isset($_FILES['image2']) && $_FILES['image2']['error'] == 0 &&
                                    isset($_FILES['image3']) && $_FILES['image3']['error'] == 0
                                ) {
                                    try {
                                        // Insert product details and get product ID
                                        $product_id = Database::iud("INSERT INTO `product` (`product_name`,`description`,`catagory_id`,`brand_id`,`price`,`qty`,`color_id`,`size_id`,`product_status_id`,`user_id`,`discount`)
                                                            VALUES('$productName','$productDescription','$mainCategoryId','$brandId','$productPrice','$quantity','$colorId','$sizeId','1','$user_id','0')");

                                        // Directory structure
                                        $targetDir = "../webImg/productImages/" . $product_id . "/";

                                        // Create the product folder if it doesn't exist
                                        if (!file_exists($targetDir)) {
                                            mkdir($targetDir, 0777, true); // Creates the directory with permissions
                                        }

                                        // Image files
                                        $image1 = $_FILES['image1'];
                                        $image2 = $_FILES['image2'];
                                        $image3 = $_FILES['image3'];

                                        // Rename and move the files to the product folder
                                        $image1Target = $targetDir . "image1.png";
                                        $image2Target = $targetDir . "image2.png";
                                        $image3Target = $targetDir . "image3.png";

                                        // Initialize an array to store paths for the DB
                                        $imagePaths = [];

                                        // Check and move image 1
                                        if ($image1['error'] == 0) {
                                            if (move_uploaded_file($image1['tmp_name'], $image1Target)) {
                                                echo "Image 1 uploaded as image1.png in folder $product_id.<br>";
                                                $imagePaths[] = "webImg/productImages/$product_id/image1.png";
                                            } else {
                                                echo "Failed to upload Image 1.<br>";
                                            }
                                        }

                                        // Check and move image 2
                                        if ($image2['error'] == 0) {
                                            if (move_uploaded_file($image2['tmp_name'], $image2Target)) {
                                                echo "Image 2 uploaded as image2.png in folder $product_id.<br>";
                                                $imagePaths[] = "webImg/productImages/$product_id/image2.png";
                                            } else {
                                                echo "Failed to upload Image 2.<br>";
                                            }
                                        }

                                        // Check and move image 3
                                        if ($image3['error'] == 0) {
                                            if (move_uploaded_file($image3['tmp_name'], $image3Target)) {
                                                echo "Image 3 uploaded as image3.png in folder $product_id.<br>";
                                                $imagePaths[] = "webImg/productImages/$product_id/image3.png";
                                            } else {
                                                echo "Failed to upload Image 3.<br>";
                                            }
                                        }

                                        // Insert image paths into the database if images were successfully uploaded
                                        foreach ($imagePaths as $path) {
                                            Database::iud("INSERT INTO `product_img` (`path`, `product_id`) VALUES ('$path', '$product_id')");
                                        }

                                        echo 'success';
                                    } catch (Exception $e) {
                                        echo $e->getMessage();
                                    }
                                } else {
                                    echo "All 3 images are required.";
                                }
                            }
                        }
                    }
                }
            }

            // Validate if all 3 images are uploaded
            // if (
            //     isset($_FILES['image1']) && $_FILES['image1']['error'] == 0 &&
            //     isset($_FILES['image2']) && $_FILES['image2']['error'] == 0 &&
            //     isset($_FILES['image3']) && $_FILES['image3']['error'] == 0
            // ) {
            //     // Directory to upload files
            //     // Print form data for debugging
            //     echo "Main Category ID: " . $mainCategoryId . "<br>";
            //     echo "Product Name: " . $productName . "<br>";
            //     echo "Product Description: " . $productDescription . "<br>";
            //     echo "Product Price: " . $productPrice . "<br>";
            //     echo "Brand ID: " . $brandId . "<br>";
            //     echo "Size ID: " . $sizeId . "<br>";
            //     echo "Color ID: " . $colorId . "<br>";
            //     echo "Quantity: " . $quantity . "<br>";
            // } else {
            //     echo "All 3 images are required.";
            // }
        } else {
            echo "Invalid request method.";
        }
    } else {
        echo ('user not found in db');
    }
} else {
    echo ("Please login or SignUp!");
}
