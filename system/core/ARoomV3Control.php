<?php
/**
 * ebh2.
 * Author: jw
 * Email: 345468755@qq.com
 */
class ARoomV3Controller extends  CControl{

    public $user = null;
    public $roominfo = null;
    public $apiServer = null;
    public function __construct() {
        parent::__construct();
        $this->checkAllowOrigin();
        $verifyCode = 0;
        $checkRoom = Ebh::app()->room->checkRoomControlV3($verifyCode);
        $this->user = Ebh::app()->user->getAdminLoginUser();
        $this->roominfo = Ebh::app()->room->getcurroom();
        $this->apiServer = Ebh::app()->getApiServer('ebh');
        if(!$checkRoom){
            $errMsgs = array(
                1 => '用户未登录!',
                2 => '权限验证失败!',
                3 => '网校不存在!'
            );
            $errMsg = isset($errMsgs[$verifyCode]) ? $errMsgs[$verifyCode] : '未知错误!';
            $this->renderjson(1,$errMsg);
        }
		
    }

    /**
     * 允许本地局域网 跨域请求
     */
    private function checkAllowOrigin(){
        $origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';
        //$origin = 'http://192.168.0.58:8080';
        $portArr = array('80','8080');
        $localPrefix = array('192.168.0','127.0.0');
        if(!empty($origin)){
            $ip = parse_url($origin,PHP_URL_HOST);//http://192.168.0.58 => 192.168.0.58
            //  $ip = '101.69.252.186';
            if(!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)){
                $allow_origin = array();
                $start = 1;
                $max = 255;
                
                for($start;$start<$max;$start++){
                    foreach($portArr as $port){
                        $newip = 'http://'.$localPrefix[0].'.'.$start.':'.$port;
                        array_push($allow_origin, $newip);
                    }
                }
                $allow_origin = array_merge($allow_origin,array('http://127.0.0.1:8080','http://127.0.0.1:80'));
                //print_r($allow_origin);die();
                if(in_array($origin, $allow_origin)){
                    header('Access-Control-Allow-Origin:'.$origin);
                    header('Access-Control-Allow-Credentials:true');
                }else{
                    //暂时先加上 允许跨域
                    header("Access-Control-Allow-Origin: *");
                }
            }
        }
    }
    
    /**
     * 获取接口分页信息
     */
    public function getPageInfo(){
        //$query['pagesize'] = $this->input->
        $page = $this->input->get('pagenum') != null ? $this->input->get('pagenum') : $this->input->post('pagenum');
        $pagesize = $this->input->get('pagesize') != null ? $this->input->get('pagesize') : $this->input->post('pagesize');

        if(intval($page) <= 0){
            $page = 1;
        }

        if($pagesize == null){
            $pagesize = 20;
        }

        $query['pagenum'] = $page;
        $query['pagesize'] = $pagesize;
        return $query;

    }

    /**
     * json格式输出
     * @param number $code 状态标识 0 成功 1 失败
     * @param string $msg 输出消息
     * @param array $data 数组参数数组
     * @param string $exit 是否结束退出
     */
    function renderjson($code=0,$msg="",$data=array(),$exit=true){
        $arr = array(
            'code'=>(intval($code) ===0) ? 0 : intval($code),
            'msg'=>$msg,
            'data'=>$data
        );
        echo json_encode($arr,JSON_UNESCAPED_UNICODE);
        if($exit){
            exit();
        }
    }
}