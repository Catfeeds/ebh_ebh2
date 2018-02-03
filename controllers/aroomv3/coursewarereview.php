<?php
/**
 * 课程评论
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/3/24
 * Time: 13:20
 */
class CoursewarereviewController extends ARoomV3Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    /*
     * 课程评论统计
     */
    public function getCount() {
        $params = array(
            'crid' => $this->roominfo['crid']
        );
        //从配置文件获取国土的crid
        $guoTuCrid = Ebh::app()->getConfig()->load('othersetting');
        $guoTuCrid['zjdlr'] = !empty($guoTuCrid['zjdlr']) ? $guoTuCrid['zjdlr'] : 0;
        $guoTuCrid['newzjdlr'] = !empty($guoTuCrid['newzjdlr']) ? $guoTuCrid['newzjdlr'] : array();
        $is_zjdlr = ($params['crid'] == $guoTuCrid['zjdlr']) || (in_array($params['crid'],$guoTuCrid['newzjdlr']));
        $is_newzjdlr = in_array($params['crid'],$guoTuCrid['newzjdlr']);
        $params['roomtype'] = $is_zjdlr ? 'com' : Ebh::app()->room->getRoomType();
        if ($is_zjdlr && $this->roominfo['uid'] != $this->user['uid']) {
            //非管理员用户,读取用户角色
            $params['uid'] = $this->user['uid'];
        }
        $classid = intval($this->input->get('classid'));
        if ($classid > 0) {
            $params['classid'] = $classid;
        }
        $sourcecrid = $this->input->get('sourcecrid');
        if(!empty($sourcecrid) && $sourcecrid > 0){
            $params['crid'] = intval($sourcecrid);
        }
        $folderid = $this->input->get('folderid');
        if($is_zjdlr){
            //如果是国土则根据audit字段获取数据
            $audit = $this->input->get('audit');
        }else{
            //非国土根据shield字段获取数据
            $shield = $this->input->get('shield');
        }
        if(isset($shield) && $shield !== ''){
            $params['shield'] = $shield;
        }
        if(isset($audit) && $audit !== ''){
            $params['audit'] = $audit;
        }
        if ($folderid !== NULL && $folderid != '') {
            $params['folderid'] = intval($folderid);
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

        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.CoursewareReview.coursewareReviewCount')
            ->addParams($params)->request();

        //返回是否为国土的状态码
        if($is_zjdlr){
            echo json_encode(array('code'=>0,'data'=>$ret,'msg'=>1)); //是国土
        }else{
            echo json_encode(array('code'=>0,'data'=>$ret,'msg'=>0));
        }
    }

    /**
     * 课程评论列表
     */
    public function index() {
        $params = array(
            'crid' => $this->roominfo['crid']
        );
        //从配置文件获取国土的crid
        $guoTuCrid = Ebh::app()->getConfig()->load('othersetting');
        $guoTuCrid['zjdlr'] = !empty($guoTuCrid['zjdlr']) ? $guoTuCrid['zjdlr'] : 0;
        $guoTuCrid['newzjdlr'] = !empty($guoTuCrid['newzjdlr']) ? $guoTuCrid['newzjdlr'] : array();
        $is_zjdlr = ($params['crid'] == $guoTuCrid['zjdlr']) || (in_array($params['crid'],$guoTuCrid['newzjdlr']));
        $is_newzjdlr = in_array($params['crid'],$guoTuCrid['newzjdlr']);
        $params['roomtype'] = $is_zjdlr ? 'com' : Ebh::app()->room->getRoomType();
        if ($is_newzjdlr && $this->roominfo['uid'] != $this->user['uid']) {
            //非管理员用户,读取用户角色
            $params['uid'] = $this->user['uid'];
        }
        $classid = intval($this->input->get('classid'));
        if ($classid > 0) {
            $params['classid'] = $classid;
        }
        $sourcecrid = $this->input->get('sourcecrid');
        if(!empty($sourcecrid) && $sourcecrid > 0){
            $params['crid'] = intval($sourcecrid);
        }
        $pageinfo = $this->getPageInfo();
        $params['pagesize'] = $pageinfo['pagesize'];
        $params['pagenum'] = $pageinfo['pagenum'];
        $folderid = $this->input->get('folderid');
        if($is_zjdlr){
            //如果是国土则根据audit字段获取数据
            $audit = $this->input->get('audit');
        }else{
            //非国土根据shield字段获取数据
            $shield = $this->input->get('shield');
        }
        
        if(isset($shield) && $shield !== ''){
            $params['shield'] = $shield;
        }
        if(isset($audit) && $audit !== ''){
            $params['audit'] = $audit;
        }
        if ($folderid !== NULL && $folderid != '') {
            $params['folderid'] = intval($folderid);
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

        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.CoursewareReview.coursewareReviewList')
            ->addParams($params)->request();
        
        if (!empty($ret)) {
            //从缓存中读取课件浏览量
            $lib = Ebh::app()->lib('Viewnum');
            array_walk($ret, function(&$v, $k, $redis) {
                $v['courseware']['viewnum'] = $redis->getViewnum('courseware', $v['toid'], $v['courseware']['viewnum']);
                $v['user']['avatar'] = getavater($v['user']);
                $v['author']['avatar'] = getavater($v['author']);
                if (empty($v['courseware']['logo'])) {
                    $v['courseware']['logo'] = 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png?v=20160504001';
                }
                $v['subject'] = parseEmotionItem($v['subject']);
                if (empty($v['children'])){
                    return;
                }
                $v['children'] = parseEmotion($v['children']);
            }, $lib);
        }
        foreach($ret as $key=>$value){
            $ret[$key]['user']['realnametitle'] = $ret[$key]['user']['realname'];
            $ret[$key]['user']['username'] = mb_substr($ret[$key]['user']['username'],0,6,'utf-8');
            $ret[$key]['user']['realname'] = mb_substr($ret[$key]['user']['realname'],0,6,'utf-8');
        }
        //获取网校别名
        if($params['crid'] == $this->roominfo['crid']){
            if (intval($this->input->get('debug')) > 0) {
                print_r($ret);exit;
            }
            //print_r($ret);exit;
            $this->renderjson(0, '本网校', $ret);
        }else{
            $param['crid'] = intval($this->roominfo['crid']);
            $param['sourcecrid'] = intval($params['crid']);
            $res = $this->apiServer->reSetting()
                        ->setService('Aroomv3.CoursewareReview.getName')
                        ->addParams($param)->request();
            $this->renderjson(0, $res['name'], $ret);
        }
        //$this->renderjson(0, '', $ret);
    }

    /**
     * 设置屏蔽状态
     */
    public function setShield() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法操作');
        }
        $logid = intval($this->input->post('logid'));
        $shield = intval($this->input->post('shield'));
        $params = array(
            'logid' => $logid,
            'shield' => $shield
        );
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.CoursewareReview.setShield')
            ->addParams($params)
            ->request();
        $this->renderjson(0, '', $ret,false);

        fastcgi_finish_request();
        //屏蔽（取消屏蔽）操作成功后记录到操作日志
        if (($ret !== false) && !empty($logid) && isset($shield)) {
            $operation = ($shield==1) ? 'shieldreview' : 'unshieldreview';
            Ebh::app()->lib('OperationLog')->addLog(array('toid'=>$logid),$operation);
        }
    }
    /**
     * 设置国土审核状态状态
     */
    public function setAudit() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法操作');
        }
        $logid = intval($this->input->post('logid'));
        $audit = intval($this->input->post('audit'));
        $params = array(
            'logid' => $logid,
            'audit' => $audit
        );
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.CoursewareReview.setAudit')
            ->addParams($params)
            ->request();
        $this->renderjson(0, '', $ret,false);

        fastcgi_finish_request();
        //审核通过（审核不通过）操作成功后记录到操作日志
        if (($ret !== false) && !empty($logid) && isset($audit)) {
            $operation = ($audit==1) ? 'auditreview' : 'unauditreview';
            Ebh::app()->lib('OperationLog')->addLog(array('toid'=>$logid),$operation);
        }
    }

    /**
     * [获取来源网校]
     * @return [json]
     */
    public function getSchsourcelist(){
        $params = array(
            'crid' => $this->roominfo['crid']
        );
        $list = $this->apiServer->reSetting()
            ->setService('Aroomv3.CoursewareReview.getSchsource')
            ->addParams($params)->request();
        $list[] = array('name'=>'本校','sourcecrid'=>$params['crid']);
        $list = array_reverse($list);
        $this->renderjson(0, '', $list);
    }


    /**
     * 评论过滤设置
     */
    public function setfilter() {
        $params = array();
        if (!$this->input->post()) {
            $this->renderjson(1, '非法操作');
        }
        $isfilter = intval($this->input->post('isfilter'));     //1开启评论审核的过滤设置
        $reviewnum = intval($this->input->post('reviewnum'));   //评论字数(过滤设置开启且大于此字数，评论默认为已审核)
        if(!isset($isfilter) || !isset($reviewnum)){
            $this->renderjson(1, '参数错误');
        }
        $params = array(
            'isfilter' => $isfilter,
            'reviewnum' => $reviewnum,
            'crid' => $this->roominfo['crid']
        );
        $redis = Ebh::app()->getCache('cache_redis');
        $redis_key = 'reviewfilter_' . $this->roominfo['crid'];
        $redis->set($redis_key,json_encode($params));//添加或更新设置到缓存中
        $this->renderjson(0, '设置修改成功');
    }

    /**
     * 获取评论过滤设置
     */
    public function getfilter() {
        $result = array();
        $redis = Ebh::app()->getCache('cache_redis');
        $redis_key = 'reviewfilter_' . $this->roominfo['crid'];
        $filterinfo = $redis->get($redis_key);  //读取缓存中评论过滤的设置
        if(!empty($filterinfo)) {              //评论审核的过滤设置是否存在
            $result = json_decode($filterinfo,true);
        }
        $this->renderjson(0, '获取评论过滤设置', $result,false);
    }
}