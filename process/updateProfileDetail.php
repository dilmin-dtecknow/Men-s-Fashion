<?php
session_start();
require('../database/connection.php');

if (!isset($_SESSION['user'])) {
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



        $loguser_id = $_SESSION['user']['id'];
        $user_rs = Database::search("SELECT * FROM user WHERE id='$loguser_id'");

        if ($user_rs->num_rows == 0) {
            echo "Invalide User Login";
            exit();
        }

        // echo $fname;
        // echo $lname;
        // echo $email;

        Database::iud("UPDATE user SET first_name='$fname', last_name='$lname', email='$email' WHERE id='$loguser_id';");
        echo 'success';
    }
}
