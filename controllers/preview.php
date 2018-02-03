<?php

/**
 * 课件预览0请求控制器
 */
class PreviewController extends CControl {
	/**
	*课件为doc/ppt/xls/pdf格式的预览
	*/
	public function view() {
		$cwid = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)) {
			$url = geturl('login') . '?returnurl=' . geturl('preview/'.$cwid);
            header("Location: $url");
			exit();
		}
		$coursemodel = $this->model('Courseware');
        $course = $coursemodel->getplaycoursedetail($cwid);
		$title = "";
		if(!empty($course)) {
			$title = $course['title'];
		}
		$url = '/attach.html?cwid='.$cwid.'&type=preview';
		$downurl = '/attach.html?cwid='.$cwid;
		$url = urlencode($url);
		$this->assign('title',$title);
		$this->assign('url',$url);
		$this->assign('downurl',$downurl);
		$this->display('common/preview');
		
	}
	/**
	*课件附件为doc/ppt/xls/pdf格式的预览
	*/
	public function att_view() {
		$attid = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)) {
			$url = geturl('login') . '?returnurl=' . geturl('preview/att/'.$attid);
            header("Location: $url");
			exit();
		}
		$attachmodel = $this->model('Attachment');
		$attach = $attachmodel->getAttachById($attid);
		$title = "";
		if(!empty($attach)) {
			$title = $attach['filename'];
		}
		$url = '/attach.html?attid='.$attid.'&type=preview';
		$downurl = '/attach.html?attid='.$attid;
		$url = urlencode($url);
		$this->assign('title',$title);
		$this->assign('url',$url);
		$this->assign('downurl',$downurl);
		$this->display('common/preview');
	}

	//课件PDF预览
	public function pdf_view(){
		$cwid = $this->uri->itemid;
		$downurl = geturl('preview/getpreview/'.$cwid);
		$file = $this->input->get('file');
		if(empty($file)){
			$redirectUrl = geturl('preview/pdf/'.$cwid).'?file='.urlencode($downurl);
			header('Location:'.$redirectUrl);exit;
		}
		$coursemodel = $this->model('Courseware');
        $course = $coursemodel->getplaycoursedetail($cwid);
        if(empty($course['apppreview'])){
        	echo '该课件暂不支持预览!';
        	exit;
        }
		$title = "";
		if(!empty($course)) {
			$title = $course['title'];
		}
		$this->assign('title',$title);
		$this->display('common/pdf_preview');
	}
	//PDF预览资源请求
	public function getpreview_view(){
		$cwid = $this->uri->itemid;
		if( !is_numeric($cwid) || $cwid<0 ){
			echo '';exit;
		}
		echo do_post('http://up.ebh.net/attach.html?preview=1&cwid='.$cwid,array('cwid'=>$cwid));
	}
}
