-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 22, 2017 at 11:21 AM
-- Server version: 5.6.35
-- PHP Version: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `m5`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('Admin', '7', 1470714995),
('Author', '6', 1470715026);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('Admin', 1, NULL, NULL, NULL, 1470714995, 1470714995),
('Author', 1, NULL, NULL, NULL, 1470714995, 1470714995),
('Editer', 1, NULL, NULL, NULL, 1470714995, 1470714995),
('manageAll', 2, 'Quản lý tất cả', NULL, NULL, 1470714995, 1470714995),
('managePost', 2, 'Tạo và chỉnh sửa bài viết', NULL, NULL, 1470714995, 1470714995),
('manageUser', 2, 'Chỉnh sửa và tạo người dùng', NULL, NULL, 1470714995, 1470714995);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('Admin', 'Author'),
('Editer', 'Author'),
('Admin', 'Editer'),
('Admin', 'manageAll'),
('Admin', 'managePost'),
('Author', 'managePost'),
('Editer', 'managePost'),
('Admin', 'manageUser'),
('Editer', 'manageUser');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `parent_id`, `title`, `description`, `slug`, `type`, `status`) VALUES
(21, 0, 'Thông báo từ hệ thống', '', 'thong-bao-tu-he-thong', 'posts', 1),
(22, 0, 'Điều khoản hệ thống', '', 'dieu-khoan-he-thong', 'posts', 1),
(23, 0, ' Hướng dẫn sử dụng', '', 'huong-dan-su-dung', 'posts', 1),
(24, 0, 'Hỏi đáp', '', 'hoi-dap', 'posts', 1);

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `name`, `value`) VALUES
(1, 'baseUrl', 'http://haiduong.top'),
(2, 'nameApp', 'Hệ thống M5'),
(4, 'm5_run', '0'),
(5, 'm5_roses_direct', '5'),
(6, 'm5_roses_sytem_1', '1'),
(7, 'm5_roses_sytem_2', '2'),
(8, 'm5_roses_sytem_3', '3'),
(9, 'm5_roses_sytem_4', '4'),
(10, 'm5_roses_sytem_5', '5'),
(11, 'type_add_time', 'min'),
(12, 'm5_cycle_min', '2'),
(13, 'm5_cycle_max', '10'),
(14, 'm5_cycle_count_day', '1440'),
(15, 'm5_money_pin', '10'),
(16, 'm5_price', '3000000'),
(17, 'm5_precent', '3'),
(18, 'm5_time_pending_transaction', '5'),
(19, 'm5_time_action_transaction', '5'),
(20, 'm5_count_pd', '2'),
(21, 'send_mail', '1'),
(22, 'm5_time_pending_transaction_gd', '5');

-- --------------------------------------------------------

--
-- Table structure for table `cron`
--

DROP TABLE IF EXISTS `cron`;
CREATE TABLE IF NOT EXISTS `cron` (
  `id` int(11) NOT NULL,
  `min` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_end` datetime DEFAULT NULL,
  `hour` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `day` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `month` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `command` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cron_job`
--

DROP TABLE IF EXISTS `cron_job`;
CREATE TABLE IF NOT EXISTS `cron_job` (
  `id` int(11) NOT NULL,
  `cron_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `table_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `date_end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cycle`
--

DROP TABLE IF EXISTS `cycle`;
CREATE TABLE IF NOT EXISTS `cycle` (
  `id` int(11) NOT NULL,
  `cronjob_id` int(11) NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  `count_day` int(11) NOT NULL,
  `date_begin` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_end` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

DROP TABLE IF EXISTS `level`;
CREATE TABLE IF NOT EXISTS `level` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `money` int(11) NOT NULL,
  `percent` int(11) NOT NULL,
  `condition` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `count_roses` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `name`, `content`, `money`, `percent`, `condition`, `type`, `count_roses`) VALUES
(1, 'M1', '', 600, 1, 0, '0', 5),
(2, 'M2', 'M1', 800, 2, 1, '1', 6),
(3, 'M3', '', 1000, 3, 1, '3', 7),
(4, 'M4', '', 1000, 3, 1, '4', 8),
(5, 'M5', '', 1000, 3, 1, '5', 8);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `member_action` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `table_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_view` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m5`
--

DROP TABLE IF EXISTS `m5`;
CREATE TABLE IF NOT EXISTS `m5` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `cronjob_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `cycle_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` double NOT NULL,
  `money_current` double NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  `viewed` int(11) NOT NULL,
  `pending` int(11) NOT NULL,
  `date_pending` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m5_map`
--

DROP TABLE IF EXISTS `m5_map`;
CREATE TABLE IF NOT EXISTS `m5_map` (
  `id` int(11) NOT NULL,
  `m5_give_id` int(11) NOT NULL,
  `m5_take_id` int(11) NOT NULL,
  `cronjob_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `member_action` int(11) NOT NULL,
  `money` double NOT NULL,
  `status` int(11) NOT NULL,
  `result` int(11) NOT NULL,
  `viewed` int(11) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_end` datetime DEFAULT NULL,
  `date_status` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `mobile` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `count_role` int(11) NOT NULL,
  `key_member` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `level_id` int(11) NOT NULL DEFAULT '1',
  `bank_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_agency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `card_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money_roses` double NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birth_day` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `count_m5` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `username`, `display_name`, `parent_id`, `mobile`, `password`, `password_hash`, `password_reset_token`, `email`, `auth_key`, `created_at`, `updated_at`, `status`, `role_id`, `count_role`, `key_member`, `level_id`, `bank_code`, `bank_name`, `bank_agency`, `card_id`, `money_roses`, `gender`, `avatar`, `birth_day`, `count_m5`) VALUES
(1, 'gnoudneyuh', 'Gnoudneyuh', 0, '0982227881', '123456', '$2y$13$cLekxQt9IhLzGsr.K2DSaejNhlEoKRZP.uE5OCHOBdaVxf/PRbTG2', 'uQodjl5xsdAK5QnkvxT3qk8-BhCTPmuT_1484475016', 'Gnoudneyuh@gmail.com', '', '2017-03-22 04:20:45', '0000-00-00 00:00:00', 5, 2, 2, 'n6FFj', 1, '1928398437', 'Công thương', 'Hà Nội', '123445', 0, '', '', '01/19/2017', 1),
(2, 'Neyuhgnoud', 'Neyuhgnoud', 0, '132456', '123456', '$2y$13$h4kYbl/Ko4/UaPopqt30.ebdv5BDRgTh8ExPTUKjRdd86Jsb/L0l6', '', 'Neyuhgnoud@gmail.com', '', '2017-03-22 04:21:06', '0000-00-00 00:00:00', 5, 2, 2, 'gh4WK', 1, '1a2344', 'Công thương', 'Hà Nội', 'a123345', 0, '', '', '', 1),
(3, 'Neyuhgnoud1', 'Neyuhgnoud1', 0, '02983', '123456', '$2y$13$N0iBqPh11x0MwZRsIKpAaefXIQu/DnOs/ynVI1OahNqfN2X4vAlgq', '', 'Neyuhgnoud1@gmail.com', '', '2017-03-22 03:56:19', '0000-00-00 00:00:00', 5, 0, 0, 'hoTth', 1, '9849819381', 'Ngoại Thương', 'Hà Nội', '038o81eo', 0, '', '', '', 1),
(4, 'Gnoudneyuh1', 'Gnoudneyuh1', 0, '092983984', '123456', '$2y$13$Asrbwq/drSDePZglXdPNy.PBnORjvnkTRMT9RqCwrztQLJrdhhpQa', '', 'Gnoudneyuh1@gmail.com', '', '2017-03-22 03:55:18', '0000-00-00 00:00:00', 5, 0, 0, 'HHJyp', 1, '938198138', 'Công thương', 'Hải Dương', '983938198398', 0, '', '', '', 1),
(5, 'thele', 'Thế Lê', 0, '0123456789', 'quangthe214', '$2y$13$u6b9PT.dOgO1mcEXu0bs0OsmjSwLCbmp/AobhgfHilzMe2VsU4Zz2', '', 'quangthe2104@gmail.com', '', '2017-03-22 03:53:23', '0000-00-00 00:00:00', 5, 0, 0, 'J2lXv', 1, '1234567890', 'Techcombank', 'Trần Thái Tông', '1234567890', 0, '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1468513964),
('m130524_201442_init', 1474388920),
('m140506_102106_rbac_init', 1468513970),
('m160920_153345_create_menu_table', 1474388957),
('m160921_145444_create_multi_level', 1474469884);

-- --------------------------------------------------------

--
-- Table structure for table `pin`
--

DROP TABLE IF EXISTS `pin`;
CREATE TABLE IF NOT EXISTS `pin` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=501 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pin`
--

INSERT INTO `pin` (`id`, `code`, `status`, `member_id`) VALUES
(1, 'HvFoYP', 1, 1),
(2, '6WE7gv', 1, 1),
(3, '5k8cBL', 1, 1),
(4, 'dn5ieT', 0, 1),
(5, 'JDDc8b', 0, 1),
(6, 'PAWfmm', 0, 1),
(7, 'ViadNH', 0, 1),
(8, 'JuPh6P', 0, 1),
(9, '2v2H9L', 0, 1),
(10, '4xJ6JK', 0, 1),
(11, 'i4bX3m', 0, 1),
(12, 'qvYd9E', 0, 1),
(13, 'qvYAMP', 0, 1),
(14, 'PrCqdl', 0, 1),
(15, '55Cpp2', 0, 1),
(16, 'LzgBmd', 0, 1),
(17, 'iTLMRK', 0, 1),
(18, 't7XbDA', 0, 1),
(19, 'DE75Eh', 0, 1),
(20, 'JBynzg', 0, 1),
(21, '5ulJFp', 0, 1),
(22, 'Duy4xY', 0, 1),
(23, 'fn4kD5', 0, 1),
(24, 'KYKYPK', 0, 1),
(25, 'ezWMq7', 0, 1),
(26, 'AFwwua', 0, 1),
(27, 'cTnCiH', 0, 1),
(28, 'YE8C22', 0, 1),
(29, 'fjmB93', 0, 1),
(30, 'wlH8qf', 0, 1),
(31, '8mW9Yo', 0, 1),
(32, 'AAFY3u', 0, 1),
(33, 'NJVs87', 0, 1),
(34, 'nNiTNi', 0, 1),
(35, 'aRLwEw', 0, 1),
(36, 'L42N7v', 0, 1),
(37, '97yyof', 0, 1),
(38, '9jT3Nc', 0, 1),
(39, 'vBlsm3', 0, 1),
(40, 'hevBMC', 0, 1),
(41, 'jMbpz9', 0, 1),
(42, 'sL5Dgk', 0, 1),
(43, 'poxMyN', 0, 1),
(44, 'BiCPvX', 0, 1),
(45, 'bqcuvN', 0, 1),
(46, 'qFH3Vk', 0, 1),
(47, 'maCVyK', 0, 1),
(48, '5tbxgX', 0, 1),
(49, '9YlrKe', 0, 1),
(50, 'zkuMME', 0, 1),
(51, 'xCFzFj', 0, 1),
(52, 'HJnggC', 0, 1),
(53, '58nccm', 0, 1),
(54, '7tKMRC', 0, 1),
(55, '3ZRAKt', 0, 1),
(56, 'eXl38H', 0, 1),
(57, 'ZiPCVv', 0, 1),
(58, '2Lcet5', 0, 1),
(59, 'vBkb9i', 0, 1),
(60, 'MAETAY', 0, 1),
(61, 'mbr8Dt', 0, 1),
(62, 'uR7Tzw', 0, 1),
(63, 'REgxao', 0, 1),
(64, 'nlpxwm', 0, 1),
(65, 'ThiJnm', 0, 1),
(66, '3y4HM5', 0, 1),
(67, '3HrNj6', 0, 1),
(68, 'B7LnCa', 0, 1),
(69, 'LVMvRm', 0, 1),
(70, 'ldPfq8', 0, 1),
(71, 'kwCcf4', 0, 1),
(72, 'V37MJL', 0, 1),
(73, 'e8jYnj', 0, 1),
(74, 'omgzF5', 0, 1),
(75, '78ta35', 0, 1),
(76, 'ZNMydE', 0, 1),
(77, 'iLFXih', 0, 1),
(78, 'BNVMp6', 0, 1),
(79, 'nm9P7z', 0, 1),
(80, 'Cfc5v7', 0, 1),
(81, 'rJHNxH', 0, 1),
(82, 'rgDxz4', 0, 1),
(83, 'NfPA94', 0, 1),
(84, 'CWMh4y', 0, 1),
(85, 'FRH5ER', 0, 1),
(86, 'LR99zk', 0, 1),
(87, 'YWTueF', 0, 1),
(88, 'kMKmgk', 0, 1),
(89, '5D9eDP', 0, 1),
(90, 'jA8ury', 0, 1),
(91, 'lBocwV', 0, 1),
(92, '4ssxxr', 0, 1),
(93, 'nT5rEp', 0, 1),
(94, 'Rd4dYs', 0, 1),
(95, 'TEMYzZ', 0, 1),
(96, 'aF4zXM', 0, 1),
(97, 'v7wgpw', 0, 1),
(98, 'cRBYs4', 0, 1),
(99, 'nCKm5g', 0, 1),
(100, 'oH4PBo', 0, 1),
(101, 'XY2EBz', 1, 2),
(102, '7YN45c', 1, 2),
(103, '7ozknC', 1, 2),
(104, 'e75joM', 0, 2),
(105, 'zKW6hF', 0, 2),
(106, 'rKxAyk', 0, 2),
(107, 'FifCeP', 0, 2),
(108, 'jzDcpc', 0, 2),
(109, 'dd5jrb', 0, 2),
(110, 'F52ogc', 0, 2),
(111, '2Hcnfm', 0, 2),
(112, 'Hlpoti', 0, 2),
(113, 'v6aLgs', 0, 2),
(114, 'YBEnld', 0, 2),
(115, 'Dwv9Da', 0, 2),
(116, 'ju8973', 0, 2),
(117, 'B6b9Hl', 0, 2),
(118, '9obnar', 0, 2),
(119, 'wfZc4K', 0, 2),
(120, 'tX5EoA', 0, 2),
(121, 'fussdY', 0, 2),
(122, 'CNgNAY', 0, 2),
(123, 'FwFARV', 0, 2),
(124, '6kVnRJ', 0, 2),
(125, 'vvNYPZ', 0, 2),
(126, 'tCpsvC', 0, 2),
(127, 'uHl2it', 0, 2),
(128, 'zKqYZL', 0, 2),
(129, 'sYWp3i', 0, 2),
(130, 'kFKxPo', 0, 2),
(131, 'iAH4ya', 0, 2),
(132, '8RwKbw', 0, 2),
(133, '6Bs8qX', 0, 2),
(134, 'n7Cl5F', 0, 2),
(135, 'ozT4ET', 0, 2),
(136, 'anX7RB', 0, 2),
(137, 'xWgT35', 0, 2),
(138, '9kTfFs', 0, 2),
(139, 'w8autz', 0, 2),
(140, 'J8bP6F', 0, 2),
(141, 'Ec4cmX', 0, 2),
(142, 'y6Xpz2', 0, 2),
(143, '3MVYx6', 0, 2),
(144, 'ZLFYZW', 0, 2),
(145, '4xEhtn', 0, 2),
(146, 'iNH24v', 0, 2),
(147, 'C5Kaf8', 0, 2),
(148, 'eZRnxn', 0, 2),
(149, 'aaNF4c', 0, 2),
(150, 'gbu4si', 0, 2),
(151, 'YBabDK', 0, 2),
(152, 'rm3Hdv', 0, 2),
(153, 'eJ8XLE', 0, 2),
(154, 'echl9s', 0, 2),
(155, 'BAkZ37', 0, 2),
(156, 'kVxWJe', 0, 2),
(157, 'bTa6eP', 0, 2),
(158, 'ZbbFqH', 0, 2),
(159, 'rXumWm', 0, 2),
(160, 'VtKbFb', 0, 2),
(161, 'ck7Hnu', 0, 2),
(162, 'BLgJzX', 0, 2),
(163, '8LMzXN', 0, 2),
(164, 'ocht7r', 0, 2),
(165, 'bHDYN3', 0, 2),
(166, '3TtClD', 0, 2),
(167, 'aExjfa', 0, 2),
(168, 'CqWhwg', 0, 2),
(169, 'gF8rk8', 0, 2),
(170, '3qFVpE', 0, 2),
(171, 'oNXZkz', 0, 2),
(172, 'E4zalb', 0, 2),
(173, 'Fhifao', 0, 2),
(174, 'uZFuvP', 0, 2),
(175, 'qr6Hxt', 0, 2),
(176, 'pH3RLA', 0, 2),
(177, 'Mu2ePA', 0, 2),
(178, 'rKhtzF', 0, 2),
(179, 'LKuXLm', 0, 2),
(180, '6nNAKt', 0, 2),
(181, 'bvWK7N', 0, 2),
(182, 'piAgHB', 0, 2),
(183, 'LTneHB', 0, 2),
(184, 'q2NATH', 0, 2),
(185, '5ip2ex', 0, 2),
(186, 'PToEpm', 0, 2),
(187, '4bnawL', 0, 2),
(188, '8qYJEM', 0, 2),
(189, 'wk4sNV', 0, 2),
(190, 'HHnhix', 0, 2),
(191, 'jJwByg', 0, 2),
(192, 'PZ9tLH', 0, 2),
(193, 'LByoWy', 0, 2),
(194, 'igEiPl', 0, 2),
(195, 'h8wnme', 0, 2),
(196, 'lZN3lP', 0, 2),
(197, 'WuTHld', 0, 2),
(198, 'jNmfgh', 0, 2),
(199, 'MXVFrz', 0, 2),
(200, '3NWDLt', 0, 2),
(201, 'hEdZDx', 1, 3),
(202, 'temuMR', 1, 3),
(203, '2pnHB4', 1, 3),
(204, 'zErN3s', 0, 3),
(205, 'Zvc8bh', 0, 3),
(206, 'uevLDJ', 0, 3),
(207, 'LEELt7', 0, 3),
(208, 'mNcgon', 0, 3),
(209, 'BXFtfm', 0, 3),
(210, 'AHAHpg', 0, 3),
(211, 'Earzrb', 0, 3),
(212, '56KBe2', 0, 3),
(213, 'JtlnTk', 0, 3),
(214, '9E5yvN', 0, 3),
(215, 'hcuWtT', 0, 3),
(216, 'CkZ6cC', 0, 3),
(217, 'CM3THv', 0, 3),
(218, 'yYZVjB', 0, 3),
(219, 'tx5VVX', 0, 3),
(220, 'FKJxk6', 0, 3),
(221, 'fT6euE', 0, 3),
(222, '293iWw', 0, 3),
(223, 'f8vRer', 0, 3),
(224, 'lWanaZ', 0, 3),
(225, 'tD7wsW', 0, 3),
(226, '8L9VEn', 0, 3),
(227, 'maRbAJ', 0, 3),
(228, 'R2j6s5', 0, 3),
(229, 'uNDJ5r', 0, 3),
(230, 'VoXT94', 0, 3),
(231, 'ulXyyZ', 0, 3),
(232, 'ZkJeb7', 0, 3),
(233, 'hhHNPZ', 0, 3),
(234, 'ZbADPW', 0, 3),
(235, 'jeZHnp', 0, 3),
(236, 'v2hLwK', 0, 3),
(237, 'LAB2l8', 0, 3),
(238, 'nEkNNT', 0, 3),
(239, 'j4H5FX', 0, 3),
(240, 'g6VfRM', 0, 3),
(241, 'fkgBDu', 0, 3),
(242, 'smZqeD', 0, 3),
(243, 'yqLjAc', 0, 3),
(244, 'AT79oT', 0, 3),
(245, 'A65BtD', 0, 3),
(246, 'diehqJ', 0, 3),
(247, 'CspTAe', 0, 3),
(248, 'aPdR6R', 0, 3),
(249, 'wmt2rA', 0, 3),
(250, 'dhghVY', 0, 3),
(251, 'iYHVl9', 0, 3),
(252, '3DeXtm', 0, 3),
(253, '49oAru', 0, 3),
(254, 'h8iE95', 0, 3),
(255, '4lo9nJ', 0, 3),
(256, 'kp5oy6', 0, 3),
(257, 'EtyJM4', 0, 3),
(258, '7vfP5W', 0, 3),
(259, 'qoltJx', 0, 3),
(260, 'ERnt2X', 0, 3),
(261, '2zc5fX', 0, 3),
(262, 'gE9TMu', 0, 3),
(263, 'Fj9RvT', 0, 3),
(264, '9wAty8', 0, 3),
(265, '29J78L', 0, 3),
(266, 'gXCAXv', 0, 3),
(267, 'J9TEX5', 0, 3),
(268, 'L2lhVd', 0, 3),
(269, 'uhPDPc', 0, 3),
(270, '9EFkAb', 0, 3),
(271, 'i4NJHK', 0, 3),
(272, 'LhsRjh', 0, 3),
(273, 'zbjehH', 0, 3),
(274, 'txyZ94', 0, 3),
(275, '8n4Pb6', 0, 3),
(276, 'Rhmd4X', 0, 3),
(277, 'sulfH7', 0, 3),
(278, 'nma7Hq', 0, 3),
(279, '47NKjq', 0, 3),
(280, '3gWoln', 0, 3),
(281, 'HXHdWt', 0, 3),
(282, 'D4tlcT', 0, 3),
(283, 'c69vsg', 0, 3),
(284, 'xll38F', 0, 3),
(285, 'cdLzBW', 0, 3),
(286, 'NH8nF8', 0, 3),
(287, 'qTRpou', 0, 3),
(288, 'uvoyaV', 0, 3),
(289, '37cygv', 0, 3),
(290, 'LHs4vs', 0, 3),
(291, 'qjMV7E', 0, 3),
(292, 't4yD2p', 0, 3),
(293, 'KFN2MX', 0, 3),
(294, 'xReRAl', 0, 3),
(295, 'VdPcRl', 0, 3),
(296, 'JHBrY5', 0, 3),
(297, '9ErK5K', 0, 3),
(298, '4gVHPN', 0, 3),
(299, '84xiMv', 0, 3),
(300, 'eVCJlP', 0, 3),
(301, 'Ncphvs', 1, 4),
(302, 'EHMTF7', 1, 4),
(303, 'L3pWj3', 1, 4),
(304, 'x9ym2P', 0, 4),
(305, 'f2BJPP', 0, 4),
(306, 'HXu6rT', 0, 4),
(307, '23cjYe', 0, 4),
(308, 'YhnJCg', 0, 4),
(309, 'MNtkTT', 0, 4),
(310, '3Ahilg', 0, 4),
(311, 'xtEMwR', 0, 4),
(312, 'f6EfMN', 0, 4),
(313, 'ptYh6i', 0, 4),
(314, 'VhrcqR', 0, 4),
(315, 'H9csvn', 0, 4),
(316, 'fxB52X', 0, 4),
(317, 'C36wcu', 0, 4),
(318, 'HEDadh', 0, 4),
(319, 'KxWNkX', 0, 4),
(320, '4NF7rt', 0, 4),
(321, 'cHgp7T', 0, 4),
(322, 'kTBCLZ', 0, 4),
(323, 'rNmmse', 0, 4),
(324, 'yemmpE', 0, 4),
(325, 'hAfZ8Z', 0, 4),
(326, '5l2mm9', 0, 4),
(327, '4Chd6Y', 0, 4),
(328, 'jevrVZ', 0, 4),
(329, 'jHn4TH', 0, 4),
(330, 'CaqnDV', 0, 4),
(331, 'mrlf5j', 0, 4),
(332, 'TW88Ck', 0, 4),
(333, 'ElVyCC', 0, 4),
(334, 'Vwjtc7', 0, 4),
(335, 'WAbeCT', 0, 4),
(336, 'unlsa6', 0, 4),
(337, 'cc8TkC', 0, 4),
(338, 'o4PHJa', 0, 4),
(339, 'KZ4DLP', 0, 4),
(340, 'pJ87yX', 0, 4),
(341, 'fYpmNN', 0, 4),
(342, '4A8lXe', 0, 4),
(343, 'hzZ4Np', 0, 4),
(344, 'gtfjv7', 0, 4),
(345, 'maaMmi', 0, 4),
(346, 'E68kJR', 0, 4),
(347, 'e48nR5', 0, 4),
(348, 'q8lHTN', 0, 4),
(349, '9o3VVP', 0, 4),
(350, 'NHoyZN', 0, 4),
(351, 'DhlV4D', 0, 4),
(352, 'hbtaZN', 0, 4),
(353, 'Dkqd7K', 0, 4),
(354, 'snfysj', 0, 4),
(355, '77hKrX', 0, 4),
(356, 'dxTLMz', 0, 4),
(357, 'nu299j', 0, 4),
(358, 'HEkwDe', 0, 4),
(359, 'uykcrE', 0, 4),
(360, '8HcD9Z', 0, 4),
(361, 'Fa2FyB', 0, 4),
(362, 'iWERXV', 0, 4),
(363, 'kk4Vqu', 0, 4),
(364, 'r3lKiq', 0, 4),
(365, 'dbhnkh', 0, 4),
(366, 'Rx3ufx', 0, 4),
(367, 'ywgVx7', 0, 4),
(368, 'WHMxRq', 0, 4),
(369, 'JEdZYB', 0, 4),
(370, 'bk4YlN', 0, 4),
(371, 'Th4PPH', 0, 4),
(372, 'XWsiHA', 0, 4),
(373, 'TFnyls', 0, 4),
(374, 'HHH9cT', 0, 4),
(375, 'DrmWbe', 0, 4),
(376, 'f9ogFN', 0, 4),
(377, 'vcDxCk', 0, 4),
(378, 'mF7Rqn', 0, 4),
(379, '4poduN', 0, 4),
(380, 'T2YP7f', 0, 4),
(381, 'ZnnutM', 0, 4),
(382, 'rafr8d', 0, 4),
(383, 'rnLp4u', 0, 4),
(384, 'Dpm94g', 0, 4),
(385, '4mrLvH', 0, 4),
(386, 'XeCMt7', 0, 4),
(387, 'upniZa', 0, 4),
(388, '7F2wfv', 0, 4),
(389, 'T36nkb', 0, 4),
(390, 'MCEbZZ', 0, 4),
(391, 'uVT42L', 0, 4),
(392, 'VsxuNM', 0, 4),
(393, 'DaCxoE', 0, 4),
(394, 'r2zNpT', 0, 4),
(395, 'jHkzpy', 0, 4),
(396, 'Z7s7dT', 0, 4),
(397, 'TBtfxv', 0, 4),
(398, 'yHx8zr', 0, 4),
(399, 'es7sNL', 0, 4),
(400, 'JhkKra', 0, 4),
(401, 'FCfsJJ', 0, 5),
(402, 'g9wTBf', 0, 5),
(403, 'J6b3NZ', 0, 5),
(404, 'fP5aRd', 0, 5),
(405, 'XkNcPH', 0, 5),
(406, '7oef2V', 0, 5),
(407, '6opKLP', 0, 5),
(408, 'j2c3bt', 0, 5),
(409, 'b75bJX', 0, 5),
(410, '7apwiM', 0, 5),
(411, 'mYysEP', 0, 5),
(412, 'djcjCb', 0, 5),
(413, 'zHrRKq', 0, 5),
(414, '5bWFHj', 0, 5),
(415, 'Jzej8F', 0, 5),
(416, 'MDZxYJ', 0, 5),
(417, 'zymwfx', 0, 5),
(418, 'thAvFK', 0, 5),
(419, 'mNFN8K', 0, 5),
(420, 'Bd87a3', 0, 5),
(421, 'eZVvaM', 0, 5),
(422, 'bHTcBt', 0, 5),
(423, 'DXX3MM', 0, 5),
(424, 'TFAjak', 0, 5),
(425, '9XWrkZ', 0, 5),
(426, 'JJ4gRD', 0, 5),
(427, 'jZ95WA', 0, 5),
(428, '7Kukjc', 0, 5),
(429, 'LWVxTy', 0, 5),
(430, 'n9eb7B', 0, 5),
(431, 'BEvFji', 0, 5),
(432, 'RhBg3D', 0, 5),
(433, 'cnKKrH', 0, 5),
(434, 'w94odb', 0, 5),
(435, 'uHpmTn', 0, 5),
(436, 'zTRosb', 0, 5),
(437, 'x22Tfm', 0, 5),
(438, 'xsqfb4', 0, 5),
(439, 'CB22Bg', 0, 5),
(440, 'zDAedp', 0, 5),
(441, 'dZYlCa', 0, 5),
(442, 'zVwue7', 0, 5),
(443, 'Cqnkk6', 0, 5),
(444, 'BD8rbZ', 0, 5),
(445, 'ENs2Fp', 0, 5),
(446, 'm6KYX7', 0, 5),
(447, 'Hv29Ys', 0, 5),
(448, 'Tn8Nwd', 0, 5),
(449, '8ZwXmb', 0, 5),
(450, 't9DMEu', 0, 5),
(451, 'e29PdZ', 0, 5),
(452, 'wRo5zx', 0, 5),
(453, '3jdnyc', 0, 5),
(454, 'zMahBX', 0, 5),
(455, 'E63mRK', 0, 5),
(456, 'CzKz4w', 0, 5),
(457, 'ekj9wd', 0, 5),
(458, 'dhXLq3', 0, 5),
(459, 'Dmmgze', 0, 5),
(460, 'uuzY26', 0, 5),
(461, 'DpWju4', 0, 5),
(462, '4Nj9yu', 0, 5),
(463, 'WhrEer', 0, 5),
(464, 'qvyYuT', 0, 5),
(465, 'NgTNM9', 0, 5),
(466, '85Zueg', 0, 5),
(467, 'Nx8Ewx', 0, 5),
(468, 'bK69Dn', 0, 5),
(469, 'mrc4Xf', 0, 5),
(470, '7ElmHb', 0, 5),
(471, 'Daj8i7', 0, 5),
(472, 'u2B9w3', 0, 5),
(473, 'RHYPuv', 0, 5),
(474, 'rLa9WY', 0, 5),
(475, 'wmk8dc', 0, 5),
(476, 'iBFoBp', 0, 5),
(477, 'o79xH7', 0, 5),
(478, 'lLP6VT', 0, 5),
(479, 'ilXnhM', 0, 5),
(480, 'WyND4y', 0, 5),
(481, 'DfFAlh', 0, 5),
(482, 'zZl7Nn', 0, 5),
(483, 'wdpEPL', 0, 5),
(484, 'Fcjwfi', 0, 5),
(485, '5wXYdB', 0, 5),
(486, 'qKYzCw', 0, 5),
(487, '8xcHKw', 0, 5),
(488, 'MzPnER', 0, 5),
(489, 'sPMKMA', 0, 5),
(490, 'img7LZ', 0, 5),
(491, '2MupKn', 0, 5),
(492, 'qenWxo', 0, 5),
(493, 'W9ptfB', 0, 5),
(494, '5tbMYp', 0, 5),
(495, 'T42Hxt', 0, 5),
(496, 'aFJYzL', 0, 5),
(497, 'KrnbYd', 0, 5),
(498, 'aNN8Dl', 0, 5),
(499, 'zFBoAL', 0, 5),
(500, 'dVEZLL', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `title`, `description`, `status`, `views`, `create_at`, `update_at`, `slug`, `type`) VALUES
(2, 7, '2', '<p>2</p>\r\n', '5', 0, '2016-11-13 15:59:23', '0000-00-00 00:00:00', '2', 'page'),
(5, 7, 'Cách chơi m5?', '<p><span style="color:rgb(68, 68, 68); font-family:droid sans,arial,sans-serif; font-size:14px">M5 l&agrave; một tr&ograve; chơi. M&agrave; tr&ograve; chơi th&igrave; trời cho như thế n&agrave;o nhận như thế. Đừng bao giờ c&oacute; tư tưởng l&agrave;m gi&agrave;u một c&aacute;ch với vẩn. V&igrave; c&aacute;i g&igrave; cũng c&oacute; c&aacute;i gi&aacute; của n&oacute;. Kh&ocirc;ng ai cho kh&ocirc;ng ai điều g&igrave;. Chỉ trừ mấy ku so&aacute;i ca chấp nhận cho con g&aacute;i n&oacute; ph&aacute; đời trai rồi n&oacute; bỏ l&agrave; miễn ph&iacute; m&agrave; th&ocirc;i.</span><br />\r\n<span style="color:rgb(68, 68, 68); font-family:droid sans,arial,sans-serif; font-size:14px">Trong đầu bạn phải lu&ocirc;n nhớ muốn l&agrave;m gi&agrave;u th&igrave; phải đi l&ecirc;n từ năng lực bản th&acirc;n. V&agrave; lu&ocirc;n theo phương ch&acirc;m &quot;Thi&ecirc;n thời, địa lợi, nh&acirc;n h&ograve;a.&quot;</span></p>\r\n', '5', 0, '2017-01-20 10:28:20', '0000-00-00 00:00:00', 'cach-choi-m5', 'post'),
(6, 7, 'Hệ thống M5 là gì?', '<p><span style="color:rgb(0, 0, 0); font-family:roboto,helvetica neue,sans-serif; font-size:16px">Dựa tr&ecirc;n nguy&ecirc; l&yacute; m&ocirc; h&igrave;nh Ponzi, hệ thống M5 hoạt động tại Việt Nam tấm c&aacute;ch đ&acirc;y 2 năm v&agrave; đang thu h&uacute;t rất rất nhiều người tham hệ thống M5 n&agrave;y. N&oacute; hoạt động dựa tr&ecirc;n 1 hệ thống tự động gọi l&agrave; Vphp.biz, Vphp.biz thực ra l&agrave; một phần mềm m&agrave; th&ocirc;i. Hệ thống M5 hoạt động tự động tr&ecirc;n hệ thống Vphp.biz n&ecirc;n kh&ocirc;ng cần người đứng đầu, tuy nhi&ecirc;n phải c&oacute; 1 đội ngũ admin quản l&yacute; để đảm bảo giao dịch c&ocirc;ng bằng cho tất cả c&aacute;c th&agrave;nh vi&ecirc;n, đồng thời tăng uy t&iacute;n của hệ thống M5, l&agrave;m cho n&oacute; tồn tại l&acirc;u nhất c&oacute; thể.</span></p>\r\n', '5', 0, '2017-01-20 10:29:55', '0000-00-00 00:00:00', 'he-thong-m5-la-gi', 'post'),
(7, 7, 'Ưu điểm của hệ thống M5 là gì?', '<p><strong>&quot;Lợi nhuận si&ecirc;u khủng&quot;</strong><span style="color:rgb(0, 0, 0); font-family:roboto,helvetica neue,sans-serif; font-size:16px">&nbsp;l&agrave; từ n&oacute;i về ưu điểm của hệ thống M5, bạn chỉ việc thực hiện c&aacute;c lệnh chuyển khoản cho (PH) v&agrave; nhận (GH) theo hướng dẫn chi tiết của hệ thống, kh&ocirc;ng cần phải vắt &oacute;c suy nghĩ, SEO hay Marketing m&agrave; tiền vẫn đổ đều đều về tải khoản ng&acirc;n h&agrave;ng. Cứ&nbsp;</span><strong>&quot;đầu tư l&agrave; c&oacute; tiền</strong></p>\r\n', '5', 0, '2017-01-20 10:34:54', '0000-00-00 00:00:00', 'uu-diem-cua-he-thong-m5-la-gi', 'post'),
(8, 7, 'Vòng quay một bắt đầu', '<p>Hệ thống game bắt đầu chạy v&ograve;ng quay 1</p>\r\n', '5', 0, '2017-01-22 16:06:30', '0000-00-00 00:00:00', 'vong-quay-mot-bat-dau', 'post');

-- --------------------------------------------------------

--
-- Table structure for table `post_relationships`
--

DROP TABLE IF EXISTS `post_relationships`;
CREATE TABLE IF NOT EXISTS `post_relationships` (
  `post_id` int(11) NOT NULL,
  `post_table` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `table_id` int(11) NOT NULL,
  `table_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `post_relationships`
--

INSERT INTO `post_relationships` (`post_id`, `post_table`, `table_id`, `table_name`) VALUES
(5, 'posts', 6, 'tags'),
(5, 'posts', 24, 'category'),
(6, 'posts', 6, 'tags'),
(6, 'posts', 24, 'category'),
(7, 'posts', 6, 'tags'),
(7, 'posts', 24, 'category'),
(8, 'posts', 1, 'tags'),
(8, 'posts', 21, 'category');

-- --------------------------------------------------------

--
-- Table structure for table `punish`
--

DROP TABLE IF EXISTS `punish`;
CREATE TABLE IF NOT EXISTS `punish` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `table_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `count_give` int(11) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `punish`
--

INSERT INTO `punish` (`id`, `member_id`, `table_id`, `table_name`, `status`, `count_give`, `create_at`) VALUES
(1, 2, 2, 'm5_map', 0, 0, '2017-01-22 23:38:02'),
(2, 4, 3, 'm5_map', 0, 1, '2017-01-22 23:38:02'),
(3, 1, 4, 'm5_map', 0, 0, '2017-01-22 23:47:01'),
(4, 3, 2, 'cycle', 0, 1, '2017-01-23 23:25:02'),
(5, 4, 2, 'cycle', 1, 1, '2017-01-23 23:25:02'),
(6, 5, 2, 'cycle', 0, 1, '2017-01-23 23:25:02'),
(7, 3, 3, 'cycle', 1, 1, '2017-01-24 23:25:03'),
(8, 5, 3, 'cycle', 1, 1, '2017-01-24 23:25:03');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

DROP TABLE IF EXISTS `report`;
CREATE TABLE IF NOT EXISTS `report` (
  `id` int(11) NOT NULL,
  `m5map_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `result` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roses`
--

DROP TABLE IF EXISTS `roses`;
CREATE TABLE IF NOT EXISTS `roses` (
  `id` int(11) NOT NULL,
  `m5_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `money` double NOT NULL,
  `percent` double NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `title`, `description`) VALUES
(1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `taxonomy`
--

DROP TABLE IF EXISTS `taxonomy`;
CREATE TABLE IF NOT EXISTS `taxonomy` (
  `id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `table_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `taxonomy`
--

INSERT INTO `taxonomy` (`id`, `table_id`, `table_name`, `type`, `value`) VALUES
(5, 21, 'category', 'ICONCATEGORY', '<i class="fa fa-inbox"></i>'),
(6, 21, 'category', 'SLUG', 'thong-bao-tu-he-thong'),
(7, 21, 'category', 'SEOBAIVIET', '{"seo_title":"","seo_description":"","seo_keyword":"","fb_title":"","fb_description":""}'),
(9, 3, 'posts', 'SLUG', 'man-united-muon-ky-hop-dong-tron-doi-voi-ibrahimovic'),
(10, 22, 'category', 'ICONCATEGORY', '<i class="fa fa-envelope-o"></i>'),
(11, 22, 'category', 'SLUG', 'dieu-khoan-he-thong'),
(12, 22, 'category', 'SEOBAIVIET', '{"seo_title":"","seo_description":"","seo_keyword":"","fb_title":"","fb_description":""}'),
(13, 23, 'category', 'ICONCATEGORY', '<i class="fa fa-file-text-o"></i>'),
(14, 23, 'category', 'SLUG', 'huong-dan-su-dung'),
(15, 23, 'category', 'SEOBAIVIET', '{"seo_title":"","seo_description":"","seo_keyword":"","fb_title":"","fb_description":""}'),
(16, 24, 'category', 'ICONCATEGORY', '<i class="fa fa-file-text-o"></i>'),
(17, 24, 'category', 'SLUG', 'hoi-dap'),
(18, 24, 'category', 'SEOBAIVIET', '{"seo_title":"","seo_description":"","seo_keyword":"","fb_title":"","fb_description":""}'),
(20, 5, 'posts', 'SEOBAIVIET', '{"seo_title":"","seo_description":"","seo_keyword":"","fb_title":"","fb_description":""}'),
(21, 6, 'posts', 'SEOBAIVIET', '{"seo_title":"","seo_description":"","seo_keyword":"","fb_title":"","fb_description":""}'),
(22, 7, 'posts', 'SEOBAIVIET', '{"seo_title":"","seo_description":"","seo_keyword":"","fb_title":"","fb_description":""}'),
(23, 8, 'posts', 'SEOBAIVIET', '{"seo_title":"","seo_description":"","seo_keyword":"","fb_title":"","fb_description":""}');

-- --------------------------------------------------------

--
-- Table structure for table `trangthai`
--

DROP TABLE IF EXISTS `trangthai`;
CREATE TABLE IF NOT EXISTS `trangthai` (
  `id` int(11) NOT NULL,
  `ten` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mo_ta` text COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(22) COLLATE utf8_unicode_ci NOT NULL,
  `thuoc_tinh` varchar(22) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `trangthai`
--

INSERT INTO `trangthai` (`id`, `ten`, `mo_ta`, `type`, `thuoc_tinh`) VALUES
(5, 'Công khai', '', 'status', ''),
(6, 'Bản nháp', '', 'status', ''),
(7, 'Thùng rác', '', 'filerindex', ''),
(8, 'Xóa', '', 'filerindex', ''),
(10, 'Tốp 1 trang chủ', '', 'postorder', ''),
(11, 'Mặc định', '', 'postorder', ''),
(13, 'Đông', '', 'huong', ''),
(17, 'Images', '', 'type_banner', 'images'),
(18, 'Top header', '', 'position_banner', 'top_header'),
(20, 'Trang hiện tại', '', 'open_new_tab', 'current_tab'),
(21, 'Mở trang mới', '', 'open_new_tab', 'open_tab'),
(22, 'Top right header', '', 'position_banner', 'top_header_left'),
(23, 'Logo footer', '', 'position_banner', 'right_footer'),
(24, 'Side bar left center', '', 'position_banner', 'sidebar_right_centrer'),
(25, 'Xóa', '', 'Users', '-1'),
(26, 'Không được nhận tiền', '', 'Users', 'role_id,1'),
(27, 'Ban người dùng', '', 'Users', 'status,2'),
(28, 'Xóa', '', 'Images', '-1'),
(29, 'Nhận tiền', '', 'Users', 'role_id,2'),
(30, 'Bán pin', '', 'Transactions', 'status,5'),
(31, 'Xóa', '', 'Transactions', 'status,-1');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `table_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `count` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `mobile`, `password`, `password_hash`, `password_reset_token`, `email`, `auth_key`, `created_at`, `updated_at`, `status`, `role_id`) VALUES
(6, 'anhntk54', '1', '1', '$2y$13$.doOnursjI45ON/o4yltQOF/I.7yfvapiYKUbuaFVc.LnAL4MpADi', '', '1', '', '2016-03-17 08:10:08', '0000-00-00 00:00:00', 1, 0),
(7, 'admin', '1', '123456', '$2y$13$tdTvwUG/CwDObkKbfreEG.qxURlrQhZ5lgG/UgYIKWWi4.4r0Qxvq', '', 'a@gmail.com', '', '2016-05-04 04:13:23', '0000-00-00 00:00:00', 1, 1),
(8, 'anhntk55', '21', '123456', '$2y$13$pHLaFbfAIC53Qb1mTsfW0us9OOnUBIMR9GGK56MbkPkI4o1tAP/jq', '', 'a@gmail.com', '', '2016-07-14 17:04:55', '0000-00-00 00:00:00', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron`
--
ALTER TABLE `cron`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_job`
--
ALTER TABLE `cron_job`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cycle`
--
ALTER TABLE `cycle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m5`
--
ALTER TABLE `m5`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m5_map`
--
ALTER TABLE `m5_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `pin`
--
ALTER TABLE `pin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_relationships`
--
ALTER TABLE `post_relationships`
  ADD PRIMARY KEY (`post_id`,`table_id`,`table_name`);

--
-- Indexes for table `punish`
--
ALTER TABLE `punish`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roses`
--
ALTER TABLE `roses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxonomy`
--
ALTER TABLE `taxonomy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trangthai`
--
ALTER TABLE `trangthai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `cron`
--
ALTER TABLE `cron`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cron_job`
--
ALTER TABLE `cron_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cycle`
--
ALTER TABLE `cycle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m5`
--
ALTER TABLE `m5`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m5_map`
--
ALTER TABLE `m5_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pin`
--
ALTER TABLE `pin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=501;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `punish`
--
ALTER TABLE `punish`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roses`
--
ALTER TABLE `roses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `taxonomy`
--
ALTER TABLE `taxonomy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `trangthai`
--
ALTER TABLE `trangthai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
