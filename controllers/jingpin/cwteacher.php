<?php
/**
 * 学校任课教师相关控制器 CwteacherController
 */
class CwteacherController extends CControl {
	 public function __construct() {
        parent::__construct();
        $check = TRUE;
		$this->assign('check',$check);
    }
	public function index(){
        $q = $this->input->get('q');
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
		$param = parsequery();
		$param['folderid'] = $requireFolderid;
		$param['q'] = $q;
		$teachermodel = $this->model('teacher');
		$teacher = $teachermodel->getcourseteacher($param);
		
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
			$examodel = $this->model('exam');
			$examcount = $examodel->getTexamcount($param);
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

		$this->assign('notop', 1);
		$this->assign('teacher',$teacher);
		$this->assign('q',$q);
		$this->display('jingpin/cwteacher');
	}

}
?>