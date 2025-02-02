-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 02, 2025 at 01:23 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_com`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(100) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_pass` varchar(255) NOT NULL,
  `admin_image` text NOT NULL,
  `admin_contact` varchar(255) NOT NULL,
  `admin_country` text NOT NULL,
  `admin_job` varchar(255) NOT NULL,
  `admin_about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `admin_email`, `admin_pass`, `admin_image`, `admin_contact`, `admin_country`, `admin_job`, `admin_about`) VALUES
(5, 'Dipongkor Roy', 'admin@gadgetshop.com', '12345', 'trimer1.jpg', '0176588', '', 'WEB DEVELOPER', 'value=\"\" >');

-- --------------------------------------------------------

--
-- Table structure for table `boxes_section`
--

CREATE TABLE `boxes_section` (
  `box_id` int(100) NOT NULL,
  `box_icon` varchar(100) NOT NULL,
  `box_title` varchar(255) NOT NULL,
  `box_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boxes_section`
--

INSERT INTO `boxes_section` (`box_id`, `box_icon`, `box_title`, `box_desc`) VALUES
(4, 'fa fa-trash', 'BEST IN MARKET', 'offer'),
(6, 'fa fa-shipping-fast fa-5', 'FAST SERVICE', 'raw'),
(7, 'fa fa-user', 'EDIT YOURSELF', 'edit'),
(8, 'fa fa-trash', 'DELETE EVERYTHING', 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `p_id` int(100) NOT NULL,
  `ip_add` varchar(255) NOT NULL,
  `qty` int(100) NOT NULL,
  `size` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`p_id`, `ip_add`, `qty`, `size`) VALUES
(38, '::1', 5, 'RED & Blue');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(100) NOT NULL,
  `cat_title` text NOT NULL,
  `cat_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`, `cat_desc`) VALUES
(7, 'SALOON PRODUCTS', 'All Saloon products'),
(8, 'PARLOR PRODUCTS', 'parlor dj'),
(9, 'GARMENTS', ''),
(11, 'OTHERS', '');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(100) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_pass` varchar(255) NOT NULL,
  `customer_country` text NOT NULL,
  `customer_city` text NOT NULL,
  `customer_contact` varchar(255) NOT NULL,
  `customer_address` text NOT NULL,
  `customer_image` text NOT NULL,
  `customer_ip` varchar(255) NOT NULL,
  `role` enum('customer','seller') NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_email`, `customer_pass`, `customer_country`, `customer_city`, `customer_contact`, `customer_address`, `customer_image`, `customer_ip`, `role`) VALUES
(23, 'raku', 'raku08@gmail.com', '12345', 'India', 'Bhiwani', '08295401008', 'Vpo- Alakhpura, Teh-Bawani khera', 'Licence.jpg', '::1', 'customer'),
(24, 'Rakesh Kumar', 'rakesh@gmail.com', '12345', 'India', 'Bhiwani', '+918295401008', 'Vpo- Alakhpura', 'IMG_20180831_153629.jpg', '::1', 'customer'),
(25, 'Rakesh Kumar', 'rakekh@gmail.com', '12345', 'India', 'Bhiwani', '08295401008', 'Vpo- Alakhpura, Teh-Bawani khera', 'PHOTO.jpg', '::1', 'customer'),
(26, 'jateen tanwar ', 'jateentanwar@gmail.com', '12345', 'India', 'Bhiwani', '08295401008', 'Vpo- Alakhpura, Teh-Bawani khera', 'Pic-4.jpg', '::1', 'customer'),
(27, 'ankita', 'ankita@gmail.com', 'abcd', 'india', 'har', '1234567890', 'sampla', 'th.jpg', '::1', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `order_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `product_id` int(100) NOT NULL,
  `due_amount` int(100) NOT NULL,
  `invoice_no` int(100) NOT NULL,
  `qty` int(10) NOT NULL,
  `size` text NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_order`
--

INSERT INTO `customer_order` (`order_id`, `customer_id`, `product_id`, `due_amount`, `invoice_no`, `qty`, `size`, `order_date`, `order_status`) VALUES
(32, 23, 18, 897, 1732273010, 3, 'RED & Blue', '2021-05-18 15:05:51', 'Complete'),
(33, 24, 17, 300, 2061043168, 1, 'RED & Blue', '2021-05-19 15:44:00', 'pending'),
(34, 26, 20, 425, 1601455995, 5, 'RED & Blue', '2021-05-25 16:41:16', 'Complete'),
(35, 26, 31, 2396, 1601455995, 4, 'RED & Blue', '2021-05-26 05:58:44', 'Complete'),
(36, 26, 33, 180, 1081656985, 1, 'RED & Blue', '2021-05-26 05:57:25', 'pending'),
(37, 27, 37, 10120, 675008297, 4, 'white', '2021-05-29 05:55:10', 'pending'),
(38, 28, 36, 599, 1624474385, 1, 'RED & Blue', '2021-06-19 10:25:24', 'Complete'),
(39, 28, 23, 349, 535526198, 1, 'RED & Blue', '2021-06-17 23:36:47', 'pending'),
(40, 28, 24, 432, 535526198, 1, 'RED & Blue', '2021-06-17 23:36:48', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(100) NOT NULL,
  `invoice_id` int(100) NOT NULL,
  `amount` int(100) NOT NULL,
  `payment_mode` text NOT NULL,
  `ref_no` int(100) NOT NULL,
  `payment_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `invoice_id`, `amount`, `payment_mode`, `ref_no`, `payment_date`) VALUES
(18, 236385455, 342, 'Paytm', 232323, '2021-05-18'),
(20, 1601455995, 599, 'google pay', 232323, '2021-05-11'),
(21, 1601455995, 599, 'Bank transfer', 112121, '2021-05-10'),
(22, 2098939645, 299, 'Bank transfer', 232323, '2021-06-17');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) NOT NULL,
  `p_cat_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_title` text NOT NULL,
  `product_img1` text NOT NULL,
  `product_img2` text NOT NULL,
  `product_img3` text NOT NULL,
  `product_price` int(10) NOT NULL,
  `product_desc` text NOT NULL,
  `product_keyword` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `p_cat_id`, `cat_id`, `date`, `product_title`, `product_img1`, `product_img2`, `product_img3`, `product_price`, `product_desc`, `product_keyword`) VALUES
(21, 3, 5, '2021-05-20 08:35:26', 'Shaving Cream', 'crem.jpg', 'crem.jpg', 'crem.jpg', 299, 'erg', 'new arrival'),
(22, 14, 5, '2021-05-20 08:37:35', 'Towel', 'Pic-4.jpg', 'Pic-4.jpg', 'Pic-4.jpg', 199, 'best', 'Makhmal'),
(23, 14, 5, '2021-05-20 08:39:19', 'Hair Drayer', 's-l1600.jpg', 's-l1600.jpg', 's-l1600.jpg', 349, 'best', 'new arrival'),
(32, 10, 8, '2021-06-18 00:15:41', 'Stylish Comb', 'comb-11.jpg', 'com.jpg', 'th (1).jpg', 543, '', 'new arrival'),
(38, 21, 7, '2021-06-18 00:10:01', 'Philips trimmer for men', 'trimer1.jpg', 'trimer2.jpg', 'trimer3.jpg', 1495, '', 're');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `p_cat_id` int(10) NOT NULL,
  `p_cat_title` text NOT NULL,
  `p_cat_desc` text NOT NULL,
  `p_cat_img` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`p_cat_id`, `p_cat_title`, `p_cat_desc`, `p_cat_img`) VALUES
(22, 'dcd', 'cdcd', 0),
(23, 'DRAYER', '', 0),
(24, 'STRIGHTENER', '', 0),
(25, 'MASSAGER', '', 0),
(26, 'SHAVING CREAM', '', 0),
(27, 'BLADE', '', 0),
(28, 'NAPKIN', '', 0),
(29, 'LOION', '', 0),
(30, 'COLOR', '', 0),
(31, 'SCISSOR', '', 0),
(32, 'CLASSIC SHAVER', '', 0),
(33, 'COMB', '', 0),
(34, 'TOWEL', '', 0),
(35, 'SHAVING FOAM', '', 0),
(36, 'FACIAL KIT', '', 0),
(37, 'POWDER', '', 0),
(38, 'LIP CARE', '', 0),
(39, 'EYE LINER', '', 0),
(40, 'EYE LINER', '', 0),
(41, 'FACE CRAEM', '', 0),
(42, 'NAILPOLISH', '', 0),
(43, 'BEAUTICREAM', '', 0),
(44, 'LACME', '', 0),
(45, 'SCIN CARE', '', 0),
(46, 'INNER WEAR', '', 0),
(47, 'UNDER WEAR', '', 0),
(48, 'CAP', '', 0),
(49, 'HANKEY', '', 0),
(50, 'DETERGENT', '', 0),
(51, 'DEODODRANT', '', 0),
(52, 'FACEWASH', '', 0),
(53, 'HAIR GEL', '', 0),
(54, 'HARPIC', '', 0),
(55, 'PERFUME', '', 0),
(56, 'WALLET', '', 0),
(57, 'BELT', '', 0),
(58, 'SOAP', '', 0),
(59, 'TOOTHPASTE', '', 0),
(60, 'HANDWASH', '', 0),
(61, 'SHAMPOO', '', 0),
(62, 'HAIR OIL', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `Id` int(10) NOT NULL,
  `slider_name` varchar(255) NOT NULL,
  `slider_image` text NOT NULL,
  `slider_url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`Id`, `slider_name`, `slider_image`, `slider_url`) VALUES
(18, 'sale', 'banner2.jpg', 'http://localhost/ecom/details.php?pro_id=10'),
(23, '', 'banner5.png', ''),
(24, '', 'banner1.jpg', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `boxes_section`
--
ALTER TABLE `boxes_section`
  ADD PRIMARY KEY (`box_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`p_cat_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `boxes_section`
--
ALTER TABLE `boxes_section`
  MODIFY `box_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `customer_order`
--
ALTER TABLE `customer_order`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `p_cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
