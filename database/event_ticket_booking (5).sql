-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2025 at 09:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_ticket_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_date` datetime NOT NULL,
  `venue` varchar(100) NOT NULL,
  `available_seats` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `event_ticket_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `seats_booked` int(11) NOT NULL,
  `category` enum('sport','flight','concert','movie','festival') DEFAULT NULL,
  `image_url` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_date`, `venue`, `available_seats`, `description`, `created_at`, `event_ticket_price`, `seats_booked`, `category`, `image_url`) VALUES
(29, 'Music Festival', '2025-06-20 14:30:00', 'Cite', 25, 'Join us with some amazing artists', '2025-06-18 06:35:28', 10.00, 25, 'festival', 'images/Summersalt.jpg'),
(30, 'Creative Workshop Festival', '2025-06-22 12:30:00', 'Alonte Sports Arena', 100, 'Come watch the creativeness', '2025-06-18 06:37:52', 50.00, 0, 'festival', 'images/CREATIVE.png'),
(31, 'Table Tennis Tournament', '2025-06-30 16:40:00', 'Araneta Coliseum', 15000, 'Watch amazing table tennis players battle their way to greatness', '2025-06-18 06:39:44', 500.00, 2, 'sport', 'images/TableTennis.jpg'),
(32, 'UFC Championship', '2025-06-29 20:00:00', 'Araneta Coliseum', 15000, 'Championship match Poirer vs McGregor', '2025-06-18 06:40:44', 500.00, 0, 'sport', 'images/UFC.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `number_of_tickets` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_status` enum('Pending','Confirm','Cancel') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `user_id`, `event_id`, `booking_date`, `number_of_tickets`, `total_price`, `payment_status`) VALUES
(259, 15, 31, '2025-06-18 18:57:10', 1, 500.00, 'Confirm'),
(260, 15, 31, '2025-06-18 18:57:10', 1, 500.00, 'Confirm'),
(261, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(262, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(263, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(264, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(265, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(266, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(267, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(268, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(269, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(270, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(271, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(272, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(273, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(274, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(275, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(276, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(277, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(278, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(279, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(280, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(281, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(282, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(283, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(284, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm'),
(285, 16, 29, '2025-06-18 19:01:47', 1, 10.00, 'Confirm');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_type` enum('admin','booker') DEFAULT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `Contact` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `created_at`, `user_type`, `firstname`, `lastname`, `Country`, `Contact`) VALUES
(7, 'ADMIN', 'ADMIN', 'admin@example.com', '2025-03-25 05:10:22', 'admin', '', '', '', ''),
(12, 'administration', '$2y$10$z/7.J/B.yFcpFzsaDpwmXuYOfSFMse/s7Fah8kGa.tlwiC3IDAoou', 'adminadmin@gmail.com', '2025-06-15 17:04:55', 'admin', '', '', '', ''),
(13, 'Paula', '$2y$10$NGuW/6SzqspqR8tx8jxUYu/B4zkVnUn662FXqCE68f1O.t0FSKih2', 'paulamarielacdan18@gmail.com', '2025-06-17 11:13:33', 'booker', '', '', '', ''),
(15, 'Carlito', '$2y$10$7DIWO89x1wabKqa.wLEHvukm0OYm76/H1J9DsBef7nnEb.WVI0RWO', 'carlitotagarro0@gmail.com', '2025-06-17 16:37:06', 'booker', '', '', '', ''),
(16, 'Charlito', '$2y$10$YWUePwUKikoACBv5pEBYY.oWjmXO7EfUFO2OwGuuF8f4nt2YbS9pO', 'ch4rlestzy27@gmail.com', '2025-06-18 19:00:53', 'booker', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `idx_event_date` (`event_date`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_user_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
