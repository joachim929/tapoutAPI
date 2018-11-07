-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2018 at 10:45 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

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
-- Table structure for table `tapout_event_category`
--

CREATE TABLE `tapout_event_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` set('unique','weekly','bi-weekly','monthly','annually','biennial','quadrennial') COLLATE utf8_bin NOT NULL,
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
(2, 'VNUnique', 'unique', 'vn', 'unqiue', '2018-10-14 08:53:03', NULL, 1, 4),
(3, 'ENUnique', 'unique', 'en', 'unqiue', '2018-10-14 08:53:03', NULL, 1, 4),
(5, 'ENMonthly', 'monthly', 'en', 'monthly', '2018-10-14 08:53:03', NULL, 1, 2),
(6, 'VNMonthly', 'monthly', 'vn', 'monthly', '2018-10-14 08:53:03', NULL, 1, 2),
(10, 'VNWeekly', 'weekly', 'vn', 'weekly', '2018-10-14 08:44:30', NULL, 1, 1);

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
(1, 1, 'Daily Happy Hour', 'Buy one Cocktail, get one free from 4pm-7pm', '', '', '16:00:00', '19:00:00', 1541242800, 1641242800, NULL, 0),
(2, 1, 'Tap Out Mondays', '6x wings any style, 1 medium Rooster bia - 130K ₫\r\n12x wings any style, 1 pint Rooster bia - 210K ₫\r\n24x wings any style, 4x medium Rooster bia 350K ₫\r\nBuy 2 get the 3rd FREE on Rooster Bia\'s all night', '', '', NULL, NULL, 1541242800, 1641242800, NULL, 0),
(3, 1, 'Rooster Night, Tuesdays', '20% off all food items', '', '', NULL, NULL, 1541242800, 1641242800, NULL, 0),
(4, 1, 'Why Wine? Wednesdays', '50% on all house wines by the glass', '', '', NULL, NULL, 1541242800, 1641242800, NULL, 0),
(5, 1, 'Tap That Keg Thursdays', 'Half a rack of ribs, choice of two sides, and free flow Tiger draft!!!', '', '', NULL, NULL, 1541242800, 1641240800, NULL, 0),
(6, 2, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía Nam', '', '', NULL, NULL, 1541242800, 1681242800, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tapout_image`
--

CREATE TABLE `tapout_image` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `img_url` varchar(191) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `page_position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tapout_image`
--

INSERT INTO `tapout_image` (`id`, `page_id`, `img_url`, `created_at`, `page_position`) VALUES
(1, 2, 'src\\assets\\photos\\540\\0W5A4669.jpg', '2018-10-14 08:59:14', 0),
(2, 2, 'src\\assets\\photos\\540\\0W5A4678.jpg', '2018-10-14 08:59:14', 0),
(3, 2, 'src\\assets\\photos\\540\\0W5A4687.jpg', '2018-10-14 08:59:31', 0),
(4, 2, 'src\\assets\\photos\\540\\0W5A4696.jpg', '2018-10-14 08:59:31', 0),
(5, 2, 'src\\assets\\photos\\540\\0W5A4703.jpg', '2018-10-14 08:59:43', 0),
(6, 2, 'src\\assets\\photos\\540\\0W5A4760.jpg', '2018-10-14 08:59:43', 0),
(7, 2, 'src\\assets\\photos\\540\\0W5A4710.jpg', '2018-10-14 08:59:58', 0),
(8, 2, 'src\\assets\\photos\\540\\0W5A4714.jpg', '2018-10-14 08:59:58', 0),
(9, 2, 'src\\assets\\photos\\540\\0W5A4718.jpg', '2018-10-14 09:00:10', 0),
(10, 2, 'src\\assets\\photos\\540\\0W5A4728.jpg', '2018-10-14 09:00:10', 0),
(11, 2, 'src\\assets\\photos\\540\\0W5A4731.jpg', '2018-10-14 09:00:32', 0),
(12, 2, 'src\\assets\\photos\\540\\0W5A4732.jpg', '2018-10-14 09:00:32', 0),
(13, 2, 'src\\assets\\photos\\540\\0W5A4736.jpg', '2018-10-14 09:00:32', 0);

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
(1, 'Starters', 'food', 1, 'en', 1, 'starters'),
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
(14, 'VNStarters', 'food', 1, 'vn', 1, 'starters'),
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
(125, 25, 'The Accomplice – Chardonnay – Australia 2016', '115K/550K', 'Glass/Bottle', 1, 'accomplice', 'vn');

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
(1, 1, 'Welcome', 'Join us for great BBQ, Craft Beers and introducing our Tap Tables. Book your Kegs now and have your own personal Tap on Table to enjoy while you support your teams.\r\n\r\nBook Your Tap Table Now!\r\ncontact@tapoutvietnam.com\r\n+84 28 62702700', '2018-10-13 19:25:46', NULL, 'en', '', 0),
(3, 4, 'Overview', 'We present a modernized model between restaurants and bar, serving an interesting twist on the all-year-round smoked BBQ’s. We are organized as a team of Dutch, Canadian and Vietnamese experts with an extensive amount of experience in hospitality from all over the world.', '2018-10-13 19:27:55', NULL, 'en', '', 0),
(4, 4, 'Johann', 'Johann has also got an international background, having lived in Germany, England, Uganda and now here in Vietnam. He has worked all over Vietnam in the hospitality industry ranging from Ha Long bay, Hanoi, Sapa, Hoi An and for the past year in Saigon.', '2018-10-13 19:27:55', NULL, 'en', '', 0),
(5, 4, 'MINNIE (HUE ANH)', 'Minnie (Hue Anh) has achieved a prolonged hospitality background by her initially studying in Switzerland and working experience in Qatar, the Cayman Islands. Finally, she returns to her sweet home Vietnam for further expanding her restaurants in Saigon.', '2018-10-13 19:27:55', NULL, 'en', '', 0),
(6, 4, 'GOAL', 'We have united together to bring one of a kind dishes, with the finest selection of beers and ciders as well as bottles of wine from our spacious cellar. A wide selection of BBQ’s cuisines, which have been smoked for hours, would also be a great accompany with the finest cocktails from Tapout’s mixologist.', '2018-10-13 19:27:55', NULL, 'en', '', 0),
(7, 4, 'WHAT MAKES US DIFFERENT', 'Not only serving food and drink, we offer our diners a brand-new experience with our table taps. Customers can now help themselves to beers their own comfort whilst watching sports, or by competing against each other on different tables with the interactive tablets.', '2018-10-13 19:27:55', NULL, 'en', '', 0),
(13, 3, 'Address', '170 Cong Quynh\r\nDistrict 1\r\nHCMC', '2018-10-13 19:29:08', NULL, 'en', '', 0),
(14, 3, 'Contact', 'Contact Number: +84 963 806 071\r\nReservations: +84 28 62702700\r\nEmail: contact@tapoutvietnam.com', '2018-10-13 19:30:32', NULL, 'en', '', 0),
(15, 3, 'Social Media', 'https://www.facebook.com/tapout84/\r\nhttps://www.instagram.com/tapoutvietnam', '2018-10-13 19:30:32', NULL, 'en', '', 0),
(16, 3, 'Opening hours', 'Monday-Sunday: 11:00-Late', '2018-10-13 19:30:32', NULL, 'en', '', 0),
(17, 1, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía Nam', '2018-10-14 08:52:09', NULL, 'vn', '', 0);

--
-- Indexes for dumped tables
--

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
  ADD UNIQUE KEY `img_url` (`img_url`),
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
-- AUTO_INCREMENT for table `tapout_event_category`
--
ALTER TABLE `tapout_event_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tapout_event_item`
--
ALTER TABLE `tapout_event_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tapout_image`
--
ALTER TABLE `tapout_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tapout_menu_category`
--
ALTER TABLE `tapout_menu_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tapout_menu_item`
--
ALTER TABLE `tapout_menu_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `tapout_page`
--
ALTER TABLE `tapout_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tapout_page_item`
--
ALTER TABLE `tapout_page_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
