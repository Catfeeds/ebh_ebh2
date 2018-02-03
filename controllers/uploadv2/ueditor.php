<?php
class UeditorController extends CControl{
    /**
     * 百度编辑器后台调度
     */
    public function index(){
        $config = Ebh::app()->getConfig()->load('ueditor');
        $action = $this->input->get('action');
        switch ($action) {
            //读取配置
            case 'config':
                $result =  json_encode($config);
                break;
            /* 上传图片 */
            case 'uploadimage':
                $this->uploadimage();
                break;
        }


        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state'=> 'callback参数不合法'
                ));
            }
        } else {
            if(!empty($action)){
                echo $result;
            }
        }
    }


    public function uploadimage(){
        $config = Ebh::app()->getConfig()->load('ueditor');
        $_UP = Ebh::app()->getConfig()->load('upconfig');

        $upfield = $config['imageFieldName'];
        $file = $_FILES[ $upfield ];
        $data = array();
        $cfile = curl_file_create(realpath($file['tmp_name']),$file['type'],$file['name']);
        $data[$upfield] = $cfile;
        $post_url = $_UP['ueditor']['image']['server'][0];

        $res = do_post($post_url,$data);
        $ret = json_decode($res,true);
        $rs['state'] = $ret['state'];
        if($ret['state'] == 'SUCCESS'){
            $rs['name'] = $ret['name'];
            $rs['original'] = $ret['originalName'];
            $rs['size'] = $ret['size'];
            $rs['type'] = $ret['type'];
            $rs['url'] = $ret['url'];
        }
        echo json_encode($rs);
        exit;

    }
}