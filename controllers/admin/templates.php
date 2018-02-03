<?php
/**
 *模板库管理
*/
class TemplatesController extends AdminControl{
    /**
     *电脑版模板库首页
     */
	public function index(){
        $data = array();
	    $uid = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        if(empty($uid)){
            echo json_encode(array('code'=>1,'msg'=>'参数不正确'));
            return ;
        }
        $data['paid'] = 0;      //模版库主类id
        $data['issystem'] = 2;  //相册类型,0普通相册,1系统相册,2首页装扮模板相册
        $data['clienttype'] = 0;//终端类型：0-电脑版,1-手机版
        $gallerys = $this->apiServer->reSetting()->setService('Classroom.Albums.getGallerys')->addParams($data)->request();
        $gallerys = !empty($gallerys) ? $gallerys : array();        //获取主类信息
        $this->assign('clienttype',$data['clienttype']);
        $this->assign('gallerys',$gallerys);
		$this->display('admin/templates');
	}
    /**
     *手机版模板库首页
     */
    public function mobiletemplates(){
        $data = array();
        $uid = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        if(empty($uid)){
            echo json_encode(array('code'=>1,'msg'=>'参数不正确'));
            return ;
        }
        $data['paid'] = 0;      //模版库主类id
        $data['issystem'] = 2;  //相册类型,0普通相册,1系统相册,2首页装扮模板相册
        $data['clienttype'] = 1;//终端类型：0-电脑版,1-手机版
        $gallerys = $this->apiServer->reSetting()->setService('Classroom.Albums.getGallerys')->addParams($data)->request();
        $gallerys = !empty($gallerys) ? $gallerys : array();        //获取主类信息
        $this->assign('clienttype',$data['clienttype']);
        $this->assign('gallerys',$gallerys);
        $this->display('admin/templates');
    }
    /**
     *模板库分类管理
     */
    public function templatesmanage(){
        $get = $this->input->get();
        $uid = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        $clienttype = isset($get['clienttype']) ? intval($get['clienttype']) : 0;
        if(empty($uid)){
            exit('<script type="text/javascript">top.location.href="/admin.html"</script>');
        }
        $this->assign('clienttype',$clienttype);
        $this->display('admin/templatesmanage');
    }

    /**
     *获取模板库模版信息
     */
    public function gettemplates(){
        $data = array();
        $post = $this->input->post();
        if(!isset($post['clienttype'])){
            renderjson(1,'未指定终端类型');
        }
        $data['issystem'] = 2;//相册类型,0普通相册,1系统相册,2首页装扮模板相册
        if(!empty($post['aid'])){//分类id
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
        if(!empty($post['toplevel']) && ($post['toplevel']==1)){    //toplevel等于1表示查询的是主类信息
            $data['toplevel'] = 1;
        }
        $data['clienttype'] = ($post['clienttype']==1) ? 1 : 0;      //终端类型：0-电脑版,1-手机版

        //获取模板库模版信息
        $photos = $this->apiServer->reSetting()->setService('Classroom.Albums.getGalleryPhotos')->addParams($data)->request();
        $photos = !empty($photos) ? $photos : array();
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $showpath = !empty($_UP['albums']['showpath']) ? $_UP['albums']['showpath'] : 'http://img.ebanhui.com/albums/'; //模版库图片展示的配置
        //组装图片url
        $picheight = 45;//模板库图片默认高度45
        if(!empty($photos['photos']) && is_array($photos['photos'])){
            foreach ($photos['photos'] as &$photo){
                if(!empty($photo['path'])){
					$photo['imgurl'] = $showpath.$photo['path'];
                }
                if(!empty($photo['width']) && !empty($photo['height'])){//等比例缩放图片宽度
                    $photo['picwidth'] = floor(($photo['width']*$picheight)/$photo['height']);
                    $photo['picheight'] = $picheight;
                }
            }
        }
        echo json_encode(array('code'=>0,'msg'=>'请求模版信息','data'=>$photos));
    }
    /**
     *模板库添加模版
     */
    public function addtemplates(){
        $post = $this->input->post();
        $get = $this->input->get();
        $uid = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        if(empty($uid)){
            exit('<script type="text/javascript">top.location.href="/admin.html"</script>');
        }

        if(!empty($post)) {
            $note[] = '确定并关闭';
            if(!isset($post['clienttype'])){
                exit('<script type="text/javascript">top.location.href="/admin.html"</script>');
            }
            if($post['clienttype']==1){
                $rurl[] = '/admin/templates/mobiletemplates.html';
            }else{
                $rurl[] = '/admin/templates.html';
            }
            //获取模板参数
            $param = array();
            $param['roomtype'] = !empty($post['roomtype']) ? h($post['roomtype']) : 'edu';//edu教育版,com企业版
            $param['clienttype'] = ($post['clienttype'] == 1) ? 1 : 0;//终端类型：0-pc端,1-移动端
            $param['uid'] = $uid;
            $param['aid'] = !empty($post['aid']) ? $post['aid'] : 0;//子分类id
            if (empty($param['aid'])) {
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'分类参数错误'));
            }
            if (!empty($post['photoname'])) {
                $param['photoname'] = h($post['photoname']);
                if (mb_strlen($param['photoname'], "UTF-8") > 50) {
                    $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'模版名字太长'));
                }
            }
            $param['issystem'] = 2;         //相册类型,0普通相册,1系统相册,2首页装扮模板相册
            if(isset($post['ishide'])){    //是否隐藏,1表示隐藏
                $param['ishide'] = intval($post['ishide']);
            }

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
            //上传服务器后保存模板信息到网校图片表
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
                    $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'模板参数不完整'));
                }
                $ret = $this->apiServer->reSetting()->setService('Classroom.Albums.addAlbumsPhotos')->addParams($param)->request();
                if (!empty($ret)) {
                    $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'上传模板成功'));
                } else {
                    $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'上传模板失败'));
                }
            } else {
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'上传模板到服务器失败'));
            }
        }else{
            $clienttype = (!empty($get['clienttype']) && ($get['clienttype']==1)) ? 1 : 0;      //终端类型：0-电脑版,1-手机版
            $this->assign('clienttype',$clienttype);
            $this->display('admin/templates_add');
        }
    }
    /**
     *编辑图片
     */
    public function edittemplates(){
        $post = $this->input->post();
        $get = $this->input->get();
        $uid = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        if(empty($uid)){
            exit('<script type="text/javascript">top.location.href="/admin.html"</script>');
        }
        $note[] = '确定并关闭';
        if((isset($get['clienttype']) && ($get['clienttype']==1)) || (isset($post['clienttype']) && ($post['clienttype']==1))){
            $rurl[] = '/admin/templates/mobiletemplates.html';
        }else{
            $rurl[] = '/admin/templates.html';
        }
        if(!empty($post)) {
            $data = array();
            $data['pid'] = !empty($post['pid']) ? intval($post['pid']) : 0;
            if (empty($data['pid'])) {
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'模版参数错误'));
            }
            if (!empty($post['oldaid'])) {//原模版子分类id
                $data['oldaid'] = intval($post['oldaid']);
            }
            if (!empty($post['newaid'])) {  //新模版子分类id
                $data['newaid'] = intval($post['newaid']);
            }
            if(isset($post['ishide'])){     //是否隐藏,1表示隐藏
                $data['ishide'] = intval($post['ishide']);
            }
            $data['issystem'] = 2;           //相册类型,0普通相册,1系统相册,2首页装扮模板相册
            if (!empty($post['photoname'])) {
                $data['photoname'] = h($post['photoname']);
                if (mb_strlen($data['photoname'], "UTF-8") > 50) {
                    $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'模版名字太长'));
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
            $photodetail = array();//模版图片详情
            $gallerysuse = array();//模板类别
            if (empty($get['pid'])) {
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'参数错误'));
            }
            $data['issystem'] = 2;//相册类型,0普通相册,1系统相册,2首页装扮模板相册
            $data['clienttype'] = (isset($get['clienttype']) && $get['clienttype']==1) ? 1 : 0;      //终端类型：0-电脑版,1-手机版
            //获取模版分类信息
            $gallerys = $this->apiServer->reSetting()->setService('Classroom.Albums.getGallerys')->addParams($data)->request();

            //获取当前模版图片信息
            $data['pid'] = intval($get['pid']);
            $photodetail = $this->apiServer->reSetting()->setService('Classroom.Albums.getPhotosByPid')->addParams($data)->request();

            //组装模版分类信息
            foreach ($gallerys as $gallery){
                if(($photodetail['paid'] == $gallery['aid']) && !empty($gallery['children'])){
                    $gallerysuse['child'] = $gallery['children'];
                }
                unset($gallery['children']);
                $gallerysuse['top'][] = $gallery;
            }
            $this->assign('clienttype', $data['clienttype']);
            $this->assign('gallerysuse', $gallerysuse);
            $this->assign('photodetail', $photodetail);
            $this->display('admin/templates_edit');
        }
    }
    /**
     *设置精选模版
     */
    public function toptemplates(){
        $post = $this->input->post();
        $data = array();
        $data['pid'] = !empty($post['pid']) ? intval($post['pid']) : 0;
        if(empty($data['pid'])){
            renderjson(1,'模版参数错误');
        }
        if(isset($post['istop']) && in_array($post['istop'],array(0,1))){//是否设置为精选模版
            $data['istop'] = $post['istop'];
        }else{
            renderjson(1,'参数不完整');
        }
        $ret = $this->apiServer->reSetting()->setService('Classroom.Albums.editGalleryPhotos')->addParams($data)->request();
        if(!empty($ret)){
            if($data['istop'] == 1){
                renderjson(0,'设为精选模版成功');
            }else{
                renderjson(0,'取消精选模版成功');
            }
        }else{
            renderjson(1,'操作失败');
        }
    }
    /**
     *删除模板库中模板
     */
    public function deltemplates(){
        $post = $this->input->post();
        $data = array();
        $data['pids'] = !empty($post['pids']) ? $post['pids'] : 0;//模版id集
        if(empty($data['pids'])){
            renderjson(1,'参数不完整');
        }
        foreach ($data['pids'] as $pid) {
            if (!is_numeric($pid)) {
                renderjson(1,'参数错误');
            }
        }
        $data['issystem'] = 2;           //相册类型,0普通相册,1系统相册,2首页装扮模板相册
        $ret = $this->apiServer->reSetting()->setService('Classroom.Albums.delGalleryPhotos')->addParams($data)->request();
        if(!empty($ret)){
            renderjson(0,'删除模版成功',$ret,false);
        }else{
            renderjson(1,'删除模版失败');
        }
    }
    /**
     *上传图片到相册
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
     *获取模板库分类
     */
    public function gettemplatesclass(){
        $data = array();
        $post = $this->input->post();
        $user = $this->user;
        if(empty($user['uid']) || !isset($post['clienttype'])){
            renderjson(1,'参数错误');
        }
        if(isset($post['paid'])){
            $data['paid'] = intval($post['paid']);
        }
        if(isset($post['q'])){
            $data['q'] = h($post['q']);
        }
        $data['clienttype'] = ($post['clienttype']==1) ? 1 : 0;      //终端类型：0-电脑版,1-手机版
        $data['issystem'] = 2;//相册类型,0普通相册,1系统相册,2首页装扮模板相册
        $gallerys = $this->apiServer->reSetting()->setService('Classroom.Albums.getGallerys')->addParams($data)->request();
        renderjson(0,'请求模板库分类',$gallerys);
    }
    /**
     *创建新模板库分类
     */
    public function addtemplatesclass(){
        $get = $this->input->get();
        $post = $this->input->post();
        $uid = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        if(empty($uid) && (!isset($post['clienttype']) || !isset($get['clienttype']))){
            exit('<script type="text/javascript">top.location.href="/admin.html"</script>');
        }
        //添加模板库分类
        if(!empty($post)){
            if(!isset($post['clienttype'])){
                exit('<script type="text/javascript">top.location.href="/admin.html"</script>');
            }
            $clienttype = ($post['clienttype']==1) ? 1 : 0;      //终端类型：0-电脑版,1-手机版
            $note[] = '确定并关闭';
            $rurl[] = '/admin/templates/templatesmanage.html?clienttype='.$clienttype;
            $data = array();
            $data['clienttype'] = $clienttype;
            $data['aid'] = !empty($post['aid']) ? intval($post['aid']) : 0;
            $data['uid'] = $uid;
            $data['alname'] = !empty($post['alname']) ? h($post['alname']) : '新建分类';
            $data['issystem'] = 2;          //相册类型,0普通相册,1系统相册,2首页装扮模板相册
            if(isset($post['ishide'])){    //是否隐藏分类,1表示隐藏
                $data['ishide'] = intval($post['ishide']);
            }

            //处理同名分类
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
            $clienttype = (!empty($get['clienttype']) && ($get['clienttype']==1)) ? 1 : 0;      //终端类型：0-电脑版,1-手机版
            $this->assign('clienttype',$clienttype);
            $this->display('admin/templatesclass_add');
        }
    }
    /**
     *编辑模板库分类
     */
    public function edittemplatesclass(){
        $post = $this->input->post();
        $get = $this->input->get();
        $uid = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        if(empty($uid)){
            exit('<script type="text/javascript">top.location.href="/admin.html"</script>');
        }
        if(!empty($post)) {
            $note[] = '确定并关闭';
            $clienttype = ($post['clienttype']==1) ? 1 : 0;      //终端类型：0-电脑版,1-手机版
            $rurl[] = '/admin/templates/templatesmanage.html?clienttype='.$clienttype;
            $data = array();
            $data['uid'] = $uid;
            $data['aid'] = !empty($post['aid']) ? intval($post['aid']) : 0;
            if(empty($data['aid'])){
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'模版库分类参数不完整'));
            }

            if (!empty($post['alname'])) {
                $data['alname'] = h($post['alname']);
            }
            if (mb_strlen($data['alname'], "UTF-8") > 50) {
                $this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'模板库分类名字太长'));
            }
            //获取当前模版分类信息
            $templatesdetail = $this->apiServer->reSetting()->setService('Classroom.Albums.getGalleryByAid')->addParams(array('aid'=>$data['aid'],'issystem'=>2))->request();
            if (isset($post['paid']) && isset($templatesdetail['paid']) && ($templatesdetail['paid'] !=0)) {         //禁止将模版库主类移动到其他主类下
                $data['paid'] = intval($post['paid']);
            }
            if (isset($post['ishide'])) {       //是否隐藏分类,1表示隐藏
                $data['ishide'] = intval($post['ishide']);
            }
            if (isset($post['displayorder'])) {//排序
                $data['displayorder'] = intval($post['displayorder']);
            }
            //编辑模版库分类
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
                $data['issystem'] = 2;//相册类型,0普通相册,1系统相册,2首页装扮模板相册
                $data['clienttype'] = (isset($get['clienttype']) && $get['clienttype']==1) ? 1 : 0;      //终端类型：0-电脑版,1-手机版
                //获取主类信息
                $data['paid'] = 0;
                $gallerys = $this->apiServer->reSetting()->setService('Classroom.Albums.getGallerys')->addParams($data)->request();

                //获取当前分类详情
                $data['aid'] = intval($get['aid']);
                $gallerydetail = $this->apiServer->reSetting()->setService('Classroom.Albums.getGalleryByAid')->addParams($data)->request();
                $this->assign('clienttype',$data['clienttype']);
                $this->assign('gallerys', $gallerys);
                $this->assign('gallerydetail', $gallerydetail);
                $this->display('admin/templatesclass_edit');
            }
        }
    }
    /**
     *删除模板库分类
     */
    public function deltemplatesclass(){
        $post = $this->input->post();
        $user = $this->user;
        $data = array();
        $data['paid'] = !empty($post['paid']) ? intval($post['paid']) : 0;  //主类id
        $data['aid'] = !empty($post['aid']) ? intval($post['aid']) : 0;     //子类id
        if(empty($user['uid']) || empty($data['aid']) || !isset($post['clienttype'])){
            renderjson(1,'参数错误');
        }
        //查询当前分类下是否有子类
        $clienttype = intval($post['clienttype']);
        $gallerys = $this->apiServer->reSetting()->setService('Classroom.Albums.getGallerys')->addParams(array('paid'=>$data['aid'],'issystem'=>2,'clienttype'=>$clienttype))->request();
        if(($gallerys !== false) && is_array($gallerys)){
            renderjson(1,'存在子类无法直接删除');
        }
        $data['uid'] = $user['uid'];
        $albums = $this->apiServer->reSetting()->setService('Classroom.Albums.delAlbums')->addParams($data)->request();
        if(!empty($albums)){
            renderjson(0,'删除模板库分类成功',$albums);
        }else{
            renderjson(1,'删除模板库分类失败');
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