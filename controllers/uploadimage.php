<?php
/**
 * 上传图片控制器
 */
class UploadimageController extends CControl{
    public function __construct() {
        parent::__construct();
        // Ebh::app()->room->checkteacher();
        
    }
    public function index() {
    	$uptype = $this->input->get('uptype');
        // $type = empty($_REQUEST['type']) ? '' : $_REQUEST['type'];
        $type = $this->input->get('type');
        $editorid= $this->input->get('editorid');
        if(empty($editorid)){
        	$editorid = 'message';
        }
        $upfield = 'upfile';
        if($uptype == 'pic' || $uptype == 'askimage' || $uptype == 'thteam' || $uptype == 'iroom')
            $upfield = 'Filedata';
        $file = $_FILES[ $upfield ];
        $data = array(
        	'uptype'=>$uptype,
        	'type'=>$type,
        	'editorid'=>$editorid
        );
        $cfile = curl_file_create(realpath($file['tmp_name']),$file['type'],$file['name']);
        if($upfield == 'upfile'){
        	$data['upfile'] = $cfile;
        }else{
        	$data['Filedata'] = $cfile;
        }
		$post_url = 'http://up.ebh.net/uploadimage.html?editorid='.$editorid;
		$res = do_post($post_url,$data);
		echo $res;
    }
	
	/*
	显示图片上传页面
	*/
	public function img(){
		if($this->input->post()){
			$file = $_FILES["UpFile"];
			$cfile = curl_file_create(realpath($file['tmp_name']),$file['type'],$file['name']);
			//纯文件无法识别为post请求,所以随便带一个tag,O(∩_∩)O哈哈~
			$data = array(
				'UpFile'=>$cfile,
				'tag'=>1
			);
			$post_url = 'http://up.ebh.net/uploadimage/img.html';
			$res = do_post($post_url,$data,false);
			if($res->status === 0){
				$fname = $res->fname;
				$sourceimg = $res->sourceimg;

				$this->assign('fname',$fname);
				$this->assign('sourceimg',$sourceimg);
			}else{
				header("Content-Type:text/html; charset=UTF-8");
				echo "<font color='red'>".$res->message."</a>";
				echo "<a href=''>点击返回</a>";
				exit;
			}
		}
		$initurl = $this->input->get('initurl');
		$this->assign('initurl',$initurl);
		$this->display('aroom/uploadimage');
	}

	public function update(){
		if(!$this->input->post()){
			echo '错误的访问';
			exit();
		}
		$postarr = $this->input->post();
		$data = array(
			'url'=>$postarr['url'],
			'cut_pos'=>$postarr['cut_pos'],
			'actionc'=>$postarr['actionc'],
			'op'=>$postarr['op']
		);
		$post_url = 'http://up.ebh.net/uploadimage/update.html';
		echo do_post($post_url,$data);
	}
}