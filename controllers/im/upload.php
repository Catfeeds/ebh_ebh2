<?php
class UploadController extends CControl{
	
    public function index(){
        $uptype = $this->input->get('uptype');
        $type = $this->input->get('type');


        $upfield = 'Filedata';
        $file = $_FILES[ $upfield ];
        $data = array(
            'uptype'=>$uptype,
            'type'=>$type
        );
        $cfile = curl_file_create(realpath($file['tmp_name']),$file['type'],$file['name']);
        $data['Filedata'] = $cfile;
        $post_url = 'http://up.ebh.net/uploadimage.html';
        $res = do_post($post_url,$data);
        echo $res;
    }
}