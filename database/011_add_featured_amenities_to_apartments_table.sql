ALTER TABLE `apartments`
    ADD COLUMN `featured_amenities` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL AFTER `sort_order`;