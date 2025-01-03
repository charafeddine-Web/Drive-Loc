<?php

namespace Classes;

use Classes\DatabaseConnection;
class  Category{
    
    private $name;
    private $description;
    private $id_category;
public function __construct($id_category,$name,$description){
    $this->id_category=$id_category;
    $this->name=$name;
    $this->description=$description;
}
    public function AddCategory() {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $sql = "INSERT INTO Category(name, description) VALUES (:name, :description)";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
    
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
    

    public function DeleteCategory($category_id) {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $sql = "DELETE FROM Category WHERE id_category = :category_id";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(':category_id', $category_id);
          $stmt->execute();
     return $stmt->fetchAll(\PDO::FETCH_OBJ);
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


    public static function ShowDetails($id_category) {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "SELECT * FROM category WHERE id_category = :id_category";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':id_category', $id_category, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            echo "Error showing category details: " . $e->getMessage();
            return false;
        }
    }
    
    
    
}