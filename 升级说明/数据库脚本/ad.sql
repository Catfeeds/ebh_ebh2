ALTER TABLE `ebh_categories`
	ADD INDEX `idx_code` (`code`),
	ADD INDEX `idx_type` (`type`);

ALTER TABLE `ebh_items`
	ADD INDEX `idx_catid` (`catid`),
	ADD INDEX `idx_folder` (`folder`),
	ADD INDEX `idx_crid` (`crid`),
	ADD INDEX `idx_citycode` (`citycode`);