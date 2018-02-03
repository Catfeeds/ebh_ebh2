<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/27
 * Time: 10:46
 * 活动专区控制器
 */
class ActivityController extends CControl{
    public function __construct(){
        parent::__construct();
        $notop = true;
        $this->assign('notop',$notop);
    }

    public function index(){
        $param = parsequery();
        $roominfo = Ebh::app()->room->getcurroom();
        $param['crid'] = $roominfo['crid'];
        $this->model('activity')->flashTop();//更新表置顶字段
        $list = $this->model('activity')->getList($param);//获取网校活动列表
//        foreach($list as &$v){
//            $now = date('Y-m-d');
//            if($now>=$v['starttime']&&$now<=$v['endtime']){
//                $v['go'] = 1;
//            }
//        }
        $count = $this->model('activity')->getCount($param['crid']);
        $pagestr = show_page($count['count'],$param['pagesize']);
//        $notop = 1;
//        $this->assign('notop',$notop);
        $this->assign('pagestr',$pagestr);
        $this->assign('list',$list);
        $this->display('aroomv2/activity');
    }

    /**
     * 发布活动
     */
    public function add(){
        $post = $this->input->post(null,false);
        if(!empty($post)){
            if(empty($post['starttime'])||empty($post['endtime'])||$post['starttime']>$post['endtime']){
                echo json_encode(array('status'=>0,'msg'=>'error'));
                exit;
            }
            if(strlen($post['subject'])<4){
                echo json_encode(array('status'=>0,'msg'=>'error'));
                exit;
            };
            if(empty($post['message'])){
                echo json_encode(array('status'=>0,'msg'=>'error'));
                exit;
            }
            if(empty($post['type'])){
                $post['type'] = 0;
            }else{
                $post['type'] = $post['type'];
                $post['tidstr'] =  !empty($post['folderids'])?$post['folderids']:$post['classids'];
                unset($post['folderids']);
                unset($post['classids']);
            }
            $rec = safeHtml($post,array('message'));//获得安全的数据
            $roominfo = Ebh::app()->room->getcurroom();
            $post['crid'] = $roominfo['crid'];
            $post['date'] = time();
            $post['subject'] = $rec['subject'];
            $post['summary'] = $rec['summary'];
            $post['starttime'] = strtotime($rec['starttime']);
            $post['endtime'] = strtotime($rec['endtime']);
            $res = $this->model('activity')->add($post);
            if($res){
                echo json_encode(array('status'=> 1, 'msg'=>'success'));
            }
        }else{
            $default = '
            <div class="hdgz">
                <div class="hdgzbt">活动规则</div>
                <p>1.所有注册并报名课程的用户均可参与。</p>
                <p>2.活动规则：</p>
                <p>3.排名标准：</p>
            </div>
            <div class="hdgz">
                <div class="hdgzbt">活动奖励</div>
                <p>1.活动新奖励：</p>
                <p>2.领取方式：</p>
            </div>
            <div class="hdgz">
                <div class="hdgzbt">温馨提示</div>
                <p>1.凡有各种作弊刷分行为的获奖用户，一律取消获奖资格。我们也希望广大e板会用户都能够互相监督，共同创建一个公正、公平、公开的抽奖环境！</p>
                <p>2.浙江新盛蓝科技有限公司在中华人民共和国法律规定范围内对本次活动具有解释权！</p>
            </div>';
            $roominfo = Ebh::app()->room->getcurroom();
            if(!empty($roominfo['crid'])){
                $this->assign('crid',$roominfo['crid']);
            }
            $this->assign('default',$default);
            $editor = Ebh::app()->lib('UMEditor');
            $this->assign('editor',$editor);
            $this->display('aroomv2/activity_add');
        }
    }

    /**
     * 活动详情
     */
    public function view(){
//        if(isset($_POST['count'])&&!empty($_POST['count'])){//获取参加活动未显示的学生
//            $mplist = $this->model('activity')->getMoreParter($_POST);
//            foreach($mplist as &$v){
//                $v['realname'] = $this->displace($v['realname']);
//                if($v['sex'] == 1)
//                    $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
//                else
//                    $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
//                $face = empty($v['face']) ? $defaulturl:$v['face'];
//                $face = str_replace('.jpg','_50_50.jpg',$face);
//                $v['face'] = $face;
//            }
//            echo json_encode($mplist);
//        }else{
            $get = $this->input->get();
            if(!empty($get['aid'])){
                $param = parsequery();
                $info = $this->model('activity')->getList($get);//获取活动信息
                $param['aid'] = $get['aid'];
                $reviews = $this->model('activity')->getReview($param);//获取活动评论
                if(isset($get['more'])&&$get['more']==1){
                    $get['limit'] = '0,99999';
                }else{
                    $get['limit'] = '0,30';
                }
                $parterlist = $this->model('activity')->getParterList($get);//获取活动学生信息
//            unset($parterlist['count']);
//            p($reviews);die;
                $count = $this->model('activity')->getReviewCount($get['aid']);
                $pagestr = show_page($count['count'],$param['pagesize']);
                if(!empty($get['more'])){
                    $this->assign('more',$get['more']);
                }
                $this->assign('parter',$parterlist);
                $this->assign('pagestr',$pagestr);
                $this->assign('page',$param);
                $this->assign('reviews',$reviews);
                $this->assign('info',$info);
                $this->assign('request',$get);
                $this->display('aroomv2/activity_view');
            }else{
                echo '未获取到活动id';
            }
    }

    /**
     * 活动编辑
     */
    public function edit(){
        $post = $this->input->post(null,false);
        if(!empty($post)){
            if(empty($post['starttime'])||empty($post['endtime'])||$post['starttime']>$post['endtime']){
                echo json_encode(array('status'=>0,'msg'=>'error'));
                exit;
            }
            if(strlen($post['subject'])<4){
                echo json_encode(array('status'=>0,'msg'=>'error'));
                exit;
            };
            if(empty($post['message'])){
                echo json_encode(array('status'=>0,'msg'=>'error'));
                exit;
            }
            $rec = safeHtml($post,array('message'));//获得安全的数据
            $post['date'] = time();
            $post['subject'] = $rec['subject'];
            $post['summary'] = $rec['summary'];
            $post['starttime'] = strtotime($rec['starttime']);
            $post['endtime'] = strtotime($rec['endtime']);
            $where['crid'] = $post['crid'];
            $where['aid'] = $post['aid'];
            unset($post['crid']);
            unset($post['aid']);
            $res = $this->model('activity')->edit($post,$where);
            if($res){
                echo json_encode(array('status'=>1, 'msg'=>'success'));
            }
        }else{
            $roominfo = Ebh::app()->room->getcurroom();
            $param['crid'] = $roominfo['crid'];
            $param['aid'] = $this->input->get('aid');
            $info = $this->model('activity')->getList($param);
            $info['starttime'] = date('Y-m-d',$info['starttime']);
            $info['endtime'] = date('Y-m-d',$info['endtime']);
            $editor = Ebh::app()->lib('UMEditor');
            $this->assign('info',$info);
            $this->assign('editor',$editor);
            $this->display('aroomv2/activity_edit');
        }
    }

    /**
     * 活动删除
     */
    public function del(){
        $id = $this->input->post('aid');
        if(empty($id)|| !is_numeric($id)){
            echo 0;
            exit();
        }
        $res = $this->model('activity')->del($id);
        if($res){
            echo 1;
        }else{
            echo 0;
        }
    }
    /**
     * 获取参与活动的人数
     */
    public function parter_num(){
        $param['aid'] = $this->input->post('aid');
        $roominfo = Ebh::app()->room->getcurroom();
        $param['crid'] = $roominfo['crid'];
        $parter = $this->model('activity')->getParter($param);
        echo empty($parter['parter']) ? 0 : $parter['parter'];
    }
    /**
     * 活动统计页面
     */
    public function stat(){
        $param = parsequery();
        $param['aid'] = $this->input->get('aid');
        $roominfo = Ebh::app()->room->getcurroom();//获取网校基本信息
        $id['crid'] = $roominfo['crid'];
        $info = $this->model('activity')->getList($param);
        $stat = $this->model('activity')->getParterList($param);
        $count = $stat['count'];
        unset($stat['count']);
        foreach($stat as &$v){
            $id['uid'] = $v['uid'];
            $classname = $this->model('activity')->getRoom($id);
            $v['classname'] = $classname['classname'];
        }
        $pagestr = show_page($count,$param['pagesize']);
        $this->assign('aid',$param['aid']);
        $this->assign('pagestr', $pagestr);
        $this->assign('info',$info);
        $this->assign('stat',$stat);
        $this->assign('page',$param);
        $this->display('aroomv2/activity_stat');
    }
    /**
     * 个人活动详情
     */
    public function details(){
        $get = $this->input->get();
        if(!empty($get)){
            $param = parsequery();
            $param = array_merge($param,$get);
            $roominfo = Ebh::app()->room->getcurroom();
            $param['crid'] = $roominfo['crid'];
            $detailslist = $this->model('activity')->getActivityDetails($param);
            $count = $detailslist['count'];
            unset($detailslist['count']);
            $pagestr = show_page($count,$param['pagesize']);
            $this->assign('pagestr',$pagestr);
            $this->assign('detailslist',$detailslist);
            $this->display('aroomv2/activity_details');
        }
    }

    /**
     * 屏蔽活动评论
     */
    public function shield(){
        $post = $this->input->post();
        if(empty($post['aid'])){
            echo json_encode(array('stat'=>0,'mag'=>'error'));
        }else{
            $res = $this->model('activity')->shieldReview($post['aid']);
            if($res){
                echo json_encode(array('stat'=>1,'msg'=>'success'));
            }else{
                echo json_encode(array('stat'=>0,'msg'=>'error'));
            }
        }
    }

    /**
     * 预览页面
     */
    public function preview(){
        $info = $this->input->post(null,false);
        if(!empty($info)){
            $this->assign('info',$info);
            $this->display('aroomv2/activity_preview');
        }
    }

    /**
     * 隐藏字符串某个字符
     * @param $param 操作的字符串
     * @param int $start 起始位置
     * @param int $num 隐藏个数
     * @return string
     */
    public function displace($param,$start=2,$num=1){
        $param = str_replace(' ','',$param);
        $len = mb_strlen($param,'utf-8');
//        if($len>$substr){
//            $param = mb_substr($param,0,$substr,'utf-8');
//        }
        $f = mb_substr($param,0,$start-1,'utf-8');
        $l = mb_substr($param,$start+$num-1,$len-$start+$num+1,'utf-8');
        return $f.'*'.$l;
    }

    /**
     * 根据crid 和 type 来读取班级或者课程列表
     */
    public function getTypeListAjax(){
        $crid = intval($this->input->post('crid'));
        $type = intval($this->input->post('type'));
        if(!empty($crid) && !empty($type)){
            if($type == 2){//读取网校下的所有课程列表
                $folderModel = $this->model('folder');
                $courselist = $folderModel->getSchoolFolder($crid);
                if(!empty($courselist)){
                    $html = '';
                    foreach ($courselist as $course) {
                        $html.='<div class="qbxs3">
                                    <span class="fl" id="'.$course['folderid'].'" onclick="addFolderids('.$course['folderid'].',this)" title="'.$course['foldername'].'">'. ssubstrch($course['foldername'], 0, 12, 'utf-8').'</span>
                                    <a href="javascript:void(0)" onclick="addFolderids('.$course['folderid'].',this)" class="fr mt5 xuanzq" ></a>
                                </div>';
                    }
                    echo $html;
                    exit;
                }
                echo '0';
                exit;
            }
            if($type == 1){//读取网校下的所有班级
                $checkbox = $this->input->post('checkbox');
                $checkbox = $checkbox?$checkbox:0;
                $classModel = $this->model('classes');
                $classlist = $classModel->getroomClassList($crid);
                if(!empty($checkbox)){
                    $cid = $this->input->post('checkbox');
                    $xk_course = $this->model('xuanke')->getCourse(array('cid'=>$cid));
                    if($xk_course['range_type']==1){
                        $classlist = $this->model('classes')->getClassListByGrade(array('cid'=>$cid,'crid'=>$crid,'grade'=>$xk_course['range_args']));
                    }elseif($xk_course['range_type']==2){
                        $classlist = $this->model('classes')->getClassListByGrade(array('cid'=>$cid,'crid'=>$crid,'classids'=>$xk_course['range_args']));
                    }
                }
                if(!empty($classlist)){
                    $html = '';
                    $classes = array();
                    foreach ($classlist as $class) {
                        $classes[$class['grade']][] = $class;
                    }
                    foreach ($classes as $key => $cl) {
                        switch($key){
                        case 1:
                                $html.='<div class="qbxs2">
                                         <span class="fl qbxs1span" onclick="shownext('.$key.',this,'.$checkbox.')">一年级</span>
                                         <a href="javascript:void(0)" class="fr mt5 xuanzq" onclick="shownexts('.$key.',this,'.$checkbox.')"></a>
                                        </div>';
                                break;
                        case 2:
                                $html.='<div class="qbxs2">
                                         <span class="fl qbxs1span" onclick="shownext('.$key.',this,'.$checkbox.')">二年级</span>
                                         <a href="javascript:void(0)" class="fr mt5 xuanzq" onclick="shownexts('.$key.',this,'.$checkbox.')"></a>
                                        </div>';
                                break;
                        case 3:
                                $html.='<div class="qbxs2">
                                         <span class="fl qbxs1span" onclick="shownext('.$key.',this,'.$checkbox.')">三年级</span>
                                         <a href="javascript:void(0)" class="fr mt5 xuanzq" onclick="shownexts('.$key.',this,'.$checkbox.')"></a>
                                        </div>';
                                break;
                        case 4:
                                $html.='<div class="qbxs2">
                                         <span class="fl qbxs1span" onclick="shownext('.$key.',this,'.$checkbox.')">四年级</span>
                                         <a href="javascript:void(0)" class="fr mt5 xuanzq" onclick="shownexts('.$key.',this,'.$checkbox.')"></a>
                                        </div>';
                                break;
                        case 5:
                                $html.='<div class="qbxs2">
                                         <span class="fl qbxs1span" onclick="shownext('.$key.',this,'.$checkbox.')">五年级</span>
                                         <a href="javascript:void(0)" class="fr mt5 xuanzq" onclick="shownexts('.$key.',this,'.$checkbox.')"></a>
                                        </div>';
                                break;
                        case 6:
                                $html.='<div class="qbxs2">
                                         <span class="fl qbxs1span" onclick="shownext('.$key.',this,'.$checkbox.')">六年级</span>
                                         <a href="javascript:void(0)" class="fr mt5 xuanzq" onclick="shownexts('.$key.',this,'.$checkbox.')"></a>
                                        </div>';
                                break;
                        case 7:
                                $html.='<div class="qbxs2">
                                         <span class="fl qbxs1span" onclick="shownext('.$key.',this,'.$checkbox.')">七年级</span>
                                         <a href="javascript:void(0)" class="fr mt5 xuanzq" onclick="shownexts('.$key.',this,'.$checkbox.')"></a>
                                        </div>';
                                break;
                        case 8:
                                $html.='<div class="qbxs2">
                                         <span class="fl qbxs1span" onclick="shownext('.$key.',this,'.$checkbox.')">八年级</span>
                                         <a href="javascript:void(0)" class="fr mt5 xuanzq" onclick="shownexts('.$key.',this,'.$checkbox.')"></a>
                                        </div>';
                                break;
                        case 9:
                                $html.='<div class="qbxs2">
                                         <span class="fl qbxs1span" onclick="shownext('.$key.',this,'.$checkbox.')">九年级</span>
                                         <a href="javascript:void(0)" class="fr mt5 xuanzq" onclick="shownexts('.$key.',this,'.$checkbox.')"></a>
                                        </div>';
                                break;
                        case 10:
                                $html.='<div class="qbxs2">
                                         <span class="fl qbxs1span" onclick="shownext('.$key.',this,'.$checkbox.')">高一</span>
                                         <a href="javascript:void(0)" class="fr mt5 xuanzq" onclick="shownexts('.$key.',this,'.$checkbox.')"></a>
                                        </div>';
                                break;
                        case 11:
                                $html.='<div class="qbxs2">
                                         <span class="fl qbxs1span" onclick="shownext('.$key.',this,'.$checkbox.')">高二</span>
                                         <a href="javascript:void(0)" class="fr mt5 xuanzq" onclick="shownexts('.$key.',this,'.$checkbox.')"></a>
                                        </div>';
                                break;
                        case 12:
                                $html.='<div class="qbxs2">
                                         <span class="fl qbxs1span" onclick="shownext('.$key.',this,'.$checkbox.')">高三</span>
                                         <a href="javascript:void(0)" class="fr mt5 xuanzq" onclick="shownexts('.$key.',this,'.$checkbox.')"></a>
                                        </div>';
                                break;
                        }
                        if($key !=0){
                           foreach ($cl as $c) {
                                $html.='<div class="qbxs3" style="display:none"  pid="'.$key.'">
                                            <span class="fl" onclick="addClassids('.$c['classid'].',this,'.$checkbox.');" id="'.$c['classid'].'" title="'.$c['classname'].'">'.ssubstrch($c['classname'], 0, 12, 'utf-8').'</span>
                                            <a href="javascript:void(0)" class="fr mt5 xuanzq" onclick="addClassids('.$c['classid'].',this,'.$checkbox.')"></a>
                                        </div>';
                            }
                        }

                    }
                    if(!empty($classes[0])){
                        $html.='<div class="qbxs2">
                                         <span class="fl qbxs1span" onclick="shownext(0,this,'.$checkbox.')">其他班级</span>
                                         <a href="javascript:void(0)" class="fr mt5 xuanzq" onclick="shownexts(0,this,'.$checkbox.')"></a>
                                        </div>';
                        foreach ($classes[0] as $c) {
                            $html.='<div class="qbxs3" style="display:none"  pid="0">
                                            <span class="fl" onclick="addClassids('.$c['classid'].',this,'.$checkbox.');" id="'.$c['classid'].'">'.ssubstrch($c['classname'], 0, 7, 'utf-8').'</span>
                                            <a href="javascript:void(0)" class="fr mt5 xuanzq" onclick="addClassids('.$c['classid'].',this,'.$checkbox.')"></a>
                                        </div>';
                        }
                    }
                    echo $html;
                    exit;
                }
                echo '0';
                exit;
            }
        }
        echo '0';
        exit;
    }
    /**
     * [getStudentListByType 通过ajax根据课程（type =2）或者班级（type=1）来获取学生列表]
     * @return [type] [description]
     */
    public function getStudentListByType(){
        $type = intval($this->input->post('type'));
        if(!empty($type) && $type ==1){//获取班级下的学生列表
            $classidlist = $this->input->post('idlist');
            $classidlist = rtrim($classidlist,',');
            $classidarr = explode(',',$classidlist);
            foreach ($classidarr as $key => $value) {
                if(empty($value)){
                    unset($classidarr[$key]);
                }
            }
            $classidarr = array_unique($classidarr);
            $classidlist = implode(',',$classidarr);
            $page = $this->input->post('page');
            $checkbox = $this->input->post('checkbox');
            if(!empty($classidlist)){
                $param = array();
                $param['classidlist'] = rtrim($classidlist,',');
                $param['page'] = !empty($page)?$page:1;
                $param['pagesize'] = 50;
                $csModel = $this->model('classes');
                //不显示的学生
                if(!empty($checkbox)){
                    $students = $this->model('xuanke')->getStudentList(array('cid'=>$checkbox,'limit'=>1000));
                    $unid = array();
                    foreach($students as $student){
                        $unid[] = $student['uid'];
                    }
                    $unid = implode(',',$unid);
                    $param['unid'] = $unid;
                }

                $studentlist = $csModel->getClassStudentList($param);
                if(!empty($studentlist[0])){
                    $studentcount = count($studentlist);
                }else{
                    unset($studentlist[0]);
                    $studentcount = 0;
                }
                $html = '';
                $checkhtml='';
                if(!empty($studentlist)){
                    $html = '<div class="xzxslist"><ul>';
                    foreach ($studentlist as $student) {
                        if($checkbox){
                            $checkhtml = '<a href="javascript:;" id="i'.$student['uid'].'" class="fr xuanzq1s"></a>';
                        }
                        if($student['sex'] == 0){
                            $html.='<li class="fl">';
                            if(!empty($student['face'])){
                                if($checkbox){
                                    $html.='<div onclick="check('.$student['uid'].')"><input type="checkbox" id="c'.$student['uid'].'" style="display: none" name="sel" class="xuanze" value="'.$student['uid'].'"/><img src="'.$student['face'].'" style="width:50px;height:50px;" title="';
                                }else{
                                    $html.='<div><img src="'.$student['face'].'" style="width:50px;height:50px;" title="';
                                }
                            }else{
                                if($checkbox){
                                    $html.='<div onclick="check('.$student['uid'].')"><input type="checkbox" id="c'.$student['uid'].'" style="display: none" name="sel" class="xuanze" value="'.$student['uid'].'"/><img src="http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg" style="width:50px;height:50px;" title="';
                                }else{
                                    $html.='<div><img src="http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg" style="width:50px;height:50px;" title="';
                                }
                            }

                                    if(!empty($student['realname'])){
                                        $html.= $student['realname'];
                                    }else{
                                        $html.= $student['username'];
                                    }
                                    $html.='"/></div>
                                    <p class="xingmingl">';
                                    if(!empty($student['realname'])){
                                        $html.= ssubstrch($student['realname'],0,5);
                                    }else{
                                        $html.= ssubstrch($student['username'],0,5);
                                    }
                                    $html.= '</p>'.$checkhtml.'
                                </li>';
                            }else{
                                $html.='<li class="fl">';
                            if(!empty($student['face'])){
                                if($checkbox){
                                    $html.='<div onclick="check('.$student['uid'].')"><input type="checkbox" id="c'.$student['uid'].'" style="display: none" name="sel" class="xuanze" value="'.$student['uid'].'"/><img src="'.$student['face'].'" style="width:50px;height:50px;" title="';
                                }else{
                                    $html.='<div><img src="'.$student['face'].'" style="width:50px;height:50px;" title="';
                                }
                            }else{
                                if($checkbox){
                                    $html.='<div onclick="check('.$student['uid'].')"><input type="checkbox" id="c'.$student['uid'].'" style="display: none" name="sel" class="xuanze" value="'.$student['uid'].'"/><img src="http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg" style="width:50px;height:50px;" title="';
                                }else{
                                    $html.='<div><img src="http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg" style="width:50px;height:50px;" title="';
                                }
                            }
                                    if(!empty($student['realname'])){
                                        $html.= $student['realname'];
                                    }else{
                                        $html.= $student['username'];
                                    }
                                    $html.='"/></div>
                                    <p class="xingmingl">';
                                    if(!empty($student['realname'])){
                                        $html.= ssubstrch($student['realname'],0,5,'utf-8');
                                    }else{
                                        $html.= ssubstrch($student['username'],0,5,'utf-8');
                                    }
                                    $html.= '</p>'.$checkhtml.'
                                </li>';
                            }
                    }
                    if($studentcount < 50){
                                $html.='</ul></div>
                                    <div class="clear"></div>
                                    <p style="text-align:center;">没有更多</p>';
                    }else{
                        $html.='</ul></div>
                                    <div class="clear"></div>
                                    <p style="text-align:center;"><a href="javascript:;" class="jzgds jzgds1" onclick="getmore(';
                        $html.=$page+1;
                        $html.=','.$checkbox.');">加载更多...</a><a href="javascript:;" style="display:none" class="jzgds jzgds2">正在加载中...</a></p>';
                    }

                }
                echo $html;
            }
        }
        if(!empty($type) && $type ==2){//获取课程下的学生列表
            $folderidlist = $this->input->post('idlist');
            $folderidlist = rtrim($folderidlist,',');
            $folderidarr = explode(',',$folderidlist);
            $folderidarr = array_unique($folderidarr);
            foreach ($folderidarr as $key => $value) {
                if(empty($value)){
                    unset($folderidarr[$key]);
                }
            }
            $folderidlist = implode(',',$folderidarr);
            $page = $this->input->post('page');
            $foldermodel = $this->model('Folder');
            if(!empty($folderidlist)){
                $myfolders = $foldermodel->getfolderbyids($folderidlist);
            }else{
                $myfolders = array();
            }
            $roominfo = Ebh::app()->room->getcurroom();
            if(!empty($folderidlist) && $roominfo['isschool'] ==7){//收费分成学校
                if(!empty($roominfo)){
                    foreach ($myfolders as $myfolder) {
                        if($myfolder['isschoolfree'] == 1 || $myfolder['fprice'] == 0){//免费课程
                            $folder['isschoolfree'][] =  $myfolder;
                        }else{//收费课程
                            $folder['userpermission'][] = $myfolder;
                        }
                    }
                        if(!empty($folder['userpermission'])){
                            $perfoldstr = '';
                            foreach ($folder['userpermission'] as $f) {
                                $perfoldstr.= $f['folderid'].',';
                            }
                            $perfoldstr = rtrim($perfoldstr,',');
                            if(!empty($perfoldstr)){
                                $upmodel = $this->model('Userpermission');
                                $uidlist = $upmodel->getUserIdListByFolderarr($perfoldstr);
                            }

                                if(!empty($uidlist)) {
                                    foreach($uidlist as $uiditem) {
                                        if(empty($uidstr)) {
                                            $uidstr = $uiditem['uid'];
                                        } else {
                                            $uidstr .= ','.$uiditem['uid'];
                                        }
                    }
                    $userlistarr = $upmodel->getUserAndClassListByUidStr($roominfo['crid'],$f['folderid'],$uidstr,'');
                    foreach ($userlistarr as $key => $value) {
                        $userlist1[] = $value;
                    }
                }
                        }
                        if(!empty($folder['isschoolfree'])){
                            $classModel = $this->model('classes');
                            $param['crid']=$roominfo['crid'];
                            $userlist2 = $classModel->getAllstudentBycrid($param);
                        }

                }
            }else{//其他学校
                $roominfo = Ebh::app()->room->getcurroom();
                $classmodel = $this->model('Classes');
                foreach ($myfolders as $myfolder) {
                    if(!empty($myfolder['grade'])){
                        $grade[] = $myfolder['grade'];
                   }else{
                        $uid[] = $myfolder['uid'];
                   }
                }
                if(!empty($grade)){//有年级的则读取年级对应下的学生
                    $grade = array_unique($grade);
                    $gstr = implode(',',$grade);
                    $userlist1 = $classmodel->getStudentListByGradearr($roominfo['crid'],$gstr);
                }
                if(!empty($uid)){//没有年级则读取课件对应老师所对应的班级
                    $uid = array_unique($uid);
                    $ustr = implode(',',$uid);
                    $classlist = $classmodel->getTeacherClassListarr($roominfo['crid'],$ustr);
                    $classlist = array_unique($classlist);
                    $classids = '';
                    foreach ($classlist as $c) {
                        $classids .= $c['classid'].',';
                    }
                    $classids = rtrim($classids,',');
                    $userlist2 = $classmodel->getClassStudentList(array('classidlist'=>$classids,'limit'=>1000));
                    }

                }
                $studentcount = 0;
                $userlist = array();
                if(!empty($userlist1)){
                    $userlist = $userlist1;
                }
                if(!empty($userlist2)){
                    $userlist = $userlist2;
                }
                if(!empty($userlist1) && !empty($userlist2)){
                    $userlist = array_merge($userlist1,$userlist2);
                }
            if(!empty($userlist)){
                if(!empty($userlist)){
                   $userslist = $this->assoc_unique($userlist,'uid');
                   $studentcount = count($userslist);
                }else{
                    $studentcount = 0;
                }
            }
            $max = min($studentcount,($page-1)*50+50);
            $html = '';
            if(!empty($userslist)){
                $html = '<div class="xzxslist"><ul>';
                for($i=($page-1)*50;$i<$max;$i++){
                    if($userslist[$i]['sex'] == 0){
                            $html.='<li class="fl">';
                            if(!empty($userslist[$i]['face'])){
                                $html.='<div><img src="'.$userslist[$i]['face'].'" style="width:50px;height:50px;" title="';
                            }else{
                                $html.='<div><img src="http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg" style="width:50px;height:50px;" title="';
                            }
                                    if(!empty($userslist[$i]['realname'])){
                                        $html.= $userslist[$i]['realname'];
                                    }else{
                                        $html.= $userslist[$i]['username'];
                                    }
                                    $html.='"/></div>
                                    <p class="xingmingl">';
                                    if(!empty($userslist[$i]['realname'])){
                                        $html.= ssubstrch($userslist[$i]['realname'],0,5,'utf-8');
                                    }else{
                                        $html.= ssubstrch($userslist[$i]['username'],0,5,'utf-8');
                                    }
                                    $html.= '</p>
                                </li>';
                            }else{
                                $html.='<li class="fl">';
                            if(!empty($userslist[$i]['face'])){
                                $html.='<div><img src="'.$userslist[$i]['face'].'" style="width:50px;height:50px;" title="';
                            }else{
                                $html.='<div><img src="http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg" style="width:50px;height:50px;" title="';
                            }
                                    if(!empty($userslist[$i]['realname'])){
                                        $html.= $userslist[$i]['realname'];
                                    }else{
                                        $html.= $userslist[$i]['username'];
                                    }
                                    $html.='"/></div>
                                    <p class="xingmingl">';
                                    if(!empty($userslist[$i]['realname'])){
                                        $html.= ssubstrch($userslist[$i]['realname'],0,5,'utf-8');
                                    }else{
                                        $html.= ssubstrch($userslist[$i]['username'],0,5,'utf-8');
                                    }
                                    $html.= '</p>
                                </li>';
                            }
                }
                 if($studentcount < 50){
                                $html.='</ul></div>
                                    <div class="clear"></div>
                                    <p style="text-align:center;">没有更多</p>';
                    }else{
                        $html.='</ul></div>
                                    <div class="clear"></div>
                                    <p style="text-align:center;"><a href="javascript:;" class="jzgds jzgds1" onclick="getmore(';
                        $html.=$page+1;
                        $html.=');">加载更多...</a><a href="javascript:;" style="display:none" class="jzgds jzgds2">正在加载中...</a></p>';
                    }
            }
            echo $html;
        }
    }

    /**
         * [assoc_unique 去掉两个数组中重复的部分]
         * @param  [type] $arr [description]
         * @param  [type] $key [description]
         * @return [type]      [description]
         */
         private function assoc_unique($arr, $key){
               $tmp_arr = array();
               foreach($arr as $k => $v){
               if(in_array($v[$key], $tmp_arr)){
                  unset($arr[$k]);
               }else {
                  $tmp_arr[] = $v[$key];
               }
              }
            sort($arr); //sort函数对数组进行排序
            return $arr;
            }
    /**
     * [enter 点击确认 将所选的班级名或课程名称显示于前台]
     * @return [type] [description]
     */
    public function enter(){
        $folders = $this->input->post('fold');
        $classids = $this->input->post('classes');
        if(!empty($folders)){
            $folders = rtrim($folders,',');
            $folderidarr = explode(',',$folders);
            foreach ($folderidarr as $key => $value) {
                if(empty($value)){
                    unset($folderidarr[$key]);
                }
            }
            $folderidarr = array_unique($folderidarr);
            $folders = implode(',',$folderidarr);
            $param['folderid'] = $folders;
            $foldModel = $this->model('Folder');
            $folderlist = $foldModel->getfolderlist($param);
            if(!empty($folderlist)){
                $html = '<ul><div id="wrap">';
                foreach ($folderlist as $fold) {
                    $html.= '<li xid="class_45"  class="lantewu">
                                    <a href="javascript:void(0)" onclick="removed(this,'.$fold['folderid'].',2)" class="languan"></a>'.$fold['foldername'].'</li>';

                }
                $html.= '<input type="hidden" name="folderids" value="';
                $html.=$folders;
                $html.='"/>';
                $html.='<input type="hidden" name="type" value="2"></div></ul>';
                echo $html;
            }
        }
        if(!empty($classids)){
            $classids = rtrim($classids,',');
            $folderidarr = explode(',',$classids);
            foreach ($folderidarr as $key => $value) {
                if(empty($value)){
                    unset($folderidarr[$key]);
                }
            }
            //var_dump($folderidarr);
            $folderidarr = array_unique($folderidarr);
            $classids = implode(',',$folderidarr);
            $classModel = $this->model('classes');
            $classlist = $classModel->getallClassInfo($classids);
            if(!empty($classlist)){
                $html = '<ul><div id="wrap">';
                foreach ($classlist as $class) {
                    $html.= '<li xid="class_45" class="lantewu">
                                    <a href="javascript:void(0)" class="languan" onclick="removed(this,'.$class['classid'].',1)"></a>'.$class['classname'].'</li>';

                }
                $html.= '<input type="hidden" name="classids" value="'.$classids.'"/>';
                $html.='<input type="hidden" name="type" value="1"></div></ul>';
                echo $html;
            }
        }
    }
    /**
     * [getNextStudentListByType 获取下一页的学生]
     * @return [type] [description]
     */
    public function getNextStudentListByType(){
        $roominfo = Ebh::app()->room->getcurroom();
        $type = intval($this->input->post('type'));
        if(!empty($type) && $type ==1){//获取班级下的学生列表
            $classidlist = $this->input->post('idlist');
            $classidlist = rtrim($classidlist,',');
            $classidarr = explode(',',$classidlist);
            foreach ($classidarr as $key => $value) {
                if(empty($value)){
                    unset($classidarr[$key]);
                }
            }
            $classidarr = array_unique($classidarr);
            $classidlist = implode(',',$classidarr);
            $page = $this->input->post('page');
            if(!empty($classidlist)){
                $param = array();
                $param['classidlist'] = rtrim($classidlist,',');
                $param['page'] = !empty($page)?$page:1;
                $param['pagesize'] = 50;
                $csModel = $this->model('classes');
                $studentlist = $csModel->getClassStudentList($param);
                if(!empty($studentlist[0])){
                    $studentcount = count($studentlist);
                }else{
                    unset($studentlist[0]);
                    $studentcount = 0;
                }
                if($studentcount >=50){
                    $studentlist['next'] = 1;
                }else{
                    $studentlist['next'] = 0;
                }
                foreach ($studentlist as $key => $value) {
                    if(!empty($value['realname'])){
                        $studentlist[$key]['realname1'] = ssubstrch($studentlist[$key]['realname'],0,6);
                    }else{
                        $studentlist[$key]['username1'] = ssubstrch($studentlist[$key]['username'],0,6);
                    }
                }
                echo json_encode($studentlist);
            }
        }
        if(!empty($type) && $type ==2){//获取课程下的学生列表
            $folderidlist = $this->input->post('idlist');
            $folderidlist = rtrim($folderidlist,',');
            $folderidarr = explode(',',$folderidlist);
            foreach ($folderidarr as $key => $value) {
                if(empty($value)){
                    unset($folderidarr[$key]);
                }
            }
            $folderidarr = array_unique($folderidarr);
            $folderidlist = implode(',',$folderidarr);
            $page = $this->input->post('page');
            if(!empty($folderidlist)){
                $foldermodel = $this->model('folder');
                $myfolders = $foldermodel->getfolderbyids($folderidlist);
            }else{
                $myfolders = array();
            }

             if(!empty($folderidlist) && $roominfo['isschool'] ==7){//收费分成学校
                if(!empty($roominfo)){
                    foreach ($myfolders as $myfolder) {
                        if($myfolder['isschoolfree'] == 1 || $myfolder['fprice'] == 0){//免费课程
                            $folder['isschoolfree'][] =  $myfolder;
                        }else{//收费课程
                            $folder['userpermission'][] = $myfolder;
                        }
                    }
                        if(!empty($folder['userpermission'])){
                            $perfoldstr = '';
                            foreach ($folder['userpermission'] as $f) {
                                $perfoldstr.= $f['folderid'].',';
                            }
                            $perfoldstr = rtrim($perfoldstr,',');
                            if(!empty($perfoldstr)){
                                $upmodel = $this->model('Userpermission');
                                $uidlist = $upmodel->getUserIdListByFolderarr($perfoldstr);
                            }

                                if(!empty($uidlist)) {
                                    foreach($uidlist as $uiditem) {
                                        if(empty($uidstr)) {
                                            $uidstr = $uiditem['uid'];
                                        } else {
                                            $uidstr .= ','.$uiditem['uid'];
                                        }
                    }
                    $userlistarr = $upmodel->getUserAndClassListByUidStr($roominfo['crid'],$f['folderid'],$uidstr,'');
                    foreach ($userlistarr as $key => $value) {
                        $userlist1[] = $value;
                    }
                }
                        }
                        if(!empty($folder['isschoolfree'])){
                            $classModel = $this->model('classes');
                            $param['crid']=$roominfo['crid'];
                            $userlist2 = $classModel->getAllstudentBycrid($param);
                        }

                }
            }else{//其他学校
                $roominfo = Ebh::app()->room->getcurroom();
                $classmodel = $this->model('Classes');
                foreach ($myfolders as $myfolder) {
                    if(!empty($myfolder['grade'])){
                        $grade[] = $myfolder['grade'];
                   }else{
                        $uid[] = $myfolder['uid'];
                   }
                }
                if(!empty($grade)){//有年级的则读取年级对应下的学生
                    $grade = array_unique($grade);
                    $gstr = implode(',',$grade);
                    $userlist1 = $classmodel->getStudentListByGradearr($roominfo['crid'],$gstr);
                }
                if(!empty($uid)){//没有年级则读取课件对应老师所对应的班级
                    $uid = array_unique($uid);
                    $ustr = implode(',',$uid);
                    $classlist = $classmodel->getTeacherClassListarr($roominfo['crid'],$ustr);
                    $classlist = array_unique($classlist);
                    $classids = '';
                    foreach ($classlist as $c) {
                        $classids .= $c['classid'].',';
                    }
                    $classids = rtrim($classids,',');
                    $userlist2 = $classmodel->getClassStudentList(array('classidlist'=>$classids,'limit'=>1000));
                    }

                }
                $studentcount = 0;
                $userlist = array();
                if(!empty($userlist1)){
                    $userlist = $userlist1;
                }
                if(!empty($userlist2)){
                    $userlist = $userlist2;
                }
                if(!empty($userlist1) && !empty($userlist2)){
                    $userlist = array_merge($userlist1,$userlist2);
                }
            if(!empty($userlist)){
                if(!empty($userlist)){
                   $userslist = $this->assoc_unique($userlist,'uid');
                   $studentcount = count($userslist);
                }else{
                    $studentcount = 0;
                }
            }
            $max = min($studentcount,($page-1)*50+50);
            for($i=($page-1)*50;$i<$max;$i++){
                if(!empty($userslist[$i])){
                    if(!empty($userslist[$i]['realname'])){
                        $userslist[$i]['realname1'] = ssubstrch($userslist[$i]['realname'],0,5,'utf-8');
                    }else{
                        $userslist[$i]['username1'] = ssubstrch($userslist[$i]['username'],0,5,'utf-8');
                    }
                    $userlist3[] = $userslist[$i];
                }
            }
            if($studentcount >= ($page*50)){
                $userlist3['next'] = 1;
            }else{
                $userlist3['next'] = 0;
            }
            echo json_encode($userlist3);
        }
    }
}