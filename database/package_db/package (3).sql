-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2025 at 09:49 AM
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
-- Database: `package_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `details` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `places` text NOT NULL,
  `days` int(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`id`, `type`, `location`, `price`, `details`, `image_path`, `created_at`, `places`, `days`, `description`) VALUES
(25, 'Chennai  Package ', 'Chennai', 40000.00, '[\"Day 1: Marina Beach & Santhome Basilica.\",\"Day 2: Kapaleeshwarar Temple & Mylapore.\",\"Day 3: Fort St. George & Government Museum.\",\"Day 4: Guindy National Park & Valluvar Kottam.\",\"Day 5: DakshinaChitra & Elliot\'s Beach.\"]', 'image/67e28ce64810d_Chennai_626x417.png', '2025-03-25 11:00:54', '[\"Marina Beach & Santhome Basilica\",\"Kapaleeshwarar Temple & Mylapore\",\" Fort St. George & Government Museum\",\"Guindy National Park & Valluvar Kottam\",\"DakshinaChitra & Elliot\'s Beach\"]', 5, 'Unwind at serene beaches, dive into history, and enjoy the vibrant culture of Chennai.'),
(26, 'Rajasthan  package', 'Rajasthan', 49999.00, '[\"Day 1: Jaipur - Amber Fort- Hawa Mahal- City Palace.\",\"Day 2: Jodhpur - Mehrangarh Fort- Jaswant Thada.\",\"Day 3: Udaipur - City Palace- Lake Pichola.\",\"Day 4: Jaisalmer - Jaisalmer Fort- Sam Sand Dunes.\",\"Day 5: Pushkar- Brahma Temple- Pushkar Lake.\"]', 'image/67e28f86d47d9_Rajasthan_626x417.png', '2025-03-25 11:12:06', '[\"Pushkar\",\"Jaisalmer\",\"Jodhpur\",\" Jaipur\",\"Udaipu\"]', 5, 'Journey through forts, palaces, and deserts in this enchanting Rajasthan tour.'),
(27, 'KolKata Package', 'KolKata', 15000.00, '[\"Day 1: Victoria Memorial & Howrah Bridge.\",\"Day 2: Dakshineswar Kali Temple & Belur Math.\",\"Day 3: Indian Museum & Marble Palace.\"]', 'image/67e291ca803b5_Kolkata_626x417.png', '2025-03-25 11:21:46', '[\"Victoria Memorial & Howrah Bridge\",\"Dakshineswar Kali Temple & Belur Math\",\"Indian Museum & Marble Palace\"]', 3, '\"Kolkata Getaway: 3 Days of Culture & Charm!\"'),
(28, 'New Delhi Package', 'Delhi', 50000.00, '[\"Day 1: India Gate- Qutub Minar.\",\"Day 2: Red Fort- Jama Masjid.\",\"Day 3: Lotus Temple- Akshardham.\",\"Day 4: Humayun\'s Tomb- Raj Ghat\"]', 'image/67e292d3591a4_img-1.jpg', '2025-03-25 11:26:11', '[\"India Gate & Qutub Minar\",\"Red Fort & Jama Masjid\",\"Lotus Temple & Akshardham\",\"Humayun\'s Tomb & Raj Ghat\"]', 4, '\"Heritage & Culture: Your Perfect Delhi Getaway!\"'),
(29, 'Kerala Package ', 'Kerala', 59999.00, '[\"Day 1: Munnar - Tea Gardens & Eravikulam National Park.\",\"Day 2: Thekkady - Periyar Wildlife Sanctuary & Spice Plantations.\",\"Day 3: Alleppey - Houseboat & Backwaters.\",\"Day 4: Kochi - Fort Kochi & Mattancherry Palace.\",\"Day 5: Wayanad - Edakkal Caves & Banasura Sagar Dam.\",\"Day 6: Kovalam - Beaches & Lighthouse.\",\"Day 7: Trivandrum - Padmanabhaswamy Temple & Napier Museum.\"]', 'image/67e2940973a58_kerala_resized_626x417.png', '2025-03-25 11:31:21', '[\"Munnar - Tea Gardens & Eravikulam National Park.\",\" Thekkady - Periyar Wildlife Sanctuary & Spice Plantations.\",\"Day 3: Alleppey - Houseboat & Backwaters.\",\"Kochi - Fort Kochi & Mattancherry Palace.\",\"Wayanad - Edakkal Caves & Banasura Sagar Dam.\",\" Kovalam - Beaches & Lighthouse.\",\"Trivandrum - Padmanabhaswamy Temple & Napier Museum.\"]', 7, '\"Discover God’s Own Country in 7 Days!\"'),
(30, 'Jammu & Kashmir Package', 'Jammu & Kashmir', 70000.00, '[\"Day 1-Patnitop - Rejuvenate in this scenic hill station.\",\"Day 2-Jammu - Visit Raghunath Temple and Bahu Fort.\",\"Day 3-Sonmarg - Marvel at the snow-capped mountains.\",\"Day 4-Pahalgam - Relax amidst lush meadows and rivers.\",\"Day 5-Gulmarg - Enjoy skiing and breathtaking landscapes.\",\"Day 6-Srinagar - Explore the serene Dal Lake and Mughal Gardens.\"]', 'image/67e29751e29f8_Jammu_Kashmir_626x417.png', '2025-03-25 11:45:21', '[\"Patnitop - Rejuvenate in this scenic hill station.\",\"Jammu - Visit Raghunath Temple and Bahu Fort.\",\"Sonmarg - Marvel at the snow-capped mountains.\",\"Pahalgam - Relax amidst lush meadows and rivers.\",\"Gulmarg - Enjoy skiing and breathtaking landscapes.\",\"Srinagar - Explore the serene Dal Lake and Mughal Gardens.\"]', 6, 'Witness the paradise on earth with its stunning valleys, pristine lakes, and enchanting gardens. Perfect for nature lovers and adventure seekers.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
