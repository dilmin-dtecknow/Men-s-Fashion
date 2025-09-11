<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | Home</title>

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->

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

    <!-- Home-->
    <section id="home">
        <div class="container">
            <h5>NEW ARRIVALS</h5>
            <h1><span>Best Price</span> For You</h1>
            <p>Shop offers the best products for the most lowest prices</p>
            <button class="btn btn-dark">Shop Now</button>
        </div>
    </section>
    <!-- Home-->

    <!-- Brands img-->
    <section id="brand" class="container">
        <div class="row">
            <img src="webImg/brand.jpg" class="img-fluid col-lg-3 col-md-6 col-sm-12">
            <img src="webImg/brand2.jpg" class="img-fluid col-lg-3 col-md-6 col-sm-12">
            <img src="webImg/brand3.jpg" class="img-fluid col-lg-3 col-md-6 col-sm-12">
            <img src="webImg/brand4.jpg" class="img-fluid col-lg-3 col-md-6 col-sm-12">
        </div>
    </section>
    <!-- Brands img-->

    <!-- New img-->
    <section class="w-100" id="newp">
        <div class="row p-0 m-0">

            <!-- 1 -->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img src="webImg/1p.jpg" class="img-fluid">
                <div class="details">
                    <h2>Extermly Awsome Shose</h2>
                    <button class="text-uppercase btn btn-dark btn-outline-secondary">Shop Now</button>
                </div>
            </div>
            <!-- 1 -->

            <!-- 2 -->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img src="webImg/2p.jpg" class="img-fluid">
                <div class="details">
                    <h2>Extermly Awsome Jackets</h2>
                    <button class="text-uppercase btn btn-dark btn-outline-secondary">Shop Now</button>
                </div>
            </div>
            <!-- 2 -->

            <!--3 -->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img src="webImg/3p.jpg" class="img-fluid">
                <div class="details">
                    <h2>50% oFF Watches</h2>
                    <button class="text-uppercase btn btn-dark btn-outline-secondary">Shop Now</button>
                </div>
            </div>
            <!-- 3 -->

        </div>
    </section>
    <!-- New img-->

    <!-- featured products-->
    <section id="featured" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
            <h3>Our Featured products</h3>
            <hr>
            <p>Heare You can check our featured products </p>
        </div>

        <!-- produtcts-->
        <dive class="row mx-auto container-fluid" id="product-results">

            <?php include('process/get_featuerd_product.php'); ?>

            <?php while ($row = $product_rs->fetch_assoc()) { ?>

                <!-- produtcts -->
                <dive class="products text-center col-lg-3 col-md-4 col-sm-12">
                    <?php $image_rs = Database::search("SELECT * FROM product_img WHERE product_id='" . $row['product_id'] . "'");
                    $image_data = $image_rs->fetch_assoc();

                    $product_rating_rs = Database::search("SELECT p.*, COALESCE(AVG(pr.rating), 0) as average_rating
                                                                FROM product p
                                                                LEFT JOIN product_ratings pr ON p.product_id = pr.product_id WHERE p.product_id='" . $row['product_id'] . "'
                                                                GROUP BY p.product_id 
                                                                ");
                    $product_rating_data = $product_rating_rs->fetch_assoc();
                    ?>
                    <img src="<?php echo $image_data['path'] ?>" class="img-fluid mb-3" />
                    <div class="star">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star" style="color: <?php echo $i <= $product_rating_data['average_rating'] ? 'gold' : 'gray'; ?>" id="star-<?php echo $row['product_id'] . '-' . $i; ?>"
                                onclick="rateProduct('<?php echo $row['product_id']; ?>', <?php echo $i; ?>)">
                            </i>
                        <?php } ?>
                    </div>

                    <!-- <h5 class="p-name"><?php echo number_format($product_rating_data['average_rating'], 1); ?></h5> -->

                    <h5 class="p-name"><?php echo $row['product_name'] ?></h5>
                    <h4 class="p-price">Rs.<?php echo $row['price'] ?></h4>

                    <?php if ($row['qty'] > 0) { ?>
                        <h4><?php echo $row['qty'] ?> &nbsp; <span style="color: green;">Itemes Available</span> </h4>
                        <a href="<?php echo "single_product.php?product_id=" . $row['product_id'] ?>"><button class="buy-now-btn btn btn-outline-secondary">Buy Now</button></a>

                    <?php } else { ?>
                        <h4 class="text-danger">Out of Stock</h4>
                        <button class="buy-now-btn btn btn-outline-secondary disabled">Buy Now</button>
                    <?php } ?>
                    <button class="buy-now-btn btn btn-outline-secondary" onclick="addtoWatchlist('<?php echo $row['product_id'] ?>');"><i class="fa fa-heart" aria-hidden="true" id='heart<?php echo $row['product_id'] ?>'></i></button>
                </dive>

            <?php } ?>

        </dive>
        <!-- produtcts-->
    </section>
    <!-- featured products-->


    <!-- Home-->
    <section id="home">
        <div class="container">
            <h5>NEW ARRIVALS</h5>
            <h1><span>Best Price</span> For You</h1>
            <p>Shop offers the best products for the most lowest prices</p>
            <button class="btn btn-dark">Shop Now</button>
        </div>
    </section>
    <!-- Home-->

    <!-- All products-->
    <section id="featured" class="my-5">
        <div class="container text-center mt-5 py-5">
            <h3>Our Featured products</h3>
            <hr>
            <p>Heare You can check our featured products </p>
        </div>

        <?php $all_products_rs = Database::search("SELECT * FROM product") ?>
        <!-- produtcts-->
        <dive class="row mx-auto container-fluid">
            <div class="product-slider">
                <?php while ($all_products_data = $all_products_rs->fetch_assoc()) {
                    $product_rating_rs = Database::search("SELECT p.*, COALESCE(AVG(pr.rating), 0) as average_rating
                                FROM product p
                                LEFT JOIN product_ratings pr ON p.product_id = pr.product_id WHERE p.product_id='" . $all_products_data['product_id'] . "'
                                GROUP BY p.product_id 
                                ");
                    $product_rating_data = $product_rating_rs->fetch_assoc();
                ?>
                    <div class="products text-center">
                        <img src="webImg/productImages/<?php echo $all_products_data['product_id']; ?>/image1.png" class="img-fluid mb-3 product-img" />
                        <div class="star">
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <i class="fas fa-star" style="color: <?php echo $i <= $product_rating_data['average_rating'] ? 'gold' : 'gray'; ?>" id="star-<?php echo $all_products_data['product_id'] . '-' . $i; ?>"
                                    onclick="rateProduct('<?php echo $all_products_data['product_id']; ?>', <?php echo $i; ?>)">
                                </i>
                            <?php } ?>
                        </div>
                        <h5 class="p-name"><?php echo $all_products_data['product_name'] ?></h5>
                        <h4 class="p-price">Rs.<?php echo $all_products_data['price'] ?></h4>
                        <?php if ($all_products_data['qty'] > 0) { ?>
                            <h4><?php echo $all_products_data['qty'] ?> &nbsp; <span style="color: green;">Itemes Available</span> </h4>
                            <a href="<?php echo "single_product.php?product_id=" . $all_products_data['product_id'] ?>"><button class="buy-now-btn btn btn-outline-secondary">Buy Now</button></a>

                        <?php } else { ?>
                            <h4 class="text-danger">Out of Stock</h4>
                            <button class="buy-now-btn btn btn-outline-secondary disabled">Buy Now</button>
                        <?php } ?>
                        <button class="buy-now-btn btn btn-outline-secondary" onclick="addtoWatchlist('<?php echo $all_products_data['product_id'] ?>');"><i class="fa fa-heart" aria-hidden="true" id='heart<?php echo $all_products_data['product_id'] ?>'></i></button>
                    </div>
                <?php } ?>


            </div>


        </dive>
        <!-- produtcts-->
    </section>
    <!-- All products-->
    <!-- Home-->
    <section id="home">
        <div class="container">
            <h5>NEW ARRIVALS</h5>
            <h1><span>Best Price</span> For You</h1>
            <p>Shop offers the best products for the most lowest prices</p>
            <button class="btn btn-dark">Shop Now</button>
        </div>
    </section>
    <!-- Home-->

    <!-- Category products-->
    <?php $category_rs = Database::search("SELECT * FROM catagory") ?>

    <?php while ($category_row = $category_rs->fetch_assoc()) { ?>
        <section id="featured" class="my-5">
            <div class="container text-center mt-5 py-5">
                <h3 style="color:chocolate;"><?php echo $category_row['catagory_name'] ?></h3>
                <hr>
                <p>Heare You can check our Category Vise products </p>
            </div>

            <?php $category_products_rs = Database::search("SELECT * FROM product WHERE catagory_id='" . $category_row['catagory_id'] . "'") ?>
            <!-- produtcts-->
            <dive class="row mx-auto container-fluid">
                <div class="product-slider">
                    <?php while ($category_products_data = $category_products_rs->fetch_assoc()) { ?>
                        <div class="products text-center">
                            <img src="webImg/productImages/<?php echo $category_products_data['product_id']; ?>/image1.png" class="img-fluid mb-3 product-img" />
                            <div class="star">
                                <?php for ($i = 0; $i <= 4; $i++) { ?>
                                    <i class="fas fa-star"></i>
                                <?php } ?>
                            </div>
                            <h5 class="p-name"><?php echo $category_products_data['product_name'] ?></h5>
                            <h4 class="p-price">Rs.<?php echo $category_products_data['price'] ?></h4>
                            <?php if ($category_products_data['qty'] > 0) { ?>
                                <h4><?php echo $category_products_data['qty'] ?> &nbsp; <span style="color: green;">Itemes Available</span> </h4>
                                <a href="<?php echo "single_product.php?product_id=" . $category_products_data['product_id'] ?>"><button class="buy-now-btn btn btn-outline-secondary">Buy Now</button></a>

                            <?php } else { ?>
                                <h4 class="text-danger">Out of Stock</h4>
                                <button class="buy-now-btn btn btn-outline-secondary disabled">Buy Now</button>
                            <?php } ?>
                            <button class="buy-now-btn btn btn-outline-secondary" onclick="addtoWatchlist('<?php echo $category_products_data['product_id'] ?>');"><i class="fa fa-heart" aria-hidden="true" id='heart<?php echo $category_products_data['product_id'] ?>'></i></button>
                        </div>
                    <?php } ?>


                </div>


            </dive>
            <!-- produtcts-->
        </section>
        <!-- Category products-->
    <?php } ?>

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
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
    <script src="js/search.js"></script>
    <script src="js/ratings.js"></script>
</body>

</html>