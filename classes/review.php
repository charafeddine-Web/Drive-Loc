<?php
namespace Classes;

use Classes\DatabaseConnection;
class Review{
    private $idVehicle;
    private $idClient;
    private $comment;
    private $rating;
    private $datecreation;


    public function __construct($idVehicle,$idClient,$comment,$rating,$datecreation){
        $this->idVehicle=$idVehicle;
        $this->idClient=$idClient;
        $this->comment=$comment;
        $this->rating=$rating;
        $this->datecreation=$datecreation;
                
    }

 
    public function add($vehicleId, $userId, $rating, $comment) {
        $con = DatabaseConnection::getInstance()->getConnection();
        $query = "INSERT INTO reviews (vehicle_id, user_id, rating, comment) VALUES (:vehicle_id, :user_id, :rating, :comment)";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':vehicle_id', $vehicleId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    
        return $stmt->execute();
    }
    
    // Method to get reviews for a specific vehicle
    public function getReviewsByVehicle($idVehicle) {
        $con = DatabaseConnection::getInstance()->getConnection();

        $query = "SELECT * FROM reviews WHERE vehicle_id = :vehicle_id ORDER BY created_at DESC";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':vehicle_id', $idVehicle, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function EditReview() {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "UPDATE reviews 
                    SET comment = :comment, datecreation = :datecreation 
                    WHERE idVehicle = :idVehicle AND idClient = :idClient";
            $stmt = $con->prepare($sql);
    
            $stmt->bindParam(':idVehicle', $this->idVehicle);
            $stmt->bindParam(':idClient', $this->idClient);
            $stmt->bindParam(':comment', $this->comment);
            $stmt->bindParam(':datecreation', $this->datecreation);
    
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error editing review: " . $e->getMessage();
            return false;
        }
    }
    
    // public function DeleteReview() {
    //     try {
    //         $con = DatabaseConnection::getInstance()->getConnection();
    //         $sql = "DELETE FROM reviews WHERE idVehicle = :idVehicle AND idClient = :idClient";
    //         $stmt = $con->prepare($sql);
    
    //         $stmt->bindParam(':idVehicle', $this->idVehicle);
    //         $stmt->bindParam(':idClient', $this->idClient);
    
    //         return $stmt->execute();
    //     } catch (\PDOException $e) {
    //         echo "Error deleting review: " . $e->getMessage();
    //         return false;
    //     }
    // }
    public function SoftDeleteReview() {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "UPDATE reviews SET deleted_at = NOW() 
                    WHERE idVehicle = :idVehicle AND idClient = :idClient AND deleted_at IS NULL";
            $stmt = $con->prepare($sql);
    
            $stmt->bindParam(':idVehicle', $this->idVehicle);
            $stmt->bindParam(':idClient', $this->idClient);
    
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error soft deleting review: " . $e->getMessage();
            return false;
        }
    }
    
    public static function ShowReviews($idVehicle = null, $idClient = null) {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "SELECT * FROM reviews WHERE deleted_at IS NULL";
            
            if ($idVehicle) {
                $sql .= " AND idVehicle = :idVehicle";
            }
            if ($idClient) {
                $sql .= " AND idClient = :idClient";
            }
    
            $stmt = $con->prepare($sql);
    
            if ($idVehicle) {
                $stmt->bindParam(':idVehicle', $idVehicle);
            }
            if ($idClient) {
                $stmt->bindParam(':idClient', $idClient);
            }
    
            $stmt->execute();
    
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error fetching reviews: " . $e->getMessage();
            return false;
        }
    }
     



}