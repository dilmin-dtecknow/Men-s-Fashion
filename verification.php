<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | Verification Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

    <link rel="stylesheet" href="css/style.css">

    <!-- Load SweetAlert2 from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5" id="log-text">
            <h2 class="form-weight-bolde">Verification</h2>
            <hr class="mx-auto">
        </div>

        <div class="mx-auto container">
            <form id="login-form">
                
                <div class="form-group">
                    <!-- <label>Email</label> -->
                    <input type="email" name="text" id="code" placeholder="Enter Verification code here" class="form-control" required>
                </div>

                <!-- <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="login-password" placeholder="Password" class="form-control" required>
                </div> -->

                <div class="form-group">
                    <input type="button" id="login-btn" value="Verify Me" class="btn" onclick="Verification();">
                </div>

                <div class="form-group">
                    <a href="register.php" id="register-url" class="btn">Don't have account? Register</a>
                </div>
            </form>
        </div>
    </section>


    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/verification.js"></script>
</body>

</html>