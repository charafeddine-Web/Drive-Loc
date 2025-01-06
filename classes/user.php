<?php
namespace Classes;
use Classes\DatabaseConnection;
use PDO;

abstract class User{
    protected $full_name;
    protected $email;
    protected $phone;
    protected $password;
    protected $id_role;
    protected $id_user;


    public function __construct($id_user,$full_name,$email, $phone,$id_role){
        $this->full_name=$full_name;
        $this->email=$email;
        $this->phone=$phone;
        $this->id_role=$id_role;
        $this->id_user=$id_user; 
    }

    
    public static function login($email, $password) {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        if (!$pdo) {
            return "Erreur de connexion à la base de données.";
        }
    
        $query = "SELECT id_user, id_role, fullname, password FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                return $user; 
            } else {
                error_log("Password verification failed for email: " . $email);
                return "Mot de passe incorrect.";
            }
        } else {
            error_log("User not found for email: " . $email);
            return "Utilisateur introuvable avec cet email.";
        }
    }
    


public static function logout() {
    session_start();
    if (isset($_SESSION['id_user'])) {  
        session_unset();  
        session_destroy();  
        header("Location: ../index.html");  
        exit();
    }
}


}