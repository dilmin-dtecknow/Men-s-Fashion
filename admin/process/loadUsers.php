<?php

require('../database/connection.php');

$user_rs =Database::search("SELECT * FROM user 
INNER JOIN user_type ON user.user_type_id=user_type.id
INNER JOIN user_status ON user.user_status_id=user_status.id");

// if ($user_rs->num_rows !=0) {
//     $user_row = $user_rs->fetch_assoc();
// }
?>