<?php
/**
 * 教师网校我的教室控制器 SettingController
 */
class SettingController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $roommodel = $this->model('Classroom');
        $myroom = $roommodel->getdetailclassroom($roominfo['crid']);
        $this->assign('myroom', $myroom);
        $this->display('aroomv2/setting');
    }
    /**
     * 修改教室信息
     */
    public function upinfo() {
        if($this->input->post() !== NULL) {
            
            $param = array();
            $summary = $this->input->post('summary');   //简介
            if($summary !== NULL) {
                $param['summary'] = $summary;
            }
            $message = $this->input->post('message');   //简介
            if($message !== NULL) {
                $param['message'] = $message;
            }
            $crphone = $this->input->post('crphone');   //电话
            if($crphone !== NULL) {
                $param['crphone'] = $crphone;
            }
            $craddress = $this->input->post('craddress');   //电话
            if($craddress !== NULL) {
                $param['craddress'] = $craddress;
            }
            $cremail = $this->input->post('cremail');   //邮箱或主页
            if($cremail !== NULL) {
                $param['cremail'] = $cremail;
            }
            $crqq = $this->input->post('crqq'); //QQ
            if($crqq !== NULL) {
                $param['crqq'] = $crqq;
            }
            $lng = $this->input->post('lng');   //经度
            if($lng !== NULL) {
                $param['lng'] = $lng;
            }
            $lat = $this->input->post('lat');   //纬度
            if($lat !== NULL) {
                $param['lat'] = $lat;
            }
            $message = $this->input->post('message');   //详细介绍
            if($message !== NULL) {
                $param['message'] = $message;
            }
            $crlabel = $this->input->post('crlabel');   //标签
            if($crlabel !== NULL) {
                $param['crlabel'] = $crlabel;
            }
            if(!empty($param)) {
                $roominfo = Ebh::app()->room->getcurroom();
                $roommodel = $this->model('Classroom');
                $param['crid'] = $roominfo['crid'];
                $result = $roommodel->editclassroom($param);
                if($result !== FALSE) {
                    echo 'success';
					$roomcache = Ebh::app()->lib('Roomcache');
					$roomcache->removeCache($roominfo['crid'],'roominfo','detail');
                } else {
                    echo 'fail';
                }
            }
            else {
                echo 'fail';
            }
        } else {
            echo 'fail';
        }
    }
    public function upmessage() {
        $roominfo = Ebh::app()->room->getcurroom();
        $roommodel = $this->model('Classroom');
        $myroom = $roommodel->getdetailclassroom($roominfo['crid']);
        $editor = Ebh::app()->lib('UMEditor');
        $this->assign('myroom', $myroom);
        $this->assign('editor', $editor);
        $this->display('aroomv2/upmessage');
    }
	/*
	普通上传头像
	*/
	public function avatarold(){
		$op = '';
		if($this->input->post()){
			$op = $this->input->post('op');
			if($this->input->post('returnurl'))
				$returnurl = '<a href="'.$this->input->post('returnurl').'">点击返回</a>';
			else
				$returnurl = '<a href="javascript:history.back(1);">点击返回</a>';
			

			$file = $_FILES["UpFile"];
			$filename = $file['tmp_name'];
			$mimetype = $file['type'];
			$postname = $file['name'];
			$upfile = curl_file_create($filename, $mimetype, $postname);
			$ret = do_post('http://up.ebh.net/avatar/avatarold.html',array('UpFile'=>$upfile,'ispost'=>1),false);

			$this->assign('fname',$ret->fname);
			$this->assign('sourceimg',$ret->sourceimg);
		}else{
			
		}
        $roomcache = Ebh::app()->lib('Roomcache');
        $uri = Ebh::app()->getUri();
        $domain = $uri->uri_domain();
        $roomcache->removeCache(0,'roominfo',$domain);
		if($op == 'teacher'){
			$this->display('teacher/avatar_old');
		}
		else{
			$classroom = $this->model('classroom');
			$roominfo = Ebh::app()->room->getcurroom();
			$roomdetail = $classroom->getclassroomdetail($roominfo['crid']);
			$cface = str_replace('_xx','',$roomdetail['cface']);
			$this->assign('sourcepath',$cface);
			$this->display('aroomv2/customlogo');
		}

	}
	/*
	文件路径
	*/
	private function getdirurl($folder) {
		$timestamp=SYSTIME;
		$destination_folder=$folder;
		$yearpath=Date('Y', $timestamp).'/';
		$monthpath=$yearpath.Date('m', $timestamp).'/';
		$dayspath = $monthpath.Date('d', $timestamp).'/';
		if(!file_exists($destination_folder))
		mkdir($destination_folder);
		if(!file_exists($destination_folder.$yearpath))
		mkdir($destination_folder.$yearpath);
		if(!file_exists($destination_folder.$monthpath))
		mkdir($destination_folder.$monthpath);
		if(!file_exists($destination_folder.$dayspath))
		mkdir($destination_folder.$dayspath);
		return ltrim($dayspath,'.');
		
	}
	public function avatarupdate(){
		if(!$this->input->post()){
			echo '错误的访问';
			exit();
		}
		$postarr = $this->input->post();
		$destshowpath = $this->input->post('destshowpath');
		if(!empty($destshowpath)){
			if($postarr['op'] == 'logo'){
				$classroom = $this->model('classroom');
				$roominfo = Ebh::app()->room->getcurroom();
				$param = array('cface'=>$destshowpath,'crid'=>$roominfo['crid']);
				$result = $classroom->editclassroom($param);
				//更新学校信息缓存
				$roomcache = Ebh::app()->lib('Roomcache');
				$roomcache->removeCache($roominfo['crid'],'roominfo','detail');
				EBh::app()->lib('Sns')->updateClassRooomCache(array('crid'=>$roominfo['crid'],'domain'=>$roominfo['domain'],'crname'=>$roominfo['crname'],'cface'=>$destshowpath));

			}elseif($postarr['op'] == 'teacher'){
				$teacher = $this->model('teacher');
				$user = Ebh::app()->user->getloginuser();
				$param = array('face'=>$destshowpath,'uid'=>$user['uid']);
				$result = $teacher->editteacher($param);
			}
		}
		if($result !== FALSE){
            echo 1;
		}
        else
			echo 0;
	}
	
	public function roomlogo(){
		$roominfo = Ebh::app()->room->getcurroom();
		$classroom = $this->model('classroom');
		if($this->input->post()){
			$param['crid'] = $roominfo['crid'];
			$param['cface'] = $this->input->post('logo');
			$result = $classroom->editclassroom($param);
			if($result !== FALSE){
				echo 1;
				$roomcache = Ebh::app()->lib('Roomcache');
				$roomcache->removeCache($roominfo['crid'],'roominfo','detail');

                $uri = Ebh::app()->getUri();
                $domain = $uri->uri_domain();
                $roomcache->removeCache(0,'roominfo',$domain);
			}
			else
				echo 0;
		}else{
			
			$myroom = $classroom->getdetailclassroom($roominfo['crid']);
			$this->assign('myroom',$myroom);
			$this->display('aroomv2/roomlogo');
		}
	}
}
