<?php
/*
基本信息
*/
class SettingsController extends CControl{
	private $user = null;
	public function __construct(){
		parent::__construct();
		$this->user = Ebh::app()->user->getloginuser();
		if(empty($this->user)){
			header('location:/login.html?returnurl='.$_SERVER['REQUEST_URI']);
			exit;
		}
		$this->assign('user',$this->user);
		
	}
	public function index(){
		
		$this->profile();
	}
	/*
	基本信息页面
	*/
	public function profile(){
		$member = $this->model('member');
		$memberdetail = $member->getfullinfo($this->user['uid']);
		//var_dump($memberdetail);
		$this->assign('memberdetail',$memberdetail);
		$this->display('myroom/profile');
	}
	/*
	修改头像页面
	*/
	public function avatar(){
		$this->display('myroom/avatar');
	}
	
	/*
	修改密码页面
	*/
	public function pass(){
		$this->display('myroom/pass');
	}
	/*
	站内信息页面
	*/
	public function msg(){
		$log = $this->model('log');
		$param = parsequery();
		$param['opid'] = 67108864;
		$param['toid'] = 6;
		$logcount = $log->getsystemlogcount($param);
		$loglist = $log->getsystemloglist($param);
		$this->assign('loglist',$loglist);
		$this->display('myroom/msg');
	}
	/*
	修改会员操作
	*/
	public function editmember(){
		$member = $this->model('member');
		$name = $this->input->post('name');
		$value = $this->input->post('value');
		$param[$name] = $value;
		//$param = $this->input->post();var_dump($param );
		$param['uid'] = $this->user['uid'];
		$res = $member->editmember($param);
		if($res){
			if($name == 'sex')
				$value = $value?'女':'男';
			if($name == 'citycode')
				;
			if($name == 'birthdate')
				$value = Date('Y-m-d',$value);
			echo json_encode(array('code'=>1,'value'=>$value));
			$credit = $this->model('credit');
			$credit->addCreditlog(array('ruleid'=>3));
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
			header('location:/member/setting/pass.html');
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
		$this->display('myroom/avatarold');

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
	EQ修改头像页面
	*/
	public function eqavatar(){
		$this->display('member/eqavatar');
	}
	/*
	EQ基本信息页面
	*/
	public function eqprofile(){
		$member = $this->model('member');
		$memberdetail = $member->getfullinfo($this->user['uid']);
		$this->assign('memberdetail',$memberdetail);
		$this->display('member/eqprofile');
	}
	/*
	返回头像地址
	*/
	public function getavatar(){
		$user = Ebh::app()->user->getloginuser();
		if(!empty($user) && !empty($user['face']))
			echo $user['face'];
	}
}
?>