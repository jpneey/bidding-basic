-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2020 at 04:29 PM
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
(1, 'jpneey', '$2y$10$k4AYoKWROtb//0wZRqtnC.fq0Jdeh3xlNkgNPLF5193tB6bwOdUlS', 5),
(2, 'admin', '$2y$10$k4AYoKWROtb//0wZRqtnC.fq0Jdeh3xlNkgNPLF5193tB6bwOdUlS', 5);

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
(19, 12, 1, 'The lorem de` connecttitur', 'the-lorem-de-connecttitur', 'jp-17859-alex-harvey-nqSUnXINsp4-unsplash.jpg', 'Vivamus vel tortor metus. Mauris congue libero sapien. Maecenas dignissim tortor quis varius molestie. Donec sollicitudin quis tellus ac ullamcorper. Pellentesque quis ligula rutrum, feugiat neque vel, ullamcorper urna. Sed venenatis dolor quis nisl rutrum, non bibendum tellus dapibus. Etiam dictum semper augue ut feugiat. \r\n\r\nPhasellus sed orci blandit, maximus neque sit amet, vestibulum orci. Phasellus finibus mi a enim tristique, at vehicula nisl ullamcorper. Sed a lacus quam. Praesent commodo fringilla tincidunt. Nam eu pulvinar elit. Phasellus at urna mauris. Ut aliquet odio nec turpis convallis malesuada.', 'MySQL,Back End,API Development,Foo,Bar', 'Antipolo City', '2020-09-26 08:00:00', '2020-09-20 11:12:52', '2020-09-27 11:12:52', 1, 0),
(20, 1, 1, 'Aenean sagittis suscipit porta', 'aenean-sagittis-suscipit-porta', '#!', 'Maecenas dignissim tortor quis varius molestie. Donec sollicitudin quis tellus ac ullamcorper. Pellentesque quis ligula rutrum, feugiat neque vel, ullamcorper urna. Sed venenatis dolor quis nisl rutrum, non bibendum tellus dapibus. Etiam dictum semper augue ut feugiat. Phasellus sed orci blandit, maximus neque sit amet, vestibulum orci. Phasellus finibus mi a enim tristique, at vehicula nisl ullamcorper. Sed a lacus quam. Praesent commodo fringilla tincidunt. Nam eu pulvinar elit. Phasellus at urna mauris. Ut aliquet odio n', 'Baz,Dot,Pepo,Lomor,Darang', 'Metro Manila', '2020-09-26 08:00:00', '2020-09-20 11:19:38', '2020-09-27 11:19:38', 1, 0),
(21, 1, 4, 'Aliquam eu mattis mi', 'aliquam-eu-mattis-mi', 'jp-31708-TB2izPhq_lYBeNjSszcXXbwhFXa_!!109519775.jpg', 'Curabitur maximus, mauris eu blandit rhoncus, lacus sapien finibus velit, quis sollicitudin sem ligula eget est. In hac habitasse platea dictumst. Phasellus at lorem facilisis, facilisis risus ut, pulvinar quam. Morbi faucibus tempus convallis. Curabitur laoreet accumsan mauris vel imperdiet. Sed purus est, lobortis ut luctus a, ultrices quis enim. Etiam molestie et metus a dapibus.', 'Charibrys,Slime,Hero,Poppins,Mex', 'Metro Manila', '2020-09-26 08:00:00', '2020-09-20 11:21:47', '2020-09-27 11:21:47', 1, 0);

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

--
-- Dumping data for table `cs_blogs`
--

INSERT INTO `cs_blogs` (`cs_blog_id`, `cs_blog_title`, `cs_blog_permalink`, `cs_blog_featured_image`, `cs_blog_category_id`, `cs_blog_content`, `cs_blog_description`, `cs_blog_keywords`, `cs_blog_added`, `cs_blog_status`) VALUES
(2, 'Lorem De` Connectitur', 'lorem-de-connectitur21482', 'http://localhost/admin/app/static/upload/jpg-91463-alex-harvey-nqSUnXINsp4-unsplash.jpg', 2, '<div class=\"browser-default\"><div style=\"text-align:center;\"><img src=\"http://localhost/admin/app/static/upload/jpg-91463-alex-harvey-nqSUnXINsp4-unsplash.jpg\"></div><br class=\"browser-default\"></div>', 'Add radio buttons to a group by adding the name attribute along with the same corresponding value for each of the radio buttons in the group. Create disabled radio buttons by adding the disabled attribute as shown below.', 'boop,beep', '2020-09-23', 0);

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
(1, 2, 'Dine-In Furnishing Corporation', 'dinein-furnishing-corporation', 'plastic chairs,tables,cooking utensils,plates,spoons and fork', 'a:0:{}', 1, 2),
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
(2, 'Front-end', ''),
(12, 'Back End', 'Lorem Ipsum Dotor sit amet');

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
(19, 19, 'Lorem Ipsum', 'kg', 15, '7800.0000'),
(20, 20, 'Sincut', 'inche', 5, '5600.9900'),
(21, 21, 'Domor', 'box', 15, '9800.6900');

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

--
-- Dumping data for table `cs_tags`
--

INSERT INTO `cs_tags` (`cs_tag_id`, `cs_category_id`, `cs_tag`, `sort_order`) VALUES
(9, 12, 'API Development', 0),
(10, 12, 'MySQL', 0),
(11, 12, 'Foo', 0),
(12, 12, 'Back End', 0);

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
-- Indexes for table `cs_products_in_biddings`
--
ALTER TABLE `cs_products_in_biddings`
  ADD PRIMARY KEY (`cs_product_id`);

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
  MODIFY `cs_admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_bidder_options`
--
ALTER TABLE `cs_bidder_options`
  MODIFY `cs_option_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_biddings`
--
ALTER TABLE `cs_biddings`
  MODIFY `cs_bidding_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `cs_bidding_winners`
--
ALTER TABLE `cs_bidding_winners`
  MODIFY `cs_winner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `cs_blogs`
--
ALTER TABLE `cs_blogs`
  MODIFY `cs_blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_business`
--
ALTER TABLE `cs_business`
  MODIFY `cs_business_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_categories`
--
ALTER TABLE `cs_categories`
  MODIFY `cs_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cs_locations`
--
ALTER TABLE `cs_locations`
  MODIFY `cs_location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cs_notifications`
--
ALTER TABLE `cs_notifications`
  MODIFY `cs_notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `cs_offers`
--
ALTER TABLE `cs_offers`
  MODIFY `cs_offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `cs_products_in_biddings`
--
ALTER TABLE `cs_products_in_biddings`
  MODIFY `cs_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `cs_tags`
--
ALTER TABLE `cs_tags`
  MODIFY `cs_tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cs_transactions`
--
ALTER TABLE `cs_transactions`
  MODIFY `cs_transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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
  MODIFY `cs_rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
