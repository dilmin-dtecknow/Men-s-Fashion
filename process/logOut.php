<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Return a success message
header("Location: ../login.php");

?>
