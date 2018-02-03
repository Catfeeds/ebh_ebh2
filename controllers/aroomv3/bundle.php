<?php
/**
 * 课程包
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/8/22
 * Time: 13:33
 */
class bundleController extends ARoomV3Controller
{
    public function __construct()
    {
        parent::__construct();
        if (defined('IS_DEBUG') && IS_DEBUG) {
            @ob_end_clean();
            header('Content-Type: application/json; charset=utf-8');
        }
    }

    /**
     * 课程包编辑
     */
    public function edit()
    {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法操作');
        }
        $name = trim($this->input->post('name'));
        if (empty($name)) {
            $this->renderjson(1, '课程包名称不能为空');
        }
        $remark = trim($this->input->post('remark'));
        if (empty($remark)) {
            $this->renderjson(1, '课程包简介不能为空');
        }
        $pid = intval($this->input->post('pid'));
        if ($pid < 1) {
            $this->renderjson(1, '课程大类不能为空');
        }
        $speaker = trim($this->input->post('speaker'));
        if (empty($speaker)) {
            $this->renderjson(1, '课程包主讲老师不能为空');
        }
        $itemids = $this->input->post('itemids');
        if (empty($itemids) || !is_array($itemids)) {
            $this->renderjson(1, '课程包课程不能为空');
        }
        $itemids = array_map('intval', $itemids);
        $itemids = array_filter($itemids, function($itemid) {
           return $itemid > 0;
        });
        if (empty($itemids)) {
            $this->renderjson(1, '课程包课程不能为空');
        }
        $bid = intval($this->input->post('bid'));
        $sid = $this->input->post('sid');
        if ($sid !== null && is_numeric($sid)) {
            $sid = intval($sid);
        } else {
            $sid = null;
        }
        $params = array(
            'name' => $name,
            'remark' => $remark,
            'pid' => $pid,
            'sid' => $sid,
            'speaker' => $speaker,
            'bprice' => floatval($this->input->post('bprice')),
            'uid' => $this->user['uid'],
            'crid' => $this->roominfo['crid'],
            'itemids' => $itemids,
            'cover' => $this->input->post('cover'),
            'detail' => $this->input->post('detail'),
			'cannotpay' => intval($this->input->post('cannotpay')),
			'limitnum' =>$this->input->post('limitnum'),
			'islimit' =>$this->input->post('islimit'),
        );
        if ($bid > 0) {
            $params['bid'] = $bid;
        }

        $ret = $this->apiServer->reSetting()
            ->setService('CourseService.Bundle.edit')
            ->addParams($params)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '课程包'.($bid > 0 ? '修改失败' : '添加失败'));
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 课程包列表
     */
    public function index() {
        $params = array(
            'crid' => $this->roominfo['crid'],
            'pid' => intval($this->input->get('pid')),
            'k' => trim($this->input->get('k')),
            'page' => intval($this->input->get('page')),
            'pagesize' => intval($this->input->get('pagesize'))
        );
        $sid = $this->input->get('sid');
        if (!empty($params['pid']) && $sid !== null) {
            $params['sid'] = intval($sid);
        }
        $ret = $this->apiServer->reSetting()
            ->setService('CourseService.Bundle.index')
            ->addParams($params)
            ->request();
		if(!empty($ret['list'])){
			$bids = array_column($ret['list'],'bid');
			$bids = implode(',',$bids);
			$needoc = $this->input->get('needoc');
			//查询课程开通人数
			if(!empty($bids) && !empty($needoc)){
				$ocdata['bid'] = $bids;
				$ocdata['crid'] = $this->roominfo['crid'];
				$ocdata['islist'] = TRUE;
				$opencount = $this->apiServer->reSetting()->setService('Classroom.Item.openCount')->addParams($ocdata)->request();
				foreach($ret['list'] as $key=>&$bundle){
					$bundle['opencount'] = empty($opencount[$bundle['bid']])?0:$opencount[$bundle['bid']]['opencount'];
				}
			}
		}
		
        if (!empty($ret)) {
            $viewlib = Ebh::app()->lib('Viewnum');
            array_walk($ret['list'], function(&$course, $k, $lib) {
                $course['viewnum'] = 0;
                foreach ($course['folderids'] as $fid => $viewnum) {
                    $course['viewnum'] = $lib->getViewnum('folder', $fid, $viewnum);
                }
            }, $viewlib);
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 删除课程包
     */
    public function remove() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法操作');
        }
        $bid = intval($this->input->post('bid'));
        if ($bid < 1) {
            $this->renderjson(1, '缺少参数');
        }
        $ret = $this->apiServer->reSetting()
            ->setService('CourseService.Bundle.remove')
            ->addParams('bid', $bid)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '课程包删除失败');
        }
        $this->renderjson(0, '课程包删除成功');
    }

    /**
     * 课程包详情
     */
    public function detail() {
        $params = array(
            'crid' => $this->roominfo['crid'],
            'bid' => intval($this->input->get('bid')),
        );
        if ($params['bid'] < 1) {
            $this->renderjson(1, '缺少参数');
        }
        $ret = $this->apiServer->reSetting()
            ->setService('CourseService.Bundle.detail')
            ->addParams($params)
            ->request();
        $this->renderjson(0, '', $ret);
    }

    /**
     * 课程包教师选择
     */
    public function teachers() {
        $params = array(
            'crid' => $this->roominfo['crid'],
            'bid' => intval($this->input->get('bid')),
        );
        if ($params['bid'] < 1) {
            $this->renderjson(1, '缺少参数');
        }
        $ret = $this->apiServer->reSetting()
            ->setService('CourseService.Bundle.teachers')
            ->addParams($params)
            ->request();
        $this->renderjson(0, '', $ret);
    }

    /**
     * 设置课程包老师
     */
    public function setTeachers() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法操作');
        }
        $bid = intval($this->input->post('bid'));
        if ($bid < 1) {
            $this->renderjson(1, '缺少参数');
        }
        $tids = $this->input->post('tids');
        if (empty($tids) || !is_array($tids)) {
            $this->renderjson(1, '缺少参数');
        }
        $tids = array_map('intval', $tids);
        $tids = array_filter($tids, function($tid) {
            return $tid > 0;
        });
        if (empty($tids)) {
            $this->renderjson(1, '缺少参数');
        }
        $ret = $this->apiServer->reSetting()
            ->setService('CourseService.Bundle.setTeachers')
            ->addParams('bid', $bid)
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('tids', $tids)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '课程包教师设置失败');
        }
        $this->renderjson(0, '课程包教师设置成功');
    }
}
