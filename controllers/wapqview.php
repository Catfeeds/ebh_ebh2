<?php 
/*
	扫二维码
	wap que2
*/
class WapqviewController extends ApiControl{
	private $user = NULL;
	private $room = NULL;
	private $k = "";
    public function __construct() {
		parent::__construct();
		
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)) {
			echo '用户未登陆';
			exit;
		}
		
		$this->user = $user;
		
		$this->k = authcode(json_encode(array('uid'=>$user['uid'],'crid'=>'','t'=>SYSTIME)),'ENCODE');
		$this->assign('k',$this->k);
		$this->assign('uid',$user['uid']);
		
        
    }
	public function index(){
		$eid = $this->input->get('eid');
		$qid = $this->input->get('qid');
		$this->assign('qid',$qid);
		$this->assign('eid',$eid);
		$this->display('common/wapqview');
	}
	
	/*
	获取题目
	*/
	public function getque(){
		$eid = $this->input->post('eid');
		$qid = $this->input->post('qid');
		$url = "/exam/simpleinfo/".$eid;
		$postRet = $this->do_post($url,array());
		// var_dump($postRet);
		$info = $postRet->info;
		if(empty($info) || empty($info->eid)){
			$this->renderJson("2000","作业不存在");
		}
		if($info->dtag == 1){
			$this->renderJson('12345','作业已删除');
		}
		if ($info->ansstarttime) {
			if (SYSTIME < $postRet->info->ansstarttime)
				$this->renderJson("2000","未到答案开放时间");
		}
		$folderid = $info->tid;
		
		$folderids = $this->getfolderids($info->crid);
		
		$etype = $info->etype;
		
		if($etype == 'TSMART') {
			$url = '/exam/getsmart/'.$eid;
		}else {
			$url = '/exam/detail/fordo/'.$eid;
			// $url = '/exam/detail/forshow/'.$eid;
		}
		
		// var_dump($postRet);
		$param = array(
			'k'=>$this->k,
			'uid'=>$postRet->info->uid,
			'forexam'=>'teacher'
		);
		// var_dump($param);
		$postRet = $this->do_post($url,$param);
		if(!in_array($folderid,$folderids) && empty($postRet->userAnswer))
			$this->renderJson('12345','未开通 '.$postRet->exam->relationname.',或者已过期');
		
		
		if(!empty($qid)){
			foreach($postRet->questionList as $k=>$question){
				if($question->question->qid != $qid)
					unset($postRet->questionList[$k]);
			}
		}
		$datas['exam'] = $postRet->exam;
		$datas['questionList'] = $postRet->questionList;
		$this->renderJson("0","",$datas);
		// var_dump($postRet);
	}
	
	
	/*
	 **私有方法，提交数据到java后台返回json数据
	 */
	private function do_post($uri, $data, $check = true){
		$url = 'http://'.__SURL__.$uri;
		// log_message($url);
		// var_dump($url);
		$ch = curl_init();
		$datastr = (json_encode($data));
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
		curl_setopt($ch, CURLOPT_POST, TRUE); 
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$datastr);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Content-Length: ' . strlen($datastr))
		);
		curl_setopt($ch, CURLOPT_URL, $url);
		$ret = curl_exec($ch);
		curl_close($ch);
		if($check == true) {
			$ret = json_decode($ret);
			$this->apiResCheck($ret);
			return $ret->datas;
		}else {
			return $ret;
		}
	}	
	/*
	 **检查java服务器返回的数据
	 */
	private function apiResCheck($res,$ajax = false){
	    if(empty($res)) {
	        $this->echoMsg("服务器取数据失败");exit;
	    }
	    if($res->errCode != 0) {
	        log_message("code:".$res->errCode.'--msg:'.$res->errMsg);
	        $this->echoMsg($res->errMsg);exit;
	    }
	}
	/*
	 **输出提示的信息
	 */
	private function echoMsg($msg){
	    header("Content-type: text/html; charset=utf-8");
	    echo '<span style="font-size:16px;font-weight:bold;color:#f00;">',$msg,'</span>';
	    echo '<a style="font-size:16px;font-weight:bold;" href="javascript:history.go(-1)">点我返回!</a>';
	    exit;
	}
	
	/*
	 **按规定向前台传数据
	 */
 	private function renderJson($errCode = 0,$errMsg = "",$datas = array() ,$ifexit = true) {
        echo json_encode(array('errCode'=>$errCode,'errMsg'=>$errMsg,'datas'=>$datas));
        if($ifexit) {
            exit;
        }
    }
	
	//获取主观题详情 此接口还需完善
	public function getSubjective() {
		$schcourseware = $this->model('Schcourseware');
		$cwid = $this->input->get('cwid');
		$aid = $this->input->get('aid');
		$qid = $this->input->get('qid');
		$result = $schcourseware->getcourselist ( array('cwid'=>$cwid));
		if($result){
			$result = $result[0];
			if($result['cwname']){
				list($name,$suffix) = explode('.',$result['cwname']);
				$remark = '';
				$voices = '';
				$images = '';
				$note = null;

				if($aid){
					$note = $schcourseware->getcoursenote ( array('cwid'=>$cwid,'aid'=>$aid,'qid'=>$qid));
					if($note){
						if($note['remark']){
							$remark = $note['remark'];	
						}
						if($note['images'])
							$images = $note['images'];
						if($note['voices'])
							$voices = $note['voices'];
					}
				}else{
					$note = $schcourseware->getcoursenote ( array('cwid'=>$cwid,'uid'=>$this->user['uid'],'aid'=>0,'qid'=>$qid));
					//$notes = $schnote->block ( array('cwid'=>$cwid,'uid'=>$uid));
					if($note){
						if($note['remark']){
							$remark = $note['remark'];
							
						}
						if($note['images'])
							$images = $note['images'];
						if($note['voices'])
							$voices = $note['voices'];
					}
				}
				$type = $result['type'];

				//获取主观题缩略图需要秘钥
				$clientip = $this->input->getip();
				$skey = $cwid.'\t'.$clientip;
				if (!empty($note['qid']))
					$skey .= '\t'.$note['qid'];
				$key = authcode($skey, 'ENCODE');

				$result = array('suffix'=>strtolower($suffix),'remark'=>$remark,'images'=>$images,'voices'=>$voices,'note'=>$note,'type'=>$type,'key'=>$key);
			}
		}
		$status = empty ( $result ) ? array('result'=>0) : $result;
		echo json_encode ( $status );

	}
	
	/*
	获取有权限的课程：免费，全校免费，开通未过期
	*/
	private function getfolderids($crid){
		$this->room = $this->model('classroom')->getRoomByCrid($crid);
		$userpermodel = $this->model('Userpermission');
			$myperparam = array('uid'=>$this->user['uid'],'crid'=>$crid,'filterdate'=>1);
			$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
			$folderids = array();
			
			foreach($myfolderlist as $f){
				$folderids[]= $f['folderid'];
			}
			
			$foldermodel = $this->model('Folder');
			if($this->room['isschool'] == 7){
				//全校免费课程
				$rumodel = $this->model('roomuser');
				$userin = $rumodel->getroomuserdetail($crid,$this->user['uid']);
				if(!empty($userin)){
					
					$schoolfreelist = $foldermodel->getfolderlist(array('crid'=>$crid,'isschoolfree'=>1,'limit'=>1000));
					foreach($schoolfreelist as $f){
						$folderids[]= $f['folderid'];
					}
				}
				
			}
			
			//免费课程（课程0，服务项0）
			$freelist = $foldermodel->getPriceZeroList($crid);
			foreach($freelist as $f){
				$folderids[]= $f['folderid'];
			}
		return $folderids;
	}
}
?>