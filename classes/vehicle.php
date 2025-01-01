<?php
namespace Classes;
use Classes\DatabaseConnection;

class Vehicle{
    private $idVeh;
    private $Model;
    private $price_day;
    private $disponibilite;
    private $transmissionType;
    private $fuelType;
    private $mileage;
    private $imageVeh;


    public function __construct($idVeh,$Model,$price_day,$disponibilite,$transmissionType,$fuelType,$mileage,$imageVeh){
        $this->idVeh=$idVeh;
        $this->Model=$Model;
        $this->price_day=$price_day;
        $this->disponibilite=$disponibilite;
        $this->transmissionType=$transmissionType;
        $this->fuelType=$fuelType;
        $this->mileage=$mileage;
        $this->imageVeh=$imageVeh;
    }


    public function addVeh() {
        try {
            // Define the upload directory and the allowed file types
            $uploadDir = '../assets/image'; // Specify the folder where you want to store images
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; // Allowed file types
    
            // Check if the image is uploaded successfully
            if (isset($_FILES['imageVeh']) && $_FILES['imageVeh']['error'] == 0) {
                $imageName = basename($_FILES['imageVeh']['name']);
                $imageType = $_FILES['imageVeh']['type'];
                $imageTmp = $_FILES['imageVeh']['tmp_name'];
    
                // Check if the file type is allowed
                if (in_array($imageType, $allowedTypes)) {
                    // Generate a unique name for the image to avoid name conflicts
                    $newImageName = uniqid() . '_' . $imageName;
                    $imagePath = $uploadDir . $newImageName;
    
                    // Move the uploaded file to the specified directory
                    if (move_uploaded_file($imageTmp, $imagePath)) {
                        // File uploaded successfully, now save the image path to the database
                        $con = DatabaseConnection::getInstance()->getConnection();
                        $sql = "INSERT INTO Vehicle (model, price_per_day, availability, transmissionType, fuelType, mileage, imageVeh) 
                                VALUES (:Model, :price_day, :disponibilite, :transmissionType, :fuelType, :mileage, :imageVeh)";
                        $stmt = $con->prepare($sql);
    
                        $stmt->bindParam(':Model', $this->Model);
                        $stmt->bindParam(':price_day', $this->price_day);
                        $stmt->bindParam(':disponibilite', $this->disponibilite);
                        $stmt->bindParam(':transmissionType', $this->transmissionType);
                        $stmt->bindParam(':fuelType', $this->fuelType);
                        $stmt->bindParam(':mileage', $this->mileage);
                        $stmt->bindParam(':imageVeh', $newImageName); // Save only the new image name
    
                        return $stmt->execute();
                    } else {
                        throw new \Exception('Failed to move the uploaded image.');
                    }
                } else {
                    throw new \Exception('Invalid file type. Only JPEG, PNG, and GIF files are allowed.');
                }
            } else {
                throw new \Exception('No image file uploaded or error during upload.');
            }
        } catch (\PDOException $e) {
            echo "Error adding vehicle: " . $e->getMessage();
            return false;
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    
    public function EditVeh() {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "UPDATE vehicles 
                    SET model = :Model, price_per_day = :price_day, availability = :disponibilite, 
                        transmissionType = :transmissionType, fuelType = :fuelType, 
                        mileage = :mileage, imageVeh = :imageVeh 
                    WHERE idVeh = :idVeh";
            $stmt = $con->prepare($sql);
            
            $stmt->bindParam(':idVeh', $this->idVeh);
            $stmt->bindParam(':Model', $this->Model);
            $stmt->bindParam(':price_day', $this->price_day);
            $stmt->bindParam(':disponibilite', $this->disponibilite);
            $stmt->bindParam(':transmissionType', $this->transmissionType);
            $stmt->bindParam(':fuelType', $this->fuelType);
            $stmt->bindParam(':mileage', $this->mileage);
            $stmt->bindParam(':imageVeh', $this->imageVeh);
    
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error editing vehicle: " . $e->getMessage();
            return false;
        }
    }
    
    public function DeleteVeh() {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "DELETE FROM vehicles WHERE idVeh = :idVeh";
            $stmt = $con->prepare($sql);
            
            $stmt->bindParam(':idVeh', $this->idVeh);
            
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error deleting vehicle: " . $e->getMessage();
            return false;
        }
    }
    
    public static function ShowVeh() {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "SELECT * FROM vehicles";
            $stmt = $con->prepare($sql);
            
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error showing vehicles: " . $e->getMessage();
            return false;
        }
    }
    
    public static function ShowDetails($idVeh) {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "SELECT * FROM vehicles WHERE idVeh = :idVeh";
            $stmt = $con->prepare($sql);
            
            $stmt->bindParam(':idVeh', $idVeh);
            $stmt->execute();
            
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error showing vehicle details: " . $e->getMessage();
            return false;
        }
    }
    
    public static function SearchVeh($keyword) {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "SELECT * FROM vehicles WHERE model LIKE :keyword";
            $stmt = $con->prepare($sql);
            
            $searchTerm = "%" . $keyword . "%";
            $stmt->bindParam(':keyword', $searchTerm);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error searching vehicles: " . $e->getMessage();
            return false;
        }
    }
    
    public static function FilterVeh($filter) {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            
            $sql = "SELECT * FROM vehicles WHERE fuelType = :fuelType AND price_per_day BETWEEN :minPrice AND :maxPrice";
            $stmt = $con->prepare($sql);
            
            $stmt->bindParam(':fuelType', $filter['fuelType']);
            $stmt->bindParam(':minPrice', $filter['minPrice']);
            $stmt->bindParam(':maxPrice', $filter['maxPrice']);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error filtering vehicles: " . $e->getMessage();
            return false;
        }
    }
    
   



}