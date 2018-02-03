<?php
class IntroduceController extends CControl{
	private $templatearr = array('zwx','scb','qjb','one','zhh','zho','zjdf','drag');
	public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
        if (empty($roominfo)) {
            header("Location: http://www.ebh.net");
            exit();
        }
        if ($roominfo['template'] == 'plate') {
            Ebh::app()->runAction('room/portfolio', 'introduce');
            return;
        }
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		if(in_array($roominfo['template'],$this->templatearr))
			$this->showfunc($roominfo['template']);
		
    }

    private function showfunc($template){

    	//广告
		$roominfo = Ebh::app()->room->getcurroom();
        if (empty($roominfo)) {
            header("Location: http://www.ebh.net");
            exit();
        }
        //客服浮窗
        $kefu=array();
        if($roominfo['kefuqq']!=0){
            $kefu['kefu'] = explode(',',$roominfo['kefu']);
            $kefu['kefuqq'] = explode(',',$roominfo['kefuqq']);
        }
        if(!empty($roominfo['crphone'])){
            $phone = array();
            $phone = explode(',',$roominfo['crphone']);
            $this->assign('phone',$phone);
        }
        $this->assign('kefu',$kefu);
		$param = array('crid'=>$roominfo['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlist = $this->cache->get($roomadkey);
		if(empty($adlist)) {
			$admodel = $this->model('Ad');        
			$adlist = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlist,600);
		}
		$this->assign('adlist', $adlist);
		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		//stores的详情介绍
		$classroom = $this->model('classroom');
		$classroomchachekey = $this->cache->getcachekey('classroom',$crid);
		$classroommess = $this->cache->get($classroomchachekey);

		if(empty($classroommess)) {
			$classroommess = $classroom->getdetailclassroom($crid);
			$this->cache->set($classroomchachekey,$classroommess,300);
		}

		$this->assign('classroommess', $classroommess);

		$this->display('shop/'.$template.'/introduce');
    }
	
}