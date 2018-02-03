<?php
/*
附件
*/
class AttachmentController extends AdminControl{

	public function index(){
		$this->getlist(1);
		$this->display('admin/attachment');
	}
	public function getlist($init=0){
		$attachment = $this->model('attachment');
		$pagination = $this->input->get('param');
		$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
		$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
		$pagination['total'] = $attachment -> getattachmentcount($pagination);
		$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
		$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
		$attachmentlist = $attachment -> getattachmentlist($pagination);
		
		if(!$init){
			$attachmentlist[] = $pagination;
			echo json_encode($attachmentlist);
		}
		else{
			$this->assign('attachmentlist',json_encode($attachmentlist));
			$this->assign('pagination',$pagination);
			$this->assign('ctrl','attachment');
		}
	}
	/*
	编辑 ajax
	*/
	public function editattachment(){
		$attachment = $this->model('attachment');
		if($this->input->post()){
			$param = $this->input->post();
			echo $attachment->editattachment($param);
		}
		/*
		else{
			$crid = $this->input->get('crid');
			$attachmentdetail = $attachment->getattachmentdetail($crid);
			$this->assign('attachmentdetail',$attachmentdetail);
			$this->display('admin/attachment_edit');
		}*/
	}
	/*
	删除 ajax
	*/
	public function del(){
		$attachment = $this->model('attachment');
		$attid = $this->input->post('attid');
		echo json_encode(array('success'=>$attachment->deleteattachment($attid)));
	}
}
?>