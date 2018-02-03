<?php
/**
 * 上传作业上传解析课件
 */
class UploadanswercourseController extends CControl {

    public function index() {
		$user = Ebh::app()->user->getloginuser();
		if(empty($user))
			exit();
        $post = $this->input->post();
		if(!empty($post)){
			$qid = $this->input->post('qid');
			if(!is_numeric($qid) || $qid <= 0)
				exit;
			$this->_upload();
		} else {
			$this->_show_upload();
		}

    }
	/**
	*处理上传表单处理
	*/
	private function _upload() {
		$user = Ebh::app()->user->getloginuser();
		$upinfo = $this->input->post('up');
		$url = $upinfo['upfilepath'];
		$cwsize = $upinfo['upfilesize'];
		list($cwsource,$cwurl) = explode(',',$url);
		$ucoursemodel = $this->model('Usercourseware');
		$qid = $this->input->post('qid');
		$param = array(
			'uid'=>$user['uid'],
			'cwsize'=>$cwsize,
			'cwsource'=>$cwsource,
			'cwurl'=>$cwurl
		);
		$cwid = $ucoursemodel->insert($param);
		header('Location:/uploadanswercourse/callback.html?cwid='.$cwid.'&cwsource='.$cwsource.'&cwurl='.$cwurl.'&qid='.$_POST['qid']);
		// header('Location: http://exam.ebanhui.com/upcourseware.php?cwid='.$cwid.'&qid='.$_POST['qid'].'&cwsource='.$cwsource.'&cwurl='.$cwurl);
		exit;
	}
	/**
	*显示上传界面
	*/
	private function _show_upload() {
		$qid = $this->input->get('qid');
		if(is_numeric($qid) && $qid > 0) {
			$this->assign('qid',$qid);
			$upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('upcontrol',$upcontrol);
			$this->display('common/upload_answercourse');
		}
	}

	/**
	 *上传成功之后的回调函数
	 */
	public function callback(){
		$cwid = $this->input->get('cwid');
		$cwsource = $this->input->get('cwsource');
		$cwurl = $this->input->get('cwurl');
		$qid = $this->input->get('qid');
		$this->assign('cwid',$cwid);
		$this->assign('cwsource',$cwsource);
		$this->assign('qid',$qid);
		$this->assign('cwurl',$cwurl);
		$this->display('common/upcourse');
	}
}
?>