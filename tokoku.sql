/*
SQLyog Professional v12.5.1 (64 bit)
MySQL - 5.7.36-0ubuntu0.18.04.1 : Database - tokoku
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tokoku` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `tokoku`;

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) DEFAULT NULL,
  `is_delete` enum('0','1') DEFAULT '1' COMMENT '0. Delete, 1.Aktif',
  `created_by` varchar(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`kategori_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `kategori` */

insert  into `kategori`(`kategori_id`,`nama_kategori`,`is_delete`,`created_by`,`created_at`,`updated_at`) values 
(1,'Baju','0','1',1638761351,1638864240),
(2,'Celana Js','0','1',1638761351,1638864207),
(3,'Kaos','0','1',1638863147,1638864240),
(4,'Makanan','1','1',1638864644,1638864644),
(5,'Barang','1','1',1638864868,1638864868),
(6,'Alat Tulis','1','1',1638864945,1638864945);

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `migration` */

insert  into `migration`(`version`,`apply_time`) values 
('m000000_000000_base',1638712587),
('m130524_201442_init',1638712587),
('m190124_110200_add_verification_token_column_to_user_table',1638712587);

/*Table structure for table `produk` */

DROP TABLE IF EXISTS `produk`;

CREATE TABLE `produk` (
  `produk_id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_id` varchar(11) DEFAULT NULL,
  `nama_produk` varchar(255) DEFAULT NULL,
  `qty` varchar(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `is_delete` enum('0','1') DEFAULT '1' COMMENT '0. Delete, 1.Aktif',
  `created_by` varchar(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`produk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `produk` */

insert  into `produk`(`produk_id`,`kategori_id`,`nama_produk`,`qty`,`gambar`,`is_delete`,`created_by`,`created_at`,`updated_at`) values 
(1,'2','Baju Batik','50','1','0','1',1638761351,1638849567),
(5,'2','Baju Batik','50','snack-2021-12-07-03:58:16.png','0','1',1638847018,1638864237),
(6,'4','Bakso Granat','100','bakso-2021-12-07-08:27:18.jpeg','1','1',1638864746,1638865422),
(7,'6','Pencil Warna','100','pewarna-2021-12-07-08:23:17.jpeg','1','1',1638865043,1638865450),
(8,'4','Nasi Goreng','100','nasi-goreng-2021-12-07-08:01:25.jpeg','1','1',1638865501,1638865501),
(9,'4','Nasi Goreng Gila','100','nasi-goreng-gila-2021-12-07-08:31:25.jpeg','1','1',1638865531,1638865531),
(10,'4','Bakso Beranak','100','bakso-beranak-2021-12-07-08:44:25.jpeg','1','1',1638865544,1638865544),
(11,'4','Bakso Merapi','100','bakso-merapi-2021-12-07-08:04:26.jpeg','1','1',1638865564,1638866387),
(12,'4','Bakso Jumbo','100','bakso-jumbo-2021-12-07-08:48:43.jpeg','1','1',1638866628,1638866628),
(13,'4','Bakso','100','bakso-2021-12-07-08:07:57.jpeg','1','1',1638867427,1638867427),
(14,'4','Nasi Goreng Spesial','100','nasi-goreng-spesial-2021-12-07-08:48:57.jpeg','1','1',1638867468,1638867468),
(15,'4','Nasi Goreng Bakso','100','nasi-goreng-bakso-2021-12-07-08:54:58.jpeg','1','1',1638867534,1638867534),
(16,'4','Nasi Goreng Sosis','100','nasi-goreng-sosis-2021-12-07-08:09:59.jpeg','1','1',1638867549,1638867549);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('1','2') COLLATE utf8_unicode_ci DEFAULT '2' COMMENT '1. Master, 2.User',
  `status` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0. Tidak Aktif, 1. Aktif, 2. Suspend',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`nama`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`role`,`status`,`created_at`,`updated_at`,`verification_token`) values 
(1,'andri007','Andri Rizki Saputra','TR00k5SU--Aq_s9arsCa_tGm1WPYks1n','$2y$13$QLPo1NBu9rOLaY3zHEAQdu.Ecu7bdJ70KbogUF57eRjq8yU08YmL.',NULL,'andri.rizki007@gmail.com','1','1',1638761351,1638761351,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
