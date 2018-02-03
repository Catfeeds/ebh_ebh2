<?php
/**
 * 
 * 折扣控制器
 * Author: simple
 * Date: 2017/04/28
 *  
 */
class DiscountController extends ARoomV3Controller{
    /**
     * 判断折扣开关是否开启
     * @param $crid
     * @return 1/0
     */ 
    public function checkSwitch($crid){
        $param['crid'] = $crid;
        $ret = $this->apiServer->reSetting()
             ->setService('Aroomv3.Discount.checkSwitch')
             ->addParams($param)->request();
        return ($ret == TRUE) ? 1:0;
    }

    /**
     * 设置折扣开、关
     * @param $flag  1/0  
     */
    public function changeSwitch(){
        $flag = intval($this->input->get('flag'));
        $param['flag'] = $flag;
        $param['crid'] = $this->roominfo['crid'];
        $ret = $this->apiServer->reSetting()
             ->setService('Aroomv3.Discount.changeSwitch')
             ->addParams($param)->request();
        
        //更新缓存
        $this->_updateCache($this->roominfo['crid']);
        
        $ret ? $this->renderjson(1, '操作成功') : $this->renderjson(0, '操作失败'); 
    }

    /**
     * 添加折扣
     * @param $num 课程数量  $discount 对应折扣
     */
	public function add(){//添加
	    $num = intval($this->input->post('num'));
	    $discount = $this->input->post('discount');
        $discount = $discount*0.1;
        $sub = intval($this->input->post('sub'));
        if(empty($num) || empty($discount)){
            $this->renderjson(0, '非法操作');
            return false;
        }
        $param['crid'] = $this->roominfo['crid'];
        $param['num'] = $num;
        $param['discount'] = $discount;
        $param['sub'] = $sub;
        $ret = $this->apiServer->reSetting()
             ->setService('Aroomv3.Discount.add')
             ->addParams($param)->request();
        
        //更新缓存
        $this->_updateCache($this->roominfo['crid']);
  
        $ret ? $this->renderjson(1, '操作成功') : $this->renderjson(0, '操作失败');
	}
    /**
     * 删除折扣
     * @param $num 课程数量 
     */
	public function del(){//删除
		$num = intval($this->input->post('num'));
        if(empty($num)){
            $this->renderjson(0, '非法操作');
            return false;
        }
        $param['crid'] = $this->roominfo['crid'];
		$param['num'] = $num;
		$ret = $this->apiServer->reSetting() 
			 ->setService('Aroomv3.Discount.del')
			 ->addParams($param)->request();
		
        //更新缓存
        $this->_updateCache($this->roominfo['crid']);
        
		$ret ? $this->renderjson(1, '操作成功') : $this->renderjson(0, '操作失败');
      
	} 
    /**
     * 查询折扣列表
     * @return $data[][]
     */
    public function getlist(){//查询折扣列表              
		$crid = $this->roominfo['crid'];
        $isschool = $this->roominfo['isschool'];
        //更新缓存
        $this->_updateCache($this->roominfo['crid']);
        $switch = $this->checkSwitch($crid);
        if($isschool == 3){
            $code = 0;
            $switch = 0;
            $msg = '租赁制，不显示';                 
            echo json_encode(array('code' => $code,'switch' => $switch,'msg' => $msg,'data' => array()));   		
        }else{
            $param = array();
            $param['crid'] = $crid;
            $ret = $this->apiServer->reSetting()
                ->setService('Aroomv3.Discount.getlist')
                ->addParams($param)->request();
            $ret = empty($ret) ? array():$ret;
            $i=0;
            foreach($ret as $v){
                $ret[$i][1] = $v[1]*10;//将折扣数据0.80形式转换为8（折）的形式
                $i++;
            }
            if($switch){
                $code = 1;
                $msg = '开关打开';                 
                echo json_encode(array('code' => $code,'switch' => $switch,'msg' => $msg,'data' => $ret));
            }else{
                $code = 1;
                $msg = '开关关闭';                 
                echo json_encode(array('code' => $code,'switch' => $switch,'msg' => $msg,'data' => $ret));
            }
        }
	}
    
	/**
	 * 更新网校缓存
	 * @param unknown $crid
	 */
	private function _updateCache($crid){
	    //更新缓存
	    $redis = Ebh::app()->getCache('cache_redis');
	    $redis_key = 'room_systemsetting_' . $crid;
	    $redis->remove($redis_key);
	}

}