ALTER TABLE `actions`
    ADD COLUMN `price_regular` DECIMAL(15,4) NULL DEFAULT NULL AFTER `extra`,
    ADD COLUMN `price_weekends` DECIMAL(15,4) NULL DEFAULT NULL AFTER `price_regular`;