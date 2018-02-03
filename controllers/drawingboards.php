<?php
/**
 * 画板
 */

class DrawingboardsController extends CControl
{
    public function index()
    {
        $url = (string) $_GET['url'];
        $title = $this->input->get('title');
        $icqid = $this->input->get('icqid');
        $this->assign('baseUrl', $url);
        $this->assign('title', $title);
        $this->assign('icqid', $icqid);
        $this->display('drawingboards/index');
    }


    /*
     *学生端手机上传主观题，启用画板调用地址
     */
    public function mobUpSubjectAns() 
    {   
        $uid = intval($this->input->get('uid'));
        $aid = intval($this->input->get('aid'));
        $isSee = intval($this->input->get('isSee'));
        $cwid = intval($this->input->get('cwid'));
        $qid = intval($this->input->get('qid'));
        $dialog = $_GET['dialog'];
        $user = Ebh::app()->user->getloginuser();
        if (empty($uid) OR $uid != $user['uid']) {
            exit();
        }
        $url = $_GET['imgsrc'];
        $this->assign('baseUrl', $url);
        $this->assign('qid', $qid);
        $this->assign('dialog', $dialog);
        $this->assign('isSee', $isSee);
        $this->assign('uid', $uid);
        $this->assign('cwid', $cwid);
        $this->assign('aid', $aid);
        $this->display('drawingboards/mobileupsubject');
    }

    /*
     *学生端手机拍照上传图片(可选相册)
     */
    public function upAnsByPhoto() 
    {  
        $cwid = intval($this->input->get('cwid'));
        $qid = intval($this->input->get('qid'));
        $uid = intval($this->input->get('uid'));
        $user = Ebh::app()->user->getloginuser();
        if (empty($uid) OR $uid != $user['uid']) {
            exit();
        }
        $this->assign('uid', $uid);
        $this->assign('qid', $qid);
        $this->assign('cwid', $cwid);
        $this->display('drawingboards/upsubjectbyphoto');
    }
	
	//获取图片地址。解决canvas同源策略
	public function getimg(){
        
        $url  = $this->input->get('url');
        $urlArr = explode('.', $url);
        $ext = $urlArr[count($urlArr)-1];
        header('content-type:image/'.$ext.';');
        $content = file_get_contents($url);
        echo $content;

    }

    //base64画板图片上传至服务器
    public function upload(){
        $file = $this->input->post('data');
       
        $data['data'] = $file;
        $post_url = 'http://up.ebh.net/uploaddraws.html';
        $res = do_post($post_url,$data);
        echo $res;
    }
}