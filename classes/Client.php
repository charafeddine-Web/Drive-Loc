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
            $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
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
}