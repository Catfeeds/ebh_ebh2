<?php

/**
 * 用户信息控制器类 UserstateController
 * 主要处理用户最新的待批作业数，答疑数，评论数等
 */
class UserstateController extends CControl {

    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
    /*
     * 获取根据type和时间对应的用户需处理的记录数
     */
    public function index() {
        $type = $this->input->post('type'); //需要查看的类型
        if ($type !== NULL) {
            $typecounts = array();
            if (is_numeric($type)) {
                $typecounts[$type] = $this->_gettypecount($type);
            } else if (is_array($type)) {
                foreach ($type as $typeid) {
                    if (is_numeric($typeid)) {
                        $typecounts[$typeid] = $this->_gettypecount($typeid);
                    }
                }
            }
            echo json_encode($typecounts);
        }
    }
    /**
     * 根据分类获取该分类和用户状态时间下的记录数
     * @param type $type
     * @return int 记录数
     */
    private function _gettypecount($type) {
        $count = 0;
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $statemodel = $this->model('Userstate');
        $subtime = $statemodel->getsubtime($roominfo['crid'],$user['uid'],$type);
        if($type == 1) {    //待批作业
            $exammodel = $this->model('Exam');
            if($roominfo['isschool'] == 3 || $roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
                $count = $exammodel->getnewschexamcountbytime($roominfo['crid'],$user['uid'],$subtime);
            } else if ($roominfo['isschool'] == 2) {
                $count = $exammodel->getnewexamcountbytime($roominfo['crid'],$user['uid'],$subtime);
            }
        } else if($type == 2) { //新问题
            $askmodel = $this->model('Askquestion');
            $count = $askmodel->getnewaskcountbytime($roominfo['crid'],$subtime);
        } else if($type == 3) { //新评论
            $reviewmodel = $this->model('Review');
            $param = array('crid'=>$roominfo['crid'],'uid'=>$user['uid'],'time'=>$subtime);
            $count = $reviewmodel->getreviewlistcountbycrid($param);
        }
        return $count;
    }

}
