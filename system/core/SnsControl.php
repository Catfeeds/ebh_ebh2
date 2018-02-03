<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 13:39
 */
class SnsBaseController extends  CControl{
    public $apiServer;
    public $user = false;
    public $curUser = 0;
    public function __construct(){
        parent::__construct();
        Ebh::app()->user->checkUserLogin(null,true);
        $this->apiServer = Ebh::app()->getApiServer('ebh');
        $this->user = Ebh::app()->user->getloginuser();

        if($this->uri->itemid == 0){
            $this->curUser = $this->user['uid'];
        }else{
            $this->curUser = intval($this->uri->itemid);
        }

        //获取当前用户统计
        $curUserinfo =  $this->apiServer->reSetting()->setService('Sns.Info.detail')->addParams(array('uid'=>$this->curUser,'userid'=>$this->user['uid']))->request();
        $this->assign('snsUser',$curUserinfo);
        $this->assign('user', $this->user);

        $this->assign('uid',$this->curUser);
    }

    /**
     * 对添加或编辑的问题的标题和内容进行敏感词验证
     */
    public function checkSensitive($title){
        require_once(LIB_PATH."SimpleDict.php");
        if(!file_exists(LIB_PATH."sensitive.cache")){
            SimpleDict::make(LIB_PATH."sensitive.dat",LIB_PATH."sensitive.cache");
        }
        $dict = new SimpleDict(LIB_PATH."sensitive.cache");
        $title =  preg_replace("/\s/","",$title);
        $result = $dict->search($title);
        $resultarr= array();
        if(!empty($result)){
            foreach ($result as $key => $value) {
                $resultarr[] =  $value['value'];
            }
            renderjson(1,'内容含有敏感词',array(
                'Sensitive'=>$resultarr
            ));
        }
    }
}