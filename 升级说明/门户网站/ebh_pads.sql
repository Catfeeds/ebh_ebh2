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

-- 导出  表 ebh2.ebh_pads 结构
CREATE TABLE IF NOT EXISTS `ebh_pads` (
  `aid` int(11) NOT NULL AUTO_INCREMENT COMMENT '广告ID',
  `tid` int(11) DEFAULT '0' COMMENT '广告所对应的type',
  `catid` int(11) unsigned DEFAULT '0' COMMENT '广告对应的栏目',
  `uid` int(11) DEFAULT '0' COMMENT '广告所属用户的id',
  `openuser` varchar(128) DEFAULT '神秘人' COMMENT '广告添加者名字',
  `subject` varchar(256) DEFAULT '0' COMMENT '广告标题',
  `message` text COMMENT '广告内容',
  `thumb` varchar(256) DEFAULT '0' COMMENT '广告图片地址',
  `linkurl` varchar(256) DEFAULT '0' COMMENT '广告链接地址',
  `dateline` int(11) unsigned DEFAULT '0' COMMENT '广告发布时间',
  `lastpost` int(11) unsigned DEFAULT '0' COMMENT '广告最后修改时间',
  `begintime` int(11) unsigned DEFAULT '0' COMMENT '广告开始投放时间',
  `endtime` int(11) unsigned DEFAULT '0' COMMENT '广告结束投放时间',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '广告状态1正常2锁定',
  `displayorder` int(11) unsigned DEFAULT '0' COMMENT '广告排列顺序',
  PRIMARY KEY (`aid`),
  KEY `idx_catid` (`catid`),
  KEY `idx_uid` (`uid`),
  KEY `idx_openuid` (`openuser`),
  KEY `idx_tid` (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门户广告表';

-- 数据导出被取消选择。
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
