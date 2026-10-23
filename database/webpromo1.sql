-- WebPromo - skema lengkap MySQL 5.7+/8.x atau MariaDB 10.3+.
-- Pilih database di phpMyAdmin lalu Import file ini. Aman diimpor ulang:
-- tabel dibuat bila belum ada, data contoh hanya ditambahkan bila belum ada (INSERT IGNORE).
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `admin` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `dibuat` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`), UNIQUE KEY `uq_admin_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `settings` (
  `kunci` VARCHAR(50) NOT NULL,
  `nilai` TEXT NOT NULL,
  PRIMARY KEY (`kunci`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `banner` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` VARCHAR(255) NOT NULL DEFAULT '',
  `subjudul` TEXT NOT NULL,
  `gambar` VARCHAR(500) NOT NULL DEFAULT '',
  `tombol` VARCHAR(100) NOT NULL DEFAULT '',
  `link` VARCHAR(500) NOT NULL DEFAULT '',
  `urutan` INT NOT NULL DEFAULT 0,
  `dibuat` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`), KEY `idx_banner_urutan` (`urutan`, `id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `portofolio` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` VARCHAR(255) NOT NULL DEFAULT '',
  `kategori` VARCHAR(100) NOT NULL DEFAULT '',
  `gambar` VARCHAR(500) NOT NULL DEFAULT '',
  `url` VARCHAR(500) NOT NULL DEFAULT '',
  `deskripsi` TEXT NOT NULL,
  `urutan` INT NOT NULL DEFAULT 0,
  `dibuat` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`), KEY `idx_portofolio_kategori` (`kategori`), KEY `idx_portofolio_urutan` (`urutan`, `id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `produk` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(255) NOT NULL DEFAULT '',
  `harga` BIGINT UNSIGNED NOT NULL DEFAULT 0,
  `fitur` TEXT NOT NULL COMMENT 'Satu fitur per baris',
  `populer` TINYINT(1) NOT NULL DEFAULT 0,
  `urutan` INT NOT NULL DEFAULT 0,
  `dibuat` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`), KEY `idx_produk_urutan` (`urutan`, `id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `testimoni` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(150) NOT NULL DEFAULT '',
  `jabatan` VARCHAR(150) NOT NULL DEFAULT '',
  `foto` VARCHAR(500) NOT NULL DEFAULT '',
  `isi` TEXT NOT NULL,
  `rating` TINYINT UNSIGNED NOT NULL DEFAULT 5,
  `urutan` INT NOT NULL DEFAULT 0,
  `dibuat` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`), KEY `idx_testimoni_urutan` (`urutan`, `id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `faq` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pertanyaan` VARCHAR(500) NOT NULL DEFAULT '',
  `jawaban` TEXT NOT NULL,
  `urutan` INT NOT NULL DEFAULT 0,
  `dibuat` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`), KEY `idx_faq_urutan` (`urutan`, `id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `pesan_kontak` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(150) NOT NULL,
  `email` VARCHAR(254) NOT NULL,
  `telepon` VARCHAR(40) NOT NULL DEFAULT '',
  `pesan` TEXT NOT NULL,
  `tanggal` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `legacy_key` CHAR(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_pesan_legacy` (`legacy_key`),
  KEY `idx_pesan_tanggal` (`tanggal`, `id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===== Data awal =====
-- Admin awal: admin / admin123 (password tersimpan terenkripsi). GANTI segera.
INSERT IGNORE INTO `admin` (`id`, `username`, `password_hash`) VALUES
(1, 'admin', '$2y$12$aTLLvRw6j.zK8uYrfuO0lO.n1mi4eMihPaEcvM7M7NY4DJUsTcAY2');

INSERT IGNORE INTO `settings` (`kunci`, `nilai`) VALUES
('nama_situs', 'WebPromo.id'),
('tagline', 'Jasa Pembuatan Website Profesional'),
('whatsapp', '6281234567890'),
('email', 'halo@webpromo.id'),
('telepon', '0812-3456-7890'),
('alamat', 'Jl. Merdeka No. 10, Jakarta'),
('warna', '#ff5a1f'),
('instagram', 'https://instagram.com/'),
('facebook', 'https://facebook.com/'),
('meta_deskripsi', 'Jasa pembuatan website company profile, toko online, dan landing page.'),
('footer', '© 2026 WebPromo.id. All rights reserved.');

INSERT IGNORE INTO `banner` (`id`, `judul`, `subjudul`, `gambar`, `tombol`, `link`, `urutan`) VALUES
(1, 'Jasa Pembuatan Website Profesional & Terjangkau', 'Tingkatkan kredibilitas bisnis Anda dengan website modern, cepat, dan SEO friendly.', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1600', 'Lihat Paket', 'produk.php', 1),
(2, 'Website Toko Online Siap Jualan', 'Terima pesanan 24 jam dengan katalog produk dan checkout WhatsApp.', 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1600', 'Konsultasi Gratis', 'kontak.php', 2);

INSERT IGNORE INTO `portofolio` (`id`, `judul`, `kategori`, `gambar`, `url`, `deskripsi`, `urutan`) VALUES
(1, 'Klinik Sehat', 'Company Profile', 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800', '#', 'Website klinik dengan booking online.', 1),
(2, 'Kopi Nusantara', 'Toko Online', 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800', '#', 'Toko online kopi lokal.', 2),
(3, 'Properti Jaya', 'Landing Page', 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800', '#', 'Landing page penjualan perumahan.', 3),
(4, 'Sekolah Cerdas', 'Company Profile', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800', '#', 'Website sekolah dan PPDB online.', 4),
(5, 'Fashion Kita', 'Toko Online', 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800', '#', 'Katalog fashion dengan checkout WA.', 5),
(6, 'Travel Bahagia', 'Landing Page', 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=800', '#', 'Landing page paket wisata.', 6);

INSERT IGNORE INTO `produk` (`id`, `nama`, `harga`, `fitur`, `populer`, `urutan`) VALUES
(1, 'Paket Starter', 750000, 'Landing page 1 halaman\nDomain .com 1 tahun\nHosting 1 GB\nSSL gratis\nTombol WhatsApp', 0, 1),
(2, 'Paket Bisnis', 1500000, 'Company profile 5 halaman\nDomain .com 1 tahun\nHosting 3 GB\nEmail bisnis\nSEO dasar\nRevisi 3x', 1, 2),
(3, 'Paket Toko Online', 2500000, 'Katalog produk unlimited\nKeranjang & checkout WA\nHosting 5 GB\nPanel admin\nSEO lanjutan\nGaransi 1 tahun', 0, 3);

INSERT IGNORE INTO `testimoni` (`id`, `nama`, `jabatan`, `foto`, `isi`, `rating`, `urutan`) VALUES
(1, 'Budi Santoso', 'Owner Kopi Nusantara', 'https://i.pravatar.cc/150?img=12', 'Websitenya cepat dan rapi, penjualan online naik drastis!', 5, 1),
(2, 'Siti Rahma', 'Manager Klinik Sehat', 'https://i.pravatar.cc/150?img=47', 'Pelayanan ramah, revisi cepat. Sangat direkomendasikan.', 5, 2),
(3, 'Andi Wijaya', 'CEO Properti Jaya', 'https://i.pravatar.cc/150?img=33', 'Landing page-nya menghasilkan banyak leads. Mantap!', 4, 3);

INSERT IGNORE INTO `faq` (`id`, `pertanyaan`, `jawaban`, `urutan`) VALUES
(1, 'Berapa lama proses pembuatan website?', 'Rata-rata 3–7 hari kerja tergantung paket dan kelengkapan materi.', 1),
(2, 'Apakah sudah termasuk domain dan hosting?', 'Ya, semua paket sudah termasuk domain dan hosting selama 1 tahun.', 2),
(3, 'Apakah bisa revisi?', 'Bisa, setiap paket mendapatkan jatah revisi sesuai ketentuan.', 3),
(4, 'Bagaimana cara pembayarannya?', 'DP 50% di awal dan pelunasan setelah website selesai.', 4);