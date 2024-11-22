# ************************************************************
# Sequel Ace SQL dump
# Version 20075
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: localhost (MySQL 5.5.5-10.4.28-MariaDB)
# Database: shop
# Generation Time: 2024-11-22 11:06:31 +0000
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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
	(18,'Spring Green','284',13.00,0,'images/green/springgreen.jpeg','green','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
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
	(38,'Heroic Pink','436',13.99,0,'images/pink/heroicpink.webp','pink','PINKYYYYY'),
	(39,'Babydoll Pink','427',13.99,0,'images/pink/babydollpink.webp','pink','Pink Gellac&#039;s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(40,'Bohemian Pink','412',13.99,0,'images/pink/bohemianpink.webp','pink','Pink Gellac&#039;s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(42,'Parisian Pink','423',13.99,0,'images/pink/parisianpink.webp','pink','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(43,'Rosewater Pink','388',13.99,0,'images/pink/rosewaterpink.Webp','pink','Pink Gellac&#039;s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(44,'Sakura Pink','398',13.99,0,'images/pink/sakurapink.webp','pink','Pink Gellac&#039;s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(45,'Vibrant Pink','395',13.99,0,'images/pink/vibrantpink.webp','pink','Pink Gellac&#039;s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(46,'Glitter Pink','141',15.99,1,'images/glitters/glitterpink.webp','pink','Pink Gellac&#039;s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(47,'Mermaid Pink','246',25.99,1,'images/glitters/mermaidpink.webp','pink','Pink Gellac&#039;s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(48,'Milkshake Pink','265',13.99,0,'images/pink/milkshakepink.webp','pink','Pink Gellac&#039;s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.'),
	(49,'Coral Red','123',13.99,0,'images/red/coralred.jpeg','red','Pink Gellac\'s professionele gellak biedt een prachtige, langdurige kleur die zowel trendy als tijdloos is. Deze intens gepigmenteerde kleurtjes zijn perfect voor elke gelegenheid, of je nu gaat voor een subtiele, klassieke look of een gedurfde, opvallende stijl. De formule is ontworpen voor een flexibele, chipvrije afwerking die tot wel twee weken blijft zitten zonder dat je je zorgen hoeft te maken over vervaging of beschadiging. Elk kleurtje heeft een rijke, glanzende finish die de natuurlijke schoonheid van je nagels benadrukt.');

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
  `created_at` date DEFAULT curdate(),
  PRIMARY KEY (`id`),
  KEY `product_id` (`products_id`),
  KEY `user_id` (`users_id`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `review_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;

INSERT INTO `review` (`id`, `text`, `products_id`, `users_id`, `created_at`)
VALUES
	(38,'cccc',18,23,'2024-11-21'),
	(39,'mooiii',33,24,'2024-11-22');

/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;


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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `password`, `currency`, `is_admin`, `firstname`, `lastname`)
VALUES
	(23,'admin@admin.be','$2y$12$9G2joNngN.FWo8YgeHGhi.VXwSgjUflb9TlDU95ee85hkHb9A/nru',1000.00,1,'admin','admin'),
	(24,'a','$2y$12$.3.q1mMtfMMt4iYc1smqgehgA75udIKGXSbAQ31A84Hf0bAz2mdVe',1000.00,0,'Alitha','Pauwels');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
