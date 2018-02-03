<?php
/*
学校后台管理
*/
class AsettingController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
	}
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
        $roommodel = $this->model('Classroom');
        $myroom = $roommodel->getdetailclassroom($roominfo['crid']);
		$classesmodel = $this->model('Classes');
        $classesnum = $classesmodel->getroomclasscount($roominfo['crid']);
		$foldermodel = $this->model('Folder');
		$param = array();
		$param['crid'] = $roominfo['crid'];
		$param['nosubfolder'] = 1;
        $foldernum = $foldermodel->getcount($param);
		$reviewnum = $foldermodel->getAllReviewnum($param);
		//部分实例
		$user = Ebh::app()->user->getloginuser();
		if(empty($user) || $user['groupid'] != 5) {
			header("Location: /");
			return;
		}
		$roommodel = $this->model('Classroom');
		$roomlist = $roommodel->getTVroomlist();
		$this->assign('roomlist',$roomlist);

        //客服信息
        $kefu=array();
        if(!empty($myroom['kefu'])||!empty($myroom['kefuqq'])){
            $kefu['kefu'] = explode(',',$myroom['kefu']);
            $kefu['kefuqq'] = explode(',',$myroom['kefuqq']);
        }
        $this->assign('kefu',$kefu);

        $this->assign('myroom', $myroom);
		$this->assign('classesnum', $classesnum);
		$this->assign('foldernum', $foldernum);
		$this->assign('reviewnum', $reviewnum);
		$this->display('aroomv2/asetting');
	}
	/**
     * 修改教室信息
     */
    public function upinfo() {
        if($this->input->post() !== NULL) {
            
            $param = array();
            $summary = $this->input->post('summary');   //简介
            if($summary !== NULL) {
                $param['summary'] = $summary;
            }
            $message = $this->input->post('message');   //简介
            if($message !== NULL) {
                $param['message'] = $message;
            }
            $crphone = $this->input->post('crphone');   //电话
            if($crphone !== NULL) {
                $param['crphone'] = $crphone;
            }
            $craddress = $this->input->post('craddress');   //电话
            if($craddress !== NULL) {
                $param['craddress'] = $craddress;
            }
            $kfcontent = $this->input->post('kfcontent'); //客服信息
            if($kfcontent !== NULL) {
                $kf=array();
                $qq=array();
                foreach($kfcontent as $k=>$v){
                    if($k==0||$k%2==0){
                        if($v=='请输入客服名称，如：徐老师'){
                            $v=0;
                        }
                        $kf[]=$v;
                    }else{
                        if($v=='请输入QQ号码'){
                            if($kf[($k-1)/2]===0){
                                unset($kf[($k-1)/2]);
                                continue;
                            }
                            $v=0;
                        }
                        $qq[]=$v;
                    }
                }
                $param['kefu'] = implode(',',$kf);
                $param['kefuqq'] = implode(',',$qq);
            }
			
            $cremail = $this->input->post('cremail');   //邮箱或主页
            if($cremail !== NULL) {
                $param['cremail'] = $cremail;
            }
            $crqq = $this->input->post('crqq'); //QQ
            if($crqq !== NULL) {
                $param['crqq'] = $crqq;
            }
			$weibosina = $this->input->post('weibosina');
			if($weibosina !== NULL){
				$param['weibosina'] = $weibosina;
			}
            $lng = $this->input->post('lng');   //经度
            if($lng !== NULL) {
                $param['lng'] = $lng;
            }
            $lat = $this->input->post('lat');   //纬度
            if($lat !== NULL) {
                $param['lat'] = $lat;
            }
            $message = $this->input->post('message');   //详细介绍
            if($message !== NULL) {
                $param['message'] = $message;
            }
            $crlabel = $this->input->post('crlabel');   //标签
            if($crlabel !== NULL) {
                $param['crlabel'] = $crlabel;
            }
            if(!empty($param)) {
                $roominfo = Ebh::app()->room->getcurroom();
                $roommodel = $this->model('Classroom');
                $param['crid'] = $roominfo['crid'];
                $result = $roommodel->editclassroom($param);
                if($result !== FALSE) {
                    echo 'success';
					$roomcache = Ebh::app()->lib('Roomcache');
                    $uri = Ebh::app()->getUri();
                    $domain = $uri->uri_domain();
					$roomcache->removeCache(0,'roominfo',$domain);
					$roomcache->removeCache($roominfo['crid'],'roominfo','detail');
                } else {
                    echo 'fail';
                }
            }
            else {
                echo 'fail';
            }
        } else {
            echo 'fail';
        }
    }
    public function upmessage() {
        $roominfo = Ebh::app()->room->getcurroom();
        $roommodel = $this->model('Classroom');
        $myroom = $roommodel->getdetailclassroom($roominfo['crid']);
        $editor = Ebh::app()->lib('UMEditor');
        $this->assign('myroom', $myroom);
        $this->assign('editor', $editor);
        $this->display('aroomv2/upmessage');
    }

    //qq设置提示页
    public function qqsetting(){
        $this->display('aroomv2/asetting_qq');
    }
}
?>