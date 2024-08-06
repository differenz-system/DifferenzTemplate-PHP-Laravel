-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 06, 2024 at 03:12 PM
-- Server version: 8.0.39-0ubuntu0.22.04.1
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `difftemplatenew`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password_tokens`
--

CREATE TABLE `forgot_password_tokens` (
  `TokenId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `UserId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forgot_password_tokens`
--

INSERT INTO `forgot_password_tokens` (`TokenId`, `UserId`, `Token`, `created_at`, `updated_at`) VALUES
('dy3ncVAM8hjHtQUh7w8QCl6TTKEZSm1N', 'pESzFqyJSmPeRCcO5l7tVDU07Ddj4IGv', '0', '2024-08-05 01:40:55', '2024-08-05 01:45:06');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_08_02_140511_create_forgot_password_tokens_table', 2),
(7, '2024_08_02_141333_alter_users_table_set_primary_key', 3),
(8, '2024_08_05_063110_change_tokenid_column_type_in_forgot_password_tokens_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Role` tinyint NOT NULL COMMENT '1: User, 2: Admin',
  `FirstName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `AuthToken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DeviceToken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DeviceType` tinyint NOT NULL DEFAULT '0' COMMENT '1: IOS, 2: Android, 3: Website, 4: Admin',
  `SocialType` tinyint NOT NULL DEFAULT '0' COMMENT '1: Normal, 2: Facebook, 3:Google',
  `SocialIdentifier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ProfilePicture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsDelete` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `Role`, `FirstName`, `LastName`, `Email`, `Password`, `AuthToken`, `DeviceToken`, `DeviceType`, `SocialType`, `SocialIdentifier`, `ProfilePicture`, `IsDelete`, `remember_token`, `created_at`, `updated_at`) VALUES
('9eaTdVDoqmwh82NVvCWdczrYIJ3DOWkB', 1, 'john', 'lewis', 'john@yopmail.com', '$2y$10$7GER5bE8SXsTaZFy3nTz0.bhqc5yuJk4B8IySmLKtVvi1fwihVNgm', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.RGlmZmVyZW56UHJvamVjdA.5KR05FpSU9TvTLGbcJx580w6QmZBJa34RcSU5t6RMdQ', '', 1, 0, '123', '1578045981.jpg', '0', NULL, '2020-01-03 04:36:21', '2024-08-02 07:53:31'),
('9KlMPBCPPSELEEVpeYWwuVUGWPPSgyZC', 1, 'test', 'test', 'test@gmail.com', '$2y$12$havbmwUYGoMP4OmSsgtbcOao9qHrPZAxun3t.o4wB1Hr2P//bdq9m', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.RGlmZmVyZW56UHJvamVjdA.9OkuJ9O-xMvBMdJgNKvcy55_KcGq-BV6-javYVTq0uo', '', 1, 0, '', '', '0', NULL, '2024-08-02 09:05:18', '2024-08-02 09:05:18'),
('aff878cdd4dd790ecc8a21832aa59a61', 2, 'Differenz', 'Project', 'differenzproject@yopmail.com', '$2y$12$we51KArRp.knzEuawbGjfOGdEWAlCqQvmGs0vvF4dUWc25nIx/8S2', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.RGlmZmVyZW56UHJvamVjdA.QhbUhWw3GY_ZS1u6i1k48XL_iiKo9rbAvsBGtrjX2q0', 'string', 4, 0, NULL, '1722936315.png', '0', NULL, '2019-11-14 10:35:41', '2024-08-06 03:55:15'),
('pESzFqyJSmPeRCcO5l7tVDU07Ddj4IGv', 1, 'abc', 'abc', 'abc@gmail.com', '$2y$12$we51KArRp.knzEuawbGjfOGdEWAlCqQvmGs0vvF4dUWc25nIx/8S2', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.RGlmZmVyZW56UHJvamVjdA.Vh_9gWJGcKFkQ7HhDLO7RjnAnY67rxaWZqmCoH1kl0k', '', 1, 0, NULL, '', '0', NULL, '2024-08-04 23:39:09', '2024-08-05 01:45:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `forgot_password_tokens`
--
ALTER TABLE `forgot_password_tokens`
  ADD PRIMARY KEY (`TokenId`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `users_email_unique` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
