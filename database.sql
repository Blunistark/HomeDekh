-- Create the database
CREATE DATABASE IF NOT EXISTS `homedhek_db`;

-- Use the database
USE `homedhek_db`;

-- Table structure for table `users`
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20),
  `address` TEXT,
  `role` ENUM('owner', 'customer') NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table structure for table `properties`
CREATE TABLE IF NOT EXISTS `properties` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `owner_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `address` TEXT NOT NULL,
  `latitude` DECIMAL(10, 8),
  `longitude` DECIMAL(11, 8),
  `description` TEXT,
  `status` ENUM('available', 'booked', 'unavailable') DEFAULT 'available',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`owner_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

-- Table structure for table `property_images`
CREATE TABLE IF NOT EXISTS `property_images` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `property_id` INT NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `is_thumbnail` BOOLEAN DEFAULT FALSE,
  FOREIGN KEY (`property_id`) REFERENCES `properties`(`id`) ON DELETE CASCADE
);

-- Table structure for table `room_types`
CREATE TABLE IF NOT EXISTS `room_types` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `property_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL, -- e.g., 'Single Room', 'Double Room', 'Apartment'
  `price_per_night` DECIMAL(10, 2) NOT NULL,
  `capacity` INT NOT NULL, -- Number of people it can accommodate
  `description` TEXT,
  FOREIGN KEY (`property_id`) REFERENCES `properties`(`id`) ON DELETE CASCADE
);

-- Table structure for table `amenities`
CREATE TABLE IF NOT EXISTS `amenities` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL UNIQUE,
  `icon_class` VARCHAR(255) -- For Font Awesome or similar icon libraries
);

-- Pre-populate amenities table
INSERT INTO `amenities` (`name`, `icon_class`) VALUES
('WiFi', 'fas fa-wifi'),
('Food', 'fas fa-utensils'),
('TV', 'fas fa-tv'),
('Attached Bathroom', 'fas fa-bath'),
('Refrigerator', 'fas fa-snowflake'),
('AC', 'fas fa-wind'),
('Gym', 'fas fa-dumbbell'),
('Laundry', 'fas fa-tshirt'),
('Study Room', 'fas fa-book'),
('Parking', 'fas fa-parking'),
('24/7 Security', 'fas fa-shield-alt'),
('Power Backup', 'fas fa-bolt');

-- Table structure for table `property_amenities`
-- (Junction table for many-to-many relationship between properties and amenities)
CREATE TABLE IF NOT EXISTS `property_amenities` (
  `property_id` INT NOT NULL,
  `amenity_id` INT NOT NULL,
  PRIMARY KEY (`property_id`, `amenity_id`),
  FOREIGN KEY (`property_id`) REFERENCES `properties`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`amenity_id`) REFERENCES `amenities`(`id`) ON DELETE CASCADE
);

-- Table structure for table `additional_services`
CREATE TABLE IF NOT EXISTS `additional_services` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `property_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `description` TEXT,
  FOREIGN KEY (`property_id`) REFERENCES `properties`(`id`) ON DELETE CASCADE
);

-- Table structure for table `nearby_places`
CREATE TABLE IF NOT EXISTS `nearby_places` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `property_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `type` VARCHAR(100), -- e.g., 'Restaurant', 'Hospital', 'School', 'Bus Stop'
  `distance_km` DECIMAL(5, 2),
  FOREIGN KEY (`property_id`) REFERENCES `properties`(`id`) ON DELETE CASCADE
);
