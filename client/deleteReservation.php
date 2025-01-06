<?php
require_once '../autoload.php';

use Classes\Reservation;
if (isset($_GET['id'])) {
    $reservationId = intval($_GET['id']);
    $reservation = new Reservation(null,null,null,null,null,null,null,null);
    if ($reservation->deleteReservation($reservationId)) {
        header('Location: index.php?status=deleted');
        exit();
    } else {
        header('Location: index.php?status=error');
        exit();
    }
} else {
    header('Location: index.php?status=invalid');
    exit();
}
