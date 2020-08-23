-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2020 at 12:25 PM
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
  `cs_bidding_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `cs_transactions`
--

CREATE TABLE `cs_transactions` (
  `cs_transaction_id` int(11) NOT NULL,
  `cs_bidder_id` int(11) NOT NULL,
  `cs_bid_owner_id` int(11) NOT NULL,
  `cs_bidding_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'jpneey', 'burato348@gmail.com', 'a:5:{s:11:\"cs_facebook\";N;s:11:\"cs_linkedin\";N;s:10:\"cs_website\";N;s:12:\"cs_telephone\";N;s:9:\"cs_mobile\";N;}', 'You are one click away on reaching the next step of Canvasspoint&#39;s registration process! Please click the button below to setup your account', '$2y$10$qkY8Vtz7p97.R2VerRzyPuKjRVResSXzyhaGsc78bXcJ.K2nNlArO', '1', 'jp-95245-jp.jpg', 0);

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
  MODIFY `cs_bidding_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_business`
--
ALTER TABLE `cs_business`
  MODIFY `cs_business_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `cs_offer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_products_in_biddings`
--
ALTER TABLE `cs_products_in_biddings`
  MODIFY `cs_product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_transactions`
--
ALTER TABLE `cs_transactions`
  MODIFY `cs_transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_users`
--
ALTER TABLE `cs_users`
  MODIFY `cs_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_user_address`
--
ALTER TABLE `cs_user_address`
  MODIFY `cs_address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_user_ratings`
--
ALTER TABLE `cs_user_ratings`
  MODIFY `cs_rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
