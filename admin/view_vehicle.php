<?php
require_once '../autoload.php';
use Classes\Vehicle;

if (isset($_GET['id'])) {
    $id_vehicle = $_GET['id'];

    try {
        $vehicle = new Vehicle(null, null, null, null, null, null, null, null, null);
        $details = $vehicle->ShowDetails($id_vehicle); 

        if ($details) {
            echo '<strong>Model:</strong> ' . htmlspecialchars($details[0]->model) . '<br>';
            echo '<strong>Category:</strong> ' . htmlspecialchars($details[0]->category_id) . '<br>';
            echo '<strong>Price per Day:</strong> ' . htmlspecialchars($details[0]->price_per_day) . '<br>';
            echo '<strong>Mileage:</strong> ' . htmlspecialchars($details[0]->mileage) . ' km<br>';
            echo '<strong>Fuel Type:</strong> ' . htmlspecialchars($details[0]->fuelType) . '<br>';
            echo '<strong>Transmission Type:</strong> ' . htmlspecialchars($details[0]->transmissionType) . '<br>';
            echo '<div class="flex flex-col items-center justify-center gap-4">';
            echo '<strong>Availability:</strong> ' . htmlspecialchars($details[0]->availability) . '<br>';
            echo '<img src="../assets/image/' . htmlspecialchars($details[0]->imageVeh) . '" alt="Vehicle Image" width="200"  class="rounded-xl"/>';
            echo'</div>';
        } else {
            echo 'Vehicle not found.';
        }
    } catch (PDOException $e) {
        echo 'Error fetching vehicle details: ' . $e->getMessage();
    }
} else {
    echo 'No vehicle selected.';
}
?>
