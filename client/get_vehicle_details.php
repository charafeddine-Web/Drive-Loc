<?php

use Classes\Vehicle;
header('Content-Type: application/json');

// Get vehicle ID from POST data
$vehicleId = json_decode(file_get_contents('php://input'))->vehicleId;

// Fetch vehicle details by ID
$vehicle = Vehicle::getVehicleById($vehicleId);

// Return vehicle details as JSON
echo json_encode($vehicle);
exit;
?>
