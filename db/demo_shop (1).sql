-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2017 at 06:51 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(70) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `order_position` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE','DELETE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `image`, `order_position`, `created_at`, `updated_at`, `status`) VALUES
(1, 'cxfxdv', 'vv', 1, '2017-01-19 00:00:00', NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(70) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE','DELETE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `parent_id`, `created_at`, `updated_at`, `status`) VALUES
(1, 'rrrrrrr', 'category_1483184047.jpg', 0, '2016-12-15 00:00:00', '2016-12-31 12:03:32', 'ACTIVE'),
(4, 'test5', NULL, 0, '2016-12-31 10:30:28', '2017-01-01 16:24:13', 'ACTIVE'),
(5, 'test1', 'category_1483180811.jpg', 1, '2016-12-31 10:40:11', '2016-12-31 10:40:11', 'ACTIVE'),
(6, 'test2', 'category_1483180894.jpg', 1, '2016-12-31 10:41:34', '2017-01-01 19:13:06', 'ACTIVE'),
(7, 'test13', 'category_1483288730.jpg', 0, '2017-01-01 16:38:51', '2017-01-01 16:38:51', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(130) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `default_image` varchar(255) DEFAULT NULL COMMENT 'this is default image',
  `s_description` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `ord_position` tinyint(1) NOT NULL DEFAULT '0',
  `is_featured` enum('Y','N') NOT NULL DEFAULT 'N',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE','DELETE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `code`, `default_image`, `s_description`, `description`, `ord_position`, `is_featured`, `created_at`, `updated_at`, `status`) VALUES
(1, 'sddsfds', 'sdfds', 'product_1483367097.jpg', 'sdfsd sdfdsf dsf ', 'sdfds fsdf sdfdsf sdf', 0, 'Y', '2017-01-02 14:24:58', NULL, 'ACTIVE'),
(2, 'sdfdsfsdf', '484625fdsg', 'product_1483368585.jpg', 'dfgfd', 'dfg', 0, 'N', '2017-01-02 14:49:46', NULL, 'ACTIVE'),
(3, 'sdfdsfasd', '484625', 'product_1483368827.jpg', 'ads', 'sdf', 0, 'Y', '2017-01-02 14:53:47', '2017-01-03 12:36:36', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `product_brand_maps`
--

CREATE TABLE `product_brand_maps` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_brand_maps`
--

INSERT INTO `product_brand_maps` (`id`, `brand_id`, `product_id`) VALUES
(1, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_category_maps`
--

CREATE TABLE `product_category_maps` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL DEFAULT '0',
  `sub_cat_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_category_maps`
--

INSERT INTO `product_category_maps` (`id`, `cat_id`, `sub_cat_id`, `product_id`) VALUES
(10, 1, 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `status` enum('ACTIVE','INACTIVE','DELETE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `image`, `product_id`, `status`) VALUES
(1, 'asdfasfd', 3, 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `product_prices`
--

CREATE TABLE `product_prices` (
  `id` int(11) NOT NULL,
  `original_price` float NOT NULL DEFAULT '0',
  `offer_percent` float NOT NULL DEFAULT '0',
  `vat_percent` float NOT NULL DEFAULT '0',
  `tax_percent` float NOT NULL DEFAULT '0',
  `other_service_charge` float NOT NULL DEFAULT '0',
  `delevery_charge` float NOT NULL DEFAULT '0',
  `offer_start_date` datetime DEFAULT NULL,
  `offer_end_date` datetime DEFAULT NULL,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_prices`
--

INSERT INTO `product_prices` (`id`, `original_price`, `offer_percent`, `vat_percent`, `tax_percent`, `other_service_charge`, `delevery_charge`, `offer_start_date`, `offer_end_date`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, 1, 1, 1, '2016-12-13 11:12:12', '2016-12-13 11:12:12', 3, '2017-01-02 14:53:47', '2017-01-03 12:36:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(190) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(13) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8_unicode_ci,
  `type` enum('SA','U') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'U',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE','DELETE') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'INACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `name`, `email`, `password`, `phone`, `default_image`, `about`, `type`, `created_at`, `updated_at`, `remember_token`, `status`) VALUES
(2, 'Admin', 'Site Admin', 'admin@gmail.com', '$2y$10$ZOk7QNbzopdSoj/G.UQNW.vew5.u/AU..OmVXkXKKzoGTipu6HbGa', NULL, NULL, NULL, 'SA', '2016-12-31 08:10:24', NULL, NULL, 'ACTIVE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_brand_maps`
--
ALTER TABLE `product_brand_maps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category_maps`
--
ALTER TABLE `product_category_maps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_prices`
--
ALTER TABLE `product_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_user_name_index` (`user_name`),
  ADD KEY `users_name_index` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `product_brand_maps`
--
ALTER TABLE `product_brand_maps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `product_category_maps`
--
ALTER TABLE `product_category_maps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `product_prices`
--
ALTER TABLE `product_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
