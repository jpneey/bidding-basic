-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2020 at 02:05 PM
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
  `cs_bidding_location` varchar(64) NOT NULL DEFAULT 'Metro Manila',
  `cs_bidding_date_needed` datetime NOT NULL,
  `cs_bidding_added` datetime NOT NULL DEFAULT current_timestamp(),
  `cs_bidding_expiration` datetime NOT NULL,
  `cs_bidding_status` int(11) NOT NULL
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
  `cs_location` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_locations`
--

INSERT INTO `cs_locations` (`cs_location_id`, `cs_location`) VALUES
(1, 'Metro Manila'),
(2, 'Pasig City'),
(3, 'Cainta'),
(4, 'Antipolo City');

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
(2, 'pexelss', 'supplier@mail.com', NULL, 'advanced note: When dynamically changing the value of a textarea with methods like jQuery&#39;s .val(), you must trigger an autoresize on it afterwords because .val() does not automatically trigger the events we&#39;ve binded to the textarea.', '$2y$10$m9FtVWlOKuC2X/7LOfLmNeVVhv5RofyqW7kpz41F/BN7/m/obSNYi', '2', 'jp-20456-08012020010811.png'),
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
(1, 3, 4, 4, 'good'),
(2, 2, 3, 2, 'good');

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
-- AUTO_INCREMENT for table `cs_biddings`
--
ALTER TABLE `cs_biddings`
  MODIFY `cs_bidding_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `cs_offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_products_in_biddings`
--
ALTER TABLE `cs_products_in_biddings`
  MODIFY `cs_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `cs_rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
