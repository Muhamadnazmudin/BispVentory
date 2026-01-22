-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 22 Jan 2026 pada 16.05
-- Versi server: 5.7.33
-- Versi PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `bispventory`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(50) DEFAULT NULL,
  `nama_barang` varchar(150) NOT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `id_kategori` int(11) NOT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `kode_barang`, `nama_barang`, `merk`, `id_kategori`, `satuan`, `keterangan`, `created_at`) VALUES
(2, '001', 'Kertas HVS 75 rim', 'SIDU', 1, 'Rim', 'atk', '2026-01-21 07:56:45'),
(3, '002', 'lem kertas', 'Glukol', 1, 'pcs', '', '2026-01-21 08:05:33'),
(4, '003', 'Ballpoint', 'Standar', 1, 'pcs', '', '2026-01-21 08:52:31'),
(5, '004', 'staples kecil', 'etona', 1, 'kotak', 'kotak kecil', '2026-01-22 14:32:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_keluar` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `pemohon` enum('guru','siswa') DEFAULT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `keterangan` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_keluar`, `id_barang`, `tanggal`, `jumlah`, `pemohon`, `id_guru`, `id_siswa`, `keterangan`, `created_at`) VALUES
(3, 4, '2026-01-22', 5, 'guru', 1, NULL, 'Realisasi permohonan ID 6', '2026-01-22 22:48:27'),
(4, 2, '2026-01-22', 15, 'guru', 1, NULL, 'Realisasi permohonan ID 6', '2026-01-22 22:48:27'),
(5, 3, '2026-01-22', 10, 'guru', 1, NULL, 'untuk pembelajarna lainnya', '2026-01-22 22:48:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_masuk` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `toko` varchar(150) DEFAULT NULL,
  `perolehan` enum('BOSP','BOPD') DEFAULT 'BOSP',
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_masuk`, `tanggal`, `id_barang`, `jumlah`, `satuan`, `toko`, `perolehan`, `keterangan`, `created_at`) VALUES
(1, '2026-01-21', 2, 10, 'Rim', 'indotar', 'BOSP', NULL, '2026-01-21 07:58:25'),
(2, '2026-01-20', 2, 20, 'Rim', 'mona', 'BOSP', NULL, '2026-01-21 08:01:17'),
(3, '2026-01-21', 3, 10, 'pcs', 'indotar', 'BOSP', NULL, '2026-01-21 08:05:49'),
(4, '2026-01-19', 3, 15, 'pcs', 'indotar', 'BOSP', NULL, '2026-01-21 08:06:07'),
(5, '2026-01-21', 4, 10, 'pcs', 'indotar', 'BOSP', NULL, '2026-01-21 08:53:09'),
(6, '2026-01-22', 5, 20, 'kotak', 'indotar', 'BOSP', NULL, '2026-01-22 14:32:26'),
(7, '2026-01-08', 4, 10, 'pcs', 'indotama', 'BOSP', NULL, '2026-01-22 15:20:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_ruangan`
--

CREATE TABLE `barang_ruangan` (
  `id_barang_ruangan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_ruangan` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pengajuan`
--

CREATE TABLE `detail_pengajuan` (
  `id_detail` int(11) NOT NULL,
  `id_pengajuan` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `nama_guru` varchar(150) NOT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id_guru`, `nip`, `nama_guru`, `jabatan`, `no_hp`, `created_at`) VALUES
(1, '199408282022211006', 'Muhamad Hendi Guntara', 'PBJ', NULL, '2026-01-21 08:20:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_barang`
--

CREATE TABLE `kategori_barang` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori_barang`
--

INSERT INTO `kategori_barang` (`id_kategori`, `nama_kategori`, `keterangan`, `created_at`) VALUES
(1, 'Alat Tulis Kantor', 'Ateka', '2026-01-21 07:23:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_barang`
--

CREATE TABLE `pengajuan_barang` (
  `id_pengajuan` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `pemohon` enum('guru','siswa') DEFAULT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `permohonan`
--

CREATE TABLE `permohonan` (
  `id_permohonan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `pemohon` enum('guru','siswa') NOT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `permohonan`
--

INSERT INTO `permohonan` (`id_permohonan`, `tanggal`, `pemohon`, `id_guru`, `id_siswa`, `status`, `keterangan`, `created_at`) VALUES
(5, '2026-01-20', 'guru', 1, NULL, 'ditolak', 'untuk pembelajaran', '2026-01-22 14:59:18'),
(6, '2026-01-20', 'guru', 1, NULL, 'disetujui', 'untuk pembelajaran', '2026-01-22 15:00:47'),
(7, '2026-01-21', 'guru', 1, NULL, 'disetujui', 'untuk pembelajarna lainnya', '2026-01-22 15:08:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permohonan_detail`
--

CREATE TABLE `permohonan_detail` (
  `id_detail` int(11) NOT NULL,
  `id_permohonan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `permohonan_detail`
--

INSERT INTO `permohonan_detail` (`id_detail`, `id_permohonan`, `id_barang`, `jumlah`) VALUES
(7, 5, 4, 5),
(8, 5, 2, 15),
(9, 5, 3, 10),
(10, 5, 5, 10),
(11, 6, 4, 5),
(12, 6, 2, 15),
(13, 7, 3, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `nama_ruangan` varchar(100) NOT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `nama_siswa` varchar(150) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `role` enum('admin','guru','siswa') DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$nk64qHM.ZhgT85k1Gy83XOwY/cqCZnBgagdOVqGm.E/jKw.bKbkLG', 'Administrator', 'admin', '2026-01-21 05:32:39');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_keluar`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_masuk`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `barang_ruangan`
--
ALTER TABLE `barang_ruangan`
  ADD PRIMARY KEY (`id_barang_ruangan`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_ruangan` (`id_ruangan`);

--
-- Indeks untuk tabel `detail_pengajuan`
--
ALTER TABLE `detail_pengajuan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pengajuan` (`id_pengajuan`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indeks untuk tabel `kategori_barang`
--
ALTER TABLE `kategori_barang`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `pengajuan_barang`
--
ALTER TABLE `pengajuan_barang`
  ADD PRIMARY KEY (`id_pengajuan`);

--
-- Indeks untuk tabel `permohonan`
--
ALTER TABLE `permohonan`
  ADD PRIMARY KEY (`id_permohonan`);

--
-- Indeks untuk tabel `permohonan_detail`
--
ALTER TABLE `permohonan_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_permohonan` (`id_permohonan`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `barang_ruangan`
--
ALTER TABLE `barang_ruangan`
  MODIFY `id_barang_ruangan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_pengajuan`
--
ALTER TABLE `detail_pengajuan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kategori_barang`
--
ALTER TABLE `kategori_barang`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_barang`
--
ALTER TABLE `pengajuan_barang`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `permohonan`
--
ALTER TABLE `permohonan`
  MODIFY `id_permohonan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `permohonan_detail`
--
ALTER TABLE `permohonan_detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_barang` (`id_kategori`);

--
-- Ketidakleluasaan untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);

--
-- Ketidakleluasaan untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);

--
-- Ketidakleluasaan untuk tabel `barang_ruangan`
--
ALTER TABLE `barang_ruangan`
  ADD CONSTRAINT `barang_ruangan_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `barang_ruangan_ibfk_2` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`);

--
-- Ketidakleluasaan untuk tabel `detail_pengajuan`
--
ALTER TABLE `detail_pengajuan`
  ADD CONSTRAINT `detail_pengajuan_ibfk_1` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan_barang` (`id_pengajuan`),
  ADD CONSTRAINT `detail_pengajuan_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);

--
-- Ketidakleluasaan untuk tabel `permohonan_detail`
--
ALTER TABLE `permohonan_detail`
  ADD CONSTRAINT `permohonan_detail_ibfk_1` FOREIGN KEY (`id_permohonan`) REFERENCES `permohonan` (`id_permohonan`),
  ADD CONSTRAINT `permohonan_detail_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
