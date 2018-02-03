ALTER TABLE `ebh_notes`
	CHANGE COLUMN `uid` `uid` INT(11) NOT NULL DEFAULT '0' COMMENT '所属用户编号' AFTER `noteid`,
	CHANGE COLUMN `cwid` `cwid` INT(11) NOT NULL DEFAULT '0' COMMENT '所属课件编号' AFTER `uid`,
	CHANGE COLUMN `crid` `crid` INT(11) NOT NULL DEFAULT '0' COMMENT '笔记所属的教室编号' AFTER `cwid`,
	CHANGE COLUMN `source` `source` VARCHAR(500) NOT NULL DEFAULT '' COMMENT '笔记存放服务器，适用于多服务器的情况,如http://file2.ebanhui.com/' AFTER `crid`,
	CHANGE COLUMN `url` `url` VARCHAR(500) NOT NULL DEFAULT '' COMMENT '笔记文件相对路径' AFTER `source`,
	CHANGE COLUMN `size` `size` INT(11) NOT NULL DEFAULT '0' COMMENT '笔记文件大小' AFTER `url`,
	CHANGE COLUMN `dateline` `dateline` INT(11) NOT NULL DEFAULT '0' COMMENT '笔记上传时间' AFTER `size`,
	ADD INDEX `idx_cwid` (`cwid`),
	ADD INDEX `idx_dateline` (`dateline`);;