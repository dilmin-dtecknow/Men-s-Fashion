<?php

require('../database/connection.php');

$pid = $_GET['productid'];
$stateId = $_GET['stateId'];

// echo "product ID: " . $pid;
// echo "stateId : " . $stateId;

if ($stateId != 1) {
    Database::iud("UPDATE product SET product_status_id='1' WHERE product_id='$pid'");
    echo 'success';
} else {
    Database::iud("UPDATE product SET product_status_id='2' WHERE product_id='$pid'");
    echo 'success';
}
