<?php
/**
 * 首页模板模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/18
 * Time: 17:47
 */
class PortfolioController extends CControl {
    private $user;
    private $room;
    //是否启用模板内容占位符
    public $viewholder = true;
    public $baseurl;
    public $course_viewholder = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_243_144.jpg';
    //缓存配置
    private $cache_time = array(
        //导航菜单
        'navigation' => array(
            'module' => 'navigator',
            'param' => 'plate-navigation',
            'expire' => 3600,//1小时
            'needupdate' => true
        ),
        //滚动通知
        'notice' => array(
            'module' => 'sendinfo',
            'param' => 'plate-notice',
            'expire' => 3600,//1小时
            'needupdate' => true
        ),
        //免费试听
        'free' => array(
            'module' => 'courseware',
            'param' => 'plate-free',
            'expire' => 3600,//1小时
            'needupdate' => true
        ),
        //新闻资讯
        'news' => array(
            'module' => 'news',
            'param' => 'plate-news',
            'expire' => 300,//5分钟
            'needupdate' => true
        ),
        //广告轮播
        'ad' => array(
            'module' => 'item',
            'param' => 'plate-ad',
            'expire' => 3600,//1小时
            'needupdate' => true
        ),
        //调查问卷
        'survey' => array(
            'module' => 'survey',
            'param' => 'plate-survey',
            'expire' => 3600,//1小时
            'needupdate' => true
        ),
        //课程列表
        'courselist' => array(
            'module' => 'other',
            'expire' => 3600,//1小时
            'needupdate' => true
        ),
        //应用
        'app' => array(
            'module' => 'custommessage',
            'param' => 'plate-app',
            'expire' => 3600,
            'needupdate' => true
        ),
        //积分排名
        'rank' => array(
            'module' => 'user',
            'param' => 'plate-rank',
            'expire' => 3600,//1小时
            'needupdate' => true
        ),
        //最新报名
        'latestreport' => array(
            'module' => 'user',
            'param' => 'plate-latestreport',
            'expire' => 3600,//1小时
            'needupdate' => true
        ),
        //学员动态
        'dynamic' => array(
            'module' => 'user',
            'param' => 'plate-dynamic',
            'expire' => 300,//5分钟
            'needupdate' => true
        ),
        //课程排名
        'courserank' => array(
            'module' => 'folder',
            'param' => 'plate-courserank',
            'expire' => 3600,//1小时
            'needupdate' => true
        )
    );
    public function __construct()
    {
        parent::__construct();
        $upconfig = Ebh::app()->getConfig()->load('upconfig');
        $this->baseurl = $upconfig['pic']['showpath'];
        $this->user = Ebh::app()->user->getloginuser();
        $this->room = Ebh::app()->room->getcurroom();
		if (!empty($this->room['fulldomain']) && stripos($_SERVER['HTTP_HOST'], '.ebh.net') !== false) {
			header('Location:http://'.$this->room['fulldomain'].$_SERVER['REQUEST_URI']);
			exit();
		}
        //
        if(empty($this->user)) {
            //exit();
        }
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            //exit();
        }
        //$this->room['crid'] = 10194;
    }

    //首页
    public function home() {
        $currentdomain = getdomain();
        //读取模块
        $model = $this->model('portfolio');
        $plateModel = $this->model('plate');
        $room_cache = Ebh::app()->lib('Roomcache');
		$room_type = Ebh::app()->room->getRoomType();
        $modules = $model->getPortfolioConfig($this->room['crid'], $room_type == 'com' ? 1 : 0);
        $roommodel = $this->model('classroom');
        $roomdetail  = $roommodel->getclassroomdetail($this->room['crid']);
        $roomdetail = array_merge($this->room, $roomdetail);
        $domain = $this->model('Domaincheck')->getdomain($this->room['crid']);
        if (!empty($domain['fulldomain'])) {
            $roomdetail['domain'] = $domain['fulldomain'];
        }
        $roomdetail['domain'] = $currentdomain;
        $roomdetail['isdesign'] = $this->room['isdesign'];
        $this->assign('roomdetail', $roomdetail);
        if (!empty($roomdetail['isdesign'])) {
            $apiServer = Ebh::app()->getApiServer('ebh');
            $roomtype = Ebh::app()->room->getRoomType();
            $ret = $apiServer->reSetting()
                ->setService('Classroom.Design.getdesign')
                ->addParams('crid', $roomdetail['crid'])
                ->addParams('roomtype', $room_type)
                ->request();
            if (!empty($ret['status'])) {
                $this->assign('head', str_replace('\"', '"', $ret['data']['head']));
                $this->assign('foot', str_replace('\"', '"', $ret['data']['foot']));
                $settings = str_replace('\"', '"', $ret['data']['settings']);
                $settings = json_decode($settings, true);
                $this->assign('publicSetting', $settings);
            }
        }
        $content_height = 0;
        $has_slide = false;
        $has_window_login = false;
        $repeat_count = 0;

        if (!empty($modules)) {
            $system_info = $this->model('Systemsetting')->getSetting($this->room['crid']);
            $enabled = true;
            if (!empty($this->user) && $this->user['groupid'] == 6 && !empty($system_info['isbanbuy'])) {
                //判断是否本校学生
                $isStudent = $model->isAlumni($this->room['crid'], $this->user['uid']);
                $enabled = $isStudent;
            }
            foreach ($modules as &$module) {
                if (!empty($module['width'])) {
                    $module['width'] -= 20;
                } else {
                    $module['width'] = 1200;
                }
                if (!empty($module['height']) && $module['height'] != 320) {
                    $module['height'] -= 10;
                } else {
                    $module['height'] = 320;
                }
                //unset($module['rows'],$module['max_data_count'], $module['editable'], $module['area_sign'],$module['ctitle'], $module['custom_data'], $module['background_color'], $module['mid'], $module['code']);continue;

                //计算内容高度
                $content_height = max($content_height, $module['top'] + $module['height']);
                //页头
                if ($module['mid'] == 1) {
                    if (!empty($module['custom_data']['options'][0]['image'])) {
                        $module['custom_data']['options'][0]['image'] = show_plate_img($module['custom_data']['options'][0]['image']);
                    }
                    continue;
                }
                //选项卡(导航模块)
                if ($module['mid'] == 2) {
                    $has_window_login = true;
                    if (!empty($this->user)) {
                        $module['logined'] = true;
                        if ($this->user['uid'] == $this->room['uid']) {
                            $module['is_admin'] = true;
                        }
                        $module['user'] = $this->user;
                    }
                    $cache_set = $this->cache_time[$module['code']];
                    $navigatordata = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
                    if (false&&!empty($navigatordata)) {
                        $navigatordata = array_filter($navigatordata, function($nav) {
                            if ($nav['code'] == 'news') {
                                return false;
                            }
                            return true;
                        });
                        $module['menu'] = $navigatordata;
                        continue;
                    }
                    $tourl = null;
                    $navigatordata = $model->getNavigator($this->room['crid'], $tourl);
                    if (!empty($tourl)){
                        if (strpos($_SERVER['REQUEST_URI'], $tourl) !== 0) {
                            header('Location: '.$tourl);
                            exit;
                        }
                    }

                    if (!empty($navigatordata)) {
                        $navigatordata = array_filter($navigatordata, function($nav) {
                            if ($nav['code'] == 'news') {
                                return false;
                            }
                            return true;
                        });
                    }


                    $module['menu'] = $navigatordata;
                    $room_cache->setCache($this->room['crid'],
                        $cache_set['module'],
                        $cache_set['param'],
                        $navigatordata,
                        $cache_set['expire'],
                        $cache_set['needupdate']);
                    unset($navigatordata);
                    continue;
                }
                //轮播大图
                if ($module['mid'] == 3) {
                    $has_slide = true;
                    if (!empty($module['custom_data']['options'])) {
                        $module['custom_data']['options'] = array_map(function($e) {
                            $e['image'] = show_plate_img($e['image']);
                            return $e;
                        }, $module['custom_data']['options']);
                    }
					$module['room_type'] = $room_type;
                    continue;
                }
                //滚动通知
                if ($module['mid'] == 4) {
                    $cache_set = $this->cache_time[$module['code']];
                    $notice = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
                    if (!empty($notice)) {
                        $module['data'] = $notice;
                        continue;
                    }
                    $module['data'] = $model->getNoticeList($this->room['crid'], 3);
                    $room_cache->setCache($this->room['crid'],
                        $cache_set['module'],
                        $cache_set['param'],
                        $module['data'],
                        $cache_set['expire'],
                        $cache_set['needupdate']);
                    continue;
                }
                //网校简介
                if ($module['mid'] == 5) {
                    $module['room_type'] = $room_type;
					$module['data'] = $this->room;
                    continue;
                }
                //用户登录
                if ($module['mid'] == 6) {
                    $module['room'] = $this->room;
                    $module['currentdomain'] = $currentdomain;
                    if (!empty($this->user)) {
                        $module['data'] = $this->user;
                    }
                    continue;
                }
                //免费试听
                if ($module['mid'] == 7) {
                    /*$cache_set = $this->cache_time[$module['code']];
                    $free_data = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
                    if (!empty($free_data)) {
                        $module['data'] = $free_data;
                        continue;
                    }*/
                    $module['data'] = $model->getFreeList($this->room['crid']);
                    if ($this->room['crid'] == 14083) {
                        //免费试听排序，临时代码
                        $topIds = array(195001, 195003, 195005, 195007, 195009, 195011);
                        $cwids = array();
                        foreach ($module['data'] as $freedate) {
                            $cwids[] = in_array($freedate['cwid'], $topIds) ? $freedate['cwid'] : PHP_INT_MAX;
                        }
                        array_multisort($cwids, SORT_ASC, SORT_NUMERIC, $module['data']);
                    }
                    if ($this->room['crid'] == 14283) {
                        //http://xz.ebh.net/，望真艺教网校
                        $topIds = array(207789 , 207791, 207793, 207795, 207797, 207799);
                        $cwids = array();
                        foreach ($module['data'] as $freedate) {
                            $cwids[] = in_array($freedate['cwid'], $topIds) ? $freedate['cwid'] : PHP_INT_MAX;
                        }
                        array_multisort($cwids, SORT_ASC, SORT_NUMERIC, $module['data']);
                    }

                    /*$room_cache->setCache($this->room['crid'],
                        $cache_set['module'],
                        $cache_set['param'],
                        $module['data'],
                        $cache_set['expire'],
                        $cache_set['needupdate']);*/
                    continue;
                }
                //新闻资讯
                if ($module['mid'] == 8) {
                    $cache_set = $this->cache_time[$module['code']];
                    $news = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
                    if (!empty($news)) {
                        $module['data'] = $news;
                        continue;
                    }
                    $module['data'] = $model->getNewsList($this->room['crid'], 6);
                    $room_cache->setCache($this->room['crid'],
                        $cache_set['module'],
                        $cache_set['param'],
                        $module['data'],
                        $cache_set['expire'],
                        $cache_set['needupdate']);
                    continue;
                }
                //轮播广告
                if ($module['mid'] == 9) {
                    $has_slide = true;
                    $repeat_count++;
                    $module['index'] = $repeat_count;
                    if (!empty($module['custom_data']['options'])) {
                        $module['custom_data']['options'] = array_map(function($e) {
                            $e['image'] = show_plate_img($e['image']);
                            return $e;
                        }, $module['custom_data']['options']);
                    }
                    continue;
                }
                //调查问卷
                if ($module['mid'] == 10) {
                    $cache_set = $this->cache_time[$module['code']];
                    $curs = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
                    if (!empty($curs)) {
                        $module['data'] = $curs;
                        //continue;
                    }
                    $module['data'] = $model->getSurveyList($this->room['crid'], 6, true);
                    $room_cache->setCache($this->room['crid'],
                        $cache_set['module'],
                        $cache_set['param'],
                        $module['data'],
                        $cache_set['expire'],
                        $cache_set['needupdate']);
                    continue;
                }
                //课程列表
                if ($module['mid'] == 1111111) {
                    $has_window_login = true;
                    $uid = !empty($this->user) ? $this->user['uid'] : 0;
                    $packages = $plateModel->payPackageMenu($this->room['crid'], 0, null, true);
                    if (empty($packages)) {
                        continue;
                    }
                    $courselist['surveyid'] = $this->_need_survery($this->room['crid'], $this->user);
                    list($k, $v) = each($packages);
                    $itemFilters = array();
                    $courselist['pid'] = 0;
                    if ($v['displayorder'] != -1) {
                        $courselist['pid'] = $v['pid'];
                        $courselist['sorts'] = $plateModel->paySortMenu($v['pid'], true);
                        $itemFilters['pid'] = $v['pid'];
                    }
                    $courselist['packages'] = $packages;

                    $items = $plateModel->payItemList($this->room['crid'], $itemFilters);
                    $oitems = $plateModel->otherItemList($this->room['crid'], $itemFilters);
                    if (!empty($oitems)) {
                        $oitems = array_map(function($o) {
                            $o['tg'] = true;
                            return $o;
                        }, $oitems);
                    }
                    $items = array_merge($items, $oitems);
                    unset($oitems);
                    $courselist['isalumni'] = false;
                    if (!empty($items) && !empty($this->user)) {
                        $folderid_arr = array_column($items, 'folderid');
                        $folderid_arr = array_unique($folderid_arr);
                        $courselist['userpermisions'] = $model->getUserpermisions($this->user['uid'], $folderid_arr, $this->room['crid']);
                        //用户是否是校友
                        $courselist['isalumni'] = $model->isAlumni($this->room['crid'], $this->user['uid']);
                    } else {
                        $courselist['userpermisions'] = false;
                    }
                    $this->_pageItem($items, $courselist['isalumni']);
                    if ($module['columns'] == 4) {
                        if ($v['displayorder'] != -1) {
                            $courselist['items'] = $items;
                            if (count($items) > 80) {
                                $courselist['items'] = array_slice($items, 0, 80);
                            }
                        } else {
                            //服务包定位全部
                            $courselist['group_by_package'] = true;
                            foreach ($items as $gitem) {
                                if (!isset($courselist['packages'][$gitem['pid']])) {
                                    continue;
                                }
                                $courselist['packages'][$gitem['pid']]['items'][] = $gitem;
                            }
                        }

                    } else {
                        if (!empty($courselist['packages'])) {
                            if ($v['displayorder'] == -1 && !empty($items)) {
                                //服务包定位全部
                                $courselist['group_by_package'] = true;
                                foreach ($items as $gitem) {
                                    if (!isset($courselist['packages'][$gitem['pid']])) {
                                        continue;
                                    }
                                    $courselist['packages'][$gitem['pid']]['items'][] = $gitem;
                                }
                            } else {
                                $group_big = array();
                                $group_normal = array();
                                $group_small = array();
                                $rows = 0;
                                if (!empty($items)) {
                                    foreach ($items as $id => $course) {
                                        if ($course['view_mode'] == 2) {
                                            $group_big[$rows++] = $course;
                                            continue;
                                        }
                                        if ($course['view_mode'] == 0) {
                                            $last_group = end($group_normal);
                                            if ($last_group === false || count($last_group) % 3 == 0) {
                                                $group_normal[$rows++] = array($course);
                                                continue;
                                            }
                                            $k = key($group_normal);
                                            $group_normal[$k][] = $course;
                                            continue;
                                        }
                                        if ($course['view_mode'] == 1) {
                                            $last_group = end($group_small);
                                            if ($last_group === false || count($last_group) % 2 == 0) {
                                                $group_small[$rows++] = array($course);
                                                continue;
                                            }
                                            $k = key($group_small);
                                            $group_small[$k][] = $course;
                                            continue;
                                        }
                                    }
                                }
                                $normal_rows = 0;
                                $other_rows = 0;
                                for ($i = 0; $i < $rows; $i++) {
                                    /*if ($normal_rows < 3 && $normal_rows + $other_rows >=5 || $normal_rows > 2 && $normal_rows + $other_rows >= 5) {
                                        $courselist['more'] = true;
                                        break;
                                    }*/
                                    if ($normal_rows + $other_rows >= 20) {
                                        $courselist['more'] = true;
                                        break;
                                    }
                                    if (key_exists($i, $group_big)) {
                                        $tmp[] = array('view_mode' => 2, 'data' => array($group_big[$i]));
                                        $other_rows++;
                                        continue;
                                    }
                                    if (key_exists($i, $group_normal)) {
                                        $tmp[] = array('view_mode' => 0, 'data' => $group_normal[$i]);
                                        $normal_rows++;
                                        continue;
                                    }
                                    if (key_exists($i, $group_small)) {
                                        $tmp[] = array('view_mode' => 1, 'data' => $group_small[$i]);
                                        $other_rows++;
                                        continue;
                                    }
                                }
                                if (!empty($tmp)) {
                                    $courselist['group'] = $tmp;
                                }
                                unset($module['data']['items']);
                            }
                        }
                    }
                    $module['data'] = $courselist;
                    continue;
                }
                if ($module['mid'] == 11) {
                    $api = Ebh::app()->getApiServer('ebh');
                    $courseServices = $api->reSetting()
                        ->setService('CourseService.StudyService.index')
                        ->addParams(array(
                            'uid' => !empty($this->user) && $this->user['groupid'] == 6 ? $this->user['uid'] : 0,
                            'crid' => $this->room['crid'],
                            'column' => $module['columns']
                        ))
                        ->request();
                    $module['data'] = $courseServices;
                    $appsetting = Ebh::app()->getConfig()->load('othersetting');
                    $surveyid = $this->_need_survery($this->room['crid'], $this->user);
                    if (!empty($module['data']['items'])) {
                        array_walk($module['data']['items'], function(&$group, $k, $args) {
                            array_walk($group['services'], function(&$course, $k, $args) {
                                if (!$args['enabled']) {
                                    $course['cannotpay'] = true;
                                }
                                $clientClasses = array();
                                $course['url'] = 'javascript:;';
                                if (empty($course['cover'])) {
                                    $course['cover'] = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_243_144.jpg';
                                } else {
                                    $course['cover'] = show_plate_course_cover($course['cover']);
                                }
                                if (!empty($course['bid'])) {
                                    $course['t'] = 2;
                                    $course['id'] = $course['bid'];
                                    $course['title'] = $course['name'];
                                } else if (!empty($course['showbysort'])) {
                                    $course['t'] = 1;
                                    $course['id'] = $course['sid'];
                                    $course['title'] = $course['sname'];
                                } else {
                                    $course['t'] = 0;
                                    $course['id'] = $course['itemid'];
                                    $course['title'] = $course['iname'];
                                }
                                if ($course['t'] == 2) {
                                    $course['detailurl'] = '/room/portfolio/tagged/'.$course['id'].'.html';
                                } else if ($course['t'] == 1) {
                                    $course['detailurl'] = '/room/portfolio/bundle/'.$course['id'].'.html';
                                } else {
                                    $course['detailurl'] = '/courseinfo/'.$course['itemid'].'.html';
                                }

                                if (!empty($args['szlz'])) {
                                    $clientClasses[] = 'szlz';
                                }
                                if (!empty($course['hasPower'])) {
                                    $clientClasses[] = 'plate-allow';
                                    $course['css'] = implode(' ', $clientClasses);
                                    if (empty($args['iscollege'])) {
                                        $course['url'] = '/myroom/stusubject/'.$course['folderid'].'.html';
                                        return;
                                    }
                                    if ($course['showmode'] == 3) {
                                        $course['url'] = '/myroom/college/study/introduce/'.$course['folderid'].'.html';
                                        return;
                                    }
                                    $course['url'] = '/myroom.html?url=/myroom/college/study/cwlist/'.$course['folderid'].'.html';
                                    return;
                                } else if (!empty($args['surveyid'])) {
                                    $clientClasses[] = 'survey';
                                }

                                if (!empty($course['cannotpay'])) {
                                    $clientClasses[] = 'plate-sign-disabled';
                                    $course['css'] = implode(' ', $clientClasses);
                                    return;
                                }
                                if ($course['price'] == 0) {
                                    $clientClasses[] = 'plate-sign-free';
                                }

                                if (empty($args['user'])) {
                                    $clientClasses[] = 'plate-sign-unlogin';
                                    $course['css'] = ' '.implode(' ', $clientClasses);
                                    return;
                                } else if ($args['user']['groupid'] == 5) {
                                    $clientClasses[] = 'plate-sign-unallow';
                                    $course['css'] = ' '.implode(' ', $clientClasses);
                                    return;
                                }

                                $course['css'] = ' '.implode(' ', $clientClasses);
                                if ($course['price'] == 0) {
                                    return;
                                }
                                if ($course['t'] == 2) {
                                    $course['url'] = '/ibuy.html?bid='.$course['id'];
                                    return;
                                }
                                if (!empty($course['tagged'])) {
                                    $course['url'] = '/ibuy.html?sid='.$course['id'].'&itemid='.$course['itemid'];
                                    return;
                                }
                                $course['url'] = '/ibuy.html?itemid='.$course['itemid'];
                            }, $args);
                        }, array(
                            'iscollege' => $this->room['iscollege'],
                            'isplate' => $this->room['template'] == 'plate',
                            'user' => $this->user,
                            'szlz' => !empty($appsetting['szlz']) && $appsetting['szlz'] == $this->room['crid'],
                            'surveyid' => $surveyid,
                            'enabled' => $enabled
                        ));

                        $module['data']['surveyid'] = $surveyid;
                        $module['data']['szlz'] = !empty($appsetting['szlz']) && $appsetting['szlz'] == $this->room['crid'];
                    }

                    //print_r($module['data']['courses']);exit;
                }
                //应用
                if ($module['mid'] == 12) {
                    $cache_set = $this->cache_time[$module['code']];
                    $app = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
                    if (!empty($app)) {
                        $module['data'] = array_slice($app, 0, 6);
                        continue;
                    }
                    if ($app = $model->getAppList($this->room['crid'], 1)) {
                        $module['data'] = array_slice($app, 0, 6);
                        $room_cache->setCache($this->room['crid'],
                            $cache_set['module'],
                            $cache_set['param'],
                            $module['data'],
                            $cache_set['expire'],
                            $cache_set['needupdate']);
                    }
                    continue;
                }
                //微信公众号
                if ($module['mid'] == 13) {
                    if (!empty($module['custom_data']['options'][0]['image'])) {
                        $global_qcode = $module['custom_data']['options'][0]['image'] = show_plate_img($module['custom_data']['options'][0]['image']);
                    }
                    if (empty($global_qcode)) {
                        $module['custom_data']['options'][0]['image'] = $global_qcode = $roomdetail['wechatimg'];
                    }
                    continue;
                }
                //积分排名
                if ($module['mid'] == 14) {
                    $cache_set = $this->cache_time[$module['code']];
                    $rank = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
                    if (!empty($rank)) {
                        $module['data'] = $rank;
                        continue;
                    }
                    $module['data'] = $model->getRankList($this->room['crid'], 12 * $module['columns']);
                    $room_cache->setCache($this->room['crid'],
                        $cache_set['module'],
                        $cache_set['param'],
                        $module['data'],
                        $cache_set['expire'],
                        $cache_set['needupdate']);
                    continue;
                }
                //最新报名
                if ($module['mid'] == 15) {
                    $cache_set = $this->cache_time[$module['code']];
                    $latest = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
                    if (!empty($latest)) {
                        $module['data'] = array_slice($latest, 0, 3 * $module['columns']);
                        continue;
                    }
                    $latest = $model->getLatestReportList($this->room['crid'], 20);
                    if (empty($latest)) {
                        continue;
                    }
                    $module['data'] = array_slice($latest, 0, 3 * $module['columns']);
                    $room_cache->setCache($this->room['crid'],
                        $cache_set['module'],
                        $cache_set['param'],
                        $latest,
                        $cache_set['expire'],
                        $cache_set['needupdate']);
                    continue;
                }
                //学员动态
                if ($module['mid'] == 16) {
                    $cache_set = $this->cache_time[$module['code']];
                    $dy = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
                    if (false&&!empty($dy)) {
                        $module['data'] = array_slice($dy, 0, 3 * $module['columns']);
                        continue;
                    }
                    $dy = $model->getDynamicList($this->room['crid'], 8);
                    if (!empty($dy)) {
                        $module['data'] = array_slice($dy, 0, 3 * $module['columns']);
                        $room_cache->setCache($this->room['crid'],
                            $cache_set['module'],
                            $cache_set['param'],
                            $module['data'],
                            $cache_set['expire'],
                            $cache_set['needupdate']);
                    }
                    continue;
                }
                //获取用户名
                if ($module['mid'] == 17) {
                    $has_window_login = true;
                    $module['room'] = $this->room;
                    $module['currentdomain'] = $currentdomain;
                    continue;
                }
                //热门标签
                if ($module['mid'] == 18) {
                    if (!empty($this->room['crlabel'])) {
                        $module['data'] = array_slice(explode(',', $this->room['crlabel']), 0, 8);
                    }
                    continue;
                }
                //课程排名
                if ($module['mid'] == 19) {
                    $cache_set = $this->cache_time[$module['code']];
                    $cr = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
                    if (!empty($cr)) {
                        $module['data'] = array_slice($cr, 0, 3 * $module['columns']);
                        continue;
                    }
                    $cr = $model->getCourseRankList($this->room['crid'], 6);
                    if (!empty($cr)) {
                        $module['data'] = array_slice($cr, 0, 3 * $module['columns']);
                        $room_cache->setCache($this->room['crid'],
                            $cache_set['module'],
                            $cache_set['param'],
                            $module['data'],
                            $cache_set['expire'],
                            $cache_set['needupdate']);
                    }

                    continue;
                }
                //富文本
                if ($module['mid'] == 20) {
                    if (isset($module['custom_data']['richtext'])) {
                        $p = "/<img[^>]+?src=\"([^\"]+?)\"[^>]*?>/i";
                        if (preg_match_all($p, $module['custom_data']['richtext'], $m)) {
                            foreach ($m[0] as $ii => $ee) {
                                $height = $width = '';
                                if (preg_match('/width="(\d+)"/', $ee, $sm) || preg_match('/width:\s*(\d+)/', $ee, $sm)) {
                                    $width = ' width="'.$sm[1].'"';
                                }
                                if (preg_match('/height="(\d+)"/', $ee, $sm) || preg_match('/height:\s*(\d+)/', $ee, $sm)) {
                                    $height = ' height="'.$sm[1].'"';
                                }
                                $module['custom_data']['richtext'] = str_replace($m[0][$ii], '<img src="'.$m[1][$ii].'"'.$width.$height.' />', $module['custom_data']['richtext']);
                            }
                        }
                    }
                    continue;
                }
                //精品课件
                if ($module['mid'] == 21) {
                    if ($module['ititle'] == '精品课件') {
                        $module['ititle'] = '单课列表';
                    }
                    if ($module['ctitle'] == '精品课件') {
                        $module['ctitle'] = '单课列表';
                    }
                    $surveyid = $this->_need_survery($this->room['crid'], $this->user);
                    $module['data'] = array(
                        'courses' => $model->getFolders($this->room['crid']),
                        'finewares' => $model->getFineCoursewares($this->room['crid'], null, 20),
                        'user' => $this->user,
                        'surveyid' => $surveyid
                    );
                    if (!empty($module['data']['finewares'])) {
                        if (!$enabled) {
                            array_walk($module['data']['finewares'], function(&$fireware) {
                                $fireware['cannotpay'] = true;
                            });
                        }
                        $uid = array_column($module['data']['finewares'], 'uid');
                        $module['data']['publishers'] = $model->getUsers($uid);

                        if (!empty($this->user) && $this->user['groupid'] == 6) {
                            $folderids = array_column($module['data']['finewares'], 'folderid');
                            $module['data']['course_permisions'] = $model->getUserpermisions($this->user['uid'], $folderids, $this->room['crid']);
                            $module['data']['course_permisions'] = array_flip($module['data']['course_permisions']);

                            $coursewareids = array_column($module['data']['finewares'], 'cwid');
                            $module['data']['courseware_permisions'] = $model->getCoursewarePermisions($this->user['uid'], $this->room['crid'], $coursewareids);
                            $module['data']['courseware_permisions'] = array_flip($module['data']['courseware_permisions']);
                            unset($folderids, $coursewareids);
                        }
                    }
                }
                //名师团队
                if ($module['mid'] == 22) {
                    $module['data'] = $model->getMasterSimpleList($this->room['crid'], 0, true);
                }
				//自选课程
				if ($module['mid'] == 23) {
                    $items = $plateModel->getManualCourses($this->room['crid'], 0);
                    //print_r($items);exit;
                    $module['data']['isalumni'] = false;
                    if (!empty($items) && !empty($this->user)) {
                        $module['data']['userpermisions'] = $plateModel->getUserpermisions($this->user['uid'], $this->room['crid']);
                        //用户是否是校友
                        $module['data']['isalumni'] = $model->isAlumni($this->room['crid'], $this->user['uid']);
                    } else {
                        $module['data']['userpermisions'] = false;
                    }

					$module['data']['manualcourses'] = $items;
                    $module['data']['surveyid'] = $this->_need_survery($this->room['crid'], $this->user);
                    $module['data']['user'] = $this->user;
                    $module['data']['crid'] = $this->room['crid'];
				}
				//课程导航
                if ($module['mid'] == 24) {
                    $module['data']['packages'] = $plateModel->payPackageMenu($this->room['crid'], 0, null, true);
                    $pid = 0;
                    if (!empty($module['data']['packages'])) {
                        $localed = array_filter($module['data']['packages'], function($p) {
                            return $p['located'] == 1;
                        });
                        if (!empty($localed)) {
                            $localed_package = reset($localed);
                            $pid = $localed_package['pid'];
                        } else {
                            $first_package = reset($module['data']['packages']);
                            if ($first_package['displayorder'] > -1) {
                                $pid = $first_package['pid'];
                            }
                        }
                    }
                    if ($pid > 0) {
                        $module['data']['sorts'] = $plateModel->paySortMenu($pid, true);
                    }
                    $module['data']['pid'] = $pid;
                }

                //课程包
                if ($module['mid'] == 25) {
                    $uid = !empty($this->user) ? $this->user['uid'] : 0;
                    $api = Ebh::app()->getApiServer('ebh');
                    $bundles = $api->reSetting()
                        ->setService('CourseService.Bundle.index')
                        ->addParams('crid', $this->room['crid'])
                        ->addParams('uid', $uid)
                        ->addParams('display', 1)
                        ->request();
                    if (!empty($bundles)) {
                        foreach ($bundles['list'] as $k => $v) {
                            if (!$enabled) {
                                $bundles['list'][$k]['cannotpay'] = true;
                            }
                            if (empty($v['cover'])) {
                                $bundles['list'][$k]['cover'] = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_243_144.jpg';
                            }
                            if (!empty($v['hasPower'])) {
                                if (empty($this->room['iscollege'])) {
                                    $bundles['list'][$k]['url'] = sprintf('/myroom/stusubject/%s.html', $v['folderid']);
                                } else if ($v['showmode'] == 3) {
                                    $bundles['list'][$k]['url'] = sprintf('/myroom/college/study/introduce/%s.html', $v['folderid']);
                                } else {
                                    $bundles['list'][$k]['url'] = sprintf('/myroom.html?url=/myroom/college/study/cwlist/%s.html', $v['folderid']);
                                }
                            }
                        }
                        $module['data']['bundles'] = $bundles['list'];
                        $module['data']['surveyid'] = $this->_need_survery($this->room['crid'], $this->user);
                        $module['data']['crname'] = $this->room['crname'];
                    }
                }
            }

            $top_modules = array_filter($modules, function($e) {
                return $e['show_type'] == 1;
            });
            if (empty($global_qcode)) {
                $global_qcode = $roomdetail['wechatimg'];
            }
            $normal_modules = array_diff_key($modules, $top_modules);
            $adjust_modules = $this->_regroup_modules_2($normal_modules);
            //print_r($adjust_modules);exit;
            if (empty($roomdetail['isdesign'])) {
                if (!empty($top_modules)) {
                    $top_modules = array_values($top_modules);
                    $top_menu_index = $top_slide_index = -1;
                    $show_course_menu = false;
                    foreach($top_modules as $index => $top_module_item) {
                        if ($top_module_item['mid'] == 2) {
                            $top_menu_index = $index;
                            $show_course_menu = !empty($top_module_item['arg_sign']);
                            $theme = $this->_get_course_menu_theme($top_module_item['background_color']);
                            $this->assign('menu_theme', $theme);
                            continue;
                        }
                        if ($top_module_item['mid'] == 3) {
                            $top_slide_index = $index;
                            continue;
                        }
                    }
                    //判断头部轮播广告是否位于导航之下
                    if ($top_slide_index == $top_menu_index + 1) {
                        $this->assign('allways_show_course_menus', true);
                    }
                    $top = array_column($top_modules, 'top');
                    if ($show_course_menu) {
                        $course_menus = $model->getCourseMenu($this->room['crid']);
                        $this->assign('course_menus', $course_menus);
                    }
                    array_multisort($top, SORT_ASC, SORT_NUMERIC, $top_modules);
                }
                $this->assign('top_modules', $top_modules);
            }

            $this->assign('currentdomain', $currentdomain);
            $this->assign('varpool', array('currentdomain' => $currentdomain));
            $this->assign('has_slide', $has_slide);
            $this->assign('has_window_login', $has_window_login);
            $this->assign('global_qcode', $global_qcode);
            $config_json = json_encode($modules, true);
            $this->assign('config_json', $config_json);
            unset($modules);
        }
        if (empty($adjust_modules)) {
            $inner_data = array(
                'content_height' => $content_height,
                'modules' => !empty($normal_modules) ? $normal_modules : array(),
                'roomdetail' => $roomdetail
            );
        } else {
            $inner_data = array(
                'content_height' => $content_height,
                'modules' => !empty($adjust_modules) ? $adjust_modules : array(),
                'roomdetail' => $roomdetail,
                'adjust' => true
            );
        }
        $inner_data['title'] = $roomdetail['crname'];
        $system_info = $this->model('Systemsetting')->getSetting($this->room['crid']);
        if (!empty($system_info['subtitle'])) {
            $inner_data['title'] = $inner_data['title'] . ' - ' . $system_info['subtitle'];
        }
		$appsetting = Ebh::app()->getConfig()->load('othersetting');
        $this->assign('szlz', !empty($appsetting['szlz']) && $appsetting['szlz'] == $this->room['crid']);
        $this->assign('content_height', $content_height);
        $this->assign('inner_view', 'shop/plate/context');
        $this->assign('inner_data', $inner_data);
        $this->display('shop/plate/portfolio');
        exit;
    }

    /**
     * 模块分组，方案二
     * @param $modules
     * @return array|bool
     */
    private function _regroup_modules_2($modules) {
        //$modules = $this->_adjust_modules_group($modules);
        //$modules = $this->_deal_auto_modules($modules);
        //exit();
        $full_modules = array_filter($modules, function($m) {
            return $m['show_type'] == 3 && $m['columns'] == 4;
        });
        $module_arr = array();
        $full_modules = array_values($full_modules);
        $has_courselist = false;
        if (!empty($full_modules)) {
            foreach ($full_modules as $index => $m) {
                if ($m['mid'] == 11) {
                    $has_courselist = true;
                }
                foreach ($modules as $item) {
                    if ($item['top'] < $m['top']) {
                        if ($index == 0) {
                            $module_arr['top'][] = $item;
                        }
                        continue;
                    }
                    if ($item['top'] == $m['top']) {
                        $module_arr[] = $m;
                        continue;
                    }
                    if ($item['show_type'] == 3 && $item['columns'] == 4) {
                        break;
                    }
                    if ($item['top'] > $m['top']) {
                        $module_arr["{$m['top']}-bottom"][] = $item;
                    }

                }
            }
            unset($full_modules);
            $module_arr = array_values($module_arr);
        }
        if (!empty($module_arr)) {
            if ($has_courselist) {
                return $this->_count_height($module_arr);
            }
            $base_module = null;
            foreach ($module_arr as $k => &$module_group) {
                if (!empty($module_group['mid'])) {
                    continue;
                }
                foreach ($module_group as $module) {
                    if ($module['mid'] == 11) {
                        $row_group_index = $k;
                        $base_module = $module;
                        break;
                    }
                }
            }
            if (!isset($row_group_index)) {
                return $this->_count_height($module_arr);
            }
            $tmp = $this->_regroup_courselist($module_arr[$row_group_index], $base_module);
            $max_index = count($module_arr);
            unset($module_arr[$row_group_index]);
            $module_arr = $this->_count_height($module_arr);
            $ret = array();
            for ($i = 0; $i < $row_group_index; $i++) {
                $ret[] = $this->_single_row($module_arr[$i]);
            }
            foreach ($tmp as $item) {
                $ret[] = $item;
            }

            for ($i = $row_group_index + 1; $i < $max_index; $i++) {
                $ret[] = $this->_single_row($module_arr[$i]);
            }
            return $ret;
        }

        foreach ($modules as $module) {
            if ($module['mid'] == 11) {
                $courselist_module = $module;
                break;
            }
        }
        if (empty($courselist_module)) {
            return false;
        }
        return $this->_regroup_courselist($modules, $courselist_module);
    }
    private function _regroup_courselist($modules, $base_module) {
        $is_waterfall = true;
        $base_right = $base_module['left'] + $base_module['width'];
        foreach ($modules as $module) {
            $right = $module['left'] + $module['width'];
            if ($module['left'] < $base_module['left'] && $right > $base_module['left'] || $module['left'] < $base_right && $right > $base_right) {
                $is_waterfall = false;
                break;
            }
        }
        if ($is_waterfall) {
            //是一个规范的瀑布流布局
            //print_r($this->_regroup_waterfall_layout($modules, $base_module));exit;
            return $this->_regroup_waterfall_layout($modules, $base_module);
        }

        $top_modules = array();
        $bottom_modules = array();
        $top_base_top = -1;
        $top_base_left = -1;
        $bottom_base_top = -1;
        $bottom_base_left = -1;
        foreach ($modules as $k => $module) {
            if ($module['top'] < $base_module['top']) {
                $top_modules[$k] = $module;
                $top_base_top = $top_base_top == -1 ? $module['top'] : min($top_base_top, $module['top']);
                $top_base_left = $top_base_left == -1 ? $module['left'] : min($top_base_left, $module['left']);
                continue;
            }
            if ($module['top'] > $base_module['top'] + $base_module['height']) {
                $bottom_modules[$k] = $module;
                $bottom_base_top = $bottom_base_top == -1 ? $module['top'] : min($bottom_base_top, $module['top']);
                $bottom_base_left = $bottom_base_left == -1 ? $module['left'] : min($bottom_base_left, $module['left']);
                continue;
            }
            $auto_modules[] = $module;
        }

        foreach ($auto_modules as $auto_module) {
            if ($auto_module['mid'] == 11) {
                $self = $auto_module;
                continue;
            }
            if ($auto_module['left'] > 0) {
                $right_modules[] = $auto_module;
                continue;
            }
            $left_modules[] = $auto_module;
        }
        $group_modules = array('group' => true, 'width' => 1200);
        if (!empty($left_modules)) {
            $base_top = -1;
            $height = 0;
            foreach ($left_modules as &$left_module) {
                if ($base_top < 0) {
                    $base_top = $left_module['top'];
                }
                $left_module['top'] -= $base_top;
                $left_module['left'] = 0;
                $height = max($height, $left_module['top'] + $left_module['height']);
            }
            $left_modules['height'] = $height;
            $left_modules['width'] = 285;
            $group_modules[] = $left_modules;
        }
        $group_modules[] = $self;
        if (!empty($right_modules)) {
            $base_top = -1;
            $height = 0;
            foreach ($right_modules as &$right_module) {
                if ($base_top < 0) {
                    $base_top = $right_module['top'];
                }
                $right_module['top'] -= $base_top;
                $right_module['left'] = 0;
                $height = max($height, $right_module['top'] + $right_module['height']);
            }
            $right_modules['height'] = $height;
            $right_modules['width'] = 285;
            $group_modules[] = $right_modules;
        }
        //$group_modules = array_values($group_modules);
        $ret = array();
        if (!empty($top_modules)) {
            $height = 0;
            foreach ($top_modules as &$top_module) {
                $top_module['left'] -= $top_base_left;
                $top_module['top'] -= $top_base_top;
                $height = max($height, $top_module['top'] + $top_module['height']);
            }
            $top_modules['height'] = $height;
            $ret[] = $top_modules;
        }
        $ret[] = $group_modules;
        if (!empty($bottom_modules)) {
            $height = 0;
            foreach ($bottom_modules as &$bottom_module) {
                $bottom_module['left'] -= $bottom_base_left;
                $bottom_module['top'] -= $bottom_base_top;
                $height = max($height, $bottom_module['top'] + $bottom_module['height']);
            }
            $bottom_modules['height'] = $height;
            $ret[] = $bottom_modules;
        }
        return $ret;
    }


    private function _adjust_modules_group($modules) {
        $modules = array_map(function($module) {
           return (object) $module;
        }, $modules);
        array_walk($modules, function($module) {
           $module->right = $module->left + $module->width;
           $module->bottom = $module->top + $module->height;
        });
        //print_r($modules);exit;
        //将模块排序，top 升序,left 升序
        $tops = array_column($modules, 'top');
        $lefts = array_column($modules, 'left');
        array_multisort($tops, SORT_ASC, SORT_NUMERIC, $lefts, SORT_ASC, SORT_NUMERIC, $modules);
        unset($tops, $lefts);
        if ($this->_check_exists_auto_module($modules)) {
            $modules = $this->_group_by_horizontal($modules);
        }

        print_r($modules);
        return;










        $need_adjust = $this->_check_exists_auto_module($modules);
        if (!$need_adjust) {
            return $modules;
        }

        $modules = $this->_group_by_horizontal($modules, 4);
        /*foreach ($modules as $index => $group) {
            if (!is_array($group)) {
                continue;
            }
            $modules[$index] = $this->_relocate($group);
            $modules[$index] = $this->_group_by_vertical($modules[$index]);
        }*/
        print_r($modules);
    }

    /**
     * 检查分组是否包含自适应模块
     * @param $modules
     * @return bool
     */
    private function _check_exists_auto_module($modules) {
        foreach ($modules as $module) {
            if ($module->show_type == 3) {
                return true;
            }
        }
        return false;
    }
    /**
     * 重新计算分组模块的相对位置
     * @param $modules
     * @return mixed
     */
    private function _relocate($modules) {
        $tops = array_column($modules, 'top');
        $lefts = array_column($modules, 'left');
        $base_top = min($tops);
        $base_left = min($lefts);
        array_walk($modules, function($module, $key, $base) {
            $module->left -= $base['left'];
            $module->top -= $base['top'];
        }, array(
            'top' => $base_top,
            'left' => $base_left
        ));
        return $modules;
    }

    /**
     * 计算模块分组宽度
     * @param $modules
     * @return mixed
     */
    private function _compute_group_width($modules) {
        $lefts = array_column($modules, 'left');
        $rights = array_column($modules, 'right');
        $left_boundary = min($lefts);
        $right_boundary = max($rights);
        //分组容器宽度
        $width = $right_boundary - $left_boundary;
        return $width;
    }

    /**
     * 横切分组
     * @param $modules
     * @return mixed
     */
    private function _group_by_horizontal($modules) {
        //分组容器宽度
        $width = $this->_compute_group_width($modules);
        $columns = array(
            285 => 1,
            590 => 2,
            895 => 3,
            1200 => 4
        );
        if (!isset($columns[$width])) {
            return array();
        }
        $column_count = $columns[$width];
        $group_index = 0;
        foreach ($modules as $module) {
            if ($module->columns == $column_count) {
                $group_index++;
                $tmp_modules[$group_index] = $module;
                $group_index++;
                continue;
            }
            $tmp_modules[$group_index][] = $module;
        }
        if (!empty($tmp_modules)) {
            if (count($tmp_modules) == 1) {
                $sign_value = reset($tmp_modules);
                if (is_object($sign_value)) {
                    return $sign_value;
                }
                if ($this->_check_exists_auto_module($sign_value)) {
                    return $this->_group_by_vertical($sign_value);
                }
                return $sign_value;
            }
            foreach ($tmp_modules as $index => $group) {
                if (is_object($group)) {
                    continue;
                }
                $tmp_modules[$index] = $this->_relocate($group);
                $exists_auto_module = $this->_check_exists_auto_module($group);
                if ($exists_auto_module) {
                    $tmp_modules[$index] = $this->_group_by_vertical($group);
                }
            }
            return $tmp_modules;
        }
        return $modules;
    }

    /**
     * 竖切分组
     * @param $modules
     * @return mixed
     */
    private function _group_by_vertical($modules) {
        $lefts = array_column($modules, 'left');
        $lefts = array_unique($lefts);
        $lefts = array_filter($lefts, function($left) {
            return $left > 0;
        });
        sort($lefts, SORT_NUMERIC);
        $split_sign = array_flip($lefts);
        foreach ($split_sign as $k => $v) {
            $split_sign[$k] = true;
        }
        foreach ($modules as $module) {
            foreach ($lefts as $left) {
                if ($left > $module->left && $left < $module->right) {
                    $split_sign[$left] = false;
                }
            }
        }
        $split_sign = array_filter($split_sign, function($split_sign) {
           return $split_sign;
        });
        if (!empty($split_sign)) {
            foreach ($split_sign as $left => $sign) {
                foreach ($modules as $index => $module) {
                    if ($module->left < $left) {
                        $tmp_group[$left][] = $module;
                        unset($modules[$index]);
                    }
                }
            }
            $tmp_group[] = $modules;
        }

        if (!empty($tmp_group)) {
            $tmp_group = array_values($tmp_group);
            if (count($tmp_group) == 1) {
                $single_value = reset($tmp_group);
                if ($this->_check_exists_auto_module($single_value)) {
                    return $this->_recursive($single_value);
                }
                return $single_value;
            }
            foreach ($tmp_group as $index => $group) {
                if ($this->_check_exists_auto_module($group)) {
                    $tmp_group[$index] = $this->_group_by_horizontal($group);
                }
            }
            return $tmp_group;
        }
        return $modules;
    }

    private function _recursive($modules, $level = 0) {
        $stop = $level + 1 == 2;
        foreach ($modules as $index => $module) {
            if ($module->show_type == 3 && empty($module->deal)) {
                $auto_module = $module;
                $modules[$index]->deal = true;
                break;
            }
        }
        if (empty($auto_module)) {
            return $modules;
        }
        $group = array();
        $top_group = array();
        $left_group = array();
        $right_group = array();
        $deter_module = null;
        foreach ($modules as $index => $module) {
            if ($module->top < $auto_module->top) {
                $top_group[] = $module;
                unset($modules[$index]);
                continue;
            }
            break;
        }
        foreach ($modules as $index => $module) {
            if ($module->right < $auto_module->left || $module->left > $auto_module->right) {
                continue;
            }
            if ($auto_module->left > $module->left && $auto_module->left < $module->right ||
                $auto_module->right > $modules->left && $auto_module->right < $module->right) {
                $deter_module = $module;
                break;
            }
            $group[] = $module;
            unset($modules[$index]);
        }
        if ($auto_module->left > 0) {
            foreach ($modules as $index => $module) {
                if ($module->left >= $auto_module->left) {
                    continue;
                }
                if (!empty($deter_module) && ($module->top > $deter_module->top || $module->eid == $deter_module->eid)) {
                    break;
                }
                $left_group[] = $module;
                unset($modules[$index]);
            }
        }
        if ($auto_module->right < 1200) {
            foreach ($modules as $index => $module) {
                if (!empty($deter_module) && ($module->top > $deter_module->top || $module->eid == $deter_module->eid)) {
                    break;
                }
                if ($module->left > $auto_module->right) {
                    $right_group[] = $module;
                    unset($modules[$index]);
                }
            }
        }



        $ret = array();
        if (!empty($top_group)) {
            if (!$stop) {
                $top_group = $this->_recursive($top_group);
            }
            $ret[] = $top_group;
        }
        if (!empty($left_group)) {
            if (!$stop) {
                $left_group = $this->_recursive($left_group);
            }
            $ret[] = $left_group;
        }
        if (!empty($group)) {
            if (!$stop) {
                $group = $this->_recursive($group);
            }
            $ret[] = $group;
        }
        if (!empty($right_group)) {
            if (!$stop) {
                $right_group = $this->_recursive($right_group);
            }
            $ret[] = $right_group;
        }
        if (!empty($modules)) {
            if (!$stop) {
                $modules = $this->_recursive($modules);
            }
            $ret[] = $modules;
        }
        unset($top_group, $left_group, $group, $right_group, $modules);
        return $ret;
    }






    /**
     * 模块调整布局，第一步以整列模块(4列)分组
     * @param $modules
     * @return array|mixed
     */
    private function _split_rows($modules) {
        $modules = array_map(function($a_module) {
            return (object) $a_module;
        }, $modules);
        $group_index = 0;
        foreach ($modules as $module) {
            if ($module->columns == 4) {
                $group_index++;
                $tmp_modules[$group_index] = $module;
                $group_index++;
                continue;
            }
            $tmp_modules[$group_index][] = $module;
        }
        if (!empty($tmp_modules)) {
            $modules = $tmp_modules;
            if (count($tmp_modules) == 0) {
                $modules = reset($tmp_modules);
            }
        }
        return $modules;
    }

    private function _deal_auto_modules($modules) {
        foreach ($modules as $index => $group) {
            if (!is_array($group)) {
                //非数组，不处理
                continue;
            }
            if (count($group) == 1) {
                //单值数组，将数组赋值为单值
                $modules[$index] = reset($group);
                continue;
            }
            //自适应模块
            $auto_module_group = array_filter($group, function($module) {
                return $module->show_type == 3;
            });
            if (count($auto_module_group) == 0) {
                //分组中不包含自适应模块，无需处理
                continue;
            }
            //判断是否规范的瀑布流布局
            if (!$this->_is_standard_waterfall($group)) {

            }
        }
        //print_r($modules);
    }
    private function _is_standard_waterfall($modules) {
        $left_arr = array_column($modules, 'left');
        $left_arr = array_unique($left_arr);
        $left_arr = array_filter($left_arr, function($left) {
           return $left > 0;
        });
        $left_arr_through_sign = array_flip($left_arr);
        foreach ($modules as $module) {

        }

        print_r($left_arr_through_sign);
        print_r($left_arr);
    }




    private static $filter_base = 0;
    private function _regroup_waterfall_layout($modules, $base_module) {
        $left_group = array();
        $right_group = array();
        if ($base_module['left'] > 0) {
            $left_group = array_filter($modules, function($m) {
                return $m['left'] == 0;
            });
            $left_group['width'] = 285;
            $right_group = array_diff_key($modules, $left_group);
            $right_group['width'] = 895;
        } else {
            /*self::$filter_base = $base_module['left'] + $base_module['width'];
            $left_group = array_filter($modules, function($m) {
                return $m['left'] < self::$filter_base;
            });*/
            $left_group = array();
            $right = $base_module['left'] + $base_module['width'];
            foreach ($modules as $mk => $mm) {
                if ($mm['left'] < $right) {
                    $left_group[$mk] = $mm;
                }
            }

            $left_group['width'] = 895;
            $right_group = array_diff_key($modules, $left_group);
            $right_group['width'] = 285;
        }

        if ($left_group['width'] == 895) {
            $base_left = $base_top = -1;
            $group = array(
                'group' => true,
                'width' => 895
            );
            foreach ($left_group as $id => $item) {
                if ($item['top'] == $base_module['top']) {
                    break;
                }
                if ($base_left < 0) {
                    $base_left = $item['left'];
                }
                if ($base_top < 0) {
                    $base_top = $item['top'];
                }
                $base_left = min($base_left, $item['left']);
                $base_top = min($base_top, $item['top']);
                $group[0][$id] = $item;
            }

            if ($base_left > -1) {
                $height = 0;
                foreach ($group[0] as &$item) {
                    $item['left'] -= $base_left;
                    $item['top'] -= $base_top;
                    $height = max($height, $item['top'] + $item['height']);
                }
                $group[0]['height'] = $height;
            }
            $group[] = $base_module;
            self::$filter_base = $base_module['top'];
            /*$bottom_tmp = array_filter($left_group, function($m) {
               return $m['top'] > self::$filter_base;
            });*/
            $bottom_tmp = array();
            foreach ($left_group as $lk => $ll) {
                if ($ll['top'] > $base_module['top']) {
                    $bottom_tmp[$lk] = $ll;
                }
            }
            if (!empty($bottom_tmp)) {
                $base_left = $base_top = -1;
                foreach ($bottom_tmp as $item2) {
                    if ($base_left < 0) {
                        $base_left = $item2['left'];
                    }
                    if ($base_top < 0) {
                        $base_top = $item2['top'];
                    }
                    $base_left = min($base_left, $item2['left']);
                    $base_top = min($base_top, $item2['top']);
                }
                $height = 0;
                foreach ($bottom_tmp as &$item2) {
                    $item2['left'] -= $base_left;
                    $item2['top'] -= $base_top;
                    $height = max($height, $item2['top'] + $item2['height']);
                }
                $bottom_tmp['height'] = $height;
                $group[] = $bottom_tmp;
                unset($bottom_tmp);
            }
            $ret = array(array(
                'group' => true,
                'width' => 1200,
                $group,
                $right_group
            ));

            return $ret;
        }

        if ($right_group['width'] == 895) {
            $base_left = $base_top = -1;
            $group = array(
                'group' => true,
                'width' => 895
            );
            foreach ($right_group as $id => $item) {
                if ($item['top'] == $base_module['top']) {
                    break;
                }
                if ($base_left < 0) {
                    $base_left = $item['left'];
                }
                if ($base_top < 0) {
                    $base_top = $item['top'];
                }
                $base_left = min($base_left, $item['left']);
                $base_top = min($base_top, $item['top']);
                $group[0][$id] = $item;
            }
            if ($base_left > -1) {
                $height = 0;
                foreach ($group[0] as &$item) {
                    $item['left'] -= $base_left;
                    $item['top'] -= $base_top;
                    $height = max($height, $item['top'] + $item['height']);
                }
                $group[0]['height'] = $height;
            }
            $group[] = $base_module;
            /*self::$filter_base = $base_module['top'];
            $bottom_tmp = array_filter($right_group, function($m) {
                return $m['top'] > self::$filter_base;
            });*/
            $bottom_tmp = array();
            foreach ($right_group as $glk => $g1) {
                if ($g1['top'] > $base_module['top']) {
                    $bottom_tmp[$glk] = $g1;
                }
            }

            if (!empty($bottom_tmp)) {
                $base_left = $base_top = -1;
                foreach ($bottom_tmp as $item2) {
                    if ($base_left < 0) {
                        $base_left = $item2['left'];
                    }
                    if ($base_top < 0) {
                        $base_top = $item2['top'];
                    }
                    $base_left = min($base_left, $item2['left']);
                    $base_top = min($base_top, $item2['top']);
                }
                $height = 0;
                foreach ($bottom_tmp as &$item2) {
                    $item2['left'] -= $base_left;
                    $item2['top'] -= $base_top;
                    $height = max($height, $item2['top'] + $item2['height']);
                }
                $bottom_tmp['height'] = $height;
                $group[] = $bottom_tmp;
                unset($bottom_tmp);
            }
            $ret = array(array(
                'group' => true,
                'width' => 1200,
                $left_group,
                $group
            ));
            return $ret;
        }
    }

    private function _count_height($modules) {
        $arr = array();//print_r($modules);print_r($arr);exit;
        foreach ($modules as $k => $module) {
            if (!empty($module['mid'])) {
                continue;
            }
            foreach ($module as $item) {
                if (!isset($arr[$k]['left'])) {
                    $arr[$k]['left'] = $item['left'];
                } else {
                    $arr[$k]['left'] = min($arr[$k]['left'], $item['left']);
                }
                if (!isset($arr[$k]['top'])) {
                    $arr[$k]['top'] = $item['top'];
                } else {
                    $arr[$k]['top'] = min($arr[$k]['top'], $item['top']);
                }
            }
        }
        foreach ($modules as $k => &$module) {
            if (!empty($module['mid'])) {
                continue;
            }
            $height = 0;
            foreach ($module as &$item) {
                $item['left'] -= $arr[$k]['left'];
                $item['top'] -= $arr[$k]['top'];
                $height = max($height, $item['top'] + $item['height']);
            }
            $module['height'] = $height;
        }
        //print_r($modules);exit;
        return $modules;
    }

    private function _single_row($modules) {
        return $modules;
        /*$auto_height_modules = array_filter($modules, function($m) {
           return $m['mid'] == 7;
        });
        if (empty($auto_height_modules)) {
            return $modules;
        }
        print_r($modules);exit;*/
    }

    /**
     * 返回三列模式课程列表
     */
    public function ajax_courseware_three() {
        $pid = intval($this->input->get('pid'));
        $sid = intval($this->input->get('sid'));
        $model = $this->model('portfolio');

        $data = $model->getServicePackWhole($this->room['crid'], $this->user['uid'], $this->user['groupid'],
            'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_243_144.jpg',
            !empty($this->room['iscollege']),
            $this->room['domain'],
            $pid, $sid, false);
        $group_big = array();
        $group_normal = array();
        $group_small = array();
        $rows = 0;
        foreach ($data['items'] as $id => $course) {
            if ($course['view_mode'] == 2) {
                $group_big[$rows++] = $course;
                continue;
            }
            if ($course['view_mode'] == 0) {
                $last_group = end($group_normal);
                if ($last_group === false || count($last_group) % 3 == 0) {
                    $group_normal[$rows++] = array($course);
                    continue;
                }
                $k = key($group_normal);
                $group_normal[$k][] = $course;
                continue;
            }
            if ($course['view_mode'] == 1) {
                $last_group = end($group_small);
                if ($last_group === false || count($last_group) % 2 == 0) {
                    $group_small[$rows++] = array($course);
                    continue;
                }
                $k = key($group_small);
                $group_small[$k][] = $course;
                continue;
            }
        }
        $normal_rows = 0;
        $other_rows = 0;
        for ($i = 0; $i < $rows; $i++) {
            if ($normal_rows < 3 && $normal_rows + $other_rows >=5 || $normal_rows > 2 && $normal_rows + $other_rows >= 5) {
                $data['more'] = true;
                break;
            }
            if (key_exists($i, $group_big)) {
                $tmp[] = array('view_mode' => 2, 'data' => array($group_big[$i]));
                $other_rows++;
                continue;
            }
            if (key_exists($i, $group_normal)) {
                $tmp[] = array('view_mode' => 0, 'data' => $group_normal[$i]);
                $normal_rows++;
                continue;
            }
            if (key_exists($i, $group_small)) {
                $tmp[] = array('view_mode' => 1, 'data' => $group_small[$i]);
                $other_rows++;
                continue;
            }
        }
        $data['group'] = $tmp;
        //unset($data['items']);
        $this->assign('varpool', array('data' => $data, 'ajax' => 1));
        $this->display('shop/plate/portfolio-courselist/courselist-3');
    }
    /**
     * 返回四列模式课程列表
     */
    public function ajax_courseware_four() {
        $pid = intval($this->input->get('pid'));
        $sid = intval($this->input->get('sid'));
        $model = $this->model('portfolio');
        $data = $model->getServicePackWhole($this->room['crid'], $this->user['uid'], $this->user['groupid'],
            'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_243_144.jpg',
            !empty($this->room['iscollege']),
            $this->room['domain'],
            $pid, $sid, false);
        if (!empty($data['items']) && count($data['items']) > 8) {
            $data['items'] = array_slice($data['items'], 0, 8);
            $data['more'] = true;
        }
        $this->assign('varpool', array('data' => $data, 'ajax' => 1));
        $this->display('shop/plate/portfolio-courselist/courselist-4');
    }

    /**
     * 加载模块内容
     */
    public function index() {
        if (empty($this->user)) {
            //未登录
            echo '';
            exit();
        }
        //sleep(3);
        $room_cache = Ebh::app()->lib('Roomcache');
        $mid = intval($this->input->get('mid'));
        $model = $this->model('portfolio');
        if ($mid == 0) {
            $course_menus = $model->getCourseMenu($this->room['crid']);
            $this->assign('course_menus', $course_menus);
            $this->assign('setting', true);
            $this->display('shop/plate/portfolio-courses-menu');
            return;
        }
        $columns = intval($this->input->get('columns'));
        $rows = intval($this->input->get('rows'));
        if ($mid < 1 || $columns < 1) {
            return;
        }
        $rows = max(1, $rows);
        $eid = intval($this->input->get('eid'));
        $module = $model->getModule($mid, $columns, $rows);
        if (empty($module)) {
            return;
        }
        $this->assign('setting', true);
        //页头
        if ($mid == 1) {
            $data = array();
            if ($eid > 0) {
                $bgcolor = $model->getBackGroundColor($this->room['crid'], $mid);
                $data['custom_data']['bgcolor'] = $bgcolor;

                $options = $model->getSingleModuleCustomData($this->room['crid'], $mid);
                if (!empty($options[0]['image'])) {
                    $data['custom_data']['options'][0]['image'] = show_plate_img($options[0]['image']);
                }
            }
            $this->assign('varpool', $data);
            $this->display('shop/plate/portfolio-logo');
            return;
        }
        //选项卡
        if ($mid == 2) {
            $cache_set = $this->cache_time[$module['code']];
            $navigatordata = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
            if (empty($navigatordata)) {
                $tourl = null;
                $navigatordata = $model->getNavigator($this->room['crid'], $tourl);
                $room_cache->setCache($this->room['crid'],
                    $cache_set['module'],
                    $cache_set['param'],
                    $navigatordata,
                    $cache_set['expire'],
                    $cache_set['needupdate']);
            }
            if (!empty($navigatordata)) {
                $navigatordata = array_filter($navigatordata, function($nav) {
                    if ($nav['code'] == 'news') {
                        return false;
                    }
                    return true;
                });
            }
            $module['menu'] = $navigatordata;

            $this->assign('varpool', array('menu' => $navigatordata));
            $this->display('shop/plate/portfolio-navigation');
            unset($navigatordata);
            return;
        }
        //轮播大图
        if ($mid == 3) {
            if ($eid > 0) {
                $module['custom_data']['bgcolor'] = $model->getBackGroundColor($this->room['crid'], $mid);
                $module['custom_data']['options'] = $model->getSingleModuleCustomData($this->room['crid'], $mid);
                if (!empty($module['custom_data']['options'])) {
                    $module['custom_data']['options'] = array_map(function($e) {
                        $e['image'] = show_plate_img($e['image']);
                        return $e;
                    }, $module['custom_data']['options']);
                }
            }
			$module['room_type'] = Ebh::app()->room->getRoomType();

            $this->assign('varpool', $module);
            $this->display('shop/plate/portfolio-slide');


            return;
        }
        //滚动通知
        if ($mid == 4) {
            $cache_set = $this->cache_time[$module['code']];
            $notice = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
            if (empty($notice)) {
                $notice = $model->getNoticeList($this->room['crid'], 3);
                $room_cache->setCache($this->room['crid'],
                    $cache_set['module'],
                    $cache_set['param'],
                    $notice,
                    $cache_set['expire'],
                    $cache_set['needupdate']);
            }
            $this->assign('varpool', array('data' => $notice));
            $this->display('shop/plate/portfolio-notice');
            return;
        }
        //网校简介
        if ($mid == 5) {
            $this->assign('varpool', array('data' => $this->room, 'viewholder' => $this->viewholder, 'room_type' => Ebh::app()->room->getRoomType()));
            $this->display(sprintf('shop/plate/portfolio-%s/%s-1-%d', $module['code'], $module['code'], $columns));
            return;
        }
        //用户登录
        if ($mid == 6) {
            $this->display(sprintf('shop/plate/portfolio-%s/%s-1-%d', $module['code'], $module['code'], $columns));
            return;
        }
        //免费试听
        if ($mid == 7) {
            $data = $model->getFreeList($this->room['crid']);
            $this->assign('varpool', array('data' => $data));
            $this->display(sprintf('shop/plate/portfolio-%s/%s-%d', $module['code'], $module['code'], $columns));
            return;
        }
        //新闻资讯
        if ($mid == 8) {
            $cache_set = $this->cache_time[$module['code']];
            $news = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
            if (empty($news)) {
                $news = $model->getNewsList($this->room['crid'], 6);
                $room_cache->setCache($this->room['crid'],
                    $cache_set['module'],
                    $cache_set['param'],
                    $news,
                    $cache_set['expire'],
                    $cache_set['needupdate']);
            }
            $this->assign('varpool', array('data'=> $news, 'viewholder' => $this->viewholder));
            $this->display(sprintf('shop/plate/portfolio-%s/%s-1-%d', $module['code'], $module['code'], $columns));
            return;
        }
        //轮播广告
        if ($mid == 9) {
            $data = array();
            if ($eid > 0) {
                $data = $model->getMulModuleCustomData($this->room['crid'], $eid);
                if (!empty($data)) {
                    $data = array_map(function($e) {
                        $e['image'] = show_plate_img($e['image']);
                        return $e;
                    }, $data);
                }
            }
            $this->assign('varpool', array('custom_data' => array('options'=>$data)));
            $this->display(sprintf('shop/plate/portfolio-%s/%s-1-%d', $module['code'], $module['code'], $columns));
            return;
        }
        //调查问卷
        if ($mid == 10) {
            $cache_set = $this->cache_time[$module['code']];
            $curs = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
            if (empty($curs)) {
                $curs = $model->getSurveyList($this->room['crid'], 6, true);
                $room_cache->setCache($this->room['crid'],
                    $cache_set['module'],
                    $cache_set['param'],
                    $curs,
                    $cache_set['expire'],
                    $cache_set['needupdate']);
            }
            $this->assign('varpool', array('data'=> $curs, 'viewholder' => $this->viewholder));
            $this->display(sprintf('shop/plate/portfolio-%s/%s-1-%d', $module['code'], $module['code'], $columns));
            return;
        }
        //课程列表
        if ($mid == 11) {
            $uid = !empty($this->user) ? $this->user['uid'] : 0;

            $plateModel = $this->model('plate');
            $packages = $plateModel->payPackageMenu($this->room['crid'], 0, null, true);
            if (empty($packages)) {
                return;
            }
            $courselist['surveyid'] = false;
            $courselist['pid'] = 0;
            list($k, $v) = each($packages);
            $itemFilters = array();
            if ($v['displayorder'] != -1) {
                $courselist['pid'] = $v['pid'];
                $courselist['sorts'] = $plateModel->paySortMenu($v['pid'], true);
                $itemFilters['pid'] = $v['pid'];
            }
            $courselist['packages'] = $packages;


            $items = $plateModel->payItemList($this->room['crid'], $itemFilters);

            $courselist['isalumni'] = false;
            $courselist['userpermisions'] = false;

            $this->_pageItem($items, $courselist['isalumni']);
            if ($columns == 4) {
                if ($v['displayorder'] != -1) {
                    $courselist['items'] = $items;
                    if (count($items) > 80) {
                        $courselist['items'] = array_slice($items, 0, 80);
                    }
                } else {
                    //服务包定位全部
                    $courselist['group_by_package'] = true;
                    foreach ($items as $gitem) {
                        if (!isset($courselist['packages'][$gitem['pid']])) {
                            continue;
                        }
                        $courselist['packages'][$gitem['pid']]['items'][] = $gitem;
                    }
                }

            } else {
                if (!empty($courselist['packages'])) {
                    if ($v['displayorder'] == -1 && !empty($items)) {
                        //服务包定位全部
                        $courselist['group_by_package'] = true;
                        foreach ($items as $gitem) {
                            if (!isset($courselist['packages'][$gitem['pid']])) {
                                continue;
                            }
                            $courselist['packages'][$gitem['pid']]['items'][] = $gitem;
                        }
                    } else {
                        $group_big = array();
                        $group_normal = array();
                        $group_small = array();
                        $rows = 0;
                        if (!empty($items)) {
                            foreach ($items as $id => $course) {
                                if ($course['view_mode'] == 2) {
                                    $group_big[$rows++] = $course;
                                    continue;
                                }
                                if ($course['view_mode'] == 0) {
                                    $last_group = end($group_normal);
                                    if ($last_group === false || count($last_group) % 3 == 0) {
                                        $group_normal[$rows++] = array($course);
                                        continue;
                                    }
                                    $k = key($group_normal);
                                    $group_normal[$k][] = $course;
                                    continue;
                                }
                                if ($course['view_mode'] == 1) {
                                    $last_group = end($group_small);
                                    if ($last_group === false || count($last_group) % 2 == 0) {
                                        $group_small[$rows++] = array($course);
                                        continue;
                                    }
                                    $k = key($group_small);
                                    $group_small[$k][] = $course;
                                    continue;
                                }
                            }
                        }
                        $normal_rows = 0;
                        $other_rows = 0;
                        for ($i = 0; $i < $rows; $i++) {
                            /*if ($normal_rows < 3 && $normal_rows + $other_rows >=5 || $normal_rows > 2 && $normal_rows + $other_rows >= 5) {
                                $courselist['more'] = true;
                                break;
                            }*/
                            if ($normal_rows + $other_rows >= 20) {
                                $courselist['more'] = true;
                                break;
                            }
                            if (key_exists($i, $group_big)) {
                                $tmp[] = array('view_mode' => 2, 'data' => array($group_big[$i]));
                                $other_rows++;
                                continue;
                            }
                            if (key_exists($i, $group_normal)) {
                                $tmp[] = array('view_mode' => 0, 'data' => $group_normal[$i]);
                                $normal_rows++;
                                continue;
                            }
                            if (key_exists($i, $group_small)) {
                                $tmp[] = array('view_mode' => 1, 'data' => $group_small[$i]);
                                $other_rows++;
                                continue;
                            }
                        }
                        if (!empty($tmp)) {
                            $courselist['group'] = $tmp;
                        }
                        unset($module['data']['items']);
                    }
                }
            }
            $courselist['items'] = $items;
            //$module['data'] = $courselist;

            $this->assign('varpool', array('data' => $courselist, 'viewholder' => $this->viewholder, 'more' => $this->viewholder));
            $this->display(sprintf('shop/plate/portfolio-%s/%s-%d', $module['code'], $module['code'], $columns));
            return;
        }
        //应用
        if ($mid == 12) {
            $cache_set = $this->cache_time[$module['code']];
            $app = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
            if (empty($app)) {
                $app = $model->getAppList($this->room['crid'], 1);
            }
            if (!empty($app)) {
                $app = array_slice($app, 0, 6);
                $room_cache->getCache($this->room['crid'],
                    $cache_set['module'],
                    $cache_set['param'],
                    $cache_set['expire'],
                    $cache_set['needupdate']);
            }
            $this->assign('varpool', array('data' => $app, 'viewholder' => $this->viewholder));
            $this->display(sprintf('shop/plate/portfolio-%s/%s-1-%d', $module['code'], $module['code'], $columns));
            return;
        }
        //微信公众号
        if ($mid == 13) {
            $data = array();
            if ($eid > 0) {
                $options = $model->getSingleModuleCustomData($this->room['crid'], $mid);
                if (!empty($options[0]['image'])) {
                    $data['custom_data']['options'][0]['image'] = show_plate_img($options[0]['image']);
                } else {
                    $roommodel = $this->model('classroom');
                    $roomdetail  = $roommodel->getclassroomdetail($this->room['crid']);
                    $data['custom_data']['options'][0]['image'] = show_plate_img($roomdetail['wechatimg']);
                }
            }

            $this->assign('varpool', $data);
            $this->display(sprintf('shop/plate/portfolio-%s/%s-1-%d', $module['code'], $module['code'], $columns));
            return;
        }
        //积分排名
        if ($mid == 14) {
            $cache_set = $this->cache_time[$module['code']];
            $rank = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
            if (empty($rank)) {
                $rank = $model->getRankList($this->room['crid'], 12 * $columns);
                $room_cache->setCache($this->room['crid'],
                    $cache_set['module'],
                    $cache_set['param'],
                    $rank,
                    $cache_set['expire'],
                    $cache_set['needupdate']);
            }
            $this->assign('varpool', array('data' => $rank, 'viewholder' => $this->viewholder));
            $this->display(sprintf('shop/plate/portfolio-%s/%s-1-%d', $module['code'], $module['code'], $columns));
            return;
        }
        //最新报名
        if ($mid == 15) {
            $cache_set = $this->cache_time[$module['code']];
            $latest = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
            if (empty($latest)) {
                $latest = $model->getLatestReportList($this->room['crid'], 20);
                $room_cache->setCache($this->room['crid'],
                    $cache_set['module'],
                    $cache_set['param'],
                    $latest,
                    $cache_set['expire'],
                    $cache_set['needupdate']);
            }
            if (!empty($latest)) {
                $latest = array_slice($latest, 0, 3 * $columns);
            }
            $this->assign('varpool', array('data' => $latest, 'viewholder' => $this->viewholder));
            $this->display(sprintf('shop/plate/portfolio-%s/%s-1-%d', $module['code'], $module['code'], $columns));
            return;
        }
        //学员动态
        if ($mid == 16) {
            $cache_set = $this->cache_time[$module['code']];
            $dy = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
            if (empty($dy)) {
                $dy = $model->getDynamicList($this->room['crid'], 8);
            }
            if (!empty($dy)) {
                $dy = array_slice($dy, 0, 3 * $columns);
                $room_cache->setCache($this->room['crid'],
                    $cache_set['module'],
                    $cache_set['param'],
                    $dy,
                    $cache_set['expire'],
                    $cache_set['needupdate']);
            }
            $this->assign('varpool', array('data'=> $dy, 'viewholder' => $this->viewholder));
            $this->display(sprintf('shop/plate/portfolio-%s/%s-1-%d', $module['code'], $module['code'], $columns));
            return;
        }
        //获取用户名
        if ($mid == 17) {
            $this->display(sprintf('shop/plate/portfolio-%s/%s-1-%d', $module['code'], $module['code'], $columns));
            return;
        }
        //热门标签
        if ($mid == 18) {
            $data = array_slice(explode(',', $this->room['crlabel']), 0, 8);
            $this->assign('varpool', array('data'=>$data, 'viewholder' => $this->viewholder));
            $this->display(sprintf('shop/plate/portfolio-%s/%s-1-%d', $module['code'], $module['code'], $columns));
            return;
        }

        //课程排名
        if ($mid == 19) {
            $cache_set = $this->cache_time[$module['code']];
            $cr = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
            if (empty($cr)) {
                $cr = $model->getCourseRankList($this->room['crid'], 6);
            }
            if (!empty($cr)) {
                $cr = array_slice($cr, 0, 3 * $columns);
                $room_cache->setCache($this->room['crid'],
                    $cache_set['module'],
                    $cache_set['param'],
                    $cr,
                    $cache_set['expire'],
                    $cache_set['needupdate']);
            }
            $this->assign('varpool', array('data' => $cr, 'viewholder' => $this->viewholder));
            $this->display(sprintf('shop/plate/portfolio-%s/%s-1-%d', $module['code'], $module['code'], $columns));
            return;
        }
        //富文本
        if ($mid == 20) {
            if ($richtext = $model->getRichText($eid, $this->room['crid'])) {
                echo $richtext;
            }
            return;
        }
        //精品课件
        if ($mid == 21) {
            $data = array(
                'courses' => $model->getFolders($this->room['crid']),
                'finewares' => $model->getFineCoursewares($this->room['crid'], null, 20)
            );
            if (!empty($data['finewares'])) {
                $uid = array_column($data['finewares'], 'uid');
                $data['publishers'] = $model->getUsers($uid);
            }
            $this->assign('varpool', array('data'=> $data, 'viewholder' => $this->viewholder));
            $this->display(sprintf('shop/plate/portfolio-%s/%s-%d', $module['code'], $module['code'], $columns));
            return;
        }
		//名师团队
        if ($mid == 22) {
            $masters = $model->getMasterSimpleList($this->room['crid'], 0, true);
            $teachers = $model->getTeacherSimpleList($this->room['crid'], 0, true);

            if (!empty($masters) && !empty($teachers)) {
                $masterids = array_keys($masters);
                $masterids = array_flip($masterids);
                array_walk($teachers, function(&$teacher, $k, $masterids) {
                    if (isset($masterids[$k])) {
                        $teacher['isMaster'] = 1;
                    }
                }, $masterids);
            }
            $data = array(
                'teachers' => $teachers,
                'masters' => $masters
            );
            $this->assign('varpool', array('data' => $data, 'viewholder' => $this->viewholder));
            $this->display(sprintf('shop/plate/portfolio-%s/%s-%d', $module['code'], $module['code'], $columns));
            return;
        }
		//自选课程
		if ($mid == 23) {
            $data = $this->model('Plate')->getManualCourses($this->room['crid'], 0);
            $this->assign('varpool', array('data'=> $data, 'viewholder' => $this->viewholder));
			$this->display('shop/plate/portfolio-'.$module['code'].'/'.$module['code'].'-'.$columns);
		}
		//课程导航
        if ($mid == 24) {
            $data = array();
            $data['packages'] = $this->model('Plate')->payPackageMenu($this->room['crid'], 0, null, true);
            $pid = 0;
            if (!empty($data['packages'])) {
                $localed = array_filter($data['packages'], function($p) {
                   return $p['located'] == 1;
                });
                if (!empty($localed)) {
                    $localed_package = reset($localed);
                    $pid = $localed_package['pid'];
                } else {
                    $first_package = reset($data['packages']);
                    if ($first_package['displayorder'] > -1) {
                        $pid = $first_package['pid'];
                    }
                }
            }
            $pids = array_keys($data['packages']);
            $sorts = $this->model('Plate')->paySortMenu($pids, true);
            if (!empty($sorts)) {
                $gsorts = array();
                foreach ($sorts as $sid => $sort) {
                    $gsorts[$sort['pid']][$sid] = $sort;
                    if (empty($gsorts[$sort['pid']][0]) && count($gsorts[$sort['pid']]) > 1) {
                        array_unshift($gsorts[$sort['pid']], array(
                            'pid' => $sort['pid'],
                            'sid' => 0,
                            'sname' => '全部'
                        ));
                    }
                }
                $data['sorts'] = $gsorts;
            }
            $data['pid'] = $pid;
            $this->assign('varpool', array('data'=> $data, 'viewholder' => $this->viewholder));
            $this->display('shop/plate/portfolio-'.$module['code'].'/'.$module['code'].'-'.$columns);
        }
        //课程包
        if ($mid == 25) {
            $api = Ebh::app()->getApiServer('ebh');
            $bundles = $api->reSetting()
                ->setService('CourseService.Bundle.index')
                ->addParams('crid', $this->room['crid'])
                ->addParams('display', 1)
                ->request();
            if (!empty($bundles)) {
                foreach ($bundles['list'] as $k => $v) {
                    if (empty($v['cover'])) {
                        $bundles['list'][$k]['cover'] = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_243_144.jpg';
                    }
                }
            }
            $this->assign('varpool', $bundles);
            $this->display('shop/plate/portfolio-'.$module['code'].'/'.$module['code'].'-'.$columns);
        }
    }

    /**
     * 获取单个模块默认配置
     */
    public function getModuleSet() {
        if (empty($this->user)) {
            echo json_encode(array(
                'errno' => 10,
                'msg' => '未登录'
            ));
            exit();
        }
        $mid = intval($this->input->get('mid'));
        if ($mid < 1) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '模块不存在'
            ));
            exit();
        }
        $model = $this->model('portfolio');
        $columns = intval($this->input->get('columns'));
        $module = $model->getModuleSet($mid, $columns);
        if (empty($module)) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '模块不存在'
            ));
            exit();
        }

        echo json_encode($module);
    }

    /**
     * 加载首页模板配置
     */
    public function config() {
        if (empty($this->user)) {
            echo json_encode(array());
            exit();
        }

        $model = $this->model('portfolio');
        $tmpid = intval($this->input->get('tmpid'));

        $upconfig = Ebh::app()->getConfig()->load('upconfig');
        $baseurl = $upconfig['hmodule']['showpath'];
		$room_type = Ebh::app()->room->getRoomType();
		$room_type = $room_type == 'com' ? 1 : 0;
        if ($tmpid == 2) {
            //恢复默认
            $modules = $model->getPortfolioConfig(0, $room_type, true);
            echo json_encode($modules, true);
            exit();
        }
        if ($modules = $model->getPortfolioConfig($this->room['crid'], $room_type, true)) {
            foreach ($modules as $index => $module) {
                if ($module['mid'] == 21) {
                    //临时将精品课件模块强制４列
                    if ($module['ititle'] == '精品课件') {
                        $modules[$index]['ititle'] = '单课列表';
                    }
                    if ($module['ctitle'] == '精品课件') {
                        $modules[$index]['ctitle'] = '单课列表';
                    }
                    $modules[$index]['area_sign'] = array(4);
                }
            }
            $top = array_column($modules, 'top');
            $left = array_column($modules, 'left');
            array_multisort($top, SORT_ASC, SORT_NUMERIC,$left, SORT_ASC, SORT_NUMERIC, $modules);
            echo json_encode($modules, true);
            exit();
        }
    }

    /**
     * 保存首页模板配置
     */
    public function save_config() {
        if (empty($this->user)) {
            echo json_encode(array(
                'errno' => 10,
                'msg' => '未登录'
            ));
            exit();
        }
        $upconfig = Ebh::app()->getConfig()->load('upconfig');
        $baseurl = $upconfig['hmodule']['showpath'];
        $model = $this->model('portfolio');
        $post_data = file_get_contents('php://input');

        $arr = json_decode($post_data, true);
        $category = Ebh::app()->room->getRoomType();
        //print_r($arr);exit;
        //$arr = json_decode('[{"eid":"98","mid":"1","ititle":"页头","columns":"4","rows":"1","max_data_count":"1","left":0,"top":0,"width":"1200","height":"140","background_color":"#e58888","code":"logo","show_type":"1","editable":"1","area_sign":[4],"custom_data":{"bgcolor":"#e58888","options":[{"image":"2016/11/13/14790011181964.jpg","href":"","zindex":"0"}]},"ctitle":"页头"},{"eid":"99","mid":"2","ititle":"选项卡","columns":"4","rows":"1","max_data_count":"0","left":0,"top":150.1666717529297,"width":"0","height":"0","background_color":"","code":"navigation","show_type":"1","editable":"0","area_sign":[4],"ctitle":"选项卡"},{"eid":"96","mid":"3","ititle":"轮播大图","columns":"4","rows":"1","max_data_count":"0","left":0,"top":200.21665954589844,"width":"0","height":"0","background_color":"#0a96ed","code":"slide","show_type":"1","editable":"1","area_sign":[4],"custom_data":{"bgcolor":"#0a96ed","options":[{"image":"2016/11/13/14790055609132.jpg","href":"","zindex":"0"},{"image":"2016/11/13/14790055632490.jpg","href":"","zindex":"1"}]},"ctitle":"轮播大图"},{"eid":"94","mid":"9","ititle":"轮播广告","columns":2,"rows":1,"max_data_count":"0","left":0,"top":0,"width":610,"height":330,"background_color":"","code":"ad","show_type":"2","editable":"1","area_sign":[3,2,1],"custom_data":[],"ctitle":"轮播广告","index":"0"},{"eid":"95","mid":"9","ititle":"轮播广告","columns":1,"rows":1,"max_data_count":"0","left":610,"top":0,"width":305,"height":330,"background_color":"","code":"ad","show_type":"2","editable":"1","area_sign":[3,2,1],"custom_data":{"bgcolor":"","options":[{"image":"2016/11/13/14790111727392.jpg","href":"","zindex":"0"},{"image":"2016/11/13/14790111785272.jpg","href":"","zindex":"1"}],"del":1},"ctitle":"轮播广告","index":"1"},{"eid":"97","mid":"13","ititle":"微信公众号","columns":1,"rows":1,"max_data_count":"0","left":915,"top":0,"width":305,"height":330,"background_color":"","code":"official","show_type":"2","editable":"1","area_sign":[1],"custom_data":[],"ctitle":"微信公众号"},{"eid":"93","mid":"9","ititle":"轮播广告","columns":3,"rows":1,"max_data_count":"0","left":0,"top":330,"width":915,"height":330,"background_color":"","code":"ad","show_type":"2","editable":"1","area_sign":[3,2,1],"custom_data":[],"ctitle":"轮播广告","index":"2"}]', true);
		$manued = $model->checkManued($this->room['crid'], $category == 'com' ? 1 : 0);
		if (!$manued && !empty($arr)) {
			array_walk($arr, function(&$m, $k) {
				$m['seid'] = $m['eid'];
				$m['eid'] = 0;
			});
		}
		$room_type = Ebh::app()->room->getRoomType();
		//print_r($arr);exit;
        $r = $model->savePortfolioConfig($this->room['crid'], $room_type, $arr, $baseurl);
        if ($r === false) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '保存失败'
            ));
            exit();
        }
        $has_fineware = false;
        foreach ($arr as $arr_item) {
            if ($arr_item['code'] == 'fineware') {
                $has_fineware = true;
                break;
            }
        }
        $room_model = $this->model('Classroom');
        $navigator_sourse = $room_model->getNavigator($this->room['crid']);
        $navigator = unserialize($navigator_sourse);
        if (!empty($navigator['navarr'])) {
            $fineware_index = -1;
            foreach ($navigator['navarr'] as $index => $it) {
                if ($it['code'] == 'fineware') {
                    $fineware_index = $index;
                    break;
                }
            }
            if (!$has_fineware) {
                if ($fineware_index > -1) {
                    $navigator['navarr'][$fineware_index]['available'] = 0;
                }
            } else {
                if ($fineware_index > -1) {
                    $navigator['navarr'][$fineware_index]['available'] = 1;
                } else {
                    $tmp = array();
                    $inserted = false;
                    $roomnav = Ebh::app()->getConfig()->load('roomnav');
                    if (!empty($roomnav['fineware'])) {
                        $fineware_nav = array(
                            'name' => $roomnav['fineware']['name'],
                            'code' => $roomnav['fineware']['code'],
                            'nickname' => $roomnav['fineware']['name'],
                            'available' => 1
                        );
                    } else {
                        $fineware_nav = array(
                            'name' => '单课列表',
                            'code' => 'fineware',
                            'nickname' => '单课列表',
                            'available' => 1
                        );
                    }

                    foreach ($navigator['navarr'] as $item) {
                        $tmp[] = $item;
                        if ($item['code'] == 'platform') {
                            $tmp[] = $fineware_nav;
                            $inserted = true;
                        }
                    }
                    if (!$inserted) {
                        $tmp[] = $fineware_nav;
                    }
                    $navigator['navarr'] = $tmp;
                }
            }
            $up_param = array();
            $up_param['crid'] = $this->room['crid'];
            $up_param['navigator'] = serialize($navigator);
            //重置网校类型
            /*$up_param['isdesign'] = 0;
            if(mb_strlen($up_param['navigator'],'UTF-8') <= 5000){
                $res = $room_model->editclassroom($up_param);
                if ($res) {
                    $roomcache = Ebh::app()->lib('Roomcache');
                    $roomcache->removeCache($this->room['crid'],'navigator','plate-navigation');
                    //更新导航成功后刷新导航相关缓存
                    updateRoomCache($this->room['crid'], 'navigator');

                    //清空网校缓存
                    $roomcache = Ebh::app()->lib('Roomcache');
                    $roomcache->removeCache(0,'roominfo',$this->room['domain']);
                }
            }*/
        }
        //保存成功后清除缓存
        $room_cache = Ebh::app()->lib('Roomcache');
        foreach ($this->cache_time as $cache_item) {
            if (empty($cache_item['param'])) {
                continue;
            }
            $room_cache->removeCache($this->room['crid'], $cache_item['module'], $cache_item['param']);
        }

        echo  json_encode($r);
        //保存装扮操作成功后记录到操作日志
        fastcgi_finish_request();
        //获取原首页装扮信息
        if (!empty($this->room['crid'])) {
            $logdata = array();
            $logdata['toid'] = $this->room['crid'];
            $logdata['title'] = '老版首页装扮';
            $logdata['clientType'] = '电脑';
            Ebh::app()->lib('OperationLog')->addLog($logdata,'savedesign');
        }
        exit();
    }

    /**
     * 自定义模板
     */
    public function custportal() {
        if (empty($this->user) || $this->room['uid'] != $this->user['uid']) {
            header('location:/login.html?returnurl='.$_SERVER['REQUEST_URI']);
            exit();
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $roommodel = $this->model('classroom');
        $roomdetail = $roommodel->getclassroomdetail($roominfo['crid']);
        $this->assign('roomdetail',$roomdetail);
        $this->display('shop/plate/portfolio-edit');
    }

    /**
     * 课件详情
     * @param $itemid
     */
    public function courseinfo() {
        $pos = $this->input->get('pos');
        if ($pos === null) {
            $pos = 1;
        } else {
            $pos = (int) $pos;
        }
        $itemid = $this->uri->itemid;
        //读取模块
        $model = $this->model('portfolio');
        $pay_item = $model->getSinglePayItem($this->room['crid'], $itemid);
        $system_info = $this->model('Systemsetting')->getSetting($this->room['crid']);
        $enabled = true;
        if (!empty($this->user) && $this->user['groupid'] == 6 && !empty($system_info['isbanbuy'])) {
            //判断是否本校学生
            $isStudent = $model->isAlumni($this->room['crid'], $this->user['uid']);
            $enabled = $isStudent;
        }
        if (!$enabled) {
            $pay_item['cannotpay'] = true;
        }
/*         if (empty($pay_item)) {
            header('Location:/');
            exit();
        } */
        $upconfig = Ebh::app()->getConfig()->load('upconfig');
        $baseurl = $upconfig['hmodule']['showpath'];
        $room_type = Ebh::app()->room->getRoomType();
        $modules = $model->getPortfolioConfig($this->room['crid'], $room_type == 'com' ? 1 : 0);
        $qcode_module = array_filter($modules, function($item) {
            return $item['mid'] == 13;
        });
        if (!empty($qcode_module)) {
            $qcode_module = current($qcode_module);
            if (!empty($qcode_module['custom_data']['options'][0]['image'])) {
                $global_qcode = show_plate_img($qcode_module['custom_data']['options'][0]['image']);
                $this->assign('global_qcode', $global_qcode);
            }
            if (empty($global_qcode)) {
                $roommodel = $this->model('classroom');
                $roomdetail  = $roommodel->getclassroomdetail($this->room['crid']);
                $global_qcode = $roomdetail['wechatimg'];
                $this->assign('global_qcode', $global_qcode);
            }
        }

        if (!empty($this->user)) {
            $folderid = $pay_item['folderid'];
            if (!empty($pay_item['group_members'])) {
                $folderid = array_keys($pay_item['group_members']);
            }
            $userpermisions = array();
            if ($this->user['groupid'] == 6) {
                $userpermisions = $model->getUserpermisions($this->user['uid'], $folderid, $this->room['crid']);
            }
            $pay_item['url'] = $this->format_pay_item_url($pay_item, $userpermisions);
        } else {
            $pay_item['url'] = false;
        }
        if (!empty($pay_item['cannotpay'])) {
            $pay_item['sign_status'] =  $this->sign_status(null);
        } else {
            $pay_item['sign_status'] =  $this->sign_status($pay_item['url']);
        }
		
				
		//课程设置了限制报名时,查询开通人数
		if(!empty($pay_item['islimit']) && $pay_item['limitnum']>0){
			$openlimit = Ebh::app()->lib('OpenLimit');
			$openstatus = $openlimit->checkStatus($pay_item);
			
			if(!$openstatus && empty($pay_item['allow'])){//状态设置为无法报名
				$pay_item['sign_status'] =  $this->sign_status(null);
			}
		}

        $inner_data = array();
        if (empty($pay_item['showimg'])) {
            $pay_item['showimg'] = 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/course_cover_default.png';
        }
        $pay_item['showimg'] = str_replace('folderimg/', 'folderimgs/', $pay_item['showimg']);
        $room_cache = Ebh::app()->lib('Roomcache');
        $cache_set = $this->cache_time['latestreport'];
        $latest = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
        if (empty($latest)) {
            $latest = $model->getLatestReportList($this->room['crid'], 20);
            $room_cache->setCache($this->room['crid'],
                $cache_set['module'],
                $cache_set['param'],
                $latest,
                $cache_set['expire'],
                $cache_set['needupdate']);
        }
        if (!empty($latest)) {
            $inner_data['latest_sign'] = $latest;
        }
        $othersettings = array();
        if (isset($pay_item['othersettings']) && is_array($pay_item['othersettings'])) {
            $othersettings = array_filter($pay_item['othersettings'], function ($setting) {
                return !empty($setting['show']);
            });
        }
        if ($this->input->get('pos') === null) {
            $step = 0;
            foreach ($othersettings as $othersetting) {
                if (!empty($othersetting['cur'])) {
                    $pos = $step;
                    break;
                }
                $step++;
            }
        }

        $urls = array(
            'directory' => '/room/portfolio/course_directory.html',
            'summary' => '/room/portfolio/course_info.html',
            'teacher' => '/room/portfolio/course_teachers.html',
            'download' => '/room/portfolio/course_docs.html'
        );
        $inner_data['urls'] = json_encode(array_values(array_intersect_key($urls, $othersettings)));
        $cache_set = $this->cache_time['dynamic'];
        $dy = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
        if (empty($dy)) {
            $dy = $model->getDynamicList($this->room['crid'], 20);
            $room_cache->setCache($this->room['crid'],
                $cache_set['module'],
                $cache_set['param'],
                $dy,
                $cache_set['expire'],
                $cache_set['needupdate']);
        }
        if (!empty($dy)) {
            $inner_data['dynamic'] = array_slice($dy, 0, 8);
        }

        $cache_set = $this->cache_time['courserank'];
        $cr = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
        if (empty($cr)) {
            $cr = $model->getCourseRankList($this->room['crid'], 6);
            $room_cache->setCache($this->room['crid'],
                $cache_set['module'],
                $cache_set['param'],
                $cr,
                $cache_set['expire'],
                $cache_set['needupdate']);
        }
        if (!empty($cr)) {
            $inner_data['courselist'] = array_slice($cr, 0, 5);
        }
        $surveyid = $this->_need_survery($this->room['crid'], $this->user);
        if (!empty($surveyid)) {
            $inner_data['surveyid'] = $surveyid;
        }
        
        //判断课程是本网校的产生的还是企业选课来的
        $roominfo = Ebh::app()->room->getcurroom();
        //获取网校二维码
        $upconfig = Ebh::app()->getConfig()->load('upconfig');
        $qrcode = $upconfig['qrcode'];
        $baseurl =$qrcode['server'][0];
        $inner_data['baseurl'] = $baseurl;
        $inner_data['roominfo'] = $roominfo;
        
        //获取分销key
        $sharekey = $this->getsharekey($itemid,$roominfo['crid']);
        $inner_data['sharekey'] = $sharekey;
        $inner_data['userid'] = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        
        //获取网校分销key
        $schoolsharekey = $this->getsharekey(0, $roominfo['crid'],'school');
        //var_dump($schoolsharekey);die;
        
        $inner_data['schoolsharekey'] = $schoolsharekey;
        $inner_data['pay_item'] = $pay_item;
		$pay_item_iname = isset($pay_item['iname']) ? $pay_item['iname'] : '';
        $inner_data['title'] = empty($pay_item['foldername']) ? $pay_item_iname : $pay_item['foldername'];
        $inner_data['pos'] = $pos;
        $this->assign('inner_view', 'shop/plate/courseinfo');
        $this->assign('inner_data', $inner_data);
        $this->_template($model);
        //手机跳转页面
        if (is_mobile()) {
            $this->assign('roominfo',$roominfo);
            $this->display('shop/plate/portfolio_courseinfo_mobile');
            exit;
        }
        $this->display('shop/plate/portfolio');
    }

    /**
     * 获取分销key
     * 分销加密key组成方式
     * coursetype%itemid%folderid%crid%sourcecrid%providercrid%uid%ip%dateline
     */
    protected function getsharekey($itemid,$crid,$from='course'){
        $sharekey = Ebh::app()->runAction('room/share','getsharekey',array('itemid'=>$itemid,'crid'=>$crid,'from'=>$from));
        return $sharekey;
    }
    
    /**
     * 获取分享码key
     */
    public function getsharekeyajax(){
        Ebh::app()->runAction('room/share','getsharekeyajax');
    }
    /**
     * 打包分类详情
     * @param $sid
     */
    public function bundle_view() {
        $sortid = intval($this->uri->itemid);
        $model = $this->model('portfolio');
        $pay_sort = $model->getPaySortInto($sortid);
        if (empty($pay_sort)) {
            header('Location:/');
            exit();
        }
        $room_type = Ebh::app()->room->getRoomType();
        $modules = $model->getPortfolioConfig($this->room['crid'], $room_type == 'com' ? 1 : 0);
        $qcode_module = array_filter($modules, function($item) {
            return $item['mid'] == 13;
        });
        if (!empty($qcode_module)) {
            $qcode_module = current($qcode_module);
            if (!empty($qcode_module['custom_data']['options'][0]['image'])) {
                $global_qcode = show_plate_img($qcode_module['custom_data']['options'][0]['image']);
                $this->assign('global_qcode', $global_qcode);
            }
            if (empty($global_qcode)) {
                $roommodel = $this->model('classroom');
                $roomdetail  = $roommodel->getclassroomdetail($this->room['crid']);
                $global_qcode = $roomdetail['wechatimg'];
                $this->assign('global_qcode', $global_qcode);
            }
        }
        $pay_sort['summary'] = strip_tags($pay_sort['content']);
        $pay_sort['coursewarenum'] = 0;
        $pay_sort['viewnum'] = 0;
        $pay_sort['price'] = 0;
        $pay_sort['imonth'] = 0;
        $pay_sort['iday'] = 0;
        $pay_sort['hasPower'] = true;
        //$pay_items = $model->getPayItemsUnderSort($pay_sort['sid']);
        $api = Ebh::app()->getApiServer('ebh');
        $pay_items = $api->reSetting()
            ->setService('CourseService.Course.sortCourseList')
            ->addParams('sid', $sortid)
            ->addParams('crid', $this->room['crid'])
            ->addParams('uid', !empty($this->user) && $this->user['groupid'] == 6 ? $this->user['uid'] : 0)
            ->request();
        $viewnumlib = Ebh::app()->lib('Viewnum');
        if (!empty($pay_items)) {
            $isAlumni = !empty($this->user) && $this->user['groupid'] == 6 ? $model->isAlumni($this->room['crid'], $this->user['uid']) : false;
            $cannotpay = false;
            foreach ($pay_items as $pay_item) {
                $viewnum = $viewnumlib->getViewnum('folder', $pay_item['folderid']);
                $pay_sort['coursewarenum'] += $pay_item['coursewarenum'];
                $pay_sort['viewnum'] += empty($viewnum) ? $pay_item['viewnum'] : $viewnum;
                $pay_sort['imonth'] = max($pay_sort['imonth'], $pay_item['imonth']);
                $pay_sort['iday'] = max($pay_sort['iday'], $pay_item['iday']);
                if (!$isAlumni || empty($pay_item['isschoolfree'])) {
                    $pay_sort['price'] += $pay_item['iprice'];
                }
                /*if (empty($pay_sort['imgurl']) && !empty($pay_item['img'])) {
                    $pay_sort['imgurl'] = show_plate_resource(str_replace('_th', '', $pay_item['img']));
                }*/
                if (empty($pay_sort['itemid'])) {
                    $pay_sort['itemid'] = $pay_item['itemid'];
                    $pay_sort['folderid'] = $pay_item['folderid'];
                }
                if (!empty($pay_item['cannotpay'])) {
                    $cannotpay = true;
                }
                $pay_sort['hasPower'] = $pay_sort['hasPower'] && !empty($pay_item['hasPower']);
            }

            $system_info = $this->model('Systemsetting')->getSetting($this->room['crid']);
            $enabled = true;
            if (!empty($this->user) && $this->user['groupid'] == 6 && !empty($system_info['isbanbuy'])) {
                //判断是否本校学生
                $enabled = $isAlumni;
            }
            if (!$enabled) {
                $pay_sort['cannotpay'] = true;
            }
        }
        if (empty($pay_sort['imgurl'])) {
            $pay_sort['imgurl'] = 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/course_cover_default.png';
        }
        if (empty($this->user)) {
            $pay_sort['sign_status'] = $this->sign_status(false);
        } else if ($this->user['groupid'] == 5) {
            $pay_sort['sign_status'] = $this->sign_status('');
        } else if ($pay_sort['price'] == 0 && !$cannotpay) {
            $pay_sort['sign_status'] = $this->sign_status(0);
        } else if(!empty($pay_sort['hasPower'])) {
            $pay_sort['url'] = '/myroom.html?url=/myroom/college/study/cwlist/'.$pay_sort['folderid'].'.html';
        } else if(!empty($pay_sort['itemid'])){
            $pay_sort['url'] = "/ibuy.html?itemid={$pay_sort['itemid']}&sid={$pay_sort['sid']}";
        }
        $inner_data = array();
        $inner_data['pay_sort'] = $pay_sort;
        $inner_data['pay_items'] = $pay_items;
        $inner_data['title'] = $pay_sort['sname'];
        $inner_data['design'] = $this->room['isdesign'];
        $room_cache = Ebh::app()->lib('Roomcache');
        $cache_set = $this->cache_time['latestreport'];
        $latest = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
        if (empty($latest)) {
            $latest = $model->getLatestReportList($this->room['crid'], 20);
            $room_cache->setCache($this->room['crid'],
                $cache_set['module'],
                $cache_set['param'],
                $latest,
                $cache_set['expire'],
                $cache_set['needupdate']);
        }
        if (!empty($latest)) {
            $inner_data['latest_sign'] = $latest;
        }


        $cache_set = $this->cache_time['dynamic'];
        $dy = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
        if (empty($dy)) {
            $dy = $model->getDynamicList($this->room['crid'], 8);
            $room_cache->setCache($this->room['crid'],
                $cache_set['module'],
                $cache_set['param'],
                $dy,
                $cache_set['expire'],
                $cache_set['needupdate']);
        }
        if (!empty($dy)) {
            $inner_data['dynamic'] = array_slice($dy, 0, 8);
        }

        $cache_set = $this->cache_time['courserank'];
        $cr = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
        if (empty($cr)) {
            $cr = $model->getCourseRankList($this->room['crid'], 6);
            $room_cache->setCache($this->room['crid'],
                $cache_set['module'],
                $cache_set['param'],
                $cr,
                $cache_set['expire'],
                $cache_set['needupdate']);
        }
        if (!empty($cr)) {
            $inner_data['courselist'] = array_slice($cr, 0, 5);
        }
        $this->assign('inner_view', 'shop/plate/portfolio-bundle');
        $this->_template($model);
        $this->assign('inner_data', $inner_data);
        $this->display('shop/plate/portfolio');
    }

    /**
     * 课程包详情
     */
    public function tagged_view() {
        $bid = intval($this->uri->itemid);
        $uid = empty($this->user) || $this->user['uid'] == 5 ? 0 : $this->user['uid'];
        $api = Ebh::app()->getApiServer('ebh');
        $bundle = $api->reSetting()
            ->setService('CourseService.Bundle.detail')
            ->addParams('bid', $bid)
            ->addParams('crid', $this->room['crid'])
            ->addParams('uid', $uid)
            ->request();
        if (empty($bundle)) {
            header('Location:/');
            exit();
        }
        $system_info = $this->model('Systemsetting')->getSetting($this->room['crid']);
        $enabled = true;
        if (!empty($this->user) && $this->user['groupid'] == 6 && !empty($system_info['isbanbuy'])) {
            //判断是否本校学生
            $isStudent = $this->model('Portfolio')->isAlumni($this->room['crid'], $this->user['uid']);
            $enabled = $isStudent;
        }
        if (!$enabled) {
            $bundle['cannotpay'] = true;
        }
        //print_r($bundle);exit;
        $viewnumlib = Ebh::app()->lib('Viewnum');
        //从缓存中读取实时课程浏览数
        $bundle['viewnum'] = $bundle['coursewarenum'] = $bundle['imonth'] = $bundle['iday'] = 0;
        foreach ($bundle['courses'] as $k => $course) {
            $bundle['courses'][$k]['viewnum'] = $viewnumlib->getViewnum('folder', $course['folderid'], $course['viewnum']);
            $bundle['viewnum'] += $bundle['courses'][$k]['viewnum'];
            $bundle['coursewarenum'] += $course['coursewarenum'];
            $bundle['imonth'] = max($bundle['imonth'], $course['imonth']);
            $bundle['iday'] = max($bundle['iday'], $course['iday']);
            if (empty($course['img'])) {
                $bundle['courses'][$k]['img'] = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_247_147.jpg';
            }
        }
        if (!empty($bundle['hasPower'])) {
            $firstCourseKey = key($bundle['courses']);
            if (empty($this->room['iscollege'])) {
                $bundle['url'] = sprintf('/myroom/stusubject/%s.html', $bundle['courses'][$firstCourseKey]['folderid']);
            } else if ($bundle['courses'][$firstCourseKey]['showmode'] == 3) {
                $bundle['url'] = sprintf('/myroom/college/study/introduce/%s.html', $bundle['courses'][$firstCourseKey]['folderid']);
            } else {
                $bundle['url'] = sprintf('/myroom.html?url=/myroom/college/study/cwlist/%s.html', $bundle['courses'][$firstCourseKey]['folderid']);
            }
        } else {
            $bundle['url'] = '/ibuy.html?bid='.$bundle['bid'];
        }

        $surveyid = $module['data']['surveyid'] = $this->_need_survery($this->room['crid'], $this->user);


        $model = $this->model('portfolio');
        $room_type = Ebh::app()->room->getRoomType();
        $modules = $model->getPortfolioConfig($this->room['crid'], $room_type == 'com' ? 1 : 0);
        $qcode_module = array_filter($modules, function($item) {
            return $item['mid'] == 13;
        });
        if (!empty($qcode_module)) {
            $qcode_module = current($qcode_module);
            if (!empty($qcode_module['custom_data']['options'][0]['image'])) {
                $global_qcode = show_plate_img($qcode_module['custom_data']['options'][0]['image']);
                $this->assign('global_qcode', $global_qcode);
            }
            if (empty($global_qcode)) {
                $roommodel = $this->model('classroom');
                $roomdetail  = $roommodel->getclassroomdetail($this->room['crid']);
                $global_qcode = $roomdetail['wechatimg'];
                $this->assign('global_qcode', $global_qcode);
            }
        }

        if (empty($bundle['cover']) || strpos($bundle['cover'], '/ebh/tpl/default/images/folderimgs/course_cover_default') !== false) {
            $bundle['cover'] = 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/course_cover_default.png';
        } else {
            $bundle['cover'] = preg_replace_callback('/_\d+_\d+/', function($matches) {
                return '';
            }, $bundle['cover']);
        }
		//课程包设置了限制报名时,查询开通人数
		if(!empty($bundle['islimit']) && $bundle['limitnum']>0){
			$openlimit = Ebh::app()->lib('OpenLimit');
			$openstatus = $openlimit->checkStatus($bundle);
			
			if(!$openstatus && empty($bundle['hasPower'])){//状态设置为无法报名
				$bundle['url'] = NULL;
			}
		}
		
        $inner_data = array();
        $inner_data['bundle'] = $bundle;
        $inner_data['pay_items'] = null;
        $inner_data['title'] = $bundle['name'];
        $inner_data['user'] = $this->user;
        $inner_data['design'] = $this->room['isdesign'];
        $room_cache = Ebh::app()->lib('Roomcache');
        $cache_set = $this->cache_time['latestreport'];
        $latest = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
        if (empty($latest)) {
            $latest = $model->getLatestReportList($this->room['crid'], 20);
            $room_cache->setCache($this->room['crid'],
                $cache_set['module'],
                $cache_set['param'],
                $latest,
                $cache_set['expire'],
                $cache_set['needupdate']);
        }
        if (!empty($latest)) {
            $inner_data['latest_sign'] = $latest;
        }


        $cache_set = $this->cache_time['dynamic'];
        $dy = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
        if (empty($dy)) {
            $dy = $model->getDynamicList($this->room['crid'], 8);
            $room_cache->setCache($this->room['crid'],
                $cache_set['module'],
                $cache_set['param'],
                $dy,
                $cache_set['expire'],
                $cache_set['needupdate']);
        }
        if (!empty($dy)) {
            $inner_data['dynamic'] = array_slice($dy, 0, 8);
        }

        $cache_set = $this->cache_time['courserank'];
        $cr = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
        if (empty($cr)) {
            $cr = $model->getCourseRankList($this->room['crid'], 6);
            $room_cache->setCache($this->room['crid'],
                $cache_set['module'],
                $cache_set['param'],
                $cr,
                $cache_set['expire'],
                $cache_set['needupdate']);
        }
        if (!empty($cr)) {
            $inner_data['courselist'] = array_slice($cr, 0, 5);
            array_walk($inner_data['courselist'], function(&$c, $k, $lib) {
                $c['viewnum'] = $lib->getViewnum('folder', $c['folderid'], $c['viewnum']);
            }, $viewnumlib);
        }
        $this->assign('inner_view', 'shop/plate/portfolio-tagged');
        $this->_template($model);
        $this->assign('inner_data', $inner_data);//print_r($inner_data);exit;
        $this->display('shop/plate/portfolio');
    }

    /**
     * 课程包教师列表
     */
    public function ajax_teacherinfo() {
        $bid = intval($this->input->get('bid'));
        if ($bid < 1) {
            exit();
        }
        $api = Ebh::app()->getApiServer('ebh');
        $teachers = $api->reSetting()
            ->setService('CourseService.Bundle.teacherInfos')
            ->addParams('bid', $bid)
            ->addParams('crid', $this->room['crid'])
            ->request();
        if (!empty($teachers)) {
            $clconfig = Ebh::app()->getConfig()->load('creditlevel_t');
            array_walk($teachers, function(&$teacher, $k, $clconfig) {
                foreach ($clconfig as $item) {
                    if ($item['min'] <= $teacher['credit'] && $item['max'] >= $teacher['credit']) {
                        $teacher['level'] = $item['title'];
                        break;
                    }
                }
            }, $clconfig);
        }
        //print_r($teachers);exit;
        $this->assign('teachers', $teachers);
        $this->assign('pagestr', '');
        $this->display('shop/plate/course_info_teachers');
    }

    /**
     * @param $itemArr 服务项
     * @param bool $isStudent 是否本校学生
     * @param bool $showFree 是否只显示免费项
     * @param int $orderType 排序方式，0-最新,1-最热,1-价格从高到低,2-价格从低到高,null-默认
     */
    private function _pageItem(&$itemArr, $isStudent = false, $showFree = false, $orderType = null) {
		if (empty($itemArr)) {
			return;
		}
        foreach ($itemArr as $k => $item) {
            if ($item['showbysort'] != 1) {
                $itemArr[$k]['viewnum'] = $this->getViewnum('folder', $item['folderid'], $item['viewnum']);
                if ($isStudent && $item['isschoolfree']) {
                    $itemArr[$k]['iprice'] = 0;
                    $itemArr[$k]['fprice'] = 0;
                }
                unset($itemArr[$k]['content'], $itemArr[$k]['imgurl'], $itemArr[$k]['showaslongblock']);
                continue;
            }
            unset($itemArr[$k]);
            $sid = $item['sid'];
            if (!isset($group[$sid])) {
                $group[$sid] = $item;
                $group[$sid]['viewnum'] = $this->getViewnum('folder', $item['folderid'], $item['viewnum']);
                $group[$sid]['summary'] = $item['content'];
                $group[$sid]['view_mode'] = 0;
                if ($isStudent && $group[$sid]['isschoolfree']) {
                    $group[$sid]['iprice'] = 0;
                    $group[$sid]['fprice'] = 0;
                }
                if (!empty($group[$sid]['showaslongblock'])/* && !empty($group[$sid]['imgurl'])*/) {
                    $group[$sid]['iname'] = $group[$sid]['sname'];
                    $group[$sid]['img'] = $group[$sid]['imgurl'];
                }
                unset($group[$sid]['content'], $group[$sid]['showaslongblock'], $group[$sid]['imgurl']);
                continue;
            }
            $group[$sid]['speaker'] = ltrim($group[$sid]['speaker'] . ',' . $item['speaker']);
            $group[$sid]['coursewarenum'] += $item['coursewarenum'];
            $group[$sid]['viewnum'] += $this->getViewnum('folder', $item['folderid'], $item['viewnum']);
            $group[$sid]['fdisplayorder'] = min($group[$sid]['fdisplayorder'], $item['fdisplayorder']);
            $group[$sid]['pdisplayorder'] = min($group[$sid]['pdisplayorder'], $item['pdisplayorder']);
            $group[$sid]['itemid'] = min($group[$sid]['itemid'], $item['itemid']);
            if (!$isStudent || !$item['isschoolfree']) {
                $group[$sid]['iprice'] += $item['iprice'];
                $group[$sid]['fprice'] += $item['fprice'];
            }
            if (isset($item['grank'])) {
                $group[$sid]['grank'] = min($group[$sid]['grank'], $item['grank']);
            } else if (isset($item['prank'])) {
                $group[$sid]['prank'] = min($group[$sid]['prank'], $item['prank']);
            } else if (isset($item['srank'])) {
                $group[$sid]['srank'] = min($group[$sid]['srank'], $item['srank']);
            }
        }
        array_walk($itemArr, function(&$f) {
            if (empty($f['speaker'])) {
                return;
            }
            $speakers = explode(',', $f['speaker']);
            $speakers = array_unique($speakers);
            $f['speaker'] = implode(',', $speakers);
        });
        if (!empty($group)) {
            $itemArr = array_merge($itemArr, $group);
            unset($group);
        }

        if ($orderType === null) {
            $rankArr = array();
            $itemidArr = array();
            $first = reset($itemArr);
            foreach ($itemArr as $oitem) {
                if (isset($first['srank']) && isset($oitem['srank'])) {
                    $rankArr[] = $oitem['srank'];
                } else if (isset($first['prank']) && isset($oitem['prank'])) {
                    $rankArr[] = $oitem['prank'];
                } else if (isset($first['grank']) && isset($oitem['grank'])) {
                    $rankArr[] = $oitem['grank'];
                } else {
                    $rankArr[] = 4294967295;
                }

                $itemidArr[] = $oitem['itemid'];
            }
            array_multisort($rankArr, SORT_ASC, SORT_NUMERIC,
                $itemidArr, SORT_DESC, SORT_NUMERIC, $itemArr);
            return;
        }
        if ($showFree) {
            $itemArr = array_filter($itemArr, function($item) {
                return $item['iprice'] == 0;
            });
        }
        $itemidArr = array_column($itemArr, 'itemid');
        if ($orderType == 1) {
            $viewnumArr = array_column($itemArr, 'viewnum');
            array_multisort($viewnumArr, SORT_DESC, SORT_NUMERIC,
                $itemidArr, SORT_DESC, SORT_NUMERIC, $itemArr);
            return;
        }
        if ($orderType == 2) {
            $priceArr = array_column($itemArr, 'iprice');
            array_multisort($priceArr, SORT_DESC, SORT_NUMERIC,
                $itemidArr, SORT_DESC, SORT_NUMERIC, $itemArr);
            return;
        }
        if ($orderType == 3) {
            $priceArr = array_column($itemArr, 'iprice');
            array_multisort($priceArr, SORT_ASC, SORT_NUMERIC,
                $itemidArr, SORT_DESC, SORT_NUMERIC, $itemArr);
            return;
        }
        $first = reset($itemArr);
        $rankArr = array();
        foreach ($itemArr as $oitem) {
            if (isset($first['srank']) && isset($oitem['srank'])) {
                $rankArr[] = $oitem['srank'];
            } else if (isset($first['prank']) && isset($oitem['prank'])) {
                $rankArr[] = $oitem['prank'];
            } else if (isset($first['grank']) && isset($oitem['grank'])) {
                $rankArr[] = $oitem['grank'];
            } else {
                $rankArr[] = 4294967295;
            }
        }
        array_multisort($rankArr, SORT_ASC, SORT_NUMERIC, $itemidArr, SORT_DESC, SORT_NUMERIC, $itemArr);
    }

    /**
     * 选课中心
     */
    public function platform() {
        $isAjax = $this->input->get('ajax');
        if (is_mobile() && !$isAjax) {
            $this->getHeaderAndFooter();
            $this->display('shop/plate/platform_mobile');
            exit;
        }
        $filter_params = array(
            'crid' => $this->room['crid']
        );
        $pid = $this->input->get('pid');
        if (is_numeric($pid) && $pid > 0) {
            $filter_params['pid'] = intval($pid);
        }
        $sid = $this->input->get('sid');
        if (!empty($filter_params['pid']) && $sid !== null && is_numeric($sid)) {
            $filter_params['sid'] = max(0, intval($sid));
        }
        if (!empty($this->user) && $this->user['groupid'] == 6) {
            $filter_params['uid'] = $this->user['uid'];
        }
        $model = $this->model('portfolio');
        /*$tourl = '';
        $nav = $model->getNavigator($this->room['crid'], $tourl);
        $enabled = false;
        if (!empty($nav)) {
            foreach ($nav as $nitem) {
                if ($nitem['code'] == 'platform' && $nitem['available'] == 1) {
                    $enabled = true;
                    break;
                }
            }
        }
        if (!$enabled) {
            header('Location:/');
            exit();
        }*/
        $room_type = Ebh::app()->room->getRoomType();
        $modules = $model->getPortfolioConfig($this->room['crid'], $room_type == 'com' ? 1 : 0);
        if (!empty($modules)) {
            $qcode_module = array_filter($modules, function($item) {
                return $item['mid'] == 13;
            });
        }
        if (!empty($qcode_module)) {
            $qcode_module = current($qcode_module);
            if (!empty($qcode_module['custom_data']['options'][0]['image'])) {
                $global_qcode = show_plate_img($qcode_module['custom_data']['options'][0]['image']);
                $this->assign('global_qcode', $global_qcode);
            }
            if (empty($global_qcode)) {
                $roommodel = $this->model('classroom');
                $roomdetail  = $roommodel->getclassroomdetail($this->room['crid']);
                $global_qcode = $roomdetail['wechatimg'];
                $this->assign('global_qcode', $global_qcode);
            }
        }
        $upconfig = Ebh::app()->getConfig()->load('upconfig');
        $baseurl = $upconfig['hmodule']['showpath'];
        //读取模块
        $api = Ebh::app()->getApiServer('ebh');
        $appsetting = Ebh::app()->getConfig()->load('othersetting');
        $surveyid = $this->_need_survery($this->room['crid'], $this->user);
        $param = parsequery();
        $page = intval($this->input->get('page'));
        if (!empty($page)) {
            $param['page'] = $page;
        }
        $param['page'] = max(1, $param['page']);
        $param['pagesize'] = 20;
        $keyword = trim($this->input->get('q'));
        $params = array(
            'crid' => $this->room['crid'],
            'page' => $param['page'],
            'pagesize' => $param['pagesize'],
            'isfree' => $param['viewmode'],
            'ordertype' => $param['sortmode'],
            'uid' => !empty($this->user) && $this->user['groupid'] == 6 ? $this->user['uid'] : 0
        );
        if ($keyword != '') {
            $params['q'] = $keyword;
        }
        $pid = intval($this->input->get('pid'));
        if ($pid > 0) {
            $params['pid'] = $pid;
            $sid = $this->input->get('sid');
            if ($sid !== null && $sid >= 0) {
                $params['sid'] = intval($sid);
            }
        }
        $data = $api->reSetting()
            ->setService('CourseService.StudyService.index')
            ->addParams($params)
            ->request();
        if (!empty($data['items'])) {
            $data['items'] = $data['items'][0]['services'];
        }
        if (!empty($data['hasother'])) {
            $cur = (count($data['sorts']) == 0 || isset($data['sid']) && $data['sid'] == 0) ? 1 : 0;
            $data['sorts'][] = array(
                'sid' => 0,
                'pid' => $data['pid'],
                'sname' => '其他课程',
                'cur' => $cur
            );
        }
        if (!empty($data['sorts']) && count($data['sorts']) == 1) {
            $sidIndex = key($data['sorts']);
            $data['sorts'][$sidIndex]['cur'] = 1;
        }
        /*if (!empty($data['count'])) {
            $userStatus = 0;
            if (empty($this->user)) {
                $userStatus = 1;
            } else if ($this->user['groupid'] == 5) {
                $userStatus = 2;
            }
            $this->formatCourses($data['group'][0], $userStatus);
            $data['courselist'] = $data['group'][0];
            unset($data['group']);
        }*/
        if (empty($data)) {
            $data = array();
        }
        if (isset($data['pid'])) {
            $queryArgs[] = 'pid='.$data['pid'];
        }
        if (isset($data['sid'])) {
            $queryArgs[] = 'sid='.$data['sid'];
        }
        $param['query'] = !empty($queryArgs) ? '?'.implode('&', $queryArgs) : '';
        $inner_data = array_merge($params, $data);
        if (!empty($inner_data['items'])) {
            $system_info = $this->model('Systemsetting')->getSetting($this->room['crid']);
            $enabled = true;
            if (!empty($this->user) && $this->user['groupid'] == 6 && !empty($system_info['isbanbuy'])) {
                //判断是否本校学生
                $isStudent = $model->isAlumni($this->room['crid'], $this->user['uid']);
                $enabled = $isStudent;
            }
            array_walk($inner_data['items'], function(&$course, $k, $args) {
                if (!$args['enabled']) {
                    $course['cannotpay'] = true;
                }
                if (isset($course['bid'])) {
                    $course['t'] = 2;
                    $course['title'] = $course['name'];
                    $course['id'] = $course['bid'];
                } else if (!empty($course['showbysort'])) {
                    $course['t'] = 1;
                    $course['title'] = $course['sname'];
                    $course['id'] = $course['sid'];
                } else {
                    $course['t'] = 0;
                    $course['title'] = $course['iname'];
                    $course['id'] = $course['itemid'];
                }
                $clientClasses = array();
                $course['url'] = 'javascript:;';
                if (empty($course['cover'])) {
                    $course['cover'] = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_243_144.jpg';
                } else {
                    $course['cover'] = show_plate_course_cover($course['cover']);
                }
                if (!empty($course['bid'])) {
                    $course['detailurl'] = '/room/portfolio/tagged/'.$course['bid'].'.html';
                } else if (!empty($course['showbysort'])) {
                    $course['detailurl'] = '/room/portfolio/bundle/'.$course['sid'].'.html';
                } else {
                    $course['detailurl'] = '/courseinfo/'.$course['itemid'].'.html';
                }

                if (!empty($args['szlz'])) {
                    $clientClasses[] = 'szlz';
                }
                if (!empty($course['haspower'])) {
                    $clientClasses[] = 'plate-allow';
                    $course['css'] = implode(' ', $clientClasses);
                    if (empty($args['iscollege'])) {
                        $course['url'] = '/myroom/stusubject/'.$course['folderid'].'.html';
                        return;
                    }
                    if ($course['showmode'] == 3) {
                        $course['url'] = '/myroom/college/study/introduce/'.$course['folderid'].'.html';
                        return;
                    }
                    $course['url'] = '/myroom.html?url=/myroom/college/study/cwlist/'.$course['folderid'].'.html';
                    return;
                } else if (!empty($args['surveyid'])) {
                    $clientClasses[] = 'survey';
                }

                if (!empty($course['cannotpay'])) {
                    $clientClasses[] = 'plate-sign-disabled';
                    $course['css'] = implode(' ', $clientClasses);
                    return;
                }

                if ($course['price'] == 0) {
                    $clientClasses[] = 'plate-sign-free';
                }

                if (empty($args['user'])) {
                    $clientClasses[] = 'plate-sign-unlogin';
                    $course['css'] = ' '.implode(' ', $clientClasses);
                    return;
                } else if ($args['user']['groupid'] == 5) {
                    $clientClasses[] = 'plate-sign-unallow';
                    $course['css'] = ' '.implode(' ', $clientClasses);
                    return;
                }

                $course['css'] = ' '.implode(' ', $clientClasses);
                if ($course['price'] == 0) {
                    return;
                }
                if (!empty($course['bid'])) {
                    $course['url'] = '/ibuy.html?bid='.$course['bid'];
                    return;
                }
                if (!empty($course['showbysort'])) {
                    $course['url'] = '/ibuy.html?sid='.$course['sid'].'&itemid='.$course['itemid'];
                    return;
                }
                $course['url'] = '/ibuy.html?itemid='.$course['itemid'];
            }, array(
                'iscollege' => $this->room['iscollege'],
                'isplate' => $this->room['template'] == 'plate',
                'user' => $this->user,
                'szlz' => !empty($appsetting['szlz']) && $appsetting['szlz'] == $this->room['crid'],
                'surveyid' => $surveyid,
                'enabled' => $enabled
            ));
        }

        $inner_data['surveyid'] = $surveyid;
        $inner_data['pagestr'] = show_page($data['count'], $param['pagesize']);
        $inner_data['user'] = $this->user;
        $inner_data['query'] = $param['query'];
        /*$inner_data['ordertype'] = $param['sortmode'];
        $inner_data['isfree'] = $param['viewmode'];*/

        if (!empty($this->room['isdesign'])) {
            $inner_data['design'] = true;
        }
        //是ajax请求就输出数据
        if (!empty($isAjax)) {
            $inner_data['count'] = $data['count'];
            unset($inner_data['pagestr']);
            renderjson(0,'success',$inner_data);
        }
        
        $this->assign('inner_view', 'shop/plate/platform');
        $this->assign('inner_data', $inner_data);
        $this->_template($model);
        $this->display('shop/plate/portfolio');
    }

    /**
     * 需要填写问卷ID
     * @param $crid
     * @param $user
     * @return bool
     */
    private function _need_survery($crid, $user) {
        $otherconfig = Ebh::app()->getConfig()->load('othersetting');
        if (!empty($otherconfig['survey_crids']) && is_array($otherconfig['survey_crids']) && in_array($crid, $otherconfig['survey_crids'])) {
            $survey_model = $this->model('Survey');
            $survey_id = $survey_model->getSurveyIdBeforeBuy($crid);
            if (empty($survey_id)) {
                return false;
            }
            if (empty($user)) {
                return $survey_id;
            }
            if ($user['groupid'] == 5) {
                return false;
            }
            $answered = $survey_model->answered($survey_id, $user['uid']);
            if (!$answered) {
                return $survey_id;
            }
        }
        return false;
    }

    /**
     * 是否需要填写问卷
     */
    public function ajax_check_surveryed() {
        $ret = $this->_need_survery($this->room['crid'], $this->user);
        if ($ret) {
            echo $ret;
            exit();
        }
        echo '0';
        exit();
    }

    /**
     * 网校简介
     */
    public function introduce() {
        //读取模块
        $model = $this->model('portfolio');
        /*$tourl = '';
        $nav = $model->getNavigator($this->room['crid'], $tourl);
        $enabled = false;
        if (!empty($nav)) {
            foreach ($nav as $nitem) {
                if ($nitem['code'] == 'introduce' && $nitem['available'] == 1) {
                    $enabled = true;
                    break;
                }
            }
        }
        if (!$enabled) {
            header('Location:/');
            exit();
        }*/

        $roomdetail = $model->getClassroomDetail($this->room['crid']);
        $room_type = Ebh::app()->room->getRoomType();
        $modules = $model->getPortfolioConfig($this->room['crid'], $room_type == 'com' ? 1 : 0);
        $qcode_module = array_filter($modules, function($item) {
            return $item['mid'] == 13;
        });
        if (!empty($qcode_module)) {
            $qcode_module = current($qcode_module);
            if (!empty($qcode_module['custom_data']['options'][0]['image'])) {
                $global_qcode = show_plate_img($qcode_module['custom_data']['options'][0]['image']);
                $this->assign('global_qcode', $global_qcode);
            }
            if (empty($global_qcode)) {
                $roommodel = $this->model('classroom');
                $roomdetail  = $roommodel->getclassroomdetail($this->room['crid']);
                $global_qcode = $roomdetail['wechatimg'];
                $this->assign('global_qcode', $global_qcode);
            }
        }
        $this->assign('inner_view', 'shop/plate/introduce');
        $this->assign('inner_data', array(
            'roomdetail'=> $roomdetail,
            'title' => '网校简介'
        ));
        $this->_template($model, $roomdetail);
        $this->display('shop/plate/portfolio');
    }

    /**
     * 联系我们
     */
    public function contacts() {
        //读取模块
        $model = $this->model('portfolio');
        /*$tourl = '';
        $nav = $model->getNavigator($this->room['crid'], $tourl);
        $enabled = false;
        if (!empty($nav)) {
            foreach ($nav as $nitem) {
                if ($nitem['code'] == 'contact' && $nitem['available'] == 1) {
                    $enabled = true;
                    break;
                }
            }
        }
        if (!$enabled) {
            header('Location:/');
            exit();
        }*/
        $roomdetail = $model->getClassroomDetail($this->room['crid']);
        $roomdetail = array_merge($this->room, $roomdetail);
        $room_type = Ebh::app()->room->getRoomType();
        $modules = $model->getPortfolioConfig($this->room['crid'], $room_type == 'com' ? 1 : 0);
        $qcode_module = array_filter($modules, function($item) {
            return $item['mid'] == 13;
        });
        //$roomdetail = array($this->room, $roomdetail);
        if (!empty($qcode_module)) {
            $qcode_module = current($qcode_module);
            if (!empty($qcode_module['custom_data']['options'][0]['image'])) {
                $global_qcode = show_plate_img($qcode_module['custom_data']['options'][0]['image']);
                $this->assign('global_qcode', $global_qcode);
            }
            if (empty($global_qcode)) {
                $roommodel = $this->model('classroom');
                $roomdetail  = $roommodel->getclassroomdetail($this->room['crid']);
                $global_qcode = $roomdetail['wechatimg'];
                $this->assign('global_qcode', $global_qcode);
            }
        }
        //客服浮窗
        if(isset($roomdetail['kefuqq']) && $roomdetail['kefuqq'] != '0'){
            $roomdetail['kefu'] = explode(',',$roomdetail['kefu']);
            $roomdetail['kefuqq']= explode(',',$roomdetail['kefuqq']);
        }
        $inner_data = array();
        $inner_data['title'] = '联系我们';
        $inner_data['roomdetail'] = $roomdetail;
        $this->assign('inner_view', 'shop/plate/contacts');
        $this->assign('inner_data', $inner_data);
        $this->_template($model, $roomdetail);
        $this->display('shop/plate/portfolio');
    }

    /**
     * 新闻资讯
     */
    public function dyinformation() {
        //读取模块
        $model = $this->model('portfolio');
        /*$nav = $model->getNavigator($this->room['crid'], $tourl);
        $enabled = false;
        if (!empty($nav)) {
            foreach ($nav as $nitem) {
                if ($nitem['code'] == 'news' && $nitem['available'] == 1) {
                    $enabled = true;
                    break;
                }
            }
        }
        if (!$enabled) {
            header('Location:/');
            exit();
        }*/
        $method = $this->uri->uri_method();
        $room_type = Ebh::app()->room->getRoomType();
        $modules = $model->getPortfolioConfig($this->room['crid'], $room_type == 'com' ? 1 : 0);
        $qcode_module = array_filter($modules, function($item) {
            return $item['mid'] == 13;
        });
        if (!empty($qcode_module)) {
            $qcode_module = current($qcode_module);
            if (!empty($qcode_module['custom_data']['options'][0]['image'])) {
                $global_qcode = show_plate_img($qcode_module['custom_data']['options'][0]['image']);
                $this->assign('global_qcode', $global_qcode);
            }
            if (empty($global_qcode)) {
                $roommodel = $this->model('classroom');
                $roomdetail  = $roommodel->getclassroomdetail($this->room['crid']);
                $global_qcode = $roomdetail['wechatimg'];
                $this->assign('global_qcode', $global_qcode);
            }
        }
        if($method == 'view'){
            //新闻列表页
            $itemid = $this->uri->itemid;
            $newsmodel = $this->model('news');
            $itemview = $newsmodel->getNewsDetail(array('crid'=>$this->room['crid'],'itemid'=>$itemid));
            if (empty($itemview)) {
                header('Location:/');
                exit();
            }
			//仅内部用户查看
			if(!empty($itemview['isinternal'])){
				if(empty($this->user)){
					$this->assign('isroomuser',FALSE);
				} else {
					$isroomuser = $this->model('Roomuser')->checkUser($this->user,$this->room['crid']);
					$itemview['isroomuser'] = $isroomuser;
				}
			}
			//附件
			if(!empty($itemview['attid'])){
				$itemview['attachlist'] = Ebh::app()->getApiServer('ebh')
				->reSetting()
                ->setService('Aroomv3.Attach.List')
                ->addParams('crid', $this->room['crid'])
                ->addParams('attid', $itemview['attid'])
                ->request();
			}
            //增加新闻条数
            $newsmodel->addviewnum($itemid);
            $itemview['title'] = $itemview['subject'];
            if (!empty($this->room['isdesign'])) {
                $itemview['design'] = true;
            }
            $this->assign('inner_data', $itemview);
            $this->assign('inner_view', 'shop/plate/view');
            if (preg_match('/^n\d+?/', $itemview['navcode'], $m)) {
                $this->_template($model, null, substr($m[0], 0, 2));
            } else {
                $this->_template($model, null, 'news');
            }
        }else{
            //新闻资讯
            $pagesize = 20;
            $page = $this->uri->uri_page();
            $newsmodel = $this->model('news');
            $params = parsequery();
            $params['crid'] = $this->room['crid'];
            $params['status'] = 1;
            $params['navcode'] = 'news';
            $params['page'] = $page;
            $params['pagesize'] = $pagesize;
            $count = $newsmodel->getnewscount($params);
            $mitemlist = $newsmodel->getnewslist($params);
            $pagestr = show_page($count,$pagesize);
            $this->assign('inner_data',array(
                'newlist'=>array('mitemlist'=>$mitemlist,'pagestr'=>$pagestr),'title' => '新闻资讯', 'design' => !empty($this->room['isdesign'])));
            $this->assign('inner_view', 'shop/plate/dyinformation');
            $this->_template($model);
        }
        if (is_mobile()) {
            $this->display('shop/plate/portfolio_dyinformation_mobile');
            exit;
        }
        
        $this->display('shop/plate/portfolio');

    }

    /**
     * 网校发布
     */
    public function publish() {
        //修改网校发布内容为暂无内容---start////////////////////////////////////////////////////////////
        $model = $this->model('portfolio');
        $roomdetail = $model->getClassroomDetail($this->room['crid']);
        $this->assign('inner_data', '');
        $this->assign('inner_view', 'shop/plate/publish');
        $this->_template($model, $roomdetail);
        $this->display('shop/plate/portfolio');exit;//修改网校发布内容为暂无内容
        //修改网校发布内容为暂无内容---end////////////////////////////////////////////////////////////
        if(false){//修改网校发布内容为暂无内容---start---
        //读取模块
        $model = $this->model('portfolio');
        /*$tourl = '';
        $nav = $model->getNavigator($this->room['crid'], $tourl);
        $enabled = false;
        if (!empty($nav)) {
            foreach ($nav as $nitem) {
                if ($nitem['code'] == 'publish' && $nitem['available'] == 1) {
                    $enabled = true;
                    break;
                }
            }
        }
        if (!$enabled) {
            header('Location:/');
            exit();
        }*/
        $roomdetail = $model->getClassroomDetail($this->room['crid']);
        $inner_data = array();
        $inner_data['roominfo'] = $this->room;
        $inner_data['roomdetail'] = $roomdetail;
        $model = $this->model('portfolio');
        $room_type = Ebh::app()->room->getRoomType();
        $modules = $model->getPortfolioConfig($this->room['crid'], $room_type == 'com' ? 1 : 0);
        $qcode_module = array_filter($modules, function($item) {
            return $item['mid'] == 13;
        });
        if (!empty($qcode_module)) {
            $qcode_module = current($qcode_module);
            if (!empty($qcode_module['custom_data']['options'][0]['image'])) {
                $global_qcode = show_plate_img($qcode_module['custom_data']['options'][0]['image']);
                $this->assign('global_qcode', $global_qcode);
            }
            if (empty($global_qcode)) {
                $roommodel = $this->model('classroom');
                $roomdetail  = $roommodel->getclassroomdetail($this->room['crid']);
                $global_qcode = $roomdetail['wechatimg'];
                $this->assign('global_qcode', $global_qcode);
            }
        }
        //////////////////////////////////////////////////////////////////////////////////////
        $stime = microtime(true);
        $roominfo = $this->room;
        $diffage = date('Y',SYSTIME) - date('Y',$roominfo['dateline']);
        $user = Ebh::app()->user->getloginuser();
        $this->eventstring = $this->getEventString();
        $this->crid = $roominfo['crid'];
        $inner_data['user'] = $user;
        $timearr = array();
        $this->joindata($timearr,$roominfo,'birthday');//诞生
        $this->getData($timearr,'firststu');//第一个学生
        $this->getData($timearr,'firstcourse');//第一个课件
        $this->getData($timearr,'firstiaclass');//第一次互动
        $this->getData($timearr,'firstreview');//第一条评论
        $this->getData($timearr,'firstexam');//第一份作业
        $this->getData($timearr,'firstask');//第一个提问
        $this->getData($timearr,'firstnotice');//第一个通知
        $this->getData($timearr,'firstsurvey');//第一个问卷调查
        $etime = microtime(true);
        //改变网校诞生年份显示
        if($diffage >0){
            $tmpval = $timearr[$roominfo['dateline']];
            $tmpkey = strtotime( (date('Y',$roominfo['dateline']) - 1).'-'.date('m-d',$roominfo['dateline']) );
            unset($timearr[$roominfo['dateline']]);
            $ntimearr = array();
            $ntimearr[$tmpkey] = $tmpval;
            foreach ($timearr as $key=>$val){
                $ntimearr[$key] = $val;
            }
            $timearr = $ntimearr;
        }

        //多久前创建
        $agestr = $this->getAgestr($roominfo['dateline']);
        $inner_data['agestr'] = $agestr;

        $pmodel = $this->model('publish');

        //互动数量
        $iacount = $pmodel->getIaclassroomCount($this->crid);
        $inner_data['iacount'] = $iacount;

        //教师数量
        $teachercount = $pmodel->getTeacherCount($this->crid);
        $inner_data['teachercount'] = $teachercount;

        //最热/最冷门课程
        $courselist = $pmodel->getCourseList($this->crid);
        $coursetopstr = '';
        $coursetoplist = array();
        foreach($courselist as $k=>$course){
            $course['foldername'] = !empty($course['foldername']) ? $course['foldername'] : '';
            $coursetopstr.= $course['foldername'].'，';
            $coursetoplist[] = $course;
            if($k==2)
                break;
        }
        if(count($courselist)>3){
            $coursebottom = $courselist[count($courselist)-1];
        } else {
            $coursebottom = array();
        }
        $inner_data['coursetopstr'] = mb_substr($coursetopstr,0,-1,'utf-8');
        $inner_data['coursetoplist'] = $coursetoplist;
        $inner_data['coursebottom'] = $coursebottom;


        //$this->getAssignData('creditloglist');//积分记录
        $inner_data['creditloglist'] = $this->getAssignData('creditloglist');
        $inner_data['creditlist'] = $this->getAssignData('creditlist');//积分排名
        $inner_data['femalepercent'] = $this->getAssignData('femalepercent');//女生比例
        // $this->getAssignData('lastloginlist');//最后登录时间列表
        $lastloginlist = $pmodel->getlastloginlist($this->crid);

        for($i=0;$i<24;$i++){
            $loginhour[$i] = 0;
        }
        $stucount = count($lastloginlist);
        foreach($lastloginlist as $login){
            $loginhour[$login['hour']]++;
        }
        $hourcountstr = '';
        if (!empty($stucount)) {
            foreach($loginhour as $hour){
                $hourcountstr .= round($hour*100/$stucount,2).',';
            }
        }

        $inner_data['hourcountstr'] = rtrim($hourcountstr,',');

        $this->getSexInfo($inner_data);

        //教室首页广告获取
        $param = array('crid'=>$roominfo['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
        $roomadkey = $this->cache->getcachekey('ad',$param);
        $adlist = $this->cache->get($roomadkey);
        if(empty($adlist)) {
            $admodel = $this->model('Ad');
            $adlist = $admodel->getAdList($param);
            $this->cache->set($roomadkey,$adlist,600);
        }

        //客服浮窗
        $kefu=array();
        if(isset($roominfo['kefuqq']) && $roominfo['kefuqq'] != '0'){
            $kefu['kefu'] = explode(',',$roominfo['kefu']);
            $kefu['kefuqq'] = explode(',',$roominfo['kefuqq']);
        }
        if(!empty($roominfo['crphone'])){
            $phone = array();
            $phone = explode(',',$roominfo['crphone']);
            $inner_data['phone'] = $phone;
        }
        $inner_data['kefu'] = $kefu;

        $inner_data['adlist'] =  $adlist;
        $inner_data['timearr'] = $timearr;
        //////////////////////////////////////////////////////////////////////////////////////
        $this->assign('inner_data', $inner_data);
        $this->assign('inner_view', 'shop/plate/publish');
        $this->_template($model, $roomdetail);
        $this->display('shop/plate/portfolio');
        }//修改网校发布内容为暂无内容---end---
    }
    private function getEventString(){
        $eventstring = array(
            'birthday'=>'我诞生啦',

            'firststu'=>'我拥有了<span class="hoastr">第一名优秀的学员</span>“<var>realname</var>”，他现在已经成为学霸咯',

            'firstcourse'=>'大家上了<span class="hoastr">第一堂精品课程</span>“<var>title</var>”',

            'firstiaclass'=>'“<var>realname</var>”<span class="hoastr">第一次</span>与讲师进行了<span class="hoastr">课堂互动</span>，学习效果不错哦',

            'firstreview'=>'“<var>realname</var>”给我们留下了非常有意义的<span class="hoastr">第一条评论</span>',

            'firstexam'=>'给“<var>classname</var>”布置了<span class="hoastr">第一份课后作业</span> PS：“<var>realname</var>”第一个完成的哦',

            'firstask'=>'收到了“<var>realname</var>”提的<span class="hoastr">第一个提问</span>',

            'firstnotice'=>'我们发布了<span class="hoastr">第一条网校通知</span>，你还记得是什么内容吗？',

            'firstsurvey'=>'为了倾听大家对网校发展的建议和意见，我们发布了<span class="hoastr">第一份调查问卷</span>。',

            'moremale'=>'男同学在人数上比女同学更有优势哦',
            'morefemale'=>'男同学在人数上比女男同学更有优势哦',
            'nearlysex'=>'男女同学在人数上势均力敌哦'

        );

        return $eventstring;
    }
    private function getData(&$timearr,$code){
        $pmodel = $this->model('publish');
        $funcstr = 'get'.$code;
        $$code = $pmodel->$funcstr($this->crid);
        $this->joinData($timearr,$$code,$code);
    }
    private function joinData(&$timearr,$data,$code){
        if(!empty($data['dateline'])){
            $timearr[$data['dateline']] = preg_replace_callback(
                '/<var>([a-z]*)<\/var>/',
                function($matches)use($data){
                    return $data[$matches[1]];
                },
                $this->eventstring[$code]);

        }
    }
    private function getAssignData($code){
        $pmodel = $this->model('publish');
        $funcstr = 'get'.$code;
        $$code = $pmodel->$funcstr($this->crid);
        //$this->assign($code,$$code);
        return $$code;
    }
    private function getAgestr($birthdate){
        $diffage = date('Y',SYSTIME) - date('Y',$birthdate);
        $theage = $diffage > 0 ? $diffage + 2 : $diffage + 1;
        /*
        $age_second = SYSTIME-$birthdate;
        $age_day = $age_second/86400;
        if($age_day<30)
            $agestr = '<span style="font-size:28px;color:blue"> '.floor($age_day).' </span>天';
        elseif($age_day>=30 && $age_day<365)
            $agestr = '<span style="font-size:28px;color:blue"> '.floor($age_day/30).' </span>月';
        elseif($age_day>=365)
            $agestr = '<span style="font-size:28px;color:blue"> '.$theage.' </span>年';
        */
        $agestr = '<span style="font-size:28px;color:blue"> '.$theage.' </span>年';
        return $agestr;
    }
    private function getSexInfo(&$inner_data){
        $paramuser = array('crid'=>$this->crid);


        // $stime = microtime(true);
        //性别比例
        $rumodel = $this->model('roomuser');
        $paramuser['sex'] = 0;
        $sex[0] = $rumodel->getSexCount($paramuser);
        $paramuser['sex'] = 1;
        $sex[1] = $rumodel->getSexCount($paramuser);
        if($sex[0] == 0 && $sex[1] == 0){
            $sexpercent[0] = 0;
            $sexpercent[1] = 0;
        }else{
            $sexpercent[0] = round($sex[0]/($sex[0]+$sex[1])*100,2);
            $sexpercent[1] = 100-$sexpercent[0];
        }
        //性别登录比例
        $paramuser['sex'] = 0;
        $logincount[0] = $rumodel->getLoginCount($paramuser);
        $paramuser['sex'] = 1;
        $logincount[1] = $rumodel->getLoginCount($paramuser);

        if($logincount[0]==0 && $logincount[1]==0){
            $loginpercent[0] = 0;
            $loginpercent[1] = 0;
        }else{
            $loginpercent[0] = round($logincount[0]/($logincount[0]+$logincount[1])*100,2);
            $loginpercent[1] = 100-$loginpercent[0];
        }
        //$this->assign('sexpercent',$sexpercent);
        //$this->assign('loginpercent',$loginpercent);
        $inner_data['sexpercent'] = $sexpercent;
        $inner_data['loginpercent'] = $loginpercent;
    }

    /**
     * 自定义导航
     */
    public function navcm()
    {
		$get = $this->input->get();
        $itemid = $this->uri->itemid;
		if (!empty($get['itemid'])) {
			$itemid = intval($get['itemid']);
		}
        $model = $this->model('portfolio');
        $roommodel = $this->model('classroom');
        $room_type = Ebh::app()->room->getRoomType();
        $modules = $model->getPortfolioConfig($this->room['crid'], $room_type ? 1 : 0);
        $qcode_module = array_filter($modules, function($item) {
            return $item['mid'] == 13;
        });
        if (!empty($qcode_module)) {
            $qcode_module = current($qcode_module);
            if (!empty($qcode_module['custom_data']['options'][0]['image'])) {
                $global_qcode = show_plate_img($qcode_module['custom_data']['options'][0]['image']);
                $this->assign('global_qcode', $global_qcode);
            }
            if (empty($global_qcode)) {
                $roommodel = $this->model('classroom');
                $roomdetail  = $roommodel->getclassroomdetail($this->room['crid']);
                $global_qcode = $roomdetail['wechatimg'];
                $this->assign('global_qcode', $global_qcode);
            }
        }
        //富文本
        $custommessage = $roommodel->getcustommessage(array('crid'=>$this->room['crid'],'index'=>'\'n'.$itemid.'\''));
        $inner_data = array();
        if (!empty($custommessage[0])) {
            $inner_data['custommessage'] = $custommessage[0]['custommessage'];
        }
        if (!empty($this->room['isdesign'])) {
            $inner_data['design'] = true;
        }
        $tourl = null;
        $navigatordata = $model->getNavigator($this->room['crid'], $tourl);
        $s = $this->input->get('s');
        if ($s !== null) {
            $inner_data['subid'] = intval($this->input->get('s'));
        }
        $enabled = false;

        if (!empty($navigatordata)) {
            $navigatordata = array_filter($navigatordata, function($nav) {
                if ($nav['code'] == 'news') {
                    return false;
                }
                return true;
            });
            foreach ($navigatordata as $n) {
                if ($n['code'] == 'n'.$itemid) {
                    if (!empty($n['available'])) {
                        $enabled = true;
                    }
                    $menu = $n;
                    $inner_data['title'] = $n['nickname'];
                    break;
                }
            }
        }
        /*if (!$enabled) {
            header('Location:/');
            exit();
        }*/
        $k = -1;
        if (!empty($menu['subnav'])) {
            $pattern = '/^n(\d+)s(\d+)$/';
            $subnav = array_filter($menu['subnav'], function($submenu) {
                return !empty($submenu['subavailable']);
            });
            foreach($subnav as $index => &$s) {
                if (preg_match($pattern, $s['subcode'], $m)) {
                    $s['url'] = sprintf('/navcm/%d.html?s=%d', $m[1], $m[2]);
                    $s['index'] = $m[2];
                    if (isset($inner_data['subid']) && $inner_data['subid'] == $m[2]) {
                        $k = $index;
                    }
                } else {
                    $s['url'] = 'javascript:;';
                }
            }
            $inner_data['subnav'] = $subnav;
        }
        if ($k < 0) {
            $inner_data['subid'] = 0;
        }
        $newsmodel = $this->model('news');
        $param = parsequery();
       
        if (isset($get['page'])) {
            $param['page'] = intval($get['page']);
        }
        $param['crid'] = $this->room['crid'];
        $param['status'] = 1;
        $param['q'] = trim($this->input->get('q'));

       if (!empty($inner_data['subnav'])) {
            array_unshift($inner_data['subnav'], array(
                'subcode' => 'n'.$itemid.'s0',
                'subnickname' => '全部',
                'url' => '/navcm/'.$itemid.'.html?s=0',
                'index' => 0
            ));
            if (isset($inner_data['subid']) && $inner_data['subid'] == 0) {
                /*$current_subnav = $inner_data['subnav'][$k];
                $param['navcode'] = $current_subnav['subcode'];*/
                $inner_data['sublist'] = $newsmodel->getnewslist($param, 'n'.$itemid);
                if (!empty($inner_data['sublist']) && count($inner_data['sublist']) == 1) {
                    $firstKey = key($inner_data['sublist']);
                    //附件
                    if(!empty($inner_data['sublist'][$firstKey]['attid'])){
                        $inner_data['sublist'][$firstKey]['attachlist'] = Ebh::app()->getApiServer('ebh')
                            ->reSetting()
                            ->setService('Aroomv3.Attach.List')
                            ->addParams('crid', $this->room['crid'])
                            ->addParams('attid', $inner_data['sublist'][$firstKey]['attid'])
                            ->request();
                    }
                }
                if (!isset($get['page'])) {
                    $inner_data['count'] = $newsmodel->getnewscount($param, 'n'.$itemid);
                }
            } else if (!empty($inner_data['subid'])) {
                $current_subnav = $inner_data['subnav'][$k + 1];
                $param['navcode'] = $current_subnav['subcode'];
                $inner_data['sublist'] = $newsmodel->getnewslist($param);
                if (!isset($get['page'])) {
                    $inner_data['count'] = $newsmodel->getnewscount($param);
                }
                if (!empty($inner_data['sublist']) && count($inner_data['sublist']) == 1) {
                    $firstKey = key($inner_data['sublist']);
                    //附件
                    if(!empty($inner_data['sublist'][$firstKey]['attid'])){
                        $inner_data['sublist'][$firstKey]['attachlist'] = Ebh::app()->getApiServer('ebh')
                            ->reSetting()
                            ->setService('Aroomv3.Attach.List')
                            ->addParams('crid', $this->room['crid'])
                            ->addParams('attid', $inner_data['sublist'][$firstKey]['attid'])
                            ->request();
                    }
                }
                if (!empty($inner_data['sublist']) && count($inner_data['sublist']) == 1 && !isset($get['page'])) {
                    $this->model('news')->addviewnum($inner_data['sublist'][0]['itemid']);
                }
            } elseif (empty($inner_data['custommessage'])) {
                $first_subnav = current($inner_data['subnav']);
                $inner_data['subid'] = $first_subnav['index'];
                $param['navcode'] = $first_subnav['subcode'];
                $inner_data['sublist'] = $newsmodel->getnewslist($param);
            }
			
			//仅内部用户查看
			if(empty($this->user)){
				$this->assign('isroomuser',FALSE);
			} else {
				$isroomuser = $this->model('Roomuser')->checkUser($this->user,$this->room['crid']);
				$inner_data['isroomuser'] = $isroomuser;
			}
			
        } else {
            $param['navcode'] = 'n'.$itemid.'';
            if (!isset($get['page'])) {
                $inner_data['count'] = $newsmodel->getnewscount($param);
            }
            $inner_data['list'] = $newsmodel->getnewslist($param);
        }
        if (isset($get['page'])) {
            echo json_encode($inner_data);exit;
        }
        if (!empty($inner_data['count'])) {
            $inner_data['pagestr'] = show_page($inner_data['count'], $param['pagesize']);
        }

        $this->assign('inner_view', 'shop/plate/navcm');
        $this->assign('inner_data', $inner_data);
        $this->_template($model);
        //手机跳转页面
        if (is_mobile()) {
			$this->assign('itemid', $itemid);
            $this->display('shop/plate/portfolio_navcm_mobile');
            exit;
        }
        $this->display('shop/plate/portfolio');
    }

    /**
     * 加载模板框架
     * @param $model
     * @param null $roomdetail
     */
    private function _template($model, $roomdetail = null, $navcode = null) {
        $upconfig = Ebh::app()->getConfig()->load('upconfig');
        $baseurl = $upconfig['hmodule']['showpath'];
        $room_type = Ebh::app()->room->getRoomType();
        $modules = $model->getPortfolioConfig($this->room['crid'], $room_type == 'com' ? 1 : 0);
        $room_cache = Ebh::app()->lib('Roomcache');
        $has_slide = false;
        $currentdomain = getdomain();
        $this->assign('varpool', array('currentdomain' => $currentdomain));
        if (!empty($this->user)) {
            $this->user['isadmin'] = $this->user['groupid'] == 5;
            $this->user['showname'] = !empty($this->user['realname']) ? shortstr($this->user['realname'], 8, ''): shortstr($this->user['username'], 8, '');
            $this->user['face'] = getavater($this->user, '120_120');
            $user = array(
                'username' => $this->user['username'],
                'showname' => $this->user['showname'],
                'groupid' => $this->user['groupid'],
                'isadmin' => $this->user['isadmin'],
                'face' => $this->user['face'],
                'lastlogtime' => $this->user['lastlogintime']
            );
            $this->assign('plateUser', $user);
        }
        if (!empty($this->room)) {
            $room = array(
                'crname' => $this->room['crname'],
                'crphone' => $this->room['crphone'],
                'kefuqq' => $this->room['kefuqq'],
                'summary' => $this->room['summary'],
                'wechatimg' => $this->room['wechatimg'],
                'cface' => $this->room['cface'],
                'lat' => $this->room['lat'],
                'lng' => $this->room['lng'],
                'craddress' => $this->room['craddress']
            );
            $this->assign('plateRoom', $room);
        }
        $this->assign('user', $this->user);
        $this->assign('roominfo', $this->room);
        if (empty($roomdetail)) {
            $roomdetail = $model->getClassroomDetail($this->room['crid']);
        }
        $roomdetail['isdesign'] = $this->room['isdesign'];
        if (!empty($roomdetail['isdesign'])) {
            $apiServer = Ebh::app()->getApiServer('ebh');
            $roomtype = Ebh::app()->room->getRoomType();
            $is_mobile = is_mobile();
            $ret = $apiServer->reSetting()
                ->setService('Classroom.Design.getdesign')
                ->addParams('crid', $roomdetail['crid'])
                ->addParams('roomtype', $roomtype)
                ->addParams('clientType', $is_mobile)
                ->request();
            if ($is_mobile && (empty($ret['status']) || empty($ret['data']))) {
                $ret = $apiServer->reSetting()
                    ->setService('Classroom.Design.getdesign')
                    ->addParams('crid', $roomdetail['crid'])
                    ->addParams('roomtype', $roomtype)
                    ->addParams('clientType', 0)
                    ->request();
                $is_mobile = false;
            }
            if (!empty($ret['status']) && !empty($ret['data'])) {
                $this->assign('head', str_replace('\"', '"', $ret['data']['head']));
                $this->assign('foot', str_replace('\"', '"', $ret['data']['foot']));
                $settings = str_replace('\"', '"', $ret['data']['settings']);
                $settings = json_decode($settings, true);
                $this->assign('settings', $settings);
            }
            $this->assign('ismobile', $is_mobile);
        } else {
            if (!empty($modules)) {
                $top_modules = array_filter($modules, function($e) {
                    return $e['show_type'] == 1 && ($e['mid'] == 1 || $e['mid'] == 2 || $e['mid'] == 3);
                });
                $logo_module = array_filter($top_modules, function($module) {
                    return $module['mid'] == 1;
                });
                if (!empty($logo_module)) {
                    $top_modules = array_filter($top_modules, function($e) {
                        return $e['mid'] == 1 || $e['mid'] == 2;
                    });
                }
                if (!empty($top_modules)) {
                    $top_modules = array_values($top_modules);
                    $top_menu_index = -1;
                    $top_slide_index = -1;
                    $show_course_menu = false;
                    foreach ($top_modules as $index => &$module) {
                        $mid = $module['mid'];
                        //页头
                        if ($module['mid'] == 1) {
                            if (!empty($module['custom_data']['options'][0]['image'])) {
                                $module['custom_data']['options'][0]['image'] = show_plate_img($module['custom_data']['options'][0]['image']);
                            }
                            continue;
                        }
                        //选项卡(导航模块)
                        if ($module['mid'] == 2) {
                            $top_menu_index = $index;
                            $show_course_menu = !empty($module['arg_sign']);
                            $this->assign('has_window_login', true);
                            $theme = $this->_get_course_menu_theme($module['background_color']);
                            $this->assign('menu_theme', $theme);
                            if (!empty($this->user)) {
                                $module['logined'] = true;
                                if ($this->user['uid'] == $this->room['uid']) {
                                    $module['is_admin'] = true;
                                }
                                $module['user'] = $this->user;
                            }
                            $module['q'] = trim($this->input->get('q'));
                            if (!empty($navcode)) {
                                $module['navcode'] = $navcode;
                            }
                            $cache_set = $this->cache_time[$module['code']];
                            $navigatordata = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);

                            if (!empty($navigatordata)) {
                                if (!empty($navigatordata)) {
                                    $navigatordata = array_filter($navigatordata, function($nav) {
                                        if ($nav['code'] == 'news') {
                                            return false;
                                        }
                                        return true;
                                    });
                                }
                                $module['menu'] = $navigatordata;
                                continue;
                            }
                            $tourl = null;
                            $navigatordata = $model->getNavigator($this->room['crid'], $tourl);
                            if (empty($navigatordata)){
                                if (!empty($tourl)) {
                                    if (strpos($_SERVER['REQUEST_URI'], $tourl) !== 0) {
                                        header('Location: '.$tourl);
                                        exit;
                                    }
                                }
                            }
                            if (!empty($navigatordata)) {
                                $navigatordata = array_filter($navigatordata, function($nav) {
                                    if ($nav['code'] == 'news') {
                                        return false;
                                    }
                                    return true;
                                });
                            }
                            $module['menu'] = $navigatordata;
                            $room_cache->setCache($this->room['crid'],
                                $cache_set['module'],
                                $cache_set['param'],
                                $navigatordata,
                                $cache_set['expire'],
                                $cache_set['needupdate']);
                            unset($navigatordata);
                            continue;
                        }
                        //轮播大图
                        if ($module['mid'] == 3) {
                            $top_slide_index = $index;
                            $has_slide = true;
                            if (!empty($module['custom_data']['options'])) {
                                $module['custom_data']['options'] = array_map(function($e) {
                                    $e['image'] = show_plate_img($e['image']);
                                    return $e;
                                }, $module['custom_data']['options']);
                            }
                            $module['room_type'] = $room_type;
                            continue;
                        }
                        //滚动通知
                        if ($module['mid'] == 4) {
                            $cache_set = $this->cache_time[$module['code']];
                            $notice = $room_cache->getCache($this->room['crid'], $cache_set['module'], $cache_set['param']);
                            if (!empty($notice)) {
                                $module['data'] = $notice;
                                continue;
                            }
                            $module['data'] = $model->getNoticeList($this->room['crid'], 3);
                            $room_cache->setCache($this->room['crid'],
                                $cache_set['module'],
                                $cache_set['param'],
                                $module['data'],
                                $cache_set['expire'],
                                $cache_set['needupdate']);
                            continue;
                        }
                    }
                    if ($top_slide_index == $top_menu_index + 1) {
                        //判断头部轮播广告是否位于导航之下
                        $this->assign('allways_show_course_menus', true);
                    }
                    if ($show_course_menu) {
                        $course_menus = $model->getCourseMenu($this->room['crid']);
                        $this->assign('course_menus', $course_menus);
                    }
                }

                $this->assign('top_modules', $top_modules);
            }
        }


        $this->assign('has_slide', $has_slide);
        $this->assign('roomdetail', $roomdetail);
    }

    /**
     * 精品课件
     */
    public function fineware() {
        //读取模块
        $model = $this->model('portfolio');
        /*$tourl = '';
        $nav = $model->getNavigator($this->room['crid'], $tourl);
        $enabled = false;
        if (!empty($nav)) {
            foreach ($nav as $nitem) {
                if ($nitem['code'] == 'fineware' && $nitem['available'] == 1) {
                    $enabled = true;
                    break;
                }
            }
        }
        if (!$enabled) {
            header('Location:/');
            exit();
        }*/
        $roomdetail = $model->getClassroomDetail($this->room['crid']);
        $room_type = Ebh::app()->room->getRoomType();
        $modules = $model->getPortfolioConfig($this->room['crid'], $room_type == 'com' ? 1 : 0);
        $qcode_module = array_filter($modules, function($item) {
            return $item['mid'] == 13;
        });
        //$roomdetail = array($this->room, $roomdetail);
        if (!empty($qcode_module)) {
            $qcode_module = current($qcode_module);
            if (!empty($qcode_module['custom_data']['options'][0]['image'])) {
                $global_qcode = show_plate_img($qcode_module['custom_data']['options'][0]['image']);
                $this->assign('global_qcode', $global_qcode);
            }
            if (empty($global_qcode)) {
                $roommodel = $this->model('classroom');
                $roomdetail  = $roommodel->getclassroomdetail($this->room['crid']);
                $global_qcode = $roomdetail['wechatimg'];
                $this->assign('global_qcode', $global_qcode);
            }
        }
        //客服浮窗
        if(isset($roomdetail['kefuqq']) && $roomdetail['kefuqq'] != '0'){
            $roomdetail['kefu'] = explode(',',$roomdetail['kefu']);
            $roomdetail['kefuqq']= explode(',',$roomdetail['kefuqq']);
        }
        $param = parsequery();
        $inner_data = array();
        $inner_data['title'] = '单课列表';
        $sort_type = !isset($param['sortmode']) ? 0 : intval($param['sortmode']);
        $inner_data['isfree'] = intval($sort_type / 10);
        $inner_data['order_sign'] = intval($sort_type % 10);
        $inner_data['courseid'] = isset($param['viewmode']) ? intval($param['viewmode']) : 0;
        $inner_data['design'] = $this->room['isdesign'];
        $inner_data['courses'] = $model->getFolders($this->room['crid']);
        $surveyid = $this->_need_survery($this->room['crid'], $this->user);
        if (!empty($surveyid)) {
            $inner_data['surveyid'] = $surveyid;
        }
        $count = $model->getFineCoursewareCount($this->room['crid'], array(
            'folderid' => $inner_data['courseid'],
            'isfree' => $inner_data['isfree'],
            'order' => $inner_data['order_sign']
        ));
        if (!empty($count)) {
            $system_info = $this->model('Systemsetting')->getSetting($this->room['crid']);
            $enabled = true;
            if (!empty($this->user) && $this->user['groupid'] == 6 && !empty($system_info['isbanbuy'])) {
                //判断是否本校学生
                $isStudent = $model->isAlumni($this->room['crid'], $this->user['uid']);
                $enabled = $isStudent;
            }
            $inner_data['items'] = $model->getFineCoursewares($this->room['crid'], array(
                'folderid' => $inner_data['courseid'],
                'isfree' => $inner_data['isfree'],
                'order' => $inner_data['order_sign']
            ), $param);
            $inner_data['enabled'] = $enabled;
            if (is_array($inner_data['items'])) {
                //精品课件列表不为空，获取附加用户信息
                $uids = array_column($inner_data['items'], 'uid');
                $inner_data['publishers'] = $model->getUsers($uids);
                unset($uids);
                if (!empty($this->user) && $this->user['groupid'] == 6) {
                    $folderids = array_column($inner_data['items'], 'folderid');
                    $inner_data['course_permisions'] = $model->getUserpermisions($this->user['uid'], $folderids, $this->room['crid']);
                    $inner_data['course_permisions'] = array_flip($inner_data['course_permisions']);
                    $coursewareids = array_column($inner_data['items'], 'cwid');
                    $inner_data['courseware_permisions'] = $model->getCoursewarePermisions($this->user['uid'], $this->room['crid'], $coursewareids);
                    $inner_data['courseware_permisions'] = array_flip($inner_data['courseware_permisions']);
                    //print_r($inner_data['course_permisions']);
                    //print_r($inner_data['courseware_permisions']);exit();
                    unset($folderids, $coursewareids);
                }
            }
            $inner_data['pagestr'] = show_page($count, $param['pagesize']);
        }
        $inner_data['user'] = $this->user;
        $this->assign('inner_view', 'shop/plate/fineware');
        $this->assign('inner_data', $inner_data);
        $this->_template($model, $roomdetail);
        $this->display('shop/plate/portfolio');
    }

    /**
     * 检查课件权限
     */
    public function ajax_check_courseware_userpermisions() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法操作'
            ));
            exit();
        }
        if (empty($this->user)) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '用户未登录'
            ));
            exit();
        }
        if ($this->user['groupid'] == 5) {
            echo json_encode(array(
                'errno' => 3,
                'msg' => '教师账号，不允许进行此操作。'
            ));
            exit();
        }
        $cwid = intval($this->input->post('cwid'));
        if ($cwid < 1) {
            echo json_encode(array(
                'errno' => 4,
                'msg' => '参数错误'
            ));
            exit();
        }
        $model = $this->model('Portfolio');
        $courseware = $model->getCoursewareInfo($this->room['crid'], $cwid);
        if (empty($courseware)) {
            echo json_encode(array(
                'errno' => 5,
                'msg' => '课件不存在'
            ));
            exit();
        }
        $courseware['crname'] = $this->room['crname'];
        $courseware['logo'] = $this->show_courseware($courseware['logo']);
        $course_permision = $model->getUserpermisions($this->user['uid'], $courseware['folderid'], $this->room['crid']);
        if (is_array($course_permision) && in_array($courseware['folderid'], $course_permision)) {
            //具有课程权限
            $courseware['signed'] = true;

        } else {
            $courseware_permisions = $model->getCoursewarePermisions($this->user['uid'], $this->room['crid'], $courseware['cwid']);
            if (is_array($courseware_permisions) && in_array($courseware['cwid'], $courseware_permisions)) {
                //具有课件权限
                $courseware['signed'] = true;
            }
        }

		if (!empty($courseware['signed'])) {
			$courseware['url'] = '/myroom/mycourse/'.$courseware['cwid'].'.html';
		}
		if ($courseware['cprice'] > 0) {
			$courseware['url'] = '/ibuy.html?cwid='.$courseware['cwid'];
		}
        echo json_encode(array(
            'errno' => 0,
            'data' => array(
                'courseware' => $courseware
            )
        ));
    }

    /**
     * 课程封面
     * @param $logo
     * @return string
     */
    public function show_courseware($logo) {
        $logo = trim($logo);
        if (empty($logo)) {
            return 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png';
        }
        return $logo;
    }

    public function master() {
        //读取模块
        $model = $this->model('portfolio');
        /*$tourl = '';
        $nav = $model->getNavigator($this->room['crid'], $tourl);
        $enabled = false;
        if (!empty($nav)) {
            foreach ($nav as $nitem) {
                if ($nitem['code'] == 'fineware' && $nitem['available'] == 1) {
                    $enabled = true;
                    break;
                }
            }
        }
        if (!$enabled) {
            header('Location:/');
            exit();
        }*/
        $roomdetail = $model->getClassroomDetail($this->room['crid']);
        $room_type = Ebh::app()->room->getRoomType();
        $modules = $model->getPortfolioConfig($this->room['crid'], $room_type == 'com' ? 1 : 0);
        $qcode_module = array_filter($modules, function($item) {
            return $item['mid'] == 13;
        });
        //$roomdetail = array($this->room, $roomdetail);
        if (!empty($qcode_module)) {
            $qcode_module = current($qcode_module);
            if (!empty($qcode_module['custom_data']['options'][0]['image'])) {
                $global_qcode = show_plate_img($qcode_module['custom_data']['options'][0]['image']);
                $this->assign('global_qcode', $global_qcode);
            }
            if (empty($global_qcode)) {
                $roommodel = $this->model('classroom');
                $roomdetail  = $roommodel->getclassroomdetail($this->room['crid']);
                $global_qcode = $roomdetail['wechatimg'];
                $this->assign('global_qcode', $global_qcode);
            }
        }
        //客服浮窗
        if(isset($roomdetail['kefuqq']) && $roomdetail['kefuqq'] != '0'){
            $roomdetail['kefu'] = explode(',',$roomdetail['kefu']);
            $roomdetail['kefuqq']= explode(',',$roomdetail['kefuqq']);
        }
        $param = parsequery();
        $inner_data = array();
        $inner_data['title'] = '名师团队';

        $surveyid = $this->_need_survery($this->room['crid'], $this->user);
        if (!empty($surveyid)) {
            $inner_data['surveyid'] = $surveyid;
        }

        $inner_data['user'] = $this->user;
        $this->assign('inner_view', 'shop/plate/master');
        $this->assign('inner_data', $inner_data);
        $this->_template($model, $roomdetail);
        $this->display('shop/plate/portfolio');
    }

    public function master_detail($teacherid) {
        //读取模块
        $model = $this->model('portfolio');
        $teacherModel = $this->model('Teacher');
        $master = $teacherModel->getteacherdetail(intval($teacherid));
        if (empty($master)) {
            header('Location:/');
            exit();
        }
        /*$tourl = '';
        $nav = $model->getNavigator($this->room['crid'], $tourl);
        $enabled = false;
        if (!empty($nav)) {
            foreach ($nav as $nitem) {
                if ($nitem['code'] == 'fineware' && $nitem['available'] == 1) {
                    $enabled = true;
                    break;
                }
            }
        }
        if (!$enabled) {
            header('Location:/');
            exit();
        }*/
        $roomdetail = $model->getClassroomDetail($this->room['crid']);
        $room_type = Ebh::app()->room->getRoomType();
        $modules = $model->getPortfolioConfig($this->room['crid'], $room_type == 'com' ? 1 : 0);
        $qcode_module = array_filter($modules, function($item) {
            return $item['mid'] == 13;
        });
        //$roomdetail = array($this->room, $roomdetail);
        if (!empty($qcode_module)) {
            $qcode_module = current($qcode_module);
            if (!empty($qcode_module['custom_data']['options'][0]['image'])) {
                $global_qcode = show_plate_img($qcode_module['custom_data']['options'][0]['image']);
                $this->assign('global_qcode', $global_qcode);
            }
            if (empty($global_qcode)) {
                $roommodel = $this->model('classroom');
                $roomdetail  = $roommodel->getclassroomdetail($this->room['crid']);
                $global_qcode = $roomdetail['wechatimg'];
                $this->assign('global_qcode', $global_qcode);
            }
        }
        //客服浮窗
        if(isset($roomdetail['kefuqq']) && $roomdetail['kefuqq'] != '0'){
            $roomdetail['kefu'] = explode(',',$roomdetail['kefu']);
            $roomdetail['kefuqq']= explode(',',$roomdetail['kefuqq']);
        }
        $inner_data = array();
        $inner_data['title'] = empty($master['realname']) ? '名师团队' : $master['realname'];

        $surveyid = $this->_need_survery($this->room['crid'], $this->user);
        if (!empty($surveyid)) {
            $inner_data['surveyid'] = $surveyid;
        }
        $folderids = $model->getMasterFolderids($teacherid, $this->room['crid']);
        $items = $this->model('Plate')->payItemList($this->room['crid'], array(
            'folderids' => $folderids,
            'formaster' => 1
        ));
        if (!empty($items)) {
            $isalumni = false;//用户是否是校友
            if (!empty($this->user)) {
                $isalumni = $model->isAlumni($this->room['crid'], $this->user['uid']);
            }
            $this->_pageItem($items, $isalumni);
            if (!empty($this->user)) {
                $folderid_arr = array_column($items, 'folderid');
                $folderid_arr = array_unique($folderid_arr);
                $inner_data['userpermisions'] = $model->getUserpermisions($this->user['uid'], $folderid_arr, $this->room['crid']);
                unset($folderid_arr);
            }
            $inner_data['items'] = $items;
        }

        $api = Ebh::app()->getApiServer('ebh');
        $uid = !empty($this->user) && $this->user['groupid'] == 6 ? $this->user['uid'] : 0;
        $bundles = $api->reSetting()
            ->setService('CourseService.Bundle.teacherBundleList')
            ->addParams('tid', $teacherid)
            ->addParams('crid', $this->room['crid'])
            ->addParams('uid', $uid)
            ->request();
        if (!empty($bundles)) {
            array_walk($bundles, function(&$bundle, $k, $defaultImg) {
                if (empty($bundle['cover'])) {
                    $bundle['cover'] = $defaultImg;
                    $bundle['viewnum'] = 0;
                    foreach ($bundle['cids'] as $cid) {
                        $bundle['viewnum'] += $this->getViewnum('folder', $cid);
                    }
                    unset($bundle['cids']);
                }
                if (!empty($bundle['hasPower'])) {
                    $folderid = $bundle['cids'][0];
                    $bundle['url'] = sprintf('/myroom.html?url=/myroom/college/study/cwlist/%s.html', $folderid);
                } else if ($bundle['bprice'] > 0) {
                    $bundle['url'] = '/ibuy.html?bid='.$bundle['bid'];
                }
            }, $this->course_viewholder);
            //测试代码
            //$bundles = array_fill(0,10, reset($bundles));
            $inner_data['bundles'] = $bundles;
        }
        //print_r($bundles);exit;
        $inner_data['user'] = $this->user;
        $inner_data['master'] = $master;
        if (!empty($this->room['isdesign'])) {
            $inner_data['design'] = true;
        }
        $this->assign('inner_view', 'shop/plate/master-detail');
        $this->assign('inner_data', $inner_data);
        $this->_template($model, $roomdetail);
        //手机跳转到手机页面
        if (is_mobile()) {
            $this->display('shop/plate/portfolio_master_mobile');
            exit;
        }
        $this->display('shop/plate/portfolio');
    }

    /**
     * 用户名称
     * @param $user
     * @return mixed
     */
    public function show_name($user) {
        if (empty($user)) {
            return '　';
        }
        if (!empty($user['realname'])) {
            return $user['realname'];
        }
        return $user['username'];
    }

    /**
     * 课程目录
     */
    public function course_directory() {
        $folderid = intval($this->input->get('fid'));
        $model = $this->model('portfolio');
        $param = parsequery();
        if (empty($param['q'])) {
            $param['q'] = '';
        }
        $param['pagesize'] = 20;
        $directory = $model->getFolderDirectories($this->room['crid'], $folderid, $param['page'], $param['pagesize'],$param['q']);
        //判断是否开通了单课收费，限于学生账号
        if (!empty($this->user) && $this->user['groupid'] == 6) {
            if (!empty($directory[2])) {
                $cwidPay = '';
                foreach ($directory[2] as $value) {
                    if ($value['cwpay']) {
                        $cwidPay .= $value['cwid'].',';
                    }
                }
            }
            if (!empty($cwidPay)) {
                $payParam['uid'] = $this->user['uid'];
                $payParam['cwids'] = substr($cwidPay, 0,-1);
                $payParam['folderid'] = $folderid;
                $payParam['filterdate'] = 1;
                $payParam['crid'] = $this->room['crid'];
                $user_pay_cwids = $this->model('userpermission')->getUserPayCwList($payParam);
                if (!empty($user_pay_cwids) && !empty($directory[1])) {
                    foreach ($user_pay_cwids as $pvalue) {
                        $pay_cwids[] = $pvalue['cwid'];
                    }
                    foreach ($directory[1] as &$value) {//权限注入，判断是否开通
                        foreach ($value['items'] as &$ivalue) {
                            if (in_array($ivalue['cwid'], $pay_cwids)) {
                                $ivalue['showtype'] = 2;//开通过的
                            } else {
                                if ($ivalue['cwpay']) {
                                    if ($ivalue['looktime']) {
                                        $ivalue['showtype'] = 3;//试听的
                                    } else {
                                        $ivalue['showtype'] = 1;//需要开通，显示购买
                                    }
                                } else {
                                    $ivalue['showtype'] = 0;//不能单课购买，不显示开通
                                }
                            }
                        }
                    }
                } else if (!empty($directory[1])) {
                    foreach ($directory[1] as &$value) {//权限注入，判断是否开通
                        foreach ($value['items'] as &$ivalue) {
                            if ($ivalue['cwpay']) {
                                if ($ivalue['looktime']) {
                                    $ivalue['showtype'] = 3;//试听的
                                } else {
                                    $ivalue['showtype'] = 1;//需要开通，显示购买
                                }
                            } else {
                                $ivalue['showtype'] = 0;//不能单课购买，不显示开通
                            }
                        }
                    }
                }
            }
        } elseif (empty($this->user)) {
            if (!empty($directory[1])) {
                foreach ($directory[1] as &$value) {//权限注入，判断是否开通
                    foreach ($value['items'] as &$ivalue) {
                        if ($ivalue['cwpay']) {
                            if ($ivalue['looktime']) {
                                $ivalue['showtype'] = 3;//试听的
                            } else {
                                 $ivalue['showtype'] = 1;//需要开通，显示购买
                            }
                        } else {
                            $ivalue['showtype'] = 0;//不能单课购买，不显示开通
                        }
                    }
                }
            }
            $this->assign('nologin', 1);
        }
        $this->assign('directory', $directory[1]);
        $pagestr = ajaxpage($directory[0], $param['pagesize'], $param['page']);
        if (!empty($this->user) && $this->user['groupid'] == 6) {
            $system_info = $this->model('Systemsetting')->getSetting($this->room['crid']);
            $enabled = true;
            if (!empty($this->user) && $this->user['groupid'] == 6 && !empty($system_info['isbanbuy'])) {
                //判断是否本校学生
                $isStudent = $model->isAlumni($this->room['crid'], $this->user['uid']);
                $enabled = $isStudent;
            }
            $this->assign('enabled', $enabled);
        }
        $this->assign('pagestr', $pagestr);
        $this->display('shop/plate/course_info_directory');
    }
    /**
     * 课程介绍
     */
    public function course_info() {
        $folderid = intval($this->input->get('fid'));
        $foldermodel = $this->model('folder');
        $folder = $foldermodel->getfolderbyid($folderid);
        if(!empty($folder['introduce'])) {
            $folder['introduce'] = unserialize($folder['introduce']);
        }
        $this->assign('folder',$folder);
        $this->display('shop/plate/course_info');
    }
    /**
     * 课程任课教师
     */
    public function course_teachers() {
        $folderid = intval($this->input->get('fid'));
        $model = $this->model('portfolio');
        $param = parsequery();
        $param['pagesize'] = 5;
        $teachers = $model->getFolderTeachers($this->room['crid'], $folderid, $param['page'], $param['pagesize']);
        $this->assign('teachers', $teachers[1]);
        $pagestr = ajaxpage($teachers[0], $param['pagesize'], $param['page']);
        $this->assign('pagestr', $pagestr);
        $this->display('shop/plate/course_info_teachers');
    }
    /**
     * 课程资料下载
     */
    public function course_docs() {
        $folderid = intval($this->input->get('fid'));
        $model = $this->model('portfolio');
        $param = parsequery();
        $param['pagesize'] = 20;
        $attachments = $model->getAttachments($this->room['crid'], $folderid, $param['page'], $param['pagesize']);
        $this->assign('attachments', $attachments[1]);
        $pagestr = ajaxpage($attachments[0], $param['pagesize'], $param['page']);
        $this->assign('pagestr', $pagestr);
        $this->display('shop/plate/course_info_attachments');
    }

    /**
     * 删除免费试听课件
     */
    public function ajax_remove_free() {
        if ($this->isPost()) {
            if (empty($this->user) || $this->user['uid'] != $this->room['uid']) {
                echo json_encode(array(
                    'errno' => '2',
                    'msg' => '无权限执行此操作'
                ));
                exit();
            }
            $cwid = intval($this->input->post('cwid'));
            $model = $this->model('portfolio');
            if ($model->removeFreeCourseware($this->room['crid'], $cwid)) {
                echo json_encode(array(
                    'errno' => '0'
                ));
                exit();
            }
            echo json_encode(array(
                'errno' => '3',
                'msg' => '非法操作'
            ));
            exit();
        }
        echo json_encode(array(
            'errno' => '1',
            'msg' => '非法操作'
        ));
        exit();
    }

    /**
     * 获取免费试听列表
     */
    public function ajax_refresh_free() {
        $model = $this->model('portfolio');
        $freelist = $model->getFreeList($this->room['crid']);
        if (empty($freelist)) {
            $freelist = array();
        }
        echo json_encode($freelist, true);
    }

    /**
     * 删除富文本
     */
    public function ajax_remove_richtext() {
        if ($this->isPost()) {
            $eid = intval($this->input->post('eid'));
            $model = $this->model('portfolio');
            $model->deleteRichText($eid, $this->room['crid']);
        }

    }

    /**
     * 设置名师团队
     */
    public function ajax_set_masters() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法操作'
            ));
            exit();
        }
        $masterids = $this->input->post('masterids');
        if (empty($masterids)) {
            $masterids = array();
        } else {
            if (is_array($masterids)) {
                $masterids = array_map('intval', $masterids);
                $masterids = array_unique($masterids);
            } else {
                $masterids = array(intval($masterids));
            }
        }

        $model = $this->model('Portfolio');
        $storeids = $model->getMasterIds($this->room['crid']);
        $addids = array_diff($masterids, $storeids);
        $removeids = array_diff($storeids, $masterids);

        $addCount = 0;
        $removeCount = 0;
        if (!empty($addids)) {
            foreach ($addids as $addid) {
                if ($model->addMaster($addid, $this->room['crid'])) {
                    $addCount++;
                }
            }
        }
        if (!empty($removeids)) {
            foreach ($removeids as $removeid) {
                if ($model->removeMaster($removeid, $this->room['crid'])) {
                    $removeCount++;
                }
            }
        }
        echo json_encode(array(
            'errno' => 0,
            'msg' => '添加'.$addCount.'位名师，删除'.$removeCount.'位名师',
            'data' => array(
                'add' => $addCount,
                'delete' => $removeids
            )
        ));
        exit();
    }

    /**
     * 删除名师
     */
    public function ajax_remove_master() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法操作'
            ));
            exit();
        }
        $masterid = intval($this->input->post('masterid'));
        if ($masterid < 1) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '参数错误'
            ));
            exit();
        }
        $ret = $this->model('Portfolio')->removeMaster($masterid, $this->room['crid']);
        echo json_encode(array(
            'errno' => 0,
            'msg' => '删除成功',
            'data' => $ret
        ));
        exit();
    }

    /**
     * 排序免费试听
     */
    public function ajax_order_freeware() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法操作'
            ));
            exit();
        }
        $cwids = $this->input->post('cwids');
        if (!is_array($cwids)) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '参数错误'
            ));
            exit();
        }
        $affected_rows = $this->model('Portfolio')->orderFreeware($cwids, $this->room['crid']);
        if ($affected_rows === false) {
            echo json_encode(array(
                'errno' => 3,
                'msg' => '排序失败'
            ));
            exit();
        }
        echo json_encode(array(
            'errno' => 0,
            'data' => $affected_rows
        ));
    }
    /**
     * 排序名师团队
     */
    public function ajax_order_master() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法操作'
            ));
            exit();
        }
        $tids = $this->input->post('tids');
        if (!is_array($tids)) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '参数错误'
            ));
            exit();
        }
        $affected_rows = $this->model('Portfolio')->orderMasters($tids, $this->room['crid']);
        if ($affected_rows === false) {
            echo json_encode(array(
                'errno' => 3,
                'msg' => '排序失败'
            ));
            exit();
        }
        echo json_encode(array(
            'errno' => 0,
            'data' => $affected_rows
        ));
    }

    /**
     * 更新自选课程
     */
    public function ajax_update_manualcourse() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法操作'
            ));
            exit();
        }
        $adds = $this->input->post('adds');
        $dels = $this->input->post('dels');
        if (empty($adds) && empty($dels)) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '参数为空，禁止操作'
            ));
            exit();
        }
        $this->model('Plate')->datchUpdateManualCourse($adds, $dels, $this->room['crid']);
        echo json_encode(array(
            'errno' => 0
        ));
        exit();
    }

    /**
     * 删除自选课程
     */
    public function ajax_del_manualcourse() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法操作'
            ));
            exit();
        }
        $itemid = intval($this->input->post('itemid'));
        $ret = $this->model('Plate')->delManualCourse($itemid, $this->room['crid']);
        if ($ret === false) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '删除失败'
            ));
            exit();
        }
        echo json_encode(array(
            'errno' => 0,
            'msg' => '删除成功',
            'data' => $ret
        ));
        exit();
    }

    /**
     * 设置默认课程导航菜单
     */
    public function ajax_located_course() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法操作'
            ));
            exit();
        }
        $pid = intval($this->input->post('pid'));
        if ($pid < 1) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '参数错误'
            ));
            exit();
        }
        $ret = $this->model('Plate')->locatedPackage($pid, $this->room['crid']);
        echo json_encode(array(
            'errno' => 0,
            'data' => $ret
        ));
        exit();
    }

    /**
     * 格式化新闻封面路径
     * @param $url
     * @return bool|string
     */
    function show_plate_news_img($url) {
        if (empty($url)) {
            return false;
        }
        if (stripos($url, 'http://') === false) {
            $filename = explode('.', $url);
            return sprintf('%s%s_th.%s', $this->baseurl, $filename[0], $filename[1]);
        }
        return $url;
    }

    /**
     * 验证用户登录后的课程权限，返回下一步骤路径
     */
    public function ajax_check_userpermisions() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法操作'
            ));
            exit();
        }

        if (empty($this->user)) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '未登录'
            ));
            exit();
        }

        if ($this->user['groupid'] == 5) {
            echo json_encode(array(
                'errno' => 3,
                'msg' => '教师账号，不允许进行此操作'
            ));
            exit();
        }

        $itemid = intval($this->input->post('itemid'));
        $model = $this->model('portfolio');

        $item = $model->getSinglePayItem($this->room['crid'], $itemid);
        if (empty($item)) {
            echo json_encode(array(
                'errno' => 4,
                'msg' => '参数错误'
            ));
            exit();
        }
        $showimg = $item['showimg'];
        if (empty($showimg)) {
            $showimg = $this->course_viewholder;
        }
        $img = show_plate_course_cover($showimg);
        $img = show_thumb($img);
        $item['showimg'] = $img;
        $folderid = $item['folderid'];
        if (!empty($item['group_members'])) {
            $folderid = array_keys($item['group_members']);
        }
        $userpermision = $model->getUserpermisions($this->user['uid'], $folderid, $this->room['crid']);
        $url = $this->format_pay_item_url($item, $userpermision);
        $item['url'] = $url;
        echo json_encode(array(
            'errno' => 0,
            'data' => array(
                'item' => $item
            )
        ));
        exit();
    }

    /**
     * 处理价格为0课件列表下一流程网址
     * @param $pay_item
     * @param $userpermisions
     * @return bool|int|string
     */
    public function format_pay_item_url(&$pay_item, $userpermisions) {
        if (!empty($pay_item['cannotpay'])) {
            //不能支付
            return null;
        }
        if (empty($this->user)) {
            //用户未登录
            return false;
        }
        if ($this->user['groupid'] == 5) {
            //教师用户
            return '';
        }
        $allow = false;//$pay_item['fprice'] == 0;
        if (!$allow && is_array($userpermisions)) {
            //判断是否具有课程权限
            $allow = in_array($pay_item['folderid'], $userpermisions);
        }
        if ($allow) {
            //具有课程权限,直接进入学习
            $pay_item['allow'] = true;
            if (empty($this->room['iscollege'])) {
                return sprintf('/myroom/stusubject/%s.html', $pay_item['folderid']);
            }
            if ($pay_item['showmode'] == 3) {
                return sprintf('/myroom/college/study/introduce/%s.html', $pay_item['folderid']);
            }
            return sprintf('/myroom.html?url=/myroom/college/study/cwlist/%s.html', $pay_item['folderid']);
        }
        $model = $this->model('Portfolio');
        $is_alumni = $model->isAlumni($this->room['crid'], $this->user['uid']);

        if ($pay_item['sid'] == 0 || empty($pay_item['showbysort'])) {
            //判断是否为全校免费课程，是：价格置0处理
            if ($pay_item['iprice'] == 0 || !empty($pay_item['isschoolfree']) && $is_alumni) {
                //零散服务项价格为0
                return 0;
            }
        }
        if (!empty($pay_item['showbysort'])) {
            //捆绑销售处理
            if (!empty($pay_item['group_members'])) {
                $isfree = true;
                foreach ($pay_item['group_members'] as $group_member) {
                    if ($group_member['iprice'] > 0 || empty($pay_item['isschoolfree']) || !$is_alumni) {
                        $isfree = false;
                        break;
                    }
                }
                if ($isfree) {
                    //捆绑销售服务项价格都为0
                    return 0;
                }
            }

            $sum_price = $model->sortsCountPrice($pay_item['sid']);
            if (empty($sum_price) || $sum_price == 0) {
                return 0;
            }
        }
        //服务项价格大于0
        if ($this->room['domain'] == 'yxwl') {
            return '/classactive/bank.html';
        }
        if (!empty($pay_item['showbysort'])) {
            return sprintf('/ibuy.html?itemid=%d&sid=%d', $pay_item['itemid'], $pay_item['sid']);
        }
        if ($pay_item['sid'] > 0 && (empty($pay_item['crid']) || $pay_item['crid'] == $this->room['crid'])) {
            return sprintf('/ibuy.html?itemid=%d', $pay_item['itemid']);
        }

        return sprintf('/ibuy.html?itemid=%d', $pay_item['itemid']);
    }

    /**
     * 课程列表网址分类
     * @param $empty_value
     * @return string
     */
    public function sign_status($empty_value) {
        if ($empty_value === null) {
            return ' plate-sign-disabled';
        }
        if ($empty_value === false) {
            //未登录
            return ' plate-sign-unlogin';
        }
        if ($empty_value === '') {
            //教师用户
            return ' plate-sign-unallow';
        }
        if ($empty_value === 0) {
            //免费课程
            return ' plate-sign-free';
        }
        return '';
    }

    /**
     * 显示大数字
     * @param $num 数字
     * @param $len 限制长度
     * @return string
     */
    public function large($num, $len) {
        $str = strval($num);
        if (strlen($str) > $len) {
            return str_repeat('9', $len - 1).'+';
        }
        return $str;
    }

    /////////临时代码，删除三个学生的网校权限
    private function __adjust_err() {
        $uid_arr = array(
            'jxh871' => 10299,
            'xs00002' => 12190,
            'xs00003' => 3124099
        );
        $db = Ebh::app()->getdb();
        $sql = "SELECT `crid`,`uid` FROM `ebh_roomusers` WHERE `uid`=10299";
        $roomuser1 = $db->query($sql)->list_array('crid');
        $sql = "SELECT `crid`,`uid` FROM `ebh_roomusers` WHERE `uid`=12190";
        $roomuser2 = $db->query($sql)->list_array('crid');
        $sql = "SELECT `crid`,`uid` FROM `ebh_roomusers` WHERE `uid`=3124099";
        $roomuser3 = $db->query($sql)->list_array('crid');

        $roomuser = array_intersect_key($roomuser1, $roomuser2, $roomuser3);
        $crid_arr = array_keys($roomuser);
        if (empty($crid_arr)) {
            return;
        }
        $crid_arr_str = implode(',', $crid_arr);
        $start = strtotime('2016-12-20');
        $sql = "SELECT `crid`,`crname`,`domain` FROM `ebh_classrooms` WHERE `crid` IN($crid_arr_str) AND `dateline`>$start";
        $remove_students = $db->query($sql)->list_array();
        if (empty($remove_students)) {
            return;
        }
        foreach ($remove_students as $remove_student) {
            $db->query("DELETE FROM `ebh_roomusers` WHERE `uid`=10299 AND `crid`={$remove_student['crid']}");
            $db->query("DELETE FROM `ebh_roomusers` WHERE `uid`=12190 AND `crid`={$remove_student['crid']}");
            $db->query("DELETE FROM `ebh_roomusers` WHERE `uid`=3124099 AND `crid`={$remove_student['crid']}");
        }
    }


    public function ___count_courseware() {
        $db = Ebh::app()->getDb();
        $num = 10;
        $folderid_arr = $db->query("SELECT `folderid` FROM `ebh_folders` WHERE `coursewarenum`<0 LIMIT $num")->list_field();
        if (empty($folderid_arr)) {
            die("处理完成");
        }
        $folderid_arr_str = implode(',', $folderid_arr);
        $folder_courseware_count = $db->query("SELECT `a`.`folderid`,COUNT(1) AS `c` FROM `ebh_roomcourses` `a` JOIN `ebh_coursewares` `b` ON `a`.`cwid`=`b`.`cwid` WHERE `a`.`folderid` IN($folderid_arr_str) AND `b`.`status`>=0 and crid=10622 GROUP BY `folderid`")->list_array('folderid');
        foreach ($folder_courseware_count as $k => $item) {
            $db->update('ebh_folders', array(
                'coursewarenum' => $item['c']
            ), "`folderid`=$k");
        }
    }

    /**
     * 分类菜单背景颜色主题映射
     * @param $bgcolor
     * @return string
     */
    private function _get_course_menu_theme($bgcolor) {
        switch ($bgcolor) {
            case 'ff9b28ae':
                return 'theme_1';
            case 'ff663db5':
                return 'theme_2';
            case 'ff4052b4':
                return 'theme_3';
            case 'ff1f96f2':
                return 'theme_4';
            case 'ffff753f':
                return 'theme_5';
            case 'ff00bcd2':
                return 'theme_6';
            case 'fffea000':
                return 'theme_7';
            case 'fff2c300':
                return 'theme_8';
            case 'ffb7c500':
                return 'theme_9';
            case 'ff89c34a':
                return 'theme_10';
            case 'ff4daf51':
                return 'theme_11';
            case 'ff009687':
                return 'theme_12';
            case 'fff47d00':
                return 'theme_13';
            case 'fff34637':
                return 'theme_14';
            case 'ffe71e62':
                return 'theme_15';
            case 'ffc11759':
                return 'theme_16';
        }
        return '';
    }

    function getViewnum($type,$id, $default = null){
        $redis = Ebh::app()->getCache('cache_redis');
        $viewnum = $redis->hget($type.'viewnum',$id);
        if (empty($viewnum)) {
            return intval($default);
        }
        return intval($viewnum);
    }

    /**
     * 自选课程面板
     */
    public function get_manual_panel() {
        $model = $this->model('Plate');
        //本校课程
        $datas = $model->getManualCourseList($this->room['crid']);
        //第三方选课课程
        $others = $model->getSourceCourseList($this->room['crid']);
        //已选择的课程ID集
        $manuals = $model->getManualCourseidList($this->room['crid']);
        //课程来源网校
        $classrooms = array(
            $this->room['crid'] => array(
                'sourcecrid' => $this->room['crid'],
                'name' => '本校课程'
            )
        );
        $packages = $sorts = array();
        $firstPid = false;
        if (!empty($datas)) {
            //提取本校服务包、服务项
            //初始定位的服务包ID与服务包分类ID
            $firstSid = false;
            foreach ($datas as $k => $dataitem) {
                if (!isset($packages[$dataitem['pid']])) {
                    $packages[$dataitem['pid']] = array(
                        'pname' => $dataitem['pname'],
                        'crid' => $this->room['crid']
                    );
                    if ($firstPid === false) {
                        $firstPid = $dataitem['pid'];
                        $packages[$dataitem['pid']]['cur'] = 1;
                    }
                }

                if ($dataitem['sid'] == 0) {
                    $packages[$dataitem['pid']]['hasOther'] = 1;
                }
                $skey = $dataitem['pid'].'-'.$dataitem['sid'];
                if (!isset($sorts[$skey])) {
                    $sorts[$skey] = array(
                        'sname' => $dataitem['sname'],
                        'pid' => $dataitem['pid'],
                        'sid' => $dataitem['sid'],
                        'crid' => $this->room['crid']
                    );
                    if ($firstPid === $dataitem['pid']) {
                        $sorts[$skey]['show'] = 1;
                    }
                    if ($firstSid === false) {
                        $firstSid = $dataitem['sid'];
                        $sorts[$skey]['cur'] = true;
                    }
                }
                $showimg = $dataitem['img'];
                if (empty($showimg)) {
                    $showimg = $this->course_viewholder;
                }
                $img = show_plate_course_cover($showimg);
                $img = show_thumb($img);
                $datas[$k]['img'] = $img;
                $datas[$k]['sourcecrid'] = $this->room['crid'];
                //课程已选择
                $datas[$k]['ati'] = isset($manuals[$dataitem['itemid']]) ? 1 : 0;
                if ($firstSid === $dataitem['sid'] && $firstPid === $dataitem['pid']) {
                    $datas[$k]['show'] = 1;
                }
            }
        }

        if (!empty($others)) {
            //提交第三方网校服务包、服务项
            $sourcecrids = array_column($others, 'sourcecrid');
            $sourcecrids = array_unique($sourcecrids);
            $sources = $model->getSourceList($this->room['crid'], $sourcecrids, true);
            $classrooms = $classrooms + $sources;
            unset($sourcecrids, $sources);
            foreach ($others as $k => $otheritem) {
                $showimg = $otheritem['img'];
                if (empty($showimg)) {
                    $showimg = $this->course_viewholder;
                }
                $img = show_plate_course_cover($showimg);
                $img = show_thumb($img);
                $others[$k]['img'] = $img;
                //课程已选择
                $others[$k]['ati'] = isset($manuals[$otheritem['itemid']]) ? 1 : 0;
                if (!isset($packages[$otheritem['pid']])) {
                    $packages[$otheritem['pid']] = array(
                        'pname' => $otheritem['pname'],
                        'crid' => $otheritem['sourcecrid']
                    );
                }

                if ($otheritem['sid'] == 0) {
                    $packages[$otheritem['pid']]['hasOther'] = 1;
                }
                $skey = $otheritem['pid'].'-'.$otheritem['sid'];
                if (isset($sorts[$skey])) {
                    continue;
                }
                $sorts[$skey] = array(
                    'sname' => $otheritem['sname'],
                    'pid' => $otheritem['pid'],
                    'sid' => $otheritem['sid'],
                    'crid' => $otheritem['sourcecrid']
                );
            }
        }

        $this->assign('datas', $datas);
        $this->assign('others', $others);
        $this->assign('packages', $packages);
        $this->assign('sorts', $sorts);
        $this->assign('classrooms', $classrooms);
        $this->assign('crid', $this->room['crid']);
        $this->assign('firstPid', $firstPid);
        $this->display('shop/plate/manual_panel');
    }

    /**
     * 选择课程包面板
     */
    public function get_bundles_panel() {
        $api = Ebh::app()->getApiServer('ebh');
        $bundles = $api->reSetting()
            ->setService('CourseService.Bundle.index')
            ->addParams('crid', $this->room['crid'])
            ->addParams('showtype', 1)
            ->request();
        if (!empty($bundles['list'])) {
            $packages = $sorts = array();
            foreach ($bundles['list'] as $k => $v) {
                if (empty($v['cover'])) {
                    $bundles['list'][$k]['cover'] = $this->course_viewholder;
                }
                if (!isset($packages[$v['pid']])) {
                    $packages[$v['pid']] = array(
                        'pid' => $v['pid'],
                        'pname' => $v['pname'],
                        'displayorder' => $v['pdisplayorder']
                    );
                }
                unset($bundles['list'][$k]['pdisplayorder']);
                if (!isset($sorts[$v['sid']])) {
                    $sorts[$v['sid']] = $v['sname'];
                }
            }
            $pids = array_keys($packages);
            $packageorders = array_column($packages, 'displayorder');
            array_multisort($packageorders, SORT_ASC, SORT_NUMERIC,
                $pids, SORT_DESC, SORT_NUMERIC, $packages);
            unset($pids, $packageorders);
            //$packages = array_fill(0,30, reset($packages));
            $firstPackage = reset($packages);
            //print_r($firstPackage);exit;
            $this->assign('pid', $firstPackage['pid']);
            $this->assign('packages', $packages);
            $this->assign('sorts', $sorts);
            $this->assign('bundles', $bundles['list']);
        }
        $this->display('shop/plate/bundles_panel');
    }

    /**
     * 大数显示
     * @param $number 数字
     * @param $len 长度
     * @return string
     */
    public function formatBigNumber($number, $len) {
        $length = strval($number);
        if ($length >= $len) {
            $max = intval(str_repeat('9', $len));
            if ($number <= $max) {
                return $number;
            }
            return str_repeat('9', $len - 1).'+';
        }
        return $number;
    }

    /**
     * 删除课程包
     */
    public function ajax_del_bundle() {
        if (!$this->isPost()) {
            echo json_encode(array('errno' => 1, 'msg' => '非法访问'));
            exit();
        }
        $bid = intval($this->input->post('bid'));
        if ($bid < 1) {
            echo json_encode(array('errno' => 1, 'msg' => '参数错误'));
            exit();
        }
        $api = Ebh::app()->getApiServer('ebh');
        $ret = $api->reSetting()
            ->setService('CourseService.Bundle.setAttibute')
            ->addParams('crid', $this->room['crid'])
            ->addParams('bid', $bid)
            ->addParams('display', 0)
            ->addParams('displayorder', 0)
            ->request();
        if ($ret === false) {
            echo json_encode(array('errno' => 1, 'msg' => '课程包删除错误'));
            exit();
        }
        echo json_encode(array('errno' => 0));
        exit();
    }

    /**
     * 选择课程包
     */
    public function ajax_update_bundles() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法操作'
            ));
            exit();
        }
        $adds = $this->input->post('adds');
        $dels = $this->input->post('dels');
        if (empty($adds) && empty($dels)) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '参数为空，禁止操作'
            ));
            exit();
        }
        $api = Ebh::app()->getApiServer('ebh');
        $ret = $api->reSetting()
            ->setService('CourseService.Bundle.setVisibility')
            ->addParams('crid', $this->room['crid'])
            ->addParams('adds', $adds)
            ->addParams('dels', $dels)
            ->request();
        if ($ret === false) {
            echo json_encode(array('errno' => 1, 'msg' => '课程包设置失败'));
            exit();
        }
        echo json_encode(array(
            'errno' => 0
        ));
        exit();
    }

    /**
     * 课程包详情
     */
    public function ajax_check_bundle() {
        if (!$this->isPost()) {
            echo json_encode(array('errno' => 1, 'msg' => '非法操作'));
            exit();
        }
        if (empty($this->user)) {
            echo json_encode(array('errno' => 2, 'msg' => '未登录'));
            exit();
        }
        $bid = intval($this->input->post('bid'));
        if ($bid < 1) {
            echo json_encode(array('errno' => 3, 'msg' => '缺少参数'));
            exit();
        }
        $api = Ebh::app()->getApiServer('ebh');
        $ret = $api->reSetting()
            ->setService('CourseService.Bundle.detail')
            ->addParams('crid', $this->room['crid'])
            ->addParams('bid', $bid)
            ->addParams('uid', $this->user['uid'])
            ->request();
        if (empty($ret)) {
            echo json_encode(array('errno' => 4, 'msg' => '课程包不存在'));
            exit();
        }
        if (!empty($ret['hasPower'])) {
            foreach ($ret['courses'] as $course) {
                if (empty($this->room['iscollege'])) {
                    $ret['url'] = sprintf('/myroom/stusubject/%s.html', $course['folderid']);
                } else if ($course['showmode'] == 3) {
                    $ret['url'] = sprintf('/myroom/college/study/introduce/%s.html', $course['folderid']);
                } else {
                    $ret['url'] = sprintf('/myroom.html?url=/myroom/college/study/cwlist/%s.html', $course['folderid']);
                }
                break;
            }
        } else if ($ret['bprice'] == 0) {
            //$ret['url'] = '0';
        } else {
            $ret['url'] = '/ibuy.html?bid='.$ret['bid'];
        }
        if (empty($ret['cover'])) {
            $ret['cover'] = $this->course_viewholder;
        }
        $ret['crname'] = $this->room['crname'];
        echo json_encode(array(
           'errno' => 0,
            'data' => $ret
        ));
        exit();
    }

    public function verify() {
        sleep(2);echo 'fff';
    }

    /**
     * 检查打包服务分类
     */
    public function ajax_check_sort() {
        if (!$this->isPost()) {
            echo json_encode(array('errno' => 1, 'msg' => '非法操作'));
            exit();
        }
        if (empty($this->user)) {
            echo json_encode(array('errno' => 2, 'msg' => '未登录'));
            exit();
        }
        $sid = intval($this->input->post('sid'));
        if ($sid < 1) {
            echo json_encode(array('errno' => 3, 'msg' => '缺少参数'));
            exit();
        }
        $api = Ebh::app()->getApiServer('ebh');
        $ret = $api->reSetting()
            ->setService('CourseService.Course.sort')
            ->addParams('crid', $this->room['crid'])
            ->addParams('sid', $sid)
            ->addParams('uid', $this->user['uid'])
            ->request();
        if (empty($ret)) {
            echo json_encode(array('errno' => 4, 'msg' => '打包课程不存在'));
            exit();
        }
        if (!empty($ret['hasPower'])) {
            if (empty($this->room['iscollege'])) {
                $ret['url'] = sprintf('/myroom/stusubject/%s.html', $ret['folderid']);
            } else if ($ret['showmode'] == 3) {
                $ret['url'] = sprintf('/myroom/college/study/introduce/%s.html', $ret['folderid']);
            } else {
                $ret['url'] = sprintf('/myroom.html?url=/myroom/college/study/cwlist/%s.html', $ret['folderid']);
            }
        } else if ($ret['price'] == 0) {
            //$ret['url'] = '0';
        } else if (!empty($ret['showbysort'])) {
            $ret['url'] = '/ibuy.html?sid='.$ret['sid'];
        } else {
            $ret['url'] = '/ibuy.html?sid='.$ret['sid'].'&itemid='.$ret['itemid'];
        }
        if (empty($ret['imgurl'])) {
            $ret['imgurl'] = $this->course_viewholder;
        }
        $ret['crname'] = $this->room['crname'];
        $ret['content'] = strip_tags($ret['content']);
        echo json_encode(array(
            'errno' => 0,
            'data' => $ret
        ));
        exit();
    }

    /**
     * 课程目录
     */
    public function course_directory_mobile() {
        $folderid = intval($this->input->get('folderid'));
        $param['page'] = intval($this->input->get('page'));
        $param['crid'] = intval($this->input->get('crid'));
        $param['pagesize'] = 20;
        $param['folderid'] = $folderid;
        $this->apiServer = Ebh::app()->getApiServer('ebh'); 
        $directory = $this->apiServer->reSetting()->setService('Classroom.Folder.getFolderDirectories')->addParams($param)->request();
        if (!empty($directory[1])) {
            echo json_encode(array_values($directory[1]));
        } else {
            echo json_encode(array());
        }
    }

    /**
     * 报名课程大类列表
     */
    public function getMorePackageList(){
        $api = Ebh::app()->getApiServer('ebh');
        $categorys = $api->reSetting()
            ->setService('CourseService.StudyService.courseCategoryList')
            ->addParams('crid', $this->room['crid'])
            ->request();
        renderjson(0, '', $categorys);
    }

    /**
     *获取共用的头部和尾部数据
     */
    public function getHeaderAndFooter($roomdetail=NULL) {
        $model = $this->model('portfolio');
        if (!empty($this->user)) {
            $this->user['isadmin'] = $this->user['groupid'] == 5;
            $this->user['showname'] = !empty($this->user['realname']) ? shortstr($this->user['realname'], 8, ''): shortstr($this->user['username'], 8, '');
            $this->user['face'] = getavater($this->user, '120_120');
            $user = array(
                'username' => $this->user['username'],
                'showname' => $this->user['showname'],
                'groupid' => $this->user['groupid'],
                'isadmin' => $this->user['isadmin'],
                'face' => $this->user['face'],
                'lastlogtime' => $this->user['lastlogintime']
            );
            $this->assign('plateUser', $user);
        }
        if (!empty($this->room)) {
            $room = array(
                'crname' => $this->room['crname'],
                'crphone' => $this->room['crphone'],
                'kefuqq' => $this->room['kefuqq'],
                'summary' => $this->room['summary'],
                'wechatimg' => $this->room['wechatimg'],
                'cface' => $this->room['cface'],
                'lat' => $this->room['lat'],
                'lng' => $this->room['lng'],
                'craddress' => $this->room['craddress']
            );
            $this->assign('plateRoom', $room);
        }
        $this->assign('user', $this->user);
        $this->assign('roominfo', $this->room);
        if (empty($roomdetail)) {
            $roomdetail = $model->getClassroomDetail($this->room['crid']);
        }
        $roomdetail['isdesign'] = $this->room['isdesign'];
        if (!empty($roomdetail['isdesign'])) {
            $room_type = Ebh::app()->room->getRoomType();
            $apiServer = Ebh::app()->getApiServer('ebh');
            $roomtype = Ebh::app()->room->getRoomType();
            $ret = $apiServer->reSetting()
                ->setService('Classroom.Design.getdesign')
                ->addParams('crid', $roomdetail['crid'])
                ->addParams('roomtype', $room_type)
                ->addParams('clientType', is_mobile())
                ->request();
            if (!empty($ret['status'])) {
                $this->assign('head', str_replace('\"', '"', $ret['data']['head']));
                $this->assign('foot', str_replace('\"', '"', $ret['data']['foot']));
                $settings = str_replace('\"', '"', $ret['data']['settings']);
                $settings = json_decode($settings, true);
                $this->assign('settings', $settings);
            }
        }
    }

    /**
     * 加载局部页
     * @param $view view文件相对路径
     * @param array $vars 局部变量池
     * @param bool $inherit 是否继承父级变量
     * @param bool $isload 是否直接加载，否：返回view渲染后的数据
     * @return bool|string
     */
    public function partial2($view, $vars = array(), $inherit = false, $isload = true) {
        $viewpath = VIEW_PATH.$view.'.php';
        if(!file_exists($viewpath)) {
            echo 'error view not exists:'.$viewpath;
            return false;



        }

        if ($inherit) {
            extract($this->get_vars(null));
        }
        extract($vars, EXTR_OVERWRITE);
        unset($vars, $inherit, $view);
        if ($isload) {
            unset($isload);
            include $viewpath;
            return true;
        }
        unset($isload);
        ob_start();
        include $viewpath;
        $outputstr = ob_get_contents();
        @ob_end_clean();
        return $outputstr;
    }
}
