<?php
/**************************************
 *微校通 服务器端 定时器 群发处理 
 *@author eker
 *@email qq704855854@126.com
 *仅仅服务器内部调用
 * 
 ****************************************/
//加载初始化配置
init();
//验证来源 只允许内部访问
if(checklocal()==false){
    exit();
}

//加载初始化配置
function init(){
    //重新加载框架起动文件
    define('IN_EBH', TRUE);
    define('S_ROOT', dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
    define('IS_DEBUG', FALSE);  //是否开启调试状态
    date_default_timezone_set('Asia/Shanghai');
    $config = S_ROOT.'config/config.php';
    require S_ROOT.'system/core/runtime.php';
    Ebh::createIndexApplication($config)->run();
}
//验证来源 验证内网访问
function checklocal(){
    $fromip = getip();
    return !filter_var($fromip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
}

/**
 * 微校通 定时器发送类
 * @author eker
 */
class EthCronController extends CControl{
    private $model = null;
    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model('Eth');
    }

    /***************************************以下是微信推送 定时发送处理*****************************************************/
    /**
     * 定时发送处理
     *
     * 发送处理接口
     */
    public function send(){
        $redis = Ebh::app()->getCache('cache_redis');
        $redis_list_key = 'wxt_list';
        $process_count = 100;

        //获取链表的长度
        //$len = $redis->llen($redis_list_key);


        //测试
        //log_message(var_export(date("Y-m-d H:i:s"),true));
        //$input = EBH::app()->getInput();
        //$cookie = $input->cookie('auth');
        //log_message(var_export($cookie,true));



        $listarr = $redis->lrange($redis_list_key,0,$process_count-1);
        //echo '<pre>';
        //var_dump($listarr);
        $len = count($listarr);
        if($len<=0) return ;

        //删除链表数据
        $redis->ltrim($redis_list_key,$len,-1);

        //发送微信消息
        foreach($listarr as $list){
            $trycount = 0;	//发送消息失败后的尝试次数 //目前尝试3次
            $docheck = false;
            while (!$docheck){
                if($trycount < 3){
                    $sresult = $this->send_weixin($list);
                    if(!$sresult) {	//发送失败，则重新尝试发送
                        $sresult = $this->send_weixin($list);
                        $trycount ++;
                    }else{//发送成功
                        $docheck = true;
                        $this->save_inbox($list);
                    }
                }else{//三次尝试 发送失败
                    $this->save_inbox($list,false);
                    break;
                }
            }
        }

    }
    /**
     * 发送消息到微信账号
     * @return unknown
     */
    protected function send_weixin($list){
        //$openid = 'o5TnfjmDmAq0mO7h4OlkEl1pMYXI';
        //$openid = 'o5TnfjqPjtS9k54Og7G2r4V6cFR0';

        //list($uid,$mid,$batchid) = explode("%", $list);
        $listarr = $this->getListData($list);
        //log_message(var_export($listarr,true));
        //获取消息信息
        $message = $this->model("Eth")->getMessage($listarr['mid']);
        $msg = $message['subject'];
        $weixinlib = Ebh::app()->lib('Wechat');
        $config = $this->model("Eth")->getConfigByCrid($listarr['crid']);
        $weixinlib->init($config);

        //读取授权域名
        $domain =$weixinlib->getDomain();
        $show_msg_url = !empty($domain) ? $domain : "http://eth.ebh.net"  ;

        $content = array(
            "url"=>$show_msg_url."/wxt/msg/{$listarr['mid']}.html?student={$listarr['uid']}&ebhcode={$config['ebhcode']}",
            "data"=>array(
                "first"=>array(
                    "value"=>shortstr($msg,40),
                    "color"=>"#173177"
                ),
                "keyword1"=>array(
                    "value"=>$message['crname'],
                    "color"=>"#173177"
                ),
                "keyword2"=>array(
                    "value"=>$message['send_user'],
                    "color"=>"#173177"
                ),
                "keyword3"=>array(
                    "value"=>date('Y-m-d H:i:s'),
                    "color"=>"#173177"
                ),
                "keyword4"=>array(
                    "value"=>$msg,
                    "color"=>"#173177"
                ),
                "remark"=>array(
                    "value"=>"点击查看",
                    "color"=>"#173177"
                )
            )
            );

        //暂时先去掉消息标题
        $content['data']['first'] = array();
        //获取用户绑定的父母openid
        $sresult = true;//暂时 默认是有绑定了
        $parents = $this->model("Eth")->getParentOpenid($listarr['uid']);
        if(!empty($parents)){
            foreach($parents as $parent){
                if($parent['crid'] == $listarr['crid']){//向绑定该网校下的父母发送推送
                    $openid = $parent['openid'];
                    $sresult = $weixinlib->sendMessageByOpenidWithTpl($openid,$content,false);
                    //log_message(var_export($openid,true));
                    //父母收件未读数+1
                    $this->model("Eth")->incrNoread($openid);
                }

            }
        }

        return $sresult;
    }

    /**
     * 发送成功/失败 写入收件箱
     */
    protected function save_inbox($list,$success=true){
        //list($uid,$mid,$batchid) = explode("%", $list);
        $listarr = $this->getListData($list);
        $mid = $listarr['mid'];
        $uid = $listarr['uid'];
        $message = $this->model("Eth")->getMessage($mid);
        $ceceive_user = $this->model("Eth")->getUserInfo(array(array('uid'=>$uid)));
        $ceceive_user = $ceceive_user[0];
        //写收件箱
        $inbox = array(
            'in_uid'=>$uid,
            'in_user'=>getusername($ceceive_user),
            'mid'=>$mid,
            'crid'=>$listarr['crid'],
            'status'=>($success==true)?1:0,
            'dateline'=>SYSTIME
        );
        $this->model("Eth")->addInbox($inbox);

        //更新邮件计数
        if($success==false){
            $incrarr = array(
                "send_success_num"=>"send_success_num - 1",
                "send_error_num"=>"send_error_num + 1"
            );
            $this->model->editMessage(null,$mid,$incrarr);
            $this->model->editOutbox(null,$mid,$incrarr);
        }

        //批次是否处理完
        if($listarr['totalcount'] == $listarr['indexcount']){
            //标记处理完成
            $this->model->updateBatchStatus($listarr['batchid']);
        }
    }

    /**
     * 处理redis链表存储数据-单个数据
     */
    protected function getListData($list){
        $ret = false;
        if(empty($list) || (strpos($list, "%")==false)){
            return false;
        }
        list($uid,$crid,$mid,$batchid,$totalcount,$indexcount) = explode("%", $list);
        $ret = array(
            'uid'=>$uid,
            'mid'=>$mid,
            'crid'=>$crid,
            'batchid'=>$batchid,
            'totalcount'=>$totalcount,
            'indexcount'=>$indexcount,
        );
        return $ret;
    }

    /**
     * 测试...
     */
    public function demo(){
        $ceceive_user = $this->model("Eth")->getUserInfo(array(array("uid"=>10269)));
        $ceceive_user = $ceceive_user[0];
        var_dump($ceceive_user);
    }

}

//定时发送
$cron = new EthCronController();
$cron->send();
