<?php
namespace Classes;

use Classes\DatabaseConnection;
use Classes\User;
class Client extends User{
    
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

    public function register(){
        try{
            $con=  DatabaseConnection::getInstance()->getConnection();
            $sql="INSERT into users(fullname,phone,email,password,id_role)values(:full_name,:phone,:email,:password,:id_role)";
            $stmt=$con->prepare($sql);
            // if (!$this->full_name || !$this->email || !$this->password) {
            //     throw new \Exception("Missing required fields: name, email, or password.");
            // }
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
            $id_role=2;
            $stmt->bindParam(':full_name',$this->full_name);
            $stmt->bindParam(':phone',$this->phone);
            $stmt->bindParam(':email',$this->email);
            $stmt->bindParam(':password',$hashedPassword);
            $stmt->bindParam(':id_role', $id_role);

            if($stmt->execute()){
                return true;
            }

        }catch (\PDOException $e) {
            echo "Registration Error: " . $e->getMessage();
            return false;
        }
    }



    public function ShowAllClient() {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "SELECT * FROM users";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            echo "Error retrieving client's reservations: " . $e->getMessage();
            return false;
        }
    }
    public function ViewStatistic() {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $query = "
                SELECT 
                    (SELECT COUNT(DISTINCT user_id) FROM Reservation) AS total_client_res,
                    (SELECT COUNT(DISTINCT id_user) FROM users WHERE id_user NOT IN (SELECT DISTINCT user_id FROM Reservation)) AS total_client_nres
            ";
            
            $stmt = $pdo->query($query);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
            if ($result) {
                return $result; 
            } else {
                return [
                    'total_client_res' => 0,
                    'total_client_nres' => 0,
                ];
            }
        } catch (\PDOException $e) {
            echo "Error retrieving statistics: " . $e->getMessage();
            return false;
        }
    }
    
}