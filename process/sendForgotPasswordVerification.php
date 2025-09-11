<?php
session_start();
require('../database/connection.php');

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    if (empty($email)) {
        echo ("Please enter your Email !!!");
    } else if (strlen($email) >= 100) {
        echo ("Email must have less than 100 characters");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo ("Invalid Email !!!");
    } else {
        $resultSet = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");
        $userList = $resultSet->num_rows;

        if ($userList > 0) {
            $user_row = $resultSet->fetch_assoc();

            $first_name = $user_row['first_name'];
            //generate verification code
            $code = rand(100000, 999999);

            // $hashed_password = password_hash($password, PASSWORD_DEFAULT);


            Database::iud("UPDATE `user` SET `verification`='$code' WHERE 
                `email`='" . $email  . "'");

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
            $mail->setFrom('t3tharusha830@gmail.com', 'Shop Forgot Password Verification');
            $mail->addReplyTo('t3tharusha830@gmail.com', 'Shop Forgot Password Verification');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Your Forgot Password One time Verification Code';
            $bodyContent = "Dear " . $first_name . ",\n\nYour Forgot Password One time verification code is: " . $code . "\n\nThank you!";
            // $bodyContent ='<h1 style="color:red; font-size: 16px; font-weight: bold;">Don\'t Share With enyone!</h1>';
            $mail->Body    = $bodyContent;

            if (!$mail->send()) {
                echo 'Verification code sending failed';
            }
            echo "success";
        } else {
            echo ("Unauthorized access!");
        }
    }
}

// echo 'Server';
