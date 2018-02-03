<?php
/**
 * 社区控制器
 * Class ForumController
 */
class ForumController extends CControl{
    public $apiServer;
    public function __construct(){
        parent::__construct();
        $this->apiServer = Ebh::app()->getApiServer('ebh');
        Ebh::app()->room->checkRoomControl();

    }

    public function categoryAjax(){
        $fid = intval($this->input->post('fid'));
        if($fid <= 0){
            echo json_encode(array('status'=>0,'msg'=>'参数错误！'));exit;
        }
        $data = $this->apiServer->reSetting()->setService('Forums.Forums.getCategory')->addParams('fid',$fid)->request();
        $ret['status'] = 1;
        $ret['data']['list'] = $data;
        echo json_encode($ret);
    }

    /**
     * 异步读取社区列表
     */
    public function listsAjax(){
        $roominfo = Ebh::app()->room->getcurroom();
        $page = intval($this->input->post('page'));
        if($page <= 0){
            $page = 1;
        }
        $data = $this->apiServer->reSetting()->setService('Forums.Forums.list')->addParams('crid',$roominfo['crid'])->addParams('p',$page)->request();
        $ret['status'] = 1;
        $ret['data']['list'] = $data['list'];
        $ret['data']['total'] = $data['total'];

        echo json_encode($ret);
    }

    public function index(){

        $roominfo = Ebh::app()->room->getcurroom();
        $param = parsequery();
        $data = $this->apiServer->reSetting()->setService('Forums.Forums.list')->addParams('crid',$roominfo['crid'])->addParams('p',$param['page'])->request();
        $list = $data['list'];
        $total = $data['total'];
        $data  = $this->apiServer->reSetting()->setService('Member.Teacher.getRoomTeacher')->addParams('crid',$roominfo['crid'])->request();
        $this->assign('teachers',$data['list']);
        $pagestr = show_page($total);
        $this->assign('list',$list);
        $pageNum = intval($param['page']);
        $this->assign('pageNum',$pageNum);
        $this->assign('pagestr',$pagestr);
        $this->display('aroomv2/forum');
    }

    /**
     * 读取社区信息
     */
    public function infoAjax(){
        $id = intval($this->input->get('id'));
        $result = $this->apiServer->reSetting()->setService('Forums.Forums.detail')->addParams('fid',$id)->request();

        if(!$result){
            echo json_encode(array('status'=>0,'msg'=>'信息不存在'));
        }else{
            echo json_encode(array('status'=>1,'data'=>$result));
        }
    }

    /**
     * 新增社区
     */
    public function addAjax(){
        $post = $this->input->post();

        if(empty($post['name'])){
            echo json_encode(array('status'=>0,'msg'=>'社区名称必须填写'));exit;
        }

        $data['name'] = $post['name'];
        $data['image'] = empty($post['image']) ? '' : $post['image'];
        $data['notice'] = empty($post['notice']) ? '' : $post['notice'];
        $data['manager'] = empty($post['manager']) ? '' : implode(',',$post['manager']);

        if(!empty($post['category'])){
            foreach($post['category'] as $category){
                if($category != ''){
                    $data['category'][] = $category;
                }
            }
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $data['crid'] = $roominfo['crid'];


        $result = $this->apiServer->reSetting()->setService('Forums.Forums.add')->addParams($data)->request();

        echo json_encode(array('status'=>$result['status'] ? 1 : 0,'msg'=>$result['status'] ? '' : '新增失败,请稍后在试或联系管理员'));

    }

    /**
     * 编辑社区
     */
    public function editAjax(){
        $post = $this->input->post();
        $fid = intval($post['fid']);
        if($fid <= 0){
            echo json_encode(array('status'=>0,'msg'=>'参数错误！'));exit;
        }
        if(empty($post['name'])){
            echo json_encode(array('status'=>0,'msg'=>'社区名称必须填写'));exit;
        }
        $data['fid'] = $fid;
        $data['name'] = $post['name'];
        $data['image'] = empty($post['image']) ? '' : $post['image'];
        $data['notice'] = empty($post['notice']) ? '' : $post['notice'];
        $data['manager'] = empty($post['manager']) ? '' : implode(',',$post['manager']);


        if(!empty($post['category'])){
            foreach($post['category'] as $category){
                if($category != ''){
                    $data['category'][] = $category;
                }
            }
        }

        if(!empty($post['categorys'])){
            foreach($post['categorys'] as $key=>$category){
                if($category != ''){
                    $data['categorys'][$key] = $category;
                }
            }
        }
        $result = $this->apiServer->reSetting()->setService('Forums.Forums.edit')->addParams($data)->request();
        //var_dump($result);die;
        echo json_encode(array('status'=>$result['status'] ? 1 : 0,'msg'=>$result['status'] ? '' : '编辑失败,请稍后在试或联系管理员'));
    }

    /**
     * 设置社区排序
     */
    public function sortAjax(){
        $post = $this->input->post();
        $fid = intval($post['fid']);
        if($fid <= 0){
            echo json_encode(array('status'=>0,'msg'=>'参数错误！'));exit;
        }
        $sort = intval($post['sort']);
        $data['fid'] = $fid;
        $data['sort'] = $sort;
        $result = $this->apiServer->reSetting()->setService('Forums.Forums.sort')->addParams($data)->request();
        echo json_encode(array('status'=>$result['status'] ? 1 : 0,'msg'=>$result['status'] ? '' : '设置失败,请稍后在试或联系管理员'));
    }

    /**
     * 社区聊天室状态
     */
    public function setChatroomAjax(){
        $post = $this->input->post();
        $fid = intval($post['fid']);
        if($fid <= 0){
            echo json_encode(array('status'=>0,'msg'=>'参数错误！'));exit;
        }
        $is_open = intval($post['is_open']);
        $data['fid'] = $fid;
        $data['is_open'] = $is_open;
        $result = $this->apiServer->reSetting()->setService('Forums.Forums.setChatroom')->addParams($data)->request();
        echo json_encode(array('status'=>$result['status'] ? 1 : 0,'msg'=>$result['status'] ? '' : '设置失败,请稍后在试或联系管理员'));
    }

    /**
     * 设置社区关闭状态
     */
    public function setCloseAjax(){
        $post = $this->input->post();
        $fid = intval($post['fid']);
        if($fid <= 0){
            echo json_encode(array('status'=>0,'msg'=>'参数错误！'));exit;
        }
        $is_close = intval($post['is_close']);
        if($is_close > 0){
            $is_close = 1;
        }else{
            $is_close = 0;
        }

        $data['fid'] = $fid;
        $data['is_close'] = $is_close;
        $result = $this->apiServer->reSetting()->setService('Forums.Forums.setCloseForum')->addParams($data)->request();

        echo json_encode(array('status'=>$result['status'] ? 1 : 0,'msg'=>$result['status'] ? '' : '设置失败,请稍后在试或联系管理员'));
    }

    public function delForumAjax(){
        $post = $this->input->post();
        $fid = intval($post['fid']);
        if($fid <= 0){
            echo json_encode(array('status'=>0,'msg'=>'参数错误！'));exit;
        }
        $data['fid'] = $fid;
        $result = $this->apiServer->reSetting()->setService('Forums.Forums.delForum')->addParams($data)->request();
        echo json_encode(array('status'=>$result['status'] ? 1 : 0,'msg'=>$result['status'] ? '' : '删除失败,请稍后在试或联系管理员'));
    }

    /**
     * 编辑帖子分类向上移动
     */
    public function categorySortAjax(){
        $post = $this->input->post();
        $cate_id = intval($post['cate_id']);
        $other_cate_id = intval($post['other_cate_id']);
        if($cate_id <= 0 || $other_cate_id <= 0){
            echo json_encode(array('error_code'=>1,'msg'=>'参数错误！'));exit;
        }
        $data['cate_id'] = $cate_id;
        $data['other_cate_id'] = $other_cate_id;
        $result = $this->apiServer->reSetting()->setService('Forums.Forums.categorySort')->addParams($data)->request();
        echo json_encode($result ? array('error_code'=>0,'msg'=>'') : array('error_code'=>1,'msg'=>'分类排序失败，请稍后重试'));
    }
    
    /**
     * [删除帖子分类]
     */
    public function delCategoryAjax(){
        $cate_id = intval($this->input->post('cate_id'));
        if($cate_id <= 0){
            echo json_encode(array('error'=>1,'msg'=>'参数错误！'));exit;
        }
        $data['cate_id'] = $cate_id;
        $result = $this->apiServer->reSetting()->setService('Forums.Forums.delCategory')->addParams($data)->request();
        
        echo json_encode($result ? array('error'=>0,'msg'=>'') : array('error'=>1,'msg'=>'该分类下有帖子，不能删除'));
        
    }



}