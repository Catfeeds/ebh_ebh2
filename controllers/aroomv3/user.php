<?php
/**
 * ebh2.
 * Author: jw
 * Email: 345468755@qq.com
 */
class UserController extends ARoomV3Controller{
    public function info(){
        $result['user']['uid'] = $this->user['uid'];
        $result['user']['username'] = $this->user['username'];
        $result['user']['realname'] = $this->user['realname'];
        $result['user']['face'] = $this->user['face'];
        $result['user']['groupid'] = $this->user['groupid'];
        $result['user']['sex'] = $this->user['sex'];
        $result['roominfo']['crid'] = $this->roominfo['crid'];
		$result['roominfo']['uid'] = $this->roominfo['uid'];
        $result['roominfo']['crname'] = $this->roominfo['crname'];
        $result['roominfo']['subtitle'] = !empty($this->roominfo['subtitle']) ? $this->roominfo['subtitle'] : '';
        $result['roominfo']['domain'] = $this->roominfo['domain'].'.ebh.net';
		$result['user']['isadmin'] = $this->user['uid'] == $this->roominfo['uid'];
        $unreadlist = Ebh::app()->lib('EMessage')->getUnReadCount($this->user['uid'],$this->roominfo['crid']);

        $result['msg']['total'] = 0;
        if (!empty($unreadlist))
        {
            foreach ($unreadlist as $key => $value)
            {
                /**
                 * 2:新回答
                 * 3:私信
				 * 4:评论
				 * 5:提问
                 */
                $useKey = array(2,3,4,5);
                if(in_array($key,$useKey)){
                    $result['msg']['type_' . $key] = intval($value);
                    $result['msg']['total'] += $value;
                }
            }
        }

        $this->renderjson(0,'',$result);
    }

    /**
     * 判断用户名是否已存在
     */
    public function checkExists() {
        $username = trim($this->input->post('username'));
        if ($username == '') {
            $this->renderjson(0);
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Member.User.exists')
            ->addParams('username', $username)
            ->request();
        if (!empty($ret)) {
            $this->renderjson(1, '用户名称已存在', $ret);
        }
        $this->renderjson(0, '', $ret);
    }
}