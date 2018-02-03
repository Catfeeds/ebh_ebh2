<?php
/**
 *图片库管理
*/
class GalleryController extends AdminControl{
    /**
     *图片库首页
     */
	public function index(){
        $data = array();
	    $uid = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        if(empty($uid)){
            echo json_encode(array('code'=>1,'msg'=>'参数不正确'));
            return ;
        }
        $data['paid'] = 0;
        $gallerys = $this->apiServer->reSetting()->setService('Classroom.Albums.getGallerys')->addParams($data)->request();
        $gallerys = !empty($gallerys) ? $gallerys : array();
		$this->assign('gallerys',$gallerys);
		$this->display('admin/galleryphotos');
	}
    /**
     *图片库分类管理
     */
    public function gallerymanage(){
        $uid = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        if(empty($uid)){
            echo json_encode(array('code'=>1,'msg'=>'参数不正确'));
            return ;
        }
        $this->display('admin/gallerymanage');
    }

    /**
     *获取图片库图片
     */
    public function getphotos(){
        $data = array();
        $post = $this->input->post();
        if(!empty($post['systype'])){
            $data['systype'] = intval($post['systype']);
        }
        if(!empty($post['aid'])){
            $data['aid'] = intval($post['aid']);
        }
        if(isset($post['q']) && ($post['q'] != null) && ($post['q'] != '')){
            $data['q'] = h($post['q']);
        }
        if(!empty($post['page'])){
            $data['page'] = intval($post['page']);
        }
        if(!empty($post['pagesize'])){
            $data['pagesize'] = intval($post['pagesize']);
        }
        $photos = $this->apiServer->reSetting()->setService('Classroom.Albums.getGalleryPhotos')->addParams($data)->request();
        $photos = !empty($photos) ? $photos : array();
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $showpath = !empty($_UP['albums']['showpath']) ? $_UP['albums']['showpath'] : 'http://img.ebanhui.com/albums/'; //相册图片展示的配置
        if(!empty($photos['photos']) && is_array($photos['photos'])){
            foreach ($photos['photos'] as &$photo){
                if(!empty($photo['path'])){
                    $photo['imgurl'] = $showpath.$photo['path'];
                }
            }
        }
        echo json_encode(array('code'=>0,'msg'=>'请求图片信息','data'=>$photos));
    }
    /**
     *图片库添加图片
     */
    public function addgalleryphotos(){
        $post = $this->input->post();
        $note[] = '确定并关闭';
        $rurl[] = '/admin/gallery.html';
        $uid = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        if(empty($uid)){
            $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'参数错误'));
        }
        if(!empty($post)) {
            $param = array();
            $param['uid'] = $uid;
            $param['aid'] = !empty($post['aid']) ? $post['aid'] : 0;
            if (empty($param['aid'])) {
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'参数错误'));
            }
            if (!empty($post['photoname'])) {
                $param['photoname'] = h($post['photoname']);
                if (mb_strlen($param['photoname'], "UTF-8") > 50) {
                    $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'图片名字太长'));
                }
            }
            $param['issystem'] = 1;
            //图片上传服务器
            $res = $this->addphotos();
            if(isset($res['code']) && ($res['code']==1)){
                $message = !empty($res['msg']) ? $res['msg'] : '上传图片失败';
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>$message));
            }
            //获取图片上传的服务器配置信息
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            $server = $_UP['albums']['server'][0];
            $url = parse_url($server);
            $param['server'] = !empty($url['host']) ? $url['host'] : 'up.ebh.net';
            //上传服务器后保存图片信息
            if (!empty($res['data'])) {
                $photoinfo = json_decode($res['data'],true);
                if (isset($photoinfo['code']) && ($photoinfo['code'] == 0) && !empty($photoinfo['data'])) {
                    $originalName = !empty($photoinfo['data']['originalName']) ? $photoinfo['data']['originalName'] : '';
                    if(!empty($originalName)){
                        $originalName =  substr($originalName, 0, strrpos($originalName, '.'));
                    }
                    $param['photoname'] = !empty($param['photoname']) ? $param['photoname'] : $originalName;
                    $param['ext'] = !empty($photoinfo['data']['type']) ? trim($photoinfo['data']['type'],'.') : '';
                    $param['size'] = !empty($photoinfo['data']['size']) ? intval($photoinfo['data']['size']) : 0;
                    $param['path'] = !empty($photoinfo['data']['url']) ? $photoinfo['data']['url'] : '';
                    $param['width'] = !empty($photoinfo['data']['width']) ? intval($photoinfo['data']['width']) : 0;
                    $param['height'] = !empty($photoinfo['data']['height']) ? intval($photoinfo['data']['height']) : 0;
                }
                if(empty($param['photoname']) || empty($param['ext']) || empty($param['server']) || empty($param['path']) || empty($param['size']) || empty($param['width']) || empty($param['height'])){
                    $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'图片参数不完整'));
                }
                $ret = $this->apiServer->reSetting()->setService('Classroom.Albums.addAlbumsPhotos')->addParams($param)->request();
                if (!empty($ret)) {
                    $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'上传图片成功'));
                } else {
                    $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'上传图片失败'));
                }
            } else {
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'上传图片到服务器失败'));
            }
        }else{
            $data = array();
            $gallerys = array();
            $data['issystem'] = 1;
            $data['paid'] = 0;
            $gallerys = $this->apiServer->reSetting()->setService('Classroom.Albums.getGallerys')->addParams($data)->request();
            $this->assign('gallerys', $gallerys);
            $this->display('admin/galleryphotos_add');
        }
    }
    /**
     *编辑图片
     */
    public function editphotos(){
        $post = $this->input->post();
        $get = $this->input->get();
        $note[] = '确定并关闭';
        $rurl[] = '/admin/gallery.html';
        $uid = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        if(empty($uid)){
            $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'参数错误'));
        }
        if(!empty($post)) {
            $data = array();
            $data['pid'] = !empty($post['pid']) ? intval($post['pid']) : 0;
            if (empty($data['pid'])) {
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'参数错误'));
            }
            if (!empty($post['oldaid'])) {
                $data['oldaid'] = intval($post['oldaid']);
            }
            if (!empty($post['newaid'])) {
                $data['newaid'] = intval($post['newaid']);
            }
            if (!empty($post['photoname'])) {
                $data['photoname'] = h($post['photoname']);
                if (mb_strlen($data['photoname'], "UTF-8") > 50) {
                    $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'图片名字太长'));
                }
            }
            if(!empty($_FILES)){
                //图片类型大小判断
                $file = $_FILES['uploadfile'];
                if (isset($file['error']) && ($file['error']==0)) {
                    $res = $this->addphotos();
                    if(isset($res['code']) && ($res['code']==1)){
                        $message = !empty($res['msg']) ? $res['msg'] : '上传图片失败';
                        $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>$message));
                    }
                    //图片上传服务器
                    $_UP = Ebh::app()->getConfig()->load('upconfig');
                    $server = $_UP['albums']['server'][0];
                    $url = parse_url($server);
                    $data['server'] = !empty($url['host']) ? $url['host'] : 'up.ebh.net';
                    //上传服务器后保存图片信息
                    if (!empty($res['data'])) {
                        $photoinfo = json_decode($res['data'], true);
                        if (isset($photoinfo['code']) && ($photoinfo['code'] == 0) && !empty($photoinfo['data'])) {
                            $originalName = !empty($photoinfo['data']['originalName']) ? $photoinfo['data']['originalName'] : '';
                            if (!empty($originalName)) {
                                $originalName = substr($originalName, 0, strrpos($originalName, '.'));
                            }
                            $data['photoname'] = !empty($data['photoname']) ? $data['photoname'] : $originalName;
                            $data['ext'] = !empty($photoinfo['data']['type']) ? trim($photoinfo['data']['type'], '.') : '';
                            $data['size'] = !empty($photoinfo['data']['size']) ? intval($photoinfo['data']['size']) : 0;
                            $data['path'] = !empty($photoinfo['data']['url']) ? $photoinfo['data']['url'] : '';
                            $data['width'] = !empty($photoinfo['data']['width']) ? intval($photoinfo['data']['width']) : 0;
                            $data['height'] = !empty($photoinfo['data']['height']) ? intval($photoinfo['data']['height']) : 0;
                        }
                        if (empty($data['photoname']) || empty($data['ext']) || empty($data['size']) || empty($data['server']) || empty($data['path']) || empty($data['width']) || empty($data['height'])) {
                            $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'参数不完整'));
                        }
                    }
                }
            }
            $ret = $this->apiServer->reSetting()->setService('Classroom.Albums.editGalleryPhotos')->addParams($data)->request();
            if (!empty($ret)) {
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'操作成功'));
            } else {
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'操作失败'));
            }
        }else{
            $data = array();
            $gallerys = array();
            $photodetail = array();
            if (empty($get['pid'])) {
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'参数错误'));
            }
            $data['paid'] = 0;
            $data['issystem'] = 1;
            $gallerys = $this->apiServer->reSetting()->setService('Classroom.Albums.getGallerys')->addParams($data)->request();
            $data['pid'] = intval($get['pid']);
            $photodetail = $this->apiServer->reSetting()->setService('Classroom.Albums.getPhotosByPid')->addParams($data)->request();
            $this->assign('gallerys', $gallerys);
            $this->assign('photodetail', $photodetail);
            $this->display('admin/galleryphotos_edit');
        }
    }
    /**
     *置顶图片
     */
    public function topphotos(){
        $post = $this->input->post();
        $data = array();
        $data['pid'] = !empty($post['pid']) ? intval($post['pid']) : 0;
        if(empty($data['pid'])){
            renderjson(1,'参数错误');
        }
        if(isset($post['istop']) && in_array($post['istop'],array(0,1))){
            $data['istop'] = $post['istop'];
        }else{
            renderjson(1,'参数不完整');
        }
        $ret = $this->apiServer->reSetting()->setService('Classroom.Albums.editGalleryPhotos')->addParams($data)->request();
        if(!empty($ret)){
            if($data['istop'] == 1){
                renderjson(0,'置顶图片成功');
            }else{
                renderjson(0,'取消置顶成功');
            }
        }else{
            renderjson(1,'操作失败');
        }
    }
    /**
     *删除图片库中图片
     */
    public function delphotos(){
        $post = $this->input->post();
        $data = array();
        $data['pids'] = !empty($post['pids']) ? $post['pids'] : 0;
        if(empty($data['pids'])){
            renderjson(1,'参数不完整');
        }
        foreach ($data['pids'] as $pid) {
            if (!is_numeric($pid)) {
                renderjson(1,'参数错误');
            }
        }
        $ret = $this->apiServer->reSetting()->setService('Classroom.Albums.delGalleryPhotos')->addParams($data)->request();
        if(!empty($ret)){
            renderjson(0,'删除图片成功',$ret,false);
        }else{
            renderjson(1,'删除图片失败');
        }
    }
    /**
     *上传图片到图片库
     */
    private function addphotos(){
        //图片类型大小判断
        if(empty($_FILES)){
            return array('code'=>1,'msg'=>'无图片上传');
        }
        $upfield = 'upfile';
        if (!isset($_FILES['upfile'])) {
            $upfield = key($_FILES);
        }
        $file = $_FILES[$upfield];
        if (empty($file['size'])) {
            return array('code'=>1,'msg'=>'无图片上传');
        }
        if ($file['size'] > 5120000) {
            return array('code'=>1,'msg'=>'图片大小超过上限5M,上传失败');
        }
        $uptypes = array('image/jpg', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/gif', 'image/x-png');//上传文件类型列表
        if (!empty($file['type']) && !in_array($file['type'], $uptypes)) {
            return array('code'=>1,'msg'=>'上传类型不支持');
        }
        //图片上传服务器
        $data = array('upfield'=>$upfield,'size'=>$file['size']);
        $cfile = curl_file_create(realpath($file['tmp_name']),$file['type'],$file['name']);
        $data[$upfield] = $cfile;
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $server = $_UP['albums']['server'][0];
        $res = do_post($server,$data);
        //清除缓存区数据
        @ob_end_clean();
        return array('code'=>0,'msg'=>'图片上传成功','data'=>$res);
    }

    /**
     *获取图片库分类
     */
    public function getgallerys(){
        $data = array();
        $post = $this->input->post();
        $user = $this->user;
        if(empty($user['uid'])){
            renderjson(1,'参数错误');
        }
        if(isset($post['paid'])){
            $data['paid'] = intval($post['paid']);
        }
        if(isset($post['q'])){
            $data['q'] = h($post['q']);
        }
        if(!empty($post['systype'])){
            $data['systype'] = intval($post['systype']);
        }
        $data['issystem'] = 1;
        $gallerys = $this->apiServer->reSetting()->setService('Classroom.Albums.getGallerys')->addParams($data)->request();
        renderjson(0,'请求图片库分类',$gallerys);
    }
    /**
     *创建新图片库分类
     */
    public function addgallerys(){
        $post = $this->input->post();
        $note[] = '确定并关闭';
        $rurl[] = '/admin/gallery/gallerymanage.html';
        $uid = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        if(empty($uid)){
            $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'参数不完整'));
        }
        if(!empty($post)){
            $data = array();
            $data['systype'] = !empty($post['systype']) ? intval($post['systype']) : 0;
            $data['aid'] = !empty($post['aid']) ? intval($post['aid']) : 0;
            if(empty($data['aid']) || empty($data['systype'])){
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'参数不完整'));
            }
            $data['uid'] = $uid;
            $data['alname'] = !empty($post['alname']) ? h($post['alname']) : '新建分类';
            $data['issystem'] = 1;
            if(isset($post['ishide'])){
                $data['ishide'] = intval($post['ishide']);
            }
            //处理同名文件
            $albums = $this->apiServer->reSetting()->setService('Classroom.Albums.getGallerys')->addParams($data)->request();
            if(!empty($albums)){
                $namearr = array_column($albums,'alname');
                if(!empty($namearr)){
                    $data['alname'] = $this->fileRename($data['alname'],$namearr);
                }
            }
            if(isset($post['displayorder'])){
                $data['displayorder'] = intval($post['displayorder']);
            }
            //保存到数据库
            if(!empty($data)){
                $albums = $this->apiServer->reSetting()->setService('Classroom.Albums.addAlbums')->addParams($data)->request();
                if(!empty($albums)){
                    $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'操作成功'));
                }
            }else{
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'操作失败'));
            }
        }else{
            $data = array();
            $gallerys = array();
            $data['issystem'] = 1;
            $data['paid'] = 0;
            $gallerys = $this->apiServer->reSetting()->setService('Classroom.Albums.getGallerys')->addParams($data)->request();
            $this->assign('gallerys',$gallerys);
            $this->display('admin/gallery_add');
        }
    }
    /**
     *编辑图片库分类
     */
    public function editgallerys(){
        $post = $this->input->post();
        $get = $this->input->get();
        $note[] = '确定并关闭';
        $rurl[] = '/admin/gallery/gallerymanage.html';
        $uid = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        if(empty($uid)){
            $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'参数不完整'));
        }
        if(!empty($post)) {
            $data = array();
            $data['uid'] = $uid;
            $data['aid'] = !empty($post['aid']) ? intval($post['aid']) : '';
            $data['systype'] = !empty($post['systype']) ? intval($post['systype']) : '';
            if(empty($data['aid']) || empty($data['systype'])){
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'参数不完整'));
            }
            if (!empty($post['alname'])) {
                $data['alname'] = h($post['alname']);
            }
            if (mb_strlen($data['alname'], "UTF-8") > 50) {
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'图片库分类名字太长'));
            }
            if (isset($post['paid'])) {
                $data['paid'] = intval($post['paid']);
            }
            if (isset($post['ishide'])) {
                $data['ishide'] = intval($post['ishide']);
            }
            if (isset($post['displayorder'])) {
                $data['displayorder'] = intval($post['displayorder']);
            }
            $albums = $this->apiServer->reSetting()->setService('Classroom.Albums.editAlbums')->addParams($data)->request();
            if (!empty($albums)) {
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'操作成功'));
            } else {
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'操作失败'));
            }
        }else {
            if (!empty($get['aid'])) {
                $data = array();
                $gallerys = array();
                $gallerydetail = array();
                $data['issystem'] = 1;
                $data['paid'] = 0;
                $gallerys = $this->apiServer->reSetting()->setService('Classroom.Albums.getGallerys')->addParams($data)->request();
                $data['aid'] = intval($get['aid']);
                $gallerydetail = $this->apiServer->reSetting()->setService('Classroom.Albums.getGalleryByAid')->addParams($data)->request();
                $this->assign('gallerys', $gallerys);
                $this->assign('gallerydetail', $gallerydetail);
                $this->display('admin/gallery_edit');
            }
        }
    }
    /**
     *删除图片库分类
     */
    public function delgallerys(){
        $post = $this->input->post();
        $user = $this->user;
        $data = array();
        $data['paid'] = !empty($post['paid']) ? intval($post['paid']) : 0;
        $data['aid'] = !empty($post['aid']) ? intval($post['aid']) : 0;
        if(empty($user['uid']) || empty($data['paid']) || empty($data['aid'])){
            renderjson(1,'参数错误');
        }
        $data['uid'] = $user['uid'];
        $albums = $this->apiServer->reSetting()->setService('Classroom.Albums.delAlbums')->addParams($data)->request();
        if(!empty($albums)){
            renderjson(0,'删除图片库分类成功',$albums);
        }else{
            renderjson(1,'删除图片库分类失败');
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

}