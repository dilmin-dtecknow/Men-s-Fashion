<?php
session_start();
require('database/connection.php');

// // Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit(); // Stop further script execution
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

    <!-- popup -->
    <link rel="stylesheet" href="css/manageorderdetailspopup.css">

    <!-- Load SweetAlert2 from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body class="animsition">
    <div class="page-wrapper">
<?php include 'header.php' ?>

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- DATA TABLE -->
                            <h3 class="title-5 m-b-35">data table</h3>
                            <div class="table-data__tool">
                                <div class="table-data__tool-left">
                                    <div class="rs-select2--light rs-select2--md">
                                        <label class="form-label fs-5">Frome Date :</label>
                                        <input type="date" class="form-control fs-6" id="fromd" />
                                    </div>
                                    <div class="rs-select2--light rs-select2--md">
                                        <label class="form-label fs-5">To Date :</label>
                                        <input type="date" class="form-control fs-6" id="tod" />
                                    </div>

                                </div>
                                <div class="table-data__tool-right">
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="orderDateSearch();" >
                                        <i class="zmdi zmdi-plus"></i>Serch by date</button>
                                    <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                                        <button class="btn btn-dark" onclick="window.location.reload();" >Refresh</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive table-responsive-data2">

                            </div>
                            <!-- END DATA TABLE -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- USER DATA-->
                            <div class="user-data m-b-30">
                                <h3 class="title-3 m-b-30">
                                    <i class="zmdi zmdi-account-calendar"></i>Order data
                                </h3>
                                <div class="filters m-b-45">
                                    <form class="form-header" action="" method="POST">
                                        <input class="au-input au-input--xl" type="text" name="search"
                                            placeholder="Search Oders &amp; ..." id="inId" onkeyup="searchInvoiceid();" />
                                        <button class="au-btn--submit" type="submit">
                                            <i class="zmdi zmdi-search"></i>
                                        </button>
                                    </form>

                                </div>
                                <div class="table-responsive table-data">
                                    <table class="table table-data2">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Order id
                                                </th>
                                                <th>Order Cost</th>
                                                <th>Order Date</th>
                                                <th>Order To</th>

                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="body">
                                            <?php
                                            // $userId = $_SESSION['user']['id'];
                                            $order_rs =  Database::search("SELECT * FROM orders");

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
                                                            } ?>
                                                            Rs.<?php echo $newTotal ?>
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
                                                            <div class="table-data-feature">

                                                                <button class="item" data-toggle="tooltip"
                                                                    onclick="showOrderDetails('<?php echo $oderId ?>');"
                                                                    data-placement="top" title="More">
                                                                    <i class="zmdi zmdi-more"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                <?php } ?>

                                            <?php } else { ?>
                                                <h2 class="no-order-notifier">No Orders Yet....</h2>
                                            <?php } ?>
                                            <tr class="spacer"></tr>

                                        </tbody>
                                    </table>
                                </div>

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
                                        <button id="confirmOrderButton" class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="confirmOrder();">Change current state</button>

                                    </div>
                                </div>
                                <!-- <div class="user-data__footer">
                                        <button class="au-btn au-btn-load">load more</button>
                                    </div> -->
                            </div>
                            <!-- END USER DATA-->
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                                <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a
                                        href="https://colorlib.com">Colorlib</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>
    <script src="programjs/manageOrder.js"></script>

</body>

</html>