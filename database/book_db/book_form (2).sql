-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2025 at 09:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `book_form`
--

CREATE TABLE `book_form` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `guests` int(100) NOT NULL,
  `arrivals` date NOT NULL,
  `leaving` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `vehicle` varchar(255) NOT NULL,
  `hotel` varchar(255) NOT NULL,
  `menu` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_form`
--

INSERT INTO `book_form` (`id`, `name`, `email`, `phone`, `address`, `location`, `guests`, `arrivals`, `leaving`, `type`, `price`, `vehicle`, `hotel`, `menu`) VALUES
(23, 'Danush ', 'danuh@gmail.com', '9080012137', '69/5 mettu street santhangadu, 69/5 mettu street santhangadu', 'Delhi', 5, '2025-03-25', '2025-03-27', 'Adventure', 100000.00, 'Economy', '3 Star', '0'),
(24, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'asa', 6, '2025-03-28', '2025-03-29', '', 0.00, '', '', '0'),
(25, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'Delhi', 6, '2025-03-29', '2025-04-01', '', 0.00, '', '', '0'),
(26, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'Delhi', 5, '2025-03-27', '2025-03-31', 'family', 10000100.00, '', '', '0'),
(27, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'dehli', 5, '2025-03-24', '2025-03-25', 'Adventure', 100000.00, '', '', '0'),
(28, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'dehli', 5, '2025-03-24', '2025-03-25', 'Adventure', 0.00, '', '', '0'),
(30, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'dehli', 5, '2025-03-27', '2025-03-27', 'Adventure', 100000.00, 'caee', '5 satr', '0'),
(31, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'mumbai', 5, '2025-03-24', '2025-03-25', 'Mumbai Luxury Package', 100000.00, 'Car', '3 Star', '0'),
(32, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'Jammu & Kashmir', 5, '2025-03-25', '2025-03-26', 'Jammu & Kashmir Package', 69999.00, 'Bus', '5 Star', '0'),
(33, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'Jammu & Kashmir', 3, '2025-04-17', '2025-04-22', 'Jammu & Kashmir Package', 224400.00, 'Van', '5 Star', '0'),
(34, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'Jammu & Kashmir', 3, '2025-04-17', '2025-04-22', 'Jammu & Kashmir Package', 0.00, 'Van', '5 Star', '0'),
(35, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'Jammu & Kashmir', 2, '2025-04-09', '2025-04-14', 'Jammu & Kashmir Package', 0.00, 'Car', '3 Star', 'Veg'),
(36, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'Jammu & Kashmir', 1, '2025-04-04', '2025-04-09', 'Jammu & Kashmir Package', 0.00, 'Car', '3 Star', 'Veg'),
(37, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'Jammu & Kashmir', 1, '2025-04-03', '2025-04-08', 'Jammu & Kashmir Package', 0.00, 'Car', '3 Star', 'Veg'),
(38, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'Jammu & Kashmir', 1, '2025-04-03', '2025-04-08', 'Jammu & Kashmir Package', 0.00, 'Car', '3 Star', 'Veg'),
(39, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'Jammu & Kashmir', 1, '2025-04-04', '2025-04-09', 'Jammu & Kashmir Package', 70000.00, 'Car', '3 Star', 'Veg'),
(40, 'Danush ', 'll6532637@gmail.com', '9080012137', '69/5 mettu street santhangadu', 'Jammu & Kashmir', 4, '2025-04-17', '2025-04-22', 'Jammu & Kashmir Package', 297200.00, 'Bus', '5 Star', 'Non-Veg'),
(41, 'aswin', 'll6532637@gmail.com', '0908001213', '69/5 mettu street santhangadu', 'Kerala', 1, '2025-04-04', '2025-04-10', 'Kerala Package ', 60999.00, 'Van', '3 Star', 'Veg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book_form`
--
ALTER TABLE `book_form`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book_form`
--
ALTER TABLE `book_form`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
