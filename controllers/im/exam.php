<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 9:42
 */
class ExamController extends ApiControl{
    private $k = '';
    private $user = false;
    public function __construct() {
        parent::__construct();
        $input = EBH::app()->getInput();
        $key = $input->get('key');
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
        $roominfo = Ebh::app()->room->getcurroom();
        $this->k = authcode(json_encode(array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'t'=>SYSTIME)),'ENCODE');
        $this->user = $user;
		$this->assign('user',$user);
        $this->assign('crid',$roominfo['crid']);
        $this->assign('key',$key);

    }

    /**
     * 老师推送页面
     */
    public function view(){
        if($this->user['groupid'] != 5){
            exit;
        }
		$cwid = $this->uri->itemid;
		$coursemodel = $this->model('Courseware');
		$course = $coursemodel->getcoursedetail($cwid);
		$this->assign('course',$course);
		$this->assign('cwid',$cwid);
        $this->display('im/exam');
    }
    public function count(){
        $eid = intval($this->input->get('eid'));
        $url = "/exam/summary/".$eid;
        $postRet = $this->do_post($url,array(
            'k' =>  $this->k
        ));
        $postRet = json_decode($postRet,true);
        if($postRet['errCode'] == 0){
            $count = $postRet['datas']['answerNums']['anscount'];
        }else{
            $count = 0;
        }

        $this->renderJson(0,'',array('count'=>$count));



    }

    /**
     * 学生页面
     */
    public function student(){
        if($this->user['groupid'] != 6){
            exit;
        }
        $this->display('im/exam_student');
    }

    /**
     * 学生获取作业数据单独处理 因为需要根据eid单独获取
     */
    public function examAjax(){
        $url = "/exam/exambyeids";
        $eids = $this->input->post('eids');
        if(!is_array($eids)){
            $this->renderJson(0,'',array('examList'=>array()));
        }
        $postRet = $this->do_post($url,array(
            'k' =>  $this->k,
            'size'  =>  count($eids),
            'eids'  =>  $eids
        ));
        $postRet = json_decode($postRet);

        $uidarr = array();
        $estypeIds = '';//作业类型id
        if ($postRet->errCode != 0) {
            $this->renderJson(0,'',array('examList'=>array()));
        }

        $examList = $postRet->datas->examList;
        if (empty($examList)) {
            $this->renderJson(0,'',array('examList'=>array()));
        }
        foreach ($examList as $examinfo) {
            if ($examinfo->exam->estype)
                $estypeIds .= intval($examinfo->exam->estype).',';
            $examinfo->exam->datelineStr = timetostr($examinfo->exam->dateline);
            $uidarr[]= $examinfo->exam->uid;
        }
        //获得个作业对应的分类名称
        if (!empty($estypeIds)) {
            $estypeList = $this->model('schestype')->getEstypeByIds(substr($estypeIds, 0, -1));//类型名字
            if ($estypeList) {
                foreach ($estypeList as $value) {
                    $estypeNames[$value['id']] = $value;
                }
            }
        }

        //插入老师数据
        if (!empty($estypeNames)) {
            if(!empty($uidarr)){
                $userarr = $this->model('user')->getUserArray($uidarr);
                foreach ($examList as $examinfo) {
                    if (isset($estypeNames[$examinfo->exam->estype])) {
                        $examinfo->exam->estype = $estypeNames[$examinfo->exam->estype]['estype'];//作业类型名字赋值
                    }
                    $examinfo->exam->realname = shortstr($userarr[$examinfo->exam->uid]['realname'],8);
                    $examinfo->exam->realnametitle = $userarr[$examinfo->exam->uid]['realname'];
                }
            }
        } else {
            if(!empty($uidarr)){
                $userarr = $this->model('user')->getUserArray($uidarr);
                foreach ($examList as $examinfo) {
                    $examinfo->exam->realname = shortstr($userarr[$examinfo->exam->uid]['realname'],8);
                    $examinfo->exam->realnametitle = $userarr[$examinfo->exam->uid]['realname'];
                }
            }
        }

        $datas = array(
            'examList'=>$examList
        );
        $this->renderJson('0','',$datas);
    }


    /*
	 **按规定向前台传数据
	 */
    private function renderJson($errCode = 0,$errMsg = "",$datas = array() ,$ifexit = true) {
        echo json_encode(array('errCode'=>$errCode,'errMsg'=>$errMsg,'datas'=>$datas));
        if($ifexit) {
            exit;
        }
    }

    /*
	 **私有方法，提交数据到java后台返回json数据
	 */
    private function do_post($uri, $data, $check = true){
        $url = 'http://'.__SURL__.$uri;
        $ch = curl_init();
        $datastr = (json_encode($data));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$datastr);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($datastr))
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }
}