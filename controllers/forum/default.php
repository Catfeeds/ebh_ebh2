<?php
class DefaultController extends CControl{
    public $apiServer;
    public function __construct(){
        parent::__construct();
        $this->apiServer = Ebh::app()->getApiServer('ebh');
    }
    public function index(){
        $roominfo = Ebh::app()->room->getcurroom();
        $this->assign('roominfo', $roominfo);
        $this->assign('room', $roominfo);
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);

        $fid = intval($this->input->get('fid'));
        $cate_id = intval($this->input->get('cate_id'));
        if($fid <= 0){
            exit;
        }

        if($user){
            $data['fid'] = $fid;
            $data['uid'] = $user['uid'];
            $joinInfo = $this->apiServer->reSetting()->setService('Forums.Forums.getJoinForumInfo')->addParams($data)->request();

        }else{
            $joinInfo = false;
        }

        $this->assign('joininfo',$joinInfo);
        $forum = $this->apiServer->reSetting()->setService('Forums.Forums.detail')->addParams('fid',$fid)->request();
        if($forum['is_del'] == 1 || $forum['is_close'] == 1){
            show_404();exit;
        } 
        $is_manager = false;
        foreach($forum['manager'] as $manager){
            if($user['uid'] == $manager['uid']){
                $is_manager = true;
            }
            $forum['manager_name'][] = $manager['realname'] ? $manager['realname'] :$manager['username'];
        }

        $categorys = $this->apiServer->reSetting()->setService('Forums.Forums.getCategory')->addParams('fid',$fid)->request();

        $param = parsequery();
        $data = array();
        $data['p'] = $param['page'];
        $data['fid'] = $fid;
        $data['is_del'] = 0;
        if($cate_id > 0){
            $data['cate_id'] = $cate_id;
        }

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
        $this->assign('is_manager',$is_manager);
        $this->assign('categorys',$categorys);
        $this->assign('list',$list);
        $this->assign('cate_id',$cate_id);
        $this->assign('pagestr',$pagestr);
        $this->assign('page_title',$forum['name']);
        $this->assign('forum',$forum);
        $this->display('forum/view');
    }


}