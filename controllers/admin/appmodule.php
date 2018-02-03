<?php
/**
 *应用模块控制器
*/
class AppmoduleController extends AdminControl{
	public function index(){
		
		$this->display('admin/appmodule');
	}
	
	public function getListAjax(){
		$queryArr['q'] = $this->input->post('query');
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		
		$ammodel = $this->model('appmodule');
		$list = $ammodel->getmodulelist($queryArr);
		$total = $ammodel->getmodulecount($queryArr);
		array_unshift($list, array('total'=>$total));
		echo json_encode($list);
	}
	
	public function add(){
		if($this->input->post()){
			$param['modulename'] = $this->input->post('modulename');
			$param['modulename_t'] = $this->input->post('modulename_t');
			$param['modulecode'] = $this->input->post('modulecode');
			$param['url'] = $this->input->post('url');
			$param['url_t'] = $this->input->post('url_t');
			$param['system'] = $this->input->post('system')?$this->input->post('system'):0;
			$param['classname'] = $this->input->post('classname');
			$param['target'] = $this->input->post('target');
			$param['isstrict'] = $this->input->post('isstrict')?$this->input->post('isstrict'):0;
			$param['tors'] = $this->input->post('tors');
			$param['showmode'] = $this->input->post('showmode');
			$param['ismore'] = $this->input->post('ismore');
			$param['remark'] = trim($this->input->post('remark'));
            $param['remark_t'] = trim($this->input->post('remark_t'));
			$ammodel = $this->model('appmodule');
			$ammodel->addappmodule($param);
			$this->goback();
		}			
		else
			$this->display('admin/appmodule_add');
	}
	public function edit(){
		$ammodel = $this->model('appmodule');
		if($this->input->post()){
			$param['moduleid'] = $this->input->post('moduleid');
			$param['modulename'] = $this->input->post('modulename');
			$param['modulename_t'] = $this->input->post('modulename_t');
			$param['modulecode'] = $this->input->post('modulecode');
			$param['url'] = $this->input->post('url');
			$param['url_t'] = $this->input->post('url_t');
			$param['system'] = $this->input->post('system')?$this->input->post('system'):0;
			$param['classname'] = $this->input->post('classname');
			$param['target'] = $this->input->post('target');
			$param['isstrict'] = $this->input->post('isstrict')?$this->input->post('isstrict'):0;
			$param['tors'] = $this->input->post('tors');
			$param['showmode'] = $this->input->post('showmode');
            $param['remark'] = trim($this->input->post('remark'));
            $param['remark_t'] = trim($this->input->post('remark_t'));
            $param['ismore'] = intval($this->input->post('ismore')) == 1 ? 1 : 0;
			$ammodel = $this->model('appmodule');
			$ret = $ammodel->editappmodule($param);
			if (!empty($ret)) {
			    //修改成功
                $ammodel->syncRoomModule($param['moduleid']);
            }
			$this->goback();
		}			
		else{
			$moduleid = $this->input->get('moduleid');
			$module = $ammodel->getmoduleinfo($moduleid);
			$this->assign('module',$module);
			$this->display('admin/appmodule_edit');
		}
	}
	
	/*
	设置过应用模块的网校列表
	*/
	public function permission(){
		$this->display('admin/appmodule_permission');
	}
	/**
	 * [getListAjaxPermission 通过ajax获取列表]
	 * @return [type] [description]
	 */
	public function getListAjaxPermission(){
		$queryArr['q'] = $this->input->post('query');
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		if(!empty($queryArr['q'])){
			$CModel = $this->model('classroom');
			$total = $CModel->getclassroomcount($queryArr);
			$list = $CModel->getclassroomlist($queryArr);
		}else{
			$ammodel = $this->model('appmodule');
			$list = $ammodel->getclassroomlist($queryArr);
			$total = $ammodel->getclassroomcount($queryArr);
		}
		array_unshift($list, array('total'=>$total));
		echo json_encode($list);
	}
	/**
	 * [viewmodel 展示appmodule_view 页面]
	 * @return [type] [description]
	 */
	public function viewmodel(){
		$moduleid = intval($this->input->get('moduleid'));
		$this->assign('moduleid',$moduleid);
		$this->display('admin/appmodule_view');
	}
	/**
	 * [getListAjaxModule 通过ajax进行对应模块及搜索框的内容进行筛选]
	 * @return [type] [description]
	 */
	public function getListAjaxModule(){
		$queryArr['q'] = $this->input->post('query');
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		$queryArr['moduleid'] = intval($this->input->get('moduleid'));
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		$ammodel = $this->model('appmodule');
		$list = $ammodel->getclassroomlistbymid($queryArr);
		$total = $ammodel->getclassroomcountbymid($queryArr);
		array_unshift($list, array('total'=>$total));
		echo json_encode($list);
	}
	/*
	编辑网校权限
	*/
	public function classroomedit(){
		if($this->input->post()){
			// var_dump($this->input->post());
			$availablearr = $this->input->post('available');
			$crid = $this->input->post('crid');
			if(!empty($availablearr)){
				$ammodel = $this->model('appmodule');
				$ret = $ammodel->roommoduleedit(array('crid'=>$crid,'modulelist'=>$availablearr), true);
                if ($ret) {
                    $defind_shop_module = 32;
                    //更新网校导航配置
                    $shop_module_id = 0;
                    foreach ($availablearr as $availableid) {
                        if ($availableid == $defind_shop_module) {
                            $shop_module_id = $defind_shop_module;
                            break;
                        }
                    }
                    $room_model = $this->model('Classroom');
                    $navigator_sourse = $room_model->getNavigator($crid);
                    $navigator = unserialize($navigator_sourse);
                    $nav_shop_key = false;
                    foreach ($navigator['navarr'] as $navkey => $nav) {
                        if ($nav['code'] == 'shop') {
                            $nav_shop_key = $navkey;
                            break;
                        }
                    }
                    $edited = false;
                    if ($shop_module_id == 0 && $nav_shop_key !== false) {
                        //删除商城链接
                        unset($navigator['navarr'][$nav_shop_key]);
                        $edited = true;
                    } else if($shop_module_id > 0 && $nav_shop_key === false) {
                        //添加商城链接
                        $shop_module = $ammodel->getmoduleinfo($defind_shop_module);
                        $navigator['navarr'][] = array(
                            'code' => 'shop',
                            'name' => !empty($shop_module) ? $shop_module['modulename'] : '网校商城',
                            'nickname' => !empty($shop_module) ? $shop_module['modulename'] : '网校商城',
                            'available' => 1,
							'url'=>'/shop.html'
                        );
                        $edited = true;
                    } else if($shop_module_id > 0 && $nav_shop_key !== false) {
                        //启用商城链接
                        $shop_module = $ammodel->getmoduleinfo($defind_shop_module);
                        $navigator['navarr'][$nav_shop_key]['name'] = !empty($shop_module) ? $shop_module['modulename'] : '网校商城';
                        $navigator['navarr'][$nav_shop_key]['nickname'] = !empty($shop_module) ? $shop_module['modulename'] : '网校商城';
                        $navigator['navarr'][$nav_shop_key]['available'] = true;
                        $edited = true;
                    }
                    if ($edited) {
                        //更新导航
                        $param['crid'] = $crid;
                        $param['navigator'] = serialize($navigator);
                        if(mb_strlen($param['navigator'],'UTF-8') <= 5000){
                            $res = $room_model->editclassroom($param);
                            if ($res) {
                                $roomcache = Ebh::app()->lib('Roomcache');
                                $roomcache->removeCache($crid,'navigator','plate-navigation');
                                //更新导航成功后刷新导航相关缓存
                                updateRoomCache($crid, 'navigator');
                            }
                        }
                    }
                }
				$this->goback('/admin/appmodule/permission.html');
			}else{
				
			}
		}else{
			$crid = $this->input->get('crid');
			$ammodel = $this->model('appmodule');
			$roommodulelist = $ammodel->getmodulelist(array('limit' => 1000), true);
            array_walk($roommodulelist, function(&$module) {
                $module['available'] = !empty($module['system']) ? 1 : 0;
            });
			if (!empty($crid)) {
                $crmodel = $this->model('classroom');
                $roominfo = $crmodel->getdetailclassroommulti($crid);
                $this->assign('roominfo',$roominfo[0]);
                $selfset = $ammodel->getRoomModuleSet($crid, true);
                if (!empty($selfset)) {
                    foreach ($selfset as $k => $set) {
                        if (isset($roommodulelist[$k]) && empty($roommodulelist[$k]['system'])) {
                            $roommodulelist[$k]['available'] = 1;
                        }

                    }
                }
            }

			$rmarr = array();
			foreach($roommodulelist as $k=>$module){
				$rmarr[$module['moduleid']] = $module;
			}
			$this->assign('rmarr',$rmarr);
			$modulelist = $ammodel->getmodulelist(array('limit'=>100));
			$this->assign('crid',$crid);
			$this->assign('modulelist',$modulelist);
			$this->display('admin/appmodule_classroomedit');
		}
	}
	
	public function goback($returnurl="/admin/appmodule.html"){
		$note[] = '确定并关闭';
		$rurl[] = $returnurl;
		$this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl));
		exit;
	}
	
	/*
	将系统模块数据添加到roommodule表，直接启用
	*/
	public function initsys(){
		$moduleid = $this->input->post('moduleid');
		$ammodel = $this->model('appmodule');
		echo json_encode(array('success'=>$ammodel->initsystemmodule($moduleid)));
		// var_dump($moduleid);
	}
	public function del(){
		$ammodel = $this->model('appmodule');
		$moduleid = $this->input->post('moduleid');
		echo json_encode(array('success'=>$ammodel->remove($moduleid)));
		// var_dump($moduleid);
	}

    /**
     * 删除网校的模块配置
     */
	public function remove_module_set() {
        if (!$this->isPost()) {
            echo json_encode('非法操作');
            exit();
        }
        $moduleid = intval($this->input->post('moduleid'));
        if ($moduleid < 1) {
            echo json_encode('参数错误');
            exit();
        }
        $ammodel = $this->model('appmodule');
        echo json_encode(array('success'=>$ammodel->recycleModule($moduleid)));
    }
}