<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    $vehicleId = $_GET['id'];

    echo json_encode(['vehicle' => $vehicle, 'reviews' => $reviews]);
}
