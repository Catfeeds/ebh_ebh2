<?php
/**
 * 学校任课教师相关控制器 CwteacherController
 */
class CwteacherController extends CControl {
	 public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
        $check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
		//$aq = $this->input->get('aq');
        //$folderid = $this->input->get('fid');
		$requireFolderid = $this->input->get('folderid');
		if(!is_numeric($requireFolderid) || $requireFolderid < 0){
			echo '课程不存在,请刷新页面重试';
            exit();
		}
		if(!empty($requireFolderid)){
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
		//$cwid = $this->input->get('cwid');
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['folderid'] = $requireFolderid;
		$param['q'] = $q;
		$teachermodel = $this->model('teacher');
		$teacher = $teachermodel->getcourseteacher($param);

		//java数据服务器地址,取新作业的数量数据
		$newExamPower = $this->model('appmodule')->checkRoomMoudle($roominfo['crid'],'/troomv2/examv2.html');
		if ($newExamPower) {
			$param['ttype'] = 'FOLDER';
			$param['tid'] = $requireFolderid;
			$dataserver = EBH::app()->getConfig('dataserver')->load('dataserver');
	        $servers = $dataserver['servers'];
	        //随机抽取一台服务器
	        $target_server = $servers[array_rand($servers,1)];
			$url = 'http://'.$target_server.'/exam/telist';
		}
		foreach ($teacher as $k=>$arr) {
			$param['uid'] = $arr['tid'];
			//$param['folderid'] = $requireFolderid;
			//讲课(课件数)
			$coursewaremodel = $this->model('courseware');
			$coursewarecount = $coursewaremodel->getTcoursecount($param);
			$teacher[$k]['coursewarecount'] =  $coursewarecount['count'];
			//总课时
			$teacher[$k]['coursewarecwlength'] =  $coursewarecount['cwlength'];
			//作业数量
			if ($newExamPower) {//开通新作业就用新作业的页面
				$param['status'] = 1;
				$param['size'] = 1;
				$param['k'] = authcode(json_encode(array('uid'=>$arr['tid'],'crid'=>$roominfo['crid'],'t'=>SYSTIME)),'ENCODE');
				$postParam = json_encode($param);
				$postRet = do_post($url,$postParam,FALSE,TRUE);
				$examcount = $postRet->datas->pageInfo->totalElement;;
			} else {
				$examodel = $this->model('exam');
				$examcount = $examodel->getTexamcount($param);
			}
			$teacher[$k]['examcount'] =  $examcount;
			//解答数量
			$askcountmodel = $this->model('askquestion');
			$askcount = $askcountmodel->getaskcountbyanswers($param);
			$teacher[$k]['askcount'] =  $askcount;
			//评论
			$param['rev'] = 'rev';
			$reviewmodel = $this->model('review');
			$reviewcount = $reviewmodel->getreviewcount($param);
			$teacher[$k]['reviewcount'] =  $reviewcount;
			//积分
			$classmodel = $this->model('Classes');
			$clconfig = Ebh::app()->getConfig()->load('creditlevel_t');
			foreach($clconfig as $clevel){
				if($arr['credit']>=$clevel['min'] && $arr['credit']<=$clevel['max']){
					$teacher[$k]['jifen_data'] = $clevel['title'];
				}
			} 
			
		}
		$this->assign('teacher',$teacher);
		$this->assign('q',$q);
		$this->display('college/cwteacher');
	}

}
?>