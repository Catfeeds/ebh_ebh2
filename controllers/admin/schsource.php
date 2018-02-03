<?php
/*
企业选课
*/
class SchsourceController extends AdminControl{

	public function index(){
		
		$this->display('admin/schsource_list');
	}
	
	/**
	 *企业列表
	 */
	public function getListAjax(){
		$param = safeHtml($this->input->post());
		$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
		$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
		$offset = max(0,($pageNumber-1)*$pageSize);
		$queryArr['limit'] = $offset.','.$pageSize;
		if(!empty($param['query'])){
			$queryArr['q'] = $param['query'];
		}
		if(!empty($param['sourceid'])){
			$queryArr['sourceid'] = $param['sourceid'];
		}
		if(!empty($param['crid'])){
			$queryArr['crid'] = $param['crid'];
		}
		if(!empty($param['sourcecrid'])){
			$queryArr['sourcecrid'] = $param['sourcecrid'];
		}
		$ssmodel = $this->model('Schsource');
		$list = $ssmodel->getSourceList($queryArr);
		$count = $ssmodel->getSourceCount($queryArr);
		array_unshift($list,array('total'=>$count));
		echo json_encode($list);
	}
	
	/*
	课程列表
	*/
	public function getItemList(){
		$param = safeHtml($this->input->post());
		$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
		$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
		$offset = max(0,($pageNumber-1)*$pageSize);
		// parse_str($param['query'],$queryArr);
		$queryArr['limit'] = $offset.','.$pageSize;
		// $queryArr['pid'] = $param['pid'];
		// $queryArr['sourceid'] = $param['sourceid'];
		$queryArr['crid'] = $param['crid'];
		$ssmodel = $this->model('Schsource');
		$list = $ssmodel->getItemList($queryArr);
		if(!empty($list)){
			$itemids = array_column($list,'itemid');
			$itemids = implode(',',$itemids);
			$folderlist = $this->model('Payitem')->getFolderListByItemids($itemids,$param['crid']);
			foreach($list as $k=>$item){
				$itemid = $item['itemid'];
				if(empty($folderlist[$itemid]) || $folderlist[$itemid]['del'] !=0){
					unset($list[$k]);
				}
			}
		}
		$count = $ssmodel->getItemCount($queryArr);
		array_unshift($list,array('total'=>$count));
		echo json_encode($list);
	}
	
	/*
	添加对应关系，选择课程
	*/
	public function add(){
		if($this->input->post()){
			$post = $this->input->post();
			if(empty($post['crid']) || empty($post['sourcecrid']) || empty($post['name'])){
				echo json_encode(array('code'=>1,'msg'=>'参数不正确'));
				return ;
			}
			$data['crid'] = $post['crid'];
			$data['sourcecrid'] = $post['sourcecrid'];
			$data['name'] = $post['name'];
            //总分成比例之和等于0或100
            $total = 0;
            $data['compercent'] = !empty($post['compercent']) ? intval($post['compercent']) : 0;
            $data['roompercent'] = !empty($post['roompercent']) ? intval($post['roompercent']) : 0;
            $data['providerpercent'] = !empty($post['providerpercent']) ? intval($post['providerpercent']) : 0;
            $total = $data['compercent'] + $data['roompercent'] + $data['providerpercent'];
            if(($total != 0) && ($total != 100)){
                echo json_encode(array('code'=>1,'msg'=>'总分成比例设置错误'));
                return ;
            }
			$itemlist = $post['itemlist'];
			$folderidarr = array();
			if(!empty($itemlist)){ //去掉重复的课程
				foreach($itemlist as $k=>$item){
					if(in_array($item['folderid'],$folderidarr)){
						unset($itemlist[$k]);
					} else {
						$folderidarr[] = $item['folderid'];
					}
				}
			}
            //单分成比例之和必须等于0或者100
            foreach($itemlist as $i=>$items){
                if(isset($items['compercent']) && isset($items['roompercent']) && isset($items['providerpercent'])){
                    $items['compercent'] = !empty($items['compercent']) ? intval($items['compercent']) : 0;
                    $items['roompercent'] = !empty($items['roompercent']) ? intval($items['roompercent']) : 0;
                    $items['providerpercent'] = !empty($items['providerpercent']) ? intval($items['providerpercent']) : 0;
                    $itemtotal = 0;
                    $itemtotal = $items['compercent'] + $items['roompercent'] + $items['providerpercent'];
                    if(!empty($itemtotal) && $itemtotal != 100){
                        echo json_encode(array('code'=>1,'msg'=>'单分成比例设置错误'));
                        return ;
                    }
                }
            }
			$data['itemlist'] = $itemlist;
			
			$ssmodel = $this->model('Schsource');
			$res = $ssmodel->add($data);
			if($res == FALSE){
				echo json_encode(array('code'=>1,'msg'=>'失败'));
			} else {
				echo json_encode(array('code'=>0,'msg'=>'成功'));
			}
		} else {
			$this->display('admin/schsource_add');
		}
	}
	
	/*
	编辑关联信息,变更课程
	*/
	public function edit(){
		if($this->input->post()){
			$post = $this->input->post();
			if(empty($post['sourceid']) || empty($post['name'])){
				echo json_encode(array('code'=>1,'msg'=>'参数不正确'));
				return ;
			}
            $data['sourceid'] = $post['sourceid'];
			$data['name'] = $post['name'];
            //总分成比例之和等于0或100
            $total = 0;
            $data['compercent'] = !empty($post['compercent']) ? intval($post['compercent']) : 0;
            $data['roompercent'] = !empty($post['roompercent']) ? intval($post['roompercent']) : 0;
            $data['providerpercent'] = !empty($post['providerpercent']) ? intval($post['providerpercent']) : 0;
            $total = $data['compercent'] + $data['roompercent'] + $data['providerpercent'];
            if(($total != 0) && ($total != 100)){
                echo json_encode(array('code'=>1,'msg'=>'总分成比例设置错误'));
                return ;
            }
			$itemlist = array();
			if(!empty($post['itemlist'])){
				$itemlist = $post['itemlist'];
				$folderidarr = array();
				//去掉重复的课程
				foreach($itemlist as $k=>$item){
					if(in_array($item['folderid'],$folderidarr)){
						unset($itemlist[$k]);
					} else {
						$folderidarr[] = $item['folderid'];
					}
				}
			}
            //单分成比例之和必须等于0或者100
            foreach($itemlist as $i=>$items){
                if(isset($items['compercent']) && isset($items['roompercent']) && isset($items['providerpercent'])){
                    $items['compercent'] = !empty($items['compercent']) ? intval($items['compercent']) : 0;
                    $items['roompercent'] = !empty($items['roompercent']) ? intval($items['roompercent']) : 0;
                    $items['providerpercent'] = !empty($items['providerpercent']) ? intval($items['providerpercent']) : 0;
                    $itemtotal = 0;
                    $itemtotal = $items['compercent'] + $items['roompercent'] + $items['providerpercent'];
                    if(!empty($itemtotal) && $itemtotal != 100){
                        echo json_encode(array('code'=>1,'msg'=>'单分成比例设置错误'));
                        return ;
                    }
                }
            }
			$data['itemlist'] = $itemlist;
			$ssmodel = $this->model('Schsource');
			$res = $ssmodel->edit($data);
			$code = 0;$msg = '成功';
			if($res != 3){
				$code = 1;
				switch($res){
					case 0:$msg = '失败';
						break;
					case 1:$msg = '编辑名称成功，编辑课程失败';
						break;
					case 2:$msg = '编辑课程成功,编辑名称失败';
						break;
				}
			}
			echo json_encode(array('code'=>$code,'msg'=>$msg));
		} else {
			$sourceid = $this->input->get('sourceid');
			if(empty($sourceid)){
				echo 'sourceid 为空';exit;
			}
			$this->assign('sourceid',$sourceid);
			$this->display('admin/schsource_edit');
		}
	}
	
	/*
	已选课程,编辑时查询的数据
	*/
	public function getSelectedItems(){
		$ssmodel = $this->model('Schsource');
		$sourceid = $this->input->post('sourceid');
		$itemlist = $ssmodel->getSelectedItems(array('sourceid'=>$sourceid,'del'=>0));
		echo json_encode($itemlist);
	}
	
	public function del(){
		if($this->input->post()){
			$sourceid = $this->input->post('sourceid');
			$res = $this->model('Schsource')->delSource($sourceid);
			if($res != FALSE){
				echo json_encode(array('success'=>true));
				return ;
			}
		}
		echo json_encode(array('删除失败'));
	}

	/**
	 * [设置排序]
	 */
	public function setSortAjax(){
		$sortNumber = intval($this->input->post('sort'));
		$sourceid = intval($this->input->post('sourceid'));
		if($sortNumber < 0 || empty($sortNumber) || $sourceid < 0 || empty($sourceid)){
			echo json_encode(array('error_code'=>1,'msg'=>'排序参数不正确'));exit;
		}
		$ssmodel = $this->model('Schsource');
		$result = $ssmodel->setSort($sortNumber,$sourceid);
		echo $result ? json_encode(array('error_code'=>0,'msg'=>'')) : json_encode(array('error_code'=>1,'msg'=>'排序失败'));
	}
}
?>