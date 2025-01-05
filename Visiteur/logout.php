<?php
require_once '../autoload.php'; 

use Classes\User;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    error_log("Logout triggered");
    User::logout();
}

//for admin I'dont want add Form 
session_start();
session_unset();
session_destroy();
header("Location: ../index.html");
exit;
