<?php
/**
*听课完成请求控制器
*/
class StudyfinishController extends CControl{

	public $apiServer;
    public function __construct(){
        parent::__construct();
        $this->apiServer = Ebh::app()->getApiServer('ebh');
	}
	/**
	*听课完成请求
	*/
	public function index() {
		$cwid = $this->input->post('cwid');
		$result = array();
		$ctime = intval($this->input->post('ctime'));
		$ltime = intval($this->input->post('ltime'));
		$finished = intval($this->input->post('finished'));
		$logid = intval($this->input->post('logid'));
		$curtime = intval($this->input->post('curtime'));//当前进度条时间
		$crid = intval($this->input->post('crid'));	//学习所在平台，不一定同课件所在的crid
		$ip = $this->input->getip();
		$user = Ebh::app()->user->getloginuser();
		if($user['groupid'] != 6)
			exit;
		$data = array('cwid'=>$cwid,'ctime'=>$ctime,'ltime'=>$ltime,'finished'=>$finished,'logid'=>$logid,
			'curtime'=>$curtime,'uid'=>$user['uid'],'ip'=>$ip,'crid'=>$crid);
		//通过接口方式调用学习记录
		$result = $this->apiServer->reSetting()->setService('Study.Log.add')->addParams($data)->request();
        if(isset($result['logid'])){
            echo json_encode(array('status'=>$result['logid']));
        }
		/**
		 *
		 学习记录采用接口方式添加，老的方式暂时注释，后续去掉
		$studymodel = $this->model('Studylog');


		//如果听课时长达到了视频总时长的0.9倍则听课时长标记为总时长，
		//如果听课时长超过了视频总时长的2倍，则听课时长标记为课件总时长的2倍
		if(is_numeric($ctime) && is_numeric($ltime) && ($ctime > 0) && ($ltime > 0) ){
			if( ( $ltime < $ctime ) && ( $ltime/$ctime>0.9 ) ){
				$ltime = $ctime;
			}
			if( $ltime > ($ctime * 2) ){
				$ltime = ( $ctime * 2 );
			}
		}else{
			exit;
		}


		$param = array('uid'=>$user['uid'],'cwid'=>$cwid,'ctime'=>$ctime,'ltime'=>$ltime,'finished'=>$finished);
		if($logid > 0) {
			$param['logid'] = $logid;
		} else {
			$param['logid'] = 0;
		}
		if( $ltime  > ($ctime * 3) ){
			$result['status'] = $logid;
			echo json_encode($result);
			exit();
		}
		$param['curtime'] = 0;
		if(!empty($curtime) && is_numeric($curtime) && $curtime<=$ctime)
			$param['curtime'] = intval($curtime);
		$afrows = $studymodel->addlog($param);
		$logid = $afrows;
		if($afrows > 0) {
			
			$percent = $ltime/$ctime;
			$cwinfo = $this->model('courseware')->getSimplecourseByCwid($cwid);
			$roominfo = Ebh::app()->room->getcurroom();
			if(!empty($roominfo)){
				$other_config = Ebh::app()->getConfig()->load('othersetting');
				$other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
				$other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
				$is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
				$is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);
				if($is_zjdlr){//国土的按累计时长计算
					$pmodel = $this->model('Progress');
					$pct = $pmodel->getFolderProgressByCwid_cwsum(array('cwid'=>$cwid,'uid'=>$user['uid']));
					$percent = $pct[0]['percent'];
				}
			}
			if($percent>0.9){
				$credit = $this->model('credit');
				$credit->addCreditlog(array('ruleid'=>5,'detail'=>$cwinfo['title'],'cwid'=>$cwid));
			}
			$result['status'] = $logid;
		} else {
			$result['status'] = 0;
		}
		echo json_encode($result);
		*/
	}
	
}
?>