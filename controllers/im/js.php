<?php
class JsController extends CControl{
    /**
     * 返回直播需要的JS全局变量
     */
    public function index(){
        $input = EBH::app()->getInput();
        $cwid = intval($input->get('cwid'));

        $liveInfoModel = $this->model('Liveinfo');
        $liveInfo = $liveInfoModel->getLiveInfoByCwid($cwid);
        $liveconfig = Ebh::app()->getConfig()->load('live');
        if(!$liveInfo){
            $coursemodel = $this->model('Courseware');
            $course = $coursemodel->getcoursedetail($cwid);
            $liveInfo['cwid'] = $course['cwid'];
            $liveInfo['liveid'] = $course['liveid'];
            $liveInfo['httppullurl'] = '';
            $liveInfo['hlspullurl'] = $liveconfig['Sata']['hlsPurllUrl'];
            $liveInfo['rtmppullurl'] = $liveconfig['Sata']['rtmpPullUrl'];
            $liveInfo['pushurl'] = $liveconfig['Sata']['pushUrl'];
        }

        $cryptDesLib = Ebh::app()->lib('CryptDes');
        $cryptDesLib->set($liveconfig['deskey'],$liveconfig['desiv']);
        $httppullurl = urlencode($cryptDesLib->encrypt($liveInfo['httppullurl']));
        $hlspullurl = urlencode($cryptDesLib->encrypt($liveInfo['hlspullurl']));
        $rtmppullurl = urlencode($cryptDesLib->encrypt($liveInfo['rtmppullurl']));
        $pushurl = urlencode($cryptDesLib->encrypt($liveInfo['pushurl']));
        $content = "var liveinfo={ cwid:'{$liveInfo['cwid']}',liveid:'{$liveInfo['liveid']}',httppullurl:'{$httppullurl}',hlspullurl:'$hlspullurl{}',rtmppullurl:'{$rtmppullurl}',pushurl:'{$pushurl}'};";
        $expire = 604800;
        header ( 'Content-type: application/x-javascript' );
        header ( 'Cache-Control: max-age=' . $expire );
        header ( 'Accept-Ranges: bytes' );
        header ( 'Content-Length: ' . strlen ( $content ) );
        echo $content;


    }
}