<?php
session_start();
require('../database/connection.php');
if (isset($_POST['new_password'])) {
    if (isset($_SESSION['admin'])) {
        $logUserId = $_SESSION['admin']['email'];
        $new_password = $_POST['new_password'];

        $loguser_rs = Database::search("SELECT * FROM admin WHERE email='$logUserId'");

        if ($loguser_rs->num_rows != 0) {
            $logUser_row = $loguser_rs->fetch_assoc();

            $userId = $logUser_row['email'];

            Database::iud("UPDATE admin SET password='$new_password' WHERE email='$userId'");

            echo 'password_updated';
        } else {
            echo "Invalide User Access!";
        }
    }
} else {
    echo 'Invalid Request!';
}
