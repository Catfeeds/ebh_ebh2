<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 11:34
 */
class AttendanceController extends CControl {
    private $api = null;
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
        $this->api = Ebh::app()->getApiServer('ebh');
    }

    /**
     * 考勤出勤课件列表
     */
    public function index(){
        $roominfo = Ebh::app()->room->getcurroom();

        $param = parsequery();
        $parameters['crid'] = $roominfo['crid'];
        $parameters['p'] = $param['page'] > 0 ? $param['page'] : 1;


        $folderid = intval($this->input->get('folderid'));
        if($folderid > 0){
            $parameters['folderid'] = $folderid;
        }
        $startTime = $this->input->get('startTime');
        if(!empty($startTime)){
            $parameters['begindate'] = strtotime($startTime);
        }

        $endTime = $this->input->get('endTime');
        if( !empty($endTime)){
            $parameters['enddate'] = strtotime($endTime) + 86400;
        }

        //名字搜索
        $name = $this->input->get('name');

        if(!empty($name)){
            $parameters['name'] = $name;
        }


        $courses = $this->api->reSetting()
            ->setService('Classroom.Attendance.course')
            ->addParams($parameters)
            ->request();

        $pagestr = show_page($courses['total']);


        $folders = $this->api->reSetting()
            ->setService('Aroomv3.Course.courseList')
            ->addParams(array(
                'crid'  =>  $roominfo['crid'],
                'roominfo'  =>  $roominfo,
                'pagesize'  =>  10000
            ))
            ->request();

        $this->assign('page',$parameters['p']);
        $this->assign('pagestr',$pagestr);
        $this->assign('folders',$folders['courselist']);
        $this->assign('list',$courses['list']);
        $this->display('troomv2/attendance_course');
    }

    /**
     * 出勤统计页面
     */
    public function count_view(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $cwid = $this->uri->itemid;
        $parameters['crid'] = $roominfo['crid'];
        $parameters['cwid'] = $cwid;
        $parameters['uid'] = $user['uid'];
        //班级过滤
        $classid = intval($this->input->get('classid'));

        if($classid > 0){
            $parameters['classid'] = $classid;
        }

        $result = $this->api->reSetting()
            ->setService('Classroom.Attendance.count')
            ->addParams($parameters)
            ->request();

        //是否导出
        $export = intval($this->input->get('export'));

        //开始导出数据
        if($export > 0){
            $titleData = array('课件名称','课程','课件开始时间','班级','应到人数','已到人数','出勤率');
            $widtharr = array(20,20,20,20,20,20,20);
            $exportData = array();
            if(!empty($result['list'] )){
                foreach ($result['list'] as $data){

                    $exportData[] = array(
                        $result['course']['title'],
                        $result['course']['foldername'],
                        date('Y-m-d H:i:s',$result['course']['submitat']),
                        $data['classname'],
                        $data['student_count'],
                        $data['join_count'],
                        ($data['student_count'] > 0 ? intval($data['join_count']/$data['student_count'] * 100) : 0) . '%'
                    );
                }
            }
            $filename = '出勤列表'.date('YmdH:is');
            $this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);
            exit;
        }

        $this->assign('list',$result['list']);
        $this->assign('classes',$result['classes']);
        $this->assign('cwid',$cwid);
        $this->display('troomv2/attendance_count');
    }
    /**
     * 考勤
     */
    public function check_view(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $cwid = $this->uri->itemid;
        $param = parsequery();
        $parameters['crid'] = $roominfo['crid'];
        $parameters['cwid'] = $cwid;
        $parameters['p'] = $param['page'] > 0 ? $param['page'] : 1;
        $parameters['uid'] = $user['uid'];

        //班级过滤
        $classid = intval($this->input->get('classid'));

        if($classid > 0){
            $parameters['classid'] = $classid;
        }
        //名字搜索
        $name = $this->input->get('name');

        if(!empty($name)){
            $parameters['name'] = $name;
        }
        //时间范围过滤
        $startTime = $this->input->get('startTime');
        if(!empty($startTime)){
            $parameters['begindate'] = strtotime($startTime);
        }

        $endTime = $this->input->get('endTime');
        if( !empty($endTime)){
            $parameters['enddate'] = strtotime($endTime) + 86400;
        }
        //学习状态过滤
        $state = intval($this->input->get('state'));
        if($state > 0){
            $parameters['state'] = $state;
        }


        //是否导出
        $export = intval($this->input->get('export'));

        if($export > 0){
            $parameters['all'] = 1;
        }

        $userList = $this->api->reSetting()
            ->setService('Classroom.Attendance.check')
            ->addParams($parameters)
            ->request();
        //开始导出数据
        if($export > 0){
            $titleData = array('课件名称','课程','课件开始时间','进入课堂时间','班级','帐号','学习状态');
            $widtharr = array(20,20,20,20,20,20,20);
            $exportData = array();
            if(!empty($userList['list'] )){
                foreach ($userList['list'] as $data){

                    $exportData[] = array(
                        $userList['course']['title'],
                        $userList['course']['foldername'],
                        date('Y-m-d H:i:s',$userList['course']['submitat']),
                        $data['jointime'] > 0 ? date('Y-m-d H:i:s',$data['jointime']) : '--',
                        $data['classname'],
                        $data['realname'].'('.$data['username'].')',
                        $data['jointime'] > 0 ? '已学习' : '未学习'
                    );
                }
            }
            $filename = '考勤列表'.date('YmdH:is');
            $this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);
            exit;
        }


        $pagestr = show_page($userList['total']);

        $this->assign('pagestr',$pagestr);
        $this->assign('list',$userList['list']);
        $this->assign('classes',$userList['classes']);
        $this->assign('cwid',$cwid);
        $this->display('troomv2/attendance_check');
    }

    /**
     * 出勤详情
     */
    public function detail_view(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $cwid = $this->uri->itemid;
        $classid = intval($this->input->get('classid'));
        $param = parsequery();
        $parameters['crid'] = $roominfo['crid'];
        $parameters['cwid'] = $cwid;
        $parameters['p'] = $param['page'] > 0 ? $param['page'] : 1;
        $parameters['uid'] = $user['uid'];
        $parameters['classid'] = $classid;
        //名字搜索
        $name = $this->input->get('name');

        if(!empty($name)){
            $parameters['name'] = $name;
        }


        //学习状态过滤
        $state = intval($this->input->get('state'));
        if($state > 0){
            $parameters['state'] = $state;
        }
        //获取所有数据 不分页
        $parameters['all'] = 1;
        $userList = $this->api->reSetting()
            ->setService('Classroom.Attendance.check')
            ->addParams($parameters)
            ->request();
        $this->assign('course',$userList['course']);
        $pagestr = show_page($userList['total']);

        $this->assign('pagestr',$pagestr);

        $list = $userList['list'];
        //获取学习记录
        $uids = array_column($list,'uid');
        $playlog = $this->api->reSetting()
            ->setService('Study.Log.listv2')
            ->addParams(array(
                'uids'  =>  implode(',',$uids),
                'cwids' =>  $cwid
            ))
            ->request();



        foreach ($list as &$data){

            if(isset($playlog[$data['uid'].'_'.$cwid]) && $playlog[$data['uid'].'_'.$cwid]){
                $data['playcount'] = $playlog[$data['uid'].'_'.$cwid]['playcount'];
                $data['startdate'] = $playlog[$data['uid'].'_'.$cwid]['startdate'];
                $data['lastdate'] = $playlog[$data['uid'].'_'.$cwid]['lastdate'];
                $data['ctime'] = $playlog[$data['uid'].'_'.$cwid]['ctime'];
                $data['ltime'] = $playlog[$data['uid'].'_'.$cwid]['totalltime'];
            }else{
                $data['playcount'] = 0;
                $data['startdate'] = 0;
                $data['lastdate'] = 0;
                $data['ctime'] = 0;
                $data['ltime'] = 0;
            }
        }


        $list = $this->arraySort($list,'ltime','desc');


        //是否导出
        $export = intval($this->input->get('export'));


        if($export > 0){
            $titleData = array('课件名称','课程','课件开始时间','班级','帐号','手机号码','观看次数','首次学习时间','最后学习时间','视频总时长','累计学习时长');
            $widtharr = array(20,20,20,20,20,20,20,20,20,20,20);
            $exportData = array();
            if(!empty($list )){
                foreach ($list as $data){

                    $exportData[] = array(
                        $userList['course']['title'],
                        $userList['course']['foldername'],
                        date('Y-m-d H:i:s',$userList['course']['submitat']),
                        $data['classname'],
                        $data['realname'].'('.$data['username'].')',
                        empty($data['mobile']) ?  '--' : $data['mobile'],
                        $data['playcount'],
                        $data['startdate'] > 0 ? date('Y-m-d H:i:s',$data['startdate']) : '--',
                        $data['lastdate'] > 0 ? date('Y-m-d H:i:s',$data['lastdate']) : '--',
                        intval($userList['course']['cwlength'] / 60).'分'.intval($userList['course']['cwlength'] % 60).'秒',
                        intval($data['ltime'] / 60).'分'.intval($data['ltime'] % 60).'秒'
                    );
                }
            }
            $filename = '考勤详情'.date('YmdH:is');
            $this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);
            exit;
        }
        $pagestr = show_page($userList['total']);

        $this->assign('pagestr',$pagestr);
        $this->assign('list',$list);
        $this->assign('classes',$userList['classes']);
        $this->assign('cwid',$cwid);
        $this->display('troomv2/attendance_detail');
    }

    /**
     * 数据排序
     * @param $arr
     * @param $keys
     * @param string $type
     * @return array
     */
    private function arraySort($arr, $keys, $type = 'asc') {
        $keysvalue = $new_array = array();
        foreach ($arr as $k => $v){
            $keysvalue[$k] = $v[$keys];
        }
        $type == 'asc' ? asort($keysvalue) : arsort($keysvalue);
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) {
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }

    /**
     * 导出excel
     * @param Array array("编号",'用户名','性别'....)
     * @param Array array('1','李华','男'...)
     * @param String rgbColor
     * @param String execl文件名称
     *
     */
    protected  function _exportExcel($titleArr,$dataArr,$titleColor="FF808080",$name,$manuallywidth=array()){

        set_time_limit(0);
        $objPHPExcel = Ebh::app()->lib('PHPExcel');

        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");

        // 设置列表标题
        if(is_array($titleArr)){
            $str = "A";
            foreach($titleArr as $k=>$v){
                $p = $str++.'1';//列A1,B1,C1,D1
                if(empty($manuallywidth))
                    $objPHPExcel->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);//设置列宽_自适应
                $pt = $objPHPExcel->getActiveSheet()->getStyle($p);

                $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                $pt->getFont()->setSize(14);
                $pt->getFont()->setBold(true);

                //$pt->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//设置列填充模式 solid
                $pt->getFill()->getStartColor()->setARGB($titleColor);//设置列填充颜色
                //$pt->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//设置列边宽
                $objPHPExcel->getActiveSheet()->setCellValue($p, $v);//设置列名称
            }
        }
        //传值
        if(is_array($dataArr)){
            foreach ($dataArr as $k=>$v) {
                $str = "A";
                foreach($titleArr as $kt=>$vt){
                    $p = $str.($k+2);//从第二列填充内容 A22,B22...A33 B33
                    $pt = $objPHPExcel->getActiveSheet();
                    if(empty($manuallywidth))
                        $pt->getColumnDimension($str)->setAutoSize(true);//单元格每项内容自适应
                    if(is_numeric($v[$kt])){
                        if(empty($manuallywidth))
                            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);//A列头标题自适应
                        $pt->getStyle($p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);//设置单元格文本存储类型
                        $pt->getColumnDimension($str)->setWidth(20);//设置单元格宽度
                        $pt->setCellValue($p, $v[$kt].' ');//填充内容
                    }else{
                        $pt->setCellValue($p, ' '.$v[$kt]);
                    }

                    $str++;
                }
            }
        }
        if(!empty($manuallywidth)){
            $str = 'A';
            foreach($manuallywidth as $width){
                $objPHPExcel->getActiveSheet()->getColumnDimension($str)->setWidth($width);
                $str++;
            }
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