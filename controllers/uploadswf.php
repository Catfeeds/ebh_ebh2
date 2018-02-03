<?php

/**
 * 上传课件预览文件控制器类
 */
class UploadswfController extends CControl {

    public function index() {
		$ip = $this->input->getip();
		$_serverlist = Ebh::app()->getConfig()->load('allowservers');
		if(!empty($_serverlist) && !in_array($ip,$_serverlist)) {	//不在列表内的IP 不允许上传
			exit(0);
		}
        $uploader = Ebh::app()->lib('Uploader');
        //上传配置
        $config = array(
            "savePath" => "uploads/", //存储文件夹
            "showPath" => "uploads/", //显示文件夹
            "maxSize" => 314572800, //允许的文件最大尺寸，单位字节 300M
            "allowFiles" => array(".swf")  //允许的文件格式
        );
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $up_type = 'attachment';
        $upload_name = 'file';
		$filename = $_FILES[$upload_name]['name'];
        $savepath = 'uploads/';
        $showpath = 'uploads/';
        if (!empty($_UP[$up_type]['savepath'])) {
            $savepath = $_UP[$up_type]['savepath'];
        }
        $config['savePath'] = $savepath;
        $config['showPath'] = $showpath;
		$filetime = strstr($filename,'.',true);
		if(strlen($filetime) > 10) {
			$filetime = substr($filetime,0,10);
		}
		$year = date('Y',$filetime);
		$month = date('m',$filetime);
		$day = date('d',$filetime);
		$folder = $year.'/'.$month.'/'.$day.'/';
		$uploader->setName($filename);
		$uploader->setFolder($folder);
        $uploader->init($upload_name, $config);
        $info = $uploader->getFileInfo();
        exit(0);
    }

}
