<?php
/**
 * 跨域上传文件成功回调控制，用于把回调信息加载到对应的页面
 */

class UpdoneController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)) {
			echo '用户未登陆';
			exit;
		}      
    }
    public function index() {
    	$type = $this->input->get('type');//上传返回的类型
    	if ($type == 1) {//主观题
			if ($this->input->get('cwid')) {
				$outputjs = '<SCRIPT LANGUAGE="JavaScript">parent.examobj.subjectiveshow('.$this->input->get('cwid').','.$this->input->get('qid').',\''.$this->input->get('url').'\');</SCRIPT>';
			}

		} elseif ($type == 3) {//导入试题解析课件
			$outputjs = '<SCRIPT LANGUAGE="JavaScript">
			parent.examobj.showCourseware(\''.$this->input->get('cwsource').'\',\''.$this->input->get('cwid').'\','.$this->input->get('qid').',\''.$this->input->get('cwurl').'\',\''.$this->input->get('ramid').'\');</SCRIPT>';

		} elseif ($type == 4) {//导入音频试题
			$showpath = $this->input->get('showpath');
			$qid = $this->input->get('qid');
			$ramid = $this->input->get('ramid');
			$outputjs = '<script>window.parent.examobj.audioshow(\''.$showpath.'\','.$qid.');</script>';
			if (!empty($ramid))
				$outputjs = '<script>window.parent.WU.get("'.$ramid.'")(\''.$showpath.'\',"'.$ramid.'");</script>';

		} elseif ($type == 5) {//试题中的附件上传，如图片，音频，动画
			$showpath = $this->input->get('showpath');
			$uptype = $this->input->get('uptype');
			$resultparam = $this->input->get('resultparam',false);
			$outputjs = '<SCRIPT>window.parent.showImg(\''.$showpath.'\','.$uptype.','.$resultparam.');</SCRIPT>';

		} elseif ($type == 6) {//试题中的试卷上传
			$cwurl = $this->input->get('cwurl',false);
			$ramid = $this->input->get('ramid');
			$fname = $this->input->get('fname');
			$outputjs = '<SCRIPT>window.parent.WU.get(\''.$ramid.'\')(\''.$cwurl.'\',\''.$fname.'\');</SCRIPT>';
		}

		//构建跨域回调的输出界面
		$output = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<base target="_self" />
					<meta http-equiv="pragma" content="no-cache">
					<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
					<title>主观题上传-e板会在线作业</title>';

		$output .= 	$outputjs;		

		$output .=	'<style>
					body,td{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:#FCFDFD;color:#666666;margin-left:20px;font-size:12px;}
					</style>
					</head>
					<body>
					<div style="width:300px; height:50px;font-size:12px;">
					载入中......
					</div>
					</body>
					</html>';
		echo $output;exit;
	}
}
