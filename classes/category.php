<?php

namespace Classes;

use Classes\DatabaseConnection;
class  Category{
    
    public $name;
    public $description;

    public function AddCategory($name, $description) {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $sql = "INSERT INTO Category(name, description) VALUES (:name, :description)";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
    
            return $stmt->execute(); 
        } catch (\PDOException $e) {
            echo "Error adding category: " . $e->getMessage();
            return false; 
        }
    }
    
    public function UpdateCategory($id, $name, $description) {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $sql = "UPDATE Category SET name = :name, description = :description WHERE id = :id";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
    
            return $stmt->execute(); 
        } catch (\PDOException $e) {
            echo "Error updating category: " . $e->getMessage();
            return false; 
        }
    }
    

    public function DeleteCategory($id) {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $sql = "DELETE FROM Category WHERE id = :id";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(':id', $id);
    
            return $stmt->execute(); 
        } catch (\PDOException $e) {
            echo "Error deleting category: " . $e->getMessage();
            return false; 
        }
    }
    
    public static function ShowCategory() {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "SELECT * FROM Category";
            $stmt = $con->prepare($sql);
            
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error showing Category: " . $e->getMessage();
            return false;
        }
    }
    
}