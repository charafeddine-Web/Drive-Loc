<?php
namespace Classes;

use Classes\DatabaseConnection;

class Reservation{

    private $idRes;
    private $idVeh;
    private $idUser;
    private $DateDebut;
    private $DateFin;
    private $status;
    private $pickup_location;
    private $dropoff_location;

    public function __construct($idRes,$idVeh,$idUser,$DateDebut,$DateFin,$status,$pickup_location,$dropoff_location){
        $this->idRes=$idRes;
        $this->idVeh=$idVeh;
        $this->idUser=$idUser;
        $this->DateDebut=$DateDebut;
        $this->DateFin=$DateFin;
        $this->status=$status;
        $this->pickup_location=$pickup_location;
        $this->dropoff_location=$dropoff_location;
    }
    public function addReservation($vehicle_id, $idUser, $pickup_location, $dropoff_location, $start_date, $end_date) {
        if (empty($idUser)) {
            return ['error' => 'User ID is missing or invalid.'];
        }
    
        $pdo = DatabaseConnection::getInstance()->getConnection();
        $query = "CALL AjouterReservation(:vehicle_id, :user_id, :pickup_location, :dropoff_location, :start_date, :end_date)";
        $stmt = $pdo->prepare($query);
    
        $stmt->bindParam(':vehicle_id', $vehicle_id);
        $stmt->bindParam(':user_id', $idUser);
        $stmt->bindParam(':pickup_location', $pickup_location);
        $stmt->bindParam(':dropoff_location', $dropoff_location);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
    
        try {
            if ($stmt->execute()) {
                header('location: ../client/index.php');
                return ['success' => 'Reservation successful.'];
            } else {
                return ['error' => 'Failed to add reservation.'];
            }
        } catch (\PDOException $e) {
            error_log("Error adding reservation: " . $e->getMessage());
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function deleteReservation($id) {
        $pdo = DatabaseConnection::getInstance()->getConnection();

        try {
            $query = "DELETE FROM reservation WHERE id_res = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
    
    public function AccepteRes($idRes) {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "UPDATE Reservation SET status = 'Accepted' WHERE id_res = :idRes";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':idRes', $idRes);
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error accepting reservation: " . $e->getMessage();
            return false;
        }
    }
    
    public function RefuseRes($idRes) {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "UPDATE Reservation SET status = 'Rejected' WHERE id_res = :idRes";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':idRes', $idRes);
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error refusing reservation: " . $e->getMessage();
            return false;
        }
    }
    
    public function ShowAllRes() {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "SELECT 
                    r.*, 
                    c.fullname, 
                            v.model AS vehicle_model
                        FROM 
                            Reservation r
                        JOIN 
                            Users c ON r.user_id = c.id_user
                        JOIN 
                    Vehicle v ON r.vehicle_id = v.id_vehicle";            
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            echo "Error retrieving reservations: " . $e->getMessage();
            return false;
        }
    }
    
    public function ShowAllRes_client($idUser) {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "SELECT r.*,v.model,v.price_per_day,v.imageVeh FROM Reservation r 
            inner join Vehicle v  on r.vehicle_id=v.id_vehicle
            WHERE user_id = :idUser";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':idUser', $idUser);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            echo "Error retrieving client's reservations: " . $e->getMessage();
            return false;
        }
    }
    

     public static function editReservation($id_reservation, $start_date, $end_date, $pickup_location, $dropoff_location) {
        $pdo= DatabaseConnection::getInstance()->getConnection();
        $sql = "UPDATE reservation SET start_date = ?, end_date = ?, pickup_location = ?, dropoff_location = ? WHERE id_res = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$start_date, $end_date, $pickup_location, $dropoff_location, $id_reservation]);
    }
    
}