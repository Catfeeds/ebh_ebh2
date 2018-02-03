<?php
/**
 * ebh2.
 * User: ycq
 * 部门
 */
class DeptController extends CControl{
    public function __construct() {
        parent::__construct();
        $this->apiServer = Ebh::app()->getApiServer('ebh');
    }

    /**
     * 部门列表
     */
    public function index(){
        //清除缓存区数据
        @ob_end_clean();
        header('Content-Type: application/json; charset=utf-8');
        $roomInfo = ebh::app()->room->getcurroom();
        if (empty($roomInfo)) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法访问'
            ));
            exit();
        }
        $params = array(
            'crid' => $roomInfo['crid'],
            'deptName' => trim($this->input->get('deptname'))
        );
        $number = intval($this->input->get('number'));
        if ($number > 0) {
            $params['number'] = $number;
        }
        $deptlist = $this->apiServer->reSetting()
            ->setService('Aroomv3.Enterprise.getDeptList')
            ->addParams($params)
            ->request();
        echo json_encode(array(
            'errno' => 0,
            'data' => $deptlist
        ));
        exit();
    }

    /**
     * 验证部门是否有效(部门名称与编号是否有效对应)
     * 验证成功返回部门ID
     */
    public function verify() {
        //清除缓存区数据
        @ob_end_clean();
        header('Content-Type: application/json; charset=utf-8');
        $roomInfo = ebh::app()->room->getcurroom();
        if (empty($roomInfo)) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法访问'
            ));
            exit();
        }
        $deptname = trim($this->input->get('deptname'));
        if ($deptname == '') {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '部门名称不能为空'
            ));
            exit();
        }
        $code = trim($this->input->get('code'));
        if ($code == '') {
            echo json_encode(array(
                'errno' => 3,
                'msg' => '部门编号不能为空'
            ));
            exit();
        }
        $params = array(
            'crid' => $roomInfo['crid'],
            'deptName' => $deptname,
            'code' => $code
        );
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Enterprise.verify')
            ->addParams($params)
            ->request();
        if ($ret === false) {
            echo json_encode(array(
                'errno' => 10,
                'msg' => '部门验证失败'
            ));
            exit();
        }
        echo json_encode(array(
            'errno' => 0,
            'data' => intval($ret)
        ));
        exit();
    }
}