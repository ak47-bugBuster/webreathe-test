--  Author: Akshaya Bhandare 
-- Page: DATABASE  SCHEMA
-- Date Created: 19th April 2025

--------------------------------------------------------------------------------------

-- Module Table Query
CREATE TABLE modules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    type VARCHAR(50),
    status VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
---------------------------------------------------------------------------------------

-- Measurement Table Query
CREATE TABLE measurements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    module_id INT,
    value FLOAT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (module_id) REFERENCES modules(id)
);
-------------------------------------------------------------------------------------------