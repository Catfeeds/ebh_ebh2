<?php
/**
 * 系统设置
 */
class SystemsettingController extends CControl {
	public function __construct(){
		parent::__construct();
        Ebh::app()->room->checkRoomControl();
	}

	/**
	 * 系统设置菜单页
	 */
	public function index(){
		$this->display('aroomv2/systemsetting');
	}

	/**
	 * 推广设置
	 */
	public function seo() {
		$roominfo = Ebh::app()->room->getcurroom();
		$systemsetting = $this->model('systemsetting')->getSetting($roominfo['crid']);
		if (!empty($systemsetting)){
			$systemsetting['ipbanlist'] = str_replace(',', "\n", $systemsetting['ipbanlist']);
		}
		$this->assign('roominfo', $roominfo);
		$this->assign('systemsetting', $systemsetting);
		$this->display('aroomv2/systemsetting_seo');
	}

	/**
	 * 保存推广设置
	 */
	public function saveseo() {
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['faviconimg'] = $this->input->post('faviconimg');
		$param['favicon'] = $this->input->post('favicon');
		$param['metakeywords'] = $this->input->post('metakeywords');
		$param['metadescription'] = $this->input->post('metadescription');
		$param['ipbanlist'] = $this->input->post('ipbanlist');
		$param['analytics'] = $this->input->post('analytics', FALSE);
		$icp = strip_tags($this->input->post('icp'));

		$result = $this->model('systemsetting')->update($param);
		$result_room = $this->model('classroom')->editclassroom(array('crid'=>$roominfo['crid'], 'icp'=>$icp));
		if ($result !== false && $result_room !== false)
		{
			$this->_updateCache($param);//更新缓存
			echo json_encode(array('status' => 1, 'msg' => '保存成功'));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0, 'msg' => '保存失败'));
			exit;
		}
	}

	/**
	 * 域名设置
	 */
	public function domain() {
		$roominfo = Ebh::app()->room->getcurroom();
		$systemsetting = $this->model('systemsetting')->getSetting($roominfo['crid']);
        $param['toid']=$roominfo['crid'];
        $param['type']=13;
        $checkresult=$this->model('billchecks')->getdomainCheckDetail($param);
        $fulldomain=$this->model('domaincheck')->getdomain($roominfo['crid']);
        $this->assign('fulldomain',$fulldomain);
        $this->assign('checkresult',$checkresult);
		$this->assign('roominfo', $roominfo);
		$this->assign('systemsetting', $systemsetting);
		$this->display('aroomv2/systemsetting_domain');

	}

	/**
	 * 绑定域名
	 */
	public function binddomain() {

		$this->display('aroomv2/systemsetting_binddomain');
	}

	/**
	 * 保存域名
	 */
	public function savebinddomain() {
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['fulldomain'] = $this->input->post('fulldomain');
        $param['domain_time']=SYSTIME;
        $param['crname']=$roominfo['crname'];
        $isdomain=$this->model('classroom')->checkdomain($param);
        if (empty($isdomain)){
            $checkresult=$this->checkDomain($param['fulldomain']);
            if (($checkresult==true) ){
                $result =$this->model('domaincheck')->editdomain($param);
                if ($result !== false )
                {
                    $this->_updateCache($param);//更新缓存
                    echo json_encode(array('status' => 1, 'msg' => '提交成功'));
                    exit;
                }
                else
                {
                    echo json_encode(array('status' => 0, 'msg' => '提交失败'));
                    exit;
                }

            }else{
                echo json_encode(array('status' => 0, 'msg' => '请输入已注册的域名'));
            }
        }else{
            echo json_encode(array('status' => 0, 'msg' => '域名已经存在'));
        }

	}

	/**
	 * 解除绑定
	 */
	public function unbinddomain() {
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['fulldomain'] = '';
        $param['icp']='';
		$result = $this->model('classroom')->editclassroom($param);
        $res=$this->model('domaincheck')->deldomain($param);
        $bparam['crid']=$roominfo['crid'];
        $bparam['admin_status']='';
        $bparam['teach_status']='';
        $bparam['admin_remark']='';
        $bparam['teach_remark']='';
        $bparam['type']=13;
        $checkresult=$this->model('billchecks')->editstatus($bparam);
		if (($result !== false) && ($checkresult !==false) &&($res !==false) )
		{
			$this->_updateCache($param);//更新缓存
			echo json_encode(array('status' => 1, 'msg' => '解除成功'));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0, 'msg' => '解除失败'));
			exit;
		}

	}

	/**
	 * 修改域名
	 */
	public function modifydomain() {
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['fulldomain'] = $this->input->post('fulldomain');
        $isdomain=$this->model('classroom')->checkdomain($param);
        if (empty($isdomain)){
            $checkresult=$this->checkDomain($param['fulldomain']);
            if($checkresult==true){
                $param['domain_time']=SYSTIME;
                $param['crid']=$roominfo['crid'];
                $param['icp']='';
                $bparam['crid']=$roominfo['crid'];
                $bparam['admin_status']='';
                $bparam['teach_status']='';
                $bparam['admin_remark']='';
                $bparam['teach_remark']='';
                $bparam['type']=13;
                $tresult =$this->model('domaincheck')->editdomain($param);
                $bresult=$this->model('billchecks')->editstatus($bparam);
                if ( ($bresult !== false) && ($tresult !==false))
                {
                    $this->_updateCache($param);//更新缓存
                    $this->_updateCache($bparam);
                    echo json_encode(array('status' => 1, 'msg' => '修改成功'));
                    exit;
                }
                else
                {
                    echo json_encode(array('status' => 0, 'msg' => '修改失败'));
                    exit;
                }
            }else{
                echo json_encode(array('status' => 0, 'msg' => '请输入已注册的域名'));
                exit;
            }

        }else{
            echo json_encode(array('status' => 0, 'msg' => '域名已经存在'));
        }


	}

	/**
	 * 登录设置
	 */
	public function login() {
		$roominfo = Ebh::app()->room->getcurroom();
		$systemsetting = $this->model('systemsetting')->getSetting($roominfo['crid']);
		$this->assign('systemsetting', $systemsetting);
		$this->display('aroomv2/systemsetting_login');
	}

	/**
	 * 保存登录设置
	 */
	public function savelogin() {
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['limitnum'] = $this->input->post('limitnum');
		$result = $this->model('systemsetting')->update($param);
		if ($result !== false)
		{
			$this->_updateCache($param);//更新缓存
			echo json_encode(array('status' => 1, 'msg' => '保存成功'));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0, 'msg' => '保存失败'));
			exit;
		}

	}

	/**
	 * 登录设备查看
	 */
	public function client() {
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['q'] = $this->input->get('q');
		$clientlist = $this->model('userclient')->getClientList($param);
		$clientcount = $this->model('userclient')->getClientCount($param);
		$pagestr = show_page($clientcount);
		$this->assign('q',$param['q']);
		$this->assign('pagestr',$pagestr);
		$this->assign('clientlist', $clientlist);
		$this->display('aroomv2/systemsetting_client');
	}

	/**
	 * 查看全部设备
	 */
	public function showclient() {
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $this->input->post('uid');

		$info = array('username'=>'', 'realname'=>'', 'clients'=>'');
		$clientlist = $this->model('userclient')->getUserClientList($param);
		if (!empty($clientlist)){
			foreach ($clientlist as $client) {
				$info['username'] = empty($info['username']) ? $client['username'] : $info['username'];
				$info['realname'] = empty($info['realname']) ? $client['realname'] : $info['realname'];
				$myclient[] = $client['system'] . ' ' . $client['browser'] . '浏览器';
			}
			$info['clients'] = implode('、', $myclient);
		}

		echo json_encode(array('status'=>1, 'info'=>$info));
	}

	/**
	 * 保存登录设置
	 */
	public function clearclient() {
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $this->input->post('uid');

		//检查是否存在登录设备记录
		$clientlist = $this->model('userclient')->getUserClientList($param);
		if (empty($clientlist)){
			echo json_encode(array('status' => 0, 'msg' => '清除失败'));
			exit;
		}

		//清除记录
		$result = $this->model('userclient')->delete($param);
		if ($result !== FALSE)
		{
			echo json_encode(array('status' => 1, 'msg' => '清除成功'));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0, 'msg' => '清除失败'));
			exit;
		}

	}

	//更新缓存
	private function _updateCache($param) {
		$roominfo = Ebh::app()->room->getcurroom();
		$settingarr = array('favicon', 'metakeywords', 'metadescription', 'ipbanlist', 'analytics', 'limitnum', 'service', 'opservicetime', 'opserviceuid', 'crid');
		foreach ($param as $key => $value) {
			if (!in_array($key, $settingarr))
				unset($param[$key]);
		}
        $param['crid'] = $roominfo['crid'];
		$redis = Ebh::app()->getCache('cache_redis');
		$redis_key = 'room_systemsetting_' . $roominfo['crid'];

		$redis->hMset($redis_key, $param);
	}
	
	
	/**
	 * 验证域名是否有效
	 * 已注册的域名 可以使用
	 */
	protected function checkDomain($url){
		//require_once 'Whois.php';

		$check = false;
		$whois =  Ebh::app()->lib("Whois");
		$topdomain = $this->getTopDomain($url);
        //print_r($topdomain);die;
		if(!empty($topdomain)){
			$row = $whois->query($topdomain, 3);
            //print_r($row);
			if(($row['error']===0) && ($row['data']['registration']=='registered')){
				$check  = true;
			}
		}

		return $check;
	}
	
	/**
	 * 获取顶级域名
	 * @param unknown $url
	 */
	protected function getTopDomain($url){
		$topdomain = false;
		if($this->isDomain($url)){
		  // echo 111;die;
			preg_match('/[\w][\w-]*\.(?:com\.cn|com|cn|co|net|org|gov|cc|biz|info)(\/|$)/isU', $url, $domain);
			$topdomain =  rtrim($domain[0], '/');
		}

		return $topdomain;
	}
	
	/**
	 * @author      Default7 <default7@zbphp.com>
	 * @description 匹配
	 *              t.cn 正确
	 *              t-.cn 错误
	 *              tt.cn正确
	 *              -t.cn 错误
	 *              t-t.cn 正确
	 *              tst-test-tst.cn 正确
	 *              tst--tt.cn -- 错误
	 *
	 *
	 *
	 * @param $domain
	 *
	 * @return bool
	 */
	protected function isDomain($domain)
	{

		 $result=!empty($domain) && strpos($domain, '--') === false &&
		preg_match('/^([a-z0-9]+([a-z0-9-]*(?:[a-z0-9]+))?\.)?[a-z0-9]+([a-z0-9-]*(?:[a-z0-9]+))?(\.us|\.tv|\.org\.cn|\.org|\.net\.cn|\.net|\.mobi|\.me|\.la|\.info|\.hk|\.gov\.cn|\.edu|\.com\.cn|\.com|\.co\.jp|\.co|\.cn|\.cc|\.biz)$/i', $domain) ? true : false;

        return $result;
	}
	

}