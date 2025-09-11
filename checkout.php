<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | Checkout</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

    <link rel="stylesheet" href="css/style.css">

    <!-- Load SweetAlert2 from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body onload="loadCheckout();">
    <?php include "header.php"; ?>

    <!--  -->
    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5" id="log-text">
            <h2 class="form-weight-bolde">Check Out</h2>
            <hr class="mx-auto">
        </div>

        <div class="mx-auto container col-sm-12">
            <form id="checkout-form">

                <div class="form-group checkout-small-element">
                    <label>First Name</label>
                    <input type="text" name="fname" id="checkout-fname" placeholder="First Name" class="form-control" oninput="capitalizeFirstLetter(this)" required>
                </div>

                <div class="form-group checkout-small-element">
                    <label>Last Name</label>
                    <input type="text" name="lname" id="checkout-lname" placeholder="Last Name" class="form-control" oninput="capitalizeFirstLetter(this)" required>
                </div>

                <!-- <div class="form-group checkout-small-element">
                    <label>Email</label>
                    <input type="email" name="email" id="checkout-email" placeholder="Email" class="form-control" required>
                </div> -->

                <div class="form-group checkout-small-element">
                    <label>Mobile Number</label>
                    <input type="tel" name="mobile" id="checkout-mobile" placeholder="mobile" class="form-control" required>
                </div>
                <div class="form-group checkout-small-element">
                    <label>City</label>
                    <!-- <input type="text" name="city" id="checkout-city" placeholder="City" class="form-control" required> -->
                    <select id="city" class="form-control">
                        <option value="0">Select a City</option>
                    </select>
                </div>

                <div class="form-group checkout-small-element">
                    <label>Postal/Zip Code</label>
                    <input type="text" name="country" id="checkout-zip-code" placeholder="Postal/zip" class="form-control" required>
                </div>

                <div class="form-group checkout-large-element mt-3 mb-2">
                    <label>Address Line 1</label>
                    <input type="text" name="addressl1" id="checkout-addressl1" placeholder="Address Line 1" class="form-control" required>
                </div>

                <div class="form-group checkout-large-element mt-3 mb-2">
                    <label>Address Line 2</label>
                    <input type="text" name="addressl2" id="checkout-addressl2" placeholder="Address Line 2" class="form-control" required>
                </div>

                <div class="form-group checkout-large-element mt-3 mb-2">
                    <input type="checkbox" id="c_ship_different_address">
                    <label for="c_ship_different_address">Ship To A Current Address?</label>
                </div>

                <!-- <style>
                    /* Change background color when the checkbox is checked */
                    input[type="checkbox"]:checked+label {
                        background-color: orange;
                    }
                </style> -->

                <div class="row mb-5">
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black">Your Order</h2>
                        <div class="p-3 p-lg-5 border">
                            <table class="table site-block-order-table mb-5">
                                <thead>
                                    <th>Product</th>
                                    <th>Total</th>
                                </thead>
                                <tbody id="cs-tbody">
                                    <tr id="item-tr">
                                        <td><span id="item-title">Top Up T-Shirt</span> <strong class="mx-2">x</strong> <span id="item-qty">1</span></td>
                                        <td>Rs.&nbsp;<span id="item-subtotal">250.00</span></td>
                                    </tr>


                                    <tr id="order-subtotal-tr">
                                        <td class="text-black font-weight-bold"><strong>Order Subtotal</strong></td>
                                        <td class="text-black">Rs.&nbsp;<span id="subtotal">350.00</span></td>
                                    </tr>
                                    <tr id="order-shipping-tr">
                                        <td class="text-black font-weight-bold"><strong>Shipping Fee</strong></td>
                                        <td class="text-black">Rs.&nbsp;<span id="shipping-amount">350.00</span></td>
                                    </tr>
                                    <tr id="order-total-tr">
                                        <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
                                        <td class="text-black font-weight-bold"><strong>Rs.&nbsp;<span id="total">350.00</span></strong></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="form-group checkout-btn-container">
                    <input type="button" id="checkout-btn" value="Checkout" class="btn" onclick="checkout();" >
                </div>


            </form>
        </div>
    </section>

    <?php include "footer.php"; ?>

    <!-- payHere -->
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/checkout.js"></script>
</body>

</html>