<?php

$oderId = $_GET['oderId'];

require('../database/connection.php');

$order_status_rs = Database::search("SELECT order_status_id FROM order_item WHERE orders_id='$oderId'");

if ($order_status_rs->num_rows != 0) {
    $result_row = $order_status_rs->fetch_assoc();

    if ($result_row['order_status_id'] != 3) {
        echo 'Your order not shipe Yet!';
    } else {
        try {
            Database::iud("UPDATE order_item SET order_status_id='4' WHERE orders_id='$oderId'");
            echo 'success';

        } catch (Exception $e) {
            echo $e;
        }
    }
}
