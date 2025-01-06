create database drive_loc;
use drive_loc;

CREATE TABLE Role (
    id_role INT AUTO_INCREMENT PRIMARY KEY,       
    name VARCHAR(50) NOT NULL UNIQUE              
);

CREATE TABLE Users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,       
    fullname VARCHAR(100) NOT NULL,              
    phone VARCHAR(15),                            
    email VARCHAR(100) UNIQUE NOT NULL,           
    password VARCHAR(255) NOT NULL,               
    id_role INT NOT NULL,                         
    FOREIGN KEY (id_role) REFERENCES Role(id_role) 
);



CREATE TABLE Category (
    id_category INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT
);


CREATE TABLE Vehicle (
    id_vehicle INT AUTO_INCREMENT PRIMARY KEY,
    model VARCHAR(100) NOT NULL,
    price_per_day FLOAT NOT NULL,
    availability enum('Available','Unavailable'),
    transmissionType enum('Automatic','Manual'),
    fuelType varchar(50),
    mileage float,
    category_id INT,
    imageVeh varchar(200),
    FOREIGN KEY (category_id) REFERENCES Category(id_category)
);


CREATE TABLE Reservation (
    id_res INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_id INT NOT NULL,
    user_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    pickup_location VARCHAR(255) NOT NULL,
    dropoff_location VARCHAR(255) NOT NULL,
    FOREIGN KEY (vehicle_id) REFERENCES Vehicle(id_vehicle),
    FOREIGN KEY (user_id) REFERENCES Users(id_user)
);

CREATE TABLE reviews (
    id_review INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    vehicle_id INT NOT NULL,
    comment TEXT NOT NULL,
    rating DECIMAL(2,1) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id_user),
    FOREIGN KEY (vehicle_id) REFERENCES vehicle(id_vehicle)
);

-- les Vue SQL

CREATE OR REPLACE VIEW ListeVehicules AS
SELECT 
    v.id_vehicle AS vehicle_id,
    v.model AS vehicle_model,
    v.price_per_day AS vehicle_price_per_day,
    v.transmissionType AS vehicle_transmission,
    v.fuelType AS vehicle_fuel_type,
    v.mileage AS vehicle_mileage,
    v.availability AS vehicle_availability,
    c.name AS category_name,
    v.imageVeh AS vehicle_image
FROM 
    Vehicle v
INNER JOIN 
    Category c ON v.category_id = c.id_category;

-- les procedure stocker sql pour ajouter reservation
DELIMITER $$

CREATE PROCEDURE AjouterReservation(
    IN p_vehicle_id INT,
    IN p_user_id INT,
    IN p_pickup_location VARCHAR(255),
    IN p_dropoff_location VARCHAR(255),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    INSERT INTO reservation(vehicle_id, user_id, pickup_location, dropoff_location, start_date, end_date)
    VALUES (p_vehicle_id, p_user_id, p_pickup_location, p_dropoff_location, p_start_date, p_end_date);
END $$

DELIMITER ;

