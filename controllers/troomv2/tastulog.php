<?php
/**
 * 学生监察控制器TastulogController
 */
class TastulogController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
    public function index() {
		$classid = $this->uri->uri_attr(0); //班级编号
        $type = $this->uri->uri_attr(1);    //类型，1 听课笔记 2 学生作业 3学生记录 4查看错题集
//        $typename = '';
//        if($type == 1)
//            $typename = '听课笔记';
//        else if($type == 2)
//            $typename = '学生作业';
//        else if($type == 3)
//            $typename = '学生记录';
//        else if($type == 4)
//            $typename = '查看错题集';
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $queryarr = parsequery();
        $classmodel = $this->model('Classes');
        $classlist = $classmodel->getTeacherClassList($roominfo['crid'],$user['uid']);
        if(is_numeric($classid)) {
            $queryarr['classid'] = $classid;
        }
        $classidlist = '';
        $clist = array();   //classid为key和classname为value的数组
        foreach ($classlist as $c) {
            if(empty($classidlist))
                $classidlist = $c['classid'];
            else
                $classidlist .= ','.$c['classid'];
            $clist[$c['classid']] = $c['classname'];
        }
        if(!empty($classidlist))
            $queryarr['classidlist'] = $classidlist;
        $students = false;
        $pagestr = '';
        if(!empty($classidlist)) {
            $students = $classmodel->getClassStudentList($queryarr);
            $count = $classmodel->getClassStudentCount($queryarr);
            $pagestr = show_page($count);
            for($i = 0; $i < count($students); $i ++) {
                $students[$i]['classname'] = $clist[$students[$i]['classid']];
            }
        }
        
        $this->assign('classid', $classid);
 //       $this->assign('type', $type);
//        $this->assign('typename', $typename);
        $this->assign('classlist', $classlist);
		$this->assign('q', $q);
        $this->assign('students', $students);
        $this->assign('pagestr', $pagestr);
        $this->display('troomv2/tastulog');
    }
}
