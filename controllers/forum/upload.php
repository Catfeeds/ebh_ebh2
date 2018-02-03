<?php
class UploadController extends CControl{
	
    public function index(){
        $_UP = Ebh::app()->getConfig()->load('upconfig');

        $upfield = 'Filedata';
        $file = $_FILES[ $upfield ];
        $data = array();
        $cfile = curl_file_create(realpath($file['tmp_name']),$file['type'],$file['name']);
        $data['uptype'] = 'pic';
        $data['Filedata'] = $cfile;
        $post_url = $_UP['forum']['server'][0];

        $res = do_post($post_url,$data);
        echo $res;
    }
}