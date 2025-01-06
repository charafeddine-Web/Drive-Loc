<?php
require_once '../autoload.php';

use Classes\Vehicle;

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$search = $data['search'] ?? '';
$category = $data['category'] ?? null;
try {
    $vehicles = Vehicle::filterVehicles($search, $category);
    echo json_encode($vehicles);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
