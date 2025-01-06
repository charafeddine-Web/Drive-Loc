<?php
require_once '../autoload.php';

use Classes\Reservation;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservationId = filter_input(INPUT_POST, 'reservation_id', FILTER_VALIDATE_INT);
    $startDate = filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_STRING);
    $endDate = filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_STRING);
    $pickupLocation = filter_input(INPUT_POST, 'pickup_location', FILTER_SANITIZE_STRING);
    $dropoffLocation = filter_input(INPUT_POST, 'dropoff_location', FILTER_SANITIZE_STRING);

    $reservation =  Reservation::editReservation($reservationId, $startDate, $endDate, $pickupLocation, $dropoffLocation);
    if ($reservation) {
        header('Location: index.php?success=1');
        exit();
    } else {
        header('Location: index.php?error=1');
        exit();
    }
}