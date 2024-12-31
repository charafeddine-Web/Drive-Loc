<?php
namespace Classes;
use Classes\DatabaseConnection;
use PDO;

abstract class User{
    protected $full_name;
    protected $email;
    protected $phone;
    protected $password;
    protected $id_role=2;
    protected $id_user;


    public function __construct($id_user = null,$full_name,$email, $phone,$id_role){
        $this->full_name=$full_name;
        $this->email=$email;
        $this->phone=$phone;
        $this->id_role=$id_role;
        $this->id_user=$id_user; 
    }

    
   
public function getIdRole() {
        return $this->id_role;
    }
    public function getIduser() {
        return $this->id_user;
    }

public function setfull_name($full_name) {
    $this->full_name = $full_name;
}

public function getfull_name() {
    return $this->full_name;
}

public function setEmail($email) {
    $this->email = $email;
}

public function getEmail() {
    return $this->email;
}

public function setphonr($phone) {
    $this->phone = $phone;
}

public function getphone() {
    return $this->phone;
}
public static function login($email, $password) {
    $pdo = DatabaseConnection::getInstance()->getConnection();
    
    if (!$pdo) {
        echo "Erreur de connexion à la base de données.";
        return null;
    }

    $query = "SELECT id_user, id_role, fullname password FROM users WHERE email = :email";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            session_start();

            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['id_role'] = $user['id_role'];  
            $_SESSION['fullname'] = $user['fullname']; 

            if ($_SESSION['id_role'] != 2) { 
                header("Location: ../admin/index.php");
                exit();
            } else { 
                header("Location: ../client/index.php");
                exit();
            }
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>Swal.fire('Erreur!', 'Mot de passe incorrect.', 'error');</script>";
        }
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>Swal.fire('Erreur!', 'Utilisateur introuvable avec cet email.', 'error');</script>";
    }
}

    
    
    
    public static function logout() {
        session_start();
        if (isset($_SESSION['user_id'])) {
            session_unset();
            session_destroy();
            header("Location: ../index.html");  
            exit();
        }
    }

}