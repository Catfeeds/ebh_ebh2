<?php
/**
 *菜单管理
*/
class MenuController extends AdminControl{
	public function index(){
		$crid = $this->input->get('crid');
		if(!empty($crid)){//单个网校的
			$roominfo = $this->model('classroom')->getclassroomdetail($crid);
		} else {
			$roominfo['crid'] = 0;
			$roominfo['crname'] = '基础菜单';
		}
		$this->assign('roominfo',$roominfo);
		$this->display('admin/menu');
	}
	
	/*
	菜单列表
	*/
	public function getListAjax(){
		$param['q'] = $this->input->post('query');
		$param['crid'] = $this->input->post('crid');
		if(!empty($param['crid'])){
			$menulist = $this->apiServer->reSetting()->setService('Adminv2.Menu.list')->addParams($param)->request();
		} else {
			$param['roomtype'] = $this->input->post('roomtype');
			$menulist = $this->apiServer->reSetting()->setService('Adminv2.Menu.baseList')->addParams($param)->request();
		}
		echo json_encode($menulist);
	}
	
	/*
	添加菜单
	*/
	public function add(){
		if($this->input->post()){
			$param = $this->input->post();
			$result = $this->apiServer->reSetting()->setService('Adminv2.Menu.add')->addParams($param)->request();
			$this->goback('/admin/menu.html?crid='.$param['crid']);
		}			
		else{
			$param['crid'] = $this->input->get('crid');
			$param['onlylevel1'] = 1;
			if(!empty($param['crid'])){
				$menulist = $this->apiServer->reSetting()->setService('Adminv2.Menu.list')->addParams($param)->request();
			} else {
				$param['roomtype'] = $this->input->get('roomtype');
				$menulist = $this->apiServer->reSetting()->setService('Adminv2.Menu.baseList')->addParams($param)->request();
			}
			$this->assign('menulist',$menulist['menulist']);
			$this->assign('crid',$param['crid']);
			$this->display('admin/menu_add');
		}
	}
	/*
	编辑菜单
	*/
	public function edit(){
		if($this->input->post()){
			$param = $this->input->post();
			$param['status'] = $this->input->post('status');
			$result = $this->apiServer->reSetting()->setService('Adminv2.Menu.edit')->addParams($param)->request();
			if(empty($param['isajax']))
				$this->goback('/admin/menu.html?crid='.$param['crid'],'修改成功');
			else
				echo json_encode(array('success'=>$result));
		}			
		else{
			$param['crid'] = $this->input->get('crid');
			$param['onlylevel1'] = 1;
			if(!empty($param['crid'])){
				$menulist = $this->apiServer->reSetting()->setService('Adminv2.Menu.list')->addParams($param)->request();
			} else {
				$param['roomtype'] = $this->input->get('roomtype');
				$menulist = $this->apiServer->reSetting()->setService('Adminv2.Menu.baseList')->addParams($param)->request();
			}
			$param['mid'] = $this->input->get('mid');
			$menudetail = $this->apiServer->reSetting()->setService('Adminv2.Menu.detail')->addParams($param)->request();
			if(empty($menudetail)){
				$this->goback('/admin/menu.html?crid='.$param['crid'],'数据出错');
			}
			$this->assign('menudetail',$menudetail);
			$this->assign('menulist',$menulist['menulist']);
			$this->assign('crid',$param['crid']);
			$this->display('admin/menu_edit');
		}
	}
	
	/*
	删除菜单
	*/
	public function del(){
		if($this->input->post()){
			$param = $this->input->post();
			$result = $this->apiServer->reSetting()->setService('Adminv2.Menu.del')->addParams($param)->request();
			echo json_encode(array('success'=>$result));
		}
	}
	
	public function goback($returnurl="/admin/menu.html",$msg=''){
		$note[] = '确定并关闭';
		$rurl[] = $returnurl;
		$this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>$msg));
		exit;
	}
    /**
    *选择菜单
    */
    public function choose(){
        if($this->input->post()){
            $post = $this->input->post();
            $param['roomtype'] = intval($post['roomtype']); //网校类型,0教育版,1企业版
            if(!empty($post['page'])){
                $param['page'] = intval($post['page']);
            }
            if(!empty($post['pagesize'])) {
                $param['pagesize'] = intval($post['pagesize']);
            }
            if(($post['q'] != null) && ($post['q'] != '')){
                $param['q'] = h($post['q']);
            }
            if(!empty($post['tmid'])){  //父级菜单id
                $param['tmid'] = intval($post['tmid']);
            }
            $menulist = $this->apiServer->reSetting()->setService('Adminv2.Menu.getListByQuery')->addParams($param)->request();
            $mtitlearr = array('学员管理','单位管理','学分统计');
            if(!empty($menulist['menulist']) && ($param['roomtype'] == 0)){
                foreach ($menulist['menulist'] as &$menu){
                    if(in_array($menu['mtitle'],$mtitlearr)){
                        $menu['mtitle'] = str_replace($menu['mtitle'], $menu['mtitle'].'(国土专用)', $menu['mtitle']);
                    }
                }
            }
            echo json_encode($menulist);
        }
        else{
            $this->display('admin/menu_choose');
        }
    }
	
}