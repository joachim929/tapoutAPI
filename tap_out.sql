-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2019 at 12:36 AM
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
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` set('unique','weekly') COLLATE utf8_bin NOT NULL,
  `language` set('en','vn') COLLATE utf8_bin NOT NULL,
  `tag` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `page_position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `event_category`
--

INSERT INTO `event_category` (`id`, `name`, `type`, `language`, `tag`, `created_at`, `edited_at`, `active`, `page_position`) VALUES
(1, 'ENWeekly', 'weekly', 'en', 'weekly', '2018-10-14 08:44:30', NULL, 1, 1),
(2, 'VNUnique', 'unique', 'vn', 'football', '2018-10-14 08:53:03', NULL, 1, 4),
(3, 'ENUnique', 'unique', 'en', 'football', '2018-10-14 08:53:03', NULL, 1, 4),
(5, 'ENData', 'unique', 'en', 'data', '2018-10-14 08:53:03', NULL, 1, 2),
(6, 'VNData', 'unique', 'vn', 'data', '2018-10-14 08:53:03', NULL, 1, 2),
(10, 'VNWeekly', 'weekly', 'vn', 'weekly', '2018-10-14 08:44:30', NULL, 1, 1),
(11, 'VNTest Active', 'weekly', 'vn', 'weekly', '2018-10-14 08:44:30', NULL, 0, 1),
(12, 'ENTest Active', 'weekly', 'en', 'weekly', '2018-10-14 08:44:30', NULL, 0, 99);

-- --------------------------------------------------------

--
-- Table structure for table `event_item`
--

CREATE TABLE `event_item` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `heading` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `language` set('en','vn') COLLATE utf8_bin NOT NULL,
  `tag` varchar(255) COLLATE utf8_bin NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `start_date` int(11) NOT NULL,
  `edited_at` int(11) DEFAULT NULL,
  `category_position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `event_item`
--

INSERT INTO `event_item` (`id`, `category_id`, `heading`, `description`, `language`, `tag`, `start_time`, `end_time`, `created_at`, `start_date`, `edited_at`, `category_position`) VALUES
(1, 1, 'Daily Happy Hour', 'Buy one Cocktail, get one free from 4pm-7pm', 'en', 'happyhour', '16:00:00', '19:00:00', 1541242800, 1641242800, NULL, 0),
(2, 1, 'Tap Out Mondays', '6x wings any style, 1 medium Rooster bia - 130K ₫\r\n12x wings any style, 1 pint Rooster bia - 210K ₫\r\n24x wings any style, 4x medium Rooster bia 350K ₫\r\nBuy 2 get the 3rd FREE on Rooster Bia\'s all night', 'en', 'mondays', '16:00:00', '20:00:00', 1541242800, 1641242800, NULL, 2),
(3, 1, 'Rooster Night, Tuesdays', '20% off all food items', 'en', 'tuesdays', '17:00:00', '21:00:00', 1541242800, 1641242800, NULL, 1),
(4, 1, 'Why Wine? Wednesdays', '50% on all house wines by the glass', 'en', 'wednesdays', '18:00:00', '22:00:00', 1541242800, 1641242800, NULL, 4),
(5, 1, 'Tap That Keg Thursdays', 'Half a rack of ribs, choice of two sides, and free flow Tiger draft!!!', 'en', 'thursdays', '19:00:00', '23:00:00', 1541242800, 1641240800, NULL, 3),
(6, 3, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía Nam', 'en', '', '20:00:00', '00:00:00', 1541242800, 1641240800, NULL, 0),
(7, 10, 'Daily Happy Hour', 'Buy one Cocktail, get one free from 4pm-7pm', 'vn', 'happyhour', '16:00:00', '19:00:00', 1541242800, 1641242800, NULL, 0),
(8, 10, 'Tap Out Mondays', '6x wings any style, 1 medium Rooster bia - 130K ₫\r\n12x wings any style, 1 pint Rooster bia - 210K ₫\r\n24x wings any style, 4x medium Rooster bia 350K ₫\r\nBuy 2 get the 3rd FREE on Rooster Bia\'s all night', 'vn', 'mondays', '16:00:00', '20:00:00', 1541242800, 1641240800, NULL, 2),
(9, 10, 'Rooster Night, Tuesdays', '20% off all food items', 'vn', 'tuesdays', '17:00:00', '21:00:00', 1541242800, 1641242800, NULL, 1),
(10, 10, 'Why Wine? Wednesdays', '50% on all house wines by the glass', 'vn', 'wednesdays', '18:00:00', '22:00:00', 1541242800, 1641242800, NULL, 4),
(11, 10, 'Tap That Keg Thursdays', 'Half a rack of ribs, choice of two sides, and free flow Tiger draft!!!', 'vn', 'thursdays', '19:00:00', '23:00:00', 1541242800, 1641240800, NULL, 3),
(12, 2, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía Nam', 'en', '', '20:00:00', '00:00:00', 1541242800, 1641240800, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `image_details`
--

CREATE TABLE `image_details` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `img_url` varchar(191) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `page_position` int(11) NOT NULL,
  `caption` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `alt` varchar(255) COLLATE utf8_bin NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `tag` varchar(255) COLLATE utf8_bin NOT NULL,
  `language` set('en','vn') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `image_details`
--

INSERT INTO `image_details` (`id`, `page_id`, `img_url`, `created_at`, `page_position`, `caption`, `alt`, `height`, `width`, `tag`, `language`) VALUES
(25, 4, '/assets/photos/540/DSC07487.jpg', '2019-01-02 17:30:28', 3, NULL, '', 0, 0, '4', 'vn'),
(26, 4, '/assets/photos/540/DSC07487.jpg', '2018-12-30 18:36:03', 10, NULL, '', 0, 0, '5', 'en'),
(27, 4, '/assets/photos/540/DSC07487.jpg', '2018-12-30 18:36:03', 10, NULL, '', 0, 0, '5', 'vn'),
(28, 4, '/assets/photos/540/DSC07494.jpg', '2018-12-30 18:36:03', 11, NULL, '', 0, 0, '6', 'en'),
(29, 4, '/assets/photos/540/DSC07494.jpg', '2018-12-30 18:36:03', 11, NULL, '', 0, 0, '6', 'vn'),
(30, 4, '/assets/photos/540/DSC07398.jpg', '2018-12-30 18:36:03', 7, NULL, '', 0, 0, '3', 'en'),
(31, 4, '/assets/photos/540/DSC07494.jpg', '2019-01-02 11:40:10', 14, NULL, '', 0, 0, '2', 'en'),
(32, 4, '/assets/photos/540/DSC07398.jpg', '2018-12-30 18:36:03', 7, NULL, '', 0, 0, '3', 'vn'),
(33, 4, '/assets/photos/540/DSC07494.jpg', '2019-01-02 11:40:10', 14, NULL, '', 0, 0, '2', 'vn'),
(34, 4, '/assets/photos/540/DSC07494.jpg', '2019-01-02 11:40:10', 13, NULL, '', 0, 0, '1', 'en'),
(35, 4, '/assets/photos/540/DSC07494.jpg', '2019-01-02 11:40:10', 13, NULL, '', 0, 0, '1', 'vn');

-- --------------------------------------------------------

--
-- Table structure for table `image_list`
--

CREATE TABLE `image_list` (
  `id` int(11) NOT NULL,
  `imgUrl` char(255) COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `image_list`
--

INSERT INTO `image_list` (`id`, `imgUrl`, `active`, `created_at`) VALUES
(1, 'DSC07514.jpg', 1, '2018-12-30 22:18:28'),
(2, 'IMG_0243.jpg', 1, '2018-12-30 22:18:28'),
(3, 'ACP-1.jpg', 1, '2018-12-30 22:24:40'),
(4, 'IMG_0282.jpg', 1, '2018-12-30 22:24:40'),
(5, 'DSC07649-2.jpg', 1, '2018-12-30 22:24:55'),
(6, 'DSC07506.jpg', 1, '2018-12-30 22:24:55'),
(7, 'DSC08000.jpg', 1, '2018-12-30 22:27:23'),
(8, 'IMG_0277.jpg', 1, '2018-12-30 22:27:23'),
(9, 'ACP-5.jpg', 1, '2018-12-30 22:27:23'),
(10, 'DSC07398.jpg', 1, '2018-12-30 22:27:23'),
(11, 'DSC07595.jpg', 1, '2018-12-30 22:27:23'),
(12, 'DSC07685-2.jpg', 1, '2018-12-30 22:27:23'),
(13, 'DSC07571.jpg', 1, '2018-12-30 22:27:23'),
(14, 'DSC07422.jpg', 1, '2018-12-30 22:27:23'),
(15, 'IMG_0246.jpg', 1, '2018-12-30 22:27:23'),
(16, 'DSC07657.jpg', 1, '2018-12-30 22:27:23');

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
  `page_position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `menu_category`
--

INSERT INTO `menu_category` (`id`, `en_name`, `vn_name`, `type`, `active`, `page_position`) VALUES
(1, 'EN Breakfast', 'VN Breakfast', 'food', 1, 1),
(3, 'EN Mains', 'VN Mains', 'food', 1, 30),
(12, 'EN White Wine', 'VN White Wines', 'drink', 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE `menu_item` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `caption` varchar(255) COLLATE utf8_bin NOT NULL,
  `price` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `category_position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `menu_item`
--

INSERT INTO `menu_item` (`id`, `category_id`, `caption`, `price`, `category_position`) VALUES
(14, 1, 'Spinach & Artichoke DipSpinach & Artichoke Dip', '85K', 28),
(16, 1, 'Loaded Fries', '140K', 18),
(32, 3, '250g Australian Grain fed Rib Eye Steak', '250K', 2),
(84, 12, 'The Accomplice – Chardonnay – Australia 2016', '115K/550K', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_details`
--

CREATE TABLE `menu_item_details` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL,
  `language` set('en','vn') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `menu_item_details`
--

INSERT INTO `menu_item_details` (`id`, `item_id`, `title`, `description`, `language`) VALUES
(1, 16, 'EN Loaded Fries', 'Hand cut fries topped with pulled pork, bacon, cheddar cheese and Cool Ranch dressing', 'en'),
(2, 16, 'VN Loaded Fries', 'ở phíaServed with Two Choice of Sides', 'vn'),
(3, 84, 'The Accomplice', 'EN Glass/Bottle', 'en'),
(4, 84, 'VN chữ Quốc ngữ The Accomplice', 'chữ Quốc ngữ Glass/Bottle', 'vn'),
(5, 32, '250g Australian Grain fed Rib Eye Steak', 'Its a fooking burger alright', 'en'),
(6, 32, 'chữ Quốc ngữ Australian burger', 'chữ Quốc ngữ Its a fooking burger alright', 'vn'),
(7, 14, 'En Spinach innit', 'Hand cut fries topped with pulled pork, bacon, cheddar cheese and Cool Ranch dressing', 'en'),
(8, 14, 'ở phíaServed Spinach with Two Choice of Sides', 'ở phíaServed with Two Choice of Sides', 'vn');

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
-- AUTO_INCREMENT for table `image_details`
--
ALTER TABLE `image_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `image_list`
--
ALTER TABLE `image_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `menu_category`
--
ALTER TABLE `menu_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `menu_item`
--
ALTER TABLE `menu_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `menu_item_details`
--
ALTER TABLE `menu_item_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- Constraints for table `page_item`
--
ALTER TABLE `page_item`
  ADD CONSTRAINT `page_item_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
