/*
 Navicat Premium Data Transfer

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 80300 (8.3.0)
 Source Host           : localhost:3306
 Source Schema         : db_estrada

 Target Server Type    : MySQL
 Target Server Version : 80300 (8.3.0)
 File Encoding         : 65001

 Date: 19/02/2024 23:21:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for m_karyawan
-- ----------------------------
DROP TABLE IF EXISTS `m_karyawan`;
CREATE TABLE `m_karyawan` (
  `nik` varchar(8) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `alamat` text,
  `tgllahir` datetime DEFAULT NULL,
  `divisi` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of m_karyawan
-- ----------------------------
BEGIN;
INSERT INTO `m_karyawan` (`nik`, `nama`, `alamat`, `tgllahir`, `divisi`, `status`, `created_date`) VALUES ('10240001', 'IT', 'Address', '2024-02-19 00:00:00', 'IT', 'Tetap', '2024-02-19 23:14:28');
INSERT INTO `m_karyawan` (`nik`, `nama`, `alamat`, `tgllahir`, `divisi`, `status`, `created_date`) VALUES ('10240002', 'IT', 'Address', '2024-02-19 00:00:00', 'IT', 'Kontrak', '2024-02-19 23:14:41');
INSERT INTO `m_karyawan` (`nik`, `nama`, `alamat`, `tgllahir`, `divisi`, `status`, `created_date`) VALUES ('11240001', 'HRD', 'address', '2024-02-06 00:00:00', 'HRD', 'Tetap', '2024-02-19 23:19:57');
INSERT INTO `m_karyawan` (`nik`, `nama`, `alamat`, `tgllahir`, `divisi`, `status`, `created_date`) VALUES ('12240001', 'Finance', 'Address', '2024-02-19 00:00:00', 'Finance', 'Tetap', '2024-02-19 23:15:27');
COMMIT;

-- ----------------------------
-- Procedure structure for AddKaryawan
-- ----------------------------
DROP PROCEDURE IF EXISTS `AddKaryawan`;
delimiter ;;
CREATE PROCEDURE `AddKaryawan`(IN in_nama VARCHAR(150),
  IN in_alamat TEXT,
  IN in_tgllahir DATETIME,
  IN in_divisi VARCHAR(20),
  IN in_status VARCHAR(20))
BEGIN
  DECLARE divisi_code VARCHAR(2);
  DECLARE current_year VARCHAR(2);
  DECLARE max_sequence INT;

  -- Mapping divisi ke kode divisi
  CASE in_divisi
    WHEN 'IT' THEN SET divisi_code = '10';
    WHEN 'HRD' THEN SET divisi_code = '11';
    WHEN 'Finance' THEN SET divisi_code = '12';
    ELSE SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Invalid divisi';
  END CASE;

  -- Mendapatkan tahun sekarang
  SET current_year = SUBSTRING(YEAR(NOW()), 3);

  -- Mendapatkan urutan maksimal berdasarkan kode divisi dan tahun sekarang
  SELECT COALESCE(MAX(CAST(SUBSTRING(nik, 5) AS UNSIGNED)), 0) INTO max_sequence
  FROM m_karyawan
  WHERE nik LIKE CONCAT(divisi_code, current_year, '%');

  -- Menyusun NIK baru
  SET @new_nik = CONCAT(divisi_code, current_year, LPAD(max_sequence + 1, 4, '0'));

  -- Menambahkan karyawan ke dalam tabel
  INSERT INTO m_karyawan (nik, nama, alamat, tgllahir, divisi, status, created_date)
  VALUES (@new_nik, in_nama, in_alamat, in_tgllahir, in_divisi, in_status, NOW());

  -- Mengembalikan NIK baru
  SELECT @new_nik AS new_nik;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for DeleteKaryawan
-- ----------------------------
DROP PROCEDURE IF EXISTS `DeleteKaryawan`;
delimiter ;;
CREATE PROCEDURE `DeleteKaryawan`(IN in_nik VARCHAR(8))
BEGIN
  DELETE FROM m_karyawan WHERE nik = in_nik;
  
  SELECT 'Karyawan deleted successfully' AS message;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for EditKaryawan
-- ----------------------------
DROP PROCEDURE IF EXISTS `EditKaryawan`;
delimiter ;;
CREATE PROCEDURE `EditKaryawan`(IN in_nik VARCHAR(8),
  IN in_nama VARCHAR(150),
  IN in_alamat TEXT,
  IN in_tgllahir DATETIME,
  IN in_divisi VARCHAR(20),
  IN in_status VARCHAR(20))
BEGIN
  UPDATE m_karyawan
  SET nama = in_nama,
      alamat = in_alamat,
      tgllahir = in_tgllahir,
      divisi = in_divisi,
      status = in_status
  WHERE nik = in_nik;
  
  SELECT 'Karyawan updated successfully' AS message;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for GetKaryawanDetail
-- ----------------------------
DROP PROCEDURE IF EXISTS `GetKaryawanDetail`;
delimiter ;;
CREATE PROCEDURE `GetKaryawanDetail`(IN p_nik VARCHAR(8))
BEGIN
  SELECT * FROM m_karyawan WHERE nik = p_nik;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for ListKaryawan
-- ----------------------------
DROP PROCEDURE IF EXISTS `ListKaryawan`;
delimiter ;;
CREATE PROCEDURE `ListKaryawan`()
BEGIN
  SELECT * FROM m_karyawan;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
