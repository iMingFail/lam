/*
SQLyog v10.2 
MySQL - 5.6.35-log : Database - lam
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`lam` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `lam`;

/*Table structure for table `admin_permission_role` */

DROP TABLE IF EXISTS `admin_permission_role`;

CREATE TABLE `admin_permission_role` (
  `permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `admin_permission_role` */

insert  into `admin_permission_role`(`permission_id`,`role_id`) values (2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1);

/*Table structure for table `admin_permissions` */

DROP TABLE IF EXISTS `admin_permissions`;

CREATE TABLE `admin_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '权限名',
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '权限解释名称',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '描述与备注',
  `cid` tinyint(4) NOT NULL COMMENT '级别',
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '图标',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `admin_permissions` */

insert  into `admin_permissions`(`id`,`name`,`label`,`description`,`cid`,`icon`,`created_at`,`updated_at`) values (1,'admin.permission','权限管理','',0,'fa-users','2016-05-21 10:06:50','2016-06-22 13:49:09'),(2,'admin.permission.index','权限列表','',1,'','2016-05-21 10:08:04','2016-05-21 10:08:04'),(3,'admin.permission.create','权限添加','',1,'','2016-05-21 10:08:18','2016-05-21 10:08:18'),(4,'admin.permission.edit','权限修改','',1,'','2016-05-21 10:08:35','2016-05-21 10:08:35'),(5,'admin.permission.destroy ','权限删除','',1,'','2016-05-21 10:09:57','2016-05-21 10:09:57'),(6,'admin.role.index','角色列表','',1,'','2016-05-23 10:36:40','2016-05-23 10:36:40'),(7,'admin.role.create','角色添加','',1,'','2016-05-23 10:37:07','2016-05-23 10:37:07'),(8,'admin.role.edit','角色修改','',1,'','2016-05-23 10:37:22','2016-05-23 10:37:22'),(9,'admin.role.destroy','角色删除','',1,'','2016-05-23 10:37:48','2016-05-23 10:37:48'),(10,'admin.user.index','用户管理','',1,'','2016-05-23 10:38:52','2016-05-23 10:38:52'),(11,'admin.user.create','用户添加','',1,'','2016-05-23 10:39:21','2016-06-22 13:49:29'),(12,'admin.user.edit','用户编辑','',1,'','2016-05-23 10:39:52','2016-05-23 10:39:52'),(13,'admin.user.destroy','用户删除','',1,'','2016-05-23 10:40:36','2016-05-23 10:40:36'),(14,'admin.xunlian.manage','迅联数据','',0,'fa-cny','2017-11-04 13:47:03','2017-11-04 13:47:03'),(15,'admin.xunlian.index','客户列表','',14,'','2017-11-04 13:47:34','2017-11-04 13:47:34'),(16,'admin.xunlian.create','新增客户','',14,'','2017-11-04 17:56:37','2017-11-04 17:56:37'),(17,'admin.xunlian.edit','编辑客户','',14,'','2017-11-04 17:56:56','2017-11-04 17:56:56'),(18,'admin.xunlian.destroy','删除客户','',14,'','2017-11-04 17:57:11','2017-11-04 17:57:36'),(19,'admin.merchant.index','商户号','',14,'','2017-11-04 18:09:19','2017-11-04 18:09:19'),(20,'admin.merchant.create','新建商户号','',14,'','2017-11-04 18:09:40','2017-11-04 18:09:40'),(21,'admin.merchant.edit','编辑商户号','',14,'','2017-11-04 18:09:54','2017-11-04 18:09:54'),(22,'admin.merchant.destroy','删除商户号','',14,'','2017-11-04 18:10:11','2017-11-04 18:10:11');

/*Table structure for table `admin_role_user` */

DROP TABLE IF EXISTS `admin_role_user`;

CREATE TABLE `admin_role_user` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `admin_role_user` */

insert  into `admin_role_user`(`role_id`,`user_id`) values (1,2);

/*Table structure for table `admin_roles` */

DROP TABLE IF EXISTS `admin_roles`;

CREATE TABLE `admin_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色名称',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '备注',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `admin_roles` */

insert  into `admin_roles`(`id`,`name`,`description`,`created_at`,`updated_at`) values (1,'管理员','','2017-11-04 16:47:21','2017-11-04 16:47:21');

/*Table structure for table `admin_users` */

DROP TABLE IF EXISTS `admin_users`;

CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员用户表ID',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `admin_users` */

insert  into `admin_users`(`id`,`name`,`email`,`password`,`remember_token`,`created_at`,`updated_at`) values (1,'root','root@admin.com','$2y$10$NBiBlowwUlfUBtEbVHCNmOjrxtLXdxejE.hba/WZnnUpL5ZhMqQo.',NULL,'2017-11-03 02:54:25','2017-11-03 02:54:25'),(2,'王志明','178738517@qq.com','$2y$10$GVTP1DHkBAatK7zqggJPX.IyW6ONyL9CAFk1Oh/llq4V0S4yxM8eW',NULL,'2017-11-04 16:47:45','2017-11-04 16:47:45');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2016_11_10_033438_create_admin_users_table',1),(4,'2016_11_10_034922_create_admin_permissions_table',1),(5,'2016_11_10_034952_create_admin_roles_table',1),(6,'2016_11_10_035417_create_admin_role_user_table',1),(7,'2016_11_10_035534_create_admin_permission_role_table',1);

/*Table structure for table `operator_logs` */

DROP TABLE IF EXISTS `operator_logs`;

CREATE TABLE `operator_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `model` varchar(100) NOT NULL,
  `aid` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(2) NOT NULL,
  `content` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `operator_logs` */

insert  into `operator_logs`(`id`,`uid`,`model`,`aid`,`type`,`content`,`created_at`,`updated_at`) values (1,15,'AppModelsAdminPermission',1,3,'?????:admin.xunlian.index(????)','2017-11-04 15:51:49','2017-11-04 15:51:49'),(2,15,'\\App\\Models\\Admin\\Permission',1,3,'修改了权限:admin.xunlian.index(客户列表)','2017-11-04 15:55:28','2017-11-04 15:55:28'),(3,1,'\\App\\Models\\Admin\\Role',1,1,'用户{1}添加角色管理员{1}','2017-11-04 16:47:21','2017-11-04 16:47:21'),(4,2,'\\App\\Models\\Admin\\AdminUser',1,1,'添加了用户王志明','2017-11-04 16:47:45','2017-11-04 16:47:45'),(5,1,'\\App\\Models\\Admin\\XunlianUser',1,1,'添加了商户xinkehu ','2017-11-04 17:07:13','2017-11-04 17:07:13'),(6,2,'\\App\\Models\\Admin\\XunlianUser',1,1,'添加了商户客户2','2017-11-04 17:22:01','2017-11-04 17:22:01'),(7,1,'\\App\\Models\\Admin\\XunlianUser',1,3,'编辑了商户xinkehu ','2017-11-04 17:23:41','2017-11-04 17:23:41'),(8,16,'\\App\\Models\\Admin\\Permission',2,1,'添加了权限:admin.xunlian.create(新增客户)','2017-11-04 17:56:37','2017-11-04 17:56:37'),(9,17,'\\App\\Models\\Admin\\Permission',2,1,'添加了权限:admin.xunlian.edit(编辑客户)','2017-11-04 17:56:56','2017-11-04 17:56:56'),(10,18,'\\App\\Models\\Admin\\Permission',2,1,'添加了权限:admin.xunlian.destory(删除客户)','2017-11-04 17:57:16','2017-11-04 17:57:16'),(11,18,'\\App\\Models\\Admin\\Permission',2,3,'修改了权限:admin.xunlian.destroy(删除客户)','2017-11-04 17:57:36','2017-11-04 17:57:36'),(12,1,'\\App\\Models\\Admin\\Role',2,3,'用户{2}编辑角色管理员{1}','2017-11-04 17:57:45','2017-11-04 17:57:45'),(13,19,'\\App\\Models\\Admin\\Permission',2,1,'添加了权限:admin.merchant.index(商户号)','2017-11-04 18:09:19','2017-11-04 18:09:19'),(14,20,'\\App\\Models\\Admin\\Permission',2,1,'添加了权限:admin.merchant.create(新建商户号)','2017-11-04 18:09:40','2017-11-04 18:09:40'),(15,21,'\\App\\Models\\Admin\\Permission',2,1,'添加了权限:admin.merchant.edit(编辑商户号)','2017-11-04 18:09:54','2017-11-04 18:09:54'),(16,22,'\\App\\Models\\Admin\\Permission',2,1,'添加了权限:admin.merchant.destroy(删除商户号)','2017-11-04 18:10:11','2017-11-04 18:10:11'),(17,1,'\\App\\Models\\Admin\\Role',2,3,'用户{2}编辑角色管理员{1}','2017-11-04 18:10:28','2017-11-04 18:10:28');

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

/*Table structure for table `xunlian_merchants` */

DROP TABLE IF EXISTS `xunlian_merchants`;

CREATE TABLE `xunlian_merchants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xuid` int(11) NOT NULL COMMENT '关联的迅联客户',
  `mchntid` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '商户号',
  `inscd` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '93081888' COMMENT '机构号',
  `miyao` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '密钥',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `xunlian_merchants` */

/*Table structure for table `xunlian_users` */

DROP TABLE IF EXISTS `xunlian_users`;

CREATE TABLE `xunlian_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '客户名称',
  `count_price` float(11,2) NOT NULL DEFAULT '0.00' COMMENT '总款项',
  `paid_price` float(11,2) NOT NULL DEFAULT '0.00' COMMENT '已付',
  `bepaid_price` float(11,2) NOT NULL DEFAULT '0.00' COMMENT '未付',
  `remake` text COMMENT '备注',
  `domain` text COMMENT '域名',
  `datum` varchar(200) DEFAULT NULL COMMENT '资料文件,zip',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL COMMENT '客户姓名',
  `phone` varchar(100) DEFAULT NULL COMMENT '手机',
  `wechat` varchar(200) DEFAULT NULL COMMENT '微信群二维码',
  `aid` int(11) NOT NULL DEFAULT '1' COMMENT '所属员工',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `xunlian_users` */

insert  into `xunlian_users`(`id`,`name`,`count_price`,`paid_price`,`bepaid_price`,`remake`,`domain`,`datum`,`created_at`,`updated_at`,`username`,`phone`,`wechat`,`aid`,`status`) values (1,'xinkehu ',7200.00,4000.00,3200.00,'测试的','www.baidu.com',NULL,'2017-11-04 17:07:13','2017-11-04 17:23:41','名字1','732982123',NULL,2,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
