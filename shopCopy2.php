<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include "header.php"; ?>

    <div class="allp my-5 py-5"></div>

    <section>
        <div class="producth1 text-center">
            <h1>All Products</h1>
        </div>
    </section>

    <section id="brand" class="container">
        <div class="row">
            <img src="webImg/brand.jpg" class="img-fluid col-lg-3 col-md-6 col-sm-12">
            <img src="webImg/brand2.jpg" class="img-fluid col-lg-3 col-md-6 col-sm-12">
            <img src="webImg/brand3.jpg" class="img-fluid col-lg-3 col-md-6 col-sm-12">
            <img src="webImg/brand4.jpg" class="img-fluid col-lg-3 col-md-6 col-sm-12">
        </div>
    </section>
    <!-- Brands img-->
    <div class="container">
        <hr style="color: orange;">
        <p style="font-size: 40px; cursor: pointer;">🔴🟠🟡🟢🔵🟣🟤⚫⚪🔴🟠🟡🟢🔵🟣🟤⚫⚪🔴🟠🟡🟢🔵</p>
    </div>

    <!-- Main content with sidebar filters and product list -->
    <div class="container my-5">
        <div class="row">

            <!-- Sidebar Filters -->
            <div class="col-lg-3 col-md-4 mb-5">
                <h3>Filter by</h3>
                <hr>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="axil-shop-top mb--40">
                            <div class="category-select align-items-center justify-content-lg-end justify-content-between">
                                <!-- Start Single Select  -->

                                <select class="single-select btn btn-primary" id="p-sort">
                                    <!--                                                            <option class="dropdown-item" >Relevance</option>-->
                                    <option class="dropdown-item">Name, A to Z</option>
                                    <option class="dropdown-item">Name, Z to A</option>
                                    <option class="dropdown-divider"></option>
                                    <option class="dropdown-item">Product, New to Old</option>
                                    <option class="dropdown-item">Product, Old to New</option>
                                    <option class="dropdown-divider"></option>
                                    <option class="dropdown-item">Price, low to high</option>
                                    <option class="dropdown-item">Price, high to low</option>
                                    <option class="dropdown-divider"></option>
                                    <option class="dropdown-item">Brand, A to Z</option>
                                    <option class="dropdown-item">Brand, Z to A</option>
                                </select>
                                <!-- End Single Select  -->
                            </div>
                            <div class="d-lg-none">
                                <button class="product-filter-mobile filter-toggle btn btn-primary"><i class="fas fa-filter"></i> FILTER</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <!-- Categories -->
                <?php include('process/get_filters.php'); ?>
                <h5>Category</h5>
                <ul class="list-group mb-4">
                    <?php while ($category_row = $category_rs->fetch_assoc()) {
                        // Use the category name or ID to make each checkbox unique
                        $category_id = "category_" . $category_row['catagory_id']; // Assuming you have category_id
                    ?>
                        <li class="list-group-item">
                            <input type="radio" name="category" id="<?php echo $category_id; ?>" class="form-check-input" >
                            <label for="<?php echo $category_id; ?>"><?php echo $category_row['catagory_name']; ?></label>
                        </li>
                    <?php } ?>
                    <!-- <li class="list-group-item">
                        <input type="checkbox" id="women" class="form-check-input">
                        <label for="women">Women</label>
                    </li>
                    <li class="list-group-item">
                        <input type="checkbox" id="kids" class="form-check-input">
                        <label for="kids">Kids</label>
                    </li> -->
                </ul>

                <!-- Price Range -->
                <h5>Price Range</h5>
                <input type="range" class="form-range mb-4" min="0" max="5000" step="100" id="priceRange">
                <p>Price: Rs. <span id="priceRangeValue">2500</span></p>

                <!-- Colors -->
                <h5>Color</h5>
                <ul class="list-group mb-4">
                    <?php while ($color_row = $color_rs->fetch_assoc()) {
                        $color_id = "color_" . $color_row['color_id']; // Assuming you have color_id
                        $color_name = $color_row['color_name']; // Color name (e.g., 'Red')
                    ?>
                        <li class="list-group-item d-flex align-items-center">
                            <!-- Checkbox on the left -->
                            <input type="checkbox" id="<?php echo $color_id; ?>" class="form-check-input me-2" onclick="colourSelection('<?php echo $color_id; ?>')">

                            <!-- Label with color name and color sample in a row -->
                            <label for="<?php echo $color_id; ?>" class="d-flex align-items-center">
                                <!-- Color name -->
                                <?php echo $color_name; ?>
                                <!-- Color sample -->
                                <div style="background-color: <?php echo $color_name; ?>; height: 15px; width: 15px; border: 1px solid #000; margin-left: 10px;"></div>
                            </label>
                        </li>
                    <?php } ?>
                </ul>

                <!-- Size -->
                <h5>Size</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item">
                        <input type="radio" id="s" name="size" class="form-check-input">
                        <label for="red">S</label>
                    </li>
                    <li class="list-group-item">
                        <input type="radio" id="m" name="size" class="form-check-input">
                        <label for="blue">M</label>
                    </li>
                    <li class="list-group-item">
                        <input type="radio" id="l" name="size" class="form-check-input">
                        <label for="black">L</label>
                    </li>
                </ul>

                <!-- Brands -->
                <h5>Brands</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item">
                        <input type="checkbox" id="brand1" class="form-check-input">
                        <label for="brand1">Nike</label>
                    </li>
                    <li class="list-group-item">
                        <input type="checkbox" id="brand2" class="form-check-input">
                        <label for="brand2">Adidas</label>
                    </li>
                    <li class="list-group-item">
                        <input type="checkbox" id="brand3" class="form-check-input">
                        <label for="brand3">Puma</label>
                    </li>
                </ul>

                <div class="border p-4 rounded mb-4">
                    <!--<h3 hidden class="mb-3 h6 text-uppercase text-black d-block">Categories</h3>-->
                    <button class="axil-btn btn btn-primary mb-3" onclick="searchProducts();">Apply</button>
                    <button class="axil-btn btn btn-info " onclick="window.location.reload();">Reset All</button>
                </div>
            </div>

            <!-- Products -->
            <div class="col-lg-9 col-md-8">
                <section id="featured" class="my-5">
                    <div class="container">
                        <h3>Our All Products</h3>
                        <hr style="width: 150px; color: orange;">
                        <p>Here you can check our all products 👍</p>
                    </div>

                    <!-- Product List -->
                    <div class="row">

                        <!-- Product 1 -->
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

                        <!-- Product 2 -->
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

                        <!-- Product 3 -->
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
                        <!-- Product 1 -->
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

                        <!-- Product 2 -->
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

                        <!-- Product 3 -->
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

                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mt-4">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>

                </section>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>

    <script src="js/script.js"></script>
    <script src="js/shop.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>