<?php

use Classes\Vehicle;

header('Content-Type: application/json');
$categoryId = $_POST['category'] ?? null;
$vehicles = Vehicle::getVehiclesByCategory($categoryId);
echo json_encode($vehicles); 


