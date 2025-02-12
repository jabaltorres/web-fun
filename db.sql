/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.9-MariaDB, for debian-linux-gnu (aarch64)
--
-- Host: db    Database: db
-- ------------------------------------------------------
-- Server version	10.4.34-MariaDB-1:10.4.34+maria~ubu2004-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `hashed_password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES
(1,'Jabal','Torres','jabaltorres@gmail.com','jabaltorres','$2y$10$sarvONdYXnBjlIJUEruVKe1Z4EMyXtNfTExkX2rf7paPbjt2YlvDy');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_list`
--

DROP TABLE IF EXISTS `contact_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `rank_id` int(11) DEFAULT NULL,
  `favorite` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_ranking` (`rank_id`),
  CONSTRAINT `fk_ranking` FOREIGN KEY (`rank_id`) REFERENCES `rankings` (`rank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_list`
--

LOCK TABLES `contact_list` WRITE;
/*!40000 ALTER TABLE `contact_list` DISABLE KEYS */;
INSERT INTO `contact_list` VALUES
(1,'Jabal','Torres','jabaltorres@gmail.com','Lorem ipsum dolor sit amet, consectetur adipiscing elit. \r\n\r\nSed gravida mauris a arcu efficitur venenatis. \r\n\r\nSed porta lacus tortor. Suspendisse lobortis turpis non neque ultrices, at ornare neque vehicula.','img_66357d27739b30.30818654.jpg','555-740-3382',5,1),
(2,'Jabal','Torres','jabal@fivetwofive.com','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed gravida mauris a arcu efficitur venenatis. Sed porta lacus tortor. Suspendisse lobortis turpis non neque ultrices, at ornare neque vehicula.','model-002.png','555-789-1235',1,0),
(3,'Bill','Gates','fake.email.address@gmail.com','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed gravida mauris a arcu efficitur venenatis. Sed porta lacus tortor. Suspendisse lobortis turpis non neque ultrices, at ornare neque vehicula.','model-003.png','555-123-4567',3,0),
(4,'Bob','Barker','fake.email.address@gmail.com','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed gravida mauris a arcu efficitur venenatis. Sed porta lacus tortor. Suspendisse lobortis turpis non neque ultrices, at ornare neque vehicula.','model-004.png','650-123-3382',4,0),
(13,'Terry','Cloth','faking.email.address@gmail.com','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed gravida mauris a arcu efficitur venenatis. Sed porta lacus tortor. Suspendisse lobortis turpis non neque ultrices, at ornare neque vehicula.','model-005.png','555-789-1234',2,1),
(14,'Jeezy','Pickles','faker.email.address@gmail.com','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed gravida mauris a arcu efficitur venenatis. Sed porta lacus tortor. Suspendisse lobortis turpis non neque ultrices, at ornare neque vehicula.',NULL,'555-123-4566',4,0),
(15,'Oscar','Myeres','fakey.email.address@gmail.com','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed gravida mauris a arcu efficitur venenatis. ','img_6636a169d9eed1.82250801.png','556-789-1236',1,1),
(16,'Andy','Dandy','andy.dandy@gmail.com','',NULL,'',NULL,0);
/*!40000 ALTER TABLE `contact_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) DEFAULT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `position` int(3) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT NULL,
  `content` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subject_id` (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES
(2,1,'History',2,1,'<div id=\"content\">\r\n<h1>History</h1>\r\n<p><strong>Our Beginnings</strong><br>KrateCMS was born out of a passion for organizing and managing information efficiently. Like a record crate that stores treasured vinyl albums, our platform was built to help individuals and businesses store, access, and manage their data with ease. Initially conceived as a simple project to help users keep track of their contacts, KrateCMS has since evolved into a fully-featured content management system.</p>\r\n<p><strong>Growth and Development</strong><br>As more users embraced the simplicity and flexibility of KrateCMS, it became clear that there was a need to expand the system&rsquo;s capabilities. Over the years, we added features such as user roles, advanced search functionalities, and custom data fields, all designed to help our users tailor their experience to fit their specific needs. This growth has been driven by feedback from our dedicated community, whose insights have shaped the evolution of KrateCMS.</p>\r\n<p><strong>A Turning Point</strong><br>The introduction of cloud hosting and modern security practices marked a major turning point for KrateCMS. By moving to cloud-based infrastructure, we ensured that our platform remained accessible and scalable, while also maintaining top-tier security standards. This shift has allowed us to support larger databases, offer better performance, and protect our users&rsquo; data with greater reliability.</p>\r\n<p><strong>Looking to the Future</strong><br>Today, KrateCMS continues to evolve, adapting to the ever-changing landscape of content management. With plans to integrate more automation features and deeper analytics, the platform is set to meet the growing demands of modern businesses. Our journey is far from over, and we are excited to see how KrateCMS will continue to empower users in the years to come.</p>\r\n</div>'),
(8,5,'To Dos',2,1,'<div id=\"content\">\r\n<h1>To Dos</h1>\r\n<p>Hot chicken locavore actually helvetica. Intelligentsia bicycle rights yuccie, readymade green juice waistcoat farm-to-table literally. Bitters knausgaard schlitz photo booth tumeric artisan. Yr gastropub whatever hexagon, cardigan disrupt tote bag iPhone aesthetic actually health goth trust fund artisan tousled lumbersexual. Normcore vape viral next level. Tattooed deep v everyday carry polaroid. Heirloom retro godard enamel pin.</p>\r\n<ol>\r\n<li>Add title field for pages</li>\r\n<li>Second Item</li>\r\n<li>Third item</li>\r\n</ol>\r\n<h2>What Else Can I Add Here?</h2>\r\n<ul>\r\n<li>One cool thing</li>\r\n<li>Another cool thing</li>\r\n<li>Third cool thing</li>\r\n</ul>\r\n</div>'),
(9,3,'Read Me',3,1,'<div id=\"content\">\r\n<h1>Read Me</h1>\r\n<p class=\"p1\">KrateCMS is a lightweight, flexible content management system designed to help users efficiently manage data and content. Built for scalability and ease of use, KrateCMS empowers both individuals and businesses to organize their information with minimal technical effort. Whether you&rsquo;re tracking personal collections or managing large-scale projects, KrateCMS provides the tools to handle it all.</p>\r\n<p class=\"p3\"><strong>Features</strong></p>\r\n<ul>\r\n<li class=\"p4\"><strong>Customizable Content Types</strong>: Define and organize content to fit your unique needs.</li>\r\n<li class=\"p4\"><strong>User Role Management</strong>: Control access and permissions with a simple role-based system.</li>\r\n<li class=\"p4\"><strong>Search and Filter</strong>: Quickly find and sort through data with advanced search functionalities.</li>\r\n<li class=\"p4\"><strong>Secure Cloud Hosting</strong>: Safeguard your data with modern security practices and reliable cloud infrastructure.</li>\r\n</ul>\r\n</div>'),
(11,5,'Hello World',1,1,'<div id=\"content\">\r\n<h1>Hello World</h1>\r\n<p>Obligatory Hello World post.</p>\r\n</div>');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rankings`
--

DROP TABLE IF EXISTS `rankings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rankings` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `rank_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rankings`
--

LOCK TABLES `rankings` WRITE;
/*!40000 ALTER TABLE `rankings` DISABLE KEYS */;
INSERT INTO `rankings` VALUES
(1,'Great'),
(2,'Good'),
(3,'Ok'),
(4,'Bad'),
(5,'Worst');
/*!40000 ALTER TABLE `rankings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` enum('string','integer','float','boolean','json','array') NOT NULL DEFAULT 'string',
  `category` varchar(50) DEFAULT 'general',
  `description` varchar(255) DEFAULT NULL,
  `is_private` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`setting_id`),
  UNIQUE KEY `setting_key` (`setting_key`),
  KEY `idx_setting_key` (`setting_key`),
  KEY `idx_category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES
(1,'dark_mode','0','boolean','general','Enable dark mode',0,'2025-01-31 03:41:55','2025-02-01 07:40:50',1,1),
(2,'logo_url','https://916marketing.com/wp-content/uploads/2025/01/916-Maketing-Logo.svg','string','branding','Logo Url',0,'2025-01-31 04:06:32','2025-01-31 05:24:22',1,1),
(3,'audio_source','https://jabaltorres.com/wp-content/uploads/2024/06/Cinematic-Adventures.mp3','string','audio','Cinematix Adventures',0,'2025-01-31 04:41:11','2025-01-31 05:43:02',1,1),
(27,'site_name','KrateCMS','string','site','Site Name',0,'2025-01-31 05:26:05','2025-02-01 02:05:14',1,1),
(28,'site_url','https://916marketing.com','string','site','Site URL',0,'2025-01-31 05:27:10','2025-02-01 02:39:13',1,1),
(29,'admin_email','jabaltorres@gmail.com','string','admin','JT\'s email',0,'2025-01-31 05:27:29','2025-01-31 23:51:32',1,1),
(30,'site_tagline','Simple. Scalable. Smart Content Management.','string','site','Site Tagline',0,'2025-01-31 05:28:53','2025-02-01 02:39:05',1,1),
(31,'site_description','A Very Cool Descripition','string','site','Agreed, in deed',0,'2025-01-31 05:29:20','2025-02-01 02:05:26',1,1),
(32,'site_author','Jabal Torres','string','site','',0,'2025-01-31 05:29:38','2025-02-01 02:04:32',1,1),
(38,'audio_player_on','0','boolean','audio','Audio player on by default',0,'2025-01-31 16:39:12','2025-02-01 12:21:23',1,1),
(52,'postmark_from_email','info@jabaltorres.com','string','postmark','Postmark Sender Signature',0,'2025-01-31 23:35:56','2025-01-31 23:35:56',1,1),
(60,'social_facebook','https://facebook.com','string','social','',0,'2025-02-01 00:39:45','2025-02-01 02:01:42',1,1),
(61,'social_linkedin','https://linkedin.com','string','social','',0,'2025-02-01 00:40:30','2025-02-01 02:01:57',1,1),
(62,'social_instagram','https://instagram.com','string','social','',0,'2025-02-01 00:41:01','2025-02-01 02:01:50',1,1),
(65,'audio_default_on_load','https://jabaltorres.com/wp-content/uploads/2025/01/THATS-WHATS-UP.mp3','string','audio','Audio to play on load',0,'2025-02-01 02:01:13','2025-02-01 02:07:51',1,1),
(75,'admin_name','Jabal Torres','string','admin','Admin Name',0,'2025-02-01 02:07:14','2025-02-01 02:07:14',1,1);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) DEFAULT NULL,
  `position` int(3) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES
(1,'About Me',1,1),
(3,'Documentation',2,1),
(5,'Resources',3,1);
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('Administrator','Manager','Standard User','Guest') NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Jabal','Torres','jabaltorres@gmail.com','jabaltorres','$2y$10$DZyc2Sh2ky/3Y9.tkAxiOetILtN8ThbkDvUW.JWsdgDIpf0rG044C','Administrator'),
(2,'Clifford','Smith','fake.email4@gmail.com','rafael','$2y$10$WsKN1CWtZuR.W9JU856EZ.GvknSA7xQU9/wR69QWM.2O530EQ9KGm','Administrator'),
(3,'John','Doe','john.doe@gmail.com','johndoe','$2y$10$odWrJUhCjbk8eUc.auZ02uruWX83qhY4dDIl5nB2bia69t.y8.lhW','Manager'),
(4,'Eloney','Musk','elon.musk@gmail.com','elon','$2y$10$cqzSWh7r6DKm8/NNzYLslOr54uIn4tCRDfsejibdWaeLct2Jg9WvW','Manager'),
(5,'Brew','Bro','brew.bro@gmail.com','brewbro','$2y$10$uySAG82QJ8H8ORnGiSfnUuvnuUMsYrC8cKG/XXCAgxme/i9Hsvnu6','Standard User'),
(6,'Jason','Wilde','j.wilde@gmail.com','wilde','$2y$10$MhmkMUl5lD/gKDXWmmXNq.WsZB1GyA/hDBKhoFEJ4sqNr2LS2YMHm','Guest');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vinyl_records`
--

DROP TABLE IF EXISTS `vinyl_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vinyl_records` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `release_year` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `catalog_number` varchar(255) DEFAULT NULL,
  `format` enum('12"','10"','7"') NOT NULL,
  `speed` enum('33 1/3 RPM','45 RPM','78 RPM') NOT NULL,
  `condition` enum('Mint','Near Mint','Very Good','Good','Fair','Poor') NOT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `front_image` varchar(255) DEFAULT NULL,
  `back_image` varchar(255) DEFAULT NULL,
  `purchase_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `audio_file_url` varchar(255) DEFAULT NULL,
  `bpm` int(11) DEFAULT NULL,
  PRIMARY KEY (`record_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vinyl_records`
--

LOCK TABLES `vinyl_records` WRITE;
/*!40000 ALTER TABLE `vinyl_records` DISABLE KEYS */;
INSERT INTO `vinyl_records` VALUES
(1,'The Jump Off Vol.1','The Perfectionist / Realz','Hip Hop',2007,'Independent','00000','12\"','33 1/3 RPM','Mint','2024-09-01',30.00,'These are notes','','','https://jabaltorres.com/the-jump-off-vol-1/','2024-09-07 06:42:50','2025-02-01 13:40:16','',0),
(2,'The Elmatic Instrumentals','Will Sessions','Rap',2011,'Fat Beats Records','FB5149','12\"','33 1/3 RPM','Near Mint','2016-03-10',20.00,'Elmatic had been initially planned and announced in 2008 as a tribute to the historic 1994 album Illmatic by Nas, but it wasnâ€™t until early 2011 that Elzhi and his manager Jae Barber agreed that it would be best to recreate all of the beats from scratch--and there was clearly nobody who could do it better than producer Sam Beaubien and Will Sessions. Since itâ€™s widely considered to be the holy grail of hip-hop recordings, the prospect of duplicating the music from Illmatic was daunting. By using the original sample sources of the albumâ€™s tracks as a foundation, producer Sam Beaubien and the band members managed to recreate both the sound and the mood of the classic album with stunning precision on Elmatic, exceeding lofty expectations set by loyal fans and skeptical critics alike.','',NULL,'https://willsessions.bandcamp.com/album/the-elmatic-instrumentals','2024-09-07 22:40:08','2025-01-30 21:40:52',NULL,NULL),
(3,'The Miseducation of Lauryn Hill','Lauryn Hill','Hip Hop',2000,'Ruffhouse Records / Columbia','MOVLP060','12\"','33 1/3 RPM','Very Good','2017-09-11',24.00,'','',NULL,'https://tinyurl.com/tmeolh','2024-09-07 22:49:05','2025-01-30 21:40:52','',0),
(4,'Cinematic Adventure','Jabal Torres ft Reals','Hip Hop',2024,'Independent','123456','12\"','33 1/3 RPM','Mint','2024-06-04',19.99,'Laculis et metus. Duis in magna laoreet, varius nisl eget, rutrum velit. Curabitur volutpat turpis orci, et ullamcorper elit ultrices sed.','',NULL,'https://jabaltorres.com/the-jump-off-vol-1/','2024-09-08 06:29:06','2025-02-01 13:27:54','https://jabaltorres.com/wp-content/uploads/2024/06/Cinematic-Adventures.mp3',98),
(6,'Bring Da Ruckus','Wu-Tang Clan','Hip Hop',1994,'Wu Tang','0000','12\"','33 1/3 RPM','Mint','2024-09-03',12.00,'',NULL,NULL,'https://store.thewutangclan.com/products/bring-da-ruckus-t-shirt','2024-09-12 03:15:08','2025-02-01 15:16:23','https://jabaltorres.com/wp-content/uploads/2024/09/Wu-Tang-Clan-Bring-Da-Ruckus.mp3',120);
/*!40000 ALTER TABLE `vinyl_records` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-01 12:11:13
