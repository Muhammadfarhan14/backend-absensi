-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 04, 2024 at 12:41 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `backend-absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `datangs`
--

CREATE TABLE `datangs` (
  `id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date NOT NULL DEFAULT '2023-11-05',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `datangs`
--

INSERT INTO `datangs` (`id`, `mahasiswa_id`, `keterangan`, `gambar`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 1, 'hadir', 'http://127.0.0.1:1000/images/syahrul-datang-20231224205558.jpg', '2023-11-21', '2023-11-21 15:29:16', '2023-12-24 12:55:58'),
(2, 3, 'hadir', NULL, '2023-11-21', '2023-11-26 15:37:19', '2023-11-26 15:37:19'),
(6, 3, 'hadir', NULL, '2023-11-22', '2023-11-26 15:37:19', '2023-11-26 15:37:19');

-- --------------------------------------------------------

--
-- Table structure for table `dosen_pembimbing`
--

CREATE TABLE `dosen_pembimbing` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pdf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dosen_pembimbing`
--

INSERT INTO `dosen_pembimbing` (`id`, `user_id`, `nama`, `gambar`, `pdf`, `created_at`, `updated_at`) VALUES
(1, 3, 'Irma Suriani S', 'http://127.0.0.1:2000/images/irma-suriani-s-20231114111539.png', 'http://127.0.0.1:1000/pdf/tabel_kegiatan_ppl_dosen_irma_suriani_s.pdf', '2023-11-14 03:15:39', '2023-12-16 15:27:25');

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
-- Table structure for table `kegiatans`
--

CREATE TABLE `kegiatans` (
  `id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED DEFAULT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `tanggal` date NOT NULL DEFAULT '2023-11-05',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kegiatans`
--

INSERT INTO `kegiatans` (`id`, `mahasiswa_id`, `gambar`, `deskripsi`, `jam_mulai`, `jam_selesai`, `tanggal`, `created_at`, `updated_at`) VALUES
(2, 1, 'http://127.0.0.1:2000/images/kegiatan-20231122004307.png', 'kirim hewan', '08:00:00', '09:00:00', '2023-11-22', '2023-11-21 16:43:07', '2023-11-21 16:43:07'),
(3, 1, 'http://127.0.0.1:2000/images/kegiatan-20231126185618.png', 'kirim hewan', '08:00:00', '09:00:00', '2023-11-26', '2023-11-26 10:56:18', '2023-11-26 10:56:18'),
(4, 1, 'http://127.0.0.1:2000/images/kegiatan-20231126185635.png', 'kirim hewan', '08:00:00', '09:00:00', '2023-11-26', '2023-11-26 10:56:35', '2023-11-26 10:56:35'),
(5, 3, 'http://127.0.0.1:2000/images/kegiatan-20231126221959.png', 'pesan hewan', '09:00:00', '10:00:00', '2023-11-26', '2023-11-26 14:19:59', '2023-11-26 14:19:59'),
(6, 3, 'http://127.0.0.1:2000/images/kegiatan-20231126221959.png', 'kirim hewan', '08:00:00', '09:00:00', '2023-11-27', '2023-11-26 14:19:59', '2023-11-26 14:19:59');

-- --------------------------------------------------------

--
-- Table structure for table `kendalas`
--

CREATE TABLE `kendalas` (
  `id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED DEFAULT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `tanggal` date NOT NULL DEFAULT '2023-11-05',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kendalas`
--

INSERT INTO `kendalas` (`id`, `mahasiswa_id`, `deskripsi`, `status`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 1, 'minum', 1, '2023-12-17', '2023-11-21 16:00:59', '2023-12-17 07:53:31'),
(2, 3, 'minum', 1, '2023-12-17', '2023-12-17 05:58:54', '2023-12-17 05:58:54');

-- --------------------------------------------------------

--
-- Table structure for table `komens`
--

CREATE TABLE `komens` (
  `id` bigint UNSIGNED NOT NULL,
  `kendala_id` bigint UNSIGNED DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `komens`
--

INSERT INTO `komens` (`id`, `kendala_id`, `author`, `deskripsi`, `tanggal`, `created_at`, `updated_at`) VALUES
(2, 1, NULL, 'saya sudah minum', '2023-11-22', '2023-11-21 16:09:44', '2023-11-21 16:09:44'),
(3, 1, NULL, 'saya sudah minum', NULL, '2023-11-21 16:42:43', '2023-11-21 16:42:43'),
(4, 2, NULL, 'aman', NULL, '2023-11-21 16:42:54', '2023-11-21 16:42:54'),
(5, 2, NULL, 'tidur', NULL, '2023-11-21 16:42:54', '2023-11-21 16:42:54'),
(6, 1, NULL, 'minum', '2023-12-17', '2023-12-17 14:40:58', '2023-12-17 14:40:58');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria_penilaian`
--

CREATE TABLE `kriteria_penilaian` (
  `id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED DEFAULT NULL,
  `inovasi` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kerja_sama` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disiplin` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inisiatif` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kerajinan` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sikap` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kriteria_penilaian`
--

INSERT INTO `kriteria_penilaian` (`id`, `mahasiswa_id`, `inovasi`, `kerja_sama`, `disiplin`, `inisiatif`, `kerajinan`, `sikap`, `created_at`, `updated_at`) VALUES
(1, 1, '3', '2', '4', '1', '3', '2', '2023-11-26 11:02:25', '2023-11-26 11:02:25'),
(2, 3, '3', '2', '4', '1', '3', '2', '2023-11-26 15:39:33', '2023-11-26 15:39:33');

-- --------------------------------------------------------

--
-- Table structure for table `lokasis`
--

CREATE TABLE `lokasis` (
  `id` bigint UNSIGNED NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lokasis`
--

INSERT INTO `lokasis` (`id`, `gambar`, `nama`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'http://127.0.0.1:2000/images/bps-gowa-20231114111559.png', 'BPS Gowa', 'Samata', '2023-11-14 03:15:59', '2023-11-14 03:15:59');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswas`
--

CREATE TABLE `mahasiswas` (
  `id` bigint UNSIGNED NOT NULL,
  `id_PPL` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `lokasi_id` bigint UNSIGNED DEFAULT NULL,
  `pembimbing_lapangan_id` bigint UNSIGNED DEFAULT NULL,
  `dosen_pembimbing_id` bigint UNSIGNED DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pdf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `keterangan` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mahasiswas`
--

INSERT INTO `mahasiswas` (`id`, `id_PPL`, `user_id`, `lokasi_id`, `pembimbing_lapangan_id`, `dosen_pembimbing_id`, `nama`, `nim`, `gambar`, `pdf`, `created_at`, `updated_at`, `keterangan`) VALUES
(1, '97547', 4, 1, 2, 1, 'Syahrul', '60900120042', 'http://127.0.0.1:2000/images/syahrul-20231114111626.png', 'http://127.0.0.1:1000/pdf/tabel_kegiatan_ppl_syahrul.pdf', '2023-11-14 03:16:26', '2023-12-16 15:29:23', 1),
(3, '82571', 7, 1, 2, 1, 'Muh Rafli Datu Adam', '60900120011', 'http://127.0.0.1:2000/images/muh-rafli-datu-adam-20231126221914.png', 'http://127.0.0.1:2000/pdf/tabel_kegiatan_ppl_muh_rafli_datu_adam.pdf', '2023-11-26 14:19:14', '2023-11-26 15:40:20', 1);

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
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_04_28_063640_create_mahasiswas_table', 1),
(6, '2023_05_01_071107_create_pulangs_table', 1),
(7, '2023_05_01_071120_create_datangs_table', 1),
(8, '2023_05_01_071134_create_kegiatans_table', 1),
(9, '2023_05_01_071145_create_kendalas_table', 1),
(10, '2023_05_01_103025_create_lokasis_table', 1),
(11, '2023_05_04_065048_create_dosen_pembimbing_table', 1),
(12, '2023_05_04_065236_create_pembimbing_lapangan_table', 1),
(13, '2023_05_13_064406_add_foreign_key_lokasi_id_to_mahasiswa', 1),
(14, '2023_05_13_070331_add_delete_to_mahasiswa', 1),
(15, '2023_05_13_070855_add_foreign_key_to_mahasiswa', 1),
(16, '2023_05_13_071706_add_delete_to_mahasiswa', 1),
(17, '2023_05_15_104245_add_nama_to_users', 1),
(18, '2023_05_17_123550_add_status_to_kendala', 1),
(19, '2023_05_17_130808_add_jam_mulai_dan_jam_selesai_to_kegiatan', 1),
(20, '2023_05_28_061055_create_kriteria_penilaian_table', 1),
(21, '2023_06_02_115733_create_date_to_datang_table', 1),
(22, '2023_06_02_123714_create_tanggal_to_pulang_table', 1),
(23, '2023_06_02_132814_create_tanggal_to_kendala_table', 1),
(24, '2023_06_02_134235_create_tanggal_to_kegiatan_table', 1),
(25, '2023_06_02_162339_create_hari_pertama_to_datang_table', 1),
(26, '2023_06_05_192602_add_hari_pertama_to_pulang', 1),
(27, '2023_06_12_140945_add_pdf_to_mahasiswa', 1),
(28, '2023_06_25_143026_add_pdf_to_dosen_pembimbing_table', 1),
(29, '2023_11_14_112952_add_delete_gambar_dan_hari_pertama_to_datang', 2),
(30, '2023_11_14_124148_add_delete_gambar_dan_hari_pertama_to_pulang', 2),
(31, '2023_11_14_134328_add_delete_gambar_dan_hari_pertama_to_kegiatan', 2),
(32, '2023_11_17_133019_create_komens_table', 2),
(33, '2023_11_18_215506_add_keterangan_to_mahasiswa', 2),
(34, '2023_11_26_145249_add_keterangan_to_pembimbing_lapangan', 3),
(35, '2023_11_26_232827_add_gambar_to_pulangs', 4),
(36, '2024_02_17_224724_add_tanggal_to_personal_access_tokens', 5);

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
-- Table structure for table `pembimbing_lapangan`
--

CREATE TABLE `pembimbing_lapangan` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `keterangan` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembimbing_lapangan`
--

INSERT INTO `pembimbing_lapangan` (`id`, `user_id`, `nama`, `created_at`, `updated_at`, `keterangan`) VALUES
(2, 2, 'Muiz Muharram', '2023-11-14 03:15:21', '2023-11-26 07:46:36', 1),
(3, 6, 'Fajratul', '2023-11-26 07:26:24', '2023-11-26 07:46:36', 1);

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
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `tanggal`, `created_at`, `updated_at`) VALUES
(32, 'App\\Models\\User', 1, 'admin', 'e8a467595f4feeb4a2934ad279d33c40d3a81077d021fa2660e3a50e4dd86e3d', '[\"*\"]', NULL, NULL, NULL, '2024-02-17 14:57:58', '2024-02-17 14:57:58');

-- --------------------------------------------------------

--
-- Table structure for table `pulangs`
--

CREATE TABLE `pulangs` (
  `id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date NOT NULL DEFAULT '2023-11-05',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pulangs`
--

INSERT INTO `pulangs` (`id`, `mahasiswa_id`, `keterangan`, `gambar`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 1, 'hadir', NULL, '2023-11-25', '2023-11-26 11:08:27', '2023-11-26 11:08:27'),
(2, 1, 'hadir', NULL, '2023-11-26', '2023-11-26 11:09:34', '2023-11-26 11:09:34'),
(3, 3, NULL, NULL, '2023-11-26', '2023-11-26 14:20:11', '2023-11-26 14:20:11'),
(4, 3, 'hadir', 'http://127.0.0.1:2000/images/muh-rafli-datu-adam-pulang-20231126233345.png', '2023-11-27', '2023-11-26 15:33:45', '2023-11-26 15:33:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `roles`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$nLSvPHc9gaE6eHtyJ1nzP.Xgh3TsUR.XQE7uF3dbdTQkD2MKcgBnG', 'Ahmad Ilham', 'super_admin', NULL, '2023-11-05 07:06:27', '2023-11-05 07:06:27'),
(2, 'muis021', '$2y$10$uqYfcuq7PIB2y5HoJBDD4Ov6V1PCl9ec0oalpEUf19D9yOvlL9W/u', 'Muiz Muharram', 'pembimbing_lapangan', NULL, '2023-11-14 03:15:21', '2023-11-14 03:15:21'),
(3, 'irma', '$2y$10$amaNJuENZy6xNpOvsarSfeeOZbeYRIeJkPs/tao1StRqLMrCbo5z.', 'Irma Suriani S', 'dosen_pembimbing', NULL, '2023-11-14 03:15:39', '2023-11-14 03:15:39'),
(4, '60900120042', '$2y$10$kiPeYyzKy.GQnNkjVP5HAOPQAZCvVFBMjsAZFBAK43Tr3tZKETwbG', 'Syahrul', 'mahasiswa', NULL, '2023-11-14 03:16:26', '2023-11-14 03:16:26'),
(5, '60900120020', '$2y$10$c1QJTCL2VBPPFBurWK.WueWKY8NLtZTA.D6Sa0wOTP4jMjM7YNLH2', 'tes', 'mahasiswa', NULL, '2023-11-26 04:24:48', '2023-11-26 04:24:48'),
(6, 'fajar', '$2y$10$ylHPNtwZ54I7n/vdIYps6OzWZy1U6YmtPC6u/fMQLwdX30cwU6tgG', 'Fajratul', 'pembimbing_lapangan', NULL, '2023-11-26 07:26:24', '2023-11-26 07:26:24'),
(7, '60900120011', '$2y$10$gIE2H8EomGMEO8xHjemIdOOg1zeVDDX0TKubfOreptoZhhuckD5Em', 'Muh Rafli Datu Adam', 'mahasiswa', NULL, '2023-11-26 14:19:14', '2023-11-26 14:19:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `datangs`
--
ALTER TABLE `datangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `datangs_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indexes for table `dosen_pembimbing`
--
ALTER TABLE `dosen_pembimbing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dosen_pembimbing_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kegiatans`
--
ALTER TABLE `kegiatans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kegiatans_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indexes for table `kendalas`
--
ALTER TABLE `kendalas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kendalas_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indexes for table `komens`
--
ALTER TABLE `komens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `komens_kendala_id_foreign` (`kendala_id`);

--
-- Indexes for table `kriteria_penilaian`
--
ALTER TABLE `kriteria_penilaian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kriteria_penilaian_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indexes for table `lokasis`
--
ALTER TABLE `lokasis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mahasiswas_user_id_foreign` (`user_id`),
  ADD KEY `mahasiswas_lokasi_id_foreign` (`lokasi_id`),
  ADD KEY `mahasiswas_pembimbing_lapangan_id_foreign` (`pembimbing_lapangan_id`),
  ADD KEY `mahasiswas_dosen_pembimbing_id_foreign` (`dosen_pembimbing_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembimbing_lapangan`
--
ALTER TABLE `pembimbing_lapangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembimbing_lapangan_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pulangs`
--
ALTER TABLE `pulangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pulangs_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `datangs`
--
ALTER TABLE `datangs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dosen_pembimbing`
--
ALTER TABLE `dosen_pembimbing`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kegiatans`
--
ALTER TABLE `kegiatans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kendalas`
--
ALTER TABLE `kendalas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `komens`
--
ALTER TABLE `komens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kriteria_penilaian`
--
ALTER TABLE `kriteria_penilaian`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lokasis`
--
ALTER TABLE `lokasis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mahasiswas`
--
ALTER TABLE `mahasiswas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `pembimbing_lapangan`
--
ALTER TABLE `pembimbing_lapangan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `pulangs`
--
ALTER TABLE `pulangs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `datangs`
--
ALTER TABLE `datangs`
  ADD CONSTRAINT `datangs_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dosen_pembimbing`
--
ALTER TABLE `dosen_pembimbing`
  ADD CONSTRAINT `dosen_pembimbing_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kegiatans`
--
ALTER TABLE `kegiatans`
  ADD CONSTRAINT `kegiatans_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kendalas`
--
ALTER TABLE `kendalas`
  ADD CONSTRAINT `kendalas_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `komens`
--
ALTER TABLE `komens`
  ADD CONSTRAINT `komens_kendala_id_foreign` FOREIGN KEY (`kendala_id`) REFERENCES `kendalas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kriteria_penilaian`
--
ALTER TABLE `kriteria_penilaian`
  ADD CONSTRAINT `kriteria_penilaian_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD CONSTRAINT `mahasiswas_dosen_pembimbing_id_foreign` FOREIGN KEY (`dosen_pembimbing_id`) REFERENCES `dosen_pembimbing` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mahasiswas_lokasi_id_foreign` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mahasiswas_pembimbing_lapangan_id_foreign` FOREIGN KEY (`pembimbing_lapangan_id`) REFERENCES `pembimbing_lapangan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mahasiswas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembimbing_lapangan`
--
ALTER TABLE `pembimbing_lapangan`
  ADD CONSTRAINT `pembimbing_lapangan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pulangs`
--
ALTER TABLE `pulangs`
  ADD CONSTRAINT `pulangs_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
