<?php

/**
 * 学生我的答疑控制器类 MyaskController
 */
class MyaskController extends CControl {
	private $check = NULL;
    public function __construct() {
        parent::__construct();
        $check = TRUE;
		$this->check = $check;
		$this->assign('check',$check);
    }

    
	public function all(){
		$requireFolderid = $this->input->get('folderid');
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
        $queryarr = parsequery();
        $queryarr['shield'] = 0;
        //$queryarr['crid'] = $roominfo['crid'];
        $folderid = intval($folderid);
        if(!empty($folderid)){
            $queryarr['folderid'] = $folderid;
        }
		
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getallasklist($queryarr);
        $count = $askmodel->getallaskcount($queryarr);
        $pagestr = show_page($count);

        //更新评论用户状态时间
        $typeid = 2;
        
        $this->assign('notop', 1);
        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);

    
        $this->display('jingpin/myask_all');
	}
   
    /**
     * 问题详情
     */
   /* public function view() {
        $qid = $this->uri->itemid;
        if (is_numeric($qid)) {
			$roominfo = Ebh::app()->room->getcurroom();
			$crid = $roominfo['crid'];
            $editor = Ebh::app()->lib('UMEditor');
            $param = parsequery();
			$param['qid'] = $qid;
			$param['pagesize'] = 10;
            $askmodel = $this->model('Askquestion');
            $user = Ebh::app()->user->getloginuser();
            //人气数+1
            $askmodel->addviewnum($qid);
            $ask = $askmodel->getdetailaskbyqid($qid, $user['uid'],$crid);
            if(empty($ask)){
                $url = getenv("HTTP_REFERER");
                header("Content-type:text/html;charset=utf-8");
                echo "问题不存在或已删除";
                echo '<a href="'. $url.'">返回</a>';
                exit;
            }
            elseif(!empty($ask) && $ask['shield']==1){
                $url = getenv("HTTP_REFERER");
                header("Content-type:text/html;charset=utf-8");
                echo "问题被屏蔽，无法查看";
                echo '<a href="'. $url.'">返回</a>'; 
                exit;
            }
            $answers = $askmodel->getdetailanswersbyqid($param);
            $count = $askmodel->getdetailanswerscountbyqid($qid);
            $pagestr = show_page($count,$param['pagesize']);
			
			//悬赏奖励者名单
			$rewardlist = array();
			if ($ask['isrewarded'] == 1)
			{
				$rewardlist = $this->model('credit')->getRewardList($qid);
			}
            $this->assign('rewardlist', $rewardlist);

			$answerers =  $askmodel->getanswerer(array('qid'=>$qid));
			$this->assign('answerers',$answerers);
            $this->assign('ask', $ask);
            $this->assign('answers', $answers);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('qid', $qid);
            $this->assign('editor', $editor);
            $this->display('college/myask_view');
        }
    }
*/
    
	
}
