-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 11, 2020 at 05:53 PM
-- Server version: 5.7.31-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `HandSMetals`
--

-- --------------------------------------------------------

--
-- Table structure for table `Customers`
--

CREATE TABLE `Customers` (
  `company` varchar(20) NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Customers`
--

INSERT INTO `Customers` (`company`, `contact`, `phone`, `email`) VALUES
('Apple', 'Bob', '12344455', 'bob@apple.com'),
('IWUCool', 'Me', '789545', 'me@me.com'),
('Microsoft', 'Bill Gates', '1347664859', 'Bill@MS.com'),
('New', 'me', '78542', 'hi@me'),
('Person', 'Micah', '12345', 'me@gmail.com'),
('Withers', 'Micah', '123456', 'micah@withers.com');

-- --------------------------------------------------------

--
-- Table structure for table `Lots`
--

CREATE TABLE `Lots` (
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lotnum` int(5) UNSIGNED NOT NULL,
  `customer` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'DIRTY',
  `type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Lots`
--

INSERT INTO `Lots` (`date`, `lotnum`, `customer`, `status`, `type`) VALUES
('2020-09-17 17:02:32', 1, 'Apple', 'DIRTY', NULL),
('2020-09-17 17:12:51', 2, 'Microsoft', 'DIRTY', NULL),
('2020-09-17 17:14:54', 3, 'Apple', 'DIRTY', NULL),
('2020-09-17 17:22:03', 4, 'Person', 'DIRTY', NULL),
('2020-09-17 17:29:42', 5, 'Apple', 'DIRTY', NULL),
('2020-09-17 17:30:14', 6, 'IWUCool', 'DIRTY', NULL),
('2020-09-17 17:34:28', 7, 'Microsoft', 'DIRTY', NULL),
('2020-09-17 17:37:42', 8, 'Withers', 'DIRTY', NULL),
('2020-09-17 17:46:52', 9, 'Withers', 'DIRTY', NULL),
('2020-09-20 14:48:24', 10, 'Apple', 'DIRTY', NULL),
('2020-10-05 17:10:52', 11, 'Microsoft', 'DIRTY', NULL),
('2020-10-05 17:27:10', 12, 'New', 'DIRTY', NULL),
('2020-10-06 14:00:46', 13, 'Microsoft', 'DIRTY', NULL),
('2020-10-08 15:32:27', 14, 'Person', 'DIRTY', NULL),
('2020-10-08 15:33:29', 15, 'IWUCool', 'DIRTY', NULL),
('2020-10-08 16:34:57', 16, 'Microsoft', 'DIRTY', NULL),
('2020-10-11 16:38:11', 17, 'Apple', 'DIRTY', NULL),
('2020-10-11 16:43:14', 18, 'Apple', 'DIRTY', NULL),
('2020-10-11 17:32:47', 19, 'IWUCool', 'DIRTY', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Pallets`
--

CREATE TABLE `Pallets` (
  `lotnum` int(10) UNSIGNED NOT NULL,
  `palletnum` int(10) UNSIGNED NOT NULL,
  `gross` decimal(10,0) UNSIGNED NOT NULL,
  `tare` decimal(10,0) UNSIGNED NOT NULL,
  `net` decimal(10,0) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Pallets`
--

INSERT INTO `Pallets` (`lotnum`, `palletnum`, `gross`, `tare`, `net`) VALUES
(11, 1, '2345', '234', '2111'),
(11, 2, '3456', '654', '2802'),
(12, 1, '12345', '123', '12222'),
(12, 2, '2345', '134', '2211'),
(12, 3, '12346', '109', '12237'),
(13, 1, '1234', '34', '1200'),
(13, 2, '123', '23', '100'),
(13, 3, '12345', '345', '12000'),
(13, 4, '23456', '45', '23411'),
(13, 5, '2345', '345', '2000'),
(13, 6, '987', '67', '920'),
(13, 7, '12345', '456', '11889'),
(13, 8, '123', '23', '100'),
(13, 9, '1234', '123', '1111'),
(14, 1, '32456', '45', '32411'),
(15, 1, '2345', '45', '2300'),
(16, 1, '2345', '345', '2000'),
(17, 1, '1234', '123', '1111'),
(17, 2, '5678', '1234', '4444'),
(18, 1, '55555', '33333', '22222'),
(19, 1, '741', '85', '656');

--
-- Triggers `Pallets`
--
DELIMITER $$
CREATE TRIGGER `trg_calculate_net` BEFORE INSERT ON `Pallets` FOR EACH ROW SET NEW.net = NEW.gross - NEW.tare
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_increment_pallet` BEFORE INSERT ON `Pallets` FOR EACH ROW SET NEW.palletnum = (
    SELECT IFNULL(MAX(palletnum), 0) + 1
    FROM Pallets
    WHERE lotnum = NEW.lotnum
    )
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `username`, `password`) VALUES
(1, 'hsAdmin', 'hsMetalsAdmin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Customers`
--
ALTER TABLE `Customers`
  ADD PRIMARY KEY (`company`);

--
-- Indexes for table `Lots`
--
ALTER TABLE `Lots`
  ADD PRIMARY KEY (`lotnum`),
  ADD KEY `customer_name` (`customer`);

--
-- Indexes for table `Pallets`
--
ALTER TABLE `Pallets`
  ADD PRIMARY KEY (`lotnum`,`palletnum`),
  ADD UNIQUE KEY `lotnum` (`lotnum`,`palletnum`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`username`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Lots`
--
ALTER TABLE `Lots`
  ADD CONSTRAINT `customer_name` FOREIGN KEY (`customer`) REFERENCES `Customers` (`company`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Pallets`
--
ALTER TABLE `Pallets`
  ADD CONSTRAINT `lotnum_fk` FOREIGN KEY (`lotnum`) REFERENCES `Lots` (`lotnum`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
