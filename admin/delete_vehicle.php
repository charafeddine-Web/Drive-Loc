<?php
require_once '../autoload.php';

use Classes\Vehicle;
if (isset($_GET['id_vehicle'])) {
    $id_vehicle = $_GET['id_vehicle'];
    try {
        $vehicle = new Vehicle(null,null,null,null,null,null,null,null,null);
        $st=$vehicle->DeleteVeh($id_vehicle);
        if($st){
            echo '<script>alert("Vehicle deleted successfully.")</script>';
            header('Location: listVehicle.php');
            exit;
        }
       
    } catch (PDOException $e) {
        echo 'Error deleting vehicle: ' . $e->getMessage();
    }
}
?>
