<?php
session_start();
require('../database/connection.php');
require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST['email']) && ($_POST['password'])) {
    $admin_email = $_POST['email'];
    $admin_password = $_POST['password'];

    // echo $admin_email;
    // echo $admin_password;

    $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email`='$admin_email' AND `password`='$admin_password'");

    $admin_num = $admin_rs->num_rows;

    if ($admin_num > 0) {

        // echo 'found';
        //generate verification code
        $code = rand(100000, 999999);

        $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);


        $query = "UPDATE `admin` SET `verification`='$code' WHERE `email`='$admin_email'";

        // echo "Executing query: " . $query;
        Database::iud($query);

        // Save the log admin's  in the session
        $admin_data = $admin_rs->fetch_assoc();
        $first_name = $admin_data['fname'];
        // echo $admin_data;
        $_SESSION['adminemail'] = $admin_data['email'];

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 't3tharusha830@gmail.com';
        $mail->Password = 'c g g m k d l p a j x k g e i z';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('t3tharusha830@gmail.com', 'Mens Fashion Shop Admin Verification');
        $mail->addReplyTo('t3tharusha830@gmail.com', 'Mens Fashion Shop Admin Verification');
        $mail->addAddress($admin_email);
        $mail->isHTML(true);
        $mail->Subject = 'Your Verification Code';
        $bodyContent = "Dear " . $first_name . ",\n\nYour verification code is: " . $code . "\n\nThank you!";
        // $bodyContent ='<h1 style="color:red; font-size: 16px; font-weight: bold;">Don\'t Share With enyone!</h1>';
        $mail->Body    = $bodyContent;

        if (!$mail->send()) {
            echo 'Verification code sending failed';
        }
        echo "success";
    } else {
        echo 'Invalide details';
    }
} else {
    echo 'Email or Password Coruped!';
}

// echo 'Server';
