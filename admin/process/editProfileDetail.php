<?php
session_start();
require('../database/connection.php');

if (!isset($_SESSION['admin'])) {
    echo 'user not found';
    exit();
}
if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email'])) {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];

    if (empty($fname) || $fname == null) {
        echo 'Can not empty first name';
    } else if (empty($lname) || $lname == null) {
        echo 'Can not empty last name';
    } else if (empty($email) || $email == null) {
        echo 'Can not empty Email';
    }else if (strlen($email) >= 100) {
        echo ("Email must have less than 100 characters");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo ("Invalid Email !!!");
    }  else {



        $loguser_email = $_SESSION['admin']['email'];
        $user_rs = Database::search("SELECT * FROM admin WHERE email='$loguser_email'");

        if ($user_rs->num_rows == 0) {
            echo "Invalide User Login";
            exit();
        }

        // echo $fname;
        // echo $lname;
        // echo $email;

        Database::iud("UPDATE admin SET fname='$fname', lname='$lname', email='$email' WHERE email='$loguser_email';");
        echo 'success';
    }
}