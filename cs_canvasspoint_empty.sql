-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2021 at 06:04 AM
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
-- Table structure for table `cs_admin`
--

CREATE TABLE `cs_admin` (
  `cs_admin_id` int(11) NOT NULL,
  `cs_admin_user` varchar(64) NOT NULL,
  `cs_admin_password` varchar(255) NOT NULL,
  `cs_admin_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_admin`
--

INSERT INTO `cs_admin` (`cs_admin_id`, `cs_admin_user`, `cs_admin_password`, `cs_admin_role`) VALUES
(1, 'jpneey', '$2y$10$k4AYoKWROtb//0wZRqtnC.fq0Jdeh3xlNkgNPLF5193tB6bwOdUlS', 5);

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

-- --------------------------------------------------------

--
-- Table structure for table `cs_blogs`
--

CREATE TABLE `cs_blogs` (
  `cs_blog_id` int(11) NOT NULL,
  `cs_blog_title` varchar(255) NOT NULL,
  `cs_blog_permalink` varchar(300) NOT NULL,
  `cs_blog_featured_image` varchar(255) NOT NULL,
  `cs_blog_category_id` int(11) NOT NULL,
  `cs_blog_content` text NOT NULL,
  `cs_blog_description` varchar(500) NOT NULL,
  `cs_blog_keywords` varchar(500) NOT NULL,
  `cs_blog_added` date NOT NULL,
  `cs_blog_status` int(11) NOT NULL DEFAULT 0
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
(1, 'Miscelaneous', '');

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

-- --------------------------------------------------------

--
-- Table structure for table `cs_plans`
--

CREATE TABLE `cs_plans` (
  `cs_plan_id` int(11) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_plan_status` int(11) NOT NULL DEFAULT 0,
  `cs_to_open` int(11) NOT NULL DEFAULT 4,
  `cs_to_view` int(11) NOT NULL DEFAULT 4,
  `cs_to_featured` int(11) NOT NULL DEFAULT 3,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `cs_plan_payment` varchar(255) NOT NULL,
  `cs_gateway_comment` varchar(255) NOT NULL DEFAULT '',
  `expires` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cs_products`
--

CREATE TABLE `cs_products` (
  `cs_product_id` int(11) NOT NULL,
  `cs_category_id` int(11) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_product_name` varchar(500) NOT NULL,
  `cs_product_details` text NOT NULL,
  `cs_product_image` varchar(255) NOT NULL,
  `cs_product_price` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `cs_sale_price` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `cs_unit` varchar(255) NOT NULL,
  `cs_product_permalink` varchar(500) NOT NULL,
  `cs_link` varchar(500) NOT NULL DEFAULT '#!',
  `cs_link_text` varchar(50) NOT NULL DEFAULT 'Add to Cart',
  `cs_inquired` int(11) NOT NULL DEFAULT 0
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
-- Table structure for table `cs_store`
--

CREATE TABLE `cs_store` (
  `cs_setting_id` int(11) NOT NULL,
  `cs_setting_name` varchar(255) NOT NULL,
  `cs_setting_value` varchar(255) NOT NULL,
  `cs_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_store`
--

INSERT INTO `cs_store` (`cs_setting_id`, `cs_setting_name`, `cs_setting_value`, `cs_status`) VALUES
(1, 'admin_email', 'burato348@gmail.com', 1),
(2, 'admin_home', '1590,210,127,0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cs_tags`
--

CREATE TABLE `cs_tags` (
  `cs_tag_id` int(11) NOT NULL,
  `cs_category_id` int(11) NOT NULL,
  `cs_tag` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indexes for table `cs_admin`
--
ALTER TABLE `cs_admin`
  ADD PRIMARY KEY (`cs_admin_id`);

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
-- Indexes for table `cs_blogs`
--
ALTER TABLE `cs_blogs`
  ADD PRIMARY KEY (`cs_blog_id`);

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
-- Indexes for table `cs_plans`
--
ALTER TABLE `cs_plans`
  ADD PRIMARY KEY (`cs_plan_id`);

--
-- Indexes for table `cs_products`
--
ALTER TABLE `cs_products`
  ADD PRIMARY KEY (`cs_product_id`);

--
-- Indexes for table `cs_products_in_biddings`
--
ALTER TABLE `cs_products_in_biddings`
  ADD PRIMARY KEY (`cs_product_id`);

--
-- Indexes for table `cs_store`
--
ALTER TABLE `cs_store`
  ADD PRIMARY KEY (`cs_setting_id`);

--
-- Indexes for table `cs_tags`
--
ALTER TABLE `cs_tags`
  ADD PRIMARY KEY (`cs_tag_id`);

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
-- AUTO_INCREMENT for table `cs_admin`
--
ALTER TABLE `cs_admin`
  MODIFY `cs_admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `cs_bidding_winners`
--
ALTER TABLE `cs_bidding_winners`
  MODIFY `cs_winner_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_blogs`
--
ALTER TABLE `cs_blogs`
  MODIFY `cs_blog_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_business`
--
ALTER TABLE `cs_business`
  MODIFY `cs_business_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_categories`
--
ALTER TABLE `cs_categories`
  MODIFY `cs_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_locations`
--
ALTER TABLE `cs_locations`
  MODIFY `cs_location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cs_notifications`
--
ALTER TABLE `cs_notifications`
  MODIFY `cs_notif_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_offers`
--
ALTER TABLE `cs_offers`
  MODIFY `cs_offer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_plans`
--
ALTER TABLE `cs_plans`
  MODIFY `cs_plan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_products`
--
ALTER TABLE `cs_products`
  MODIFY `cs_product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_products_in_biddings`
--
ALTER TABLE `cs_products_in_biddings`
  MODIFY `cs_product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_store`
--
ALTER TABLE `cs_store`
  MODIFY `cs_setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_tags`
--
ALTER TABLE `cs_tags`
  MODIFY `cs_tag_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_transactions`
--
ALTER TABLE `cs_transactions`
  MODIFY `cs_transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_users`
--
ALTER TABLE `cs_users`
  MODIFY `cs_user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_user_address`
--
ALTER TABLE `cs_user_address`
  MODIFY `cs_address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_user_ratings`
--
ALTER TABLE `cs_user_ratings`
  MODIFY `cs_rating_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
