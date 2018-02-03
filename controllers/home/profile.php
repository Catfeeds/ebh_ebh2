<?php
/**
 * 个人信息
 */
class ProfileController extends CControl {
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
		header("location:/home/profile/profile.html");
	}
	/*
	基本信息页面
	*/
	public function profile(){
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
        $this->assign('user', $user);
		$member = $this->model('member');
		$memberdetail = $member->getfullinfo($this->user['uid']);
		//var_dump($memberdetail);
        $explist = $this->model('experiences')->getList($this->user['uid']);
		$this->assign('memberdetail',$memberdetail);
        $this->assign('explist', $explist);
		$this->display('home/profile');
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
		$this->display('home/avatar');
	}
	
	/*
	修改密码页面
	*/
	public function pass(){
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
        $this->assign('user', $user);
		$this->display('home/pass');
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
		$this->assign('payorderList',$payorderList);
		$payorderCount = $payorderModel->getOrderDetailListCount($param);
		$pageStr = show_page($payorderCount,$param['pagesize']);
		$this->assign('pageStr',$pageStr);
		
		$this->display('home/msg');
	}
	/*
	历史数据
	*/
	public function largedb(){
		$this->display('home/largedb');
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
			header('location:/home/profile/pass.html');
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
		$this->display('home/avatarold');

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
		$mysign = empty($callback) ? $this->input->post('mysign') : $this->input->get('mysign');
		$mysign = h(strip_tags($mysign));
		$uid = $this->user['uid'];
		$data['code'] = 0;//修改成功标志，1表示成功，0表示失败
		$data['mysign'] = '';//返回的已截取的字符串
		if(!empty($mysign)){
			$this->checkSensitive($mysign);
		}
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
     * 对添加或编辑的问题的标题和内容进行敏感词验证
     */
    public function checkSensitive($title){
    	//获取国土的网校配置,如果是国土，不进行验证
        $roominfo = Ebh::app()->room->getcurroom();
        $appsetting = Ebh::app()->getConfig()->load('othersetting');
        $appsetting['zjdlsensitive'] =  !empty($appsetting['zjdlsensitive'])? 1 : 0;//浙江国土是否开通关键字过滤
        $appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
        $appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']);
        if (($is_zjdlr || $is_newzjdlr) && !$appsetting['zjdlsensitive']) {//国土网校则执行
            return '';
        }
		
        require(LIB_PATH."SimpleDict.php");
        if(!file_exists(LIB_PATH."sensitive.cache")){
            SimpleDict::make(LIB_PATH."sensitive.dat",LIB_PATH."sensitive.cache");
        } 
        $dict = new SimpleDict(LIB_PATH."sensitive.cache");
        $title =  preg_replace("/\s/","",$title);
        $result = $dict->search($title);
        $resultarr= array();
        if(!empty($result)){
            foreach ($result as $key => $value) {
                $resultarr[] =  $value['value'];
            }
            echo json_encode(array('code'=>0,'Sensitive'=>$resultarr));
            exit;
        }
    }
    //添加QQ在线状态
	public function addqqhref(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$href = $this->input->post('href');
		$url = 'http://shop.ebh.net/'.$roominfo['crid'].'/user/addqqhref.html';
		$data['qq_href'] = $href;
		$data['uid'] = $user['uid'];
		$data['crid'] = $roominfo['crid'];
		$ret = do_post($url, $data);
		echo $ret;die;
	}
	//如何获取QQ在线状态
	public function step(){
	    $room = Ebh::app()->room->getcurroom();
	    $this->assign('room',$room);
		$this->display('mall/step');
	}
	
}