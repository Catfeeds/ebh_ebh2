<?php
/**
 *学分控制器
 */
class SchcreditController extends CControl{
	public function index(){
		//获取当前学校信息
		$roominfo = Ebh::app()->room->getcurroom();

		//获取当前学校的类型
		$type = $roominfo['grade'];

		//判断学校的类型是否合法
		if(!in_array($type, array(0,1,7,10))){
			show_404();
			exit;
		}

		//根据学校类型获取学校年级列表
		$_SG = Ebh::app()->getConfig()->load('schoolgrade');
		$gradeList = $_SG[$type];

		$this->assign('gradeList',$gradeList);

		//获取学分数据库模型
		$schcreditModel = $this->model('schcredit');

		//获取当前学校的年级学分情况
		$curschoolInfo = array(
			'crid'=>$roominfo['crid']
		);
		$gradeScoreList = $schcreditModel->getScoreList($curschoolInfo);
		$gradeScoreList = $this->formatScore($gradeScoreList);
		$this->assign('gradeScoreList',$gradeScoreList);
		$this->display('aroomv2/schcredit');
	}

	public function editAjax(){
		//获取修改参数
		$rec = $this->input->post();
		if(empty($rec['grade'])){
			echo 0;exit;
		}
		//获取要修改学分的年级
		$grade = intval($rec['grade']);
		//获取要修改成的学分
		$score = intval($rec['score']);

		//获取当前学校信息
		$roominfo = Ebh::app()->room->getcurroom();

		//生成参数
		$param = array();
		$param['crid'] = $roominfo['crid'];
		$param['grade'] = $grade;
		$param['score'] = $score;

		$where = array(
			'crid'=>$roominfo['crid'],
			'grade'=>$grade
		);

		//获取学分数据库模型
		$schcreditModel = $this->model('schcredit');

		//获取当前学校的年级学分情况
		$curschoolInfo = array(
			'crid'=>$roominfo['crid'],
			'grade'=>$grade
		);
		$gradeScore = $schcreditModel->getScoreList($curschoolInfo);
		//如果该学校该年级学分不存在则添加一条记录否则修改对应的记录
		if(empty($gradeScore)){
			echo $schcreditModel->_insert($param);
		}else{
			echo $schcreditModel->_update($param,$where);
		}

		/**写日志开始**/
		fastcgi_finish_request();
		$message = '学分信息：'.json_encode($param);
		$opid = 1;
		if(!empty($gradeScore)){
			$message.= json_encode($where);
			$opid = 2;
		}
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$roominfo['crid'],
				'message'=>$message,
				'opid'=>$opid,
				'type'=>'classroom'
				)
		);
		/**写日志结束**/
	}

	/**
	 *格式化学校学分设置
	 */
	private function formatScore($scoreList = array()){
		$returnArr = array();
		foreach ($scoreList as $score) {
			$returnArr[$score['grade']] = $score;
		}
		return $returnArr;
	}

	/**
	*学生学分同步
	*使用方法：1.教师账号登录
	*		   2.请求网址：http://xxx.ebanhui.com/aroom/schcredit/creditSync.html (xxx表示学校域名)
	*			或者：请求网址 http://xxx.ebanhui.com/aroom/schcredit/creditSync.html?dolog=1 (会记录下修复学生的信息)
	*结果页显示修复数目 如 fixed:2 表示修复了2个学生
	*/
	public function creditSync(){
		set_time_limit(0);
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$dolog = $this->input->get('dolog');
		if(empty($roominfo) || empty($user) || $user['groupid']!=5){
			header("Content-type:text/html;charset=utf-8");
			echo '教室或者教师信息有误！';exit;
		}
		$param = array(
			'crid'=>$roominfo['crid'],
			'limit'=>10000
		);
		$stuList = $this->model('roomuser')->getaroomstudentlist($param);
		if(empty($stuList)){
			header("Content-type:text/html;charset=utf-8");
			echo '教室没有学生！';exit;
		}

		$fixed = array();
		$schcreditlogModel = $this->model('schcreditlog');
		foreach ($stuList as $stu) {
			$res = $schcreditlogModel->schcreditSync($roominfo['crid'],$stu['uid']);
			if($res>0){
				array_push($fixed, $stu['uid'].'----'.$stu['username'].'----'.$stu['realname']);
			}
		}
		if($dolog){
			log_message(implode("\r\n", $fixed));
		}
		echo 'fixed:',count($fixed);
	}

	/**
	*学生学分同步
	*使用方法：1.教师账号登录
	*		   2.请求网址：http://xxx.ebanhui.com/aroom/schcredit/schcreditTimeSync.html (xxx表示学校域名)
	*			或者：请求网址 http://xxx.ebanhui.com/aroom/schcredit/schcreditTimeSync.html?dolog=1 (会记录下修复学生的信息)
	*结果页显示修复数目 如 fixed:2 表示修复了2个学生
	*/
	public function schcreditTimeSync(){
		set_time_limit(0);
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$dolog = $this->input->get('dolog');
		if(empty($roominfo) || empty($user) || $user['groupid']!=5){
			header("Content-type:text/html;charset=utf-8");
			echo '教室或者教师信息有误！';exit;
		}
		$param = array(
			'crid'=>$roominfo['crid'],
			'limit'=>10000
		);
		$stuList = $this->model('roomuser')->getaroomstudentlist($param);
		if(empty($stuList)){
			header("Content-type:text/html;charset=utf-8");
			echo '教室没有学生！';exit;
		}
		$fixed = array();
		$schcreditlogModel = $this->model('schcreditlog');
		foreach ($stuList as $stu) {
			$res = $schcreditlogModel->schcreditTimeSync($roominfo['crid'],$stu['uid']);
			if($res>0){
				array_push($fixed, $stu['uid'].'----'.$stu['username'].'----'.$stu['realname']);
			}
		}
		if($dolog){
			log_message(implode("\r\n", $fixed));
		}
		echo 'fixed:',count($fixed);
	}
}