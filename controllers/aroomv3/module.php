<?php
/**
 * 模块设置
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/3/18
 * Time: 10:02
 */
class moduleController extends ARoomV3Controller
{
    /**
     * 模块配置信息
     */
    public function index()
    {
        $tor = intval($this->input->get('tor'));
        if (!in_array($tor, array(0, 1))) {
            $tor = 0;
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Module.modules')
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('tor', $tor)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '网校不存在');
        }
        $room_type = Ebh::app()->room->getRoomType();
        $room_type = $room_type == 'com' ? 1 : 0;
        $replaces = array();
        //当前为企业版时替换数组中对应的名称
        if ($room_type === 1){
            $replaces = $replaces + array (
                '学生' => '员工',
                '同学' => '同事',
                '老师' => '讲师',
                '教师' => '讲师',
                '学校' => '公司',
                '网校' => '平台',
                '班级' => '部门'
            );
        }
        $otherconfig = Ebh::app()->getConfig()->load('othersetting');
        if (isset($otherconfig['leblue']) && $otherconfig['leblue'] == $this->roominfo['crid']) {
            //老年大学模块说明将员工替换为老人
            $replaces['员工'] = '老人';
        }
        if (!empty($replaces)) {
            //文字替换
            array_walk_recursive($ret, function(&$item, $k, $replaces) {
                if (!in_array($k, array('nickname', 'remark'))) {
                    return;
                }
                foreach ($replaces as $search => $replace){
                    $item = str_replace($search, $replace, $item);
                }
            }, $replaces);
        }

        $this->renderjson(0, '', $ret);
    }

    /**
     * 模块配置更新
     */
    public function update() {
        if (!$this->isPost()) {
            $this->renderjson(1, '操作方式错误');
        }
        $tor = intval($this->input->post('tor'));
        if (!in_array($tor, array(0, 1))) {
            $this->renderjson(1, '模块错误');
        }

        $data = $this->input->post('data');

        if (empty($data) || !is_array($data)) {
            $this->renderjson(1, '参数错误');
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Module.update')
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('tor', $tor)
            ->addParams('data', $data)
            ->request();
        if ($ret ===  false) {
            $this->renderjson(1, '模块更新失败');
        }
        $roomcache = Ebh::app()->lib('Roomcache');
        $modulekey = array('name'=>'appmodule','tors'=>$tor);
        $roomcache->removeCache($this->roominfo['crid'],'other',$modulekey);
        $this->renderjson(0, '模块更新成功');
    }
	
	/*
	 *需要显示的特定页面模块
	*/
	public function necessaryModule(){
		$data['crid'] = $this->roominfo['crid'];
		$list = $this->apiServer->reSetting()->setService('Aroomv3.Module.necessaryModule')->addParams($data)->request();
		$this->renderjson(0,'',$list);
	}
}