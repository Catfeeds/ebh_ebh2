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

-- 导出  表 ebh2.ebh_pitems 结构
CREATE TABLE IF NOT EXISTS `ebh_pitems` (
  `itemid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章的id',
  `catid` int(11) DEFAULT '0' COMMENT '文章所在栏目的catid',
  `subject` varchar(255) DEFAULT NULL COMMENT '文章标题',
  `note` varchar(255) DEFAULT NULL COMMENT '文章简介',
  `message` text COMMENT '文章具体内容',
  `source` varchar(255) DEFAULT NULL COMMENT '文章的来源',
  `itemurl` varchar(255) DEFAULT NULL COMMENT '文章地址,为空时显示本站文章，不为空则显示外部链接',
  `thumb` varchar(255) DEFAULT NULL COMMENT '文章对应缩略图',
  `uid` int(11) DEFAULT '0' COMMENT '发布者UID',
  `author` varchar(50) DEFAULT NULL COMMENT '文章作者',
  `dateline` int(11) DEFAULT '0' COMMENT '文章初次发布时间',
  `lastpost` int(11) DEFAULT '0' COMMENT '文章最后修改时间',
  `tag` varchar(100) DEFAULT NULL COMMENT '文章对应的标签',
  `viewnum` int(11) DEFAULT '0' COMMENT '文章浏览次数',
  `sharenum` int(11) DEFAULT '0' COMMENT '文章分享次数',
  `top` tinyint(1) DEFAULT '0' COMMENT '文章置顶',
  `hot` tinyint(1) DEFAULT '0',
  `best` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1' COMMENT '1为锁定,2为不锁定,锁定之后前台不显示',
  `displayorder` int(11) DEFAULT '0' COMMENT '文章排序',
  PRIMARY KEY (`itemid`),
  KEY `idx_catid` (`catid`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='ebh门户文章表';

-- 正在导出表  ebh2.ebh_pitems 的数据：~0 rows (大约)
DELETE FROM `ebh_pitems`;
/*!40000 ALTER TABLE `ebh_pitems` DISABLE KEYS */;
/*!40000 ALTER TABLE `ebh_pitems` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
