<?php

/**
 * 上传课件控制器类
 */
class UploadController extends CControl {

    public function index() {
        $this->_checkSize();
        $uploader = Ebh::app()->lib('Uploader');
        //上传配置
        $config = array(
            "savePath" => "uploads/", //存储文件夹
            "showPath" => "uploads/", //显示文件夹
            "maxSize" => 314572800, //允许的文件最大尺寸，单位字节 300M
            "allowFiles" => array(".ebh", ".ebhp", ".jpg", ".jpeg", ".png", ".gif", ".ppt", ".excel", ".xls", ".wps", ".pdf", ".zip", ".rar", ".7z", ".doc", ".docx", ".avi", ".mpg", ".flv",".mp3",".swf",".pptx",".xlsx",".rmvb",".mp4")  //允许的文件格式
        );
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $up_type = 'course';
        $upload_name = 'Filedata';
        $path_info = pathinfo($_FILES[$upload_name]['name']);
        $file_extension = $path_info["extension"];
        if ($file_extension != 'ebhp') {
            $up_type = 'attachment';
        }
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
            echo $server_path . ',' . $info['url'];
        }
        exit(0);
    }

    /**
     *检测尺寸
     */
    private function _checkSize(){
        $headers = getallheaders();
        $maxSize = 1024*1024*300;
        if(!empty($headers['Content-Length']) && $headers['Content-Length'] > $maxSize){
            echo '-1';exit;
        }
    }
}
