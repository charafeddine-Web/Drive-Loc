create database drive_loc;
use drive_loc;


CREATE TABLE User (
    id_user INT AUTO_INCREMENT PRIMARY KEY,       -- Unique identifier for the user
    fullname VARCHAR(100) NOT NULL,               -- User's full name
    phone VARCHAR(15),                            -- User's phone number
    email VARCHAR(100) UNIQUE NOT NULL,           -- User's email
    password VARCHAR(255) NOT NULL,               -- Encrypted password
    role ENUM('client', 'admin') NOT NULL         -- Role: either 'client' or 'admin'
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
    availability BOOLEAN DEFAULT TRUE,
    transmissionType varchar(50),
    fuelType varchar(50),
    mileage float,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES Category(id_category)
);


CREATE TABLE Reservation (
    id_res INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_id INT NOT NULL,
    user_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    pickup_location VARCHAR(255) NOT NULL,
    dropoff_location VARCHAR(255) NOT NULL,
    FOREIGN KEY (vehicle_id) REFERENCES Vehicle(id_vehicle),
    FOREIGN KEY (user_id) REFERENCES User(id_user)
);

CREATE TABLE Review (
    id_review INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_id INT NOT NULL,
    user_id INT NOT NULL,
    comment TEXT,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vehicle_id) REFERENCES Vehicle(id_vehicle),
    FOREIGN KEY (user_id) REFERENCES User(id_user)
);

-- Ex INSERTION DES DONNER

INSERT INTO User (fullname, phone, email, password, role) VALUES
('Ahmed El Khattabi', '0661234567', 'ahmed.elkhattabi@example.com', 'password123', 'client'),
('Fatima Zahra Bouziane', '0677654321', 'fatima.bouziane@example.com', 'securepass', 'client'),
('Youssef Benjelloun', '0652349876', 'youssef.benjelloun@example.com', 'adminpass', 'admin'),
('Sara El Idrissi', '0684321567', 'sara.elidrissi@example.com', 'clientpass', 'client'),
('Mohamed Alaoui', '0621238765', 'mohamed.alaoui@example.com', 'admin123', 'admin');

INSERT INTO Category (name, description) VALUES
('Economy', 'Affordable and fuel-efficient vehicles for budget-conscious clients.'),
('Luxury', 'Premium vehicles for clients seeking comfort and style.'),
('SUV', 'Spacious and robust vehicles, ideal for off-road and family trips.'),
('Electric', 'Eco-friendly vehicles powered by electricity.'),
('Compact', 'Small and efficient vehicles for city driving.');

INSERT INTO Vehicle (model, price_per_day, availability, transmissionType, fuelType, mileage, category_id) VALUES
('Dacia Sandero', 200.00, TRUE, 'Manual', 'Petrol', 15.0, 1),
('Hyundai Tucson', 500.00, TRUE, 'Automatic', 'Diesel', 12.0, 3),
('Tesla Model 3', 800.00, TRUE, 'Automatic', 'Electric', 0.0, 4),
('Mercedes-Benz E-Class', 1200.00, TRUE, 'Automatic', 'Petrol', 10.0, 2),
('Renault Clio', 250.00, TRUE, 'Manual', 'Diesel', 18.0, 5);


INSERT INTO Reservation (vehicle_id, user_id, start_date, end_date, pickup_location, dropoff_location) VALUES
(1, 1, '2024-01-10', '2024-01-15', 'Casablanca', 'Rabat'),
(3, 2, '2024-02-01', '2024-02-05', 'Marrakech', 'Agadir'),
(2, 4, '2024-03-20', '2024-03-25', 'Tangier', 'Tetouan'),
(5, 1, '2024-04-15', '2024-04-18', 'Oujda', 'Nador'),
(4, 3, '2024-05-05', '2024-05-10', 'Casablanca', 'Fes');


INSERT INTO Review (vehicle_id, user_id, comment, date) VALUES
(1, 1, 'Excellent car, very fuel-efficient!', '2024-01-16 10:00:00'),
(3, 2, 'The Tesla Model 3 was amazing. Smooth ride!', '2024-02-06 12:30:00'),
(2, 4, 'Hyundai Tucson was perfect for our family trip.', '2024-03-26 09:00:00'),
(5, 1, 'The Renault Clio was a bit small but great for the city.', '2024-04-19 08:45:00'),
(4, 3, 'Mercedes-Benz was luxurious and comfortable.', '2024-05-11 14:20:00');
