<?php
class PublishController extends CControl{
	//是否是后台判断
	private $crid;
	private $eventstring;
	public function __construct(){
		parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();	
		if(empty($roominfo)){	//非网校页面直接跳转到首页
			header('location: /');
			exit;
		}
		if ($roominfo['template'] == 'plate') {
            Ebh::app()->runAction('room/portfolio', 'publish');
            exit();
        }
	}
	public function index(){
        //修改网校发布内容为暂无内容---start////////////////////////////////////////////////////////////
        $user = Ebh::app()->user->getloginuser();
        $roominfo = Ebh::app()->room->getcurroom();
        $this->assign('roominfo',$roominfo);
        $this->assign('user',$user);
        $this->assign('adlist',array());//教室首页广告获取
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
        $this->display('common/publish');exit;
        //修改网校发布内容为暂无内容---end////////////////////////////////////////////////////////////
        if(false){//修改网校发布内容为暂无内容---start---
		$stime = microtime(true);
		$roominfo = Ebh::app()->room->getcurroom();
		$diffage = date('Y',SYSTIME) - date('Y',$roominfo['dateline']);
		$user = Ebh::app()->user->getloginuser();
		$this->eventstring = $this->getEventString();
		$this->crid = $roominfo['crid'];
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		$timearr = array();
		$this->joindata($timearr,$roominfo,'birthday');//诞生
		$this->getData($timearr,'firststu');//第一个学生
		$this->getData($timearr,'firstcourse');//第一个课件
		$this->getData($timearr,'firstiaclass');//第一次互动
		$this->getData($timearr,'firstreview');//第一条评论
		$this->getData($timearr,'firstexam');//第一份作业
		$this->getData($timearr,'firstask');//第一个提问
		$this->getData($timearr,'firstnotice');//第一个通知
		$this->getData($timearr,'firstsurvey');//第一个问卷调查
		$etime = microtime(true);
		//改变网校诞生年份显示
		if($diffage >0){
			$tmpval = $timearr[$roominfo['dateline']];
			$tmpkey = strtotime( (date('Y',$roominfo['dateline']) - 1).'-'.date('m-d',$roominfo['dateline']) );
			unset($timearr[$roominfo['dateline']]);
			$ntimearr = array();
			$ntimearr[$tmpkey] = $tmpval;
			foreach ($timearr as $key=>$val){
				$ntimearr[$key] = $val;
			}
			$timearr = $ntimearr;
		}

		//多久前创建
		$agestr = $this->getAgestr($roominfo['dateline']);
		$this->assign('agestr',$agestr);

		$pmodel = $this->model('publish');

		//互动数量
		$iacount = $pmodel->getIaclassroomCount($this->crid);
		$this->assign('iacount',$iacount);

		//教师数量
		$teachercount = $pmodel->getTeacherCount($this->crid);
		$this->assign('teachercount',$teachercount);

		//最热/最冷门课程
		$courselist = $pmodel->getCourseList($this->crid);
		$coursetopstr = '';
		$coursetoplist = array();
		foreach($courselist as $k=>$course){
			$coursetopstr.= $course['foldername'].'，';
			$coursetoplist[] = $course;
			if($k==2)
				break;
		}
		$coursebottom = array();
		if(count($courselist)>3){
			$coursebottom = $courselist[count($courselist)-1];
		}
		$this->assign('coursetopstr',mb_substr($coursetopstr,0,-1,'utf-8'));
		$this->assign('coursetoplist',$coursetoplist);
		$this->assign('coursebottom',$coursebottom);


		$this->getAssignData('creditloglist');//积分记录
		$this->getAssignData('creditlist');//积分排名
		$this->getAssignData('femalepercent');//女生比例
		// $this->getAssignData('lastloginlist');//最后登录时间列表
		$lastloginlist = $pmodel->getlastloginlist($this->crid);

		for($i=0;$i<24;$i++){
			$loginhour[$i] = 0;
		}
		$stucount = count($lastloginlist);
		foreach($lastloginlist as $login){
			$loginhour[$login['hour']]++;
		}
		$hourcountstr = '';
		foreach($loginhour as $hour){
		    if($stucount > 0 ){
		        $hourcountstr .= round($hour*100/$stucount,2).',';
		    }else{
		        $hourcountstr .= '0.00,';
		    }
		}
		$this->assign('hourcountstr',rtrim($hourcountstr,','));

		$this->getSexInfo();

		//教室首页广告获取
		$param = array('crid'=>$roominfo['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlist = $this->cache->get($roomadkey);
		if(empty($adlist)) {
			$admodel = $this->model('Ad');
			$adlist = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlist,600);
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

		$this->assign('adlist', $adlist);
		$this->assign('timearr',$timearr);
		$this->display('common/publish');
        }//修改网校发布内容为暂无内容---end---
		
	}
	
	/*
	按code访问相应方法获取数据
	*/
	private function getData(&$timearr,$code){
		$pmodel = $this->model('publish');
		$funcstr = 'get'.$code;
		$$code = $pmodel->$funcstr($this->crid);
		$this->joinData($timearr,$$code,$code);
	}
	/*
	将数据替换掉标识
	*/
	private function joinData(&$timearr,$data,$code){
		if(!empty($data['dateline'])){
			$timearr[$data['dateline']] = preg_replace_callback(
								'/<var>([a-z]*)<\/var>/',
								function($matches)use($data){
									return $data[$matches[1]];
								},
								$this->eventstring[$code]);
			
		}
	}
	
	private function getAssignData($code){
		$pmodel = $this->model('publish');
		$funcstr = 'get'.$code;
		$$code = $pmodel->$funcstr($this->crid);
		$this->assign($code,$$code);
	}
	
	private function getEventString(){
		$eventstring = array(
			'birthday'=>'我诞生啦',
						
			'firststu'=>'我拥有了<span class="hoastr">第一名优秀的学员</span>“<var>realname</var>”，他现在已经成为学霸咯',
						
			'firstcourse'=>'大家上了<span class="hoastr">第一堂精品课程</span>“<var>title</var>”',
						
			'firstiaclass'=>'“<var>realname</var>”<span class="hoastr">第一次</span>与讲师进行了<span class="hoastr">课堂互动</span>，学习效果不错哦',
			
			'firstreview'=>'“<var>realname</var>”给我们留下了非常有意义的<span class="hoastr">第一条评论</span>',
			
			'firstexam'=>'给“<var>classname</var>”布置了<span class="hoastr">第一份课后作业</span> PS：“<var>realname</var>”第一个完成的哦',
			
			'firstask'=>'收到了“<var>realname</var>”提的<span class="hoastr">第一个提问</span>',
			
			'firstnotice'=>'我们发布了<span class="hoastr">第一条网校通知</span>，你还记得是什么内容吗？',
			
			'firstsurvey'=>'为了倾听大家对网校发展的建议和意见，我们发布了<span class="hoastr">第一份调查问卷</span>。',
			
			'moremale'=>'男同学在人数上比女同学更有优势哦',
			'morefemale'=>'男同学在人数上比女男同学更有优势哦',
			'nearlysex'=>'男女同学在人数上势均力敌哦'
			
			);
			
		return $eventstring;
	}
	
	private function getAgestr($birthdate){
		$diffage = date('Y',SYSTIME) - date('Y',$birthdate);
		$theage = $diffage > 0 ? $diffage + 2 : $diffage + 1;
		/*
		$age_second = SYSTIME-$birthdate;
		$age_day = $age_second/86400;
		if($age_day<30)
			$agestr = '<span style="font-size:28px;color:blue"> '.floor($age_day).' </span>天';
		elseif($age_day>=30 && $age_day<365)
			$agestr = '<span style="font-size:28px;color:blue"> '.floor($age_day/30).' </span>月';
		elseif($age_day>=365)
			$agestr = '<span style="font-size:28px;color:blue"> '.$theage.' </span>年';
		*/
		$agestr = '<span style="font-size:28px;color:blue"> '.$theage.' </span>年';
		return $agestr;
	}
	
	private function getSexInfo(){
		$paramuser = array('crid'=>$this->crid);
	
	
		// $stime = microtime(true);
		//性别比例
		$rumodel = $this->model('roomuser');
		$paramuser['sex'] = 0;
		$sex[0] = $rumodel->getSexCount($paramuser);
		$paramuser['sex'] = 1;
		$sex[1] = $rumodel->getSexCount($paramuser);
		if($sex[0]==0 && $sex[1]==0){
			$sexpercent[0] = 0;
			$sexpercent[1] = 0;
		}else{
			$sexpercent[0] = round($sex[0]/($sex[0]+$sex[1])*100,2);
			$sexpercent[1] = 100-$sexpercent[0];
		}
		//性别登录比例
		$paramuser['sex'] = 0;
		$logincount[0] = $rumodel->getLoginCount($paramuser);
		$paramuser['sex'] = 1;
		$logincount[1] = $rumodel->getLoginCount($paramuser);
		
		if($logincount[0]==0 && $logincount[1]==0){
			$loginpercent[0] = 0;
			$loginpercent[1] = 0;
		}else{
			$loginpercent[0] = round($logincount[0]/($logincount[0]+$logincount[1])*100,2);
			$loginpercent[1] = 100-$loginpercent[0];
		}
		$this->assign('sexpercent',$sexpercent);
		$this->assign('loginpercent',$loginpercent);
	}
	
}