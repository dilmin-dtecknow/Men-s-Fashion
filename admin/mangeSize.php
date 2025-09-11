<?php
session_start();
require('database/connection.php');

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit(); // Stop further script execution
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Manage Size</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
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

     <!-- Load SweetAlert2 from CDN -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link rel="icon" href="images/icon/M.png">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <?php include('header.php') ?>

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Form -->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">Add New Size</div>
                                <div class="card-body">
                                    <div class="card-title">
                                        <h3 class="text-center title-2">Add</h3>
                                    </div>
                                    <hr>
                                    <form novalidate="novalidate">
                                        <div class="form-group">
                                            <label for="size-name" class="control-label mb-1">Size Name</label>
                                            <input id="size-name" name="size-name" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                        </div>

                                        <!-- Centering the button -->
                                        <div class="d-flex justify-content-center">
                                            <button id="payment-button" type="button" class="btn btn-lg btn-info" onclick="addSize();" >
                                                <i class="fa fa-plus-circle fa-spin" aria-hidden="true"></i>&nbsp;
                                                <span id="payment-button-amount">Add</span>
                                                <span id="payment-button-sending" style="display:none;">Sending…</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Table -->
                        <section class="col-lg-12">
                            <div>
                                <div class="table-responsive table--no-card m-b-30" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th>Size Id</th>
                                                <th>Name</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $size_rs = Database::search("SELECT * FROM size");
                                            while ($size_row = $size_rs->fetch_assoc()) { ?>
                                                <tr>
                                                    <td><?php echo $size_row['size_id']?></td>
                                                    <td>
                                                        <input type="text" name="size-name" id="size_<?php echo $size_row['size_id']  ?>" value="<?php echo $size_row['size_name']?>">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-dark" onclick="updateSize('<?php echo $size_row['size_id'] ?>');" >Update</button>
                                                    </td>

                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="copyright">
                            <p>Copyright © 2018 Men's Fashion Shop. All rights reserved. Template by <a href="">Men's Fashion Shop</a>.</p>
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

    <!-- page js -->
     <script src="programjs/manageSize.js"></script>

</body>

</html>
<!-- end document-->