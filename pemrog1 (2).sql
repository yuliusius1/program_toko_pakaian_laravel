-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2021 at 08:35 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pemrog1`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `slug`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Pakaian Pria', 'male-category', 1, '2021-10-21 22:48:59', '2021-10-21 22:48:59'),
(2, 'Pakaian Wanita', 'female-category', 1, '2021-10-21 22:48:59', '2021-10-21 22:48:59');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_10_13_164420_create_products_table', 1),
(6, '2021_10_13_164525_create_categories_table', 1),
(7, '2021_10_13_164555_create_sub_categories_table', 1),
(8, '2021_10_13_164640_create_orders_table', 1),
(9, '2021_10_13_164715_create_order_details_table', 1),
(10, '2021_10_13_165224_create_roles_table', 1),
(11, '2021_10_19_105954_create_user__tokens_table', 1),
(12, '2021_10_20_041744_create_payments_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_harga` double NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `invoice_id`, `user_id`, `total_harga`, `status`, `date_created`, `created_at`, `updated_at`) VALUES
(1, '77248', 1, 4621900, '4', '2021-10-22', '2021-10-22 00:09:01', '2021-10-22 00:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_harga` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `product_id`, `order_id`, `quantity`, `total_harga`, `created_at`, `updated_at`) VALUES
(1, 10, 1, 10, 4290000, '2021-10-22 00:09:01', '2021-10-22 00:09:13'),
(2, 11, 1, 1, 129000, '2021-10-22 00:10:03', '2021-10-22 00:10:03'),
(3, 12, 1, 1, 41000, '2021-10-22 00:10:06', '2021-10-22 00:10:06'),
(4, 9, 1, 1, 82900, '2021-10-22 00:10:09', '2021-10-22 00:10:09'),
(5, 14, 1, 1, 79000, '2021-10-22 00:10:12', '2021-10-22 00:10:12');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `invoice_id`, `from`, `method`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', '77248', '0895392920800', '2', '4621900', '3', '2021-10-22 00:20:10', '2021-10-22 00:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `stock` int(11) NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `sub_category_id`, `name`, `slug`, `size`, `description`, `price`, `stock`, `photo`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Monalisa Daster All Size Motif Karakter - Part1 - Tsum Tsum pink', 'monalisa-daster-all-size-motif-karakter-part1-tsum-tsum-pink', '123', 'Daster', 34000, 20, 'product/BoRIYtMuy1tGx95l5QwIxILX5jv3gaUb0z9yPMNY.jpg', 1, '2021-10-21 23:27:07', '2021-10-21 23:27:07'),
(2, 1, 4, 'Hoodie Jumper Small', 'hoodie-jumper-small', '1', 'Hoodie Jumper Small - S Nyaman', 169000, 100, 'product/qR6wHwBjB3rfAHXrZgCcPfzfs5my2IZvmJKLLF6k.jpg', 1, '2021-10-21 23:31:00', '2021-10-21 23:31:00'),
(3, 1, 2, 'Celana Jeans Abu abu', 'celana-jeans-abu-abu', '1', 'Celana Jeans Abu abu Uk 34,35,36,37', 199000, 998, 'product/BZWIAKs4VSc0WbxFT2DZYBLl4nKtHtDTrv4ZAvHP.jpg', 1, '2021-10-21 23:44:35', '2021-10-21 23:44:35'),
(4, 1, 10, 'Kemeja Polos Putih Lengan Panjang Slimfit', 'kemeja-polos-putih-lengan-panjang-slimfit', '1', 'Kemeja Polos Putih Lengan Panjang Slimfit - M', 84000, 898, 'product/ASZUu44xvu82NTa3t6Pyjp5FeTTo07yaxwlJHYsn.jpg', 1, '2021-10-21 23:47:32', '2021-10-21 23:47:32'),
(5, 1, 3, 'M231 Jaket Pria Oxford Panjang Warna Navy 1768B', 'm231-jaket-pria-oxford-panjang-warna-navy-1768b', '1', 'M231 Jaket Pria Oxford Panjang Warna Black 1768B', 179000, 100, 'product/3uT4STIsHZDkq8obiFn468A1NRTkVG6scxJdevsE.jpg', 1, '2021-10-21 23:49:36', '2021-10-21 23:49:36'),
(6, 1, 4, 'GARAF KSIE SWEATER PRIA LENGAN PANJANG JAKET SWEATER COWO HODIE', 'garaf-ksie-sweater-pria-lengan-panjang-jaket-sweater-cowo-hodie', '1', 'GARAF KSIE SWEATER PRIA LENGAN PANJANG JAKET SWEATER COWO HODIE', 49000, 496, 'product/gBvwMuixsj7uNwhM8IPkAKQl4dVvjBFORZxB5EhV.jpg', 1, '2021-10-21 23:50:54', '2021-10-21 23:50:54'),
(7, 2, 5, 'Kaos Oversize I N E C E L - Putih', 'kaos-oversize-i-n-e-c-e-l-putih', '1', 'Kaos Oversize I N E C E L - Putih', 25000, 1000, 'product/pX0bbdxdAkN8FMdkajVEA7XCtGcL1anRb19dnD7g.jpg', 1, '2021-10-21 23:53:04', '2021-10-21 23:53:04'),
(8, 2, 8, 'MINISO Dompet Wanita Bergaris Panjang Tiga Kali Lipat Dompet Wanita', 'miniso-dompet-wanita-bergaris-panjang-tiga-kali-lipat-dompet-wanita', '1', 'MINISO Dompet Wanita Bergaris Panjang Tiga Kali Lipat Dompet Wanita', 89900, 99, 'product/XbV9EKigYbjwGXcLqPcQZybt70IrFvjUO2x9X5jG.jpg', 1, '2021-10-21 23:56:33', '2021-10-21 23:56:33'),
(9, 2, 8, 'Dompet Panjang Wanita / Women Long Wallet', 'dompet-panjang-wanita-women-long-wallet', '1', 'Dompet Panjang Wanita / Women Long Wallet', 82900, 99, 'product/m9h8BNClmTXsWWthIKVYEXjWXMO7YXHHgacUyOoA.jpg', 1, '2021-10-21 23:58:52', '2021-10-22 00:15:22'),
(10, 2, 8, 'Dompet Wanita Coach Original Medium Corner ZIp Wallet Lily Print', 'dompet-wanita-coach-original-medium-corner-zip-wallet-lily-print', '100', 'Dompet Wanita Coach Original Medium Corner ZIp Wallet Lily Print', 429000, 887, 'product/OPnhHfTo6EkLh3HvdBknwFCbRUrrWCZWD9Y78Quv.jpg', 1, '2021-10-22 00:00:59', '2021-10-22 00:15:21'),
(11, 2, 7, 'Consenso collar tie poplin blouse ORIGINAL', 'consenso-collar-tie-poplin-blouse-original', '123', 'Consenso collar tie poplin blouse ORIGINAL', 129000, 99, 'product/tGdQkSD1MTlM2ZO57izmFj8uvDHVckqnAhnTPxdA.jpg', 1, '2021-10-22 00:02:26', '2021-10-22 00:15:22'),
(12, 2, 7, 'FortKlass KORINA Baju atasan blouse wanita lengan panjang', 'fortklass-korina-baju-atasan-blouse-wanita-lengan-panjang', '1', 'FortKlass KORINA Baju atasan blouse wanita lengan panjang', 41000, 197, 'product/EJ4A2eYKS9rNO7bxxzdagszPSwm96IZht6QEhXqk.jpg', 1, '2021-10-22 00:03:17', '2021-10-22 00:15:22'),
(13, 2, 7, 'BLOUSE PAKAIAN WANITA MOGA WHITE | X768', 'blouse-pakaian-wanita-moga-white-x768', '123', 'BLOUSE PAKAIAN WANITA MOGA WHITE | X768', 69000, 100, 'product/F4JmAUBf6uze6Z9fLLCTYUM0SzGMwIhZX1huJJj4.jpg', 1, '2021-10-22 00:04:28', '2021-10-22 00:04:28'),
(14, 2, 1, 'Atasan Wanita Blouse High Quality Terbaru Elegant', 'atasan-wanita-blouse-high-quality-terbaru-elegant', '1', 'Atasan Wanita Blouse High Quality Terbaru Elegant', 79000, 88, 'product/eK8QOfAyj88FHkQ56J6wNb8yGIoNFMxDchyyrQHA.jpg', 1, '2021-10-22 00:05:11', '2021-10-22 00:15:22');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'Member', '2021-10-21 22:48:59', '2021-10-21 22:48:59'),
(2, 'Admin', '2021-10-21 22:48:59', '2021-10-21 22:48:59');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `sub_category_name`, `slug`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'Daster', 'female-category-daster', 1, '2021-10-21 22:48:59', '2021-10-21 22:48:59'),
(2, 1, 'Jeans', 'male-category-jeans', 1, '2021-10-21 22:48:59', '2021-10-21 22:48:59'),
(3, 1, 'Jacket', 'male-category-jacket', 1, '2021-10-21 22:48:59', '2021-10-21 22:48:59'),
(4, 1, 'Hoodie', 'male-category-hoodie', 1, '2021-10-21 22:48:59', '2021-10-21 22:48:59'),
(5, 2, 'Kaos Wanita', 'female-category-kaos', 1, '2021-10-21 22:56:14', '2021-10-21 22:56:14'),
(6, 1, 'Kaos Pria', 'male-category-kaos', 1, '2021-10-21 22:56:31', '2021-10-21 22:56:31'),
(7, 2, 'Blouse', 'female-category-blouse', 1, '2021-10-21 22:56:47', '2021-10-21 22:56:47'),
(8, 2, 'Dompet', 'female-category-dompet', 1, '2021-10-21 22:57:21', '2021-10-21 22:57:21'),
(9, 2, 'Kemeja Wanita', 'female-category-kemeja', 1, '2021-10-21 22:57:50', '2021-10-21 22:57:50'),
(10, 1, 'Kemeja Pria', 'male-category-kemeja', 1, '2021-10-21 22:58:08', '2021-10-21 22:58:08'),
(11, 1, 'Celana Jogger', 'male-category-jogger', 1, '2021-10-21 22:58:44', '2021-10-21 22:58:44'),
(12, 2, 'Gamis', 'female-category-gamis', 1, '2021-10-21 22:59:51', '2021-10-21 22:59:51'),
(13, 2, 'Legging', 'female-category-legging', 1, '2021-10-21 23:00:16', '2021-10-21 23:00:16'),
(14, 2, 'Sweater', 'female-category-sweater', 1, '2021-10-21 23:01:51', '2021-10-21 23:01:51'),
(15, 1, 'Sweater', 'male-category-sweater', 1, '2021-10-21 23:02:08', '2021-10-21 23:02:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `photo`, `role_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'User Yulius', 'yiyus49@gmail.com', '$2y$10$QmD2gYJGaghFR7eTCPn6BOJMVniPhIX02nBJnmn/Lg3oj49yDtYlC', 'profile/default.jpg', 1, 1, '2021-10-21 22:48:59', '2021-10-21 22:48:59'),
(2, 'Admin Yulius', 'yiyus58@gmail.com', '$2y$10$YuHfxyZ.m4OLhPAmGYZSfeNGHegNT.V8FCKbUvvwTil7H5Bxfi4KW', 'profile/default.jpg', 2, 1, '2021-10-21 22:48:59', '2021-10-21 22:48:59');

-- --------------------------------------------------------

--
-- Table structure for table `user__tokens`
--

CREATE TABLE `user__tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_category_name_unique` (`category_name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_invoice_id_unique` (`invoice_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_invoice_id_unique` (`invoice_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_role_name_unique` (`role_name`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_categories_slug_unique` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user__tokens`
--
ALTER TABLE `user__tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user__tokens_token_unique` (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user__tokens`
--
ALTER TABLE `user__tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
