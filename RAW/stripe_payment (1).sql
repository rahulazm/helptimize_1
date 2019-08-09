-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2019 at 09:18 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.0.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helptimize_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `stripe_payment`
--

CREATE TABLE `stripe_payment` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `item_number` varchar(255) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `currency_code` varchar(55) NOT NULL,
  `txn_id` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_response` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stripe_payment`
--

INSERT INTO `stripe_payment` (`id`, `email`, `item_number`, `amount`, `currency_code`, `txn_id`, `payment_status`, `payment_response`, `create_at`) VALUES
(2, '', 'ch_1F5F7iFeuudOWVhKnNT8osKo', 0.00, '', '', '', '', '2019-08-08 17:09:05'),
(3, '', 'ch_1F5FIrFeuudOWVhKnb5tYWtQ', 10.88, 'usd', 'txn_1F5FIrFeuudOWVhKRunotMQ0', 'success', '', '2019-08-08 17:20:35'),
(4, '', 'ch_1F5FKCFeuudOWVhKN07lBIa2', 10.88, 'usd', 'txn_1F5FKDFeuudOWVhKFvfesm38', 'success', 'succeeded', '2019-08-08 17:21:59'),
(5, '', 'ch_1F5QQsFeuudOWVhKY2LNdkW7', 10.88, 'usd', 'txn_1F5QQsFeuudOWVhKZgbzKvoz', 'success', 'succeeded', '2019-08-09 05:13:36'),
(6, '', 'ch_1F5SKEFeuudOWVhKZJHMYT8s', 10.88, 'usd', 'txn_1F5SKEFeuudOWVhKxF5vpv0K', 'success', 'succeeded', '2019-08-09 07:14:52'),
(7, '', 'ch_1F5SNXFeuudOWVhKvLTq9jXK', 10.88, 'usd', 'txn_1F5SNXFeuudOWVhKFN91DdcI', 'success', 'succeeded', '2019-08-09 07:18:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stripe_payment`
--
ALTER TABLE `stripe_payment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stripe_payment`
--
ALTER TABLE `stripe_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
