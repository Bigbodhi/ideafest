-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2023 at 01:08 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ideafest`
--

-- --------------------------------------------------------

--
-- Table structure for table `audience_votes`
--

CREATE TABLE `audience_votes` (
  `id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vote_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `points` int(11) NOT NULL,
  `scores` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audience_votes`
--

INSERT INTO `audience_votes` (`id`, `participant_id`, `user_id`, `vote_date`, `points`, `scores`) VALUES
(20, 7, 3, '2023-05-06 14:17:10', 8, '[\"2\",\"4\",\"1\",\"1\"]'),
(21, 6, 3, '2023-05-06 14:17:21', 5, '[\"1\",\"1\",\"2\",\"1\"]');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `max_points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `max_points`) VALUES
(1, 'Slide Content', 20),
(2, 'Design', 15),
(3, 'Delivery', 25),
(4, 'Overall Impression', 40);

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `photo` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`id`, `name`, `email`, `user_id`, `created_at`, `photo`, `description`) VALUES
(5, 'Attiksh', 'attiksh@bba.com', 1, '2023-05-02 11:21:18', 'uploads/1683026478_icon.png', 'Test 1'),
(6, 'Karan', 'karan@bba.com', 1, '2023-05-02 11:22:03', 'uploads/1683026523_icon.png', 'Test 2'),
(7, 'Sarnith', 'sarnith@bba.com', 1, '2023-05-02 11:22:20', 'uploads/1683026540_icon.png', 'Test 3');

-- --------------------------------------------------------

--
-- Table structure for table `scoredata`
--

CREATE TABLE `scoredata` (
  `id` int(11) NOT NULL,
  `participant_id` int(11) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `scoredata`
--

INSERT INTO `scoredata` (`id`, `participant_id`, `points`, `details`) VALUES
(1, 1, 11, '[[\"4\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"5\"],[\"0\",\"0\",\"0\",\"2\",\"0\",\"0\",\"0\"]]'),
(2, 1, 25, '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\"],[\"10\",\"5\",\"5\",\"5\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]'),
(3, 2, 80, '[[\"4\",\"4\",\"3\",\"3\",\"3\",\"3\"],[\"4\",\"3\",\"4\",\"4\"],[\"10\",\"5\",\"5\",\"5\"],[\"5\",\"5\",\"3\",\"2\",\"2\",\"2\",\"1\"]]'),
(4, 7, 9, '[[\"4\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"5\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `id` int(11) UNSIGNED NOT NULL,
  `participant_id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `jury_id` int(11) UNSIGNED NOT NULL,
  `points` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','jury','audience','participant') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'sam', 'svd2305@gmail.com', '$2y$10$xvfzib/lhJVz6F7Noh..oOXJKGXwWD9O/7FbwzrclNLBTqzHpRqhW', 'admin', '2023-05-01 09:01:31'),
(2, 'bigbodhi', 'bigbodhiacademy@gmail.com', '$2y$10$nUffxRBy3UM/.4JlIWG/7uHrrEIPsRIDy6Gz3Kc1BxmgCZ6uKBEKe', 'admin', '2023-05-01 11:22:03'),
(3, 'people', 'people@in.com', '$2y$10$wTn2WYlTWckkEzQYMdZ8puQTtUnPF/qtVOTDprk0tJHKWKte4miXe', 'audience', '2023-05-02 07:38:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audience_votes`
--
ALTER TABLE `audience_votes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `scoredata`
--
ALTER TABLE `scoredata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `participant_id` (`participant_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `jury_id` (`jury_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audience_votes`
--
ALTER TABLE `audience_votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `scoredata`
--
ALTER TABLE `scoredata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`),
  ADD CONSTRAINT `scores_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `scores_ibfk_3` FOREIGN KEY (`jury_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
