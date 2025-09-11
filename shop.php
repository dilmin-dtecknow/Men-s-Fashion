<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

    <link rel="stylesheet" href="css/style.css">

    <!-- Load SweetAlert2 from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body onload="loadShop();" >
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
                <hr style="width: 150px; color: orange;">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="axil-shop-top mb--40">
                            <div class="category-select align-items-center justify-content-lg-end justify-content-between">
                                <!-- Start Single Select  -->

                                <select class="single-select btn btn-warning" id="p-sort">
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
                <h4>Category</h4>
                <ul class="list-group mb-4">
                    <?php while ($category_row = $category_rs->fetch_assoc()) {
                        // Use the category name or ID to make each checkbox unique
                        $category_id = $category_row['catagory_id']; // Assuming you have category_id
                    ?>
                        <li class="list-group-item">
                            <input type="radio" name="category" id="<?php echo $category_id; ?>" class="form-check-input">
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
                <h4>Filter by Price</h4>
                <div class="price-slider-container">
                    <input type="range" class="form-range" min="0" max="10000" step="100" id="minPriceRange" value="0" oninput="updateMinPriceValue(this.value)">
                    <input type="range" class="form-range" min="0" max="10000" step="100" id="maxPriceRange" value="10000" oninput="updateMaxPriceValue(this.value)">
                    <p>Rs. <span id="minPriceRangeValue">0</span> - Rs. <span id="maxPriceRangeValue">10000</span></p>
                </div>



                <!-- Colors -->
                <h4>Color</h4>
                <ul class="list-group mb-4">
                    <?php while ($color_row = $color_rs->fetch_assoc()) {
                        $color_id = $color_row['color_id']; // Assuming  have color_id
                        $color_name = $color_row['color_name']; // Color name (e.g., 'Red')
                    ?>
                        <li class="list-group-item d-flex align-items-center">
                            <!-- Checkbox on the left -->
                            <input type="radio" id="<?php echo $color_id; ?>" class="form-check-input me-2" name="colour">

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
                <h4>Size</h4>
                <ul class="list-group mb-4">
                    <?php while ($size_row = $size_rs->fetch_assoc()) {
                        $size_id = $size_row['size_id']; // Assuming  have size_id
                        $size_name = $size_row['size_name']; // size name (e.g., 'M')
                    ?>
                        <li class="list-group-item">
                            <input type="radio" id="<?php echo $size_id; ?>" name="size" class="form-check-input">
                            <label for="<?php echo $size_id; ?>"><?php echo $size_name; ?></label>
                        </li>
                    <?php } ?>
                </ul>

                <!-- Brands -->
                <h4>Brands</h4>
                <ul class="list-group mb-4">
                    <?php while ($brand_row = $brand_rs->fetch_assoc()) {
                        $brand_id = $brand_row['brand_id']; // Assuming  have size_id
                        $brand_name = $brand_row['brand_name']; // size name (e.g., 'M')
                    ?>
                        <li class="list-group-item">
                            <input type="radio" id="<?php echo $brand_id; ?>" class="form-check-input" name="brand">
                            <label for="<?php echo $brand_id; ?>"><?php echo $brand_name; ?></label>
                        </li>
                    <?php } ?>
                </ul>

                <div class="border p-4 rounded mb-4">
                    <button class="axil-btn btn btn-primary" onclick="searchProducts(0);">Apply</button>
                    <button class="axil-btn btn btn-info" onclick="window.location.reload();">Reset All</button>
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
                    <div class="row" id="product-container">

                        <!-- Product 1 -->
                        <dive class="products text-center col-lg-3 col-md-4 col-sm-12" id="single-product" >
                            <img src="webImg/feturep1.jpg" class="product-image img-fluid mb-3" id="single-product-img-1" />
                            <div class="star">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h5 class="p-name" id="single-product-title">Sports Shose</h5>
                            <h4 class="p-price" id="single-product-price" >4000</h4>
                            <a href="#" id="single-product-a-2" class="buy-now-btn btn btn-outline-secondary" style="color: white; font-weight: bold;">Buy Now</a>
                        </dive>

                        <!-- Product 2 -->
                        <dive class="products text-center col-lg-3 col-md-4 col-sm-12">
                            <img src="webImg/feturep2.jpg" class="img-fluid mb-3 product-image" />
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
                            <img src="webImg/feturep3.jpg" class="img-fluid mb-3 product-image" />
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
                            <img src="webImg/feturep1.jpg" class="img-fluid mb-3  product-image" />
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
                            <img src="webImg/feturep2.jpg" class="img-fluid mb-3  product-image" />
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
                            <img src="webImg/feturep3.jpg" class="img-fluid mb-3  product-image" />
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
                    <nav aria-label="Page navigation" id="pagination-container" >
                        <ul class="pagination justify-content-center mt-4">
                            <li class="page-item"><a class="page-link" href="#" id="pagination-button" >Previous</a></li>
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