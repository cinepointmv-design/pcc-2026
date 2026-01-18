-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2024 at 11:45 AM
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
-- Database: `bcrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `allservice`
--

CREATE TABLE `allservice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `allservice`
--

INSERT INTO `allservice` (`id`, `name`, `price`, `created_at`, `updated_at`) VALUES
(5, 'CRM', 4000.00, '2024-01-05 02:08:31', '2024-01-05 02:09:27'),
(6, 'Digital marketing', 8000.00, '2024-01-05 02:08:56', '2024-01-05 02:08:56'),
(7, 'Web desiging', 5000.00, '2024-01-05 02:09:08', '2024-01-05 02:09:15');

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batch_time` time NOT NULL,
  `course` varchar(255) NOT NULL,
  `lab` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `whatsapp_api` varchar(255) DEFAULT NULL,
  `sms_api` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `username`, `email`, `phone`, `business_name`, `password`, `location`, `whatsapp_number`, `whatsapp_api`, `sms_api`, `created_at`, `updated_at`) VALUES
(31, 'Arashdeep Singh', 'arashdeepsingh@admin', 'hypergaming8954@gmail.com', '7986779699', 'dffd', '123', 'Patiala,Punjab', '7986779699', 'ds322', '232efd', '2024-01-06 01:10:02', '2024-01-06 01:10:02');

-- --------------------------------------------------------

--
-- Table structure for table `client_payments`
--

CREATE TABLE `client_payments` (
  `id` int(11) NOT NULL,
  `client_id` int(200) NOT NULL,
  `total_payment` int(200) NOT NULL,
  `total_paid_amount` int(200) DEFAULT NULL,
  `pay_amount` int(200) NOT NULL,
  `pending_amount` int(200) NOT NULL,
  `payment_date` date NOT NULL,
  `next_due_date` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_payments`
--

INSERT INTO `client_payments` (`id`, `client_id`, `total_payment`, `total_paid_amount`, `pay_amount`, `pending_amount`, `payment_date`, `next_due_date`, `updated_at`, `created_at`) VALUES
(12, 31, 12000, 10000, 10000, 2000, '2024-02-11', '2024-02-10', '2024-01-11 00:17:01', '2024-01-06 01:10:02');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `fees` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `lab_number` int(50) NOT NULL,
  `client_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `fees`, `duration`, `created_at`, `updated_at`, `lab_number`, `client_id`) VALUES
(43, 'Graphics', '2000', 2, '2024-01-14 07:09:16', '2024-01-14 07:09:16', 46, 31),
(44, 'web', '3000', 1, '2024-01-14 07:09:32', '2024-01-14 07:09:32', 46, 31),
(45, 'digital', '1000', 2, '2024-01-15 03:28:54', '2024-01-15 03:28:54', 47, 31),
(46, 'development', '32332', 2, '2024-01-15 03:29:09', '2024-01-15 03:29:09', 48, 31);

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `demo_date` date NOT NULL,
  `followup_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `course_id` int(200) NOT NULL,
  `client_id` int(200) NOT NULL,
  `status` enum('open','close','lead','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enquiries`
--

INSERT INTO `enquiries` (`id`, `name`, `email`, `phone`, `whatsapp_number`, `reference`, `demo_date`, `followup_date`, `description`, `created_at`, `updated_at`, `course_id`, `client_id`, `status`) VALUES
(79, 'testing', 'harry@gmail.com', '7986779699', '7986779699', 'esssa', '2024-01-10', '2024-01-14', 'sdcd', '2024-01-14 07:26:18', '2024-01-14 07:29:38', 43, 31, 'lead'),
(85, 'harry', 'harry1@gmail.comds', '213231233443', '7986779699', NULL, '2024-01-10', '2024-01-15', NULL, '2024-01-14 08:31:05', '2024-01-14 23:55:59', 43, 31, 'lead'),
(88, 'new enquiry', 'newenquiry@gmail.com', '798677969943', NULL, NULL, '2024-01-14', '2024-01-16', NULL, '2024-01-16 00:58:08', '2024-01-16 00:59:25', 44, 31, 'lead'),
(89, 'Karan', 'kaml@gmal.comsad', '79867 7969934', '7986779699', 'adsads', '2024-01-09', '2024-01-19', 'asd', '2024-01-16 02:20:19', '2024-01-19 07:11:08', 45, 31, 'close'),
(90, 'Arash', 'noob@gmail.comddc', '354154544543', '7986779699', 'adsads', '2024-01-13', '2024-01-19', NULL, '2024-01-16 05:07:31', '2024-01-19 07:16:42', 45, 31, 'close'),
(91, 'totdatjkjfsd', 'kaml@gmal.comdasda', '354154544545', NULL, NULL, '2024-01-15', '2024-01-19', NULL, '2024-01-19 07:21:47', '2024-01-19 07:22:42', 44, 31, 'close'),
(92, 'Arash', 'badjadjkahskd@gmal.com', '79867723423', NULL, 'adsads', '2024-01-17', '2024-01-18', NULL, '2024-01-19 07:27:35', '2024-01-19 07:27:35', 45, 31, 'open');

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
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `student_id` int(200) NOT NULL,
  `total_fees` int(200) NOT NULL,
  `total_paid_fees` int(200) NOT NULL,
  `pay_amount` int(200) DEFAULT NULL,
  `pending_fees` int(200) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `next_due_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `student_id`, `total_fees`, `total_paid_fees`, `pay_amount`, `pending_fees`, `payment_date`, `next_due_date`, `created_at`, `updated_at`) VALUES
(135, 172, 2000, 1000, 1000, 1000, '2024-01-14', '2024-01-17', '2024-01-14 13:00:44', '2024-01-14 13:00:44'),
(136, 172, 2000, 1500, 500, 500, '2024-01-14', '2024-01-15', '2024-01-14 13:02:27', '2024-01-14 13:02:27'),
(137, 173, 5000, 2000, 2000, 3000, '2024-01-15', '2024-01-17', '2024-01-15 05:26:39', '2024-01-15 05:26:39'),
(138, 172, 2000, 2000, 500, 0, '2024-01-15', NULL, '2024-01-15 05:27:21', '2024-01-15 05:27:21'),
(142, 180, 2000, 1000, 1000, 1000, '2024-01-15', '2024-02-14', '2024-01-15 08:46:29', '2024-01-15 08:46:29'),
(143, 181, 2000, 1000, 1000, 1000, '2024-01-15', '2024-02-14', '2024-01-15 08:48:19', '2024-01-15 08:48:19'),
(145, 183, 1000, 1000, 1000, 0, '2024-01-16', NULL, '2024-01-16 06:29:44', '2024-01-16 06:29:44');

-- --------------------------------------------------------

--
-- Table structure for table `followup`
--

CREATE TABLE `followup` (
  `id` int(11) NOT NULL,
  `enquiry_id` int(11) DEFAULT NULL,
  `call` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `status` enum('open','close','lead','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `followup`
--

INSERT INTO `followup` (`id`, `enquiry_id`, `call`, `time`, `description`, `updated_at`, `created_at`, `status`) VALUES
(111, 80, NULL, NULL, NULL, '2024-01-14 07:53:32', '2024-01-14 07:53:32', 'open'),
(112, 81, NULL, NULL, NULL, '2024-01-14 07:54:54', '2024-01-14 07:54:54', 'open'),
(113, 82, NULL, NULL, NULL, '2024-01-14 08:02:26', '2024-01-14 08:02:26', 'open'),
(117, 86, NULL, NULL, NULL, '2024-01-14 08:34:08', '2024-01-14 08:34:08', 'open'),
(121, 88, NULL, NULL, NULL, '2024-01-16 00:58:08', '2024-01-16 00:58:08', 'open'),
(122, 88, '2024-01-16', '06:29:03', 'ew', '2024-01-16 00:59:03', '2024-01-16 00:59:03', 'open'),
(123, 88, '2024-01-16', '06:29:25', 'done', '2024-01-16 00:59:25', '2024-01-16 00:59:25', 'lead'),
(130, 91, NULL, NULL, NULL, '2024-01-19 07:21:47', '2024-01-19 07:21:47', 'open'),
(131, 91, '2024-01-19', '12:52:12', 'yes', '2024-01-19 07:22:12', '2024-01-19 07:22:12', 'open'),
(132, 91, '2024-01-19', '12:52:42', NULL, '2024-01-19 07:22:42', '2024-01-19 07:22:42', 'close'),
(133, 92, NULL, NULL, NULL, '2024-01-19 07:27:35', '2024-01-19 07:27:35', 'open');

-- --------------------------------------------------------

--
-- Table structure for table `labs`
--

CREATE TABLE `labs` (
  `id` int(11) NOT NULL,
  `lab_name` varchar(200) DEFAULT NULL,
  `seats` int(11) NOT NULL,
  `total_seats` varchar(200) DEFAULT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL,
  `client_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `labs`
--

INSERT INTO `labs` (`id`, `lab_name`, `seats`, `total_seats`, `updated_at`, `created_at`, `client_id`) VALUES
(46, 'lab 1', 0, '1', '2024-01-15', '2024-01-14', 31),
(47, 'lab 2', 2, '3', '2024-01-16', '2024-01-15', 31),
(48, 'lab 4', 5, '5', '2024-01-15', '2024-01-15', 31);

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2023_11_14_074008_create_sessions_table', 1),
(8, '2023_11_14_091255_create_clients_table', 1),
(9, '2023_11_14_114906_create_services_table', 1),
(10, '2023_11_20_121747_create_allservice_table', 1),
(11, '2023_12_14_103408_create_enquiries_table', 1),
(12, '2023_12_14_104912_create_courses_table', 1),
(13, '2023_12_15_085625_create_batches_table', 1),
(14, '2023_12_15_120246_create_students_table', 2),
(15, '2023_12_17_075741_create_student_course_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `owner_login`
--

CREATE TABLE `owner_login` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owner_login`
--

INSERT INTO `owner_login` (`id`, `name`, `email`, `password`) VALUES
(5, 'kamal', 'kamal@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `service` varchar(255) NOT NULL,
  `duration_months` int(11) NOT NULL,
  `charges` decimal(8,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expiry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `username`, `service`, `duration_months`, `charges`, `description`, `created_at`, `updated_at`, `expiry_date`) VALUES
(55, 'arashdeepsingh@admin', 'Digital marketing', 1, 8000.00, 'ds', '2024-01-06 01:10:02', '2024-01-11 00:17:01', '2024-02-11'),
(66, 'arashdeepsingh@admin', 'CRM', 1, 4000.00, NULL, '2024-01-08 23:34:39', '2024-01-11 00:17:01', '2024-02-11');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('6kVOnEjRcV5APZYGyMMDIg5EQYwNymeOhKptmCRv', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiT21UVnd4R3JmakRQTmlLTXNuRm9QeDNNV3d6eUp0M0VZZlFTRzNBRyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdHVkZW50cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7czo0OiJuYW1lIjtzOjE1OiJBcmFzaGRlZXAgU2luZ2giO3M6OToiY2xpZW50X2lkIjtpOjMxO3M6MTA6ImFkbWluX25hbWUiO3M6NToia2FtYWwiO3M6ODoiYWRtaW5faWQiO2k6NTt9', 1705926462),
('k9gJhsCpb8l8GAZ3JlcqxLnlUPgFS5jEP7JvvRNC', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMDlaSlB2ZVFVWjcwRFVISkJqWlJCUUM1Mk1GaWs5WTJoeU5CYmFlTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbGllbnRzLWxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1706265761);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `whatsapp_number` varchar(200) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `fathername` varchar(255) DEFAULT NULL,
  `joiningdate` date DEFAULT current_timestamp(),
  `DOB` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `community` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `board` varchar(255) DEFAULT NULL,
  `passing_year` varchar(255) DEFAULT NULL,
  `percentage` double(8,2) DEFAULT NULL,
  `subjects` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `client_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `phone`, `whatsapp_number`, `city`, `fathername`, `joiningdate`, `DOB`, `gender`, `address`, `pincode`, `community`, `qualification`, `board`, `passing_year`, `percentage`, `subjects`, `created_at`, `updated_at`, `client_id`) VALUES
(172, 'testing', 'harry@gmail.com', '7986779699', '7986779699', NULL, 'gurdhian singh', '2024-01-14', '2024-01-14', 'male', 'patiala', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-14 07:30:44', '2024-01-14 07:30:44', 31),
(173, 'harry', 'harry1@gmail.comds', '213231233443', '7986779699', NULL, 'gurdhian singh', '2024-01-15', '2024-01-15', 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-14 23:56:39', '2024-01-14 23:56:39', 31),
(180, 'testing', 'karan@gmail.comhj', '21323123', NULL, NULL, NULL, '2024-01-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-15 03:16:29', '2024-01-15 03:16:29', 31),
(181, 'harry', 'kamal@gmail.com', '2132312334', NULL, NULL, NULL, '2024-01-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-15 03:18:19', '2024-01-15 03:18:19', 31),
(183, 'new enquiry', 'newenquiry@gmail.com', '798677969943', NULL, NULL, NULL, '2024-01-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-16 00:59:44', '2024-01-16 00:59:44', 31);

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE `student_course` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `batch` varchar(255) NOT NULL,
  `fees` int(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`id`, `student_id`, `course_id`, `batch`, `fees`, `created_at`, `updated_at`) VALUES
(254, 172, 43, '12:00 PM to 12:00 PM', 2000, '2024-01-14 07:30:44', '2024-01-14 07:30:44'),
(255, 173, 43, '12:00 PM to 12:00 PM', 2000, '2024-01-14 23:56:39', '2024-01-14 23:56:39'),
(256, 173, 44, '12:00 PM to 12:00 PM', 3000, '2024-01-14 23:56:39', '2024-01-14 23:56:39'),
(261, 180, 43, '12:00 PM to 12:00 PM', 2000, '2024-01-15 03:16:29', '2024-01-15 03:16:29'),
(262, 181, 43, '12:00 PM to 12:00 PM', 2000, '2024-01-15 03:18:19', '2024-01-15 03:18:19'),
(265, 183, 45, '12:00 PM to 12:00 PM', 1000, '2024-01-16 00:59:44', '2024-01-16 00:59:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allservice`
--
ALTER TABLE `allservice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_username_unique` (`username`),
  ADD UNIQUE KEY `clients_email_unique` (`email`);

--
-- Indexes for table `client_payments`
--
ALTER TABLE `client_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enquiries_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followup`
--
ALTER TABLE `followup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `labs`
--
ALTER TABLE `labs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owner_login`
--
ALTER TABLE `owner_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student_course`
--
ALTER TABLE `student_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_course_student_id_foreign` (`student_id`),
  ADD KEY `student_course_course_id_foreign` (`course_id`);

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
-- AUTO_INCREMENT for table `allservice`
--
ALTER TABLE `allservice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `client_payments`
--
ALTER TABLE `client_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `followup`
--
ALTER TABLE `followup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `labs`
--
ALTER TABLE `labs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `owner_login`
--
ALTER TABLE `owner_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `student_course`
--
ALTER TABLE `student_course`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_course`
--
ALTER TABLE `student_course`
  ADD CONSTRAINT `student_course_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_course_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
