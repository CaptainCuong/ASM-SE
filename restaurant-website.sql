SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Database name :  `pos_system`

CREATE TABLE `in_order` (
  `id` int(5) NOT NULL,
  `order_id` int(5) NOT NULL,
  `menu_id` int(5) NOT NULL,
  `quantity` int(3) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `menus` (
  `menu_id` int(2) NOT NULL,
  `menu_name` varchar(40) NOT NULL,
  `menu_description` varchar(255) NOT NULL,
  `menu_price` decimal(4,2) NOT NULL,
  `menu_image` varchar(255) NOT NULL,
  `category_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_image`, `category_id`) VALUES
(0, 'Wonton noodles soup', 'Lorem Ipsum has been the industry standard dummy text ever since the 1500s', 5, 'wonton_noodle.png', 1),
(1, 'Char siu noodles soup', 'Lorem Ipsum has been the industry standard dummy text ever since the 1500s', 5, 'charsiu_noodle.png', 1),
(2, 'Roast chicken noodles soup', 'Lorem Ipsum has been the industry standard dummy text ever since the 1500s', 5, 'chicken_noodle.png', 1),
(3, 'Beef stir-fry noodles', 'Lorem Ipsum has been the industry standard dummy text ever since the 1500s', 5, 'beef_noodle.png', 1),
(4, 'Mixed stir-fry noodles', 'Lorem Ipsum has been the industry standard dummy text ever since the 1500s', 5, 'mix_noodle.png', 1),
(5, 'Roast chicken fried rice', 'Lorem Ipsum has been the industry standard dummy text ever since the 1500s', 4, 'chicken_rice.png', 2),
(6, 'Char siu fried rice', 'Lorem Ipsum has been the industry standard dummy text ever since the 1500s', 4, 'charsiu_rice.png', 2),
(7, 'beef fried rice', 'Lorem Ipsum has been the industry standard dummy text ever since the 1500s', 4, 'beef_rice.png', 2),
(8, 'Bubblefish soup', 'Lorem Ipsum has been the industry standard dummy text ever since the 1500s', 3, 'soup.png', 3);

CREATE TABLE `menu_categories` (
  `category_id` int(2) NOT NULL,
  `category_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `menu_categories` (`category_id`, `category_name`) VALUES
(1, 'Noodle'),
(2, 'Rice'),
(3, 'Soup'),
(4, 'Dessert');


CREATE TABLE `placed_orders` (
  `order_id` int(5) NOT NULL,
  `order_time` datetime NOT NULL,
  `table_id` int(5) NOT NULL,
  `user_id` int(5),
  `payment_method` varchar(50) NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `total` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `tables` (
  `table_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `tables` (`table_id`) VALUES
(1);

CREATE TABLE `website_settings` (
  `option_id` int(5) NOT NULL,
  `option_name` varchar(255) NOT NULL,
  `option_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `website_settings` (`option_id`, `option_name`, `option_value`) VALUES
(1, 'restaurant_name', 'VINCENT PIZZA'),
(2, 'restaurant_email', 'vincent.pizza@gmail.com'),
(3, 'admin_email', 'drissjiri@gmail.com'),
(4, 'restaurant_phonenumber', '088866777555'),
(5, 'restaurant_address', '1580  Boone Street, Corpus Christi, TX, 78476 - USA');

CREATE TABLE `image_gallery` (
  `image_id` int(2) NOT NULL,
  `image_name` varchar(30) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `reservations` (
  `reservation_id` int(5) NOT NULL,
  `date_created` datetime NOT NULL,
  `user_id` int(2) NOT NULL,
  `selected_time` datetime NOT NULL,
  `nbr_guests` int(2) NOT NULL,
  `table_id` int(3) NOT NULL,
  `liberated` tinyint(1) NOT NULL DEFAULT '0',
  `canceled` tinyint(1) NOT NULL DEFAULT '0',
  `cancellation_reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `user_id` int(2) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `messages` (
  `msg_id` int(3) NOT NULL,
  `incoming_msg_id` int(3) NOT NULL,
  `outgoing_meg_id` int(3) NOT NULL,
  `msg` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `image_gallery`
  ADD PRIMARY KEY (`image_id`);

ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `in_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu` (`menu_id`),
  ADD KEY `fk_order` (`order_id`);

ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `FK_menu_category_id` (`category_id`);

ALTER TABLE `menu_categories`
  ADD PRIMARY KEY (`category_id`);

ALTER TABLE `placed_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_table` (`table_id`);

ALTER TABLE `tables`
  ADD PRIMARY KEY (`table_id`);

ALTER TABLE `website_settings`
  ADD PRIMARY KEY (`option_id`);

ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

ALTER TABLE `in_order`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `menus`
  MODIFY `menu_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE `menu_categories`
  MODIFY `category_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `placed_orders`
  MODIFY `order_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `tables`
  MODIFY `table_id` int(3) NOT NULL;

ALTER TABLE `website_settings`
  MODIFY `option_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `image_gallery`
  MODIFY `image_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `reservations`
  MODIFY `reservation_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `users`
  MODIFY `user_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `messages`
  MODIFY `msg_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `in_order`
  ADD CONSTRAINT `fk_menu` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`menu_id`),
  ADD CONSTRAINT `fk_order` FOREIGN KEY (`order_id`) REFERENCES `placed_orders` (`order_id`);

ALTER TABLE `menus`
  ADD CONSTRAINT `FK_menu_category_id` FOREIGN KEY (`category_id`) REFERENCES `menu_categories` (`category_id`);

ALTER TABLE `placed_orders`
  ADD CONSTRAINT `fk_table` FOREIGN KEY (`table_id`) REFERENCES `tables` (`table_id`);
  
ALTER TABLE `placed_orders`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `reservations`
  ADD CONSTRAINT `table` FOREIGN KEY (`table_id`) REFERENCES `tables` (`table_id`),
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `messages`
  ADD CONSTRAINT `in_msg` FOREIGN KEY (`incoming_msg_id`) REFERENCES `tables` (`table_id`),
  ADD CONSTRAINT `out_msg` FOREIGN KEY (`outgoing_meg_id`) REFERENCES `tables` (`table_id`);


COMMIT;
