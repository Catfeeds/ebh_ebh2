ALTER TABLE `ebh_examanswers`
	ADD INDEX `idx_eid` (`eid`);

ALTER TABLE `ebh_examanswers`
	CHANGE COLUMN `uid` `uid` INT(11) NOT NULL DEFAULT '0' COMMENT 'ѧ��ID' AFTER `status`,
	CHANGE COLUMN `tid` `tid` INT(11) NOT NULL DEFAULT '0' COMMENT '���ĵĽ�ʦID' AFTER `uid`;