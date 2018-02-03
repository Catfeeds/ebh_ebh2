<?php
class CloudlistController extends PortalControl {
    public function index() {
        //暂时不用的代码 抛出404;
        show_404();
        exit;  
        
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		//网校列表标签显示
		$labelmodel = $this->model('label');
		$param = array('displayorder'=>'browsenumber desc','limit'=>'0,15');
		$labellist = $labelmodel->getLabelList($param);
		$this->assign('labellist', $labellist);
		//左侧标签按showtime添加次数显示
		$params = array('displayorder'=>'showtime desc','limit'=>'0,15');
		$labelshow = $labelmodel->getLabelList($params);
		$this->assign('labelshow', $labelshow);
		//网校列表显示
		$classroommodel = $this->model('classroom');
		$q = $this->input->get('q');
		$q = h($q);
		$q = htmlentities($q, ENT_QUOTES, "UTF-8");
		$beginprice = $this->input->get('beginprice');
		$endprice = $this->input->get('endprice');
		$param = parsequery();
		$param['pagesize'] = 12;
		$param['q'] = $q;
		$param['beginprice'] = intval($beginprice);
		$param['endprice'] = intval($endprice);
		$param['property'] = (int)$this->input->get('property');
		$param['citycode'] = max($this->input->get('address_sheng'),$this->input->get('address_shi'),$this->input->get('address_qu'));
		$this->assign('citycode',$param['citycode']);
		$param['grade'] = $this->input->get('grade');
		$param['subject'] = $this->input->get('subject');
		$param['filterorder'] = 20000;
		if($this->uri->sortmode == 0)
			$param['order'] = 'cr.crid desc';
		//按价格
		elseif($this->uri->sortmode ==1 )
			$param['order'] = 'cr.crprice desc,cr.displayorder asc';
		//按人气
		elseif($this->uri->sortmode ==2 )
			$param['order'] = 'cr.stunum desc';
		//按最新
		elseif($this->uri->sortmode ==3 )
			$param['order'] = 'cr.crid desc';
		//按推荐
		elseif($this->uri->sortmode ==4 )
			$param['order'] = 'cr.displayorder asc';
		
		$classroomkey = $this->cache->getcachekey('classroom',$param);
		$classroom = $this->cache->get($classroomkey);
		if(empty($classroom)) {
			$classroomcount = $classroommodel->getclassroomcount($param);
			$classroomlist = $classroommodel->getclassroomall($param);
			if(!empty($user)){
				$roomuser = $this->model('roomuser');
				$roomlist = $roomuser->getroomlist($user['uid']);
				$tempcount = count($classroom);
				for($i=0;$i<$tempcount;$i++){
					foreach($roomlist as $rl){
						if($classroom[$i]['crid'] == $rl['crid'])
							$classroom[$i]['in'] = 1;
					}
				}
			}
			$classroom =  array('list'=>$classroomlist,'count'=>$classroomcount);
			$this->cache->set($classroomkey,$classroom,300);	//缓存5分钟
		}else{
			$classroomlist = $classroom['list'];
			$classroomcount = $classroom['count'];
		}
		$pagestr = show_page($classroomcount,$param['pagesize']);
		$this->assign('classroomcount', $classroomcount);
		$this->assign('pagestr',$pagestr);
		$this->assign('classroomlist', $classroomlist);
		$this->assign('q',$param['q']);
		$this->assign('param',$param);
		$this->display('common/cloudlist');
	}
}
?>