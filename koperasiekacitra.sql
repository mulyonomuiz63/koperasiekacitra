-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Jan 2026 pada 04.23
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
('0878e046-6877-478d-beca-f25d43ae086a', 'tes1@gmail.com', 'Invoice Pembayaran: INV/2026/01/00001', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Tue, 27 Jan 2026 07:47:47 +0000\r\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\r\nReturn-Path: &lt;noreply@gmail.com&gt;\r\nTo: tes1@gmail.com\r\nSubject: =?UTF-8?Q?Invoice=20Pembayaran:=20INV/2026/01/00001?=\r\nReply-To: &lt;noreply@gmail.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@gmail.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;69786da31b63b6.67522702@gmail.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-27 14:47:47'),
('1', 'tes@gmail.com', 'Reset Password', 'failed', '220 smtp.gmail.com ESMTP 98e67ed59e1d1-35273277f68sm2406647a91.0 - gsmtp\r\n<br><pre>hello: 250-smtp.gmail.com at your service, [114.10.100.116]\r\n250-SIZE 35882577\r\n250-8BITMIME\r\n250-STARTTLS\r\n250-ENHANCEDSTATUSCODES\r\n250-PIPELINING\r\n250-CHUNKING\r\n250 SMTPUTF8\r\n</pre><pre>starttls: 220 2.0.0 Ready to start TLS\r\n</pre><pre>hello: 250-smtp.gmail.com at your service, [114.10.100.116]\r\n250-SIZE 35882577\r\n250-8BITMIME\r\n250-AUTH LOGIN PLAIN XOAUTH2 PLAIN-CLIENTTOKEN OAUTHBEARER XOAUTH\r\n250-ENHANCEDSTATUSCODES\r\n250-PIPELINING\r\n250-CHUNKING\r\n250 SMTPUTF8\r\n</pre>Failed to authenticate password. Error: 535-5.7.8 Username and Password not accepted. For more information, go to\r\n535 5.7.8  https://support.google.com/mail/?p=BadCredentials 98e67ed59e1d1-35273277f68sm2406647a91.0 - gsmtp\r\n<br>Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Sat, 17 Jan 2026 15:52:00 +0000\r\nFrom: &quot;Aplikasi Anda&quot; &lt;noreply@email.com&gt;\r\nReturn-Path: &lt;noreply@email.com&gt;\r\nTo: tes@gmail.com\r\nSubject: =?UTF-8?Q?Reset=20Password?=\r\nReply-To: &lt;noreply@email.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@email.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;696bb020867ea5.36442006@email.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-17 22:52:03'),
('2bfae032-9977-454b-a606-f9413a524ec3', 'tes1@gmail.com', 'Pemberitahuan Penolakan Pembayaran', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Tue, 27 Jan 2026 07:05:45 +0000\r\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\r\nReturn-Path: &lt;noreply@gmail.com&gt;\r\nTo: tes1@gmail.com\r\nSubject: =?UTF-8?Q?Pemberitahuan=20Penolakan=20Pembayaran?=\r\nReply-To: &lt;noreply@gmail.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@gmail.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;697863c9748ec2.99605799@gmail.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-27 14:05:45'),
('45dc240c-72fe-46df-99e0-04c41af3452d', 'mulyonomuiz633@gmail.com', 'Verifikasi Akun Koperasi Eka Citra Mandiri', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Sun, 25 Jan 2026 01:20:34 +0000\r\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\r\nReturn-Path: &lt;noreply@gmail.com&gt;\r\nTo: mulyonomuiz633@gmail.com\r\nSubject: =?UTF-8?Q?Verifikasi=20Akun=20Koperasi=20Eka=20Citra=20Mandiri?=\r\nReply-To: &lt;noreply@gmail.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@gmail.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;69756fe2d56ff6.78893454@gmail.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-25 08:20:34'),
('516dce2f-b2cb-4651-a437-b2dc22a4f711', 'mulyonoias68323@gmail.com', 'Verifikasi Akun Koperasi Eka Citra Mandiri', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Tue, 27 Jan 2026 06:37:24 +0000\r\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\r\nReturn-Path: &lt;noreply@gmail.com&gt;\r\nTo: mulyonoias68323@gmail.com\r\nSubject: =?UTF-8?Q?Verifikasi=20Akun=20Koperasi=20Eka=20Citra=20Mandiri?=\r\nReply-To: &lt;noreply@gmail.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@gmail.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;69785d2786dd97.59944986@gmail.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-27 13:37:27'),
('b852d773-363e-4141-87b0-991d272df236', 'mulyonoias68@gmail.com', 'Verifikasi Akun Koperasi Eka Citra Mandiri', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Sun, 25 Jan 2026 01:10:55 +0000\r\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\r\nReturn-Path: &lt;noreply@gmail.com&gt;\r\nTo: mulyonoias68@gmail.com\r\nSubject: =?UTF-8?Q?Verifikasi=20Akun=20Koperasi=20Eka=20Citra=20Mandiri?=\r\nReply-To: &lt;noreply@gmail.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@gmail.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;69756d9f48a344.21508432@gmail.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-25 08:10:55'),
('bb4bca72-2191-421a-94ed-c9fe7f96416d', 'mulyonomuiz63@gmail.com', 'Reset Password', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Sun, 25 Jan 2026 01:28:04 +0000\r\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\r\nReturn-Path: &lt;noreply@gmail.com&gt;\r\nTo: mulyonomuiz63@gmail.com\r\nSubject: =?UTF-8?Q?Reset=20Password?=\r\nReply-To: &lt;noreply@gmail.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: noreply@gmail.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;697571a4e970f9.00876379@gmail.com&gt;\r\nMime-Version: 1.0\r\n\n</pre>', '2026-01-25 08:28:04'),
('ec6706d5-b0e2-4958-86dd-15ea6277f90a', 'mulyonomuiz63@gmail.com', 'Verifikasi Akun Koperasi', 'failed', 'Unable to send email using SMTP. Your server might not be configured to send mail using this method.<br><pre>Date: Sat, 24 Jan 2026 16:19:39 +0000\nFrom: &quot;Koperasi Eka Citra Mandiri&quot; &lt;noreply@gmail.com&gt;\nReturn-Path: &lt;noreply@gmail.com&gt;\nTo: mulyonomuiz63@gmail.com\nSubject: =?UTF-8?Q?Verifikasi=20Akun=20Koperasi?=\nReply-To: &lt;noreply@gmail.com&gt;\nUser-Agent: CodeIgniter\nX-Sender: noreply@gmail.com\nX-Mailer: CodeIgniter\nX-Priority: 3 (Normal)\nMessage-ID: &lt;6974f11b583ab7.16142389@gmail.com&gt;\nMime-Version: 1.0\n\n</pre>', '2026-01-24 23:19:39');

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

--
-- Dumping data untuk tabel `galeri`
--

INSERT INTO `galeri` (`id`, `title`, `description`, `filename`, `jenis_galeri`, `status`, `created_at`, `updated_at`) VALUES
('2', 'Tes  ok', '<p>tes</p>', '1769069733_b49f4b69a240558cd060.jpg', 'atas', 'A', '2026-01-17 07:58:28', '2026-01-27 09:29:41'),
('2346534', 'Tes', '<p>tes</p>', '1769069733_b49f4b69a240558cd060.jpg', 'bawah', 'A', '2026-01-17 07:58:28', '2026-01-27 09:29:46'),
('23465344545', 'Tes', '<p>tes</p>', '1769069733_b49f4b69a240558cd060.jpg', 'bawah', 'A', '2026-01-17 07:58:28', '2026-01-27 09:29:51'),
('23465344545242', 'Tes', '<p>tes</p>', '1769069733_b49f4b69a240558cd060.jpg', 'bawah', 'A', '2026-01-17 07:58:28', '2026-01-27 09:29:55'),
('23686', 'Tes', '<p>tes</p>', '1769069733_b49f4b69a240558cd060.jpg', 'atas', 'A', '2026-01-17 07:58:28', '2026-01-27 09:29:59');

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
('104e622e-704b-4c17-b858-aa9f74871118', '556bdb4a-d932-4285-8373-13ec8d83246e', 1, 2026, 50000, '2026-01-27', 'B', '2026-01-27 13:47:22', NULL),
('d4be8781-99fc-4b89-b2c7-6f38e6bd909d', '2', 1, 2026, 50000, '2026-01-27', 'S', '2026-01-27 13:47:22', '2026-01-27 14:47:47');

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
('13a64307-387e-4fd0-998f-cdf229ab78e7', 1, 2026, 2, 50000.00, '2026-01-27 06:47:22', 'SUCCESS', NULL);

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
('1', 'Ketua', 'ADMIN', '-', NULL, '2026-01-24 12:02:22'),
('2', 'Sekertaris', 'ADMIN', '-', '2026-01-17 01:20:12', '2026-01-24 11:56:56'),
('2523f7db-28e2-4f86-997a-e0adac2fad81', 'Komisaris', 'ADMIN', '-', '2026-01-24 12:03:10', NULL),
('3', 'Bendahara', 'ADMIN', '-', '2026-01-17 01:20:36', '2026-01-24 11:57:00'),
('4', 'Anggota', 'ANGGOTA', '-', '2026-01-17 01:20:45', '2026-01-24 11:57:04');

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

--
-- Dumping data untuk tabel `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `email`, `ip_address`, `attempts`, `last_attempt`) VALUES
('2', 'asdsad@dsf', '::1', 1, '2026-01-17 14:47:05'),
('6', 'tem@gmail.com', '::1', 1, '2026-01-18 05:24:21'),
('7', 'tes1@gmail', '::1', 1, '2026-01-18 05:34:09'),
('8', 'ts@gmail.com', '::1', 1, '2026-01-21 02:40:14');

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
('10', 'Users', 'users', '/users', 'ki-outline ki-element-11', '7', 3, 1, '2026-01-15 15:56:45', '0000-00-00 00:00:00'),
('11', 'Settings', 'settings', '/settings', 'ki-outline ki-element-11', NULL, 2, 1, '2026-01-16 15:19:56', '0000-00-00 00:00:00'),
('15', 'Master Data', 'master-data', '#', 'ki-outline ki-element-11', NULL, 3, 1, '2026-01-16 22:42:46', '0000-00-00 00:00:00'),
('16', 'Pegawai', 'pegawai', '/pegawai', 'ki-outline ki-element-11', '15', 2, 1, '2026-01-16 22:43:39', '0000-00-00 00:00:00'),
('17', 'Perusahaan', 'perusahaan', '/perusahaan', 'ki-outline ki-element-11', '15', 1, 1, '2026-01-16 22:44:01', '0000-00-00 00:00:00'),
('19', 'Jabatan', 'jabatan', '/jabatan', 'ki-outline ki-element-11', '15', 3, 1, '2026-01-17 08:09:26', '0000-00-00 00:00:00'),
('1b1de8ff-1c7b-46c5-9368-2e504d3e4c00', 'Category', 'category', '/category', 'ki-outline ki-element-11', '3149b0e2-c230-4b78-a07f-cec023da2fe6', 1, 1, '2026-01-23 10:49:49', NULL),
('20', 'Galeri', 'galeri', '/galeri', 'ki-outline ki-element-11', '15', 4, 1, '2026-01-17 14:32:10', '0000-00-00 00:00:00'),
('21', 'Faq', 'faq', '/faq', 'ki-outline ki-element-11', '15', 4, 1, '2026-01-17 15:08:20', '0000-00-00 00:00:00'),
('22', 'Pembayaran', 'pembayaran', '/pembayaran', 'ki-outline ki-element-11', NULL, 4, 1, '2026-01-18 15:47:41', '0000-00-00 00:00:00'),
('23', 'Iuran', 'iuran', '/sw-anggota/iuran', 'ki-outline ki-element-11', NULL, 5, 1, '2026-01-20 09:53:56', '2026-01-21 21:32:56'),
('24', 'Histori', 'histori-iuran', '/sw-anggota/histori-iuran', 'ki-outline ki-element-11', NULL, 5, 1, '2026-01-20 23:05:50', '2026-01-24 22:39:26'),
('25', 'Iuran Bulanan', 'iuran-bulanan', '/iuran-bulanan', 'ki-outline ki-element-11', NULL, 6, 1, '2026-01-20 23:52:25', '0000-00-00 00:00:00'),
('3149b0e2-c230-4b78-a07f-cec023da2fe6', 'Blog & News', 'blog-news', '#', 'ki-outline ki-element-11', NULL, 7, 1, '2026-01-23 10:48:43', '2026-01-23 14:56:45'),
('58daa6c7-4e79-4a1c-97ef-0e168b7b10ea', 'News', 'news', '/news', 'ki-outline ki-element-11', '3149b0e2-c230-4b78-a07f-cec023da2fe6', 2, 1, '2026-01-23 11:53:59', '2026-01-23 14:56:40'),
('7', 'User Management', 'user-management', '#', 'ki-outline ki-element-11', NULL, 1, 1, '2026-01-15 15:42:35', '0000-00-00 00:00:00'),
('7de2bdfc-4bd9-42c7-b008-bb20febc2f23', 'Slider', 'slider', '/slider', 'ki-outline ki-element-11', '15', 7, 1, '2026-01-27 09:23:26', NULL),
('8', 'Menus', 'menus', '/menus', 'ki-outline ki-element-11', '7', 1, 1, '2026-01-15 15:47:05', '0000-00-00 00:00:00'),
('9', 'Roles', 'roles', '/roles', 'ki-outline ki-element-11', '7', 2, 1, '2026-01-15 15:48:09', '0000-00-00 00:00:00');

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
('14496f02-f3e3-405f-a7d1-f9827d0dcc68', 'b1d5261d-c3e0-47ec-aa78-10ab1d45fdce', 'tes', 'tes', '', '<p>tes</p>', '1769164860_6c6b52090c2ebaf0c365.png', 'Admin', 7, 'publish', '2026-01-23 10:41:00', '2026-01-26 07:27:09'),
('15d54546-8ec9-473c-b66e-4b48b9945508', '1cee8226-f834-11f0-b74b-68f728f3cb26', 'Koperasi Eka Citra Mandiri', 'koperasi-eka-citra-mandiri', '', '<p><strong class=\"Yjhzub\"><a class=\"GI370e\" href=\"https://www.google.com/search?q=Epsum+Labs+%28EpsumThings%29&amp;oq=ep&amp;gs_lcrp=EgZjaHJvbWUqBggBEEUYOzIGCAAQRRg5MgYIARBFGDsyBwgCEAAYjwIyBwgDEAAYjwIyBwgEEAAYjwIyBggFEEUYPDIGCAYQRRg8MgYIBxBFGDzSAQgyMDE1ajBqNKgCALACAQ&amp;sourceid=chrome&amp;ie=UTF-8&amp;ved=2ahUKEwjLi7SGnaGSAxUo1TgGHZi-BKkQgK4QegYIAQgAEAo\" data-ved=\"2ahUKEwjLi7SGnaGSAxUo1TgGHZi-BKkQgK4QegYIAQgAEAo\" data-hveid=\"CAEIABAK\">Epsum Labs (EpsumThings)</a></strong>: Sebuah platform IoT (Internet of Things) dan IIoT (Industrial Internet of Things) untuk otomatisasi, pemantauan, dan visualisasi proses, menawarkan solusi untuk manufaktur, logistik, dan lainnya d</p>', '1769160283_4c69f4866b13c294bb65.jpg', 'Admin', 12, 'publish', '2026-01-23 08:24:25', '2026-01-24 00:42:19'),
('c3776c39-ceec-4130-8a50-ff4d28d4e7d3', 'b1d5261d-c3e0-47ec-aa78-10ab1d45fdce', 'Perkuat Fondasi Ekonomi Bali, OJK dan BPS Perluas Jangkauan Survei Literasi Keuangan 2026', 'perkuat-fondasi-ekonomi-bali-ojk-dan-bps-perluas-jangkauan-survei-literasi-keuangan-2026', '', '<p>Denpasar&ndash; Dalam upaya membangun masyarakat yang cerdas secara finansial, Otoritas Jasa Keuangan (OJK) Provinsi Bali bersinergi dengan Badan Pusat Statistik (BPS) dan Lembaga Penjamin Simpanan (LPS) resmi memulai persiapan Survei Nasional Literasi dan Inklusi Keuangan (SNLIK) 2026.</p>\r\n<p>Berbeda dari tahun-tahun sebelumnya, tahun ini Bali melakukan lompatan besar. Jika sebelumnya survei hanya menyasar tiga kabupaten, kini SNLIK 2026 akan menjangkau seluruh kabupaten/kota di Provinsi Bali.</p>\r\n<p>Perluasan ini bertujuan untuk menghasilkan peta kekuatan ekonomi masyarakat yang jauh lebih akurat hingga ke pelosok daerah.<br><br><br></p>', '1769164491_953282b326efdb64580e.jpg', 'Admin', 29, 'publish', '2026-01-23 10:34:51', '2026-01-27 15:21:11');

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
('2', '10', '435352', 13213, 'mulyono ias', 'L', '2026-01-09', 'Sumberjo', 'Tumijaya RT 010 RW 003 Kecamatan Jayapura Kabupaten OKU Timur Provinsi Sumatera Selatan', '63443634', '1', '1', '2026-01-18', 'A', 'A', 'default.jpg', '2026-01-16 23:16:35', '2026-01-25 01:13:44'),
('556bdb4a-d932-4285-8373-13ec8d83246e', '3a488747-bd55-4f92-88ec-e4fcb54b03d6', '202601242668', 2147483647, 'mulyono ias', 'L', '1997-08-06', 'Sumberjo', 'Lampung selatan', '081532423436', '1', '4', '2026-01-24', 'A', 'A', 'default.jpg', '2026-01-24 23:19:39', '2026-01-25 00:25:27'),
('6ee1897e-2a87-47a6-9597-17968b026f3b', '4f2e746f-41c7-476f-824d-0c259f282917', NULL, NULL, '', 'L', NULL, '', NULL, NULL, '1', '4', NULL, 'T', 'T', 'default.jpg', '2026-01-27 13:37:27', NULL),
('94e3af69-f952-11f0-b74b-68f728f3cb26', '5', NULL, NULL, 'Super Admin', '', NULL, '', NULL, NULL, '1', '1', NULL, 'A', 'T', 'default.jpg', '2026-01-25 01:28:35', '2026-01-25 01:28:51');

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
('78f72a22-fa34-4a9a-83ea-4cc41c255233', 'INV/2026/01/00001', '2026-01-27 07:47:47', '2', 'bulanan', 1, 2026, 50000, 'bukti_78f72a22-fa34-4a9a-83ea-4cc41c255233_20260127073236.jpeg', '2026-01-27', 'mulyono', 'A', NULL, '', '2026-01-27 07:47:47', '2026-01-27 14:09:17', '2026-01-27 14:47:47'),
('c753d9a5-be85-4df2-bb0d-df683dbefd66', NULL, NULL, '2', 'bulanan', 1, 2026, 50000, 'bukti_c753d9a5-be85-4df2-bb0d-df683dbefd66_20260127065404.jpeg', NULL, '', 'R', NULL, '', NULL, '2026-01-27 13:48:10', '2026-01-27 14:05:45');

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
('78a3925a-6536-4342-9d93-c8eb4d6953a6', '78f72a22-fa34-4a9a-83ea-4cc41c255233', 'd4be8781-99fc-4b89-b2c7-6f38e6bd909d', 50000),
('fca8ba45-83d6-44c9-b8d5-430879f74982', 'c753d9a5-be85-4df2-bb0d-df683dbefd66', 'd4be8781-99fc-4b89-b2c7-6f38e6bd909d', 50000);

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
('1', 'PT Masyon', 'Lampung', '081532423436', 'mulyonomuiz63@gmail.com', 'default', NULL, NULL);

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
('1', 'Ketua', 'ADMIN', 'tes', NULL),
('2', 'Bendahara', 'ADMIN', NULL, NULL),
('24801181-23c5-4d65-bcc8-cbfa032ca6e8', 'Superadmin', 'ADMIN', '-', '2026-01-24 11:26:33'),
('3', 'Sekretaris', 'ADMIN', NULL, NULL),
('4', 'Anggota', 'ANGGOTA', NULL, NULL);

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
('01c230e8-5e9c-4f2c-b44e-f21df1ccea9a', '1', '25', 1, 1, 1, 1, '2026-01-27 02:24:34', '2026-01-27 02:24:34'),
('044f2d58-1a66-4e15-a9d0-8978da8aefcb', '1', '15', 1, 0, 0, 0, '2026-01-27 02:24:34', '2026-01-27 02:24:34'),
('07e44524-37eb-406d-9034-6a06f7354e7f', '1', '20', 1, 1, 1, 1, '2026-01-27 02:24:34', '2026-01-27 02:24:34'),
('126', '4', '23', 1, 1, 1, 1, '2026-01-20 16:06:08', '2026-01-20 16:06:08'),
('127', '4', '24', 1, 1, 1, 1, '2026-01-20 16:06:08', '2026-01-20 16:06:08'),
('178eda6d-a1b4-4a59-8a53-b3e7680207b1', '1', '3149b0e2-c230-4b78-a07f-cec023da2fe6', 1, 0, 0, 0, '2026-01-27 02:24:34', '2026-01-27 02:24:34'),
('2e4f9ae0-96c6-42d0-8e1c-53fa458bd683', '1', '10', 1, 1, 1, 1, '2026-01-27 02:24:34', '2026-01-27 02:24:34'),
('2f5693fa-11ef-46bc-8d29-6370c9df28e5', '1', '17', 1, 1, 1, 1, '2026-01-27 02:24:34', '2026-01-27 02:24:34'),
('3dc7eba7-e769-4603-80e4-a15fa419d9ef', '1', '16', 1, 1, 1, 1, '2026-01-27 02:24:34', '2026-01-27 02:24:34'),
('859dda6e-1807-4560-8f95-e78d85558662', '1', '9', 1, 1, 1, 1, '2026-01-27 02:24:34', '2026-01-27 02:24:34'),
('86967e21-691b-497a-9431-ef1ec7bd4c6e', '1', '11', 1, 1, 1, 1, '2026-01-27 02:24:34', '2026-01-27 02:24:34'),
('8cb937be-01b5-43b3-91ff-0f62d9080f18', '1', '1b1de8ff-1c7b-46c5-9368-2e504d3e4c00', 1, 1, 1, 0, '2026-01-27 02:24:34', '2026-01-27 02:24:34'),
('acdc8bcf-48a9-4ba0-a333-ac9d1799768e', '1', '22', 1, 1, 1, 1, '2026-01-27 02:24:34', '2026-01-27 02:24:34'),
('ba4dc06c-0f1c-47a2-a5a6-db53ab9842ab', '1', '58daa6c7-4e79-4a1c-97ef-0e168b7b10ea', 1, 1, 0, 0, '2026-01-27 02:24:34', '2026-01-27 02:24:34'),
('ca2fb38e-6b60-45db-b803-473dcae67cf1', '1', '8', 1, 1, 1, 1, '2026-01-27 02:24:34', '2026-01-27 02:24:34'),
('d03ec58c-f544-4d68-bf46-4f957247cefc', '1', '21', 1, 1, 1, 1, '2026-01-27 02:24:34', '2026-01-27 02:24:34'),
('e6a2dc15-0d2a-40e3-8cdc-7be9e182ff24', '1', '19', 1, 1, 1, 1, '2026-01-27 02:24:34', '2026-01-27 02:24:34'),
('fbee84f1-abff-4031-9dcc-bbdca2ccbfac', '1', '7de2bdfc-4bd9-42c7-b008-bb20febc2f23', 1, 1, 1, 1, '2026-01-27 02:24:34', '2026-01-27 02:24:34');

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
('1', 'tesa', 'tesa@gmail.com', '$2y$10$X6hgBSUV3IfjLxNWq4DXX.9kkeyLxtrMPuLMzUT/xBseOnUksM86y', '4', 'inactive', NULL, NULL, '8d684e5e036d25e3974ecdd6151afdcd0176d4ee1b473055758541d627155ddb', NULL, NULL, '2026-01-21 15:15:00'),
('10', 'tesd', 'tes1@gmail.com', '$2y$10$G7uKDINd5tsyyJFRAie92OKTMnd7hLvokulKJDKHS5WzG5YAbQ4yC', '4', 'active', NULL, NULL, '5288ebbe5bb7033f850416cf04d7b2c27607a7bbd5195805cabf617b6cf91412', '535eecbe22f31858f3bf7023642213cda4f4977c88a71fdc3d92580d76d27fcf', NULL, NULL),
('11', 'ada', 'ada@gmail.com', '$2y$10$rTQ26qX5aitqDpPBcN1beuPRfElrcih7hw/ysbY0djFoBUuFKvJ5C', '4', 'active', NULL, '2026-01-24 16:30:57', NULL, NULL, NULL, '2026-01-24 23:30:57'),
('3a488747-bd55-4f92-88ec-e4fcb54b03d6', 'mulyonomuiz63', 'mulyonomuiz63@gmail.com', '$2y$10$QHdukAYjywnFvfqhx8MBoORDrbK6uwNS0wla1hGJcZgV9.uWL6pIS', '4', 'active', NULL, '2026-01-24 16:25:39', NULL, NULL, '2026-01-24 23:19:39', '2026-01-25 08:53:10'),
('4f2e746f-41c7-476f-824d-0c259f282917', 'mulyonoias68323', 'mulyonoias68323@gmail.com', '$2y$10$zUjO7xMqo29Vu2YgvQq5W.XxhPeJgpLfz.kGEanexL6SP9cyiYdJK', '4', 'inactive', NULL, NULL, '2bcf297eba834af2c1ad7c413b22d49bc109f2b9f8aa7fe491809862ce0fc713', NULL, '2026-01-27 13:37:27', NULL),
('5', 'tes', 'tes@gmail.com', '$2y$10$G7uKDINd5tsyyJFRAie92OKTMnd7hLvokulKJDKHS5WzG5YAbQ4yC', '1', 'active', '2026-01-17 07:22:23', NULL, '967ef6e71f282e67e0e37f97d1c29cc49b63ea5e094fb6b0dd7e285330b17ed6', NULL, NULL, '2026-01-24 23:57:10'),
('6', 'anissa', 'anissa@gmail.com', '$2y$10$az1KVGKEpQ5whzif/ILu3ODvhc31bRH6XVEMzQHg.loScgkBIW72a', '2', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
('8', 'tess', 'tess@gmail.com', '$2y$10$8aY6Pnz2tD78Y65pgjt6KO.C7/Bts6V95h8arPvkTSNxmmE2DBYge', '4', 'inactive', NULL, NULL, '767b42c93a294a9b15d80fb414767d511d3bc72df6aea3111884d786d8f61e70', NULL, NULL, NULL),
('859fd4d0-b253-4304-972a-81b78a0ab146', 'mulyonomuiz633', 'mulyonomuiz633@gmail.com', '$2y$10$N711nOCKce4xtBS/F/WV1OlQMnnufzWvT.KFfu3eOo/tIwcrLqFdu', '4', 'inactive', NULL, NULL, '9a531ab5c58db18328c93054fcef7432d36d389be03f7af1a751b9e8d0dc0651', NULL, '2026-01-25 08:20:34', NULL),
('f66fa219-ed64-46ef-85c8-1e95a47112c1', 'mulyonoias68', 'mulyonoias68@gmail.com', '$2y$10$dfHqPaQIXuIJ1GxlyWSTReEiBJFQzL76PizeqvdvK8GH7Qvmq4JH2', '4', 'inactive', NULL, NULL, '4c87b6cc8a22f18ff9f97dd9c160e9d8064d87d98c1259ce8bcfe1c16a3c78ab', NULL, '2026-01-25 08:10:55', NULL);

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
-- Dumping data untuk tabel `user_permissions`
--

INSERT INTO `user_permissions` (`id`, `user_id`, `menu_id`, `can_view`, `can_create`, `can_update`, `can_delete`, `created_at`, `updated_at`) VALUES
('15', '1', '7', 1, 0, 0, 0, '2026-01-15 08:48:56', '2026-01-15 08:48:56'),
('16', '1', '8', 1, 0, 0, 0, '2026-01-15 08:48:56', '2026-01-15 08:48:56'),
('17', '1', '9', 1, 0, 0, 0, '2026-01-15 08:48:56', '2026-01-15 08:48:56'),
('68', '5', '7', 1, 0, 0, 0, '2026-01-15 16:54:14', '2026-01-15 16:54:14'),
('69', '5', '9', 1, 1, 1, 1, '2026-01-15 16:54:14', '2026-01-15 16:54:14'),
('70', '5', '10', 1, 0, 0, 0, '2026-01-15 16:54:14', '2026-01-15 16:54:14'),
('76', '6', '7', 1, 1, 1, 1, '2026-01-16 14:17:38', '2026-01-16 14:17:38'),
('77', '6', '8', 1, 0, 0, 1, '2026-01-16 14:17:38', '2026-01-16 14:17:38'),
('78', '6', '9', 1, 0, 0, 1, '2026-01-16 14:17:38', '2026-01-16 14:17:38'),
('79', '6', '10', 1, 0, 0, 1, '2026-01-16 14:17:38', '2026-01-16 14:17:38'),
('80', '6', '11', 1, 1, 1, 1, '2026-01-16 14:17:38', '2026-01-16 14:17:38');

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
