ALTER TABLE `ebh_notes`
	ADD COLUMN `fimage` VARCHAR(500) NOT NULL DEFAULT '' COMMENT 'flash笔记图片' AFTER `size`;
ALTER TABLE `ebh_notes`
	ADD COLUMN `ftext` VARCHAR(5000) NOT NULL DEFAULT '' COMMENT 'flash笔记文本' AFTER `fimage`;
ALTER TABLE `ebh_notes`
	ADD COLUMN `fdateline` INT(11) NOT NULL DEFAULT 0 COMMENT 'flash笔记上传时间' AFTER `ftext`;