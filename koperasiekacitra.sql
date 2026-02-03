-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Jan 2026 pada 17.59
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koperasiekacitra`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` char(36) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_slug` varchar(110) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_slug`, `created_at`, `updated_at`) VALUES
('1cee8226-f834-11f0-b74b-68f728f3cb26', 'Iuran Bulanan', 'eka-citra', '2026-01-23 08:18:09', '2026-01-23 10:22:58'),
('b1d5261d-c3e0-47ec-aa78-10ab1d45fdce', 'Keuangan Perpajakan', 'keuangan-perpajakan', '2026-01-23 10:23:50', '2026-01-23 10:25:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `email_logs`
--

CREATE TABLE `email_logs` (
  `id` char(36) NOT NULL,
  `recipient` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `status` enum('success','failed') DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `email_logs`
--

INSERT INTO `email_logs` (`id`, `recipient`, `subject`, `status`, `error_message`, `created_at`) VALUES
('0b42863b-7de0-49e6-b3f7-f85051d722cd', 'mulyonomuiz63@gmail.com', 'Pemberitahuan Penolakan Pembayaran', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Fri, 30 Jan 2026 16:39:08 +0000\r\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\r\nReturn-Path: &lt;noreply@gmail.com&gt;\r\nTo: mulyonomuiz63@gmail.com\r\nSubject: =?UTF-8?Q?Pemberitahuan=20Penolakan=20Pembayaran?=\r\nReply-To: &lt;noreply@gmail.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@gmail.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;697cdeacc7e5b7.07960467@gmail.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-30 23:39:08'),
('1b7ea4dc-f51b-432f-99be-5c6a658a1cbe', 'ketua@gmail.com', 'Invoice Pembayaran: INV/2026/01/00004', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Sat, 31 Jan 2026 15:57:26 +0000\r\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\r\nReturn-Path: &lt;noreply@gmail.com&gt;\r\nTo: ketua@gmail.com\r\nSubject: =?UTF-8?Q?Invoice=20Pembayaran:=20INV/2026/01/00004?=\r\nReply-To: &lt;noreply@gmail.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@gmail.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;697e2666f36fb1.31357681@gmail.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-31 22:57:27'),
('1e954475-1735-400e-8e4b-60c4fab305c6', 'mulyonomuiz63@gmail.com', 'Selamat! Pendaftaran & Pembayaran Anda Disetujui', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Sat, 31 Jan 2026 09:13:41 +0000\r\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\r\nReturn-Path: &lt;noreply@gmail.com&gt;\r\nTo: mulyonomuiz63@gmail.com\r\nSubject: =?UTF-8?Q?Selamat!=20Pendaftaran=20&amp;=20Pembayaran=20Anda=20Disetujui?=\r\nReply-To: &lt;noreply@gmail.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@gmail.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;697dc7c571f6e5.18248920@gmail.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-31 16:13:41'),
('3b041650-7960-480f-a7c0-4eb00e4d2a90', 'mulyonomuiz63@gmail.com', 'Invoice Pembayaran: INV/2026/01/00003', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Sat, 31 Jan 2026 09:39:17 +0000\r\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\r\nReturn-Path: &lt;noreply@gmail.com&gt;\r\nTo: mulyonomuiz63@gmail.com\r\nSubject: =?UTF-8?Q?Invoice=20Pembayaran:=20INV/2026/01/00003?=\r\nReply-To: &lt;noreply@gmail.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@gmail.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;697dcdc5502630.95568232@gmail.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-31 16:39:17'),
('5cf3552a-b3a2-466c-ac6e-b70e4d3c5e3b', 'mulyonomuiz63@gmail.com', 'Verifikasi Akun Koperasi Eka Citra Mandiri', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Fri, 30 Jan 2026 15:44:37 +0000\r\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\r\nReturn-Path: &lt;noreply@gmail.com&gt;\r\nTo: mulyonomuiz63@gmail.com\r\nSubject: =?UTF-8?Q?Verifikasi=20Akun=20Koperasi=20Eka=20Citra=20Mandiri?=\r\nReply-To: &lt;noreply@gmail.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@gmail.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;697cd1e56ea009.52331159@gmail.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-30 22:44:37'),
('7e86d881-0ade-4283-af95-536e9fc9b9e2', 'mulyonomuiz63@gmail.com', 'Pemberitahuan: Pembayaran Pendaftaran Ditolak', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Fri, 30 Jan 2026 15:51:47 +0000\r\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\r\nReturn-Path: &lt;noreply@gmail.com&gt;\r\nTo: mulyonomuiz63@gmail.com\r\nSubject: =?UTF-8?Q?Pemberitahuan:=20Pembayaran=20Pendaftaran=20Ditolak?=\r\nReply-To: &lt;noreply@gmail.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@gmail.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;697cd393e5ff09.93933762@gmail.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-30 22:51:47'),
('b571ee58-d96c-4d79-bacd-902bcc87dfa6', 'mulyonomuiz63@gmail.com', 'Invoice Pembayaran: INV/2026/01/00002', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Sat, 31 Jan 2026 09:23:02 +0000\r\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\r\nReturn-Path: &lt;noreply@gmail.com&gt;\r\nTo: mulyonomuiz63@gmail.com\r\nSubject: =?UTF-8?Q?Invoice=20Pembayaran:=20INV/2026/01/00002?=\r\nReply-To: &lt;noreply@gmail.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@gmail.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;697dc9f6a5b689.99341046@gmail.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-31 16:23:02'),
('ce272698-9105-4750-bddf-36c96182cc9d', 'mulyonomuiz63@gmail.com', 'Selamat! Pendaftaran & Pembayaran Anda Disetujui', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Fri, 30 Jan 2026 15:54:53 +0000\r\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\r\nReturn-Path: &lt;noreply@gmail.com&gt;\r\nTo: mulyonomuiz63@gmail.com\r\nSubject: =?UTF-8?Q?Selamat!=20Pendaftaran=20&amp;=20Pembayaran=20Anda=20Disetujui?=\r\nReply-To: &lt;noreply@gmail.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@gmail.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;697cd44d3f9dc7.26868425@gmail.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-30 22:54:53'),
('ece12c56-4ed8-4493-adae-a242eeae3077', 'mulyonomuiz63@gmail.com', 'Invoice Pembayaran: INV/2026/01/00001', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Fri, 30 Jan 2026 16:40:40 +0000\r\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\r\nReturn-Path: &lt;noreply@gmail.com&gt;\r\nTo: mulyonomuiz63@gmail.com\r\nSubject: =?UTF-8?Q?Invoice=20Pembayaran:=20INV/2026/01/00001?=\r\nReply-To: &lt;noreply@gmail.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@gmail.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;697cdf086300b9.78767440@gmail.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-30 23:40:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `faq`
--

CREATE TABLE `faq` (
  `id` char(36) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=aktif, 0=nonaktif',
  `sort_order` int(11) NOT NULL DEFAULT 0 COMMENT 'Urutan tampil FAQ',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri`
--

CREATE TABLE `galeri` (
  `id` char(36) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `jenis_galeri` varchar(50) NOT NULL DEFAULT 'atas',
  `status` enum('A','T') NOT NULL DEFAULT 'A' COMMENT 'A=>aktif,\r\nT=> Tidak Aktif',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `iuran_bulanan`
--

CREATE TABLE `iuran_bulanan` (
  `id` char(36) NOT NULL,
  `pegawai_id` char(36) NOT NULL,
  `bulan` tinyint(4) NOT NULL,
  `tahun` smallint(6) NOT NULL,
  `jumlah_iuran` decimal(12,0) NOT NULL DEFAULT 0,
  `tgl_tagihan` date NOT NULL,
  `status` enum('S','B','P','V') NOT NULL DEFAULT 'B' COMMENT 'S => Lunas,\r\nB => Belum Lunas,\r\nP => PENDING,\r\nV => menunggu approve admin',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `iuran_bulanan`
--

INSERT INTO `iuran_bulanan` (`id`, `pegawai_id`, `bulan`, `tahun`, `jumlah_iuran`, `tgl_tagihan`, `status`, `created_at`, `updated_at`) VALUES
('7805711e-9cba-4461-a2ee-d5fd18c8b701', '31c56167-ade8-4d89-acdb-a27020be42d1', 1, 2026, 50000, '2026-01-31', 'S', '2026-01-31 16:11:08', '2026-01-31 22:57:26'),
('a234d203-2ea7-4430-a7bd-85d4b6db6c50', 'ed78d26d-ee09-4d6e-8c9d-e2565e2db69d', 1, 2026, 50000, '2026-01-31', 'S', '2026-01-31 16:19:52', '2026-01-31 16:23:02'),
('a234d203-2ea7-4430-a7bd-85d4b6db6c53', 'ed78d26d-ee09-4d6e-8c9d-e2565e2db69d', 12, 2025, 50000, '2025-12-31', 'S', '2026-01-31 16:19:52', '2026-01-31 16:39:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `iuran_generate_log`
--

CREATE TABLE `iuran_generate_log` (
  `id` char(36) NOT NULL,
  `bulan` tinyint(4) DEFAULT NULL,
  `tahun` smallint(6) DEFAULT NULL,
  `total_pegawai` int(11) DEFAULT NULL,
  `nominal` decimal(12,2) DEFAULT NULL,
  `dijalankan_pada` datetime DEFAULT NULL,
  `status` enum('SUCCESS','FAILED') DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `iuran_generate_log`
--

INSERT INTO `iuran_generate_log` (`id`, `bulan`, `tahun`, `total_pegawai`, `nominal`, `dijalankan_pada`, `status`, `keterangan`) VALUES
('fc43d183-74c0-4900-bb4d-c134d60b94c7', 1, 2026, 1, 50000.00, '2026-01-31 09:19:52', 'SUCCESS', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id` char(36) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `jabatan_key` varchar(20) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`, `jabatan_key`, `keterangan`, `created_at`, `updated_at`) VALUES
('14dd0ae1-9d23-4c9a-970b-0b3a0ccfb68f', 'SEKERTARIS', 'ADMIN', 'Sekertaris koperasi', '2026-01-30 22:19:48', NULL),
('34393209-acb2-4b6b-a6be-d3977adf651c', 'KETUA', 'ADMIN', 'Ketua koperasi', '2026-01-31 14:48:27', '2026-01-31 14:49:06'),
('7db0a8d9-0bdc-48e1-be71-08b05fee44f0', 'ANGGOTA', 'ANGGOTA', 'Anggota koperasi', '2026-01-30 22:20:19', NULL),
('fb4c7fa8-725b-4704-860f-2f2bf6c6fdc1', 'BENDAHARA', 'ADMIN', 'Bendahara koperasi', '2026-01-30 22:19:24', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` char(36) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `attempts` int(11) NOT NULL DEFAULT 1,
  `last_attempt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menus`
--

CREATE TABLE `menus` (
  `id` char(36) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `url` varchar(150) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `menu_order` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menus`
--

INSERT INTO `menus` (`id`, `name`, `slug`, `url`, `icon`, `parent_id`, `menu_order`, `is_active`, `created_at`, `updated_at`) VALUES
('08520e54-27a3-4b24-a370-c6148ad1025b', 'Master Data', 'master-data', '#', 'ki-duotone ki-book-open fs-2', NULL, 2, 1, '2026-01-30 22:00:27', '2026-01-31 15:51:12'),
('0b1728d9-fc0f-4917-89d5-e2e9f5caaaed', 'Laporan', 'laporan', '/laporan', 'ki-duotone ki-chart-line-star fs-2', '6fb528c4-4014-48ed-ad6b-23532d7d74dc', 3, 1, '2026-01-30 22:04:46', '2026-01-31 15:59:22'),
('45d86c6e-852f-4b98-9a10-ce3752fe4d32', 'Menus', 'menus', '/menus', 'ki-duotone ki-burger-menu fs-2', 'ad1e981f-2503-447e-8ee6-62b08538cc57', 1, 1, '2026-01-30 16:58:54', '2026-01-31 15:44:39'),
('468b0d9c-9329-4bfe-aa06-9215b897195d', 'Pembayaran', 'pembayaran', '/pembayaran', 'ki-duotone ki-credit-cart fs-2', '6fb528c4-4014-48ed-ad6b-23532d7d74dc', 1, 1, '2026-01-30 22:04:00', '2026-01-31 15:58:06'),
('484b70d6-91da-4c3a-bc62-4cb4c43d7048', 'Settings', 'settings', '/settings', 'ki-duotone ki-setting-2 fs-2', NULL, 7, 1, '2026-01-30 22:08:01', '2026-01-31 15:41:49'),
('54856bf1-42b8-4e64-9d2c-fa53d9f50efe', ' Pegawai', 'pegawai', '/pegawai', 'ki-duotone ki-address-book fs-2', '08520e54-27a3-4b24-a370-c6148ad1025b', 2, 1, '2026-01-30 22:01:16', '2026-01-31 15:54:36'),
('557135d1-49b1-4917-8b77-8d75e5e0d7a9', 'Jabatan', 'jabatan', '/jabatan', 'ki-duotone ki-medal-star fs-2', '08520e54-27a3-4b24-a370-c6148ad1025b', 3, 1, '2026-01-30 22:01:43', '2026-01-31 15:55:07'),
('56430441-9789-4ab8-b884-c0b1747804f0', 'News', 'news', '/news', 'ki-duotone ki-book fs-2', '9c6cdd4c-a2f9-427e-aa94-b3804e8c55cf', 2, 1, '2026-01-30 22:06:07', '2026-01-31 16:02:58'),
('6356b71f-2231-4a33-abc7-940987158e02', 'Faq', 'faq', '/faq', 'ki-duotone ki-message-question fs-2', '08520e54-27a3-4b24-a370-c6148ad1025b', 5, 1, '2026-01-30 22:02:28', '2026-01-31 15:55:57'),
('68378c24-2093-4a36-b55e-d756c6b4b624', 'Category', 'category', '/category', 'ki-duotone ki-category fs-2', '9c6cdd4c-a2f9-427e-aa94-b3804e8c55cf', 1, 1, '2026-01-30 22:05:49', '2026-01-31 15:59:58'),
('6fb528c4-4014-48ed-ad6b-23532d7d74dc', 'Keaungan', 'keaungan', '/keuangan', 'ki-duotone ki-wallet fs-2', NULL, 3, 1, '2026-01-30 22:03:31', '2026-01-31 15:49:12'),
('72c97d31-984f-4b64-bf87-3ea4234c8277', 'Galeri', 'galeri', '/galeri', 'ki-duotone ki-picture fs-2', '08520e54-27a3-4b24-a370-c6148ad1025b', 4, 1, '2026-01-30 22:02:08', '2026-01-31 15:55:30'),
('75eabb9e-c0dd-4753-9d5a-0603f5685a3e', 'Roles', 'roles', '/roles', 'ki-duotone ki-shield-search fs-2', 'ad1e981f-2503-447e-8ee6-62b08538cc57', 2, 1, '2026-01-30 21:52:24', '2026-01-31 15:46:09'),
('88d0ff51-0201-4832-b380-e8fb1cdc3e0c', 'Iuran Bulanan', 'iuran-bulanan', '/iuran-bulanan', 'ki-duotone ki-calendar-tick fs-2', '6fb528c4-4014-48ed-ad6b-23532d7d74dc', 2, 1, '2026-01-30 22:04:25', '2026-01-31 15:58:33'),
('9c6cdd4c-a2f9-427e-aa94-b3804e8c55cf', 'Blog & News', 'blog-news', '#', 'ki-duotone ki-notepad fs-2', NULL, 4, 1, '2026-01-30 22:05:22', '2026-01-31 15:52:14'),
('a120a4ae-4931-42d8-876c-606b3e0e0016', 'Histori', 'histori-iuran', '/sw-anggota/histori-iuran', 'ki-duotone ki-watch fs-2', NULL, 6, 1, '2026-01-30 22:07:37', '2026-01-31 16:01:43'),
('ad1e981f-2503-447e-8ee6-62b08538cc57', 'User Management', 'user-management', '#', 'ki-duotone ki-profile-user fs-2', NULL, 1, 1, '2026-01-30 16:56:13', '2026-01-31 15:44:02'),
('af6d4f6d-e530-4133-a3d6-59ca15e0d16c', 'Users', 'users', '/users', 'ki-duotone ki-people fs-2', 'ad1e981f-2503-447e-8ee6-62b08538cc57', 3, 1, '2026-01-30 21:59:38', '2026-01-31 15:47:00'),
('af8ac9be-422f-4bce-a757-a276c7dbb847', 'Iuran', 'iuran', '/sw-anggota/iuran', 'ki-duotone ki-bill fs-2', NULL, 5, 1, '2026-01-30 22:07:08', '2026-01-31 15:52:42'),
('cd3272b1-c35e-4583-8a34-49bdc1e2fc87', 'Slider', 'slider', '/slider', 'ki-duotone ki-slider-vertical fs-2', '08520e54-27a3-4b24-a370-c6148ad1025b', 6, 1, '2026-01-30 22:02:58', '2026-01-31 15:56:29'),
('e33a1f3b-58cd-43b8-8ea0-6747f8247ee4', 'Perusahaan', 'perusahaan', '/perusahaan', 'ki-duotone ki-shop fs-2', '08520e54-27a3-4b24-a370-c6148ad1025b', 1, 1, '2026-01-30 22:00:53', '2026-01-31 15:54:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-01-15-032829', 'App\\Database\\Migrations\\CreateRoles', 'default', 'App', 1768448138, 1),
(2, '2026-01-15-032830', 'App\\Database\\Migrations\\CreateUsers', 'default', 'App', 1768448138, 1),
(3, '2026-01-15-032909', 'App\\Database\\Migrations\\CreateAnggota', 'default', 'App', 1768448138, 1),
(4, '2026-01-15-032929', 'App\\Database\\Migrations\\CreateMenus', 'default', 'App', 1768448138, 1),
(5, '2026-01-15-033156', 'App\\Database\\Migrations\\CreatePermissions', 'default', 'App', 1768448138, 1),
(8, '2026-01-15-033507', 'App\\Database\\Migrations\\CreatePasswordResets', 'default', 'App', 1768448138, 1),
(9, '2026-01-15-033401', 'App\\Database\\Migrations\\CreateUserPermissions', 'default', 'App', 1768459044, 2),
(10, '2026-01-15-033224', 'App\\Database\\Migrations\\CreateRolePermissions', 'default', 'App', 1768459671, 3),
(13, '2026-01-16-150653', 'App\\Database\\Migrations\\CreatePerusahaan', 'default', 'App', 1768577064, 4),
(14, '2026-01-16-150810', 'App\\Database\\Migrations\\CreateJabatan', 'default', 'App', 1768577064, 4),
(15, '2026-01-16-151419', 'App\\Database\\Migrations\\CreatePegawai', 'default', 'App', 1768577259, 5),
(16, '2026-01-17-000217', 'App\\Database\\Migrations\\CreateSetting', 'default', 'App', 1768608176, 6),
(17, '2026-01-17-072428', 'App\\Database\\Migrations\\CreateGaleri', 'default', 'App', 1768634702, 7),
(18, '2026-01-17-080156', 'App\\Database\\Migrations\\CreateFaq', 'default', 'App', 1768636947, 8),
(20, '2026-01-17-143027', 'App\\Database\\Migrations\\CreateLoginAttemptsTable', 'default', 'App', 1768660306, 9),
(21, '2026-01-18-101356', 'App\\Database\\Migrations\\CreatePembayaran', 'default', 'App', 1768731713, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `news`
--

CREATE TABLE `news` (
  `id` char(36) NOT NULL,
  `category_id` char(36) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `keyword` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT 'default.jpg',
  `author` varchar(100) DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `status` enum('publish','draft') DEFAULT 'publish',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `news`
--

INSERT INTO `news` (`id`, `category_id`, `title`, `slug`, `keyword`, `content`, `image`, `author`, `views`, `status`, `created_at`, `updated_at`) VALUES
('14496f02-f3e3-405f-a7d1-f9827d0dcc67', 'b1d5261d-c3e0-47ec-aa78-10ab1d45fdce', 'tes', 'tes-1', '', '<p>tes</p>', '1769164860_6c6b52090c2ebaf0c365.png', 'Admin', 7, 'publish', '2026-01-23 10:41:00', '2026-01-26 07:27:09'),
('14496f02-f3e3-405f-a7d1-f9827d0dcc68', 'b1d5261d-c3e0-47ec-aa78-10ab1d45fdce', 'tes', 'tes', '', '<p>tes</p>', '1769164860_6c6b52090c2ebaf0c365.png', 'Admin', 7, 'publish', '2026-01-23 10:41:00', '2026-01-26 07:27:09'),
('15d54546-8ec9-473c-b66e-4b48b9945508', '1cee8226-f834-11f0-b74b-68f728f3cb26', 'Koperasi Eka Citra Mandiri', 'koperasi-eka-citra-mandiri', '', '<p><strong class=\"Yjhzub\"><a class=\"GI370e\" href=\"https://www.google.com/search?q=Epsum+Labs+%28EpsumThings%29&amp;oq=ep&amp;gs_lcrp=EgZjaHJvbWUqBggBEEUYOzIGCAAQRRg5MgYIARBFGDsyBwgCEAAYjwIyBwgDEAAYjwIyBwgEEAAYjwIyBggFEEUYPDIGCAYQRRg8MgYIBxBFGDzSAQgyMDE1ajBqNKgCALACAQ&amp;sourceid=chrome&amp;ie=UTF-8&amp;ved=2ahUKEwjLi7SGnaGSAxUo1TgGHZi-BKkQgK4QegYIAQgAEAo\" data-ved=\"2ahUKEwjLi7SGnaGSAxUo1TgGHZi-BKkQgK4QegYIAQgAEAo\" data-hveid=\"CAEIABAK\">Epsum Labs (EpsumThings)</a></strong>: Sebuah platform IoT (Internet of Things) dan IIoT (Industrial Internet of Things) untuk otomatisasi, pemantauan, dan visualisasi proses, menawarkan solusi untuk manufaktur, logistik, dan lainnya d</p>', '1769160283_4c69f4866b13c294bb65.jpg', 'Admin', 12, 'publish', '2026-01-23 08:24:25', '2026-01-24 00:42:19'),
('c3776c39-ceec-4130-8a50-ff4d28d4e7d3', 'b1d5261d-c3e0-47ec-aa78-10ab1d45fdce', 'Perkuat Fondasi Ekonomi Bali, OJK dan BPS Perluas Jangkauan Survei Literasi Keuangan 2026', 'perkuat-fondasi-ekonomi-bali-ojk-dan-bps-perluas-jangkauan-survei-literasi-keuangan-2026', '', '<p>Denpasar&ndash; Dalam upaya membangun masyarakat yang cerdas secara finansial, Otoritas Jasa Keuangan (OJK) Provinsi Bali bersinergi dengan Badan Pusat Statistik (BPS) dan Lembaga Penjamin Simpanan (LPS) resmi memulai persiapan Survei Nasional Literasi dan Inklusi Keuangan (SNLIK) 2026.</p>\r\n<p>Berbeda dari tahun-tahun sebelumnya, tahun ini Bali melakukan lompatan besar. Jika sebelumnya survei hanya menyasar tiga kabupaten, kini SNLIK 2026 akan menjangkau seluruh kabupaten/kota di Provinsi Bali.</p>\r\n<p>Perluasan ini bertujuan untuk menghasilkan peta kekuatan ekonomi masyarakat yang jauh lebih akurat hingga ke pelosok daerah.<br><br><br></p>', '1769164491_953282b326efdb64580e.jpg', 'Admin', 29, 'publish', '2026-01-23 10:34:51', '2026-01-27 15:21:11'),
('c3776c39-ceec-4130-8a50-ff4d28d4e7d6', 'b1d5261d-c3e0-47ec-aa78-10ab1d45fdce', 'Perkuat Fondasi Ekonomi Bali, OJK dan BPS Perluas Jangkauan Survei Literasi Keuangan 2026', 'perkuat-fondasi-ekonomi-bali-ojk-dan-bps-perluas-jangkauan-survei-literasi-keuangan-2026-1', '', '<p>Denpasar&ndash; Dalam upaya membangun masyarakat yang cerdas secara finansial, Otoritas Jasa Keuangan (OJK) Provinsi Bali bersinergi dengan Badan Pusat Statistik (BPS) dan Lembaga Penjamin Simpanan (LPS) resmi memulai persiapan Survei Nasional Literasi dan Inklusi Keuangan (SNLIK) 2026.</p>\r\n<p>Berbeda dari tahun-tahun sebelumnya, tahun ini Bali melakukan lompatan besar. Jika sebelumnya survei hanya menyasar tiga kabupaten, kini SNLIK 2026 akan menjangkau seluruh kabupaten/kota di Provinsi Bali.</p>\r\n<p>Perluasan ini bertujuan untuk menghasilkan peta kekuatan ekonomi masyarakat yang jauh lebih akurat hingga ke pelosok daerah.<br><br><br></p>', '1769164491_953282b326efdb64580e.jpg', 'Admin', 29, 'publish', '2026-01-23 10:34:51', '2026-01-27 15:21:11'),
('c3776c39-ceec-4130-8a50-ff4d28d4e7d7', 'b1d5261d-c3e0-47ec-aa78-10ab1d45fdce', 'Perkuat Fondasi Ekonomi Bali, OJK dan BPS Perluas Jangkauan Survei Literasi Keuangan 2026', 'perkuat-fondasi-ekonomi-bali-ojk-dan-bps-perluas-jangkauan-survei-literasi-keuangan-2026-2', '', '<p>Denpasar&ndash; Dalam upaya membangun masyarakat yang cerdas secara finansial, Otoritas Jasa Keuangan (OJK) Provinsi Bali bersinergi dengan Badan Pusat Statistik (BPS) dan Lembaga Penjamin Simpanan (LPS) resmi memulai persiapan Survei Nasional Literasi dan Inklusi Keuangan (SNLIK) 2026.</p>\r\n<p>Berbeda dari tahun-tahun sebelumnya, tahun ini Bali melakukan lompatan besar. Jika sebelumnya survei hanya menyasar tiga kabupaten, kini SNLIK 2026 akan menjangkau seluruh kabupaten/kota di Provinsi Bali.</p>\r\n<p>Perluasan ini bertujuan untuk menghasilkan peta kekuatan ekonomi masyarakat yang jauh lebih akurat hingga ke pelosok daerah.<br><br><br></p>', '1769164491_953282b326efdb64580e.jpg', 'Admin', 29, 'publish', '2026-01-23 10:34:51', '2026-01-27 15:21:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `news_tags`
--

CREATE TABLE `news_tags` (
  `news_id` char(36) NOT NULL,
  `tag_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `news_tags`
--

INSERT INTO `news_tags` (`news_id`, `tag_id`) VALUES
('14496f02-f3e3-405f-a7d1-f9827d0dcc68', '307a0fb2-6d51-492c-91fc-93ab513f86f6'),
('14496f02-f3e3-405f-a7d1-f9827d0dcc68', '453f9830-f852-4324-b3cd-df05925078c7'),
('15d54546-8ec9-473c-b66e-4b48b9945508', '29096a69-aca5-4862-aa00-f8b208fdf69f'),
('15d54546-8ec9-473c-b66e-4b48b9945508', '307a0fb2-6d51-492c-91fc-93ab513f86f6'),
('15d54546-8ec9-473c-b66e-4b48b9945508', '453f9830-f852-4324-b3cd-df05925078c7'),
('c3776c39-ceec-4130-8a50-ff4d28d4e7d3', '1436f296-2de0-4b69-a9d7-0aae0b6df783'),
('c3776c39-ceec-4130-8a50-ff4d28d4e7d3', '307a0fb2-6d51-492c-91fc-93ab513f86f6'),
('c3776c39-ceec-4130-8a50-ff4d28d4e7d3', '453f9830-f852-4324-b3cd-df05925078c7'),
('c3776c39-ceec-4130-8a50-ff4d28d4e7d3', 'e85f6fbd-d45d-45dc-a816-9313628d68e0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expired_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `nik` int(20) DEFAULT NULL,
  `nama` varchar(150) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `tempat_lahir` varchar(150) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `perusahaan_id` char(36) NOT NULL,
  `jabatan_id` char(36) NOT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `status` enum('A','T','R') NOT NULL DEFAULT 'A' COMMENT '''A => aktif'',''T => nonaktif'',''R => resign''',
  `status_iuran` enum('A','T') NOT NULL DEFAULT 'T' COMMENT 'A => Aktif\r\nT => Tidak Aktif',
  `avatar` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id`, `user_id`, `nip`, `nik`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `tempat_lahir`, `alamat`, `no_hp`, `perusahaan_id`, `jabatan_id`, `tanggal_masuk`, `status`, `status_iuran`, `avatar`, `created_at`, `updated_at`) VALUES
('31c56167-ade8-4d89-acdb-a27020be42d1', 'c8c91e6e-991e-496c-a7ef-6ba18fda3513', '43535242', NULL, 'Ketua', 'L', '1997-08-06', '', 'Tumijaya RT 010 RW 003 Kecamatan Jayapura Kabupaten OKU Timur Provinsi Sumatera Selatan', '081532423436', '0a6f632e-5b06-4299-9a14-1045719f9e36', '34393209-acb2-4b6b-a6be-d3977adf651c', '2026-01-30', 'A', 'A', 'default.jpg', '2026-01-30 22:37:55', '2026-01-31 14:49:49'),
('ed78d26d-ee09-4d6e-8c9d-e2565e2db69d', '54aa2657-a745-449e-b54a-fab1d2ea8501', '202601301222', 2147483647, 'Mulyono', 'L', '1997-08-06', 'Sumberjo', 'Tumijaya kec jayapura kab OKU Timur', '081532423436', '0a6f632e-5b06-4299-9a14-1045719f9e36', '7db0a8d9-0bdc-48e1-be71-08b05fee44f0', '2026-01-30', 'A', 'A', 'default.jpg', '2026-01-30 22:44:37', '2026-01-31 16:13:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` char(36) NOT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `invoice_at` datetime DEFAULT NULL,
  `pegawai_id` char(36) DEFAULT NULL,
  `jenis_transaksi` varchar(30) NOT NULL COMMENT 'pendaftaran, bulanan, denda, lainnya',
  `bulan` tinyint(2) DEFAULT NULL COMMENT '1-12 khusus iuran',
  `tahun` smallint(4) DEFAULT NULL,
  `jumlah_bayar` decimal(12,0) NOT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `nama_pengirim` varchar(100) NOT NULL,
  `status` enum('P','V','A','R') NOT NULL DEFAULT 'P' COMMENT '''pending'',''verifikasi'',''approved'',''rejected''',
  `keterangan` text DEFAULT NULL,
  `catatan_verifikasi` text NOT NULL,
  `validated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `invoice_no`, `invoice_at`, `pegawai_id`, `jenis_transaksi`, `bulan`, `tahun`, `jumlah_bayar`, `bukti_bayar`, `tgl_bayar`, `nama_pengirim`, `status`, `keterangan`, `catatan_verifikasi`, `validated_at`, `created_at`, `updated_at`) VALUES
('1ff9f332-9116-4d99-bbe6-3c11eee93a17', 'INV/2026/01/00003', '2026-01-31 09:39:17', 'ed78d26d-ee09-4d6e-8c9d-e2565e2db69d', 'bulanan', 12, 2025, 50000, 'bukti_1ff9f332-9116-4d99-bbe6-3c11eee93a17_20260131093851.jpeg', '2026-01-31', 'Mulyono', 'A', NULL, '', '2026-01-31 09:39:17', '2026-01-31 16:38:06', '2026-01-31 16:39:17'),
('9850331a-e2a0-4933-ad18-5516ff34cf77', 'INV/2026/01/00004', '2026-01-31 15:57:26', '31c56167-ade8-4d89-acdb-a27020be42d1', 'bulanan', 1, 2026, 50000, 'bukti_9850331a-e2a0-4933-ad18-5516ff34cf77_20260131155340.jpeg', '2026-01-31', 'Mulyono', 'A', NULL, '', '2026-01-31 15:57:26', '2026-01-31 22:43:11', '2026-01-31 22:57:26'),
('bfb3bfa9-7655-4b42-bec2-8144f63986a8', 'INV/2026/01/00001', '2026-01-31 09:13:41', 'ed78d26d-ee09-4d6e-8c9d-e2565e2db69d', 'pendaftaran', 1, 2026, 250000, '1769850745_50893b2e29e5855ec41e.jpeg', '2026-01-31', '', 'A', NULL, '', '2026-01-31 09:23:02', '2026-01-31 16:12:25', '2026-01-31 16:42:59'),
('e43615fd-ff38-4c04-b80f-9a3b3bf80251', 'INV/2026/01/00002', '2026-01-31 09:23:02', 'ed78d26d-ee09-4d6e-8c9d-e2565e2db69d', 'bulanan', 1, 2026, 50000, 'bukti_e43615fd-ff38-4c04-b80f-9a3b3bf80251_20260131092145.jpeg', '2026-01-31', 'Mulyono', 'A', NULL, '', '2026-01-31 09:23:02', '2026-01-31 16:21:30', '2026-01-31 16:23:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran_detail`
--

CREATE TABLE `pembayaran_detail` (
  `id` char(36) NOT NULL,
  `pembayaran_id` char(36) NOT NULL,
  `iuran_id` char(36) NOT NULL,
  `jumlah_bayar` decimal(12,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran_detail`
--

INSERT INTO `pembayaran_detail` (`id`, `pembayaran_id`, `iuran_id`, `jumlah_bayar`) VALUES
('7897be53-5f5b-48bd-97f8-99740cf19668', '1ff9f332-9116-4d99-bbe6-3c11eee93a17', 'a234d203-2ea7-4430-a7bd-85d4b6db6c53', 50000),
('812f116e-4318-4977-8c82-46f55b652c3c', 'e43615fd-ff38-4c04-b80f-9a3b3bf80251', 'a234d203-2ea7-4430-a7bd-85d4b6db6c50', 50000),
('fcd595cc-910d-4f80-91fd-9f867c2cdf22', '9850331a-e2a0-4933-ad18-5516ff34cf77', '7805711e-9cba-4461-a2ee-d5fd18c8b701', 50000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` char(36) NOT NULL,
  `menu_id` char(36) NOT NULL,
  `can_view` tinyint(1) NOT NULL DEFAULT 0,
  `can_create` tinyint(1) NOT NULL DEFAULT 0,
  `can_update` tinyint(1) NOT NULL DEFAULT 0,
  `can_delete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id` char(36) NOT NULL,
  `nama_perusahaan` varchar(150) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `perusahaan_key` varchar(20) NOT NULL DEFAULT 'default',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perusahaan`
--

INSERT INTO `perusahaan` (`id`, `nama_perusahaan`, `alamat`, `telepon`, `email`, `perusahaan_key`, `created_at`, `updated_at`) VALUES
('0a6f632e-5b06-4299-9a14-1045719f9e36', 'Koperasi Eka Citra Mandiri', 'Koperasi eka citra ', '0812353533', 'koperasiekacitra@gmail.com', 'default', NULL, NULL),
('1', 'Pt Masyon Kusuma', 'Bandar Lampung', '081532423436', 'mulyonomuiz63@gmail.com', 'default', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` char(36) NOT NULL,
  `name` varchar(50) NOT NULL,
  `role_key` varchar(20) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `role_key`, `description`, `created_at`) VALUES
('2d440565-bda1-49cb-929c-42e1881c5beb', 'Sekretaris', 'ADMIN', 'Sekretaris koperasi', '2026-01-30 21:31:56'),
('815e11b7-d224-4614-8a69-d7fda9a1b707', 'Superadmin', 'ADMIN', 'Role yang dapat memberikan seluruh akses', '2026-01-30 21:28:33'),
('dc038392-4b5b-4f4c-83c7-c3677b54c9d9', 'Bendahara', 'ADMIN', 'Bendahara koperasi', '2026-01-30 21:32:30'),
('dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', 'Ketua', 'ADMIN', 'Ketua Koperasi', '2026-01-30 21:29:47'),
('fdd2255d-45b5-4b5d-939e-ce61c13fee57', 'Anggota', 'ANGGOTA', 'Anggota koperasi', '2026-01-30 21:32:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` char(36) NOT NULL,
  `role_id` char(36) NOT NULL,
  `menu_id` char(36) NOT NULL,
  `can_view` tinyint(4) NOT NULL DEFAULT 0,
  `can_create` tinyint(4) NOT NULL DEFAULT 0,
  `can_update` tinyint(4) NOT NULL DEFAULT 0,
  `can_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `menu_id`, `can_view`, `can_create`, `can_update`, `can_delete`, `created_at`, `updated_at`) VALUES
('0d7c3981-7bf0-4660-bf21-d297df566aca', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', '6356b71f-2231-4a33-abc7-940987158e02', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('17657b73-b1c5-4a40-ae48-57af8886d2a7', '815e11b7-d224-4614-8a69-d7fda9a1b707', 'af6d4f6d-e530-4133-a3d6-59ca15e0d16c', 1, 1, 1, 1, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('1af535be-6f3f-4cfc-83f8-2c5115041e70', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', '45d86c6e-852f-4b98-9a10-ce3752fe4d32', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('2243f163-abe5-4556-b48f-ed7a0ecc63e6', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', '0b1728d9-fc0f-4917-89d5-e2e9f5caaaed', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('267a0df1-49d9-4ba1-9f5c-f54d033a583b', 'dc038392-4b5b-4f4c-83c7-c3677b54c9d9', '0b1728d9-fc0f-4917-89d5-e2e9f5caaaed', 1, 1, 1, 1, '2026-01-30 15:11:07', '2026-01-30 15:11:07'),
('3048eac6-1cd1-4a7d-9cc4-995739b8b382', '815e11b7-d224-4614-8a69-d7fda9a1b707', '468b0d9c-9329-4bfe-aa06-9215b897195d', 1, 1, 1, 1, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('31697165-7e7b-43c3-a9f0-956a2bd73004', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', '08520e54-27a3-4b24-a370-c6148ad1025b', 1, 0, 0, 0, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('37b78e3b-2a47-42aa-8aea-ef48405f78cc', '815e11b7-d224-4614-8a69-d7fda9a1b707', 'cd3272b1-c35e-4583-8a34-49bdc1e2fc87', 1, 1, 1, 1, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('3aa868b6-543f-4dcb-82ef-94f231fcf044', 'fdd2255d-45b5-4b5d-939e-ce61c13fee57', 'a120a4ae-4931-42d8-876c-606b3e0e0016', 1, 1, 1, 1, '2026-01-30 15:13:30', '2026-01-30 15:13:30'),
('45011916-d23d-4a41-a5ff-daa247c0782b', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', '56430441-9789-4ab8-b884-c0b1747804f0', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('4a46744c-999d-4ee0-993b-09bd71292632', 'dc038392-4b5b-4f4c-83c7-c3677b54c9d9', '6fb528c4-4014-48ed-ad6b-23532d7d74dc', 1, 0, 0, 0, '2026-01-30 15:11:07', '2026-01-30 15:11:07'),
('4b9f1504-967a-4f89-9052-f000625588cf', '815e11b7-d224-4614-8a69-d7fda9a1b707', '557135d1-49b1-4917-8b77-8d75e5e0d7a9', 1, 1, 1, 1, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('4dd86d37-607e-4d16-b84a-5d9a0694c6a7', '815e11b7-d224-4614-8a69-d7fda9a1b707', '9c6cdd4c-a2f9-427e-aa94-b3804e8c55cf', 1, 0, 0, 0, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('51de6352-c9fb-4dd5-ba4d-04b51ddf4ea7', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', '72c97d31-984f-4b64-bf87-3ea4234c8277', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('5ac5349c-9765-4e99-8484-cce1b8d527ae', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', '468b0d9c-9329-4bfe-aa06-9215b897195d', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('743c08eb-ca9e-4cf7-a635-e5c7c79f1062', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', '88d0ff51-0201-4832-b380-e8fb1cdc3e0c', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('771bc31c-870a-4521-a66c-ade616e29f4c', '815e11b7-d224-4614-8a69-d7fda9a1b707', '6fb528c4-4014-48ed-ad6b-23532d7d74dc', 1, 0, 0, 0, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('7b5ca11f-9f60-4c75-b3dc-74c8739db01c', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', 'e33a1f3b-58cd-43b8-8ea0-6747f8247ee4', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('86f8202d-c759-434f-982c-a7dc2fcc439c', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', '54856bf1-42b8-4e64-9d2c-fa53d9f50efe', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('89738f21-799e-4ced-8aa1-1e139c671734', '815e11b7-d224-4614-8a69-d7fda9a1b707', '68378c24-2093-4a36-b55e-d756c6b4b624', 1, 1, 1, 1, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('94fa632f-8083-4632-9d97-3cdcacaaea17', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', '557135d1-49b1-4917-8b77-8d75e5e0d7a9', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('a5344766-bbdb-4886-a24e-8b136031d103', '815e11b7-d224-4614-8a69-d7fda9a1b707', '54856bf1-42b8-4e64-9d2c-fa53d9f50efe', 1, 1, 1, 1, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('ab1dfd23-dbb8-446c-b8c0-620dcf42279d', 'dc038392-4b5b-4f4c-83c7-c3677b54c9d9', '88d0ff51-0201-4832-b380-e8fb1cdc3e0c', 1, 1, 1, 1, '2026-01-30 15:11:07', '2026-01-30 15:11:07'),
('acd7d847-c842-4c85-b8f1-8ec779857514', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', 'af8ac9be-422f-4bce-a757-a276c7dbb847', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('aed71cd9-2266-4cc2-bc88-5556984b7f75', '815e11b7-d224-4614-8a69-d7fda9a1b707', '88d0ff51-0201-4832-b380-e8fb1cdc3e0c', 1, 1, 1, 1, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('afba52b5-1654-49e0-adaf-bddc553578ae', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', '75eabb9e-c0dd-4753-9d5a-0603f5685a3e', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('b3bba716-8af1-4638-b2b8-894f6f7a55d2', '815e11b7-d224-4614-8a69-d7fda9a1b707', '0b1728d9-fc0f-4917-89d5-e2e9f5caaaed', 1, 1, 1, 1, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('b859cf50-c511-45be-88f1-2eabaa4b89e9', 'fdd2255d-45b5-4b5d-939e-ce61c13fee57', 'af8ac9be-422f-4bce-a757-a276c7dbb847', 1, 1, 1, 1, '2026-01-30 15:13:30', '2026-01-30 15:13:30'),
('bc4f5b2d-65e4-4bb1-bdb4-ffdb334b6139', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', 'cd3272b1-c35e-4583-8a34-49bdc1e2fc87', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('c0bcaa4d-5b41-482c-8ab9-f5b42dae456d', '815e11b7-d224-4614-8a69-d7fda9a1b707', '45d86c6e-852f-4b98-9a10-ce3752fe4d32', 1, 1, 1, 1, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('cbd1603f-c45f-4d37-8e72-ba5ded6e3385', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', 'a120a4ae-4931-42d8-876c-606b3e0e0016', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('d1e84f5f-2d67-4597-97d5-1e0ba4ddbfef', '815e11b7-d224-4614-8a69-d7fda9a1b707', 'e33a1f3b-58cd-43b8-8ea0-6747f8247ee4', 1, 1, 1, 1, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('d298eb1a-c2df-40e2-bc8b-460bec613218', '815e11b7-d224-4614-8a69-d7fda9a1b707', '6356b71f-2231-4a33-abc7-940987158e02', 1, 1, 1, 1, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('d733e268-2b40-4f12-b362-f85b05694dce', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', '484b70d6-91da-4c3a-bc62-4cb4c43d7048', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('d84b0fc6-57cb-45d8-92e5-1781aaada9c5', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', '6fb528c4-4014-48ed-ad6b-23532d7d74dc', 1, 0, 0, 0, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('dd8315c2-7e51-477e-9abd-83eca8f903b5', '815e11b7-d224-4614-8a69-d7fda9a1b707', '56430441-9789-4ab8-b884-c0b1747804f0', 1, 1, 1, 1, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('ded95aa2-fe55-4b49-87fb-65af642b16f6', '815e11b7-d224-4614-8a69-d7fda9a1b707', '72c97d31-984f-4b64-bf87-3ea4234c8277', 1, 1, 1, 1, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('dff3ee39-f7a0-43ac-843f-73d5025e8e4a', 'dc038392-4b5b-4f4c-83c7-c3677b54c9d9', '468b0d9c-9329-4bfe-aa06-9215b897195d', 1, 1, 1, 1, '2026-01-30 15:11:07', '2026-01-30 15:11:07'),
('e3a2cbee-43df-4a36-acfa-bdaf70dd250b', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', '9c6cdd4c-a2f9-427e-aa94-b3804e8c55cf', 1, 0, 0, 0, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('e4a99636-a48c-4589-84b5-7b082e3f5080', '815e11b7-d224-4614-8a69-d7fda9a1b707', 'ad1e981f-2503-447e-8ee6-62b08538cc57', 1, 0, 0, 0, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('e885f3d5-6c6e-4dc9-b0b4-029ad6cedb87', '815e11b7-d224-4614-8a69-d7fda9a1b707', '75eabb9e-c0dd-4753-9d5a-0603f5685a3e', 1, 1, 1, 1, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('ee4b6539-3644-4688-996e-6ded03d1fba6', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', 'af6d4f6d-e530-4133-a3d6-59ca15e0d16c', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('eed208af-12d3-4b2a-8027-ea5ce4ed1ba7', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', '68378c24-2093-4a36-b55e-d756c6b4b624', 1, 1, 1, 1, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('efb60f53-8f7c-495a-9cd8-35ddb9256914', '815e11b7-d224-4614-8a69-d7fda9a1b707', '08520e54-27a3-4b24-a370-c6148ad1025b', 1, 0, 0, 0, '2026-01-31 09:06:14', '2026-01-31 09:06:14'),
('f04bd94f-8ccf-49df-a7b4-6276d4681e9f', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', 'ad1e981f-2503-447e-8ee6-62b08538cc57', 1, 0, 0, 0, '2026-01-31 15:37:41', '2026-01-31 15:37:41'),
('f1284c59-1397-446e-aa5b-5c24576e2de7', '815e11b7-d224-4614-8a69-d7fda9a1b707', '484b70d6-91da-4c3a-bc62-4cb4c43d7048', 1, 1, 1, 1, '2026-01-31 09:06:14', '2026-01-31 09:06:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` char(36) NOT NULL,
  `key` varchar(100) NOT NULL COMMENT 'Nama key setting, misal: app_name, app_icon',
  `value` text DEFAULT NULL COMMENT 'Nilai setting',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
('01e4b564-0658-4d27-a4c8-9b148e84f796', 'google_maps', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.13456789!2d105.266!3d-5.388!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNcKwMjMnMTYuOCJTIDEwNcKwMTUnNTcuNiJF!5e0!3m2!1sid!2sid!4v123456789', NULL, NULL),
('032a1170-a0fa-4d22-abab-d7cd27f86da3', 'logo_perusahaan', '1769234296_bdef46dc7fc4e278a28b.png', NULL, NULL),
('0cfacdab-c5ef-4d9e-a2f1-a4545dcccb06', 'smtp_pass', 'bd3f6fa877d698', NULL, NULL),
('15cba2db-6f0f-4cf4-962a-ecbc97221220', 'nominal_iuran', '50000', NULL, NULL),
('174796d2-dbbb-49ec-8bf4-11f7836a3f5a', 'footer_youtube', 'https://www.youtube.com/', NULL, NULL),
('25526201-4877-41b9-b13d-101e2aee71f6', 'smtp_from_name', 'Koperasi Eka Citra Mandiri', NULL, NULL),
('2cab184e-5330-41b3-86e0-367cb3d35579', 'tahun_berdiri', '2025', NULL, NULL),
('2edabfb3-e6ed-4af8-ad86-a0f0e2c9b295', 'smtp_user', 'f4dd695c45f093', NULL, NULL),
('30c5f72b-2fd4-4f51-9b61-d51a07cffb43', 'app_versi', '1.0', NULL, NULL),
('32748df9-7f76-4a38-8ee6-1846bae5ba03', 'nama_bank', 'BCA', NULL, NULL),
('3beeadf3-9cb7-42de-884b-87d89f518d4e', 'smtp_host', ' sandbox.smtp.mailtrap.io', NULL, NULL),
('60457af3-de6b-4d1e-b42c-543956fa6926', 'footer_instagram', 'https://www.instagram.com/', NULL, NULL),
('63b8576e-73eb-4309-a86c-d0a506e16ff7', 'smtp_crypto', 'tls', NULL, NULL),
('657ad2dc-d782-4b21-9342-351763f53a4e', 'app_phone', '083274324234', NULL, NULL),
('7820a192-7a42-448d-bfbd-0f69bdacfc83', 'app_name', 'Koperasi Eka Citra Mandiri', NULL, NULL),
('78517235-215f-44ba-a41e-ec558b95ab27', 'tgl_tagihan_iuran', '5', NULL, NULL),
('86dee4f8-2739-4a96-9650-117f2e498f32', 'captcha_site_key', '', NULL, NULL),
('96afa8e2-3888-4a2b-8e0f-a03cb843103c', 'app_email', 'mulyonomuiz63@gmail.com', NULL, NULL),
('97bded47-d511-4fb6-a077-9efde971243b', 'app_icon', '1769234296_5f8800b35d86815523bc.png', NULL, NULL),
('988aa00c-d039-4eb2-a3d9-0efbcfbbd4a3', 'footer_linkedin', 'https://www.linkedin.com/', NULL, NULL),
('b5f87ffe-103e-47fa-b849-2f2886ced4e4', 'smtp_port', '587', NULL, NULL),
('c36fdc3a-4e9e-4678-bc76-2d193e239067', 'status_iuran', 'A', NULL, NULL),
('cd87a82f-7a18-4811-974b-6a93f03eabe7', 'site_description', 'Dengan rahmat Tuhan Yang Maha Esa dan atas segala karunia-Nya, pada hari Sabtu, 3 Mei 2025, bertempat di Universitas Negeri Jakarta dalam rangka Peringatan Hari Ulang Tahun Keluarga Mahasiswa Pencinta Alam Eka Citra Universitas Negeri Jakarta yang ke-44 tahun, para anggota luar biasa KMPA Eka Citra dengan penuh  kesadaran,  cita-cita  luhur,  dan  rasa tanggung  jawab terhadap kemajuan organisasi, almamater, bangsa, dan dunia, resmi mendirikan suatu badan usaha berbadan hukum berbentuk Koperasi.\r\nKoperasi ini menjadi badan usaha otonom yang berada di bawah naungan Yayasan  Eka  Citra  Indonesia  (disingkat  YAKANESIA),  sebagai  wadah pemberdayaan ekonomi, profesionalisme, dan kemandirian bagi seluruh anggota.', NULL, NULL),
('d4248d74-9bcf-4eb0-bab6-4d74c8fdb079', 'norek', '1280835702', NULL, NULL),
('d59d9f53-f748-4c19-94c1-9c0a829f51ee', 'captcha_status', 'T', NULL, NULL),
('da6c4b7b-c8ed-4f25-9c76-83b393e0e5be', 'footer_facebook', 'http://facebook.com/', NULL, NULL),
('dc2793c3-7f8d-4379-a018-082db0f0b97b', 'site_keywords', 'Koperasi, Eka, Citra, Mandiri', NULL, NULL),
('e16cdab3-6930-4352-866f-d5b2872a7cef', 'smtp_from_email', 'noreply@gmail.com', NULL, NULL),
('e6ce381f-5409-4552-8371-5bf4a1ae3ecb', 'captcha_secret_key', '', NULL, NULL),
('ef154945-3e88-4501-b901-d2422ec1e9fb', 'nama_pemilik', 'Koperasi Eka Citra Mandiri', NULL, NULL),
('f65b225c-c2ea-4e02-bd20-6346e53dae75', 'alamat_perusahaan', 'Cibubur, Gunung Putri, Bogor, Jawa Barat 16966', NULL, NULL),
('fbc089da-eb12-4795-acd8-143f0ebf986e', 'footer_twitter', 'dsf', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `slider`
--

CREATE TABLE `slider` (
  `id` char(36) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `jenis_slider` varchar(50) NOT NULL DEFAULT 'top',
  `status` enum('A','T') NOT NULL DEFAULT 'A' COMMENT 'A=>aktif, \r\nT=>tidak aktif',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `slider`
--

INSERT INTO `slider` (`id`, `title`, `description`, `filename`, `jenis_slider`, `status`, `created_at`, `updated_at`) VALUES
('01c0575f-49e8-440e-b6d3-05c5bc854d30', 'Slider Utama', '<p>-</p>', '1769480712_996be4b7fd1e5c516b05.png', 'top', 'A', '2026-01-27 09:25:14', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tags`
--

CREATE TABLE `tags` (
  `id` char(36) NOT NULL,
  `tag_name` varchar(100) NOT NULL,
  `tag_slug` varchar(110) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tags`
--

INSERT INTO `tags` (`id`, `tag_name`, `tag_slug`, `created_at`, `updated_at`) VALUES
('1436f296-2de0-4b69-a9d7-0aae0b6df783', 'keuangan', 'keuangan', '2026-01-23 10:34:51', NULL),
('29096a69-aca5-4862-aa00-f8b208fdf69f', 'eka', 'eka', '2026-01-23 09:32:19', NULL),
('307a0fb2-6d51-492c-91fc-93ab513f86f6', 'koperasi', 'koperasi', '2026-01-23 09:32:19', NULL),
('453f9830-f852-4324-b3cd-df05925078c7', 'mandiri', 'mandiri', '2026-01-23 09:32:44', NULL),
('e85f6fbd-d45d-45dc-a816-9313628d68e0', 'citra', 'citra', '2026-01-23 10:38:58', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` char(36) NOT NULL,
  `status` enum('active','inactive','blocked') NOT NULL DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(64) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role_id`, `status`, `last_login`, `email_verified_at`, `verification_token`, `remember_token`, `created_at`, `updated_at`) VALUES
('03523811-12b4-4879-94ae-638b0454ba8c', 'bendahara', 'bendahara@gmail.com', '$2y$10$7PWV543iyqVSiGQtlRCDbedis/sqLSqH0x8ZoEiLtVMLZcnrrreZ6', 'dc038392-4b5b-4f4c-83c7-c3677b54c9d9', 'active', NULL, NULL, NULL, NULL, '2026-01-30 22:32:04', NULL),
('45a797b3-243a-4d64-b9d3-66b50287bef7', 'sekretaris', 'sekretaris@gmail.com', '$2y$10$BOBEnVJ012pZZSL9IsU2E.I94GPZUMcZcKDwa.vJ/uhCU2KqxSIFC', '2d440565-bda1-49cb-929c-42e1881c5beb', 'active', NULL, NULL, NULL, NULL, '2026-01-30 22:33:25', NULL),
('54aa2657-a745-449e-b54a-fab1d2ea8501', 'mulyonomuiz63', 'mulyonomuiz63@gmail.com', '$2y$10$Twj2I30EkSRm1dhw9H29eOQq1SV6rlyHIe/Ji5dexpamjMLB9rUIC', 'fdd2255d-45b5-4b5d-939e-ce61c13fee57', 'active', NULL, NULL, NULL, NULL, '2026-01-30 22:44:37', '2026-01-30 22:45:15'),
('55924364-7203-4c47-a5e8-5bd2bb534ca9', 'superadmin', 'superadmin@gmail.com', '$2y$10$.BMM/AffpjBE5oYZjoTqCOuWnfVDSXrxAmXBEes/zE.HxyZGBVtUy', '815e11b7-d224-4614-8a69-d7fda9a1b707', 'active', NULL, NULL, NULL, NULL, '2026-01-30 22:39:01', '2026-01-31 22:17:52'),
('c8c91e6e-991e-496c-a7ef-6ba18fda3513', 'ketua', 'ketua@gmail.com', '$2y$10$.BMM/AffpjBE5oYZjoTqCOuWnfVDSXrxAmXBEes/zE.HxyZGBVtUy', 'dd35e6ec-b68a-45f6-b5cd-fd2ba5d505f1', 'active', NULL, NULL, NULL, NULL, '2026-01-30 22:31:27', NULL),
('d309836b-4720-4bb2-b106-ac69e7ef39fe', 'anggota', 'anggota@gmail.com', '$2y$10$FeiWy.n1FSTNrj9rzBH7deTuV14frh8YWQ9LGSNITUsAu.KFgksey', 'fdd2255d-45b5-4b5d-939e-ce61c13fee57', 'active', NULL, NULL, NULL, NULL, '2026-01-30 22:34:49', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `menu_id` char(36) NOT NULL,
  `can_view` tinyint(4) NOT NULL DEFAULT 0,
  `can_create` tinyint(4) NOT NULL DEFAULT 0,
  `can_update` tinyint(4) NOT NULL DEFAULT 0,
  `can_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_slug` (`category_slug`);

--
-- Indeks untuk tabel `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `iuran_bulanan`
--
ALTER TABLE `iuran_bulanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_iuran` (`pegawai_id`,`bulan`,`tahun`),
  ADD KEY `idx_iuran_pegawai` (`pegawai_id`),
  ADD KEY `idx_bulan_tahun` (`bulan`,`tahun`);

--
-- Indeks untuk tabel `iuran_generate_log`
--
ALTER TABLE `iuran_generate_log`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_ip_address` (`email`,`ip_address`);

--
-- Indeks untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_news_category` (`category_id`);

--
-- Indeks untuk tabel `news_tags`
--
ALTER TABLE `news_tags`
  ADD PRIMARY KEY (`news_id`,`tag_id`),
  ADD KEY `fk_news_tags_tag` (`tag_id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_notif` (`user_id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_password` (`user_id`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `idx_pegawai_iuran` (`status`,`status_iuran`),
  ADD KEY `fk_perusahaan_pegawai` (`perusahaan_id`),
  ADD KEY `fk_jabatan_pegawai` (`jabatan_id`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_no` (`invoice_no`),
  ADD KEY `idx_pegawai` (`pegawai_id`),
  ADD KEY `idx_pembayaran_bulan_tahun` (`bulan`,`tahun`),
  ADD KEY `idx_pembayaran_status` (`status`),
  ADD KEY `idx_pembayaran_jenis_bulan_tahun` (`jenis_transaksi`,`bulan`,`tahun`);

--
-- Indeks untuk tabel `pembayaran_detail`
--
ALTER TABLE `pembayaran_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pembayaran_p_detail` (`pembayaran_id`),
  ADD KEY `fk_iuran_p_detail` (`iuran_id`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu_permission` (`menu_id`);

--
-- Indeks untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu_role` (`menu_id`),
  ADD KEY `fk_role_permission` (`role_id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indeks untuk tabel `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag_slug` (`tag_slug`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_role_user` (`role_id`);

--
-- Indeks untuk tabel `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu_user_permission` (`menu_id`),
  ADD KEY `fk_user_user_permission` (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `iuran_bulanan`
--
ALTER TABLE `iuran_bulanan`
  ADD CONSTRAINT `fk_pegawai_iuran` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `news_tags`
--
ALTER TABLE `news_tags`
  ADD CONSTRAINT `fk_news_tags_news` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_news_tags_tag` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_user_notif` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `fk_user_password` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `fk_jabatan_pegawai` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_perusahaan_pegawai` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_pegawai` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pegawai_pembayaran` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran_detail`
--
ALTER TABLE `pembayaran_detail`
  ADD CONSTRAINT `fk_iuran_p_detail` FOREIGN KEY (`iuran_id`) REFERENCES `iuran_bulanan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pembayaran_p_detail` FOREIGN KEY (`pembayaran_id`) REFERENCES `pembayaran` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `fk_menu_permission` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `fk_menu_role` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_role_permission` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role_user` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `fk_menu_user_permission` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_user_permission` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
