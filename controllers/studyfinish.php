<?php
/**
 * wap2
 * Author: jw
 * Email: 345468755@qq.com
 * 听课完成请求控制器
 */
class StudyfinishController extends CControl{
    public function __construct() {
        parent::__construct();

        $this->apiServer = Ebh::app()->getApiServer('ebh');
    }
    public function index(){
        $cwid = $this->input->post('id');
        $ctime = intval($this->input->post('ctime'));
        $ltime = intval($this->input->post('ltime'));

        $logid = intval($this->input->post('lid'));
        $curtime = intval($this->input->post('curtime'));//当前进度条时间
		$roominfo = Ebh::app()->room->getcurroom();
        $crid = $roominfo['crid'];
        $ip = $this->input->getip();
        $user = Ebh::app()->user->getloginuser();


        if($ltime >= $ctime &&  $curtime >=$ctime){
            $finished = 1;
        }else{
            $finished = 0;
        }
        if($user['groupid'] != 6){
            exit;
        }

        $data = array('cwid'=>$cwid,'ctime'=>$ctime,'ltime'=>$ltime,'finished'=>$finished,'logid'=>$logid,
            'curtime'=>$curtime,'uid'=>$user['uid'],'ip'=>$ip,'crid'=>$crid);
        $result = $this->apiServer->reSetting()->setService('Study.Log.add')->addParams($data)->request();
        echo json_encode(array('status'=>$result['logid']));

    }
}