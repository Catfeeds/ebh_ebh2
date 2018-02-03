<?php
/*
任务
*/
class TaskController extends AdminControl{
	
	public function index(){
		$this->getlist(1);
		$this->display('admin/task');
	}
	public function getlist($init=0){
		$task = $this->model('task');
		$pagination = $this->input->get('param');
		$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
		$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
		$pagination['total'] = $task -> gettaskcount($pagination);
		$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
		$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
		$tasklist = $task -> gettasklist($pagination);
		
		if(!$init){
			$tasklist[] = $pagination;
			echo json_encode($tasklist);
		}
		else{
			$this->assign('tasklist',json_encode($tasklist));
			$this->assign('pagination',$pagination);
			$this->assign('ctrl','task');
		}
	}
	/*
	添加任务
	*/
	public function add(){
		$task = $this->model('task');
		if($this->input->post()){
			$param = $this->input->post();
			$res = $task->addtask($param);
			if($res!==false){
				$this->widget('note_widget',array('note'=>'操作成功,跳转中...','returnurl'=>'/admin/task.html'));
				exit;
			}
		}else{
			$this->display('admin/task_add');
		}
	}
	/*
	编辑任务
	*/
	public function edit(){
		$task = $this->model('task');
		if($this->input->post()){
			$param = $this->input->post();
			$res = $task->edittask($param);
			if($res!==false){
				$this->widget('note_widget',array('note'=>'操作成功,跳转中...','returnurl'=>'/admin/task.html'));
				exit;
			}
		}else{
			$id = $this->input->get('id');
			$taskdetail = $task->gettaskdetail($id);
			$this->assign('taskdetail',$taskdetail);
			$this->display('admin/task_edit');
		}
	}
	
	/*
	删除任务 ajax
	*/
	public function del(){
		$task = $this->model('task');
		$id = $this->input->post('id');
		echo json_encode(array('success'=>$task->deletetask($id)));
	}
}
?>