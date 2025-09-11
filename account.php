<?php
session_start();
require('database/connection.php');

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit(); // Stop further script execution
}
$logUserId = $_SESSION['user']['id'];
$user_rs = Database::search("SELECT * FROM user WHERE id='$logUserId'");

if ($user_rs->num_rows == 0) {
    header("Location: login.php");
    exit();
}

$user_data = $user_rs->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | My Account</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/orderdetailspopup.css">

    <!-- Load SweetAlert2 from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <?php include "header.php"; ?>

    <section class="my-5 py-5">
        <div class="row container mx-auto">
            <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
                <h3 class="font-weight-bold">Account Info..</h3>
                <hr class="mx-auto">
                <!-- profile img -->
                <div class="col-12 bg-body rounded mt-2 mb-2">
                    <?php
                    $userId = $user_data['id'];
                    $userImagePath = "webImg/usersImage/" . $userId . "/image.png";
                    $defaultImagePath = "webImg/defaultimage.png";

                    // Check if the user's image exists
                    $imagePathToShow = file_exists($userImagePath) ? $userImagePath : $defaultImagePath;
                    ?>
                    <div class="d-flex flex-column align-items-center text-center p-2 py-2">
                        <!-- Image preview element webImg/defaultimage.png-->
                        <img src="<?php echo $imagePathToShow; ?>" class="rounded-circle mt-5" style="width: 150px; cursor: pointer;" id="viewImg" onclick="document.getElementById('profileimg').click();" />
                    </div>

                    <!-- Hidden file input -->
                    <input type="file" class="d-none" id="profileimg" accept="image/*" onchange="previewImage(event)" />

                    <!-- Button to trigger image upload -->
                    <button class="btn btn-success mt-3" onclick="changeImage();">Update Profile Image</button>
                </div>


                <!-- profile info -->
                <div class="account-info">

                    <p style="text-align: center;" class="mt-2 mb-2">Email : &nbsp; <span><?php echo $user_data['email'] ?></span></p>
                    <?php
                    $user_type_id = $user_data['user_type_id'];
                    $type_rs = Database::search("SELECT * FROM user_type WHERE id='$user_type_id'");

                    $type_data = $type_rs->fetch_assoc();
                    ?>
                    <p class="mt-2 mb-2">Type : &nbsp; <span><?php echo  $type_data['name'] ?></span></p>

                    <div class="row">
                        <div class="col-6" style="text-align: start;">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="fname" id="fname" value="<?php echo $user_data['first_name'] ?>">
                        </div>

                        <div class="col-6" style="text-align: start;">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="lname" id="lname" value="<?php echo $user_data['last_name'] ?>">
                        </div>
                        <div class="col-12" style="text-align: start;">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="lname" id="email" value="<?php echo $user_data['email'] ?>">
                        </div>
                    </div>

                    <div class="col-12 d-grid mt-3">
                        <button class="btn" id="update-btn" onclick="updateProfile();">Update My Profile</button>
                    </div>

                    <div class="col-lg-12 mt-3">
                        <h3>Current Shiping Address</h3>
                    </div>

                    <?php
                    $address_rs =  Database::search("SELECT * FROM address WHERE user_id='" . $user_data['id'] . "'  ORDER BY id DESC ");

                    if ($address_rs->num_rows == 0) {
                        echo '<div class="col-12" style="text-align: start;">
                        <label class="form-label">No Curent Address Yet!</label>
                    </div>';
                    } else {
                        $address_data = $address_rs->fetch_assoc();
                    ?>

                        <div class="row">
                            <div class="col-6" style="text-align: start;">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="adfname" id="adfname" value="<?php echo $address_data['first_name'] ?>">
                            </div>

                            <div class="col-6" style="text-align: start;">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="adlname" id="adlname" value="<?php echo $address_data['last_name'] ?>">
                            </div>
                        </div>

                        <div class="col-12" style="text-align: start;">
                            <label class="form-label">Mobile</label>
                            <input type="text" maxlength="10" pattern="[0-9]" class="form-control" name="mobile" id="mobile" value="<?php echo $address_data['mobile'] ?>">
                        </div>

                        <div class="col-12" style="text-align: start;">
                            <label class="form-label">Address Line 1</label>
                            <input type="text" class="form-control" name="address-l1" id="address-l1" value="<?php echo $address_data['line1'] ?>">
                        </div>

                        <div class="col-12" style="text-align: start;">
                            <label class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" name="address-l2" id="address-l2" value="<?php echo $address_data['line2'] ?>">
                        </div>

                        <div class="row">
                            <!-- <div class="col-6" style="text-align: start;">
                            <label class="form-label">Country</label>
                            <select class="form-select" id="country">
                                <option value="0">Select Country</option>
                                <option value="1">Sri Lanka</option>
                            </select>

                        </div> -->
                            <?php
                            $address_city_rs = Database::search("SELECT * FROM city WHERE id='" . $address_data['city_id'] . "'");
                            $address_city_data = $address_city_rs->fetch_assoc();
                            ?>
                            <div class="col-6" style="text-align: start;">
                                <label class="form-label">City</label>
                                <select class="form-select" id="citty" disabled>
                                    <option value="0"><?php echo $address_city_data['name'] ?></option>
                                    <!-- <option value="1">Colombo</option> -->
                                </select>
                            </div>

                            <!-- <div class="col-6" style="text-align: start;">
                            <label class="form-label">District</label>
                            <select class="form-select" id="country">
                                <option value="0">Select District</option>
                                <option value="1">Western</option>
                            </select>

                        </div> -->

                            <div class="col-6" style="text-align: start;">
                                <label class="form-label">Zip Code</label>
                                <input maxlength="5" type="code" class="form-control" name="zipcode" id="zipcode" value="<?php echo $address_data['postal_code'] ?>">
                            </div>

                        </div>

                        <div class="col-12 d-grid mt-3">
                            <button class="btn" id="update-btn" onclick="updateAddress();">Update My Current Address</button>
                        </div>
                    <?php } ?>

                    <p class="mt-3 mb-2"><a href="#" id="orders-btn">Your Orders</a></p>
                    <p><a href="process/logOut.php" id="logout-btn">Log out</a></p>
                </div>

            </div>



            <!-- Change Password -->
            <div class="col-lg-6 col-md-12 col-sm-12">
                <form id="account-form">
                    <h3>Change Password</h3>
                    <hr class="mxauto">
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="account-paassword" name="password" placeholder="Change Password">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('account-paassword', 'toggle-password-eye')" style="border: none; background: none;">
                                <i class="fa fa-eye" id="toggle-password-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" onkeyup="showMsg();" id="account-paassword-confirm" name="confirmpassword" placeholder="Confirm Password">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('account-paassword-confirm', 'toggle-confirm-password-eye')" style="border: none; background: none;">
                                <i class="fa fa-eye" id="toggle-confirm-password-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label id="show-msg" style="color: red;"></label>
                    </div>
                    <div class="form-group">
                        <input type="button" value="Change Password" onclick="updatePassword();" class="btn" id="change-pass-btn">
                    </div>

                    <?php
                    $user = $_SESSION['user'];
                    $userType = $user['user_type_id'];
                    $userStatus = $user['user_status_id'];
                    ?>
                    <div class="form-group">
                        <a href="product-registation.php" style="text-decoration: none; color: #FE9900; ">Product Registation</a>
                    </div>

                </form>
            </div>

            <!-- Orders -->
            <section class="container cart my-5 py-5">
                <div class="container mt-5 col-12">
                    <h2 class="font-weight-bolde">My Orders</h2>
                    <hr>
                    <table class="mt-5 pt-5">
                        <tr>
                            <th>Order Id</th>
                            <th>Order Cost</th>
                            <th>Order Date</th>
                            <th>Order To</th>
                            <th>Order Details</th>
                        </tr>

                        <!-- Cart Products  -->

                        <?php
                        $userId = $_SESSION['user']['id'];
                        $order_rs =  Database::search("SELECT * FROM orders WHERE user_id='$userId'");

                        if ($order_rs->num_rows != 0) {
                            while ($order_row = $order_rs->fetch_assoc()) { ?>

                                <tr>
                                    <td><?php echo $order_row['id'] ?></td>
                                    <td>
                                        <?php
                                        $oderId = $order_row['id'];
                                        $total_rs = Database::search("SELECT SUM(order_item.qty * product.price) AS total_cost FROM order_item INNER JOIN product ON order_item.product_id=product.product_id WHERE orders_id='$oderId'");
                                        $tota_row = $total_rs->fetch_assoc();

                                        $order_item_rs = Database::search("SELECT * FROM order_item WHERE orders_id='$oderId'");



                                        $addressId = $order_row['address_id'];
                                        $address_rs = Database::search("SELECT * FROM address WHERE id='$addressId'");

                                        $length = $order_item_rs->num_rows;
                                        // echo $length;
                                        $addres_row = $address_rs->fetch_assoc();

                                        $addres_row['city_id'];

                                        $city_rs = Database::search("SELECT * FROM city WHERE id='" . $addres_row['city_id'] . "'");
                                        // $city_row = $city_rs->fetch_assoc();

                                        // $total = 0;
                                        $newTotal = 0;
                                        while ($city_row = $city_rs->fetch_assoc()) {
                                            $shippingCharge = $city_row["shipping_charge"];

                                            $fullTotal = $shippingCharge * $length;

                                            $total = $tota_row['total_cost'];
                                            $newTotal = $total + $fullTotal;
                                        }


                                        ?>
                                        <small><span>Rs.<?php echo $newTotal ?></small>
                                    </td>
                                    <td>
                                        <span><?php echo $order_row['date_time'] ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        // $addressId = $order_row['address_id'];
                                        $address_rs = Database::search("SELECT * FROM address WHERE id='$addressId'");

                                        if ($address_rs->num_rows != 0) {
                                            $addres_row = $address_rs->fetch_assoc();
                                        ?>
                                            <span><?php echo $addres_row['line1'] ?> <br><?php echo $addres_row['line2'] ?> <br><?php echo $addres_row['mobile'] ?> </span>
                                        <?php
                                        } else { ?>

                                        <?php } ?>

                                    </td>
                                    <td>
                                        <button class="detail-btn" onclick="showOrderDetails('<?php echo $oderId ?>');">Details</button>
                                    </td>
                                </tr>

                            <?php } ?>

                        <?php } else { ?>
                            <h2 class="no-order-notifier">No Orders Yet....</h2>
                        <?php } ?>


                    </table>
                    <!-- Order Products  -->

                </div>



            </section>
            <!-- order -->

            <!-- orderitem Popup -->
            <div id="orderDetailsModal" class="modal">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeModal();">&times;</span>
                    <h3>Order Details</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total (No Shipping)</th>
                                <th>Order Staus</th>
                                <th>Total (With Shipping)</th>
                            </tr>
                        </thead>
                        <tbody id="orderItemsTableBody"></tbody>
                    </table>
                    <button id="confirmOrderButton" class="detail-btn" onclick="confirmOrder();">Confirm</button>

                </div>
            </div>


        </div>
    </section>

    <?php include "footer.php"; ?>
    <script src="js/script.js"></script>
    <script src="js/profile.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>