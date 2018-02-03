ALTER TABLE `ebh_onlinecourses`
	CHANGE COLUMN `crid` `crid` INT(11) NOT NULL DEFAULT '0' COMMENT '所属教室编号' ,
	CHANGE COLUMN `title` `title` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '课程标题',
	CHANGE COLUMN `tid` `tid` INT(11) NOT NULL DEFAULT '0' COMMENT '所属教师编号' ,
	CHANGE COLUMN `tname` `tname` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '主讲教师' ,
	CHANGE COLUMN `cdate` `cdate` INT(11) NOT NULL DEFAULT '0' COMMENT '开课时间' ,
	CHANGE COLUMN `ctime` `ctime` INT(11) NOT NULL DEFAULT '0' COMMENT '开课时长,以分钟为单位，如60 即表示60分钟' ,
	CHANGE COLUMN `summary` `summary` VARCHAR(500) NOT NULL DEFAULT '' COMMENT '课程简介',
	
	CHANGE COLUMN `image` `image` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '课件封面' ,
	CHANGE COLUMN `cwsource` `cwsource` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '课件所在服务器',
	CHANGE COLUMN `cwurl` `cwurl` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '课件所在相对路径' ,
	CHANGE COLUMN `maxnum` `maxnum` INT(11)  NOT NULL DEFAULT '0' COMMENT '最大人数' ,
	CHANGE COLUMN `dateline` `dateline` INT(11) NOT NULL DEFAULT '0' COMMENT '记录添加时间',
	CHANGE COLUMN `status` `status` INT(11) NOT NULL DEFAULT '0' COMMENT '课程状态默认状态为0',
	CHANGE COLUMN `recordsource` `recordsource` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '课程录播课件所在服务器',
	CHANGE COLUMN `recordurl` `recordurl` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '课程录播课件所在相对路径',
	CHANGE COLUMN `rflag` `rflag` INT(11) NOT NULL DEFAULT '0' COMMENT '是否已经有录播课件了1为有';



ALTER TABLE `ebh_onlinecourses`
	ADD COLUMN `auid` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '助教编号' AFTER `tname`;