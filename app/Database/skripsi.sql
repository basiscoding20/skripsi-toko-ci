DROP TABLE IF EXISTS `toko_auth_activation_attempts`;
CREATE TABLE `toko_auth_activation_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(191) NOT NULL,
  `user_agent` varchar(191) NOT NULL,
  `token` varchar(191) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `toko_auth_activation_attempts` WRITE;
UNLOCK TABLES;

DROP TABLE IF EXISTS `toko_auth_groups`;
CREATE TABLE `toko_auth_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

LOCK TABLES `toko_auth_groups` WRITE;
INSERT INTO `toko_auth_groups` VALUES (1,'admin','Role Admin'),(2,'seller','Role Seller'),(3,'user','Role User'),(4,'kurir','Role Kurir'),(5,'teknisi','Role Teknisi');
UNLOCK TABLES;

DROP TABLE IF EXISTS `toko_auth_permissions`;
CREATE TABLE `toko_auth_permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

LOCK TABLES `toko_auth_permissions` WRITE;
INSERT INTO `toko_auth_permissions` VALUES (1,'manage-users','Manage All Users'),(2,'manage-profile','Manage User\'s Profile'),(3,'manage-categories','Manage All Categories'),(4,'manage-products','Manage All Products');
UNLOCK TABLES;

DROP TABLE IF EXISTS `toko_users`;
CREATE TABLE `toko_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text,
  `username` varchar(30) NOT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `password_hash` varchar(191) NOT NULL,
  `reset_hash` varchar(191) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(191) DEFAULT NULL,
  `status` varchar(191) DEFAULT NULL,
  `status_message` varchar(191) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nik` (`nik`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

LOCK TABLES `toko_users` WRITE;
INSERT INTO `toko_users` VALUES (1,'Administrator','admin@gmail.com','1111111111111111','111111111111','Address','admin','1624367400_dfe17ef09c20a3474616.jpg','$2y$10$O064i9/HwdCg3IYXoefCZOkE.YKuwmQfpTXdKUOpEbLqFybu6YVGG',NULL,NULL,NULL,NULL,NULL,NULL,1,0,'2021-06-21 20:53:28','2021-06-21 20:53:28',NULL),(2,'Seller Toko','seller@gmail.com','1111111111111112','111111111112','Address Seller','seller','1624372462_02f9fb4f66d45b505469.jpg','$2y$10$Il4LWsv7.Q8gzZda9XmBR.VY7PvUmvhFUCfUFQRMwW3sEx4qU2t6y',NULL,NULL,NULL,NULL,NULL,NULL,1,0,'2021-06-22 01:11:16','2021-06-22 01:11:16',NULL),(3,'User','user@gmail.com','1111111111111113','111111111113','Alamat User','user','1624373953_2052f8862aecccfdb454.jpg','$2y$10$51Mz7XVdAw8vZxs17IiQA.uJB7ve86HgRHDy8nqPy4dHIKHJ2qA7y',NULL,NULL,NULL,NULL,NULL,NULL,1,0,'2021-06-22 21:59:13','2021-06-22 21:59:13',NULL);
UNLOCK TABLES;

DROP TABLE IF EXISTS `toko_auth_groups_permissions`;
CREATE TABLE `toko_auth_groups_permissions` (
  `group_id` int(11) unsigned NOT NULL DEFAULT '0',
  `permission_id` int(11) unsigned NOT NULL DEFAULT '0',
  KEY `toko_auth_groups_permissions_permission_id_foreign` (`permission_id`),
  KEY `group_id_permission_id` (`group_id`,`permission_id`),
  CONSTRAINT `toko_auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `toko_auth_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `toko_auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `toko_auth_permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `toko_auth_groups_permissions` WRITE;
UNLOCK TABLES;

DROP TABLE IF EXISTS `toko_auth_groups_users`;
CREATE TABLE `toko_auth_groups_users` (
  `group_id` int(11) unsigned NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  KEY `toko_auth_groups_users_user_id_foreign` (`user_id`),
  KEY `group_id_user_id` (`group_id`,`user_id`),
  CONSTRAINT `toko_auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `toko_auth_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `toko_auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `toko_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `toko_auth_groups_users` WRITE;
INSERT INTO `toko_auth_groups_users` VALUES (1,1),(2,2),(3,3);
UNLOCK TABLES;

DROP TABLE IF EXISTS `toko_auth_logins`;
CREATE TABLE `toko_auth_logins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

LOCK TABLES `toko_auth_logins` WRITE;
INSERT INTO `toko_auth_logins` VALUES (1,'127.0.0.1','admin',1,'2021-06-21 20:53:43',0),(2,'127.0.0.1','admin@gmail.com',1,'2021-06-21 20:55:01',1),(3,'127.0.0.1','admin@gmail.com',1,'2021-06-21 23:57:58',1),(4,'127.0.0.1','admin@gmail.com',1,'2021-06-22 00:01:23',1),(5,'127.0.0.1','admin@gmail.com',1,'2021-06-22 00:56:27',1),(6,'127.0.0.1','seller@gmail.com',2,'2021-06-22 01:11:30',1),(7,'127.0.0.1','admin@gmail.com',1,'2021-06-22 09:10:38',1),(8,'127.0.0.1','admin@gmail.com',1,'2021-06-22 18:11:28',1),(9,'127.0.0.1','seller@gmail.com',2,'2021-06-23 09:41:55',1),(10,'127.0.0.1','admin@gmail.com',1,'2021-06-23 10:49:28',1),(11,'127.0.0.1','admin@gmail.com',1,'2021-06-23 10:49:56',1),(12,'127.0.0.1','admin@gmail.com',1,'2021-06-23 22:36:08',1),(13,'127.0.0.1','admin@gmail.com',1,'2021-06-24 10:58:57',1),(14,'127.0.0.1','admin@gmail.com',1,'2021-06-24 19:39:13',1),(15,'127.0.0.1','admin',NULL,'2021-06-24 20:13:01',0),(16,'127.0.0.1','admin@gmail.com',1,'2021-06-24 20:13:12',1),(17,'127.0.0.1','admin@gmail.com',1,'2021-06-25 11:27:02',1),(18,'127.0.0.1','admin',NULL,'2021-06-25 15:47:19',0),(19,'127.0.0.1','admin@gmail.com',1,'2021-06-25 15:47:28',1),(20,'127.0.0.1','user@gmail.com',3,'2021-06-26 17:45:19',1),(21,'127.0.0.1','user@gmail.com',3,'2021-06-26 21:45:18',1);
UNLOCK TABLES;

DROP TABLE IF EXISTS `toko_auth_reset_attempts`;
CREATE TABLE `toko_auth_reset_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL,
  `ip_address` varchar(191) NOT NULL,
  `user_agent` varchar(191) NOT NULL,
  `token` varchar(191) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `toko_auth_reset_attempts` WRITE;
UNLOCK TABLES;

DROP TABLE IF EXISTS `toko_auth_tokens`;
CREATE TABLE `toko_auth_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `selector` varchar(191) NOT NULL,
  `hashedValidator` varchar(191) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `toko_auth_tokens_user_id_foreign` (`user_id`),
  KEY `selector` (`selector`),
  CONSTRAINT `toko_auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `toko_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `toko_auth_tokens` WRITE;
UNLOCK TABLES;

DROP TABLE IF EXISTS `toko_auth_users_permissions`;
CREATE TABLE `toko_auth_users_permissions` (
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `permission_id` int(11) unsigned NOT NULL DEFAULT '0',
  KEY `toko_auth_users_permissions_permission_id_foreign` (`permission_id`),
  KEY `user_id_permission_id` (`user_id`,`permission_id`),
  CONSTRAINT `toko_auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `toko_auth_permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `toko_auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `toko_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `toko_auth_users_permissions` WRITE;
UNLOCK TABLES;

DROP TABLE IF EXISTS `toko_categories`;
CREATE TABLE `toko_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) DEFAULT NULL,
  `description` text,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `type` enum('product','service') NOT NULL DEFAULT 'product',
  `slug` varchar(191) NOT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

LOCK TABLES `toko_categories` WRITE;
INSERT INTO `toko_categories` VALUES (1,'Electronic','Category for product electronic','active','product','electronic-product','1624427089_58f5f8fc7a061fa6a943.png','2021-06-23 12:44:49','2021-06-23 16:36:09',NULL),(2,'Handphone & Tablet','Category for product handphone & tablet','active','product','handphone-tablet-product','1624427508_d5189b86d3f9d012ae22.jpeg','2021-06-23 12:51:48','2021-06-23 18:52:08',NULL),(3,'Electronic','Category for service electronic','active','service','electronic-service','1624507592_5fed6d5d0978515f9fa2.png','2021-06-24 11:06:33','2021-06-24 11:06:33',NULL),(4,'Service Handphone & Tablet','Category for service Handphone & Tablet','active','service','service-handphone-tablet-service','1624508665_c03af9964bc6095e74db.jpg','2021-06-24 11:24:25','2021-06-24 11:24:25',NULL);
UNLOCK TABLES;

DROP TABLE IF EXISTS `toko_migrations`;
CREATE TABLE `toko_migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

LOCK TABLES `toko_migrations` WRITE;
INSERT INTO `toko_migrations` VALUES (1,'2017-11-20-223112','Myth\\Auth\\Database\\Migrations\\CreateAuthTables','default','Myth\\Auth',1624268211,1),(2,'2021-06-18-075015','App\\Database\\Migrations\\Categories','default','App',1624268212,1),(3,'2021-06-18-082632','App\\Database\\Migrations\\Products','default','App',1624328389,2),(4,'2021-06-26-180005','App\\Database\\Migrations\\Orders','default','App',1624731649,3),(5,'2021-06-26-180019','App\\Database\\Migrations\\OrderDetails','default','App',1624731650,3);
UNLOCK TABLES;

DROP TABLE IF EXISTS `toko_products`;
CREATE TABLE `toko_products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) DEFAULT NULL,
  `description` text,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `price_sale` decimal(12,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(7,0) NOT NULL DEFAULT '0',
  `status` enum('published','draft') NOT NULL DEFAULT 'draft',
  `type` enum('product','service') NOT NULL DEFAULT 'product',
  `category_id` int(11) unsigned NOT NULL,
  `slug` varchar(191) NOT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `seller_id` int(11) unsigned NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `toko_products_category_id_foreign` (`category_id`),
  KEY `toko_products_seller_id_foreign` (`seller_id`),
  CONSTRAINT `toko_products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `toko_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `toko_products_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `toko_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `toko_products` WRITE;
INSERT INTO `toko_products` VALUES (1,'TV SHARP 32 INCHI SMART TV','PROMO HEBOH!\r\nYuk yang pengen beli tv, mesin cuci, kulkas segera ke toko SILENGKAP (Pusat Elektronik) dengan harga spesial.\r\n\r\nHarga kami sudah include bubble wrap packaging.\r\n\r\nFITUR :\r\n-Antenna Booster, Memiliki Fitur Antenna Booster yang berfungsi untuk memperkuat sinyal yang diterima oleh antena,\r\n-7 Shields Protection\r\n-SHARP Pengalaman Terbaik saat Menonton\r\n-Warna lebih dinamis untuk gambar lebih baik\r\n-media player, kemudahan melihat media dari berbagai sumber\r\n-CONECT SHARE, mainkan konten favorit anda dari perangkat USB & HDMI\r\n-Dolby Digital\r\n-Sound Reflect Design rich detail and superb stereo imaging\r\n-Super ECO Mode optimized energy efficient screen display\r\n-X2 Master Engine\r\n-Comfort Mode\r\n-Easy Smart (Browser & YouTube)\r\n-Wireless Mirroring\r\n-Digital Broadcast (DVB-T2) Compatible\r\n\r\nSPESIFIKASI :\r\n-USB 2.0 MP3/PHOTO/VIDEO\r\n-HDMI\r\n-Resolusi : HD 1366 x 768p\r\n-Colour Enhancement, Wide Colour\r\n-2 Built-in speaker 5W x 2\r\n-Original Surround\r\n-Power Consumption (Energy Saving Mode) : 36 W',2900000.00,2610000.00,96,'published','product',1,'tv-sharp-32-inchi-smart-tv-product','1624518741_44fd0e74e188031cddb2.png',2,'2021-06-24 14:12:21','2021-06-27 02:02:46',NULL),(2,'Xiaomi Official Poco M3 4/64GB Snapdragon 662 Mi Smartphone - Power Black','Kondisi: Baru\r\nBerat: 500 Gram\r\nKategori: Android OS\r\nEtalase: Poco\r\nXiaomi Official Store Garansi Resmi\r\n\r\nPoco M3 dilengkapi dengan 48MP AI triple kamera, 2MP kamera makro f/2.4, 48MP kamera utama f/1.79, 2MP sensor depth f/2.4.\r\n\r\nPoco M3 memiliki layar besar berukuran 6.53\" 1080P FHD+, Memberikan kualitas gambar yang lebih baik dan pengalaman visual yang luar biasa secara keseluruhan.\r\n\r\nPoco M3 dilengkapi dengan speaker ganda bersertifikat Hi-Res Audio.\r\n\r\nPoco M3 memiliki baterai besar 6000mAh namun sangat ringan. Dan setelah baterai hampir habis, Anda dapat menggunakannya dalam sekejap dengan pengisian cepat 18W.\r\n\r\nPoco M3 menggunakan prosesor 11nm memberikan daya lebih dari yang Anda harapkan. Qualcomm® Snapdragon ™ 662 menghadirkan prosesor octa-core performa tinggi dengan clock maksimum kecepatan 2.0GHz\r\n\r\nPoco M3 tersedia dalam 3 pilihan warna yaitu POCO Yellow, Cool Blue, dan Power Black.\r\n\r\nSpesifikasi:\r\n\r\nDimensi\r\nTinggi ; 162.3 mm, Lebar: 77.3 mm, Ketebalan : 9.6mm, Berat : 198g\r\nProsesor\r\nQualcomm® Snapdragon™ 662\r\nQualcomm® Kryo™ 260, 11nm proses manufaktur\r\nFrekuensi CPU : Octa-core prosesor, hingga 2.0 GHz\r\nGPU: Adreno™ 610 GPU\r\nAI: 3rd gen Qualcomm® AI Engine\r\nPenyimpanan dan RAM\r\n6GB + 128GB\r\nLPDDR4X + UFS 2.2\r\n4GB + 64GB\r\nLPDDR4X + UFS 2.1.\r\nTampilan\r\n6.53\" FHD+ Layar Dot Drop\r\nSertifikasi TÜV Rheinland® Low Blue Light\r\nResolusi: 2340x1080 FHD+\r\n19.5:9 aspect ratio, 395ppi\r\nCorning® Gorilla® Glass 3\r\nBaterai dan Pengisian daya\r\n6000mAh (typ)*\r\nPort konektor bolak-balik USB-C\r\nMendukung pengisian cepat 18W\r\nPengisi daya cepat 22,5W di dalam kotak\r\nKamera Belakang\r\n48MP AI Triple Kamera\r\n48 MP Kamera utama\r\n\r\nSensor sidik jari di bagian sisi, AI Face unlock\r\nPemutar Audio\r\nMendukung format audio seperti MP3, FLAC, APE, DSF, M4A, AAC, OGG, WAV, WMA, AMR, AWB\r\nSistem Operasi\r\nMIUI 12 untuk POCO, Berbasis Android 10\r\n\r\nIsi Paket Pembelian\r\n\r\nPOCO M3/ Adapter/ Kabel USB Type-C/ SIM Eject Tool/\r\nSoft Case/ Panduan Pengguna/ Kartu Garansi',1899000.00,1799000.00,97,'published','product',2,'xiaomi-official-poco-m3-464gb-snapdragon-662-mi-smartphone-power-black-product','1624618843_3f88d0b1abc5bea302c9.jpeg',2,'2021-06-25 18:00:43','2021-06-27 02:02:46',NULL);
UNLOCK TABLES;

DROP TABLE IF EXISTS `toko_orders`;
CREATE TABLE `toko_orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('order','paid','on progress','receive','completed','rejected') NOT NULL DEFAULT 'order',
  `kurir_teknisi` int(11) unsigned DEFAULT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `toko_orders_user_id_foreign` (`user_id`),
  CONSTRAINT `toko_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `toko_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `toko_orders` WRITE;
INSERT INTO `toko_orders` VALUES (1,'REF-20210627015806',3,11428000.00,'order',NULL,NULL,'2021-06-27 01:58:06','2021-06-27 01:58:06',NULL),(2,'REF-20210627020245',3,4409000.00,'order',NULL,NULL,'2021-06-27 02:02:45','2021-06-27 02:02:45',NULL);
UNLOCK TABLES;

DROP TABLE IF EXISTS `toko_order_details`;
CREATE TABLE `toko_order_details` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `quantity` decimal(7,0) NOT NULL DEFAULT '0',
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `type` enum('product','service') NOT NULL DEFAULT 'product',
  `category_id` int(11) unsigned NOT NULL,
  `datetime` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `toko_order_details_order_id_foreign` (`order_id`),
  KEY `toko_order_details_product_id_foreign` (`product_id`),
  KEY `toko_order_details_category_id_foreign` (`category_id`),
  CONSTRAINT `toko_order_details_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `toko_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `toko_order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `toko_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `toko_order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `toko_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

LOCK TABLES `toko_order_details` WRITE;
INSERT INTO `toko_order_details` VALUES (1,1,1,3,2610000.00,'product',1,NULL,'2021-06-27 01:58:06','2021-06-27 01:58:06',NULL),(2,1,2,2,1799000.00,'product',2,NULL,'2021-06-27 01:58:07','2021-06-27 01:58:07',NULL),(3,2,2,1,1799000.00,'product',2,NULL,'2021-06-27 02:02:46','2021-06-27 02:02:46',NULL),(4,2,1,1,2610000.00,'product',1,NULL,'2021-06-27 02:02:46','2021-06-27 02:02:46',NULL);
UNLOCK TABLES;