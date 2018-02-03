<?php
/*
后台通用方法，分类列表，搜索框等。
*/
class CommonController extends CControl{
	//获取分类列表，主要用于小挂件categories_widget
		public function getGategoriesList($where=null){
			$where=(array)json_decode($this->input->post('where',false));
			$checked=trim($this->input->post('checked'));
			if(strpos($checked,',')!==false){
				$checked=explode(',',$checked);
			}
			$isad=trim($this->input->post('isad'));
			// $Clist = $this->model('category')->getNewsCategoriesByType($type);
			if(!isset($where['type'])){
				$where['type'] = '';
			}
			$Clist = $this->model('category')->getCategoriesByParam($where);
			if(is_array($Clist)){
				$Clist = getTree($Clist);
			}
			$options = '';



				if(is_array($checked)){
					if(in_array('nation', $checked)){
						$options.='<option value="nation" selected=selected >全国首页</option>';
					}else{
						if($where['type']=='courseware'&&$where['position']==1){
							$options.='<option value="nation" >全国首页</option>';
						}
					}
					
					if(in_array('all', $checked)){
						$options.='<option value="all" selected=selected >所有频道</option>';
					}else{
						if(isset($where['ischannel'])){
							$options.='<option value="all" >所有频道</option>';
							
						}
					}
					if(in_array('index', $checked)){
						$options.='<option value="index" selected=selected >首页频道</option>';
					}else{
						if(isset($where['ischannel'])){
							$options.='<option value="index" >首页频道</option>';
							
						}
					}

					foreach ($Clist as $v) {
						if(in_array($v['catid'], $checked)){
							$options.='<option value='.$v['catid'] .' selected=selected >'.$v['name'].'</option>';
						}else{
							$options.='<option value='.$v['catid'] .'>'.$v['name'].'</option>';
						}
				
					}
				}else{

					
					// if($checked=='nation'||$checked=='index'||$checked=='all'){
						if($checked=='nation'){
								$options.='<option value="nation" selected=selected >全国首页</option>';
								
						}else{
							if($where['type']=='courseware'&&$where['position']==1){
								$options.='<option value="nation" >全国首页</option>';
							}
						}
						if($checked=='all'){
								$options.='<option value="all" selected=selected >所有频道</option>';
								
						}else{
							if(isset($where['ischannel'])){
								$options.='<option value="all" >所有频道</option>';
							
							}
						}
						if($checked=='index'){
								$options.='<option value="index" selected=selected >首页频道</option>';
							
						}else{
							if(isset($where['ischannel'])){
								$options.='<option value="index" >首页频道</option>';
							
							}
						}

					// }
					foreach ($Clist as $v) {

						if($checked==$v['catid']){
							{
								$options.='<option value='.$v['catid'] .' selected=selected >'.$v['name'].'</option>';
							}

							
						}else{
							$options.='<option value='.$v['catid'] .'>'.$v['name'].'</option>';
						}
				
					}
				}
			echo  $options;
		}
			
		/*
		搜索教室页面，用作弹出框
		*/
		public function classroom_search(){
			$this->display('admin/classroom_search');
		}
		/*
		内容来源网校搜索
		*/
		public function classroom_search_provider(){
			$this->display('admin/classroom_search_provider');
		}
		public function getClassroomList(){
			$param = $this->input->post();
			$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
			$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
			$offset = max(0,($pageNumber-1)*$pageSize);
			parse_str($param['query'],$queryArr);
			$queryArr['limit'] = $offset.','.$pageSize;
			if(!empty($param['isschool'])){
				$queryArr['isschool'] = $param['isschool'];
			}
			$CModel = $this->model('classroom');
			$total = $CModel->getclassroomcount($queryArr);
			$CList = $CModel->getclassroomlist($queryArr);
			foreach($CList as $k=>$cr){
				$feearr = unserialize($cr['profitratio']);
				$CList[$k]['comfeepercent'] = $feearr['company'];
				$CList[$k]['roomfeepercent'] = $feearr['teacher'];
				$CList[$k]['providerfeepercent'] = $feearr['agent'];
			}
			array_unshift($CList,array('total'=>$total));
			echo json_encode($CList);
		}
		
		/*
	判断用户名是否已经存在
	*/
	public function exists(){
		$user = $this->model('user');
		$param['username'] = $this->input->get('username');
		if($user->exists($param['username']))
			echo 1;
		else
			echo 0;
	}
	
	/*
	获取分成比例
	*/
	public function getFeePercent(){
		$crid = $this->input->post('crid');
		$crmodel = $this->model('classroom');
		$classdetail = $crmodel->getclassroomdetail($crid);
		$feearr = unserialize($classdetail['profitratio']);
		$data['comfeepercent'] = $feearr['company'];
		$data['roomfeepercent'] = $feearr['teacher'];
		$data['providerfeepercent'] = $feearr['agent'];
		echo json_encode($data);
		
	}
}
?>