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


    public function __construct($idVeh=null,$Model=null,$price_day=null,$disponibilite=null,$transmissionType=null,$fuelType=null,$mileage=null,$imageVeh=null,$idCategory=null){
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
    
    
    
    // public static function PaginateVeh($currentPage, $itemsPerPage, $category = null) {
    //     $offset = ($currentPage - 1) * $itemsPerPage;
    //     $query = "SELECT * FROM Vehicle";
    //     if ($category) {
    //         $query .= " WHERE id_category = :category";
    //     }
    
    //     $query .= " LIMIT :offset, :itemsPerPage";
        
    //     $db = DatabaseConnection::getInstance()->getConnection();
    //     $stmt = $db->prepare($query);
    
    //     if ($category) {
    //         $stmt->bindValue(':category', $category, \PDO::PARAM_INT);
    //     }
    //     $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
    //     $stmt->bindValue(':itemsPerPage', $itemsPerPage, \PDO::PARAM_INT);
    
    //     $stmt->execute();
    //     return $stmt->fetchAll(\PDO::FETCH_CLASS, self::class);
    // }
    

    public static function getTotalVehiclesCount($category = null) {
        $query = "SELECT COUNT(*) FROM vehicle";
        if ($category) {
            $query .= " WHERE id_category = :category";
        }
        $db = DatabaseConnection::getInstance()->getConnection();
        $stmt = $db->prepare($query);
    
        if ($category) {
            $stmt->bindValue(':category', $category, \PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    

    public function addVeh() {
        try {
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
            $stmt->bindParam(':imageVeh', $this->imageVeh); 
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
            $sql = "SELECT * FROM ListeVehicules";
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
            
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            echo "Error showing vehicle details: " . $e->getMessage();
            return false;
        }
    }

    // public static function SearchVeh($keyword) {
    //     try {
    //         $con = DatabaseConnection::getInstance()->getConnection();
    //         $sql = "SELECT * FROM Vehicle WHERE model LIKE :keyword";
    //         $stmt = $con->prepare($sql);
            
    //         $searchTerm = "%" . $keyword . "%";
    //         $stmt->bindParam(':keyword', $searchTerm);
    //         $stmt->execute();
            
    //         return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    //     } catch (\PDOException $e) {
    //         echo "Error searching vehicles: " . $e->getMessage();
    //         return false;
    //     }
    // }
    

    public static function filterVehicles($search, $category) {
        $pdo =  DatabaseConnection::getInstance()->getConnection();
        $query = "SELECT * FROM vehicle WHERE 1=1";

        if ($category) {
            $query .= " AND category_id = :category";
        }
        if (!empty($search)) {
            $query .= " AND model LIKE :search";
        }

        $stmt = $pdo->prepare($query);

        if ($category) {
            $stmt->bindValue(':category', $category);
        }
        if (!empty($search)) {
            $stmt->bindValue(':search', '%' . $search . '%');
        }

        $stmt->execute();
        $vehicles = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $vehicles;
    }
    public static function getVehicleById($vehicleId) {
        $query = "SELECT * FROM vehicle WHERE id_vehicle = :vehicleId";
        $db = DatabaseConnection::getInstance()->getConnection();
        $stmt = $db->prepare($query);
        $stmt->bindValue(':vehicleId', $vehicleId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
   
    public static function getVehiclesByCategory($categoryId) {
        $query = "SELECT * FROM vehicle WHERE 1=1";
        if ($categoryId) {
            $query .= " AND category_id = :category";
        }
        
        $db = DatabaseConnection::getInstance()->getConnection();
        $stmt = $db->prepare($query);
        
        if ($categoryId) {
            $stmt->bindValue(':category', $categoryId, \PDO::PARAM_INT);
        }
        
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return $result ?: [];
    }
    


}