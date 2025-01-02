<?php
namespace Classes;
use Classes\DatabaseConnection;

class Vehicle{
    private $idVeh;
    private $idCategory;
    private $Model;
    private $price_day;
    private $disponibilite;
    private $transmissionType;
    private $fuelType;
    private $mileage;
    private $imageVeh;


    public function __construct($idVeh,$Model,$price_day,$disponibilite,$transmissionType,$fuelType,$mileage,$imageVeh,$idCategory){
        $this->idVeh=$idVeh;
        $this->Model=$Model;
        $this->price_day=$price_day;
        $this->disponibilite=$disponibilite;
        $this->transmissionType=$transmissionType;
        $this->fuelType=$fuelType;
        $this->mileage=$mileage;
        $this->imageVeh=$imageVeh;
        $this->idCategory=$idCategory;
    }
    public function addVeh() {
        try {

            $uploadDir = realpath(__DIR__ . '/../assets/image/') . '/';
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    throw new \Exception('Failed to create upload directory.'); 
                }
            }
    
            if (isset($_FILES['imageVeh']) && $_FILES['imageVeh']['error'] === UPLOAD_ERR_OK) {
                $imageTmp = $_FILES['imageVeh']['tmp_name'];
    
                $originalImageName = basename($_FILES['imageVeh']['name']);
                $sanitizedImageName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', $originalImageName);
                $imagePath = $uploadDir . $sanitizedImageName;
    
                if (move_uploaded_file($imageTmp, $imagePath)) {
                    echo 'good';
                } else { 
                    throw new \Exception('Failed to move the uploaded image. Check directory permissions and path.');
                }
            } else {
                throw new \Exception('File upload error or no file uploaded.');
            }
    
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "INSERT INTO Vehicle (model, price_per_day, availability, transmissionType, fuelType, mileage, imageVeh, category_id) 
                    VALUES (:model, :price_day, :disponibilite, :transmissionType, :fuelType, :mileage, :imageVeh, :idCategory)";
            $stmt = $con->prepare($sql);
    
            $stmt->bindParam(':model', $this->Model);
            $stmt->bindParam(':price_day', $this->price_day);
            $stmt->bindParam(':disponibilite', $this->disponibilite);
            $stmt->bindParam(':transmissionType', $this->transmissionType);
            $stmt->bindParam(':fuelType', $this->fuelType);
            $stmt->bindParam(':mileage', $this->mileage);
            $stmt->bindParam(':imageVeh', $sanitizedImageName); 
            $stmt->bindParam(':idCategory', $this->idCategory); 
    
            if ($stmt->execute()) {
                return true; 
            } else {
                throw new \Exception('Database error: Failed to add vehicle.'); 
            }
        } catch (\PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return false;
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    
    public function EditVeh() {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "UPDATE Vehicle 
                    SET model = :Model, price_per_day = :price_day, availability = :disponibilite, 
                        transmissionType = :transmissionType, fuelType = :fuelType, 
                        mileage = :mileage, imageVeh = :imageVeh ,category_id = :idCategory
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
            $stmt->bindParam(':idCategory', $this->idCategory);
    
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error editing vehicle: " . $e->getMessage();
            return false;
        }
    }
    
    public function DeleteVeh($id_vehicle) {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "DELETE FROM Vehicle WHERE id_vehicle = :idVeh";
            $stmt = $con->prepare($sql);
            
            $stmt->bindParam(':idVeh', $id_vehicle);
            
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error deleting vehicle: " . $e->getMessage();
            return false;
        }
    }
    
    public static function ShowVeh() {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "SELECT * FROM Vehicle";
            $stmt = $con->prepare($sql);
            
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error showing vehicles: " . $e->getMessage();
            return false;
        }
    }

    public static function showStatistic(){
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $query = "SELECT 
                         (SELECT COUNT(*) FROM Vehicle where availability='Available') AS total_veh_Available,
                         (SELECT COUNT(*) FROM Vehicle where availability='Unavailable') AS total_vec_Unavailable";
            $stmt = $pdo->query($query);
    
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
            if ($result) {
                return $result;
            } else {
                return [
                    'total_veh_Available' => 0,
                    'total_vec_Unavailable' => 0,
                ];
            }
        } catch (\PDOException $e) {
            echo "Error retrieving statistics Vehicles: " . $e->getMessage();
            return false; 
        }
    }
    public static function ShowDetails($idVeh) {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "SELECT v.*, c.name AS category_name FROM Vehicle v
                    INNER JOIN Category c ON c.id_category = v.category_id
                    WHERE v.id_vehicle = :idVeh";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':idVeh', $idVeh, \PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_OBJ); // This returns an array of objects
        } catch (\PDOException $e) {
            echo "Error showing vehicle details: " . $e->getMessage();
            return false;
        }
    }
    
    

    public static function getVehiclesByCategory($category_id) {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Vehicle WHERE category_id = :category_id");
        $stmt->bindParam(':category_id', $category_id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    
    public static function SearchVeh($keyword) {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "SELECT * FROM Vehicle WHERE model LIKE :keyword";
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
            
            $sql = "SELECT * FROM Vehicle WHERE fuelType = :fuelType AND price_per_day BETWEEN :minPrice AND :maxPrice";
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