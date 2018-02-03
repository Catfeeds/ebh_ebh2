<?php
/*
学校后台管理
*/
class AsettingController extends CControl{
	public function __construct(){
		parent::__construct();
		$this->haspower = Ebh::app()->room->checkRoomControl();
        //Ebh::app()->room->checkteacher();
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
        $this->assign('myroom', $myroom);
		$this->assign('classesnum', $classesnum);
		$this->assign('foldernum', $foldernum);
		$this->assign('reviewnum', $reviewnum);
		$this->display('aroom/asetting');
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
        $this->display('aroom/upmessage');
    }
}
?>