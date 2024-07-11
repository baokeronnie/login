CREATE DATABASE IF NOT EXISTS user_auth;
USE user_auth;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    approved TINYINT(1) DEFAULT 0,
    is_admin TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO users (username, email, password_hash) 
VALUES ('leaf4', 'leaf@gmail.com', 'R@b76198815');

SELECT id, username, password_hash 
FROM users 
WHERE username = 'exampleUser' OR email = 'user@example.com';

