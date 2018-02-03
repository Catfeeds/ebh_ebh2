<?php
/**
 * 上传作业主观题课件控制器类
 */
class UploadsubjectiveController extends CControl {

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
		$uploader = Ebh::app()->lib('Uploader');
        //上传配置
        $config = array(
            "savePath" => "uploads/", //存储文件夹
            "showPath" => "uploads/", //显示文件夹
            "maxSize" => 209715200, //允许的文件最大尺寸，单位字节
            "allowFiles" => array(".ebh",".jpg",".jpeg",".gif")  //允许的文件格式
        );
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $up_type = 'examcourse';
        $upload_name = 'upfile';
        $savepath = 'uploads/';
        $showpath = 'uploads/';
        if (!empty($_UP[$up_type]['savepath'])) {
            $savepath = $_UP[$up_type]['savepath'];
        }
        if (!empty($_UP[$up_type]['showpath'])) {
            $showpath = $_UP[$up_type]['showpath'];
        }
        $config['savePath'] = $savepath;
        $config['showPath'] = $showpath;

        $uploader->init($upload_name, $config);
        $info = $uploader->getFileInfo();
        if ($info['state'] == 'SUCCESS') {
			$server_path = 'http://' . $_SERVER['HTTP_HOST'] . '/';
			$coursemodel = $this->model('Schcourseware');
			$param = array(
				'uid'		=>$user['uid'],
				'cwsize'	=>$info['size'],
				'cwname'	=>$info["originalName"],
				'cwsource'	=>$server_path,
				'cwurl'		=>$info['url']
			);
			$cwid = $coursemodel->insert($param);
			if($cwid > 0) {
				$qid = $this->input->post('qid');
				header('Location: http://exam.ebanhui.com/upsubjective.php?cwid='.$cwid.'&qid='.$qid);
				exit;
			}
        }
        exit(0);
	}
	/**
	*显示上传界面
	*/
	private function _show_upload() {
		$qid = $this->input->get('qid');
		if(is_numeric($qid) && $qid > 0) {
			$this->assign('qid',$qid);
			$this->display('common/upload_subjective');
		}
	}
}
?>