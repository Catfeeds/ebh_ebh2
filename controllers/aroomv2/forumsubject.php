<?php
class ForumsubjectController extends CControl{
    public $apiServer;
    public function __construct(){
        parent::__construct();
        $this->apiServer = Ebh::app()->getApiServer('ebh');
        Ebh::app()->room->checkRoomControl();

    }

    public function index(){
        $roominfo = Ebh::app()->room->getcurroom();
        $param = parsequery();
        
        $data['p'] = $param['page'];
        $data['crid'] = $roominfo['crid'];
        $data['is_del'] = 0;
        $cate_id = intval($this->input->get('cate_id'));
        $forum_id = intval($this->input->get('forum_id'));
        if($forum_id > 0){
            $data['fid'] = $forum_id;
        }
        if($cate_id > 0){
            $data['cate_id'] = $cate_id;
        }
        $data['keyword'] = $this->input->get('keyword');
        $data['module'] = 'back';
        $result = $this->apiServer->reSetting()->setService('Forums.ForumsSubject.getSubject')->addParams($data)->request();

        $list = $result['list'];
        $redis = Ebh::app()->getCache('redis_cache');
        foreach($list as $key=>$value){
            $list[$key]['view_count'] = $redis->get('view_count'.$value['sid']);
            if(empty($list[$key]['view_count'])){
                $list[$key]['view_count'] = 0;
            }
        }
        $total = $result['total'];
        $pagestr = show_page($total);
        $pageNum = intval($data['p']);
        $this->assign('pageNum',$pageNum);
        $this->assign('list',$list);
        $this->assign('pagestr',$pagestr);
        $this->display('aroomv2/forum_subject');
    }

    /**
     * 设置热帖状态
     */
    public function setHotSubjectAjax(){
        $post = $this->input->post();
        $sid = intval($post['sid']);
        if($sid <= 0){
            echo json_encode(array('status'=>0,'msg'=>'参数错误！'));exit;
        }
        $is_hot = intval($post['is_hot']);
        if($is_hot > 0){
            $is_hot = 1;
        }else{
            $is_hot = 0;
        }

        $data['sid'] = $sid;
        $data['is_hot'] = $is_hot;
        $result = $this->apiServer->reSetting()->setService('Forums.ForumsSubject.setSubjectHot')->addParams($data)->request();

        echo json_encode(array('status'=>$result['status'] ? 1 : 0,'msg'=>$result['status'] ? '' : '设置失败,请稍后在试或联系管理员'));
    }

    /**
     * 设置帖子置顶状态
     */
    public function setTopSubjectAjax(){
        $post = $this->input->post();
        $sid = intval($post['sid']);
        if($sid <= 0){
            echo json_encode(array('status'=>0,'msg'=>'参数错误！'));exit;
        }
        $is_top = intval($post['is_top']);
        if($is_top > 0){
            $is_top = 1;
        }else{
            $is_top = 0;
        }

        $data['sid'] = $sid;
        $data['is_top'] = $is_top;
        $result = $this->apiServer->reSetting()->setService('Forums.ForumsSubject.setSubjectTop')->addParams($data)->request();

        echo json_encode(array('status'=>$result['status'] ? 1 : 0,'msg'=>$result['status'] ? '' : '设置失败,请稍后在试或联系管理员'));
    }

    /**
     * 删除帖子
     */
    public function delSubjectAjax(){
        $roominfo = Ebh::app()->room->getcurroom();
        $post = $this->input->post();
        $sid = intval($post['sid']);
        if($sid <= 0){
            echo json_encode(array('status'=>0,'msg'=>'参数错误！'));exit;
        }
        $subject = $this->apiServer->reSetting()->setService('Forums.ForumsSubject.getDetail')->addParams(array('sid'=>$sid))->request();
        if(!$subject || $subject['crid'] != $roominfo['crid']){
            echo json_encode(array('status'=>0,'msg'=>'该帖子不属于你的网校,不能删除！'));exit;
        }

        $data['sid'] = $sid;

        $result = $this->apiServer->reSetting()->setService('Forums.ForumsSubject.delSubject')->addParams($data)->request();
        echo json_encode(array('status'=>$result['status'] ? 1 : 0,'msg'=>$result['status'] ? '' : '删除失败,请稍后在试或联系管理员'));
    }






}