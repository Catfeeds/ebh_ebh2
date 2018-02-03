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

-- 导出  表 ebh2.ebh_previews 结构
CREATE TABLE IF NOT EXISTS `ebh_previews` (
  `reviewid` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `itemid` int(11) DEFAULT NULL COMMENT '评论对应的文章的ID',
  `uid` int(11) DEFAULT NULL COMMENT '评论对应的用户ID',
  `subject` varchar(300) DEFAULT NULL COMMENT '评论的内容',
  `dateline` int(11) DEFAULT NULL COMMENT '评论的时间',
  `fromip` varchar(15) DEFAULT NULL COMMENT '评论IP',
  `status` tinyint(1) DEFAULT '1' COMMENT '1为不锁定,2为锁定,锁定时前台不显示改评论',
  PRIMARY KEY (`reviewid`),
  KEY `idx_itemid` (`itemid`),
  KEY `idx_uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ebh门户频道评论表';

-- 数据导出被取消选择。
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
