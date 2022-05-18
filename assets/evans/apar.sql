/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : apar

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 24/01/2022 21:48:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for m_admin
-- ----------------------------
DROP TABLE IF EXISTS `m_admin`;
CREATE TABLE `m_admin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `level` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'SUPER_ADMIN | ADMIN',
  `no_hp` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_admin
-- ----------------------------
INSERT INTO `m_admin` VALUES (1, 'ella@gmail.com', 'e14678ed4409fd7dec4d9999669f5b51', 'Ella Wulandari', 'SUPER_ADMIN', '085726096515', 'Admin Super', '2022-01-22 16:23:23', NULL, NULL);
INSERT INTO `m_admin` VALUES (2, 'rafly.firdausy@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'RAFLI FIRDAUSY IRAWAN', 'SUPER_ADMIN', '6285726096515', 'TEs', '2022-01-22 18:16:49', '2022-01-22 19:47:58', NULL);
INSERT INTO `m_admin` VALUES (3, 'rafly@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'RAFLI FIRDAUSY IRAWAN', 'SUPER_ADMIN', '6285726096515', 'Contoh Keterangan', '2022-01-22 18:23:07', NULL, NULL);
INSERT INTO `m_admin` VALUES (4, 'dida@gmail.com', '894c925e9616baf4484f6fccbf9013c0', 'Ervina Nadia Salsabila', 'SUPER_ADMIN', '0857260965159', 'Testing Edit', '2022-01-22 18:25:06', '2022-01-22 19:47:51', NULL);
INSERT INTO `m_admin` VALUES (5, 'region@gmail.com', '74be16979710d4c4e7c6647856088456', 'Region AdminX', 'SUPER_ADMIN', '0857260965150', 'Contoh KeteranganXX', '2022-01-22 20:11:52', '2022-01-22 20:19:57', NULL);

-- ----------------------------
-- Table structure for m_jenis_apar
-- ----------------------------
DROP TABLE IF EXISTS `m_jenis_apar`;
CREATE TABLE `m_jenis_apar`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_jenis_apar
-- ----------------------------
INSERT INTO `m_jenis_apar` VALUES (1, 'Powder', 'Keterangan 1', '2022-01-23 21:55:51', NULL, NULL);
INSERT INTO `m_jenis_apar` VALUES (2, 'Foam', 'Keterangan 2', '2022-01-23 21:55:54', NULL, NULL);
INSERT INTO `m_jenis_apar` VALUES (3, 'CO2', 'Keterangan 3', '2022-01-23 21:55:57', '2022-01-24 00:06:30', NULL);
INSERT INTO `m_jenis_apar` VALUES (4, 'JENIS APAR BARU YA GES YA', 'TESTING AJA', '2022-01-24 00:06:43', '2022-01-24 00:06:51', '2022-01-24 00:06:51');

-- ----------------------------
-- Table structure for m_perusahaan
-- ----------------------------
DROP TABLE IF EXISTS `m_perusahaan`;
CREATE TABLE `m_perusahaan`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_region` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_perusahaan
-- ----------------------------
INSERT INTO `m_perusahaan` VALUES (1, '1', 'PTTJA', 'Contoh Keterangan', '2022-01-23 15:26:21', NULL, NULL);
INSERT INTO `m_perusahaan` VALUES (2, '2', 'Perusahaan Yoi', 'Hehehe', '2022-01-23 15:36:52', '2022-01-23 15:40:54', '2022-01-23 15:40:54');
INSERT INTO `m_perusahaan` VALUES (3, '2', 'Perusahaan Lain', 'Yoi', '2022-01-23 16:14:44', NULL, NULL);

-- ----------------------------
-- Table structure for m_region
-- ----------------------------
DROP TABLE IF EXISTS `m_region`;
CREATE TABLE `m_region`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_region
-- ----------------------------
INSERT INTO `m_region` VALUES (1, 'Kota Bangun', 'Contoh Keterangan', '2022-01-22 20:07:32', NULL, NULL);
INSERT INTO `m_region` VALUES (2, 'Region Yoi', 'YA GAES YA', '2022-01-22 20:12:57', '2022-01-22 20:21:57', NULL);
INSERT INTO `m_region` VALUES (3, 'Region Baru TestingX', 'Oke MantapX', '2022-01-22 20:22:20', '2022-01-22 20:22:35', '2022-01-22 20:22:35');
INSERT INTO `m_region` VALUES (4, 'Tes RegionX', 'Tes keteranganX', '2022-01-23 15:21:09', '2022-01-23 15:21:20', '2022-01-23 15:21:20');

-- ----------------------------
-- Table structure for m_unit
-- ----------------------------
DROP TABLE IF EXISTS `m_unit`;
CREATE TABLE `m_unit`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_region` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_perusahaan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_unit
-- ----------------------------
INSERT INTO `m_unit` VALUES (1, '1', '1', 'RHM', 'Contoh Keterangan', '2022-01-23 15:44:05', NULL, NULL);
INSERT INTO `m_unit` VALUES (2, '1', '1', 'Unit Baru', 'Yoi', '2022-01-23 16:10:39', NULL, NULL);
INSERT INTO `m_unit` VALUES (3, '2', '3', 'MANTAP', 'SELESAI MASTER', '2022-01-23 16:14:57', '2022-01-23 16:17:09', NULL);

-- ----------------------------
-- Table structure for tr_apar
-- ----------------------------
DROP TABLE IF EXISTS `tr_apar`;
CREATE TABLE `tr_apar`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_region` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_perusahaan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_unit` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `lokasi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kode_apar` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_jenis_apar` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `berat_apar` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `handle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pressure` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pin` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `selang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tabung` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `posisi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `segitiga` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `label` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `berat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `powder` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pengisian_terakhir` date NULL DEFAULT NULL,
  `pengisian_berikutnya` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tr_apar
-- ----------------------------
INSERT INTO `tr_apar` VALUES (1, '1', '1', '1', '2022-01-23', 'Contoh Lokasi', 'ABC1234', '1', '6', 'v', 'v', 'v', 'v', 'v', 'v', 'v', 'v', 'v', 'v', '2022-01-27', '2022-01-29', 'OKE MANTAP', '2022-01-23 23:49:17', NULL, NULL);
INSERT INTO `tr_apar` VALUES (2, '1', '1', '1', '2022-01-24', 'Lokasi Lain', 'ABC1234', '2', '6', 'v', 'x', 'x', 'v', 'x', 'v', 'x', 'v', 'x', 'x', '2022-01-19', '2022-02-04', 'Percobaan', '2022-01-23 23:50:03', NULL, NULL);
INSERT INTO `tr_apar` VALUES (3, '2', '3', '3', '2022-01-24', 'Rumah Saya', 'WXYZ', '3', '6', 'v', 'v', 'x', 'x', 'v', 'x', 'x', 'x', 'x', 'v', '2022-01-20', '2022-01-27', 'OKE MANTAP', '2022-01-23 23:52:11', NULL, NULL);
INSERT INTO `tr_apar` VALUES (4, '1', '1', '1', '2022-01-23', 'Oke Mantap', 'ABC1234', '2', '9', 'x', 'v', 'x', 'v', 'v', 'v', 'v', 'v', 'v', 'v', '2022-01-03', '2022-01-31', 'oke', '2022-01-23 23:54:03', NULL, NULL);

-- ----------------------------
-- View structure for vtr_apar
-- ----------------------------
DROP VIEW IF EXISTS `vtr_apar`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vtr_apar` AS SELECT
	tr_apar.id,
	tr_apar.id_region,
	m_region.nama as nama_region,
	tr_apar.id_perusahaan,
	m_perusahaan.nama as nama_perusahaan,
	tr_apar.id_unit,
	m_unit.nama as nama_unit,
	tr_apar.tanggal,
	tr_apar.lokasi,
	tr_apar.kode_apar,
	tr_apar.id_jenis_apar,
	m_jenis_apar.nama as nama_jenis_apar,
	tr_apar.berat_apar,
	tr_apar.handle,
	tr_apar.pressure,
	tr_apar.pin,
	tr_apar.selang,
	tr_apar.tabung,
	tr_apar.posisi,
	tr_apar.segitiga,
	tr_apar.label,
	tr_apar.berat,
	tr_apar.powder,
	tr_apar.pengisian_terakhir,
	tr_apar.pengisian_berikutnya,
	tr_apar.keterangan
FROM
	tr_apar
	INNER JOIN m_region ON m_region.id = tr_apar.id_region
	INNER JOIN m_perusahaan ON m_perusahaan.id = tr_apar.id_perusahaan
	INNER JOIN m_unit ON m_unit.id = tr_apar.id_unit
	INNER JOIN m_jenis_apar ON m_jenis_apar.id = tr_apar.id_jenis_apar ;

-- ----------------------------
-- View structure for v_perusahaan
-- ----------------------------
DROP VIEW IF EXISTS `v_perusahaan`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_perusahaan` AS SELECT
	m_perusahaan.id,
	m_perusahaan.id_region,
	m_region.nama as nama_region,
	m_perusahaan.nama,
	m_perusahaan.keterangan,
	m_perusahaan.created_at,
	m_perusahaan.updated_at,
	m_perusahaan.deleted_at
FROM
	m_perusahaan
	LEFT JOIN m_region ON m_region.id = m_perusahaan.id_region ;

-- ----------------------------
-- View structure for v_unit
-- ----------------------------
DROP VIEW IF EXISTS `v_unit`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_unit` AS SELECT
	m_unit.id,
	m_unit.id_region,
	m_region.nama as nama_region,
	m_unit.id_perusahaan,
	m_perusahaan.nama as nama_perusahaan,
	m_unit.nama,
	m_unit.keterangan,
	m_unit.created_at,
	m_unit.updated_at,
	m_unit.deleted_at
FROM
	m_unit
	INNER JOIN m_region ON m_region.id = m_unit.id_region
	INNER JOIN m_perusahaan ON m_perusahaan.id = m_unit.id_perusahaan ;

SET FOREIGN_KEY_CHECKS = 1;
