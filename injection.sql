CREATE TABLE account (
    id INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(255) NOT NULL,
    Registered DATETIME DEFAULT CURRENT_TIMESTAMP,
    Username VARCHAR(100) NOT NULL UNIQUE,
    Birthday DATE,
    Address VARCHAR(255),
    ContactNumber VARCHAR(20),
    Email VARCHAR(100),
    Role VARCHAR(50),
    Password VARCHAR(255)
);

CREATE TABLE access_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rfid VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    access_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    role text(50) NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rfid VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    birthday VARCHAR(255) NOT NULL,
    address	 VARCHAR(255) NOT NULL,
    pin	INT(255) NOT NULL,
    role text(50) NOT NULL
);


