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
    


    public function ShowThemes(){
        $pdo = DatabaseConnection::getInstance()->getConnection();
        try{
            $sql="SELECT * FROM themes";
            $stmt=$pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\Exception $e) {
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