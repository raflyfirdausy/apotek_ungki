/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : apotek_ungki

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 28/05/2022 03:47:52
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for m_admin
-- ----------------------------
DROP TABLE IF EXISTS `m_admin`;
CREATE TABLE `m_admin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_hp` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jenis_kelamin` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `level` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'ADMIN | KEPALA_APOTEK | KARYAWAN',
  `id_suplier` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_admin
-- ----------------------------
INSERT INTO `m_admin` VALUES (1, 'ungki', '74be16979710d4c4e7c6647856088456', 'UNGKI Kepala Apotek', '0857260965551', 'PEREMPUAN', 'KEPALA_APOTEK', NULL, 'Kepala Apotek', '2022-05-18 00:00:00', '2022-05-28 03:14:57', NULL);
INSERT INTO `m_admin` VALUES (2, 'rafly', 'f5bb0c8de146c67b44babbf4e6584cc0', 'RAFLY', '6285726096515', 'LAKI-LAKI', 'KEPALA_APOTEK', NULL, NULL, '2022-05-18 22:36:57', '2022-05-18 22:38:27', '2022-05-18 22:38:27');
INSERT INTO `m_admin` VALUES (3, 'karyawan_ungki', '4297f44b13955235245b2497399d7a93', 'Karyawan Ungki', '085726096515', 'LAKI-LAKI', 'KARYAWAN', NULL, NULL, '2022-05-18 22:40:47', '2022-05-19 23:31:52', '2022-05-19 23:31:52');
INSERT INTO `m_admin` VALUES (4, 'suplier_ungki', '4297f44b13955235245b2497399d7a93', 'Suplier Ungki', '6285726096515', 'LAKI-LAKI', 'SUPLIER', '3', NULL, '2022-05-19 00:58:31', NULL, NULL);
INSERT INTO `m_admin` VALUES (5, 'testing', 'f5bb0c8de146c67b44babbf4e6584cc0', 'OKE MANTAP', '123123123', 'LAKI-LAKI', 'SUPLIER', NULL, NULL, '2022-05-19 23:28:55', '2022-05-19 23:30:10', NULL);
INSERT INTO `m_admin` VALUES (6, 'rafff', '74be16979710d4c4e7c6647856088456', 'Rafff', '085726096515', 'LAKI-LAKI', 'SUPLIER', '4', NULL, '2022-05-25 00:45:46', '2022-05-25 00:52:41', NULL);
INSERT INTO `m_admin` VALUES (7, 'karyawan', 'f5bb0c8de146c67b44babbf4e6584cc0', 'Karyawan Contoh', '085726096515', 'LAKI-LAKI', 'KARYAWAN', NULL, NULL, '2022-05-28 01:31:12', NULL, NULL);
INSERT INTO `m_admin` VALUES (8, 'suplier', 'f5bb0c8de146c67b44babbf4e6584cc0', 'Suplier Contoh', '0857260965159', 'LAKI-LAKI', 'SUPLIER', '3', NULL, '2022-05-28 01:31:56', NULL, NULL);

-- ----------------------------
-- Table structure for m_identitas
-- ----------------------------
DROP TABLE IF EXISTS `m_identitas`;
CREATE TABLE `m_identitas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_aplikasi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_apotek` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sia_no` int(11) NULL DEFAULT NULL,
  `pemilik` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `apa` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sipa_no` int(11) NULL DEFAULT NULL,
  `prov` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kab` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kec` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kel` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telp` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `website` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_identitas
-- ----------------------------
INSERT INTO `m_identitas` VALUES (1, 'SiPotek', 'Apotek Ungki', -4951280, 'Ungki', 'Ungki, S.Farm, APT', 44212269, '33', '02', '123', '123', 'Klahang', '085726096515', 'ungki@gmail.com', 'ungki.com', 'logo.png', '2022-04-20 23:35:39', NULL, NULL);
INSERT INTO `m_identitas` VALUES (2, 'SiPotek', 'Apotek Ungki', 1234567, 'Ungki', NULL, NULL, 'Jawa Tengah', 'Banyumas', 'Sokaraja', 'Klahang', 'Klahang', '085726096515', 'ungki@gmail.com', 'ungki.com', 'logo_20220421161046.jpeg', '2022-04-21 16:10:46', NULL, NULL);
INSERT INTO `m_identitas` VALUES (3, 'SiPotek', 'Apotek Ungki', 1234567, 'Ungki', NULL, NULL, 'Jawa Tengah', 'Banyumas', 'Sokaraja', 'Klahang', 'Klahang', '085726096515', 'ungki@gmail.com', 'ungki.com', NULL, '2022-04-21 16:12:55', NULL, NULL);
INSERT INTO `m_identitas` VALUES (4, 'SiPotek', 'Apotek Ungki', 1234567, 'Ungki', NULL, NULL, 'Jawa Tengah', 'Banyumas', 'Sokaraja', 'Klahang', 'Klahang', '085726096515', 'ungki@gmail.com', 'ungki.com', NULL, '2022-04-21 16:15:55', NULL, NULL);
INSERT INTO `m_identitas` VALUES (5, 'SiPotek', 'Apotek Ungki', 1234567, 'Ungki', '', 0, 'Jawa Tengah', 'Banyumas', 'Sokaraja', 'Klahang', 'Klahang', '085726096515', 'ungki@gmail.com', 'ungki.com', 'logo_20220421161708.jpg', '2022-04-21 16:17:08', NULL, NULL);
INSERT INTO `m_identitas` VALUES (6, 'SiPotek', 'Apotek Ungki', 1234567, 'Ungki', '', 0, 'Jawa Tengah', 'Banyumas', 'Sokaraja', 'Klahang', 'Klahang', '085726096515', 'ungki@gmail.com', 'ungki.com', NULL, '2022-04-21 16:17:24', NULL, NULL);
INSERT INTO `m_identitas` VALUES (7, 'SiPotek', 'Apotek Ungki', 1234567, 'Ungki', '', 0, 'Jawa Tengah', 'Banyumas', 'Sokaraja', 'Klahang', 'Klahang', '085726096515', 'ungki@gmail.com', 'ungki.com', 'logo_20220421162032.png', '2022-04-21 16:20:32', NULL, NULL);
INSERT INTO `m_identitas` VALUES (8, 'SiPotek', 'Apotek Ungki', 1234567, 'Ungki', '', 0, 'Jawa Tengah', 'Banyumas', 'Sokaraja', 'Klahang', 'Klahang', '085726096515', 'ungki@gmail.com', 'ungki.com', 'logo_20220422132954.jpeg', '2022-04-22 13:29:54', NULL, NULL);
INSERT INTO `m_identitas` VALUES (9, 'SiPotek', 'Apotek Ungki', 1234567, 'Ungki', '', 0, 'Jawa Tengah', 'Banyumas', 'Sokaraja', 'Klahang', 'Klahang', '085726096515', 'ungki@gmail.com', 'ungki.com', 'logo_20220422133150.png', '2022-04-22 13:31:50', NULL, NULL);
INSERT INTO `m_identitas` VALUES (10, 'SiPotek', 'Apotek Ungki', 1234567, 'Ungki', '', 0, 'Jawa Tengah', 'Banyumas', 'Sokaraja', 'Klahang', 'Klahang', '085726096515', 'ungki@gmail.com', 'ungki.com', 'logo_20220517005529.png', '2022-05-17 00:55:29', NULL, NULL);
INSERT INTO `m_identitas` VALUES (11, 'SiPotek', 'Apotek Ungki', 1234567, 'Ungki', '', 0, 'Jawa Tengah', 'Banyumas', 'Sokaraja', 'Klahang', 'Klahang', '085726096515', 'ungki@gmail.com', 'ungki.com', 'logo_20220519221947.png', '2022-05-19 22:19:47', NULL, NULL);

-- ----------------------------
-- Table structure for m_obat
-- ----------------------------
DROP TABLE IF EXISTS `m_obat`;
CREATE TABLE `m_obat`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_golongan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_kategori` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_satuan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kode_obat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `min_stok` float NULL DEFAULT 0,
  `deskripsi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `indikasi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `kandungan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `dosis` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `kemasan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `efek_samping` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_obat
-- ----------------------------
INSERT INTO `m_obat` VALUES (1, '2', '2', '2', 'OBT2205230001', 'Bodrexin Tok', 10, 'Contoh Deskripsi', 'Contoh INdikasi', 'Contoh kandungan obat', 'Dosis obat', 'Contoh Bentuk / kemasan', 'Efek samping', '2022-05-23 21:28:22', '2022-05-27 22:38:06', NULL);
INSERT INTO `m_obat` VALUES (2, '2', '2', '2', 'OBT2205230002', 'Bodrexin Extra', 10, 'Contoh Deskripsi', 'Contoh INdikasi', 'Contoh kandungan obat', 'Dosis obat', 'Contoh Bentuk / kemasan', 'Efek samping', '2022-05-23 21:28:22', '2022-05-24 00:14:53', NULL);
INSERT INTO `m_obat` VALUES (3, '2', '2', '2', 'OBT2205230003', 'Mixagrip', 10, 'Deskripsi obat', 'infikasi', '', '', '', '', '2022-05-23 21:37:05', NULL, NULL);
INSERT INTO `m_obat` VALUES (4, '2', '2', '2', 'OBT2205230004', 'Ultraflu', 50, '', '', '', '', '', '', '2022-05-23 21:40:50', '2022-05-25 00:33:39', NULL);
INSERT INTO `m_obat` VALUES (5, '2', '2', '2', 'OBT2205230005', 'Paracetamol', 10, '', '', '', '', '', '', '2022-05-23 21:42:00', NULL, NULL);
INSERT INTO `m_obat` VALUES (6, '2', '3', '2', 'OBT2205230006', 'ParamexX', 1, 'dessX', 'indikasiX', 'kandunganX', 'dosisX', 'bentukX', 'efekX', '2022-05-23 23:51:19', '2022-05-26 12:16:23', NULL);
INSERT INTO `m_obat` VALUES (7, '3', '2', '3', 'OBT2205270001', 'Panadol', 50, '', '', '', '', '', '', '2022-05-27 02:49:23', '2022-05-27 02:49:58', NULL);

-- ----------------------------
-- Table structure for m_obat_golongan
-- ----------------------------
DROP TABLE IF EXISTS `m_obat_golongan`;
CREATE TABLE `m_obat_golongan`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_obat_golongan
-- ----------------------------
INSERT INTO `m_obat_golongan` VALUES (1, 'Testing Golongan', 'Contoh Keterangan', '2022-05-20 14:33:18', '2022-05-21 09:11:18', '2022-05-21 09:11:18');
INSERT INTO `m_obat_golongan` VALUES (2, 'Alergi', 'Contoh', '2022-05-21 09:05:56', '2022-05-21 09:10:02', NULL);
INSERT INTO `m_obat_golongan` VALUES (3, 'Golongan Lain', '', '2022-05-23 23:50:10', NULL, NULL);

-- ----------------------------
-- Table structure for m_obat_gudang
-- ----------------------------
DROP TABLE IF EXISTS `m_obat_gudang`;
CREATE TABLE `m_obat_gudang`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for m_obat_kategori
-- ----------------------------
DROP TABLE IF EXISTS `m_obat_kategori`;
CREATE TABLE `m_obat_kategori`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_obat_kategori
-- ----------------------------
INSERT INTO `m_obat_kategori` VALUES (1, 'Contoh KategoriX', 'Oke MantapX', '2022-05-21 09:25:45', '2022-05-21 09:25:56', '2022-05-21 09:25:56');
INSERT INTO `m_obat_kategori` VALUES (2, 'Contoh Kategori', 'Contoh Keterangan', '2022-05-23 21:18:20', NULL, NULL);
INSERT INTO `m_obat_kategori` VALUES (3, 'Kategori Lain', '', '2022-05-23 23:50:19', NULL, NULL);

-- ----------------------------
-- Table structure for m_obat_satuan
-- ----------------------------
DROP TABLE IF EXISTS `m_obat_satuan`;
CREATE TABLE `m_obat_satuan`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_obat_satuan
-- ----------------------------
INSERT INTO `m_obat_satuan` VALUES (1, 'Contoh SatuanX', 'Keterangan Contoh SatuanX', '2022-05-21 20:53:55', '2022-05-21 20:54:08', '2022-05-21 20:54:08');
INSERT INTO `m_obat_satuan` VALUES (2, 'Bungkus', 'Bungkus', '2022-05-21 20:54:45', NULL, NULL);
INSERT INTO `m_obat_satuan` VALUES (3, 'Satuan Lain', '', '2022-05-23 23:50:27', NULL, NULL);

-- ----------------------------
-- Table structure for m_obat_stok
-- ----------------------------
DROP TABLE IF EXISTS `m_obat_stok`;
CREATE TABLE `m_obat_stok`  (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_obat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `stok` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tgl_expired` date NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_obat_stok
-- ----------------------------
INSERT INTO `m_obat_stok` VALUES (1, '7', '200', '2022-07-01', '2022-05-27 03:23:45', '2022-05-27 23:18:04', NULL);
INSERT INTO `m_obat_stok` VALUES (2, '7', '100', '2022-05-27', '2022-05-27 03:35:11', '2022-05-27 23:18:04', NULL);
INSERT INTO `m_obat_stok` VALUES (3, '7', '300', '2022-08-17', '2022-05-27 03:35:33', '2022-05-27 23:18:04', NULL);
INSERT INTO `m_obat_stok` VALUES (4, '6', '100', '2022-09-21', '2022-05-27 03:49:53', '2022-05-27 23:18:27', NULL);
INSERT INTO `m_obat_stok` VALUES (5, '1', '1', '2022-06-08', '2022-05-28 03:04:36', NULL, NULL);
INSERT INTO `m_obat_stok` VALUES (6, '3', '2', '2022-06-09', '2022-05-28 03:04:36', NULL, NULL);
INSERT INTO `m_obat_stok` VALUES (7, '4', '303', '2022-06-11', '2022-05-28 03:04:36', '2022-05-28 03:13:57', NULL);
INSERT INTO `m_obat_stok` VALUES (8, '3', '200', '2022-06-23', '2022-05-28 03:13:57', NULL, NULL);
INSERT INTO `m_obat_stok` VALUES (9, '5', '100', '2022-06-18', '2022-05-28 03:13:57', NULL, NULL);

-- ----------------------------
-- Table structure for m_pelanggan
-- ----------------------------
DROP TABLE IF EXISTS `m_pelanggan`;
CREATE TABLE `m_pelanggan`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_hp` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `goldar` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jenis_kelamin` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tgl_lahir` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_prov` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_kab` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_kec` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_kel` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sta_perkawinan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pekerjaan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_ibu` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_ayah` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alergi_obat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for m_suplier
-- ----------------------------
DROP TABLE IF EXISTS `m_suplier`;
CREATE TABLE `m_suplier`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kota` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_telp` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_rek` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_bank` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_suplier
-- ----------------------------
INSERT INTO `m_suplier` VALUES (1, 'Coba EDIT', 'KLAHANG', 'Purwokerto Edit', '0000', '1260029399938882', 'BRI', '2022-05-19 22:55:11', '2022-05-21 09:10:52', '2022-05-21 09:10:52');
INSERT INTO `m_suplier` VALUES (2, 'RAFLI FIRDAUSY IRAWAN', 'Klahang RT 05/02 , kecamatan sokaraja, kab. Banyumas', 'Purwokerto', '08112666105', '1260029399938882', 'BRI', '2022-05-19 22:58:20', '2022-05-19 23:34:19', '2022-05-19 23:34:19');
INSERT INTO `m_suplier` VALUES (3, 'Suplier Rafly', 'KLAHANG', 'Purwokerto', '08112666105', '1260029399938882', 'BRI', '2022-05-19 22:59:12', '2022-05-26 15:09:40', NULL);
INSERT INTO `m_suplier` VALUES (4, 'Contoh Suplier', 'Alamat Contoh', 'Kota Contoh', '085726096515', '12312313', 'MANDIRI', '2022-05-20 13:29:15', NULL, NULL);
INSERT INTO `m_suplier` VALUES (5, 'UNGKI KEPALA APOTEKX', NULL, NULL, NULL, NULL, NULL, '2022-05-21 22:58:29', '2022-05-26 15:09:32', '2022-05-26 15:09:32');

-- ----------------------------
-- Table structure for tr_pemesanan
-- ----------------------------
DROP TABLE IF EXISTS `tr_pemesanan`;
CREATE TABLE `tr_pemesanan`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_admin` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_suplier` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_faktur` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tgl_faktur` date NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  `status_suplier` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'MENUNGGU' COMMENT 'MENUNGGU | DI_TERIMA | DI_TOLAK',
  `status_apotek` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'MENUNGGU | DI_TERIMA | KOMPLAIN | BATAL',
  `keterangan_suplier` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan_apotek` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan_pemesanan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tr_pemesanan
-- ----------------------------
INSERT INTO `tr_pemesanan` VALUES (5, '1', '4', 'FKTR2205260001', '2022-05-26', '2022-05-26 15:08:59', '2022-05-26 17:41:43', '2022-05-26 17:41:43', 'MENUNGGU', 'MENUNGGU', NULL, NULL, 'Testing');
INSERT INTO `tr_pemesanan` VALUES (6, '1', '4', 'FKTR2205260002', '2022-05-26', '2022-05-26 15:10:04', '2022-05-27 02:40:33', '2022-05-27 02:40:33', 'MENUNGGU', 'MENUNGGU', NULL, NULL, 'Yoi mantapX');
INSERT INTO `tr_pemesanan` VALUES (7, '1', '3', 'FKTR2205270001', '2022-05-27', '2022-05-27 02:40:55', '2022-05-28 03:04:36', NULL, 'DI_TERIMA', 'MENUNGGU', NULL, NULL, 'Testing aja');
INSERT INTO `tr_pemesanan` VALUES (8, '1', '3', 'FKTR2205280001', '2022-05-28', '2022-05-28 01:26:12', '2022-05-28 03:13:57', NULL, 'DI_TERIMA', 'MENUNGGU', NULL, NULL, 'Contoh Cataatan');
INSERT INTO `tr_pemesanan` VALUES (9, '1', '3', 'FKTR2205280002', '2022-05-28', '2022-05-28 03:16:11', '2022-05-28 03:30:20', NULL, 'DI_TOLAK', 'MENUNGGU', NULL, NULL, 'Contoh Pemesanan');
INSERT INTO `tr_pemesanan` VALUES (10, '1', '3', 'FKTR2205280003', '2022-05-28', '2022-05-28 03:43:28', NULL, NULL, 'MENUNGGU', 'MENUNGGU', NULL, NULL, '');

-- ----------------------------
-- Table structure for tr_pemesanan_detail
-- ----------------------------
DROP TABLE IF EXISTS `tr_pemesanan_detail`;
CREATE TABLE `tr_pemesanan_detail`  (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_pemesanan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_obat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `qty` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `catatan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `qty_acc` int(11) NULL DEFAULT NULL,
  `tgl_expired` date NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 37 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tr_pemesanan_detail
-- ----------------------------
INSERT INTO `tr_pemesanan_detail` VALUES (9, '5', '1', '100', 'Oke Mantap', NULL, NULL, '2022-05-26 15:08:59', '2022-05-26 17:41:43', '2022-05-26 17:41:43');
INSERT INTO `tr_pemesanan_detail` VALUES (10, '5', '3', '200', 'Bungkus', NULL, NULL, '2022-05-26 15:08:59', '2022-05-26 17:41:43', '2022-05-26 17:41:43');
INSERT INTO `tr_pemesanan_detail` VALUES (11, '5', '5', '500', 'Yang banyak', NULL, NULL, '2022-05-26 15:08:59', '2022-05-26 17:41:43', '2022-05-26 17:41:43');
INSERT INTO `tr_pemesanan_detail` VALUES (12, '6', '5', '100', 'Oke yoi', NULL, NULL, '2022-05-26 15:10:04', '2022-05-27 02:40:33', '2022-05-27 02:40:33');
INSERT INTO `tr_pemesanan_detail` VALUES (13, '6', '4', '500', 'Tambahan', NULL, NULL, '2022-05-26 15:10:04', '2022-05-27 02:40:33', '2022-05-27 02:40:33');
INSERT INTO `tr_pemesanan_detail` VALUES (14, '6', '5', '111', 'Oke yoi', NULL, NULL, '2022-05-27 02:39:39', '2022-05-27 02:40:33', '2022-05-27 02:40:33');
INSERT INTO `tr_pemesanan_detail` VALUES (15, '6', '4', '222', 'Tambahan', NULL, NULL, '2022-05-27 02:39:39', '2022-05-27 02:40:33', '2022-05-27 02:40:33');
INSERT INTO `tr_pemesanan_detail` VALUES (16, '6', '6', '999', '', NULL, NULL, '2022-05-27 02:39:39', '2022-05-27 02:40:33', '2022-05-27 02:40:33');
INSERT INTO `tr_pemesanan_detail` VALUES (17, '7', '1', '10', 'Mantap', NULL, NULL, '2022-05-27 02:40:55', '2022-05-27 22:44:40', '2022-05-27 22:44:40');
INSERT INTO `tr_pemesanan_detail` VALUES (18, '7', '3', '11', 'Yoi', NULL, NULL, '2022-05-27 02:40:55', '2022-05-27 22:44:40', '2022-05-27 22:44:40');
INSERT INTO `tr_pemesanan_detail` VALUES (19, '7', '1', '10', 'Mantap', 1, '2022-06-08', '2022-05-27 22:44:40', '2022-05-28 03:04:36', NULL);
INSERT INTO `tr_pemesanan_detail` VALUES (20, '7', '3', '11', 'Yoi', 2, '2022-06-09', '2022-05-27 22:44:40', '2022-05-28 03:04:36', NULL);
INSERT INTO `tr_pemesanan_detail` VALUES (21, '7', '4', '12', 'mantap', 3, '2022-06-11', '2022-05-27 22:44:40', '2022-05-28 03:04:36', NULL);
INSERT INTO `tr_pemesanan_detail` VALUES (22, '8', '4', '10', 'Oke Mantap', NULL, NULL, '2022-05-28 01:26:12', '2022-05-28 03:08:00', '2022-05-28 03:08:00');
INSERT INTO `tr_pemesanan_detail` VALUES (23, '8', '4', '10', 'Oke Mantap', NULL, NULL, '2022-05-28 01:26:30', '2022-05-28 03:08:00', '2022-05-28 03:08:00');
INSERT INTO `tr_pemesanan_detail` VALUES (24, '8', '3', '200', '', NULL, NULL, '2022-05-28 01:26:30', '2022-05-28 03:08:00', '2022-05-28 03:08:00');
INSERT INTO `tr_pemesanan_detail` VALUES (25, '8', '5', '300', '', NULL, NULL, '2022-05-28 01:26:30', '2022-05-28 03:08:00', '2022-05-28 03:08:00');
INSERT INTO `tr_pemesanan_detail` VALUES (26, '8', '4', '10', 'Oke Mantap', NULL, NULL, '2022-05-28 02:28:20', '2022-05-28 03:08:00', '2022-05-28 03:08:00');
INSERT INTO `tr_pemesanan_detail` VALUES (27, '8', '3', '200', '', NULL, NULL, '2022-05-28 02:28:20', '2022-05-28 03:08:00', '2022-05-28 03:08:00');
INSERT INTO `tr_pemesanan_detail` VALUES (28, '8', '5', '300', '', NULL, NULL, '2022-05-28 02:28:20', '2022-05-28 03:08:00', '2022-05-28 03:08:00');
INSERT INTO `tr_pemesanan_detail` VALUES (29, '8', '4', '10', 'Oke Mantap', 300, '2022-06-11', '2022-05-28 03:08:00', '2022-05-28 03:13:57', NULL);
INSERT INTO `tr_pemesanan_detail` VALUES (30, '8', '3', '200', '', 200, '2022-06-23', '2022-05-28 03:08:00', '2022-05-28 03:13:57', NULL);
INSERT INTO `tr_pemesanan_detail` VALUES (31, '8', '5', '300', '', 100, '2022-06-18', '2022-05-28 03:08:00', '2022-05-28 03:13:57', NULL);
INSERT INTO `tr_pemesanan_detail` VALUES (32, '9', '4', '100', 'Oke', 0, '2022-05-28', '2022-05-28 03:16:11', '2022-05-28 03:30:20', NULL);
INSERT INTO `tr_pemesanan_detail` VALUES (33, '9', '2', '200', 'Mantap', 0, '2022-05-28', '2022-05-28 03:16:11', '2022-05-28 03:30:20', NULL);
INSERT INTO `tr_pemesanan_detail` VALUES (34, '9', '7', '300', 'Yoi', 0, '2022-05-28', '2022-05-28 03:16:11', '2022-05-28 03:30:20', NULL);
INSERT INTO `tr_pemesanan_detail` VALUES (35, '9', '1', '500', 'Yaa', 0, '2022-05-28', '2022-05-28 03:16:11', '2022-05-28 03:30:20', NULL);
INSERT INTO `tr_pemesanan_detail` VALUES (36, '10', '6', '1', 'oke', NULL, NULL, '2022-05-28 03:43:28', NULL, NULL);

-- ----------------------------
-- Table structure for tr_penjualan
-- ----------------------------
DROP TABLE IF EXISTS `tr_penjualan`;
CREATE TABLE `tr_penjualan`  (
  `id` int(11) NOT NULL,
  `id_admin` date NULL DEFAULT NULL,
  `id_pembeli` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `waktu` datetime(0) NULL DEFAULT NULL,
  `no_resep` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `cash` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'PROSES' COMMENT 'PROSES | PENDING | SELESAI',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tr_penjualan_detail
-- ----------------------------
DROP TABLE IF EXISTS `tr_penjualan_detail`;
CREATE TABLE `tr_penjualan_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_admin` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_transaksi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_obat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `satuan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `harga` int(11) NULL DEFAULT NULL,
  `jumlah` float NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tr_transaksi_obat
-- ----------------------------
DROP TABLE IF EXISTS `tr_transaksi_obat`;
CREATE TABLE `tr_transaksi_obat`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_admin` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_obat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_stok` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tanggal` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `stok_awal` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `stok_akhir` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jenis` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'STOK OPNAME | OBAT MASUK | OBAT KELUAR',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tr_transaksi_obat
-- ----------------------------
INSERT INTO `tr_transaksi_obat` VALUES (1, '1', '4', NULL, '2022-05-25', '100', '200', 'Oke Mantap', 'STOCK OPNAME', '2022-05-25 00:33:39', NULL, '2022-05-27 03:24:07');
INSERT INTO `tr_transaksi_obat` VALUES (2, '1', '6', NULL, '2022-05-25', '500', '400', 'Testing', 'STOCK OPNAME', '2022-05-25 00:35:44', NULL, '2022-05-27 03:24:07');
INSERT INTO `tr_transaksi_obat` VALUES (3, '1', '6', NULL, '2022-05-25', '400', '300', 'Testing yagesya', 'STOCK OPNAME', '2022-05-25 00:36:09', NULL, '2022-05-27 03:24:07');
INSERT INTO `tr_transaksi_obat` VALUES (4, '1', '6', NULL, '2022-05-26', '300', '100', 'Percobaan', 'STOCK OPNAME', '2022-05-26 12:16:23', NULL, '2022-05-27 03:24:07');
INSERT INTO `tr_transaksi_obat` VALUES (5, '1', '7', '1', '2022-05-27', '0', '100', 'Penambahan stok obat secara manual', 'TAMBAH STOK', '2022-05-27 03:23:45', NULL, NULL);
INSERT INTO `tr_transaksi_obat` VALUES (6, '1', '7', '1', '2022-05-27', '100', '150', 'Penambahan stok obat secara manual', 'TAMBAH STOK', '2022-05-27 03:26:20', NULL, NULL);
INSERT INTO `tr_transaksi_obat` VALUES (7, '1', '7', '2', '2022-05-27', '0', '300', 'Penambahan stok obat secara manual', 'TAMBAH STOK', '2022-05-27 03:35:11', NULL, NULL);
INSERT INTO `tr_transaksi_obat` VALUES (8, '1', '7', '3', '2022-05-27', '0', '600', 'Penambahan stok obat secara manual', 'TAMBAH STOK', '2022-05-27 03:35:33', NULL, NULL);
INSERT INTO `tr_transaksi_obat` VALUES (9, '1', '6', '4', '2022-05-27', '0', '50', 'Penambahan stok obat secara manual', 'TAMBAH STOK', '2022-05-27 03:49:53', NULL, NULL);
INSERT INTO `tr_transaksi_obat` VALUES (10, '1', '7', NULL, '2022-05-27', '300', '100', 'Perubahan stok dari 300 menjadi 100', 'STOCK OPNAME', '2022-05-27 23:18:04', NULL, NULL);
INSERT INTO `tr_transaksi_obat` VALUES (11, '1', '7', NULL, '2022-05-27', '150', '200', 'Perubahan stok dari 150 menjadi 200', 'STOCK OPNAME', '2022-05-27 23:18:04', NULL, NULL);
INSERT INTO `tr_transaksi_obat` VALUES (12, '1', '7', NULL, '2022-05-27', '600', '300', 'Perubahan stok dari 600 menjadi 300', 'STOCK OPNAME', '2022-05-27 23:18:04', NULL, NULL);
INSERT INTO `tr_transaksi_obat` VALUES (13, '1', '6', NULL, '2022-05-27', '50', '100', 'Perubahan stok dari 50 menjadi 100', 'STOCK OPNAME', '2022-05-27 23:18:27', NULL, NULL);
INSERT INTO `tr_transaksi_obat` VALUES (14, '8', '1', NULL, '2022-05-28', NULL, '1', 'Penambahan stok obat oleh suplier', 'TAMBAH BY PO', '2022-05-28 03:04:36', NULL, NULL);
INSERT INTO `tr_transaksi_obat` VALUES (15, '8', '3', NULL, '2022-05-28', NULL, '2', 'Penambahan stok obat oleh suplier', 'TAMBAH BY PO', '2022-05-28 03:04:36', NULL, NULL);
INSERT INTO `tr_transaksi_obat` VALUES (16, '8', '4', NULL, '2022-05-28', NULL, '3', 'Penambahan stok obat oleh suplier', 'TAMBAH BY PO', '2022-05-28 03:04:36', NULL, NULL);
INSERT INTO `tr_transaksi_obat` VALUES (17, '8', '4', '7', '2022-05-28', '3', '303', 'Penambahan stok obat oleh suplier', 'TAMBAH BY PO', '2022-05-28 03:13:57', NULL, NULL);
INSERT INTO `tr_transaksi_obat` VALUES (18, '8', '3', NULL, '2022-05-28', NULL, '200', 'Penambahan stok obat oleh suplier', 'TAMBAH BY PO', '2022-05-28 03:13:57', NULL, NULL);
INSERT INTO `tr_transaksi_obat` VALUES (19, '8', '5', NULL, '2022-05-28', NULL, '100', 'Penambahan stok obat oleh suplier', 'TAMBAH BY PO', '2022-05-28 03:13:57', NULL, NULL);

-- ----------------------------
-- View structure for v_admin
-- ----------------------------
DROP VIEW IF EXISTS `v_admin`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_admin` AS SELECT
	m_admin.* ,
	m_suplier.nama as nama_suplier
FROM
	m_admin
	LEFT JOIN m_suplier ON m_admin.id_suplier = m_suplier.id ;

-- ----------------------------
-- View structure for v_obat
-- ----------------------------
DROP VIEW IF EXISTS `v_obat`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_obat` AS SELECT
	m_obat.id,
	m_obat.kode_obat,
	m_obat.nama,
	( CASE WHEN v_stok_total.stok IS NULL THEN 0 ELSE v_stok_total.stok END ) AS stok,
	m_obat.id_satuan,
	m_obat.id_golongan,
	m_obat.id_kategori,
	m_obat_golongan.nama AS nama_golongan,
	m_obat_kategori.nama AS nama_kategori,
	m_obat_satuan.nama AS nama_satuan,
	m_obat.min_stok,
	m_obat.deskripsi,
	m_obat.indikasi,
	m_obat.kandungan,
	m_obat.dosis,
	m_obat.kemasan,
	m_obat.efek_samping,
	m_obat.created_at 
FROM
	m_obat
	LEFT JOIN m_obat_golongan ON m_obat_golongan.id = m_obat.id_golongan
	LEFT JOIN m_obat_kategori ON m_obat_kategori.id = m_obat.id_kategori
	LEFT JOIN m_obat_satuan ON m_obat_satuan.id = m_obat.id_satuan
	LEFT JOIN v_stok_total ON v_stok_total.id_obat = m_obat.id 
WHERE
	m_obat.deleted_at IS NULL ;

-- ----------------------------
-- View structure for v_pemesanan
-- ----------------------------
DROP VIEW IF EXISTS `v_pemesanan`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_pemesanan` AS SELECT
	tr_pemesanan.*,
	m_admin.nama as nama_admin,
	m_suplier.nama as nama_suplier,
	v_total_pemesanan_obat.total_obat as total_obat
FROM
	tr_pemesanan
	LEFT JOIN m_admin ON m_admin.id = tr_pemesanan.id_admin
	LEFT JOIN m_suplier ON m_suplier.id = tr_pemesanan.id_suplier
	LEFT JOIN v_total_pemesanan_obat ON v_total_pemesanan_obat.id_pemesanan = tr_pemesanan.id ;

-- ----------------------------
-- View structure for v_pemesanan_detail
-- ----------------------------
DROP VIEW IF EXISTS `v_pemesanan_detail`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_pemesanan_detail` AS SELECT
	tr_pemesanan_detail.id,
	tr_pemesanan_detail.id_pemesanan,
	tr_pemesanan.no_faktur as no_faktur,
	tr_pemesanan_detail.id_obat,
	m_obat.nama as nama_obat,
	tr_pemesanan_detail.qty,
	tr_pemesanan_detail.qty_acc,
	tr_pemesanan_detail.catatan,
	v_total_pemesanan_obat.total_obat as total_obat,	
	tr_pemesanan_detail.tgl_expired,
	tr_pemesanan_detail.created_at,
	tr_pemesanan_detail.updated_at,
	tr_pemesanan_detail.deleted_at
FROM
	tr_pemesanan_detail
	LEFT JOIN m_obat ON m_obat.id = tr_pemesanan_detail.id_obat
	LEFT JOIN tr_pemesanan ON tr_pemesanan.id = tr_pemesanan_detail.id_pemesanan
	LEFT JOIN v_total_pemesanan_obat ON v_total_pemesanan_obat.id_pemesanan = tr_pemesanan_detail.id_pemesanan ;

-- ----------------------------
-- View structure for v_stok_obat
-- ----------------------------
DROP VIEW IF EXISTS `v_stok_obat`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_stok_obat` AS SELECT
	 m_obat_stok.id,
	 m_obat_stok.id_obat,
	 m_obat.nama as nama_obat,
	 m_obat_stok.stok,
	 m_obat.id_satuan as id_satuan,
	 m_obat_satuan.nama as nama_satuan,
	 m_obat_stok.tgl_expired,
	 m_obat_stok.created_at,
	 m_obat_stok.updated_at,
	 m_obat_stok.deleted_at
FROM
	m_obat_stok
	LEFT JOIN m_obat ON m_obat.id = m_obat_stok.id_obat
	LEFT JOIN m_obat_satuan ON m_obat_satuan.id = m_obat.id_satuan ;

-- ----------------------------
-- View structure for v_stok_total
-- ----------------------------
DROP VIEW IF EXISTS `v_stok_total`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_stok_total` AS SELECT
	id_obat,
	SUM( stok ) AS stok 
FROM
	m_obat_stok
	WHERE m_obat_stok.deleted_at IS NULL
	GROUP BY id_obat ;

-- ----------------------------
-- View structure for v_total_pemesanan_obat
-- ----------------------------
DROP VIEW IF EXISTS `v_total_pemesanan_obat`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_total_pemesanan_obat` AS SELECT 
	id_pemesanan,
	COUNT(id_obat) as total_obat
FROM
	tr_pemesanan_detail
	WHERE tr_pemesanan_detail.deleted_at IS NULL
	GROUP BY id_pemesanan ;

SET FOREIGN_KEY_CHECKS = 1;
