-- init_db.sql
CREATE DATABASE IF NOT EXISTS csstudyhub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE csstudyhub;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(150) UNIQUE,
  password VARCHAR(255),
  role ENUM('student','admin') DEFAULT 'student',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pdfs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  filename VARCHAR(255),
  uploaded_by INT,
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE tests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  duration_minutes INT DEFAULT 10,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  test_id INT,
  question TEXT,
  opt_a VARCHAR(255),
  opt_b VARCHAR(255),
  opt_c VARCHAR(255),
  opt_d VARCHAR(255),
  correct CHAR(1),
  FOREIGN KEY (test_id) REFERENCES tests(id) ON DELETE CASCADE
);

CREATE TABLE test_results (
  id INT AUTO_INCREMENT PRIMARY KEY,
  test_id INT,
  user_id INT,
  score INT,
  total INT,
  time_taken_seconds INT,
  taken_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (test_id) REFERENCES tests(id) ON DELETE SET NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
