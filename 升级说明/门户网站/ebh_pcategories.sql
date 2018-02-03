-- --------------------------------------------------------
-- 主机:                           192.168.0.27
-- 服务器版本:                        5.5.35-log - Source distribution
-- 服务器操作系统:                      Linux
-- HeidiSQL 版本:                  8.3.0.4792
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出  表 ebh2.ebh_pcategories 结构
CREATE TABLE IF NOT EXISTS `ebh_pcategories` (
  `catid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目编号',
  `upid` int(11) DEFAULT '0' COMMENT '父级栏目编号',
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '栏目名称',
  `keyword` varchar(100) DEFAULT NULL COMMENT '栏目关键字',
  `description` varchar(500) DEFAULT NULL COMMENT '栏目描述',
  `displayorder` int(11) DEFAULT '0' COMMENT '栏目排序',
  `caturl` varchar(255) DEFAULT NULL COMMENT '栏目url地址',
  `target` varchar(10) DEFAULT NULL COMMENT '栏目打开方式',
  `system` tinyint(1) unsigned DEFAULT '1' COMMENT '1为系统2为非系统',
  `visible` tinyint(1) unsigned DEFAULT '1' COMMENT '1可见2不可见',
  PRIMARY KEY (`catid`),
  KEY `idx_code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COMMENT='ebh门户分类，用于保存分类信息';

-- 正在导出表  ebh2.ebh_pcategories 的数据：~44 rows (大约)
DELETE FROM `ebh_pcategories`;
/*!40000 ALTER TABLE `ebh_pcategories` DISABLE KEYS */;
INSERT INTO `ebh_pcategories` (`catid`, `upid`, `code`, `name`, `keyword`, `description`, `displayorder`, `caturl`, `target`, `system`, `visible`) VALUES
	(1, 0, 'yjxpt', '云教学平台', '云教学平台', '云教学平台', 0, '', '', 1, 1),
	(2, 1, 'jxpt', '教学平台', '教学平台', '教学平台', 0, '', '', 1, 1),
	(3, 1, 'pmzb', '屏幕直播', '屏幕直播', '屏幕直播', 1, '', '', 1, 1),
	(4, 1, 'wlxx', '网络学校', '网络学校', '网络学校', 2, '', '', 1, 1),
	(5, 1, 'stkj', '试听课件', '试听课件', '试听课件', 3, '', '', 1, 1),
	(6, 1, 'qypx', '企业培训', '企业培训', '企业培训', 4, '', '', 1, 1),
	(7, 1, 'hddy', '互动答疑', '互动答疑', '互动答疑', 5, '', '', 1, 1),
	(8, 0, 'xwdt', '新闻动态', '新闻动态', '新闻动态', 1, '', '', 1, 1),
	(9, 8, 'jydt', '教育动态', '教育动态', '教育动态', 0, '', '', 1, 1),
	(10, 8, 'jxyj', '教学研究', '教学研究', '教学研究', 1, '', '', 1, 1),
	(11, 8, 'ksxz', '考试新政', '考试新政', '考试新政', 2, '', '', 1, 1),
	(12, 8, 'zcfg', '政策法规', '政策法规', '政策法规', 3, '', '', 1, 1),
	(13, 8, 'zgkzx', '中高考资讯', '中高考资讯', '中高考资讯', 4, '', '', 1, 1),
	(14, 8, 'xyxw', '校园新闻', '校园新闻', '校园新闻', 8, '', '', 1, 1),
	(15, 0, 'xyzx', '校园在线', '校园在线', '校园在线', 2, '', '', 1, 1),
	(16, 15, 'sxjy', '学生剪影', '学生剪影', '学生剪影', 0, '', '', 1, 1),
	(17, 15, 'zyxs', '状元心声', '状元心声', '状元心声', 1, '', '', 1, 1),
	(18, 15, 'jsfc', '教师风采', '教师风采', '教师风采', 2, '', '', 1, 1),
	(19, 15, 'xymj', '校园美景', '校园美景', '校园美景', 3, '', '', 1, 1),
	(20, 15, 'xyzxx', '校园之星', '校园之星', '校园之星', 4, '', '', 1, 1),
	(21, 15, 'xysh', '校园生活', '校园生活', '校园生活', 5, '', '', 1, 1),
	(22, 0, 'qwbk', '趣味百科', '趣味百科', '趣味百科', 3, '', '', 1, 1),
	(23, 22, 'qqbg', '千奇百怪', '千奇百怪', '千奇百怪', 0, '', '', 1, 1),
	(24, 22, 'qsbl', '糗事爆料', '糗事爆料', '糗事爆料', 1, '', '', 1, 1),
	(25, 22, 'bkzt', '百科杂谈', '百科杂谈', '百科杂谈', 2, '', '', 1, 1),
	(26, 22, 'jdcs', '经典测试', '经典测试', '经典测试', 3, '', '', 1, 1),
	(27, 22, 'zlky', '智力考验', '智力考验', '智力考验', 4, '', '', 1, 1),
	(28, 22, 'stjw', '说图解文', '说图解文', '说图解文', 5, '', '', 1, 1),
	(29, 0, 'wljx', '网络教学', '网络教学', '网络教学', 4, '', '', 1, 1),
	(30, 29, 'fzkt', '翻转课堂', '翻转课堂', '翻转课堂', 0, '', '', 1, 1),
	(31, 29, 'zhxy', '智慧校园', '智慧校园', '智慧校园', 1, '', '', 1, 1),
	(32, 29, 'kzkt', '空中课堂', '空中课堂', '空中课堂', 2, '', '', 1, 1),
	(33, 0, 'czlz', '成长励志', '成长励志', '成长励志', 5, '', '', 1, 1),
	(34, 33, 'gxjd', '国学经典', '国学经典', '国学经典', 0, '', '', 1, 1),
	(35, 33, 'gwrs', '感悟人生', '感悟人生', '感悟人生', 1, '', '', 1, 1),
	(36, 33, 'cygs', '创业故事', '创业故事', '创业故事', 2, '', '', 1, 1),
	(37, 0, 'ebhyy', 'e板会应用', 'e板会应用', 'e板会应用', 6, '', '', 1, 1),
	(38, 37, 'wkgj', '微课工具', '微课工具', '微课工具', 0, '', '', 1, 1),
	(39, 37, 'pmzbb', '屏幕直播', '屏幕直播', '屏幕直播', 1, '', '', 1, 1),
	(40, 37, 'jxjst', '教学即时通', '教学即时通', '教学即时通', 2, '', '', 1, 1),
	(41, 0, 'bzzx', '帮助中心', '帮助中心', '帮助中心', 7, '', '', 1, 1),
	(42, 41, 'wkzz', '微课制作', '微课制作', '微课制作', 0, '', '', 1, 1),
	(43, 41, 'ssrm', '师生入门', '师生入门', '师生入门', 1, '', '', 1, 1),
	(44, 41, 'kfzx', '客服中心', '客服中心', '客服中心', 2, '', '', 1, 1);
/*!40000 ALTER TABLE `ebh_pcategories` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
