<?php
/**
 * ebh2.
 * Author: jw
 * Email: 345468755@qq.com
 */
class SubjectController extends CControl{
    public $apiServer;
    public function __construct(){
        parent::__construct();
        $this->apiServer = Ebh::app()->getApiServer('ebh');
    }

    /**
     * 帖子详情页
     */
    public function index(){
        $roominfo = Ebh::app()->room->getcurroom();
        $this->assign('roominfo', $roominfo);
        $this->assign('room', $roominfo);
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);


        $sid = intval($this->input->get('sid'));
        if($sid <= 0){
            exit;
        }

        //设置帖子浏览量
        $this->subjectViewCount($sid);

        $subject = $this->apiServer->reSetting()->setService('Forums.ForumsSubject.getDetail')->addParams(array('sid'=>$sid))->request();
        if(!$subject || $subject['is_del'] == 1){
            show_404();exit;
        }
        $redis = Ebh::app()->getCache('cache_redis');
        $key = 'view_count'.$sid;
        $view_count = $redis->get($key);
        $subject['view_count'] += $view_count;

        $fid = $subject['fid'];
        if($user){
            $data['fid'] = $fid;
            $data['uid'] = $user['uid'];
            $joinInfo = $this->apiServer->reSetting()->setService('Forums.Forums.getJoinForumInfo')->addParams($data)->request();

        }else{
            $joinInfo = false;
        }
        $this->assign('joininfo',$joinInfo);

        $forum = $this->apiServer->reSetting()->setService('Forums.Forums.detail')->addParams('fid',$fid)->request();


        foreach($forum['manager'] as $manager){
            $forum['manager_name'][] = $manager['realname'] ? $manager['realname'] :$manager['username'];
        }

        

        $editor = Ebh::app()->lib('UMEditor');
        $this->assign('editor',$editor);
        $this->assign('page_title',$subject['title']);
        $this->assign('forum',$forum);
        $this->assign('subject',$subject);
        $this->display('forum/subject');
    }

    /**
     * 回复评论
     */
    public function replyAjax(){
        $sid = intval($this->input->post('sid'));
        $user = Ebh::app()->user->getloginuser();

        if(!$user){
            echo json_encode(array('status'=>0,'msg'=>'你未登陆,不能发表评论'));exit;
        }

        $subject = $this->apiServer->reSetting()->setService('Forums.ForumsSubject.getDetail')->addParams(array('sid'=>$sid))->request();
        if(!$subject){
            echo json_encode(array('status'=>0,'msg'=>'帖子不存在'));exit;
        }
        $data = array();
        $data['fid'] = $subject['fid'];
        $data['uid'] = $user['uid'];
        $joinInfo = $this->apiServer->reSetting()->setService('Forums.Forums.getJoinForumInfo')->addParams($data)->request();
        if(!$joinInfo){
            echo json_encode(array('status'=>0,'msg'=>'你未加入该社区,暂时不能评论'));exit;
        }

        $data = array();
        $data['sid'] = $sid;
        $data['prid'] = intval($this->input->post('prid'));
        $data['uid'] = $user['uid'];
        $data['touid'] = intval($this->input->post('touid'));
        $data['content'] = $this->input->post('content');
        if(empty($data['content'])){
            echo json_encode(array('status'=>0,'msg'=>'回复内容不能为空'));exit;
        }

        preg_match_all('/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i',$data['content'],$match);

        if($match){
            $imgs = $match[1];
        }
        $imgArr = array();
        foreach($imgs as $img){
            if(strstr($img,'ebh')){
                $imgArr[] = $img;
            }
        }
        $data['imgs'] = implode('|',$imgArr);
        $data['dateline'] = time();
        $result = $this->apiServer->reSetting()->setService('Forums.ForumsSubjectReply.reply')->addParams($data)->request();
        if($result['status']){
            echo json_encode(array('status'=>1,'id'=>$result['id'],'data'=>$data));
        }else{
            echo json_encode(array('status'=>0,'msg'=>'发表回复失败,请联系管理员或稍后在试'));exit;
        }

    }

    /**
     * 获取回复列表
     */
    public function replyListAjax(){
        $sid = intval($this->input->post('sid'));
        $page = intval($this->input->post('page'));
        if($page <= 0){
            $page = 1;
        }
        $result = $this->apiServer->reSetting()->setService('Forums.ForumsSubjectReply.list')->addParams(array('sid'=>$sid,'p'=>$page))->request();

        $ret['list'] = $result['list'];
        $ret['total'] = $result['total'];
        echo json_encode($ret);

    }

    /**
     * 获取指定评论的回复列表
     */
    public function replySonListAjax(){
        $rid = intval($this->input->post('rid'));
        $page = intval($this->input->post('page'));
        if($page <= 0){
            $page = 1;
        }
        if($rid <= 0){
            echo json_encode(array('status'=>0,'msg'=>'获取回复内容失败'));exit;
        }

        $result = $this->apiServer->reSetting()->setService('Forums.ForumsSubjectReply.sonList')->addParams(array('rid'=>$rid,'p'=>$page))->request();
        $ret['list'] = $result['list'];
        $ret['total'] = $result['total'];
        echo json_encode($ret);
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
        $this->checkPermission($sid);

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
        $this->checkPermission($sid);

        $is_top = intval($post['is_top']);
        if($is_top > 0){
            $is_top = 1;
        }else{
            $is_top = 0;
        }

        $data['sid'] = $sid;
        $data['is_top'] = $is_top;
        $result = $this->apiServer->reSetting()->setService('Forums.ForumsSubject.setSubjectTop')->addParams($data)->request();

        echo json_encode(array('status'=>$result['status'] ? 1 : 0,'msg'=>$result['status'] ? '' : '设置失败,最多置顶三个'));
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

        $this->checkPermission($sid);

        $data['sid'] = $sid;

        $result = $this->apiServer->reSetting()->setService('Forums.ForumsSubject.delSubject')->addParams($data)->request();
        echo json_encode(array('status'=>$result['status'] ? 1 : 0,'msg'=>$result['status'] ? '' : '删除失败,请稍后在试或联系管理员'));
    }

    /**
     * 帖子管理权限验证
     */
    private function checkPermission($sid){
        $user = Ebh::app()->user->getloginuser();
        $subject = $this->apiServer->reSetting()->setService('Forums.ForumsSubject.getDetail')->addParams(array('sid'=>$sid))->request();
        if(!$subject){
            echo json_encode(array('status'=>0,'msg'=>'帖子不存在！'));exit;
        }

        $forum = $this->apiServer->reSetting()->setService('Forums.Forums.detail')->addParams('fid',$subject['fid'])->request();

        $is_manager = false;
        foreach($forum['manager'] as $manager){
            if($user['uid'] == $manager['uid']){
                $is_manager = true;
                break;
            }
        }
        if(!$is_manager){
            echo json_encode(array('status'=>0,'msg'=>'权限不足！'));exit;
        }
    }
    /**
     * 删除帖子回复
     */
    public function delCommentAjax(){
        $roominfo = Ebh::app()->room->getcurroom();
        $rid = intval($this->input->post('rid'));
        if($rid <= 0){
            echo json_encode(array('status'=>0,'msg'=>'参数错误！'));exit;
        }
        $data['rid'] = $rid;
        $result = $this->apiServer->reSetting()->setService('Forums.ForumsSubjectReply.delSubjectReply')->addParams($data)->request();
        $status = $result ? array('status'=>1,'msg'=>'') : array('status'=>0,'msg'=>'删除失败,请稍后在试或联系管理员');
        echo json_encode($status);
    }

    /**
     * [设置帖子浏览次数]
     */
    protected function subjectViewCount($sid){
        $cip = getip();
        if(isset($cip)){
            $redis = Ebh::app()->getCache('cache_redis');
            $key = 'view_count'.$sid;
            $redis->incr($key);
            $view_count = $redis->get($key);//echo $view_count;
            //浏览量没增加100数据库更新一次 防止频繁更新数据库
            if(($view_count % 100) == 0){
                $data['sid'] = intval($sid);
                $data['view_count'] = intval($view_count);
                $result = $this->apiServer->reSetting()->setService('Forums.ForumsSubject.setViewCount')->addParams($data)->request();
            }
        } 
    }

    /**
     * 楼主删除自己的帖子
     */
    public function delSelfSubject(){
        $params['sid'] = intval($this->input->post('sid'));
        $result = $this->apiServer->reSetting()
            ->setService('Forums.Forums.delSelfSubject')
            ->addParams($params)
            ->request();
        $message = $result ? array('status'=>0,'msg'=>'删除成功') : array('status'=>1,'msg'=>'删除失败');
        echo json_encode($message);
    }
}