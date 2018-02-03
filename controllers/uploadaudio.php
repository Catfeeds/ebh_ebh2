<?php
/**
 * 上传声音控制器，主要用于答疑的语音上传，以后可扩展为其他普通的附件类型下载。不需要判断权限的
 */
class UploadaudioController extends CControl{
    public function __construct() {
        parent::__construct();
        // Ebh::app()->room->checkteacher();
        
    }
    public function index() {
        $uploader = Ebh::app()->lib('Uploader');
        //上传配置
        $config = array(
            "savePath" => "uploads/" ,             //存储文件夹
            "showPath" => "uploads/" ,              //显示文件夹
            "maxSize" => 20971520 ,                   //允许的文件最大尺寸，单位字节
            "allowFiles" => array( ".wav" , ".mp3")  //允许的文件格式;
        );
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        
        $up_type = 'audio';
        $savepath = 'uploads/';
        $showpath = 'uploads/';
        if(!empty($_UP[$up_type]['savepath'])){
            $savepath = $_UP[$up_type]['savepath'];
		}
        if(!empty($_UP[$up_type]['showpath'])){
            $showpath = $_UP[$up_type]['showpath'];
		}
        $config['savePath'] = $savepath;
        $config['showPath'] = $showpath;
        $upfield = 'Filedata';
        $uploader->init($upfield,$config);

        $info = $uploader->getFileInfo();
        $info['url_path'] = $info['showurl'];
        echo json_encode($info);

    }
    
    /**
     * 答疑flash录音上传接口
     * 
     */
    public function upload(){
    	if (!empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
    		$_UP = Ebh::app()->getConfig()->load('upconfig');
    		
    		$up_type = 'audio';
    		$savepath = 'uploads/';
    		$showpath = 'uploads/';
    		if(!empty($_UP[$up_type]['savepath'])){
    			$savepath = $_UP[$up_type]['savepath'];
    		}
    		if(!empty($_UP[$up_type]['showpath'])){
    			$showpath = $_UP[$up_type]['showpath'];
    		}
    		
    		$mp3 =$GLOBALS['HTTP_RAW_POST_DATA'];
    		//$mp3 = file_get_contents("php://input"); //这个占用内存小
    		$filename = SYSTIME.'.mp3';
    		$folderpath = $this->getFolder($savepath);
    		$destsavepath = $savepath.$folderpath.$filename;
    		$destshowpath = $showpath.$folderpath.$filename;
    		
    		@file_put_contents($destsavepath,$mp3);
    		echo json_encode(array('audiosrc'=>$destshowpath));
    	}else{
    		echo  'error';
    		exit;
    	}
    }
    
    /**
     * 按照日期自动创建存储文件夹
     * @return string
     */
    private function getFolder($savepath)
    {
    	$pathStr = $savepath;
    	//以天存档
    	$yearpath = Date('Y', SYSTIME) . "/";
    	$monthpath = $yearpath . Date('m', SYSTIME) . "/";
    	$dayspath = $monthpath . Date('d', SYSTIME) . "/";
    	if (!file_exists($pathStr))
    		mkdir($pathStr);
    	if (!file_exists($pathStr . $yearpath))
    		mkdir($pathStr . $yearpath);
    	if (!file_exists($pathStr . $monthpath))
    		mkdir($pathStr . $monthpath);
    	if (!file_exists($pathStr . $dayspath))
    		mkdir($pathStr . $dayspath);
    	return ltrim($dayspath, '.');
    }
}
