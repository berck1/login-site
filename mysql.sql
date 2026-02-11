CREATE DATABASE arteamorim;
ALTER TABLE users ADD remember_token VARCHAR(255) NULL;

USE arteamorim;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

