# ************************************************************
# Sequel Ace SQL dump
# Version 20062
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: localhost (MySQL 5.5.5-10.4.21-MariaDB)
# Database: ug_warning_system
# Generation Time: 2024-02-23 02:35:18 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table catatan
# ------------------------------------------------------------

CREATE TABLE `catatan` (
  `id_log_auto` int(11) NOT NULL AUTO_INCREMENT,
  `catatan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_log_auto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table content
# ------------------------------------------------------------

CREATE TABLE `content` (
  `id_content` int(11) NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `parameter_id` int(11) NOT NULL DEFAULT 0,
  `variable_id` int(11) NOT NULL DEFAULT 0,
  `total_qty_parameter` int(11) NOT NULL DEFAULT 0,
  `state` int(11) NOT NULL DEFAULT 0,
  `threshold_state_qty` int(11) NOT NULL DEFAULT 0,
  `threshold_state_persentase` double NOT NULL DEFAULT 0 COMMENT 'state_off/total_qty_variable*100',
  `is_parameter_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_sound_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_speech_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_light_strobe_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_threshold_confirm` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_content`),
  KEY `FK_content_variable` (`variable_id`),
  KEY `FK_content_parameter` (`parameter_id`),
  CONSTRAINT `FK_content_parameter` FOREIGN KEY (`parameter_id`) REFERENCES `parameter` (`id_parameter`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_content_variable` FOREIGN KEY (`variable_id`) REFERENCES `variable` (`id_variable`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

LOCK TABLES `content` WRITE;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;

INSERT INTO `content` (`id_content`, `waktu`, `parameter_id`, `variable_id`, `total_qty_parameter`, `state`, `threshold_state_qty`, `threshold_state_persentase`, `is_parameter_active`, `is_sound_active`, `is_speech_active`, `is_light_strobe_active`, `is_threshold_confirm`)
VALUES
	(1,'2024-02-23 19:40:48',1,1,59,2,2,0,1,1,1,0,1),
	(2,'2024-02-23 19:40:48',1,2,59,2,2,0,1,1,1,0,1),
	(3,'2024-02-23 19:40:48',1,3,59,2,2,0,1,1,1,0,1),
	(4,'2024-02-23 19:40:48',1,4,59,2,2,0,1,1,1,0,1),
	(5,'2024-02-23 19:40:48',1,5,59,2,2,0,1,1,1,0,1),
	(6,'2024-02-23 19:40:48',1,6,59,2,2,0,1,1,1,0,1);

/*!40000 ALTER TABLE `content` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table mslokasi
# ------------------------------------------------------------

CREATE TABLE `mslokasi` (
  `id_lokasi_auto` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lokasi` varchar(50) DEFAULT '0',
  `ip_address` varchar(50) DEFAULT '0',
  `is_registered` tinyint(1) DEFAULT 0,
  `registered_by` varchar(50) DEFAULT '0',
  `registered_time` timestamp NULL DEFAULT current_timestamp(),
  `catatan` text DEFAULT NULL,
  PRIMARY KEY (`id_lokasi_auto`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

LOCK TABLES `mslokasi` WRITE;
/*!40000 ALTER TABLE `mslokasi` DISABLE KEYS */;

INSERT INTO `mslokasi` (`id_lokasi_auto`, `nama_lokasi`, `ip_address`, `is_registered`, `registered_by`, `registered_time`, `catatan`)
VALUES
	(1,'Power Plant','0',0,'0','2022-07-21 07:20:58','demo 1'),
	(2,'Lokasi G','0',0,'0','2022-07-21 07:32:32',NULL),
	(3,'Lokasi H','0',0,'0','2022-07-21 07:32:44',NULL),
	(4,'Lokasi A','0',0,'0','2022-07-21 07:32:57',NULL),
	(5,'Lokasi Basecamp','0',0,'0','2022-07-21 07:33:12','demo 2'),
	(6,'Lokasi W','0',0,'0','2022-07-21 07:33:26',NULL),
	(7,'Lokasi D','0',0,'0','2022-07-21 07:33:38',NULL),
	(8,'Lokasi V','0',0,'0','2022-07-21 07:33:56','demo 4'),
	(9,'Lokasi U','0',0,'0','2022-07-21 07:34:08','demo 3'),
	(10,'Lokasi J','0',0,'0','2022-07-21 07:34:20',NULL),
	(11,'Lokasi Cipaku','0',0,'0','2022-07-21 07:34:35','lokasi paling jauh');

/*!40000 ALTER TABLE `mslokasi` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table msmember
# ------------------------------------------------------------

CREATE TABLE `msmember` (
  `id_member` int(11) NOT NULL AUTO_INCREMENT,
  `nama_member` varchar(50) DEFAULT NULL,
  `nama_panggilan` varchar(50) DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `rfid_tag_number` varchar(10) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT current_timestamp(),
  `created_by` varchar(50) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_member`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

LOCK TABLES `msmember` WRITE;
/*!40000 ALTER TABLE `msmember` DISABLE KEYS */;

INSERT INTO `msmember` (`id_member`, `nama_member`, `nama_panggilan`, `tempat_lahir`, `tgl_lahir`, `rfid_tag_number`, `created_date`, `created_by`, `modified_date`, `modified_by`)
VALUES
	(1,'RIDWAN SAPOETRA','RIDWAN','JAKARTA','1991-10-16','0013435486',NULL,NULL,NULL,NULL),
	(2,'WIRANTO','WIRANTO','JAKARTA','2023-11-15','1604979280','2023-11-15 07:52:37',NULL,'2023-11-15 14:52:38',NULL);

/*!40000 ALTER TABLE `msmember` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table msregional
# ------------------------------------------------------------

CREATE TABLE `msregional` (
  `id_regional_auto` int(11) NOT NULL AUTO_INCREMENT,
  `nama_regional` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id_regional_auto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

LOCK TABLES `msregional` WRITE;
/*!40000 ALTER TABLE `msregional` DISABLE KEYS */;

INSERT INTO `msregional` (`id_regional_auto`, `nama_regional`)
VALUES
	(1,'Regional Bandung');

/*!40000 ALTER TABLE `msregional` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table msuser
# ------------------------------------------------------------

CREATE TABLE `msuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `group_name` varchar(50) DEFAULT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `hint` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `id_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

LOCK TABLES `msuser` WRITE;
/*!40000 ALTER TABLE `msuser` DISABLE KEYS */;

INSERT INTO `msuser` (`id`, `username`, `password`, `group_name`, `fname`, `hint`)
VALUES
	(2,'admin','a669abd14698035a35dabe625c0f5829','sa','Ridwan Sapoetra','admin');

/*!40000 ALTER TABLE `msuser` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table parameter
# ------------------------------------------------------------

CREATE TABLE `parameter` (
  `id_parameter` int(11) NOT NULL AUTO_INCREMENT,
  `nama_parameter` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_parameter`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

LOCK TABLES `parameter` WRITE;
/*!40000 ALTER TABLE `parameter` DISABLE KEYS */;

INSERT INTO `parameter` (`id_parameter`, `nama_parameter`)
VALUES
	(1,'ATM Down'),
	(2,'SLA'),
	(3,'COM Down');

/*!40000 ALTER TABLE `parameter` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table rfid_log_client
# ------------------------------------------------------------

CREATE TABLE `rfid_log_client` (
  `id_auto` int(11) NOT NULL AUTO_INCREMENT,
  `id_lokasi` int(2) NOT NULL DEFAULT 0,
  `rfid_tag_number` varchar(10) DEFAULT '0',
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_upload` tinyint(1) NOT NULL DEFAULT 0,
  `ip_address` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id_auto`),
  KEY `FK_rfid_log_mslokasi` (`id_lokasi`),
  CONSTRAINT `FK_rfid_log_mslokasi` FOREIGN KEY (`id_lokasi`) REFERENCES `mslokasi` (`id_lokasi_auto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

LOCK TABLES `rfid_log_client` WRITE;
/*!40000 ALTER TABLE `rfid_log_client` DISABLE KEYS */;

INSERT INTO `rfid_log_client` (`id_auto`, `id_lokasi`, `rfid_tag_number`, `waktu`, `is_upload`, `ip_address`)
VALUES
	(1,4,'0013435486','2023-01-15 08:06:45',1,'127.0.0.1'),
	(2,4,'0013435486','2023-01-15 08:09:06',1,'127.0.0.1'),
	(3,4,'0013452938','2023-01-15 08:09:24',1,'127.0.0.1'),
	(4,4,'3646578816','2023-01-15 08:11:19',1,'127.0.0.1'),
	(5,4,'3646578816','2023-01-15 08:11:22',1,'127.0.0.1'),
	(6,4,'3646578816','2023-01-15 08:11:26',1,'127.0.0.1'),
	(7,4,'3646578816','2023-01-15 08:15:40',1,'127.0.0.1'),
	(8,4,'3646578816','2023-01-15 08:15:46',1,'127.0.0.1'),
	(9,4,'3646578816','2023-01-15 08:16:02',1,'127.0.0.1'),
	(10,4,'1604979280','2023-11-15 07:55:06',1,'192.168.3.100');

/*!40000 ALTER TABLE `rfid_log_client` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table rfid_log_server
# ------------------------------------------------------------

CREATE TABLE `rfid_log_server` (
  `id_auto` int(11) NOT NULL AUTO_INCREMENT,
  `id_lokasi` int(2) NOT NULL DEFAULT 0,
  `rfid_tag_number` varchar(10) DEFAULT '0',
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_upload` tinyint(1) NOT NULL DEFAULT 0,
  `ip_address` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id_auto`),
  KEY `FK_rfid_log_mslokasi` (`id_lokasi`),
  CONSTRAINT `FK_rfid_log_server_mslokasi` FOREIGN KEY (`id_lokasi`) REFERENCES `mslokasi` (`id_lokasi_auto`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

LOCK TABLES `rfid_log_server` WRITE;
/*!40000 ALTER TABLE `rfid_log_server` DISABLE KEYS */;

INSERT INTO `rfid_log_server` (`id_auto`, `id_lokasi`, `rfid_tag_number`, `waktu`, `is_upload`, `ip_address`)
VALUES
	(1,4,'0013435486','2023-01-15 08:06:45',1,'127.0.0.1'),
	(2,4,'0013435486','2023-01-15 08:09:06',1,'127.0.0.1'),
	(3,4,'0013452938','2023-01-15 08:09:24',1,'127.0.0.1'),
	(4,4,'3646578816','2023-01-15 08:11:19',1,'127.0.0.1'),
	(5,4,'3646578816','2023-01-15 08:11:22',1,'127.0.0.1'),
	(6,4,'3646578816','2023-01-15 08:11:26',1,'127.0.0.1'),
	(7,4,'3646578816','2023-01-15 08:15:40',1,'127.0.0.1'),
	(8,4,'3646578816','2023-01-15 08:15:46',1,'127.0.0.1'),
	(9,4,'3646578816','2023-01-15 08:16:02',1,'127.0.0.1'),
	(10,4,'1604979280','2023-11-15 07:55:06',1,'192.168.3.100');

/*!40000 ALTER TABLE `rfid_log_server` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table variable
# ------------------------------------------------------------

CREATE TABLE `variable` (
  `id_variable` int(11) NOT NULL AUTO_INCREMENT,
  `nama_variable` varchar(100) NOT NULL,
  `parameter_id` int(11) NOT NULL,
  PRIMARY KEY (`id_variable`),
  KEY `FK_variable_parameter` (`parameter_id`),
  CONSTRAINT `FK_variable_parameter` FOREIGN KEY (`parameter_id`) REFERENCES `parameter` (`id_parameter`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

LOCK TABLES `variable` WRITE;
/*!40000 ALTER TABLE `variable` DISABLE KEYS */;

INSERT INTO `variable` (`id_variable`, `nama_variable`, `parameter_id`)
VALUES
	(1,'ATM In Operational',1),
	(2,'ATM Out of Order',1),
	(3,'ATM Supervisor Mode',1),
	(4,'ATM Cash Low',1),
	(5,'ATM Cash Out',1),
	(6,'ATM No Connection',1),
	(7,'Physical Error - Kaset 1',1),
	(8,'Physical Error - Kaset 2',1),
	(9,'Physical Error - Kaset 3',1),
	(10,'Physical Error - Kaset 4',1),
	(11,'Physical Error - Stacker',1),
	(12,'Physical Error - Dispenser',1),
	(13,'Physical Error - Card Reader',1),
	(14,'Physical Error - Printer',1),
	(15,'Physical Error - Printer Paper',1),
	(16,'Physical Error - Pinpad',1),
	(17,'Physical Error - Camera',1),
	(18,'Physical Error - Retained Cards > 5',1),
	(19,'Physical Error - Trx < 1d (2h - 23)',1),
	(20,'Physical Error - Trx > 1d',1),
	(21,'Physical Error - Offline > 1d',1),
	(22,'Jaringan Komunikasi - Leased-Line',1),
	(23,'Jaringan Komunikasi - Telkom',1),
	(24,'Jaringan Komunikasi - Indosat',1),
	(25,'Jaringan Komunikasi - Telkomsel',1),
	(26,'Jaringan Komunikasi - MAMO',1),
	(27,'Jaringan Komunikasi - Lintas Arta',1),
	(28,'Jaringan Komunikasi - Telenet',1),
	(29,'Jaringan Komunikasi - PRIMACOM',1),
	(30,'Jaringan Komunikasi - Tangara',1),
	(31,'Jaringan Komunikasi - PSN',1),
	(32,'Jaringan Komunikasi - XL',1),
	(33,'Jaringan Komunikasi - Sanatel',1),
	(34,'Jaringan Komunikasi - PSN',1),
	(35,'Jaringan Komunikasi - PSN',1),
	(36,'Jaringan Komunikasi - PSN',1);

/*!40000 ALTER TABLE `variable` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
