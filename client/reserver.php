<?php
use Classes\Reservation;
require_once '../autoload.php'; 
session_start();
if (isset($_POST['submit'])) {
    $vehicle_id = $_POST['vehicle_id'] ?? null;
    $idUser = $_POST['idUser'] ?? null;
    $pickup_location = $_POST['pickupLocation'];
    $dropoff_location = $_POST['dropoffLocation'];
    $start_date = $_POST['startDate'];
    $end_date = $_POST['endDate'];


    $reservation = new Reservation(null,null,null,null,null,null,null,null);
    $response = $reservation->addReservation( $vehicle_id,$idUser,$pickup_location, $dropoff_location,$start_date, $end_date );
    echo json_encode($response);
}