DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) DEFAULT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `position` int(3) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `fk_subject_id` (`subject_id`)
);

INSERT INTO `pages` VALUES (1,1,'Globe Bank',1,1,NULL),(2,1,'History',2,1,NULL),(3,1,'Leadership',3,1,NULL),(4,1,'Contact Us',4,1,NULL),(5,2,'Banking',1,1,NULL),(6,2,'Credit Cards',2,1,NULL),(7,2,'Mortgages',3,1,NULL),(8,3,'Checking',1,1,NULL),(9,3,'Loans',2,1,NULL),(10,3,'Merchant Services',3,1,NULL);

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) DEFAULT NULL,
  `position` int(3) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `subjects` VALUES (1,'About Globe Bank',1,1),(2,'Consumer',2,1),(3,'Small Business',3,0),(5,'Commercial',4,1);
