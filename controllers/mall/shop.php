<?php
class ShopController extends CControl{
	private $user = null;
	private $shopconfig;
	public function __construct(){
		parent::__construct();
		$this->user = Ebh::app()->user->getloginuser();
		if(empty($this->user)){
			header('location:/login.html?returnurl='.$_SERVER['REQUEST_URI']);
			exit;
		}
        $this->shopconfig = Ebh::app()->getConfig()->load('shopconfig');
		$this->assign('user',$this->user);
	}
    public function index() {
    	$roominfo = Ebh::app()->room->getcurroom();
    	$this->assign('room', $roominfo);
    	$user = Ebh::app()->user->getloginuser();
    	$this->assign('user', $user);
    	$roommodel = $this->model('Classroom');
    	$roomlist = $roommodel->getroomlistbyuid($user['uid']);
    	$this->assign('roomlist', $roomlist);
    	$this->assign('roominfo', $roominfo);

    	$this->display("mall/home");
    }
	/**
	 * [delivery 发货处理]
	 * @return [type] [description]
	 */
	public function delivery_view(){
		$post = $this->input->post();
		$ordernum = $this->uri->itemid;
		$crinfo = Ebh::app()->room->getcurroom();
		$crid = empty($crinfo['crid']) ? 0 : $crinfo['crid'];
		$res = do_shop_post($this->shopconfig['order_checkstatus_url'],array('ordernum'=>$ordernum,'crid'=>$crid),false);
		if($res->status != 1){
			if(empty($post)){
				echo '参数错误！';
				exit;
			}else{
				echo json_encode(array('status'=>0));
				exit;
			}
		}
		if(!empty($ordernum) && !empty($crid) && $res->status == 1){
			if(empty($post)){//显示发货页面
				$url = $this->shopconfig['order_logistic_url'];
				$logisticslist = do_shop_post($url,array(),false);
				$editor = Ebh::app()->lib('UMEditor');
				$this->assign('editor',$editor);
				$this->assign('is_real',$res->is_real);
				$this->assign('logistics',$logisticslist->list);
				$this->assign('ordernum',$ordernum);
				$this->display('mall/order/delivery');
			}else{//发货内容提交
				$param = array();
				$param['exptype'] = empty($post['exptype']) ? 1 : $post['exptype'];//发货方式 1：快递 2：当面交易
				$param['lid'] = empty($post['lid']) ? 0 : $post['lid'];//物流公司id
				$param['remark'] = empty($post['remark']) ? '' : $post['remark'];
				$param['expnum'] = empty($post['expnum']) ? '' : $post['expnum'];
				$param['ordertype'] = 2;//订单状态，2为已发货，等待买家确认
				$param['ordernum'] = $ordernum;
				$param['crid'] = $crid;
				$url = $this->shopconfig['order_update_url'];
				$res = do_shop_post($url,$param,false);
				echo json_encode(array('data'=>$res->status));
			}
		}
	}
	//获取地址json数据
	public function getAreajson(){
		$file = LIB_PATH . 'area.json';
		if(file_exists($file)){
			$json = file_get_contents($file);
			echo $json;
			exit;
		}
	}

    /**
     * 异步获取
     */
    public function ajaxGetArea(){
        $input = EBH::app()->getInput();
        $parent_areacode = intval($input->get('parent_areacode'));
        $cities = $this->model('Cities')->getCitiesByParent($parent_areacode);

        echo json_encode($cities);
    }
}