<?php
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
echo '<script>window.location.href = "./index.php";</script>';
exit();
?>
