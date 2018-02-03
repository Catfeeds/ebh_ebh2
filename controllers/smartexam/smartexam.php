<?php
/**
 * 微题控制器
 */
class SmartexamController extends CControl {
    public function __construct(){
        parent::__construct();
        $roominfo = Ebh::app()->room->getcurroom();
        $check = TRUE;
        if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
            $check = Ebh::app()->room->checkstudent(TRUE);
        } else {
            Ebh::app()->room->checkstudent();
        }
        $this->assign('crid',$roominfo['crid']);
    }
    /**
     *试卷列表
     */
    public function qlist(){
    	$roominfo = Ebh::app()->room->getcurroom();
    	$user = Ebh::app()->user->getloginuser();
    	$param = array_merge(parsequery(),array(
    		'uid'=>$user['uid'],
    		'crid'=>$roominfo['crid']
    	));
    	$seModel = $this->model('smartexam');
        $elist = $seModel->getList($param);
        $this->_fetch_ans($elist);
        $this->_fetch_cannew($elist);
        $ecount = $seModel->getListCount($param);
    	$pagestr = show_page($ecount,$param['pagesize']);
        $this->assign('crid',$roominfo['crid']);
    	$this->assign('elist',$elist);
    	$this->assign('pagestr',$pagestr);
    	$this->display('smartexam/smartexam_all2');
    }

    /**
     *智能作业注入答题记录
     */
    private function _fetch_ans(&$elist = array()){
        $eidarr = array();
        foreach ($elist as &$e) {
            $eidarr[] = $e['eid'];
            $e['alist'] = array();
        }
        if(empty($eidarr)){
            return;
        }
        $user = Ebh::app()->user->getloginuser();
        $param = array(
            'uid'=>$user['uid'],
            'eid_in'=>$eidarr
        );
        $alist = $this->model('smartexam')->getExamsAnswerList($param);
        if(empty($alist)){
            return;
        }
        $aDB = array();
        foreach ($alist as $a) {
            $a['totalscore'] = intval($a['totalscore']);
            $a['score'] = intval($a['score']);
            $key = 'eid_'.$a['eid'];
            if(!array_key_exists($key,$aDB)){
                $aDB[$key] = array();
            }
            $aDB[$key][] = $a;
        }

        foreach ($elist as &$e) {
            $key = 'eid_'.$e['eid'];
            if(array_key_exists($key,$aDB)){
                $e['alist'] = $aDB[$key];
            }
        }
    }

    /**
     *同一份试卷能否新开作业
     *_fetch_ans之后调用
     */
    private function _fetch_cannew(&$elist = array()){
        if(empty($elist) || !is_array($elist)){
            return;
        }
        foreach ($elist as &$e) {
            $e['cannew'] = 1;
            if($e['status'] == 3){
                $e['cannew'] = 0;
                continue;
            }
            foreach ($e['alist'] as &$a) {
                if($a['status'] == 0){
                    $e['cannew'] = 0;
                    break;
                }
            }
        }
    }

    /**
     *删除试卷
     */
    public function delexam(){
        $ret = array(
            'status'=>0,
            'msg'=>''
        );
        $eid = $this->input->post('eid');
        if(!is_numeric($eid) || $eid < 0){
            $ret['status'] = -1;
            $res['msg'] = '作业编号非法';
            echo json_encode($ret);
            exit();
        }

        $user = Ebh::app()->user->getloginuser();
        if(empty($user)){
            $ret['status'] = -2;
            $res['msg'] = '用户登录信息失效,请重新登录再试';
            echo json_encode($ret);
            exit();
        }

        $examinfo = $this->model('smartexam')->getSmartExamDetail($eid,$user['uid']);
        if(empty($examinfo)){
            $ret['status'] = -3;
            $res['msg'] = '作业与用户不匹配,或者作业已经删除';
            echo json_encode($ret);
            exit();
        }

        $res = $this->model('smartexam')->delexam($eid,$user['uid']);
        if($res === false){
            $ret['status'] = -4;
            $res['msg'] = '删除失败，请稍后再试';
        }
        echo json_encode($ret);
    }

    //错题分析
    public function fenxi(){
        $aid = $this->input->post('aid');
        $res = array(
            'status'=>0,
            'msg'=>'获取成功',
            'htmlstr'=>"",
        );
        if(!is_numeric($aid) || $aid < 0){
            $res['status'] = '-2';
            $res['msg'] = '参数不正确';
            echo json_encode($res);
            exit();
        }
       
        $datapackage = $this->model('smartexam')->answerFenxi($aid);
        $res["htmlstr"] = $this->_display('smartexam/fenxi_fragment',array(
            'datapackage'=>$datapackage,
        ));
        echo json_encode($res);
    }
    /**
     * 碎片模板 O(∩_∩)O哈哈~
     * @param string $view 模板名称
     */
    private function _display($view,$context) {
        $viewpath = VIEW_PATH.$view.'.php';
        if(!file_exists($viewpath)) {
            echo 'error view not exists:'.$viewpath;
            return;
        }
        ob_start();
        extract($context);
        include $viewpath;
        $outputstr = ob_get_contents();
        @ob_end_clean();
        return $outputstr;
    }
}