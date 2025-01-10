<?php
require_once '../../autoload.php'; 
use Classes\DatabaseConnection;

class Theme{
    private ?int $idTheme;
    private ?string $name;
    private ?string $description;

    public function __construct($idTheme,$name,$description){
        $this->idTheme=$idTheme;
        $this->name=$name;
        $this->description=$description;
    }
    public function AddTheme($name, $description){
        $pdo = DatabaseConnection::getInstance()->getConnection();
        try {
            $sql = "INSERT INTO themes (name, description) VALUES (:name, :description)";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":description", $description);
            
            return $stmt->execute();
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            return false; 
        }
    }
    
    public function EditTheme($idTheme) {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        try {
            $sql = "UPDATE themes SET name = :name, description = :description WHERE idTheme = :idTheme";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":idTheme", $idTheme, PDO::PARAM_INT);
            $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
            $stmt->bindParam(":description", $this->description, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            return false; 
        }
    }
    

    public function DeleteTheme($idTheme){
        $pdo = DatabaseConnection::getInstance()->getConnection();
        try {
            $sql = "DELETE FROM themes WHERE idTheme = :idTheme";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":idTheme", $idTheme, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            return false; 
        }
    }
    
    public function GetThemeDetails($idTheme) {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        try {
            $sql = "SELECT * FROM themes WHERE idTheme = :idTheme";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":idTheme", $idTheme, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching theme details: " . $e->getMessage());
        }
    }


    public function ShowThemes() {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        try {
            $sql = "SELECT * FROM themes";
        
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    






    public function getIdTheme(): int {
        return $this->idTheme;
    }

    public function getname(): string {
        return $this->name;
    }

    public function setname(string $name): void {
        $this->name = $name;
    }

    public function getdescription(): string {
        return $this->description;
    }

    public function setdescription(string $description): void {
        $this->description = $description;
    }


}