-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2020 at 03:56 PM
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
  `cs_bidding_date_needed` datetime NOT NULL,
  `cs_bidding_added` datetime NOT NULL DEFAULT current_timestamp(),
  `cs_bidding_expiration` datetime NOT NULL,
  `cs_bidding_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_biddings`
--

INSERT INTO `cs_biddings` (`cs_bidding_id`, `cs_bidding_category_id`, `cs_bidding_user_id`, `cs_bidding_title`, `cs_bidding_permalink`, `cs_bidding_picture`, `cs_bidding_details`, `cs_bidding_tags`, `cs_bidding_date_needed`, `cs_bidding_added`, `cs_bidding_expiration`, `cs_bidding_status`) VALUES
(36, 1, 1, 'Looking for white plastic cups', 'white-plastic-cups', 'jp-19133-0f93d75b43a854efa4b9660acfbbbdf0.jpg', 'Plastic cups are often used for gatherings where it would be inconvenient to wash dishes afterward, due to factors such as location or number of guests. Plastic cups can be used for storing most liquids, but hot liquids may melt or warp the material.', 'plastic cups,minimalist,white,birthdays,,,', '2020-07-26 08:00:00', '2020-07-21 22:07:03', '2020-07-28 22:07:03', 1);

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
(1, 'Manpower', '');

-- --------------------------------------------------------

--
-- Table structure for table `cs_offers`
--

CREATE TABLE `cs_offers` (
  `cs_offer_id` int(11) NOT NULL,
  `cs_bidding_id` int(11) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_offer` text NOT NULL
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

--
-- Dumping data for table `cs_products_in_biddings`
--

INSERT INTO `cs_products_in_biddings` (`cs_product_id`, `cs_bidding_id`, `cs_product_name`, `cs_product_unit`, `cs_product_qty`, `cs_product_price`) VALUES
(5, 36, 'Plastic cups', 'pcs', 150, '9996.9900');

-- --------------------------------------------------------

--
-- Table structure for table `cs_users`
--

CREATE TABLE `cs_users` (
  `cs_user_id` int(11) NOT NULL,
  `cs_user_name` varchar(64) NOT NULL,
  `cs_user_email` varchar(64) NOT NULL,
  `cs_user_password` varchar(255) NOT NULL,
  `cs_user_role` varchar(64) NOT NULL,
  `cs_user_avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_users`
--

INSERT INTO `cs_users` (`cs_user_id`, `cs_user_name`, `cs_user_email`, `cs_user_password`, `cs_user_role`, `cs_user_avatar`) VALUES
(1, 'jpneey', 'burato348@gmail.com', '$2y$05$Dw8tZp0alICppTOuHoSpi.PiUn3f3V1hrdZRIg9158shWQmW8UxgO', '1', 'jp.jpg'),
(2, 'supplier', 'supplier@mail.com', '$2y$05$Dw8tZp0alICppTOuHoSpi.PiUn3f3V1hrdZRIg9158shWQmW8UxgO', '2', '#!');

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

--
-- Dumping data for table `cs_user_address`
--

INSERT INTO `cs_user_address` (`cs_address_id`, `cs_user_id`, `cs_address_province`, `cs_address_city`, `cs_address_line`) VALUES
(1, 1, 'Rizal', 'Cainta', 'Penny lane st. Valley Golf, brgy. San Juan');

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
-- Indexes for table `cs_biddings`
--
ALTER TABLE `cs_biddings`
  ADD PRIMARY KEY (`cs_bidding_id`);

--
-- Indexes for table `cs_categories`
--
ALTER TABLE `cs_categories`
  ADD PRIMARY KEY (`cs_category_id`);

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
-- AUTO_INCREMENT for table `cs_biddings`
--
ALTER TABLE `cs_biddings`
  MODIFY `cs_bidding_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `cs_categories`
--
ALTER TABLE `cs_categories`
  MODIFY `cs_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_offers`
--
ALTER TABLE `cs_offers`
  MODIFY `cs_offer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_products_in_biddings`
--
ALTER TABLE `cs_products_in_biddings`
  MODIFY `cs_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cs_users`
--
ALTER TABLE `cs_users`
  MODIFY `cs_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_user_address`
--
ALTER TABLE `cs_user_address`
  MODIFY `cs_address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_user_ratings`
--
ALTER TABLE `cs_user_ratings`
  MODIFY `cs_rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
