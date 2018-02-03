<?php
/**
 * Plate模板数据
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/2/14
 * Time: 14:05
 */
class PlateModel extends CModel
{
    private $_cache;
    private $_debug = false;
    function __construct()
    {
        parent::__construct();
        $this->_debug = defined('IS_DEBUG') ? IS_DEBUG : false;
        $this->_cache = Ebh::app()->lib('Roomcache');
    }

    /**
     * 获取头部模块
     * @param $crid 网校ID
     * @param int $category 网校类型：0-网校版，1-企业版
     * @return array
     */
    public function getTopModuleList($crid, $category = 0) {
        $crid = intval($crid);
        if ($crid < 1) {
            return array();
        }
        $category = intval($category);
        if (!in_array($category, array(0, 1))) {
            return array();
        }

        return array();
    }

    /**
     * 自选课程选项列表，只列出零售课程，(分层网校)
     * @param $crid 当前网校ID
     * @param int $limit 查询限量条件
     * @return array
     */
    public function getManualCourseList($crid, $limit = 0) {
        $crid = intval($crid);
        $fields = array(
            '`a`.`iname`', '`a`.`itemid`', '`a`.`pid`', '`a`.`sid`',
            '`b`.`folderid`', '`b`.`foldername`', '`b`.`img`',
            '`c`.`pname`',
            'IFNULL(`d`.`sname`,\'其他\') AS `sname`',
            'IFNULL(`d`.`sdisplayorder`,2147483647) AS `sorder`'
        );
        $wheres = array(
            '`a`.`crid`='.$crid,
            '`a`.`status`=0',
            '`a`.`defind_course`=1',
            '`b`.`del`=0',
            '`b`.`folderlevel`=2',
            '`b`.`power`=0',
            '`c`.`status`=1',
            'IFNULL(`d`.`showbysort`,0)=0'
        );
        $sql = 'SELECT '.implode(',', $fields).' FROM `ebh_pay_items` `a` 
               LEFT JOIN `ebh_folders` `b` ON `b`.`folderid`=`a`.`folderid`
               LEFT JOIN `ebh_pay_packages` `c` ON `c`.`pid`=`a`.`pid`
               LEFT JOIN `ebh_pay_sorts` `d` ON `d`.`sid`=`a`.`sid` WHERE '.
            implode(' AND ', $wheres).' GROUP BY `a`.`folderid` 
            ORDER BY `c`.`displayorder` ASC,`c`.`pid` DESC,`sorder` ASC,`a`.`sid` DESC,`a`.`folderid`';
        $offset = 0;
        $top = 0;
        if (!empty($limit)) {
            if (is_array($limit)) {
                $page = !empty($limit['page']) ? intval($limit['page']) : 1;
                $page = max(1, $page);
                $top = !empty($limit['pagesize']) ? intval($limit['pagesize']) : 1;
                $top = max(1, $top);
                $offset = ($page - 1) * $top;
            } else {
                $top = intval($limit);
            }
        }
        if ($top > 0) {
            $sql .= ' LIMIT '.$offset.','.$top;
        }
        return $this->db->query($sql)->list_array();
    }

    /**
     * 选课来源学校列表
     * @param $crid 当前网校ID
     * @param array $condition 查询条件
     * @param bool $setKey 是否以来源网校ID为key
     * @param int $limit 查询限量条件
     * @return array
     */
    public function getSourceList($crid, $condition = array(), $setKey = false, $limit = 0) {
        $crid = intval($crid);
        $offset = 0;
        $top = 0;
        if (!empty($limit)) {
            if (is_array($limit)) {
                $page = !empty($limit['page']) ? intval($limit['page']) : 1;
                $page = max(1, $page);
                $top = !empty($limit['pagesize']) ? intval($limit['pagesize']) : 1;
                $top = max(1, $top);
                $offset = ($page - 1) * $top;
            } else {
                $top = intval($limit);
            }
        }
        $wheres = array('`crid`='.$crid);
        if (!empty($condition['sourcecrid'])) {
            if (is_array($condition['sourcecrid'])) {
                $sourcecrids = array_map('intval', $condition['sourcecrid']);
                $wheres[] = '`sourcecrid` IN('.implode(',', $sourcecrids).')';
                unset($sourcecrids);
            } else {
                $wheres[] = '`sourcecrid`='.intval($condition['sourcecrid']);
            }
        }
        $sql = 'SELECT `sourcecrid`,`name` FROM `ebh_schsources` WHERE '.
            implode(' AND ', $wheres).' ORDER BY `sort`,`sourceid` DESC';
        if ($top > 0) {
            $sql .= ' LIMIT '.$offset.','.$top;
        }
        return $this->db->query($sql)->list_array($setKey ? 'sourcecrid' : '');
    }

    /**
     * 企业选课列表，(分层网校)
     * @param $crid 当前网校ID
     * @param int $sourcecrid 来源网校ID,0为所有来源网校
     * @param int $limit 查询限量条件
     * @return array
     */
    public function getSourceCourseList($crid, $sourcecrid = 0, $limit = 0) {
        $crid = intval($crid);
        $sourcecrid = intval($sourcecrid);
        $fields = array(
            '`a`.`sourcecrid`',
            '`b`.`iname`', '`b`.`itemid`', '`b`.`pid`', '`b`.`sid`',
            '`c`.`folderid`', '`c`.`foldername`', '`c`.`img`',
            '`d`.`pname`',
            'IFNULL(`e`.`sname`,\'其他\') AS `sname`',
            'IFNULL(`e`.`sdisplayorder`,2147483647) AS `sorder`'
        );
        $wheres = array(
            '`a`.`crid`='.$crid,
            '`a`.`del`=0',
            '`f`.`crid` IS NOT NULL',
            '`b`.`status`=0',
            '`c`.`del`=0',
            '`c`.`folderlevel`=2',
            '`c`.`power`=0',
            '`d`.`status`=1',
            'IFNULL(`e`.`showbysort`,0)=0'
        );
        if ($sourcecrid > 0) {
            $wheres[] = '`a`.`sourcecrid`='.$sourcecrid;
        }
        $sql = 'SELECT '.implode(',', $fields).' FROM `ebh_schsourceitems` `a` 
               LEFT JOIN `ebh_pay_items` `b` ON `b`.`itemid`=`a`.`itemid`
               LEFT JOIN `ebh_folders` `c` ON `c`.`folderid`=`b`.`folderid`
               LEFT JOIN `ebh_pay_packages` `d` ON `d`.`pid`=`b`.`pid`
               LEFT JOIN `ebh_pay_sorts` `e` ON `e`.`sid`=`b`.`sid`
               LEFT JOIN `ebh_classrooms` `f` ON `f`.`crid`=`a`.`sourcecrid` WHERE '.
            implode(' AND ', $wheres).' GROUP BY `b`.`folderid` 
            ORDER BY `d`.`displayorder` ASC,`d`.`pid` DESC,`sorder` ASC,`b`.`folderid` DESC';
        $offset = 0;
        $top = 0;
        if (!empty($limit)) {
            if (is_array($limit)) {
                $page = !empty($limit['page']) ? intval($limit['page']) : 1;
                $page = max(1, $page);
                $top = !empty($limit['pagesize']) ? intval($limit['pagesize']) : 1;
                $top = max(1, $top);
                $offset = ($page - 1) * $top;
            } else {
                $top = intval($limit);
            }
        }
        if ($top > 0) {
            $sql .= ' LIMIT '.$offset.','.$top;
        }
        return $this->db->query($sql)->list_array();
    }

    /**
     * 已选择的课程ID集,过滤无效的课程
     * @param $crid 网校ID
     * @return array
     */
    public function getManualCourseidList($crid) {
        $crid = intval($crid);
        $fields = array(
            '`a`.`itemid`'
        );
        $wheres = array(
            '`a`.`crid`='.$crid,
            '`b`.`status`=0',
            '`c`.`power`=0',
            '`c`.`del`=0'
        );
        $sql = 'SELECT '.implode(',', $fields).' FROM `ebh_manual_courses` `a` 
               LEFT JOIN `ebh_pay_items` `b` ON `b`.`itemid`=`a`.`itemid`
               LEFT JOIN `ebh_folders` `c` ON `c`.`folderid`=`b`.`folderid` 
               WHERE '.implode(' AND ', $wheres).' ORDER BY `a`.`order` DESC,`a`.`dateline` DESC';
        return $this->db->query($sql)->list_field('itemid', 'itemid');
    }

    /**
     * 获取自选课程,过滤无效的课程
     * 包中的课程按添加时间升序排序，包以第一个课程的添加时间升序排序,本网校的课程优先
     * @param $crid 网校ID
     * @param null $itype 服务包类型
     * @return array
     */
    public function getManualCourses($crid, $itype = null) {
        $crid = (int) $crid;
        $fields = array(
            '`a`.`itemid`', '`a`.`folderid`', '`a`.`dateline`', '`a`.`order`',
            '`b`.`iprice`', '`b`.`cannotpay`', '`b`.`itype`', '`b`.`iname`', '`b`.`sid`', 'IF(`b`.`crid`='.$crid.',0,1) AS `other`',
            '`c`.`foldername`', '`c`.`img`', '`c`.`coursewarenum`', '`c`.`fprice`',
            '0 AS `isschoolfree`', '`c`.`viewnum`', '`c`.`speaker`', '`c`.`summary`' , '`c`.`showmode`',
            '`d`.`pid`', '`d`.`pname`', '`d`.`crid`'
        );
        $wheres = array(
            '`a`.`crid`='.$crid,
            '`b`.`status`=0',
            '`c`.`power`=0',
            '`c`.`del`=0',
            '`d`.`status`=1'
        );
        $sql = 'SELECT '.implode(',', $fields).' FROM `ebh_manual_courses` `a` 
               LEFT JOIN `ebh_pay_items` `b` ON `b`.`itemid`=`a`.`itemid`
               LEFT JOIN `ebh_folders` `c` ON `c`.`folderid`=`b`.`folderid`
               LEFT JOIN `ebh_pay_packages` `d` ON `d`.`pid`=`b`.`pid` 
               WHERE '.implode(' AND ', $wheres);
        $ret = $this->db->query($sql)->list_array('itemid');
        if (empty($ret)) {
            return array();
        }
        //第三方网校课程，重置自定义价格
        $others = array_filter($ret, function($item) {
            return $item['other'] == '1';
        });
        if (!empty($others)) {
            $otherids = array_keys($others);
            $sql = 'SELECT `price`,`itemid`,`del` FROM `ebh_schsourceitems` WHERE `itemid` IN('.implode(',',$otherids).') AND `crid`='.$crid;
            $others = $this->db->query($sql)->list_array('itemid');
            foreach ($others as $ok => $other) {
                if ($other['del'] == '1') {
                    unset($ret[$ok]);
                    continue;
                }
                $ret[$ok]['iprice'] = $other['price'];
                $ret[$ok]['cannotpay'] = 0;
            }
            unset($others);
        }
        $packages = array();
        foreach ($ret as $item) {
            //将课程按服务包分组
            if (!isset($packages[$item['pid']])) {
                $packages[$item['pid']] = array(
                    'pid' => $item['pid'],
                    'pname' => $item['pname'],
                    'crid' => $item['crid'],
                    'other' => $item['other']
                );
            }
            $packages[$item['pid']]['children'][] = $item;
        }
        unset($ret);
        //排序课程
        array_walk($packages, function(&$pitem) {
            $ts = array_column($pitem['children'], 'dateline');
            array_multisort($ts, SORT_ASC, SORT_NUMERIC, $pitem['children']);
        });
        //排序服务包
        $crids = array_column($packages, 'other');
        //第一个课程时间
        $ts = array_map(function($package) {
            $firstCourse = reset($package['children']);
            return $firstCourse['dateline'];
        }, $packages);
        array_multisort($crids, SORT_ASC, SORT_NUMERIC,
            $ts, SORT_ASC, SORT_NUMERIC, $packages);
        unset($crids, $ts);
        return $packages;
    }

    /**
     * 批量设置自选课程,允许选定第三方网校课程
     * @param $adds 新增的自选课程服务项ID
     * @param $dels 删除的自选课程服务项ID
     * @param $crid 网校ID
     * @return bool
     */
    public function datchUpdateManualCourse($adds, $dels, $crid) {
        $crid = (int) $crid;
        if (is_array($dels)) {
            $dels = array_map('intval', $dels);
            $sql = 'DELETE FROM `ebh_manual_courses` WHERE `itemid` IN('.implode(',', $dels).') AND `crid`='.$crid;
        } else {
            $sql = 'DELETE FROM `ebh_manual_courses` WHERE `itemid`='.intval($dels).' AND `crid`='.$crid;
        }
        $this->db->query($sql);
        if (is_array($adds)) {
            $adds = array_map('intval', $adds);
        } else {
            $adds = array(intval($adds));
        }
        $wheres = array(
            '`a`.`itemid` IN('.implode(',', $adds).')',
            '`a`.`status`=0',
            '`b`.`del`=0'
        );
        $sql = 'SELECT `a`.`folderid`,`a`.`itemid` FROM `ebh_pay_items` `a` 
                LEFT JOIN `ebh_folders` `b` ON `b`.`folderid`=`a`.`folderid` 
                WHERE '.implode(' AND ', $wheres);
        $manuals = $this->db->query($sql)->list_array('itemid');
        if (empty($manuals)) {
            return true;
        }
        $now = SYSTIME;
        foreach ($adds as $itemid) {
            if (!isset($manuals[$itemid])) {
                continue;
            }
            $this->db->insert('ebh_manual_courses', array(
                'itemid' => $itemid,
                'crid' => $crid,
                'folderid' => $manuals[$itemid]['folderid'],
                'dateline' => $now++
            ));
        }
        return true;
    }

    /**
     * 获取服务包列表，按优先级、添加顺序取
     * 服务包可能是第三方网校的,只返回有服务项的包
     * @param $crid 网校ID
     * @param bool $setKey 是否以服务包ID为键
     * @param int $limit 查询限量条件
     * @return mixed
     */
    public function getPackageMenu($crid, $setKey = true, $limit = 0) {
        $crid = intval($crid);
        $top = $offset = 0;
        if (!empty($limit)) {
            if (is_array($limit)) {
                $page = !empty($limit['page']) ? intval($limit['page']) : 1;
                $page = max(1, $page);
                $top = !empty($limit['pagesize']) ? intval($limit['pagesize']) : 1;
                $top = max(1, $top);
                $offset = ($page - 1) * $top;
            } else {
                $top = intval($limit);
            }
        }
        $wheres = array(
            '`a`.`crid`='.$crid,
            '`a`.`status`=0',
            '`b`.`del`=0',
            '`b`.`power`=0',
            '`b`.`folderlevel`=2',
            '`c`.`status`=1',
            '`c`.`itype`=0'
        );
        $sql = 'SELECT DISTINCT `a`.`pid`,`c`.`pname`,`c`.`displayorder`,IF(`c`.`crid`='.$crid.',1,0) AS `source` 
                FROM `ebh_pay_items` `a` 
                LEFT JOIN `ebh_folders` `b` ON `b`.`folderid`=`a`.`folderid` 
                LEFT JOIN `ebh_pay_packages` `c` ON `c`.`pid`=`a`.`pid` 
                WHERE '.implode(' AND ', $wheres).' ORDER BY `source` DESC,`c`.`displayorder`,`a`.`pid`';
        unset($wheres);
        if ($top > 0) {
            $sql .= ' LIMIT '.$offset.','.$top;
        }
        return $this->db->query($sql)->list_array($setKey ? 'pid' : '');
    }

    /**
     * 获取服务分类列表，按优先级、添加顺序取
     * @param $pid 服务包ID
     * @param bool $setKey $setKey 是否以服务包ID为键
     * @param int $limit 查询限量条件
     * @return mixed
     */
    public function getSortMenu($pid, $setKey = true, $limit = 0) {
        $pid = intval($pid);
        $top = $offset = 0;
        if (!empty($limit)) {
            if (is_array($limit)) {
                $page = !empty($limit['page']) ? intval($limit['page']) : 1;
                $page = max(1, $page);
                $top = !empty($limit['pagesize']) ? intval($limit['pagesize']) : 1;
                $top = max(1, $top);
                $offset = ($page - 1) * $top;
            } else {
                $top = intval($limit);
            }
        }
        $wheres = array(
            '`a`.`pid`='.$pid,
            '`a`.`status`=0',
            '`b`.`del`=0',
            '`b`.`power`=0',
            '`b`.`folderlevel`=2',
            'IFNULL(`c`.`ishide`,0)=0'
        );
        $sql = 'SELECT DISTINCT `a`.`sid`,IFNULL(`c`.`sname`,\'其他\') AS `sname` FROM `ebh_pay_items` `a`
                LEFT JOIN `ebh_folders` `b` ON `b`.`folderid`=`a`.`folderid` 
                LEFT JOIN `ebh_pay_sorts` `c` ON `c`.`sid`=`a`.`sid` 
                WHERE '.implode(' AND ', $wheres).' ORDER BY 
                IFNULL(`c`.`sdisplayorder`,2147483647),`c`.`sid` DESC';
        unset($wheres);
        if ($top > 0) {
            $sql .= ' LIMIT '.$offset.','.$top;
        }
        return $this->db->query($sql)->list_array($setKey ? 'sid' : '');
    }

    public function getPayItemList($crid) {

    }

/////////////////////
    /**
     * 服务包
     * @param $crid 所在网校ID
     * @param null $itype 服务类型,0：原有方式创建的服务包，1：精品课堂创建的服务包
     * @param null $limit 限制条件
     * @param bool $setKey 设置键
     * @return mixed
     */
    public function payPackageMenu($crid, $itype = null, $limit = null, $setKey = false) {
        $params = array(
            '`crid`='.intval($crid),
            '`status`=1'
        );
        if ($itype !== NULL) {
            $params[] = '`itype`='.(intval($itype) == 0 ? 0 : 1);
        }
        $sql = 'SELECT `pid`,`pname`,`displayorder`,`located` FROM `ebh_pay_packages` WHERE '.implode(' AND ', $params).' ORDER BY `displayorder` ASC,`pid` DESC';
        if (!empty($limit)) {
            $top = 20;
            $offset = 0;
            if (is_array($limit)) {
                if (isset($limit['pagesize'])) {
                    $top = max(1, intval($limit['pagesize']));
                }
                $page = 1;
                if (isset($limit['page'])) {
                    $page = max($page, intval($limit['page']));
                }
                $offset = ($page - 1) * $top;
            } else {
                $top = max(1, intval($limit));
            }
            $sql .= ' LIMIT '.$offset.','.$top;
        }

        $mine = $this->db->query($sql)->list_array($setKey ? 'pid' : '');
        if (empty($limit)) {
            //第三方包
            $wheres = array(
                '`a`.`crid`='.$crid,
                '`a`.`del`=0',
                '`b`.`status`=0',
                '`c`.`status`=1',
                '`d`.`del`=0',
                '`d`.`folderlevel`=2'
            );
            $sql = 'SELECT DISTINCT `b`.`pid`,`c`.`pname`,`c`.`displayorder`,`c`.`located` FROM `ebh_schsourceitems` `a` LEFT JOIN `ebh_pay_items` `b` ON `b`.`itemid`=`a`.`itemid` 
                    LEFT JOIN `ebh_pay_packages` `c` ON `c`.`pid`=`b`.`pid` 
                    LEFT JOIN `ebh_folders` `d` ON `d`.`folderid`=`b`.`folderid` 
                    WHERE '.implode(' AND ', $wheres).' ORDER BY `c`.`displayorder`,`c`.`pid` DESC';
            $others = $this->db->query($sql)->list_array($setKey ? 'pid' : '');
            $mine = $mine + $others;
        }
        return $mine;
    }

    /**
     * 服务包分类
     * @param $pid 服务包ID
     * @param $setKey 是否设置键
     * @return mixed
     */
    public function paySortMenu($pid, $setKey) {
        if (is_array($pid)) {
            $pid = array_map('intval', $pid);
            $pid = array_filter($pid, function($id) {
               return $id > 0;
            });
            $pid = array_unique($pid);
            $filterParams = array(
                '`pid` IN('.implode(',', $pid).')',
                '`ishide`=0'
            );
        } else {
            $filterParams = array(
                '`pid`='.intval($pid),
                '`ishide`=0'
            );
        }

        $sql = 'SELECT `sid`,`pid`,`sname` FROM `ebh_pay_sorts` WHERE '.implode(' AND ', $filterParams).' ORDER BY `sdisplayorder` ASC,`sid` DESC';
        return $this->db->query($sql)->list_array($setKey ? 'sid' : '');
    }

    /**
     * 判断包下是否有未设置分类的服务项
     * @param $pid 服务包ID
     * @return bool
     */
    public function hasOtherItem($pid, $crid) {
        $item = $this->db->query(
            'SELECT `itemid` FROM `ebh_pay_items` WHERE `pid`='.intval($pid).' AND `sid`=0 AND `crid`='.intval($crid))
            ->row_array();
        if (!empty($item)) {
            return true;
        }
        //查询选课服务项
        $wheres = array(
            '`a`.`crid`='.$crid,
            '`a`.`del`=0',
            '`b`.`status`=0',
            '`b`.`sid`=0',
            '`b`.`pid`='.$pid,
            '`c`.`status`=1',
            '`d`.`del`=0',
            '`d`.`folderlevel`=2'
        );
        $sql = 'SELECT DISTINCT `b`.`sid` FROM `ebh_schsourceitems` `a` 
                LEFT JOIN `ebh_pay_items` `b` ON `b`.`itemid`=`a`.`itemid` 
                LEFT JOIN `ebh_pay_packages` `c` ON `c`.`pid`=`b`.`pid` 
                LEFT JOIN `ebh_folders` `d` ON `d`.`folderid`=`b`.`folderid` 
                WHERE '.implode(' AND ', $wheres).' LIMIT 1';
        $other = $this->db->query($sql)->row_array();
        if (!empty($other)) {
            return true;
        }
        return false;
    }

    /**
     * 服务项集
     * @param $crid 所属网校ID
     * @param null $filterParams 筛选条件
     * @return mixed
     */
    public function payItemList($crid, $filterParams = null) {
        $fields = array(
            '`a`.`itemid`',
            '`a`.`iname`',
            '`a`.`pid`',
            '`a`.`sid`',
            '`a`.`iprice`',
            '`a`.`cannotpay`',
            '`a`.`view_mode`',
            '`d`.`fprice`',
            'IFNULL(`c`.`sname`,\'\') AS `sname`',
            'IFNULL(`c`.`showbysort`,0) AS `showbysort`',
            'IFNULL(`c`.`showaslongblock`,0) AS `showaslongblock`',
            '`c`.`imgurl`',
            '`c`.`content`',
            '`d`.`folderid`',
            '`d`.`foldername`',
            '`d`.`isschoolfree`',
            '`d`.`viewnum`',
            '`d`.`coursewarenum`',
            '`d`.`img`',
            '`d`.`summary`',
            '`d`.`showmode`',
            '`d`.`speaker`',
            '`d`.`displayorder` AS `fdisplayorder`',
            '`b`.`displayorder` AS `pdisplayorder`'
        );
        $params = array(
            '`b`.`crid`='.intval($crid),
            '`b`.`status`=1',
            'IFNULL(`c`.`ishide`,0)=0',
            '`a`.`status`=0',
            '`d`.`del`=0',
            '`d`.`power`=0'
        );
        $pid = 0;
        $sid = -1;
        if (!empty($filterParams)) {
            if (!empty($filterParams['pid'])) {
                $pid = intval($filterParams['pid']);
                $params[] = '`a`.`pid`='.$pid;
            }
            if ($pid > 0 && isset($filterParams['sid'])) {
                $sid = intval($filterParams['sid']);
                $params[] = '`a`.`sid`='.$sid;
            }
            if (!empty($filterParams['s'])) {
                $params[] = '`d`.`foldername` LIKE '.$this->db->escape('%'.strval($filterParams['s']).'%');
            }
            if (!empty($filterParams['folderids'])) {
                if (is_array($filterParams['folderids'])) {
                    $folderids = array_map('intval', $filterParams['folderids']);
                } else {
                    $folderids = array(intval($filterParams['folderids']));
                }
                $params[] = '`d`.`folderid` IN('.implode(',', $folderids).')';
            } else {
                if (isset($filterParams['formaster'])) {
                    $params[] = '`d`.`folderid`=0';
                }
            }
        }
        if ($sid > -1) {
            array_unshift($fields, 'IFNULL(`e`.`srank`,0) AS `srank`');
        } else if ($pid > 0) {
            array_unshift($fields, 'IFNULL(`e`.`prank`,0) AS `prank`');
        } else {
            array_unshift($fields, 'IFNULL(`e`.`grank`,0) AS `grank`');
        }
        $sql = 'SELECT '.implode(',', $fields).' FROM `ebh_pay_items` `a`'.
            ' LEFT JOIN `ebh_pay_packages` `b` ON `a`.`pid`=`b`.`pid`'.
            ' LEFT JOIN `ebh_pay_sorts` `c` ON `a`.`sid`=`c`.`sid`'.
            ' LEFT JOIN `ebh_folders` `d` ON `a`.`folderid`=`d`.`folderid`'.
            ' LEFT JOIN `ebh_courseranks` `e` ON `a`.`folderid`=`e`.`folderid`'.
            ' WHERE '.implode(' AND ', $params);
        if ($sid > -1) {
            $sql .= ' ORDER BY `e`.`srank` ASC,`a`.`itemid` DESC';
        } else if ($pid > 0) {
            $sql .= ' ORDER BY `e`.`prank` ASC,`a`.`itemid` DESC';
        } else {
            $sql .= ' ORDER BY `e`.`grank` ASC,`a`.`itemid` DESC';
        }
        return $this->db->query($sql)->list_array();
    }

    public function otherItemList($crid, $filterParams = null) {
        $fields = array(
            '`b`.`itemid`',
            '`b`.`iname`',
            '`b`.`pid`',
            '`b`.`sid`',
            '`a`.`price` AS `iprice`',
            '0 AS `cannotpay`',
            '`b`.`view_mode`',
            '`e`.`fprice`',
            'IFNULL(`d`.`sname`,\'\') AS `sname`',
            '0 AS `showbysort`',
            '0 AS `showaslongblock`',
            '`d`.`imgurl`',
            '`d`.`content`',
            '`e`.`folderid`',
            '`e`.`foldername`',
            '`e`.`isschoolfree`',
            '`e`.`viewnum`',
            '`e`.`coursewarenum`',
            '`e`.`img`',
            '`e`.`summary`',
            '`e`.`showmode`',
            '`e`.`speaker`',
            '`e`.`displayorder` AS `fdisplayorder`',
            '`c`.`displayorder` AS `pdisplayorder`'
        );
        $params = array(
            '`a`.`crid`='.intval($crid),
            '`a`.`del`=0',
            '`c`.`status`=1',
            'IFNULL(`d`.`ishide`,0)=0',
            '`b`.`status`=0',
            '`e`.`del`=0',
            '`e`.`folderlevel`=2'
        );
        $pid = 0;
        $sid = -1;
        if (!empty($filterParams)) {
            if (!empty($filterParams['pid'])) {
                $pid = intval($filterParams['pid']);
                $params[] = '`b`.`pid`='.$pid;
            }
            if ($pid > 0 && isset($filterParams['sid'])) {
                $sid = intval($filterParams['sid']);
                $params[] = '`b`.`sid`='.$sid;
            }
            if (!empty($filterParams['s'])) {
                $params[] = '`e`.`foldername` LIKE '.$this->db->escape('%'.strval($filterParams['s']).'%');
            }
            if (!empty($filterParams['folderids'])) {
                if (is_array($filterParams['folderids'])) {
                    $folderids = array_map('intval', $filterParams['folderids']);
                } else {
                    $folderids = array(intval($filterParams['folderids']));
                }
                $params[] = '`e`.`folderid` IN('.implode(',', $folderids).')';
            } else {
                if (isset($filterParams['formaster'])) {
                    $params[] = '`e`.`folderid`=0';
                }
            }
        }

        $sql = 'SELECT '.implode(',', $fields).' FROM `ebh_schsourceitems` `a` '.
            ' LEFT JOIN `ebh_pay_items` `b` ON `b`.`itemid`=`a`.`itemid`'.
            ' LEFT JOIN `ebh_pay_packages` `c` ON `c`.`pid`=`b`.`pid`'.
            ' LEFT JOIN `ebh_pay_sorts` `d` ON `d`.`sid`=`b`.`sid`'.
            ' LEFT JOIN `ebh_folders` `e` ON `e`.`folderid`=`b`.`folderid`'.
            ' WHERE '.implode(' AND ', $params);
        return $this->db->query($sql)->list_array();
    }

    /**
     * 公用头部模块
     * @param $crid
     * @return mixed
     */
    public function getPublicTopComponent($crid) {
        $component = $this->db->query(
            'SELECT `tmpid` FROM `ebh_component_schools` WHERE `crid`='.intval($crid))
            ->row_array();
        $tmpid = $component['tmpid'];
        if (empty($tmpid)) {
            $tmpid = 0;
        }
        $sql = 'SELECT `eid`,`mid`,`arg_sign`,`background_color` FROM `ebh_component_items` WHERE `tmpid`='.$tmpid.' AND `mid` IN(1,2,13) AND `status`=0 ORDER BY `ty` ASC';
        $items = $this->db->query($sql)->list_array('mid');
        if (isset($items[1])) {
            //读取头部Logo图
            $options = $this->db->query(
                'SELECT `image`,`href` FROM `ebh_component_item_options` WHERE `eid`='.$items[1]['eid'].' AND `mid`=1 AND `status`=0')
                ->list_array();
            $items[1]['custom_data']['options'] = $options;
        }
        if (isset($items[13])) {
            //读取二维码配置
            $options = $this->db->query(
                'SELECT `image`,`href` FROM `ebh_component_item_options` WHERE `eid`='.$items[13]['eid'].' AND `mid`=13 AND `status`=0')
                ->list_array();
            $items[13]['custom_data']['options'] = $options;
        }
        return $items;
    }

    /**
     * 获取首页导航
     * @param $crid
     * @param $tourl
     * @return bool|mixed
     */
    public function getNavigator($crid, &$tourl) {
        $tourl = null;
        $crid = intval($crid);
        if ($crid < 1) {
            return false;
        }
        $sql = "SELECT `navigator` FROM `ebh_classrooms` WHERE `crid`=$crid";
        $res = $this->db->query($sql)->row_array();
        if (empty($res)) {
            return false;
        }
        $navigator = unserialize($res['navigator']);
        if (!empty($navigator)) {
            $navigatorarr = $navigator['navarr'];
            $navigatorlist = Ebh::app()->getConfig()->load('roomnav');
            $hasindex = false;
            foreach($navigatorarr as $nav){
                if($nav['code'] == 'index' && !empty($nav['available'])){
                    $hasindex = true;
                    break;
                }
            }
            if(!$hasindex){
                //无主页时跳到导航设置的第一个页面
                foreach($navigatorarr as $nav){
                    if(empty($nav['available'])) {
                        continue;
                    }
                    if (in_array($nav['code'], array_keys($navigatorlist), true)){
                        $tourl = $navigatorlist[$nav['code']]['url'].'.html';
                        //return false;
                    } else {
                        $tourl = '/navcm/'.ltrim($nav['code'],'n').'.html';
                        //return false;
                    }
                    break;
                }
                if (empty($tourl)) {
                    $tourl = "http://www.ebh.net";
                }
            }

            $classroom_nav = array_filter($navigator['navarr'], function($e) {
                return !empty($e['available']);
            });
            if (!empty($classroom_nav)) {
                $nav_keys = array_keys($navigatorlist);
                $nav_keys[] = 'shop';
                foreach ($classroom_nav as &$classroom_nav_item) {
                    if (in_array($classroom_nav_item['code'], $nav_keys, true)) {
                        if ($classroom_nav_item['code'] == 'index') {
                            $classroom_nav_item['url'] = '/';
                            continue;
                        }
                        if ($classroom_nav_item['code'] == 'shop') {
                            //$classroom_nav_item['url'] = "http://shop.ebh.net/{$crid}.html";
                            $classroom_nav_item['url'] = !empty($classroom_nav_item['url']) ? $classroom_nav_item['url'] : "/shop.html";
                            $classroom_nav_item['target'] = '_blank';
                            continue;
                        }
                        $classroom_nav_item['url'] = $navigatorlist[$classroom_nav_item['code']]['url'].'.html';
                        continue;
                    }
                    if (empty($classroom_nav_item['url'])) {
                        $classroom_nav_item['url'] = '/navcm/'.ltrim($classroom_nav_item['code'],'n').'.html';
                    }
                }
                unset($nav_keys);
            }
            return $classroom_nav;
        }
        return $navigator;
    }

    /**
     * 课程菜单：服务包->分类
     * @param $crid
     * @return bool
     */
    public function getCourseMenu($crid) {
        $crid = (int) $crid;
        if ($crid < 1) {
            return false;
        }
        $sql = "SELECT `pname`,`pid`,`displayorder` FROM `ebh_pay_packages` WHERE `crid`=$crid AND `status`=1 ORDER BY `displayorder` ASC,`pid` DESC LIMIT 5";
        $server_packages = $this->db->query($sql)->list_array('pid');
        if (empty($server_packages)) {
            return false;
        }
        $pid_arr = array_keys($server_packages);
        $pid_arr = array_unique($pid_arr);
        $pid_arr_str = implode(',', $pid_arr);
        $sql = "SELECT `sid`,`sname`,`pid` FROM `ebh_pay_sorts` WHERE `pid` IN($pid_arr_str) AND `ishide`=0 ORDER BY `sdisplayorder` ASC,`sid` DESC";
        $sorts = $this->db->query($sql)->list_array();
        if (!empty($sorts)) {
            foreach ($sorts as $sort) {
                $server_packages[$sort['pid']]['sorts'][] = $sort;
            }
        }
        $sql = "SELECT DISTINCT `a`.`pid` FROM `ebh_pay_items` `a` JOIN `ebh_folders` `b` ON `a`.`folderid`=`b`.`folderid` 
                WHERE `a`.`crid`=$crid AND `a`.`pid` IN($pid_arr_str) AND `a`.`sid`=0 AND `a`.`status`=0 AND `a`.`cannotpay`=0 AND `b`.`del`=0";
        $other_items = $this->db->query($sql)->list_array();
        if (!empty($other_items)) {
            foreach ($other_items as $item) {
                $server_packages[$item['pid']]['sorts'][] = array(
                    'sid' => 0,
                    'pid' => $item['pid'],
                    'sname' => '其它课程'
                );
            }
        }
        return $server_packages;
    }

    /**
     * 获取用户的课程权限
     * @param $uid
     * @param $crid
     * @return bool
     */
    public function getUserpermisions($uid, $crid) {
        $now = SYSTIME - 86400;
        $crid = (int) $crid;
        return $this->db->query(
            "SELECT DISTINCT `folderid` FROM `ebh_userpermisions` WHERE `uid`=$uid AND `crid`=$crid AND `cwid`=0 AND `enddate`>=$now")
            ->list_field();
    }

    /**
     * 添加自选课程
     * @param $itemid 服务项ID
     * @param $crid 网校ID
     * @return bool
     */
    public function addManualCourse($itemid, $crid) {
        $itemid = (int) $itemid;
        $crid = (int) $crid;
        $wheres = array(
            '`itemid`='.$itemid,
            '`crid`='.$crid,
            '`status`=0'
        );
        $item = $this->db->query(
            'SELECT `folderid` FROM `ebh_pay_items` WHERE '.implode(' AND ', $wheres))
            ->row_array();
        if (empty($item)) {
            return false;
        }
        $this->db->insert('ebh_manual_courses', array(
            'itemid' => $itemid,
            'crid' => $crid,
            'folderid' => $item['folderid'],
            'dateline' => SYSTIME
        ));
    }

    /**
     * 删除自选课程
     * @param $itemid 服务项ID
     * @param $crid 网校ID
     * @return mixed
     */
    public function delManualCourse($itemid, $crid) {
        $itemid = (int) $itemid;
        $crid = (int) $crid;
        $wheres = array(
            'itemid' => $itemid,
            'crid' => $crid
        );
        return $this->db->delete('ebh_manual_courses', $wheres);
    }

    /**
     * 自选课程页板数据
     * @param $crid
     * @param null $itype
     * @return array
     */
    public function getManualCoursesForPanel($crid, $itype = null) {
        $crid = (int) $crid;
        $items = $this->db->query(
            'SELECT `itemid`,`pid`,`iname`,`sid`,`folderid` FROM `ebh_pay_items` WHERE `crid`='.$crid.' AND `status`=0')
            ->list_array('itemid');
        if (empty($items)) {
            return array();
        }
        $pids = array_column($items, 'pid', 'itemid');
        $upids = array_unique($pids);
        $wheres = array(
            '`pid` IN('.implode(',', $upids).')',
            '`status`=1'
        );
        if ($itype !== null) {
            $wheres[] = '`itype`='.(intval($itype) == 1 ? 1 : 0);
        }
        $packages = $this->db->query(
            'SELECT `pid`,`pname` FROM `ebh_pay_packages` WHERE '.implode(' AND ', $wheres))
            ->list_array('pid');
        if (count($packages) != count($upids)) {
            $tmp_pids = array_keys($packages);
            $disabled = array_diff($pids, $tmp_pids);
            unset($tmp_pids, $upids);
            $items = array_diff_key($items, $disabled);
        }
        if (empty($items)) {
            return array();
        }
        $fids = array_column($items, 'folderid', 'itemid');
        $ufids = array_unique($fids);
        $wheres = array(
            '`folderid` IN('.implode(',', $ufids).')',
            '`del`=0',
            '`power`=0'
        );
        $folders = $this->db->query('SELECT `folderid`,`foldername`,`img` FROM `ebh_folders` WHERE '.implode(' AND ', $wheres))
            ->list_array('folderid');
        if (count($folders) != count($ufids)) {
            $tmp_fids = array_keys($folders);
            $disabled = array_diff($fids, $tmp_fids);
            unset($tmp_fids, $ufids);
            $items = array_diff_key($items, $disabled);
        }
        if (empty($items)) {
            return array();
        }
        $sids = array_column($items, 'sid', 'itemid');
        $usids = array_unique($sids);
        $wheres = array(
            '`sid` IN('.implode(',', $usids).')',
            '`showbysort`=0',
            '`ishide`=0'
        );
        $sorts = $this->db->query(
            'SELECT `sid` FROM `ebh_pay_sorts` WHERE '.implode(' AND ', $wheres))
            ->list_field();
        $sorts[] = '0';
        $disabled = array_diff($sids, $sorts);
        $items = array_diff_key($items, $disabled);
        if (empty($items)) {
            return array();
        }
        $manuals = $this->db->query(
            'SELECT `itemid` FROM `ebh_manual_courses` WHERE `crid`='.$crid)
            ->list_field('itemid', 'itemid');
        $ret = array();
        foreach ($items as $itemid => $item) {
            if (!isset($packages[$item['pid']])) {
                continue;
            }
            if (empty($packages[$item['pid']]['pname'])) {
                die($item['pid']);
            }
            if (!isset($ret[$item['pid']])) {
                $ret[$item['pid']] = $packages[$item['pid']];
            }
            $item = array_merge($item, $folders[$item['folderid']]);
            $item['choosed'] = isset($manuals[$itemid]);
            $ret[$item['pid']]['children'][$itemid] = $item;
        }
        return $ret;
    }

    /**
     * 定位服务包
     * @param $pid 服务包ID
     * @param $crid 网校ID
     * @return mixed
     */
    public function locatedPackage($pid, $crid) {
        $pid = (int) $pid;
        $crid = (int) $crid;
        $this->db->update('ebh_pay_packages', array('located' => 0), array(
            'crid' => $crid
        ));
        return $this->db->update('ebh_pay_packages', array('located' => 1), array(
            'pid' => $pid,
            'crid' => $crid
        ));
    }

    /**
     * 切换网校类型后同步模板参数
     * @param $property
     * @param $crid
     * @return bool
     */
    public function changeRoomType($property, $crid) {
        $crid = (int) $crid;
        if ($crid < 1) {
            return false;
        }
        $tmp = $this->db->query(
            'SELECT `category` FROM `ebh_component_schools` WHERE `crid`='.$crid)
            ->row_array();
        if (empty($tmp)) {
            return true;
        }
        if ($property == 3 && $tmp['category'] == 0) {
            return $this->db->update('ebh_component_schools', array('category' => 1), '`crid`='.$crid);
        } else if ($property != 3 && $tmp['category'] == 1) {
            return $this->db->update('ebh_component_schools', array('category' => 0), '`crid`='.$crid);
        }
    }




    /************************************************************************************************/
    /**
     * 网校详情
     * @param $crid
     * @return mixed
     */
    public function getClassroomDetail($crid) {
        return $this->db->query(
            'SELECT `summary`,`message` FROM `ebh_classrooms` WHERE `crid`='.intval($crid))
            ->row_array();
    }

    /**
     * 头部模块
     * @param $crid 网校ID
     * @param bool $iscom 是否企业网校模板
     * @return array
     */
    public function getTopModules($crid, $iscom = false) {
        $crid = intval($crid);
        $category = $iscom ? 1 : 0;
        $sql = 'SELECT `tmpid`,`crid` FROM `ebh_component_schools` WHERE `crid` IN('.$crid.',0) AND `category`='.
            $category.' ORDER BY `crid` DESC';
        $component = $this->db->query($sql)->row_array();
        if (empty($component)) {

        }
        return array();
    }
}