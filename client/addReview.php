<?php

require_once '../autoload.php';

use Classes\Review;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicleId = $_POST['vehicle_id'] ?? null;
    $userId = $_POST['user_id'] ?? null; 
    $rating = $_POST['rating'] ?? null;
    $comment = $_POST['comment'] ?? null;

    if ($vehicleId && $userId && $rating && $comment) {
        $review = new Review(null,null,null,null,null);

        if ($review->add($vehicleId, $userId, $rating, $comment)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
}