<?php
namespace Classes;

class Review{
    private $idVehicle;
    private $idClient;
    private $comment;
    private $datecreation;


    public function __construct($idVehicle,$idClient,$comment,$datecreation){
        $this->idVehicle=$idVehicle;
        $this->idClient=$idClient;
        $this->comment=$comment;
        $this->datecreation=$datecreation;
                
    }

    public function addReview(){
        
    }
    public function EditReview(){

    }
    public function DeleteReview(){

    }



}