-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 20, 2020 at 11:08 AM
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
CREATE DATABASE IF NOT EXISTS `handsmetals` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `handsmetals`;

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
('Brown\'s Plumbing', 'Marshall Brown', '3172700227', 'marshlendel@gmail.com'),
('Schmidt\'s Forgery', 'Josiah Schmidt', '2603558423', 'josiah.schmidt@gmail.com'),
('Withers Lawncare', 'Micah Withers', '9373132512', 'micah.withers@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `lots`
--

DROP TABLE IF EXISTS `lots`;
CREATE TABLE IF NOT EXISTS `lots` (
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lotnum` int(5) UNSIGNED NOT NULL,
  `customer` varchar(20) NOT NULL,
  `gross` decimal(10,0) NOT NULL DEFAULT '0',
  `tare` decimal(10,0) NOT NULL DEFAULT '0',
  `net` decimal(10,0) NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL DEFAULT 'DIRTY',
  `type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`lotnum`),
  KEY `customer_name` (`customer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lots`
--

INSERT INTO `lots` (`date`, `lotnum`, `customer`, `gross`, `tare`, `net`, `status`, `type`) VALUES
('2020-10-19 22:27:21', 1, 'Withers Lawncare', '9935', '961', '8974', 'DIRTY', NULL),
('2020-10-19 22:32:50', 2, 'Brown\'s Plumbing', '77157', '10740', '66417', 'DIRTY', NULL),
('2020-10-19 22:34:09', 3, 'Schmidt\'s Forgery', '147402', '13170', '134232', 'DIRTY', NULL),
('2020-10-19 23:04:58', 4, 'Withers Lawncare', '19513', '1225', '18288', 'DIRTY', NULL);

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
  `net` decimal(10,0) UNSIGNED NOT NULL,
  PRIMARY KEY (`lotnum`,`palletnum`),
  UNIQUE KEY `lotnum` (`lotnum`,`palletnum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pallets`
--

INSERT INTO `pallets` (`lotnum`, `palletnum`, `gross`, `tare`, `net`) VALUES
(1, 1, '4567', '456', '4111'),
(1, 2, '456', '4', '452'),
(1, 3, '345', '45', '300'),
(1, 4, '4567', '456', '4111'),
(2, 1, '45678', '5674', '40004'),
(2, 2, '3456', '456', '3000'),
(2, 3, '23456', '4567', '18889'),
(2, 4, '4567', '43', '4524'),
(3, 1, '34567', '456', '34111'),
(3, 2, '34567', '4579', '29988'),
(3, 3, '23456', '3456', '20000'),
(3, 4, '45678', '4567', '41111'),
(3, 5, '4567', '56', '4511'),
(3, 6, '4567', '56', '4511'),
(4, 1, '4567', '45', '4522'),
(4, 2, '4567', '456', '4111'),
(4, 3, '3456', '345', '3111'),
(4, 4, '3456', '34', '3422'),
(4, 5, '3467', '345', '3122');

--
-- Triggers `pallets`
--
DROP TRIGGER IF EXISTS `trg_calculate_net`;
DELIMITER $$
CREATE TRIGGER `trg_calculate_net` BEFORE INSERT ON `pallets` FOR EACH ROW SET NEW.net = NEW.gross - NEW.tare
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_increment_pallet`;
DELIMITER $$
CREATE TRIGGER `trg_increment_pallet` BEFORE INSERT ON `pallets` FOR EACH ROW SET NEW.palletnum = (
    SELECT IFNULL(MAX(palletnum), 0) + 1
    FROM Pallets
    WHERE lotnum = NEW.lotnum
    )
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_on_del_updt_lot`;
DELIMITER $$
CREATE TRIGGER `trg_on_del_updt_lot` AFTER DELETE ON `pallets` FOR EACH ROW UPDATE Lots
SET gross = IF((SELECT SUM(gross) FROM Pallets WHERE lotnum = OLD.lotnum GROUP BY lotnum) IS NULL, 0, (SELECT SUM(gross) FROM Pallets WHERE lotnum = OLD.lotnum GROUP BY lotnum)),
    tare = IF((SELECT SUM(tare) FROM Pallets WHERE lotnum = OLD.lotnum GROUP BY lotnum) IS NULL, 0, (SELECT SUM(tare) FROM Pallets WHERE lotnum = OLD.lotnum GROUP BY lotnum)),
    net = IF((SELECT SUM(net) FROM Pallets WHERE lotnum = OLD.lotnum GROUP BY lotnum) IS NULL, 0, (SELECT SUM(net) FROM Pallets WHERE lotnum = OLD.lotnum GROUP BY lotnum))
WHERE lotnum = OLD.lotnum
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_on_insert_updt_lot`;
DELIMITER $$
CREATE TRIGGER `trg_on_insert_updt_lot` AFTER INSERT ON `pallets` FOR EACH ROW UPDATE Lots
SET gross = (SELECT SUM(gross) FROM Pallets WHERE lotnum = NEW.lotnum GROUP BY lotnum),
	tare = (SELECT SUM(tare) FROM Pallets WHERE lotnum = NEW.lotnum GROUP BY lotnum),
    	net = (SELECT SUM(net) FROM Pallets WHERE lotnum = NEW.lotnum GROUP BY lotnum)
WHERE lotnum = NEW.lotnum
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_on_update_updt_lot`;
DELIMITER $$
CREATE TRIGGER `trg_on_update_updt_lot` AFTER UPDATE ON `pallets` FOR EACH ROW UPDATE Lots
SET gross = (SELECT SUM(gross) FROM Pallets WHERE lotnum = OLD.lotnum GROUP BY net),
	tare = (SELECT SUM(tare) FROM Pallets WHERE lotnum = OLD.lotnum GROUP BY net),
    net = (SELECT SUM(net) FROM Pallets WHERE lotnum = OLD.lotnum GROUP BY net)
WHERE lotnum = OLD.lotnum
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
