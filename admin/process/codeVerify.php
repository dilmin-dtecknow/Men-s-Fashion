<?php

session_start();
require('../database/connection.php');

if (isset($_GET['code']) || $_GET['code'] == '') {
    $v_code =  $_GET['code'];




    if (isset($_SESSION['adminemail'])) {
        $logAdminEmail = $_SESSION['adminemail'];

        // echo $v_code;
        $admin_rs = Database::search("SELECT * FROM admin WHERE verification='$v_code' AND email='$logAdminEmail'");


        if ($admin_rs->num_rows == 1) {
            $admin_data = $admin_rs->fetch_assoc();

            // Remove the specific session variable
            unset($_SESSION['adminemail']);
            $_SESSION["admin"] = $admin_data;
            echo ("success");
        } else {
            echo ("invalid verification code.");
        }
    } else {
        echo 'Please login and try again!';
    }
} else {
    echo 'code is empty';
}

// echo 'Server';
