-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 04, 2020 at 10:27 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `handsmetals`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `company` varchar(20) NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`company`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`company`, `contact`, `phone`, `email`) VALUES
('IUWU', 'Wesley', '7656771938', 'mail@wesley.edu'),
('IWU2.0', 'Donald Trump', '180083957', 'afjlsjf'),
('Magic Marshmellow', 'Marshmellow', '3172700227', 'magicmellow@gmail.com'),
('Schmidt\'s Forgery', 'Josiah Schmidt', '2603558423', 'josiah.schmidt@gmail.com'),
('Withers Lawncare', 'Micah Withers', '9373132512', 'micah.withers@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `lots`
--

DROP TABLE IF EXISTS `lots`;
CREATE TABLE IF NOT EXISTS `lots` (
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lotnum` int(10) UNSIGNED NOT NULL,
  `customer` varchar(32) NOT NULL,
  `status` enum('DIRTY','CLEAN','PARTIALLY-SHIPPED','SHIPPED') NOT NULL DEFAULT 'DIRTY',
  `type` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`lotnum`),
  KEY `customer_name` (`customer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lots`
--

INSERT INTO `lots` (`date`, `lotnum`, `customer`, `status`, `type`) VALUES
('2020-10-19 22:27:21', 1, 'IUWU', 'DIRTY', NULL),
('2020-10-19 22:34:09', 3, 'Schmidt\'s Forgery', 'DIRTY', NULL),
('2020-10-20 18:24:11', 5, 'Schmidt\'s Forgery', 'DIRTY', NULL),
('2020-10-22 15:44:28', 6, 'IUWU', 'PARTIALLY-SHIPPED', NULL),
('2020-10-26 21:00:39', 7, 'IUWU', 'DIRTY', NULL),
('2020-10-27 16:10:56', 11, 'IUWU', 'DIRTY', NULL),
('2020-10-29 15:43:55', 12, 'Magic Marshmellow', 'DIRTY', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pallets`
--

DROP TABLE IF EXISTS `pallets`;
CREATE TABLE IF NOT EXISTS `pallets` (
  `lotnum` int(10) UNSIGNED NOT NULL,
  `palletnum` int(10) UNSIGNED NOT NULL,
  `gross` decimal(10,0) UNSIGNED NOT NULL,
  `tare` decimal(10,0) UNSIGNED NOT NULL,
  PRIMARY KEY (`lotnum`,`palletnum`),
  UNIQUE KEY `lotnum` (`lotnum`,`palletnum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pallets`
--

INSERT INTO `pallets` (`lotnum`, `palletnum`, `gross`, `tare`) VALUES
(1, 1, '4567', '456'),
(1, 2, '456', '4'),
(1, 3, '345', '45'),
(1, 4, '4567', '456'),
(3, 1, '34567', '456'),
(3, 2, '34567', '4579'),
(3, 3, '23456', '3456'),
(3, 4, '45678', '4567'),
(3, 5, '4567', '56'),
(3, 6, '4567', '56'),
(3, 7, '4566', '456'),
(5, 1, '3456', '234'),
(6, 1, '3456', '34'),
(7, 1, '5678', '456'),
(7, 2, '3456', '345'),
(7, 3, '4567', '345'),
(7, 4, '5678', '23'),
(7, 5, '5678', '890'),
(7, 6, '89075', '2457'),
(7, 7, '4567', '678'),
(7, 8, '5678', '4567'),
(7, 9, '2345', '234'),
(7, 10, '3456', '45'),
(7, 11, '5678', '567'),
(7, 12, '4567', '45'),
(7, 13, '4567', '45'),
(11, 1, '4567', '45');

--
-- Triggers `pallets`
--
DROP TRIGGER IF EXISTS `trg_increment_palletnum`;
DELIMITER $$
CREATE TRIGGER `trg_increment_palletnum` BEFORE INSERT ON `pallets` FOR EACH ROW SET NEW.palletnum = (
    SELECT IFNULL(MAX(palletnum), 0) + 1
	FROM Pallets
	WHERE lotnum = NEW.lotnum)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`username`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lots`
--
ALTER TABLE `lots`
  ADD CONSTRAINT `customer_name` FOREIGN KEY (`customer`) REFERENCES `customers` (`company`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pallets`
--
ALTER TABLE `pallets`
  ADD CONSTRAINT `lotnum_fk` FOREIGN KEY (`lotnum`) REFERENCES `lots` (`lotnum`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
