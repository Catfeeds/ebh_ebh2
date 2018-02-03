<?php
/**
 * 统一图片上传处理
 */
class ImageController extends CControl {
    private $_is_debug = false;
    public function __construct()
    {
        parent::__construct();
        if (defined('IS_DEBUG')) {
            $this->_is_debug = IS_DEBUG;
        }
    }
    /**
     * 通用图片上传处理
     */
	public function index() {
	    if(empty($_FILES)){
	        $this->renderJson(1, '无图片上传');
	        exit;
	    }
        $upfield = 'upfile';
	    if (!isset($_FILES['upfile'])) {
	        $upfield = key($_FILES);
        }
        $file = $_FILES[$upfield];
	    if (empty($file['size'])) {
            $this->renderJson(1, '无图片上传');
            exit;
        }
	    $request = $this->input->request();
	    $from = empty($request['from']) ? "":$request['from'];//来自哪里的上传
	    $uptype = empty($request['uptype']) ? "aroomv3" : $request['uptype'];//上传存储类型
        $size = empty($request['size']) ? "" : $request['size'];//上传存储类型

        if (!in_array($uptype, array('logo','ico','qcode','course','news','avater','aroomv3','app'))) {
            $this->renderJson(1, '上传类型不支持');
            exit();
        }

        if ($file['size'] > 2097152) {
            $this->renderJson(1, '图片容量超过上限2M,上传失败');
            exit();
        }
        $data = array('from'=>$from,'uptype'=>$uptype,'upfield'=>$upfield,'size'=>$size);
        $cfile = curl_file_create(realpath($file['tmp_name']),$file['type'],$file['name']);
        $data[$upfield] = $cfile;
        if (preg_match('/^\d+_\d+$/', $data['size'])) {
            $selectionW = !empty($request['selection_w']) ? intval($request['selection_w']) : 0;
            $selectionH = !empty($request['selection_h']) ? intval($request['selection_h']) : 0;
            $selectionX = !empty($request['selection_x']) ? intval($request['selection_x']) : 0;
            $selectionY = !empty($request['selection_y']) ? intval($request['selection_y']) : 0;
            if ($selectionW > 0 && $selectionH > 0 && $selectionX >= 0 && $selectionY >= 0) {
                $data['selection_w'] = $selectionW;
                $data['selection_h'] = $selectionH;
                $data['selection_x'] = $selectionX;
                $data['selection_y'] = $selectionY;
            }
        }
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $server = isset($_UP[$uptype]) ? $_UP[$uptype]['server'][0] : $_UP['aroomv3']['server'][0];
        $res = do_post($server,$data);
        //清除缓存区数据
        @ob_end_clean();
        header('Content-Type: application/json; charset=utf-8');
        echo $res;
	}
    /**
     * json数据
     * @param $errcode 错误代码
     * @param $data 反馈数据，当$errcode > 0时，为错误信息字符串
     */
    private function renderJson($errcode, $data) {
        $errcode = intval($errcode);
        $ret = array(
            'code' => $errcode
        );
        if ($errcode > 0) {
            $ret['msg'] = strval($data);
        } else {
            $ret['data'] = $data;
        }
        //清除缓存区数据
        @ob_end_clean();
        header('Content-Type: application/json; charset=utf-8');
        if (!$this->_is_debug) {
            echo json_encode($ret);
            exit();
        }
        echo json_encode($ret,JSON_UNESCAPED_UNICODE);
        exit();
    }
}
