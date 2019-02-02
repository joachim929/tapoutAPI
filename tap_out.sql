-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2019 at 08:03 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tap_out`
--

-- --------------------------------------------------------

--
-- Table structure for table `event_category`
--

CREATE TABLE `event_category` (
  `id` int(11) NOT NULL,
  `en_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `vn_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` set('unique','weekly') COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `page_position` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `event_category`
--

INSERT INTO `event_category` (`id`, `en_name`, `vn_name`, `type`, `active`, `page_position`, `created_at`, `edited_at`) VALUES
(1, 'ENWeekly', '', 'weekly', 1, 1, '2018-10-14 08:44:30', NULL),
(2, 'VNUnique', '', 'unique', 1, 4, '2018-10-14 08:53:03', NULL),
(3, 'ENUnique', '', 'unique', 1, 4, '2018-10-14 08:53:03', NULL),
(5, 'ENData', '', 'unique', 1, 2, '2018-10-14 08:53:03', NULL),
(6, 'VNData', '', 'unique', 1, 2, '2018-10-14 08:53:03', NULL),
(10, 'VNWeekly', '', 'weekly', 1, 1, '2018-10-14 08:44:30', NULL),
(11, 'VNTest Active', '', 'weekly', 0, 1, '2018-10-14 08:44:30', NULL),
(12, 'ENTest Active', '', 'weekly', 0, 99, '2018-10-14 08:44:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_item`
--

CREATE TABLE `event_item` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `category_position` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `event_item`
--

INSERT INTO `event_item` (`id`, `category_id`, `start_time`, `end_time`, `start_date`, `end_date`, `category_position`, `created_at`, `edited_at`) VALUES
(1, 1, '16:00:00', '19:00:00', '0000-00-00', NULL, 0, '0000-00-00 00:00:00', NULL),
(2, 1, '16:00:00', '20:00:00', '0000-00-00', NULL, 2, '0000-00-00 00:00:00', NULL),
(3, 1, '17:00:00', '21:00:00', '0000-00-00', NULL, 1, '0000-00-00 00:00:00', NULL),
(4, 1, '18:00:00', '22:00:00', '0000-00-00', NULL, 4, '0000-00-00 00:00:00', NULL),
(5, 1, '19:00:00', '23:00:00', '0000-00-00', NULL, 3, '0000-00-00 00:00:00', NULL),
(6, 3, '20:00:00', '00:00:00', '0000-00-00', NULL, 0, '0000-00-00 00:00:00', NULL),
(7, 10, '16:00:00', '19:00:00', '0000-00-00', NULL, 0, '0000-00-00 00:00:00', NULL),
(8, 10, '16:00:00', '20:00:00', '0000-00-00', NULL, 2, '0000-00-00 00:00:00', NULL),
(9, 10, '17:00:00', '21:00:00', '0000-00-00', NULL, 1, '0000-00-00 00:00:00', NULL),
(10, 10, '18:00:00', '22:00:00', '0000-00-00', NULL, 4, '0000-00-00 00:00:00', NULL),
(11, 10, '19:00:00', '23:00:00', '0000-00-00', NULL, 3, '0000-00-00 00:00:00', NULL),
(12, 2, '20:00:00', '00:00:00', '0000-00-00', NULL, 0, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_item_details`
--

CREATE TABLE `event_item_details` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `language` set('en','vn') COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `image_details`
--

CREATE TABLE `image_details` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `img_url` varchar(191) COLLATE utf8_bin NOT NULL,
  `page_position` int(11) NOT NULL,
  `caption` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `alt` varchar(255) COLLATE utf8_bin NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `tag` varchar(255) COLLATE utf8_bin NOT NULL,
  `language` set('en','vn') COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `image_details`
--

INSERT INTO `image_details` (`id`, `page_id`, `img_url`, `page_position`, `caption`, `alt`, `height`, `width`, `tag`, `language`, `created_at`, `edited_at`) VALUES
(25, 4, '/assets/photos/540/DSC07487.jpg', 3, NULL, '', 0, 0, '4', 'vn', '2019-01-02 17:30:28', NULL),
(26, 4, '/assets/photos/540/DSC07487.jpg', 10, NULL, '', 0, 0, '5', 'en', '2018-12-30 18:36:03', NULL),
(27, 4, '/assets/photos/540/DSC07487.jpg', 10, NULL, '', 0, 0, '5', 'vn', '2018-12-30 18:36:03', NULL),
(28, 4, '/assets/photos/540/DSC07494.jpg', 11, NULL, '', 0, 0, '6', 'en', '2018-12-30 18:36:03', NULL),
(29, 4, '/assets/photos/540/DSC07494.jpg', 11, NULL, '', 0, 0, '6', 'vn', '2018-12-30 18:36:03', NULL),
(30, 4, '/assets/photos/540/DSC07398.jpg', 7, NULL, '', 0, 0, '3', 'en', '2018-12-30 18:36:03', NULL),
(31, 4, '/assets/photos/540/DSC07494.jpg', 14, NULL, '', 0, 0, '2', 'en', '2019-01-02 11:40:10', NULL),
(32, 4, '/assets/photos/540/DSC07398.jpg', 7, NULL, '', 0, 0, '3', 'vn', '2018-12-30 18:36:03', NULL),
(33, 4, '/assets/photos/540/DSC07494.jpg', 14, NULL, '', 0, 0, '2', 'vn', '2019-01-02 11:40:10', NULL),
(34, 4, '/assets/photos/540/DSC07494.jpg', 13, NULL, '', 0, 0, '1', 'en', '2019-01-02 11:40:10', NULL),
(35, 4, '/assets/photos/540/DSC07494.jpg', 13, NULL, '', 0, 0, '1', 'vn', '2019-01-02 11:40:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `image_list`
--

CREATE TABLE `image_list` (
  `id` int(11) NOT NULL,
  `imgUrl` char(255) COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `image_list`
--

INSERT INTO `image_list` (`id`, `imgUrl`, `active`, `created_at`, `edited_at`) VALUES
(1, 'DSC07514.jpg', 1, '2018-12-30 22:18:28', NULL),
(2, 'IMG_0243.jpg', 1, '2018-12-30 22:18:28', NULL),
(3, 'ACP-1.jpg', 1, '2018-12-30 22:24:40', NULL),
(4, 'IMG_0282.jpg', 1, '2018-12-30 22:24:40', NULL),
(5, 'DSC07649-2.jpg', 1, '2018-12-30 22:24:55', NULL),
(6, 'DSC07506.jpg', 1, '2018-12-30 22:24:55', NULL),
(7, 'DSC08000.jpg', 1, '2018-12-30 22:27:23', NULL),
(8, 'IMG_0277.jpg', 1, '2018-12-30 22:27:23', NULL),
(9, 'ACP-5.jpg', 1, '2018-12-30 22:27:23', NULL),
(10, 'DSC07398.jpg', 1, '2018-12-30 22:27:23', NULL),
(11, 'DSC07595.jpg', 1, '2018-12-30 22:27:23', NULL),
(12, 'DSC07685-2.jpg', 1, '2018-12-30 22:27:23', NULL),
(13, 'DSC07571.jpg', 1, '2018-12-30 22:27:23', NULL),
(14, 'DSC07422.jpg', 1, '2018-12-30 22:27:23', NULL),
(15, 'IMG_0246.jpg', 1, '2018-12-30 22:27:23', NULL),
(16, 'DSC07657.jpg', 1, '2018-12-30 22:27:23', NULL),
(17, 'testing', 1, '2019-01-12 14:15:32', NULL),
(19, 'te1sting', 1, '2019-01-12 14:20:45', NULL),
(20, 'te2sting', 1, '2019-01-12 14:22:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_category`
--

CREATE TABLE `menu_category` (
  `id` int(11) NOT NULL,
  `en_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `vn_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` set('food','drink') COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `page_position` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `menu_category`
--

INSERT INTO `menu_category` (`id`, `en_name`, `vn_name`, `type`, `active`, `page_position`, `created_at`, `edited_at`) VALUES
(1, 'Position 1', 'Position 1', 'drink', 1, 1, '2019-01-11 22:02:25', '2019-02-02 18:36:24'),
(3, 'Position 5', 'Position 5', 'food', 1, 9, '2019-01-11 22:02:25', '2019-02-02 14:29:56'),
(12, 'Position 2', 'Position 2', 'drink', 1, 6, '2019-01-11 22:02:25', '2019-02-02 14:29:56'),
(23, 'Position 4', 'Position 4', 'food', 1, 8, '2019-01-13 18:52:29', '2019-02-02 14:29:56'),
(25, 'Position 3', 'Position 3', 'food', 1, 7, '2019-01-13 21:06:19', '2019-02-02 14:29:56'),
(35, 'Test 1', 'Test 1 VN', 'food', 1, 5, '2019-01-30 21:14:22', '2019-02-02 18:01:01'),
(36, 'test', 'test', 'food', 1, 4, '2019-01-30 21:15:28', '2019-02-02 18:01:02'),
(37, 'new test', 'new test', 'drink', 1, 3, '2019-02-02 13:39:16', '2019-02-02 18:01:04'),
(38, 'test BCD', 'test BC', 'food', 1, 2, '2019-02-02 13:43:13', '2019-02-02 18:36:24'),
(41, 'Another Test1', 'Another Test1', 'food', 1, 10, '2019-02-02 13:57:01', '2019-02-02 14:30:04');

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE `menu_item` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `category_position` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `menu_item`
--

INSERT INTO `menu_item` (`id`, `category_id`, `price`, `category_position`, `created_at`, `edited_at`) VALUES
(14, 1, '85K', 2, '2019-01-11 22:03:44', '2019-01-30 21:19:59'),
(16, 1, '140K', 4, '2019-01-11 22:03:44', '2019-01-30 20:44:29'),
(32, 3, '250K', 3, '2019-01-11 22:03:44', '2019-01-30 18:51:45'),
(84, 12, '115K/550K', 3, '2019-01-11 22:03:44', NULL),
(157, 12, 'testK', 2, '2019-01-13 21:06:40', '2019-01-30 20:41:35'),
(158, 12, 'testK', 1, '2019-01-13 21:06:44', '2019-01-30 20:41:35'),
(159, 1, '1337K', 9, '2019-01-16 15:44:52', '2019-01-30 21:19:59'),
(160, 25, '1337K', 1, '2019-01-16 15:45:09', '2019-02-02 18:36:35'),
(161, 1, '1337K', 3, '2019-01-16 15:45:22', '2019-01-30 21:19:59'),
(162, 25, '1337K', 2, '2019-01-16 15:45:34', '2019-02-02 18:36:35'),
(163, 1, '1337K', 5, '2019-01-16 15:45:45', '2019-01-30 21:19:59'),
(164, 1, '1337K', 6, '2019-01-16 15:45:57', '2019-01-30 21:19:59'),
(169, 1, '151', 7, '2019-01-19 21:46:37', '2019-01-30 21:19:59'),
(170, 1, '151', 8, '2019-01-19 21:47:27', '2019-01-30 21:19:59'),
(171, 3, 'test', 2, '2019-01-19 21:48:10', '2019-02-02 18:36:40'),
(172, 3, 'test', 1, '2019-01-19 21:48:12', '2019-02-02 18:36:40'),
(178, 1, '15', 1, '2019-01-30 21:19:59', NULL),
(179, 35, '5252', 1, '2019-01-30 21:21:48', NULL),
(180, 1, 'test', 10, '2019-02-02 18:10:37', NULL),
(185, 38, 'test', 1, '2019-02-02 18:19:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_details`
--

CREATE TABLE `menu_item_details` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `language` set('en','vn') COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `menu_item_details`
--

INSERT INTO `menu_item_details` (`id`, `item_id`, `title`, `description`, `language`, `created_at`, `edited_at`) VALUES
(1, 16, 'EN Loaded Fries', 'Hand cut fries topped with pulled pork, bacon, cheddar cheese and Cool Ranch dressing', 'en', '2019-01-11 22:04:28', NULL),
(2, 16, 'VN Loaded Fries', 'ở phíaServed with Two Choice of Sides', 'vn', '2019-01-11 22:04:28', NULL),
(3, 84, 'The Accomplice', 'EN Glass/Bottle', 'en', '2019-01-11 22:04:28', NULL),
(4, 84, 'VN chữ Quốc ngữ The Accomplice', 'chữ Quốc ngữ Glass/Bottle', 'vn', '2019-01-11 22:04:28', NULL),
(5, 32, '250g Australian Grain fed Rib Eye Steak', 'Its a fooking burger alright', 'en', '2019-01-11 22:04:28', NULL),
(6, 32, 'chữ Quốc ngữ Australian burger', 'chữ Quốc ngữ Its a fooking burger alright', 'vn', '2019-01-11 22:04:28', NULL),
(7, 14, 'En Spinach innit', 'Hand cut fries topped with pulled pork, bacon, cheddar cheese and Cool Ranch dressing', 'en', '2019-01-11 22:04:28', NULL),
(8, 14, 'ở phíaServed Spinach with Two Choice of Sides', 'ở phíaServed with Two Choice of Sides', 'vn', '2019-01-11 22:04:28', NULL),
(102, 157, 'Test Edit Test 3', 'enDesc Test', 'en', '2019-01-13 21:06:40', '2019-01-30 20:09:07'),
(103, 157, 'Test Edit Test 3', 'vnDesc Test', 'vn', '2019-01-13 21:06:40', '2019-01-30 20:09:07'),
(104, 158, 'Test test edit 2', 'enDesc Test test edit 2', 'en', '2019-01-13 21:06:45', '2019-01-30 20:05:06'),
(105, 158, 'Test test edit 2', 'vnDesc Test test edit 2', 'vn', '2019-01-13 21:06:45', '2019-01-30 20:05:06'),
(106, 159, 'enTest1', 'enDesc Test', 'en', '2019-01-16 15:44:52', NULL),
(107, 159, 'vnTest1', 'vnDesc Test', 'vn', '2019-01-16 15:44:52', NULL),
(108, 160, 'enTest2', 'enDesc Test', 'en', '2019-01-16 15:45:09', NULL),
(109, 160, 'vnTest2', 'vnDesc Test', 'vn', '2019-01-16 15:45:10', NULL),
(110, 161, 'enTest3', 'enDesc Test', 'en', '2019-01-16 15:45:22', NULL),
(111, 161, 'vnTest3', 'vnDesc Test', 'vn', '2019-01-16 15:45:22', NULL),
(112, 162, 'enTest4', 'enDesc Test', 'en', '2019-01-16 15:45:34', NULL),
(113, 162, 'vnTest4', 'vnDesc Test', 'vn', '2019-01-16 15:45:34', NULL),
(114, 163, 'enTest5', 'enDesc Test', 'en', '2019-01-16 15:45:45', NULL),
(115, 163, 'vnTest5', 'vnDesc Test', 'vn', '2019-01-16 15:45:45', NULL),
(116, 164, 'enTest6', 'enDesc Test', 'en', '2019-01-16 15:45:57', NULL),
(117, 164, 'vnTest6', 'vnDesc Test', 'vn', '2019-01-16 15:45:57', NULL),
(118, 169, 'Trevor Noah', NULL, 'en', '2019-01-19 21:46:41', '2019-01-30 19:53:39'),
(119, 169, 'Trevor Noah', NULL, 'vn', '2019-01-19 21:46:49', '2019-01-30 19:53:39'),
(120, 170, 'testest', NULL, 'en', '2019-01-19 21:47:27', NULL),
(121, 170, 'testetset', NULL, 'vn', '2019-01-19 21:47:27', NULL),
(122, 171, 'Test Save', NULL, 'en', '2019-01-19 21:48:10', '2019-01-30 20:31:15'),
(123, 171, 'testsetst', NULL, 'vn', '2019-01-19 21:48:11', NULL),
(124, 172, 'ysetest', NULL, 'en', '2019-01-19 21:48:12', NULL),
(125, 172, 'testsetst', NULL, 'vn', '2019-01-19 21:48:12', NULL),
(136, 178, 'test', NULL, 'en', '2019-01-30 21:19:59', NULL),
(137, 178, 'test', NULL, 'vn', '2019-01-30 21:19:59', NULL),
(138, 179, '23523552', NULL, 'en', '2019-01-30 21:21:48', NULL),
(139, 179, '23555225', NULL, 'vn', '2019-01-30 21:21:48', NULL),
(140, 180, 'test', NULL, 'en', '2019-02-02 18:10:37', NULL),
(141, 180, 'test', NULL, 'vn', '2019-02-02 18:10:37', NULL),
(150, 185, 'test', NULL, 'en', '2019-02-02 18:19:56', NULL),
(151, 185, 'test', NULL, 'vn', '2019-02-02 18:19:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `new_image_details`
--

CREATE TABLE `new_image_details` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `img_url` varchar(191) COLLATE utf8_bin NOT NULL,
  `caption` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `alt` varchar(255) COLLATE utf8_bin NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `tag` varchar(255) COLLATE utf8_bin NOT NULL,
  `language` set('en','vn') COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `new_page_item`
--

CREATE TABLE `new_page_item` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `caption` varchar(255) COLLATE utf8_bin NOT NULL,
  `page_position` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `new_page_item`
--

INSERT INTO `new_page_item` (`id`, `page_id`, `caption`, `page_position`, `created_at`, `edited_at`) VALUES
(80, 4, '4f', 12, '2019-01-02 11:40:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `new_page_item_details`
--

CREATE TABLE `new_page_item_details` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `heading` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `language` set('en','vn') COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `name`) VALUES
(1, 'Home'),
(2, 'Gallery'),
(3, 'Contact'),
(4, 'About');

-- --------------------------------------------------------

--
-- Table structure for table `page_item`
--

CREATE TABLE `page_item` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `heading` varchar(255) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL,
  `language` set('en','vn') COLLATE utf8_bin NOT NULL,
  `tag` varchar(255) COLLATE utf8_bin NOT NULL,
  `page_position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `page_item`
--

INSERT INTO `page_item` (`id`, `page_id`, `heading`, `content`, `created_at`, `edited_at`, `language`, `tag`, `page_position`) VALUES
(1, 1, 'Welcome', 'Join us for great BBQ, Craft Beers and introducing our Tap Tables. Book your Kegs now and have your own personal Tap on Table to enjoy while you support your teams.\r\n\r\nBook Your Tap Table Now!\r\ncontact@tapoutvietnam.com\r\n+84 28 62702700', '2018-10-13 19:25:46', NULL, 'en', 'welcome', 1),
(3, 4, 'Overview', 'We present a modernized model between restaurants and bar, serving an interesting twist on the all-year-round smoked BBQ’s. We are organized as a team of Dutch, Canadian and Vietnamese experts with an extensive amount of experience in hospitality from all over the world.', '2018-10-13 19:27:55', NULL, 'en', 'overview', 6),
(5, 4, 'MINNIE (HUE ANH)', 'Minnie (Hue Anh) has achieved a prolonged hospitality background by her initially studying in Switzerland and working experience in Qatar, the Cayman Islands. Finally, she returns to her sweet home Vietnam for further expanding her restaurants in Saigon.', '2018-10-13 19:27:55', NULL, 'en', 'minnie', 16),
(6, 4, 'GOAL', 'We have united together to bring one of a kind dishes, with the finest selection of beers and ciders as well as bottles of wine from our spacious cellar. A wide selection of BBQ’s cuisines, which have been smoked for hours, would also be a great accompany with the finest cocktails from Tapout’s mixologist.', '2018-10-13 19:27:55', NULL, 'en', 'goal', 15),
(13, 3, 'Address', '170 Cong Quynh\r\nDistrict 1\r\nHCMC', '2018-10-13 19:29:08', NULL, 'en', '', 10),
(14, 3, 'Contact', 'Contact Number: +84 963 806 071\r\nReservations: +84 28 62702700\r\nEmail: contact@tapoutvietnam.com', '2018-10-13 19:30:32', NULL, 'en', '', 7),
(15, 3, 'Social Media', 'https://www.facebook.com/tapout84/\r\nhttps://www.instagram.com/tapoutvietnam', '2018-10-13 19:30:32', NULL, 'en', '', 9),
(16, 3, 'Opening hours', 'Monday-Sunday: 11:00-Late', '2018-10-13 19:30:32', NULL, 'en', '', 8),
(17, 1, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía Nam', '2018-10-14 08:52:09', NULL, 'vn', '', 11),
(18, 4, 'VNOverview', 'We present a modernized model between restaurants and bar, serving an interesting twist on the all-year-round smoked BBQ’s. We are organized as a team of Dutch, Canadian and Vietnamese experts with an extensive amount of experience in hospitality from all over the world.', '2018-10-13 19:27:55', NULL, 'vn', 'overview', 6),
(20, 4, 'VNMINNIE (HUE ANH)', 'Minnie (Hue Anh) has achieved a prolonged hospitality background by her initially studying in Switzerland and working experience in Qatar, the Cayman Islands. Finally, she returns to her sweet home Vietnam for further expanding her restaurants in Saigon.', '2018-10-13 19:27:55', NULL, 'vn', 'minnie', 16),
(21, 4, 'VNGOAL', 'We have united together to bring one of a kind dishes, with the finest selection of beers and ciders as well as bottles of wine from our spacious cellar. A wide selection of BBQ’s cuisines, which have been smoked for hours, would also be a great accompany with the finest cocktails from Tapout’s mixologist.', '2018-10-13 19:27:55', NULL, 'vn', 'goal', 15),
(23, 1, 'VNWelcome', 'Join us for great BBQ, Craft Beers and introducing our Tap Tables. Book your Kegs now and have your own personal Tap on Table to enjoy while you support your teams.\r\n\r\nBook Your Tap Table Now!\r\ncontact@tapoutvietnam.com\r\n+84 28 62702700', '2018-10-13 19:25:46', NULL, 'vn', 'welcome', 1),
(63, 4, 'ENTrevor', 'Trever Noah', '2018-10-13 19:27:55', NULL, 'en', 'initializeDelete', 8),
(64, 4, 'VNTrevor', 'TREVER NOAH with the finest cocktails from Tapout’s mixologist.', '2018-10-13 19:27:55', NULL, 'vn', 'initializeDelete', 8),
(65, 4, 'EnHeadingTest', 'EnContentTest EnContentTest EnContentTest EnContentTest ', '2018-12-30 12:10:32', NULL, 'en', '41', 9),
(66, 4, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía Nam', '2018-12-30 12:10:32', NULL, 'vn', '41', 9),
(71, 4, 'Test from frontend', 'Content test from front end', '2018-12-30 12:14:47', NULL, 'en', '47', 1),
(72, 4, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía Nam', '2018-12-30 12:14:47', NULL, 'vn', '47', 1),
(73, 4, 'Test from frontend', 'Content test from front end', '2018-12-30 12:15:01', NULL, 'en', '49', 4),
(74, 4, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía Nam', '2018-12-30 12:15:01', NULL, 'vn', '49', 4),
(79, 4, 'EnHeadingTest', 'EnContentTest EnContentTest EnContentTest EnContentTest ', '2019-01-02 11:40:10', NULL, 'en', '4f', 12),
(80, 4, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía Nam', '2019-01-02 11:40:10', NULL, 'vn', '4f', 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event_category`
--
ALTER TABLE `event_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_item`
--
ALTER TABLE `event_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `event_item_details`
--
ALTER TABLE `event_item_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `image_details`
--
ALTER TABLE `image_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `image_list`
--
ALTER TABLE `image_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `imgUrl` (`imgUrl`);

--
-- Indexes for table `menu_category`
--
ALTER TABLE `menu_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `menu_item_details`
--
ALTER TABLE `menu_item_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `new_image_details`
--
ALTER TABLE `new_image_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `new_page_item`
--
ALTER TABLE `new_page_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `new_page_item_details`
--
ALTER TABLE `new_page_item_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_item`
--
ALTER TABLE `page_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event_category`
--
ALTER TABLE `event_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `event_item`
--
ALTER TABLE `event_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `event_item_details`
--
ALTER TABLE `event_item_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_details`
--
ALTER TABLE `image_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `image_list`
--
ALTER TABLE `image_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `menu_category`
--
ALTER TABLE `menu_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `menu_item`
--
ALTER TABLE `menu_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `menu_item_details`
--
ALTER TABLE `menu_item_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `new_image_details`
--
ALTER TABLE `new_image_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `new_page_item`
--
ALTER TABLE `new_page_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `new_page_item_details`
--
ALTER TABLE `new_page_item_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `page_item`
--
ALTER TABLE `page_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_item`
--
ALTER TABLE `event_item`
  ADD CONSTRAINT `event_item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `event_category` (`id`);

--
-- Constraints for table `event_item_details`
--
ALTER TABLE `event_item_details`
  ADD CONSTRAINT `event_item_details_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `event_item` (`id`);

--
-- Constraints for table `image_details`
--
ALTER TABLE `image_details`
  ADD CONSTRAINT `image_details_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`);

--
-- Constraints for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD CONSTRAINT `menu_item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `menu_category` (`id`);

--
-- Constraints for table `menu_item_details`
--
ALTER TABLE `menu_item_details`
  ADD CONSTRAINT `menu_item_details_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `menu_item` (`id`);

--
-- Constraints for table `new_image_details`
--
ALTER TABLE `new_image_details`
  ADD CONSTRAINT `new_image_details_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `new_page_item` (`id`);

--
-- Constraints for table `new_page_item_details`
--
ALTER TABLE `new_page_item_details`
  ADD CONSTRAINT `new_page_item_details_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `new_page_item` (`id`);

--
-- Constraints for table `page_item`
--
ALTER TABLE `page_item`
  ADD CONSTRAINT `page_item_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
