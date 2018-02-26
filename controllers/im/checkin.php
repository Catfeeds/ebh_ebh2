<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 13:05
 */
class CheckinController extends CControl{
    private $user = false;
    public function __construct() {
        parent::__construct();
        $key = $this->input->get('key');
        $user = Ebh::app()->user->getloginuser();
        if(empty($key) && !$user){
            exit;
        }
        $key = base64_decode($key);
        //如果用户未登录 设置用户cookie
        if(!empty($key)) {

            $keyArr = explode("\t",authcode($key, 'DECODE'));
            if(count($keyArr) > 1){
                @list($password, $uid) = $keyArr;
            }else{
                exit;
            }
            $auth = authcode("$password\t$uid", 'ENCODE');
            $this->input->setcookie('auth', $auth, 31536000);
            $this->input->setcookie('ak', $auth, 31536000);
            $user = Ebh::app()->user->getloginuser();

        }
        $this->user = $user;
        $this->assign('user',$user);
        $this->assign('key',$key);
    }

    /**
     * 短信通知
     */
    public function sms_view(){
        if($this->user['groupid'] != 5){
            exit;
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $cwid = $this->uri->itemid;
        $parameters['cwid'] = $cwid;
        $parameters['crid'] = $roominfo['crid'];
        $apiServer = Ebh::app()->getApiServer('ebh');
        $course =  $apiServer->reSetting()->setService('Classroom.Checkin.msg')->addParams($parameters)->request();
        if($course['status'] == 0){
            renderjson(1,$course['msg']);
        }
        renderjson(0,'通知成功');
    }
    /**
     * 老师签到管理页面
     */
    public function view(){
        if($this->user['groupid'] != 5){
            exit;
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $cwid = $this->uri->itemid;
        $apiServer = Ebh::app()->getApiServer('ebh');
        $parameters['cwid'] = $cwid;
        $course =  $apiServer->reSetting()->setService('Classroom.Course.detail')->addParams($parameters)->request();
        if($course['status'] == 0){
            echo $course['msg'];exit;
        }
        $course = $course['data'];
        //读取该课程下 学生列表
        $parameters = array();
        $parameters['crid'] = $roominfo['crid'];
        $parameters['folderid'] = $course['folderid'];
        $parameters['cwid'] = $cwid;
        $userList = $apiServer->reSetting()->setService('Classroom.Folder.getFolderStudent')->addParams($parameters)->request();
        //获取已签到的学生数组
        $redis = Ebh::app()->getCache('cache_redis')->getRedis();
        $checkinUserList = $redis->zRange('chatroom_checkin_'.$cwid,0,-1);
        //获取在线学生数组
        $onlineUserList = $redis->lRange('chatroom_'.$cwid.'_member_list',0,-1);
        //foreach ()
        $checkinList = array();
        //在线已签到列表
        $onlineCheckinList = array();
        //离线已签到列表
        $offlineCheckinList = array();
        $unCheckinList = array();
        //在线未签到列表
        $onlineUnCheckinList = array();
        //离线未签到列表
        $offlineUnCheckinList= array();
        foreach ($userList as &$user){
            if(in_array($user['uid'],$checkinUserList)){
                $user['checkin'] = true;
            }else{
                $user['checkin'] = false;
            }

            if(in_array($user['uid'],$onlineUserList)){
                $user['online'] = true;
            }else{
                $user['online'] = false;
            }

            if($user['checkin']){
                //$checkinList[] = $user;

                if($user['online']){
                    $onlineCheckinList[] = $user;
                }else{
                    $offlineCheckinList[] = $user;
                }
            }else{
                if($user['online']){
                    $onlineUnCheckinList[] = $user;
                }else{
                    $offlineUnCheckinList[] = $user;
                }
                //$unCheckinList[] = $user;
            }
        }

        $checkinList = array_merge($onlineCheckinList,$offlineCheckinList);
        $unCheckinList = array_merge($onlineUnCheckinList,$offlineUnCheckinList);

        $sendCount = intval($redis->get('chatroom_checkin_sms_'.$cwid));

        $this->assign('send_count',$sendCount);
        //$this->assign('userList',$user);
        $this->assign('checkinlist',$checkinList);
        $this->assign('uncheckinlist',$unCheckinList);
        $this->assign('cwid',$cwid);
        $this->display('im/checkin_t');
    }

    /**
     * 导出
     */
    public function export_view(){
        if($this->user['groupid'] != 5){
            exit;
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $cwid = $this->uri->itemid;
        $apiServer = Ebh::app()->getApiServer('ebh');
        $parameters['cwid'] = $cwid;
        $course =  $apiServer->reSetting()->setService('Classroom.Course.detail')->addParams($parameters)->request();
        if($course['status'] == 0){
            echo $course['msg'];exit;
        }
        $course = $course['data'];
        //读取该课程下 学生列表
        $parameters = array();
        $parameters['crid'] = $roominfo['crid'];
        $parameters['folderid'] = $course['folderid'];
        $parameters['cwid'] = $cwid;
        $userList = $apiServer->reSetting()->setService('Classroom.Folder.getFolderStudent')->addParams($parameters)->request();
        //获取已签到的学生数组
        $redis = Ebh::app()->getCache('cache_redis')->getRedis();
        $checkinUserList = $redis->zRange('chatroom_checkin_'.$cwid,0,-1);
        //获取在线学生数组
        $onlineUserList = $redis->lRange('chatroom_'.$cwid.'_member_list',0,-1);
        //foreach ()

        $checkinList = array();
        $unCheckinList = array();
        foreach ($userList as &$user){
            if(in_array($user['uid'],$checkinUserList)){
                $user['checkin'] = true;
            }else{
                $user['checkin'] = false;
            }

            if(in_array($user['uid'],$onlineUserList)){
                $user['online'] = true;
            }else{
                $user['online'] = false;
            }

            if($user['checkin']){
                $checkinList[] = $user;
            }else{
                $unCheckinList[] = $user;
            }



        }
        $this->_exportExcel('签到记录-'.date('YmdHis'),$checkinList,$unCheckinList);
    }

    /**
     * 导出excel
     * @param $name
     * @param $checkinList
     * @param $unCheckinList
     */
    protected  function _exportExcel($name,$checkinList,$unCheckinList){
        set_time_limit(0);
        $objPHPExcel = Ebh::app()->lib('PHPExcel');
        //模拟数据
        $checkedData = array(
            array('班级','帐号', '姓名','性别', '联系方式', '最后登录时间', '登录IP','状态'),
        );
        $uncheckedData = array(
            array('班级','帐号', '姓名','性别', '联系方式','最后登录时间', '登录IP','状态'),
        );
        $ipLib = Ebh::app()->lib('IPaddress');

        if(!empty($checkinList)){
            foreach ($checkinList as $user){
                if(!empty($user['ip'])){
                    $ipAddress = $ipLib->find($user['ip']);
                    $ipAddress = rtrim(implode('-',$ipAddress),'-');
                }

                $checkedData[] = array(
                    $user['classname'],
                    $user['username'],
                    $user['realname'],
                    $user['sex'] == 0 ? '男' :'女',
                    $user['mobile'],
                    !empty($user['lastlogintime']) ? date('Y-m-d H:i:s',$user['lastlogintime']) : '',
                    !empty($user['ip']) ? $ipAddress.'-'.$user['ip'] : '',
                    $user['online'] ? '在线' : '离线'
                );
            }
        }
        if(!empty($unCheckinList)){
            foreach ($unCheckinList as $user){
                if(!empty($user['ip'])){
                    $ipAddress = $ipLib->find($user['ip']);
                    $ipAddress = rtrim(implode('-',$ipAddress),'-');
                }
                $uncheckedData[] = array(
                    $user['classname'],
                    $user['username'],
                    $user['realname'],
                    $user['sex'] == 0 ? '男' :'女',
                    $user['mobile'],
                    !empty($user['lastlogintime']) ? date('Y-m-d H:i:s',$user['lastlogintime']) : '',
                    !empty($user['ip']) ? $ipAddress.'-'.$user['ip'] : '',
                    $user['online'] ? '在线' : '离线'
                );
            }
        }


        $objPHPExcel->getProperties()
            ->setTitle("签到数据导出")
            ->setSubject("签到数据导出")
            ->setDescription("签到数据导出")
            ->setKeywords("excel")
            ->setCategory("result file");

        $objPHPExcel->setactivesheetindex(0);
        $objPHPExcel->getActiveSheet()->setTitle('已签到');
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        //设置列宽
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        //写入多行数据
        foreach($checkedData as $k=>$v){
            $k = $k+1;
            $objPHPExcel->getactivesheet()->setcellvalue('A'.$k, $v[0]);
            $objPHPExcel->getactivesheet()->setcellvalue('B'.$k, $v[1]);
            $objPHPExcel->getactivesheet()->setcellvalue('C'.$k, $v[2]);
            $objPHPExcel->getactivesheet()->setcellvalue('D'.$k, $v[3]);
            $objPHPExcel->getactivesheet()->setcellvalue('E'.$k, $v[4]);
            $objPHPExcel->getactivesheet()->setcellvalue('F'.$k, $v[5]);
            $objPHPExcel->getactivesheet()->setcellvalue('G'.$k, $v[6]);
            $objPHPExcel->getactivesheet()->setcellvalue('H'.$k, $v[7]);
        }

        //创建一个新的工作空间(sheet)
        $objPHPExcel->createSheet();
        $objPHPExcel->setactivesheetindex(1);

        $objPHPExcel->getActiveSheet()->setTitle('未签到');
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        //设置列宽
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        //写入多行数据
        foreach($uncheckedData as $k=>$v){
            $k = $k+1;
            /* @func 设置列 */
            $objPHPExcel->getactivesheet()->setcellvalue('A'.$k, $v[0]);
            $objPHPExcel->getactivesheet()->setcellvalue('B'.$k, $v[1]);
            $objPHPExcel->getactivesheet()->setcellvalue('C'.$k, $v[2]);
            $objPHPExcel->getactivesheet()->setcellvalue('D'.$k, $v[3]);
            $objPHPExcel->getactivesheet()->setcellvalue('E'.$k, $v[4]);
            $objPHPExcel->getactivesheet()->setcellvalue('F'.$k, $v[5]);
            $objPHPExcel->getactivesheet()->setcellvalue('G'.$k, $v[6]);
            $objPHPExcel->getactivesheet()->setcellvalue('H'.$k, $v[7]);
        }

        //exit(0);
        // 输出下载文件 到浏览器
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
            $name = urlencode($name);
        } else {
            $name = str_replace(' ', '', $name);
        }

        $filename  = $name.".xls";//文件名,带格式
        header("Content-type: text/csv");//重要 屏蔽ie等安全提醒
        header('Content-Type:application/x-msexecl;name="'.$name.'"');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $objWriter->save('php://output');
    }
}