ALTER TABLE `ebh_askquestions`
	ADD COLUMN `fromip` VARCHAR(15) NULL DEFAULT NULL COMMENT '答疑的ip' AFTER `attsrc`;