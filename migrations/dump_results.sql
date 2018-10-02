-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 12, 2018 at 01:02 PM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dyntech`
--

-- --------------------------------------------------------

INSERT INTO `resultcampbell` (`campbellId`, `settingId`, `initialSpin`, `finalSpin`, `steps`, `crsp`) VALUES
('1W8wrgSIKukU78XxxhgGs', 1, '6.000000e+1', '1.200000e+4', '8.000000e+1', '6.000000e+0'),
('22uXJsyeBnAQD4q1MfFSI', 1, '1.000000e+0', '2.000000e+2', '8.000000e+1', '6.000000e+0'),
('1iEGhP15rwm3ioSL9jXH1', 4, '6.000000e+1', '1.200000e+4', '8.000000e+1', '6.000000e+0'),
('2qD3I1yDJDIRZupXy1rwd', 4, '1.000000e+0', '2.000000e+2', '8.000000e+1', '6.000000e+0'),
('1QAmLOcgsrr6xEzuR8irZ', 5, '0.000000e+0', '1.500000e+4', '1.000000e+2', '6.000000e+0'),
('2XxRJYg4GqZYRiAqpAfN0', 5, '0.000000e+0', '2.500000e+2', '1.000000e+2', '6.000000e+0'),
('1i6ivyHgNwBzEFdQs6WAx', 6, '2.000000e+2', '2.500000e+4', '3.000000e+2', '8.000000e+0'),
('R4v36X8yTRjSBKahajbAY', 8, '2.000000e+2', '2.500000e+4', '3.000000e+2', '8.000000e+0'),
('NvVjknwdfvzesmwhXJfQs', 9, '2.000000e+2', '2.500000e+4', '3.000000e+2', '8.000000e+0'),
('SBG0PzJGlPnysOhmQmz6l', 10, '2.000000e+2', '2.500000e+4', '3.000000e+2', '8.000000e+0');

-- --------------------------------------------------------

INSERT INTO `resultconstant` (`constantId`, `settingId`, `initialFrequency`, `finalFrequency`, `modes`, `steps`, `speed`) VALUES
('5fo5zF9c70YXhGqSZbOXw', 8, '1.000000e+0', '5.000000e+2', '2.000000e+1', '5.000000e+2', '3.000000e+3');

-- --------------------------------------------------------

INSERT INTO `resultforcemodel` (`forceId`, `constantId`, `position`, `coord`, `force`) VALUES
('M2jGVgXYt7E06JYSlJPbu', '5fo5zF9c70YXhGqSZbOXw', '3.000000e-1', '1.000000e+0', '1.000000e+1');

-- --------------------------------------------------------

INSERT INTO `resultmodes` (`modesId`, `settingId`, `maxFrequency`, `numModes`) VALUES
('AlgK1ATcK6C8NeCRkqThA', 8, '1.500000e+5', '6.000000e+0'),
('dSarBOIt6sCJccpF31xTQ', 9, '1.500000e+5', '6.000000e+0'),
('tXxRJYg4GqZYRiAqpAfN0', 6, '1.500000e+5', '6.000000e+0'),
('pLpR2wNe3fhlV4mByhK3c', 11, '1.500000e+5', '6.000000e+0');

-- --------------------------------------------------------

INSERT INTO `resultphasemodel` (`phaseId`, `model`, `modelId`, `position`, `unbalance`, `phase`) VALUES
('RJCGZ4zBHQRhzPPCqMTiP', 'unbalance', '7sB7UtHBUMFDyt0XnrML9', '2.500000e-1', '5.000000e-5', '1.000000e+0');

-- --------------------------------------------------------

INSERT INTO `resultresponsemodel` (`responseId`, `model`, `modelId`, `position`, `coord`) VALUES
('4bJKWj88h9pgOTLLmXO6A', 'resultconstant', '5fo5zF9c70YXhGqSZbOXw', '3.000000e-1', '1.000000e+0'),
('G2uXJsyeBnAQD4q1MfFSI', 'resultunbalance', '7sB7UtHBUMFDyt0XnrML9', '2.500000e-1', '1.000000e+0'),
('RJCGZ4zBHQRhzPPCqMTiP', 'resulttorsional', 'Nki626wTeFo2avD4jOPtL', '3.000000e-1', '0.000000e+0');

-- --------------------------------------------------------

INSERT INTO `resultstiffness` (`crticalMapId`, `settingId`, `initialStiff`, `initialSpeed`, `finalSpeed`, `numDecades`, `numFrequencies`) VALUES
('hL7Jx3zbnpXmCeI6iif8o', 4, '1.000000e+4', '2.000000e+2', '1.200000e+4', '5.000000e+0', '6.000000e+0');

-- --------------------------------------------------------

INSERT INTO `resulttorkphasemodel` (`torkPhaseId`, `torsionalId`, `position`, `tork`, `phase`) VALUES
('hL7Jx3zbnpXmCeI6iif8o', 'Nki626wTeFo2avD4jOPtL', '3.000000e-1', '6.000000e+1', '1.000000e+1');

-- --------------------------------------------------------

INSERT INTO `resulttorsional` (`torsionalId`, `settingId`, `initialFrequency`, `finalFrequency`, `steps`, `modes`) VALUES
('Nki626wTeFo2avD4jOPtL', 8, '1.000000e+0', '5.000000e+2', '5.000000e+2', '2.000000e+1');

-- --------------------------------------------------------

INSERT INTO `resultunbalance` (`unbalanceId`, `settingId`, `initialSpin`, `finalSpin`, `steps`, `modes`) VALUES
('7sB7UtHBUMFDyt0XnrML9', 8, '1.000000e+3', '3.000000e+4', '3.500000e+2', '2.000000e+1');

-- --------------------------------------------------------
