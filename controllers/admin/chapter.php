<?php
class ChapterController extends AdminControl{
	public function index(){
		
		$grade = $this->model('grade');
		$subject = $this->model('subject');
		$gradelist = $grade->getgradelist(array());
		$subjectlist = $subject->getsubjectlist(array());
		$this->assign('gradelist',$gradelist);
		$this->assign('subjectlist',$subjectlist);
		
		$this->getlist(0);
		$this->display('admin/chapter');
	}
	public function getlist($ajax=1){
		$chapter = $this->model('chapter');
		$gradeid = $this->input->post('gradeid');
		$subjectid = $this->input->post('subjectid');
		$chapterlist = $chapter->getchapterlist(array('gradeid'=>$gradeid,'subjectid'=>$subjectid));
		// var_dump($chapterlist);
		if($ajax){
			echo json_encode(array_values($chapterlist));
		}else{
			$this->assign('chapterlist',$chapterlist);
		}
	}
	/*
	添加章节
	*/
	public function addchapter(){
		$param['gradeid'] = $this->input->post('gradeid');
		$param['subjectid'] = $this->input->post('subjectid');
		if(empty($param['gradeid']) || empty($param['subjectid']))
			echo 111111111;
		$param['pid'] = $this->input->post('pid');
		$param['chaptername'] = htmlspecialchars($this->input->post('chaptername'));
		$param['displayorder'] = $this->input->post('displayorder');
		$res = $this->model('chapter')->insert($param);
		if($res)
			echo 1;
		else 
			echo 0;
	}
	/*
	编辑章节
	*/
	public function editchapter(){
		$param['chapterid'] = $this->input->post('chapterid');
		$param['chaptername'] = htmlspecialchars($this->input->post('chaptername'));
		$param['displayorder'] = $this->input->post('displayorder');
		$res = $this->model('chapter')->update($param);
		if($res!==false)
			echo 1;
		else 
			echo 0;
	}
	public function deletechapter(){
		$chapterid = $this->input->post('chapterid');
		$res = $this->model('chapter')->delete($chapterid);
		if($res)
			echo 1;
		else
			echo 0;
	}
}
?>