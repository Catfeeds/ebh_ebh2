<?php
/**
 * 课程章节控制器类
 */
class SectionController extends CControl{
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
        
    }
    public function index() {
        if(NULL != $this->input->post('folderid')) {
            $roominfo = Ebh::app()->room->getcurroom();
            $crid = $roominfo['crid'];
            $folderid = intval($this->input->post('folderid'));
            $sectionmodel = $this->model('Section');
            $sections = $sectionmodel->getsections(array('crid'=>$crid,'folderid'=>$folderid));
            echo json_encode($sections);
        } else {
			$folderid = $this->uri->uri_attr(0);
			$folderid = empty($folderid) ? 0 : intval($folderid);
			$this->assign('folderid',$folderid);
			$this->display('troomv2/section');
		}
    }
    public function add() {
        if(NULL != $this->input->post('folderid')) {
            $roominfo = Ebh::app()->room->getcurroom();
            $crid = $roominfo['crid'];
            $folderid = intval($this->input->post('folderid'));
            $sname = $this->input->post('sname');
			$sname = htmlspecialchars($sname);
            if(empty($sname) || empty($folderid)) {
                echo json_encode(array('status'=>0));
            }
            $sectionmodel = $this->model('Section');
            $maxorder = $sectionmodel->getmaxorder($folderid);
            $param = array('folderid'=>$folderid,'crid'=>$crid,'sname'=>$sname,'dateline'=>time(),'displayorder'=>$maxorder+1,'coursewarecount'=>0);
            $sid = $sectionmodel->insert($param);
            if(!empty($sid)){
				echo json_encode(array('status'=>1,'sid'=>$sid,'sname'=>$sname,'displayorder'=>$maxorder+1));
            }else{
                echo json_encode(array('status'=>0));
            }
        }
    }
    public function edit() {
        if(NULL != $this->input->post('sid')) {
            $roominfo = Ebh::app()->room->getcurroom();
            $crid = $roominfo['crid'];
            $sid = intval($this->input->post('sid'));
            $sname = $this->input->post('title');
            if(empty($sname) || empty($sid)) {
                echo json_encode(array('status'=>0));
            }
            $sectionmodel = $this->model('Section');
            $wherearr = array('sid'=>$sid,'crid'=>$crid);
            $param = array('sname'=>$sname);
            $arows = $sectionmodel->update($param,$wherearr);
            if(!empty($arows)){
				echo json_encode(array('status'=>1,'sid'=>$sid,'sname'=>$sname));
            }else{
                echo json_encode(array('status'=>0));
            }
        }
    }
    public function del() {
        if(NULL != $this->input->post('sid')) {
            $roominfo = Ebh::app()->room->getcurroom();
            $crid = $roominfo['crid'];
            $sid = intval($this->input->post('sid'));
            if(empty($sid)) {
                echo json_encode(array('status'=>0));
            }
            $sectionmodel = $this->model('Section');
            $wherearr = array('sid'=>$sid,'crid'=>$crid);
            $arows = $sectionmodel->del($wherearr);
            //将原来属于章节下的课件的sid置为0
            $coursemodel = $this->model('Roomcourse');
            $coursemodel->setSidBysid($sid,$crid);
            if(!empty($arows)){
				echo json_encode(array('status'=>1,'sid'=>$sid));
            }else{
                echo json_encode(array('status'=>0));
            }
        }
    }
	/*
	 * 上移章节
	*/
    public function moveup() {
        if(NULL != $this->input->post('sid')) {
            $sid = intval($this->input->post('sid'));
            if(empty($sid)) {
                echo json_encode(array('status'=>0));
            }
            $sectionmodel = $this->model('Section');
            $arows = $sectionmodel->moveup($sid);
            if(!empty($arows)){
				echo json_encode(array('status'=>1,'sid'=>$sid));
            }else{
                echo json_encode(array('status'=>0));
            }
        }
    }
	
	/*
	 * 下移章节
	*/
    public function movedown() {
        if(NULL != $this->input->post('sid')) {
            $sid = intval($this->input->post('sid'));
            if(empty($sid)) {
                echo json_encode(array('status'=>0));
            }
            $sectionmodel = $this->model('Section');
            $arows = $sectionmodel->movedown($sid);
            if(!empty($arows)){
				echo json_encode(array('status'=>1,'sid'=>$sid));
            }else{
                echo json_encode(array('status'=>0));
            }
        }
    }
	
	/*
	 * 直接输入排序号修改
	*/
	public function updateOrder(){
		$roominfo = Ebh::app()->room->getcurroom();
		$data['sid'] = intval($this->input->post('sid'));
		$data['displayorder'] = intval($this->input->post('displayorder'));
		$data['crid'] = $roominfo['crid'];
		if(empty($data['sid']) || empty($data['displayorder']) || $data['displayorder']<0) {
			echo json_encode(array('status'=>0));
		}
		
		$result = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Aroomv3.Section.updateOrder')->addParams($data)->request();
		
		if($result !== FALSE){
			echo json_encode(array('status'=>1,'sid'=>$data['sid']));
		} else {
			echo json_encode(array('status'=>0));
		}
	}
}
