ALTER TABLE `orders`
    ADD COLUMN `hash` VARCHAR(191) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL AFTER `payment_installment`;