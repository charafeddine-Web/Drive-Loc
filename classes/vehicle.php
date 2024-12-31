<?php
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
        $this->fuelType=$fuelType;
        $this->mileage=$mileage;
        $this->imageVeh=$imageVeh;
    }


    public function addVeh() {
        try {
            $con = DatabaseConnection::getInstance()->getConnection();
            $sql = "INSERT INTO vehicles (Model, price_day, disponibilite, transmissionType, fuelType, mileage, imageVeh) 
                    VALUES (:Model, :price_day, :disponibilite, :transmissionType, :fuelType, :mileage, :imageVeh)";
            $stmt = $con->prepare($sql);
    
            $stmt->bindParam(':Model', $this->Model);
            $stmt->bindParam(':price_day', $this->price_day);
            $stmt->bindParam(':disponibilite', $this->disponibilite);
            $stmt->bindParam(':transmissionType', $this->transmissionType);
            $stmt->bindParam(':fuelType', $this->fuelType);
            $stmt->bindParam(':mileage', $this->mileage);
            $stmt->bindParam(':imageVeh', $this->imageVeh);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error adding vehicle: " . $e->getMessage();
            return false;
        }
    }
    
    public function EditVeh(){

    }
    public function DeleteVeh(){

    }
    public function ShowVeh(){

    }
    public function ShowDetails(){

    }
    public function SearchVeh(){

    }
    public function FilterVeh(){

    }
   



}