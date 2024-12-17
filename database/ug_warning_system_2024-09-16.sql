# ************************************************************
# Sequel Ace SQL dump
# Version 20067
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: localhost (MySQL 5.5.5-10.4.21-MariaDB)
# Database: ug_warning_system
# Generation Time: 2024-09-16 02:44:08 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table audio
# ------------------------------------------------------------

CREATE TABLE `audio` (
  `id_audio` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama_audio` varchar(50) DEFAULT NULL,
  `nama_file` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_audio`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

LOCK TABLES `audio` WRITE;
/*!40000 ALTER TABLE `audio` DISABLE KEYS */;

INSERT INTO `audio` (`id_audio`, `nama_audio`, `nama_file`, `is_active`)
VALUES
	(7,'Alarm 1','sound1.mp3',0),
	(8,'Alarm 2','sound2.mp3',0),
	(9,'Alarm 3','sound3.mp3',1),
	(10,'Buzzer','buzzer.mp3',0),
	(11,'Global Sound','global_sound.mp3',0),
	(12,'Tingtung','tingtung.mp3',0);

/*!40000 ALTER TABLE `audio` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table catatan
# ------------------------------------------------------------

CREATE TABLE `catatan` (
  `id_log_auto` int(11) NOT NULL AUTO_INCREMENT,
  `catatan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_log_auto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table config
# ------------------------------------------------------------

CREATE TABLE `config` (
  `id_config` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `config_name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `variable` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `value` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 0,
  `owner` enum('web','robot','controller') CHARACTER SET utf8mb4 DEFAULT 'web',
  `keterangan` text CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`id_config`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;

INSERT INTO `config` (`id_config`, `config_name`, `variable`, `value`, `is_active`, `owner`, `keterangan`)
VALUES
	(1,'Interval Hit APIS List Data / Milli Second','interval_request',60000,1,'web','60.000 milli second = 1 menit'),
	(2,'Interval Trigger Alert Play Sound / Milli Second','interval_request',60000,1,'web','60.000 milli second = 1 menit'),
	(3,'Global Sound Trigger Alert','global_sound',0,1,'web','1 = active, 0 = not active'),
	(4,'Default URL Path Jika Default Sound Tidak Ada','http://192.168.201.129:3000/greet?name=global_sound.mp3',0,1,'web','1 = active, 0 = not active'),
	(5,'URL Server Web Socket','192.168.201.129:3000',0,1,'web','1 = active, 0 = not active'),
	(6,'Warna Global Light CSS Color Code / Blink','#ff0000',1,1,'web','Code hexa warna'),
	(7,'Interval Controller Request / Milli Second','interval_request',60000,1,'controller','60.000 milli second = 1 menit'),
	(8,'Interval Light On / Milli Second','interval_request',10000,1,'controller','60.000 milli second = 1 menit'),
	(9,'Controller Play Sound ?','is_play_sound',1,1,'controller','1 = Ya, 0 = Tidak'),
	(10,'IP Address Controller','127.0.0.1:5000',1,1,'web','Data communication');

/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table content
# ------------------------------------------------------------

CREATE TABLE `content` (
  `id_content` int(11) NOT NULL AUTO_INCREMENT,
  `relation_key` varchar(50) DEFAULT NULL,
  `waktu` datetime DEFAULT NULL,
  `parameter_id` int(11) DEFAULT 0,
  `variable_id` int(11) DEFAULT 0,
  `variable_tts` varchar(200) DEFAULT NULL,
  `left_string_tts` varchar(200) DEFAULT NULL,
  `right_string_tts` varchar(200) DEFAULT NULL,
  `total_qty_parameter` int(11) DEFAULT 0,
  `is_parameter_active` tinyint(1) DEFAULT 0,
  `is_reverse_threshold` tinyint(1) DEFAULT 0,
  `state` double(4,2) NOT NULL DEFAULT 0.00,
  `threshold_state_qty_proactive` double(4,2) NOT NULL DEFAULT 0.00,
  `threshold_state_persentase_proactive` double(4,2) NOT NULL DEFAULT 0.00 COMMENT 'state_off/total_qty_variable*100',
  `light_proactive` tinyint(1) NOT NULL DEFAULT 0,
  `sound_proactive` tinyint(1) NOT NULL DEFAULT 0,
  `text_to_speech_proactive` text DEFAULT NULL,
  `threshold_state_qty_active` double(4,2) DEFAULT 0.00,
  `threshold_state_persentase_active` double(4,2) DEFAULT 0.00,
  `light_active` tinyint(1) DEFAULT 0,
  `sound_active` tinyint(1) DEFAULT 0,
  `text_to_speech_active` text DEFAULT NULL,
  `is_light_strobe_active` tinyint(1) DEFAULT 0,
  `interval` int(11) DEFAULT 0,
  `is_threshold_confirm` tinyint(1) DEFAULT 0,
  `light_color_code` varchar(50) DEFAULT NULL,
  `sound_id` int(11) DEFAULT 0,
  `query` text DEFAULT NULL,
  `is_data_passive` tinyint(1) DEFAULT 0,
  `is_done_play` tinyint(1) DEFAULT 0,
  `is_controller_done_play` tinyint(1) DEFAULT 0,
  `free_text_tts` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_content`),
  KEY `FK_content_variable` (`variable_id`),
  KEY `FK_content_parameter` (`parameter_id`),
  CONSTRAINT `FK_content_parameter` FOREIGN KEY (`parameter_id`) REFERENCES `parameter` (`id_parameter`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_content_variable` FOREIGN KEY (`variable_id`) REFERENCES `variable` (`id_variable`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

LOCK TABLES `content` WRITE;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;

INSERT INTO `content` (`id_content`, `relation_key`, `waktu`, `parameter_id`, `variable_id`, `variable_tts`, `left_string_tts`, `right_string_tts`, `total_qty_parameter`, `is_parameter_active`, `is_reverse_threshold`, `state`, `threshold_state_qty_proactive`, `threshold_state_persentase_proactive`, `light_proactive`, `sound_proactive`, `text_to_speech_proactive`, `threshold_state_qty_active`, `threshold_state_persentase_active`, `light_active`, `sound_active`, `text_to_speech_active`, `is_light_strobe_active`, `interval`, `is_threshold_confirm`, `light_color_code`, `sound_id`, `query`, `is_data_passive`, `is_done_play`, `is_controller_done_play`, `free_text_tts`)
VALUES
	(60,'Declined by Jalin-BNI','2024-08-11 18:56:40',2,44,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BNI',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Decline Jalin BNI'),
	(61,'Declined by Jalin-BRI','2024-08-11 18:57:14',2,45,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BRI',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Decline Jalin BRI'),
	(62,'Declined by Jalin-BTN','2024-08-11 18:57:58',2,46,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BTN',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Decline Jalin BTN'),
	(63,'Declined by Jalin-Mandiri','2024-08-11 18:58:28',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Decline Jalin Mandiri'),
	(64,'Declined by Client-BNI','2024-08-11 18:59:15',2,48,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BNI',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Decline by Client BNI'),
	(65,'Declined by Client-BRI','2024-08-11 18:59:45',2,49,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BRI',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Decline by Client BRI'),
	(66,'Declined by Client-BTN','2024-08-11 19:00:19',2,50,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BTN',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Decline by Client BTN'),
	(67,'Declined by Client-Mandiri','2024-08-11 19:00:56',2,51,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Decline by Client Mandiri'),
	(68,'Declined by System-BNI','2024-08-11 19:01:42',2,52,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BNI',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Decline System BNI'),
	(69,'Declined by System-BRI','2024-08-11 19:02:16',2,53,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BRI',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Decline System BRI'),
	(70,'Declined by System-BTN','2024-08-11 19:02:56',2,54,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BTN',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Decline System BTN'),
	(71,'Declined by System-Mandiri','2024-08-11 19:03:37',2,55,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Decline System Mandiri'),
	(76,'Approved Transactions-Mandiri','2024-08-13 10:13:51',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Approved Transactions Mandiri'),
	(77,'Approved Transactions-BNI','2024-08-13 10:15:00',2,61,NULL,'Perhatian, Saat ini terjadi penurunan ','pada atm BNI',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Approved Transactions BNI'),
	(78,'Approved Transactions-BRI','2024-08-13 10:16:12',2,62,NULL,'Perhatian, Saat ini terjadi penurunan ','pada atm BRI',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Approved Transactions BRI'),
	(79,'Approved Transactions-BTN','2024-08-13 10:16:52',2,63,NULL,'Perhatian, Saat ini terjadi penurunan ','pada atm BTN',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,0,0,'Approved Transactions BTN');

/*!40000 ALTER TABLE `content` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table content_demo
# ------------------------------------------------------------

CREATE TABLE `content_demo` (
  `id_content` int(11) NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `parameter_id` int(11) NOT NULL DEFAULT 0,
  `variable_id` int(11) NOT NULL DEFAULT 0,
  `total_qty_parameter` int(11) NOT NULL DEFAULT 0,
  `is_parameter_active` tinyint(1) NOT NULL DEFAULT 0,
  `state` int(11) NOT NULL DEFAULT 0,
  `threshold_state_qty_proactive` int(11) NOT NULL DEFAULT 0,
  `threshold_state_persentase_proactive` double NOT NULL DEFAULT 0 COMMENT 'state_off/total_qty_variable*100',
  `light_proactive` tinyint(1) NOT NULL DEFAULT 0,
  `sound_proactive` tinyint(1) NOT NULL DEFAULT 0,
  `text_to_speech_proactive` text DEFAULT NULL,
  `threshold_state_qty_active` int(11) DEFAULT 0,
  `threshold_state_persentase_active` double DEFAULT 0,
  `light_active` tinyint(1) DEFAULT 0,
  `sound_active` tinyint(1) DEFAULT 0,
  `text_to_speech_active` text DEFAULT NULL,
  `is_light_strobe_active` tinyint(1) NOT NULL DEFAULT 0,
  `interval` int(11) DEFAULT 0,
  `is_threshold_confirm` tinyint(1) DEFAULT 0,
  `light_color_code` varchar(50) DEFAULT NULL,
  `sound_id` int(11) DEFAULT 0,
  PRIMARY KEY (`id_content`),
  KEY `FK_content_variable` (`variable_id`),
  KEY `FK_content_parameter` (`parameter_id`),
  CONSTRAINT `content_demo_ibfk_1` FOREIGN KEY (`parameter_id`) REFERENCES `parameter` (`id_parameter`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `content_demo_ibfk_2` FOREIGN KEY (`variable_id`) REFERENCES `variable` (`id_variable`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

LOCK TABLES `content_demo` WRITE;
/*!40000 ALTER TABLE `content_demo` DISABLE KEYS */;

INSERT INTO `content_demo` (`id_content`, `waktu`, `parameter_id`, `variable_id`, `total_qty_parameter`, `is_parameter_active`, `state`, `threshold_state_qty_proactive`, `threshold_state_persentase_proactive`, `light_proactive`, `sound_proactive`, `text_to_speech_proactive`, `threshold_state_qty_active`, `threshold_state_persentase_active`, `light_active`, `sound_active`, `text_to_speech_active`, `is_light_strobe_active`, `interval`, `is_threshold_confirm`, `light_color_code`, `sound_id`)
VALUES
	(67,'2024-02-28 19:34:11',1,5,60,0,3,0,0,0,0,NULL,5,8,0,0,'',0,0,0,NULL,0),
	(68,'2024-02-28 19:40:24',1,3,60,1,7,0,0,0,0,NULL,5,8,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',0,0,0,'#ffea00',4),
	(69,'2024-02-28 19:45:43',1,4,60,1,7,0,0,0,0,NULL,5,8,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',0,0,0,'#00ffaa',4);

/*!40000 ALTER TABLE `content_demo` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table content_log
# ------------------------------------------------------------

CREATE TABLE `content_log` (
  `id_content` int(11) NOT NULL AUTO_INCREMENT,
  `relation_key` varchar(50) DEFAULT NULL,
  `waktu` datetime DEFAULT NULL,
  `parameter_id` int(11) DEFAULT 0,
  `variable_id` int(11) DEFAULT 0,
  `variable_tts` varchar(200) DEFAULT NULL,
  `left_string_tts` varchar(200) DEFAULT NULL,
  `right_string_tts` varchar(200) DEFAULT NULL,
  `total_qty_parameter` int(11) DEFAULT 0,
  `is_parameter_active` tinyint(1) DEFAULT 0,
  `is_reverse_threshold` tinyint(1) DEFAULT 0,
  `state` double(4,2) NOT NULL DEFAULT 0.00,
  `threshold_state_qty_proactive` double(4,2) NOT NULL DEFAULT 0.00,
  `threshold_state_persentase_proactive` double(4,2) NOT NULL DEFAULT 0.00 COMMENT 'state_off/total_qty_variable*100',
  `light_proactive` tinyint(1) NOT NULL DEFAULT 0,
  `sound_proactive` tinyint(1) NOT NULL DEFAULT 0,
  `text_to_speech_proactive` text DEFAULT NULL,
  `threshold_state_qty_active` double(4,2) DEFAULT 0.00,
  `threshold_state_persentase_active` double(4,2) DEFAULT 0.00,
  `light_active` tinyint(1) DEFAULT 0,
  `sound_active` tinyint(1) DEFAULT 0,
  `text_to_speech_active` text DEFAULT NULL,
  `is_light_strobe_active` tinyint(1) DEFAULT 0,
  `interval` int(11) DEFAULT 0,
  `is_threshold_confirm` tinyint(1) DEFAULT 0,
  `light_color_code` varchar(50) DEFAULT NULL,
  `sound_id` int(11) DEFAULT 0,
  `query` text DEFAULT NULL,
  `is_data_passive` tinyint(1) DEFAULT 0,
  `is_done_play` tinyint(1) DEFAULT 0,
  `is_controller_done_play` tinyint(1) DEFAULT 0,
  `free_text_tts` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_content`),
  KEY `FK_content_variable` (`variable_id`),
  KEY `FK_content_parameter` (`parameter_id`),
  CONSTRAINT `content_log_ibfk_1` FOREIGN KEY (`parameter_id`) REFERENCES `parameter` (`id_parameter`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `content_log_ibfk_2` FOREIGN KEY (`variable_id`) REFERENCES `variable` (`id_variable`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=latin1;

LOCK TABLES `content_log` WRITE;
/*!40000 ALTER TABLE `content_log` DISABLE KEYS */;

INSERT INTO `content_log` (`id_content`, `relation_key`, `waktu`, `parameter_id`, `variable_id`, `variable_tts`, `left_string_tts`, `right_string_tts`, `total_qty_parameter`, `is_parameter_active`, `is_reverse_threshold`, `state`, `threshold_state_qty_proactive`, `threshold_state_persentase_proactive`, `light_proactive`, `sound_proactive`, `text_to_speech_proactive`, `threshold_state_qty_active`, `threshold_state_persentase_active`, `light_active`, `sound_active`, `text_to_speech_active`, `is_light_strobe_active`, `interval`, `is_threshold_confirm`, `light_color_code`, `sound_id`, `query`, `is_data_passive`, `is_done_play`, `is_controller_done_play`, `free_text_tts`)
VALUES
	(105,'Approved Transactions-Mandiri','2024-08-26 17:37:17',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(106,'Approved Transactions-Mandiri','2024-08-26 17:48:12',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(107,'Approved Transactions-Mandiri','2024-08-26 17:48:14',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(108,'Approved Transactions-Mandiri','2024-08-27 07:46:04',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(109,'Approved Transactions-Mandiri','2024-08-27 07:50:43',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(110,'Declined by Jalin-Mandiri','2024-08-27 07:53:15',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(111,'Declined by Client-Mandiri','2024-08-27 07:53:20',2,51,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(112,'Approved Transactions-Mandiri','2024-08-27 07:53:29',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(113,'Approved Transactions-Mandiri','2024-08-27 07:54:41',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(114,'Declined by Jalin-Mandiri','2024-08-27 07:54:47',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(115,'Declined by Client-Mandiri','2024-08-27 07:54:50',2,51,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(116,'Declined by Client-Mandiri','2024-08-27 07:57:10',2,51,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(117,'Approved Transactions-Mandiri','2024-08-27 07:57:15',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(118,'Declined by Jalin-Mandiri','2024-08-27 07:57:20',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(119,'Declined by Jalin-Mandiri','2024-08-27 08:03:38',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(120,'Declined by Client-BRI','2024-08-27 08:03:41',2,49,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BRI',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(121,'Declined by Client-Mandiri','2024-08-27 08:03:45',2,51,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(122,'Declined by Jalin-BNI','2024-08-27 08:04:37',2,44,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BNI',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(123,'Declined by Jalin-BRI','2024-08-27 08:04:41',2,45,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BRI',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(124,'Declined by Jalin-BTN','2024-08-27 08:04:45',2,46,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BTN',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(125,'Declined by Jalin-BTN','2024-08-27 08:19:40',2,46,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BTN',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(126,'Declined by Jalin-BTN','2024-08-27 08:20:47',2,46,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BTN',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(127,'Declined by Jalin-Mandiri','2024-08-27 08:28:00',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(128,'Declined by Jalin-Mandiri','2024-08-27 08:34:31',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(129,'Declined by Jalin-Mandiri','2024-08-27 08:35:14',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(130,'Approved Transactions-Mandiri','2024-08-27 08:36:15',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(131,'Declined by Jalin-Mandiri','2024-08-27 08:36:20',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(132,'Declined by Jalin-Mandiri','2024-08-27 08:36:48',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(133,'Approved Transactions-Mandiri','2024-08-27 08:36:53',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(134,'Approved Transactions-Mandiri','2024-08-27 08:37:36',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(135,'Declined by Jalin-Mandiri','2024-08-27 08:37:41',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(136,'Declined by Jalin-Mandiri','2024-08-27 08:38:19',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(137,'Approved Transactions-Mandiri','2024-08-27 08:38:24',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(138,'Approved Transactions-Mandiri','2024-08-27 08:51:19',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(139,'Approved Transactions-Mandiri','2024-08-27 08:52:04',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(140,'Approved Transactions-Mandiri','2024-08-27 08:52:38',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(141,'Approved Transactions-Mandiri','2024-08-27 08:54:30',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(142,'Approved Transactions-Mandiri','2024-08-27 08:54:37',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(143,'Approved Transactions-Mandiri','2024-08-27 08:55:50',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(144,'Declined by Jalin-Mandiri','2024-08-27 08:55:58',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(145,'Declined by Jalin-Mandiri','2024-08-27 08:56:43',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(146,'Approved Transactions-Mandiri','2024-08-27 08:56:52',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(147,'Approved Transactions-Mandiri','2024-08-27 08:58:18',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(148,'Declined by Jalin-Mandiri','2024-08-27 08:58:22',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(149,'Declined by Jalin-Mandiri','2024-08-27 08:59:01',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(150,'Approved Transactions-Mandiri','2024-08-27 08:59:05',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(151,'Approved Transactions-Mandiri','2024-08-27 08:59:48',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(152,'Declined by Jalin-Mandiri','2024-08-27 08:59:53',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(153,'Declined by Jalin-Mandiri','2024-08-27 09:00:44',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(154,'Approved Transactions-Mandiri','2024-08-27 09:00:50',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(155,'Approved Transactions-Mandiri','2024-08-27 09:03:46',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(156,'Approved Transactions-Mandiri','2024-08-27 09:10:17',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(157,'Approved Transactions-Mandiri','2024-08-27 09:10:48',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(158,'Approved Transactions-Mandiri','2024-08-27 09:14:36',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(159,'Approved Transactions-Mandiri','2024-08-27 09:14:40',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(160,'Approved Transactions-Mandiri','2024-08-27 09:14:44',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(161,'Approved Transactions-Mandiri','2024-08-27 09:18:41',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(162,'Approved Transactions-Mandiri','2024-08-27 09:28:01',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(163,'Approved Transactions-Mandiri','2024-08-27 09:29:12',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(164,'Approved Transactions-Mandiri','2024-08-27 09:32:20',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(165,'Approved Transactions-Mandiri','2024-08-27 09:34:24',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(166,'Approved Transactions-Mandiri','2024-08-27 09:36:19',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(167,'Approved Transactions-Mandiri','2024-08-27 09:38:29',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(168,'Declined by Jalin-Mandiri','2024-08-27 09:38:38',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(169,'Declined by Jalin-Mandiri','2024-08-27 09:40:29',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(170,'Declined by Jalin-Mandiri','2024-08-27 09:40:36',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(171,'Declined by Jalin-Mandiri','2024-08-27 09:43:41',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(172,'Declined by Client-Mandiri','2024-08-27 09:43:51',2,51,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(173,'Declined by Client-Mandiri','2024-08-27 09:49:04',2,51,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(174,'Declined by Jalin-Mandiri','2024-08-27 09:49:09',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(175,'Declined by Jalin-Mandiri','2024-08-27 09:58:38',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(176,'Declined by Jalin-Mandiri','2024-08-27 10:07:55',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(177,'Declined by Jalin-Mandiri','2024-08-27 10:22:53',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(178,'Declined by Jalin-Mandiri','2024-08-27 10:25:27',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(179,'Approved Transactions-Mandiri','2024-08-27 10:26:55',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(180,'Declined by Jalin-BNI','2024-08-27 10:28:22',2,44,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BNI',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(181,'Declined by Jalin-BNI','2024-08-27 10:39:31',2,44,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BNI',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(182,'Declined by Jalin-BNI','2024-08-27 10:50:48',2,44,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BNI',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(183,'Declined by Jalin-Mandiri','2024-08-27 10:50:54',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(184,'Declined by Client-Mandiri','2024-08-27 10:51:01',2,51,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(185,'Approved Transactions-Mandiri','2024-08-27 10:51:07',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(186,'Approved Transactions-Mandiri','2024-08-27 10:52:10',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(187,'Approved Transactions-Mandiri','2024-08-27 10:55:27',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(188,'Approved Transactions-Mandiri','2024-08-27 10:57:28',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(189,'Declined by Client-Mandiri','2024-08-27 10:57:34',2,51,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(190,'Declined by Jalin-Mandiri','2024-08-27 10:57:39',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(191,'Declined by Jalin-Mandiri','2024-08-27 10:58:54',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(192,'Declined by Jalin-BNI','2024-08-27 10:58:59',2,44,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BNI',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(193,'Declined by System-BTN','2024-08-27 10:59:06',2,54,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BTN',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(194,'Approved Transactions-Mandiri','2024-08-27 10:59:11',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(195,'Approved Transactions-Mandiri','2024-08-27 11:01:57',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(196,'Approved Transactions-Mandiri','2024-08-27 11:03:26',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(197,'Declined by Jalin-Mandiri','2024-08-27 11:03:32',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(198,'Declined by Jalin-Mandiri','2024-08-27 11:08:48',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(199,'Approved Transactions-Mandiri','2024-08-27 11:09:05',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(200,'Approved Transactions-Mandiri','2024-08-27 11:19:54',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(201,'Declined by Client-BTN','2024-08-27 11:20:44',2,50,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BTN',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(202,'Declined by Client-BTN','2024-08-27 11:22:47',2,50,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BTN',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(203,'Declined by Jalin-BNI','2024-08-27 11:22:55',2,44,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm BNI',0,1,0,30.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(204,'Approved Transactions-Mandiri','2024-08-27 11:22:59',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,1,NULL),
	(205,'Approved Transactions-Mandiri','2024-08-27 13:41:15',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,NULL),
	(206,'Approved Transactions-Mandiri','2024-08-27 14:59:48',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,NULL),
	(207,'Approved Transactions-Mandiri','2024-08-27 15:00:16',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,NULL),
	(208,'Approved Transactions-Mandiri','2024-08-27 15:00:18',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,NULL),
	(209,'Approved Transactions-Mandiri','2024-08-27 15:02:30',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,NULL),
	(210,'Declined by Jalin-Mandiri','2024-08-27 19:12:26',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,NULL),
	(211,'Declined by Jalin-Mandiri','2024-08-27 19:34:54',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,NULL),
	(212,'Declined by Jalin-Mandiri','2024-08-27 19:44:04',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,NULL),
	(213,'Declined by Jalin-Mandiri','2024-08-27 19:45:04',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,NULL),
	(214,'Declined by Jalin-Mandiri','2024-08-27 19:47:40',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,NULL),
	(215,'Declined by Jalin-Mandiri','2024-08-27 19:52:17',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,'Decline Jalin Mandiri'),
	(216,'Declined by Jalin-Mandiri','2024-08-27 19:53:06',2,47,NULL,'Perhatian, Saat ini terjadi peningkatan ','pada atm Mandiri',0,1,0,5.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,'Decline Jalin Mandiri'),
	(217,'Approved Transactions-Mandiri','2024-08-27 19:53:13',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,'Approved Transactions Mandiri'),
	(218,'Approved Transactions-Mandiri','2024-08-29 04:44:36',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,'Approved Transactions Mandiri'),
	(219,'Approved Transactions-Mandiri','2024-08-29 04:47:37',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,'Approved Transactions Mandiri'),
	(220,'Approved Transactions-Mandiri','2024-08-29 04:48:41',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,'Approved Transactions Mandiri'),
	(221,'Approved Transactions-Mandiri','2024-08-29 04:50:26',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,'Approved Transactions Mandiri'),
	(222,'Approved Transactions-Mandiri','2024-08-29 04:52:29',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,'Approved Transactions Mandiri'),
	(223,'Approved Transactions-Mandiri','2024-08-29 04:54:24',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,'Approved Transactions Mandiri'),
	(224,'Approved Transactions-Mandiri','2024-08-29 08:57:22',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,'Approved Transactions Mandiri'),
	(225,'Approved Transactions-Mandiri','2024-08-29 08:58:43',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,'Approved Transactions Mandiri'),
	(226,'Approved Transactions-Mandiri','2024-08-29 09:00:41',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,'Approved Transactions Mandiri'),
	(227,'Approved Transactions-Mandiri','2024-08-29 20:25:34',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,'Approved Transactions Mandiri'),
	(228,'Approved Transactions-Mandiri','2024-08-29 20:26:37',2,60,NULL,'Perhatian, Saat ini terjadi penurunan','pada atm mandiri',0,1,1,10.00,0.00,0.00,1,1,NULL,0.00,20.00,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL,1,1,0,'Approved Transactions Mandiri');

/*!40000 ALTER TABLE `content_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table content_transaction
# ------------------------------------------------------------

CREATE TABLE `content_transaction` (
  `id_content` int(11) NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `parameter_id` int(11) NOT NULL DEFAULT 0,
  `variable_id` int(11) NOT NULL DEFAULT 0,
  `total_qty_parameter` int(11) NOT NULL DEFAULT 0,
  `is_parameter_active` tinyint(1) NOT NULL DEFAULT 0,
  `state` int(11) NOT NULL DEFAULT 0,
  `state_source` int(11) DEFAULT 0,
  `threshold_state_qty_proactive` int(11) NOT NULL DEFAULT 0,
  `threshold_state_persentase_proactive` double NOT NULL DEFAULT 0 COMMENT 'state_off/total_qty_variable*100',
  `light_proactive` tinyint(1) NOT NULL DEFAULT 0,
  `sound_proactive` tinyint(1) NOT NULL DEFAULT 0,
  `text_to_speech_proactive` text DEFAULT NULL,
  `threshold_state_qty_active` int(11) DEFAULT 0,
  `threshold_state_persentase_active` double DEFAULT 0,
  `light_active` tinyint(1) DEFAULT 0,
  `sound_active` tinyint(1) DEFAULT 0,
  `text_to_speech_active` text DEFAULT NULL,
  `is_light_strobe_active` tinyint(1) NOT NULL DEFAULT 0,
  `interval` int(11) DEFAULT 0,
  `is_threshold_confirm` tinyint(1) DEFAULT 0,
  `light_color_code` varchar(50) DEFAULT NULL,
  `sound_id` int(11) DEFAULT 0,
  `query` text DEFAULT NULL,
  PRIMARY KEY (`id_content`),
  KEY `FK_content_variable` (`variable_id`),
  KEY `FK_content_parameter` (`parameter_id`),
  CONSTRAINT `content_transaction_ibfk_1` FOREIGN KEY (`parameter_id`) REFERENCES `parameter` (`id_parameter`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `content_transaction_ibfk_2` FOREIGN KEY (`variable_id`) REFERENCES `variable` (`id_variable`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

LOCK TABLES `content_transaction` WRITE;
/*!40000 ALTER TABLE `content_transaction` DISABLE KEYS */;

INSERT INTO `content_transaction` (`id_content`, `waktu`, `parameter_id`, `variable_id`, `total_qty_parameter`, `is_parameter_active`, `state`, `state_source`, `threshold_state_qty_proactive`, `threshold_state_persentase_proactive`, `light_proactive`, `sound_proactive`, `text_to_speech_proactive`, `threshold_state_qty_active`, `threshold_state_persentase_active`, `light_active`, `sound_active`, `text_to_speech_active`, `is_light_strobe_active`, `interval`, `is_threshold_confirm`, `light_color_code`, `sound_id`, `query`)
VALUES
	(7,'2024-02-23 15:04:12',1,1,850,0,0,0,3,5,0,0,NULL,1,0,NULL,NULL,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',0,0,0,'#ff0000',4,NULL),
	(8,'2024-02-23 15:04:12',1,2,800,1,20,0,3,5,1,1,NULL,5,8,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL),
	(9,'2024-02-23 15:04:12',1,3,800,1,5,0,3,5,1,1,NULL,5,8,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL),
	(10,'2024-02-28 15:41:02',1,4,850,0,1,0,3,5,0,0,NULL,5,8,NULL,NULL,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',0,0,0,'#ff0000',4,NULL),
	(11,'2024-02-23 15:04:12',1,5,850,0,0,0,3,5,0,0,NULL,2,3,NULL,NULL,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',0,0,0,'#ff0000',4,NULL),
	(12,'2024-02-23 15:04:12',1,6,800,1,20,0,3,5,1,1,NULL,1,0,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#ff0000',4,NULL),
	(13,'2024-02-23 15:04:12',1,7,800,0,0,0,3,5,0,0,NULL,5,8,NULL,NULL,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',0,0,0,'#ff0000',4,NULL),
	(14,'2024-02-23 15:04:12',1,8,800,0,0,0,3,5,0,0,NULL,5,8,NULL,NULL,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',0,0,0,'#ff0000',4,NULL),
	(15,'2024-02-23 15:04:12',1,9,60,0,0,0,3,5,0,0,NULL,5,8,NULL,NULL,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',0,0,NULL,'#ff0000',4,NULL),
	(16,'2024-02-23 15:04:12',1,10,60,0,0,0,3,5,0,0,NULL,5,8,NULL,NULL,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',0,0,NULL,'#ff0000',4,NULL),
	(17,'2024-02-23 15:04:12',1,11,800,0,0,0,3,5,0,0,NULL,5,8,NULL,NULL,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',0,0,0,'#ff0000',4,NULL),
	(18,'2024-02-23 15:04:12',1,12,60,0,0,0,3,5,0,0,NULL,5,8,NULL,NULL,'',0,0,NULL,'#ff0000',4,NULL),
	(19,'2024-02-23 15:04:12',1,13,60,0,0,0,3,5,0,0,NULL,5,8,NULL,NULL,'',0,0,NULL,'#ff0000',4,NULL),
	(20,'2024-02-23 15:04:12',1,14,60,0,0,0,3,5,0,0,NULL,5,8,NULL,NULL,'',0,0,NULL,'#ff0000',4,NULL),
	(21,'2024-02-23 15:04:12',1,15,60,0,0,0,3,5,0,0,NULL,5,8,NULL,NULL,'',0,0,NULL,'#ff0000',4,NULL),
	(22,'2024-02-23 15:04:12',1,16,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(23,'2024-02-23 15:04:12',1,17,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(24,'2024-02-23 15:04:12',1,18,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(25,'2024-02-23 15:04:12',1,19,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(26,'2024-02-23 15:04:12',1,20,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(27,'2024-02-23 15:04:12',1,21,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(28,'2024-02-23 15:04:12',1,22,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(29,'2024-02-23 15:04:12',1,23,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(30,'2024-02-23 15:04:12',1,24,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(31,'2024-02-23 15:04:12',1,25,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(32,'2024-02-23 15:04:12',1,26,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(33,'2024-02-23 15:04:12',1,27,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(34,'2024-02-23 15:04:12',1,28,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(35,'2024-02-23 15:04:12',1,29,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(36,'2024-02-23 15:04:12',1,30,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(37,'2024-02-23 15:04:12',1,31,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(38,'2024-02-23 15:04:12',1,32,60,0,10,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(40,'2024-02-23 15:04:12',1,34,60,0,0,0,3,5,0,0,NULL,5,8,0,0,NULL,1,0,0,'#ff0000',4,NULL),
	(48,'2024-02-27 09:02:26',2,37,1000,1,0,0,3,5,1,1,NULL,100,10,1,1,'',1,0,0,'#ff0000',4,NULL),
	(49,'2024-02-27 09:04:39',2,38,11296,0,0,0,3,5,0,0,'',5,8,0,0,'',1,0,NULL,'#ff0000',4,NULL),
	(50,'2024-02-27 09:13:49',2,39,11296,0,0,0,3,5,0,0,'',5,8,0,0,'',1,0,NULL,'#ff0000',4,NULL),
	(59,'2024-08-08 15:57:02',2,43,1000,1,0,15,0,0,1,1,NULL,1,0,1,1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0,0,'#f10404',4,NULL);

/*!40000 ALTER TABLE `content_transaction` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table grafana_data
# ------------------------------------------------------------

CREATE TABLE `grafana_data` (
  `metrics` varchar(50) NOT NULL,
  `actual_condition` double(4,2) DEFAULT NULL,
  `waktu` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`metrics`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `grafana_data` WRITE;
/*!40000 ALTER TABLE `grafana_data` DISABLE KEYS */;

INSERT INTO `grafana_data` (`metrics`, `actual_condition`, `waktu`)
VALUES
	('Decline Jalin BNI',20.66,NULL),
	('Decline Jalin BRI',14.22,NULL),
	('Decline Jalin BTN',50.77,NULL),
	('Decline Jalin Mandiri',17.77,NULL),
	('Decline Nasabah BNI',20.10,NULL),
	('Decline Nasabah BRI',23.00,NULL),
	('Decline Nasabah BTN',10.00,NULL),
	('Decline Nasabah Mandiri',1.00,NULL),
	('Decline System BNI',12.00,NULL),
	('Decline System BRI',8.90,NULL),
	('Decline System BTN',5.60,NULL),
	('Decline System Mandiri',12.44,NULL),
	('No Transaksi BNI',11.98,NULL),
	('No Transaksi BRI',29.10,NULL),
	('No Transaksi BTN',8.70,NULL),
	('No Transaksi Mandiri',25.45,NULL);

/*!40000 ALTER TABLE `grafana_data` ENABLE KEYS */;
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
	(1,'Power Plant','0',0,'0','2022-07-21 14:20:58','demo 1'),
	(2,'Lokasi G','0',0,'0','2022-07-21 14:32:32',NULL),
	(3,'Lokasi H','0',0,'0','2022-07-21 14:32:44',NULL),
	(4,'Lokasi A','0',0,'0','2022-07-21 14:32:57',NULL),
	(5,'Lokasi Basecamp','0',0,'0','2022-07-21 14:33:12','demo 2'),
	(6,'Lokasi W','0',0,'0','2022-07-21 14:33:26',NULL),
	(7,'Lokasi D','0',0,'0','2022-07-21 14:33:38',NULL),
	(8,'Lokasi V','0',0,'0','2022-07-21 14:33:56','demo 4'),
	(9,'Lokasi U','0',0,'0','2022-07-21 14:34:08','demo 3'),
	(10,'Lokasi J','0',0,'0','2022-07-21 14:34:20',NULL),
	(11,'Lokasi Cipaku','0',0,'0','2022-07-21 14:34:35','lokasi paling jauh');

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
	(2,'WIRANTO','WIRANTO','JAKARTA','2023-11-15','1604979280','2023-11-15 14:52:37',NULL,'2023-11-15 14:52:38',NULL);

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
  `total_data` double(4,2) DEFAULT NULL,
  PRIMARY KEY (`id_parameter`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

LOCK TABLES `parameter` WRITE;
/*!40000 ALTER TABLE `parameter` DISABLE KEYS */;

INSERT INTO `parameter` (`id_parameter`, `nama_parameter`, `total_data`)
VALUES
	(1,'Dashboard ATM Monitoring',0.00),
	(2,'Dashboard Transaction Monitoring',0.00);

/*!40000 ALTER TABLE `parameter` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pengaturan_sistem
# ------------------------------------------------------------

CREATE TABLE `pengaturan_sistem` (
  `is_system_on` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `field_for_comparison` varchar(50) NOT NULL,
  `compare_by` varchar(10) DEFAULT NULL,
  `global_integrasi_data` enum('active','passive','all') DEFAULT 'passive',
  PRIMARY KEY (`is_system_on`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `pengaturan_sistem` WRITE;
/*!40000 ALTER TABLE `pengaturan_sistem` DISABLE KEYS */;

INSERT INTO `pengaturan_sistem` (`is_system_on`, `field_for_comparison`, `compare_by`, `global_integrasi_data`)
VALUES
	(1,'threshold_state_persentase_active','%','passive');

/*!40000 ALTER TABLE `pengaturan_sistem` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table rfid_log_client
# ------------------------------------------------------------

CREATE TABLE `rfid_log_client` (
  `id_auto` int(11) NOT NULL AUTO_INCREMENT,
  `id_lokasi` int(11) NOT NULL DEFAULT 0,
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
	(1,4,'0013435486','2023-01-15 15:06:45',1,'127.0.0.1'),
	(2,4,'0013435486','2023-01-15 15:09:06',1,'127.0.0.1'),
	(3,4,'0013452938','2023-01-15 15:09:24',1,'127.0.0.1'),
	(4,4,'3646578816','2023-01-15 15:11:19',1,'127.0.0.1'),
	(5,4,'3646578816','2023-01-15 15:11:22',1,'127.0.0.1'),
	(6,4,'3646578816','2023-01-15 15:11:26',1,'127.0.0.1'),
	(7,4,'3646578816','2023-01-15 15:15:40',1,'127.0.0.1'),
	(8,4,'3646578816','2023-01-15 15:15:46',1,'127.0.0.1'),
	(9,4,'3646578816','2023-01-15 15:16:02',1,'127.0.0.1'),
	(10,4,'1604979280','2023-11-15 14:55:06',1,'192.168.3.100');

/*!40000 ALTER TABLE `rfid_log_client` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table rfid_log_server
# ------------------------------------------------------------

CREATE TABLE `rfid_log_server` (
  `id_auto` int(11) NOT NULL AUTO_INCREMENT,
  `id_lokasi` int(11) NOT NULL DEFAULT 0,
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
	(1,4,'0013435486','2023-01-15 15:06:45',1,'127.0.0.1'),
	(2,4,'0013435486','2023-01-15 15:09:06',1,'127.0.0.1'),
	(3,4,'0013452938','2023-01-15 15:09:24',1,'127.0.0.1'),
	(4,4,'3646578816','2023-01-15 15:11:19',1,'127.0.0.1'),
	(5,4,'3646578816','2023-01-15 15:11:22',1,'127.0.0.1'),
	(6,4,'3646578816','2023-01-15 15:11:26',1,'127.0.0.1'),
	(7,4,'3646578816','2023-01-15 15:15:40',1,'127.0.0.1'),
	(8,4,'3646578816','2023-01-15 15:15:46',1,'127.0.0.1'),
	(9,4,'3646578816','2023-01-15 15:16:02',1,'127.0.0.1'),
	(10,4,'1604979280','2023-11-15 14:55:06',1,'192.168.3.100');

/*!40000 ALTER TABLE `rfid_log_server` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sound
# ------------------------------------------------------------

CREATE TABLE `sound` (
  `id_sound` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama_sound` varchar(50) DEFAULT NULL,
  `nama_file` varchar(50) DEFAULT NULL,
  `html_id` varchar(50) DEFAULT NULL,
  `is_tts` tinyint(1) DEFAULT 0,
  `text_tts` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `durasi_sound` int(11) DEFAULT 0,
  PRIMARY KEY (`id_sound`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

LOCK TABLES `sound` WRITE;
/*!40000 ALTER TABLE `sound` DISABLE KEYS */;

INSERT INTO `sound` (`id_sound`, `nama_sound`, `nama_file`, `html_id`, `is_tts`, `text_tts`, `is_active`, `durasi_sound`)
VALUES
	(1,'Sound 1','sound1.mp3','sound1',0,NULL,1,0),
	(2,'Sound 2','sound2.mp3','sound2',0,NULL,1,0),
	(3,'Sound 3','sound3.mp3','sound3',0,NULL,1,0),
	(4,'Alert + Speech',NULL,'sound4',1,'Perhatian, Nama Variabel saat ini mencapai 10 unit atm',1,0);

/*!40000 ALTER TABLE `sound` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table terbilang
# ------------------------------------------------------------

CREATE TABLE `terbilang` (
  `id_terbilang` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bilangan` varchar(50) DEFAULT NULL,
  `index_file` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_terbilang`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

LOCK TABLES `terbilang` WRITE;
/*!40000 ALTER TABLE `terbilang` DISABLE KEYS */;

INSERT INTO `terbilang` (`id_terbilang`, `bilangan`, `index_file`)
VALUES
	(1,'satu','001'),
	(2,'dua','002'),
	(3,'tiga','003'),
	(4,'empat','004'),
	(5,'lima','005'),
	(6,'enam','006'),
	(7,'tujuh','007'),
	(8,'delapan','008'),
	(9,'sembilan','009'),
	(10,'sepuluh','010'),
	(11,'sebelas','011'),
	(12,'belas','012'),
	(13,'puluh','013'),
	(14,'ratus','014'),
	(15,'ribu','015'),
	(16,'seratus','016'),
	(17,'seribu','017');

/*!40000 ALTER TABLE `terbilang` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `avatar` varchar(255) DEFAULT 'default.jpg',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `is_confirmed` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `avatar`, `created_at`, `updated_at`, `is_admin`, `is_confirmed`, `is_deleted`, `phone`, `address`, `active`)
VALUES
	(1,'sm4rtschool','sm4rtschool@gmail.com','$2y$10$4/ouRVhxkyYdqmA8NhqNoeyFtLe0ue8XG0bNQ3X/1fje1dNSDkRFi','default.jpg','2023-12-08 01:36:13',NULL,0,0,0,NULL,NULL,0),
	(2,'yusuf.karimah@gmail.com','yusuf.karimah@gmail.com','$2y$10$1piUsrNnLBPE9Gz7Q8VCFuAIK7Qo8paknVa/637oa3/jYUs2A8bla','default.jpg','2024-06-24 16:48:50',NULL,0,0,0,'085217478087','Jl. Yusuf Karimah Nusantara Raya No. III',1),
	(3,'yoga.pontoh@jalin.co.id','yoga.pontoh@jalin.co.id','$2y$10$rSQl4fb1Z87cBHWLD6aKL.rMLrVKC3H/q2MYReDX7CbjJLh3p4vNO','default.jpg','2024-08-07 10:21:41',NULL,0,0,0,'082266661530','Gd Menara, Jl. Mega Kuningan Barat No.4 No. 1 Kav E, RT.5/RW.2, Kuningan, East Kuningan, Setiabudi, South Jakarta City, Jakarta 12950',1);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table variable
# ------------------------------------------------------------

CREATE TABLE `variable` (
  `id_variable` int(11) NOT NULL AUTO_INCREMENT,
  `nama_variable` varchar(100) NOT NULL,
  `parameter_id` int(11) NOT NULL,
  `index_file` varchar(20) NOT NULL,
  PRIMARY KEY (`id_variable`),
  KEY `FK_variable_parameter` (`parameter_id`),
  CONSTRAINT `FK_variable_parameter` FOREIGN KEY (`parameter_id`) REFERENCES `parameter` (`id_parameter`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;

LOCK TABLES `variable` WRITE;
/*!40000 ALTER TABLE `variable` DISABLE KEYS */;

INSERT INTO `variable` (`id_variable`, `nama_variable`, `parameter_id`, `index_file`)
VALUES
	(1,'ATM In Operational',1,'1'),
	(2,'ATM Out of Order',1,'2'),
	(3,'ATM Supervisor Mode',1,'3'),
	(4,'ATM Cash Low',1,'4'),
	(5,'ATM Cash Out',1,'5'),
	(6,'ATM No Connection',1,'6'),
	(7,'Physical Error - Kaset 1',1,'7'),
	(8,'Physical Error - Kaset 2',1,'8'),
	(9,'Physical Error - Kaset 3',1,'9'),
	(10,'Physical Error - Kaset 4',1,'10'),
	(11,'Physical Error - Stacker',1,'11'),
	(12,'Physical Error - Dispenser',1,'12'),
	(13,'Physical Error - Card Reader',1,'13'),
	(14,'Physical Error - Printer',1,'14'),
	(15,'Physical Error - Printer Paper',1,'15'),
	(16,'Physical Error - Pinpad',1,'16'),
	(17,'Physical Error - Camera',1,'17'),
	(18,'Physical Error - Retained Cards > 5',1,'18'),
	(19,'Physical Error - Trx < 1d (2h - 23)',1,'19'),
	(20,'Physical Error - Trx > 1d',1,'20'),
	(21,'Physical Error - Offline > 1d',1,'21'),
	(22,'Jaringan Komunikasi - Leased-Line',1,'22'),
	(23,'Jaringan Komunikasi - Telkom',1,'23'),
	(24,'Jaringan Komunikasi - Indosat',1,'24'),
	(25,'Jaringan Komunikasi - Telkomsel',1,'25'),
	(26,'Jaringan Komunikasi - MAMO',1,'26'),
	(27,'Jaringan Komunikasi - Lintas Arta',1,'27'),
	(28,'Jaringan Komunikasi - Telenet',1,'28'),
	(29,'Jaringan Komunikasi - PRIMACOM',1,'29'),
	(30,'Jaringan Komunikasi - Tangara',1,'30'),
	(31,'Jaringan Komunikasi - PSN',1,'31'),
	(32,'Jaringan Komunikasi - XL',1,'32'),
	(33,'Jaringan Komunikasi - Sanatel',1,'33'),
	(34,'Jaringan Komunikasi - PSN',1,'34'),
	(35,'Jaringan Komunikasi - PSN',1,'35'),
	(36,'Jaringan Komunikasi - PSN',1,'36'),
	(37,'Virtual ATM Decline',2,'37'),
	(38,'QRCB Decline',2,'38'),
	(39,'TPP Decline',2,'39'),
	(43,'Decline By Sistem BNI',2,''),
	(44,'Decline Jalin BNI',2,''),
	(45,'Decline Jalin BRI',2,''),
	(46,'Decline Jalin BTN',2,''),
	(47,'Decline Jalin Mandiri',2,''),
	(48,'Decline by Client BNI',2,''),
	(49,'Decline by Client BRI',2,''),
	(50,'Decline by Client BTN',2,''),
	(51,'Decline by Client Mandiri',2,''),
	(52,'Decline System BNI',2,''),
	(53,'Decline System BRI',2,''),
	(54,'Decline System BTN',2,''),
	(55,'Decline System Mandiri',2,''),
	(56,'No Transaksi BNI',2,''),
	(57,'No Transaksi BRI',2,''),
	(58,'No Transaksi BTN',2,''),
	(59,'No Transaksi Mandiri',2,''),
	(60,'Approved Transactions Mandiri',2,''),
	(61,'Approved Transactions BNI',2,''),
	(62,'Approved Transactions BRI',2,''),
	(63,'Approved Transactions BTN',2,''),
	(64,'dummy variable',2,'');

/*!40000 ALTER TABLE `variable` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
