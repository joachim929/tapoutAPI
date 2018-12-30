-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2018 at 10:29 PM
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
-- Database: `tapout`
--

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
-- Table structure for table `tapout_event_category`
--

CREATE TABLE `tapout_event_category` (
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
-- Dumping data for table `tapout_event_category`
--

INSERT INTO `tapout_event_category` (`id`, `name`, `type`, `language`, `tag`, `created_at`, `edited_at`, `active`, `page_position`) VALUES
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
-- Table structure for table `tapout_event_item`
--

CREATE TABLE `tapout_event_item` (
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
-- Dumping data for table `tapout_event_item`
--

INSERT INTO `tapout_event_item` (`id`, `category_id`, `heading`, `description`, `language`, `tag`, `start_time`, `end_time`, `created_at`, `start_date`, `edited_at`, `category_position`) VALUES
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
-- Table structure for table `tapout_image`
--

CREATE TABLE `tapout_image` (
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
-- Dumping data for table `tapout_image`
--

INSERT INTO `tapout_image` (`id`, `page_id`, `img_url`, `created_at`, `page_position`, `caption`, `alt`, `height`, `width`, `tag`, `language`) VALUES
(24, 4, '/assets/photos/540/DSC07487.jpg', '2018-12-30 18:36:03', 5, NULL, '', 0, 0, '4', 'en'),
(25, 4, '/assets/photos/540/DSC07487.jpg', '2018-12-30 18:36:03', 5, NULL, '', 0, 0, '4', 'vn'),
(26, 4, '/assets/photos/540/DSC07487.jpg', '2018-12-30 18:36:03', 10, NULL, '', 0, 0, '5', 'en'),
(27, 4, '/assets/photos/540/DSC07487.jpg', '2018-12-30 18:36:03', 10, NULL, '', 0, 0, '5', 'vn'),
(28, 4, '/assets/photos/540/DSC07494.jpg', '2018-12-30 18:36:03', 11, NULL, '', 0, 0, '6', 'en'),
(29, 4, '/assets/photos/540/DSC07494.jpg', '2018-12-30 18:36:03', 11, NULL, '', 0, 0, '6', 'vn'),
(30, 4, '/assets/photos/540/DSC07398.jpg', '2018-12-30 18:36:03', 7, NULL, '', 0, 0, '3', 'en'),
(31, 4, '/assets/photos/540/DSC07494.jpg', '2018-12-30 18:36:03', 13, NULL, '', 0, 0, '2', 'en'),
(32, 4, '/assets/photos/540/DSC07398.jpg', '2018-12-30 18:36:03', 7, NULL, '', 0, 0, '3', 'vn'),
(33, 4, '/assets/photos/540/DSC07494.jpg', '2018-12-30 18:36:03', 13, NULL, '', 0, 0, '2', 'vn'),
(34, 4, '/assets/photos/540/DSC07494.jpg', '2018-12-30 18:36:03', 12, NULL, '', 0, 0, '1', 'en'),
(35, 4, '/assets/photos/540/DSC07494.jpg', '2018-12-30 18:36:03', 12, NULL, '', 0, 0, '1', 'vn');

-- --------------------------------------------------------

--
-- Table structure for table `tapout_menu_category`
--

CREATE TABLE `tapout_menu_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` set('food','drink') COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `language` set('en','vn') COLLATE utf8_bin NOT NULL,
  `page_position` int(11) NOT NULL,
  `tag` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tapout_menu_category`
--

INSERT INTO `tapout_menu_category` (`id`, `name`, `type`, `active`, `language`, `page_position`, `tag`) VALUES
(1, 'Breakfast', 'food', 1, 'en', 1, 'breakfast'),
(2, 'Burgers & Sandwiches', 'food', 1, 'en', 20, 'burgers'),
(3, 'Mains', 'food', 1, 'en', 30, 'mains'),
(4, 'Sides', 'food', 1, 'en', 3, 'sides'),
(5, 'Desserts', 'food', 1, 'en', 10, 'desserts'),
(6, 'On-tap', 'drink', 1, 'en', 5, 'on-tap'),
(7, 'Bottles', 'drink', 1, 'en', 6, 'bottles'),
(8, 'Special-Beers', 'drink', 1, 'en', 7, 'special-beers'),
(9, 'Mixers', 'drink', 1, 'en', 100, 'mixers'),
(10, 'Cocktails', 'drink', 1, 'en', 9, 'cocktails'),
(11, 'Red Wine', 'drink', 1, 'en', 12, 'red-wine'),
(12, 'White Wine', 'drink', 1, 'en', 11, 'white-wine'),
(13, 'Rose & Prosecco', 'drink', 1, 'en', 13, 'rose'),
(14, 'VNBreakfast', 'food', 1, 'vn', 1, 'breakfast'),
(15, 'VNMains', 'food', 1, 'vn', 30, 'mains'),
(16, 'VNSides', 'food', 1, 'vn', 3, 'sides'),
(17, 'VNBurgers & Sandwiches', 'food', 1, 'vn', 20, 'burgers'),
(18, 'VNDesserts', 'food', 1, 'vn', 10, 'desserts'),
(19, 'VNOn-top', 'drink', 1, 'vn', 5, 'on-tap'),
(20, 'VNBottles', 'drink', 1, 'vn', 6, 'bottles'),
(21, 'VNSpecial-Beers', 'drink', 1, 'vn', 7, 'special-beers'),
(22, 'VNMixers', 'drink', 1, 'vn', 100, 'mixers'),
(23, 'VNCocktails', 'drink', 1, 'vn', 9, 'cocktails'),
(24, 'VNRed Wine', 'drink', 1, 'vn', 12, 'red-wine'),
(25, 'VNWhite Wine', 'drink', 1, 'vn', 111, 'white-wine'),
(26, 'VNRose & Prosecco', 'drink', 1, 'vn', 13, 'rose');

-- --------------------------------------------------------

--
-- Table structure for table `tapout_menu_item`
--

CREATE TABLE `tapout_menu_item` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `price` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin,
  `category_position` int(11) NOT NULL,
  `tag` varchar(255) COLLATE utf8_bin NOT NULL,
  `language` set('en','vn') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tapout_menu_item`
--

INSERT INTO `tapout_menu_item` (`id`, `category_id`, `title`, `price`, `description`, `category_position`, `tag`, `language`) VALUES
(14, 1, 'Spinach & Artichoke DipSpinach & Artichoke Dip', '85K', 'Cold dip served with homemade chips, and assorted fresh vegetables', 28, 'spinach', 'en'),
(15, 1, 'Chili Cheese Fries', '155K', 'Hand cut fries topped with homemade chili, cheddar cheese, sour cream & green onions', 5116, 'chili cheese', 'en'),
(16, 1, 'Loaded Fries', '140K', 'Hand cut fries topped with pulled pork, bacon, cheddar cheese and Cool Ranch dressing', 18, 'loaded fries', 'en'),
(28, 2, 'Pulled Pork Sandwich', '150K', 'Smoked & pulled pork shoulder topped with green apple coleslaw, served with a side of your choice', 24, 'pulled pork', 'en'),
(29, 2, 'Steak Sandwich', '200K', '125g grilled Australian rib eye, marinated red peppers & zucchini, coriander & lime chimichurri and cheddar cheese. Served on a homemade grilled light rye bread.', 29, 'steak sand', 'en'),
(30, 2, 'Montreal Smoked Meat Sandwich', '180K', 'Wood smoked cured brisket in our homemade rye bread, smothered in yellow mustard, served with hand cut fries, coleslaw and kosher dill', 21, 'montreal', 'en'),
(31, 3, 'Wood Smoked Ribs Half / Full Rack', '300K / 550K', 'Served with Two Choice of Sides', 33, 'wood smoked', 'en'),
(32, 3, '250g Australian Grain fed Rib Eye Steak', '250K', 'Flame grilled and pan finished with butter, garlic and rosemary', 2, 'australian', 'en'),
(33, 3, 'Fish & Chips', '170K', 'Beer battered fish and fries, served with a homemade tartar sauce', 11, 'fish & chips', 'en'),
(37, 4, 'Salad', '45K', 'Lettuce, cherry tomato, marinated zucchini & peppers, rosemary vinaigrette', 26, 'salad', 'en'),
(38, 4, 'Green Beans', '40K', 'Steamed and tossed with butter, garlic and cherry tomatoes', 13, 'green beans', 'en'),
(39, 4, 'Coleslaw', '35K', NULL, 8, 'coleslaw', 'en'),
(41, 5, 'Group Ice Cream Tacos deal:', '230K', '3 Tacos', 14, 'group ice', 'en'),
(42, 5, 'Baked Pineapple & Camembert', '190K', '125g Camembert wheel oven baked topped with a sweet pineapple reduction. Served with toasted bread.', 3, 'baked pineapple', 'en'),
(43, 5, 'Banana Foster', '90K', 'Bananas flambéed with dark rum & banana liqueur, brown sugar and cinnamon, served with coconut ice cream', 4, 'banana foster', 'en'),
(48, 6, 'Pasteur Street Passion Fruit Wheat Ale', '90K', 'IBU 15 - ABV 4.0%', 22, 'pasteur fruit wheat', 'en'),
(49, 6, 'Heart Of Darkness Loose Rivet New England IPA', '95K', 'IBU 59 - ABV 7.5%', 15, 'heart of darkness', 'en'),
(50, 6, 'Heart Of Darkness Mexican Pilsner', '90K', 'IBU 24 - ABV 4.2%', 19, 'mexican pils', 'en'),
(59, 7, 'Gauden Schwarzbier', '70K', 'ABV 5.2%', 12, 'gauden', 'en'),
(60, 7, 'Tiger Bottle', '50K', 'ABV 5.0%', 30, 'tiger bottle', 'en'),
(61, 7, 'Desperado Bottle', '60K', 'ABV 5.9%', 10, 'desperado', 'en'),
(62, 8, 'Modern Belgian Dark', '200K', '500ml - IBU 23 - ABV 8.1%', 20, 'modern belgian dark', 'en'),
(63, 8, 'Independence Stout', '220K', '500ml - IBU 68 - ABV 12%', 17, 'independence stout', 'en'),
(66, 9, 'House Pours', '80K', NULL, 16, 'house pours', 'en'),
(67, 9, 'Premium Pours', '90K - 175K', NULL, 23, 'premium pours', 'en'),
(68, 10, 'Celery Sour', '120K', 'Gin, celery & lime juice, sugar syrup, egg whites, bitters', 6, 'celery', 'en'),
(69, 10, 'Tropical Climax', '150K', 'Light rum, dark rum, apricot brandy, triple sec, pineapple, lime & fresh passion fruit juice.', 7, 'climax', 'en'),
(72, 10, 'Coronita', '180K', 'Double shot tequila, triple sec, lime & passion fruit juice blended with ice, served in a large cocktail glass with a mini corona.', 9, 'coronita', 'en'),
(77, 11, 'Sanama – Cabernet Sauvignon – Chile 2016', '90K/400K', 'Glass/Bottle', 27, 'sanama', 'en'),
(78, 11, 'Woolshed – Merlot – Australia 2017', '95K/450K', 'Glass/Bottle', 34, 'woolshedmer', 'en'),
(79, 11, 'Ribshack – Pinnotage/Merlot – South Africa 2016', '125K/680K', 'Glass/Bottle', 25, 'ribshack', 'en'),
(82, 12, 'Casa Subercaseaux – Sauvignon Blanc – Chile 2017', '95K/420K', 'Glass/Bottle', 5, 'casa', 'en'),
(83, 12, 'Woolshed - Sauvignon Blanc - Australia 2017', '95K/420K', 'Glass/Bottle', 35, 'woolshedsauv', 'en'),
(84, 12, 'The Accomplice – Chardonnay – Australia 2016', '115K/550K', 'Glass/Bottle', 1, 'accomplice', 'en'),
(86, 13, 'Vignerons St. Tropez – Grenache/Cinsault – France', '1,000K', 'Bottle', 32, 'vignerons', 'en'),
(87, 13, 'Tommasi Filo Dora Prosecco – Italy', '1,200K', 'Bottle', 31, 'tommasi', 'en'),
(90, 26, 'Tommasi Filo Dora Prosecco – Italy', '1,200K', 'Bottle', 31, 'tommasi', 'vn'),
(91, 26, 'Vignerons St. Tropez – Grenache/Cinsault – France', '1,000K', 'Bottle', 32, 'vignerons', 'vn'),
(92, 14, 'Spinach & Artichoke DipSpinach & Artichoke Dip', '85K', 'Cold dip served with homemade chips, and assorted fresh vegetables', 28, 'spinach', 'vn'),
(93, 14, 'Chili Cheese Fries', '155K', 'Hand cut fries topped with homemade chili, cheddar cheese, sour cream & green onions', 5116, 'chili cheese', 'vn'),
(94, 14, 'Loaded Fries', '140K', 'Hand cut fries topped with pulled pork, bacon, cheddar cheese and Cool Ranch dressing', 18, 'loaded fries', 'vn'),
(95, 17, 'Pulled Pork Sandwich', '150K', 'Smoked & pulled pork shoulder topped with green apple coleslaw, served with a side of your choice', 24, 'pulled pork', 'vn'),
(96, 17, 'Steak Sandwich', '200K', '125g grilled Australian rib eye, marinated red peppers & zucchini, coriander & lime chimichurri and cheddar cheese. Served on a homemade grilled light rye bread.', 29, 'steak sand', 'vn'),
(97, 17, 'Montreal Smoked Meat Sandwich', '180K', 'Wood smoked cured brisket in our homemade rye bread, smothered in yellow mustard, served with hand cut fries, coleslaw and kosher dill', 21, 'montreal', 'vn'),
(98, 15, 'Wood Smoked Ribs Half / Full Rack', '300K / 550K', 'Served with Two Choice of Sides', 33, 'wood smoked', 'vn'),
(99, 15, '250g Australian Grain fed Rib Eye Steak', '250K', 'Flame grilled and pan finished with butter, garlic and rosemary', 2, 'australian', 'vn'),
(100, 15, 'Fish & Chips', '170K', 'Beer battered fish and fries, served with a homemade tartar sauce', 11, 'fish & chips', 'vn'),
(101, 16, 'Salad', '45K', 'Lettuce, cherry tomato, marinated zucchini & peppers, rosemary vinaigrette', 26, 'salad', 'vn'),
(102, 16, 'Green Beans', '40K', 'Steamed and tossed with butter, garlic and cherry tomatoes', 13, 'green beans', 'vn'),
(103, 16, 'Coleslaw', '35K', NULL, 8, 'coleslaw', 'vn'),
(104, 18, 'Group Ice Cream Tacos deal:', '230K', '3 Tacos', 14, 'group ice', 'vn'),
(105, 18, 'Baked Pineapple & Camembert', '190K', '125g Camembert wheel oven baked topped with a sweet pineapple reduction. Served with toasted bread.', 3, 'baked pineapple', 'vn'),
(106, 18, 'Banana Foster', '90K', 'Bananas flambéed with dark rum & banana liqueur, brown sugar and cinnamon, served with coconut ice cream', 4, 'banana foster', 'vn'),
(107, 19, 'Pasteur Street Passion Fruit Wheat Ale', '90K', 'IBU 15 - ABV 4.0%', 22, 'pasteur fruit wheat', 'vn'),
(108, 19, 'Heart Of Darkness Loose Rivet New England IPA', '95K', 'IBU 59 - ABV 7.5%', 15, 'heart of darkness', 'vn'),
(109, 19, 'Heart Of Darkness Mexican Pilsner', '90K', 'IBU 24 - ABV 4.2%', 19, 'mexican pils', 'vn'),
(110, 20, 'Gauden Schwarzbier', '70K', 'ABV 5.2%', 12, 'gauden', 'vn'),
(111, 20, 'Tiger Bottle', '50K', 'ABV 5.0%', 30, 'tiger bottle', 'vn'),
(112, 20, 'Desperado Bottle', '60K', 'ABV 5.9%', 10, 'desperado', 'vn'),
(113, 21, 'Modern Belgian Dark', '200K', '500ml - IBU 23 - ABV 8.1%', 20, 'modern belgian dark', 'vn'),
(114, 21, 'Independence Stout', '220K', '500ml - IBU 68 - ABV 12%', 17, 'independence stout', 'vn'),
(115, 22, 'House Pours', '80K', NULL, 16, 'house pours', 'vn'),
(116, 22, 'Premium Pours', '90K - 175K', NULL, 23, 'premium pours', 'vn'),
(117, 23, 'Celery Sour', '120K', 'Gin, celery & lime juice, sugar syrup, egg whites, bitters', 6, 'celery', 'vn'),
(118, 23, 'Tropical Climax', '150K', 'Light rum, dark rum, apricot brandy, triple sec, pineapple, lime & fresh passion fruit juice.', 7, 'climax', 'vn'),
(119, 10, 'Coronita', '180K', 'Double shot tequila, triple sec, lime & passion fruit juice blended with ice, served in a large cocktail glass with a mini corona.', 9, 'coronita', 'vn'),
(120, 24, 'Sanama – Cabernet Sauvignon – Chile 2016', '90K/400K', 'Glass/Bottle', 27, 'sanama', 'vn'),
(121, 24, 'Woolshed – Merlot – Australia 2017', '95K/450K', 'Glass/Bottle', 34, 'woolshedmer', 'vn'),
(122, 24, 'Ribshack – Pinnotage/Merlot – South Africa 2016', '125K/680K', 'Glass/Bottle', 25, 'ribshack', 'vn'),
(123, 25, 'Casa Subercaseaux – Sauvignon Blanc – Chile 2017', '95K/420K', 'Glass/Bottle', 5, 'casa', 'vn'),
(124, 25, 'Woolshed - Sauvignon Blanc - Australia 2017', '95K/420K', 'Glass/Bottle', 35, 'woolshedsauv', 'vn'),
(125, 25, 'The Accomplice – Chardonnay – Australia 2016', '115K/550K', 'Glass/Bottle', 1, 'accomplice', 'vn'),
(126, 1, 'Saigon Steak N\\\' Eggs', '220K', 'Thick sliced beef brisket two fried eggs and grilled tomato with home made bread roll', 1, 'steakneggs', 'en'),
(127, 14, 'Saigon Steak N\\\' Eggs', '220K', 'Thick sliced beef brisket two fried eggs and grilled tomato with home made bread roll', 1, 'steakneggs', 'vn');

-- --------------------------------------------------------

--
-- Table structure for table `tapout_page`
--

CREATE TABLE `tapout_page` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tapout_page`
--

INSERT INTO `tapout_page` (`id`, `name`) VALUES
(1, 'Home'),
(2, 'Gallery'),
(3, 'Contact'),
(4, 'About');

-- --------------------------------------------------------

--
-- Table structure for table `tapout_page_item`
--

CREATE TABLE `tapout_page_item` (
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
-- Dumping data for table `tapout_page_item`
--

INSERT INTO `tapout_page_item` (`id`, `page_id`, `heading`, `content`, `created_at`, `edited_at`, `language`, `tag`, `page_position`) VALUES
(1, 1, 'Welcome', 'Join us for great BBQ, Craft Beers and introducing our Tap Tables. Book your Kegs now and have your own personal Tap on Table to enjoy while you support your teams.\r\n\r\nBook Your Tap Table Now!\r\ncontact@tapoutvietnam.com\r\n+84 28 62702700', '2018-10-13 19:25:46', NULL, 'en', 'welcome', 1),
(3, 4, 'Overview', 'We present a modernized model between restaurants and bar, serving an interesting twist on the all-year-round smoked BBQ’s. We are organized as a team of Dutch, Canadian and Vietnamese experts with an extensive amount of experience in hospitality from all over the world.', '2018-10-13 19:27:55', NULL, 'en', 'overview', 6),
(5, 4, 'MINNIE (HUE ANH)', 'Minnie (Hue Anh) has achieved a prolonged hospitality background by her initially studying in Switzerland and working experience in Qatar, the Cayman Islands. Finally, she returns to her sweet home Vietnam for further expanding her restaurants in Saigon.', '2018-10-13 19:27:55', NULL, 'en', 'minnie', 15),
(6, 4, 'GOAL', 'We have united together to bring one of a kind dishes, with the finest selection of beers and ciders as well as bottles of wine from our spacious cellar. A wide selection of BBQ’s cuisines, which have been smoked for hours, would also be a great accompany with the finest cocktails from Tapout’s mixologist.', '2018-10-13 19:27:55', NULL, 'en', 'goal', 14),
(13, 3, 'Address', '170 Cong Quynh\r\nDistrict 1\r\nHCMC', '2018-10-13 19:29:08', NULL, 'en', '', 10),
(14, 3, 'Contact', 'Contact Number: +84 963 806 071\r\nReservations: +84 28 62702700\r\nEmail: contact@tapoutvietnam.com', '2018-10-13 19:30:32', NULL, 'en', '', 7),
(15, 3, 'Social Media', 'https://www.facebook.com/tapout84/\r\nhttps://www.instagram.com/tapoutvietnam', '2018-10-13 19:30:32', NULL, 'en', '', 9),
(16, 3, 'Opening hours', 'Monday-Sunday: 11:00-Late', '2018-10-13 19:30:32', NULL, 'en', '', 8),
(17, 1, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía Nam', '2018-10-14 08:52:09', NULL, 'vn', '', 11),
(18, 4, 'VNOverview', 'We present a modernized model between restaurants and bar, serving an interesting twist on the all-year-round smoked BBQ’s. We are organized as a team of Dutch, Canadian and Vietnamese experts with an extensive amount of experience in hospitality from all over the world.', '2018-10-13 19:27:55', NULL, 'vn', 'overview', 6),
(20, 4, 'VNMINNIE (HUE ANH)', 'Minnie (Hue Anh) has achieved a prolonged hospitality background by her initially studying in Switzerland and working experience in Qatar, the Cayman Islands. Finally, she returns to her sweet home Vietnam for further expanding her restaurants in Saigon.', '2018-10-13 19:27:55', NULL, 'vn', 'minnie', 15),
(21, 4, 'VNGOAL', 'We have united together to bring one of a kind dishes, with the finest selection of beers and ciders as well as bottles of wine from our spacious cellar. A wide selection of BBQ’s cuisines, which have been smoked for hours, would also be a great accompany with the finest cocktails from Tapout’s mixologist.', '2018-10-13 19:27:55', NULL, 'vn', 'goal', 14),
(23, 1, 'VNWelcome', 'Join us for great BBQ, Craft Beers and introducing our Tap Tables. Book your Kegs now and have your own personal Tap on Table to enjoy while you support your teams.\r\n\r\nBook Your Tap Table Now!\r\ncontact@tapoutvietnam.com\r\n+84 28 62702700', '2018-10-13 19:25:46', NULL, 'vn', 'welcome', 1),
(63, 4, 'ENTrevor', 'Trever Noah', '2018-10-13 19:27:55', NULL, 'en', 'initializeDelete', 8),
(64, 4, 'VNTrevor', 'TREVER NOAH with the finest cocktails from Tapout’s mixologist.', '2018-10-13 19:27:55', NULL, 'vn', 'initializeDelete', 8),
(65, 4, 'EnHeadingTest', 'EnContentTest EnContentTest EnContentTest EnContentTest ', '2018-12-30 12:10:32', NULL, 'en', '41', 9),
(66, 4, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía Nam', '2018-12-30 12:10:32', NULL, 'vn', '41', 9),
(67, 4, 'EnHeadingTest', 'EnContentTest EnContentTest EnContentTest EnContentTest ', '2018-12-30 12:11:49', NULL, 'en', '43', 16),
(68, 4, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía Nam', '2018-12-30 12:11:49', NULL, 'vn', '43', 16),
(69, 4, 'EnHeadingTest', 'EnContentTest EnContentTest EnContentTest EnContentTest ', '2018-12-30 12:11:56', NULL, 'en', '45', 4),
(70, 4, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía Nam', '2018-12-30 12:11:56', NULL, 'vn', '45', 4),
(71, 4, 'Test from frontend', 'Content test from front end', '2018-12-30 12:14:47', NULL, 'en', '47', 3),
(72, 4, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía Nam', '2018-12-30 12:14:47', NULL, 'vn', '47', 3),
(73, 4, 'Test from frontend', 'Content test from front end', '2018-12-30 12:15:01', NULL, 'en', '49', 1),
(74, 4, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía NamDu lịch ở Rạch Giá, ở phía Nam', '2018-12-30 12:15:01', NULL, 'vn', '49', 1),
(77, 4, 'ENTesting', 'ENContent testing', '2018-12-30 18:36:02', NULL, 'en', '4b', 2),
(78, 4, 'VNTEsting', 'VNContent Testing', '2018-12-30 18:36:02', NULL, 'vn', '4b', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `image_list`
--
ALTER TABLE `image_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `imgUrl` (`imgUrl`);

--
-- Indexes for table `tapout_event_category`
--
ALTER TABLE `tapout_event_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tapout_event_item`
--
ALTER TABLE `tapout_event_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tapout_image`
--
ALTER TABLE `tapout_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `tapout_menu_category`
--
ALTER TABLE `tapout_menu_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tapout_menu_item`
--
ALTER TABLE `tapout_menu_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tapout_page`
--
ALTER TABLE `tapout_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tapout_page_item`
--
ALTER TABLE `tapout_page_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `image_list`
--
ALTER TABLE `image_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tapout_event_category`
--
ALTER TABLE `tapout_event_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tapout_event_item`
--
ALTER TABLE `tapout_event_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tapout_image`
--
ALTER TABLE `tapout_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tapout_menu_category`
--
ALTER TABLE `tapout_menu_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tapout_menu_item`
--
ALTER TABLE `tapout_menu_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `tapout_page`
--
ALTER TABLE `tapout_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tapout_page_item`
--
ALTER TABLE `tapout_page_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tapout_event_item`
--
ALTER TABLE `tapout_event_item`
  ADD CONSTRAINT `tapout_event_item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tapout_event_category` (`id`);

--
-- Constraints for table `tapout_image`
--
ALTER TABLE `tapout_image`
  ADD CONSTRAINT `tapout_image_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `tapout_page` (`id`);

--
-- Constraints for table `tapout_menu_item`
--
ALTER TABLE `tapout_menu_item`
  ADD CONSTRAINT `tapout_menu_item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tapout_menu_category` (`id`);

--
-- Constraints for table `tapout_page_item`
--
ALTER TABLE `tapout_page_item`
  ADD CONSTRAINT `tapout_page_item_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `tapout_page` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
