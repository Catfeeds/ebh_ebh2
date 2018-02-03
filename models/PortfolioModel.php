<?php
/**
 * 网校门户模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/9
 * Time: 15:58
 */
class PortfolioModel extends CModel {
    private $_redis;

    /**
     * 原有方式创建的服务包
     */
    const PACKAGE_TYPE_INT_NORMAL = 0;
    /**
     * 精品课堂创建的服务包
     */
    const PACKAGE_TYPE_INT_BEST = 1;
    /**
     * 全部服务包
     */
    const PACKAGE_TYPE_INT_ALL = 2;


    //fastcgi_finish_request();
    public function __construct()
    {
        parent::__construct();
        $this->_redis = Ebh::app()->getCache('cache_redis');
    }

    /**
     * 获取模块配置
     * @param $crid 网校ID:0表示获取默认配置
	 * @param $category 网校类型：0-网校版，1-企业版
     * @param $reset 是否重新从配置参数中生成配置
     * @return array|bool
     */
    public function getPortfolioConfig($crid, $category = 0, $reset = false) {
        $crid = intval($crid);
        $room_cache = Ebh::app()->lib('Roomcache');
        $modules = $room_cache->getCache($crid, 'other', 'plate-cofing');
        if (false&&!empty($modules)) {
            return $modules;
        }
        //从配置表中读取配置
		$sql = 'SELECT `crid`,`tmpid`,`theme` FROM `ebh_component_schools` WHERE `crid` IN ('.$crid.',0) AND `category`='.intval($category).' ORDER BY `crid` DESC LIMIT 1';
        $ret = $this->db->query($sql)->row_array();
        if (empty($ret)) {
            return false;
        }
        //json解析错误，重新生成json文件
        $tmpid = $ret['tmpid'];
		$reset_eid = false;

        if ($ret['crid'] != $crid) {
			$reset_eid = true;
			$crid = intval($ret['crid']);
            $sql = "SELECT `eid`,`mid`,`ititle`,`columns`,`rows`,`max_rows` AS `max_data_count`,`tx` `left`,`ty` `top`,`width`,`height`,`background_color`,`arg_sign` 
                    FROM `ebh_component_items` 
                    WHERE `tmpid`=$tmpid AND `status`=0 ORDER BY `top` ASC,`left` ASC";
        } else {
            $sql = "SELECT `eid`,`mid`,`ititle`,`columns`,`rows`,`max_rows` AS `max_data_count`,`tx` `left`,`ty` `top`,`width`,`height`,`background_color`,`arg_sign` 
                    FROM `ebh_component_items` 
                    WHERE `tmpid`=$tmpid AND `status`=0 ORDER BY `top` ASC,`left` ASC";
        }

        $ret = $this->db->query($sql)->list_array();
        if (empty($ret)) {
            return false;
        }
        $sql = "SELECT `mid`,`code`,`ctitle`,`show_type`,`renameable`,`backgroundable`,`repeatable`,`resizeable`,`area_sign`," .
            "`module_type`,`disabled`,`editable` FROM `ebh_component_bases` ORDER BY `zindex` ASC,`mid` ASC";
        $m = $this->db->query($sql)->list_array('mid');
        $columns_m = array_map(function($e) {
            $ret = array();
            $c = $e['area_sign'] & 8;
            if ($c == 8) {
                $ret[] = 4;
            }
            $c = $e['area_sign'] & 4;
            if ($c == 4) {
                $ret[] = 3;
            }
            $c = $e['area_sign'] & 2;
            if ($c == 2) {
                $ret[]  = 2;
            }
            $c = $e['area_sign'] & 1;
            if ($c == 1) {
                $ret[] = 1;
            }
            return $ret;
        }, $m);
        $sql = 'SELECT `eid`,`image`,`href`,`zindex`,`bgcolor` FROM `ebh_component_item_options` WHERE `crid`='.$crid.' AND `status`=0 ORDER BY `zindex` ASC';

        $options = $this->db->query($sql)->list_array();
        $sql = 'SELECT `eid`,`richtext` FROM `ebh_component_richtexts` WHERE `crid`='.$crid.' AND `status`=1';
        $rich_texts = $this->db->query($sql)->list_array('eid');

        $has_disabled = false;
        foreach ($ret as &$ret_item) {
            if ($m[$ret_item['mid']]['disabled'] != 0) {
                //模块已禁用
                $has_disabled = true;
                $ret_item['remove'] = 1;
                continue;
            }
            $ret_item['code'] = $m[$ret_item['mid']]['code'];
            $ret_item['show_type'] = $m[$ret_item['mid']]['show_type'];
            if (empty($ret_item['ititle'])) {
                $ret_item['ititle'] = $m[$ret_item['mid']]['ctitle'];
            }
            $ret_item['editable'] = $m[$ret_item['mid']]['editable'];
            $ret_item['area_sign'] = $columns_m[$ret_item['mid']];
            if ($ret_item['editable']) {
                //echo $ret_item['eid'];print_r($options);exit;
                $ret_item['custom_data'] = array(
                    'bgcolor' => $ret_item['background_color'],
                    'options' => array()
                );
                if (!empty($ret_item['eid']) && !empty($options)) {
                    foreach ($options as $option) {
                        if ($option['eid'] == $ret_item['eid']) {
                            $ret_item['custom_data']['options'][] = array(
                                'image' => $option['image'],
                                'href' => $option['href'],
                                'zindex' => $option['zindex'],
                                'bgcolor' => $option['bgcolor']
                            );
                        }
                    }
                }
                if (!empty($ret_item['eid']) && !empty($rich_texts[$ret_item['eid']])) {
                    $ret_item['custom_data']['richtext'] = stripslashes($rich_texts[$ret_item['eid']]['richtext']);
                }
            }
            $ret_item['ctitle'] = $m[$ret_item['mid']]['ctitle'];
            if ($ret_item['mid'] == 11) {
                $ret_item['ititle'] = '';
                $ret_item['ctitle'] = '';
            }
			if ($reset_eid) {
				//$ret_item['eid'] = 0;
                $ret_item['reset_eid'] = true;
			}
        }
        if ($has_disabled) {
            $ret = array_filter($ret, function($e) {
               return empty($e['remove']);
            });
        }
        //$json_str = json_encode($ret);
        $room_cache->setCache($crid, 'other', 'plate-cofing', $ret);
        return $ret;
    }

    /**
     * 保存模块配置
     * @param $crid
	 * @param $room_type
     * @param $config
     * @param $baseurl
     * @return array|bool
     */
    public function savePortfolioConfig($crid, $room_type, $config, $baseurl = '') {
        $crid = (int) $crid;
        //配置有效性验证
        if ($crid < 1 || empty($config) || !is_array($config)) {
            return false;
        }

        $err_config = array_filter($config, function($e) {
            if (!is_array($e) || empty($e['mid'])) {
                return true;
            }
            if (!empty($e['editable']) && !empty($e['custom_data']['options'])) {
                foreach ($e['custom_data']['options'] as $option) {
                    return /*!empty($option['href']) && !preg_match("/^https?:\/\/.+?$/", $option['href']) ||*/
                    !empty($option['bgcolor']) && !preg_match('/^#(?:[0-9a-f]{3}){1,2}$/i', $option['bgcolor']);
                }
            }
           return  false;
        });
        if (!empty($err_config)) {
            return array(
                'errno' => 11,
                'msg' => '配置格式错误'
            );
        }

        $sql = "SELECT `mid`,`code`,`ctitle`,`show_type`,`renameable`,`backgroundable`,`repeatable`,`resizeable`,`area_sign`,
            `module_type`,`disabled`,0 AS `mcount` FROM `ebh_component_bases`";
        $m = $this->db->query($sql)->list_array('mid');

        //修改的模块项ID
        $eid_arr = array();

        //禁用的模块
        $disabled_m = array_filter($m, function($e) {
            return $e['disabled'];
        });
        $disabled_m = array_keys($disabled_m);
        //单一调用的模块
        $single_m = array_filter($m, function($e) {
            return !$e['repeatable'];
        });
        //可重命名的模块
        $renameabled_m = array_filter($m, function($e) {
            return $e['renameable'];
        });
        $renameabled_m = array_keys($renameabled_m);
        //模块规格表
        $columns_m = array_map(function($e) {
            $ret = array();
            $c = $e['area_sign'] & 8;
            if ($c == 8) {
                $ret[] = 4;
            }
            $c = $e['area_sign'] & 4;
            if ($c == 4) {
                $ret[] = 3;
            }
            $c = $e['area_sign'] & 2;
            if ($c == 2) {
                $ret[]  = 2;
            }
            $c = $e['area_sign'] & 1;
            if ($c == 1) {
                $ret[] = 1;
            }
            return $ret;
        }, $m);
        //数据验证
        foreach ($config as $config_item) {
            if (in_array($config_item['mid'], $disabled_m)) {
                return array(
                    'errno' => 101,
                    'msg' => sprintf('配置错误:模块[%d]已禁用', $config_item['mid'])
                );
            }

            if (!in_array($config_item['mid'], $renameabled_m) && !empty($config_item['ititle']) && $config_item['ititle'] != $config_item['ctitle']) {
                return array(
                    'errno' => 102,
                    'msg' => sprintf('配置错误:模块[%d]禁用自定义名称', $config_item['mid'])
                );
            }

            if (array_key_exists($config_item['mid'], $single_m)) {
                $single_m[$config_item['mid']]['mcount']++;
                if ($single_m[$config_item['mid']]['mcount'] > 1) {
                    return array(
                        'errno' => 103,
                        'msg' => sprintf('配置错误:模块[%d]只能调用一次', $config_item['mid'])
                    );
                }
            }

            if (!in_array($config_item['columns'], $columns_m[$config_item['mid']])) {
                return array(
                    'errno' => 104,
                    'msg' => sprintf('配置错误:模块[%d]-%d行-%d列，使用错误', $config_item['mid'],
                        $config_item['columns'], $config_item['rows'])
                );
            }

            if (!empty($config_item['eid'])) {
                $eid_arr[] = $config_item['eid'];
            }
        }

        $json_str = json_encode($config);

        $redundancy_eids = $this->db->query("SELECT `eid` FROM `ebh_component_items` WHERE `crid`=$crid")
            ->list_field('eid');
        //冗余的模块配置项
        if (!empty($redundancy_eids) && !empty($eid_arr)) {
            $redundancy_eids = array_diff($redundancy_eids, $eid_arr);
        }
        //新增的模块配置项
        $new_module_arr = array();
        $this->db->begin_trans();
        //更新模板配置表
        $sql = "SELECT `tmpid` FROM `ebh_component_schools` WHERE `crid`=$crid LIMIT 1";
        $ret = $this->db->query($sql)->row_array();
        if (empty($ret)) {
            $tmpid = $this->db->insert('ebh_component_schools', array(
                'crid' => $crid,
                'jsonstr' => $json_str,
				'category' => $room_type == 'com' ? 1 : 0
            ));
            if ($tmpid === 0) {
                return array(
                    'errno' => 1001,
                    'msg' => '新增模板配置失败'
                );
            }
        } else {
            $tmpid = $ret['tmpid'];
            $ret = $this->db->update('ebh_component_schools', array('jsonstr' => $json_str), "`crid`=$crid");
            if ($ret === false) {
                return array(
                    'errno' => 1002,
                    'msg' => '更新模板配置失败'
                );
            }
        }

        foreach ($config as &$ci) {
            $index = $ci['code'] . '-' . (!isset($ci['index']) ? 'm' : intval($ci['index']));
            $eid = !isset($ci['eid']) ? 0 : intval($ci['eid']);
            if ($eid == 0 && !empty($redundancy_eids)) {
                $eid = array_pop($redundancy_eids);
                $ci['custom_data']['del'] = 1;
            }
            $param = array();
            $param['mid'] = isset($ci['mid']) ? (int) $ci['mid'] : 0;
            $param['columns'] = isset($ci['columns']) ? (int) $ci['columns'] : 0;
            $param['rows'] = isset($ci['rows']) ? max(1, (int) $ci['rows']) : 0;
            $param['rows'] = $ci['show_type'] < 3 ? 1 : 0;
            $param['max_rows'] = isset($ci['max_data_count']) ? (int) $ci['max_data_count'] : 0;
            $param['tx'] = isset($ci['left']) ? (int) $ci['left'] : 0;
            $param['ty'] = isset($ci['top']) ? (int) $ci['top'] : 0;
            $param['width'] = isset($ci['width']) ? (int) $ci['width'] : 0;
            $param['height'] = isset($ci['height']) ? (int) $ci['height'] : 0;
            $param['arg_sign'] = isset($ci['arg_sign']) ? (int) $ci['arg_sign'] : 0;
            if (isset($ci['background_color'])) {
                $param['background_color'] = trim($ci['background_color']);
            } else {
                $param['background_color'] = '';
            }
            if ($ci['editable'] && !empty($ci['custom_data']['bgcolor']) &&
                preg_match('/^#(?:[0-9a-f]{3}){1,2}$/i', $ci['custom_data']['bgcolor'])) {
                $param['background_color'] = strtolower($ci['custom_data']['bgcolor']);
            }
            if (isset($ci['zindex'])) {
                $param['zindex'] = (int) $ci['zindex'];
            } else {
                $param['zindex'] = 0;
            }
            if (!empty($ci['ititle']) && $m[$ci['mid']]['ctitle'] != $ci['ititle']) {
                $param['ititle'] = trim($ci['ititle']);
            } else {
                $param['ititle'] = '';
            }
            $param['status'] = 0;

            if ($eid == 0) {
                $param['crid'] = $crid;
                $param['tmpid'] = $tmpid;
                $ret = $this->db->insert('ebh_component_items', $param);
                if ($ret > 0) {
                    $new_module_arr[] = $index . '-'. $ret;
                }
                if ($ret === 0) {
                    $this->db->rollback_trans();
                    return array(
                        'errno' => 1003,
                        'msg' => '添加模块失败'
                    );
                }
                $eid = $ret;
            } else {
                $ret = $this->db->update('ebh_component_items', $param, "`eid`=$eid");
                $new_module_arr[] = $index . '-'. $eid;
                if ($ret === false) {
                    $this->db->rollback_trans();
                    return array(
                        'errno' => 1004,
                        'msg' => '更新模块失败'
                    );
                }
            }



            //保存模块自定义数据
            //print_r($ci['custom_data']['options']);
            if (!empty($ci['custom_data']['del']) || !empty($ci['custom_data']['options'])) {
                //删除模块自定义数据
                $ret = $this->db->simple_query("DELETE FROM `ebh_component_item_options` WHERE `eid`=$eid");
                if ($ret === false) {
                    return array(
                        'errno' => 1005,
                        'msg' => '删除模块自定义数据失败'
                    );
                }
            }
            if ($ci['editable']) {
                if (!empty($ci['custom_data']['options'])) {
                    $options = array_filter($ci['custom_data']['options'], function($e) {
                        return !empty($e['image']);
                    });
                    $options = array_slice($options, 0, 8);
                    foreach ($options as $ov) {
                        $ovoption = array(
                            'eid' => $eid,
                            'crid' => $crid,
                            'mid' => $ci['mid']
                        );
                        if (is_array($ov)) {
                            $ovoption['image'] = !empty($ov['image']) ? str_replace($baseurl, '', $ov['image']) : '';
                            if (!empty($ov['href'])) {
                                if (!preg_match("/^https?:\/\/.+?$/", $ov['href'])) {
                                    $ovoption['href'] = "http://".$ov['href'];
                                } else {
                                    $ovoption['href'] = $ov['href'];
                                }
                            } else {
                                $ovoption['href'] = '';
                            }
                            $ovoption['zindex'] = !empty($ov['zindex']) ? $ov['zindex'] : '';
                            $ovoption['bgcolor'] = !empty($ov['bgcolor']) ? $ov['bgcolor'] : '';
                            $ret = $this->db->insert('ebh_component_item_options', $ovoption);
                            if ($ret == 0) {
                                $this->db->rollback_trans();
                                return array(
                                    'errno' => 1006,
                                    'msg' => '保存模块数据失败'
                                );
                            }
                        }
                        if ($ovoption['mid'] == 13) {
                            //同步二维码
                            if (strpos($ovoption['image'], 'http://') === 0) {
                                $wurl = $ovoption['image'];
                            } else {
                                $wurl = $baseurl.$ovoption['image'];
                            }
                            $this->db->update('ebh_classrooms', array('wechatimg' => $wurl), '`crid`='.$crid);
                            if ($ret == 0) {
                                $this->db->rollback_trans();
                                return array(
                                    'errno' => 1006,
                                    'msg' => '保存模块数据失败'
                                );
                            }
                        }
                    }
                }
				if (empty($ci['custom_data']) && !empty($ci['seid'])) {
					$default_rich = $this->db->query('SELECT `richtext` FROM `ebh_component_richtexts` WHERE `eid`='.$ci['seid'])->row_array();
					if (!empty($default_rich)) {
						$ci['custom_data']['richtext'] = $default_rich['richtext'];
					}
				}
                if (!empty($ci['custom_data']['richtext'])) {
                    $rich_text = str_replace('</script>', '&lt;/script&gt;', $ci['custom_data']['richtext']);
                    $rich_text = preg_replace('/<script([^>]*?)>/i', '&lt;script$1&gt;', $rich_text);
                    $rich_text = $this->db->escape($rich_text);
                    $ret = $this->db->query(
                        "REPLACE INTO `ebh_component_richtexts`(`eid`,`crid`,`richtext`) VALUES($eid, $crid, $rich_text)");
                    if (empty($ret)) {
                        $this->db->rollback_trans();
                        return array(
                            'errno' => 1007,
                            'msg' => '保存模块富文本数据失败'
                        );
                    }
                }
            }
        }
        //冗余模块配置标志删除
        if (!empty($redundancy_eids)) {
            $current_eid_arr_str = implode(',', $redundancy_eids);
            $ret = $this->db->simple_query("UPDATE `ebh_component_items` SET `status`=1 WHERE `eid` IN($current_eid_arr_str)");
            if ($ret === false) {
                $this->db->rollback_trans();
                return array(
                    'errno' => 1007,
                    'msg' => '保存失败'
                );
            }
            $ret = $this->db->simple_query("DELETE FROM `ebh_component_item_options` WHERE `eid` IN($current_eid_arr_str)");
            if ($ret === false) {
                $this->db->rollback_trans();
                return array(
                    'errno' => 1008,
                    'msg' => '保存失败'
                );
            }
        }

        $this->db->commit_trans();
        $room_cache = Ebh::app()->lib('Roomcache');
        $room_cache->removeCache($crid, 'other', 'plate-cofing');
        return array('errno' => 0, 'data' => $new_module_arr);
    }

    /**
     * 获取模块配置
     * @param $mid
     * @param $columns
     * @return bool
     */
    public function getModuleSet($mid, $columns) {
        $mid = (int) $mid;
        $columns = (int) $columns;
        if ($mid < 1 || $columns < 1 || $columns > 4) {
            return false;
        }
        $sql = "SELECT `mid`,`code`,`ctitle`,`show_type`,`renameable`,`backgroundable`,`editable`,`area_sign` FROM `ebh_component_bases` WHERE `mid`=$mid";
        $module = $this->db->query($sql)->row_array();
        if (empty($module)) { return false; }
        $ret = array();
        $c = $module['area_sign'] & 8;
        if ($c == 8) {
            $ret[] = 4;
        }
        $c = $module['area_sign'] & 4;
        if ($c == 4) {
            $ret[] = 3;
        }
        $c = $module['area_sign'] & 2;
        if ($c == 2) {
            $ret[]  = 2;
        }
        $c = $module['area_sign'] & 1;
        if ($c == 1) {
            $ret[] = 1;
        }
        if (!in_array($columns, $ret)) {
            return false;
        }
        $module['area_sign'] = $ret;
        return $module;
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
        if (!empty($res)) {
            $navigator = unserialize($res['navigator']);
        }
        $navigatorlist = Ebh::app()->getConfig()->load('roomnav');

        if (!empty($navigator)) {
            $navigatorarr = $navigator['navarr'];
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
        $defined = array_map(function($n) {
            $n['nickname'] = $n['name'];
            if ($n['url'] != '/') {
                $n['url'] .= '.html';
            }
            return $n;
        }, $navigatorlist);
        return $defined;
    }

    /**
     * 获取网校公告
     * @param $crid
     * @param int $num
     * @return bool
     */
    public function getNoticeList($crid, $num = 3) {
        $crid = intval($crid);
        if ($crid < 1) {
            return false;
        }
        $num = max(3, intval($num));
        $num = 1;
        $sql = "SELECT `message` FROM `ebh_sendinfo` WHERE `toid`=$crid AND `type`='announcement' " .
            "ORDER BY `infoid` DESC LIMIT $num";
        return $this->db->query($sql)->list_array();
    }

    /**
     * 获取网校新闻资讯列表
     * @param $crid
     * @param int $num
     * @return bool
     */
    public function getNewsList($crid, $num = 6) {
        $crid = (int) $crid;
        if ($crid < 1) {
            return false;
        }
        $num = max(1, intval($num));
        $sql = "SELECT `itemid`,`subject`,`note`,`message`,`dateline`,`thumb`,`viewnum` FROM `ebh_news` 
                WHERE `crid`=$crid AND `navcode`='news' AND `status`=1 ORDER BY `displayorder` ASC,`itemid` DESC LIMIT $num";
        return $this->db->query($sql)->list_array();
    }

    /**
     * 获取积分排名列表
     * @param $crid
     * @param int $num
     * @return bool
     */
    public function getRankList($crid, $num = 3) {
        $crid = intval($crid);
        if ($crid < 1) {
            return false;
        }
        $num = max(3, intval($num));
        $sql = "SELECT `a`.`uid`,`a`.`username`,`a`.`realname`,`a`.`face`,`a`.`credit`,`a`.`sex`,`a`.`groupid` 
            FROM `ebh_users` `a` 
            INNER JOIN `ebh_roomusers` `b` ON `a`.`uid`=`b`.`uid` 
            WHERE `b`.`crid`=$crid ORDER BY `a`.`credit` DESC LIMIT $num";
        return $this->db->query($sql)->list_array();
    }

    /**
     * 获取学生动态列表，过滤重复的学生
     * @param $crid
     * @param int $num
     * @return bool
     */
    public function getDynamicList($crid, $num = 3) {
        $crid = intval($crid);
        if ($crid < 1) {
            return false;
        }
        $num = max(1, intval($num));
        $sql = "SELECT `a`.`uid`,`c`.`title`,`d`.`sex`,`d`.`username`,`d`.`realname`,`d`.`face`,`d`.`groupid` 
                FROM `ebh_playlogs` `a` 
                JOIN `ebh_roomcourses` `b` ON `a`.`cwid`=`b`.`cwid`
                JOIN `ebh_coursewares` `c` ON `a`.`cwid`=`c`.`cwid` 
                JOIN `ebh_users` `d` ON `a`.`uid`=`d`.`uid`
                WHERE `a`.`crid`=$crid AND `c`.`status`=1 ORDER BY `logid` DESC LIMIT 200";

        $log_arr = $this->db->query($sql)->list_array();
        if (empty($log_arr)) {
            return false;
        }
        $ret = array();
        foreach ($log_arr as $item) {
            if (count($ret) >= $num) {
                return $ret;
            }
            if (isset($ret[$item['uid']])) {
                continue;
            }
            $ret[$item['uid']] = $item;
        }
        return $ret;
    }

    /**
     * 获取应用列表
     * @param $crid
     * @param int $index
     * @return bool|mixed
     */
    public function getAppList($crid, $index = 0) {
        $crid = (int) $crid;
        if ($crid < 1) {
            return false;
        }
        $index = max(0, intval($index));
        $sql = "SELECT `appstr` FROM `ebh_custommessages` WHERE `crid`=$crid";
        if ($index > 0) {
            $sql .= " AND `index`='$index' ORDER BY `cid` DESC LIMIT 1";
        }
        if ($ret = $this->db->query($sql)->row_array()) {
            return unserialize($ret['appstr']);
        }
        return false;
    }

    /**
     * 获取免费试听列表
     * @param $crid
     * @param int $num
     * @return bool
     */
    public function getFreeList($crid, $num = 0) {
        $crid = intval($crid);
        if ($crid < 1) {
            return false;
        }
        $num = max(3, intval($num));
        $sql = "SELECT `a`.`cwid`,`a`.`folderid`,`a`.`cdisplayorder`,`a`.`sid`,
              `b`.`title`,`b`.`logo`,`b`.`cwname`,`b`.`islive`,`b`.`displayorder` AS `bdisplayorder`,`b`.`cwurl`
              FROM `ebh_roomcourses` `a` 
              JOIN `ebh_coursewares` `b` ON `a`.`cwid`=`b`.`cwid` 
              WHERE `crid`=$crid AND `isfree`=1 AND `b`.`status`=1";
        $free = $this->db->query($sql)->list_array('cwid');
        if (empty($free)) {
            return false;
        }

        $folderid_arr = array_unique(array_column($free, 'folderid'));
        $folderid_arr_str = implode(',', $folderid_arr);
        $folders = $this->db->query(
            "SELECT `folderid`,`displayorder` AS `fdisplayorder` FROM `ebh_folders` WHERE `folderid` IN($folderid_arr_str)")
            ->list_array('folderid');
        $sectionid_arr = array_unique(array_column($free, 'sid'));
        $sectionid_arr = array_filter($sectionid_arr, function($e) {
            return $e > 0;
        });
        if (!empty($sectionid_arr)) {
            $sectionid_arr_str = implode(',', $sectionid_arr);
            $sections = $this->db->query(
                "SELECT `sid`,IFNULL(`displayorder`,1) AS `sdisplayorder` FROM `ebh_sections` WHERE `sid` IN($sectionid_arr_str)")
                ->list_array('sid');
        }

        $mediatype = array('flv','mp4','avi','mpeg','mpg','rmvb','rm','mov');
        foreach ($free as $cwid => &$fitem) {
            $fitem = array_merge($fitem, $folders[$fitem['folderid']]);
            if ($fitem['sid'] > 0 && !empty($sections[$fitem['sid']])) {
                $fitem = array_merge($fitem, $sections[$fitem['sid']]);
            } else {
                $fitem['sdisplayorder'] = PHP_INT_MAX;
            }
            if (empty($fitem['logo']) && $fitem['islive'] == 1) {
                $fitem['logo'] = 'http://static.ebanhui.com/ebh/tpl/2014/images/livelogo.jpg';
            }
            $arr = explode('.',$fitem['cwurl']);
            $type = $arr[count($arr)-1];
            if (in_array($type, $mediatype)) {
                $fitem['isvedio'] = 1;
            }
        }
        $fdisplayorder = array_column($free, 'fdisplayorder');
        $folderid = array_column($free, 'folderid');
        $sdisplayorder = array_column($free, 'sdisplayorder');
        $sid = array_column($free, 'sid');
        $cdisplayorder = array_column($free, 'cdisplayorder');
        $bdisplayorder = array_column($free, 'bdisplayorder');
        $cwid = array_column($free, 'cwid');
        array_multisort($fdisplayorder, SORT_ASC, SORT_NUMERIC,
            $folderid, SORT_DESC, SORT_NUMERIC,
            $sdisplayorder, SORT_ASC, SORT_NUMERIC,
            $sid, SORT_ASC, SORT_NUMERIC,
            $cdisplayorder, SORT_ASC, SORT_NUMERIC,
            $bdisplayorder, SORT_ASC, SORT_NUMERIC,
            $cwid, SORT_DESC, SORT_NUMERIC,
            $free);
        return $free;
    }

    /**
     * 获取最新报名列表
     * @param $crid
     * @param int $num
     * @return bool
     */
    public function getLatestReportList($crid, $num = 3) {
        $crid = intval($crid);
        if ($crid < 1) {
            return false;
        }
        $num = max(3, intval($num));
        $sql = "SELECT `a`.`uid`,MAX(`a`.`detailid`) AS `detailid`,`a`.`oname`,`b`.`uid`,`b`.`username`,`b`.`realname`,`b`.`sex`,`b`.`face`,`b`.`groupid` 
                FROM `ebh_pay_orderdetails` `a` 
                JOIN `ebh_users` `b` ON `a`.`uid`=`b`.`uid`
                WHERE `a`.`crid`=$crid AND `a`.`dstatus`=1 AND `a`.`invalid`=0 
                GROUP BY `a`.`uid` ORDER BY `detailid` DESC LIMIT $num";
        $order_users = $this->db->query($sql)->list_array();
        if (empty($order_users)) {
            return false;
        }
        $detail_id = array_unique(array_column($order_users, 'detailid'));
        $detail_id_str = implode(',', $detail_id);
        $sql = "SELECT `detailid`,`oname` FROM `ebh_pay_orderdetails`
              WHERE `detailid` IN($detail_id_str)";
        $onames = $this->db->query($sql)->list_array('detailid');
        foreach ($order_users as &$order_user) {
            $order_user['oname'] = $onames[$order_user['detailid']]['oname'];
        }
        return $order_users;
    }

    /**
     * 获取课程排行榜列表
     * @param $crid
     * @param int $num
     * @return bool
     */
    public function getCourseRankList($crid, $num = 3) {
        $crid = intval($crid);
        if ($crid < 1) {
            return false;
        }
        $num = max(3, intval($num));
        $sql = "SELECT `folderid`,`foldername`,`img`,`viewnum`,`credittime`,`coursewarenum` FROM `ebh_folders` 
              WHERE `crid`=$crid AND `folderlevel`=2 ORDER BY `viewnum` DESC LIMIT $num";
        return $this->db->query($sql)->list_array();
    }

    /**
     * 获取问卷列表
     * @param $crid
     * @param int $num
     * @param bool $strip_tags 是否去除html标签
     * @return bool
     */
    public function getSurveyList($crid, $num = 6, $strip_tags = false) {
        $crid = intval($crid);
        if ($crid < 1) {
            return false;
        }
        $num = max(1, intval($num));
//        $day_unit = SYSTIME - SYSTIME % 24 * 3600;
        $day_unit = SYSTIME;
        $sql = "SELECT `sid`,`title` FROM `ebh_surveys` 
              WHERE `crid`=$crid AND `type`=0 AND `ispublish`=1 AND `isdelete`=0 
              AND (`startdate`<" . SYSTIME ." AND `enddate`>" .$day_unit." OR `enddate`=0) 
              ORDER BY `sid` DESC LIMIT $num";
        $arr = $this->db->query($sql)->list_array();

        if ($strip_tags = true) {
            foreach ($arr as &$item) {
                //$item['title'] = strip_tags(htmlspecialchars(htmlspecialchars_decode($item['title']), ENT_NOQUOTES));
                $title = str_replace('\\n', '', htmlspecialchars_decode($item['title']));
                $title = preg_replace('/<[\w\/].*?>/i', '', $title);
                $item['title'] = $title;
            }
        }
        return $arr;
    }

    /**
     * 首页课程列表
     * @param $crid 网校ID
     * @param $uid 当前用户ID
     * @param $groupid 当前用户类型
     * @param $viewholder 课程缺少图片
     * @param $iscollege
     * @param $domain 网校域名
     * @param $pid　服务包ID
     * @param $sid 服务包分类ID
     * @param $home 是否首次调用
     * @return array|bool
     */
    public function getServicePackWhole($crid) {
        $crid = (int) $crid;
        $room_cache = Ebh::app()->lib('Roomcache');
        $d = $room_cache->getCache($crid, 'paypackage', array('t'=>'plate'));
        if (true||empty($d)) {
            $sql = "SELECT `pname`,`pid`,`displayorder` FROM `ebh_pay_packages` WHERE `crid`=$crid AND `status`=1 ORDER BY `displayorder` ASC,`pid` DESC LIMIT 200";
            $server_packages = $this->db->query($sql)->list_array('pid');
            if (empty($server_packages)) {
                return false;
            }
            $ret['packages'] = $server_packages;
            $ret['pid'] = 0;
            $first_package = reset($server_packages);
            if ($first_package['displayorder'] > -1) {
                $ret['pid'] = $first_package['pid'];
            }
            if ($ret['pid'] > 0) {
                $sql = "SELECT `sid`,`sname` FROM `ebh_pay_sorts` WHERE `pid`={$ret['pid']} AND `ishide`=0 ORDER BY `sdisplayorder` ASC";
                $sorts = $this->db->query($sql)->list_array('sid');
                if (!empty($sorts)) {
                    $ret['sorts'] = $sorts;
                }
            }
            $sql = "SELECT `a`.`sid`,`a`.`itemid`,`a`.`pid`,`a`.`iname`,`a`.`folderid`,`a`.`longblockimg`,`a`.`iprice`,`b`.`foldername`,`a`.`view_mode`,`a`.`cannotpay`,
            `a`.`ptype`,`b`.`viewnum`,`b`.`coursewarenum`,`b`.`summary`,`b`.`img`,`b`.`speaker`,`b`.`fprice`,`b`.`showmode`,`b`.`isschoolfree`,
            `d`.`showaslongblock`,`d`.`showbysort` 
            FROM `ebh_pay_items` `a` 
            JOIN `ebh_folders` `b` ON `a`.`folderid`=`b`.`folderid` 
            JOIN `ebh_pay_packages` `c` ON `a`.`pid`=`c`.`pid`
            LEFT JOIN `ebh_pay_sorts` `d` ON `a`.`sid`=`d`.`sid` 
            WHERE `a`.`crid`=$crid AND `a`.`status`=0 AND `c`.`status`=1 AND IFNULL(`d`.`ishide`, 0)=0 AND b.del=0 AND b.power=0";

            if ($ret['pid'] > 0) {
                $sql .= " AND `a`.`pid`={$ret['pid']}";
            } else {
                $pid_arr = array_keys($server_packages);
                $pid_arr_str = implode(',', $pid_arr);
                $sql .= " AND `a`.`pid` IN($pid_arr_str)";
            }
            $sql .= " ORDER BY `c`.`displayorder` ASC,`c`.`pid` DESC,`b`.`displayorder` ASC,`a`.`itemid` DESC LIMIT 100";
            $ret['items'] = $this->db->query($sql)->list_array('itemid');
            if (!empty($ret['items']) && $ret['pid'] > 0) {
                foreach ($ret['items'] as $item) {
                    if ($item['sid'] == 0) {
                        $ret['sorts'][0] = array(
                            'sid' => 0,
                            'sname' => '其他'
                        );
                        break;
                    }
                }
            }
            return $ret;

            //$room_cache->setCache($crid, 'paypackage', array('t'=>'plate','pid'=> $pid, 'sid'=>'sid'), $ret, 5 * 60, true);
        }
        //return $ret;
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
     * 判断是否为校友
     * @param $crid
     * @param $uid
     * @return bool
     */
    public function isAlumni($crid, $uid) {
        $crid = (int) $crid;
        $uid = (int) $uid;
        if ($crid < 1 || $uid < 1) {
            return false;
        }
        $sql = "SELECT 1 AS `exists` FROM `ebh_roomusers` WHERE `uid`=$uid AND `crid`=$crid";
        $exists = $this->db->query($sql)->row_array();
        return !empty($exists);
    }

    /**
     * 获取模块信息
     * @param $mid
     * @param $columns
     * @param @rows
     * @return bool
     */
    public function getModule($mid, $columns = 1, $rows = 1) {
        $mid = (int) $mid;
        if ($mid < 1) {
            return false;
        }
        $sql = "SELECT `show_type`,`area_sign`,`code` FROM `ebh_component_bases` WHERE `mid`=$mid";
        $d = $this->db->query($sql)->row_array();
        if (empty($d)) {
            return false;
        }
        $ret = array();
        $c = $d['area_sign'] & 8;
        if ($c == 8) {
            $ret[] = 4;
        }
        $c = $d['area_sign'] & 4;
        if ($c == 4) {
            $ret[] = 3;
        }
        $c = $d['area_sign'] & 2;
        if ($c == 2) {
            $ret[]  = 2;
        }
        $c = $d['area_sign'] & 1;
        if ($c == 1) {
            $ret[] = 1;
        }
        if (!in_array($columns, $ret)) {
            return false;
        }
        return $d;
    }

    /**
     * 获取背景色
     * @param $crid
     * @param $mid
     * @return bool
     */
    public function getBackGroundColor($crid, $mid) {
        $crid = (int) $crid;
        $mid = (int) $mid;
        if ($crid < 1) {
            return false;
        }
        $sql = "SELECT `background_color` FROM `ebh_component_items` WHERE `mid`=$mid AND `crid`=$crid AND `status`=0 LIMIT 1";
        if ($ret = $this->db->query($sql)->row_array()) {
            if (!preg_match('/^#(?:[0-9a-f]{3}){1,2}$/i', $ret['background_color'])) {
                return '';
            }
            return $ret['background_color'];
        }
        return '';
    }
    /**
     * 获取单一模块自定义数据
     * @param $crid
     * @param $mid
     * @return bool|mixed
     */
    public function getSingleModuleCustomData($crid, $mid) {
        $crid = (int) $crid;
        $mid = (int) $mid;
        if ($crid < 1) {
            return false;
        }
        $sql = "SELECT `image`,`href`,`zindex`,`bgcolor` FROM `ebh_component_item_options` WHERE `mid`=$mid " .
            "AND `crid`=$crid AND `status`=0 ORDER BY `zindex` ASC";
        $options = $this->db->query($sql)->list_array();
        if (empty($options)) {
            return false;
        }

        return $options;
    }

    /**
     * 获取多次调用模块自定义数据
     * @param $crid
     * @param $eid
     * @return bool|mixed
     */
    public function getMulModuleCustomData($crid, $eid) {
        $crid = (int) $crid;
        $eid = (int) $eid;

        if ($crid < 1) {
            return false;
        }

        $sql = "SELECT `image`,`href`,`zindex`,`bgcolor` FROM `ebh_component_item_options` WHERE `eid`=$eid AND `crid` IN($crid,0) AND `status`=0 ORDER BY `zindex` ASC";
        $options = $this->db->query($sql)->list_array();
        if (empty($options)) {
            return false;
        }
        return $options;
    }

    /**
     * 获取网校详情
     * @param $crid
     * @return bool
     */
    public function getClassroomDetail($crid) {
        $crid = (int) $crid;
        if ($crid < 1) {
            return false;
        }
        $sql = "SELECT `a`.*,`b`.`username`,`b`.`uid` FROM (SELECT `uid`,`catid`,`crid`,`crname`,`begindate`,`banner`," .
            "`upid`,`enddate`,`dateline`,`maxnum`,`domain`,`status`,`citycode`,`cface`,`craddress`,`crqq`,`crphone`," .
            "`cremail`,`crlabel`,`summary`,`ispublic`,`isshare`,`modulepower`,`stumodulepower`,`isschool`,`grade`," .
            "`template`,`profitratio`,`crprice`,`displayorder`,`property`,`floatadimg`,`floatadurl`,`showusername`," .
            "`defaultpass`,`hastv`,`tvlogo`,`custommodule`,`iscollege`,`wechatimg` ,`kefuqq`,`kefu`,`message`,`lng`,`lat`,`isdesign` 
            FROM `ebh_classrooms` WHERE `crid`=$crid) AS `a` " .
            "LEFT JOIN `ebh_users` AS `b` ON `a`.`uid`=`b`.`uid`";
        return $this->db->query($sql)->row_array();
    }

    /**
     * 获取服务包列表
     * @param $crid
     * @param $pid
     * @return bool
     */
    public function getServicePack($crid, $pid = 0) {
        $crid = (int) $crid;
        $sql = "SELECT `pid`,`pname`,`limitdate` FROM `ebh_pay_packages` WHERE `crid`=$crid " .
            "AND `status`=1 ORDER BY `displayorder` ASC,`pid` DESC";
        $server_packages = $this->db->query($sql)->list_array('pid');
        if (empty($server_packages)) {
            return false;
        }

        if ($pid > 0 && isset($server_packages[$pid])) {

        } else {
            $first_package = current($server_packages);
            $pid = $first_package['pid'];
        }

        $sql = "SELECT `sid`,`pid`,`sname`,`showaslongblock` FROM `ebh_pay_sorts` WHERE `pid`=$pid AND `ishide` = 0";
        if ($sorts = $this->db->query($sql)->list_array('sid')) {
            foreach ($sorts as $sid => $sort) {
                $server_packages[$sort['pid']]['sorts'][$sid] = $sort;
            }
        }
        $has_other = $this->db->query("SELECT `itemid` FROM `ebh_pay_items` WHERE `pid`=$pid AND `sid`=0 AND `status`=0 LIMIT 1")->row_array();
        if (!empty($has_other)) {
            $server_packages[$pid]['sorts'][0] = array(
                'sid' => 0,
                'pid' => $pid,
                'sname' => '其它课程',
                'showaslongblock' => 0);
        }
        return $server_packages;
    }

    /**
     * 统计分类项数
     * @param $crid 网校ID
     * @param $filter_params 筛选条件
     * @return bool
     */
    public function getPayItemCount($crid, $filter_params) {
        $crid = (int) $crid;
        if ($crid < 1 || !is_array($filter_params)) {
            return 0;
        }
        $pid = !empty($filter_params['pid']) && is_numeric($filter_params['pid']) ? intval($filter_params['pid']) : 0;
        $sid = false;
        if (isset($filter_params['sid']) && is_numeric($filter_params['sid'])) {
            $sid = intval($filter_params['sid']);
        }
        if ($sid === false || $sid === 0) {
            //分类条件为空或未设置分类
            $sql = "SELECT COUNT(1) AS `c` FROM `ebh_pay_items` `a` 
                    JOIN `ebh_folders` `b` ON `a`.`folderid`=`b`.`folderid` 
                    JOIN `ebh_pay_packages` `c` ON `a`.`pid`=`c`.`pid`
                    WHERE `a`.`crid`=$crid AND `c`.`status`=1 AND `a`.`status`=0";
            if ($pid > 0) {
                $sql .= " AND `a`.`pid`=$pid";
                if ($sid === 0) {
                    $sql .= " AND `a`.`sid`=0";
                }
            }

            if (!empty($filter_params['free'])) {
                $sql .= " AND `a`.`iprice`=0";
            }
            if (!empty($filter_params['keyword'])) {
                $keyword = $this->db->escape('%'.trim($filter_params['keyword']).'%');
                $sql .= " AND `b`.`foldername` LIKE $keyword";
            }
            $count = $this->db->query($sql)->row_array();
            if (!empty($count['c'])) {
                return $count['c'];
            }
            return 0;
        }

        $sql = "SELECT COUNT(1) AS `c` FROM `ebh_pay_items` `a` 
                    JOIN `ebh_folders` `b` ON `a`.`folderid`=`b`.`folderid` 
                    JOIN `ebh_pay_packages` `c` ON `a`.`pid`=`c`.`pid`
                    JOIN `ebh_pay_sorts` `d` ON `a`.`sid`=`d`.`sid`
                    WHERE `a`.`crid`=$crid AND `a`.`status`=0 AND `a`.`pid`=$pid AND `a`.`sid`=$sid AND `d`.`ishide`=0";
        if (!empty($filter_params['free'])) {
            $sql .= " AND `a`.`iprice`=0";
        }
        if (!empty($filter_params['keyword'])) {
            $keyword = $this->db->escape('%'.trim($filter_params['keyword']).'%');
            $sql .= " AND `b`.`foldername` LIKE $keyword";
        }
        $count = $this->db->query($sql)->row_array();
        if (!empty($count['c'])) {
            return $count['c'];
        }
        return 0;
    }
    /**
     * 获取服务项
     * @param $crid 网校ID
     * @param array $filter_params 筛选条件
     * @param int $order 排序方式
     * @param int $pageindex
     * @param int $pagesize
     * @return array
     */
    public function getPayItems($crid, $filter_params = array(), $order = 0, $pageindex = 1, $pagesize = 20) {
        $crid = (int) $crid;
        $pageindex = max(1, intval($pageindex));
        $pagesize = (int) $pagesize;
        $offset = ($pageindex - 1) * $pagesize;

        $pid = !empty($filter_params['pid']) && is_numeric($filter_params['pid']) ? intval($filter_params['pid']) : 0;
        $sid = false;
        if (isset($filter_params['sid']) && is_numeric($filter_params['sid'])) {
            $sid = intval($filter_params['sid']);
        }
        $sql = "SELECT `a`.`sid`,`a`.`itemid`,`a`.`iname`,`a`.`folderid`,`a`.`longblockimg`,`a`.`iprice`,`a`.`cannotpay`,`a`.`ptype`,`b`.`foldername`,
            `b`.`viewnum`,`b`.`coursewarenum`,`b`.`summary`,`b`.`img`,`b`.`speaker`,`b`.`fprice`,`b`.`showmode`,`b`.`isschoolfree`,
            `d`.`showaslongblock`,`d`.`showbysort` 
            FROM `ebh_pay_items` `a` 
            JOIN `ebh_folders` `b` ON `a`.`folderid`=`b`.`folderid` 
            JOIN `ebh_pay_packages` `c` ON `a`.`pid`=`c`.`pid`
            LEFT JOIN `ebh_pay_sorts` `d` ON `a`.`sid`=`d`.`sid` 
            WHERE `a`.`crid`=$crid AND `a`.`status`=0 AND `c`.`status`=1 AND IFNULL(`d`.`ishide`, 0)=0 AND b.del=0 AND b.power=0";

        if ($pid > 0) {
            $sql .= " AND `a`.`pid`=$pid";
        }
        if ($sid !== false) {
            $sql .= " AND `a`.`sid`=$sid";
        }
        if (!empty($filter_params['free'])) {
            $sql .= " AND `a`.`iprice`=0";
        }

        if (!empty($filter_params['keyword'])) {
            $keyword = $this->db->escape('%'.trim($filter_params['keyword']).'%');
            $sql .= " AND `b`.`foldername` LIKE $keyword";
        }

        if ($order == 1) {
            //按热度降序排序
            $sql .= " ORDER BY `b`.`viewnum` DESC,`a`.`itemid` DESC";
        } elseif ($order == 2) {
            //按价格降序排序
            $sql .= " ORDER BY `a`.`iprice` DESC,`a`.`itemid` DESC";
        } elseif ($order == 3) {
            //按价格升序排序
            $sql .= " ORDER BY `a`.`iprice` ASC,`a`.`itemid` DESC";
        } else {
            //默认按时间降序排序
            $sql .= " ORDER BY `c`.`displayorder` ASC,`c`.`pid` DESC,`b`.`displayorder` ASC,`a`.`itemid` DESC";
        }
        $sql .= " LIMIT $offset, $pagesize";
        $items = $this->db->query($sql)->list_array('itemid');
        return $items;
    }

    /**
     * 获取服务项
     * @param $crid
     * @param $itemid
     * @return bool
     */
    public function getSinglePayItem($crid, $itemid) {
        $crid = (int) $crid;
        $itemid = (int) $itemid;
        if ($crid < 0 || $itemid < 0) {
            return false;
        }
        //服务项
        $sql = "SELECT `pid`,`sid`,`itemid`,`crid`,`iname`,`folderid`,`longblockimg`,`iprice`,`imonth`,`iday`,`cannotpay`,`ptype`,`limitnum`,`islimit`
                FROM `ebh_pay_items` WHERE `itemid`=$itemid AND `crid`=$crid AND `status`=0";
        $item = $this->db->query($sql)->row_array();
        if (empty($item)) {
            //查询第三方网校服务项
            $fields = array(
                '`a`.`price` AS `iprice`', '`c`.`folderid`', '`c`.`detail`', '`a`.`itemid`', '`b`.`sid`','`b`.`crid`', '`b`.`pid`', '`b`.`imonth`', '`b`.`iday`', '`b`.`iname`',
                '`c`.`foldername`', '`c`.`viewnum`', '`c`.`coursewarenum`', '`c`.`introduce`','`c`.`summary`', '`c`.`img` AS `showimg`', '`c`.`speaker`',
                '`c`.`fprice`', '`c`.`showmode`',
                '`d`.`pname`', 'IFNULL(`e`.`sname`,\'其他\') AS `sname`'
            );
            $wheres = array(
                '`a`.`itemid`='.$itemid,
                '`a`.`crid`='.$crid,
                '`a`.`del`=0',
                '`b`.`status`=0',
                '`c`.`del`=0'
            );
            $sql =  'SELECT '.implode(',', $fields).' FROM `ebh_schsourceitems` `a` JOIN `ebh_pay_items` `b` ON `b`.`itemid`=`a`.`itemid` 
                    JOIN `ebh_folders` `c` ON `c`.`folderid`=`b`.`folderid` 
                    JOIN `ebh_pay_packages` `d` ON `d`.`pid`=`b`.`pid`
                    LEFT JOIN `ebh_pay_sorts` `e` ON `e`.`sid`=`b`.`sid`
                    WHERE '.implode(' AND ', $wheres);
            $item = $this->db->query($sql)->row_array();
            if (!empty($item)) {
                return $item;
            }
        }
        if (empty($item)) {
            return false;
        }
        //服务项关联课程
        $sql = "SELECT `foldername`,`viewnum`,`detail`,`introduce`,`coursewarenum`,`summary`,`img`,`speaker`,`fprice`,`showmode`,`isschoolfree` 
                FROM `ebh_folders` WHERE `folderid`={$item['folderid']} AND `power`=0";
        $folder = $this->db->query($sql)->row_array();
        if (empty($folder)) {
            return false;
        }
        //所属服务包
        $sql = "SELECT `pname` FROM `ebh_pay_packages` WHERE `pid`={$item['pid']} AND `status`=1";
        $package = $this->db->query($sql)->row_array();
        if (empty($package)) {
            return false;
        }
        //所属网校
        $sql = "SELECT `crname` FROM `ebh_classrooms` WHERE `crid`={$item['crid']}";
        $room = $this->db->query($sql)->row_array();
        $item['crname'] = $room['crname'];
        if ($item['sid'] > 0) {
            //所属分类
            $sql = "SELECT `sname`,`showaslongblock`,`showbysort` FROM `ebh_pay_sorts` WHERE `sid`={$item['sid']} AND `ishide`=0";
            $sort = $this->db->query($sql)->row_array();
            if (empty($sort)) {
                return false;
            }
        }
        $item = array_merge($item, $package, $folder);
        $item['showimg'] = $item['img'];
        unset($item['img']);
        if (!empty($sort)) {
            $item = array_merge($item, $sort);
            if ($sort['showbysort'] == 1) {
                //捆绑销售
                $sql = "SELECT `itemid`,`folderid`,`iprice` FROM `ebh_pay_items` WHERE `sid`={$item['sid']} AND `crid`=$crid AND `status`=0";
                $item['group_members'] = $this->db->query($sql)->list_array('folderid');
            }
            if (!empty($item['showaslongblock']) && !empty($item['longblockimg'])) {
                $item['showimg'] = $item['longblockimg'];
                unset($item['longblockimg']);
            }
        }
        return $item;
    }

    /**
     * 获取打包服务项的总价格
     * @param $sid
     * @return bool
     */
    public function sortsCountPrice($sid) {
        $sid = (int) $sid;
        if ($sid < 1) {
            return false;
        }
        $sql = "SELECT `a`.`iprice`,`a`.`cannotpay`,`b`.`isschoolfree` FROM `ebh_pay_items` `a` 
                JOIN `ebh_folders` `b` ON `a`.`folderid`=`b`.`folderid` 
                WHERE `a`.`sid`=$sid AND `status`=0";
        $ret = $this->db->query($sql)->list_array();
        if (empty($ret)) {
            return false;
        }
        $sum = 0;
        foreach ($ret as $item) {
            if ($item['cannotpay'] == 1) {
                return 1;
            }
            if ($item['isschoolfree'] == 0) {
                $sum += $item['iprice'];
            }
        }
        return $sum;
    }

    /**
     * 获取用户的课程权限
     * @param $uid
     * @param $folderid
     * @param $crid
     * @return bool
     */
    public function getUserpermisions($uid, $folderid, $crid) {
        $now = SYSTIME - 86400;
        $crid = (int) $crid;
        if (is_array($folderid)) {
            $folderid_arr = array_filter($folderid, function($folderitem) {
                return is_numeric($folderitem);
            });
            if (empty($folderid_arr)) {
                return false;
            }
            $folderid_arr_str = implode(',', $folderid_arr);
            return $this->db->query(
                "SELECT DISTINCT `folderid` FROM `ebh_userpermisions` WHERE `uid`=$uid AND `crid`=$crid AND `cwid`=0 AND `folderid` IN($folderid_arr_str) AND `enddate`>=$now")
                ->list_field();
        }
        if (is_numeric($folderid)) {
            return $this->db->query(
                "SELECT DISTINCT `folderid` FROM `ebh_userpermisions` WHERE `uid`=$uid AND `crid`=$crid AND `cwid`=0 AND `folderid`=$folderid AND `enddate`>=$now")
                ->list_field();
        }
        return false;
    }

    /**
     * 课程任课教师列表
     * @param $crid
     * @param $folderid
     * @param int $pageindex
     * @param int $pagesize
     */
    public function getFolderTeachers($crid, $folderid, $pageindex = 1, $pagesize = 20) {
        $crid = (int) $crid;
        $folderid = (int) $folderid;
        $pageindex = max(1, intval($pageindex));
        $pagesize = max(1, intval($pagesize));
        $offset = ($pageindex - 1) * $pagesize;
        $count = $this->db->query(
            "SELECT COUNT(1) AS `c` FROM `ebh_teacherfolders` WHERE `folderid`=$folderid")
            ->row_array();
        if (empty($count['c'])) {
            return false;
        }
        $count = $count['c'];
        $sql = "SELECT `tid` FROM `ebh_teacherfolders` WHERE `folderid`=$folderid LIMIT $offset,$pagesize";
        $tid_arr = $this->db->query($sql)->list_field();
        $tid_arr_str = implode(',', $tid_arr);
        $teachers = $this->db->query("SELECT `a`.`uid`,`a`.`sex`,`a`.`face`,`a`.`username`,`a`.`realname`,`a`.`groupid`,".
            "`a`.`mysign`,`a`.`credit`,`b`.`profile` FROM `ebh_users` `a` JOIN `ebh_teachers` `b` ON ".
            "`a`.`uid`=`b`.`teacherid` WHERE `a`.`uid` IN($tid_arr_str) ORDER BY `a`.`uid` DESC")->list_array('uid');
        $clconfig = Ebh::app()->getConfig()->load('creditlevel_t');
        $sql = "SELECT COUNT(1) AS `c`,SUM(`a`.`cwlength`) AS `cwlength`,`a`.`uid` FROM `ebh_coursewares` `a` JOIN ".
            "`ebh_roomcourses` `b` ON `a`.`cwid`=`b`.`cwid` WHERE `b`.`crid`=$crid ".
            "GROUP BY `a`.`uid` HAVING `a`.`uid` IN($tid_arr_str)";
        $teacher_courseware = $this->db->query($sql)->list_array('uid');
        $sql = "SELECT COUNT(1) AS `c`,`uid` FROM `ebh_exams` WHERE `crid`=$crid AND `status`=1 GROUP BY `uid` HAVING `uid` IN($tid_arr_str)";
        $teacher_exam = $this->db->query($sql)->list_array('uid');
        $sql = "SELECT COUNT(1) AS `c`,`tid` FROM `ebh_askquestions` WHERE `crid`=$crid AND `answered`=1 GROUP BY `tid` HAVING `tid` IN($tid_arr_str)";
        $teacher_answer = $this->db->query($sql)->list_array('tid');
        $sql = "SELECT COUNT(1) AS `c`,`a`.`uid` FROM `ebh_reviews` `a` JOIN `ebh_coursewares` `b` ON (`a`.`toid`=`b`.`cwid`) ".
            "JOIN `ebh_roomcourses` `c` ON (`b`.`cwid`=`c`.cwid) WHERE `c`.`crid`=$crid GROUP BY `a`.`uid` HAVING `a`.`uid` IN($tid_arr_str)";
        $teacher_review = $this->db->query($sql)->list_array('uid');
        foreach ($teachers as $uid => &$teacher) {
            foreach ($clconfig as $item) {
                if ($item['min'] <= $teacher['credit'] && $item['max'] >= $teacher['credit']) {
                    $teacher['level'] = $item['title'];
                    break;
                }
                if (!empty($teacher_courseware[$uid])) {
                    $teacher['courseware_count'] = $teacher_courseware[$uid]['c'];
                    $teacher['courseware_length'] = round($teacher_courseware[$uid]['cwlength'] / 60);
                }
                if (!empty($teacher_exam[$uid])) {
                    $teacher['exam_count'] = $teacher_exam[$uid]['c'];
                }
                if (!empty($teacher_answer[$uid])) {
                    $teacher['answer_count'] = $teacher_answer[$uid]['c'];
                }
                if (!empty($teacher_review[$uid])) {
                    $teacher['review_count'] = $teacher_review[$uid]['c'];
                }
            }
        }
        return array(
            $count,
            $teachers);
    }

    /**
     * 课件附件列表
     * @param $crid
     * @param $folderid
     * @param $pageindex
     * @param $pagesize
     */
    public function getAttachments($crid, $folderid, $pageindex = 1, $pagesize = 20) {
        $crid = (int) $crid;
        $folderid = (int) $folderid;
        $pageindex = max(1, intval($pageindex));
        $pagesize = max(1, intval($pagesize));
        $offset = ($pageindex - 1) * $pagesize;
        $sql = "SELECT COUNT(1) AS `c`
				FROM `ebh_attachments` `a` 
				JOIN `ebh_coursewares` `b` on `a`.`cwid`=`b`.`cwid`
				JOIN `ebh_roomcourses` `c` on `c`.cwid= `b`.`cwid`
				WHERE `a`.`status`=1 AND `b`.`status`=1 AND `c`.`folderid`=$folderid";
        $c = $this->db->query($sql)->row_array();
        if (empty($c['c'])) {
            return false;
        }

        $sql = "SELECT `a`.`attid`,`a`.`title` `atttitle`,`b`.`title` `cwtitle`,`b`.`cwid`,`a`.`filename`,`a`.`dateline`,`a`.`size`,`a`.`source`,`a`.`suffix`,`b`.`cwsource`,`a`.`ispreview`
				FROM `ebh_attachments` `a` 
				JOIN `ebh_coursewares` `b` on `a`.`cwid`=`b`.`cwid`
				JOIN `ebh_roomcourses` `c` on `c`.cwid= `b`.`cwid`
				WHERE `a`.`status`=1 AND `b`.`status`=1 AND `c`.`folderid`=$folderid ORDER BY `a`.`cwid` LIMIT $offset,$pagesize";
        $items = $this->db->query($sql)->list_array();
        $list = array();
        foreach ($items as $item) {
            if (empty($list[$item['cwid']])) {
                $list[$item['cwid']] = array();
                $list[$item['cwid']]['courseware'] = $item['cwtitle'];
            }
            $item['size_description'] = $this->getsize($item['size']);
            $list[$item['cwid']]['items'][] = $item;
        }
        return array($c['c'], $list);
    }

    /**
     * 课程目录列表
     * @param $crid
     * @param $folderid
     * @param int $pageindex
     * @param int $pagesize
     */
    public function getFolderDirectories($crid, $folderid, $pageindex = 1, $pagesize = 20, $q='') {
        $crid = (int) $crid;
        $folderid = (int) $folderid;
        $pageindex = max(1, intval($pageindex));
        $pagesize = max(1, intval($pagesize));
        $offset = ($pageindex - 1) * $pagesize;
        $sql = "SELECT COUNT(1) AS `c` 
                FROM `ebh_roomcourses` `a` 
                JOIN `ebh_coursewares` `b` ON `a`.`cwid`=`b`.`cwid` 
                WHERE `a`.`folderid`=$folderid AND `b`.`status`=1";
        if ($q) {
            $sql .= " AND `b`.`title` LIKE '%".$this->db->escape_str($q)."%'";
        }
        $c = $this->db->query($sql)->row_array();
        if (empty($c['c'])) {
            return false;
        }

        if ($q) {
            $sql = "SELECT `a`.`looktime`,`a`.`cprice`,`a`.`cwid`,`a`.`cwpay`,`b`.`cwurl`,`b`.`viewnum`,`b`.`islive`,`b`.`attachmentnum`,`b`.`logo`,`b`.`summary`,`b`.`title`,`b`.`dateline`,`b`.`reviewnum`,`c`.`coursewarecount`,`c`.`sid`,IFNULL(`c`.`sname`,'其他') AS `sname`,`d`.`username`,`d`.`realname`,`d`.`sex`,`d`.`face`,`d`.`groupid`,IFNULL(`c`.`displayorder`,10000) AS `sdisplayorder` 
                FROM `ebh_roomcourses` `a` 
                JOIN `ebh_coursewares` `b` ON `a`.`cwid`=`b`.`cwid` 
                LEFT JOIN `ebh_sections` `c` ON `a`.`sid`=`c`.`sid` 
                JOIN `ebh_users` `d` ON `b`.`uid`=`d`.`uid`
                LEFT JOIN `ebh_folders` `e` ON `e`.`folderid`=`a`.`folderid`
                WHERE `a`.`folderid`=$folderid AND `b`.`status`=1 AND `b`.`title` LIKE '%".$this->db->escape_str($q)."%' AND `e`.`del`=0
                ORDER BY `sdisplayorder`,`c`.`sid`,`a`.`cdisplayorder`,`b`.`displayorder` ASC,`b`.`cwid` DESC LIMIT $offset,$pagesize";
        } else {
            $sql = "SELECT `a`.`looktime`,`a`.`cprice`,`a`.`cwid`,`a`.`cwpay`,`b`.`cwurl`,`b`.`viewnum`,`b`.`islive`,`b`.`attachmentnum`,`b`.`logo`,`b`.`summary`,`b`.`title`,`b`.`dateline`,`b`.`reviewnum`,`c`.`coursewarecount`,`c`.`sid`,IFNULL(`c`.`sname`,'其他') AS `sname`,`d`.`username`,`d`.`realname`,`d`.`sex`,`d`.`face`,`d`.`groupid`,IFNULL(`c`.`displayorder`,10000) AS `sdisplayorder` 
                FROM `ebh_roomcourses` `a` 
                JOIN `ebh_coursewares` `b` ON `a`.`cwid`=`b`.`cwid` 
                LEFT JOIN `ebh_sections` `c` ON `a`.`sid`=`c`.`sid` 
                JOIN `ebh_users` `d` ON `b`.`uid`=`d`.`uid`
                LEFT JOIN `ebh_folders` `e` ON `e`.`folderid`=`a`.`folderid`
                WHERE `a`.`folderid`=$folderid AND `b`.`status`=1 AND `e`.`del`=0
                ORDER BY `sdisplayorder`,`c`.`sid`,`a`.`cdisplayorder`,`b`.`displayorder` ASC,`b`.`cwid` DESC LIMIT $offset,$pagesize";
        }
        $coursewares = $this->db->query($sql)->list_array();
        $list = array();
        $mediatype = array('flv','mp4','avi','mpeg','mpg','rmvb','rm','mov');
        foreach ($coursewares as $courseware) {
            if (empty($list[$courseware['sid']])) {
                $list[$courseware['sid']] = array();
                $list[$courseware['sid']]['section'] = $courseware['sname'];
                $list[$courseware['sid']]['count'] = 0;
            }

            $arr = explode('.',$courseware['cwurl']);
            $type = $arr[count($arr)-1];
            $isVideotype = in_array($type,$mediatype);

            if (empty($courseware['logo']) && $isVideotype){
                $courseware['logo'] = !empty($courseware['islive']) ?
                    'http://static.ebanhui.com/ebh/tpl/2014/images/livelogo.jpg' :
                    'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png';
            }
            if (!$isVideotype) {
                if (strstr($type,'ppt')){
                    $playimg = 'ppt';
                } elseif (strstr($type,'doc')) {
                    $playimg = 'doc';
                } elseif ($type == 'rar' || $type == 'zip' || $type == '7z'){
                    $playimg = 'rar';
                } elseif ($type == 'mp3'){
                    $playimg = 'mp3';
                } else {
                    $playimg = 'attach';
                }
                $courseware['logo'] = "http://static.ebanhui.com/ebh/tpl/2014/images/$playimg.png";
            }
            $list[$courseware['sid']]['items'][] = $courseware;
            $list[$courseware['sid']]['count']++;
        }
        return array($c['c'], $list,$coursewares);
    }

    /**
     * 获模块取富文本内容
     * @param $eid 自定义模块ID
     * @param $crid 网校ID
     * @return bool
     */
    public function getRichText($eid, $crid) {
        $crid = (int)$crid;
        $eid = (int)$eid;
        if ($crid < 1 || $eid < 1) {
            return false;
        }
        $sql = 'SELECT `richtext` FROM `ebh_component_richtexts` WHERE `eid`='.$eid.' AND `crid` IN('.$crid.',0) AND `status`=1 ORDER BY `crid` DESC LIMIT 1';
        $ret = $this->db->query($sql)->row_array();
        if (empty($ret)) {
            return false;
        }
        $rich_text = $ret['richtext'];
        $rich_text = str_replace('</script>', '&lt;/script&gt;', $rich_text);
        $rich_text = preg_replace('/<script([^>]*?)>/i', '&lt;script$1&gt;', $rich_text);
        return stripslashes($rich_text);
    }

    /**
     * 删除富文本
     * @param $eid
     * @param $crid
     */
    public function deleteRichText($eid, $crid) {
        $crid = (int)$crid;
        $eid = (int)$eid;
        if ($crid < 1 || $eid < 1) {
            return false;
        }
        $sql = "DELETE FROM `ebh_component_richtexts` WHERE `eid`=$eid AND `crid`=$crid";
        $this->db->query($sql);
        $room_cache = Ebh::app()->lib('Roomcache');
        $modules = $room_cache->removeCache($crid, 'other', 'plate-cofing');
    }

    /**
     * 删除免费试听课件
     * @param $crid 网校ID
     * @param $cwid 课件ID
     */
    public function removeFreeCourseware($crid, $cwid) {
        $crid = (int) $crid;
        $cwid = (int) $cwid;
        return $this->db->update('ebh_roomcourses',
            array('isfree' => 0), "`crid`=$crid AND `cwid`=$cwid");
    }

    private function getsize($bsize){
        $size = "0字节";
        if (!empty($bsize))
        {
            $gsize = $bsize / (1024 * 1024 * 1024);
            $msize = $bsize / (1024 * 1024);
            $ksize = $bsize / 1024;
            if ($gsize > 1)
            {
                $size = round($gsize,2) . "G";
            }
            else if($msize > 1)
            {
                $size = round($msize,2) . "M";
            }
            else if($ksize > 1)
            {

                $size = round($ksize,0) . "K";
            }
            else
            {
                $size = $bsize . "字节";
            }
        }
        return $size;
    }

    /**
     * 获取课程列表
     * @param $crid
     * @param $limit
     * @return bool
     */
    public function getFolders($crid, $limit = 1000) {
        $crid = (int) $crid;
        if ($crid < 1) {
            return false;
        }
        if (is_array($limit)) {
            $pagesize = !empty($limit['pagesize']) ? max(1, intval($limit['pagesize'])) : 1000;
            $page = !empty($limit['page']) ? max(1, intval($limit['page'])) : 1;
            $offset = ($page - 1) * $pagesize;
        } else {
            $offset = 0;
            $pagesize = max(1, intval($limit));
        }
        $sql = "SELECT `folderid`,`foldername` 
                FROM `ebh_folders` 
                WHERE `crid`=$crid AND `del`=0 AND `power`=0 ORDER BY `displayorder` ASC,`folderid` DESC LIMIT $offset,$pagesize";
        return $this->db->query($sql)->list_array('folderid');
    }

    /**
     * 获取精品课件列表
     * @param $crid
     * @param $params
     * @param $limit
     * @return bool
     */
    public function getFineCoursewares($crid, $params, $limit = 1000) {
        $crid = (int) $crid;
        if ($crid < 1) {
            return false;
        }
        if (is_array($limit)) {
            $pagesize = !empty($limit['pagesize']) ? max(1, intval($limit['pagesize'])) : 1000;
            $page = !empty($limit['page']) ? max(1, intval($limit['page'])) : 1;
            $offset = ($page - 1) * $pagesize;
        } else {
            $offset = 0;
            $pagesize = max(1, intval($limit));
        }
        $conditions = array("`a`.`crid`=$crid");
        if (!empty($params['folderid'])) {
            $folderid = intval($params['folderid']);
            if ($folderid > 0) {
                array_unshift($conditions, "`a`.`folderid`=$folderid");
            }
        }
        if (!empty($params['isfree'])) {
            $conditions[] = "`a`.`cprice`=0";
        }
        $conditions[] = "`a`.`cwpay`=1";
        $conditions[] = "`b`.`status`=1";
        $conditions[] = "`c`.`del`=0";
        $order[] = "`a`.`cwid` DESC";
        if (!empty($params['order'])) {
            switch (intval($params['order'])) {
                case 1:
                    //课件浏览数降序
                    array_unshift($order, "`b`.`viewnum` DESC");
                    break;
                case 2:
                    //课件价格降序
                    array_unshift($order, "`a`.`cprice` DESC");
                    break;
                case 3:
                    //课件价格升序
                    array_unshift($order, "`a`.`cprice` ASC");
                    break;
            }
        }
        $sql = "SELECT `a`.`cwid`,`a`.`folderid`,`a`.`cprice`,`b`.`title`,`b`.`uid`,`b`.`logo`,`b`.`dateline`,`b`.`summary`,`b`.`viewnum`,`b`.`reviewnum`,`b`.`truedateline`,`b`.`endat`,`b`.`islive` 
                FROM `ebh_roomcourses` `a` 
                JOIN `ebh_coursewares` `b` ON `a`.`cwid`=`b`.`cwid`
                JOIN `ebh_folders` `c` ON `a`.`folderid`=`c`.`folderid` 
                WHERE ".implode(' AND ', $conditions)." ORDER BY ".implode(',', $order)." LIMIT $offset,$pagesize";
        return $this->db->query($sql)->list_array('cwid');
    }

    /**
     * 统计精品课件
     * @param $crid
     * @param $params
     * @return bool
     */
    public function getFineCoursewareCount($crid, $params) {
        $crid = (int) $crid;
        if ($crid < 1) {
            return false;
        }
        $conditions = array("`a`.`crid`=$crid");
        if (!empty($params['folderid'])) {
            $folderid = intval($params['folderid']);
            if ($folderid > 0) {
                array_unshift($conditions, "`a`.`folderid`=$folderid");
            }
        }
        if (!empty($params['isfree'])) {
            $conditions[] = "`a`.`cprice`=0";
        }
        $conditions[] = "`a`.`cwpay`=1";
        $conditions[] = "`b`.`status`=1";
        $conditions[] = "`c`.`del`=0";
        $sql = "SELECT COUNT(1) AS `c` 
                FROM `ebh_roomcourses` `a` 
                JOIN `ebh_coursewares` `b` ON `a`.`cwid`=`b`.`cwid`
                JOIN `ebh_folders` `c` ON `a`.`folderid`=`c`.`folderid` 
                WHERE ".implode(' AND ', $conditions);
        $ret = $this->db->query($sql)->row_array();
        if (isset($ret['c'])) {
            return $ret['c'];
        }
        return false;
    }

    /**
     * 获取用户信息
     * @param $uid
     * @return bool
     */
    public function getUsers($uid) {
        if (is_array($uid)) {
            $uid = array_map(function($item) {
                return (int) $item;
            }, $uid);
            $uid = array_unique($uid);
            $uid = array_filter($uid, function($item) {
               return $item > 0;
            });
            $uid_arr_str = implode(',', $uid);
            $sql = "SELECT `uid`,`username`,`realname`,`sex`,`groupid`,`face` FROM `ebh_users` WHERE `uid` IN($uid_arr_str)";
        } else {
            $uid = (int) $uid;
            if ($uid < 1) {
                return false;
            }
            $sql = "SELECT `uid`,`username`,`realname`,`sex`,`groupid`,`face` FROM `ebh_users` WHERE `uid`=$uid";
        }
        return $this->db->query($sql)->list_array('uid');
    }

    /**
     * 获取用户权限
     * @param $uid
     * @param $crid
     * @param $coursewareid
     */
    public function getCoursewarePermisions($uid, $crid, $coursewareid) {
        $uid = (int) $uid;
        $crid = (int) $crid;
        if ($uid < 1 || $crid < 1) {
            return false;
        }
        $now = SYSTIME - 86400;
        if (is_array($coursewareid)) {
            $coursewareid = array_map(function($cid) {
                return (int) $cid;
            }, $coursewareid);
            $coursewareid = array_unique($coursewareid);
            $coursewareid = array_filter($coursewareid, function($cid) {
               return $cid > 0;
            });
            if (empty($coursewareid)) {
                return false;
            }
            $coursewareid_arr_str = implode(',', $coursewareid);
            return $this->db->query(
                "SELECT `cwid` FROM `ebh_userpermisions` WHERE `uid`=$uid AND `crid`=$crid AND `cwid` IN($coursewareid_arr_str) AND `enddate`>=$now")
                ->list_field();
        }
        $coursewareid = (int) $coursewareid;
        if ($coursewareid < 1) {
            return false;
        }
        return $this->db->query(
            "SELECT `cwid` FROM `ebh_userpermisions` WHERE `uid`=$uid AND `crid`=$crid AND `cwid`=$coursewareid AND `enddate`>=$now")
            ->list_field();
    }

    /**
     * 精品课件详情
     * @param $crid
     * @param $cwid
     * @return bool
     */
    public function getCoursewareInfo($crid, $cwid) {
        $crid = (int) $crid;
        $cwid = (int) $cwid;
        if ($crid < 1 || $cwid < 1) {
            return false;
        }
        $sql = "SELECT `a`.`cwid`,`a`.`folderid`,`a`.`cprice`,`b`.`title`,`b`.`logo`,`b`.`summary` 
                FROM `ebh_roomcourses` `a` 
                JOIN `ebh_coursewares` `b` ON `a`.`cwid`=`b`.`cwid`
                JOIN `ebh_folders` `c` ON `a`.`folderid`=`c`.`folderid` 
                WHERE `a`.`cwid`=$cwid AND `a`.`crid`=$crid AND `a`.`cwpay`=1 AND `b`.`status`=1 AND `c`.`del`=0";
        return $this->db->query($sql)->row_array();
    }

    /**
     * 服务包分类详情
     * @param $sid
     * @return mixed
     */
    public function getPaySortInto($sid) {
        $sid = (int) $sid;
        $sql = "SELECT `sid`,`pid`,`sname`,`content`,`showbysort`,`imgurl`,`showaslongblock` 
                FROM `ebh_pay_sorts` WHERE `sid`=$sid AND `ishide`=0";
        return $this->db->query($sql)->row_array();
    }

    public function getPayItemsUnderSort($sid) {
        $sid = (int) $sid;
        $sql = "SELECT `a`.`itemid`,`a`.`iname`,`a`.`folderid`,`a`.`iprice`,`a`.`longblockimg`,`a`.`iday`,`a`.`imonth`,`a`.`cannotpay`,`b`.`foldername`,`b`.`img`,`b`.`coursewarenum`,`b`.`viewnum`,`b`.`speaker`,`b`.`isschoolfree` 
                FROM `ebh_pay_items` `a` JOIN `ebh_folders` `b` ON `a`.`folderid`=`b`.`folderid`
                WHERE `a`.`sid`=$sid AND `a`.`status`=0 AND `b`.`del`=0
                ORDER BY `b`.`displayorder` ASC,`a`.`itemid` DESC";
        return $this->db->query($sql)->list_array('itemid');
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * 服务包列表
     * @param $crid 网校ID
     * @param int $type 服务包创建方式
     * @param int $limit 数量约束
     * @return bool
     */
    function getPackageDirectory($crid, $type = PortfolioModel::PACKAGE_TYPE_INT_NORMAL, $limit = 3000)
    {
        $crid = (int) $crid;
        if ($crid < 1) {
            return false;
        }
        $params = array("`crid`=$crid");
        if ($type === PortfolioModel::PACKAGE_TYPE_INT_BEST) {
            $params[] = "`itype`=1";
        } else if ($type === PortfolioModel::PACKAGE_TYPE_INT_NORMAL) {
            $params[] = "`itype`=0";
        }

        $params[] = "`status`=1";
        $offset = 0;
        $pagesize = 1;
        if (is_array($limit)) {
            $page = 1;
            if (isset($limit['page'])) {
                $page = max(1, intval($limit['page']));
            }
            if (isset($limit['pagesize'])) {
                $pagesize = max(1, intval($limit['pagesize']));
            }
            $offset = ($page - 1) * $pagesize;
        } else {
            $pagesize = max($pagesize, intval($limit));
        }
        $where_str = implode(' AND ', $params);
        $sql = "SELECT `pid`,`pname`,`displayorder` FROM `ebh_pay_packages` 
                WHERE $where_str ORDER BY `displayorder` ASC,`pid` DESC LIMIT $offset,$pagesize";
        return $this->db->query($sql)->list_array('pid');
    }

    /**
     * 服务包分类列表
     * @param $pids 服务包ID集
     * @param int $limit 数量约束
     * @return bool
     */
    function getSortList($pids, $limit = 9000)
    {
        if (empty($pids)) {
            return false;
        }
        $pid_arr = array();
        if (is_array($pids)) {
            $pids = array_map(function($pid) {
                return (int) $pid;
            }, $pids);
            $pids = array_filter($pids, function($pid) {
                return $pid > 0;
            });
            if (empty($pids)) {
                return false;
            }
            $pid_arr = $pids;
        } else {
            $pid = (int) $pids;
            if ($pid < 1) {
                return false;
            }
            $pid_arr[] = $pid;
        }
        $params = array();
        $pid_arr_str = implode(',', $pid_arr);
        $params[] = "`pid` IN($pid_arr_str)";
        $params[] = "`ishide`=0";
        $where_str = implode(' AND ', $params);
        unset($pid_arr, $params);
        $offset = 0;
        $pagesize = 1;
        if (is_array($limit)) {
            $page = 1;
            if (isset($limit['page'])) {
                $page = max(1, intval($limit['page']));
            }
            if (isset($limit['pagesize'])) {
                $pagesize = max(1, intval($limit['pagesize']));
            }
            $offset = ($page - 1) * $pagesize;
        } else {
            $pagesize = max($pagesize, intval($limit));
        }
        $sql = "SELECT `sid`,`pid`,`sname`,`content`,`discount`,`imgurl`,`showaslongblock` 
                FROM `ebh_pay_sorts` WHERE $where_str ORDER BY `sdisplayorder` ASC,`sid` DESC LIMIT $offset,$pagesize";
        return $this->db->query($sql)->list_array('sid');
    }

    /**
     * 分类列表
     * @param $sids
     * @return bool
     */
    function getSortsByKeys($sids) {
        if (is_array($sids)) {
            $sids = array_map(function($sid) {
                return (int) $sid;
            }, $sids);
            $sids = array_filter($sids, function($sid) {
                return $sid > 0;
            });
            if (empty($sids)) {
                return false;
            }
            if (count($sids) > 1) {
                $sid_arr_str = implode(',', $sids);
                $param = "`sid` IN($sid_arr_str)";
            } else {
                $sid = reset($sids);
                $param = "`sid`=$sid";
            }
        } else {
            $sid = (int) $sids;
            if ($sid < 1) {
                return false;
            }
            $param = "`sid`=$sid";
        }
        $sql = "SELECT `pid`,`sid`,`sname`,`content`,`showbysort`,`imgurl`,`showaslongblock` FROM `ebh_pay_sorts` WHERE $param";
        return $this->db->query($sql)->list_array('sid');
    }

    /**
     * 服务项列表
     * @param $crid
     * @param null $condition
     * @param int $limit
     * @return bool
     */
    function getItemList($crid, $condition = null, $limit = 30000)
    {
        $crid = (int) $crid;
        if ($crid < 1) {
            return false;
        }
        $params = array();
        if (isset($condition['pid'])) {
            if (is_array($condition['pid'])) {
                $pid_arr = array_map(function($pid) {
                    return (int) $pid;
                }, $condition['pid']);
                $pid_arr = array_filter($pid_arr, function($pid) {
                    return $pid > 0;
                });
                if (!empty($pid_arr)) {
                    $pid_arr_str = implode(',', $pid_arr);
                    unset($pid_arr);
                    $params[] = "`a`.`pid` IN($pid_arr_str)";
                }
            } else {
                $params[] = "`a`.`pid`=".intval($condition['pid']);
                if (isset($condition['sid'])) {
                    $params[] = "`a`.`sid`=".intval($condition['sid']);
                }
            }
        }
        $params[] = "`crid`=$crid";
        $params[] = "`status`=0";
        $params[] = "IFNULL(`ishide`,0)=0";
        $params[] = "`itype`=0";
        $where_str = implode(' AND ', $params);
        $offset = 0;
        $pagesize = 1;
        if (is_array($limit)) {
            $page = 1;
            if (isset($limit['page'])) {
                $page = max(1, intval($limit['page']));
            }
            if (isset($limit['pagesize'])) {
                $pagesize = max(1, intval($limit['pagesize']));
            }
            $offset = ($page - 1) * $pagesize;
        } else {
            $pagesize = max($pagesize, intval($limit));
        }
        $sql = "SELECT `itemid`,`a`.`pid`,`a`.`sid`,`iname`,`isummary`,`folderid`,`iprice`,`imonth`,`iday`,`cannotpay`,`longblockimg`,`view_mode`,IFNULL(`b`.`showbysort`,0) `showbysort`,IFNULL(`b`.`showaslongblock`, 0) `showaslongblock` 
                FROM `ebh_pay_items` `a` LEFT JOIN `ebh_pay_sorts` `b` ON `a`.`sid`=`b`.`sid` WHERE $where_str 
                ORDER BY `a`.`itemid` DESC LIMIT $offset,$pagesize";
        return $this->db->query($sql)->list_array('itemid');
    }

    /**
     * 课程目录列表
     * @param $crid
     * @param array $filter_params
     * @param int $limit
     * @return bool
     */
    function getFolderDirectory($crid, $filter_params = array(), $limit = 30000)
    {
        $crid = (int) $crid;
        if ($crid < 1) {
            return false;
        }
        $offset = 0;
        $pagesize = 1;
        if (is_array($limit)) {
            $page = 1;
            if (isset($limit['page'])) {
                $page = max(1, intval($limit['page']));
            }
            if (isset($limit['pagesize'])) {
                $pagesize = max(1, intval($limit['pagesize']));
            }
            $offset = ($page - 1) * $pagesize;
        } else {
            $pagesize = max($pagesize, intval($limit));
        }
        $params = array();
        $params[] = "`crid`=$crid";
        $params[] = "`del`=0";
        $params[] = "`ispublic`=0";
        $params[] = "`power`=0";
        if (!empty($filter_params['s'])) {
            $keyword = trim($filter_params['s']);
            $keyword = $this->db->escape("%{$keyword}%");
            $params[] = "`foldername` LIKE $keyword";
        }
        $where_str = implode(' AND ', $params);
        $sql = "SELECT `folderid`,`foldername`,`img`,`coursewarenum`,`summary`,`fprice`,`isschoolfree`,`viewnum`,`speaker`,`showmode`,`displayorder` 
                FROM `ebh_folders` WHERE $where_str ORDER BY `displayorder` ASC,`folderid` DESC LIMIT $offset,$pagesize";
        return $this->db->query($sql)->list_array('folderid');
    }

    /**
     * 获取网校教师简单列表
     * @param $crid 网校ID
     * @param int $limit 查询限制条件
     * @param bool $setKey 是否将uid设置为键
     * @return mixed
     */
    public function getTeacherSimpleList($crid, $limit = 0, $setKey = false) {
        $crid = intval($crid);
        $sql = 'SELECT `c`.`uid`,`c`.`username`,`c`.`realname`,`c`.`groupid`,`c`.`sex`,`c`.`face`,`b`.`profile`,`b`.`professionaltitle` FROM `ebh_roomteachers` `a`
              Left JOIN `ebh_teachers` `b` ON `a`.`tid`=`b`.`teacherid`
              LEFT JOIN `ebh_users` `c` ON `a`.`tid`=`c`.`uid`
              WHERE IFNULL(`b`.`teacherid`,0)>0 AND IFNULL(`c`.`uid`,0)>0 AND `a`.`crid`='.$crid;
        if (!empty($limit)) {
            $offset = 0;
            if (is_array($limit)) {
                $page = !empty($limit['page']) ? max(1, intval($limit['page'])) : 1;
                $limit = !empty($limit['pagesize']) ? intval($limit['pagesize']) : 20;
                $offset = ($page - 1) * $limit;
            } else {
                $limit = intval($limit);
            }
            $sql .= ' LIMIT '.$offset.','.$limit;
        }
        return $this->db->query($sql)->list_array($setKey ? 'uid' : '');
    }

    /**
     * 获取名师ID集
     * @param $crid 网校ID
     * @return mixed
     */
    public function getMasterIds($crid) {
        return $this->db->query('SELECT `tid` FROM `ebh_masters` WHERE `crid`='.intval($crid))->list_field();
    }

    /**
     * 添加名师
     * @param $tid 教师ID
     * @param $crid 网校ID
     * @return mixed
     */
    public function addMaster($tid, $crid) {
        return $this->db->insert('ebh_masters', array(
            'tid' => intval($tid),
            'crid' => intval($crid),
			'dateline' => SYSTIME
        ));
    }

    /**
     * 删除名师
     * @param $tid 教师ID
     * @param $crid 网校ID
     * @return mixed
     */
    public function removeMaster($tid, $crid) {
        return $this->db->delete('ebh_masters', array(
            'tid' => intval($tid),
            'crid' => intval($crid)
        ));
    }

    /**
     * 名师详情
     * @param $uid 名师ID
     * @param $crid 网校ID
     * @return mixed
     */
    public function masterDetail($uid, $crid) {
        $uid = intval($uid);
        $crid = intval($crid);
        $sql = 'SELECT `c`.`username`,`c`.`realname`,`c`.`groupid`,`c`.`sex`,`c`.`face`,`b`.`profile`,`b`.`professionaltitle`,`b`.`message` FROM `ebh_masters` `a` 
              LEFT JOIN `ebh_teachers` `b` ON `a`.`tid`=`b`.`teacherid` 
              LEFT JOIN `ebh_users` `c` ON `a`.`tid`=`c`.`uid` 
              WHERE `a`.`crid`='.$crid.' AND `a`.`tid`='.$uid.' AND IFNULL(`b`.`teacherid`,0)>0 AND IFNULL(`c`.`uid`, 0)>0';
        return $this->db->query($sql)->row_array();
    }

    /**
     * 获取名师课程ID集
     * @param $uid 名师ID
     * @param $crid 网校ID
     * @return mixed
     */
    public function getMasterFolderids($uid, $crid) {
        $sql = 'SELECT `folderid` FROM `ebh_teacherfolders` WHERE `tid`='.intval($uid).' AND `crid`='.intval($crid);
        return $this->db->query($sql)->list_field();
    }

    /**
     * 获取网校名师简单列表
     * @param $crid 网校ID
     * @param int $limit 查询限制条件
     * @param bool $setKey 是否将uid设置为键
     * @return mixed
     */
    public function getMasterSimpleList($crid, $limit = 0, $setKey = false) {
        $crid = intval($crid);
        $sql = 'SELECT `c`.`uid`,`c`.`username`,`c`.`realname`,`c`.`groupid`,`c`.`sex`,`c`.`face`,`b`.`profile`,`b`.`professionaltitle` 
              FROM `ebh_masters` `m`
              LEFT JOIN `ebh_roomteachers` `a` ON `m`.`tid`=`a`.`tid`
              Left JOIN `ebh_teachers` `b` ON `a`.`tid`=`b`.`teacherid`
              LEFT JOIN `ebh_users` `c` ON `a`.`tid`=`c`.`uid`
              WHERE IFNULL(`b`.`teacherid`,0)>0 AND IFNULL(`c`.`uid`,0)>0 AND `a`.`crid`='.$crid.' AND `m`.`crid`='.$crid.' ORDER BY `m`.`displayorder` DESC,`m`.`dateline` ASC';

        if (!empty($limit)) {
            $offset = 0;
            if (is_array($limit)) {
                $page = !empty($limit['page']) ? max(1, intval($limit['page'])) : 1;
                $limit = !empty($limit['pagesize']) ? intval($limit['pagesize']) : 20;
                $offset = ($page - 1) * $limit;
            } else {
                $limit = intval($limit);
            }
            $sql .= ' LIMIT '.$offset.','.$limit;
        }
        return $this->db->query($sql)->list_array($setKey ? 'uid' : '');
    }

    /**
     * 名师团队排序
     * @param $tids 名师ID集
     * @param $crid 所在网校
     * @return bool|int
     */
    public function orderMasters($tids, $crid) {
        if (!is_array($tids)) {
            return false;
        }
        $tids = array_map('intval', $tids);
        $tids = array_filter($tids, function($tid) {
            return $tid > 0;
        });
        if (empty($tids)) {
            return false;
        }
        $crid = (int) $crid;
        $maxIndex = count($tids);
        $affected_rows = 0;
        foreach ($tids as $tid) {
            $affected_rows += $this->db->update('ebh_masters', array('displayorder' => $maxIndex--), array(
                'tid' => $tid,
                'crid' => $crid
            ));
        }
        return $affected_rows;
    }

    /**
     * 免费试听课件排序
     * @param $cwids 课件ID集
     * @param $crid 所在网校
     * @return bool|int
     */
    public function orderFreeware($cwids, $crid) {
        if (!is_array($cwids)) {
            return false;
        }
        $cwids = array_map('intval', $cwids);
        $cwids = array_filter($cwids, function($cwid) {
            return $cwid > 0;
        });
        if (empty($cwids)) {
            return false;
        }
        $crid = (int) $crid;
        $maxIndex = count($cwids);
        $affected_rows = 0;
        foreach ($cwids as $cwid) {
            $affected_rows += $this->db->update('ebh_roomcourses', array('fdisplayorder' => $maxIndex--), array(
                'twid' => $cwid,
                'crid' => $crid
            ));
        }
        return $affected_rows;
    }
	/**
	 * 判断网校是否自定义过模板
	 */
	public function checkManued($crid, $category) {
		$crid = (int) $crid;
		$category = (int) $category;
		$sql = 'SELECT `tmpid` FROM `ebh_component_schools` WHERE `crid`='.$crid.' AND `category`='.$category;
		$tmp = $this->db->query($sql)->row_array();
		return !empty($tmp['tmpid']);
	}
}
