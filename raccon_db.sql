
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ;

CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `total` decimal(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ;

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(5,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;

INSERT INTO `products` VALUES (1,'Avocado','Fresh from near farm',10.00,'','2023-02-10 09:21:37',NULL,NULL),(2,'Mango','Juicy like no other mangoes',12.00,NULL,'2023-02-10 09:22:17',NULL,NULL),(3,'Banana','Big one!',2.00,NULL,'2023-02-10 09:22:56',NULL,NULL),(4,'Watermelon','No bottle of juice needed',60.00,NULL,'2023-02-10 09:23:52',NULL,NULL),(5,'Tresor Mwema','Mwema',456.00,NULL,'2023-02-10 12:21:47',NULL,NULL),(6,'Tresor Mwema','Mwema',456.00,NULL,'2023-02-10 12:22:02',NULL,NULL);

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;

