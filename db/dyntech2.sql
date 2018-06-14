-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2018 at 09:08 PM
-- Server version: 5.6.17-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dyntech2`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1502387437),
('admin', '4', 1524078866),
('manageSettings', '2', 1502387437),
('manageStaffs', '2', 1502387437),
('manageUsers', '2', 1502387437),
('staff', '2', 1502387437),
('user', '3', 1502387437);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Administrator', NULL, NULL, 1502387436, 1502387436),
('manageSettings', 2, 'Manage settings', NULL, NULL, 1502387436, 1502387436),
('manageStaffs', 2, 'Manage staffs', NULL, NULL, 1502387436, 1502387436),
('manageUsers', 2, 'Manage users', NULL, NULL, 1502387436, 1502387436),
('staff', 1, 'Staff', NULL, NULL, 1502387436, 1502387436),
('user', 1, 'User', NULL, NULL, 1502387436, 1502387436);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1502387123),
('m140506_102106_rbac_init', 1502387129),
('m170125_081951_create_setting_table', 1502387435),
('m170125_082006_create_user_table', 1502387436),
('m170506_004517_init_rbac', 1502387437);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_name` varchar(255) DEFAULT NULL,
  `meta_type` varchar(50) DEFAULT NULL,
  `meta_desc` text,
  `meta_attribute` text,
  `meta_value` longtext,
  `is_public` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx-setting` (`meta_key`,`meta_type`,`is_public`,`status`,`created_at`,`updated_at`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `meta_key`, `meta_name`, `meta_type`, `meta_desc`, `meta_attribute`, `meta_value`, `is_public`, `status`, `created_at`, `updated_at`) VALUES
(1, 'timezone', 'Timezone', 'select', 'Set the time zone of the application', '{"list":[{"value":"Australia/Adelaide","label":"Australia/Adelaide"},{"value":"Australia/Brisbane","label":"Australia/Brisbane"},{"value":"Australia/Canberra","label":"Australia/Canberra"},{"value":"Australia/Hobart","label":"Australia/Hobart"},{"value":"Australia/Melbourne","label":"Australia/Melbourne"},{"value":"Australia/Perth","label":"Australia/Perth"},{"value":"Australia/Sydney","label":"Australia/Sydney"}]}', 'Australia/Melbourne', 1, 1, '2017-08-10 17:50:35', '2017-08-10 17:50:35'),
(2, 'test_setting1', 'Test Setting1', 'number', 'Test Setting Description', '', '15', 1, 1, '2017-08-10 17:50:35', '2017-08-10 17:50:35'),
(3, 'test_setting2', 'Test Setting2', 'text', 'Test Setting Description', '', 'value', 1, 1, '2017-08-10 17:50:35', '2017-08-10 17:50:35');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) DEFAULT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `access_token_expired_at` timestamp NULL DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `unconfirmed_email` varchar(255) DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `registration_ip` varchar(20) DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(20) DEFAULT NULL,
  `blocked_at` timestamp NULL DEFAULT NULL,
  `status` int(2) DEFAULT '10',
  `role` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx-user` (`username`,`auth_key`,`password_hash`,`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `access_token_expired_at`, `password_hash`, `password_reset_token`, `email`, `unconfirmed_email`, `confirmed_at`, `registration_ip`, `last_login_at`, `last_login_ip`, `blocked_at`, `status`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'dVN8fzR_KzJ_lBrymfXI6qyH2QzyXYUU', '2018-04-19 22:10:48', '$2y$13$9Gouh1ZbewVEh4bQIGsifOs8/RWW/7RIs0CAGNd7tapXFm9.WxiXS', NULL, 'admin@demo.com', 'admin@demo.com', '2017-05-05 19:38:48', '127.0.0.1', '2018-04-18 19:10:48', '127.0.0.1', NULL, 10, 99, '2017-05-05 19:38:03', '2018-04-18 22:10:47'),
(2, 'staff', 'Xm-zZRREtAIKsFlINVRLSw3U7llbx_5a', '2017-05-30 23:30:31', '$2y$13$TKh5pEy0RFTmkC9Kjvb9A.WR/I1QVzYHdfYDw0m7MnHnN0bsv96Jq', NULL, 'staff@demo.com', 'staff@demo.com', '2017-05-15 12:20:53', '127.0.0.1', '2017-05-29 23:30:31', '127.0.0.1', NULL, 10, 50, '2017-05-15 12:19:02', '2017-05-29 23:30:29'),
(3, 'user', 'rNXSqIas_43RdpG0e5_7d1W06iK8pXJ8', '2017-06-04 03:13:02', '$2y$13$nd/F3g6jjIa1/Sk6JZxZ5uVq0OpsbOmW1OdnbDG6BpFqgkFbQotjm', NULL, 'user@demo.com', 'user@demo.com', '2017-06-03 03:12:16', '127.0.0.1', '2017-06-03 03:13:02', '127.0.0.1', NULL, 10, 10, '2017-05-22 02:31:53', '2017-06-03 16:34:52'),
(4, 'rotordyn', 'EPTNMrg3lwO-r9wT_3DUHXPZR51s2EAm', '2018-04-19 22:18:51', '$2y$13$8kEVAkZZSFFaQuqhtEFgHeS52lkYmRUX5907wFk5eZyIkyJg/7ksG', NULL, 'auto@rotordyn.com.br', 'auto@rotordyn.com.br', '2018-04-18 19:14:00', '127.0.0.1', '2018-04-18 19:18:51', '127.0.0.1', NULL, 10, 50, '2018-04-18 22:14:24', '2018-04-18 22:18:51');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
