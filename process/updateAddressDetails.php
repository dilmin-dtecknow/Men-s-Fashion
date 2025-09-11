<?php
session_start();
require('../database/connection.php');

if (!isset($_SESSION['user'])) {
    echo 'Please Login First';
    exit();
}

if (isset($_POST['addressFname']) && isset($_POST['addressLname']) && isset($_POST['mobile']) && isset($_POST['addressl1']) && isset($_POST['addressl2']) && isset($_POST['zipcode'])) {
    $fname = $_POST['addressFname'];
    $lname = $_POST['addressLname'];
    $mobile = $_POST['mobile'];
    $addressl1 = $_POST['addressl1'];
    $addressl2 = $_POST['addressl2'];
    $zipcode = $_POST['zipcode'];

    $loguser_id = $_SESSION['user']['id'];
    $user_rs = Database::search("SELECT * FROM user WHERE id='$loguser_id'");

    if ($user_rs->num_rows == 0) {
        echo "Invalide User Login";
        exit();
    }


    Database::iud("UPDATE address SET first_name='$fname', last_name='$lname', line1='$addressl1',line2='$addressl2',postal_code='$zipcode',mobile='$mobile' WHERE user_id='$loguser_id';");
    echo 'success';
}

// echo 'Server';
