-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2018 at 08:08 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tapout_event_category`
--

INSERT INTO `tapout_event_category` (`id`, `name`, `type`, `language`, `created_at`, `edited_at`, `active`) VALUES
(1, 'Weekly Specials', 'weekly', 'en', '2018-10-14 08:44:30', NULL, 1),
(2, 'Du lịch ở Rạch Giá, ở phía Nam', 'unique', 'vn', '2018-10-14 08:53:03', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tapout_event_item`
--

CREATE TABLE `tapout_event_item` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `heading` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `start_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tapout_event_item`
--

INSERT INTO `tapout_event_item` (`id`, `category_id`, `heading`, `description`, `start_time`, `end_time`, `start_date`, `created_at`, `edited_at`) VALUES
(1, 1, 'Daily Happy Hour', 'Buy one Cocktail, get one free from 4pm-7pm', '16:00:00', '19:00:00', '0000-00-00', '2018-10-14 08:49:10', NULL),
(2, 1, 'Tap Out Mondays', '6x wings any style, 1 medium Rooster bia - 130K ₫\r\n12x wings any style, 1 pint Rooster bia - 210K ₫\r\n24x wings any style, 4x medium Rooster bia 350K ₫\r\nBuy 2 get the 3rd FREE on Rooster Bia\'s all night', NULL, NULL, '0000-00-00', '2018-10-14 08:49:10', NULL),
(3, 1, 'Rooster Night, Tuesdays', '20% off all food items', NULL, NULL, '0000-00-00', '2018-10-14 08:50:20', NULL),
(4, 1, 'Why Wine? Wednesdays', '50% on all house wines by the glass', NULL, NULL, '0000-00-00', '2018-10-14 08:50:20', NULL),
(5, 1, 'Tap That Keg Thursdays', 'Half a rack of ribs, choice of two sides, and free flow Tiger draft!!!', NULL, NULL, '0000-00-00', '2018-10-14 08:50:40', NULL),
(6, 2, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía Nam', NULL, NULL, '0000-00-00', '2018-10-14 08:53:13', NULL);

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
  `page_position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tapout_menu_category`
--

INSERT INTO `tapout_menu_category` (`id`, `name`, `type`, `active`, `language`, `page_position`) VALUES
(1, 'Starters', 'food', 1, 'en', 1),
(2, 'Burgers & Sandwiches', 'food', 1, 'en', 20),
(3, 'Mains', 'food', 1, 'en', 30),
(4, 'Sides', 'food', 1, 'en', 3),
(5, 'Desserts', 'food', 1, 'en', 10),
(6, 'On-tap', 'drink', 1, 'en', 5),
(7, 'Bottles', 'drink', 1, 'en', 6),
(8, 'Special-Beers', 'drink', 1, 'en', 7),
(9, 'Mixers', 'drink', 1, 'en', 100),
(10, 'Cocktails', 'drink', 1, 'en', 9),
(11, 'Red Wine', 'drink', 1, 'en', 12),
(12, 'White Wine', 'drink', 1, 'en', 11),
(13, 'Rose & Prosecco', 'drink', 1, 'en', 13),
(14, 'Du lịch ở Rạch Giá, ở phía Nam', 'food', 1, 'vn', 14);

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
  `category_position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tapout_menu_item`
--

INSERT INTO `tapout_menu_item` (`id`, `category_id`, `title`, `price`, `description`, `category_position`) VALUES
(1, 1, 'Grilled Peanut Butter Pad Thai Chicken Skewer', '25K', NULL, 11),
(2, 1, 'Grilled Teriyaki Beef Skewer', '30K', NULL, 111),
(3, 1, 'Cajun Prawns 1 / 3', '60K / 150K', 'Marinated & Grilled Prawn skewers, served with avocado crema', 1111),
(4, 1, 'Fried Oysters', '85K', 'Topped with pomegranate molasses, cool ranch dressing and diced jalapeno', 2),
(5, 1, 'Onion Blossom', '75K', 'Full white onion carved into a blossom shape then battered & fried, served with a spicy cocktail sauce', 1),
(6, 1, 'Prawn Tacos', '85K', '2 homemade flour tortillas, avodaco crema, cajun prawns, sauteed onions & red pepper, marinated mango, sour cream', 6),
(7, 1, 'Pulled Pork Tacos', '75K', '2 homemade flour tortillas, avocado crema, pickled red cabbage, smoked pork shoulder, pineapple salsa, sour cream', 7),
(8, 1, 'Fried Chicken Wings 6pcs / 12pcs', '90K / 170K', 'Choice of sweet & sticky bourbon or Siracha Buffalo sauce', -1),
(9, 1, 'Grilled Prawn Salad', '150K', 'Grilled prawns, roasted peppers & zucchini, cherry tomatoes, goats cheese, rosemary vinaigrette', -4),
(10, 1, 'Mac ‘N Cheese Balls', '75K', 'Cheddar & bacon macaroni rolled into balls and fried. Topped with cool ranch dressing, bacon, cheddar cheese and green onions.', 20),
(13, 1, 'Chili Con Carne Small / Large', '75K / 125K', 'A bowl of homemade chili topped with cheddar cheese, fried tortillas, sour cream & green onions', -15),
(14, 1, 'Spinach & Artichoke DipSpinach & Artichoke Dip', '85K', 'Cold dip served with homemade chips, and assorted fresh vegetables', 156),
(15, 1, 'Chili Cheese Fries', '155K', 'Hand cut fries topped with homemade chili, cheddar cheese, sour cream & green onions', 5116),
(16, 1, 'Loaded Fries', '140K', 'Hand cut fries topped with pulled pork, bacon, cheddar cheese and Cool Ranch dressing', -1456),
(19, 2, 'Served with a side of your choice', NULL, NULL, 0),
(22, 2, 'Classic Burger', '125K', '150gr beef patty, lettuce, tomato, onion, pickle, ketchup & mustard', 0),
(23, 2, 'Bacon & Cheese Burger', '150K', '150gr beef patty, lettuce, tomato, smoked bacon, cheddar cheese, dill pickle, ketchup & mustard', 0),
(24, 2, 'Bacon, Cranberry and Brie Burger', '185K', '150gr beef patty, smoke bacon, brie cheese, homemade cranberry sauce and lettuce', 0),
(25, 2, 'The TAP OUT BOMB', '250K', '125gr wheel of Camembert breaded and fried, 150gr beef patty, lettuce, tomato, homemade mustard sauce', 0),
(26, 2, 'Chili Cheese Dogs Single / Double', '110K / 185K', 'Frankfurters in a grilled bun topped with chili con carne, cheddar cheese & diced Jalepenos', 0),
(27, 2, 'Cubano Sandwich', '160K', 'Smoked pork shoulder, ham, Swiss cheese, dill pickles, yellow mustard. Pressed in a Cuban style bread', 0),
(28, 2, 'Pulled Pork Sandwich', '150K', 'Smoked & pulled pork shoulder topped with green apple coleslaw, served with a side of your choice', 0),
(29, 2, 'Steak Sandwich', '200K', '125g grilled Australian rib eye, marinated red peppers & zucchini, coriander & lime chimichurri and cheddar cheese. Served on a homemade grilled light rye bread.', 0),
(30, 2, 'Montreal Smoked Meat Sandwich', '180K', 'Wood smoked cured brisket in our homemade rye bread, smothered in yellow mustard, served with hand cut fries, coleslaw and kosher dill', 0),
(31, 3, 'Wood Smoked Ribs Half / Full Rack', '300K / 550K', 'Served with Two Choice of Sides', -20),
(32, 3, '250g Australian Grain fed Rib Eye Steak', '250K', 'Flame grilled and pan finished with butter, garlic and rosemary', 0),
(33, 3, 'Fish & Chips', '170K', 'Beer battered fish and fries, served with a homemade tartar sauce', 0),
(34, 3, 'Bourbon Chicken', '160K', 'Grilled chicken breast coated in a sweet & sticky bourbon sauce, topped with goats cheese and avocado, served with a side of your choice', 0),
(35, 4, 'Hand Cut Fries', '50K', NULL, 0),
(36, 4, 'Sweet Potato Fries', '50K', NULL, 0),
(37, 4, 'Salad', '45K', 'Lettuce, cherry tomato, marinated zucchini & peppers, rosemary vinaigrette', 0),
(38, 4, 'Green Beans', '40K', 'Steamed and tossed with butter, garlic and cherry tomatoes', 0),
(39, 4, 'Coleslaw', '35K', NULL, 0),
(40, 5, 'Ice cream tacos', '90K', 'Homemade cheesecake & fudge, peanut butter, vanilla ice cream stuffed into a home made waffle “taco” cone', 0),
(41, 5, 'Group Ice Cream Tacos deal:', '230K', '3 Tacos', 0),
(42, 5, 'Baked Pineapple & Camembert', '190K', '125g Camembert wheel oven baked topped with a sweet pineapple reduction. Served with toasted bread.', 0),
(43, 5, 'Banana Foster', '90K', 'Bananas flambéed with dark rum & banana liqueur, brown sugar and cinnamon, served with coconut ice cream', 0),
(44, 6, 'East West Triple IPA', '110K', 'IBU 75 - ABV 11.0%', 0),
(45, 6, 'East West Pale Ale', '90K', 'IBU 32 – ABV 6.0%', 0),
(47, 6, 'Pasteur Street Jasmin IPA', '90K', 'IBU 50 - ABV 6.5%', 0),
(48, 6, 'Pasteur Street Passion Fruit Wheat Ale', '90K', 'IBU 15 - ABV 4.0%', 0),
(49, 6, 'Heart Of Darkness Loose Rivet New England IPA', '95K', 'IBU 59 - ABV 7.5%', 0),
(50, 6, 'Heart Of Darkness Mexican Pilsner', '90K', 'IBU 24 - ABV 4.2%', 0),
(51, 6, 'Te Te White Ale', '85K', 'IBU 19 - ABV 5.5%', 0),
(52, 6, 'Hanoi Cider', '100K', 'ABV 6.0%', 0),
(55, 6, 'Rooster Beers Blonde', '40K, 50K, 70K', 'S, M, L', 0),
(56, 6, 'ROOSTER BEERS DARK', '50K, 60K, 80K', 'S, M, L', 0),
(57, 6, 'Tiger Draft Small', '40K', 'ABV 5.0%', 0),
(58, 6, 'Tiger Draft Big', '60K', 'ABV 5.0%', 0),
(59, 7, 'Gauden Schwarzbier', '70K', 'ABV 5.2%', 0),
(60, 7, 'Tiger Bottle', '50K', 'ABV 5.0%', 0),
(61, 7, 'Desperado Bottle', '60K', 'ABV 5.9%', 0),
(62, 8, 'Modern Belgian Dark', '200K', '500ml - IBU 23 - ABV 8.1%', 0),
(63, 8, 'Independence Stout', '220K', '500ml - IBU 68 - ABV 12%', 0),
(66, 9, 'House Pours', '80K', NULL, 10),
(67, 9, 'Premium Pours', '90K - 175K', NULL, 0),
(68, 10, 'Celery Sour', '120K', 'Gin, celery & lime juice, sugar syrup, egg whites, bitters', 0),
(69, 10, 'Tropical Climax', '150K', 'Light rum, dark rum, apricot brandy, triple sec, pineapple, lime & fresh passion fruit juice.', 0),
(72, 10, 'Coronita', '180K', 'Double shot tequila, triple sec, lime & passion fruit juice blended with ice, served in a large cocktail glass with a mini corona.', 0),
(73, 10, 'Espresso Martini', '120K', 'Vodka, Kahlua, Baileys, Vietnamese café, vanilla.', 0),
(74, 10, 'Deep South Peach Tea', '130K', 'Vodka, peach liqueur, peach puree, lime juice, bitters, earl grey honey tea', 0),
(75, 10, 'Long Island', '120K', 'Vodka, rum, gin, tequila, triple sec, sugar syrup, lime juice, coke.', 0),
(76, 10, 'Tito\'s Bloody Mary', '175K', 'Tito’s Vodka, Horseradish, lime juice, Tabasco, Worcestershire sauce, kosher salt, ground pepper in Tomato juice.', 0),
(77, 11, 'Sanama – Cabernet Sauvignon – Chile 2016', '90K/400K', 'Glass/Bottle', 0),
(78, 11, 'Woolshed – Merlot – Australia 2017', '95K/450K', 'Glass/Bottle', 0),
(79, 11, 'Ribshack – Pinnotage/Merlot – South Africa 2016', '125K/680K', 'Glass/Bottle', 0),
(80, 11, 'Yalumba – Shiraz/Viognier – Australia 2015', '945K', 'Bottle', 0),
(81, 11, 'Alta Vista – Malbec – Argentina 2016', '1,250K', 'Bottle', 0),
(82, 12, 'Casa Subercaseaux – Sauvignon Blanc – Chile 2017', '95K/420K', 'Glass/Bottle', 0),
(83, 12, 'Woolshed - Sauvignon Blanc - Australia 2017', '95K/420K', 'Glass/Bottle', 0),
(84, 12, 'The Accomplice – Chardonnay – Australia 2016', '115K/550K', 'Glass/Bottle', 0),
(85, 12, 'Allan Scott – Sauvignon Blanc – New Zealand 2017', '1,000K', 'Bottle', 0),
(86, 13, 'Vignerons St. Tropez – Grenache/Cinsault – France', '1,000K', 'Bottle', 0),
(87, 13, 'Tommasi Filo Dora Prosecco – Italy', '1,200K', 'Bottle', 0),
(88, 14, 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía Nam', 'Du lịch ở Rạch Giá, ở phía Nam', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tapout_menu_item`
--
ALTER TABLE `tapout_menu_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

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
