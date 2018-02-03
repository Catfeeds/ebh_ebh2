<?php
/**
 * 我的相册
 * Author: zyp
 */
class AlbumsController extends CControl {
    private $user;
    private $roominfo;
    
    public function __construct(){
        parent::__construct();
        $this->user = Ebh::app()->user->getloginuser();
        $this->roominfo = Ebh::app()->room->getcurroom();
        $this->apiServer = Ebh::app()->getApiServer('ebh');
        $this->checkAllowOrigin();
    }
    /**
     *根据aid获取子相册信息和图片
     */
    public function getalbums(){
        $data = array();
        $post = $this->input->post();
        $user = $this->user;
        $roominfo = $this->roominfo;
        $data['aid'] = !empty($post['aid']) ? intval($post['aid']) : 0;
        if(empty($user['uid']) || empty($roominfo['crid'])){
            renderjson(1,'参数错误');
        }
        $data['crid'] = $roominfo['crid'];
        $data['uid'] = $user['uid'];
        if(isset($post['q'])){
            $data['q'] = $post['q'];
        }
        if(isset($data['q']) && $data['aid']==0){//相册首页(即aid=0)搜索时请求当前用户所有图片
            $photos = $this->apiServer->reSetting()->setService('Classroom.Albums.getUserPhotos')->addParams($data)->request();
        }else{
            $photos = $this->apiServer->reSetting()->setService('Classroom.Albums.getAlbumsPhotos')->addParams($data)->request();
        }
        $albums = $this->apiServer->reSetting()->setService('Classroom.Albums.getAlbums')->addParams($data)->request();
        $albums = !empty($albums) ? $albums : array();
        $photos = !empty($photos) ? $photos : array();
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $showpath = !empty($_UP['albums']['showpath']) ? $_UP['albums']['showpath'] : 'http://img.ebanhui.com/albums/'; //相册图片展示的配置
        renderjson(0,'请求相册和图片信息',array('ablums'=>$albums,'photos'=>$photos,'showpath'=>$showpath));
    }
    /**
     *创建新相册
     */
    public function addalbums(){
        $post = $this->input->post();
        $user = $this->user;
        $roominfo = $this->roominfo;
        if(empty($user['uid']) || empty($roominfo['crid'])){
            renderjson(1,'no crid or uid');
        }
        $data = array();
        $data['crid'] = $roominfo['crid'];
        $data['uid'] = $user['uid'];
        $data['aid'] = !empty($post['aid']) ? intval($post['aid']) : 0;
        $data['alname'] = !empty($post['alname']) ? h($post['alname']) : '新建文件夹';
        //处理同名文件
        $albums = $this->apiServer->reSetting()->setService('Classroom.Albums.getAlbums')->addParams($data)->request();
        if(!empty($albums)){
            $namearr = array_column($albums,'alname');
            if(!empty($namearr)){
                $data['alname'] = $this->fileRename($data['alname'],$namearr);
            }
        }
        //保存到数据库
        if(!empty($data)){
            $albums = $this->apiServer->reSetting()->setService('Classroom.Albums.addAlbums')->addParams($data)->request();
            if(!empty($albums)){
                renderjson(0,'创建新相册成功',$albums);
            }
        }else{
            renderjson(1,'创建新相册失败');
        }
    }
    /**
     *编辑相册
     */
    public function editalbums(){
        $post = $this->input->post();
        $user = $this->user;
        $roominfo = $this->roominfo;
        $data = array();
        $data['alname'] = !empty($post['alname']) ? h($post['alname']) : '';
        if(empty($user['uid']) || empty($roominfo['crid']) || empty($data['alname'])){
            renderjson(1,'参数不完整');
        }
        if (mb_strlen($data['alname'],"UTF-8") > 50 ) {
            renderjson(1,'相册名字太长');
        }
        $data['crid'] = $roominfo['crid'];
        $data['uid'] = $user['uid'];
        $data['aid'] = !empty($post['aid']) ? intval($post['aid']) : 0;
        $albums = $this->apiServer->reSetting()->setService('Classroom.Albums.editAlbums')->addParams($data)->request();
        if(!empty($albums)){
            renderjson(0,'编辑相册成功',$albums);
        }else{
            renderjson(1,'编辑相册失败');
        }
    }
    /**
     *删除相册
     */
    public function delalbums(){
        $post = $this->input->post();
        $user = $this->user;
        $roominfo = $this->roominfo;
        $data = array();
        $data['aid'] = !empty($post['aid']) ? intval($post['aid']) : 0;
        if(empty($user['uid']) || empty($roominfo['crid']) || empty($data['aid'])){
            renderjson(1,'参数不完整');
        }
        $data['crid'] = $roominfo['crid'];
        $data['uid'] = $user['uid'];
        $albums = $this->apiServer->reSetting()->setService('Classroom.Albums.delAlbums')->addParams($data)->request();
        if(!empty($albums)){
            renderjson(0,'删除相册成功',$albums);
        }else{
            renderjson(1,'删除相册失败');
        }
    }


    /**
     *上传图片到相册
     */
    public function addphotos(){
        $post = $this->input->post();
        $param = array();
        $user = Ebh::app()->user->getloginuser();
        $roominfo = $this->roominfo;
        if(empty($user['uid']) || empty($roominfo['crid'])){
            renderjson(1,'参数错误');
        }
        $param['crid'] = $roominfo['crid'];
        $param['uid'] = $user['uid'];
        //图片类型大小判断
        if(empty($_FILES)){
            renderJson(1, '无图片上传');
        }
        $upfield = 'upfile';
        if (!isset($_FILES['upfile'])) {
            $upfield = key($_FILES);
        }
        $file = $_FILES[$upfield];
        if (empty($file['size'])) {
            renderJson(1, '无图片上传');
        }
        if ($file['size'] > 1024000) {
            renderJson(1, '图片容量超过上限1M,上传失败');
        }
        $uptypes = array('image/jpg', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/gif', 'image/x-png');//上传文件类型列表
        if (!empty($file['type']) && !in_array($file['type'], $uptypes)) {
            renderJson(1, '上传类型不支持');
        }
        //图片上传服务器
        $data = array('upfield'=>$upfield,'size'=>$file['size']);
        $cfile = curl_file_create(realpath($file['tmp_name']),$file['type'],$file['name']);
        $data[$upfield] = $cfile;
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $server = $_UP['albums']['server'][0];
        $param['aid'] = !empty($post['aid']) ? intval($post['aid']) : 0;
        $url = parse_url($server);
        $param['server'] = !empty($url['host']) ? $url['host'] : 'up.ebh.net';
        $res = do_post($server,$data);
        //清除缓存区数据
        @ob_end_clean();
        //上传服务器后保存图片信息
        if (!empty($res)) {
            $photoinfo = json_decode($res,true);
            if (isset($photoinfo['code']) && ($photoinfo['code'] == 0) && !empty($photoinfo['data'])) {
                $param['photoname'] = !empty($photoinfo['data']['originalName']) ? $photoinfo['data']['originalName'] : '';
                if(!empty($param['photoname'])){
                    $param['photoname'] =  substr($param['photoname'], 0, strrpos($param['photoname'], '.'));
                }
                $param['ext'] = !empty($photoinfo['data']['type']) ? trim($photoinfo['data']['type'],'.') : '';
                $param['size'] = !empty($photoinfo['data']['size']) ? intval($photoinfo['data']['size']) : 0;
                $param['path'] = !empty($photoinfo['data']['url']) ? $photoinfo['data']['url'] : '';
                $param['width'] = !empty($photoinfo['data']['width']) ? intval($photoinfo['data']['width']) : 0;
                $param['height'] = !empty($photoinfo['data']['height']) ? intval($photoinfo['data']['height']) : 0;
            }
            if(empty($param['photoname']) || empty($param['ext']) || empty($param['size']) || empty($param['server']) || empty($param['path']) || empty($param['width']) || empty($param['height'])){
                renderjson(1,'参数不完整');
            }
            $ret = $this->apiServer->reSetting()->setService('Classroom.Albums.addAlbumsPhotos')->addParams($param)->request();
            if (!empty($ret)) {
                renderjson(0, '上传图片成功', $ret);
            } else {
                renderjson(1, '上传图片失败');
            }
        } else {
            renderjson(1, '上传图片到服务器失败');
        }
    }

    /**
     *编辑图片
     */
    public function editphotos(){
        $post = $this->input->post();
        $data = array();
        $user = $this->user;
        $roominfo = $this->roominfo;
        if(empty($user['uid']) || empty($roominfo['crid'])){
            renderjson(1,'参数错误');
        }
        $data['crid'] = $roominfo['crid'];
        $data['uid'] = $user['uid'];
        $data['pid'] = !empty($post['pid']) ? intval($post['pid']) : 0;
        $data['id'] = !empty($post['id']) ? intval($post['id']) : 0;
        $data['photoname'] = !empty($post['photoname']) ? h($post['photoname']) : '';
        if(empty($data['pid']) || empty($data['photoname'])){
            renderjson(1,'参数不完整');
        }
        if (mb_strlen($data['photoname'],"UTF-8") > 50 ) {
            renderjson(1,'图片名字太长');
        }
        $ret = $this->apiServer->reSetting()->setService('Classroom.Albums.editPhotos')->addParams($data)->request();
        if(!empty($ret)){
            renderjson(0,'编辑图片成功',$ret);
        }else{
            renderjson(1,'编辑图片失败');
        }
    }
    /**
     *删除相册中图片
     */
    public function delphotos(){
        $post = $this->input->post();
        $data = array();
        $data['aid'] = !empty($post['aid']) ? intval($post['aid']) : 0;
        $data['pid'] = !empty($post['pid']) ? intval($post['pid']) : 0;
        if(empty($data['pid'])){
            renderjson(1,'参数不完整');
        }
        $albums = $this->apiServer->reSetting()->setService('Classroom.Albums.delAlbumsPhotos')->addParams($data)->request();
        if(!empty($albums)){
            renderjson(0,'删除相册中图片成功',$albums);
        }else{
            renderjson(1,'删除相册中图片失败');
        }
    }

    /**
     * 返回不重复的文件或图片名
     */
    private function fileRename($oldname,$names){
        $Count = 0;
        $newname = $oldname;
        if (!empty($newname) && !empty($names) && is_array($names)) {
            while (true) {
                if (in_array($newname, $names)) {
                    $Count++;
                    $newname = $oldname . '(' . $Count . ')';
                } else {
                    break;
                }
            }
            return $newname;
        }else{
            return $oldname;
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
     *获取图片库图片列表
     */
    public function getgalleryphotos(){
        $user = $this->user;
        if(empty($user['uid'])){
            renderjson(1,'参数错误');
        }
        $data = array();
        $post = $this->input->post();
        if(!empty($post['systype'])){
            $data['systype'] = $post['systype'];//1图片，2图标
            if($data['systype'] == 2){//当图片类型为图标时不分页
                $data['notpage'] = 1;
            }
        }
        if(!empty($post['aid'])){
            $data['aid'] = $post['aid'];
        }
        if(isset($post['q']) && ($post['q'] != null) && ($post['q'] != '')){
            $data['q'] = $post['q'];
        }
        if(!empty($post['page'])){
            $data['page'] = $post['page'];
        }
        if(!empty($post['pagesize'])){
            $data['pagesize'] = $post['pagesize'];
        }
        $photos = $this->apiServer->reSetting()->setService('Classroom.Albums.getGalleryPhotos')->addParams($data)->request();
        $photos = !empty($photos) ? $photos : array();
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $showpath = !empty($_UP['albums']['showpath']) ? $_UP['albums']['showpath'] : 'http://img.ebanhui.com/albums/'; //相册图片展示的配置
        //获取图片宽高
        $picwidth = 173;//首页装扮瀑布流图片默认宽度173
        if(!empty($photos['photos']) && is_array($photos['photos'])){
            foreach ($photos['photos'] as &$photo){
                if(!empty($photo['path'])) {
                    $photo['imgurl'] = $showpath . $photo['path'];
                }
                if(!empty($photo['width']) && !empty($photo['height'])){
                    $photo['picheight'] = floor(($photo['height']*$picwidth)/$photo['width']);
                    $photo['picwidth'] = $picwidth;
                }
            }
        }
        echo json_encode(array('code'=>0,'msg'=>'请求图片信息','data'=>$photos));
    }
    /**
     *获取图片库分类
     */
    public function getgallerys(){
        $data = array();
        $post = $this->input->post();
        $user = $this->user;
        $data['aid'] = !empty($post['aid']) ? intval($post['aid']) : 0;
        if(empty($user['uid'])){
            renderjson(1,'参数错误');
        }
        if(isset($post['q'])){
            $data['q'] = $post['q'];
        }
        if(!empty($post['systype'])){
            $data['systype'] = $post['systype'];
        }
        $data['issystem'] = 1;  //显示系统图片库分类
        $data['ishide'] = 0;    //显示未隐藏的分类
        $gallerys = $this->apiServer->reSetting()->setService('Classroom.Albums.getGallerys')->addParams($data)->request();
        $gallerys = !empty($gallerys) ? $gallerys : array();
        renderjson(0,'请求图片库分类',array('gallerys'=>$gallerys));
    }
}