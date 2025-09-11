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

if (!isset($_GET['order_id'])) {
  echo 'Order ID is missing!';
  exit; // Stop further execution
}
// If the user is found, fetch the cart items
if ($user != null) {
  $user_id = $user['id'];
  $order_id = $_GET['order_id'];
  $order_rs = Database::search("SELECT * FROM orders WHERE user_id='$user_id' AND id='$order_id'");
  $order_items = $order_rs->num_rows;

  $order_data = $order_rs->fetch_assoc();

  $address_id = $order_data['address_id'];
  //address
  $address_rs = Database::search("SELECT * FROM address WHERE id='$address_id'");
  $address_row = $address_rs->fetch_assoc();

  if ($order_items == 0) {
    echo 'No Oredr Items Invalide Order!';
    exit();
  }
} else {
  echo "User not found in the database.";
  header("Location: login.php");
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/invoice.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
</head>

<body>
  <div class=" col-12 btn-toolbar mb-3 justify-content-end" style="margin-top: 10px; ">
    <button class=" btn btn-dark me-2" onclick="printInvoice();"><i class="fa-solid fa-print fa-bounce" style="color: #ea7406;"></i> Print</button>
  </div>
  <div class="container my-5" id="page">
    <!-- Invoice Header -->
    <div class="invoice-header text-center mb-4">
      <h1 class="invoice-title">Invoice</h1>
    </div>



    <!-- Invoice Details -->
    <div class="row mb-4">
      <div class="col-md-6">
        <h5>From:</h5>
        <p>
          <strong>Men's Fashion Shop</strong><br>
          123 Fashion Street<br>
          City, Country 12345<br>
          Email: shop@fashionmple.com<br>
          Phone: +123 456 7890
        </p>
      </div>
      <div class="col-md-6 text-md-right">
        <h5>To:</h5>
        <p>
          <strong><?php echo $user['first_name']." ".$user['last_name'] ?></strong><br>
          <?php echo $address_row['line1'] ?><br>
          <?php echo $address_row['line2'] ?><br>
          Email: <?php echo $user['email'] ?><br>
          Phone: <?php echo $address_row['mobile'] ?>
        </p>
      </div>
    </div>

    <!-- Invoice Information -->
    <div class="row mb-4">
      <div class="col-md-6">
        <h5>Invoice #: <strong><?php echo $order_id ?></strong></h5>
      </div>
      <div class="col-md-6 text-md-right">
        <h5>Date: <strong><?php echo $order_data['date_time'] ?></strong></h5>
      </div>
    </div>

    <!-- Invoice Table -->
    <div class="table-responsive mb-4">
      <table class="table table-bordered">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Item Id</th>
            <th scope="col">Item</th>
            <th scope="col">Description</th>
            <th scope="col" class="text-center">Quantity</th>
            <th scope="col" class="text-center">Unit Price</th>
            <th scope="col" class="text-center">Total</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $orderid =  $order_data['id'];
          $order_item_rs = Database::search("SELECT * FROM order_item WHERE orders_id='$orderid'");

          $total_qty = 0;
          $total_amount = 0;
          $newTotal = 0;
          $fullTotal = 0;
          while ($order_item_row = $order_item_rs->fetch_assoc()) {
            $product_id = $order_item_row['product_id'];
            $product_rs = Database::search("SELECT * FROM product WHERE product_id='$product_id'");

            $product_row = $product_rs->fetch_assoc();

            $total = $order_item_row['qty'] * $product_row['price'];
            $total_amount += $total;
            $total_qty += $order_item_row['qty'];



            $length = $order_item_rs->num_rows;
            // echo $length;

            $city_rs = Database::search("SELECT * FROM city WHERE id='" . $address_row['city_id'] . "'");

            while ($city_row = $city_rs->fetch_assoc()) {
              $shippingCharge = $city_row["shipping_charge"];

              $fullTotal = $shippingCharge * $length;

              // $total = $tota_row['total_cost'];
              $newTotal = $total_amount + $fullTotal;
            }

          ?>

            <!-- Sample Row 1 -->
            <tr>
              <td><?php echo $order_item_row['id'] ?></td>
              <td><?php echo $product_row['product_name'] ?></td>
              <td><?php echo $product_row['description'] ?></td>
              <td class="text-center"><?php echo $order_item_row['qty'] ?></td>
              <td class="text-center">RS.<?php echo $product_row['price'] ?>.00</td>
              <td class="text-center">RS.<?php echo $total ?>.00</td>
            </tr>
          <?php } ?>
          <!-- Sample Row 2 -->

        </tbody>
      </table>
    </div>

    <!-- Invoice Total -->
    <div class="row mb-4">
      <div class="col-md-6 offset-md-6">
        <table class="table">
          <tr>
            <th>Total Qtu:</th>
            <td class="text-right"><?php echo $total_qty ?></td>
          </tr>
          <tr>
            <th>Subtotal:</th>
            <td class="text-right">Rs.<?php echo $total_amount ?>.00</td>
          </tr>
          <tr>
            <th>Shiping Fee:</th>
            <td class="text-right">Rs.<?php echo $fullTotal ?>.00</td>
          </tr>
          <tr>
            <th>Total:</th>
            <td class="text-right"><strong>Rs.<?php echo $newTotal ?>.00</strong></td>
          </tr>
        </table>
      </div>
    </div>

    <!-- Footer -->
    <div class="text-center mt-4">
      <p>Thank you for your purchase!</p>
      <p><strong>Men's Fashion Shop</strong> | www.mensfashionshop.com</p>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>


<script src="js/invoice.js"></script>

</html>