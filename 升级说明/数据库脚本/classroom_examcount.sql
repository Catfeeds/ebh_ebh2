ALTER TABLE `ebh_classrooms`
	ADD COLUMN `examcount` INT(11) NOT NULL DEFAULT '0' COMMENT '作业数' AFTER `coursenum`;