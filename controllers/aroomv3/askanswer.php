<?php

/**
 * 解答
 * User: zyp
 * Date: 2018/1/23
 * Time: 15:30
 */
class AskanswerController extends ARoomV3Controller {
    /**
     * 解答列表
     */
    public function askAnswerList() {
        $params = array(
            'crid' => $this->roominfo['crid']
        );
        $appsetting = Ebh::app()->getConfig()->load('othersetting');
        $iszjdlr = isset($appsetting['zjdlr']) && $appsetting['zjdlr'] == $this->roominfo['crid'] || isset($appsetting['newzjdlr']) && in_array($this->roominfo['crid'], $appsetting['newzjdlr']);
        $params['roomtype'] = $iszjdlr ? 'com' : Ebh::app()->room->getRoomType();
        if ($iszjdlr && $this->roominfo['uid'] != $this->user['uid']) {
            //非管理员用户,读取用户角色
            $params['uid'] = $this->user['uid'];
        }
        $pageinfo = $this->getPageInfo();
        $params['pagesize'] = $pageinfo['pagesize'];
        $params['pagenum'] = $pageinfo['pagenum'];
        $folderid = $this->input->get('folderid');
        if ($folderid !== NULL && $folderid != '') {
            $params['folderid'] = intval($folderid);
        }
        $shield = $this->input->get('shield');  //是否屏蔽,1屏蔽状态(国土:0审核通过，1审核不通过，2待审核)
        if (($shield !== NULL) && ($shield != '')) {
            $params['shield'] = intval($shield);
        }
        $starttime = $this->input->get('starttime');
        if ($starttime !== NULL && $starttime != '') {
            $starttime = safefilter(trim($starttime));
            if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', $starttime, $match)) {
                if (checkdate($match[2], $match[3], $match[1])) {
                    $params['early'] = strtotime($starttime);
                }
            }
        }
        $endtime = $this->input->get('endtime');
        if ($endtime !== NULL && $endtime != '') {
            $endtime = safefilter(trim($endtime));
            if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', $endtime, $match)) {
                if (checkdate($match[2], $match[3], $match[1])) {
                    $params['latest'] = strtotime($endtime.' 23:59:59');
                }
            }
        }
        $k = safefilter(trim($this->input->get('k')));//关键字查询
        if (!empty($k)) {
            $params['k'] = $k;
        }
        $params['classid'] = intval($this->input->get('classid'));//获取班级id
        $ret = $this->apiServer->reSetting()
            ->setService('Classroom.Ask.askAnswerList')
            ->addParams($params)
            ->request();
        if(!empty($ret)){
            foreach ($ret as &$v){
                $v['message'] = html_entity_decode(strip_tags($v['message']));//解答内容过滤html代码
            }
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 问题统计
     */
    public function getAnswerCount() {
        $params = array(
            'crid' => $this->roominfo['crid']
        );
        $appsetting = Ebh::app()->getConfig()->load('othersetting');
        $iszjdlr = isset($appsetting['zjdlr']) && $appsetting['zjdlr'] == $this->roominfo['crid'] || isset($appsetting['newzjdlr']) && in_array($this->roominfo['crid'], $appsetting['newzjdlr']);
        $params['roomtype'] = $iszjdlr ? 'com' : Ebh::app()->room->getRoomType();
        if ($iszjdlr && $this->roominfo['uid'] != $this->user['uid']) {
            //非管理员用户,读取用户角色
            $params['uid'] = $this->user['uid'];
        }
        $folderid = $this->input->get('folderid');
        if ($folderid !== NULL && $folderid != '') {
            $params['folderid'] = intval($folderid);
        }
        $shield = $this->input->get('shield');      //是否屏蔽,1屏蔽状态(国土:0审核通过，1审核不通过，2待审核)
        if (($shield !== NULL) && ($shield != '')) {
            $params['shield'] = intval($shield);
        }
        $starttime = $this->input->get('starttime');//查询开始时间
        if ($starttime !== NULL && $starttime != '') {
            $starttime = safefilter(trim($starttime));
            if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', $starttime, $match)) {
                if (checkdate($match[2], $match[3], $match[1])) {
                    $params['early'] = strtotime($starttime);
                }
            }
        }
        $endtime = $this->input->get('endtime');
        if ($endtime !== NULL && $endtime != '') {
            $endtime = safefilter(trim($endtime));
            if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', $endtime, $match)) {
                if (checkdate($match[2], $match[3], $match[1])) {
                    $params['latest'] = strtotime($endtime.' 23:59:59');
                }
            }
        }
        $k = safefilter(trim($this->input->get('k')));
        if (!empty($k)) {
            $params['k'] = $k;
        }
        $params['classid'] = intval($this->input->get('classid'));//获取班级id
        $ret = $this->apiServer->reSetting()
            ->setService('Classroom.Ask.askAnswerCount')
            ->addParams($params)
            ->request();
        $this->renderjson(0, '', $ret);
    }

    /**
     * 设置屏蔽状态
     */
    public function setShield() {
        $params = array(
            'crid' => $this->roominfo['crid']
        );
        if (!$this->isPost() || empty($params['crid'])) {
            $this->renderjson(1, '非法操作');
        }
        $aid = intval($this->input->post('aid'));       //解答的id
        $shield = intval($this->input->post('shield')); //是否屏蔽,1屏蔽状态(国土:0审核通过，1审核不通过，2待审核)
        if(empty($aid) || !isset($shield)){
            $this->renderjson(1, '参数错误');
        }
        $params['aid'] = $aid;
        $params['shield'] = $shield;
        //判断是否国土
        $conf = Ebh::app()->getConfig()->load('othersetting');
        $conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
        $conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] : array();
        $is_zjdlr = ($params['crid'] == $conf['zjdlr']) || (in_array($params['crid'],$conf['newzjdlr']));
        if($is_zjdlr){
            $params['iszjdlr'] = 1;
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Classroom.Ask.setShield')
            ->addParams($params)
            ->request();
        $this->renderjson(0, '', $ret,false);
    }

    /**
     * 国土解答过滤设置
     */
    public function setfilter() {
        $params = array();
        if (!$this->input->post()) {
            $this->renderjson(1, '非法操作');
        }
        $isfilter = intval($this->input->post('isfilter'));     //1开启解答审核的过滤设置
        $answernum = intval($this->input->post('answernum'));   //解答字数(过滤设置开启且大于此字数，解答默认为已审核)
        if(!isset($isfilter) || !isset($answernum)){
            $this->renderjson(1, '参数错误');
        }
        $params = array(
            'isfilter' => $isfilter,
            'answernum' => $answernum,
            'crid' => $this->roominfo['crid']
        );
        $redis = Ebh::app()->getCache('cache_redis');
        $redis_key = 'answerfilter_' . $this->roominfo['crid'];
        $redis->set($redis_key,json_encode($params));//添加或更新设置到缓存中
        $this->renderjson(0, '设置修改成功');
    }

    /**
     * 获取解答过滤设置
     */
    public function getfilter() {

        $result = array();
        $redis = Ebh::app()->getCache('cache_redis');
        $redis_key = 'answerfilter_' . 12883;
        $filterinfo = $redis->get($redis_key);  //读取缓存中解答过滤的设置
        if(!empty($filterinfo)) {              //解答审核的过滤设置是否存在
            $result = json_decode($filterinfo,true);
        }
        $this->renderjson(0, '获取解答过滤设置', $result,false);
    }
}