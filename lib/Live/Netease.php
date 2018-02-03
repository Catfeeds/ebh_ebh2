<?php
require_once "LiveBase.php";

/**
 * 网易类
 * Class Netease
 */
class Netease extends  LiveBase{


    private $url = array(

    );


    /**
     * 创建一个liveId
     * @param $submitat
     * @param $cwlength
     * @return string
     */
    public function createLive($submitat,$cwlength){
        $endtime = $submitat + $cwlength;
        $nowtime = time();
        $array = str_split($endtime,1);
        $rndArray = array_rand($array,5);
        $rndStr = implode($rndArray,'');
        $liveid =  $nowtime.$rndStr;
        //开始向服务器请求数据
        $data = array(
            'name'=>$liveid,
            'type'=>0,
            'userCid'=>$liveid
        );
        $result = $this->doRequest('https://vcloud.163.com/app/channel/create',$data);
        //创建教师画板和教师摄像头频道



        if($result['code'] != 200){
            $this->setErr($result['msg']);
            return false;
        }

        $ret = array(
            'liveid'    =>  $liveid,
            'httpPullUrl'   =>  str_replace($liveid, '[liveid]', $result['ret']['httpPullUrl']),
            'hlsPullUrl'    =>  str_replace($liveid, '[liveid]', $result['ret']['hlsPullUrl']),
            'rtmpPullUrl'   =>  str_replace($liveid, '[liveid]', $result['ret']['rtmpPullUrl']),
            'pushUrl'       =>  str_replace($liveid, '[liveid]', $result['ret']['pushUrl']),
        );

        //创建老师画板频道
        $data = array(
            'name'=>$liveid.'s',
            'type'=>0,
            'userCid'=>$liveid.'s'
        );
        $result = $this->doRequest('https://vcloud.163.com/app/channel/create',$data);
        if($result['code'] != 200){
            $this->setErr($result['msg']);
            return false;
        }
        //设置录制状态
        $this->doRequest('https://vcloud.163.com/app/channel/setAlwaysRecord',array(
            'cid'   =>  $liveid.'s',
            'needRecord'    =>  1,
            'format'    =>  0,
            'duration'  =>  120
        ));

        //创建老师摄像头频道
        $data = array(
            'name'=>$liveid.'c',
            'type'=>0,
            'userCid'=>$liveid.'c'
        );
        $result = $this->doRequest('https://vcloud.163.com/app/channel/create',$data);
        if($result['code'] != 200){
            $this->setErr($result['msg']);
            return false;
        }
        //设置录制状态
        $this->doRequest('https://vcloud.163.com/app/channel/setAlwaysRecord',array(
            'cid'   =>  $liveid.'c',
            'needRecord'    =>  1,
            'format'    =>  0,
            'duration'  =>  120
        ));
        return $ret;
    }


    /**
     * 设置回调地址
     */
    public function setCallback(){
        $livereview = Ebh::app()->getConfig()->load('livereview');
        $data['recordClk'] = $livereview['netease_callback'];
        $result = $this->doRequest('https://vcloud.163.com/app/record/setcallback',$data);
        if($result['code'] != 200){
            return false;
        }
        return true;
    }

    /**
     * 获取当前回调地址
     * @return bool
     */
    public function getCallback(){
        $result = $this->doRequest('https://vcloud.163.com/app/record/callbackQuery',array());

        if($result['code'] != 200){
            return false;
        }
        return $result['ret'];
    }

    /**
     * 获取视频列表
     * @param $cid
     */
    public function getVideoList($cid){
        $data['cid'] = $cid;
        $data['records'] = 1000;
        $result = $this->doRequest('https://vcloud.163.com/app/videolist',$data);
        if($result['code'] != 200){
            return false;
        }
        return $result;
    }

    /**
     * 视频合并
     */
    public function videoMerge($outputName,$vidList){
        $data['outputName'] = $outputName;
        $data['vidList'] = $vidList;
        $result = $this->doRequest('https://vcloud.163.com/app/video/merge',$data);
        if($result['code'] != 200){
            log_message('视频合并任务创建失败'.$outputName.';code:'.$result['code'].';msg:'.$result['msg']);
            return false;
        }
        return true;
    }

    /**
     * 获取视频文件信息
     * @param $vid
     */
    public function videoInfo($vid){
        $data['vid'] = $vid;
        $result = $this->doRequest('https://vcloud.163.com/app/vod/video/get',$data);
        if($result['code'] != 200){
            return false;
        }
        return $result;
    }

    /**
     * 获取频道状态
     */
    public function channelstats($cid){
        $data['cid'] = $cid;
        $result = $this->doRequest('https://vcloud.163.com/app/channelstats',$data);

        if($result['code'] != 200){
            return false;
        }
        return $result;
    }

    /**
     * 向服务器发送数据
     * @param $url
     * @param $data
     */
    public function doRequest($url,$data){
        $Nonce = mt_rand(0,1000);
        $CurTime = time();
        $CheckSum = sha1($this->config['AppSecret'].$Nonce.$CurTime);
        $header = array(
            'AppKey'=>$this->config['AppKey'],
            'Nonce'=>$Nonce,
            'CurTime'=>$CurTime,
            'CheckSum'=>$CheckSum
        );

        return $this->doPostJson($url,$data,$header);
    }
}