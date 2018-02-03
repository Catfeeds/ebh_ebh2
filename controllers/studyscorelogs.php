<?php
/**
 *学生获取学分控制器
 */
class StudyScoreLogsController extends CControl{
    /**
     *获取系统学分设置
     * @param uid,crid
     * @return json 返回json格式网校其他学分设置
     */
    public function getOtherSetting(){
        $user = Ebh::app()->user->getloginuser();
        $roominfo = Ebh::app()->room->getcurroom();
        $param = array();
        $param['uid'] = !empty($user['uid']) ? intval($user['uid']) : 0;
        $param['crid'] = !empty($roominfo['crid']) ? intval($roominfo['crid']) : 0;
        //如果参数不合法则退出处理
        if(empty($param['uid']) || empty($param['crid'])){
            echo json_encode(array('code'=>1,'msg'=>'查询系统其他学分设置失败'));
            exit;
        }
        $apiServer = Ebh::app()->getApiServer('ebh');
        $ret = $apiServer->reSetting()->setService('Aroomv3.Room.othersetting')->addParams('crid', $param['crid'])->request();
        if(!empty($ret['creditrule'])){
            $creditrule = json_decode($ret['creditrule'],true);
            echo json_encode(array('code'=>0,'msg'=>'查询系统其他学分设置成功','data'=>$creditrule));
        }else{
            echo json_encode(array('code'=>1,'msg'=>'未查询到系统其他学分设置','data'=>array()));
        }
    }
    /**
    *获取指定用户学分明细列表
    */
    public function getScoreList(){
        $user = Ebh::app()->user->getloginuser();
        $roominfo = Ebh::app()->room->getcurroom();
        $this->assign('roominfo',$roominfo);
        $this->assign('user',$user);
        $param = parsequery();
        $param['pagesize'] = 30;
        $param['uid'] = !empty($user['uid']) ? intval($user['uid']) : 0;
        $param['crid'] = !empty($roominfo['crid']) ? intval($roominfo['crid']) : 0;
        $apiServer = Ebh::app()->getApiServer('ebh');
        $onescorelist = $apiServer->reSetting()->setService('Classroom.Score.getUserScoreList')->addParams($param)->request();
        $scorelist = !empty($onescorelist['scorelist']) ? $onescorelist['scorelist'] : array();
        $scorecount = !empty($onescorelist['scorecount']) ? $onescorelist['scorecount'] : 0;
        $pagestr = show_page($scorecount,$param['pagesize']);
        $this->assign('pagestr',$pagestr);
        $this->assign('scorelist',$scorelist);
        $this->display('college/getscore_list');
    }
	/**
	 *添加学分
     * @param type 0,1,2,3,4 (0视频课件,1作业,2发表文章,3评论,4非视频课件)
     * @return json 添加成功返回学分添加记录id
	 */
    public function addScore(){
        $rec = $this->input->post();
        if(empty($rec)){
            $rec = $this->input->get();
        }
        if(empty($rec)){
            echo json_encode(array('code'=>1,'msg'=>'学分添加失败'));
            exit;
        }
        $user = Ebh::app()->user->getloginuser();
        $roominfo = Ebh::app()->room->getcurroom();
        $param = array();
        $param['uid'] = !empty($user['uid']) ? intval($user['uid']) : 0;
        $param['crid'] = !empty($roominfo['crid']) ? intval($roominfo['crid']) : 0;
        //如果参数不合法则退出处理
        if(empty($param['uid']) || empty($param['crid'])){
            echo json_encode(array('code'=>1,'msg'=>'学分添加失败'));
            exit;
        }
        //处理传过来的post或者get参数
        $param['cwid'] = !empty($rec['cwid']) ? intval($rec['cwid']) : 0;
        $param['folderrid'] = !empty($rec['folderrid']) ? intval($rec['folderrid']) : 0;
        $param['articleid'] = !empty($rec['articleid']) ? intval($rec['articleid']) : 0;
        $param['eid'] = !empty($rec['eid']) ? intval($rec['eid']) : 0;
        $param['reviewid'] = !empty($rec['reviewid']) ? intval($rec['reviewid']) : 0;
        $param['type'] = !empty($rec['type']) ? intval($rec['type']) : 0;
        $param['readtime'] = !empty($rec['readtime']) ? intval($rec['readtime']) : 0;
        $param['wordslength'] = !empty($rec['wordslength']) ? intval($rec['wordslength']) : 0;//评论课件的总字数
        $param['dateline'] = time();
        $param['fromip'] = $this->input->getip();

        //如果参数不合法则退出处理
        if(!empty($param['cwid']) || !empty($param['reviewid']) || !empty($param['articleid']) || !empty($param['type'] )){
            $apiServer = Ebh::app()->getApiServer('ebh');
            $res = $apiServer->reSetting()->setService('Classroom.Score.addOneScore')->addParams($param)->request();
            if(isset($res['status'])){
                if($res['status']==1){
                    echo json_encode(array('code'=>0,'msg'=>$res['msg'],'data'=>$res['data']));
                }else{
                    echo json_encode(array('code'=>1,'msg'=>$res['msg']));
                }
            }else{
                echo json_encode(array('code'=>1,'msg'=>'学分添加失败'));
            }
        }else{
            echo json_encode(array('code'=>1,'msg'=>'学分添加失败'));
        }
	}
}