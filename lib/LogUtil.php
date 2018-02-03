<?php
/**
 *日志工具类
 */
class LogUtil{

    //对应数据库表ebh_logs对应字段
    private $data = array(
        'uid'=>0,'toid'=>0,'type'=>'','opid'=>0,'message'=>'','value'=>0,'credit'=>0,'fromip'=>'','dateline'=>''
    );

    //初始化一些参数
    public function __construct(){
        $user =  Ebh::app()->user->getloginuser();
        $this->data['uid'] = $user['uid'];
        $this->data['fromip'] = Ebh::app()->getInput()->getip();
        $this->data['dateline'] = SYSTIME;
        $this->db = Ebh::app()->getDb();
    }
    //设置uid
    public function setUid($uid = 0){
        $this->data['uid'] = intval($uid);
        return $this;
    }
    //设置toid
    public function setToid($toid = 0){
        $this->data['toid'] = intval($toid);
        return $this;
    }
    //设置日志类型
    public function setType($type=''){
        $type = h($type);
        $this->data['type'] = $this->db->escape_str($type);
        return $this;
    }
    //设置操作id
    public function setOpid($opid = 0){
        $this->data['opid'] = intval($opid);
        return $this;
    }
    //设置信息
    public function setMessage($message = ''){
        $message = h($message);
        $this->data['message'] = $this->db->escape_str($message);
        return $this;
    }
    //设置值
    public function setValue($value = 0){
        $this->data['value'] = intval($value);
        return $this;
    }
    //设置积分
    public function setCredit($credit = 0){
        $this->data['credit'] = intval($credit);
        return $this;
    }
    //调用不存在的方法防止出错
    public function __call($method,$param){
        log_message($this->data['uid'].'调用了LogUtil不存在的方法：'.$method.'参数为：'.json_encode($param));
        return $this;
    }

    //集中设置参数
    private function _setParam($params = array()){
        if(!empty($params)){
            foreach ($params as $key => $param) {
                $method = 'set'.ucfirst($key);
                $this->$method($param);
            }
        }
    }

    //增加一条记录(参数可选),返回日志logid
    public function add($params = array()){
        if(!empty($params)){
            $this->_setParam($params);
        }
        return $this->db->insert('ebh_logs',$this->data);
    }
}