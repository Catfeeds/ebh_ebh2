<?php

/**
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/4/7
 * Time: 9:38
 */
class CoursewareController extends ARoomV3Controller {
    /**
     * 热门课件列表
     * 根据$num返回条数，默认为4
     */
    public function hotCoursewareList() {
        $num = intval($this->input->get('num'));
        if ($num < 1) {
            $num = 4;
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Courseware.hotList')
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('num', $num)
            ->request();
        if (!empty($ret)) {
            //处理课件封面
            array_walk($ret, function(&$v, $k) {
                if (!empty($v['logo'])) {
                    return;
                }
                if (!empty($v['islive'])) {
                    $ret['logo'] = 'http://static.ebanhui.com/ebh/tpl/2014/images/livelogo.jpg';
                    return;
                }
                $ext = ltrim(strrchr($v['logo'], '.'), '.');
                if (in_array($ext, array('flv', 'mp4', 'avi', 'mpeg', 'mpg', 'rmvb', 'rm', 'mov', 'swf'))) {
                    $v['logo'] = 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png';
                    return;
                }
                switch ($ext) {
                    case 'ppt':
                    case 'doc':
                    case 'mp3':
                    case 'rar':
                        break;
                    case '7z':
                    case 'zip':
                        $ext = 'rar';
                        break;
                    default:
                        $ext = 'attach';
                        break;
                }
                $v['logo'] = 'http://static.ebanhui.com/ebh/tpl/2014/images/'.$ext.'.png';
            });
        }
        $this->renderjson(0, '', $ret);
    }
	
	/*
	 * 课件学习统计 ，所有的班级及课件
	*/
	public function statsClassCw(){
		$data['crid'] = $this->roominfo['crid'];
		$data['pagesize'] = $this->input->get('pagesize');
		$data['page'] = $this->input->get('page');
		$data['q'] = $this->input->get('q');
		$data['cwid'] = $this->input->get('cwid');
		$cwlist = $this->apiServer->reSetting()->setService('Aroomv3.Courseware.statsClassCw')->addParams($data)->request();
		
		$this->renderjson(0,'',$cwlist);
	}
	
	/*
	 * 保存班级，课件关联
	*/
	public function saveClassCwStats(){
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$data['cwid'] = $this->input->post('cwid');
		$data['itemid'] = $this->input->post('itemid');
		$classids = $this->input->post('classids');
		$data['isclear'] = $this->input->post('isclear');//是否清空操作
		$data['path'] = $this->input->post('path');
		if(empty($classids)){
			$classids = array();
			$data['isclear'] = 1;
		}
		if(empty($data['cwid']) || empty($data['isclear']) && (empty($data['itemid']) || !is_array($classids))){
			$this->renderjson(1,'参数不正确');
		}
		if(empty($data['isclear'])){//不是清空操作
			$data['classids'] = array_unique($classids);
		}
		
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Courseware.saveClassCwStats')->addParams($data)->request();
		if(!empty($result)){
			$this->renderjson(0,'操作成功');
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
	
	/*
	 * 课件学习统计,班级-课程-课件
	*/
	public function classCwStudyStats(){
		$data['crid'] = $this->roominfo['crid'];
		$data['pagesize'] = $this->input->get('pagesize');
		$data['page'] = $this->input->get('page');
		$data['starttime'] = $this->input->get('starttime');
		$data['endtime'] = $this->input->get('endtime');
		$data['classid'] = $this->input->get('classid');
		$data['itemid'] = $this->input->get('itemid');
		$data['q'] = $this->input->get('q');
		
		$cwlist = $this->apiServer->reSetting()->setService('Aroomv3.Courseware.classCwStudyStats')->addParams($data)->request();
		$this->renderjson(0,'',$cwlist);
	}
}