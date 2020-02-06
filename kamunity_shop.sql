/*
SQLyog Enterprise - MySQL GUI v8.12 
MySQL - 5.5.62 : Database - kamunity_shop
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`kamunity_shop` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `kamunity_shop`;

/*Table structure for table `cart` */

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `datecart` bigint(20) DEFAULT NULL,
  `products` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `cart` */

/*Table structure for table `catalog` */

DROP TABLE IF EXISTS `catalog`;

CREATE TABLE `catalog` (
  `id` int(11) NOT NULL,
  `name` varchar(512) DEFAULT NULL,
  `parentid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ind_parentid` (`parentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `catalog` */

/*Table structure for table `certificate` */

DROP TABLE IF EXISTS `certificate`;

CREATE TABLE `certificate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `descr` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `certificate` */

/*Table structure for table `firms` */

DROP TABLE IF EXISTS `firms`;

CREATE TABLE `firms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT 'ООО',
  `INN` varchar(12) DEFAULT '0',
  `KPP` varchar(9) DEFAULT '0',
  `OGRN` varchar(20) DEFAULT '0',
  `BIK` varchar(10) DEFAULT '0',
  `bank` varchar(255) DEFAULT '0',
  `account` varchar(21) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `firms` */

/*Table structure for table `idcode` */

DROP TABLE IF EXISTS `idcode`;

CREATE TABLE `idcode` (
  `mysql_id` int(11) NOT NULL AUTO_INCREMENT,
  `1c_code` char(11) DEFAULT NULL,
  PRIMARY KEY (`mysql_id`),
  UNIQUE KEY `1c_code` (`1c_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `idcode` */

/*Table structure for table `info` */

DROP TABLE IF EXISTS `info`;

CREATE TABLE `info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `current` int(1) DEFAULT '0',
  `delivery` int(11) DEFAULT '250',
  `name` varchar(255) DEFAULT NULL,
  `INN` varchar(12) DEFAULT NULL,
  `KPP` varchar(9) DEFAULT NULL,
  `OGRN` varchar(20) DEFAULT NULL,
  `BIK` varchar(10) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `account` varchar(21) DEFAULT NULL,
  `accountbank` varchar(21) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `director` varchar(255) DEFAULT NULL,
  `accountant` varchar(255) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `freedelivery` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `info` */

insert  into `info`(`id`,`current`,`delivery`,`name`,`INN`,`KPP`,`OGRN`,`BIK`,`bank`,`account`,`accountbank`,`address`,`director`,`accountant`,`phone`,`freedelivery`) values (1,1,250,'Общество с ограниченной ответственностью Кам-юнити','4105041756','410501001','1120021225222','040507803','ОАО СКБ ПРИМОРЬЯ Г ВЛАДИВОСТОК','40702810400590002357','30101810200000000803','684005, Камчатский край, г.Елизово, ул.Омская 79','Моисеенко Р.А.','Моисеенко Р.А.','89004444495',10000);

/*Table structure for table `paydoc` */

DROP TABLE IF EXISTS `paydoc`;

CREATE TABLE `paydoc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productorder` int(11) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `datepaydoc` bigint(20) DEFAULT NULL,
  `numberpaydoc` varchar(50) DEFAULT NULL,
  `typepaydoc` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `paydoc` */

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `parentid` int(11) DEFAULT '0',
  `name` varchar(512) DEFAULT NULL,
  `descr` text,
  `techinfo` text,
  `price` float DEFAULT '0',
  `remains` float DEFAULT '0',
  `unit` varchar(6) DEFAULT NULL,
  `recom` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ind_parentid` (`parentid`),
  KEY `ind_recom` (`recom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `product` */

/*Table structure for table `productorder` */

DROP TABLE IF EXISTS `productorder`;

CREATE TABLE `productorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `dateorder` bigint(20) DEFAULT NULL,
  `products` text,
  `orderstatus` int(11) DEFAULT '0',
  `delivery` int(11) DEFAULT '0',
  `comment` text,
  `total` float DEFAULT NULL,
  `datefinish` bigint(20) DEFAULT NULL,
  `paydocid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `productorder` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT '-',
  `secondname` varchar(255) CHARACTER SET koi8r DEFAULT '-',
  `lastname` varchar(255) DEFAULT '-',
  `phone` varchar(11) DEFAULT '-',
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT '-',
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT 'user',
  `cardpay` varchar(127) DEFAULT '0',
  `firm` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `user` */

insert  into `user`(`id`,`firstname`,`secondname`,`lastname`,`phone`,`email`,`address`,`password`,`role`,`cardpay`,`firm`) values (31,'Роман','Александрович','Моисеенко','89147857579','saint_johnny@mail.ru','Камчатский край, г. Елизово, ул. Школьная д.9 кв.5(2)','$2y$10$IjeurasPLcFZRHdaA7dOM.iMF8f5YCsFs/t3oWNkxsfVOW8ldCr5q','user','0','{\"namefirm\":\"ООО Пивков\",\"INN\":\"1234567890\",\"KPP\":\"123456789\",\"OGRN\":\"1234567890123\",\"BIK\":\"123456789\",\"bank\":\"СБЕРБАНК ООО ПАО ИТД\",\"account\":\"12345678901234567890\"}'),(32,'Роман','Александрович','Моисеенко','89147857579','admin@mail.ru','Камчатский край, г. Елизово, ул. Школьная д.9 кв.5','$2y$10$5ger3JNOWBse9BCWqv4RYeMxFxpM/BvGitzpYxJcyVtyugn5ZJx46','admin','0','');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
