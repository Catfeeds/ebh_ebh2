<?php
/**
 * 个人信息
 */
class ProfileController extends CControl {
	private $user = null;
	public function __construct(){
		parent::__construct();
		$this->user = Ebh::app()->user->getloginuser();
		Ebh::app()->user->checkUserLogin($this->user ,true);
		$this->assign('user',$this->user);
		$this->getassigintop();
	}
	public function index(){
		header("location:/homev2/profile/profile.html");
	}
	/*
	基本信息页面
	*/
	public function profile(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('roominfo', $roominfo);
		
        if($user['groupid']==5){//老师
        	$degreearr = array(
        			1 => '高中',
        			2 => '中专',
        			3 => '大专',
        			4 => '本科',
        			5 => '硕士',
        			6 => '博士'
        	);
        	$teachermodel = $this->model('Teacher');
        	$teacher = $teachermodel->getteacherdetail($this->user['uid']);
        	$teacher['bankcard'] = unserialize($teacher['bankcard']);
        	$editor = Ebh::app()->lib('UEditor');
        	$explist = $this->model('experiences')->getList($this->user['uid']);

        	$this->assign('teacher', $teacher);
        	$this->assign('editor', $editor);
        	$this->assign('degreearr', $degreearr);
        	$this->assign('explist', $explist);
        	//获取qq_href 
			$url = 'http://shop.ebh.net/'.$roominfo['crid'].'/user/getqqhref.html';
			$params['uid'] = $user['uid'];
			$params['crid'] = $roominfo['crid'];
			$ret = do_post($url,$params);
			$ret = json_decode($ret,true);
			$this->assign('qq_href', $ret['qq_href']);
        	$this->display('homev2/profile_teacher');
        }elseif($user['groupid']==6){//学生
        	$this->assign('user', $user);
        	$member = $this->model('member');
        	$memberdetail = $member->getfullinfo($this->user['uid']);
        	
        	$explist = $this->model('experiences')->getList($this->user['uid']);
        	$this->assign('memberdetail',$memberdetail);
        	$this->assign('explist', $explist);
			//隐藏顶部信息
			$hidetop = $this->input->get('ht');
			if(!empty($hidetop))
			$this->assign('hidetop',$hidetop);
			$roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
			if(!empty($roominfo['crid'])){
				$appsetting = Ebh::app()->getConfig()->load('othersetting');
	        	$appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
	        	$appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
	        	$is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
	        	$is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']);
		    }else{
		    	$is_zjdlr = false;
	        	$is_newzjdlr = false;
		    }
			if($is_zjdlr){
				$baseinfo = $this->getbaseinfo();
				$this->getQuestionList();
				$this->getStudyRecord();
				$this->getReviewList();
				$this->getNoteList();
				$this->assign('baseinfo',$baseinfo);
			}	
			//获取qq_href 
			$url = 'http://shop.ebh.net/'.$roominfo['crid'].'/user/getqqhref.html';
			$params['uid'] = $user['uid'];
			$params['crid'] = $roominfo['crid'];
			$ret = do_post($url,$params);
			$ret = json_decode($ret,true);
			$this->assign('qq_href', $ret['qq_href']);
        	$this->display('homev2/profile');
        }
		
	}
	/*
	修改头像页面
	*/
	public function avatar(){
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
        $this->assign('user', $user);
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$avatar = $_UP['avatar']['server'];
	  	$scount = count($_UP['avatar']['server']);
        $spos = rand(0, $scount - 1);
        $uploadurl = $_UP['avatar']['server'][$spos];
        $picurl = $uploadurl.'?uid='.$this->user['uid'];
        $this->assign('picurl',$picurl);
		
		//隐藏顶部信息
		$hidetop = $this->input->get('ht');
		if(!empty($hidetop))
			$this->assign('hidetop',$hidetop);
		$this->display('homev2/avatar');
	}
	
	/*
	修改密码页面
	*/
	public function pass(){
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
        $this->assign('user', $user);
		//隐藏顶部信息
		$hidetop = $this->input->get('ht');
		if(!empty($hidetop))
			$this->assign('hidetop',$hidetop);
		$this->display('homev2/pass');
	}
	/*
	服务记录
	*/
	public function msg(){
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
        $this->assign('user', $user);
		$param = parsequery();
		$param['pagesize'] = 30;
		$param['uid'] = $this->user['uid'];
		$param['status'] = 1;
		$payorderModel = $this->model('payorder');
		$payorderList = $payorderModel->getOrderDetailList($param);
<<<<<<< .mine
=======
		//print_r($payorderList);exit;
>>>>>>> .r9876
		$this->assign('payorderList',$payorderList);
		$payorderCount = $payorderModel->getOrderDetailListCount($param);
		$pageStr = show_page($payorderCount,$param['pagesize']);
		$this->assign('pageStr',$pageStr);
		//隐藏顶部信息
		$hidetop = $this->input->get('ht');
		if(!empty($hidetop))
			$this->assign('hidetop',$hidetop);
		$this->display('homev2/msg');
	}
	/*
	分享记录
	*/
	public function share(){
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
        $this->assign('user', $user);
		$param = parsequery();
		$param['pagesize'] = 30;
		$param['shareuid'] = $this->user['uid'];
		$param['isshare'] = 1;
		$param['status'] = 1;
		$payorderModel = $this->model('payorder');
		$payorderList = $payorderModel->getOrderDetailList($param);
		$this->assign('payorderList',$payorderList);
		$payorderCount = $payorderModel->getOrderDetailListCount($param);
		$pageStr = show_page($payorderCount,$param['pagesize']);
		$this->assign('pageStr',$pageStr);
		//隐藏顶部信息
		$hidetop = $this->input->get('ht');
		if(!empty($hidetop))
			$this->assign('hidetop',$hidetop);
		$this->display('homev2/record_share');
	}
	/*
	历史数据
	*/
	public function largedb(){
		$this->display('homev2/largedb');
	}
	/*
	修改会员操作
	*/
	public function editmember(){
		$param = $this->input->post('data');
		$param = array_map(function(&$v){return h($v);}, $param);
		$member = $this->model('member');		
		$param['uid'] = $this->user['uid'];
				
		//姓名为空时允许修改
		if(!empty($param['cnname'])){
			$memberdetail = $member->getfullinfo($this->user['uid']);
			if(!empty($memberdetail['realname'])){
				log_message('illegal realname change!');
				exit;
			}
		}
		else
		{
			unset($param['cnname']);
		}
		if(isset($param['birthdate']))
		{
			$param['birthdate'] = strtotime($param['birthdate']);
		}
		$res = $member->editmember($param);
		if($res){
			unset($param['uid']);
			if(!isset($param['cnname']))
			{
				$param['cnname'] = '';
			}
			if(isset($param['sex']))
			{
				$param['sex'] = $param['sex'] == 1 ? '女' : '男';
			}
			if(isset($param['birthdate']))
			{
				$param['birthdate'] = date('Y-m-d', $param['birthdate']);
			}
			echo json_encode(array('code' => 1, 'value' => $param, 'message' => '保存成功'));
			$credit = $this->model('credit');
			$credit->addCreditlog(array('ruleid'=>3));
		}
		else
		{
			echo json_encode(array('code' => 2, 'value' => $param, 'message'=> '保存失败或没有修改项'));
		}
	}
	/*
	旧密码确认
	*/
	public function checkoldpassword(){
		//$member = $this->model('member');
		if($this->user['password']==md5($this->input->post('oldpassword')))
			echo 1;
		else echo 0;
	}

	/*
	修改密码操作
	*/
	public function updatepass(){
		$member = $this->model('member');
		if($this->user['password']==md5($this->input->post('oldpassword'))){
			$param['password'] = $this->input->post('password');
			$param['uid'] = $this->user['uid'];
			$member->editmember($param);
			header('location:/homev2/profile/pass.html');
		}
	}
	/*
	 修改密码操作(ajax返回)
	*/
	public function updatepassAjax(){
		$member = $this->model('member');
		if($this->user['password']==md5($this->input->post('oldpassword'))){
			$param['password'] = $this->input->post('password');
			$param['uid'] = $this->user['uid'];
			echo $member->editmember($param);
		}
	}
	
	
	/*
	普通上传头像
	*/
	public function avatarold(){
		
		if($this->input->post()){
			if($this->input->post('returnurl'))
				$returnurl = '<a href="'.$this->input->post('returnurl').'">点击返回</a>';
			else
				$returnurl = '<a href="javascript:history.back(1);">点击返回</a>';
			
			$uptypes = array('image/jpg', //上传文件类型列表
				'image/jpeg', 'image/png', 'image/pjpeg', 'image/gif', 'image/x-png');//上传文件类型列表

			$max_file_size = 1024000; //上传文件大小限制, 单位BYTE 最大5m左右
			$_UP = Ebh::app()->getConfig()->load('upconfig');
			$savepath = $_UP['avatar']['savepath'];
			$showpath = $_UP['avatar']['showpath'];
			$sortpath = $this->getdirurl($savepath); //日期目录 2014/01/01/
			// var_dump($sortpath);
			
			// $imgpreview = 2; //是否生成预览图(1为生成,其他为不生成);
			
			if (!is_uploaded_file($_FILES["UpFile"]['tmp_name'])) {
				header("Content-Type:text/html; charset=UTF-8");
				echo "<font color='red'>文件不存在！</font>";
				echo $returnurl;
				exit;
			}else
			{
				 $ty = $this->get_extname($_FILES['UpFile']['tmp_name']);
				 if(empty($ty))
				 {
					header("Content-Type:text/html; charset=UTF-8");
					echo "<font color='red'>只能上传jpg，gif，png，jpeg图像！</font>";
					echo $returnurl;
					exit;
				 }
				
			}

			$file = $_FILES["UpFile"];
			//检查文件大小
			if ($max_file_size < $file["size"]) {
				header("Content-Type:text/html; charset=UTF-8");
				echo "<font color='red'>图片太大！图片需在1M以内。</font>";
				echo $returnurl;
				exit;
			}
			//检查文件类型
			if (!in_array($file["type"], $uptypes)) {
				header("Content-Type:text/html; charset=UTF-8");
				echo "<font color='red'>只能上传jpg，gif，png，jpeg图像！</font>";
				echo $returnurl;
				exit;
			}

			$filename = $file["tmp_name"];
			$image_size = getimagesize($filename);
			$initwidth = $image_size[0]; //等于本身图片大小
			$initheight = $image_size[1]; //等于本身图片大小
			$pinfo = pathinfo($file["name"]);
			$imagetype = $pinfo['extension'];

			$sourceimg = $sortpath . time() .'_xx.' . $ty; //只包含日期目录、文件名的路径
			$sourcepath = $savepath.$sourceimg; //包含盘符的完整路径
			if (file_exists($sourcepath) && empty($overwrite)) {
				header("Content-Type:text/html; charset=UTF-8");
				echo "<font color='red'>同名文件已经存在了！</a>";
				echo $returnurl;
				exit;
			}
			if (!copy($filename, $sourcepath)) {
				header("Content-Type:text/html; charset=UTF-8");
				echo "<font color='red'>移动文件出错！</a>";
				echo $returnurl;
				exit;
			}

			$fname = $pinfo['basename'];
			$this->assign('fname',$fname);
			$this->assign('sourceimg',$sourceimg);
		}
		$user = Ebh::app()->user->getloginuser();
		$this->assign('sourcepath',$user['face']);
		$this->display('homev2/avatarold');

	}
	/*
	文件后缀
	*/
	private function get_extname($file)
	{
		$type='';
	  $fp = fopen($file, "rb");
	  $bin = fread($fp, 2); //只读2字节
	  fclose($fp);
	  $bin_info  = @unpack("C2chars", $bin);
	  $code = intval($bin_info['chars1'].$bin_info['chars2']);
	  switch ($code) {
		case 255216:
		  $type = 'jpg';
		  break;
		case 7173:
		  $type = 'gif';
		  break;
		case 13780:
		  $type = 'png';
		  break;
	  }
	  return $type;
	}
	/*
	文件路径
	*/
	private function getdirurl($folder) {
		$timestamp=time();
		$destination_folder=$folder;
	//以天存档
		$yearpath=Date('Y', $timestamp).'/';
		$monthpath=$yearpath.Date('m', $timestamp).'/';
		$dayspath = $monthpath.Date('d', $timestamp).'/';
		if(!file_exists($destination_folder))
		mkdir($destination_folder);
		if(!file_exists($destination_folder.$yearpath))
		mkdir($destination_folder.$yearpath);
		if(!file_exists($destination_folder.$monthpath))
		mkdir($destination_folder.$monthpath);
		if(!file_exists($destination_folder.$dayspath))
		mkdir($destination_folder.$dayspath);
		return ltrim($dayspath,'.');
		
	}
	
	public function avatarupdate(){
		
		if(!$this->input->post()){
			echo '错误的访问';
			exit();
		}
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$savepath = $_UP['avatar']['savepath'];
		$showpath = $_UP['avatar']['showpath'];
		$postarr = $this->input->post();
		$sourcepath = $savepath.$postarr['url'];
		if(!file_exists( $sourcepath)){
			header("Content-Type:text/html; charset=UTF-8");
			echo "<font color='red'>文件不存在！</a>";  
			echo "<a href='javascript:history.back(1);'>点击返回</a>";
			exit;
		}
		$filetype = strtolower( strrchr( $sourcepath , '.' ) );
		$file = $postarr['url'];
		$xfile = str_replace("_xx".$filetype,$filetype,$postarr['url']);
		
		
		$this->load($sourcepath); //载入原始图片
		$posary=explode(',', $postarr['cut_pos']);
		foreach($posary as $k=>$v) $posary[$k]=intval($v); //获得缩放比例和裁剪位置
		
		if($posary[2]>0 && $posary[3]>0) $this->resize($posary[2], $posary[3]); //图片缩放
		
		//保存100*100的大图
		
		if($postarr['actionc']=='cutsave'){
			$filearr[1]['size'] = 40;
			$filearr[2]['size'] = 50;
			$filearr[3]['size'] = 78;
			$filearr[4]['size'] = 120;
			$filearr[1]['path'] = str_replace($filetype,"_40_40".$filetype,$xfile);
			$filearr[2]['path'] = str_replace($filetype,"_50_50".$filetype,$xfile);
			$filearr[3]['path'] = str_replace($filetype,"_78_78".$filetype,$xfile);
			$filearr[4]['path'] = str_replace($filetype,"_120_120".$filetype,$xfile);
			$this->cut(120, 120, intval($posary[0]), intval($posary[1]));
		}elseif($postarr['actionc']=='other'){
			if($postarr['op'] == 'folderimg'){
				$this->cut(114, 159, intval($posary[0]), intval($posary[1]));
			}else{
				$this->cut(100, 100, intval($posary[0]), intval($posary[1]));
			}
		}
		// $samll =$savepath.$file;
		// $this->save($samll);
		$this->save($savepath.$xfile);
		if(!empty($filearr)){
			foreach($filearr as $fa){
				$tmpimg = imagecreatetruecolor($fa['size'],$fa['size']);
				imagecopyresampled($tmpimg, $this->_img, 0, 0, 0, 0, $fa['size'], $fa['size'], 120, 120);
				$this->savethumb($tmpimg,$savepath.$fa['path']);
			}
		}
		$destshowpath = $showpath.$xfile;
		$usermodel = $this->model('user');
        $param = array('face'=>$destshowpath);
        $result = $usermodel->update($param,$this->user['uid']);
		if($result !== FALSE){
            echo 1;
			$credit = $this->model('credit');
			$credit->addCreditlog(array('ruleid'=>2));
		}
        else
			echo 0;
	}
	
	
		//源图象
	private $_img;
	//图片类型
	private $_imagetype;
	//实际宽度
	private $_width;
	//实际高度
	private $_height;
	

	//载入图片
	private function load($img_name, $img_type=''){
		if(!empty($img_type)) $this->_imagetype = $img_type;
		else $this->_imagetype = $this->get_type($img_name);
		switch ($this->_imagetype){
			case 'gif':
				if (function_exists('imagecreatefromgif'))	$this->_img=imagecreatefromgif($img_name);
				break;
			case 'jpg':
				$this->_img=imagecreatefromjpeg($img_name);
				break;
			case 'png':
				$this->_img=imagecreatefrompng($img_name);
				break;
			default:
				$this->_img=imagecreatefromstring($img_name);
				break;
		}
		$this->getxy();
	}

	//缩放图片
	private function resize($width, $height, $percent=0)
	{
		if(!is_resource($this->_img)) return false;
		if(empty($width) && empty($height)){
			if(empty($percent)) return false;
			else{
				$width = round($this->_width * $percent);
				$height = round($this->_height * $percent);
			}
		}elseif(empty($width) && !empty($height)){
			$width = round($height * $this->_width / $this->_height );
		}else{
			$height = round($width * $this->_height / $this->_width);
		}
		$tmpimg = imagecreatetruecolor($width,$height);
		if(function_exists('imagecopyresampled')) imagecopyresampled($tmpimg, $this->_img, 0, 0, 0, 0, $width, $height, $this->_width, $this->_height);
		else imagecopyresized($tmpimg, $this->_img, 0, 0, 0, 0, $width, $height, $this->_width, $this->_height);
		$this->destroy();
		$this->_img = $tmpimg;
		$this->getxy();
	}

	//裁剪图片
	private function cut($width, $height, $x=0, $y=0){
		if(!is_resource($this->_img)) return false;
		if($width > $this->_width) $width = $this->_width;
		if($height > $this->_height) $height = $this->_height;
		if($x < 0) $x = 0;
		if($y < 0) $y = 0;
		$tmpimg = imagecreatetruecolor($width,$height);
		imagecopy($tmpimg, $this->_img, 0, 0, $x, $y, $width, $height);
		$this->destroy();
		$this->_img = $tmpimg;
		$this->getxy();
	}
	
	
	//保存图片 $destroy=true 是保存后销毁图片变量，false这不销毁，可以继续处理这图片
	private function save($fname, $destroy=false, $type='')
	{
		if(!is_resource($this->_img)) return false;
		if(empty($type)) $type = $this->_imagetype;
		switch($type){
			case 'jpg':
			case 'jpeg':
				$ret=imagejpeg($this->_img, $fname);
				break;
			case 'gif':
				$ret=imagegif($this->_img, $fname);
				break;
			case 'png':
			default:
				$ret=imagepng($this->_img, $fname);
				break;
		}
		if($destroy) $this->destroy();
		return $ret;
	}
	//保存缩略图
	private function savethumb($thumb,$fname)
	{
		if(!is_resource($thumb)) return false;
		if(empty($type)) $type = $this->_imagetype;
		switch($type){
			case 'jpg':
			case 'jpeg':
				$ret=imagejpeg($thumb, $fname);
				break;
			case 'gif':
				$ret=imagegif($thumb, $fname);
				break;
			case 'png':
			default:
				$ret=imagepng($thumb, $fname);
				break;
		}
		return $ret;
	}
	//销毁图像
	private function destroy()
	{
		if(is_resource($this->_img)) imagedestroy($this->_img);
	}
	
	//取得图像长宽
	private function getxy()
	{
		if(is_resource($this->_img)){
			$this->_width = imagesx($this->_img);
			$this->_height = imagesy($this->_img);
		}
	}
	

	//获得图片的格式，包括jpg,png,gif
	private function get_type($img_name)//获取图像文件类型
	{
		if (preg_match("/\.(jpg|jpeg|gif|png)$/i", $img_name, $matches)){
			$type = strtolower($matches[1]);
		}else{
			$type = "string";
		}
		return $type;
	}

	/*
	返回头像地址
	*/
	public function getavatar(){
		$user = Ebh::app()->user->getloginuser();
		if(!empty($user) && !empty($user['face']))
			echo $user['face'];
	}

	/**
	 * ajax修改签名
	 */
	public function editmysign(){
		$callback = $this->input->get('callback');
		if (empty($callback))
		{
			$mysign = h($this->input->post('mysign'));
		}
		else
		{
			$mysign = h($this->input->get('mysign'));
		}
		$uid = $this->user['uid'];
		$data['code'] = 0;//修改成功标志，1表示成功，0表示失败
		$data['mysign'] = '';//返回的已截取的字符串
		if (mb_strlen($mysign, 'UTF8') <= 140)
		{
			if ($this->model('user')->update(array('mysign' => $mysign), $uid))
			{
				$data['code'] = 1;
				if (empty($mysign))
				{
					$data['mysign'] = '暂无签名';
				}
				else
				{
					$data['mysign'] = shortstr($mysign,20);
				}
			}
		}
			
		if(!empty($callback)){
			echo $callback.'('.json_encode($data).')';
		}else{
			echo json_encode($data);
		}
	}

	/**
	 * 添加过往经历
	 */
	public function addexperience(){
		$param['begindate'] = h($this->input->post('begindate'));
		$param['enddate'] = h($this->input->post('enddate'));
		$param['description'] = h($this->input->post('description'));
		$param['uid'] = $this->user['uid'];

		$res = $this->model('experiences')->addExperience($param);
		if($res)
		{
			echo json_encode(array('code' => 1, 'message' => '添加成功', 'expid' => $res));
		}
		else
		{
			echo json_encode(array('code' => 2, 'message'=> '添加失败'));
		}
	}

	/**
	 * 编辑过往经历
	 */
	public function editexperience(){
		$param['expid'] = intval($this->input->post('expid'));
		$param['begindate'] = h($this->input->post('begindate'));
		$param['enddate'] = h($this->input->post('enddate'));
		$param['description'] = h($this->input->post('description'));
		$param['uid'] = $this->user['uid'];

		//判断该条经历是否属于当前用户
		$experience = $this->model('experiences')->getOne($param['expid']);
		if ($param['uid'] != $experience['uid'])
		{
			log_message('非法编辑不属于自己的过往经历!');
			exit;
		}

		//保存
		$res = $this->model('experiences')->editExperience($param);
		if($res)
		{
			echo json_encode(array('code' => 1, 'message' => '编辑成功'));
		}
		else
		{
			echo json_encode(array('code' => 2, 'message'=> '编辑失败或没有修改项'));
		}
	}

	
	/**
	 * 删除过往经历
	 */
	public function delexperience(){
		$expid = intval($this->input->post('expid'));
		$uid = $this->user['uid'];

		//判断该条经历是否属于当前用户
		$experience = $this->model('experiences')->getOne($expid);
		if ($uid != $experience['uid'])
		{
			log_message('非法删除不属于自己的过往经历!');
			exit;
		}

		//保存
		$res = $this->model('experiences')->delExperience($expid);
		if($res)
		{
			echo json_encode(array('code' => 1, 'message' => '删除成功'));
		}
		else
		{
			echo json_encode(array('code' => 2, 'message'=> '删除失败'));
		}
	}


	/**
	 * 获取top信息
	 */
	public function getassigintop(){
		$user = $this->user;
		//uri
		$this->assign('controller',$this->uri->uri_control());
		$this->assign('action',$this->uri->uri_method());
        $clinfo = array();
        $clinfo['title']='';
		if($user['groupid']==5){//老师
			//积分等级
			$clconfig = Ebh::app()->getConfig()->load('creditlevel_t');
			foreach($clconfig as $clevel){
				if($user['credit']>=$clevel['min'] && $user['credit']<=$clevel['max']){
					$clinfo['title'] = $clevel['title'];
					if($user['credit']<=500){
						$clinfo['percent'] = 50*intval($user['credit'])/500;
					}elseif($user['credit']<=3000){
						$clinfo['percent'] = 50+30*(intval($user['credit'])-500)/2500;
					}elseif($user['credit']<=10000){
						$clinfo['percent'] = 80+20*(intval($user['credit'])-3000)/7000;
					}else{
						$clinfo['percent'] = 100;
					}
					break;
				}
			}
		}elseif($user['groupid']==6){//学生
			//积分等级
			$clconfig = Ebh::app()->getConfig()->load('creditlevel');
			foreach($clconfig as $clevel){
				if($user['credit']>=$clevel['min'] && $user['credit']<=$clevel['max']){
					$clinfo['title'] = $clevel['title'];
					if($user['credit']<=500){
						$clinfo['percent'] = 50*intval($user['credit'])/500;
					}elseif($user['credit']<=3000){
						$clinfo['percent'] = 50+30*(intval($user['credit'])-500)/2500;
					}elseif($user['credit']<=10000){
						$clinfo['percent'] = 80+20*(intval($user['credit'])-3000)/7000;
					}else{
						$clinfo['percent'] = 100;
					}
					break;
				}
			}
		}
		$this->assign('clinfo',$clinfo);
		//完成度百分比
		$percent = Ebh::app()->user->getpercent($this->user);
		$this->assign('percent',$percent);
		 
		//粉丝
		$snsmodel = $this->model('Snsbase');
		$mybaseinfo = $snsmodel->getbaseinfo($this->user['uid']);
		$myfanscount = max(0,$mybaseinfo['fansnum']);
		//关注
		$myfavoritcount = max(0,$mybaseinfo['followsnum']);
		$this->assign('myfanscount',$myfanscount);
		$this->assign('myfavoritcount',$myfavoritcount);
	}
	/**
	 * 获取成长记录基础数据 
	 */
	private function getbaseinfo(){
		$roominfo = Ebh::app()->room->getcurroom();
		//积分
		$user = Ebh::app()->user->getloginuser();
		$info['credit'] = $user['credit'];		
		$askmodel = $this->model('Askquestion');
		$studymodel = $this->model('Studylog');
		$exammodel = $this->model('Exam');
		$classesmodel = $this->model('Classes');
		//学习
		$mystudycount = $studymodel->getStudyCount(array('uid'=>$user['uid'],'totalflag'=>0,'crid'=>$roominfo['crid']));
		$info['mystudycount'] = $mystudycount;
		//提问
		$myaskcount = $askmodel->getmyaskcount(array('uid'=>$user['uid'],'shield'=>0,'crid'=>$roominfo['crid']));
		$info['myaskcount'] = $myaskcount;
		
		//答疑
		$myanscount = $askmodel->getaskcountbyanswers(array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'qshield'=>0,'ashield'=>0));
		$info['myanscount'] = $myanscount;
		//评论
		$reviewmodel = $this->model('review');
		$myreviewcount = $reviewmodel->getreviewcount(array('uid'=>$user['uid'],'rcrid'=>1,'status'=>1,'crid'=>$roominfo['crid']));
		$info['myreviewcount'] = $myreviewcount;
		return $info;
	}
	/**
	 * 获取学习记录
	 */
	public function getStudyRecord(){
		$userinfo = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$post = $this->input->post();
		$pageflag = false;
		if(empty($post)){
			$ProgressModel = $this->model('Progress');
			$studylist = $ProgressModel->getRoomStudyRecord(array('uid'=>$userinfo['uid'],'crid'=>$roominfo['crid'],'page'=>1,'pagesize'=>4,'order'=>' order by startdate desc'));
			$studycount = $ProgressModel->getRoomStudyRecordCount(array('uid'=>$userinfo['uid'],'crid'=>$roominfo['crid']));
			if($studycount > 4){
				$pageflag = true;
			}
			$page = 1;
			foreach ($studylist as &$slist) {
				$slist['titleall'] = $slist['title'];
				$slist['title'] = ssubstrch($slist['title'],0,80);
			}
			$this->assign('spage',$page);
			$this->assign('studylist',$studylist);
			$this->assign('spageflag',$pageflag);
		}else{
			$page = $post['page'];
			$ProgressModel = $this->model('Progress');
			$studylist = $ProgressModel->getRoomStudyRecord(array('uid'=>$userinfo['uid'],'crid'=>$roominfo['crid'],'page'=>$page,'pagesize'=>4,'order'=>' order by startdate desc'));
			$studycount = $ProgressModel->getRoomStudyRecordCount(array('uid'=>$userinfo['uid'],'crid'=>$roominfo['crid']));
			if(($page * 4) < $studycount){
				$pageflag = true;
			}
			foreach ($studylist as &$slist) {
				$slist['titleall'] = $slist['title'];
				$slist['title'] = ssubstrch($slist['title'],0,80);
				$slist['date'] = timetostr($slist['startdate'],'Y-m-d');
			}
			echo json_encode(array('page'=>$page,'pageflag'=>$pageflag,'studylist'=>$studylist));
			exit;
		}
	}
	/**
	 * 获取提问和解答列表
	 */
	public function getQuestionList(){
		$userinfo = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$post = $this->input->post();
		$pageflag = false;
		if(empty($post)){
			$questionModel = $this->model('Askquestion');
			$questionlist = $questionModel->getAnswerAndQuestionByUid($userinfo['uid'],$roominfo['crid']);
			$questioncount = $questionModel->getAnswerAndQuestionCount($userinfo['uid'],$roominfo['crid']);
			if($questioncount > 4){
				$pageflag = true;
			}
			$questionlist = empty($questionlist)?array():$questionlist;
			foreach ($questionlist as &$qlist) {
				$qlist['titleall'] = $qlist['title'];
				$qlist['title'] = shortstr($qlist['title'],80);
			}
			$page = 1;
			$this->assign('qpage',$page);
			$this->assign('questionlist',$questionlist);
			$this->assign('qpageflag',$pageflag);
		}else{
			$page = $post['page'];
			$questionModel = $this->model('Askquestion');
			$questionlist = $questionModel->getAnswerAndQuestionByUid($userinfo['uid'],$roominfo['crid'],$page);
			$questioncount = $questionModel->getAnswerAndQuestionCount($userinfo['uid'],$roominfo['crid']);
			if($questioncount > ($page * 4)){
				$pageflag = true;
			}
			$questionlist = empty($questionlist)?array():$questionlist;
			foreach ($questionlist as &$qlist) {
				$qlist['date'] = timetostr($qlist['dateline'],'Y-m-d');
				$qlist['titleall'] = $qlist['title'];
				$qlist['title'] = shortstr($qlist['title'],80);
			}
			echo json_encode(array('page'=>$page,'pageflag'=>$pageflag,'questionlist'=>$questionlist));
			exit;
		}
	}
	/**
	 * 获取评论列表
	 */
	public function getReviewList(){
		$userinfo = Ebh::app()->user->getloginuser();
		$post = $this->input->post();
		$pageflag = false;
		if(empty($post)){
			$param['uid'] = $userinfo['uid'];
			$param['type'] = 'courseware';
			$param['audit'] = 1;
			$param['limit'] = '0,4';
			$reviewmodel = $this->model('Review');
			$reviewlist = $reviewmodel->getreviewlist($param);
			$reviewcount = $reviewmodel->getreviewcount($param);
			$cwidarr = array();
			if(!empty($reviewlist)){
				foreach ($reviewlist as $rlist) {
					if(!in_array($rlist['toid'],$cwidarr))
						$cwidarr[] = $rlist['toid'];
				}
				
				$cwinfo = $this->model('courseware')->getCwinfoListRewardByCwid(implode(',',$cwidarr));
				if(!empty($cwinfo)){
					foreach ($reviewlist as &$rlist) {
						foreach ($cwinfo as $info) {
							if($info['cwid'] == $rlist['toid']){
								$rlist['titleall'] = $info['title'];
								$rlist['title'] = shortstr($info['title'],25);
							}
						}
						$rlist['subjectall'] = $rlist['subject'];
						$rlist['subject'] = shortstr($rlist['subject'],80);
					}
				}
			}
			$reviewlist = parseEmotion($reviewlist);
			if($reviewcount >4){
				$pageflag = true;
			}
			$page = 1;
			$this->assign('reviewlist',$reviewlist);
			$this->assign('rpage',$page);
			$this->assign('rpageflag',$pageflag);
		}else{
			$page = $post['page'];
			$param['uid'] = $userinfo['uid'];
			$param['type'] = 'courseware';
			$param['audit'] = 1;
			$param['limit'] = (($page - 1) * 4).',4';
			$reviewmodel = $this->model('Review');
			$reviewlist = $reviewmodel->getreviewlist($param);
			$reviewcount = $reviewmodel->getreviewcount($param);
			$cwidarr = array();
			if(!empty($reviewlist)){
				foreach ($reviewlist as $rlist) {
					if(!in_array($rlist['toid'],$cwidarr))
						$cwidarr[] = $rlist['toid'];

				}
				$cwinfo = $this->model('courseware')->getCwinfoListRewardByCwid(implode(',',$cwidarr));
				if(!empty($cwinfo)){
					foreach ($reviewlist as &$rlist) {
						foreach ($cwinfo as $info) {
							if($info['cwid'] == $rlist['toid']){
								$rlist['titleall'] = $info['title'];
								$rlist['title'] = shortstr($info['title'],25);
							}
						}
						$rlist['subjectall'] = $rlist['subject'];
						$rlist['subject'] = shortstr($rlist['subject'],80);
						$rlist['date'] = timetostr($rlist['dateline'],'Y-m-d');
					}
					$reviewlist = parseEmotion($reviewlist);
				}
			}
			if($reviewcount > ($page * 4)){
				$pageflag = true;
			}
			echo json_encode(array('page'=>$page,'pageflag'=>$pageflag,'reviewlist'=>$reviewlist));
			exit;
		}
	}
	/**
	 * 获取笔记记录
	 */
	public function getNoteList(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$post = $this->input->post();
		$pageflag = false;
		if(empty($post)){
			$noteModel = $this->model('Note');
			$page = 1;
			$param['page'] = $page;
			$param['pagesize'] = 4;
			$param['uid'] = $user['uid'];
			$param['crid'] = $roominfo['crid'];
			$notelist = $noteModel->getnotelistbyuid($param);
			$notecount = $noteModel->getnotelistcountbyuid($param);
			foreach ($notelist as &$nlist) {
				$nlist['titleall'] = $nlist['title'];
				$nlist['ftextall'] = strip_tags($nlist['ftext']);
				$nlist['title'] = shortstr($nlist['title'],25);
				$nlist['ftext'] = shortstr(strip_tags($nlist['ftext']),80);
			}
			if($notecount > 4){
				$pageflag = true;
			}
			$this->assign('notelist',$notelist);
			$this->assign('npage',$page);
			$this->assign('npageflag',$pageflag);
		}else{
			$page = $post['page'];
			$param['page'] = $page;
			$param['pagesize'] = 4;
			$param['uid'] = $user['uid'];
			$param['crid'] = $roominfo['crid'];
			$noteModel = $this->model('Note');
			$notelist = $noteModel->getnotelistbyuid($param);
			$notecount = $noteModel->getnotelistcountbyuid($param);
			if(!empty($notelist)){
				foreach ($notelist as &$nlist) {
					$nlist['titleall'] = $nlist['title'];
					$nlist['ftextall'] = strip_tags($nlist['ftext']);
					$nlist['title'] = shortstr($nlist['title'],25);
					$nlist['date'] = timetostr($nlist['fdateline'],'Y-m-d');
					$nlist['ftext'] = shortstr(strip_tags($nlist['ftext']),80);					
				}
			}
			if($notecount > ($page * 4)){
				$pageflag = true;
			}
			echo json_encode(array('page'=>$page,'pageflag'=>$pageflag,'notelist'=>$notelist));
			exit;
		}
	}
	
}