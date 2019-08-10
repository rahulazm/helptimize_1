-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2019 at 03:50 PM
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
-- Table structure for table `platform_fee`
--

CREATE TABLE `platform_fee` (
  `platformfee_id` int(11) NOT NULL,
  `platformfee_name` varchar(255) NOT NULL,
  `platformfee_value` float NOT NULL DEFAULT '0',
  `platformfee_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `platform_fee`
--

INSERT INTO `platform_fee` (`platformfee_id`, `platformfee_name`, `platformfee_value`, `platformfee_status`) VALUES
(1, 'stripe', 2.7, 0),
(2, '', 0, 0),
(3, '', 0, 0),
(4, 'aaa', 11, 0),
(5, 'aaa', 11, 0),
(6, 'dfssegsg', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `platform_fee`
--
ALTER TABLE `platform_fee`
  ADD PRIMARY KEY (`platformfee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `platform_fee`
--
ALTER TABLE `platform_fee`
  MODIFY `platformfee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
