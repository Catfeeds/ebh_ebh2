<?php
/**
 * 同步数据处理
 * @author erker
 * 处理完成 直接开启exit
 */
//是否启用同步脚本：true-启用，false-禁用
define('ENABLE', true);
class SyncController extends CControl {
	private $db = null;
	public function __construct(){
		parent::__construct();
        if (!ENABLE) {
            echo "<p>禁用</p>";
            exit(0);
        }
		$this->db = Ebh::app()->getDb();
	}
	
	/**
	 * 同步充值记录
	 */
	public function sync_charge() {
		set_time_limit(0);
		$start = 0;
		$page = 1;
		$offset = 100;
		$count = 0;
		
		$sql = "select count(*) as count from ebh_charges where status =1";
		$row = $this->db->query($sql)->row_array();
		$count = $row['count'];
		
		while($page<=ceil($count/$offset)){
			$start =($page-1)*$offset;
			$sql = "select * from ebh_charges where status = 1 limit $start,$offset";
			$list = $this->db->query($sql)->list_array();
			
			$k = 0;
			foreach($list as $item){
				if($item['rid']>0){
					continue;
				}
				//插入主记录表
				$rdata = array(
					'uid'=>$item['useuid'],
					'cate'=>1,
					'dateline'=>$item['dateline'],
					'status'=>1	
				);
				$rid = $this->db->insert('ebh_records',$rdata);
				
				//获取用户信息
				$usql = "select uid,balance from ebh_users where uid = {$item['useuid']} ";
				$uinfo = $this->db->query($usql)->row_array();
				$balance = $uinfo['balance'];
				
				//更新ebh_charges表
				$cdate = array(
					'rid'=>$rid,
					'curvalue'=>$balance	
				);
				$this->db->update('ebh_charges',$cdate,array('chargeid'=>$item['chargeid']));
				$k++;
			}
			
			echo 'complete  process '.($start+$k)."...<br>";
			$page++;
		}
	}
	
	/**
	 * 同步开发平台以前的绑定数据
	 */
	public function sync_open(){
		set_time_limit(0);
		
		$start = 0;
		$page = 1;
		$offset = 1000;
		$count = 0;
		
		$sql = "select count(*) as count from ebh_users where status =1 
				and ((qqopid  IS NOT NULL and  qqopid !='') 
				OR  (sinaopid  IS NOT NULL and  sinaopid !='')
				 OR  ( wxopenid != '' ) )";
		$row = $this->db->query($sql)->row_array();
		$count = $row['count'];
		
		while($page<=ceil($count/$offset)){
			$start =($page-1)*$offset;
			$sql = "select uid,qqopid,sinaopid,wxopenid from ebh_users where status = 1  
				and ((qqopid  IS NOT NULL and  qqopid !='') 
				OR  (sinaopid  IS NOT NULL and  sinaopid !='')
				 OR  ( wxopenid != '' ) )
				limit $start,$offset";
			$list = $this->db->query($sql)->list_array();
				
			$k = 0;
			foreach($list as $item){
				if(!empty($item['qqopid'])){
					$cuser = array('uid'=>$item['uid']);
					$data = array('openid'=>$item['qqopid'],'nickname'=>'');
					$this->dobind('qq', $data, $cuser);
				}
				if(!empty($item['sinaopid'])){
					$cuser = array('uid'=>$item['uid']);
					$data = array('openid'=>$item['sinaopid'],'nickname'=>'');
					$this->dobind('sina', $data, $cuser);
				}
				if(!empty($item['wxopenid'])){
					$cuser = array('uid'=>$item['uid']);
					$data = array('openid'=>$item['wxopenid'],'nickname'=>'');
					$this->dobind('wx', $data, $cuser);
				}
				
				$k++;
			}
				
			echo 'complete  process '.($start+$k)."...<br>";
			$page++;
		}
	}
	
	/**
	 * 绑定处理
	 * 对应 ebh_binds表
	 * $type qq,wx,sina
	 * $data 对应的开发平台昵称openid nickname等
	 */
	private function dobind($type,$data,$user){
		$retflag = false;
		$bdmodel = $this->model("Bind");
		$umodel = $this->model("User");
		if($type=='qq'){//QQ
			$bdata =array(
					'uid'=>$user['uid'],
					'is_qq'=>1,
					'qq_str'=>json_encode(
							array(
									'qq'=>'',
									'uid'=>$user['uid'],
									'openid'=>	$data['openid'],
									'nickname'=>$data['nickname'],
									'dateline'=>SYSTIME
							)
					)
			);
			//log_message(var_export($bdata,true));
			$retflag = $bdmodel->doBind($bdata,$user['uid']);
		}elseif($type=='wx'){//微信
			$bdata =array(
					'uid'=>$user['uid'],
					'is_wx'=>1,
					'wx_str'=>json_encode(
							array(
									'wx'=>'',
									'uid'=>$user['uid'],
									'openid'=>	$data['openid'],
									'nickname'=>$data['nickname'],
									'dateline'=>SYSTIME
							)
					)
			);
			$retflag = $bdmodel->doBind($bdata,$user['uid']);
				
			//更新主表wxopenid字段
			if(!empty($retflag)){
				//向第三方微信表插入一条记录 -- 与老版本同步(ebh_openwxs)
				$wxmodel = $this->model("Openwx");
				//先查询是否存在
				$ckwx = $wxmodel->checkexist($data['openid']);
				if(!$ckwx){
					$wdata = array(
							'uid'=>$user['uid'],
							'nickname'=>$data['nickname'],
							'openid'=>$data['openid'],
							'dateline'=>SYSTIME,
							'del'=>0
					);
					if(!empty($data['unionid'])){
						$wdata['unionid'] =$data['unionid'];
					}
					if(!empty($data['sex'])){
						$wdata['sex'] =$data['sex'];
					}
					if(!empty($data['headimgurl'])){
						$wdata['headimgurl'] =$data['headimgurl'];
					}
					$wxmodel->add($wdata);
				}

			}
	
		}elseif($type=='sina'){//微博
			$bdata =array(
					'uid'=>$user['uid'],
					'is_weibo'=>1,
					'weibo_str'=>json_encode(
							array(
									'weibo'=>'',
									'uid'=>$user['uid'],
									'sinaopid'=>$data['openid'],
									'nickname'=>$data['nickname'],
									'dateline'=>SYSTIME
							)
					)
			);
			$retflag = $bdmodel->doBind($bdata,$user['uid']);
		}
	
		return $retflag;
	}
	
	
	/**
	 *同步钟凯强开发的微信公众号openid到unionid 
	 */
	public function  sync_zkq(){

		$page = 1;//当前页
		$start = 0;//开始位置
		$pagesize = 100;//偏移量
		$total = 0;//总记录数
		$totalpage = 0;//总页数
		$sum = 0; //处理总数
		
		//微信公众号授权
		$appid = 'wx975d8f85a286b019';
		$appsecret = '0651a801cad257c653bc8c1d177d1f03';
		
		$sql = "select count(*) as count from ebh_users where wxopid  IS NOT NULL &&  wxopid != ''";
		$row = $this->db->query($sql)->row_array();
		$total = intval($row['count']);
		$totalpage = ceil($total/$pagesize);
		
		//获取token
		$get_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
		$retJSON = $this->getGet($get_token_url);
		$retJSON = json_decode($retJSON);
		if(empty($retJSON->access_token)){
			echo 'system get access_token error ...';
			exit;
		}
		$access_token = $retJSON->access_token;

		while ($page <= $totalpage ){
			$start = ($page-1)*$pagesize;
			$wsql ="select uid,wxopid from ebh_users where wxopid  IS NOT NULL &&  wxopid != ''  limit $start,$pagesize";
			$rows = $this->db->query($wsql)->list_array();
			foreach($rows as $item){
				$uid = $item['uid'];
				$openid = $item['wxopid'];
		
				//获取用户基本信息
				$get_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";
				$retObj = $this->getGet($get_info_url);
				$retObj = json_decode($retObj);
				
				if(empty($retObj->unionid)){
					continue;
				}
				
				$unionid = $retObj->unionid;
				$nickname = $retObj->nickname;
				//更新ebh_users表
				$usql = "update ebh_users set wxunionid = '{$unionid}' where uid = {$uid}  ";
				$this->db->simple_query($usql);
				
				//更新ebh_binds表
				//先查询是否存在
				$bsql = "select * from ebh_binds where uid = {$uid}";
				$brow = $this->db->query($bsql)->row_array();
				$jsonstr =json_encode(
						array(
								'wx'=>'',
								'uid'=>$uid,
								'openid'=>$openid,
								'unionid'=>$unionid,
								'nickname'=>$nickname,
								'dateline'=>SYSTIME
						)
				);
				$jsonstr = $this->db->escape($jsonstr);
				
				if(!empty($brow)){
					//修改
					$busql = "update ebh_binds set  is_wx = 1,wx_str = {$jsonstr} where uid = {$uid} ";
					$this->db->simple_query($busql);
				}else{
					//添加
					$basql = " insert into ebh_binds (uid,is_wx,wx_str) values({$uid},1,{$jsonstr}) ";
					$this->db->simple_query($basql);
				}
				
				//更新ebh_openwxs表
				//$osql = "update ebh_openwxs set unionid = '{$unionid}' where uid = {$uid} ";
				//$this->db->simple_query($osql);
				
				$sum ++;
				
				//var_dump($retObj);
			}
			$page++;
		}
		
		echo 'system has process '.$sum."...";
		
	}
	
	/**
	 * 同步黄(eker)开发的微信扫码openid到unionid
	 */
	public function sync_eker(){
		//这个暂时获取不到unionid
	}
	
	/**
	 * 同步ebh_binds表的mobile绑定手机字段同步更新到ebh_users表的cellphone字段
	 */
	public function sync_mobile(){
	    set_time_limit(0);
	    
	    $start = 0;
	    $page = 1;
	    $offset = 100;
	    $count = 0;
	    
	    $sql = "select count(*) as count from ebh_binds where is_mobile =1";
	    $row = $this->db->query($sql)->row_array();
	    $count = $row['count'];
	    
	    while($page<=ceil($count/$offset)){
	        $start =($page-1)*$offset;
	        $sql = "select uid,mobile_str from ebh_binds where is_mobile =1 limit $start,$offset";
	        $list = $this->db->query($sql)->list_array();
	    
	        $k = 0;
	        foreach($list as $item){
	            $uid = $item['uid'];
	            $jsonObj = json_decode($item['mobile_str']);
	            //同步更新ebh_user表
	            $usql = "update ebh_users set `cellphone` = '{$jsonObj->mobile}' where `uid` = $uid limit 1 ";
	            $this->db->simple_query($usql);
	            //同步更新ebh_binds表
	            $bsql = "update ebh_binds set `mobile` = '{$jsonObj->mobile}' where `uid` = $uid limit 1 ";
	            $this->db->simple_query($bsql);
	            $k++;
	        }
	    
	        echo 'complete  process '.($start+$k)."...<br>";
	        $page++;
	    }
	}
	
	
	
	
	
	
	
	
	
	

	
	/**
	 * 删除old cities的缓存
	 */
	public function delcachecity(){
	    $db = $this->db;
	    $area  = $db->query('select * from ebh_cities_old')->list_array();
	    foreach($area as $v){
	        echo "删除citycode_{$v['citycode']}缓存 <br>";
	        $this->cache->remove('citycode_'.$v['citycode']);
	        $key = md5(serialize($v['citycode']));
	        echo "删除{$key}缓存 <br>";
	        $this->cache->remove($key);
	    }
	    echo 'ok';
	}
	
	
	
	
	
	
	
	
	
	
	

	/**
	 * 模拟get
	 * @param unknown $url
	 * @return mixed
	 */
	public function getGet($url){
		//初始化
		$ch = curl_init();
		//设置选项，包括URL
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		//执行并获取HTML文档内容
		$output = curl_exec($ch);
		//释放curl句柄
		curl_close($ch);
		return $output;
	}
	
	/**
	 * 模拟post
	 * @param unknown $url
	 * @param unknown $data
	 * @return mixed
	 */
	public function getPost($url,$data){
		$post_data = $data;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// post数据
		curl_setopt($ch, CURLOPT_POST, 1);
		// post的变量
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}

	/**
	 * 同步所有网校，给没有班级或者学生的网校添加一个默认班级和默认学生
	 */
	public function sync_addDefaultClass(){
		set_time_limit(0);
		$post = $this->input->post();
		if(!empty($post)){
			$page = intval($post['page']);
		}else{//如果是第一次请求
			$start = 0;
			$page = 1;
			$offset = 100;
			$count = 0;
		}
		$offset = 100;
		$total = 0;
		//读取总的记录数
		$crmodel = $this->model('classroom');
		$total = $crmodel->getclassroomcount(array());
		$totalpage = ceil($total/$offset);
		if($page>$totalpage){
			exit();
		}
		$redis = Ebh::app()->getCache("cache_redis");
		$defaultPageKey = 'addDefaultClass'.$page;
		$ck = $redis->get($defaultPageKey);
		//p($page);
		if($ck){//如果缓存已经存在，说明此页数据已经处理，则跳到下一页
			$page++;
		}else{
			//读取所有网校列表
			$param = array();
			$param['pagesize'] = $offset;
			$param['page'] = $page;
			$classroomlist = $crmodel->getroomlist($param);
			$crid = array();//所有的crid数组
			if(!empty($classroomlist)){
				foreach ($classroomlist as $list) {
					array_push($crid,$list['crid']);
				}
			}
			$cridstr = implode(',',$crid);
			$classModel = $this->model('classes');
			$classlist = $classModel->getclasslistBycrid($cridstr);
			$classlists = array();//拥有班级的数组
			$hasstu = array();//有班级，有学生的数组
			$default = array();//班级名为默认班级的数组
			$defaultarr = array();//班级名为默认班级的学生数为0的数组
			if(!empty($classlist)){
				foreach ($classlist as $value) {
					$classlists[$value['crid']][] = $value;
				}
				foreach ($classlists as $lists) {
					foreach ($lists as $lis) {
						if($lis['stunum'] != 0){//如果有班级有学生
							$hasstu[] = $lis['crid'];
							break;
						}else{
							if($lis['classname'] == '默认班级'){
								$default[] = $lis['crid'];
							}
						}
					}
				}
				foreach ($default as $cid) {
					if(!in_array($cid,$hasstu)){
						$defaultarr[] = $cid;
					}
				}
			}
			$hasclass = array();//拥有班级的crid数组
			$noclass = array();//没有班级的crid数组
			$nostu = array();//有班级但没有学生的数组
			$nostuarr = array();//有班级没有学生，班级名没有为默认班级的数组
			$hasclass = array_keys($classlists);
			$noclass = array_diff($crid,$hasclass);
			$nostu = array_diff($hasclass,$hasstu);
			$nostuarr = array_diff($nostu,$defaultarr);
			$this->db->begin_trans();
			$this->addStu($defaultarr);
			$this->addClassAndStu($nostuarr);
			$this->addClassAndStu($noclass);
			if($this->db->trans_status() === FALSE){
            	$this->db->rollback_trans();
            	return false;
            }else{
            	$this->db->commit_trans();
            }
			$redis->set($defaultPageKey,1);
			if($page == $totalpage){
				echo 'success';
				exit();
			}
			$page++;
		}
		$res = $this->getPost('www.ebh.net/sync/sync_addDefaultClass.html',array('page'=>$page));
		if(!empty($res)){
			echo 'success';
		}
	}

	//没有班级没有学生的网校和有班级没学生且没有班级名为默认班级的网校
	public function addClassAndStu($cridarr){
		if(!empty($cridarr)){
			foreach ($cridarr as $crid) {
				$this->_defaultClass($crid);
			}
		}
	}
	//有班级没学生且有班级名为默认班级的网校
	public function addStu($cridarr){
		if(!empty($cridarr)){
			foreach ($cridarr as $crid) {
				//查出网校下名为默认班级的班级classid
				$classmodel = $this->model('classes');
				$classid = $classmodel->getClassByClassname(array('crid'=>intval($crid),'classname'=>'默认班级'));
				if(!empty($classid)){
					$this->_defaultStudent($crid,$classid['classid']);
				}
			}
		}
	}
	//默认添加一个班级
	private function _defaultClass($crid){
		if(!empty($crid)){
			$classModel = $this->model('Classes');
			$classid = $classModel->addclass(array('crid'=>intval($crid),'classname'=>'默认班级'));
			if(!empty($classid)){
				$res = $this->_defaultStudent($crid,$classid);
				if($res){
					return $res;
				}else{
					return false;
				}
			}
		}
		return false;
	}
	//默认添加一个学生
	private function _defaultStudent($crid,$classid){
		if(!empty($crid) && !empty($classid)){
			$username = $this->_createDefaultStudentUsername($crid,true);
			//先添加学生账号
			$member = $this->model('member');
			$param['username'] = $username;
			$param['password'] = '123456';
			$param['realname'] = '默认学生';
			$param['dateline'] = SYSTIME;
			$uid = $member->addmember($param);
			$this->model('credit')->addCreditlog(array('uid'=>$uid,'ruleid'=>1));
			$roomuser = $this->model('roomuser');
			$param['crid'] = $crid;
			$param['uid'] = $uid;
			$param['cnname'] = '默认学生';
			$roomuser->insert($param);
			$param['classid'] = $classid;
			$classes = $this->model('classes');
			//p($param);
			$classes->addclassstudent($param);
			Ebh::app()->lib('xNums')->add('user');
			//更新SNS的学校学生、班级学生缓存
			$snslib = Ebh::app()->lib('Sns');
			$snslib->updateClassUserCache(array('classid'=>$param['classid'],'uid'=>$uid));
			$snslib->updateRoomUserCache(array('crid'=>$param['crid'],'uid'=>$uid));

            //默认学生创建时时记录注册信息到日志
            if($uid){
                $logdata = array();
                $logdata['uid']=$uid;
                $logdata['crid']=$crid;
                $logdata['logtype'] = 4;
                $registerloglib=Ebh::app()->lib('RegisterLog');
                $registerloglib->addOneRegisterLog($logdata);
            }
			/**新增学生课程权限开始**/
			$crmodel = $this->model('classroom');
			$roominfo = $crmodel->getdetailclassroom($crid);
			if($roominfo['isschool'] != 7){
				$classCourseModel = $this->model('Classcourses');
				$userpermissionModel = $this->model('Userpermission');
				$folderids = $classCourseModel->getfolderidsbyclassid($param['classid']);
				if(!empty($folderids)){
					foreach ($folderids as $folder){
						$fids[] = $folder['folderid'];
					}
					$param['itemid'] = 0;
					$param['folderids'] = $fids;
					$param['crid'] = $param['crid'];
					$param['uid'] = $param['uid'];
					$param['type'] = 2;
					$param['classid'] = $param['classid'];
					$param['dateline'] = SYSTIME;
					$userpermissionModel->mutifAddPermission($param);
				}
			}
			/**新增学生课程权限结束**/
			//调用SNS同步接口，类型为4用户网校操作
			$snslib->do_sync($uid, 4);
			return true;
		}
		return false;
	}
	//生成一个默认的学生账号
	private function _createDefaultStudentUsername($crid,$random = false){
		//根据crid获取域名
		if(!empty($crid)){
			$domain = '';
			$crmodel = $this->model('classroom');
			$domain = $crmodel->getdomainByCrid($crid);
			$userModel = $this->model('User');
			$username = $domain['domain'].'_student';
			if($random){
				$username = $username.mt_rand(100,999);
			}
			$check = $userModel->exists($username);
			if($check){
				$this->_createDefaultStudentUsername($crid,true);
			}
			return $username;
		}
		
	}
	//分层网校同步课程、服务项，课程与零散服务项1对1关系，相同课程的零散服务项只保留最新的一个，其它隐藏
    public function syncFolderItem() {
        //查找分层网校ID
        $pagesize = 10;
        $offset = 0;
        $sql = "SELECT `crid` FROM `ebh_classrooms` WHERE `crid`>$offset AND `isschool`=7 ORDER BY `crid` ASC LIMIT $pagesize";
        $crid_arr = $this->db->query($sql)->list_field();
        echo sprintf("<p>%s   开始执行</p>", date('H:i:s'));
        while (!empty($crid_arr)) {
            foreach ($crid_arr as $crid) {
                $this->_deal($crid);
            }
            $offset = $crid;
            $sql = "SELECT `crid` FROM `ebh_classrooms` WHERE `crid`>$offset AND `isschool`=7 ORDER BY `crid` ASC LIMIT $pagesize";
            $crid_arr = $this->db->query($sql)->list_field();
        }
        echo sprintf("<p>%s   完成</p>", date('H:i:s'));
    }
    //同步网校课程服务项,未设置服务项的全校免费课程默认关联服务项
    private function _deal($crid) {
        echo sprintf("<p>处理网校  %d</p>", $crid);
        $sql = "SELECT `pid` FROM `ebh_pay_packages` WHERE `crid`=$crid AND `status`=1";
        $pid_arr = $this->db->query($sql)->list_field();

        //全校免费课程ID集
        $sql = "SELECT `folderid`,`foldername` FROM `ebh_folders` WHERE `crid`=$crid AND `isschoolfree`=1 AND `del`=0";
        $folders = $this->db->query($sql)->list_array('folderid');

        if (empty($pid_arr)) {
            if (!empty($folders)) {
                $this->_default_items($folders, $crid);
            }
            return;
        }
        $pid_arr_str = implode(',', $pid_arr);
        unset($pid_arr);
        $sid_arr = $this->db->query(
            "SELECT `sid` FROM `ebh_pay_sorts` WHERE `pid` IN($pid_arr_str) AND `showbysort`=0")->list_field();
        if (empty($sid_arr)) {
            $sql = "SELECT `itemid`,`folderid` FROM `ebh_pay_items` WHERE `pid` IN($pid_arr_str) AND `crid`=$crid ORDER BY `itemid` ASC";
        } else {
            $sid_arr[] = 0;
            $sortid_arr_str = implode(',', $sid_arr);
            $sql = "SELECT `itemid`,`folderid` FROM `ebh_pay_items` WHERE `pid` IN($pid_arr_str) AND `sid` IN($sortid_arr_str) AND `crid`=$crid ORDER BY `itemid` ASC";
        }
        $items = $this->db->query($sql)->list_array();

        if (!empty($items)) {
            $item_folderids = array_column($items, 'folderid');
            $item_folderids = array_flip($item_folderids);
            $folders = array_diff_key($folders, $item_folderids);
            unset($item_folderids);
        }
        if (!empty($folders)) {
            //未设置服务项的全校免费课程默认关联服务项
            $this->_default_items($folders, $crid);
        }
        if (empty($items)) {
            return;
        }
        $retain = array();
        foreach ($items as $k => $item) {
            //零散的服务项只保留课程的一个服务项,保留最新的服务项
            $retain[$item['folderid']] = $k;
        }
        if (count($items) == count($retain)) {
            //不存在重复课程的服务项，无需处理
            return;
        }
        $retain_keys = array_flip($retain);
        $remove_items = array_diff_key($items, $retain_keys);
        $remove_itemid_arr = array_column($remove_items, 'itemid');

        $itemid_arr_str = implode(',', $remove_itemid_arr);
        $this->db->query("UPDATE `ebh_pay_items` SET `status`=1 WHERE `itemid` IN($itemid_arr_str) AND `crid`=$crid");
    }
    //关联全校免费课程服务项
    private function _default_items($folders, $crid) {
        //$this->db->begin_trans();
        $pay_package = $this->db->query(
            "SELECT `pid` FROM `ebh_pay_packages` WHERE `crid`=$crid AND `pname`='本校免费课程'")
            ->row_array();
        if (empty($pay_package)) {
            $pid = $this->db->insert('ebh_pay_packages', array(
                'pname' => '本校免费课程',
                'crid' => $crid,
                'summary' => '同步的全校免费课程',
                'dateline' => SYSTIME,
                'uid' => 10005
            ));
        } else {
            $pid = $pay_package['pid'];
        }

        if ($pid < 1) {
            return false;
        }
        /*if ($this->trans_status() === false) {
            $this->db->rollback_trans();
            return false;
        }*/
        foreach ($folders as $folderid => $folder) {
            $itemid = $this->db->insert('ebh_pay_items', array(
                'pid' => $pid,
                'iname' => $folder['foldername'],
                'isummary' => '同步的'.$folder['foldername'],
                'crid' => $crid,
                'folderid' => $folderid,
                'iprice' => 99,
                'comfee' => 29.7,
                'roomfee' => 69.3,
                'imonth' => 12,
                'iday' => 0
            ));
            if ($itemid > 0) {
                $this->db->update('ebh_folders', array('fprice' => 99), "`folderid`=$folderid");
            }
            /*if ($this->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }*/
        }
        //$this->db->commit_trans();
    }
	//生成企业网校默认模板
	public function init_com_room_template() {
        header("Content-Type: text/html;charset=utf-8");
		$sql = 'SELECT `tmpid` FROM `ebh_component_schools` WHERE `crid`=0 AND `category`=1';
		$default_template = $this->db->query($sql)->row_array();
		if (!empty($default_template['tmpid'])) {
			die('企业网校默认模板已创建，本次操作无效。');
		}
		//广告位四张图片
		$ads = array(
		    'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/enterprise_r_1.png',
            'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/enterprise_r_2.png',
            'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/enterprise_r_3.png',
            'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/enterprise_r_4.png'
        );
		//默认的四个模块
		$default_modules = array(
			//导航栏
			array(
				'crid' => 0,
				'mid' => 2,
				'columns' => 4,
				'rows' => 1,
				'max_rows' => 1,
				'tx' => 0,
				'ty' => 0,
				'width' => 1200,
				'height' => 50,
				'position_x' => 0,
				'position_y' => 0,
				'zindex' => 0,
				'status' => 0,
				'arg_sign' => 0
			),
			//头部轮播广告
			array(
				'crid' => 0,
				'mid' => 3,
				'columns' => 4,
				'rows' => 1,
				'max_rows' => 1,
				'tx' => 0,
				'ty' => 50,
				'width' => 1200,
				'height' => 436,
				'position_x' => 0,
				'position_y' => 0,
				'zindex' => 0,
				'status' => 0,
				'arg_sign' => 0
			),
			//三列网校简介
			array(
				'crid' => 0,
				'mid' => 5,
				'columns' => 3,
				'rows' => 1,
				'max_rows' => 1,
				'tx' => 0,
				'ty' => 0,
				'width' => 915 ,
				'height' => 330,
				'position_x' => 0,
				'position_y' => 0,
				'zindex' => 0,
				'status' => 0,
				'arg_sign' => 0
			),
			//登录框
			array(
				'crid' => 0,
				'mid' => 6,
				'columns' => 1,
				'rows' => 1,
				'max_rows' => 1,
				'tx' => 915,
				'ty' => 0,
				'width' => 305,
				'height' => 330,
				'position_x' => 0,
				'position_y' => 0,
				'zindex' => 0,
				'status' => 0,
				'arg_sign' => 0
			),
			//1列广告位
			array(
				'crid' => 0,
				'mid' => 9,
				'columns' => 1,
				'rows' => 1,
				'max_rows' => 0,
				'tx' => 0,
				'ty' => 330,
				'width' => 305,
				'height' => 330,
				'position_x' => 0,
				'position_y' => 0,
				'zindex' => 0,
				'status' => 0,
				'arg_sign' => 0
			),
            //1列广告位
            array(
                'crid' => 0,
                'mid' => 9,
                'columns' => 1,
                'rows' => 1,
                'max_rows' => 0,
                'tx' => 305,
                'ty' => 330,
                'width' => 305,
                'height' => 330,
                'position_x' => 0,
                'position_y' => 0,
                'zindex' => 0,
                'status' => 0,
                'arg_sign' => 0
            ),
            //1列广告位
            array(
                'crid' => 0,
                'mid' => 9,
                'columns' => 1,
                'rows' => 1,
                'max_rows' => 0,
                'tx' => 610,
                'ty' => 330,
                'width' => 305,
                'height' => 330,
                'position_x' => 0,
                'position_y' => 0,
                'zindex' => 0,
                'status' => 0,
                'arg_sign' => 0
            ),
            //1列广告位
            array(
                'crid' => 0,
                'mid' => 9,
                'columns' => 1,
                'rows' => 1,
                'max_rows' => 0,
                'tx' => 915,
                'ty' => 330,
                'width' => 305,
                'height' => 330,
                'position_x' => 0,
                'position_y' => 0,
                'zindex' => 0,
                'status' => 0,
                'arg_sign' => 0
            )
		);
		$this->db->begin_trans();
		//生成默认模板记录
		$tmpid = $this->db->insert('ebh_component_schools', array('crid' => 0, 'category' => 1, 'jsonstr' => ''));
		if ($this->db->trans_status() === false) {
			$this->db->rollback_trans();
			die('步骤一出错，回滚操作。');
		}
		foreach ($default_modules as $module) {
			$module['tmpid'] = $tmpid;
			//生成模块配置数据
			$eid = $this->db->insert('ebh_component_items', $module);
			if ($this->db->trans_status() === false) {
				$this->db->rollback_trans();
				die('步骤二出错，回滚操作。');
			}
			//生成广告位
			if ($module['mid'] == 9) {
			    $image = array_shift($ads);
				$this->db->insert('ebh_component_item_options', array(
				    'eid' => $eid,
                    'mid' => 9,
                    'crid' => 0,
                    'image' => $image,
                    'status' => 0)
                );
				if ($this->db->trans_status() === false) {
					$this->db->rollback_trans();
					die('步骤三出错，回滚操作。');
				}
			}
		}
		$this->db->commit_trans();
		die('企业网校默认模板已创建成功');
		
	}
}
