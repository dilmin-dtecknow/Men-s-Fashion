<?php

$oderId = $_GET['oderId'];

require('../database/connection.php');

$order_status_rs = Database::search("SELECT order_status_id FROM order_item WHERE orders_id='$oderId'");

if ($order_status_rs->num_rows != 0) {
    $result_row = $order_status_rs->fetch_assoc();

//    echo $result_row['order_status_id'];

    if ($result_row['order_status_id'] == 1) {
        // echo $result_row['order_status_id'];
        try {
            Database::iud("UPDATE order_item SET order_status_id='2' WHERE orders_id='$oderId'");
            echo 'success2';
        } catch (Exception $e) {
            echo $e;
        }
    } else if ($result_row['order_status_id'] == 2) {
        // echo $result_row['order_status_id'];
        try {
            Database::iud("UPDATE order_item SET order_status_id='3' WHERE orders_id='$oderId'");
            echo 'success3';
        } catch (Exception $e) {
            echo $e;
        }
    }else if ($result_row['order_status_id'] == 3) {
        // echo $result_row['order_status_id'];
        try {
            Database::iud("UPDATE order_item SET order_status_id='4' WHERE orders_id='$oderId'");
            echo 'success4';
        } catch (Exception $e) {
            echo $e;
        }
    }else{
        echo 'package successfuly deliverd';
    }
}
