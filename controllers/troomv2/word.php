<?php
/**
 * 新版作业导出word操作
 */
//EBH::app()->helper('http');
class WordController extends ApiControl {
	private $user = NULL;
	private $room = NULL;
	private $k = "";
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)) {
			echo '用户未登陆';
			exit;
		}
		$this->user = $user;
		$this->room = $room = Ebh::app()->room->getcurroom();
		$this->k = authcode(json_encode(array('uid'=>$user['uid'],'crid'=>$room['crid'],'t'=>SYSTIME)),'ENCODE');
		$this->assign('k',$this->k);
		$this->assign('crid',$room['crid']);
		$this->assign('uid',$user['uid']);
		$this->assign('room',$room);
        
    }
    public function outword_view() {
    	$eid = $this->uri->itemid;
    	$flag = $this->input->get('flag');
    	$this->assign('eid',$eid);
    	$this->assign('flag',$flag);
		$this->display('troomv2/exam2/teacher/outword');
    }
    //通过eid导出word
    public function wordOutByEid() {
    	$_UP = Ebh::app()->getConfig()->load('upconfig');
		$result = 0;
		$eid = intval($this->input->post('eid'));
		if($eid <= 0) {
			echo $result;
			exit;
		}
		$postpath = $_UP['outwordv2']['postpath'];
		if(empty($postpath)) {
			echo 0;
			exit;
		}

		$param = array(
			'k'=>$this->k,
			'eid'=>$eid
		);

		$url = '/exam/detail/foredit/'.$eid;
		$data = $this->do_post($url,$param,false);
		$data = json_decode($data, 1);
		$data['datas']['examdata'] = json_decode($data['datas']['examdata'], 1);
		$exam = $data['datas']['exam'];

		if (empty($exam) OR '0' == $exam['status']) {
			exit('0');
		}

		if ($data['datas']['exam']['etype'] == 'TSMART') {//如果是智能作业，导出智能作业
			$param['uid'] = $data['datas']['exam']['uid'];
			$param['forexam'] = 'teacher';
			$url = '/exam/getsmart/'.$eid;
			$postRet = $this->do_post($url,$param,FALSE);//智能作业数据
			$postRet = json_decode($postRet,1);

			foreach ($postRet['datas']['questionList'] as $value) {
				$exam['ques'][] = $value['question'];
			}
		} else {
			$exam['ques'] = $data['datas']['examdata']['questionList'];//默认为普通作业
		}

		if ($data['errCode'] == 0) {
			$exam['title'] = $exam['esubject'];//标题
			unset($exam['esubject']);
			if ($exam['etype'] == 'COMMON') {
				$exam['quescount'] = count($exam['ques']);//试题数目
				$exam['type'] = 0;//种类
			} else {
				$exam['type'] = 2;
			}
			unset($exam['etype']);
			$exam['score'] = $exam['examtotalscore'];//分数
			unset($exam['examtotalscore']);

			//构造ques
			if (!empty($exam['ques'])) {
				//构建普通作业试题
				foreach ($exam['ques'] as $key => $value) {
					if (!empty($value['data']))
						$value['data'] = json_decode($value['data'],TRUE);
					$value['extdata'] = json_decode($value['extdata'],TRUE);
					$ques[$key]['chapterid'] = 0;
					$ques[$key] =  $value['extdata'];//总体赋值
					$ques[$key]['subject'] = $value['qsubject'];
					$ques[$key]['questionid'] = $value['qid'];
					$ques[$key]['type'] = !empty($value['queType']) ? $value['queType'] : $value['quetype'];
					if ($ques[$key]['type'] == 'Z') //为了兼容老版本和新版本的文字题不统一
						$ques[$key]['type'] == 'F';
					$ques[$key]['score'] = $value['quescore'];
					$ques[$key]['dif'] = $value['level'];//难度
					$ques[$key]['resolve'] = empty($value['extdata']['jx'])?'':$value['extdata']['jx'];
					$ques[$key]['dianpin'] = empty($value['extdata']['dp'])?'':$value['extdata']['dp'];
					unset($ques[$key]['dp']);
					unset($ques[$key]['jx']);
					unset($ques[$key]['qid']);
					//$ques[$key]['folderid'] = $exam['folderid'];//关联的课程
				}
				$exam['ques'] = $ques;
			}
		}

		//获取eid信息
		if (! empty ( $exam ) && $exam['uid'] == $this->user['uid']) {
			$title = $exam['title'];
			$quescount = 0;
			$ques = $exam['ques'];
			$limitdate = $exam['limittime'];
			$score = $exam['score'];
			$flag = intval($this->input->post('flag'));
			$examparam = array ('eid'=>$eid,'title'=>$title,'limitedtime' => $limitdate, 'score' => $score,'ques'=>$ques,'flag'=>$flag);
			$flag = 3;	//是否生成二维码状态 0 不生成  1 整卷二维码 2 试题二维码 3 整卷+试题二维码	此处开发方便先写死，需要前端教师自行选择
			$examparam['flag'] = $flag;
			$examresult = $this->posturl($postpath,http_build_query($examparam));
			
			
			list($year,$month,$day,$filename) = explode('_',$examresult);	//返回格式不正确，则返回错误
			if(empty($year) || empty($month) || empty($day) || empty($filename) || !is_numeric($year) || !is_numeric($month) || !is_numeric($day)) {
				echo 0;
				exit;
			}
			//$filepath = $_UP['word']['savepath'].$year.'/'.$month.'/'.$day.'/'.$filename;
			$result = $_UP['word']['showpath'].$year.'/'.$month.'/'.$day.'/'.$filename;
		}
		echo $result;
    }

    public function wordOut() {	//导出Word
    	$_UP['outword']['postpath'] = 'http://192.168.0.151:8080/outword.aspx';
    	$_UP['word']['savepath'] = '/opt/nginx/html/upload/worduploads/';
		$_UP['word']['showpath'] = 'http://up.ebh.net/worduploads/';
		$html = $_POST ['html'];
		$title = $_POST['title'];
		$quescount = 0;
		$ques = $_POST['ques'];
		//	$ques = json_encode($ques);
		//$ques = "111";
		$cwids = array();
		
		$limitdate = $_POST ['limitdate'];
		$score = $_POST ['score'];
		$examparam = array ('title'=>$title,'limitedtime' => $limitdate, 'score' => $score,'ques'=>$ques);
		//	$aaa = http_build_query($examparam);
		//	var_dump($aaa);
		$examresult = $this->posturl($postpath,http_build_query($examparam));
		list($year,$month,$day,$filename) = explode('_',$examresult);	//返回格式不正确，则返回错误
		if(empty($year) || empty($month) || empty($day) || empty($filename) || !is_numeric($year) || !is_numeric($month) || !is_numeric($day)) {
			echo 0;
			exit;
		}
		$filepath = $_UP['word']['savepath'].$year.'/'.$month.'/'.$day.'/'.$filename;
		if(!file_exists($filepath)) {	//文件不存在，返回错误
			echo 0;
			exit;
		}
		$result = $_UP['word']['showpath'].$year.'/'.$month.'/'.$day.'/'.$filename;
		echo $result;
	} 

	/*
	 **私有方法，提交数据到java后台返回json数据
	 */
	private function do_post($uri, $data, $check = true){
		$url = 'http://'.__SURL__.$uri;
		$ch = curl_init();
		$datastr = json_encode($data);
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
		return $ret;
	}	

	/**
	*提交POST请求到指定URL并返回结果
	*/
	function posturl($url,$param) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url );
		curl_setopt($curl, CURLOPT_POST, 1 );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $param );
		$rtn= curl_getinfo($curl,CURLINFO_HTTP_CODE);
		$result = curl_exec( $curl );
		if ($error = curl_error($curl) ) {
			return 'error';
		}
		curl_close($curl);
		return $result;
	}

}//class end
