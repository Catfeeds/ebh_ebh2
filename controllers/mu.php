<?php
/**
 * 弹幕控制器
 */
class MuController extends CControl {
    public function __construct(){
        parent::__construct();
        $this->user = $user = Ebh::app()->user->getloginuser();
        if(empty($user)){
            //如果用户没有登录并且操作数等于op为sdel则执行弹幕全删除操作
            $op = $this->input->get('op');
            if($op == 'sdel'){
                $this->_sdel();
            }
            exit;
        }
        $this->redis = Ebh::app()->getCache('cache_redis');
    }
    public function index(){
      
    }
    //获取课件弹幕key
    public function getMuKey($cwid){
        return 'mu_'.$cwid;
    }
    //获取课件对应秒弹幕key
    public function getListKey($cwid,$time = 0){
        return 'mu_'.$cwid.'_'.$time;
    }

    //对应课件对应秒添加一条弹幕
    public function addMu($cwid = 0,$time = 0,$content = array()){
        if( !is_numeric($cwid) || ( $cwid<=0 ) || ( $time < 0 ) || ( empty($content) ) ){
            return -1;
        }
		//暂时禁用弹幕
		return 0;

        $redis = $this->redis;
        $muKey = $this->getMuKey($cwid);
        $listKey = $this->getListKey($cwid,$time);
        $redis->sadd('MuContainer',$muKey); //把弹幕对应的课件key存下来
        $redis->sadd($muKey,$listKey);//把弹幕具体时间的key存起来
        $redis->sadd($listKey,$content);//把弹幕具体时间的内容存起来
        return 0;
    }

    //对应课件对应秒添加一条弹幕 0表示成功 其余表示失败
    public function addMuAjax(){
		//暂时禁用弹幕
		echo 0;
        exit();
        $cwid = $this->input->post('cwid');
        $time = $this->input->post('time');
        $content = $this->_packMu();
        if(empty($content)){
            echo -1;
            exit();
        }
        echo $this->addMu($cwid,$time,$content);
    }

    //获取对应课件对应秒的弹幕
    public function getMu($cwid,$time = 0){
        if( !is_numeric($cwid) || ( $cwid<=0 ) || ( $time < 0 ) ){
            return array();
        }
		//暂时禁用弹幕
		return array();
        $redis = $this->redis;
        $muKey = $this->getMuKey($cwid);
        $listKey = $this->getListKey($cwid,$time);
        $mus = $redis->smembers($listKey);
        $res = array();
        if(!empty($mus)){
            foreach ($mus as $mu) {
                $res[] = unserialize($mu);
            }
        }
        return $res;
    }

    //获取对应课件对应秒的弹幕Ajax
    public function getMuAjax(){
        $cwid = $this->input->post('cwid');
        $time = $this->input->post('time');
        $res = $this->getMu($cwid,$time);
        echo json_encode($res);
    }

    //获取指定时间段的弹幕 [2,8) 2s-8s 左闭右开 
    public function getMus($cwid,$starttime = 0,$endtime = 0){
        $mulist = array();
        $user = $this->user;
        $uid = $user['uid'];
        if(is_numeric($starttime) && is_numeric($endtime) && ($starttime < $endtime) && ($starttime >= 0) ){
            for ($i=$starttime; $i < $endtime; $i++) { 
                $mulist = array_merge($mulist,$this->getMu($cwid,$i));
            }
        }
        //剔除掉时间段内用户的弹幕
        $retlist = array();
        $duringtime = max(($endtime-$starttime),0);
        $curtime = SYSTIME;
        $offsettime = $curtime-$duringtime;
        foreach ($mulist as $mu) {
            if( ( $mu['uid'] == $uid ) &&  !empty($mu['dateline']) && ( $offsettime < $mu['dateline'] ) ){
                continue;
            }
            $retlist[] = $mu;
        }
        return $retlist;
    }

    //获取指定时间段的弹幕Ajax
    public function getMusAjax(){
        $cwid = $this->input->post('cwid');
        $starttime = $this->input->post('starttime');
        $endtime = $this->input->post('endtime');
        $res = $this->getMus($cwid,$starttime,$endtime);
        echo json_encode($res);
    }

    //删除对应课件对应秒的弹幕
    public function delMuWithTime($cwid,$time = 0){
        if( !is_numeric($cwid) || ( $cwid<=0 ) || ( $time < 0 ) ){
            return array();
        }
        $redis = $this->redis;
        $muKey = $this->getMuKey($cwid);
        $listKey = $this->getListKey($cwid,$time);
        while(true){
            $res = $redis->spop($listKey);
            if(empty($res)){
                $redis->srem($muKey,$listKey);
                break;
            }
        }
    }
    //删除指定课件的弹幕
    public function delMu($cwid = 0){
        if(!is_numeric($cwid) || $cwid <= 0){
            return;
        }
        $redis = $this->redis;
        $muKey = $this->getMuKey($cwid);
        $allListKey = $redis->smembers($muKey);
        foreach ($allListKey as $listKey) {
            $seges = explode('_', $listKey);
            $time = $seges[2];
            $this->delMuWithTime($cwid,$time);
        }
        $redis->srem('MuContainer',$muKey);
    }

    //打包弹幕信息
    private function _packMu(){
        $user = $this->user;
        $msg = $this->input->post('msg');
        $msg = $this->_msgFilter($msg);
        if(empty($msg)){
            return false;
        }
        $size = $this->input->post('size');
        $size_allow = array(10,20,30);
        if(!is_numeric($size) || !in_array( $size, $size_allow ) ){
            return false;
        }
        $color = $this->input->post('color');
        $pos = $this->input->post('pos');
        $pos_allow = array(0,1,2,3);
        if(!is_numeric($pos) || !in_array( $pos, $pos_allow ) ){
            return false;
        }
        $alpha = $this->input->post('alpha');
        if(!is_numeric($alpha) || $alpha < 0 || $alpha > 100){
            return false;
        }
        $uid = $user['uid'];
        $contentarr = array(
            'msg'=>$msg,
            'size'=>$size,
            'color'=>$color,
            'pos'=>$pos,
            'alpha'=>$alpha,
            'uid'=>$uid,
            'dateline'=>SYSTIME
        );
        return serialize($contentarr);
    }


    //过滤不文明用语,预留
    private function _msgFilter($msg = ''){
        if(!empty($msg)){
            $msg = shortstr($msg,40);
        }
        return $msg;
    }

    /**
     *删除全部弹幕
     * http://www.ebh.net/mu.html?op=sdel
    */
    private function _sdel(){
        set_time_limit(0);
        $ip = $this->input->getip();
        $allowip = array(
            '127.0.0.1',
            '192.168.0.20',
            '192.168.0.29'
        );
        $isallowed = in_array($ip, $allowip);
        if($isallowed){
            $redis = $this->redis = Ebh::app()->getCache('cache_redis');
        }else{
            $ret = array(
                'status'=>1,
                'msg'=>'权限不允许',
                'cwids'=>array()
            );
            echo json_encode($ret);
            exit();
        }
        $cwidstrmap = $redis->smembers('MuContainer');
        $cwids = array();
        foreach ($cwidstrmap as $cwidstr) {
            list($mu,$cwid)=explode('_', $cwidstr);
            if(is_numeric($cwid)){
                $this->delMu($cwid);
                array_push($cwids, $cwid);
            }
        }
       $ret = array(
            'status'=>0,
            'msg'=>'删除成功',
            'cwids'=>$cwids
        );
        echo json_encode($ret);
        exit();
    }
}
?>
