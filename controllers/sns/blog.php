<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 15:02
 */
class BlogController extends SnsBaseController{
    //我的日志页面
    public function index(){
        $parsequery = parsequery();
        $parameters['uid'] = $this->user['uid'];
        $parameters['userid'] = $this->user['uid'];
        $parameters['page'] = max(1, $parsequery['page']);
        $parameters['pagesize'] = 10;
        $result =  $this->apiServer->reSetting()->setService('Sns.Blog.list')->addParams($parameters)->request();

        $pagebar = show_page($result['count'],10);
        $category =  $this->apiServer->reSetting()->setService('Sns.Blog.category')->addParams($parameters)->request();
        $this->assign('category',$category);
        $this->assign('count',$result['count']);
        $this->assign("pagebar", $pagebar);
        $this->assign("list", $result['list']);
        $this->display('sns/blog_my');
    }


    /**
     * 他人日志页面
     */
    public function view(){
        if($this->curUser == $this->user['uid']){
            header("Location:/sns/blog.html");
        }
        $parsequery = parsequery();
        $parameters['uid'] = $this->curUser;
        $parameters['userid'] = $this->user['uid'];
        $parameters['page'] = max(1, $parsequery['page']);
        $parameters['pagesize'] = 10;
        $result =  $this->apiServer->reSetting()->setService('Sns.Blog.list')->addParams($parameters)->request();
        $pagebar = show_page($result['count'],10);

        $category =  $this->apiServer->reSetting()->setService('Sns.Blog.category')->addParams($parameters)->request();
        $this->assign('category',$category);
        $this->assign('count',$result['count']);
        $this->assign("pagebar", $pagebar);
        $this->assign("list", $result['list']);
        $this->display('sns/blog_view');
    }

    /**
     * 查看日志
     */
    public function detail(){
        $user = $this->user;
        $bid = intval($this->input->get('bid'));

        $parameters['uid'] = $user['uid'];
        $parameters['bid'] = $bid;

        $result =  $this->apiServer->reSetting()->setService('Sns.Blog.detail')->addParams($parameters)->request();

        if($result['status'] == 0){
            $this->assign('uid', $user['uid']);
            $this->assign('message', '日志不存在或已删除，请刷新空间重试');
            $this->display('sns/message');
            exit;
        }

        $this->curUser = $result['data']['blog']['uid'];
        //获取当前用户统计
        $curUserinfo =  $this->apiServer->reSetting()->setService('Sns.Info.detail')->addParams(array('uid'=>$this->curUser,'userid'=>$this->user['uid']))->request();
        $this->assign('snsUser',$curUserinfo);
        $this->assign('cates',$result['data']['cates']);
        $this->assign('blog',$result['data']['blog']);

        $this->display('sns/blog_detail');
    }


    /********************日志操作***************************/
    /**
     * 添加日志分类
     */
    public function addcate(){
        $cate = h(strip_tags($this->input->post('catename')));
        $parameters['uid'] = $this->user['uid'];
        $parameters['catename'] = $cate;
        $result =  $this->apiServer->reSetting()->setService('Sns.Blog.addCategory')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }
        renderjson(0,'添加成功',$result['data']);

    }

    /**
     * 添加日志页面
     */
    public function add(){
        $parameters['uid'] = $this->user['uid'];
        $category =  $this->apiServer->reSetting()->setService('Sns.Blog.category')->addParams($parameters)->request();
        $this->assign('category',$category);
        $this->display('sns/blog_add');
    }

    /**
     * 编辑日志
     */
    public function edit(){
        $user = $this->user;
        $bid = intval($this->input->get('bid'));

        $parameters['uid'] = $user['uid'];
        $parameters['bid'] = $bid;

        $result =  $this->apiServer->reSetting()->setService('Sns.Blog.detail')->addParams($parameters)->request();

        if($result['status'] == 0){
            $this->assign('uid', $user['uid']);
            $this->assign('message', '日志不存在或已删除，请刷新空间重试');
            $this->display('sns/message');
            exit;
        }

        if($this->user['uid'] != $result['data']['blog']['uid']){
            $this->assign('uid', $user['uid']);
            $this->assign('message', '你无权修改别人的日志');
            $this->display('sns/message');
            exit;
        }

        $this->assign('cates',$result['data']['cates']);
        $this->assign('blog',$result['data']['blog']);

        $this->display('sns/blog_edit');
    }

    /**
     * 保存日志
     */
    public function save(){
        $content = $this->input->post('content');
        $title = h(strip_tags($this->input->post('title')));
        $content = h($content);
        $cate = $this->input->post('cate');
        $bid =@ intval($this->input->post('bid'));
        $action = $this->input->post('action');
        $permission = $this->input->post('permission');

        if(empty($title) || empty($content)){
            renderjson(1,'标题或内容不能为空');
        }

        $this->checkSensitive($title);
        $this->checkSensitive($content);


        if($action == 'add'){
            $parameters['uid'] = $this->user['uid'];
            $parameters['content'] = $content;
            $parameters['title'] = $title;
            $parameters['cate'] = $cate;
            $parameters['permission'] = $permission;
            $parameters['ip'] = $this->input->getip();


            $result =  $this->apiServer->reSetting()->setService('Sns.Blog.add')->addParams($parameters)->request();

            if($result['status'] == 0){
                renderjson(1,$result['msg']);
            }
            renderjson(0,'添加成功',$result['data']);

        }else{
            $parameters['bid'] = $bid;
            $parameters['uid'] = $this->user['uid'];
            $parameters['content'] = $content;
            $parameters['title'] = $title;
            $parameters['cate'] = $cate;
            $parameters['permission'] = $permission;
            $parameters['ip'] = $this->input->getip();


            $result =  $this->apiServer->reSetting()->setService('Sns.Blog.edit')->addParams($parameters)->request();

            if($result['status'] == 0){
                renderjson(1,$result['msg']);
            }
            renderjson(0,'修改成功');
        }
    }

    /**
     * 删除日志
     */
    public function del(){
        $bid = intval($this->input->post('bid'));
        $parameters['bid'] = $bid;
        $parameters['uid'] = $this->user['uid'];
        $result =  $this->apiServer->reSetting()->setService('Sns.Blog.del')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }
        renderjson(0,'删除成功');
    }
}