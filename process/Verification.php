<?php

session_start();
require('../database/connection.php');

if (isset($_SESSION['user_email'])) {
    // echo "Logged in user: " . $_SESSION['user_email'];
    $logUserMail =  $_SESSION['user_email'];
    $code = $_POST["verification_code"];

    $resultSet = Database::search("SELECT * FROM `user` WHERE `email`='" . $logUserMail . "' AND `verification`='" . $code . "'");
    $userList = $resultSet->num_rows;

    if ($userList == 1) {
        //user found
        // echo ("Found 1");

        Database::iud("UPDATE `user` SET `verification`='Verified' WHERE 
                `email`='" .$logUserMail  . "'");


        $user = $resultSet->fetch_assoc();

        unset($_SESSION['user_email']);  // Remove the old user email from session

        $_SESSION["user"] = $user;
        echo ("success");
    } else {
        echo ("invalid verification code.");
    }
} else {
    echo "Not a valide user";
}
