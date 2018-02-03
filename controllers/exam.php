<?php
/**
*作业主观题相关控制器类 ExamController
*/
class ExamController extends CControl{
	private $life = 43200; //播放点击后的缓存时间，主要用于下载等
    private $course = NULL; //存在课件course数据对象
	public function index() {
		$t = $this->input->get('t');
        $c = $this->input->get('c');        //这里是笔记操作
        if ($c != NULL) {    //处理主观题答题笔记相关操作
            $this->_initnote();
        } else if ($t == 'ajax') {  //播放之前的请求操作，主要用于权限判断，返回生成的播放key等
            $this->_init();
        } else {
            $this->_play();
        }
	}

	/*
	 * 初始化课件权限等，为播放做准备
	 */
	private function _init()
	{
		//1，验证来源有效性
		//2，验证身份
		//3，验证余额等信息
		//4，生成明码钥匙
		//5，生成加密码
		//6，设置密码并返回钥匙
		$cwid = $this->input->get('cwid');
		$aid = $this->input->get('aid');
		$user = Ebh::app()->user->getloginuser();
		$callback = $this->input->get('callback');
		if (empty($user) || $cwid <= 0){	//用户未登录或者请求信息部完成
			$status = array('status'=>'0');
			echo $callback.'('.json_encode($status).')';
			exit();
		}
		
		$schcoursemodel = $this->model('Schcourseware');
		$course = $schcoursemodel->getcoursebyid($cwid);
		if (empty($course)) {	//主观题课件不存在
			$status = array('status' => '-1');
			echo $callback . '(' . json_encode($status) . ')';
			exit();
		}
		if($user['groupid'] != 5 && $user['groupid'] != 6) {	//只有学生和教师能查看
			$status = array('status'=>'-2');
			echo $callback.'('.json_encode($status).')';
			exit();
		}
		//输出组合key
		$ktime = SYSTIME;
		$clientip = $this->input->getip();
		$skey = $ktime.'\t'.$cwid.'\t'.$clientip;
		if (!empty($aid) && is_numeric($aid))
			$skey .= '\t'.$aid;
		$key = authcode($skey, 'ENCODE');
		$auth = $this->input->cookie('auth');
		$auth = authcode($auth,'ENCODE',$skey);
		$this->cache->set($key,$auth,$this->life);
		$param = array();
		if (is_numeric($aid) && $aid > 0 && $user['groupid'] == 5) {	//老师查看学生笔记
			$param['aid'] = $aid; 
		} else {
			$param['uid'] = $user['uid'];
		}
		$param['cwid'] = $cwid;
		$notes = $schcoursemodel->getcoursenote($param);

		$isnote = empty($notes)?'N':'Y';
		$status = array('status'=>'1','k'=>$key,'n'=>$isnote);
		if ($user['groupid'] == 5)
			$status['utype'] = 'T';
		if(!empty($course['type'])) {
			$status['type'] = 'docx';
		}
		echo $_GET['callback'].'('.json_encode($status).')';
		exit();
	}
	/*
	 * 流程如下：
		1:判断来源是否会e板会播放器
		2:判断key是否合法
		3:判断用户是否登录，判断是否非法
		4:判断用户身份，会员、代理商、老师等
		5:根据权限处理，扣费等
		6:返回课件文件
	 * 
	 */
	private function _play() 
	{
		$key = $this->input->get('k');	//获取验证信息
		if(empty($key)) {
			exit();
		}
		$pauth = $this->cache->get($key);
		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		//判断来源是否合法
		if ((strpos($useragent, 'www.ebanhui.com') === false && strpos($useragent, 'ebhplayer') === false && strpos($useragent, 'android') === false) || empty($key) || empty($pauth))
		{
		//	exit();
		}
		//判断key的有效性
		$skey = authcode($key,'DECODE');
		if (empty($skey)) {
			log_message('密匙出错，key:'.$key.' skey为空');
			exit();
		}
		@list($ktime,$cwid,$cip,$aid) = explode('\t', $skey);
		if (empty($ktime) || empty($cwid) || empty($cip) || !is_numeric($ktime) || (intval($ktime) + $this->life) < SYSTIME || !is_numeric($cwid) || $cip != $this->input->getip()) {
			log_message('密匙不合法或已失效');
		}
		$auth = authcode($pauth,'DECODE',$skey);
		$usermodel = Ebh::app()->model('User');
		$user = $usermodel->getloginbyauth($auth);
		//判断用户登录,暂不考虑媒体中心用户的判断

		if (empty($user)) {
			log_message('会员验证失败');
			exit();
		}

		//输出主观题课件信息
		if ($cwid > 0) {
			$schcoursemodel = $this->model('Schcourseware');
			$course = $schcoursemodel->getcoursebyid($cwid);
			if (!empty($course)) {
				$cwurl = $course['cwurl'];
				$cwname = $course['cwname'];
				if ($cwurl == 'default' && !empty($aid) && $user['groupid'] == 5) {	//老师查看学生笔记
					$param = array();
					$param['aid'] = $aid; 
					$param['cwid'] = $cwid;
					$note = $schcoursemodel->getcoursenote($param);
					if(!empty($note) && empty($note['url'])) {
						$cwurl = 'defaults';
					}
				} 
				getfile('examcourse',$cwurl,$cwname);
			}
			else {
				echo '课件不存在';
			}
		} else {
			echo '链接不合法';
		}
	}

	/*
	 * 处理主观题答题笔记相关请求
	 */
	private function _initnote() {
		$key = $this->input->get('k');	//获取验证信息
		if(empty($key)) {
			exit();
		}
		$pauth = $this->cache->get($key);
		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		
		//判断来源是否合法
		if ((strpos($useragent, 'www.ebanhui.com') === false && strpos($useragent, 'ebhplayer') === false && strpos($useragent, 'android') === false) || empty($key) || empty($pauth))
		{
			//exit();
		}
		//判断key的有效性
		$skey = authcode($key,'DECODE');
		if (empty($skey)) {
			log_message('密匙出错，key:'.$key.' skey为空');
			exit();
		}
		@list($ktime,$cwid,$cip,$aid) = explode('\t', $skey);
		if (empty($ktime) || empty($cwid) || empty($cip) || !is_numeric($ktime) || (intval($ktime) + $this->life) < SYSTIME || !is_numeric($cwid)) {
			log_message('密匙不合法或已失效');
		}
		$auth = authcode($pauth,'DECODE',$skey);
		$usermodel = Ebh::app()->model('User');
		$user = $usermodel->getloginbyauth($auth);
		//判断用户登录,暂不考虑媒体中心用户的判断

		if (empty($user)) {
			log_message('会员验证失败');
			exit();
		}
		$schcoursemodel = $this->model('Schcourseware');
		$server_path = 'http://'.$_SERVER['HTTP_HOST'].'/';
		$c = $this->input->get('c');//这里是笔记操作指令
		if($c == 1) {	//添加或编辑笔记
			$noteparam = array();
			if ($user['groupid'] == 5) {	//老师批阅笔记
				$noteparam['aid'] = $aid; 
			} else {
				$noteparam['uid'] = $user['uid'];
			}
			$noteparam['cwid'] = $cwid;
			$note = $schcoursemodel->getcoursenote($noteparam);
			$fieldname = 'FileName';
			if(empty($note))
				$upinfo = $this->uploadfile($fieldname);
			else {	//存在笔记，则更新文件
				$upinfo = $this->uploadfile($fieldname,$note['url']);
			}
			if($upinfo['state'] != 'SUCCESS')
				exit();
			$score = $this->input->post('score');
			$remark = $this->input->post('comment');
			if(!empty($remark))
				$remark = iconv("GB2312","UTF-8//IGNORE",$remark) ;
			if(!empty($note)){	//已存在答题笔记，则更新
				$noteparam['source'] = $server_path;
				$noteparam['url'] = $upinfo['url'];
				$noteparam['size'] = $upinfo['size'];
				if (!empty($aid) && $user['groupid'] == 5) {
					$noteparam['score'] = $score;
					$noteparam['remark'] = $remark;
				}
				$wherearr = array('noteid'=>$note['noteid']);
				$schcoursemodel->updatenote($noteparam,$wherearr);
			}else{
				if ($user['groupid'] == 5) {	//教师不能直接提交答题
					exit();
				}
				$noteparam['source'] = $server_path;
				$noteparam['url'] = $upinfo['url'];
				$noteparam['size'] = $upinfo['size'];
				$schcoursemodel->insertnote($noteparam);
			}
		}else if($c == 2){	//下载答题笔记
			$defaultebhn = 'default.ebhn';	//无作业笔记情况下的默认笔记文件
			$noteparam = array();
			if (is_numeric($aid) && $aid > 0 && $user['groupid'] == 5) {	//老师查看学生笔记
				$noteparam['aid'] = $aid; 
			} else {
				$noteparam['uid'] = $user['uid'];
			}
			$noteparam['cwid'] = $cwid;
			$note = $schcoursemodel->getcoursenote($noteparam);
			if(!empty($note)) {
				if (!empty($note['url'])) {
					getfile('examcourse',$note['url']);
				} else {
					getfile('examcourse',$defaultebhn);
				}
				
			}
		}elseif($c == 3){	//删除笔记
			$noteparam = array();
			$noteparam['uid'] = $user['uid'];
			$noteparam['cwid'] = $cwid;
			$note = $schcoursemodel->getcoursenote($noteparam);
			if(!empty($note)) {
				$result = $schcoursemodel->deletenote(array('noteid'=>$note['noteid']));
				if($result !== FALSE && !empty($note['url'])){
					delfile('examcourse',$note['url']);
				}
			}
		} else if($c == 6) {	//上传图片
			$index = $this->input->post('score');	//小节编号
			if (!is_numeric($aid) || $aid <= 0 || $user['groupid'] != 5) 	//只有老师能上传批注
				exit();
			$filekeys = array_keys($_FILES);
			foreach($filekeys as $upfield){
				$upinfo = $this->uploadfile($upfield,'','examcoursepic');
				if($upinfo['state'] == 'SUCCESS') {
					$noteparam = array();
					$noteparam['aid'] = $aid;
					$noteparam['cwid']=$cwid;
					$noteparam['url'] = $upinfo['showurl'];
					$noteparam['size'] = $upinfo['size'];
					$noteparam['index'] = $index;
					if($upfield == 'voice') {	//如果是语音留言，就插入语音数据
						$schcoursemodel->insertschcwvoices($noteparam);
					} else {
						$schcoursemodel->insertschcwimages($noteparam);
					}
				}
			}
		} elseif ($c == 7) {	//返回学生答案图片组合，http://www.ebanhui.com/2012/12/23/123123.jpg,http://www.ebanhui.com/2012/12/23/123123.jpg 用逗号隔开
			$noteparam = array();
			if ($user['groupid'] == 5) {	//老师批阅主观题答案
				$noteparam['aid'] = $aid; 
			} else {
				$noteparam['uid'] = $user['uid'];
			}
			$noteparam['cwid'] = $cwid;
			if ($user['groupid'] == 5) {
				if(empty($noteparam['aid']) || empty($noteparam['cwid'])) {
					exit();
				}
			}
			$note = $schcoursemodel->getcoursenote($noteparam);
			if(!empty($note)){
				$upanswer =$note['upanswer'];
				if(!empty($upanswer)) {
					$upanswer = trim($upanswer,',');
					echo $upanswer;
				}
			}
		} elseif ($c == 8) {	//获取主观题对应的html内容并输出
			$course = $schcoursemodel->getcoursebyid($cwid);
			if(!empty($course) && !empty($course['html'])) {
				$html = $this->gethtml($course['html']);
				echo $html;
			}
		} elseif ($c == 9) {	//上传主观题学生答题的图片
			if($user['groupid'] != 6)
				exit;
			EBH::app()->helper('image');
			$upfield = 'FileName';
			$upinfo = $this->uploadfile($upfield,'','examcoursepic');
			///log_message(print_r($upinfo,true));
			if($upinfo['state'] == 'SUCCESS') {

				//缩略图处理
				$_UP = Ebh::app()->getConfig()->load('upconfig');
				$showpath = $_UP['examcoursepic']['showpath'];
				$savepath = $_UP['examcoursepic']['savepath'];

				$filepath = $savepath.$upinfo['url'];
				$thumbsize = '800_600';
				$thumbjpg = thumb($filepath,$thumbsize,100);
				if(!empty($thumbjpg)){
					$thumbjpg = substr($thumbjpg,strlen($savepath));
					$upinfo['showurl'] = $showpath.$thumbjpg;
				}


				$noteparam = array();
				$noteparam['uid'] = $user['uid'];
				$noteparam['cwid']=$cwid;
				$note = $schcoursemodel->getcoursenote($noteparam);
				$result = 0;
				if(empty($note)) {	//如果还没有答题笔记记录，则直接生成
					$noteparam['upanswer'] = $upinfo['showurl'];
					$noteid = $schcoursemodel->insertnote($noteparam);
					if($noteid > 0)
						$result = 1;
				} else {	//如果已经有答题笔记记录，则更新
					$noteparam = array();
					if(!empty($note['upanswer']))
						$noteparam['upanswer'] = $note['upanswer'].",".$upinfo['showurl'];
					else
						$noteparam['upanswer'] = $upinfo['showurl'];
					$uresult = $schcoursemodel->updatenote($noteparam,array('noteid'=>$note['noteid']));
					if($uresult !== FALSE)
						$result = 1;
				}
				echo $result;
			} else {
				echo 0;
			}
		}
	}

	/**
	* 上传主观题答题的相关附件
	* @param string $upfield 上传$_FILES的字段名
	* @param string $url 原文件保存相对路径，如果存在，则直接更新该值 如 2013/04/19/120134aj4ljxx4zkbjyp7x.ebhn
	* @param string $configname 上传的配置项名称，即upconfig.php中对应的项
	*/
	private function uploadfile($upfield='',$url = '',$configname='') {
		$uploader = Ebh::app()->lib('Uploader');
		$uploader->setFolder(NULL);
		$uploader->setName(NULL);
		if(!empty($url)) {
			$pos = strrpos($url,'/');
			$folder = substr($url,0,$pos+1);
			$name = substr($url,$pos+1);
			$uploader->setFolder($folder);
			$uploader->setName($name);
		}
        //上传配置
        $config = array(
            "savePath" => "uploads/", //存储文件夹
            "showPath" => "uploads/", //显示文件夹
            "maxSize" => 209715200, //允许的文件最大尺寸，单位字节
            "allowFiles" => array(".ebh",".jpg",".jpeg",".png",".gif",".ebhn",".wav")  //允许的文件格式
        );
        $_UP = Ebh::app()->getConfig()->load('upconfig');
		$up_type = 'examcourse';
		if(!empty($configname)) {
			$up_type = $configname;
		}
        $upload_name = $upfield;
        $savepath = 'uploads/';
        $showpath = 'uploads/';
        if (!empty($_UP[$up_type]['savepath'])) {
            $savepath = $_UP[$up_type]['savepath'];
        }
        if (!empty($_UP[$up_type]['showpath'])) {
            $showpath = $_UP[$up_type]['showpath'];
        }
        $config['savePath'] = $savepath;
        $config['showPath'] = $showpath;

        $uploader->init($upload_name, $config);
        $info = $uploader->getFileInfo();
        return $info;
	}
	/**
	*返回主观题对应的文本页面html代码
	*/
	private function gethtml($content) {
$html=<<<myhtml
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
img{
vertical-align: middle;
word-wrap: break-word;
}
</style>
<title>主观题</title>
</head>
<body>
$content
</body>
</html>
myhtml;
		return $html;
	}
}

?>