ALTER TABLE `ebh_askanswers`
	ADD COLUMN `fromip` VARCHAR(15) NOT NULL DEFAULT '' AFTER `attsrc`;