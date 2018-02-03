ALTER TABLE `ebh_categories`
	ADD INDEX `idx_code` (`code`),
	ADD INDEX `idx_upid` (`upid`);
	
UPDATE ebh_categories SET code = 'credit' WHERE code = 'integral';