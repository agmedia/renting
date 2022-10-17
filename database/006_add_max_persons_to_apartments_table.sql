ALTER TABLE `apartments`
    ADD COLUMN `max_persons` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `children`;