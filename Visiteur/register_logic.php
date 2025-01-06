<?php
require_once '../autoload.php';
use Classes\Client;
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $success_message = "";
    $error_message = [];
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $password = $_POST['password']; 

    if (empty($name) || empty($email) || empty($password) || empty($phone)) {
        $error_message[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message[] = "Invalid email format.";
    }

    if (strlen($password) < 8) {
        $error_message[] = "Password must be at least 8 characters long.";

    }
    if (!empty($error_message)) {
        $_SESSION['error_message'] = $error_message; 
        header('Location: ./register.php');  
        exit();
    }
    if (empty($error_message)) {

            $client = new Client(null, $name, $email, $phone, $password);

            if ($client->register()) {
                session_start();
                $_SESSION['user_id'] = $client->getIduser();  
                $_SESSION['role_id'] = $client->getIdRole();  
                $_SESSION['user_name'] = $client->getfull_name(); 

                if (isset( $_SESSION['user_id']) && $_SESSION['role_id'] == 2) {
                    header("Location: ../client/index.php");
                } else {
                    header("Location: ../admin/index.php");
                }
                exit();
            } else {
                $error_message[] = "Failed to register client. Please try again.";
            }
        
    }
}

