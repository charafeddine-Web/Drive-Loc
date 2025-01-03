<?php
require_once '../autoload.php'; 
use Classes\Reservation;

try {
    $id_reservation = $_GET['id_reservation'] ?? null; 

    if (!$id_reservation) {
        throw new Exception("Reservation ID is required.");
    }
    $acRes = new Reservation(null, null, null, null, null, null, null, null);
    $res = $acRes->AccepteRes($id_reservation);

    if ($res) {
        header('Location: index.php');
        exit;
    } else {
        echo "Error accepting the reservation.";
    }
} catch (\PDOException $e) {
    echo "Error accepting reservation: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}