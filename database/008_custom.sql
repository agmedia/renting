ALTER TABLE `products`
ADD COLUMN `url` VARCHAR(255) NOT NULL AFTER `slug`,
ADD COLUMN `category_string` TEXT NULL DEFAULT NULL AFTER `url`;