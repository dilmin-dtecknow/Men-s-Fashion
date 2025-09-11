<?php
require('database/connection.php');
if (isset($_GET['product_id'])) {


    $product_id = $_GET['product_id'];

    $product_rs = Database::search("SELECT * FROM product 
    INNER JOIN product_img ON product.product_id=product_img.product_id
    INNER JOIN catagory ON catagory.catagory_id=product.catagory_id
    INNER JOIN brand ON brand.brand_id=product.brand_id
    INNER JOIN colour ON colour.color_id=product.color_id
    INNER JOIN `size` ON size.size_id=product.size_id
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
    <link rel="stylesheet" href="css/productCard.css">

    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Slick JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!-- Load SweetAlert2 from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

            <?php
            $categoryId;
            $brandId;
            while ($row = $product_rs->fetch_assoc()) {

                $categoryId =  $row['catagory_id'];
                $brandId =  $row['brand_id'];

                $product_rating_rs = Database::search("SELECT p.*, COALESCE(AVG(pr.rating), 0) as average_rating
                                                                FROM product p
                                                                LEFT JOIN product_ratings pr ON p.product_id = pr.product_id WHERE p.product_id='" . $row['product_id'] . "'
                                                                GROUP BY p.product_id 
                                                                ");
                    $product_rating_data = $product_rating_rs->fetch_assoc();
            ?>

                <div class="col-lg-5 col-md-6 col-sm-12">
                    <img class="img-fluid w-100 pb-1" style="height: 400px; object-fit: cover;" src="<?php echo $row['path'] ?>" id="main-img">

                    <!-- small img -->
                    <div class="small-img-group">
                        <?php $img_rs = Database::search("SELECT * FROM product_img WHERE product_id='" . $row['product_id'] . "'");
                        while ($img_row = $img_rs->fetch_assoc()) {
                        ?>
                            <div class="small-img-col">
                                <img src="<?php echo $img_row['path'] ?>" class="small-img img-fluid" style="object-fit: cover; height: 150px; width: 2\150px; ">
                            </div>
                        <?php } ?>

                    </div>
                </div>



                <div class="col-lg-6 col-md-12 col-12">
                    <h6>Men/<?php echo $row['catagory_name'] ?></h6>
                    <p class="py-1" id="p_id"><?php echo $row['product_id']; ?></p>
                    <h2 class="p-name" style="font-weight: bold; color: #F8AE01;" >Ratings:&nbsp;<span style="color: black; font-size: 28px;" ><?php echo number_format($product_rating_data['average_rating'], 1); ?></span></h2>
                    <div class="star">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star" style="color: <?php echo $i <= $product_rating_data['average_rating'] ? 'gold' : 'gray'; ?>" id="star-<?php echo $row['product_id'] . '-' . $i; ?>"
                                onclick="rateProduct('<?php echo $row['product_id']; ?>', <?php echo $i; ?>)">
                            </i>
                        <?php } ?>
                    </div>
                    <h3 class="py-4"><?php echo $row['product_name']; ?></h3>

                    <?php
                    $discount = $row['discount'];
                    $price = $row['price'];

                    $discountwith_price = $discount + $price;
                    if ($row['discount'] != 0) {
                    ?>
                        <!-- <h6 style="color: #EC8383;" ></h6> -->
                        <h4>Today Discount(Save-<p style="color: #EC8383;">RS.<?php echo $discount ?></p>) <p style="color: #FDB13C;">Original Price: RS. <s><?php echo $discountwith_price ?></s></p>
                        </h4>

                    <?php
                    }
                    ?>

                    <h2>Rs.<?php echo $row['price']; ?></h2>
                    <span class="py-4">Available <p style="color: orange; font-weight:bold;"><?php echo $row['qty']; ?>&nbsp;Items</p></span>
                    <form action="" method="post">
                        <input type="hidden" name="product_img" id="<?php echo $row['path'] ?>">
                        <input type="hidden" name="product_name" id="<?php echo $row['product_name'] ?>">
                        <input type="hidden" name="product_price" id="<?php echo $row['price'] ?>">
                        <input type="number" name="product_qty" value="1" min="1" id="add_cart_qty" style="width: 25%;">
                        <?php if ($row['product_status_id'] != 1) { ?>
                            <h6 style="color: red;">Sorry ! Product no longer Available</h6>
                        <?php } else { ?>
                            <button class="add-btn btn btn-dark" type="button" name="add_to_cart" onclick="addToCart(<?php echo $row['product_id']; ?>);">Add to Cart <i class="fas fa-shopping-bag"></i> </button>

                        <?php } ?>
                    </form>

                    <?php if ($row['product_status_id'] != 1) { ?>
                        <h6 style="color: red;">Sorry ! Product no longer Available</h6>
                    <?php } else { ?>
                        <button class="buy-now-btn btn btn-outline-secondary" onclick="addtoWatchlist('<?php echo $row['product_id'] ?>');"><i class="fa fa-heart" aria-hidden="true" id='heart<?php echo $row['product_id'] ?>'></i></button>
                    <?php } ?>



                    <h4 class="mt-5 mb-2">Product Details</h4>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-4">
                                <!-- <select class="form-select" id="colour_select" onchange="getBarcode(this.value)" disabled>
                                    <?php
                                    $product_name = $row['product_name'];
                                    $color_rs = Database::search("SELECT * FROM colour 
                                        INNER JOIN product ON product.color_id=colour.color_id
                                        WHERE product.product_name='" . $product_name . "'; ");
                                    while ($color_row = $color_rs->fetch_assoc()) { ?>
                                        <option value="<?php echo $color_row['color_id'] ?>"><?php echo $color_row['color_name'] ?></option>
                                    <?php } ?>
                                </select> -->

                                <div class="col-lg-4">
                                    <p style="font-size: 12px;">
                                        Colour:&nbsp;<span style="font-weight: bold; font-size: 12px;"><?php echo $row['color_name'] ?></span>
                                    </p>
                                    <div style="background-color: <?php echo $row['color_name'] ?>; width: 20px; height: 20px; border-radius: 50%;"></div>
                                </div>


                            </div>

                            <div class="col-lg-4">
                                <p style="font-size: 12px;">Brand :&nbsp;<span style="font-weight: bold; font-size: 12px; "><?php echo $row['brand_name'] ?></span></p>
                            </div>
                            <div class="col-lg-4">
                                <p style="font-size: 12px;">Size :&nbsp;<span style="font-weight: bold; font-size: 12px; "><?php echo $row['size_name'] ?></span></p>
                            </div>
                            <!-- <div class="col-lg-4">
                                <h4 class="py-3" id="setBarcode"><?php echo $row['product_id']; ?></h4>
                            </div> -->
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

        <?php
        // $categoryId = $row['catagory_id'];
        // $brandId = $row['brand_id'];
        $resultSet = Database::search("SELECT *
            FROM product
            WHERE product.catagory_id = '" . $categoryId . "'
            AND product.brand_id = '" . $brandId . "'
            AND product.product_id != '" . $product_id . "'");
        ?>

        <!-- produtcts-->
        <div class="product-slider">
            <?php while ($related_row = $resultSet->fetch_assoc()) { ?>
                <div class="products text-center">
                    <img src="webImg/productImages/<?php echo $related_row['product_id']; ?>/image1.png" class="img-fluid mb-3 product-img" />
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h5 class="p-name"><?php echo $related_row['product_name']; ?></h5>
                    <h4 class="p-price">Rs.<?php echo $related_row['price']; ?></h4>
                    <button class="buy-now-btn btn btn-outline-secondary" onclick="window.location.href='single_product.php?product_id=<?php echo $related_row['product_id']; ?>'">Buy Now</button>
                </div>
            <?php } ?>

            <!-- <div class="products text-center">
                <img src="webImg/productImages/5/image1.png" class="img-fluid mb-3 product-img" />
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name">Hello</h5>
                <h4 class="p-price">Rs.5000</h4>
                <button class="buy-now-btn btn btn-outline-secondary">Buy Now</button>
            </div> -->
        </div>
        <!-- <?php while ($related_row = $resultSet->fetch_assoc()) { ?>
                <div class="products text-center col-lg-3 col-md-4 col-sm-12">
                    <img src="webImg/productImages/<?php echo $related_row['product_id']; ?>/image1.png" class="img-fluid mb-3 product-img" />
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h5 class="p-name"><?php echo $related_row['product_name']; ?></h5>
                    <h4 class="p-price">Rs.<?php echo $related_row['price']; ?></h4>
                    <button class="buy-now-btn btn btn-outline-secondary" onclick="window.location.href='single_product.php?product_id=<?php echo $related_row['product_id']; ?>'">Buy Now</button>
                </div>
            <?php } ?> -->

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

    <!-- Initialize Slider -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('.product-slider').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                dots: true,
                arrows: true,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });
    </script>
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/addToCart.js"></script>
    <script src="js/ratings.js"></script>
</body>

</html>