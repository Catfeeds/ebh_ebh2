-- --------------------------------------------------------
-- 主机:                           192.168.0.27
-- 服务器版本:                        5.5.35-log - Source distribution
-- 服务器操作系统:                      Linux
-- HeidiSQL 版本:                  8.0.0.4396
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出  表 ebh2.ebh_resgroups 结构
DROP TABLE IF EXISTS `ebh_resgroups`;
CREATE TABLE IF NOT EXISTS `ebh_resgroups` (
  `gid` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `groupname` varchar(100) NOT NULL DEFAULT '' COMMENT '试题库分类名',
  `img` varchar(100) NOT NULL DEFAULT '' COMMENT '分类图片',
  `grade` int(11) NOT NULL DEFAULT '0' COMMENT '班级(分类):1表示小学,7表示中学,10表示高中,0表示其他',
  `lnum` int(11) NOT NULL DEFAULT '0' COMMENT '试题数',
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='试题库分类表';

-- 正在导出表  ebh2.ebh_resgroups 的数据：~26 rows (大约)
DELETE FROM `ebh_resgroups`;
/*!40000 ALTER TABLE `ebh_resgroups` DISABLE KEYS */;
INSERT INTO `ebh_resgroups` (`gid`, `groupname`, `img`, `grade`, `lnum`) VALUES
	(1, '小学语文', '/images/epaper/xiaoyuwen.jpg', 1, 2788),
	(2, '小学数学', '/images/epaper/xiaoshuxue.jpg', 1, 5553),
	(3, '小学英语', '/images/epaper/xiaoyingyu.jpg', 1, 4458),
	(4, '小学_综合', '/images/epaper/xiaozonghe.jpg', 1, 225),
	(5, '初中语文', '/images/epaper/chuyuwen.jpg', 7, 8581),
	(6, '初中数学', '/images/epaper/chushuxue.jpg', 7, 8264),
	(7, '初中英语', '/images/epaper/chuyingyu.jpg', 7, 7950),
	(8, '初中物理', '/images/epaper/chuwuli.jpg', 7, 6190),
	(9, '初中化学', '/images/epaper/chuhuaxue.jpg', 7, 5254),
	(10, '初中生物', '/images/epaper/chushengwu.jpg', 7, 4497),
	(11, '初中历史', '/images/epaper/chulishi.jpg', 7, 6592),
	(12, '初中地理', '/images/epaper/chudili.jpg', 7, 4242),
	(13, '初中政治', '/images/epaper/chuzhengzhi.jpg', 7, 6571),
	(14, '初中综合', '/images/epaper/chuzonghe.jpg', 7, 1145),
	(15, '高中语文', '/images/epaper/gaoyuwen.jpg', 10, 8730),
	(16, '高中数学', '/images/epaper/gaoshuxue.jpg', 10, 15390),
	(17, '高中英语', '/images/epaper/gaoyingyu.jpg', 10, 8755),
	(18, '高中物理', '/images/epaper/gaowuli.jpg', 10, 8916),
	(19, '高中化学', '/images/epaper/gaohuaxue.jpg', 10, 8941),
	(20, '高中生物', '/images/epaper/gaoshengwu.jpg', 10, 8569),
	(21, '高中地理', '/images/epaper/gaodili.jpg', 10, 7603),
	(22, '高中历史', '/images/epaper/gaolishi.jpg', 10, 8804),
	(23, '高中政治', '/images/epaper/gaozhengzhi.jpg', 10, 8914),
	(24, '高中基本能力', '/images/epaper/gaojibennl.jpg', 10, 992),
	(25, '高中理科综合', '/images/epaper/gaolizong.jpg', 10, 2646),
	(26, '高中文科综合', '/images/epaper/gaowenzong.jpg', 10, 2616);
/*!40000 ALTER TABLE `ebh_resgroups` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
