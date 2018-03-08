<?php
/**
 * 网校基本信息
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/3/15
 * Time: 13:33
 */
class roominfoController extends ARoomV3Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取网校基本信息
     */
    public function index()
    {
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.info')
            ->addParams('crid', $this->roominfo['crid'])->request();
        if ($ret === false) {
            $this->renderjson(1, '网校不存在');
        }

        if (!empty($ret['crlabel'])) {
            $crlabel_arr = explode(',', $ret['crlabel']);
            $crlabel_arr = array_filter($crlabel_arr, function($label) {
                return trim($label) != '';
            });
            $ret['crlabel'] = $crlabel_arr;
        } else {
            $ret['crlabel'] = array();
        }

        $ret['customer_care'] = array();
        if (!empty($ret['kefu']) && !empty($ret['kefuqq'])) {
            $kefu = $ret['kefu'];
            $kefuqq = $ret['kefuqq'];
            $kefu_arr = explode(',', $kefu);
            $kefu_arr = array_filter($kefu_arr, function($kefu_item) {
                return trim($kefu_item) != '';
            });
            $kefuqq_arr = explode(',', $kefuqq);
            $kefuqq_arr = array_filter($kefuqq_arr, function($kefuqq_item) {
                return trim($kefuqq_item) != '';
            });
            $len = min(count($kefu_arr), count($kefuqq_arr));
            $kefu_arr = array_slice($kefu_arr, 0, $len);
            $kefuqq_qrr = array_slice($kefuqq_arr, 0, $len);
            unset($ret['kefu'], $ret['kefuqq']);
            foreach ($kefu_arr as $index => $item) {
                $ret['customer_care'][] = array(
                    'name' => !empty($item) ? $item : '',
                    'qq' => !empty($kefuqq_qrr[$index]) ? $kefuqq_qrr[$index] : ''
                );
            }
        }

        $ret['domain'] = sprintf("%s.ebh.net", $ret['domain']);
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        if (isset($_UP['aroomv3']['showpath'])) {
            $path = rtrim($_UP['aroomv3']['showpath'],'/').'/';
            if ($ret['cface'] != '' && stripos($ret['cface'], 'http://') === false) {
                $ret['cface'] = $path.ltrim($ret['cface'], '/');
            }
            if ($ret['wechatimg'] != '' && stripos($ret['wechatimg'], 'http://') === false) {
                $ret['wechatimg'] = $path.ltrim($ret['wechatimg'], '/');
            }
        }
        if (empty($ret['wechatimg']) && !empty($ret['qcode'])) {
            if (isset($_UP['hmodule']['showpath'])) {
                $path = rtrim($_UP['hmodule']['showpath'],'/').'/';
                if (stripos($ret['qcode'], 'http://') === false) {
                    $ret['wechatimg'] = $path.ltrim($ret['qcode'], '/');
                } else {
                    $ret['wechatimg'] = $ret['qcode'];
                }
            } else {
                $ret['wechatimg'] = $ret['qcode'];
            }
            unset($ret['qcode']);
        }
        $defaultImage = Ebh::app()->getConfig()->load('imagePlaceholder');
        if (empty($ret['cface'])) {
            $ret['cface'] = $defaultImage['logo'];
        }
        if (empty($ret['wechatimg'])) {
            $ret['wechatimg'] = $defaultImage['qcode'];
        }
        //是否启用课程开场内容
        $othersetting = Ebh::app()->getConfig()->load('othersetting');
        $othersetting['zjdlr'] = !empty($othersetting['zjdlr']) ? $othersetting['zjdlr'] : 0;
        $othersetting['newzjdlr'] = !empty($othersetting['newzjdlr']) ? $othersetting['newzjdlr'] : array();
        $is_oldzjdlr = (($this->roominfo['crid'] == $othersetting['zjdlr']) && (!in_array($this->roominfo['crid'],$othersetting['newzjdlr'])));
        $is_zjdlr = ($this->roominfo['crid'] == $othersetting['zjdlr']) || (in_array($this->roominfo['crid'],$othersetting['newzjdlr']));
        $is_newzjdlr = in_array($this->roominfo['crid'],$othersetting['newzjdlr']);
        $ret['is_oldzjdlr'] = $is_oldzjdlr;
        $ret['is_zjdlr'] = $is_zjdlr;
        $ret['is_newzjdlr'] = $is_newzjdlr;
        if (!empty($othersetting['open-intro']) && is_array($othersetting['open-intro']) && in_array($this->roominfo['crid'], $othersetting['open-intro'])) {
            $ret['openIntro'] = 1;
        } else {
            $ret['openIntro'] = 0;
        }
        //课程总浏览量
        $folderidList = $this->apiServer->reSetting()->setService('Aroomv3.Room.getFolderId')->addParams('crid', $this->roominfo['crid'])->request();
        $redis = Ebh::app()->getCache('cache_redis');
        $all_view_num = 0;
        if(!empty($folderidList)){
            foreach($folderidList as $key=>$value){
                $all_view_num += $redis->hget('folder'.'viewnum', $value['folderid']);
            }
        }
        $ret['studynum'] = $all_view_num;
        //获取模块信息
        $module = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.getModule')
            ->addParams('crid', $this->roominfo['crid'])->request();
        $ret['moduleList'] = $module;
        $this->renderjson(0, '', $ret);
        //$this->renderjson(0, '', $module);
    }

    /**
     * 更新网校基本信息
     */
    public function update()
    {
        if (!$this->isPost()) {
            $this->renderjson(1, '操作方式错误');
        }
        $redis = Ebh::app()->getCache('cache_redis');
        $redis->remove('plate-platform-'.$this->roominfo['crid']);
        $data = $this->format_param($this->input, array(
            'cface' => true,
            'summary' => true,
            'message' => false,
            'crphone' => true,
            'craddress' => true,
            'wechatimg' => false
        ));
        $lng = $this->input->post('lng');
        if ($lng !== NULL && $lng != '') {
            $data['lng'] = floatval($lng);
        }
        $lat = $this->input->post('lat');
        if ($lat !== NULL && $lat != '') {
            $data['lat'] = floatval($lat);
        }
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        if (isset($_UP['aroomv3']['showpath'])) {
            if (!empty($data['cface']) && stripos($data['cface'], 'http://') === false) {
                //网校Logo图片相对地址转成绝对地址
                $data['cface'] = rtrim($_UP['aroomv3']['showpath'], '/').'/'.ltrim($data['cface'],'/');
            }
            if (!empty($data['wechatimg']) && stripos($data['wechatimg'], 'http://') === false) {
                $data['wechatimg'] = rtrim($_UP['aroomv3']['showpath'], '/').'/'.ltrim($data['wechatimg'],'/');
            }
        }
        $crlabel = $this->input->post('crlabel');
        if ($crlabel !== NULL) {
            if (empty($crlabel)) {
                $data['crlabel'] = '';
            } else if (is_array($crlabel)) {
                $crlabel = array_map(function($litem) {
                    return trim($litem, ', \t\n\r ');
                }, $crlabel);
                $crlabel = array_filter($crlabel, function($crlabel_item) {
                    return trim($crlabel_item) != '';
                });
                $groupCal = array_filter($crlabel, function($l) {
                    return preg_match('/[,\s]/', $l);
                });
                if (!empty($groupCal)) {
                    foreach ($groupCal as $dk => $item) {
                        unset($crlabel[$dk]);
                    }
                    foreach ($groupCal as $item) {
                        $sub = preg_split('/[,\s]/', $item);
                        $sub = array_filter($sub, function($subitem) {
                            return $subitem != '';
                        });
                        $crlabel = array_merge($crlabel, $sub);
                    }
                }
                $crlabel = array_unique($crlabel);
                $data['crlabel'] = h(implode(',', $crlabel));
            } else {
                $data['crlabel'] = h(strval($crlabel));
            }
        }


        $kefu = $this->input->post('kefu');
        if ($kefu !== NULL) {
            if (is_array($kefu)) {
                $kefu = array_map(function($kefu) {
                    $kefu = trim($kefu);
                    return empty($kefu) ? '0' : $kefu;
                }, $kefu);
                $data['kefu'] = h(implode(',', $kefu));
            } else {
                $data['kefu'] = h(strval($kefu));
            }
        }
        $kefuqq = $this->input->post('kefuqq');
        if ($kefuqq !== NULL) {
            if (is_array($kefuqq)) {
                $kefu = array_map(function($kefuqq) {
                    $kefuqq = trim($kefuqq);
                    return empty($kefuqq) ? '0' : $kefuqq;
                }, $kefuqq);

                $data['kefuqq'] = h(implode(',', $kefuqq));
            } else {
                $data['kefuqq'] = h(strval($kefuqq));
            }
        }
        $customer_care = $this->input->post('customer_care', false);
        if ($customer_care !== NULL) {
            if (is_array($customer_care)) {
                $kefu = $kefuqq = array();
                foreach ($customer_care as $kuitem) {
                    $kefu[] = !empty($kuitem['name']) ? h(trim($kuitem['name'])) : '0';
                    $kefuqq[] = !empty($kuitem['qq']) ? h(trim($kuitem['qq'])) : '0';
                }

                $data['kefu'] = implode(',', $kefu);
                $data['kefuqq'] = implode(',', $kefuqq);
            } else {
                $data['kefu'] = '';
                $data['kefuqq'] = '';
            }
        }
        $data['crid'] = $this->roominfo['crid'];
        //print_r($data);exit;
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.update')
            ->addParams($data)
            ->request();

        if ($ret === false) {
            $this->renderjson(1, '网校信息更新失败');
        }
        $roomcache = Ebh::app()->lib('Roomcache');
        $uri = Ebh::app()->getUri();
        $domain = $uri->uri_domain();
        $roomcache->removeCache(0,'roominfo',$domain);
        $roomcache->removeCache($this->roominfo['crid'],'roominfo','detail');
        $this->renderjson(0, '', array(
            'affected_rows' => $ret
        ));
    }

    /**
     * 独立域名信息
     */
    public function domain()
    {
        /*if (!empty($this->roominfo['fulldomain'])) {
            $this->renderjson(0, '', array(
                'domain' => $this->roominfo['domain'],
                'fulldomain' => $this->roominfo['fulldomain'],
                'status' => 1
            ));
        }*/
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.domain')
            ->addParams('crid', $this->roominfo['crid'])->request();
        if ($ret === false) {
            $this->renderjson(1, '网校不存在');
        }
        $ret['domain'] = $this->roominfo['domain'];
        $this->renderjson(0, '', $ret);
    }

    /**
     * 申请独立域名
     */
    public function applyDomain()
    {
        if (!$this->isPost()) {
            $this->renderjson(1, '操作方式错误');
        }
        $fulldomain = h(trim($this->input->post('fulldomain')));
        if (empty($fulldomain)) {
            $this->renderjson(1, '域名不能为空');
        }

        $params = array();
        $params['crid'] = $this->roominfo['crid'];
        $params['fulldomain'] = $fulldomain;
        $params['crname'] = $this->roominfo['crname'];

        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.applyDomain')
            ->addParams($params)->request();
        switch (intval($ret)) {
            case 1:
                $msg = '域名已占用或已拥有，操作失败';
                $code = 1;
                break;
            case 2:
                $msg = '域名已生效，本次操作无效';
                $code = 1;
                break;
            case 3:
                $msg = '域名重申请绑定成功';
                $code = 0;
                break;
            case 4:
                $msg = '域名申请绑定成功';
                $code = 0;
                break;
            default:
                $msg = '操作失败';
                $code = 1;
                break;
        }
        $this->renderjson($code, $msg);
    }

    /**
     * 解绑独立域名
     */
    public function unbindDomain()
    {
        if (!$this->isPost()) {
            $this->renderjson(1, '操作方式错误');
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.unbindDomain')
            ->addParams('crid', $this->roominfo['crid'])->request();
        if ($ret === false) {
            $this->renderjson(1, '解绑域名失败');
        }
        $this->_updateCache(array('crid' => $this->roominfo['crid']));
        $this->renderjson(0, '解绑成功');
    }

    /**
     * 网校推广信息
     */
    public function seo()
    {
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.seo')
            ->addParams('crid', $this->roominfo['crid'])->request();
        if (!empty($ret)) {
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            if (!empty($ret['faviconimg']) && !empty($ret['favicon']) && isset($_UP['aroomv3']['showpath'])) {
                $path = rtrim($_UP['aroomv3']['showpath'],'/').'/';
                if (stripos($ret['favicon'], 'http://') === false) {
                    $ret['favicon'] = $path.ltrim($ret['favicon'], '/');
                }
                if (stripos($ret['faviconimg'], 'http://') === false) {
                    $ret['faviconimg'] = $path.ltrim($ret['faviconimg'], '/');
                }
            }
            if (empty($ret['favicon'])) {
                $ret['favicon'] = '/favicon.ico';
            }
            if (empty($ret['faviconimg'])) {
                $ret['faviconimg'] = '/favicon.ico';
            }
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 更新SEO信息
     */
    public function updateSeo()
    {
        if (!$this->isPost()) {
            $this->renderjson(1, '操作方式错误');
        }
        $params = $this->format_param($this->input, array(
            'subtitle' => true,
            'favicon' => true,
            'faviconimg' => true,
            'metakeywords' => true,
            'metadescription' => true
        ));
        if (!empty($params['favicon'])) {
            //网校Logo图片相对地址转成绝对地址
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            if (isset($_UP['aroomv3']['showpath'])) {
                if ($params['favicon'] != '/favicon.ico' && stripos($params['favicon'], 'http://') === false) {
                    $params['favicon'] = rtrim($_UP['aroomv3']['showpath'], '/').'/'.ltrim($params['favicon'],'/');
                }
                if (!empty($params['faviconimg']) && stripos($params['faviconimg'], 'http://') === false) {
                    $params['faviconimg'] = rtrim($_UP['aroomv3']['showpath'], '/').'/'.ltrim($params['faviconimg'],'/');
                }
            }
        }
        $room_params = $this->format_param($this->input, array(
            'crname' => true,
            'icp' => true
        ));
        $room_params['crid'] = $this->roominfo['crid'];
        $params['crid'] = $this->roominfo['crid'];
        $analytics = $this->input->post('analytics', FALSE);
        if ($analytics !== NULL) {
            $params['analytics'] = $analytics;
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.updateSeo')
            ->addParams($params)->request();
        $ret2 = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.update')
            ->addParams($room_params)->request();
        if ($ret === false && $ret === false) {
            $this->renderjson(1, '更新失败');
        }
        $this->_updateCache($params);
        $roomcache = Ebh::app()->lib('Roomcache');
        $uri = Ebh::app()->getUri();
        $domain = $uri->uri_domain();
        $roomcache->removeCache(0,'roominfo',$domain);
        $roomcache->removeCache($this->roominfo['crid'],'roominfo','detail');
        $this->renderjson(0, '更新成功');
    }

    /**
     * 更新缓存
     * @param $param
     */
    private function _updateCache($param) {
        $settingarr = array('favicon', 'metakeywords', 'metadescription', 'ipbanlist', 'analytics', 'limitnum','creditrule', 'service', 'opservicetime', 'opserviceuid', 'crid','isdepartment','isbanregister','isbanthirdlogin','isbanbuy');
        foreach ($param as $key => $value) {
            if (!in_array($key, $settingarr))
                unset($param[$key]);
        }
        $param['crid'] = $this->roominfo['crid'];
        $redis = Ebh::app()->getCache('cache_redis');
        $redis_key = 'room_systemsetting_' . $this->roominfo['crid'];
        $redis->hMset($redis_key, $param);
    }
    /**
     * 微信公众服务号消息
     */
    public function ethSetting()
    {
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.ethsetting')
            ->addParams('crid', $this->roominfo['crid'])->request();
        $format_ret = array();
        if (!empty($ret)) {
            $format_ret['appID'] = $ret['appID'];
            $format_ret['appsecret'] = $ret['appsecret'];
            $format_ret['tempid'] = !empty($ret['template']['tempid']) ? $ret['data']['template']['tempid'] : '';
            $format_ret['phone'] = $ret['phone'];
            $format_ret['wechat'] = $ret['wechat'];
        }
        $this->renderjson(0, '', $format_ret);
    }

    /**
     * 网校其它设置
     */
    public function otherSetting() {
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.othersetting')
            ->addParams('crid', $this->roominfo['crid'])->request();
        $format_ret = array();
        if (!empty($ret)) {
            //清空系统设置缓存  获取实时数据
            $redis = Ebh::app()->getCache('cache_redis');
            $redis_key = 'room_systemsetting_' . $this->roominfo['crid'];
            $redis->del($redis_key);

            $format_ret['refusesTranger'] = $ret['refuse_stranger'] > 0 ? true : false;
            $format_ret['mobileRegister'] = $ret['mobile_register'] > 0 ? true : false;
            $format_ret['isbanbuy'] = $ret['isbanbuy'] > 0 ? true : false;
            $format_ret['isbanregister'] = $ret['isbanregister'] > 0 ? true : false;
            $format_ret['isbanthirdlogin'] = $ret['isbanthirdlogin'] > 0 ? true : false;
            $format_ret['isdepartment'] = $ret['isdepartment'] > 0 ? true : false;
            $format_ret['reviewInterval'] = $ret['review_interval'];
            $format_ret['postInterval'] = $ret['post_interval'];
            $format_ret['limitnum'] = $ret['limitnum'];
            $format_ret['showlink'] = $ret['showlink'];
            $format_ret['showmodule'] = $ret['showmodule'];
            $format_ret['ebhbrowser'] = $ret['ebhbrowser'] > 0 ? true : false;
            $format_ret['cwlistonlyself'] = $ret['cwlistonlyself'] > 0 ? true : false;
            $format_ret['showquestionbygrade'] = $ret['showquestionbygrade'] > 0 ? true : false;
            $creditrulearr = array('notvideo' => array(),'article' => array(),'comment' => array(), 'news' => array());//非视频课件,发布文章，评论课件，原创文章
            if($ret['creditrule']){
                $creditrule = json_decode($ret['creditrule'],true);
                $creditrule = array_merge($creditrulearr,$creditrule);
                foreach ($creditrule as $key=>$value){
                    $format_ret[$key]['type'] = !empty($creditrule[$key]['type']) ? $creditrule[$key]['type'] : $key;
                    $format_ret[$key]['on'] = $creditrule[$key]['on'] > 0 ? true : false;
                    if($key=='notvideo'){   $format_ret[$key]['needtime'] = $creditrule[$key]['needtime'] > 0 ? $creditrule[$key]['needtime'] : '';}
                    if($key=='comment'){    $format_ret[$key]['needwords'] = $creditrule[$key]['needwords'] > 0 ? $creditrule[$key]['needwords'] : '';}
                    if($key=='news'){    $format_ret[$key]['readtime'] = $creditrule[$key]['readtime'] > 0 ? $creditrule[$key]['readtime'] : '';}
                    $format_ret[$key]['single'] = $creditrule[$key]['single'] > 0 ? $creditrule[$key]['single'] : '';
                }
            }
        }
        $this->renderjson(0, '', $format_ret);
    }


    /**
     * 更新网校其它设置
     * @return bool
     */
    public function updateOtherSetting() {
        if (!$this->isPost()) {
            $this->renderjson(1, '操作方式错误');
        }
        $params = array();
        $params['crid'] = $this->roominfo['crid'];
        $post = $this->input->post();
        if(isset($post['refusesTranger'])){
            $params['refusesTranger'] = ((strtolower($post['refusesTranger']) === 'true') || (intval($post['refusesTranger']) > 0)) ? 1 : 0;
        }

        if(isset($post['mobileRegister'])){
            $mobileRegister  = $post['mobileRegister'];
            $params['mobileRegister'] = ((strtolower($mobileRegister) === 'true') || (intval($mobileRegister) > 0)) ? 1 : 0;
        }
        
        if(isset($post['isdepartment'])){
            $params['isdepartment'] = ((strtolower($post['isdepartment']) === 'true') || (intval($post['isdepartment']) > 0)) ? 1 : 0;
        }
        
        if(isset($post['isbanregister'])){
            $params['isbanregister'] = ((strtolower($post['isbanregister']) === 'true') || (intval($post['isbanregister']) > 0)) ? 1 : 0;
        }

        if(isset($post['isbanthirdlogin'])){
            $params['isbanthirdlogin'] = ((strtolower($post['isbanthirdlogin']) === 'true') || (intval($post['isbanthirdlogin']) > 0)) ? 1 : 0;
        }

        if(isset($post['isbanbuy'])){
            $params['isbanbuy'] = ((strtolower($post['isbanbuy']) === 'true') || (intval($post['isbanbuy']) > 0)) ? 1 : 0;
        }

        if (isset($post['reviewInterval'])) {
            $params['reviewInterval'] = intval($post['reviewInterval']);
        }
        
        if (isset($post['postInterval'])) {
            $params['postInterval'] = intval($post['postInterval']);
        }
        if (isset($post['limitnum'])) {
            $params['limitnum'] = intval($post['limitnum']);
        }
        if (isset($post['showlink'])) {
            $params['showlink'] = intval($post['showlink']);
        }
        if (isset($post['showmodule'])) {
            $params['showmodule'] = intval($post['showmodule']);
        }
        if(isset($post['ebhbrowser'])){
            $mobileRegister  = $post['ebhbrowser'];
            $params['ebhbrowser'] = ((strtolower($mobileRegister) === 'true') || (intval($mobileRegister) > 0)) ? 1 : 0;
        }
		if(isset($post['cwlistonlyself'])){//教师课件列表只显示自己发布的
            $params['cwlistonlyself'] = ((strtolower($post['cwlistonlyself']) === 'true') || (intval($post['cwlistonlyself']) > 0)) ? 1 : 0;
        }
        if(isset($post['showquestionbygrade'])){//学生端互动答疑按年级显示
            $params['showquestionbygrade'] = ((strtolower($post['showquestionbygrade']) === 'true') || (intval($post['showquestionbygrade']) > 0)) ? 1 : 0;
        }
        //其他学分设置
        $creditrule= $this->fomateScore($post);
        if(!empty($creditrule['newcredits'])){
            $params['creditrule'] = json_encode($creditrule['newcredits']);
        }

        //保存到数据库
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.updateOthersetting')
            ->addParams($params)->request();
        if ($ret === false) {
            $this->renderjson(1, '其他设置更新失败');
        }

        $redis = Ebh::app()->getCache('cache_redis');
        $redisKey = 'room_systemsetting_'.$this->roominfo['crid'];
        $redis->remove($redisKey);
        //更新缓存
        //$this->_updateCache(array('creditrule' => $params['creditrule']));

        $syncparam =array();
        $syncparam['uid'] = $this->user['uid'];
        $syncparam['crid'] = $params['crid'];
        //其他学分设置中评论视频课件得分设置改变时,同步评论学分
        if((intval($ret) == 1) && !empty($creditrule['newcredits']['comment']) && isset($creditrule['oldcredits']['comment'])){
            $syncparam['type'] = 3;
            $this->afterChangeCommentSet($creditrule['newcredits']['comment'],$creditrule['oldcredits']['comment'],$syncparam);
        }
        //其他学分设置中学习非视频课件课件得分设置改变时,同步非视频学分
        if((intval($ret) == 1) && !empty($creditrule['newcredits']['notvideo']) && isset($creditrule['oldcredits']['notvideo'])){
            $syncparam['type'] = 4;
            $this->afterChangeStudySet($creditrule['newcredits']['notvideo'],$creditrule['oldcredits']['notvideo'],$syncparam);
        }
        //其他学分设置中阅读原创文章得分设置改变时,同步阅读原创文章学分
        if((intval($ret) == 1) && !empty($creditrule['newcredits']['news']) && isset($creditrule['oldcredits']['news'])){
            $syncparam['type'] = 5;
            $this->afterChangeStudySet($creditrule['newcredits']['news'],$creditrule['oldcredits']['news'],$syncparam);
        }
        //其他学分设置中发表原创文章得分设置改变时,同步发表原创文章学分
        if((intval($ret) == 1) && !empty($creditrule['newcredits']['article']) && isset($creditrule['oldcredits']['article'])){
            $syncparam['type'] = 2;
            $this->afterChangeStudySet($creditrule['newcredits']['article'],$creditrule['oldcredits']['article'],$syncparam);
        }
        $this->renderjson(0, '其他设置更新成功',$ret);
    }

    /**
     * 处理其他学分设置
     * @param unknown $param
     */
    private function fomateScore($post){
        $creditpldarr = array();
        $params['crid'] = $this->roominfo['crid'];
        $otherset = $this->apiServer->reSetting()
        ->setService('Aroomv3.Room.othersetting')
        ->addParams($params)->request();
        if(!empty($otherset['creditrule'])){
            $creditpldarr= json_decode($otherset['creditrule'],true);
        }
        $notvideo = array();//非视频课件
        $article = array();//发布文章
        $comment = array();//评论课件
        $news = array();//阅读原创文章

        //获取打开非视频课件学分的设置参数
        $pat = "/^(?=0\.[1-9]|[1-9]\.\d).{3}$|^([1-9])$/";  //验证单次可获得的积分范围在0.1~9.9秒之间，且最多为一位小数
        
        $notvideo = array(
            'type' => 'notvideo',
            'needtime' => isset($post['needtime']) ? intval($post['needtime']) : (!empty($creditpldarr['notvideo']['needtime']) ? $creditpldarr['notvideo']['needtime'] : 0),
            'single' => isset($post['notvideo_single']) ? (preg_match($pat,$post['notvideo_single']) ? $post['notvideo_single']: 0) : (!empty($creditpldarr['notvideo']['single']) ? $creditpldarr['notvideo']['single'] : 0),
            'on' => isset($post['notvideo_on']) ? (strtolower($post['notvideo_on']) === 'true' ? 1 : 0) : (!empty($creditpldarr['notvideo']['on']) ? $creditpldarr['notvideo']['on'] : 0)
        );
        //打开该选择  判断视频学分给的合理性验证
        if(!empty($notvideo['on'])){
            if($notvideo['needtime'] && $notvideo['single']){
                $notvideo['on'] = 1;
            }else{
                $notvideo['on'] = 0;
            }
        }

        $article = array(
            'type' => 'article',
            'single'=> isset($post['article_single']) ? (preg_match($pat,$post['article_single']) ? $post['article_single']: 0) : (!empty($creditpldarr['article']['single']) ? $creditpldarr['article']['single'] : 0),
            'on' => isset($post['article_on']) ? (strtolower($post['article_on']) === 'true' ? 1 : 0): (!empty($creditpldarr['article']['on']) ? $creditpldarr['article']['on'] : 0)
        );
        //打开该选项 文章判断
        if(!empty($article['on'])){
            if($article['single']){
                $article['on'] = 1;
            }else{
                $article['on'] = 0;
            }
        }

        $comment = array(
            'type' => 'comment',
            'needwords'=>  isset($post['needwords']) ? intval($post['needwords']) : (!empty($creditpldarr['comment']['needwords']) ? $creditpldarr['comment']['needwords'] : 0),
            'single'=>isset($post['comment_single']) ? (preg_match($pat,$post['comment_single']) ? $post['comment_single']: 0) : (!empty($creditpldarr['comment']['single']) ? $creditpldarr['comment']['single'] : 0),
            'on'=>isset($post['comment_on']) ? (strtolower($post['comment_on']) === 'true' ? 1 : 0): (!empty($creditpldarr['comment']['on']) ? $creditpldarr['comment']['on'] : 0)
        );
        //打开该选择  判断评论给分的合理性验证
        if(!empty($comment['on'])){
            if($comment['needwords'] && $comment['single']){
                $comment['on'] = 1;
                //限制用户10分钟内不能连续操作评论学分同步
                if(!empty($creditpldarr['comment']['needwords']) && ($comment['needwords'] != $creditpldarr['comment']['needwords'])){
                    $synctime_key = 'synctime_review' . $params['crid'];
                    $redis = Ebh::app()->getCache('cache_redis');
                    $synctime = $redis->get($synctime_key);//读取缓存中的评论更新时间
                    if (empty($synctime)){
                        $starttime = time();
                        $redis->set($synctime_key,$starttime,600);
                    }else{
                        $this->renderjson(1, '10分钟内不能重复提交评论同步操作');
                    }
                }
            }else{
                $comment['on'] = 0;
            }
        }

        $news = array(
            'type' => 'news',
            'readtime'=>  isset($post['readtime']) ? intval($post['readtime']) : (!empty($creditpldarr['news']['readtime']) ? $creditpldarr['news']['readtime'] : 0),
            'single'=>isset($post['news_single']) ? (preg_match($pat,$post['news_single']) ? $post['news_single']: 0) : (!empty($creditpldarr['news']['single']) ? $creditpldarr['news']['single'] : 0),
            'on'=>isset($post['news_on']) ? (strtolower($post['news_on']) === 'true' ? 1 : 0): (!empty($creditpldarr['news']['on']) ? $creditpldarr['news']['on'] : 0)
        );
        //打开该选择  判断阅读原创文章给分的合理性验证
        if(!empty($news['on'])){
            if ($news['readtime'] && $news['single']) {
                $news['on'] = 1;
            } else {
                $news['on'] = 0;
            }
        }

        $newcredits = array('notvideo'=>$notvideo,'article'=>$article,'comment'=>$comment,'news'=>$news);
        $creditpldarr = !empty($creditpldarr) ? $creditpldarr : array();
        return array('newcredits'=>$newcredits,'oldcredits'=>$creditpldarr);
    }

    /**
     * 其他学分设置中评论视频课件得分设置改变时同步评论学分
     */
    public function afterChangeCommentSet($creditrules,$creditparam,$syncparam){
        if(!empty($creditrules['on']) && ($creditrules['on']==1) && $creditrules['needwords'] && $creditrules['single']){
            if($creditrules != $creditparam){
                if(isset($creditparam['needwords']) && ($creditrules['needwords'] != $creditparam['needwords'])){
                    $this->renderjson(0, '评论学分设置更新成功，评论学分同步中！',array(),false);
                    fastcgi_finish_request();
                    $this->apiServer->reSetting()->setService('Classroom.Score.doReviewScoreSync')->addParams($syncparam)->request();
                    exit;
                }else{
                    $res = $this->apiServer->reSetting()->setService('Classroom.Score.doStudyScoreSync')->addParams($syncparam)->request();
                    if($res){
                        $this->renderjson(0, '其他学分设置更新成功，评论学分同步成功！',$res);
                    }
                }
            }
        }
    }
    /**
     * 其他学分设置中非视频课件、原创文章学习或原创文章发表的得分设置改变时同步对应学分
     */
    public function afterChangeStudySet($creditrules,$creditparam,$syncparam){
        if(!empty($syncparam['type']) && $syncparam['type'] == 4){
            if(empty($creditrules['needtime'])){ return FALSE; }
        }elseif (!empty($syncparam['type']) && $syncparam['type'] == 5){
            if(empty($creditrules['readtime'])){ return FALSE; }
        }elseif (!empty($syncparam['type']) && $syncparam['type'] == 2){
            //发表原创文章无其他参数不做判断处理
        }else{
            return FALSE;
        }
        if(!empty($creditrules['on']) && ($creditrules['on']==1) && $creditrules['single']){
            if($creditrules != $creditparam){
                $res = $this->apiServer->reSetting()->setService('Classroom.Score.doStudyScoreSync')->addParams($syncparam)->request();
                if($res){
                    $this->renderjson(0, '其他学分设置更新成功，学分同步成功！',$res);
                }
            }
        }
    }
    /**
     * 更新
     */
    public function updateEthSetting()
    {
        if (!$this->isPost()) {
            $this->renderjson(1, '操作方式错误');
        }
        $wxt = Ebh::app()->getConfig()->load('wxt');
        $params = $this->format_param($this->input, array(
            'appID' => true,
            'appsecret' => true,
            'tempid' => true,
            'phone' => true,
            'wechat' => true
        ));

        $params['token'] = $wxt['token'];
        $params['server_url'] = 'http://' . $wxt['domain'] . '/server.html';
        $params['domain'] = $wxt['domain'];
        $params['ebhcode'] = md5(sha1("ebh{$this->roominfo['crid']}"));
        $params['crid'] = $this->roominfo['crid'];
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.updateEthsetting')
            ->addParams($params)->request();
        if ($ret === false) {
            $this->renderjson(1, '更新失败');
        }
        $this->renderjson(0, '更新成功');
    }

    /**
     * 登录限制
     */
    public function userClient() {
        $params = array(
            'crid' => $this->roominfo['crid']
        );
        $pageinfo = $this->getPageInfo();
        $params['pagesize'] = $pageinfo['pagesize'];
        $params['pagenum'] = $pageinfo['pagenum'];
        $k = safefilter(trim($this->input->get('k')));
        if (!empty($k)) {
            $params['k'] = $k;
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.userClientList')
            ->addParams($params)->request();
        array_walk($ret, function(&$userClient) {
           $userClient['avatar'] = getavater($userClient);
        });
        $this->renderjson(0, '', $ret);
    }

    /**
     * 登录限制统计
     */
    public function userClientCount() {
        $params = array(
            'crid' => $this->roominfo['crid']
        );
        $k = safefilter(trim($this->input->get('k')));
        if (!empty($k)) {
            $params['k'] = $k;
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.userClientCount')
            ->addParams($params)->request();
        $this->renderjson(0, '', $ret);
    }

    /**
     * IP黑名单列表
     */
    public function ipBlacklist() {
        $params = array(
            'crid' => $this->roominfo['crid'],
            'sortmode' => intval($this->input->get('sortmode'))
        );
        $pageinfo = $this->getPageInfo();
        $params['pagesize'] = $pageinfo['pagesize'];
        $params['pagenum'] = $pageinfo['pagenum'];
        $k = safefilter(trim($this->input->get('k')));
        if (!empty($k)) {
            $params['k'] = $k;
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.ipBlackList')
            ->addParams($params)->request();
        if (!empty($ret)) {
            array_walk($ret, function(&$ip) {
                $ip['ipaddr'] = long2ip($ip['ip']);
                //$ip['dateline'] = date('Y-m-d', $ip['dateline']);
            });
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * IP黑名单统计
     */
    public function ipBlacklistCount() {
        $params = array(
            'crid' => $this->roominfo['crid'],
            'k' => safefilter(trim($this->input->get('k')))
        );
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.ipBlackListCount')
            ->addParams($params)->request();
        return $this->renderjson(0, '', $ret);
    }

    /**
     * 添加IP黑名单
     */
    public function addIpblack() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法请求');
        }
        $ip = trim($this->input->post('ip'));
        if (empty($ip)) {
            $this->renderjson(1, 'IP不能为空');
        }
        if (!preg_match('/^\d{0,3}\.\d{0,3}\.\d{0,3}\.\d{0,3}$/i', $ip)) {
            $this->renderjson(1, 'IP格式错误');
        }
        $ipAddrLib = Ebh::app()->lib('IPaddress');
        $addr = $ipAddrLib->find($ip);
        $addr = array_filter($addr, function($a) {
            return !empty($a);
        });
        $params = array(
            'crid' => $this->roominfo['crid'],
            'uid' => $this->user['uid'],
            'ip' => $ip,
            'addr' => !empty($addr) ? implode(',', $addr) : '',
            'remark' => safefilter(trim($this->input->post('remark'))),
            'state' => 1
        );
        //校验该IP是否已经存在于黑名单中
        $exists = $this->ipIsExists($params['ip'],$params['crid']);
        if ($exists['count'] > 0) {
            $this->renderjson(1, '存在重复值，添加失败');
        }

        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.addIpBlack')
            ->addParams($params)->request();

        $this->renderjson(0, '添加成功');
    }

    /**
     * 校验要添加的ip黑名单是否已经存在
     * @param   $ip [用户名或ip]
     * @param   $crid  [网校ID]
     */
    protected function ipIsExists($ip,$crid){
        $params['ip'] = $ip;
        $params['crid'] = intval($crid);
        return $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.ipIsExists')
            ->addParams($params)
            ->request();
    }

    /**
     * 删除IP黑名单
     */
    public function deleteIpblack() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法请求');
        }
        $ips = $this->input->post('ips');
        if (empty($ips)) {
            $this->renderjson(1, '参数不能为空');
        }
        if (!is_array($ips)) {
            $ips = array(intval($ips));
        }
        $params = array(
            'crid' => $this->roominfo['crid'],
            'ips' => $ips
        );
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.deleteIpBlack')
            ->addParams($params)->request();
        if ($ret === false) {
            $this->renderjson(1, '删除失败');
        }
        $this->renderjson(0, '删除成功', $ret);
    }

    /**
     * 添加用户黑名单
     */
    public function addUserblack() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法请求');
        }
        $username = safefilter(trim($this->input->post('username')));
        if (empty($username)) {
            $this->renderjson(1, '参数不能为空');
        }

        if ($username == $this->user['username']) {
            $this->renderjson(1, '不能将自己的账号加入黑名单');
        }
        $params = array(
            'crid' => $this->roominfo['crid'],
            'operid' => $this->user['uid'],
            'username' => $username,
            'remark' => safefilter(trim($this->input->post('remark')))
        );
        //校验该用户是否已经存在于黑名单中
        $exists = $this->userIsExists($params['username'],$params['crid']);
        if ($exists['count'] > 0) {
            $this->renderjson(1, '存在重复值，添加失败');
        }

        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.addUserBlack')
            ->addParams($params)->request();

        if ($ret == -1) {
            $this->renderjson(1, '用户不存在，添加失败');
        }
        $this->renderjson(0, '添加成功');
    }

    /**
     * 校验用户名是已经存在于黑名单
     */
    protected function userIsExists($username,$crid){
        $params['username'] = $username;
        $params['crid'] = intval($crid);
        return $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.userIsExists')
            ->addParams($params)
            ->request();
    }

    /**
     * 用户黑名单列表
     */
    public function userBlacklist() {
        $params = array(
            'crid' => $this->roominfo['crid'],
            'sortmode' => intval($this->input->get('sortmode'))
        );
        $pageinfo = $this->getPageInfo();
        $params['pagesize'] = $pageinfo['pagesize'];
        $params['pagenum'] = $pageinfo['pagenum'];
        $k = safefilter(trim($this->input->get('k')));
        if (!empty($k)) {
            $params['k'] = $k;
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.userBlackList')
            ->addParams($params)->request();
        /*if (!empty($ret)) {
            array_walk($ret, function(&$ub) {
                $ub['dateline'] = date('Y-m-d', $ub['dateline']);
            });
        }*/
        $this->renderjson(0, '', $ret);
    }

    /**
     * 用户黑名单统计
     */
    public function userBlacklistCount() {
        $params = array(
            'crid' => $this->roominfo['crid'],
            'k' => safefilter(trim($this->input->get('k')))
        );
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.userBlackListCount')
            ->addParams($params)->request();
        return $this->renderjson(0, '', $ret);
    }

    /**
     * 删除用户黑名单
     */
    public function deleteUserblack() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法请求');
        }
        $uids = $this->input->post('uids');
        if (empty($uids)) {
            $this->renderjson(1, '参数不能为空');
        }
        if (!is_array($uids)) {
            $uids = array(intval($uids));
        }
        $params = array(
            'crid' => $this->roominfo['crid'],
            'uids' => $uids
        );
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.deleteUserBlack')
            ->addParams($params)->request();
        if ($ret === false) {
            $this->renderjson(1, '删除失败');
        }
        $this->renderjson(0, '删除成功', $ret);
    }

    /**
     * 关键词过滤统计
     */
    public function filtersCount() {
        $params = array(
            'crid' => $this->roominfo['crid'],
            'k' => safefilter(trim($this->input->get('k')))
        );
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.filtersCount')
            ->addParams($params)->request();
        return $this->renderjson(0, '', $ret);
    }

    /**
     * 关键词过滤列表
     */
    public function filtersList() {
        $params = array(
            'crid' => $this->roominfo['crid'],
            'sortmode' => intval($this->input->get('sortmode'))
        );
        $pageinfo = $this->getPageInfo();
        $params['pagesize'] = $pageinfo['pagesize'];
        $params['pagenum'] = $pageinfo['pagenum'];
        $k = safefilter(trim($this->input->get('k')));
        if (!empty($k)) {
            $params['k'] = $k;
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.filtersList')
            ->addParams($params)->request();
        /*if (!empty($ret)) {
            array_walk($ret, function(&$ub) {
                $ub['dateline'] = date('Y-m-d', $ub['dateline']);
            });
        }*/
        $this->renderjson(0, '', $ret);
    }

    /**
     * 删除关键词过滤
     */
    public function deleteFilters() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法请求');
        }
        $fids = $this->input->post('fids');
        if (empty($fids)) {
            $this->renderjson(1, '参数不能为空');
        }
        if (!is_array($fids)) {
            $fids = array(intval($fids));
        }
        $params = array(
            'crid' => $this->roominfo['crid'],
            'fids' => $fids
        );
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.deleteFilter')
            ->addParams($params)->request();
        if ($ret === false) {
            $this->renderjson(1, '删除失败');
        }
        $this->renderjson(0, '删除成功', $ret);
    }

    /**
     * 添加关键词过滤
     */
    public function addFilters() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法请求');
        }
        $keyword = safefilter(trim($this->input->post('keyword')));
        if (empty($keyword)) {
            $this->renderjson(1, '参数不能为空');
        }
        $params = array(
            'crid' => $this->roominfo['crid'],
            'uid' => $this->user['uid'],
            'keyword' => $keyword,
            'replace' => safefilter(trim($this->input->post('replace')))
        );
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.addFilters')
            ->addParams($params)->request();
        if ($ret === false) {
            $this->renderjson(1, '添加失败');
        }
        $this->renderjson(0, '添加成功', $ret);
    }

    /**
     * 删除用户登录限制
     */
    public function deleteUserclient() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法请求');
        }
        $uids = $this->input->post('uids');
        if (empty($uids)) {
            $this->renderjson(1, '参数不能为空');
        }
        if (!is_array($uids)) {
            $uids = array(intval($uids));
        }
        $params = array(
            'crid' => $this->roominfo['crid'],
            'uids' => $uids
        );
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.deleteUserClient')
            ->addParams($params)->request();
        if ($ret === false) {
            $this->renderjson(1, '删除失败');
        }
        $this->renderjson(0, '删除成功', $ret);
    }

    /**
     * 站点导航
     */
    public function navigator() {
		$roominfo = $this->roominfo;
		$navigatorlist = Ebh::app()->getConfig()->load('roomnav');
		$defaultnav = array_keys($navigatorlist);
		$crmodel = $this->model('classroom');
		$navigatorarr = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.navigator')
            ->addParams('crid', $this->roominfo['crid'])->request();

		if(!empty($navigatorarr)){
			krsort($navigatorarr);
			$indexstr = '';
			foreach($navigatorarr as $nav){
				$temp = $nav;
				if(!empty($navigatorlist[$nav['code']])){
					unset($navigatorlist[$nav['code']]);
				}else{
					$indexstr .= '\''.$nav['code'].'\',';
				}
				if($temp['code'] != 'index')
					array_unshift($navigatorlist,$temp);
				else
					$navindex = $temp;
			}
			if (!empty($navindex)) {
                array_unshift($navigatorlist,$navindex);
            }

		} else {//没有数据的学校
			$tnav = $navigatorlist;
			foreach($navigatorlist as $k=>$nav){
				$navigatorlist[$k]['nickname'] = $nav['name'];
				$navigatorlist[$k]['url'] = '/';
				$navigatorlist[$k]['target'] = '';
				$navigatorlist[$k]['available'] = '1';

			}
		}
		if (!empty($navigatorlist)) {
		    $navigatorlist = array_filter($navigatorlist, function($nav) {
		       return $nav['code'] != 'news';
            });
        }
		$navigatorlist = array_values($navigatorlist);
		// var_dump($navigatorlist);
		foreach($navigatorlist as $k=>$nav){
			if($nav['code'] == 'fineware' && $roominfo['template'] != 'plate'){//不是plate模板的，不显示精品课件
				unset($navigatorlist[$k]);
				continue;
			}
			if(empty($nav['nickname'])){
				$navigatorlist[$k]['nickname'] = $nav['name'];
			}
			if(empty($nav['target'])){
				$navigatorlist[$k]['target'] = '';
			}
			if($nav['code'] == 'shop'){//商城的，设定为系统
				$defaultnav[] = 'shop';
			}
			$notsys = !in_array($nav['code'],$defaultnav);
			$navigatorlist[$k]['navtype'] = $notsys?(empty($nav['url'])?'1':'2'):'0';
		}

        $this->renderjson(0, '', array('navigatorlist'=>$navigatorlist,'defaultnav'=>$defaultnav));
    }


    public function formatParam($input, $keys) {
        $params = array();
        foreach ($keys as $key => $item) {
            $param = $input->post($key);
            if ($param !== NULL) {
                if (!empty($item)) {
                    $params[$key] = h($param);
                    continue;
                }
                $params[$key] = $param;
            }
        }
        return $params;
    }
	/*
	保存导航
	*/
	public function saveNavigator(){
		$navigatorlist = $this->input->post('navigatorlist');
		$tnav = array();
		foreach($navigatorlist as $k=>$nav){
			$tnav[$k]['name'] = $nav['name'];
			$tnav[$k]['nickname'] = $nav['nickname'];
			$tnav[$k]['code'] = $nav['code'];
			$tnav[$k]['available'] = $nav['available'];
			$tnav[$k]['url'] = $nav['url'];
			$tnav[$k]['target'] = empty($nav['target'])?'':$nav['target'];
			$tnav[$k]['subnav'] = empty($nav['subnav'])?array():$nav['subnav'];
		}

		$navigator = serialize(array('navarr'=>$tnav));
		if(mb_strlen($navigator,'UTF-8')>5000){
			$this->renderjson(1, '内容太多');
		}
		if(!empty($navigator)){
			$ret = $this->apiServer->reSetting()
				->setService('Aroomv3.Room.update')
				->addParams('crid', $this->roominfo['crid'])
				->addParams('navigator', $navigator)
				->request();
		}
		if($ret !== FALSE){
			$roomcache = Ebh::app()->lib('Roomcache');
			$roomcache->removeCache($this->roominfo['crid'],'navigator','plate-navigation');
			updateRoomCache($this->roominfo['crid'],'navigator');
			$this->renderjson(0, '操作成功');
		} else {
			$this->renderjson(1, '操作失败');
		}
	}

	/*
	获取自定义富文本
	*/
	public function getCustomMessage(){
		$roominfo = $this->roominfo;
		$index = $this->input->get('code');
		$param['crid'] = $roominfo['crid'];
		$param['index'] = '\''.$index.'\'';
		$ret = $this->apiServer->reSetting()
				->setService('Aroomv3.Room.getCustomMessage')
				->addParams($param)
				->request();
		$this->renderjson(0, '',$ret);
	}

	/*
	保存自定义富文本
	*/
	public function saveCustomMessage(){
		$roominfo = $this->roominfo;
		$custommessage = $this->input->post('custommessage');
		$index = $this->input->post('code');
		if(!is_numeric($index) && !is_numeric(ltrim($index,'n'))){
			$this->renderjson(1, '参数错误');
		}
		$param['crid'] = $roominfo['crid'];
		$param['custommessage'] = $custommessage;
		if(isset($index)){
			$param['index'] = '\''.$index.'\'';
		}
		$ret = $this->apiServer->reSetting()
				->setService('Aroomv3.Room.saveCustomMessage')
				->addParams($param)
				->request();
		if($ret !== FALSE){
			updateRoomCache($roominfo['crid'],'custommessage');
			$this->renderjson(0, '操作成功');
		} else {
			$this->renderjson(1, '操作失败');
		}
	}

    public function format_param($input, $keys) {
        $params = array();
        foreach ($keys as $key => $item) {
            $param = $input->post($key);
            if ($param !== NULL && $param != 'undefined') {
                if (!empty($item)) {
                    $params[$key] = h($param);
                    continue;
                }
                $params[$key] = $param;
            }
        }
        return $params;
    }

    /**
     * 验证域名是否有效
     * 已注册的域名 可以使用
     */
    protected function checkDomain($url){
        //require_once 'Whois.php';

        $check = false;
        $whois =  Ebh::app()->lib("Whois");
        $topdomain = $this->getTopDomain($url);
        //print_r($topdomain);die;
        if(!empty($topdomain)){
            $row = $whois->query($topdomain, 3);
            //print_r($row);
            if(($row['error']===0) && ($row['data']['registration']=='registered')){
                $check  = true;
            }
        }

        return $check;
    }
    /**
     * 获取顶级域名
     * @param unknown $url
     */
    protected function getTopDomain($url){
        $topdomain = false;
        if($this->isDomain($url)){
            // echo 111;die;
            preg_match('/[\w][\w-]*\.(?:com\.cn|com|cn|co|net|org|gov|cc|biz|info)(\/|$)/isU', $url, $domain);
            $topdomain =  rtrim($domain[0], '/');
        }

        return $topdomain;
    }

    /**
     * @author      Default7 <default7@zbphp.com>
     * @description 匹配
     *              t.cn 正确
     *              t-.cn 错误
     *              tt.cn正确
     *              -t.cn 错误
     *              t-t.cn 正确
     *              tst-test-tst.cn 正确
     *              tst--tt.cn -- 错误
     *
     *
     *
     * @param $domain
     *
     * @return bool
     */
    protected function isDomain($domain)
    {

        $result=!empty($domain) && strpos($domain, '--') === false &&
        preg_match('/^([a-z0-9]+([a-z0-9-]*(?:[a-z0-9]+))?\.)?[a-z0-9]+([a-z0-9-]*(?:[a-z0-9]+))?(\.us|\.tv|\.org\.cn|\.org|\.net\.cn|\.net|\.mobi|\.me|\.la|\.info|\.hk|\.gov\.cn|\.edu|\.com\.cn|\.com|\.co\.jp|\.co|\.cn|\.cc|\.biz)$/i', $domain) ? true : false;

        return $result;
    }


    public function payqrcode(){
        header("Content-type: text/html; charset=utf-8");
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Room.info')
            ->addParams('crid', $this->roominfo['crid'])->request();

        $url = 'http://up.ebh.net/qrcode.html?content='.urlencode('http://wap.ebh.net/shop/school/courselist.html?domain='.$ret['domain']).'&show=1';
        $ret = file_get_contents($url);
        header("Content-type: octet/stream");
        header("Content-disposition:attachment;filename=qrcode.png;");
        echo $ret;
        /*$ret = json_decode($ret,true);

        $image = $ret['url'];*/


    }
}