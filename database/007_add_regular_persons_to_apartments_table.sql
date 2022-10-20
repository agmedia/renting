ALTER TABLE `apartments`
    ADD COLUMN `regular_persons` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `baths`,
    CHANGE COLUMN `adults` `max_adults` INT(10) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE COLUMN `children` `max_children` INT(10) UNSIGNED NOT NULL DEFAULT '0';