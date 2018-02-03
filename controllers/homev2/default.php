<?php
/**
 * 个人中心
 */
class DefaultController extends CControl {
	private $user = null;
	public function __construct(){
		parent::__construct();
		$this->user = Ebh::app()->user->getloginuser();
		Ebh::app()->user->checkUserLogin($this->user ,true);
		$this->assign('user',$this->user);
	}
	/**
	 * 个人中心-首页
	 */
    public function index() {
        if(!empty($_SERVER['REQUEST_URI']) && preg_match('/index/', $_SERVER['REQUEST_URI']) ){
            header("Location:".geturl('homev2'));
            die;
        }
    	$user = $this->user;
    	$roominfo = Ebh::app()->room->getcurroom();
    	$this->assign('room', $roominfo);
    	$this->assign('user', $this->user);
		$roomuser = $this->model('roomuser');
		$roomcount = $roomuser->getroomcount($this->user['uid']);
		$this->assign('roomcount',$roomcount);
    	$this->assign('roominfo',$roominfo);

    	$this->getassigintop();

    	//网校列表	
		if($user['groupid']=='5'){//老师
			$roommodel = $this->model('Classroom');
			$roomlist = $roommodel->getroomlistbytid($user['uid']);
			//判断我的空间是否启用
            $enable_sns = $this->model('Appmodule')->checkSns($roominfo['crid'], 1);
		}elseif($user['groupid']=='6'){
			$roomlist = $roomuser->getroomlist($user['uid']);
            //判断我的空间是否启用
            $enable_sns = $this->model('Appmodule')->checkSns($roominfo['crid'], 0);
		}
		$this->assign('enable_sns', $enable_sns);
		//处理独立域名情况
		foreach($roomlist as &$room){
			$roomurl = empty($room['fulldomain']) ? $room['domain'].'.ebh.net' : $room['fulldomain'];
			if($user['groupid']=='5'){
				$roomurl = 'http://'.$roomurl.'/troomv2.html';
			}else{
				$roomurl = 'http://'.$roomurl.'/myroom.html';
			}
			
			$room['roomurl'] =$roomurl;
			
			//获取网校分享码
			$sharekey = Ebh::app()->runAction('room/share','getsharekey',array('itemid'=>0,'crid'=>$room['crid'],'from'=>'school'));
			$room['sharekey'] = $sharekey;
		}
		$user = Ebh::app()->user->getloginuser();
        $redurl = $_SERVER['REQUEST_URI'];
        if(empty($user)){
            $url = geturl('login') . '?returnurl=' . $redurl;
            header("Location: $url");
            exit();
        }
        $itemModel = $this->model('bestitem');
        $item = $itemModel->getitemidbyuid($user['uid']);
        if(!empty($item)){
            $item = $this->unique_arr($item);
        }
        if(!empty($item)){
            $itemstr = '';
            foreach ($item as $key => $value) {
                $itemstr.= $value['itemid'].',';
            }
            $itemstr = rtrim($itemstr,',');
            if(!empty($itemstr)){
                $list = $itemModel->getmyclass($user['uid'],$itemstr);
            }
            if(!empty($list)){
                foreach ($list as $key => $value) {
                    if($value['iname'] ==''){
                        unset($list[$key]);
                    }
                }
            if(!empty($list)){
                $this->assign('count',count($list));
            }
            }
        }
            
        //获取网校二维码
        $upconfig = Ebh::app()->getConfig()->load('upconfig');
        $qrcode = $upconfig['qrcode'];
        $baseurl =$qrcode['server'][0];
        $this->assign("baseurl",$baseurl);

        
		$this->assign('roomlist',$roomlist);
    	$this->display("homev2/index");
    }
    
    /**
     * 获取top信息
     */
    public function getassigintop(){
    	$user = $this->user;
    	//uri
    	$this->assign('controller',$this->uri->uri_control());
    	$this->assign('action',$this->uri->uri_method());
    	$clinfo = array();
        $clinfo['title']='';
    	if($user['groupid']==5){//老师
    		//积分等级
    		$clconfig = Ebh::app()->getConfig()->load('creditlevel_t');
    		foreach($clconfig as $clevel){
    			if($user['credit']>=$clevel['min'] && $user['credit']<=$clevel['max']){
    				$clinfo['title'] = $clevel['title'];
    				if($user['credit']<=500){
    					$clinfo['percent'] = 50*intval($user['credit'])/500;
    				}elseif($user['credit']<=3000){
    					$clinfo['percent'] = 50+30*(intval($user['credit'])-500)/2500;
    				}elseif($user['credit']<=10000){
    					$clinfo['percent'] = 80+20*(intval($user['credit'])-3000)/7000;
    				}else{
    					$clinfo['percent'] = 100;
    				}
    				break;
    			}
    		}
    	}elseif($user['groupid']==6){//学生
    		//积分等级
    		$clconfig = Ebh::app()->getConfig()->load('creditlevel');
    		foreach($clconfig as $clevel){
    			if($user['credit']>=$clevel['min'] && $user['credit']<=$clevel['max']){
    				$clinfo['title'] = $clevel['title'];
    				if($user['credit']<=500){
    					$clinfo['percent'] = 50*intval($user['credit'])/500;
    				}elseif($user['credit']<=3000){
    					$clinfo['percent'] = 50+30*(intval($user['credit'])-500)/2500;
    				}elseif($user['credit']<=10000){
    					$clinfo['percent'] = 80+20*(intval($user['credit'])-3000)/7000;
    				}else{
    					$clinfo['percent'] = 100;
    				}
    				break;
    			}
    		}
    	}
    	$this->assign('clinfo',$clinfo);
    	//完成度百分比
    	$percent = Ebh::app()->user->getpercent($this->user);
    	$this->assign('percent',$percent);
    	
    	//粉丝
    	$snsmodel = $this->model('Snsbase');
    	$mybaseinfo = $snsmodel->getbaseinfo($this->user['uid']);
    	$myfanscount = max(0,$mybaseinfo['fansnum']);
    	//关注
    	$myfavoritcount = max(0,$mybaseinfo['followsnum']);
    	$this->assign('myfanscount',$myfanscount);
    	$this->assign('myfavoritcount',$myfavoritcount);
    }

    function unique_arr($array2D,$stkeep=false,$ndformat=true)  
        {  
            // 判断是否保留一级数组键 (一级数组键可以为非数字)  
            if($stkeep) $stArr = array_keys($array2D);  
          
            // 判断是否保留二级数组键 (所有二级数组键必须相同)  
            if($ndformat) $ndArr = array_keys(end($array2D));  
          
            //降维,也可以用implode,将一维数组转换为用逗号连接的字符串  
            foreach ($array2D as $v){  
                $v = join(",",$v);   
                $temp[] = $v;  
            }  
          
            //去掉重复的字符串,也就是重复的一维数组  
            $temp = array_unique($temp);   
          
            //再将拆开的数组重新组装  
            foreach ($temp as $k => $v)  
            {  
                if($stkeep) $k = $stArr[$k];  
                if($ndformat)  
                {  
                    $tempArr = explode(",",$v);   
                    foreach($tempArr as $ndkey => $ndval) $output[$k][$ndArr[$ndkey]] = $ndval;  
                }  
                else $output[$k] = explode(",",$v);   
            }  
          
            return $output;  
        }
        /**
         * 获取网校下第一个班级classid
         */
        public function getClassidByCrid(){
            $post = $this->input->post();
            if(!empty($post['crid'])){
                $crid = intval($post['crid']);
                $classModel = $this->model('Classes');
                $classlist = $classModel->getroomClassList($crid,0,1);
                if(!empty($classlist)){
                    echo json_encode(array('status'=>1,'classid'=>intval($classlist[0]['classid'])));
                    exit();
                }
            }
            echo json_encode(array('status'=>0));
            exit();
        }

}
