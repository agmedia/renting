ALTER TABLE `order_deposit`
    ADD COLUMN `scope_id` TINYINT(4) NOT NULL DEFAULT '1' AFTER `paid`;