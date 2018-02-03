<?php

/**
 * Class AppController
 * APP聊天对接控制器
 * 用于APP中直播界面 聊天功能引用
 * 使用方法:将页面中带入的key参数直接传递给本页面即可
 * 例：http://www.ebh.net/im/app.html?key=YWI0MmtQQ1pDeGdRK2hVRXpUeUFONjZLL1YxbE5aemlNYkxseXdsUHIwUml4Ti9LS3FPQnNRWG5IWkFJZktmRFhlQ0RseU1ZMWprZUZJL0lxZmxWcE9OTFc1WStJSDBCRzUrTFJKcmlsMzcyMjhpNGxob0Z2eGNrMFdTVG4zRTh0Zw==
 */
class AppController extends CControl{
    public function index(){
        $input = EBH::app()->getInput();
        $key = $input->get('key');

        $key = base64_decode($key);
        @list($password, $uid,$ip,$time,$cwid) = explode("\t",authcode($key, 'DECODE'));

        //if($user['groupid'])

        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		$notice = $coursemodel->getNotice($cwid);


        $course['notice'] = $notice ? $notice : '';

        $this->assign('course',$course);
        $this->assign('key',$key);
        $this->assign('cwid',$cwid);
        $this->display('im/app');
    }

    /**
     * 直播流检测
     */
    public function stream(){
        $liveid = $this->input->get('liveid');
        if(empty($liveid)){
            $liveid = $this->input->post('liveid');
        }

        if(empty($liveid)){
            renderjson(1,'频道ID必传');
        }
        $liveLib = Ebh::app()->lib('Netease','Live');

        $result = $liveLib->channelstats($liveid);
        $data['stream'] = false;
        if(!$result){
            renderjson(0,'',$data);
        }

        if($result['ret']['status'] == 1 || $result['ret']['status'] == 3){
            $data['stream'] = true;
        }
        renderjson(0,'',$data);

    }
}