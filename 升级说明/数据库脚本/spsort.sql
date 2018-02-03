ALTER TABLE `ebh_pay_sorts`
	ADD COLUMN `sdisplayorder` INT(11) NOT NULL DEFAULT '0' COMMENT '分类显示顺序' AFTER `content`;