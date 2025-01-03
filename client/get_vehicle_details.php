<?php
use Classes\Vehicle;
header('Content-Type: application/json');

$vehicleId = json_decode(file_get_contents('php://input'))->vehicleId;

if (!$vehicleId) {
    echo json_encode(['error' => 'No vehicle ID received']);
    exit;
}
$vehicle = Vehicle::getVehicleById($vehicleId);
if (!$vehicle) {
    echo json_encode(['error' => 'Vehicle not found']);
    exit;
}
echo json_encode($vehicle);
exit;
