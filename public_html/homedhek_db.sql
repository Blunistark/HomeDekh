-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 25, 2025 at 09:52 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `homedhek_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_services`
--

DROP TABLE IF EXISTS `additional_services`;
CREATE TABLE IF NOT EXISTS `additional_services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `property_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

DROP TABLE IF EXISTS `amenities`;
CREATE TABLE IF NOT EXISTS `amenities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `icon_class` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `name`, `icon_class`) VALUES
(1, 'WiFi', 'fas fa-wifi'),
(2, 'Food', 'fas fa-utensils'),
(3, 'TV', 'fas fa-tv'),
(4, 'Attached Bathroom', 'fas fa-bath'),
(5, 'Refrigerator', 'fas fa-snowflake'),
(6, 'AC', 'fas fa-wind'),
(7, 'Gym', 'fas fa-dumbbell'),
(8, 'Laundry', 'fas fa-tshirt'),
(9, 'Study Room', 'fas fa-book'),
(10, 'Parking', 'fas fa-parking'),
(11, '24/7 Security', 'fas fa-shield-alt'),
(12, 'Power Backup', 'fas fa-bolt');

-- --------------------------------------------------------

--
-- Table structure for table `nearby_places`
--

DROP TABLE IF EXISTS `nearby_places`;
CREATE TABLE IF NOT EXISTS `nearby_places` (
  `id` int NOT NULL AUTO_INCREMENT,
  `property_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `distance_km` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

DROP TABLE IF EXISTS `properties`;
CREATE TABLE IF NOT EXISTS `properties` (
  `id` int NOT NULL AUTO_INCREMENT,
  `owner_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `description` text,
  `short_description` text,
  `meta_description` text,
  `status` enum('available','booked','unavailable','pending','rejected','changes_requested') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `property_type` varchar(50) DEFAULT NULL,
  `property_category` varchar(50) DEFAULT NULL,
  `base_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `properties`

-- --------------------------------------------------------

--
-- Table structure for table `property_amenities`
--

DROP TABLE IF EXISTS `property_amenities`;
CREATE TABLE IF NOT EXISTS `property_amenities` (
  `property_id` int NOT NULL,
  `amenity_id` int NOT NULL,
  PRIMARY KEY (`property_id`,`amenity_id`),
  KEY `amenity_id` (`amenity_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

DROP TABLE IF EXISTS `property_images`;
CREATE TABLE IF NOT EXISTS `property_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `property_id` int NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_thumbnail` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

DROP TABLE IF EXISTS `room_types`;
CREATE TABLE IF NOT EXISTS `room_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `property_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price_per_night` decimal(10,2) NOT NULL,
  `capacity` int NOT NULL,
  `description` text,
  `price_per_month` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `role` enum('owner','tenant','agent','admin') NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `city`, `state`, `role`, `status`, `created_at`) VALUES
(1, 'Test', 'testteacher@example.com', '$2y$10$eR9saYaAC2Oafi.nzHnyCOzuSznkdKg1oDd/PAyYWrBxKKR.zIsJ.', NULL, NULL, 'Bangalore', 'Karnataka', 'tenant', 'active', '2025-05-23 16:37:55'),
(2, 'digitar', 'digitarapp@gmail.com', '$2y$10$QqIeqphXxvAAsykZbP.6NOf4VBE9e5zydwaIZg7n0VAB1FkcKaYim', NULL, NULL, 'Mumbai', 'Maharashtra', 'owner', 'active', '2025-05-25 05:26:23'),
(3, 'test', 'admin@example.com', '$2y$10$04sVnBo.XdNQRWUzA4WtBOVLr94elyEcWaKAP5MqUXbzj8WmFLypy', NULL, NULL, 'Delhi', 'Delhi', 'admin', 'inactive', '2025-05-25 07:01:12');

-- --------------------------------------------------------

--
-- Table structure for table `property_contacts`
--

DROP TABLE IF EXISTS `property_contacts`;
CREATE TABLE IF NOT EXISTS `property_contacts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `property_id` int NOT NULL,
  `contact_name` varchar(255),
  `contact_phone` varchar(30),
  `contact_email` varchar(255),
  `contact_image_path` varchar(255),
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_special_offers`
--

DROP TABLE IF EXISTS `property_special_offers`;
CREATE TABLE IF NOT EXISTS `property_special_offers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `property_id` int NOT NULL,
  `has_special_offer` tinyint(1) DEFAULT 0,
  `special_offer_text` text,
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_reviews`
--

DROP TABLE IF EXISTS `property_reviews`;
CREATE TABLE IF NOT EXISTS `property_reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `property_id` int NOT NULL,
  `rating` decimal(3,2),
  `review_count` int DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_feedback`
--

DROP TABLE IF EXISTS `property_feedback`;
CREATE TABLE IF NOT EXISTS `property_feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `property_id` int NOT NULL,
  `action` enum('reject','request-changes'),
  `feedback` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

-- Table structure for table `inquiries`
--

DROP TABLE IF EXISTS `inquiries`;
CREATE TABLE IF NOT EXISTS `inquiries` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `property_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `channel` ENUM('Call','WhatsApp','Email') DEFAULT 'Call',
  `status` ENUM('pending','responded','not_interested') DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`),
  CONSTRAINT `fk_inquiries_property` FOREIGN KEY (`property_id`) REFERENCES `properties`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`property_id`, `name`, `created_at`, `channel`, `status`) VALUES
(1, 'Raj Sharma', NOW(), 'Call', 'responded'),
(2, 'Priya Patel', NOW(), 'WhatsApp', 'pending'),
(3, 'Amit Singh', NOW(), 'Email', 'responded'),
(4, 'Sanjay Kumar', NOW(), 'WhatsApp', 'not_interested');

-- --------------------------------------------------------

--
-- Table structure for table `saved_properties`
--

DROP TABLE IF EXISTS `saved_properties`;
CREATE TABLE IF NOT EXISTS `saved_properties` (
  `user_id` int NOT NULL,
  `property_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`, `property_id`),
  KEY `property_id` (`property_id`),
  CONSTRAINT `fk_saved_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_saved_property` FOREIGN KEY (`property_id`) REFERENCES `properties`(`id`) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
