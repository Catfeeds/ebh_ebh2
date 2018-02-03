<?php
/**
 * 网校装扮
 * Author: eker
 * Email: eker-huang@outlook.com
 */
class DesignController extends CControl {
    private $user;
    private $room;

    public function __construct(){
        parent::__construct();
        $this->user = Ebh::app()->user->getloginuser();
        $this->room = Ebh::app()->room->getcurroom();
        $this->checkAllowOrigin();
    }

    /**
     * 首页装扮--编辑页
     */
    public function index(){
        $did = $this->get_vars('did');
        $returnurl = urlencode($_SERVER['REQUEST_URI'].(!empty($did) ? '#/?did='.$did : ''));
        //验证权限
        if (empty($this->user)) {
            $loginurl = empty($this->room) ? 'http://www.ebh.net/admin.html?returnurl='.$returnurl : '/login.html?returnurl='.$returnurl;
        } else if (!empty($this->room) && $this->user['uid'] != $this->room['uid']) {
			$loginurl = '/login.html?returnurl='.$returnurl;
        }
        if (!empty($loginurl)) {
            header('location:'.$loginurl);
            exit();
        }
        $systemsetting = !empty($this->room) ? Ebh::app()->room->getSystemSetting() : array();
        $room = $this->room;
        if (empty($room)) {
            $room = array(
                'crid' => 0,
                'crname' => '通用模板',
                'property' => 0,
                'domain' => 'www',
                'template' => 'plate',
                'upid' => 0,
                'isschool' => 7,
                'summary' => ''
            );
        }
        //加上subtitle/favicon
        $room['favicon'] = '';
        $room['subtitle'] = '';

        if(!empty($systemsetting['favicon'])){
            $room['favicon'] = $systemsetting['favicon'];
        }
        if(!empty($systemsetting['subtitle'])){
            $room['subtitle'] = $systemsetting['subtitle'];
        }
        $this->room = $room;
        $this->assign('roominfo', $room);
        //渲染模板
        $this->display('room/design/index');
    }

    /**
     * 首页装扮模板--编辑页
     */
    public function view() {
        $did = intval($this->uri->itemid);
        $_GET['did'] = $did;
        $this->assign('did', $did);
        $this->index();
    }

    /**
     * 装扮移动端
     */
    public function mobile() {
        $did = $this->get_vars('did');
        $returnurl = urlencode($_SERVER['REQUEST_URI'].(!empty($did) ? '#/?did='.$did : ''));
        //验证权限
        if (empty($this->user)) {
            $loginurl = empty($this->room) ? 'http://www.ebh.net/admin.html?returnurl='.$returnurl : '/login.html?returnurl='.$returnurl;
        } else if (!empty($this->room) && $this->user['uid'] != $this->room['uid']) {
			$loginurl = '/login.html?returnurl='.$returnurl;
        }
        if (!empty($loginurl)) {
            header('location:'.$loginurl);
            exit();
        }
        $systemsetting = !empty($this->room) ? Ebh::app()->room->getSystemSetting() : array();
        $room = $this->room;
        if (empty($room)) {
            $room = array(
                'crid' => 0,
                'crname' => '通用模板',
                'property' => 0,
                'domain' => 'www',
                'template' => 'plate',
                'upid' => 0,
                'isschool' => 7,
                'summary' => ''
            );
        }
        //加上subtitle/favicon
        $room['favicon'] = '';
        $room['subtitle'] = '';

        if(!empty($systemsetting['favicon'])){
            $room['favicon'] = $systemsetting['favicon'];
        }
        if(!empty($systemsetting['subtitle'])){
            $room['subtitle'] = $systemsetting['subtitle'];
        }
        $this->room = $room;
        $this->assign('roominfo', $room);
        //渲染模板
        $this->display('room/design/mobile');
    }

    /**
     * 装扮移动端模板
     */
    public function mobile_view() {
        $did = intval($this->uri->itemid);
        $this->assign('did', $did);
        $this->mobile();
    }

    /**
     * 网校装扮--网校首页
     */
    public function home(){
        $user = $this->user;
        $room = $this->room;
		if (!empty($room['fulldomain']) && stripos($_SERVER['HTTP_HOST'], '.ebh.net') !== false) {
			header('Location:http://'.$room['fulldomain'].$_SERVER['REQUEST_URI']);
			exit();
		}
        $apiServer = Ebh::app()->getApiServer('ebh');
        $roomtype = Ebh::app()->room->getRoomType();
        $systemsetting = Ebh::app()->room->getSystemSetting();
        $clientType = 0;
        if (is_mobile()) {
            $clientType = 1;
        }
        $ret = $apiServer->reSetting()
            ->setService('Classroom.Design.getdesign')
            ->addParams('crid', $room['crid'])
            ->addParams('roomtype', $roomtype)
            ->addParams('clientType', $clientType)
            ->request();
        if ($clientType == 1 && empty($ret['data'])) {
            $clientType = 0;
            $ret = $apiServer->reSetting()
                ->setService('Classroom.Design.getdesign')
                ->addParams('crid', $room['crid'])
                ->addParams('roomtype', $roomtype)
                ->addParams('clientType', $clientType)
                ->request();
        }
        if (empty($ret['data'])) {
            Ebh::app()->runAction('room/portfolio', 'home');
            return;
        }
        //-----这部分数据 后期可以考虑加上缓存

        //新版网校配置没数据,则返回到老版本
        /*if(empty($ret['data'])){
            //设置isdesign
            $retrow = $apiServer->reSetting()
                    ->setService('Classroom.Design.reset')
                    ->addParams('crid', $room['crid'])
                    ->request();
           if(!empty($retrow) &&($retrow['status']==1)){
               $roomcache = Ebh::app()->lib('Roomcache');
               $roomcache->removeCache(0,'roominfo',$room['domain']);
                //返回到网校首页
                header("Location:/");
                exit;
            }
        }*/
       $foot = $ret['data']['foot'];
       $head = $ret['data']['head'];
       $body = $ret['data']['body'];
       $settings = $ret['data']['settings'];
       if(!empty($settings)){
           $settings = stripslashes($settings);
           //$settings = stripslashes($settings);
           $settings = json_decode($settings);
       }
       $this->assign('foot', stripslashes($foot));
       $this->assign('head', stripslashes($head));
       $this->assign('body', stripslashes($body));
       $this->assign('did', $ret['data']['did']);
       $this->assign('settings', $settings);
       $this->assign('systemsetting', $systemsetting);

       //用户登录信息 -- 判断是不是网校管理员
       if(!empty($user) && !empty($room)){
           if($room['uid'] == $user['uid']){
               $user['isadmin'] = 1;
           }else{
               $user['isadmin'] = 0;
           }
           //处理显示用户名
           $showname = !empty($user['realname']) ? shortstr($user['realname'], 8, ''): shortstr($user['username'], 8, '');
           $user['showname'] = $showname;
           $user['face'] = getavater($user, '120_120');

           $user = array(
               'username' => $user['username'],
               'showname' => $user['showname'],
               'groupid' => $user['groupid'],
               'isadmin' => $user['isadmin'],
               'face' => $user['face'],
               'lastlogtime' => $user['lastlogintime']
           );
       }
       if (!empty($room)) {
           $room = array(
               'crname' => $room['crname'],
               'crphone' => $room['crphone'],
               'kefuqq' => $room['kefuqq'],
               'summary' => $room['summary'],
               'wechatimg' => $room['wechatimg'],
               'cface' => $room['cface'],
               'lat' => $room['lat'],
               'lng' => $room['lng'],
               'craddress' => $room['craddress'],
               'crlabel' => $room['crlabel']
           );
       }
       $this->assign('user', $user);
       $this->assign('roominfo', $room);

       if ($clientType == 1) {
           $this->display('room/design/home-mobile');
           return;
       }
       $this->display('room/design/home');
    }



    /**
     * 获取课程列表
     */
    public function getselectedourse(){
        $post = $this->input->post();
        //$post = $this->input->get();
        $crid = $this->room['crid'];
        $uid = 0;
        if(!empty($this->user)){
            $uid = $this->user['uid'];
        }
        $itemid = $post['itemid'];
        //获取课程列表
        $apiServer = Ebh::app()->getApiServer('ebh');
        $ret = $apiServer->reSetting()
                ->setService('Classroom.Folder.getselectedourse')
                ->addParams('crid', $crid)
                ->addParams('uid', $uid)
                ->addParams('itemid', $itemid)
                ->request();

             //   var_dump($ret);

        if(!empty($ret)){
            //从缓存中读取课程人气
            $viewnumlib = Ebh::app()->lib('Viewnum');
            array_walk($ret['data'], function(&$folder, $k, $lib) {
                $folder['viewnum'] = $lib->getViewnum('folder', $folder['folderid'], $folder['viewnum']);
            }, $viewnumlib);
            renderjson(intval($ret['status']) ^ 1,$ret['msg'],$ret['data']);
        }
        renderjson(1,'接口请求失败',$ret['data']);
    }

    /**
     * 保存网校装扮
     */
    public function save(){
        $user = $this->user;
        $room = $this->room;
        //$post = $this->input->post();
        $post = $_POST;
        if (empty($room)) {
            $room = array(
                'crid' => 0,
                'crname' => '通用模板',
                'property' => 0,
                'domain' => 'www',
                'template' => 'plate',
                'upid' => 0,
                'isschool' => 7,
                'summary' => '',
                'uid' => !empty($user) ? $user['uid'] : 0
            );
        }
        //$post = $this->input->get();
        //先判断用户权限 是否是管理员
        if(empty($user) || empty($post) || $room['uid'] != $user['uid']){
            renderjson(1,'请求失败,用户登录信息丢失',array());
        }
        //var_dump($post);
        $roomtype = $room['crid'] > 0 ? Ebh::app()->room->getRoomType() : 'edu';
        $head = $post['head'];
        $foot = $post['foot'];
        $body = $post['body'];
        $clientType = $post['clientType'];
        $auditions = $post['auditions'];
        $vedioids = $this->input->post('vedioids');
        $settings = trim($post['settings']);
        $did = intval($this->input->post('did'));
        //$settings = iconv('gbk', 'utf8', $settings);
        $settings = htmlspecialchars_decode($settings);
        $arr = json_decode($settings,true);
        $settings= json_encode($arr);
       // $settings= addslashes(json_encode($arr));
        //验证参数是否合法
        if(empty($clientType) && (empty($head)||empty($foot))||empty($body)||
            (!empty($auditions) && ($this->checkIntStr($auditions)==false))
            ){
                renderjson(1,'请求失败,参数不完整,请检查装扮是否完整',array());
        }
        $status = !empty($post['status']) ? $post['status']: 0;
        $crid = $room['crid'];

        $apiServer = Ebh::app()->getApiServer('ebh');
        $ret = $apiServer->reSetting()
            ->setService('Classroom.Design.save')
            ->addParams('crid', $crid)
            ->addParams('roomtype', $roomtype)
            ->addParams('uid', $user['uid'])
            ->addParams('head', $head)
            ->addParams('foot', $foot)
            ->addParams('body', $body)
            ->addParams('settings', $settings)
            ->addParams('status', $status)
            ->addParams('clientType', $clientType)
            ->addParams('did', $did)
            ->request();
        if(!empty($ret)&&($ret['status']==1)){
            //更新下网校缓存
            if ($room['crid'] > 0) {
                $uri = Ebh::app()->getUri();
                $domain = $uri->uri_domain();
                $roomcache = Ebh::app()->lib('Roomcache');
                $roomcache->removeCache(0,'roominfo',$domain);

                //设置免费试听
                $this->saveAuditions($auditions, $ret['data']);
                //设置首页视频,一定要在设置免费试听操作之后
                if (!empty($vedioids)) {
                    $this->setVedios($vedioids, $ret['data']);
                }
            }
            renderjson(0,'数据保存成功',$ret['data'], false);
            //保存装扮操作成功后记录到操作日志
            fastcgi_finish_request();
            //获取原首页装扮信息
            $designinfo = $apiServer->reSetting()->setService('Aroomv3.Design.getDesignByDid')->addparams(array('did'=>$ret['data']))->request();
            if (!empty($ret['data']) && !empty($designinfo['name']) && isset($designinfo['client_type'])) {
                $logdata = array();
                $logdata['toid'] = $ret['data'];
                $logdata['title'] = h($designinfo['name']);
                $logdata['clientType'] = ($designinfo['client_type'] == 1) ? '手机' : '电脑';
                Ebh::app()->lib('OperationLog')->addLog($logdata,'savedesign');
            }
        }else{
           renderjson(1,'接口请求失败');
        }
    }

    /**
     * 获取网校装扮
     */
    public function getdesign(){
        $user = $this->user;
        $room = $this->room;
        $post = $this->input->post();
        $crid = $this->input->post('crid');
        if (empty($room)) {
            $room = array(
                'crid' => 0,
                'crname' => '通用模板',
                'property' => 0,
                'domain' => 'www',
                'template' => 'plate',
                'upid' => 0,
                'isschool' => 7,
                'summary' => '',
                'uid' => !empty($user) ? $user['uid'] : 0
            );
        }
        //$post = $this->input->get();
        //先判断用户权限 是否是管理员
        if(empty($user) || empty($post) || $user['uid'] != $room['uid']){
            renderjson(1,'请求失败,缺少参数');
        }

        $clientType = intval($this->input->post('clientType'));
        $clientType = min(1, max(0, $clientType));
        $did = max(0, intval($this->input->post('did')));
        //判断网校是否是当前配置网校
        if(intval($crid) > 0 && $post['crid'] != $room['crid']){
            renderjson(1,'请求失败,请在你所属网校下操作');
        }
        $apiServer = Ebh::app()->getApiServer('ebh');
        $roomtype = $room['crid'] > 0 ? Ebh::app()->room->getRoomType() : 'edu';
        if ($crid !== null && intval($crid == '0')) {
            $room['crid'] = 0;
            $roomtype = 'edu';
        }
        $ret = $apiServer->reSetting()
            ->setService('Classroom.Design.getdesign')
            ->addParams('crid', $room['crid'])
            ->addParams('roomtype', $roomtype)
            ->addParams('clientType', $clientType)
            ->addParams('did', $did)
            ->request();
        if (!empty($ret) && $ret['status'] == 1){
            renderjson(0,'数据请求成功', !empty($ret['data']) ? $ret['data'] : array());
        }else{
            renderjson(0,'接口请求失败');
        }
    }

    /**
     * 获取弹窗html
     */
    public function getajaxhtml(){
        $room = $this->room;
        $get = $this->input->get();
        $type = !empty($get['type']) ? $get['type'] : 'UNKNOW';
        if($type=='login'){
            //加载登录html
            $appsetting = Ebh::app()->getConfig()->load('othersetting');
            //是否禁用用户注册功能
            $open_register = true;
            if (isset($appsetting['dis_registerable']) && is_array($appsetting['dis_registerable']) && in_array($room['crid'], $appsetting['dis_registerable'])) {
                $open_register = false;
            }
            $this->assign('open_register', $open_register);
            $varpool['currentdomain'] = getdomain();
            $this->assign('varpool', $varpool);
            $loginhtml = $this->fetch('room/design/login-min');
            header("Content-Type: text/html; charset=utf-8");
            echo $loginhtml;
        }elseif($type=='register'){
            //加载注册html
        }
    }

    /**
     * 获取网校基本信息
     */
    public function getroominfo() {
        $apiServer = Ebh::app()->getApiServer('ebh');
        $ret = $apiServer->reSetting()
            ->setService('Classroom.Design.getroominfo')
            ->addParams('crid', $this->room['crid'])
            ->request();
        if (empty($ret)) {
            renderjson(1, '参数错误');
        }
        if (!empty($this->user)) {
            $ret['currentUser'] = $this->user;
        }
        renderjson(0, '', $ret);
    }

    /**
     * 获取网校课程分类
     */
    public function getcoursecategorys() {
        $apiServer = Ebh::app()->getApiServer('ebh');
        $ret = $apiServer->reSetting()
            ->setService('Classroom.Design.getcoursecategorys')
            ->addParams('crid', $this->room['crid'])
            ->request();
        renderjson(0, '', $ret);
    }

    /**
     * 网校课程分类
     */
    public function getcoursesorts(){
        $apiServer = Ebh::app()->getApiServer('ebh');
        $data['crid'] = $this->room['crid'];
        $splist = $apiServer->reSetting()->setService('CourseService.Category.index')->addParams($data)->request();
        renderjson(0,'',array_values($splist));
    }

    /**
     * 网校分类菜单
     */
    public function getcategorymenu() {
        $pids = $this->input->get('pids');
        if (!is_array($pids)) {
            renderjson(0, '', array());
        }
        $pids = array_map('intval', $pids);
        $pids = array_filter($pids, function($pid) {
           return $pid > 0;
        });
        if (empty($pids)) {
            renderjson(0, '', array());
        }
        $apiServer = Ebh::app()->getApiServer('ebh');
        $data['crid'] = $this->room['crid'];
        $splist = $apiServer->reSetting()->setService('CourseService.Category.index')->addParams($data)->request();
        if (empty($splist)) {
            renderjson(0, '', array());
        }
        array_walk($splist, function(&$item, $k, $pids) {
            $item['packages'] = array_filter($item['packages'], function($package) use($pids) {
                return in_array($package['pid'], $pids);
            });
        }, $pids);

        $ret = array();
        foreach ($splist as $item) {
            if (empty($item['packages'])) {
                continue;
            }
            $ret = array_merge($ret, $item['packages']);
        }
        $validPids = array_column($ret, 'pid');
        $pids = array_intersect($pids, $validPids);
        $pids = array_flip($pids);
        $orders = array_map(function($item) use($pids) {
            return $pids[$item['pid']];
        }, $ret);
        array_multisort($orders, SORT_ASC, SORT_NUMERIC, $ret);
        renderjson(0,'', $ret);
    }

    /**
     * 获取视频url
     */
    public function getvediourl() {
        $cwid = intval($this->input->get('cwid'));
        $did = intval($this->input->get('did'));
        if ($cwid < 1 || $did < 1) {
            renderjson(1, '参数错误');
        }
        $apiServer = Ebh::app()->getApiServer('ebh');
        $params = array(
            'crid' => $this->room['crid'],
            'did' => $did,
            'cwid' => $cwid
        );
        $ret = $apiServer->reSetting()
            ->setService('Courseware.Vedio.getVedio')
            ->addParams($params)
            ->request();
        if (empty($ret)) {
            renderjson(2, '视频错误');
        }
        $serverutil = Ebh::app()->lib('ServerUtil');
        if($this->room['domain'] == 'dh') {
            $m3u8source = $serverutil->getZKM3u8CourseSource();
        } else {
            $m3u8source = $serverutil->getM3u8CourseSource();
        }
        $cwurl = $ret['cwurl'];
        $id = $ret['cwid'];
        if (!empty($this->user)) {
            $pwd = $this->user['password'];
            $uid = $this->user['uid'];
        } else {
            $pwd = '';
            $uid = 0;
        }
        if (empty($ret['isfree']) && !empty($ret['administrator'])) {
            //视频未设置免费试听，用课件所属的网校管理员帐号构建播放地址
            $pwd = $ret['administrator']['password'];
            $uid = $ret['administrator']['uid'];
        }
        $ip = $this->input->getip();
        $time = SYSTIME;

        $skey = "$pwd\t$uid\t$ip\t$time\t$cwurl\t$id";
        $key = authcode($skey, 'ENCODE');
        $key = urlencode($key);
        renderjson(0, '', sprintf('%s?k=%s&id=%d&.m3u8', $m3u8source, $key, $id));
    }

    /**
     * 装扮模板列表
     */
    public function getdesigntemplates() {
        $clientType = intval($this->input->get('client_type'));
        $istop = intval($this->input->get('istop'));
        $num = intval($this->input->get('num'));
        /*读取装扮模板列表*/
        $apiServer = Ebh::app()->getApiServer('ebh');
        $designList = $apiServer->reSetting()
            ->setService('Classroom.Design.getdesigntemplates')
            ->addParams('clientType', $clientType)
            ->addParams('num', $num)
            ->addParams('istop', $istop)
            ->request();
        $ret = array();
        if (!empty($designList)) {
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            $imageServer = trim($_UP['albums']['showpath'], '/').'/';
            array_walk($designList, function(&$design, $index, $imageServer) {
                if (empty($design['path'])) {
                    return;
                }
                $design['path'] = $imageServer.trim($design['path'], '/');
                $design['logo'] = preg_replace_callback('/(\d+)\.(\w+)$/', function($m) {
                    return $m[1].'_120_120.'.$m[2];
                }, $design['path']);
            }, $imageServer);
            if ($istop == 1) {
                renderjson(0, '', $designList);
            }
            foreach ($designList as $item) {
                if (empty($ret[$item['paid']])) {
                    $ret[$item['paid']] = array(
                        'aid' => $item['paid'],
                        'alname' => $item['palname'],
                        'displayorder' => $item['pdisplayorder'],
                        'subs' => array()
                    );
                }
                if (empty($ret[$item['paid']]['subs'][$item['aid']])) {
                    $ret[$item['paid']]['subs'][$item['aid']] = array(
                        'aid' => $item['aid'],
                        'alname' => $item['alname'],
                        'displayorder' => $item['displayorder'],
                        'list' => array()
                    );
                }
                $ret[$item['paid']]['subs'][$item['aid']]['list'][] = $item;
            }
            unset($designList);
            array_walk($ret, function(&$sub) {
                $aids = array_keys($sub['subs']);
                $displayorders = array_column($sub['subs'], 'displayorder');
                array_multisort($displayorders, SORT_ASC, SORT_NUMERIC,
                    $aids, SORT_DESC, SORT_NUMERIC, $sub['subs']);
            });
            $aids = array_keys($ret);
            $displayorders = array_column($ret, 'displayorder');
            array_multisort($displayorders, SORT_ASC, SORT_NUMERIC,
                $aids, SORT_DESC, SORT_NUMERIC, $ret);
        }
        renderjson(0, '', $ret);
    }

    /**
     * 添加免费试听
     */
    protected function saveAuditions($auditions, $did){
        if(empty($auditions)){
            return false;
        }
        $cwid = $auditions;
        $room = $this->room;
        $apiServer = Ebh::app()->getApiServer('ebh');
        $ret = $apiServer->reSetting()
                ->setService('Classroom.Design.setfresscourse')
                ->addParams('did', $did)
                ->addParams('cwid', $cwid)
                ->addparams('crid', $room['crid'])
                ->request();
        if(empty($ret)&&($ret['status']==1)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /**
     * 设置首页视频，将首页视频设置为免费试听
     * @param array $cwids
     */
    protected function setVedios($cwids, $did) {
        if (!is_array($cwids)) {
            return;
        }
        $cwids = array_map('intval', $cwids);
        $cwids = array_filter($cwids, function($cwid) {
            return $cwid > 0;
        });
        $room = $this->room;
        if (empty($cwids)) {
            return;
        }
        $apiServer = Ebh::app()->getApiServer('ebh');
        $params = array(
            'did' => $did,
            'cwids' => $cwids,
            'crid' => $room['crid']
        );
        $apiServer->reSetting()
            ->setService('Courseware.Vedio.setComponentVedio')
            ->addParams($params)
            ->request();
    }

    /**
     * 首页装扮资讯列表
     */
    public function getnewslists() {
        $params = array();
        $result = array();
        $categorys = array();//资讯分类
        $navcategory = array();
        $params['ranktype'] = '';//排序类型,prank主类中资讯的排序,rank子类中资讯的排序(没有子类的资讯分类均为rank)
        $post = $this->input->post();
        $params['crid'] = $this->room['crid'];
        $params['begin'] = !empty($post['begin']) ? intval($post['begin'])-1 : 0;
        $params['last'] = (!empty($post['last']) && ($post['last']>=$params['begin'])) ? (intval($post['last']) - $params['begin']): 0;
        $navcode = safefilter(trim($this->input->post('navcode')));
        $apiServer = Ebh::app()->getApiServer('ebh');
        //获取当前资讯分类及其子分类的navcode
        if (!empty($navcode) && !empty($params['crid'])) {
            $categorys = $apiServer->reSetting()->setService('Aroomv3.News.newsCategoryMenu')->addParams('crid', $params['crid'])->request();
            if ($categorys === false) {
                renderjson(1, '分类信息错误');
            }
            $categorys = array_values($categorys);
            if(!empty($categorys) && is_array($categorys)){
                foreach ($categorys as $category){
                    if(!empty($category['code']) && ($category['code']==$navcode)){
                        $navcategory = $category;
                    }
                }
                //当前资讯分类有子集时获取并组合子集的分类code
                if(!empty($navcategory) && !empty($navcategory['subnav']) && is_array($navcategory['subnav'])){
                    $params['navcode'] = $navcode.','.implode(',',array_column($navcategory['subnav'],'code'));
                    $params['ranktype'] = 'prank';
                }else{
                    $params['navcode'] = $navcode;
                    $params['ranktype'] = 'rank';
                }
            }
        }
        if(!isset($params['begin']) || empty($params['last']) || empty($params['navcode']) || empty($params['ranktype'])){
            renderjson(1, '参数错误');
        }
        $ret = $apiServer->reSetting()->setService('Aroomv3.News.getNewsLists')->addParams($params)->request();
        if ($ret === false) {
            renderjson(1, '未知错误');
        }
        if(!empty($ret) && is_array($ret)){
            $result = $ret;
        }
        renderjson(0, '查询结果', $result);
    }

    /**
     * 允许本地局域网 跨域请求
     */
    private function checkAllowOrigin(){
        $origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';
        //$origin = 'http://192.168.0.58:8080';
        $portArr = array('80','8080');
        $localPrefix = array('192.168.0','127.0.0');
        if(!empty($origin)){
            $ip = parse_url($origin,PHP_URL_HOST);//http://192.168.0.58 => 192.168.0.58
            //  $ip = '101.69.252.186';
            if(!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)){
                $allow_origin = array();
                $start = 1;
                $max = 255;

                for($start;$start<$max;$start++){
                    foreach($portArr as $port){
                        $newip = 'http://'.$localPrefix[0].'.'.$start.':'.$port;
                        array_push($allow_origin, $newip);
                    }
                }
                $allow_origin = array_merge($allow_origin,array('http://127.0.0.1:8080','http://127.0.0.1:80'));
                //print_r($allow_origin);die();
                if(in_array($origin, $allow_origin)){
                    header('Access-Control-Allow-Origin:'.$origin);
                    header('Access-Control-Allow-Credentials:true');
                }else{
                    //暂时先加上 允许跨域
                    header("Access-Control-Allow-Origin: *");
                }
            }
        }
    }

    /**
     * 验证字符串是否是整数逗号拼接而成,整数必须是大于0
     * @param string $str
     * @param string $dot
     * @return bool
     */
    protected function checkIntStr($str, $dot =","){
        $ck = false;
        if(strpos($str , $dot)!==false){
            $interArr = explode($dot, $str);
            if(count($interArr) > 0){
                $num = 0;
                foreach ($interArr as $row){
                    $inter = intval($row);
                    if($inter >0){
                        $num++;
                    }
                }
                if($num > 0 && $num==count($interArr)){
                    $ck = true;
                }
            }
        }else{
            $inter = intval($str);
            if( $inter  > 0 ){
                $ck = true;
            }
        }

        return $ck;
    }

}