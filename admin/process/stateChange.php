<?php

require('../database/connection.php');

$statusId = $_GET['statusid'];
$userId = $_GET['userid'];

// echo "Status ID: " . $statusId;
// echo "User ID: " . $userId;

if ($statusId != 1) {
    Database::iud("UPDATE user SET user_status_id='1' WHERE user.id='$userId'");
    echo 'success';
} else {
    Database::iud("UPDATE user SET user_status_id='2' WHERE user.id='$userId'");
    echo 'success';
}
