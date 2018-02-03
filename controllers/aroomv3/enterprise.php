<?php
/**
 * 企业网校组织管理接口
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/4/28
 * Time: 13:33
 */
class EnterpriseController extends ARoomV3Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 部门管理
     */
    public function deptment() {
        $uid = $this->roominfo['uid'] != $this->user['uid'] ? $this->user['uid'] : 0;
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Enterprise.index')
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('crname', $this->roominfo['crname'])
            ->addParams('show_teachers', intval($this->input->get('show_teacher')))
            ->addParams('uid', $uid > 0 ? $uid : 0)
            ->request();
        if (!empty($ret)) {
            $ret = array_values($ret);
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 添加部门
     */
    public function addDeptment() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法访问');
        }
        $superiorId = intval($this->input->post('superiorid'));
        if ($superiorId < 0) {
            $this->renderjson(1, '无操作权限');
        }
        $deptname = trim($this->input->post('deptname'));
        $displayorder = intval($this->input->post('displayorder'));
        $code = trim($this->input->post('code'));

        if ($superiorId < 0 || empty($deptname)) {
            $this->renderjson(1, '必需数据为空，添加失败。');
        }
        $deptname = str_replace('/', '', $deptname);
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Enterprise.addDeptment')
            ->addParams(array(
                'crid' => $this->roominfo['crid'],
                'superiorid' => $superiorId,
                'deptname' => $deptname,
                'displayorder' => $displayorder,
                'code' => $code,
                'uid' => $this->roominfo['uid'] != $this->user['uid'] ? $this->user['uid'] : 0
            ))
            ->request();

        if ($ret['newid'] == -1) {
            $this->renderjson(1, '部门名称已存在，添加失败');
        }
        if ($ret['newid'] == -2) {
            $this->renderjson(1, '部门编号已存在，添加失败');
        }
        if (empty($ret['newid'])) {
            $this->renderjson(1, '添加失败');
        }
        $this->renderjson(0, '添加成功', intval($ret['newid']));
    }

    /**
     * 修改部门
     */
    public function updateDeptment() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法访问');
        }
        $classid = intval($this->input->post('classid'));
        if ($classid < 1) {
            $this->renderjson(1, '必需数据为空，添加失败。');
        }
        $deptname = trim($this->input->post('classname'));
        $displayorder = intval($this->input->post('displayorder'));
        $code = trim($this->input->post('code'));
        if (empty($deptname) && $displayorder < 0 && empty($code)) {
            $this->renderjson(1, '未做修改');
        }
        $deptname = str_replace('/', '', $deptname);
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Enterprise.updateDeptment')
            ->addParams(array(
                'crid' => $this->roominfo['crid'],
                'classid' => $classid,
                'deptname' => $deptname,
                'displayorder' => $displayorder,
                'code' => $code
            ))
            ->request();
        if ($ret == -1) {
            $this->renderjson(1, '部门名已存在，修改失败');
        }
        if ($ret == -2) {
            $this->renderjson(1, '部门编号已存在，修改失败');
        }
        if (empty($ret)) {
            $this->renderjson(1, '未做修改');
        }
        $this->renderjson(0, '修改成功');
    }

    /**
     * 删除部门
     */
    public function remove() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法访问');
        }
        $classid = intval($this->input->post('classid'));
        if ($classid < 1) {
            $this->renderjson(1, '必需数据为空，删除失败。');
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Enterprise.remove')
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('classid', $classid)
            ->request();
        if ($ret > 0) {
            $this->renderjson(0, '删除成功');
        }
        $message = array(
            -100 => '该部门下还有讲师，不能删除！',
            -101 => '该部门下还有员工，不能删除！'
        );
        $this->renderjson(1, isset($message[$ret]) ? $message[$ret] : '删除失败');
    }

    /**
     * 批量修改员工部门
     */
    public function batchChangeDept() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法访问');
        }
        $classid = intval($this->input->post('classid'));
        if ($classid < 1) {
            $this->renderjson(1, '目标部门ID参数错误');
        }
        $staffid = $this->input->post('staffid');
        if ($staffid == null) {
            $this->renderjson(1, '缺少员工ID参数');
        }
        if (is_array($staffid)) {
            $staffid = array_map('intval', $staffid);
        } else {
            $staffid = array(intval($staffid));
        }

        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Enterprise.batchChangeDept')
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('classid', $classid)
            ->addParams('staffid', $staffid)
            ->request();
        if ($ret < 0) {
            $this->renderjson(0, '不能将员工转移到中间部门');
        }
        if (empty($ret)) {
            $this->renderjson(1, '修改失败');
        }
        $this->renderjson(0, '已更改'.$ret.'个员工的所在部门', array(), false);

        fastcgi_finish_request();
        Ebh::app()->lib('xNums')->add('user');
        //更新SNS的学校学生、班级学生缓存
        $snslib = Ebh::app()->lib('Sns');

        $uclassids = $this->model('classes')->getStudentClassId($staffid, $this->roominfo['crid']);
        foreach ($uclassids as $uclassid) {
            $snslib->updateClassUserCache(array('classid'=>$uclassid['classid'],'uid'=>$uclassid['uid']));
            $snslib->updateRoomUserCache(array('crid'=>$this->roominfo['crid'],'uid'=>$uclassid['uid']));

            /**新增学生课程权限开始**/
            //todo 未修改为服务层
            $classCourseModel = $this->model('Classcourses');
            $userpermissionModel = $this->model('Userpermission');
            if ($this->roominfo['property'] == 3) {
                $folderids = $classCourseModel->getDeptMentFolderIds($uclassid['classid'], $this->roominfo['crid']);
            } else {
                $folderids = $classCourseModel->getfolderidsbyclassid($uclassid['classid']);
            }

            if(!empty($folderids)){
                foreach ($folderids as $folder){
                    $fids[] = $folder['folderid'];
                }
                $param['itemid'] = 0;
                $param['folderids'] = $fids;
                $param['crid'] = $this->roominfo['crid'];
                $param['uid'] = $uclassid['uid'];
                $param['type'] = 2;
                $param['classid'] = $uclassid['classid'];
                $param['dateline'] = SYSTIME;
                $param['property'] = $this->roominfo['property'];
                $userpermissionModel->mutifAddPermission($param);
            }
            //企业选课用户权限
            if($this->roominfo['isschool'] == 7 && $this->roominfo['property'] == 3){//企业选课
                $itemlist = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.deptItemList')
                    ->addParams('classid', $uclassid['classid'])
                    ->addParams('crid', $this->roominfo['crid'])
                    ->request();
                if(!empty($itemlist)){
                    $data['uids'] = array($uclassid['uid']);
                    $data['itemlist'] = $itemlist;
                    $data['classid'] = $uclassid['classid'];
                    $res = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.addUserPermision')->addParams($data)->request();
                    // var_dump($res);
                }
            }
            /**新增学生课程权限结束**/

            //调用SNS同步接口，类型为4用户网校操作
            $snslib->do_sync($uclassid['uid'], 4);
        }
    }

    /**
     * 批量导入部门
     */
    public function input() {
        $superior = intval($this->input->get('superior'));
        $this->assign('superior', $superior);
        if (!$this->isPost()) {
            $this->display('aroomv3/deptments_input');
            return;
        }
        $superior = intval($this->input->post('superior'));
        $msg = '';
        if ($superior < 1) {
            $msg = '上级部门不能为空';
        }
        if (empty($msg) && empty($_FILES['excel'])) {
            //文件未上传
            $msg = '请上传Excel文件';
        }
        if (empty($msg) && $_FILES['excel']['error'] > 0) {
            //文件上传失败
            $msg = '文件上传失败';
        }
        if (empty($msg)) {
            $reader = Ebh::app()->lib('PhpExcelReader');
            $reader->setOutputEncoding('UTF-8');
            $r = $reader->read($_FILES['excel']['tmp_name']);
            if($r === false) {    //不支持的文件格式
                $msg = '不支持的文件格式';
            }
        }
        if (empty($msg)) {
            //处理Excel文件
            $rowCount = $reader->sheets[0]['numRows'];
            $colCount = $reader->sheets[0]['numCols'];
            $rowIndex = -1;
            for ($i = 1; $i <= $rowCount; $i++) {
                $nameIndex = $codeIndex = -1;
                for ($j = 1; $j <= $colCount; $j++) {
                    if (empty($reader->sheets[0]['cells'][$i][$j])) {
                        continue;
                    }
                    $cell = trim($reader->sheets[0]['cells'][$i][$j]);
                    if ($cell == '部门名称') {
                        $nameIndex = $j;
                        continue;
                    }
                    if ($cell == '部门编号（选填）') {
                        $codeIndex = $j;
                        continue;
                    }
                }
                if ($nameIndex > 0 && $codeIndex > 0) {
                    $rowIndex = $i + 1;
                    break;
                }
            }
            if ($rowIndex < 0) {
                $msg = '文件内容错误';
            }
        }
        if (empty($msg)) {
            $deptments = $names = $codes = $requires = $disableds = array();
            for ($i = $rowIndex; $i <= $rowCount; $i++) {
                if (empty($reader->sheets[0]['cells'][$i][$nameIndex]) && empty($reader->sheets[0]['cells'][$i][$codeIndex])) {
                    continue;
                }
                $name = trim($reader->sheets[0]['cells'][$i][$nameIndex]);
                $code = !empty($reader->sheets[0]['cells'][$i][$codeIndex]) ? trim($reader->sheets[0]['cells'][$i][$codeIndex]) : '';
                if ($name == '' && $code == '') {
                    continue;
                }
                $err = false;
                if ($name == '') {
                    $err = true;
                    $requires[] = '第'.$i.'行部门名称为空';
                }
                if ($code != '' && !preg_match('/^[a-z0-9]+$/i', $code)) {
                    $err = true;
                    $disableds[] = '第'.$i.'行部门编号格式错误';
                }
                if ($err) {
                    continue;
                }
                $deptments[] = array('deptname' => $name, 'code' => $code);
                $names[$name][] = $i;
                if ($code != '') {
                    $codes[$code][] = $i;
                }

            }
            $names = array_filter($names, function($name) {
                return count($name) > 1;
            });
            $codes = array_filter($codes, function($code) {
                return count($code) > 1;
            });
            $repeats = array();
            if (!empty($names)) {
                foreach ($names as $nameIndex => $name) {
                    $repeatRows = implode('、', $name);
                    $repeats[] = '第'.$repeatRows.'行的部门名称重复。';
                }
            }
            if (!empty($codes)) {
                foreach ($codes as $codeIndex => $code) {
                    $repeatRows = implode('、', $code);
                    $repeats[] = '第'.$repeatRows.'行的部门编号重复。';
                }
            }
            $msg = array_merge($requires, $disableds, $repeats);
        }
        if (empty($msg) && empty($deptments)) {
            $msg = '文件为空，未做导入操作';
        }
        $this->assign('msg', $msg);
        $this->assign('wait', !empty($msg) ? false : true);
        $this->display('aroomv3/deptments_input');
        if (!empty($msg)) {
            exit();
        }
        fastcgi_finish_request();
        $redis = Ebh::app()->getCache('cache_redis');
        $redis->remove('Deptments-Import-'.$this->roominfo['crid']);
        if (empty($msg)) {
            $params = array(
                'crid' => $this->roominfo['crid'],
                'superiorId' => $superior,
                'deptments' => json_encode($deptments)
            );
            if ($this->roominfo['uid'] != $this->user['uid']) {
                $params['uid'] = $this->user['uid'];
            }
            $result = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.importDeptments')->addParams($params)->request();
            if (!empty($result) && empty($result['errno'])) {
                $msg = '导入操作完成。';
            } else {
                $msg = !empty($result['msg']) ? $result['msg'] : '未知错误';
            }
            $redis->set('Deptments-Import-'.$this->roominfo['crid'], $msg);
        }
        $roominfo = ebh::app()->room->getcurroom();
        /**写日志开始**/
        $message = '批量导入：部门';
        Ebh::app()->lib('LogUtil')->add(
            array(
                'toid'=>$roominfo['crid'],
                'message'=> $message,
                'opid'=> 1,
                'type'=> 'roomuser'
            )
        );
        /**写日志结束**/
        exit;
    }

    /**
     * 获取导入状态
     */
    public function getImportResult() {
        $redis = Ebh::app()->getCache('cache_redis');
        $msg = $redis->get('Deptments-Import-'.$this->roominfo['crid']);
        if ($msg === false) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '正在执行'
            ));
            exit();
        }
        echo json_encode(array(
            'errno' => 0,
            'msg' => $msg
        ));
        $redis->remove('Deptments-Import-'.$this->roominfo['crid']);
        exit();
    }
}