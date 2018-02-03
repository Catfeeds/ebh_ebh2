<?php
class AjaxController extends CControl{
    private $user = null;
    public function __construct(){
        parent::__construct();
        $this->user = Ebh::app()->user->getloginuser();
        if(empty($this->user)){
            echo json_encode(array('code'=>1,'msg'=>'用户未登录'));exit;
        }
        $this->assign('user',$this->user);
    }
    /**
     * im初始化
     */
    public function iminit(){
        $usermodel = $this->model('user');
        $list = $usermodel->getUserInfoByUid(array(13192,408378));
        foreach($list as $v){
            $friend_list[] = array(
                'username'    =>  $v['realname'],
                'id'          =>  $v['uid'],
                'avatar'      =>  getavater($v,'120_120'),
                'sign'        =>  $v['mysign']
            );
        }

        $mine = array(
            'username'  =>  $this->user['realname'],
            'id'        =>  $this->user['uid'],
            'status'    =>  'online',
            'sign'      =>  $this->user['mysign'],
            'avatar'    =>  getavater($this->user,'120_120')
        );

        $friend[] = array(
            'groupname'   =>  'PHP',
            'id'          =>    1,
            'online'      =>    2,
            'list'        =>   $friend_list
        );

        $ret = array(
            'code'  =>  0,
            'msg'   =>  '',
            'data'  =>  array(
                'mine'  =>  $mine,
                'friend'    =>  $friend,
                'group'     =>  array(
                    array(
                        'groupname' =>  '测试群',
                        'id'        =>  101,
                        'avatar'    =>  'http://tp2.sinaimg.cn/2211874245/180/40050524279/0'
                    )
                )
            )
        );

        echo json_encode($ret);

    }

    public function group_member(){
        $usermodel = $this->model('user');
        $list = $usermodel->getUserInfoByUid(array(13192,408378));
        foreach($list as $v){
            $member_list[] = array(
                'username'    =>  $v['realname'],
                'id'          =>  $v['uid'],
                'avatar'      =>  getavater($v,'120_120'),
                'sign'        =>  $v['mysign']
            );
        }

        $data = array(
            'owner' =>  $member_list[0],
            'list'  =>  $member_list
        );

        $ret = array(
            'code'  =>  0,
            'msg'   =>  '',
            'data'  =>  $data
        );
        echo json_encode($ret);
    }
}