<?php
session_start();
require('../database/connection.php');

$logUserEmail = $_POST["email"];
$password = $_POST["password"];
$rememberme = $_POST["rememberme"];

// echo($rememberme);
$resultSet = Database::search("SELECT * FROM `user` 
   WHERE `email`='" . $logUserEmail . "' AND `password` = '" . $password . "'");

// $userList = $resultSet->num_rows;


if ($resultSet->num_rows == 1) {
    $user = $resultSet->fetch_assoc();

    if ($user['verification'] != 'Verified') {
        // Set unverified user's email in session
        $_SESSION['user_email'] = $logUserEmail;
        // echo json_encode(["success" => false, "content" => "Unverified"]);
        echo("Unverified");
    } else {
        //verified
        $_SESSION['user'] = $user;

        if ($rememberme == "true") {

            setcookie("email", $logUserEmail, time() + (60 * 60 * 24 * 365), "/");
            setcookie("password", $password, time() + (60 * 60 * 24 * 365), "/");
        } else {

            setcookie("email", "", time() - 3600, "/");
            setcookie("password", "", time() - 3600, "/");
        }
        // echo json_encode(["success" => true, "content" => "Sign-in successful"]);
        echo("success");
    }
} else {
    // echo json_encode(["success" => false, "content" => "Invalid Username or Password"]);
    echo("Invalid Username or Password");
}
