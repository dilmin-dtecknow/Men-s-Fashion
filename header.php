<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Nave bar-->
    <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-light bg-white py-3 fixed-top">
        <div class="container-fluid">


            <a class="navbar-brand" href="home.php">
                <img src="webImg/newlogo.png" class="navlogo" />
            </a>


            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Blog</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Us</a>
                    </li>
                    <!-- dropDown-->
                    <li hidden class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <!-- dropDown-->

                    <form class="d-flex d-*-none" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" id="search-text" onkeyup="serchProduct();" aria-label="Search">
                        <button class="btn btn-outline-success" style="color: white; background-color: orange; " type="submit">Search</button>
                    </form>

                    <li class="nav-item">
                        <a href="cart.php"><i class="fas fa-shopping-bag"></i></a>
                    </li>
                    <li class="nav-item">
                       <a href="watchlist.php"> <i class="fa fa-heart" aria-hidden="true"></i></a>
                    </li>

                    <li class="nav-item">
                        <a href="account.php"><i class="fas fa-user"></i></a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <!-- Nave bar-->

    <script src="js/script.js"></script>
    <script src="js/search.js"></script>
</body>

</html>