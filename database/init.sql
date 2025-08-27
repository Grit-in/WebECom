CREATE DATABASE users_db;
use users_db;

CREATE TABLE Users (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL,
    remember_token VARCHAR(255) DEFAULT NULL
);

CREATE TABLE Games (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  slug VARCHAR(255) UNIQUE NULL,
  description TEXT NOT NULL,
  price DECIMAL(8,2) NOT NULL,
  image VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  number_of_pieces INT DEFAULT 20
);

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `remember_token`) VALUES
(1, 'test', 'test@test.com', '$2y$10$io5zI5mSCNSSlpVbnqBdNeLXeRVV6xUQ3udEokjmzxWqzBoU90P6C', 'admin', NULL),
(2, 'test2', 'test2@gmail.com', '$2y$10$DXS5A.TXsH37U1KhCMqZ3ufmqBHN/YQf9PkeIHAb3ZmzgjFIDoE86', 'user', NULL),
(3, 'user', 'user@user.com', '$2y$10$7IXVbvXCrGNcYKO8sGvHq.HrNT/yVyw8DJTWMdQKb2ccL86NIneN.', 'user', NULL),
(4, 'tester3', 'daniloistijanovic3@gmail.com', '$2y$10$rUmoOH.hXw4N0IAYET5riOudLeoqxxk6PIC0tP58hPIxEl2CRTwxi', 'admin', NULL);

INSERT INTO `games` (`id`, `title`, `slug`, `description`, `price`, `image`) VALUES
(1, 'Elden Ring Nightreign', 'elden-ring-nightreign', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 19.99, 'eldenring.jpg'),
(2, 'Lies of P', 'lies-of-p', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 29.99, 'lop.jpg'),
(3, 'Rematch', 'rematch', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 39.99, 'rematch.jpg'),
(4, 'Hollow Knight', 'hollow-knight', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 39.99, 'hknight.jpg'),
(5, 'Street Fighter 6', 'street-fighter-6', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 39.99, 'sf6.avif'),
(6, 'Tekken 8', 'tekken-8', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 39.99, 'tekken8.jpg');
