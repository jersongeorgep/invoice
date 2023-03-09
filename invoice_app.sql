-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 09, 2023 at 01:56 PM
-- Server version: 10.10.2-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invoice_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_date` date NOT NULL,
  `ref_no` varchar(15) NOT NULL,
  `customer_name` varchar(150) NOT NULL,
  `address` text DEFAULT NULL,
  `mobile` varchar(100) NOT NULL,
  `grand_total` varchar(100) NOT NULL,
  `dis_amount` float NOT NULL,
  `total_value` float NOT NULL,
  `tax_total_value` float NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_date`, `ref_no`, `customer_name`, `address`, `mobile`, `grand_total`, `dis_amount`, `total_value`, `tax_total_value`, `status`, `created_at`, `updated_at`) VALUES
(1, '2023-03-09', 'INV_1000', 'Jerson George P', NULL, '9497352791', '700.00', 0, 700, 7, 1, '2023-03-09 12:55:31', '2023-03-09 12:55:31'),
(2, '2023-03-10', 'INV_1001', 'Jerson', NULL, '9497352791', '500.00', 25, 500, 5, 1, '2023-03-09 12:58:09', '2023-03-09 12:58:09'),
(3, '2023-03-09', 'INV_1002', 'customer', NULL, '9497652791', '525.00', 25, 500, 5, 1, '2023-03-09 13:05:52', '2023-03-09 13:05:52'),
(4, '2023-03-16', 'INV_1003', 'Cust01', NULL, '9497352791', '1035.00', 10, 1000, 7, 1, '2023-03-09 13:52:33', '2023-03-09 13:52:33');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_line_items`
--

DROP TABLE IF EXISTS `invoice_line_items`;
CREATE TABLE IF NOT EXISTS `invoice_line_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `unit` varchar(15) NOT NULL,
  `products` varchar(100) NOT NULL,
  `item_qty` float NOT NULL,
  `item_rate` float NOT NULL,
  `tax_percentage` float NOT NULL,
  `item_total` float NOT NULL,
  `sub_total` float NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_line_items`
--

INSERT INTO `invoice_line_items` (`id`, `invoice_id`, `unit`, `products`, `item_qty`, `item_rate`, `tax_percentage`, `item_total`, `sub_total`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kg', 'Item 01', 5, 100, 5, 500, 525, 1, '2023-03-09 12:55:31', '2023-03-09 12:55:31'),
(2, 1, 'kg', 'Item 02', 2, 100, 2, 200, 204, 1, '2023-03-09 12:55:31', '2023-03-09 12:55:31'),
(3, 2, 'kp', 'Item 01', 5, 100, 5, 500, 525, 1, '2023-03-09 12:58:09', '2023-03-09 12:58:09'),
(4, 3, 'Kg', 'Item 01', 5, 100, 5, 500, 525, 1, '2023-03-09 13:05:52', '2023-03-09 13:05:52'),
(5, 4, 'Kg', 'Item 01', 5, 100, 2, 500, 510, 1, '2023-03-09 13:52:33', '2023-03-09 13:52:33'),
(6, 4, 'Kg', 'Item 02', 10, 50, 5, 500, 525, 1, '2023-03-09 13:52:34', '2023-03-09 13:52:34');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
