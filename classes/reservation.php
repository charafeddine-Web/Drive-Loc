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

    public function AccepteRes($idRes) {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "UPDATE reservations SET status = 'Accepted' WHERE idRes = :idRes";
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
            $sql = "UPDATE reservations SET status = 'Rejected' WHERE idRes = :idRes";
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
            $sql = "SELECT * FROM reservations";
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
            $sql = "SELECT * FROM reservations WHERE idUser = :idUser";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':idUser', $idUser);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            echo "Error retrieving client's reservations: " . $e->getMessage();
            return false;
        }
    }
    



}