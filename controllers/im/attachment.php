<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 10:22
 */
class AttachmentController extends CControl{
    public function __construct() {
        parent::__construct();
        $key = $this->input->get('key');
        $user = Ebh::app()->user->getloginuser();
        if(empty($key) && !$user){
            exit;
        }
        $key = base64_decode($key);
        //如果用户未登录 设置用户cookie
        if(!empty($key)) {
            $keyArr = explode("\t",authcode($key, 'DECODE'));
            if(count($keyArr) > 1){
                @list($password, $uid) = $keyArr;
            }else{
                exit;
            }
            $auth = authcode("$password\t$uid", 'ENCODE');
            $this->input->setcookie('auth', $auth, 31536000);
            $this->input->setcookie('ak', $auth, 31536000);
            $user = Ebh::app()->user->getloginuser();

        }
        $this->user = $user;
        $this->assign('user',$user);
        $this->assign('key',$key);
    }


    public function view(){
        $cwid = $this->uri->itemid;
        //获取课件下的附件记录
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['filterstatus'] = -1;
        $queryarr['cwid'] = $cwid;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
        $this->assign('attachments', $attachments);
        $this->display('im/attachment');
    }

    public function push_view(){
        $cwid = $this->uri->itemid;
        //获取课件下的附件记录
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['filterstatus'] = -1;
        $queryarr['cwid'] = $cwid;
        $data = $attachmodel->getAttachmentListByCwid($queryarr);

        $roominfo = Ebh::app()->room->getcurroom();
        $serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
        if(!empty($data)){
            foreach ($data as &$attach){
                if($attach['ism3u8'] == 1) {	//rtmp特殊处理
                    if($roominfo['domain'] == 'dh') {
                        $m3u8source = $serverutil->getZKM3u8CourseSource();
                    } else {
                        $m3u8source = $serverutil->getM3u8CourseSource();
                    }
                    if(!empty($m3u8source)) {
                        $murl = $attach['previewurl'];
                        $key = $this->getKey($this->user,$murl,$attach['attid']);
                        $key = urlencode($key);
                        $m3u8url = "$m3u8source?k=$key&attid={$attach['attid']}&.m3u8";
                        $attach['m3u8url'] = $m3u8url;
                    }
                } else {
                    $attach['m3u8url'] = '';
                }
            }

        }
        $this->assign('attachments', $data);
        $this->display('im/push_attachment');
    }


    public function student_view(){
        $cwid = $this->uri->itemid;
        //获取课件下的附件记录
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['filterstatus'] = -1;
        $queryarr['cwid'] = $cwid;
        $data = $attachmodel->getAttachmentListByCwid($queryarr);

        $roominfo = Ebh::app()->room->getcurroom();
        $serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
        if(!empty($data)){
            foreach ($data as &$attach){
                if($attach['ism3u8'] == 1) {	//rtmp特殊处理
                    if($roominfo['domain'] == 'dh') {
                        $m3u8source = $serverutil->getZKM3u8CourseSource();
                    } else {
                        $m3u8source = $serverutil->getM3u8CourseSource();
                    }
                    if(!empty($m3u8source)) {
                        $murl = $attach['previewurl'];
                        $key = $this->getKey($this->user,$murl,$attach['attid']);
                        $key = urlencode($key);
                        $m3u8url = "$m3u8source?k=$key&attid={$attach['attid']}&.m3u8";
                        $attach['m3u8url'] = $m3u8url;
                    }
                } else {
                    $attach['m3u8url'] = '';
                }
            }

        }
        $this->assign('attachments', $data);
        $this->display('im/attachment_view');
    }

    public function ajax(){
        $data = array();

        $attids = $this->input->post('attids');
        if(!is_array($attids)){
            renderJson(0,'',$data);
        }
        $attachmodel = $this->model('Attachment');

        $data = $attachmodel->getAttachByAttids($attids);
        $roominfo = Ebh::app()->room->getcurroom();
        $serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
        if(!empty($data)){
            foreach ($data as &$attach){
                if($attach['ism3u8'] == 1) {	//rtmp特殊处理
                    if($roominfo['domain'] == 'dh') {
                        $m3u8source = $serverutil->getZKM3u8CourseSource();
                    } else {
                        $m3u8source = $serverutil->getM3u8CourseSource();
                    }
                    if(!empty($m3u8source)) {
                        $murl = $attach['previewurl'];
                        $key = $this->getKey($this->user,$murl,$attach['attid']);
                        $key = urlencode($key);
                        $m3u8url = "$m3u8source?k=$key&attid={$attach['attid']}&.m3u8";
                        $attach['m3u8url'] = $m3u8url;
                    }
                } else {
                    $attach['m3u8url'] = '';
                }
            }

        }
        renderJson(0,'',$data);
    }

    /**
     *生成包含用户信息的key，目前主要
     */
    private function getKey($user,$cwurl='',$id=0) {
        $uid = $user['uid'];
        $pwd = $user['password'];
        $ip = $this->input->getip();
        $time = SYSTIME;
        $skey = "$pwd\t$uid\t$ip\t$time\t$cwurl\t$id";
        $auth = authcode($skey, 'ENCODE');
        return $auth;
    }
}