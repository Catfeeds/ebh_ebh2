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

-- 导出  表 ebh2.ebh_padstypes 结构
CREATE TABLE IF NOT EXISTS `ebh_padstypes` (
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT '广告类型id',
  `upid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级类型id',
  `name` varchar(64) DEFAULT NULL COMMENT '广告类型名称',
  `code` varchar(64) DEFAULT NULL COMMENT '广告类型标志',
  `description` varchar(512) DEFAULT NULL COMMENT '广告类型说明',
  `visible` tinyint(1) unsigned DEFAULT '1' COMMENT '该类型下面的所有广告是否可见1,表示可见,2不可见',
  `system` tinyint(1) unsigned DEFAULT '1' COMMENT '1为系统分类2为非系统分类',
  `displayorder` int(11) unsigned DEFAULT '0' COMMENT '类型排列顺序',
  `templet` varchar(64) DEFAULT 'default' COMMENT '广告模板',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `unique_tag` (`code`),
  KEY `idx_upid` (`upid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告类型表，用来存放广告类型的相关信息';

-- 数据导出被取消选择。
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
