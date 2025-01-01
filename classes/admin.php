<?php

namespace Classes;


use Classes\User;
use Classes\DatabaseConnection;

class Admin extends User {
    public function ViewStatistic() {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $query = "SELECT 
                         (SELECT COUNT(*) FROM users) AS total_users,
                         (SELECT COUNT(*) FROM Vehicle) AS total_vehicles,
                         (SELECT COUNT(*) FROM Reservation) AS total_reservations";
            $stmt = $pdo->query($query);
    
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
            if ($result) {
                return $result;
            } else {
                return [
                    'total_users' => 0,
                    'total_vehicles' => 0,
                    'total_reservations' => 0,
                ];
            }
        } catch (\PDOException $e) {
            echo "Error retrieving statistics: " . $e->getMessage();
            return false; 
        }
    }
    
    
}
