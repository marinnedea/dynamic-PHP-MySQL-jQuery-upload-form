-- Run this if upgrading an existing install (uploads table already exists)
ALTER TABLE `uploads`
  ADD COLUMN `first_name` varchar(255) NOT NULL AFTER `id`,
  ADD COLUMN `last_name`  varchar(255) NOT NULL AFTER `first_name`,
  ADD COLUMN `email`      varchar(255) NOT NULL AFTER `last_name`;
