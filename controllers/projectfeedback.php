<?php

/**
 * 产品反馈
 * Class ProjectfeedbackController
 */
class ProjectfeedbackController extends CControl{

    const ONE_DAY_FEEDBACK_COUNT = 10;    //一个用户每日最多反馈次数

    /**
     * 反馈添加
     */
    public function add(){
        $user = Ebh::app()->user->getloginuser();
        $post = $this->input->post();
        $projectfbmodel = $this->model('Projectfeedback');
        if(empty($user)){
            echo '未登录,不能执行该操作';
            exit;
        }
        if(empty($post['feedback']) || mb_strlen($post['feedback'], 'utf8') > 500){
            echo json_encode(array('msg' => 'false'));
            return;
        }
        $param['uid'] = $user['uid'];
        $t = time();
        $param['dateline'] = $t;

        $redis = Ebh::app()->getCache('cache_redis');
        $userlimitkey = 'VC_USER_LIMIT_'.$user['uid'];
        // 邮箱限制
        $sendCnt = $redis->zScore($userlimitkey, $user['uid']);
        if($sendCnt && $sendCnt >= self::ONE_DAY_FEEDBACK_COUNT) {
            $message = array(
                'msg' => 'false',
                'reason' => 'toooften'
            );
            echo json_encode($message);
            return;
        }

        $email = $post['email'];
        if(!empty($email)){
            if(is_numeric($email)){
                $email = intval($email);
                $match = preg_match("/^[1-9][0-9]{5,11}$/", $email);
//                var_dump($match);
                if(!$match){
                    $email = FALSE;
                }
            }else{
                $email = filter_var($email,FILTER_VALIDATE_EMAIL);
            }
            if($email !== FALSE){
                $param['email'] = $email;
            }
        }
        $param['loginip'] = getip();
        $param['feedback'] = strip_tags($post['feedback']);
        $roominfo = Ebh::app()->room->getcurroom();
        $param['schoolname'] = $roominfo['crname'];
        if(is_numeric($user['groupid'])){
            $param['urole'] = intval($user['groupid']);
        }
        $room = Ebh::app()->room->getcurroom();
        if($param['urole'] == 5 && $room['uid'] == $user['uid']){
            $param['urole'] = 1;
        }
        $result = $projectfbmodel->add($param);
        if($result !== FALSE){
            //发送成功 设置缓存
            $this->setLimitTimes($user['uid']);
            echo json_encode(array('msg' => 'true'));
        }else{
            echo json_encode(array('msg' => 'false'));
        }
    }


    /**
     * 发送成功后设置缓存
     * @param $userid
     * @return bool
     */
    private function setLimitTimes($userid){
        $redis = Ebh::app()->getCache('cache_redis');
        $userlimitkey = 'VC_USER_LIMIT_'.$userid;

        //设置邮箱每天限制
        $redis->zIncrBy($userlimitkey, 1, $userid);
        $redis->expireAt($userlimitkey, strtotime(date('Y-m-d',strtotime('+1 day'))));

        return true;
    }
}