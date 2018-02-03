<?php 
/**
 *获取城市天气接口
 */
class WeatherController extends CControl{
	
	public function index(){
        $this->checkAllowOrigin();
        $day = $this->input->get('day');
        $param['day'] = empty($day) ? 0 : intval($day);
        //获取城市名字
        $IPaddress =Ebh::app()->lib('IPaddress');
        $ip = getip();
        $addressArr = $IPaddress->find($ip);
        if (empty($addressArr['2'])) {
            $addressArr['2'] = '杭州';
        }
        $param['city'] = $addressArr['2'];
        $res = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Classroom.Design.getWeather')->addParams($param)->request();
        echo json_encode($res);
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
}
?>