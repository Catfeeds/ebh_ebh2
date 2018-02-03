<?php
    /**
     * 
     * 收藏控制器
     * Author: songpeng
     * Date: 2017/04/28
     */
class CollectController extends CControl {
    /**
     * 判断折扣(收藏)开关是否开启
     * @return 1/0
     */
    public function checkSwitch(){//获取开关
        $ret = 0;
        $systeminfo = Ebh::app()->room->getSystemSetting();
        if(!empty($systeminfo['iscollect']) && ($systeminfo['iscollect']==1)){
            $ret = 1;
        }
        return $ret;
    }
    /**
     *  
     * 判断收藏按钮状态
     * 
     */
    public function checkCollectButton(){
        $user = Ebh::app()->user->getloginuser(); 
        $groupid = $user['groupid'];
        $uid = $user['uid'];
        $room = Ebh::app()->room->getcurroom();
        $crid = $room['crid'];
        $switch = $this->checkSwitch();
        if(!empty($uid) && $groupid ==6){
            if($switch){
                $folderid = intval($this->input->post('folderid'));
                $charge = $this->model('folder')->checkNotFreeFolder($crid,$folderid);              //课程是否收费
                $check = $this->model('userpermission')->getFolderPermission($uid,$crid,$folderid); //用户是否已购买
                $type = $check['type'];
                $exist = $this->model('collect')->check($uid,$crid,$folderid);                      //检查是否已收藏
                if($charge){
                    if($type ==1 ){
                        $code = 1;
                        $collect = 0;
                        $msg = '不显示';//已购买
                        $this->renderjson($code,$msg,array('collect'=>$collect));
                    }else{
                        if(!empty($exist)){
                            $code = 1;
                            $collect = 1;
                            $msg = '取消收藏';//已收藏
                            $this->renderjson($code,$msg,array('collect'=>$collect));
                        }else{
                            $code = 1;
                            $collect = 2;
                            $msg = '加入收藏';//未收藏
                            $this->renderjson($code,$msg,array('collect'=>$collect));
                        }
                    } 
                }else{
                     $code = 1;
                     $collect = 0;
                     $msg = '不显示';//免费课程
                     $this->renderjson($code,$msg,array('collect'=>$collect));
               }
            }else{
                $code = 1;
                $collect = 0;
                $msg = '不显示';//开关关闭
                $this->renderjson($code,$msg,array('collect'=>$collect));
            }
        }else{
            $code = 1;
            $collect = 0;
            $msg = '不显示';//未登录不显示
            $this->renderjson($code,$msg,array('collect'=>$collect));
        }
    }
    /**
     * 判断收藏小星星状态
     * 
     */
    public function checkStar(){
        $user = Ebh::app()->user->getloginuser();
        $groupid = $user['groupid'];
        $uid = $user['uid'];
        $room = Ebh::app()->room->getcurroom();
        $crid = $room['crid'];
        $switch = $this->checkSwitch();//判断开关是否开启
        if(!empty($uid) && $groupid ==6 && $switch){
            $code = 1;
            $switch = 1;
            $msg = '开启';
            $this->renderjson($code,$msg,array('switch'=>$switch));
        }else{
            $code = 1;
            $switch = 0;
            $msg = '关闭';
            $this->renderjson($code,$msg,array('switch'=>$switch));
        }
    }

     /**
     * 添加/取消收藏（按钮）
     * @param $flag int 0取消  1添加
     * 
     */
    public function changeButtonState(){
        $user = Ebh::app()->user->getloginuser();
        $room = Ebh::app()->room->getcurroom();
        $crid = $room['crid']; 
        $uid = $user['uid'];
        $folderid = intval($this->input->post('folderid'));
        $itemid = intval($this->input->post('itemid'));//用于支付，购买传参
        $flag = intval($this->input->post('flag'));
        $check = $this->model('collect')->check($uid,$crid,$folderid);
        if(!empty($check) && $flag ==1){
            $this->renderjson(0, '已存在');        
        }
        if(empty($check) && $flag == 1){
            $param = array('uid'=>$uid,'crid'=>$crid,'folderid'=>$folderid,'itemid'=>$itemid);
            $ck = $this->model('collect')->add($param);
            !empty($ck) ? $this->renderjson(1, '添加成功') :
            $this->renderjson(0, '添加失败');
        } 
        if(!empty($check) && $flag == 0){     
            $this->model('collect')->del($uid,$crid,$folderid);
            $this->renderjson(1, '取消成功');          
        }
        if(empty($check) && $flag == 0){
            $this->renderjson(0, '无此记录，取消失败');   
        }
    }

    /**
     * 在收藏列表中删除单个课程
     * @return 删除后的课程列表信息
     * 
     */
    public function ajax_del(){                             //收藏列表删除
        $user = Ebh::app()->user->getloginuser();
        $uid = $user['uid'];
        $room = Ebh::app()->room->getcurroom();
        $crid = $room['crid']; 
        $folderid = intval($this->input->post('folderid'));
        $ret = $this->model('collect')->del($uid,$crid,$folderid);
        $ret ? $this->renderjson(1, '操作成功') : $this->renderjson(0, '操作失败');                       
    }

    /**
     * 鼠标进入时展示收藏列表
     * @return 课程列表信息
     * 
     */
    public function  ajax_list(){                           //收藏列表展示
        $user = Ebh::app()->user->getloginuser();
        $groupid = $user['groupid'];
        $uid = $user['uid'];
        $room = Ebh::app()->room->getcurroom();
        $crid = $room['crid']; 
        if($groupid == 6){
            $itemlist = $this->model('collect')
                    ->getCollectInfoByUid($uid,$crid);
            if($itemlist){        
                $this->getlist($uid,$crid,$itemlist);           
            } else {
                $code = 1;
                $exist = 0;
                $msg = '此用户无收藏记录';
                $num = 0;
                $totalprice = 0;
                $afterdiscount = 0;
                $this->renderjson($code, $msg,array(
                    'exist' => $exist,
                    'num' => $num,
                    'totalprice' => $totalprice,
                    'afterdiscount' => $afterdiscount, 
                    ));
            } 
        }else{
            $this->renderjson(0, '非学生账号不允许操作');
        }                                  
    }

    /**
     * 收藏列表展示(ajax_list调用)
     * @return 课程列表信息
     * 
     */
    private function getlist($uid,$crid,$itemlist){
        $instr ='';
        if(is_scalar($itemlist)){
            $instr = $itemlist;
        }elseif(is_array($itemlist)){
            $instr = implode(",", $itemlist);
        }
       
        $paymodel = $this->model('Payitem');
        $listcount =  $paymodel->getItemListCount(array('crid'=>$crid,'itemidlist'=>$instr));
        $folderinfo = $paymodel->getItemList(array('crid'=>$crid,'itemidlist'=>$instr,'limit'=>$listcount));
        $totalprice = 0;                                        //总价
        foreach ( $folderinfo as $value) {
               $totalprice += $value['iprice'];
            }       
        $num = count($folderinfo);                              //课程数量
        //获取缓存                           
        $systeminfo = Ebh::app()->room->getSystemSetting();     //$systeminfo['discounts']=[[6,'0.8'],[8,'0.75']]
        $disarr = json_decode($systeminfo['discounts']);        //折扣列表
        array_multisort($disarr,SORT_ASC);
        $count = count($disarr);
        if($count){//判断是否设置折扣                                                   
            //折扣率;
            //1.获取设置折扣的最大数量$nummax
            //2.若$nummax<$num即按照最低折扣计算
            //3.若$num为设置的某个折扣数量，则按照设置的折扣计算
            //4.若$nummin<=$num && $nummax >= $num需确保取得合适的折扣区间
            //5.若$nummin>$num，则无折扣
            $nummax = $disarr[$count-1][0];
            $nummin = $disarr[0][0];
            if($nummax < $num){
                $discount = $disarr[$count-1][1];
            }
            if($nummin<=$num && $nummax >= $num){
                $count = 0;
                foreach($disarr as $v){
                    $count++;
                    if($v[0] > $num){
                        $discount = $disarr[$count-2][1];
                        break;
                    }
                    if($v[0] == $num){
                        $discount = $disarr[$count-1][1];
                        break;
                    }        
                }
            }
            if($nummin > $num || $count == 0){
                $discount = 1;
            } 
        }else{                                              //折扣打开，但未设置折扣
            $discount = 1;
        }               
        //折后价
        $afterdiscount = $totalprice*$discount;
        $afterdiscount = sprintf("%.2f",$afterdiscount);
        if($folderinfo){
            $code = 1;
            $msg = '成功';
            $this->renderjson($code,$msg,array(
                'list'=> $folderinfo,
                'num' => $num,
                'totalprice' => $totalprice,
                'afterdiscount' => $afterdiscount
            ));
        } else {
            $code = 1;
            $msg = '查询错误,数据库不存在收藏的某一个或多个课程';
            $num = 0;
            $totalprice = 0;
            $afterdiscount = 0;
            
            $this->renderjson($code,$msg,array(
                'list'=> array(),
                'num' => $num,
                'totalprice' => $totalprice,
                'afterdiscount' => $afterdiscount
            ));
        }
    }

   
    /**
     * json格式输出
     * @param number $code 状态标识 0 成功 1 失败
     * @param string $msg 输出消息
     * @param array $data 数组参数数组
     * @param string $exit 是否结束退出
     */
    public function renderjson($code=0,$msg="",$data=array(),$exit=true){
        $arr = array(
            'code'=>(intval($code) ===0) ? 0 : intval($code),
            'msg'=>$msg,
            'data'=>$data
        );
        echo json_encode($arr);
        if($exit){
            exit();
        }
    } 
}
 

