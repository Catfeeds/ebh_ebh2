<?php
class IndexController extends CControl{
    public $apiServer;
    public function __construct(){
        parent::__construct();
        $this->apiServer = Ebh::app()->getApiServer('ebh');
        Ebh::app()->user->checkUserLogin(null,true);
    }

    /**
     * 我的社区列表
     */
    public function index(){
        session_start();
        error_reporting(E_ALL&~E_NOTICE);
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $param = parsequery();
        $data['crid'] = $roominfo['crid'];
        $data['uid'] = $user['uid'];
        $data['p'] = $param['page'];
        $data['keyword'] = $this->input->get('keyword');
        $result = $this->apiServer->reSetting()->setService('Forums.Forums.frontMyForumList')->addParams($data)->request();
        $list = $result['list'];
        $redis = Ebh::app()->getCache('redis_cache');
        $all_view_count = array();
        foreach($list as $key=>$value){
            $all_view_count[$key] = 0;
            foreach($value['sidList'] as $sid){
                $all_view_count[$key] += $redis->get('view_count'.$sid['sid']);
            }
            $list[$key]['all_view_count'] = $all_view_count[$key];
            if(is_null($list[$key]['all_view_count'])){
                $list[$key]['all_view_count'] = 0;
            }
        }
        if($list){            
            $total = $result['total'];
            $_SESSION['hide'] = true;
            $pagestr = show_page($total);
            $this->assign('list',$list);
            $this->assign('pagestr',$pagestr);
            $this->display('forum/index');
        }else{
            $_SESSION['hide'] = false;
            $this->lists();
        }
    }

    /**
     * 全部社区列表
     */
    public function lists(){
        if (!isset($_SESSION)) {
            session_start();
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $param = parsequery();
        $data['crid'] = $roominfo['crid'];
        $data['uid'] = $user['uid'];
        $data['p'] = $param['page'];
        $data['keyword'] = $this->input->get('keyword');
        $result = $this->apiServer->reSetting()->setService('Forums.Forums.frontAllForumList')->addParams($data)->request();
        if($result){
            $list = $result['list'];
            $redis = Ebh::app()->getCache('redis_cache');
            $all_view_count = array();
            foreach($list as $key=>$value){
                $all_view_count[$key] = 0;
                foreach($value['sidList'] as $sid){
                    $all_view_count[$key] += $redis->get('view_count'.$sid['sid']);
                }
                $list[$key]['all_view_count'] = $all_view_count[$key];
                if(is_null($list[$key]['all_view_count'])){
                    $list[$key]['all_view_count'] = 0;
                }
            }
            $total = $result['total'];
            $pagestr = show_page($total);
            $this->assign('hide',$_SESSION['hide']);
            $this->assign('list',$list);
            $this->assign('pagestr',$pagestr);
            $this->display('forum/lists');
        }
    }

    /**
     * 我发布的帖子
     */
    public function my(){
        session_start();
        $params = $this->input->get();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $data['uid'] = $user['uid'];
        $data['crid'] = $roominfo['crid'];
        $chose = 'new';
        if(!empty($params['is_hot'])){
            $data['is_hot'] = 1;
            $chose = 'hot';
        }
        if(!empty($params['is_del'])){
            $data['is_del'] = 1;
            $chose = 'del';
        }

        $param = parsequery();
        $data['p'] = $param['page'];
        $data['keyword'] = $this->input->get('keyword');
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
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user',$user);
        $this->assign('list',$list);
        $this->assign('pagestr',$pagestr);
        $this->assign('chose',$chose);
        $this->assign('hide',$_SESSION['hide']);
        $this->display('forum/my');
    }


    /**
     * 发布新帖子
     */
    public function publish(){
        $user = Ebh::app()->user->getloginuser();
        $roominfo = Ebh::app()->room->getcurroom();
        $this->assign('roominfo', $roominfo);
        $this->assign('room', $roominfo);
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);


        $fid = intval($this->input->get('fid'));
        if($fid <= 0){
            exit;
        }
        $forum = $this->apiServer->reSetting()->setService('Forums.Forums.detail')->addParams('fid',$fid)->request();
        foreach($forum['manager'] as $manager){
            $forum['manager_name'][] = $manager['realname'] ? $manager['realname'] :$manager['username'];
        }


        $is_manager = false;
        foreach($forum['manager'] as $manager){
            if($user['uid'] == $manager['uid']){
                $is_manager = true;
                break;
            }

        }
        $data['fid'] = $fid;
        $data['uid'] = $user['uid'];
        $joinInfo = $this->apiServer->reSetting()->setService('Forums.Forums.getJoinForumInfo')->addParams($data)->request();
        $this->assign('joininfo',$joinInfo);
        $editor = Ebh::app()->lib('UMEditor');
        $this->assign('is_manager',$is_manager);
        $this->assign('page_title','发帖');
        $this->assign('editor',$editor);
        $this->assign('forum',$forum);
        $this->display('forum/publish');
    }

    /**
     * 异步发帖操作
     */
    public function publishAjax(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $post = $this->input->post();
        preg_match_all('/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i',$post['content'],$match);
        if(empty($post['title'])){
            echo json_encode(array('status'=>0,'msg'=>'发布标题不能为空'));exit;
        }
        if(empty($post['cate_id'])){
            echo json_encode(array('status'=>0,'msg'=>'帖子分类不能为空'));exit;
        }
        if($match){
            $imgs = $match[1];
        }
        $imgArr = array();
        foreach($imgs as $img){
            if(strstr($img,'ebh')){
                $imgArr[] = $img;
            }
        }
        $data['fid'] = intval($post['fid']);
        $data['uid'] = $user['uid'];
        $joinInfo = $this->apiServer->reSetting()->setService('Forums.Forums.getJoinForumInfo')->addParams($data)->request();
        if(!$joinInfo){
            echo json_encode(array('status'=>0,'msg'=>'你未加入社区,暂时不可发言'));exit;
        }
        if($joinInfo['gag_end'] > time()){
            echo json_encode(array('status'=>0,'msg'=>'你处于禁言状态暂时不可发言'));exit;
        }
        $data['fid'] = intval($post['fid']);
        $data['uid'] = $user['uid'];
        $data['cate_id'] = intval($post['cate_id']);
        $data['crid'] = $roominfo['crid'];
        $data['title'] = $post['title'];
        $data['imgs'] = implode('|',$imgArr);
        $data['content'] = $post['content'];

        $result = $this->apiServer->reSetting()->setService('Forums.ForumsSubject.add')->addParams($data)->request();
        echo json_encode(array('status'=>$result['status'] ? 1 : 0,'id'=>$result['id']));
    }

    /**
     * 加入社区操作
     */
    public function joinForumAjax(){
        $user = Ebh::app()->user->getloginuser();

        $fid = intval($this->input->post('fid'));

        if($fid < 0){
            echo json_encode(array('status'=>0,'msg'=>'社区不存在'));exit;
        }



        $forum = $this->apiServer->reSetting()->setService('Forums.Forums.detail')->addParams('fid',$fid)->request();

        if(!$forum){
            echo json_encode(array('status'=>0,'msg'=>'社区不存在'));exit;
        }
        $data['fid'] = $fid;
        $data['uid'] = $user['uid'];
        $result = $this->apiServer->reSetting()->setService('Forums.Forums.getJoinForumInfo')->addParams($data)->request();

        if($result){
            echo json_encode(array('status'=>0,'msg'=>'你已加入过该社区'));exit;
        }

        $result = $this->apiServer->reSetting()->setService('Forums.Forums.joinForum')->addParams($data)->request();


        echo json_encode(array('status'=>$result['status'] ? 1 : 0,'msg'=>$result['status'] ? '' : '操作失败,请稍后在试或联系管理员'));
    }

    /**
     * 取消加入社区操作
     */
    public function cancelJoinForumAjax(){
        $user = Ebh::app()->user->getloginuser();

        $fid = intval($this->input->post('fid'));

        if($fid < 0){
            echo json_encode(array('status'=>0,'msg'=>'社区不存在'));exit;
        }

        $data['fid'] = $fid;
        $data['uid'] = $user['uid'];
        $result = $this->apiServer->reSetting()->setService('Forums.Forums.cancelJoinForum')->addParams($data)->request();

        echo json_encode(array('status'=>$result['status'] ? 1 : 0,'msg'=>$result['status'] ? '' : '操作失败,请稍后在试或联系管理员'));
    }




}