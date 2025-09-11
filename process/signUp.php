<?php
// echo("ok");
session_start();
require('../database/connection.php');

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];

$password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

if (empty($first_name)) {
    echo ("Please enter your First Name !!!");
} else if (strlen($first_name) > 45) {
    echo ("First Name must have less than 50 characters");
} else if (empty($last_name)) {
    echo ("Please enter your Last Name !!!");
} else if (strlen($last_name) > 45) {
    echo ("Last Name must have less than 50 characters");
} else if (empty($email)) {
    echo ("Please enter your Email !!!");
} else if (strlen($email) >= 100) {
    echo ("Email must have less than 100 characters");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email !!!");
} else if (empty($password)) {
    echo ("Password field is required. Please fill in the field.");
} else if (!preg_match($password_regex, $password)) {
    echo ("Password must required 1 upper case, 1 lower case, 1 number and special lettter with 8 minimu");
} elseif (empty($confirmPassword)) {
    echo ("Confirm Password field is required. Please fill in the field.");
} else if (!preg_match($password_regex, $confirmPassword)) {
    echo ("Confirm Password must required 1 upper case, 1 lower case, 1 number and special lettter with 8 minimu");
} else if ($password !== $confirmPassword) {
    echo ("Passwords do not match.");
} else {

    $resultSet = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");
    $userList = $resultSet->num_rows;

    if ($userList > 0) {
        echo ("User with Email already used!");
    } else {
        //generate verification code
        $code = rand(100000, 999999);

        $dateTime = new DateTime();
        $timezone = new DateTimeZone("Asia/Colombo");
        $dateTime->setTimezone($timezone);
        $date = $dateTime->format("Y-m-d H:i:s");

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $query = "INSERT INTO `user`
        (`first_name`, `last_name`, `email`, `password`, `verification`, `user_type_id`, `user_status_id`, `joined_date`) 
        VALUES ('$first_name', '$last_name', '$email', '$password', '$code', '1', '1', '$date')";

        // echo "Executing query: " . $query;
        Database::iud($query);

        // Save the registered user's email in the session
        $_SESSION['user_email'] = $email;

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 't3tharusha830@gmail.com';
        $mail->Password = 'c g g m k d l p a j x k g e i z';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('t3tharusha830@gmail.com', 'Shop Verification');
        $mail->addReplyTo('t3tharusha830@gmail.com', 'Shop Verification');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Your Verification Code';
        $bodyContent = "Dear " . $first_name . ",\n\nYour verification code is: " . $code . "\n\nThank you!";
        // $bodyContent ='<h1 style="color:red; font-size: 16px; font-weight: bold;">Don\'t Share With enyone!</h1>';
        $mail->Body    = $bodyContent;

        if (!$mail->send()) {
            echo 'Verification code sending failed';
        }
        echo "success";
    }
}
