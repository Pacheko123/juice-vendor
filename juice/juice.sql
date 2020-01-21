-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 09, 2018 at 10:34 AM
-- Server version: 5.7.22-0ubuntu0.17.10.1
-- PHP Version: 7.2.5-1+ubuntu17.10.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `juice`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `account_no` varchar(255) DEFAULT NULL,
  `balance` decimal(10,0) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `account_no`, `balance`) VALUES
(3, 28, '34295863', '625'),
(4, 29, '97013852', '0');

-- --------------------------------------------------------

--
-- Table structure for table `meta_orders`
--

CREATE TABLE `meta_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meta_orders`
--

INSERT INTO `meta_orders` (`id`, `user_id`, `code`, `order_date`) VALUES
(14, 28, '9295_028', '2018-08-09 11:27:42'),
(15, 28, '1672_028', '2018-08-09 11:28:27');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `meta_id` int(11) NOT NULL DEFAULT '0',
  `stock_id` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `status` enum('pending','cleared','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `meta_id`, `stock_id`, `quantity`, `status`) VALUES
(44, 14, 1, 1, 'pending'),
(45, 14, 2, 2, 'pending'),
(46, 14, 3, 6, 'pending'),
(47, 14, 4, 1, 'pending'),
(48, 14, 5, 1, 'pending'),
(49, 15, 1, 1, 'cleared');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_price` decimal(12,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `unit_price`) VALUES
(1, 'Mango', '25.00'),
(2, 'Pineapple', '10.00'),
(3, 'Apple', '10.00'),
(4, 'Oranges', '25.00'),
(5, 'Banana', '20.00'),
(6, 'Water Melon', '5.00'),
(7, 'Banana', '50.00');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `sell_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `expiry` date NOT NULL,
  `stocked_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `quantity`, `sell_price`, `expiry`, `stocked_at`) VALUES
(1, 1, 30, '20.00', '2017-06-04', '2017-06-04 11:33:56'),
(2, 2, 54, '0.00', '2017-06-04', '2017-06-04 11:33:56'),
(3, 3, 10, '5.00', '2017-06-04', '2017-06-04 11:33:57'),
(4, 4, 122, '10.00', '2017-06-04', '2017-06-04 11:33:57'),
(5, 5, 9, '10.00', '2017-06-04', '2017-06-04 11:33:57'),
(6, 6, 37, '5.00', '2017-06-04', '2017-06-04 11:33:57');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `debit` varchar(255) NOT NULL,
  `credit` varchar(255) NOT NULL,
  `amount` decimal(10,0) NOT NULL DEFAULT '0',
  `narration` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `date`, `debit`, `credit`, `amount`, `narration`) VALUES
(16, '2018-08-04 14:36:30', '200', '12034379', '250', 'CASH Deposit'),
(17, '2018-08-04 14:36:46', '12034379', '100', '35', 'Placed Order'),
(18, '2018-08-04 14:37:31', '200', '12034379', '35', 'CASH Deposit'),
(19, '2018-08-04 14:52:05', '12034379', '100', '45', 'Placed Order'),
(20, '2018-08-04 15:41:27', '200', '45860557', '1500', 'CASH Deposit'),
(21, '2018-08-04 15:41:42', '45860557', '100', '175', 'Placed Order'),
(22, '2018-08-09 08:26:10', '200', '34295863', '500', 'CASH Deposit'),
(23, '2018-08-09 08:26:23', '200', '34295863', '200', 'CASH Deposit'),
(24, '2018-08-09 08:26:40', '200', '34295863', '100', 'CASH Deposit'),
(25, '2018-08-09 08:27:42', '34295863', '100', '150', 'Placed Order'),
(26, '2018-08-09 08:28:27', '34295863', '100', '25', 'Placed Order');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user','supplier') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `role`, `address`, `email`, `password`) VALUES
(28, 'Muthami Geoffrey', '0716028726', 'user', 'Ongata Rongai', 'ggeovry@mail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(29, 'Admin Admin', '0712345678', 'admin', 'Sample address', 'admin@mail.com', '81dc9bdb52d04dc20036dbd8313ed055');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meta_orders`
--
ALTER TABLE `meta_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `meta_orders`
--
ALTER TABLE `meta_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
