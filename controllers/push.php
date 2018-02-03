<?php
/**
 *问题和问题，问题和作业关联控制器
 */
class PushController extends CControl{
	/**
	 *获取教师回答过的问题列表
	 */
	public function question(){
		$roominfo = Ebh::app()->room->getcurroom();
      $user = Ebh::app()->user->getloginuser();
      $q = $this->input->get('q');
      $queryarr = parsequery();
      $queryarr['crid'] = $roominfo['crid'];
      $queryarr['uid'] = $user['uid'];
	    $queryarr['qshield'] = 0;
	    $queryarr['ashield'] = 0;
	    $d = $this->input->get('d');
  		if(!empty($d)) {
  			$thetime = strtotime($d);
  			if($thetime !== FALSE) {
  				$startdate = $thetime;
  				$enddate = $thetime + 86400;
  				$queryarr['startDate'] = $startdate;
  				$queryarr['endDate'] = $enddate;
  			}
  		}
      $askmodel = $this->model('Askquestion');
      $asks = $askmodel->getasklistbyanswers($queryarr);
      $count = $askmodel->getaskcountbyanswers($queryarr);
      $pagestr = show_page($count);
	
	    $this->assign('asks', $asks);
      $this->assign('pagestr', $pagestr);
      $this->assign('user', $user);
      $this->assign('crid', $roominfo['crid']);
      $this->assign('q', $q);
	    $this->assign('d',$d);
	    $this->assign('notop',1);
      $this->display('common/question_push');
	}

	/**
	 *关联问题的推送
	 */
	public function doQuestionPush(){
		$roominfo = Ebh::app()->room->getcurroom();
      $user = Ebh::app()->user->getloginuser();

      $qid = intval($this->input->post('qid'));
      $reqid = intval($this->input->post('reqid'));
      if(empty($user) || empty($qid) ||empty($reqid))
      {
      	echo 'fail';exit;
      }
  		$param = array(
  			'reqid'=>$reqid,
  			'lastansweruid'=>$user['uid'],
  			'answered'=>1
  		);
  		$where = array(
  			'qid'=>$qid,
  			'tid'=>$user['uid']
  		);
  		$askmodel = $this->model('Askquestion');
  		$result = $askmodel->relationBind($param,$where);
  		if($result>0)
  		{
  			echo 'success';
            fastcgi_finish_request();
            EBH::app()->lib('SMS')->run($qid,$user['uid'],2);
  		}else{
  			echo 'fail';
  		}
	}
 /**
   * 问题详情
  */
  public function view() {
      $qid = $this->uri->itemid;
      if (is_numeric($qid)) {
          $editor = Ebh::app()->lib('UMEditor');
          $param = parsequery();
          $param['qid'] = $qid;
          $param['pagesize'] = 10;
          $askmodel = $this->model('Askquestion');
          $user = Ebh::app()->user->getloginuser();
          //人气数+1
          $askmodel->addviewnum($qid);
          $ask = $askmodel->getdetailaskbyqid($qid, $user['uid']);
          if(!empty($ask) && $ask['shield']==1){
              $url = getenv("HTTP_REFERER");
              header("Content-type:text/html;charset=utf-8");
              echo "问题被屏蔽，无法查看";
              echo '<a href="'. $url.'">返回</a>'; 
              exit;
          }
          $answers = $askmodel->getdetailanswersbyqid($param);
          $count = $askmodel->getdetailanswerscountbyqid($qid);
          $pagestr = show_page($count);
          $this->assign('ask', $ask);
          $this->assign('answers', $answers);
          $this->assign('pagestr', $pagestr);
          $this->assign('user', $user);
          $this->assign('qid', $qid);
          $this->assign('editor', $editor);
          $this->assign('notop',1);
          $this->display('common/showpushask');
      }
  }
}
