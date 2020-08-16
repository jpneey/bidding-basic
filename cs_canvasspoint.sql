-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2020 at 10:35 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs_canvasspoint`
--

-- --------------------------------------------------------

--
-- Table structure for table `cs_bidder_options`
--

CREATE TABLE `cs_bidder_options` (
  `cs_option_id` int(11) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_allowed_view` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_bidder_options`
--

INSERT INTO `cs_bidder_options` (`cs_option_id`, `cs_user_id`, `cs_allowed_view`) VALUES
(1, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cs_biddings`
--

CREATE TABLE `cs_biddings` (
  `cs_bidding_id` int(11) NOT NULL,
  `cs_bidding_category_id` int(11) NOT NULL,
  `cs_bidding_user_id` int(11) NOT NULL,
  `cs_bidding_title` varchar(64) NOT NULL,
  `cs_bidding_permalink` varchar(255) NOT NULL,
  `cs_bidding_picture` varchar(255) NOT NULL,
  `cs_bidding_details` text NOT NULL,
  `cs_bidding_tags` text NOT NULL,
  `cs_bidding_location` varchar(64) NOT NULL DEFAULT 'Metro Manila',
  `cs_bidding_date_needed` datetime NOT NULL,
  `cs_bidding_added` datetime NOT NULL DEFAULT current_timestamp(),
  `cs_bidding_expiration` datetime NOT NULL,
  `cs_bidding_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_biddings`
--

INSERT INTO `cs_biddings` (`cs_bidding_id`, `cs_bidding_category_id`, `cs_bidding_user_id`, `cs_bidding_title`, `cs_bidding_permalink`, `cs_bidding_picture`, `cs_bidding_details`, `cs_bidding_tags`, `cs_bidding_location`, `cs_bidding_date_needed`, `cs_bidding_added`, `cs_bidding_expiration`, `cs_bidding_status`) VALUES
(17, 2, 4, 'Looking for cheap flour', 'looking-for-cheap-flour', '#!', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. kkkllmm', 'flour,cheap,manila,cainta,pasig', 'Antipolo City', '2020-08-14 08:00:00', '2020-08-09 15:22:21', '2020-08-16 15:22:21', 0),
(18, 2, 4, 'Fresh Tomatoes', 'fresh-tomatoes', '#!', 'Diam sollicitudin tempor id eu nisl nunc mi. Euismod elementum nisi quis eleifend quam adipiscing vitae proin sagittis. Ut morbi tincidunt augue interdum velit euismod in pellentesque.', 'tomatoes,veggies,lorem,ipsum,test', 'Pasig City', '2020-08-15 08:00:00', '2020-08-09 15:24:36', '2020-08-16 15:24:36', 0),
(19, 1, 4, 'Electronic Doorlock', 'electronic-doorlock', '#!', 'Arcu felis bibendum ut tristique et egestas quis. Justo nec ultrices dui sapien. Venenatis urna cursus eget nunc scelerisque. Orci porta non pulvinar neque laoreet suspendisse interdum consectetur libero. Interdum varius sit amet mattis vulputate. Pretium vulputate sapien nec sagittis aliquam. Ullamcorper sit amet risus nullam eget.', 'lock,doors,cheap,asap,opp', 'Metro Manila', '2020-08-15 08:00:00', '2020-08-09 15:26:03', '2020-08-16 15:26:03', 0),
(20, 2, 4, 'The lorem de` connecttitur', 'the-lorem-de-connecttitur', 'jp-87105-22012020011024.jpg', 'Arcu felis bibendum ut tristique et egestas quis. Justo nec ultrices dui sapien. Venenatis urna cursus eget nunc scelerisque. Orci porta non pulvinar neque laoreet suspendisse interdum consectetur libero. Interdum varius sit amet mattis vulputate. Pretium vulputate sapien nec sagittis aliquam. Ullamcorper sit amet risus nullam eget.', 'pop,mattis,pepsi,paloma,koer', 'Metro Manila', '2020-08-15 08:00:00', '2020-08-09 15:28:28', '2020-08-16 15:28:28', 0),
(21, 1, 3, 'Graphic Artist(s)', 'graphic-artists', '#!', 'Quis viverra nibh cras pulvinar mattis nunc sed. Eget mauris pharetra et ultrices neque ornare. Aenean sed adipiscing diam donec adipiscing tristique.', 'quis,aenean,diam,solom', 'Pasig City', '2020-08-15 08:00:00', '2020-08-09 15:39:01', '2020-08-16 15:39:01', 0),
(22, 1, 3, 'Eget mauris pharetra et', 'eget-mauris-pharetra-et', 'jp-64427-18012020095723SKYE-minimalist-women-clothing-fashion-Kate-Chiffon-Blouse-Top-white.jpeg.jpeg', 'Eget mauris pharetra et  Quis viverra nibh cras pulvinar mattis nunc sed. Eget mauris pharetra et ultrices neque ornare. Aenean sed adipiscing diam donec adipiscing tristique.', 'quis,aenean,diam,solom', 'Pasig City', '2020-08-15 08:00:00', '2020-08-09 15:40:02', '2020-08-16 15:40:02', 0),
(23, 2, 3, 'Arcu dui vivamus arcu felis', 'arcu-dui-vivamus-arcu-felis', 'jp-94217-1401202009443211012020192129.jpeg.jpeg', 'Arcu dui vivamus arcu felis bibendum ut tristique et egestas. Fermentum posuere urna nec tincidunt praesent semper feugiat. Sagittis', 'Yuip,Jolome,sol,kurkor,peklas', 'Antipolo City', '2020-08-15 08:00:00', '2020-08-09 15:41:35', '2020-08-16 15:41:35', 0),
(24, 2, 4, 'Jolem Arcu dui vivamus arcu felis', 'jolem-arcu-dui-vivamus-arcu-felis', '#!', 'To add tags, just enterTo add tags, just enter your tag text and press enter. You can delete them by clicking on the close icon or by using your delete button. press enter. You To add tags, just enter your tag text and press enter. You can delete them by clicking on the close icon or by using your delete button.', 'button,pepsi,paloma,testss,ssssss', 'Antipolo City', '2020-08-22 08:00:00', '2020-08-16 16:30:37', '2020-08-23 16:30:37', 1),
(25, 1, 4, 'The lorem de` connecttitur', 'the-lorem-de-connecttitur-2', '#!', 'Sou can delete them by clicking on the close icon or by using your delete button.To add tags, just enter your tag text and press enter. You can delete them by clicking on the close icon or by using your delete button.To add tags, just enter your tag text and press enternter. You can delete them by clicking on the close icon or by using your delete button.', 'poppers,toppers,oo', 'Pasig City', '2020-08-22 08:00:00', '2020-08-16 16:34:26', '2020-08-23 16:34:26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cs_business`
--

CREATE TABLE `cs_business` (
  `cs_business_id` int(11) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_business_name` varchar(64) NOT NULL,
  `cs_business_link` varchar(125) NOT NULL,
  `cs_business_tags` varchar(255) NOT NULL,
  `cs_business_featured` text NOT NULL,
  `cs_business_status` int(11) NOT NULL DEFAULT 0,
  `cs_business_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_business`
--

INSERT INTO `cs_business` (`cs_business_id`, `cs_user_id`, `cs_business_name`, `cs_business_link`, `cs_business_tags`, `cs_business_featured`, `cs_business_status`, `cs_business_category`) VALUES
(4, 2, 'Pexel Photography', 'pexel-photography', 'photography,media,design,nice,pop', 'a:5:{i:0;s:41:\"featured-product-27591-08012020010538.jpg\";i:1;s:4:\"Mugs\";i:2;s:3:\"pcs\";i:3;s:2:\"50\";i:4;s:4:\"7000\";}', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cs_categories`
--

CREATE TABLE `cs_categories` (
  `cs_category_id` int(11) NOT NULL,
  `cs_category_name` varchar(255) NOT NULL,
  `cs_category_desciption` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_categories`
--

INSERT INTO `cs_categories` (`cs_category_id`, `cs_category_name`, `cs_category_desciption`) VALUES
(1, 'Miscelaneous', ''),
(2, 'Dining', '');

-- --------------------------------------------------------

--
-- Table structure for table `cs_locations`
--

CREATE TABLE `cs_locations` (
  `cs_location_id` int(11) NOT NULL,
  `cs_location_type` int(11) NOT NULL DEFAULT 2,
  `cs_location` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_locations`
--

INSERT INTO `cs_locations` (`cs_location_id`, `cs_location_type`, `cs_location`) VALUES
(1, 2, 'Metro Manila'),
(2, 2, 'Pasig City'),
(3, 2, 'Cainta'),
(4, 2, 'Antipolo City');

-- --------------------------------------------------------

--
-- Table structure for table `cs_offers`
--

CREATE TABLE `cs_offers` (
  `cs_offer_id` int(11) NOT NULL,
  `cs_bidding_id` int(11) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_offer` text NOT NULL,
  `cs_offer_price` decimal(13,4) NOT NULL,
  `cs_date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `cs_offer_status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_offers`
--

INSERT INTO `cs_offers` (`cs_offer_id`, `cs_bidding_id`, `cs_user_id`, `cs_offer`, `cs_offer_price`, `cs_date_added`, `cs_offer_status`) VALUES
(3, 19, 2, 'a:4:{s:7:\"product\";s:8:\"Doorlock\";s:3:\"qty\";s:2:\"10\";s:4:\"date\";s:16:\"2020-8-9 8:00:00\";s:5:\"notes\";s:45:\"I can do lower but you handle the shipping :P\";}', '4000.0000', '2020-08-09 08:07:12', 0),
(4, 20, 2, 'a:4:{s:7:\"product\";s:5:\"Pepsi\";s:3:\"qty\";s:2:\"30\";s:4:\"date\";s:17:\"2020-8-15 8:00:00\";s:5:\"notes\";s:45:\"I can do lower but you handle the shipping :P\";}', '6000.0000', '2020-08-09 08:29:35', 0),
(5, 19, 5, 'a:4:{s:7:\"product\";s:8:\"Doorlock\";s:3:\"qty\";s:1:\"6\";s:4:\"date\";s:17:\"2020-8-20 8:00:00\";s:5:\"notes\";s:45:\"I can do lower but you handle the shipping :P\";}', '4500.0000', '2020-08-14 10:37:21', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cs_products_in_biddings`
--

CREATE TABLE `cs_products_in_biddings` (
  `cs_product_id` int(11) NOT NULL,
  `cs_bidding_id` int(11) NOT NULL,
  `cs_product_name` varchar(255) NOT NULL,
  `cs_product_unit` varchar(5) NOT NULL,
  `cs_product_qty` int(10) NOT NULL,
  `cs_product_price` decimal(13,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_products_in_biddings`
--

INSERT INTO `cs_products_in_biddings` (`cs_product_id`, `cs_bidding_id`, `cs_product_name`, `cs_product_unit`, `cs_product_qty`, `cs_product_price`) VALUES
(16, 17, 'Flour', 'kg', 15, '6700.0000'),
(17, 18, 'Tomatoes', 'kg', 5, '800.0000'),
(18, 19, 'Doorlock', 'pcs', 3, '2500.0000'),
(19, 20, 'Pepsi', 'oz', 15, '5000.0000'),
(20, 21, 'Quis', 'kg', 5, '700.0000'),
(21, 22, 'Quis', 'kg', 5, '700.0000'),
(22, 23, 'tristique et egestas', 'cm', 15, '9890.5600'),
(23, 24, 'Item de lorem', 'oz', 5, '7000.0000'),
(24, 25, 'Floor', 'gang', 13, '22.0000');

-- --------------------------------------------------------

--
-- Table structure for table `cs_users`
--

CREATE TABLE `cs_users` (
  `cs_user_id` int(11) NOT NULL,
  `cs_user_name` varchar(64) NOT NULL,
  `cs_user_email` varchar(64) NOT NULL,
  `cs_contact_details` text DEFAULT NULL,
  `cs_user_detail` varchar(255) DEFAULT NULL,
  `cs_user_password` varchar(255) NOT NULL,
  `cs_user_role` varchar(64) NOT NULL,
  `cs_user_avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_users`
--

INSERT INTO `cs_users` (`cs_user_id`, `cs_user_name`, `cs_user_email`, `cs_contact_details`, `cs_user_detail`, `cs_user_password`, `cs_user_role`, `cs_user_avatar`) VALUES
(2, 'pexelss', 'supplier@mail.com', 'a:5:{s:11:\"cs_facebook\";s:20:\"https://facebook.com\";s:11:\"cs_linkedin\";s:19:\"https://linkedin.ph\";s:10:\"cs_website\";s:18:\"https://pexels.com\";s:12:\"cs_telephone\";s:7:\"7778999\";s:9:\"cs_mobile\";s:10:\"0929567890\";}', 'When dynamically changing the value of a textarea with methods like jQuery&#39;s .val(), you must trigger an autoresize on it afterwords because .val() does not automatically trigger the events we&#39;ve binded to the textarea.', '$2y$10$m9FtVWlOKuC2X/7LOfLmNeVVhv5RofyqW7kpz41F/BN7/m/obSNYi', '2', 'jp-20456-08012020010811.png'),
(3, 'leafa', 'leafa@gmail.com', 'a:5:{s:11:\"cs_facebook\";s:51:\"https://material.io/resources/icons/?style=baseline\";s:11:\"cs_linkedin\";N;s:10:\"cs_website\";N;s:12:\"cs_telephone\";N;s:9:\"cs_mobile\";N;}', 'Textareas allow larger expandable user input. The border should light up simply and clearly indicating which field the user is currently editing. You must have a .input-field div wrapping your input and label. This is only used in our Input and Textarea f', '$2y$10$GIkk9Xu3c0VIzBbhkABzFub37Bo2398lUWR91hSkGyi58aMCASrFu', '1', 'jp-57753-13012020004623.jpg'),
(4, 'jpneey', 'burato348@gmail.com', 'a:5:{s:11:\"cs_facebook\";N;s:11:\"cs_linkedin\";N;s:10:\"cs_website\";N;s:12:\"cs_telephone\";N;s:9:\"cs_mobile\";N;}', 'You are one click away on reaching the next step of Canvasspoint&#39;s registration process! Please click the button below to setup your account', '$2y$10$qkY8Vtz7p97.R2VerRzyPuKjRVResSXzyhaGsc78bXcJ.K2nNlArO', '1', 'jp-95245-jp.jpg'),
(5, 'supplier-2', 'supplier-2@mail.com', NULL, 'advanced note: When dynamically changing the value of a textarea with methods like jQuery&#39;s .val(), you must trigger an autoresize on it afterwords because .val() does not automatically trigger the events we&#39;ve binded to the textarea.', '$2y$10$m9FtVWlOKuC2X/7LOfLmNeVVhv5RofyqW7kpz41F/BN7/m/obSNYi', '2', 'jp-20456-08012020010811.png');

-- --------------------------------------------------------

--
-- Table structure for table `cs_user_address`
--

CREATE TABLE `cs_user_address` (
  `cs_address_id` int(11) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_address_province` varchar(255) NOT NULL,
  `cs_address_city` varchar(255) NOT NULL,
  `cs_address_line` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cs_user_ratings`
--

CREATE TABLE `cs_user_ratings` (
  `cs_rating_id` int(11) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_user_rated_id` int(11) NOT NULL,
  `cs_rating` int(5) NOT NULL,
  `cs_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_user_ratings`
--

INSERT INTO `cs_user_ratings` (`cs_rating_id`, `cs_user_id`, `cs_user_rated_id`, `cs_rating`, `cs_comment`) VALUES
(1, 3, 4, 4, 'Quis viverra nibh cras pulvinar mattis nunc sed. Eget mauris pharetra et ultrices neque ornare. Aenean sed adipiscing diam donec adipiscing tristique. Lore'),
(2, 2, 3, 2, 'Quis viverra nibh cras pulvinar mattis nunc sed. Eget mauris pharetra et ultrices neque ornare. Aenean sed adipiscing diam donec adipiscing tristique. Lore'),
(3, 3, 2, 3, 'A Quis viverra nibh cras pulvinar mattis nunc sed. Eget mauris pharetra et ultrices neque ornare. Aenean sed adipiscing diam donec adipiscing tristique. Lore');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cs_bidder_options`
--
ALTER TABLE `cs_bidder_options`
  ADD PRIMARY KEY (`cs_option_id`);

--
-- Indexes for table `cs_biddings`
--
ALTER TABLE `cs_biddings`
  ADD PRIMARY KEY (`cs_bidding_id`);

--
-- Indexes for table `cs_business`
--
ALTER TABLE `cs_business`
  ADD PRIMARY KEY (`cs_business_id`);

--
-- Indexes for table `cs_categories`
--
ALTER TABLE `cs_categories`
  ADD PRIMARY KEY (`cs_category_id`);

--
-- Indexes for table `cs_locations`
--
ALTER TABLE `cs_locations`
  ADD PRIMARY KEY (`cs_location_id`);

--
-- Indexes for table `cs_offers`
--
ALTER TABLE `cs_offers`
  ADD PRIMARY KEY (`cs_offer_id`);

--
-- Indexes for table `cs_products_in_biddings`
--
ALTER TABLE `cs_products_in_biddings`
  ADD PRIMARY KEY (`cs_product_id`);

--
-- Indexes for table `cs_users`
--
ALTER TABLE `cs_users`
  ADD PRIMARY KEY (`cs_user_id`);

--
-- Indexes for table `cs_user_address`
--
ALTER TABLE `cs_user_address`
  ADD PRIMARY KEY (`cs_address_id`);

--
-- Indexes for table `cs_user_ratings`
--
ALTER TABLE `cs_user_ratings`
  ADD PRIMARY KEY (`cs_rating_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cs_bidder_options`
--
ALTER TABLE `cs_bidder_options`
  MODIFY `cs_option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_biddings`
--
ALTER TABLE `cs_biddings`
  MODIFY `cs_bidding_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `cs_business`
--
ALTER TABLE `cs_business`
  MODIFY `cs_business_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cs_categories`
--
ALTER TABLE `cs_categories`
  MODIFY `cs_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_locations`
--
ALTER TABLE `cs_locations`
  MODIFY `cs_location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cs_offers`
--
ALTER TABLE `cs_offers`
  MODIFY `cs_offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cs_products_in_biddings`
--
ALTER TABLE `cs_products_in_biddings`
  MODIFY `cs_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cs_users`
--
ALTER TABLE `cs_users`
  MODIFY `cs_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cs_user_address`
--
ALTER TABLE `cs_user_address`
  MODIFY `cs_address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_user_ratings`
--
ALTER TABLE `cs_user_ratings`
  MODIFY `cs_rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
