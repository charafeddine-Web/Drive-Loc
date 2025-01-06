<?php
require_once '../autoload.php'; 
use Classes\User;
session_start();

$success_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $error_message = [];

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error_message[] = "Veuillez remplir tous les champs.";
    } 

    if (!empty($error_message)) {
        $_SESSION['error_message'] = $error_message; 
        header('Location: ./login.php');  
        exit();
    }

    $user = User::login($email, $password);

    if (is_array($user)) {
        $_SESSION['user'] = $user; 
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['id_role'] = $user['id_role'];
        $_SESSION['fullname'] = $user['fullname'];
    
        if ($_SESSION['id_role'] == 2) {
            header("Location: ../client/index.php");
            exit();
        } else {
            header("Location: ../admin/index.php");
            exit();
        }
    } else {
        $error_message[] = $user; 
        $_SESSION['error_message'] = $error_message; 
        header('Location: ./login.php');  
        exit();
    }
}
