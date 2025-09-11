<?php

session_start();

if (isset($_SESSION["admin"])) {
    try {
        unset($_SESSION['admin']);

        header("Location: ../login.php");
        exit();
    } catch (Exception $e) {
        echo $e;
    }
}
