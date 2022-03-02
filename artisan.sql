/*
 Navicat Premium Data Transfer

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : artisan

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 02/03/2022 16:17:50
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tbl_keranjang
-- ----------------------------
DROP TABLE IF EXISTS `tbl_keranjang`;
CREATE TABLE `tbl_keranjang`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_users` int NULL DEFAULT NULL,
  `id_produk` int NULL DEFAULT NULL,
  `invoice` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '-',
  `jumlah` int NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_keranjang
-- ----------------------------
INSERT INTO `tbl_keranjang` VALUES (1, 2, 2, 'INV20220302080848311800', 2, '2022-03-02');
INSERT INTO `tbl_keranjang` VALUES (2, 2, 3, 'INV20220302080848311800', 1, '2022-03-02');
INSERT INTO `tbl_keranjang` VALUES (3, 2, 2, 'INV20220302080848311800', 5, '2022-03-02');
INSERT INTO `tbl_keranjang` VALUES (4, 2, 3, 'INV20220302080848311800', 2, '2022-03-02');
INSERT INTO `tbl_keranjang` VALUES (5, 2, 4, 'INV20220302080848311800', 4, '2022-03-02');

-- ----------------------------
-- Table structure for tbl_pesanan
-- ----------------------------
DROP TABLE IF EXISTS `tbl_pesanan`;
CREATE TABLE `tbl_pesanan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_users` int NULL DEFAULT NULL,
  `invoice` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `total_item` int NULL DEFAULT NULL,
  `harga_total` int NULL DEFAULT NULL,
  `total_bayar` int NULL DEFAULT NULL,
  `kembalian` int NULL DEFAULT NULL,
  `tanggal_pesan` datetime NULL DEFAULT NULL,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_pesanan
-- ----------------------------
INSERT INTO `tbl_pesanan` VALUES (1, 2, 'INV20220302080848311800', 7, 40000, 500000, 460000, '2022-03-02 15:03:08', 'Selesai');

-- ----------------------------
-- Table structure for tbl_produk
-- ----------------------------
DROP TABLE IF EXISTS `tbl_produk`;
CREATE TABLE `tbl_produk`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `produk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `deskripsi_produk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `jenis_produk` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga` int NULL DEFAULT NULL,
  `jumlah_stok` int NULL DEFAULT NULL,
  `satuan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gambar_produk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_produk
-- ----------------------------
INSERT INTO `tbl_produk` VALUES (2, 'Minyak Goreng Bimoli', '-', 'Sembako', 22000, 43, 'Item', 'YTIyMDMwMjEwNTIzOA==');
INSERT INTO `tbl_produk` VALUES (3, 'Beras', '-', 'Sembako', 12000, 45, 'Kg', 'YTIyMDMwMjEwNTMwMw==');
INSERT INTO `tbl_produk` VALUES (4, 'Jet Z', '', 'Makanan Ringan', 6000, 94, 'Item', 'YTIyMDMwMjEwNTQxNQ==');
INSERT INTO `tbl_produk` VALUES (5, 'ChikiBalls', '-', 'Makanan Ringan', 4000, 300, 'Item', 'YTIyMDMwMjEwNTQzMw==');

-- ----------------------------
-- Table structure for tbl_users
-- ----------------------------
DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `nomor_telepon` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `hak_akses` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_daftar` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_users
-- ----------------------------
INSERT INTO `tbl_users` VALUES (1, 'Reynaldo Josua Togatorop', 'reynaldo.josua@gmail.com', '12345', 'Medan', '085268401096', 'Admin', '2022-03-01 11:03:31');
INSERT INTO `tbl_users` VALUES (2, 'Konsumen 1', 'konsumen@gmail.com', '12345', '-', '085647852158', 'Pembeli', '2022-03-02 10:03:54');

-- ----------------------------
-- View structure for v_data_keranjang
-- ----------------------------
DROP VIEW IF EXISTS `v_data_keranjang`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_data_keranjang` AS SELECT tbl_keranjang.*, tbl_produk.produk, tbl_produk.jenis_produk, tbl_produk.satuan, tbl_produk.harga,tbl_produk.gambar_produk, sum(jumlah) as 'jumlah_pesanan' FROM `tbl_keranjang` INNER JOIN tbl_produk ON tbl_keranjang.id_produk = tbl_produk.id  WHERE tbl_keranjang.invoice = "-" GROUP BY id_produk ;

-- ----------------------------
-- View structure for v_data_pesanan_belum_dibayar
-- ----------------------------
DROP VIEW IF EXISTS `v_data_pesanan_belum_dibayar`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_data_pesanan_belum_dibayar` AS SELECT tbl_pesanan.*, sum(v_data_pesanan_keranjang.jumlah) as jumlah_pesanan, sum(v_data_pesanan_keranjang.harga) as sub_total, v_data_pesanan_keranjang.nama FROM `tbl_pesanan` INNER JOIN v_data_pesanan_keranjang ON tbl_pesanan.invoice = v_data_pesanan_keranjang.invoice WHERE status = 'Belum dibayar' GROUP BY tbl_pesanan.invoice ;

-- ----------------------------
-- View structure for v_data_pesanan_keranjang
-- ----------------------------
DROP VIEW IF EXISTS `v_data_pesanan_keranjang`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_data_pesanan_keranjang` AS SELECT
	tbl_keranjang.*,
	tbl_produk.produk,
	tbl_produk.jenis_produk,
	tbl_produk.satuan,
	tbl_produk.harga,
	tbl_produk.gambar_produk,
	sum( jumlah ) AS 'jumlah_pesanan',
	tbl_users.nama
FROM
	`tbl_keranjang`
	INNER JOIN tbl_produk ON tbl_keranjang.id_produk = tbl_produk.id 
	INNER JOIN tbl_users ON tbl_keranjang.id_users = tbl_users.id
WHERE
	tbl_keranjang.invoice != "" 
GROUP BY
	id_produk ;

-- ----------------------------
-- View structure for v_data_pesanan_selesai
-- ----------------------------
DROP VIEW IF EXISTS `v_data_pesanan_selesai`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_data_pesanan_selesai` AS SELECT tbl_pesanan.*, sum(v_data_pesanan_keranjang.jumlah) as jumlah_pesanan, sum(v_data_pesanan_keranjang.harga) as sub_total, v_data_pesanan_keranjang.nama FROM `tbl_pesanan` INNER JOIN v_data_pesanan_keranjang ON tbl_pesanan.invoice = v_data_pesanan_keranjang.invoice WHERE status = 'Selesai' GROUP BY tbl_pesanan.invoice ;

-- ----------------------------
-- Triggers structure for table tbl_keranjang
-- ----------------------------
DROP TRIGGER IF EXISTS `kurangStok`;
delimiter ;;
CREATE TRIGGER `kurangStok` AFTER INSERT ON `tbl_keranjang` FOR EACH ROW UPDATE tbl_produk SET jumlah_stok = jumlah_stok - NEW.jumlah WHERE id = NEW.id_produk
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbl_keranjang
-- ----------------------------
DROP TRIGGER IF EXISTS `rollbackStok`;
delimiter ;;
CREATE TRIGGER `rollbackStok` AFTER DELETE ON `tbl_keranjang` FOR EACH ROW UPDATE tbl_produk SET jumlah_stok = jumlah_stok + OLD.jumlah WHERE id = OLD.id_produk
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
