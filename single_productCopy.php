<?php
require('database/connection.php');
if (isset($_GET['product_id'])) {


    $product_id = $_GET['product_id'];

    $product_rs = Database::search("SELECT * FROM product 
    INNER JOIN stock ON product.product_id=stock.product_id 
    INNER JOIN product_img ON product.product_id=product_img.product_id
    INNER JOIN catagory ON catagory.catagory_id=product.catagory_id
    INNER JOIN brand ON brand.brand_id=product.brand_id
    INNER JOIN colour ON colour.color_id=stock.color_id
    WHERE product.product_id='" . $product_id . "' LIMIT 1");
} else {
    header('location:home.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | Single Product</title>

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
    <!-- sigle product -->
    <section class="container single-product my-5 pt-5">
        <div class="row mt-5">

            <?php while ($row = $product_rs->fetch_assoc()) { ?>

                <div class="col-lg-5 col-md-6 col-sm-12">
                    <img class="img-fluid w-100 pb-1" src="<?php echo $row['path'] ?>" id="main-img">

                    <!-- small img -->
                    <div class="small-img-group">
                        <?php $img_rs = Database::search("SELECT * FROM product_img WHERE product_id='" . $row['product_id'] . "'");
                        while ($img_row = $img_rs->fetch_assoc()) {
                        ?>
                            <div class="small-img-col">
                                <img src="<?php echo $img_row['path'] ?>" width="100%" class="small-img">
                            </div>
                        <?php } ?>

                    </div>
                </div>



                <div class="col-lg-6 col-md-12 col-12">
                    <h6>Men/<?php echo $row['catagory_name'] ?></h6>
                    <p class="py-3" id="p_id"><?php echo $row['product_id']; ?></p>
                    <h3 class="py-4"><?php echo $row['product_name']; ?></h3>
                    <h2>Rs.<?php echo $row['price']; ?></h2>
                    <form action="cartCopy.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id'] ?>">
                        <input type="hidden" name="product_img" value="<?php echo $row['path'] ?>">
                        <input type="hidden" name="product_name" value="<?php echo $row['product_name'] ?>">
                        <input type="hidden" name="product_price" value="<?php echo $row['price'] ?>">
                        <input type="number" name="product_qty" value="1" min="1">
                        <button class="add-btn btn btn-dark" type="submit" name="add_to_cart">Add to Cart <i class="fas fa-shopping-bag"></i> </button>
                    </form>



                    <h4 class="mt-5 mb-2">Product Details</h4>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-4">
                                <select class="form-select" id="colour_select" onchange="getBarcode(this.value)">
                                    <?php
                                    $color_rs = Database::search("SELECT * FROM stock 
                                        INNER JOIN colour ON stock.color_id=colour.color_id
                                        INNER JOIN product ON stock.product_id=product.product_id
                                        WHERE product.product_id='" . $product_id . "'; ");
                                    while ($color_row = $color_rs->fetch_assoc()) { ?>
                                        <option value="<?php echo $color_row['color_id'] ?>"><?php echo $color_row['color_name'] ?></option>
                                    <?php } ?>
                                </select>

                            </div>

                            <div class="col-lg-4">
                                <p style="font-size: 12px;">Brand :&nbsp;<span style="font-weight: bold; font-size: 12px; "><?php echo $row['brand_name'] ?></span></p>
                            </div>
                            <div class="col-lg-4">
                                <h4 class="py-3" id="setBarcode"><?php echo $row['barcode']; ?></h4>
                            </div>
                        </div>
                    </div>
                    <span><?php echo $row['description']; ?>
                    </span>
                </div>
            <?php } ?>

        </div>
    </section>

    <!-- Related products-->
    <section id="related-products" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
            <h3>Related products</h3>
            <hr class="br">
        </div>

        <!-- produtcts-->
        <dive class="row mx-auto container-fluid">
            <dive class="products text-center col-lg-3 col-md-4 col-sm-12">
                <img src="webImg/feturep1.jpg" class="img-fluid mb-3" />
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name">Sports Shose</h5>
                <h4 class="p-price">Rs.4000</h4>
                <button class="buy-now-btn btn btn-outline-secondary">Buy Now</button>
            </dive>

            <!-- produtcts 2-->
            <dive class="products text-center col-lg-3 col-md-4 col-sm-12">
                <img src="webImg/feturep2.jpg" class="img-fluid mb-3" />
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name">Sports Shose</h5>
                <h4 class="p-price">Rs.4000</h4>
                <button class="buy-now-btn btn btn-outline-secondary">Buy Now</button>
            </dive>

            <!-- produtcts 3-->
            <dive class="products text-center col-lg-3 col-md-4 col-sm-12">
                <img src="webImg/feturep3.jpg" class="img-fluid mb-3" />
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name">Sports Shose</h5>
                <h4 class="p-price">Rs.4000</h4>
                <button class="buy-now-btn btn btn-outline-secondary">Buy Now</button>
            </dive>

            <!-- produtcts 3-->
            <dive class="products text-center col-lg-3 col-md-4 col-sm-12">
                <img src="webImg/feturep4.jpg" class="img-fluid mb-3" />
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name">Sports Shose</h5>
                <h4 class="p-price">Rs.4000</h4>
                <button class="buy-now-btn btn btn-outline-secondary">Buy Now</button>
            </dive>

        </dive>
        <!-- produtcts-->
    </section>
    <!-- Related products-->

    <section id="approved-paymentmethod">

        <div class="row m-0">
            <div class="col-lg-3 col-md-6">

                <i class="fas fa-shopping-bag"></i> </button>


            </div>

            <div class="col-lg-3 col-md-6">

                <i class="fas fa-shopping-bag"></i> </button>


            </div>

            <div class="col-lg-3 col-md-6">

                <i class="fas fa-shopping-bag"></i> </button>


            </div>

            <div class="col-lg-3 col-md-6">

                <i class="fas fa-shopping-bag"></i> </button>


            </div>
        </div>

    </section>

    <?php include "footer.php"; ?>

    <script>
        var mainimg = document.getElementById("main-img");
        var smallimg = document.getElementsByClassName("small-img");

        for (let i = 0; i < 4; i++) {
            smallimg[i].onclick = function() {
                mainimg.src = smallimg[i].src;
            }
        }
    </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="js/script.js"></script>
</body>

</html>