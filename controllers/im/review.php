<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 11:57
 * 直播回看相关模块
 */
class ReviewController extends CControl{

    public function seturl(){
        header("Content-type: text/html; charset=utf-8");
        $liveLib = Ebh::app()->lib('Netease','Live');
        //只获取合成视频
        //$video = $liveLib->setCallback();
        echo '设置回调地址完成';
        //var_export($video);exit;
        var_export($liveLib->getCallback());
    }

    /**
     *处理课件视频，文档等的预览
     */
    private function doPreview($cwid,$cwurl,$type = "") {
        $ext = strtolower( strrchr( $cwurl , '.' ) );   //.flv
        $previewExt = array('.flv','.avi','.mpeg','.mpg','.mp4','.rmvb','.rm','.mp3','.mov','.doc','.docx','.ppt','.pptx','.xls','.xlsx','.pdf');   //允许预览处理的文件类型
        if(in_array($ext,$previewExt)) {
            //将视频转码请求到对应服务器
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            $up_type = 'attachment';
            $notifyurl = $_UP[$up_type]['notifyv2'];  // /data0/uploads/docs/
            if($type == 'att') {
                $notifyurl = $notifyurl.'?attid='.$cwid;
            } else {
                $notifyurl = $notifyurl.'?cwid='.$cwid;
            }
            $webutil = Ebh::app()->lib('WebUtil');
            $webutil->getfile($notifyurl);
        }
        return true;
    }
    /**
     * 直播回看 处理回调地址（直播结束后2小时执行该操作）
     */
    public function callback(){
        $roominfo = Ebh::app()->room->getcurroom();
        $crid = $roominfo['crid'];
        $cwid = $this->input->get('cwid');
        $liveInfoModel = $this->model('Liveinfo');
        $liveinfo = $liveInfoModel->getLiveInfoByCwid($cwid);
        $livereview = Ebh::app()->getConfig()->load('livereview');
        if(!$liveinfo){
            return false;
        }
        $liveid = $liveinfo['liveid'];

        $liveConfig = Ebh::app()->getConfig()->load('live');

        $rtmpServer = isset($liveConfig[$crid]) ? $liveConfig[$crid] : $liveConfig['default'];


        if($rtmpServer != 'Netease'){
            return false;
        }
        $liveLib = Ebh::app()->lib($rtmpServer,'Live');
        //处理画板信息
        //获取教师画板信息
        $docVideoListResult = $liveLib->getVideoList($liveid.'s');
        //如果获取失败 取消任务
        if(!$docVideoListResult || $docVideoListResult['ret']['totalRecords'] == 0){
            return false;
        }
        $docViedeoList = $docVideoListResult['ret']['videoList'];
        $docViedeoList = array_reverse($docViedeoList);
        //echo "<pre>";
        //var_export($docViedeoList);exit;
        if($docVideoListResult['ret']['totalRecords'] > 1) {
            //如果视频列表大于一个 执行合并视频
            $vidList = array();
            //过滤合成的视频
            foreach ($docViedeoList as $video){
                if(substr($video['video_name'],0,5) != 'merge'){
                    $vidList[] = $video['vid'];
                }
            }
            $liveLib->videoMerge('merge_'.$liveid.'s_'.time(),$vidList);

        }else{
            //否则直接下载视频
            $video = $liveLib->videoInfo($docViedeoList[0]['vid']);
            if(!$video){
                return false;
            }


            //执行下载操作
            $params['file'] = $video['ret']['origUrl'];;
            $params['callback'] = $livereview['download_callback'];
            $params['extra']['cwid'] = $cwid;
            $params['extra']['type'] = 's';
            $this->doRequest($livereview['download_url'],$params);

        }

        //开始处理摄像头信息
        $cameraVideoListResult = $liveLib->getVideoList($liveid.'c');


        //如果获取失败 取消任务
        if(!$cameraVideoListResult || $cameraVideoListResult['ret']['totalRecords'] == 0){
            return false;
        }
        $cameraVideoList = $cameraVideoListResult['ret']['videoList'];
        $cameraVideoList = array_reverse($cameraVideoList);
        //echo "<pre>";
        //var_export($docViedeoList);exit;
        if($cameraVideoListResult['ret']['totalRecords'] > 1) {
            //如果视频列表大于一个 执行合并视频
            $vidList = array();
            //过滤合成的视频
            foreach ($cameraVideoList as $camera){
                if(substr($camera['video_name'],0,5) != 'merge'){
                    $vidList[] = $camera['vid'];
                }
            }
            $liveLib->videoMerge('merge_'.$liveid.'c_'.time(),$vidList);

        }else{
            //否则直接下载视频
            $video = $liveLib->videoInfo($cameraVideoList[0]['vid']);
            if(!$video){
                return false;
            }

            //执行下载操作
            $params['file'] = $video['ret']['origUrl'];;
            $params['callback'] = $livereview['download_callback'];
            $params['extra']['cwid'] = $cwid;
            $params['extra']['type'] = 'c';
            $this->doRequest($livereview['download_url'],$params);

        }
    }
    /**
     * 下载完成回调
     */
    public function download_cb(){

        $sid = $this->input->post('sid');
        if($sid <= 0){
            return;
        }
        $extra = $this->input->post('extra');
        $cwid = intval($extra['cwid']);
        if($cwid <= 0){
            return;
        }
        $sourcemodel = $this->model('Source');
        $source = $sourcemodel->getFileBySid($sid);
        if(empty($source)){
            return;
        }
        if($extra['type'] == 's'){
            //画板处理
            $cwname = $source['filename'];
            $cwsource = $source['source'];
            $cwurl = $source['filepath'];
            $cwsize = $source['filesize'];
            $cwlength = $source['filelength'];
            $ism3u8 = $source['ism3u8'];
            if($ism3u8 == 1){
                $m3u8url = $source['previewurl'];
            }
            $sourceid = $source['sid'];
            $ispreview = $source['ispreview'];
            $apppreview = $source['apppreview'];
            $thumb = $source['thumb'];
            $checksum = $source['checksum'];
            //更新课件信息
            $param['cwname'] = $cwname;
            $param['cwsource'] = $cwsource;
            $param['cwurl'] = $cwurl;
            $param['cwsize'] = $cwsize;
            //$param['cwlength'] = $cwlength;
            $param['ism3u8'] = $ism3u8;
            $param['m3u8url'] = empty($m3u8url)?'':$m3u8url;
            $param['sourceid'] = $sourceid;
            $param['ispreview'] = $ispreview;
            $param['apppreview'] = $apppreview;
            $param['thumb'] = $thumb;
            $param['checksum'] = $checksum;
            $coursemodel = $this->model('Courseware');
            $res = $coursemodel->update($param,array('cwid'=>$cwid));
            if($res){
                //更新直播信息表
                $liveInfoModel = $this->model('Liveinfo');
                $liveInfoModel->addLiveInfo($cwid,array('video_sourceid'=>$sourceid));
                $this->doPreview($cwid,$cwurl);
            }
        }else{
            //教师摄像头视频处理
            $sourceid = $source['sid'];
            $liveInfoModel = $this->model('Liveinfo');
            $liveInfoModel->addLiveInfo($cwid,array('camera_sourceid'=>$sourceid));
            //转码操作
        }

    }

    /**
     * 生成签名
     * @param $data
     * @return mixed
     */
    private function makeSign($data){
        ksort($data);
        $str = http_build_query($data);
        $str.= 'vcloud';
        $str = urldecode($str);

        return md5($str);
    }
    /**
     * 网易回调
     */
    public function netease_cb(){
        /**
         * 对签名进行校验
         */
        $header = getallheaders();
        if(!isset($header['Sign'])){
            return false;
        }
        $sign = $header['Sign'];
        $livereview = Ebh::app()->getConfig()->load('livereview');
        $data = file_get_contents('php://input', 'r');

        $data = json_decode($data,true);

        if($sign != $this->makeSign($data)){
            return false;
        }
        $liveLib = Ebh::app()->lib('Netease','Live');
        $vid = isset($data['vid']) ? $data['vid'] : '';
        $video = $liveLib->videoInfo($vid);
        if(!$video){
            return false;
        }
        //获取视频信息
        $videoName = $video['ret']['videoName'];
        $nameArg = explode('_',$videoName);
        if($nameArg[0] != 'merge'){
            $index = 0;
        }else{
            $index = 1;
        }

        $type = substr($nameArg[$index],-1,1);
        $liveid = substr($nameArg[$index],0,-1);
        $liveInfoModel = $this->model('Liveinfo');
        $liveinfo = $liveInfoModel->getLiveInfoByLiveid($liveid);
        if(!$liveinfo){
            return false;
        }
        if($nameArg[0] != 'merge'){
            //如果不是合成视频回调 直接进行回调入口
            $this->doRequest($livereview['callback'].'?cwid='.$liveinfo['cwid']);
            return false;
        }
        $url = $video['ret']['origUrl'];
        $cwid = $liveinfo['cwid'];

        //执行下载操作
        $params['file'] = $url;
        $params['callback'] = $livereview['download_callback'];
        $params['extra']['cwid'] = $cwid;
        $params['extra']['type'] = $type;

        $this->doRequest($livereview['download_url'],$params);
    }

    private function doRequest($url, $param=array()){
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT,1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($param));
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
    }


}