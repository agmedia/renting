ALTER TABLE `orders`
    ADD COLUMN `sync_uid` VARCHAR(191) NULL DEFAULT NULL AFTER `comment`;