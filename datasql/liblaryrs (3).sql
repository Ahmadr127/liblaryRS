-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 05, 2025 at 09:04 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `liblaryrs`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'medis', 'Medis', '2025-09-03 02:24:18', '2025-09-03 02:24:18'),
(2, 'keperawatan', 'Keperawatan', '2025-09-03 02:24:18', '2025-09-03 02:24:18'),
(3, 'umum', 'Umum', '2025-09-03 02:24:18', '2025-09-03 02:24:18');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organizer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `context` text COLLATE utf8mb4_unicode_ci,
  `activity_date` date DEFAULT NULL,
  `activity_date_start` date DEFAULT NULL,
  `activity_date_end` date DEFAULT NULL,
  `uploaded_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `category_id`, `title`, `organizer`, `source`, `context`, `activity_date`, `activity_date_start`, `activity_date_end`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(1, 2, 'Testing Materi keperawatan', 'testing p', 'Testing s', NULL, '2025-09-10', NULL, NULL, 1, '2025-09-03 02:36:43', '2025-09-03 02:36:43'),
(2, 1, 'Testing umum', 'testing p', 'testiing s', NULL, '2025-09-05', NULL, NULL, 1, '2025-09-03 02:37:26', '2025-09-03 02:37:26'),
(3, 3, 'asd', 'asd', 'asd', NULL, '2025-09-10', NULL, NULL, 1, '2025-09-03 18:06:43', '2025-09-03 18:06:43'),
(4, 2, 'test rentang tanggal', 'test rentang tgl', 'test r tenggal', NULL, '2025-09-06', '2025-09-06', '2025-09-10', 1, '2025-09-03 18:33:36', '2025-09-03 18:33:36'),
(5, 3, 'test tgl tunggal', 'test tgl tunggal', 'test tgl tunggal', NULL, '2025-09-05', NULL, NULL, 1, '2025-09-03 18:34:36', '2025-09-03 18:34:36'),
(6, 1, 'asd', 'asd', 'asd', NULL, '2025-09-05', NULL, NULL, 1, '2025-09-04 19:28:16', '2025-09-04 19:28:16'),
(7, 2, 'test', 'test penyelenggara', 'test sumber', '<p>test konteks</p>', '2025-09-11', '2025-09-11', '2025-09-25', 1, '2025-09-04 19:45:07', '2025-09-04 19:45:07'),
(8, 2, 'test', 'test', 'test', '<p>test</p>', '2025-09-06', NULL, NULL, 1, '2025-09-04 19:53:43', '2025-09-04 19:53:43'),
(9, 3, 'assadasd', 'asddas', 'asdsda', '<p>asdasdassda</p>', '2025-09-18', NULL, NULL, 1, '2025-09-04 19:55:25', '2025-09-04 19:55:25'),
(10, 2, 'asdasdasdasd', 'asdasdfddf', 'asdasd', '<p>asasf</p>', '2025-09-02', '2025-09-05', '2025-09-19', 1, '2025-09-04 19:58:26', '2025-09-04 19:58:26'),
(11, 3, 'asd', 'asdasd', 'asd', '<p>asdasdasd</p>', '2025-09-06', NULL, NULL, 1, '2025-09-04 19:58:45', '2025-09-04 19:58:45'),
(12, 2, 'test sync', 'test sync p', 'test sumber', '<p>Test sync</p>', '2025-09-13', NULL, NULL, 1, '2025-09-05 08:49:59', '2025-09-05 08:49:59');

-- --------------------------------------------------------

--
-- Table structure for table `material_files`
--

CREATE TABLE `material_files` (
  `id` bigint UNSIGNED NOT NULL,
  `material_id` bigint UNSIGNED NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_files`
--

INSERT INTO `material_files` (`id`, `material_id`, `file_path`, `file_name`, `original_name`, `file_size`, `created_at`, `updated_at`) VALUES
(1, 1, 'materials/1756892203_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', '1756892203_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', '7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', 335824, '2025-09-03 02:36:43', '2025-09-03 02:36:43'),
(2, 2, 'materials/1756892246_9.1.3-packet-tracer---identify-mac-and-ip-addresses.pdf', '1756892246_9.1.3-packet-tracer---identify-mac-and-ip-addresses.pdf', '9.1.3-packet-tracer---identify-mac-and-ip-addresses.pdf', 165236, '2025-09-03 02:37:26', '2025-09-03 02:37:26'),
(3, 2, 'materials/1756892246_7.1.6-lab---use-wireshark-to-examine-ethernet-frames.pdf', '1756892246_7.1.6-lab---use-wireshark-to-examine-ethernet-frames.pdf', '7.1.6-lab---use-wireshark-to-examine-ethernet-frames.pdf', 335824, '2025-09-03 02:37:26', '2025-09-03 02:37:26'),
(4, 3, 'materials/1756948003_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', '1756948003_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', '7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', 335824, '2025-09-03 18:06:44', '2025-09-03 18:06:44'),
(5, 3, 'materials/1756948004_1756870063_9.3.4-packet-tracer---ipv6-neighbor-discovery.pdf', '1756948004_1756870063_9.3.4-packet-tracer---ipv6-neighbor-discovery.pdf', '1756870063_9.3.4-packet-tracer---ipv6-neighbor-discovery.pdf', 150044, '2025-09-03 18:06:44', '2025-09-03 18:06:44'),
(6, 4, 'materials/1756949616_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', '1756949616_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', '7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', 335824, '2025-09-03 18:33:38', '2025-09-03 18:33:38'),
(7, 4, 'materials/1756949618_1756870063_9.3.4-packet-tracer---ipv6-neighbor-discovery.pdf', '1756949618_1756870063_9.3.4-packet-tracer---ipv6-neighbor-discovery.pdf', '1756870063_9.3.4-packet-tracer---ipv6-neighbor-discovery.pdf', 150044, '2025-09-03 18:33:38', '2025-09-03 18:33:38'),
(8, 5, 'materials/1756949676_1756870063_9.3.4-packet-tracer---ipv6-neighbor-discovery.pdf', '1756949676_1756870063_9.3.4-packet-tracer---ipv6-neighbor-discovery.pdf', '1756870063_9.3.4-packet-tracer---ipv6-neighbor-discovery.pdf', 150044, '2025-09-03 18:34:36', '2025-09-03 18:34:36'),
(9, 6, 'materials/1757039296_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1) (1).pdf', '1757039296_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1) (1).pdf', '7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1) (1).pdf', 335824, '2025-09-04 19:28:16', '2025-09-04 19:28:16'),
(10, 7, 'materials/1757040307_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', '1757040307_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', '7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', 335824, '2025-09-04 19:45:07', '2025-09-04 19:45:07'),
(11, 8, 'materials/1757040823_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', '1757040823_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', '7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', 335824, '2025-09-04 19:53:43', '2025-09-04 19:53:43'),
(12, 9, 'materials/1757040925_1756870063_9.3.4-packet-tracer---ipv6-neighbor-discovery.pdf', '1757040925_1756870063_9.3.4-packet-tracer---ipv6-neighbor-discovery.pdf', '1756870063_9.3.4-packet-tracer---ipv6-neighbor-discovery.pdf', 150044, '2025-09-04 19:55:25', '2025-09-04 19:55:25'),
(13, 10, 'materials/1757041106_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', '1757041106_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', '7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', 335824, '2025-09-04 19:58:26', '2025-09-04 19:58:26'),
(14, 11, 'materials/1757041125_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', '1757041125_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', '7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1).pdf', 335824, '2025-09-04 19:58:45', '2025-09-04 19:58:45'),
(15, 12, 'materials/1757062199_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1) (1).pdf', '1757062199_7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1) (1).pdf', '7.1.6-lab---use-wireshark-to-examine-ethernet-frames (1) (1).pdf', 335824, '2025-09-05 08:49:59', '2025-09-05 08:49:59');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000000_create_roles_table', 1),
(5, '2024_01_01_000001_create_permissions_table', 1),
(6, '2024_01_01_000002_create_role_permission_table', 1),
(7, '2024_01_01_000003_add_role_id_to_users_table', 1),
(8, '2025_09_03_030331_add_username_to_users_table', 1),
(9, '2025_09_03_031603_create_materials_table', 1),
(10, '2025_09_03_034411_create_material_files_table', 1),
(11, '2025_09_03_034526_remove_file_fields_from_materials_table', 1),
(12, '2025_09_03_120000_create_categories_table', 1),
(13, '2025_09_03_130000_drop_category_enum_from_materials_table', 1),
(14, '2025_09_04_004347_add_index_to_activity_date_in_materials_table', 2),
(15, '2025_09_04_011129_add_date_range_to_materials_table', 3),
(16, '2025_09_04_012731_make_activity_date_nullable_in_materials_table', 4),
(17, '2025_09_05_000542_create_news_table', 5),
(18, '2025_09_05_023331_add_context_to_materials_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `views` int NOT NULL DEFAULT '0',
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `meta_data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `slug`, `image`, `image_alt`, `category_id`, `author_id`, `status`, `published_at`, `views`, `excerpt`, `meta_data`, `created_at`, `updated_at`) VALUES
(1, 'Pembukaan Perpustakaan Digital RS Modern', '<p>Kami dengan bangga mengumumkan pembukaan perpustakaan digital RS Modern yang akan memberikan akses mudah terhadap berbagai materi pembelajaran dan referensi medis untuk seluruh staf rumah sakit.</p><p>Perpustakaan digital ini dilengkapi dengan berbagai fitur canggih seperti pencarian materi, kategorisasi yang terorganisir, dan akses 24/7 dari mana saja.</p><p>Dengan adanya perpustakaan digital ini, diharapkan dapat meningkatkan kualitas pelayanan kesehatan melalui peningkatan pengetahuan dan keterampilan staf medis.</p>', 'pembukaan-perpustakaan-digital-rs-modern', NULL, NULL, 2, 1, 'published', '2025-08-30 17:18:20', 453, 'Perpustakaan digital RS Modern resmi dibuka dengan berbagai fitur canggih untuk mendukung pembelajaran staf medis.', '{\"meta_title\": \"Pembukaan Perpustakaan Digital RS Modern - Berita Terbaru\", \"meta_description\": \"Perpustakaan digital RS Modern resmi dibuka dengan berbagai fitur canggih untuk mendukung pembelajaran staf medis.\"}', '2025-09-04 17:18:20', '2025-09-04 17:18:20'),
(2, 'Pelatihan Penggunaan Sistem Perpustakaan Digital', '<p>Dalam rangka memaksimalkan penggunaan perpustakaan digital, RS Modern akan mengadakan pelatihan intensif untuk seluruh staf.</p><p>Pelatihan akan mencakup:</p><ul><li>Cara mengakses dan menggunakan sistem</li><li>Teknik pencarian materi yang efektif</li><li>Manajemen akun pengguna</li><li>Fitur-fitur advanced yang tersedia</li></ul><p>Pelatihan akan dilaksanakan secara bertahap sesuai dengan jadwal masing-masing departemen.</p>', 'pelatihan-penggunaan-sistem-perpustakaan-digital', NULL, NULL, 2, 1, 'published', '2025-09-01 17:18:20', 201, 'RS Modern mengadakan pelatihan intensif untuk memaksimalkan penggunaan perpustakaan digital bagi seluruh staf.', '{\"meta_title\": \"Pelatihan Sistem Perpustakaan Digital RS Modern\", \"meta_description\": \"RS Modern mengadakan pelatihan intensif untuk memaksimalkan penggunaan perpustakaan digital bagi seluruh staf.\"}', '2025-09-04 17:18:20', '2025-09-05 08:52:04'),
(3, 'Penambahan Koleksi Materi Terbaru', '<p>Perpustakaan digital RS Modern telah menambahkan koleksi materi terbaru yang mencakup berbagai bidang medis dan keperawatan.</p><p>Materi baru yang ditambahkan meliputi:</p><ul><li>Panduan terbaru untuk penanganan COVID-19</li><li>Protokol keperawatan modern</li><li>Teknologi medis terkini</li><li>Best practices dalam pelayanan kesehatan</li></ul><p>Semua materi telah melalui proses review dan validasi oleh tim medis berpengalaman.</p>', 'penambahan-koleksi-materi-terbaru', NULL, NULL, 1, 1, 'published', '2025-09-03 17:18:20', 188, 'Perpustakaan digital menambahkan koleksi materi terbaru yang mencakup berbagai bidang medis dan keperawatan.', '{\"meta_title\": \"Koleksi Materi Terbaru Perpustakaan Digital RS Modern\", \"meta_description\": \"Perpustakaan digital menambahkan koleksi materi terbaru yang mencakup berbagai bidang medis dan keperawatan.\"}', '2025-09-04 17:18:20', '2025-09-05 08:41:36'),
(6, 'asd', 'asd', 'asd', 'news/1757033057_asd.jpg', 'asd', 1, 1, 'published', '2025-09-12 00:44:00', 3, 'asd', '{\"meta_title\": \"a\", \"meta_description\": \"asd\"}', '2025-09-04 17:44:18', '2025-09-05 00:59:33'),
(7, 'Test', '<h1>asd</h1><p><br></p><p>asd<em> asdasd</em></p>', 'test', 'news/1757036490_test.jpg', NULL, 2, 1, 'published', '2025-09-05 01:41:00', 4, NULL, NULL, '2025-09-04 18:41:31', '2025-09-05 08:41:25'),
(8, 'Yusril Ungkap Rencana RUU Perampasan Aset Masuk Prolegnas 2025-2026', '<p><strong>Jakarta</strong> - Menko Hukum, HAM, Imigrasi, dan Pemasyarakatan, Yusril Ihza Mahendra, mengungkapkan Presiden Prabowo Subianto sudah mendorong RUU Perampasan Aset dibahas oleh DPR. Yusril mengungkapkan rencana RUU Perampasan Aset masuk dalam Prolegnas 2025-2026</p><p>\"Pak Presiden pun sudah beberapa kali juga menegaskan supaya DPR segera membahas RUU itu,\" kata Yusril di kompleks Istana Kepresidenan, Jakarta, Kamis (5/9/2025).</p><p><br></p><p>Baca artikel detiknews, \"Yusril Ungkap Rencana RUU Perampasan Aset Masuk Prolegnas 2025-2026\" selengkapnya&nbsp;<a href=\"https://news.detik.com/berita/d-8097362/yusril-ungkap-rencana-ruu-perampasan-aset-masuk-prolegnas-2025-2026\" target=\"_blank\" style=\"color: rgb(0, 0, 0);\">https://news.detik.com/berita/d-8097362/yusril-ungkap-rencana-ruu-perampasan-aset-masuk-prolegnas-2025-2026</a>.</p><p><br></p>', 'yusril-ungkap-rencana-ruu-perampasan-aset-masuk-prolegnas-2025-2026', 'news/1757059381_yusril-ungkap-rencana-ruu-perampasan-aset-masuk-prolegnas-2025-2026.png', NULL, 3, 1, 'published', '2025-09-06 08:02:00', 0, NULL, NULL, '2025-09-05 01:03:02', '2025-09-05 01:03:02'),
(9, 'test timezone', '<p>asdasd</p>', 'test-timezone', 'news/1757060512_test-timezone.png', NULL, 2, 1, 'published', '2025-09-05 08:23:00', 2, NULL, NULL, '2025-09-05 08:21:52', '2025-09-05 08:33:25'),
(10, 'test news', '<p>test waktu otomatis</p>', 'test-news', 'news/1757061083_test-news.png', NULL, 3, 1, 'published', '2025-09-05 08:31:23', 3, NULL, NULL, '2025-09-05 08:31:23', '2025-09-05 08:41:29'),
(11, 'Test sync', '<p>test sync</p>', 'test-sync', 'news/1757062237_test-sync.jpg', NULL, 3, 1, 'published', '2025-09-05 08:50:37', 1, NULL, NULL, '2025-09-05 08:50:37', '2025-09-05 08:50:46');

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'manage_roles', 'Kelola Roles', 'Mengelola roles dan permissions', '2025-09-03 02:24:18', '2025-09-03 02:24:18'),
(2, 'manage_permissions', 'Kelola Permissions', 'Mengelola permissions', '2025-09-03 02:24:18', '2025-09-03 02:24:18'),
(3, 'view_dashboard', 'Lihat Dashboard', 'Melihat halaman dashboard', '2025-09-03 02:24:18', '2025-09-03 02:24:18'),
(4, 'manage_users', 'Kelola Users', 'Mengelola pengguna', '2025-09-03 02:24:18', '2025-09-03 02:24:18'),
(5, 'manage_materials', 'Kelola Materi', 'Mengelola materi perpustakaan', '2025-09-03 02:24:18', '2025-09-03 02:24:18'),
(6, 'view_materials', 'Lihat Materi', 'Melihat daftar materi perpustakaan', '2025-09-03 02:24:18', '2025-09-03 02:24:18'),
(7, 'manage_categories', 'Kelola Kategori', 'Mengelola master kategori materi', '2025-09-03 02:24:18', '2025-09-03 02:24:18'),
(8, 'view_categories', 'Lihat Kategori', 'Melihat master kategori materi', '2025-09-03 02:24:18', '2025-09-03 02:24:18'),
(12, 'manage_news', 'Kelola Berita', 'Mengelola berita dan artikel', '2025-09-04 17:22:12', '2025-09-04 17:22:12'),
(13, 'view_news', 'Lihat Berita', 'Melihat daftar berita dan artikel', '2025-09-04 17:22:12', '2025-09-04 17:22:12');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', 'Role dengan akses penuh ke sistem', '2025-09-03 02:24:18', '2025-09-03 02:24:18'),
(2, 'librarian', 'Pustakawan', 'Role untuk mengelola perpustakaan', '2025-09-03 02:24:18', '2025-09-03 02:24:18'),
(3, 'user', 'Pengguna', 'Role untuk pengguna umum', '2025-09-03 02:24:18', '2025-09-03 02:24:18');

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 3, NULL, NULL),
(4, 1, 4, NULL, NULL),
(5, 1, 5, NULL, NULL),
(7, 1, 7, NULL, NULL),
(8, 1, 8, NULL, NULL),
(9, 2, 7, NULL, NULL),
(10, 2, 5, NULL, NULL),
(11, 2, 8, NULL, NULL),
(12, 2, 3, NULL, NULL),
(13, 2, 6, NULL, NULL),
(15, 3, 3, NULL, NULL),
(16, 3, 6, NULL, NULL),
(17, 1, 12, NULL, NULL),
(19, 2, 12, NULL, NULL),
(20, 2, 13, NULL, NULL),
(21, 3, 13, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('WAmhdif10hXCbCK5qYEU8734MRYbM5iKIOlSZk6p', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVTRqUVZCTWRVZ2poQkliU0hsa0w2VjhhVEtGUXFiMzk1bHdCR0hZYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1757062328);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`) VALUES
(1, 'Administrator', 'admin', 'admin@example.com', '2025-09-03 02:24:18', '$2y$12$SA11kBhnyMc9XWjjQQThWOspvLL.EzXh6ZrKry7F7qNjoUwQ6iXfe', 'oFZMftRrQ6yDCMYg8O6jrAhYGc5wbojiMO29LjM3aexqdX4Pr4tRd8nyXGWl', '2025-09-03 02:24:18', '2025-09-04 17:28:21', 1),
(2, 'user', 'user', 'user@gmail.com', NULL, '$2y$12$mwOcuEFV6ePuKnXuC1vWWepOYEDXBl9xIDeMONWf/lg1yW4KzYbV.', NULL, '2025-09-03 02:34:36', '2025-09-03 02:34:36', 3);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materials_uploaded_by_foreign` (`uploaded_by`),
  ADD KEY `materials_category_id_foreign` (`category_id`),
  ADD KEY `materials_activity_date_index` (`activity_date`),
  ADD KEY `materials_activity_date_start_activity_date_end_index` (`activity_date_start`,`activity_date_end`);

--
-- Indexes for table `material_files`
--
ALTER TABLE `material_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_files_material_id_foreign` (`material_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`),
  ADD KEY `news_author_id_foreign` (`author_id`),
  ADD KEY `news_status_published_at_index` (`status`,`published_at`),
  ADD KEY `news_category_id_status_index` (`category_id`,`status`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_permission_role_id_permission_id_unique` (`role_id`,`permission_id`),
  ADD KEY `role_permission_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `material_files`
--
ALTER TABLE `material_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `materials_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `material_files`
--
ALTER TABLE `material_files`
  ADD CONSTRAINT `material_files_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
