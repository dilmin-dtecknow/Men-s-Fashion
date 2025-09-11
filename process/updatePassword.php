<?php
session_start();
require('../database/connection.php');
if (isset($_POST['new_password'])) {
    if (isset($_SESSION['user'])) {
        $logUserId = $_SESSION['user']['id'];
        $new_password = $_POST['new_password'];

        $loguser_rs = Database::search("SELECT * FROM user WHERE id='$logUserId'");

        if ($loguser_rs->num_rows != 0) {
            $logUser_row = $loguser_rs->fetch_assoc();

            $userId = $logUser_row['id'];

            Database::iud("UPDATE user SET password='$new_password' WHERE id='$userId'");

            echo 'password_updated';
        } else {
            echo "Invalide User Access!";
        }
    }
} else {
    echo 'Invalid Request!';
}
