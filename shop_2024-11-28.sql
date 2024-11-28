# ************************************************************
# Sequel Ace SQL dump
# Version 20075
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: localhost (MySQL 5.5.5-10.4.28-MariaDB)
# Database: shop
# Generation Time: 2024-11-27 23:10:16 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table cart
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`products`)),
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;

INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `order_date`, `products`)
VALUES
	(29,24,30.95,'2024-11-27 21:50:16',X'5B7B2270726F647563745F6964223A372C226E616D65223A22436C617373696320426C7565222C227072696365223A2231332E3030222C227175616E74697479223A312C22746F74616C5F7072696365223A31332C22696D6167655F75726C223A22696D616765735C2F626C75655C2F636C6173736963626C75652E6A706567227D2C7B2270726F647563745F6964223A312C226E616D65223A224C757363696F757320526564222C227072696365223A2231332E3030222C227175616E74697479223A312C22746F74616C5F7072696365223A31332C22696D6167655F75726C223A22696D616765735C2F7265645C2F6C757363696F75737265642E6A706567227D5D'),
	(30,24,33.94,'2024-11-27 21:50:33',X'5B7B2270726F647563745F6964223A32322C226E616D65223A224C757875727920476F6C64222C227072696365223A2231352E3030222C227175616E74697479223A312C22746F74616C5F7072696365223A31352C22696D6167655F75726C223A22696D616765735C2F676C6974746572735C2F6C7578757279676F6C642E6A706567227D2C7B2270726F647563745F6964223A34392C226E616D65223A22436F72616C20526564222C227072696365223A2231332E3939222C227175616E74697479223A312C22746F74616C5F7072696365223A31332E393930303030303030303030303030323133313632383230373238303330303535373631333337323830323733343337352C22696D6167655F75726C223A22696D616765735C2F7265645C2F636F72616C7265642E6A706567227D5D'),
	(31,24,36.93,'2024-11-27 22:32:00',X'5B7B2270726F647563745F6964223A32362C226E616D65223A22466F7274756E6520426C7565222C227072696365223A2231352E3939222C227175616E74697479223A312C22746F74616C5F7072696365223A31352E393930303030303030303030303030323133313632383230373238303330303535373631333337323830323733343337352C22696D6167655F75726C223A22696D616765735C2F676C6974746572735C2F666F7274756E65626C75652E6A706567227D2C7B2270726F647563745F6964223A32332C226E616D65223A22436F7070657220476F6C64222C227072696365223A2231352E3939222C227175616E74697479223A312C22746F74616C5F7072696365223A31352E393930303030303030303030303030323133313632383230373238303330303535373631333337323830323733343337352C22696D6167655F75726C223A22696D616765735C2F676C6974746572735C2F636F70706572676F6C642E6A706567227D5D'),
	(32,24,34.93,'2024-11-27 23:06:08',X'5B7B2270726F647563745F6964223A223336222C226E616D65223A224472616D6174696320526564222C227072696365223A2231352E3939222C227175616E74697479223A2231222C22746F74616C5F7072696365223A31352E393930303030303030303030303030323133313632383230373238303330303535373631333337323830323733343337352C22696D6167655F75726C223A22696D616765735C2F676C6974746572735C2F6472616D617469637265642E6A706567227D2C7B2270726F647563745F6964223A223535222C226E616D65223A2250696E6520477265656E222C227072696365223A2231332E3939222C227175616E74697479223A2231222C22746F74616C5F7072696365223A31332E393930303030303030303030303030323133313632383230373238303330303535373631333337323830323733343337352C22696D6167655F75726C223A22696D616765735C2F677265656E5C2F70696E65677265656E2E6A7067227D5D'),
	(33,24,17.95,'2024-11-27 23:13:17',X'5B7B2270726F647563745F6964223A223130222C226E616D65223A22576F6E64657266756C20426C7565222C227072696365223A2231332E3030222C227175616E74697479223A2231222C22746F74616C5F7072696365223A31332C22696D6167655F75726C223A22696D616765735C2F626C75655C2F776F6E64657266756C626C75652E6A706567227D5D'),
	(34,24,36.93,'2024-11-28 00:05:58',X'5B7B2270726F647563745F6964223A223436222C226E616D65223A22476C69747465722050696E6B222C227072696365223A2231352E3939222C227175616E74697479223A2231222C22746F74616C5F7072696365223A31352E393930303030303030303030303030323133313632383230373238303330303535373631333337323830323733343337352C22696D6167655F75726C223A22696D616765735C2F676C6974746572735C2F676C697474657270696E6B2E77656270227D2C7B2270726F647563745F6964223A223336222C226E616D65223A224472616D6174696320526564222C227072696365223A2231352E3939222C227175616E74697479223A2231222C22746F74616C5F7072696365223A31352E393930303030303030303030303030323133313632383230373238303330303535373631333337323830323733343337352C22696D6167655F75726C223A22696D616765735C2F676C6974746572735C2F6472616D617469637265642E6A706567227D5D'),
	(35,24,30.95,'2024-11-28 00:07:48',X'5B7B2270726F647563745F6964223A223136222C226E616D65223A224A756E676C6520477265656E222C227072696365223A2231332E3030222C227175616E74697479223A2231222C22746F74616C5F7072696365223A31332C22696D6167655F75726C223A22696D616765735C2F677265656E5C2F6A756E676C65677265656E2E6A706567227D2C7B2270726F647563745F6964223A223133222C226E616D65223A22437265616D79205461757065222C227072696365223A2231332E3030222C227175616E74697479223A2231222C22746F74616C5F7072696365223A31332C22696D6167655F75726C223A22696D616765735C2F62726F776E5C2F637265616D7974617570652E6A706567227D5D');

/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `color_name` varchar(100) NOT NULL,
  `color_number` varchar(10) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `has_glitter` tinyint(1) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `color_group` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO `products` (`id`, `color_name`, `color_number`, `price`, `has_glitter`, `image_url`, `color_group`, `description`)
VALUES
	(1,'Luscious Red','199',13.00,0,'images/red/lusciousred.jpeg','red','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(2,'Lipstick Red','109',13.00,0,'images/red/lipstickred.jpeg','red','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(3,'Ruby Red','235',13.00,0,'images/red/rubyred.jpeg','red','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(4,'Royal Red','355',13.00,0,'images/red/royalred.jpeg','red','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(6,'Baby Blue','266',13.00,0,'images/blue/babyblue.jpeg','blue','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(7,'Classic Blue','338',13.00,0,'images/blue/classicblue.jpeg','blue','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(8,'Teal Blue','348',13.00,0,'images/blue/tealblue.jpeg','blue','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(9,'Cloudy Blue','215',13.00,0,'images/blue/cloudyblue.webp','blue','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(10,'Wonderful Blue','217',13.00,0,'images/blue/wonderfulblue.jpeg','blue','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(11,'Rosy Brown','283',13.00,0,'images/brown/rosybrown.jpeg','brown','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(12,'Hazelnut Brown','259',13.00,0,'images/brown/hazelnutbrown.jpeg','brown','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(13,'Creamy Taupe','256',13.00,0,'images/brown/creamytaupe.jpeg','brown','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(14,'Bronzed Nude','195',13.00,0,'images/brown/bronzednude.jpeg','brown','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(15,'Mocha Brown','421',13.00,0,'images/brown/mochabrown.jpeg','brown','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(16,'Jungle Green','316',13.00,0,'images/green/junglegreen.jpeg','green','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(17,'Graceful Green','309',13.00,0,'images/green/gracefulgreen.jpeg','green','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(18,'Gentle Jade','323',13.99,0,'images/green/gentlejade.jpeg','green','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(19,'Soft Jade','347',13.00,0,'images/green/softjade.jpeg','green','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(20,'Groovy Green','350',13.00,0,'images/green/groovygreen.jpeg','green','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(21,'Diamond Silver','204',15.99,1,'images/glitters/diamondsilver.jpeg','silver','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(22,'Luxury Gold','130',15.00,1,'images/glitters/luxurygold.jpeg','gold','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(23,'Copper Gold','331',15.99,1,'images/glitters/coppergold.jpeg','gold','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(24,'Fabulous Silver','129',15.99,1,'images/glitters/fabuloussilver.jpeg','silver','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(25,'Copper Crush','425',15.99,1,'images/glitters/coppercrush.jpeg','red','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(26,'Fortune Blue','366',15.99,1,'images/glitters/fortuneblue.jpeg','blue','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(27,'Midnight Purple','248',15.99,1,'images/glitters/midnightpurple.jpeg','purple','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(33,'Mermaid Green','303',15.99,1,'images/glitters/mermaidgreen.jpeg','green','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(34,'Oriental Spice','333',15.99,1,'images/glitters/orientalspice.jpeg','brown','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(36,'Dramatic Red','308',15.99,1,'images/glitters/dramaticred.jpeg','red','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(38,'Heroic Pink','436',13.99,0,'images/pink/heroicpink.webp','pink','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(40,'Bohemian Pink','412',13.99,0,'images/pink/bohemianpink.webp','pink','Pink Gellac&#039;s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(42,'Parisian Pink','423',13.99,0,'images/pink/parisianpink.webp','pink','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(43,'Rosewater Pink','388',13.99,0,'images/pink/rosewaterpink.Webp','pink','Pink Gellac&#039;s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(44,'Sakura Pink','398',13.99,0,'images/pink/sakurapink.webp','pink','Pink Gellac&#039;s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(45,'Vibrant Pink','395',13.99,0,'images/pink/vibrantpink.webp','pink','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(46,'Glitter Pink','141',15.99,1,'images/glitters/glitterpink.webp','pink','Pink Gellac&#039;s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(47,'Mermaid Pink','246',15.99,1,'images/glitters/mermaidpink.webp','pink','Pink Gellac&#039;s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(48,'Milkshake Pink','265',13.99,0,'images/pink/milkshakepink.webp','pink','Pink Gellac&#039;s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(49,'Coral Red','123',13.99,0,'images/red/coralred.jpeg','red','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(50,'Spicy Auburn','394',13.99,0,'images/red/spicyauburn.webp','red','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(51,'Tangerine Red','210',13.99,0,'images/red/tangerinered.webp','red','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(52,'Bombshell Red','430',13.99,0,'images/red/bombshellred.jpg','red','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(53,'Dancing Green','293',13.99,0,'images/green/dancinggreen.jpeg','green','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(54,'Lively Green','397',14.00,0,'images/green/livelygreen.jpg','green','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(55,'Pine Green','385',13.99,0,'images/green/pinegreen.jpg','green','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(56,'Spring Green','284',13.99,0,'images/green/springgreen.jpeg','green','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(57,'Azure Blue','301',13.99,0,'images/blue/azureblue.jpg','blue','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(58,'Indigo Blue','263',13.99,0,'images/blue/indigoblue.jpg','blue','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(59,'Seafoam Blue','145',13.99,0,'images/blue/seafoamblue.jpg','blue','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(60,'Surfing Blue','269',13.99,0,'images/blue/surfingblue.jpg','blue','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(61,'Tiffany Blue','211',13.99,0,'images/blue/tiffanyblue.jpg','blue','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(66,'Babydoll Pink','427',13.99,0,'images/pink/babydollpink.webp','pink','test');

/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table review
# ------------------------------------------------------------

DROP TABLE IF EXISTS `review`;

CREATE TABLE `review` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `products_id` int(11) unsigned NOT NULL,
  `users_id` int(11) unsigned NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `products_id` (`products_id`),
  KEY `users_id` (`users_id`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `review_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `currency` decimal(10,2) DEFAULT 1000.00,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `firstname` varchar(300) NOT NULL,
  `lastname` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `password`, `currency`, `is_admin`, `firstname`, `lastname`)
VALUES
	(23,'admin@admin.be','$2y$12$9G2joNngN.FWo8YgeHGhi.VXwSgjUflb9TlDU95ee85hkHb9A/nru',1000.00,1,'admin','admin'),
	(24,'a','$2y$10$yLq33mT1nQ8xGxe/2ALs0eETe4UI/l98JGxIW9LjEXok7HYZ/JB9C',689.61,0,'Alitha','Pauwels'),
	(25,'z','$2y$10$J3inWo1aIit/O2oxxLxKsOYC0DIaXQzDz8Q45ahfq9nIIL5d8i3aW',1000.00,0,'z','z'),
	(26,'s','$2y$10$9v88.2m5rFTrsPVRwLTnZupt85JDxNq8aqFWaVBrmjS7Y/VQTKfiq',1000.00,0,'s','s'),
	(27,'q','$2y$10$8tM.p7rEKVwtbnPbeZSn..hoxVDxU0URYLTRUDzynDqNJrOatzHNi',1000.00,0,'q','q');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
