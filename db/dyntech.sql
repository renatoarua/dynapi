-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2018 at 08:25 PM
-- Server version: 5.6.17-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dyntech`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shaft`
--

CREATE TABLE IF NOT EXISTS `machine` (
  `machineId` varchar(21) NOT NULL,
  `projectId` varchar(21) NOT NULL,
  `length` double NOT NULL,
  `ldratio` double NOT NULL,
  PRIMARY KEY (`machineId`),
  KEY `projectId` (`projectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shaftsession`
--

CREATE TABLE IF NOT EXISTS `shaftsession` (
  `shaftSessionId` varchar(21) NOT NULL,
  `machineId` varchar(21) NOT NULL,
  `materialId` varchar(21) NOT NULL,
  `length` double NOT NULL,
  `externalDiameter` double NOT NULL,
  `internalDiameter` double NOT NULL,
  `young` double NOT NULL,
  `poisson` double NOT NULL,
  `density` double NOT NULL,
  `axialForce` double NOT NULL,
  `magneticForce` double NOT NULL,
  PRIMARY KEY (`shaftSessionId`),
  KEY `machineId` (`machineId`),
  KEY `materialId` (`materialId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ribs`
--

CREATE TABLE IF NOT EXISTS `ribs` (
  `ribId` varchar(21) NOT NULL,
  `machineId` varchar(21) NOT NULL,
  `position` double NOT NULL,
  `number` double NOT NULL,
  `webThicknes` double NOT NULL,
  `webDepth` double NOT NULL,
  `flangeWidth` double NOT NULL,
  `flangeThick` double NOT NULL,

  PRIMARY KEY (`ribId`),
  KEY `machineId` (`machineId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_disc`
--

CREATE TABLE IF NOT EXISTS `disc` (
  `discId` varchar(21) NOT NULL,
  `machineId` varchar(21) NOT NULL,
  `materialId` varchar(21) NOT NULL,
  `position` double NOT NULL,
  `length` double NOT NULL,
  `externalDiameter` double NOT NULL,
  `internalDiameter` double NOT NULL,
  `density` double NOT NULL,
  `thickness` double NOT NULL,
  `mass` double NOT NULL,
  `ix` double NOT NULL,
  `iy` double NOT NULL,
  `iz` double NOT NULL,
  PRIMARY KEY (`discId`),
  KEY `machineId` (`machineId`),
  KEY `materialId` (`materialId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bearing`
--

CREATE TABLE IF NOT EXISTS `rollerbearing` (
  `rollerBearingId` varchar(21) NOT NULL,
  `machineId` varchar(21) NOT NULL,
  `position` double NOT NULL,
  `mass` double NOT NULL,
  `inertia` double NOT NULL,
  `kxx` double NOT NULL,
  `kxz` double NOT NULL,
  `kzx` double NOT NULL,
  `kzz` double NOT NULL,
  `cxx` double NOT NULL,
  `cxz` double NOT NULL,
  `czx` double NOT NULL,
  `czz` double NOT NULL,
  `ktt` double NOT NULL,
  `ktp` double NOT NULL,
  `kpp` double NOT NULL,
  `kpt` double NOT NULL,
  `ctt` double NOT NULL,
  `ctp` double NOT NULL,
  `cpp` double NOT NULL,
  `cpt` double NOT NULL,
  PRIMARY KEY (`rollerBearingId`),
  KEY `machineId` (`machineId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_journalbearing`
--

CREATE TABLE IF NOT EXISTS `journalbearing` (
  `journalBearingId` varchar(21) NOT NULL,
  `machineId` varchar(21) NOT NULL,
  `position` double NOT NULL,
  
  PRIMARY KEY (`journalBearingId`),
  KEY `machineId` (`machineId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `rotation` (
  `rotationId` varchar(21) NOT NULL,
  `journalBearingId` varchar(21) NOT NULL,
  `speed` double NOT NULL,
  `kxx` double NOT NULL,
  `kxz` double NOT NULL,
  `kzx` double NOT NULL,
  `kzz` double NOT NULL,
  `cxx` double NOT NULL,
  `cxz` double NOT NULL,
  `czx` double NOT NULL,
  `czz` double NOT NULL,
  PRIMARY KEY (`rotationId`),
  KEY `journalBearingId` (`journalBearingId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `foundation`
--

CREATE TABLE IF NOT EXISTS `foundation` (
  `foundationId` varchar(21) NOT NULL,
  `machineId` varchar(21) NOT NULL,
  `position` double NOT NULL,
  `kxx` double NOT NULL,
  `kzz` double NOT NULL,
  `cxx` double NOT NULL,
  `czz` double NOT NULL,
  `mass` double NOT NULL,
  PRIMARY KEY (`foundationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_material`
--

CREATE TABLE IF NOT EXISTS `material` (
  `materialId` varchar(21) NOT NULL,
  `name` varchar(40) NOT NULL,
  `density` double NOT NULL,
  PRIMARY KEY (`materialId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `projectId` varchar(21) NOT NULL,
  `userId` varchar(21) NOT NULL,
  `name` varchar(80) NOT NULL,
  `status` varchar(3) NOT NULL,
  PRIMARY KEY (`projectId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `LOG`
--

CREATE TABLE IF NOT EXISTS `autolog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` varchar(21) NOT NULL,
  `projectId` varchar(21) NOT NULL,
  `taskId` int(11) NOT NULL,
  `startTime` int(11) NOT NULL,
  `endTime` int(11) NOT NULL,
  `status` varchar(3) NOT NULL,

  PRIMARY KEY (`id`),
  KEY `projectId` (`projectId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rollerbearing`
--
ALTER TABLE `rollerbearing`
  ADD CONSTRAINT `bearing-machine-fk1` FOREIGN KEY (`machineId`) REFERENCES `machine` (`machineId`);

--
-- Constraints for table `disc`
--
ALTER TABLE `disc`
  ADD CONSTRAINT `disc-material-fk2` FOREIGN KEY (`materialId`) REFERENCES `tbl_material` (`materialId`),
  ADD CONSTRAINT `disc-machine-fk1` FOREIGN KEY (`machineId`) REFERENCES `machine` (`machineId`);

--
-- Constraints for table `journalbearing`
--
ALTER TABLE `journalbearing`
  ADD CONSTRAINT `journalbearing-machine-fk1` FOREIGN KEY (`machineId`) REFERENCES `machine` (`machineId`);

--
-- Constraints for table `machine`
--
ALTER TABLE `machine`
  ADD CONSTRAINT `machine-project-fk1` FOREIGN KEY (`projectId`) REFERENCES `project` (`projectId`);

--
-- Constraints for table `tbl_shaftsession`
--
ALTER TABLE `shaftsession`
  ADD CONSTRAINT `shaftsession-material-fk2` FOREIGN KEY (`materialId`) REFERENCES `material` (`materialId`),
  ADD CONSTRAINT `shaftsession-machine-fk1` FOREIGN KEY (`machineId`) REFERENCES `machine` (`machineId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
