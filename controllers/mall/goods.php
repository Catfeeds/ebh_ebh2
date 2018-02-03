<?php
/**
 * 商城
 */
class GoodsController extends CControl {
    private $shopconfig;
    const PAGE_SIZE = 20;
    public function __construct(){
        parent::__construct();
        Ebh::app()->user->checkUserLogin(null,true);
        $this->shopconfig = Ebh::app()->getConfig()->load('shopconfig');
        
        //商品显示图片地址
         $_UP = Ebh::app()->getConfig()->load('upconfig');
         $showpath =$_UP['mall']['showpath'];
         $this->assign('showpath', $showpath);
    }
    
    /**
     * 商品列表
     */
    public function index() {
        $user = Ebh::app()->user->getloginuser();
        $roominfo = Ebh::app()->room->getcurroom();
        $url = $this->shopconfig['goods_list_url'];
        $params = $this->input->get();
        if(isset($params['tagid']) && $params['tagid'] == 0){
            $status = isset($params['status']) ? $params['status'] : 0;;
        }elseif(isset($params['tagid'])){
            $status = $params['tagid'];
        }else{
            $status = 0;
        }
        $params['status']   = $status;
        $params['tagid']    = isset($params['tagid']) ? $params['tagid'] : 0;
        $params['uid']      = $user['uid'];
        $params['crid']     = $roominfo['crid'];
        $params['page']     = Ebh::app()->getUri()->page;
        $params['pagesize'] = self::PAGE_SIZE;
        $ret = do_shop_post($url, $params);
        $ret = json_decode($ret,true);
        //      p($url);die;
        
        //商品图片现在
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $showpath = $_UP['mall']['showpath'];
        $this->assign('showpath',$showpath);
        
        $pagination = show_page($ret['total'],self::PAGE_SIZE);
        $goods = array(); //商品信息
        $goods['pagination'] = $pagination;
        $goods['list']       = $ret['list'];
        $goods['params']     = $params;
        $user['hasBuyedCourse'] = $this->model('payorder')->checkIfHasBuyedCourese($user['uid']);
        $bModel = $this->model('bind');
        $bind = $bModel->getUserBInd($user['uid']);
        $mobile = json_decode($bind['mobile_str'], true);
        $user['mobile'] = $mobile['mobile'];
        $this->assign('goods',$goods);
        $this->assign('user',$user);
        $this->display('mall/goods/list');
    }
    
    /**
     * 商品发布页
     */
    public function release() {
        $user = Ebh::app()->user->getloginuser();
        $roominfo = Ebh::app()->room->getcurroom();

        $this->assign('user', $user);
        $this->assign('room', $roominfo);
        $this->display('mall/goods/release');
    }

    /**
     * 发布商品
     */
    public function addoredit() {
        $user = Ebh::app()->user->getloginuser();
        $room = Ebh::app()->room->getcurroom();
        $params = $this->input->post();
        $params['uid']      = $user['uid'];
        $params['crid']     = $room['crid'];
        $params['ip']       = getip();
        $params['operator'] = getusername($user);
        if($params['price_type'] == 2){
            $params['freight'] = 0;
        }
        $url = $this->shopconfig['goods_operation_url'];
        $ret = do_shop_post($url, $params);
        echo $ret;die;
    }


    //商品操作
    //操作 del 删除商品 up 上架商品 down 下架商品 restore 还原商品
    public function operate(){
        $user   = Ebh::app()->user->getloginuser();
        $room   = Ebh::app()->room->getcurroom();
        $posts  = $this->input->post();
        $params = array();
        $params['uid']      = $user['uid'];
        $params['crid']     = $room['crid'];
        $params['gid']      = $posts['gid'];
        $params['action']   = $posts['action'];
        $url = $this->shopconfig['goods_updatestatus_url'];
        $ret = do_shop_post($url,$params);
        echo $ret;die;
    }
    //编辑商品
    public function edit(){
        $room= Ebh::app()->room->getcurroom();
        $url = $this->shopconfig['goods_detail_url'];
        $params = array();
        $gid = $this->input->get('gid');
        $params['gid'] = $gid;
        $ret = do_shop_post($url,$params);
        $ret = json_decode($ret, true);
		$user   = Ebh::app()->user->getloginuser();
		if($user['uid'] != $ret['uid']){
			header('Location: /mall/goods.html');
			exit;
		}
        $this->assign('goods',$ret);
        $this->display('mall/goods/release');
    }
    //初始化标签弹框
    public function tags(){
        $roominfo = Ebh::app()->room->getcurroom();
        $url = $this->shopconfig['goods_taglist_url'];
        $tags = do_shop_post($url, array('crid'=>$roominfo['crid']));
        echo $tags;die;
    }
    
    /**
     * 图片上传/裁剪接口
     * 
     */
    public function upimg(){
        $post = $this->input->post();
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        if($post['cate']=='up'){
            $file = $_FILES['upfile'];
            $data = array();
            $cfile = curl_file_create(realpath($file['tmp_name']),$file['type'],$file['name']);
            $data['upfile'] = $cfile;
            $data['type'] = $post['cate'];
            $url = $_UP['mall']['server'][0];
            $res = do_post($url,$data);
            echo $res;
            exit(0);
        }elseif($post['cate']=='cut'){
            $post = $this->input->post();
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            $url = $_UP['mall']['server'][0];
            $post['type'] = $post['cate'];
            $res = do_post($url,$post);
            echo $res;
            exit(0);
        }
        
    }
}