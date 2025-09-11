<?php
require('database/connection.php');
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$admin_rs = Database::search("SELECT * FROM admin WHERE email='" . $_SESSION['admin']['email'] . "'");

if ($admin_rs->num_rows == 0) {
    header("Location: login.php");
    exit();
}

$admin_data = $admin_rs->fetch_assoc();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="css/profile.css">

    <link rel="icon" href="images/icon/M.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />


    <!-- Load SweetAlert2 from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <div class="profile-container">
        <!-- Sidebar Section -->
        <div class="profile-sidebar">
            <img src="images/icon/avatar-01.jpg" alt="Admin Profile">
            <h2><?php echo $admin_data['fname'] . " " . $admin_data['lname'] ?></h2>
            <p>Administrator</p>
        </div>

        <!-- Profile Details Section -->
        <div class="profile-details">
            <h3>Profile Information</h3>
            <div class="detail-row">
                <label for="email">Email:</label>
                <input name="email" value="<?php echo $_SESSION['admin']['email'] ?>" type="email" id="email" class="form-control" required>
            </div>
            <form class="detail-row form-group">
                <label for="fname">First Name:</label>
                <input name="fname" value="<?php echo $_SESSION['admin']['fname'] ?>" type="text" id="f-name" class="form-control" required>
            </form>
            <div class="detail-row">
                <label for="lname">Last Name:</label>
                <input name="lname" value="<?php echo $_SESSION['admin']['lname'] ?>" type="text" id="l-name" class="form-control" required>
            </div>
            <!-- <div class="detail-row">
                <label>Joined:</label>
                <span>January 1, 2022</span>
            </div> -->

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button class="btn-edit" onclick="editProfile();">Edit Profile</button>
                <button class="btn-logout"><a href="process/logOut.php">Log Out</a></button>
            </div>
        </div>
    </div>
    <div class="profile-container">
        <!-- Sidebar Section -->
        <div class="profile-sidebar">
            <p>Reset Password</p>
        </div>

        <!-- Profile Details Section -->
        <div class="profile-details">
            <h3>Profile Information</h3>
            <div class="detail-row">
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="account-paassword" name="password" placeholder="Change Password">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('account-paassword', 'toggle-password-eye')" style="border: none; background: none;">
                            <i class="fa fa-eye" id="toggle-password-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" onkeyup="showMsg();" id="account-paassword-confirm" name="confirmpassword" placeholder="Confirm Password">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('account-paassword-confirm', 'toggle-confirm-password-eye')" style="border: none; background: none;">
                            <i class="fa fa-eye" id="toggle-confirm-password-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label id="show-msg" style="color: red;"></label>
                </div>
                <!-- <div class="detail-row">
                <label>Joined:</label>
                <span>January 1, 2022</span>
            </div> -->

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="btn-edit" onclick="updatePassword();" >Reset Password</button>
                </div>
            </div>
        </div>
</body>

<script src="programjs/profile.js"></script>

</html>