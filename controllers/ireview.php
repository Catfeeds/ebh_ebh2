<?php
/**
 * 手机应用IreviewController
 */
class IreviewController extends CControl {
	private $user = NULL;	//当前用户
	public function __construct() {
		parent::__construct();
        $this->user = $this->getLoginUser();
		if(empty($this->user)) {	//非法用户，则直接退出
			echo 'user fail';
			exit();
		}
	}
	public function index() {
		$user = $this->user;
		$crid = $this->input->get('rid');
		if(empty($crid) || !is_numeric($crid) || $crid <= 0) {	//验证rid是否合法
			exit();
		}
		$reviewmodel = $this->model('review');
		//$q = $this->input->get('q');
		$params = parsequery();
		$params['crid'] = $crid;
		$params['uid'] = $user['uid'];
		$params['rcrid'] = 1;
		$params['displayorder'] = 'r.logid desc';
		$params['pagesize'] = 20;
		$params['shield'] = 1;
		//$params['q'] = $q;
		$reviews = $reviewmodel->getReviewListByUid($params);
		$count = $reviewmodel->getreviewcount($params);
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
	//	$pagestr = show_page($count,10);

		$this->assign('reviews', $reviews);
	//	$this->assign('pagestr', $pagestr);
		$this->assign('count', $count);
		$this->assign('crid', $crid);
		$this->assign('user', $user);
		$auth = $this->input->get('k');
		$this->assign('k', $auth);
		$this->display('common/ireview');
	}
	//点击加载评论列表
	public function onclicklist(){
		$user = $this->user;
		$crid = $this->input->post('crid');
		if(empty($crid) || !is_numeric($crid) || $crid <= 0) {	//验证crid是否合法
			exit();
		}
		$uid = $user['uid'];
		$reviewmodel = $this->model('review');
		$params = parsequery();
	//echo $crid.'+'.$user['uid'];
		$params['crid'] = $crid;
		$params['uid'] = $uid;
		$params['rcrid'] = 1;
		$params['displayorder'] = 'r.logid desc';
		$params['pagesize'] = 20;
		$params['shield'] = 1;
		$params['page'] = $this->input->post('page');
		$reviews = $reviewmodel->getReviewListByUid($params);
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		//数据格式化 时间和头像缩略图
		foreach($reviews as &$review){
			$review['dateline'] = date('Y-m-d H:i:s', $review['dateline']);
		}
		echo json_encode($reviews);
		exit();
	}
	/**
	*根据APP接口过来的key获取当前用户
	*/
	private function getLoginUser() {
		if (isset($this->user))
			return $this->user;
		$auth = str_replace(' ','+',$this->input->get('k'));
		$usermodel = $this->model('user');
        if (!empty($auth)) {
            @list($password, $uid,$ip,$time) = explode("\t", authcode($auth, 'DECODE'));
            $curip = $this->input->getip();
            if($curip != $ip)
                return FALSE;
            $uid = intval($uid);
            if ($uid <= 0) {
                return FALSE;
            }
            $user = $usermodel->getloginbyuid($uid,$password,TRUE);
            return $user;
        }
        return FALSE;
	}
}
