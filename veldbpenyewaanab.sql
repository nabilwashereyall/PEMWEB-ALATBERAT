-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 23, 2025 at 05:59 AM
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
-- Database: `veldbpenyewaanab`
--

-- --------------------------------------------------------

--
-- Table structure for table `AlatBerat`
--

CREATE TABLE `AlatBerat` (
  `IdAlatBerat` int(11) NOT NULL,
  `NamaAlatBerat` varchar(100) NOT NULL,
  `Tipe` varchar(100) DEFAULT NULL,
  `Spesifikasi` text DEFAULT NULL,
  `HargaSewa` decimal(15,2) DEFAULT NULL,
  `Kondisi` varchar(50) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `AlatBerat`
--

INSERT INTO `AlatBerat` (`IdAlatBerat`, `NamaAlatBerat`, `Tipe`, `Spesifikasi`, `HargaSewa`, `Kondisi`, `CreatedAt`, `UpdatedAt`) VALUES
(1, 'Excavator PC 200', 'Excavator', '20 Ton, Diesel', 500000.00, 'Baik', '2025-11-30 17:16:28', '2025-12-22 03:31:28'),
(2, 'Dozer CAT D6', 'Bulldozer', '15 Ton, Diesel', 4500000.00, 'Baik', '2025-11-30 17:16:28', '2025-11-30 17:16:28'),
(3, 'Dump Truck Isuzu', 'Truck', '10 Ton, Diesel', 3000000.00, 'Baik', '2025-11-30 17:16:28', '2025-11-30 17:16:28'),
(4, 'Excavator PC 200', 'Excavator', '20 Ton, Diesel', 5000000.00, 'Baik', '2025-11-30 17:18:12', '2025-11-30 17:18:12'),
(5, 'Dozer CAT D6', 'Bulldozer', '15 Ton, Diesel', 4500000.00, 'Baik', '2025-11-30 17:18:12', '2025-11-30 17:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `Bank`
--

CREATE TABLE `Bank` (
  `Account` varchar(50) NOT NULL,
  `NamaBank` varchar(100) NOT NULL,
  `NomorRekening` varchar(50) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Bank`
--

INSERT INTO `Bank` (`Account`, `NamaBank`, `NomorRekening`, `CreatedAt`, `UpdatedAt`) VALUES
('BCA-001', 'Bank Central Asia', '1234567890', '2025-11-30 17:16:28', '2025-11-30 17:16:28'),
('MANDIRI-001', 'Bank Mandiri', '0987654321', '2025-11-30 17:16:28', '2025-11-30 17:16:28');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `IdCustomer` int(11) NOT NULL,
  `IdUser` bigint(20) UNSIGNED DEFAULT NULL,
  `NamaCustomer` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `NoTelepon` varchar(15) DEFAULT NULL,
  `Alamat` text DEFAULT NULL,
  `Kota` varchar(50) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`IdCustomer`, `IdUser`, `NamaCustomer`, `Email`, `NoTelepon`, `Alamat`, `Kota`, `CreatedAt`, `UpdatedAt`) VALUES
(2, NULL, 'CV Bangun Jaya', 'admin@bangunjaya.com', '0315555555', 'Jl. Raya Darmo', 'Surabaya', '2025-11-30 17:16:28', '2025-11-30 17:16:28'),
(3, NULL, 'PT Konstruksi Maju', 'darabaro@company.com', '085183130507', 'jakarta', 'Kota Jakarta Pusat', '2025-12-22 10:12:38', '2025-12-22 10:12:38'),
(4, 4, 'Admin12345', 'admin@gmail.com', NULL, NULL, NULL, '2025-12-22 12:14:37', '2025-12-22 12:14:37'),
(5, 6, 'User', 'user@gmail.com', NULL, NULL, NULL, '2025-12-22 12:14:37', '2025-12-22 12:14:37');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Invoice`
--

CREATE TABLE `Invoice` (
  `NoInvoice` varchar(50) NOT NULL,
  `IdStaff` int(11) NOT NULL,
  `IdCustomer` int(11) NOT NULL,
  `Account` varchar(50) NOT NULL,
  `Tanggal` datetime DEFAULT current_timestamp(),
  `TotalAmount` decimal(15,2) DEFAULT 0.00,
  `Status` varchar(50) DEFAULT 'Pending',
  `Keterangan` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Invoice`
--

INSERT INTO `Invoice` (`NoInvoice`, `IdStaff`, `IdCustomer`, `Account`, `Tanggal`, `TotalAmount`, `Status`, `Keterangan`, `CreatedAt`, `UpdatedAt`) VALUES
('INV-20251201-001', 1, 1, 'BCA-001', '2025-12-01 00:00:00', 194150000.00, 'Pending', NULL, '2025-12-01 02:52:49', '2025-12-22 03:30:04'),
('INV-20251217-000', 1, 1, 'BCA-001', '2025-12-18 05:45:00', 0.00, 'Pending', NULL, '2025-12-18 05:49:09', '2025-12-18 05:49:09'),
('wer567uh', 4, 2, 'BCA-001', '2025-12-22 10:38:00', 49500000.00, 'Pending', NULL, '2025-12-22 10:38:46', '2025-12-22 03:39:07');

-- --------------------------------------------------------

--
-- Table structure for table `InvoiceDetail`
--

CREATE TABLE `InvoiceDetail` (
  `NoInvoice` varchar(50) NOT NULL,
  `IdAlatBerat` int(11) NOT NULL,
  `SubtotalDetail` decimal(15,2) DEFAULT 0.00,
  `TanggalAwalSewa` date DEFAULT NULL,
  `TanggalAkhirSewa` date DEFAULT NULL,
  `DurasiHari` int(11) DEFAULT 1,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `InvoiceDetail`
--

INSERT INTO `InvoiceDetail` (`NoInvoice`, `IdAlatBerat`, `SubtotalDetail`, `TanggalAwalSewa`, `TanggalAkhirSewa`, `DurasiHari`, `CreatedAt`, `UpdatedAt`) VALUES
('INV-20251201-001', 4, 176500000.00, '2025-12-01', '2026-01-31', 62, '2025-12-01 02:52:49', '2025-12-18 06:31:21'),
('123', 2, 31500000.00, '2025-12-22', '2025-12-28', 7, '2025-12-22 10:17:58', '2025-12-22 10:28:26'),
('wer567uh', 2, 45000000.00, '2025-12-22', '2025-12-31', 10, '2025-12-22 10:39:07', '2025-12-22 10:39:07');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(5, '0001_01_01_000001_create_cache_table', 1),
(6, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `PendingOrder`
--

CREATE TABLE `PendingOrder` (
  `IdPendingOrder` int(11) NOT NULL,
  `NoOrder` varchar(50) NOT NULL,
  `IdCustomer` int(11) NOT NULL,
  `Tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `Keterangan` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `PendingOrder`
--

INSERT INTO `PendingOrder` (`IdPendingOrder`, `NoOrder`, `IdCustomer`, `Tanggal`, `Status`, `Keterangan`, `CreatedAt`, `UpdatedAt`) VALUES
(2, 'ORD000001', 5, '2025-12-22 05:15:13', 'Pending', NULL, '2025-12-22 05:15:13', '2025-12-22 05:15:13'),
(3, 'ORD000002', 5, '2025-12-22 21:43:43', 'Pending', NULL, '2025-12-22 21:43:43', '2025-12-22 21:43:43'),
(4, 'ORD000003', 5, '2025-12-22 21:55:39', 'Pending', NULL, '2025-12-22 21:55:39', '2025-12-22 21:55:39');

-- --------------------------------------------------------

--
-- Table structure for table `PendingOrderDetail`
--

CREATE TABLE `PendingOrderDetail` (
  `IdPendingOrderDetail` int(11) NOT NULL,
  `IdPendingOrder` int(11) NOT NULL,
  `IdAlatBerat` int(11) NOT NULL,
  `TanggalAwalSewa` date NOT NULL,
  `TanggalAkhirSewa` date NOT NULL,
  `DurasiHari` int(11) DEFAULT NULL,
  `SubtotalDetail` decimal(15,2) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `PendingOrderDetail`
--

INSERT INTO `PendingOrderDetail` (`IdPendingOrderDetail`, `IdPendingOrder`, `IdAlatBerat`, `TanggalAwalSewa`, `TanggalAkhirSewa`, `DurasiHari`, `SubtotalDetail`, `CreatedAt`, `UpdatedAt`) VALUES
(1, 2, 1, '2025-12-22', '2025-12-31', -8, -4000000.00, '2025-12-22 05:15:13', '2025-12-22 05:15:13'),
(2, 3, 1, '2025-12-23', '2025-12-31', -7, -3500000.00, '2025-12-22 21:43:43', '2025-12-22 21:43:43'),
(3, 4, 2, '2025-12-23', '2025-12-23', 1, 4500000.00, '2025-12-22 21:55:39', '2025-12-22 21:55:39');

-- --------------------------------------------------------

--
-- Table structure for table `Staff`
--

CREATE TABLE `Staff` (
  `IdStaff` int(11) NOT NULL,
  `NamaStaff` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `NoTelepon` varchar(15) DEFAULT NULL,
  `Alamat` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Staff`
--

INSERT INTO `Staff` (`IdStaff`, `NamaStaff`, `Email`, `NoTelepon`, `Alamat`, `CreatedAt`, `UpdatedAt`) VALUES
(1, 'Ahmad Rizki', 'ahmad@company.com', '08123456789', 'Jl. Merdeka No. 5', '2025-11-30 17:16:28', '2025-11-30 17:16:28'),
(2, 'Budi Santoso', 'budi@company.com', '08123456790', 'Jl. Sudirman No. 10', '2025-11-30 17:16:28', '2025-11-30 17:16:28');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `IdUser` bigint(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Role` varchar(50) DEFAULT 'staff',
  `IsActive` tinyint(1) DEFAULT 1,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`IdUser`, `Username`, `Password`, `Email`, `Role`, `IsActive`, `CreatedAt`, `UpdatedAt`) VALUES
(4, 'Admin12345', '$2y$12$pWTuYesSG/jLjuLrUasE6upwoRwo4XtvnRIHxUDWqKQNJRp0Zrbmy', 'admin@gmail.com', 'staff', 1, '2025-12-18 01:02:22', '2025-12-18 01:02:22'),
(6, 'User', '$2y$12$wVLdbks4TLRvqOtFyv6rv.haivnv67qda6/RiUhXqA5Vdzf/sdTbu', 'user@gmail.com', 'user', 1, '2025-12-22 04:44:54', '2025-12-22 04:44:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AlatBerat`
--
ALTER TABLE `AlatBerat`
  ADD PRIMARY KEY (`IdAlatBerat`);

--
-- Indexes for table `Bank`
--
ALTER TABLE `Bank`
  ADD PRIMARY KEY (`Account`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`IdCustomer`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `Invoice`
--
ALTER TABLE `Invoice`
  ADD PRIMARY KEY (`NoInvoice`),
  ADD KEY `Account` (`Account`),
  ADD KEY `idx_tanggal` (`Tanggal`),
  ADD KEY `idx_customer` (`IdCustomer`),
  ADD KEY `idx_staff` (`IdStaff`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PendingOrder`
--
ALTER TABLE `PendingOrder`
  ADD PRIMARY KEY (`IdPendingOrder`),
  ADD UNIQUE KEY `NoOrder` (`NoOrder`),
  ADD KEY `IdCustomer` (`IdCustomer`);

--
-- Indexes for table `PendingOrderDetail`
--
ALTER TABLE `PendingOrderDetail`
  ADD PRIMARY KEY (`IdPendingOrderDetail`),
  ADD KEY `IdPendingOrder` (`IdPendingOrder`),
  ADD KEY `IdAlatBerat` (`IdAlatBerat`);

--
-- Indexes for table `Staff`
--
ALTER TABLE `Staff`
  ADD PRIMARY KEY (`IdStaff`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`IdUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AlatBerat`
--
ALTER TABLE `AlatBerat`
  MODIFY `IdAlatBerat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `IdCustomer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `PendingOrder`
--
ALTER TABLE `PendingOrder`
  MODIFY `IdPendingOrder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `PendingOrderDetail`
--
ALTER TABLE `PendingOrderDetail`
  MODIFY `IdPendingOrderDetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Staff`
--
ALTER TABLE `Staff`
  MODIFY `IdStaff` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `IdUser` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `PendingOrder`
--
ALTER TABLE `PendingOrder`
  ADD CONSTRAINT `pendingorder_ibfk_1` FOREIGN KEY (`IdCustomer`) REFERENCES `customer` (`IdCustomer`) ON DELETE CASCADE;

--
-- Constraints for table `PendingOrderDetail`
--
ALTER TABLE `PendingOrderDetail`
  ADD CONSTRAINT `pendingorderdetail_ibfk_1` FOREIGN KEY (`IdPendingOrder`) REFERENCES `PendingOrder` (`IdPendingOrder`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendingorderdetail_ibfk_2` FOREIGN KEY (`IdAlatBerat`) REFERENCES `alatBerat` (`IdAlatBerat`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
