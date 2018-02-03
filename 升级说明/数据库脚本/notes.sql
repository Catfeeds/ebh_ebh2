ALTER TABLE `ebh_notes`
	CHANGE COLUMN `uid` `uid` INT(11) NOT NULL DEFAULT '0' COMMENT '�����û����' AFTER `noteid`,
	CHANGE COLUMN `cwid` `cwid` INT(11) NOT NULL DEFAULT '0' COMMENT '�����μ����' AFTER `uid`,
	CHANGE COLUMN `crid` `crid` INT(11) NOT NULL DEFAULT '0' COMMENT '�ʼ������Ľ��ұ��' AFTER `cwid`,
	CHANGE COLUMN `source` `source` VARCHAR(500) NOT NULL DEFAULT '' COMMENT '�ʼǴ�ŷ������������ڶ�����������,��http://file2.ebanhui.com/' AFTER `crid`,
	CHANGE COLUMN `url` `url` VARCHAR(500) NOT NULL DEFAULT '' COMMENT '�ʼ��ļ����·��' AFTER `source`,
	CHANGE COLUMN `size` `size` INT(11) NOT NULL DEFAULT '0' COMMENT '�ʼ��ļ���С' AFTER `url`,
	CHANGE COLUMN `dateline` `dateline` INT(11) NOT NULL DEFAULT '0' COMMENT '�ʼ��ϴ�ʱ��' AFTER `size`,
	ADD INDEX `idx_cwid` (`cwid`),
	ADD INDEX `idx_dateline` (`dateline`);;