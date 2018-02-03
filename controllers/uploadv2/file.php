<?php
/**
 * 文件上传接口
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/7/13
 * Time: 14:46
 */
class FileController extends CControl {
    /**
     * 通用文件上传处理
     */
    private $_is_debug = false;
    public function __construct()
    {
        parent::__construct();
        if (defined('IS_DEBUG')) {
            $this->_is_debug = IS_DEBUG;
        }
    }
    public function index() {
        if(empty($_FILES)){
            $this->renderJson(1, '无文件上传');
            exit;
        }
        $upfield = key($_FILES);
        $file = $_FILES[$upfield];
        if (empty($file['size'])) {
            $this->renderJson(1, '无文件上传');
            exit;
        }
        $request = $this->input->request();
        $from = empty($request['from']) ? '' : $request['from'];//来自哪里的上传
        $uptype = empty($request['uptype']) ? 'attachment' : $request['uptype'];//上传存储类型
        if (!in_array($uptype, array('attachment', 'intro'))) {
            //仅支持通知附件、课程开场视频附件
            $this->renderJson(1, '不支持上传类型');
            exit();
        }
        $data = array('from'=>$from,'uptype'=>$uptype,'upfield'=>$upfield);

        if ($file['size'] > 524288000) {
            $this->renderJson(1, '文件容量超过上限500M,上传失败');
            exit();
        }

        $md5 = md5_file($file['tmp_name']);
        $data['md5'] = $md5;
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        if (empty($_UP['attachment']['server'][1])) {
            $this->renderJson(1, '未配置上传服务器');
            exit();
        }
        $server = $_UP['attachment']['server'][1];
        $cfile = curl_file_create(realpath($file['tmp_name']),$file['type'],$file['name']);
        $data[$upfield] = $cfile;
        $res = do_post($server,$data);
		if(!empty($request['isreturnid'])){//加入到数据库，并返回id。aroomv3资讯，网校详情
			$resarr = json_decode($res);
			if (!empty($resarr->data->server)) {
				$paramA['file_server'] = safefilter($resarr->data->server);
				$paramA['file_url'] = safefilter($resarr->data->url);
				$paramA['file_name'] = safefilter($resarr->data->originalName);
				$paramA['file_size'] = intval($resarr->data->size);
				$paramA['file_md5'] = safefilter($resarr->data->md5);
				
				$user = Ebh::app()->user->getAdminLoginUser();
				$roominfo = Ebh::app()->room->getcurroom();
				if($roominfo['uid'] == $user['uid']){
					$paramA['uid'] = $user['uid'];
					$paramA['crid'] = $roominfo['crid'];
					$attid = Ebh::app()->getApiServer('ebh')->reSetting()
					->setService('Aroomv3.Attach.add')
					->addParams($paramA)
					->request();
					//attid加入到返回结果中
					$resarr->data->attid = $attid;
					$res = json_encode($resarr);
				}
			}
		}
		
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