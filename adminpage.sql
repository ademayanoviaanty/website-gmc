-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2025 at 10:52 AM
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
-- Database: `adminpage`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `created_at`) VALUES
(1, 'Mikrotik', '2025-09-10 04:07:38'),
(2, 'Ubiquiti', '2025-09-10 04:07:38'),
(3, 'Switch', '2025-09-10 04:07:38'),
(11, 'VGA', '2025-09-10 04:57:32'),
(12, 'Lainnya', '2025-09-27 11:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active',
  `created_at` datetime DEFAULT current_timestamp(),
  `added_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `harga`, `kategori`, `deskripsi`, `photo`, `status`, `created_at`, `added_date`) VALUES
(25, 'kk,,,,,', 900000.00, 'Ubiquiti', 'dsfdsfdf', '20251018_071030_90206d27.jpg', 'Active', '2025-09-27 11:23:08', '2025-09-27 11:23:08'),
(26, 'dgfgg', 900000.00, 'Switch', 'dffd', '20251018_071021_d19f30cc.jpg', 'Active', '2025-09-27 14:08:06', '2025-09-27 14:08:06'),
(27, 'wansmsjhskj', 900000.00, 'Mikrotik', 'sdfdsfdsf', '20251018_071014_d8595143.jpg', 'Active', '2025-09-27 14:20:42', '2025-09-27 14:20:42'),
(28, 'gfhtgbhj', 900000.00, 'Lainnya', 'fdsdfdsf', '20251018_071006_d29f62e2.jpg', 'Active', '2025-09-27 14:37:18', '2025-09-27 14:37:18'),
(29, 'dgfgg', 900000.00, 'hmmmm', 'fddsfsdf', '20251008_053041_c1f3d09d.jpg', 'Active', '2025-10-01 11:30:05', '2025-10-01 11:30:05'),
(30, 'hhhhcjdncx', 1100000.00, 'Mikrotik', 'hsggshsghgdsygd', '20251018_071039_f309b7b0.jpg', 'Active', '2025-10-01 11:39:42', '2025-10-01 11:39:42'),
(31, 'OOOOOOOOOOOOO', 700000.00, 'Lainnya', 'KKKKKKKKKLKLLL', '20251015_062818_745b5577.jpg', 'Active', '2025-10-15 11:28:18', '2025-10-15 11:28:18'),
(32, 'gr3', 650000.00, 'Mikrotik', 'banbsnbans', '20251018_071658_23599855.jpg', 'Active', '2025-10-18 12:16:58', '2025-10-18 12:16:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
