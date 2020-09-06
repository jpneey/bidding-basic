-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2020 at 11:57 AM
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
  `cs_bidding_status` int(11) NOT NULL,
  `cs_expired_notif` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_biddings`
--

INSERT INTO `cs_biddings` (`cs_bidding_id`, `cs_bidding_category_id`, `cs_bidding_user_id`, `cs_bidding_title`, `cs_bidding_permalink`, `cs_bidding_picture`, `cs_bidding_details`, `cs_bidding_tags`, `cs_bidding_location`, `cs_bidding_date_needed`, `cs_bidding_added`, `cs_bidding_expiration`, `cs_bidding_status`, `cs_expired_notif`) VALUES
(9, 2, 1, 'Arcu dui vivamus arcu felis', 'arcu-dui-vivamus-arcu-felis', 'jp-77365-images-(2).jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat, harum! Consectetur nesciunt adipisci a officiis beatae ab voluptatibus vel aperiam, sequi, esse eius nulla optio voluptas. Nam dicta voluptates quo?', 'bootstrap,poppers,ministop,jolliboy,McRonalds', 'Antipolo City', '2020-09-12 08:00:00', '2020-09-06 15:52:28', '2020-09-13 15:52:28', 2, 1),
(10, 1, 1, 'Looking for cheap flour', 'looking-for-cheap-flour', 'jp-47881-22012020011024.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ea corporis tempore quidem tempora iure debitis laudantium doloremque itaque quasi quam velit labore, veniam voluptatibus totam voluptatem rerum libero delectus praesentium.', 'flour,wheat,white,powder,food', 'Metro Manila', '2020-09-06 16:35:00', '2020-09-06 16:30:52', '2020-09-13 16:30:52', 2, 1),
(12, 1, 4, 'Lorem Gara bon tags', 'lorem-gara-bon-tags', '#!', 'Material icons are delightful, beautifully crafted symbols for common actions and items. Download on desktop to use them in your digital products for Android, iOS, and web.', 'gara,bon,tags', 'Antipolo City', '2020-09-11 08:00:00', '2020-09-06 16:57:16', '2020-09-13 16:57:16', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cs_bidding_winners`
--

CREATE TABLE `cs_bidding_winners` (
  `cs_winner_id` int(11) NOT NULL,
  `cs_offer_id` int(11) NOT NULL,
  `cs_bidding_id` int(11) NOT NULL,
  `cs_offer_owner_id` int(11) NOT NULL,
  `cs_bidding_owner_id` int(11) NOT NULL,
  `cs_offer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_bidding_winners`
--

INSERT INTO `cs_bidding_winners` (`cs_winner_id`, `cs_offer_id`, `cs_bidding_id`, `cs_offer_owner_id`, `cs_bidding_owner_id`, `cs_offer`) VALUES
(18, 20, 10, 2, 1, 'a:7:{s:7:\"product\";s:6:\"Flours\";s:3:\"qty\";s:2:\"25\";s:4:\"date\";s:16:\"2020-9-6 8:00:00\";s:5:\"notes\";s:129:\"I have content with broken images, multiple images in each page. Some images have empty src value and some just broken 404 links.\";s:3:\"img\";s:2:\"#!\";s:7:\"img-two\";s:2:\"#!\";s:5:\"price\";a:1:{i:0;s:9:\"4500.0000\";}}'),
(19, 22, 12, 3, 4, 'a:7:{s:7:\"product\";s:4:\"gata\";s:3:\"qty\";s:2:\"45\";s:4:\"date\";s:16:\"2020-9-6 8:00:00\";s:5:\"notes\";s:129:\"I have content with broken images, multiple images in each page. Some images have empty src value and some just broken 404 links.\";s:3:\"img\";s:2:\"#!\";s:7:\"img-two\";s:2:\"#!\";s:5:\"price\";a:1:{i:0;s:8:\"450.0000\";}}');

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
(1, 2, 'Dine-In Furnishing Corporation', 'dinein-furnishing-corporation', 'plastic chairs,tables,cooking utensils,plates,spoons and fork', 'a:5:{i:0;s:55:\"featured-product-65345-Plastic-Dining-Chairs-Panton.jpg\";i:1;s:33:\"Contemporary Plastic Dining Chair\";i:2;s:3:\"pcs\";i:3;s:1:\"1\";i:4;s:7:\"2499.99\";}', 1, 2),
(2, 3, 'Unsplash Corporation', 'unsplash-corporation', 'unsplash,poppins,roboto,sans,serif', '', 1, 2);

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
(2, 'Front-end', '');

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
-- Table structure for table `cs_notifications`
--

CREATE TABLE `cs_notifications` (
  `cs_notif_id` int(11) NOT NULL,
  `cs_notif_read` int(11) NOT NULL DEFAULT 0,
  `cs_notif` varchar(255) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_notifications`
--

INSERT INTO `cs_notifications` (`cs_notif_id`, `cs_notif_read`, `cs_notif`, `cs_user_id`, `cs_added`) VALUES
(21, 1, 'Bidding: <a data-to=\'bid/arcu-dui-vivamus-arcu-felis/\'><b>Arcu dui vivamus arcu felis</b></a> - New proposal was created', 1, '2020-09-06 16:10:45'),
(22, 1, 'Bidding: <a data-to=\'bid/arcu-dui-vivamus-arcu-felis/\'><b>Arcu dui vivamus arcu felis</b></a> - New proposal was created', 1, '2020-09-06 16:17:59'),
(25, 0, 'Bidding: <a data-to=\"bid/arcu-dui-vivamus-arcu-felis\"><b>Arcu dui vivamus arcu felis</b></a> has ended - No Supplier has won the bidding. Client rejected all proposals', 3, '2020-09-06 16:26:33'),
(26, 0, 'Bidding: <a data-to=\"bid/arcu-dui-vivamus-arcu-felis\"><b>Arcu dui vivamus arcu felis</b></a> has ended - No Supplier has won the bidding. Client rejected all proposals', 2, '2020-09-06 16:26:33'),
(27, 1, 'Bidding: <a data-to=\'bid/looking-for-cheap-flour/\'><b>Looking for cheap flour</b></a> - New proposal was created', 1, '2020-09-06 16:31:32'),
(28, 1, 'Bidding: <a data-to=\'bid/looking-for-cheap-flour/\'><b>Looking for cheap flour</b></a> - New proposal was created', 1, '2020-09-06 16:32:06'),
(29, 1, 'Bidding: <a data-to\"bid/looking-for-cheap-flour\"><b>Looking for cheap flour</b></a> has expired.', 1, '2020-09-06 16:35:00'),
(30, 0, 'Bidding: <a data-to=\"bid/looking-for-cheap-flour\"><b>Looking for cheap flour</b></a> - bidding winner was chosen.', 3, '2020-09-06 16:40:15'),
(31, 0, 'Bidding: <a data-to=\"bid/looking-for-cheap-flour\"><b>Looking for cheap flour</b></a> - Congratulations! You won the bidding!', 2, '2020-09-06 16:40:15'),
(32, 1, 'Bidding: <a data-to=\'bid/lorem-gara-bon-tags/\'><b>Lorem Gara bon tags</b></a> - New proposal was created', 4, '2020-09-06 16:57:45'),
(33, 1, 'Bidding: <a data-to=\'bid/lorem-gara-bon-tags/\'><b>Lorem Gara bon tags</b></a> - New proposal was created', 4, '2020-09-06 16:58:59'),
(35, 0, 'Bidding: <a data-to=\"bid/lorem-gara-bon-tags\"><b>Lorem Gara bon tags</b></a> - bidding winner was chosen.', 2, '2020-09-06 17:01:35'),
(36, 0, 'Bidding: <a data-to=\"bid/lorem-gara-bon-tags\"><b>Lorem Gara bon tags</b></a> - Congratulations! You won the bidding!', 3, '2020-09-06 17:01:35'),
(37, 1, 'Bidding: <a data-to\"bid/lorem-gara-bon-tags\"><b>Lorem Gara bon tags</b></a> has expired.', 4, '2020-09-06 17:06:33'),
(38, 1, 'Bidding: <a data-to=\'bid/lorem-gara-bon-tags\'><b>Lorem Gara bon tags</b></a> - A proposal was deleted.', 4, '2020-09-06 17:13:38'),
(39, 1, 'Bidding: <a data-to=\'bid/tyu/\'><b>tyu</b></a> - New proposal was created', 1, '2020-09-06 17:40:04'),
(40, 1, 'Bidding: <a data-to=\"bid/tyu\"><b>tyu</b></a> has ended - No Supplier has won the bidding. Client rejected all proposals', 3, '2020-09-06 17:46:21');

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
  `cs_offer_status` int(1) NOT NULL DEFAULT 0,
  `cs_offer_success` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_offers`
--

INSERT INTO `cs_offers` (`cs_offer_id`, `cs_bidding_id`, `cs_user_id`, `cs_offer`, `cs_offer_price`, `cs_date_added`, `cs_offer_status`, `cs_offer_success`) VALUES
(17, 9, 3, 'a:6:{s:7:\"product\";s:9:\"Quon Elip\";s:3:\"qty\";s:2:\"15\";s:4:\"date\";s:16:\"2020-9-6 8:00:00\";s:5:\"notes\";s:172:\"Material icons are delightful, beautifully crafted symbols for common actions and items. Download on desktop to use them in your digital products for Android, iOS, and web.\";s:3:\"img\";s:28:\"jp-69405-D-UzWOyXUAEhPme.jpg\";s:7:\"img-two\";s:19:\"jp-29181-images.jpg\";}', '7399.9900', '2020-09-06 08:06:26', 2, 0),
(18, 9, 2, 'a:6:{s:7:\"product\";s:9:\"Quon Elip\";s:3:\"qty\";s:2:\"15\";s:4:\"date\";s:16:\"2020-9-6 8:00:00\";s:5:\"notes\";s:129:\"I have content with broken images, multiple images in each page. Some images have empty src value and some just broken 404 links.\";s:3:\"img\";s:2:\"#!\";s:7:\"img-two\";s:29:\"jp-30789-dribbble_shot_hd.png\";}', '6500.0000', '2020-09-06 08:17:59', 2, 0),
(19, 10, 3, 'a:6:{s:7:\"product\";s:6:\"Flours\";s:3:\"qty\";s:2:\"25\";s:4:\"date\";s:16:\"2020-9-6 8:00:00\";s:5:\"notes\";s:129:\"I have content with broken images, multiple images in each page. Some images have empty src value and some just broken 404 links.\";s:3:\"img\";s:2:\"#!\";s:7:\"img-two\";s:2:\"#!\";}', '5600.0000', '2020-09-06 08:31:32', 2, 0),
(20, 10, 2, 'a:6:{s:7:\"product\";s:6:\"Flours\";s:3:\"qty\";s:2:\"25\";s:4:\"date\";s:16:\"2020-9-6 8:00:00\";s:5:\"notes\";s:129:\"I have content with broken images, multiple images in each page. Some images have empty src value and some just broken 404 links.\";s:3:\"img\";s:2:\"#!\";s:7:\"img-two\";s:2:\"#!\";}', '4500.0000', '2020-09-06 08:32:06', 1, 1),
(22, 12, 3, 'a:6:{s:7:\"product\";s:4:\"gata\";s:3:\"qty\";s:2:\"45\";s:4:\"date\";s:16:\"2020-9-6 8:00:00\";s:5:\"notes\";s:129:\"I have content with broken images, multiple images in each page. Some images have empty src value and some just broken 404 links.\";s:3:\"img\";s:2:\"#!\";s:7:\"img-two\";s:2:\"#!\";}', '450.0000', '2020-09-06 08:58:59', 1, 0),
(24, 13, 3, 'a:6:{s:7:\"product\";s:2:\"ww\";s:3:\"qty\";s:2:\"22\";s:4:\"date\";s:16:\"2020-9-6 8:00:00\";s:5:\"notes\";s:8:\"asdadsas\";s:3:\"img\";s:2:\"#!\";s:7:\"img-two\";s:2:\"#!\";}', '22.0000', '2020-09-06 09:40:04', 2, 0);

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
(9, 9, 'Quon Elip', 'kg', 15, '8500.9900'),
(10, 10, 'Flours', 'kgs', 25, '6700.9900'),
(12, 12, 'gata', 'bon', 45, '670.9900');

-- --------------------------------------------------------

--
-- Table structure for table `cs_transactions`
--

CREATE TABLE `cs_transactions` (
  `cs_transaction_id` int(11) NOT NULL,
  `cs_bidder_id` int(11) NOT NULL,
  `cs_bid_owner_id` int(11) NOT NULL,
  `cs_bidding_title` varchar(255) NOT NULL,
  `cs_bidding_id` int(11) NOT NULL,
  `cs_is_success` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_transactions`
--

INSERT INTO `cs_transactions` (`cs_transaction_id`, `cs_bidder_id`, `cs_bid_owner_id`, `cs_bidding_title`, `cs_bidding_id`, `cs_is_success`) VALUES
(30, 2, 1, 'Looking for cheap flour', 10, 0),
(31, 2, 1, 'Looking for cheap flour', 10, 0),
(32, 3, 4, 'Lorem Gara bon tags', 12, 0);

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
  `cs_user_avatar` varchar(255) NOT NULL,
  `cs_account_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_users`
--

INSERT INTO `cs_users` (`cs_user_id`, `cs_user_name`, `cs_user_email`, `cs_contact_details`, `cs_user_detail`, `cs_user_password`, `cs_user_role`, `cs_user_avatar`, `cs_account_status`) VALUES
(1, 'jpneey', 'burato348@gmail.com', 'a:5:{s:11:\"cs_facebook\";N;s:11:\"cs_linkedin\";N;s:10:\"cs_website\";N;s:12:\"cs_telephone\";N;s:9:\"cs_mobile\";N;}', 'You are one click away on reaching the next step of Canvasspoint&#39;s registration process! Please click the button below to setup your account', '$2y$10$k4AYoKWROtb//0wZRqtnC.fq0Jdeh3xlNkgNPLF5193tB6bwOdUlS', '1', 'jp-95245-jp.jpg', 0),
(2, 'dine-in', 'supplier@mail.com', 'a:5:{s:11:\"cs_facebook\";N;s:11:\"cs_linkedin\";N;s:10:\"cs_website\";N;s:12:\"cs_telephone\";s:7:\"8700555\";s:9:\"cs_mobile\";s:11:\"09296209999\";}', 'When it comes to choosing the most perfect dining set for sale in the Philippines, look no further than Dine-In Furnishing. We have a wide range of furniture pieces which carries the creativity and ingenuity of every Filipino in the country. We take pride', '$2y$10$qkY8Vtz7p97.R2VerRzyPuKjRVResSXzyhaGsc78bXcJ.K2nNlArO', '2', 'jp-17177-08012020010811.png', 0),
(3, 'foo-bar', 'admin@mail.com', 'a:5:{s:11:\"cs_facebook\";N;s:11:\"cs_linkedin\";N;s:10:\"cs_website\";N;s:12:\"cs_telephone\";s:7:\"8700555\";s:9:\"cs_mobile\";s:11:\"09296209999\";}', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Distinctio nostrum aperiam autem, cum laborum nihil id tempore non voluptas explicabo quasi maiores a iure sit dolore doloremque blanditiis ratione iusto!', '$2y$10$qkY8Vtz7p97.R2VerRzyPuKjRVResSXzyhaGsc78bXcJ.K2nNlArO', '2', 'jp-89680-unsplash.jpg', 0),
(4, 'leafa', 'leafa@gmail.com', 'a:5:{s:11:\"cs_facebook\";N;s:11:\"cs_linkedin\";N;s:10:\"cs_website\";N;s:12:\"cs_telephone\";N;s:9:\"cs_mobile\";N;}', 'You are one click away on reaching the next step of Canvasspoint&#39;s registration process! Please click the button below to setup your account', '$2y$10$k4AYoKWROtb//0wZRqtnC.fq0Jdeh3xlNkgNPLF5193tB6bwOdUlS', '1', 'jp-65542-ae1c29bea800e5c1adde375bb4b06e56--simple-fashion-minimalist-fashion-minimalist-outfits.jpg', 0);

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
(12, 1, 2, 5, 'Thanks for making canvasspoint a better place');

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
-- Indexes for table `cs_bidding_winners`
--
ALTER TABLE `cs_bidding_winners`
  ADD PRIMARY KEY (`cs_winner_id`);

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
-- Indexes for table `cs_notifications`
--
ALTER TABLE `cs_notifications`
  ADD PRIMARY KEY (`cs_notif_id`);

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
-- Indexes for table `cs_transactions`
--
ALTER TABLE `cs_transactions`
  ADD PRIMARY KEY (`cs_transaction_id`);

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
  MODIFY `cs_option_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_biddings`
--
ALTER TABLE `cs_biddings`
  MODIFY `cs_bidding_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cs_bidding_winners`
--
ALTER TABLE `cs_bidding_winners`
  MODIFY `cs_winner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `cs_business`
--
ALTER TABLE `cs_business`
  MODIFY `cs_business_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `cs_notifications`
--
ALTER TABLE `cs_notifications`
  MODIFY `cs_notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `cs_offers`
--
ALTER TABLE `cs_offers`
  MODIFY `cs_offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `cs_products_in_biddings`
--
ALTER TABLE `cs_products_in_biddings`
  MODIFY `cs_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cs_transactions`
--
ALTER TABLE `cs_transactions`
  MODIFY `cs_transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `cs_users`
--
ALTER TABLE `cs_users`
  MODIFY `cs_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cs_user_address`
--
ALTER TABLE `cs_user_address`
  MODIFY `cs_address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_user_ratings`
--
ALTER TABLE `cs_user_ratings`
  MODIFY `cs_rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
