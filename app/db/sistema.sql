CREATE TABLE `user` (
  `user_id` integer UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_name` varchar(127),
  `user_email` varchar(256),
  `user_password` varchar(256),
  `telphone` varchar(20),
  `state` varchar(45),
  `city` varchar(45),
  `address` varchar(256),
  `complement` varchar(256),
  `is_admin` boolean,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `image` (
  `image_id` integer UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `image_name` varchar(127),
  `image_description` text,
  `image_uri` varchar(1024),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `product` (
  `product_id` integer UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `image_id` integer,
  `product_name` varchar(127),
  `product_description` text,
  `product_price` decimal(10,2),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `product_rating` (
  `product_rating_id` integer UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` integer,
  `product_id` integer,
  `rating` tinyint,
  `review` text,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `product_shopping_cart` (
  `shopping_cart_id` integer,
  `product_id` integer,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `shopping_cart` (
  `shopping_cart_id` integer UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `purchased` (
  `purchased_id` integer UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `shopping_cart_id` integer,
  `purchase_price` decimal(10,2),
  `created_at` timestamp,
  `updated_at` timestamp
);

ALTER TABLE `product` ADD FOREIGN KEY (`image_id`) REFERENCES `image` (`image_id`);

ALTER TABLE `product_rating` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

ALTER TABLE `product_rating` ADD FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

ALTER TABLE `product_shopping_cart` ADD FOREIGN KEY (`shopping_cart_id`) REFERENCES `shopping_cart` (`shopping_cart_id`);

ALTER TABLE `product_shopping_cart` ADD FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

ALTER TABLE `purchased` ADD FOREIGN KEY (`shopping_cart_id`) REFERENCES `shopping_cart` (`shopping_cart_id`);
