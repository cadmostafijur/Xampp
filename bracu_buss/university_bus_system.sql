-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2024 at 11:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `university_bus_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `profile_image` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `email`, `full_name`, `profile_image`) VALUES
(1, 'admin0', 'admin123', 'admin@gmail.com', 'admin admin', 'uploads/6615a61e41b7b1.63703939.jpg'),
(2, 'farhan00', 'farhan00', 'farhan00@gmail.com', NULL, 'uploads/6615a748a25f53.15349615.jpg'),
(4, 'bondhon', 'bondhon1', 'bondhon@gmail.com', 'Bondhon', 'uploads/pfp1.jpg'),
(9, 'mahi', 'mahi', 'mahi@bracu.com', 'mahi', '');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_pnr` varchar(255) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `schedule_id_2` int(11) DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `departure_location` varchar(250) NOT NULL,
  `arrival_location` varchar(250) NOT NULL,
  `departure_time` time NOT NULL,
  `price` int(40) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `journey_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_pnr`, `booking_id`, `user_id`, `schedule_id`, `schedule_id_2`, `booking_date`, `departure_location`, `arrival_location`, `departure_time`, `price`, `status`, `journey_date`) VALUES
('', 25, 1, NULL, 25, '2024-04-15 20:34:48', 'BRAC University', 'Baldha Garden', '00:00:00', 90, 'pending', '2024-04-17'),
('49B3EC978953A8F6', 26, 1, 5, NULL, '2024-04-15 20:37:08', 'Opposite to Hazrat Shahjalal International Airport', 'BRAC University', '00:00:00', 90, 'approved', '2024-04-18'),
('', 27, 3, NULL, 208, '2024-04-16 06:55:08', 'BRAC University', 'Mohammadpur', '00:00:00', 90, 'pending', '2024-04-18'),
('', 28, 3, NULL, 208, '2024-04-16 06:56:07', 'BRAC University', 'Mohammadpur', '00:00:00', 90, 'pending', '2024-04-18'),
('51377618FCB6177C', 29, 3, NULL, 206, '2024-04-16 06:57:15', 'BRAC University', 'Jatrabari', '00:00:00', 90, 'approved', '2024-04-19'),
('', 30, 3, 9, NULL, '2024-04-16 06:57:47', 'Shewrah', 'BRAC University', '00:00:00', 90, 'pending', '2024-04-18'),
('F629A2732BDF2EE9', 31, 1, NULL, 25, '2024-04-22 14:54:30', 'BRAC University', 'Baldha Garden', '00:00:00', 90, 'approved', '2024-04-23'),
('21B3FE305581815E', 32, 1, 6, NULL, '2024-04-22 14:55:36', 'Kawla', 'BRAC University', '00:00:00', 90, 'approved', '2024-04-23'),
('83F5B06263B2B865', 33, 1, 8, NULL, '2024-04-22 15:01:13', 'Biswa Road', 'BRAC University', '00:00:00', 90, 'approved', '2024-04-23'),
('371B16323432F7D8', 34, 1, NULL, 201, '2024-04-22 15:02:04', 'BRAC University', 'Abdullahpur', '00:00:00', 90, 'approved', '2024-04-23'),
('72938B0B8EDEDCDA', 35, 1, 2, NULL, '2024-04-22 15:06:07', 'House Building', 'BRAC University', '00:00:00', 90, 'approved', '2024-04-23'),
('7869EEA9A051EC2B', 36, 1, 3, NULL, '2024-04-22 15:10:18', 'Azampur', 'BRAC University', '00:00:00', 90, 'approved', '2024-04-23'),
('36B8083A8A5BD514', 37, 1, NULL, 202, '2024-04-22 15:11:04', 'BRAC University', 'Mirpur A', '00:00:00', 90, 'approved', '2024-04-23'),
('3FBED44919B3DE1F', 38, 1, 5, NULL, '2024-04-22 15:14:08', 'Opposite to Hazrat Shahjalal International Airport', 'BRAC University', '00:00:00', 90, 'approved', '2024-04-23'),
('EAED77C44409B8D8', 39, 1, 4, NULL, '2024-04-22 15:22:42', 'Jasimuddin', 'BRAC University', '00:00:00', 90, 'approved', '2024-04-23'),
('E72318F0D78CBD11', 40, 1, NULL, 203, '2024-04-22 15:24:38', 'BRAC University', 'Mirpur B', '00:00:00', 90, 'approved', '2024-04-23'),
('', 41, 1, NULL, 25, '2024-04-22 21:22:27', 'BRAC University', 'Baldha Garden', '00:00:00', 180, 'pending', '2024-04-25'),
('A7091C6F790BE0E0', 42, 1, 1, NULL, '2024-04-23 02:26:52', 'Abdullahpur', 'BRAC University', '00:00:00', 90, 'approved', '2024-04-23');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `bus_id` int(11) NOT NULL,
  `bus_number` varchar(20) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus_schedules`
--

CREATE TABLE `bus_schedules` (
  `schedule_id` int(11) NOT NULL,
  `departure_location` varchar(100) DEFAULT NULL,
  `arrival_location` varchar(100) DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `arrival_time` time DEFAULT NULL,
  `bus_capacity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `available_seats` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `Route` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_schedules`
--

INSERT INTO `bus_schedules` (`schedule_id`, `departure_location`, `arrival_location`, `departure_time`, `arrival_time`, `bus_capacity`, `price`, `available_seats`, `is_active`, `Route`) VALUES
(1, 'Abdullahpur', 'BRAC University', '06:40:00', '07:30:00', 30, 100.00, 30, 1, 1),
(2, 'House Building', 'BRAC University', '06:43:00', '07:30:00', 30, 100.00, 30, 1, 1),
(3, 'Azampur', 'BRAC University', '06:46:00', '07:30:00', 30, 100.00, 30, 1, 1),
(4, 'Jasimuddin', 'BRAC University', '06:49:00', '07:30:00', 30, 100.00, 30, 1, 1),
(5, 'Opposite to Hazrat Shahjalal International Airport', 'BRAC University', '06:53:00', '07:30:00', 30, 100.00, 30, 1, 1),
(6, 'Kawla', 'BRAC University', '06:55:00', '07:30:00', 30, 100.00, 30, 1, 1),
(7, 'Khilket', 'BRAC University', '06:59:00', '07:30:00', 30, 100.00, 30, 1, 1),
(8, 'Biswa Road', 'BRAC University', '07:01:00', '07:30:00', 30, 100.00, 30, 1, 1),
(9, 'Shewrah', 'BRAC University', '07:03:00', '07:30:00', 30, 100.00, 30, 1, 1),
(10, 'Government Bangla College', 'BRAC University', '06:30:00', '07:30:00', 30, 90.00, 30, 1, 2),
(11, 'Sony Cinema Hall', 'BRAC University', '06:34:00', '07:30:00', 30, 90.00, 30, 1, 2),
(12, 'Mirpur College Gate', 'BRAC University', '06:36:00', '07:30:00', 30, 90.00, 30, 1, 2),
(13, 'Syed Nazrul Islam National Swimming Complex', 'BRAC University', '06:38:00', '07:30:00', 30, 90.00, 30, 1, 2),
(14, 'Popular Diagnostic Centre', 'BRAC University', '06:41:00', '07:30:00', 30, 90.00, 30, 1, 2),
(15, 'Pallabi Post Office', 'BRAC University', '06:44:00', '07:30:00', 30, 90.00, 30, 1, 2),
(16, 'Mirpur Ceramics', 'BRAC University', '06:46:00', '07:30:00', 30, 90.00, 30, 1, 2),
(17, 'Mirpur DOHS Gate', 'BRAC University', '06:50:00', '07:30:00', 30, 90.00, 30, 1, 2),
(18, 'Pallabi Thana', 'BRAC University', '06:53:00', '07:30:00', 30, 90.00, 30, 1, 2),
(19, 'Kalshi Bus Stand', 'BRAC University', '06:55:00', '07:30:00', 30, 90.00, 30, 1, 2),
(20, 'ECB Chattar', 'BRAC University', '06:58:00', '07:30:00', 30, 90.00, 30, 1, 2),
(21, 'Kurmitola Bus Station', 'BRAC University', '07:03:00', '07:30:00', 30, 90.00, 30, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `bus_schedules_2`
--

CREATE TABLE `bus_schedules_2` (
  `schedule_id_2` int(11) NOT NULL,
  `departure_location` varchar(100) DEFAULT NULL,
  `arrival_location` varchar(100) DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `arrival_time` time DEFAULT NULL,
  `bus_capacity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `available_seats` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `route` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_schedules_2`
--

INSERT INTO `bus_schedules_2` (`schedule_id_2`, `departure_location`, `arrival_location`, `departure_time`, `arrival_time`, `bus_capacity`, `price`, `available_seats`, `is_active`, `route`) VALUES
(25, 'BRAC University', 'Baldha Garden', '00:00:00', '00:00:00', 30, 90.00, 27, 1, 21),
(105, 'BRAC University', 'Azimpur', '00:00:00', '00:00:00', 30, 90.00, 27, 1, 19),
(201, 'BRAC University', 'Abdullahpur', '00:00:00', '00:00:00', 30, 90.00, 29, 1, 15),
(202, 'BRAC University', 'Mirpur A', '00:00:00', '00:00:00', 30, 90.00, 29, 1, 16),
(203, 'BRAC University', 'Mirpur B', '00:00:00', '00:00:00', 30, 90.00, 29, 1, 17),
(204, 'BRAC University', 'Jigatola', '00:00:00', '00:00:00', 30, 90.00, 30, 1, 18),
(206, 'BRAC University', 'Jatrabari', '07:20:00', '00:00:00', 30, 90.00, 29, 1, 20),
(208, 'BRAC University', 'Mohammadpur', '06:40:00', '00:00:00', 30, 90.00, 30, 1, 22),
(209, 'BRAC University', 'Narayanganj', '00:00:00', '00:00:00', 30, 90.00, 30, 1, 23),
(210, 'BRAC University', 'Bashundhara', '00:00:00', '00:00:00', 30, 90.00, 30, 1, 24);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driver_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `license_number` varchar(20) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `booking_id`, `amount`, `transaction_date`) VALUES
(1, 11, 90.00, '2024-04-09 23:02:39'),
(2, 5, 180.00, '2024-04-09 23:04:36'),
(3, 5, 180.00, '2024-04-09 23:08:10'),
(4, 5, 180.00, '2024-04-09 23:09:13'),
(5, 5, 180.00, '2024-04-09 23:20:41'),
(6, 5, 180.00, '2024-04-09 23:26:42'),
(7, 5, 180.00, '2024-04-09 23:29:23'),
(8, 5, 180.00, '2024-04-09 23:33:39'),
(9, 1, 90.00, '2024-04-09 23:48:58'),
(10, 3, 90.00, '2024-04-09 23:53:01'),
(11, 3, 90.00, '2024-04-09 23:57:44'),
(12, 14, 90.00, '2024-04-10 09:02:25'),
(13, 14, 90.00, '2024-04-10 09:05:07'),
(14, 15, 90.00, '2024-04-13 07:45:19'),
(15, 15, 90.00, '2024-04-13 16:58:11'),
(16, 15, 90.00, '2024-04-13 16:59:11'),
(17, 27, 90.00, '2024-04-14 17:45:12'),
(18, 28, 90.00, '2024-04-14 17:49:17'),
(19, 31, 90.00, '2024-04-14 18:29:24'),
(20, 0, 90.00, '2024-04-15 09:44:04'),
(21, 0, 90.00, '2024-04-15 09:44:06'),
(22, 0, 90.00, '2024-04-15 09:44:10'),
(23, 0, 90.00, '2024-04-15 09:47:04'),
(24, 0, 90.00, '2024-04-15 09:47:06'),
(25, 0, 90.00, '2024-04-15 09:47:07'),
(26, 0, 90.00, '2024-04-15 09:47:07'),
(27, 0, 90.00, '2024-04-15 09:47:08'),
(28, 0, 90.00, '2024-04-15 09:47:08'),
(29, 0, 90.00, '2024-04-15 09:50:00'),
(30, 0, 90.00, '2024-04-15 09:53:22'),
(31, 0, 90.00, '2024-04-15 09:53:24'),
(32, 0, 90.00, '2024-04-15 10:01:03'),
(33, 0, 90.00, '2024-04-15 10:04:48'),
(34, 0, 90.00, '2024-04-15 10:14:02'),
(35, 1, 90.00, '2024-04-15 10:22:35'),
(36, 2, 90.00, '2024-04-15 10:42:02'),
(37, 4, 90.00, '2024-04-15 10:43:58'),
(38, 6, 90.00, '2024-04-15 10:49:21'),
(39, 7, 90.00, '2024-04-15 11:03:01'),
(40, 5, 90.00, '2024-04-15 11:07:30'),
(41, 8, 90.00, '2024-04-15 11:21:11'),
(42, 9, 90.00, '2024-04-15 11:25:06'),
(43, 10, 90.00, '2024-04-15 11:29:11'),
(44, 11, 90.00, '2024-04-15 11:35:49'),
(45, 12, 90.00, '2024-04-15 11:39:14'),
(46, 13, 90.00, '2024-04-15 11:43:26'),
(47, 17, 90.00, '2024-04-15 12:10:42'),
(48, 18, 90.00, '2024-04-15 12:31:25'),
(49, 19, 90.00, '2024-04-15 12:37:58'),
(50, 20, 90.00, '2024-04-15 12:58:04'),
(51, 21, 90.00, '2024-04-15 12:58:47'),
(52, 23, 90.00, '2024-04-15 17:11:10'),
(53, 24, 90.00, '2024-04-15 20:23:37'),
(54, 14, 90.00, '2024-04-15 20:26:06'),
(55, 26, 90.00, '2024-04-15 20:37:16'),
(56, 29, 90.00, '2024-04-16 06:57:22'),
(57, 31, 90.00, '2024-04-22 14:54:34'),
(58, 32, 90.00, '2024-04-22 14:55:38'),
(59, 33, 90.00, '2024-04-22 15:01:15'),
(60, 34, 90.00, '2024-04-22 15:02:06'),
(61, 35, 90.00, '2024-04-22 15:06:09'),
(62, 36, 90.00, '2024-04-22 15:10:21'),
(63, 37, 90.00, '2024-04-22 15:11:19'),
(64, 38, 90.00, '2024-04-22 15:14:10'),
(65, 39, 90.00, '2024-04-22 15:22:45'),
(66, 40, 90.00, '2024-04-22 15:24:45'),
(67, 42, 90.00, '2024-04-23 02:27:55');

-- --------------------------------------------------------

--
-- Table structure for table `travel_history`
--

CREATE TABLE `travel_history` (
  `history_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `travel_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `profile_picture` varchar(40) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `permanent_address` varchar(255) NOT NULL,
  `present_address` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `emergency_number` varchar(15) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `full_name`, `profile_picture`, `student_id`, `permanent_address`, `present_address`, `phone_number`, `emergency_number`, `blood_group`, `registration_date`, `reset_token`) VALUES
(1, 'mahin', 'mahin', 'mostafijur.bd76@gmail.com', 'Md Mostafijur Rahman', 'uploads/profile_661699c1015bc.jpg', '', '', '', '01799457125', '', 'O-', '2024-04-09 09:00:33', '18c9bdb98de81b0f449c3213e914ba5b'),
(2, 'roni', 'roni123', 'roni@gmail.com', 'Roni Ahmed', '', '22101721', 'Heltemkha, Rajshahi', 'Badda, Dhaka', '01788457621', '01788963574', 'O+', '2024-04-09 20:26:02', 'd3e968641affcdf2abc50096828be267'),
(3, 'sadman00', 'sadman00', 'sadman00@gmail.com', 'Sadman Jahen', '', '22101756', 'belly road dhaka', 'chadpur', '01775148485', '01788945515', 'A+', '2024-04-10 08:54:16', NULL),
(4, 'Bondhon', 'bondhon111', 'bondhon011@gmail.com', 'MD Samiul', 'uploads/profile_661a36432642e.jpg', '2222222', 'abc', 'def', '12345676453', '568973085595', 'B+', '2024-04-13 07:30:33', NULL),
(5, 'MD Samiul Haque', '12345', 'bondhon111@gmail.com', 'MD Samiul Haque', 'uploads/profile_661abc08da21e.jpg', '33333333', 'yhuhji', 'dyurg7ygf', '12345678999', '65647484940', 'A+', '2024-04-13 17:04:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_reviews`
--

CREATE TABLE `user_reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `admin_reply` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_reviews`
--

INSERT INTO `user_reviews` (`review_id`, `user_id`, `schedule_id`, `rating`, `comment`, `admin_reply`, `timestamp`) VALUES
(43, 1, 3, 5, 'gjh', 'ssfef', '2024-04-22 21:44:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `schedule_id` (`schedule_id`),
  ADD KEY `schedule_id_2` (`schedule_id_2`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`bus_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `bus_schedules`
--
ALTER TABLE `bus_schedules`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `bus_schedules_2`
--
ALTER TABLE `bus_schedules_2`
  ADD PRIMARY KEY (`schedule_id_2`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `travel_history`
--
ALTER TABLE `travel_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `schedule_id` (`schedule_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_reviews`
--
ALTER TABLE `user_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `bus_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_schedules`
--
ALTER TABLE `bus_schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `travel_history`
--
ALTER TABLE `travel_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_reviews`
--
ALTER TABLE `user_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `bus_schedules` (`schedule_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`schedule_id_2`) REFERENCES `bus_schedules_2` (`schedule_id_2`) ON DELETE CASCADE;

--
-- Constraints for table `buses`
--
ALTER TABLE `buses`
  ADD CONSTRAINT `buses_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`driver_id`);

--
-- Constraints for table `user_reviews`
--
ALTER TABLE `user_reviews`
  ADD CONSTRAINT `user_reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_reviews_ibfk_2` FOREIGN KEY (`schedule_id`) REFERENCES `bus_schedules` (`schedule_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
