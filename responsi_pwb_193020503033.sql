/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 10.4.13-MariaDB : Database - responsi_pwb_193020503033
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`responsi_pwb_193020503033` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `responsi_pwb_193020503033`;

/*Table structure for table `anggota` */

DROP TABLE IF EXISTS `anggota`;

CREATE TABLE `anggota` (
  `id_anggota` varchar(255) NOT NULL,
  `id_user` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_anggota`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `anggota` */

insert  into `anggota`(`id_anggota`,`id_user`,`tanggal_lahir`,`nik`,`alamat`,`no_hp`) values 
('AGT003','USR004','2001-06-27','098','aaa','086556');

/*Table structure for table `buku` */

DROP TABLE IF EXISTS `buku`;

CREATE TABLE `buku` (
  `kode_buku` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pengarang` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `stok` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`kode_buku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `buku` */

insert  into `buku`(`kode_buku`,`judul`,`pengarang`,`penerbit`,`deskripsi`,`stok`,`image`) values 
('KBK001','Algoritma & Teknik Pemrograman','Budi Sutejo, Michael An','ANDI','Menyajikan tentang konsep algoritma dan teknik pemrograman yang diaplikasikan secara lebih spesifik ke dalam bahasa Pascal',18,'6096fd11ca79c.jpg'),
('KBK002','Penerapan Data Mining Dengan Matlab','Prabowo Pudjo Widodo, dkk',' INFORMATIKA','Teori-teori dasar yang dilanjutkan implementasinya dengan bahasa pemrograman Matlab',16,'6096fdff377ff.jpg'),
('KBK003','Konsep Sistem Informasi: Dari Bit sampai ke Database','Bambang Wahyudi','ANDI','Buku ini membahas perjalanan data, terutama data yang ada di komputer, dimulai dari ukuran yang paling kecil, yaitu bit (binary digit) hingga ke database',10,'6096fffe7f7b5.jpg'),
('KBK004','Aplikasi Komputer','Dedy Iswanto','Deepublish','Berisi tentang dasar-dasar penggunaan Microsoft Office, Excel, Power Point, dll',13,'609702f2b7e90.jpg');

/*Table structure for table `pinjaman` */

DROP TABLE IF EXISTS `pinjaman`;

CREATE TABLE `pinjaman` (
  `id_pinjaman` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(255) NOT NULL,
  `kode_buku` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pinjaman`),
  KEY `id_user` (`id_user`),
  KEY `kode_buku` (`kode_buku`),
  CONSTRAINT `pinjaman_ibfk_2` FOREIGN KEY (`kode_buku`) REFERENCES `buku` (`kode_buku`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pinjaman_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4;

/*Data for the table `pinjaman` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id_user` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `user` */

insert  into `user`(`id_user`,`username`,`pass`,`nama_lengkap`) values 
('USR004','tina','$2y$10$zCFxML0xZWR0hB4W.bDtTeEfzjd.4WCpgJoTv7TyNMhxg4wN.n5Na','Tina Kurniana');

/* Trigger structure for table `pinjaman` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `Kurang_Stok` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `Kurang_Stok` AFTER INSERT ON `pinjaman` FOR EACH ROW BEGIN
	DECLARE jumlah INT;
	SET jumlah:=(SELECT pinjaman.`jumlah` FROM pinjaman WHERE pinjaman.`id_pinjaman`=new.id_pinjaman);
	UPDATE buku SET buku.`stok`= buku.`stok` - jumlah WHERE buku.`kode_buku` = new.kode_buku;
    END */$$


DELIMITER ;

/* Trigger structure for table `pinjaman` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `Update_Stok` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `Update_Stok` AFTER UPDATE ON `pinjaman` FOR EACH ROW BEGIN
	UPDATE buku SET buku.`stok`=buku.`stok`+old.jumlah WHERE buku.`kode_buku`=old.kode_buku;
        UPDATE buku SET buku.`stok`=buku.`stok`-new.jumlah WHERE buku.`kode_buku`=new.kode_buku;
    END */$$


DELIMITER ;

/* Function  structure for function  `Hitung_Jumlah_Pinjam` */

/*!50003 DROP FUNCTION IF EXISTS `Hitung_Jumlah_Pinjam` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `Hitung_Jumlah_Pinjam`(id_user varchar(255)) RETURNS int(3)
BEGIN
	DECLARE jumlah INT;
	SELECT SUM(pinjaman.`jumlah`) AS jumlah FROM pinjaman WHERE pinjaman.`id_user`=id_user AND pinjaman.`status`='Sedang dipinjam' INTO jumlah;
	RETURN jumlah;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `Delete_Buku` */

/*!50003 DROP PROCEDURE IF EXISTS  `Delete_Buku` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_Buku`(kd_bk varchar(255))
BEGIN
		delete from buku
		where kd_bk = kode_buku;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `Delete_Pinjaman` */

/*!50003 DROP PROCEDURE IF EXISTS  `Delete_Pinjaman` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_Pinjaman`(id_pj int)
BEGIN
		DELETE FROM pinjaman
		WHERE id_pj = id_pinjaman;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `Insert_Anggota` */

/*!50003 DROP PROCEDURE IF EXISTS  `Insert_Anggota` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_Anggota`(id_anggota varchar(255),id_user varchar(255), tanggal_lahir date, nik varchar(255), alamat varchar(255), no_hp varchar(255))
BEGIN
		insert into anggota values(id_anggota, id_user, tanggal_lahir, nik, alamat, no_hp);
	END */$$
DELIMITER ;

/* Procedure structure for procedure `Insert_Buku` */

/*!50003 DROP PROCEDURE IF EXISTS  `Insert_Buku` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_Buku`(kode_buku varchar(255),judul varchar(255), pengarang varchar(255), penerbit varchar(255), deskripsi text, stok int, image varchar(255))
BEGIN
		insert into buku values(kode_buku, judul, pengarang, penerbit, deskripsi, stok, image);
	END */$$
DELIMITER ;

/* Procedure structure for procedure `Insert_Pinjaman` */

/*!50003 DROP PROCEDURE IF EXISTS  `Insert_Pinjaman` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_Pinjaman`(`id_user` VARCHAR(255), `kode_buku` VARCHAR(10), `jumlah` INT, `tanggal` DATE, `stat` VARCHAR(255))
BEGIN
		INSERT INTO pinjaman (id_user,kode_buku,jumlah,tanggal,STATUS) 
		VALUES(id_user, kode_buku, jumlah, tanggal, stat);
	END */$$
DELIMITER ;

/* Procedure structure for procedure `Insert_User` */

/*!50003 DROP PROCEDURE IF EXISTS  `Insert_User` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_User`(id_user varchar(255),username VARCHAR(255), pass VARCHAR(255), fullname VARCHAR(50))
BEGIN
		INSERT INTO USER VALUE(id_user, username, pass, fullname);
	END */$$
DELIMITER ;

/* Procedure structure for procedure `Update_Buku` */

/*!50003 DROP PROCEDURE IF EXISTS  `Update_Buku` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_Buku`(ukode_buku varchar(10), ujudul varchar(255), upengarang VARCHAR(255), upenerbit VARCHAR(255), udeskripsi VARCHAR(255), ustok int, uimage VARCHAR(255))
BEGIN
		update buku
		SET judul = ujudul, pengarang = upengarang, penerbit = upenerbit, deskripsi = udeskripsi, stok = ustok, image = uimage
		WHERE kode_buku = ukode_buku;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `Update_Jumlah_Pinjaman` */

/*!50003 DROP PROCEDURE IF EXISTS  `Update_Jumlah_Pinjaman` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_Jumlah_Pinjaman`(iduser VARCHAR(255), kodebuku VARCHAR(255), jlh INT)
BEGIN
		UPDATE pinjaman SET pinjaman.`jumlah`=pinjaman.`jumlah`+jlh WHERE pinjaman.`id_user`=iduser AND pinjaman.`kode_buku`=kodebuku;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `Update_Status_Pinjaman` */

/*!50003 DROP PROCEDURE IF EXISTS  `Update_Status_Pinjaman` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_Status_Pinjaman`(`id_pinjam` INT, `iduser` VARCHAR(255), `kodebuku` VARCHAR(255))
BEGIN
		DECLARE jumlah INT;
		SET jumlah:=(SELECT pinjaman.`jumlah` FROM pinjaman WHERE pinjaman.`kode_buku`=kodebuku AND pinjaman.`id_user`=iduser AND pinjaman.`id_pinjaman`=id_pinjam);
		UPDATE pinjaman SET pinjaman.`status`='Sudah dikembalikan' WHERE pinjaman.`id_pinjaman`=id_pinjam;
		UPDATE buku SET buku.`stok`=buku.`stok`+jumlah WHERE buku.`kode_buku`=kodebuku;
	END */$$
DELIMITER ;

/*Table structure for table `data_pinjam` */

DROP TABLE IF EXISTS `data_pinjam`;

/*!50001 DROP VIEW IF EXISTS `data_pinjam` */;
/*!50001 DROP TABLE IF EXISTS `data_pinjam` */;

/*!50001 CREATE TABLE  `data_pinjam`(
 `id_user` varchar(255) ,
 `nama_lengkap` varchar(255) ,
 `jumlah` int(11) ,
 `kode_buku` varchar(255) ,
 `judul` varchar(255) ,
 `penerbit` varchar(255) ,
 `pengarang` varchar(255) ,
 `status` varchar(255) ,
 `id_pinjaman` int(11) 
)*/;

/*View structure for view data_pinjam */

/*!50001 DROP TABLE IF EXISTS `data_pinjam` */;
/*!50001 DROP VIEW IF EXISTS `data_pinjam` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `data_pinjam` AS (select `user`.`id_user` AS `id_user`,`user`.`nama_lengkap` AS `nama_lengkap`,`pinjaman`.`jumlah` AS `jumlah`,`buku`.`kode_buku` AS `kode_buku`,`buku`.`judul` AS `judul`,`buku`.`penerbit` AS `penerbit`,`buku`.`pengarang` AS `pengarang`,`pinjaman`.`status` AS `status`,`pinjaman`.`id_pinjaman` AS `id_pinjaman` from ((`user` join `pinjaman` on(`user`.`id_user` = `pinjaman`.`id_user`)) join `buku` on(`pinjaman`.`kode_buku` = `buku`.`kode_buku`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
