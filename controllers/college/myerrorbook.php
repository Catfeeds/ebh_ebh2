<?php
/**
 * 学校学生我的错题本相关控制器 MyerrorbookController
 */
class MyerrorbookController extends CControl {
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('crid',$roominfo['crid']);
        $check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
	public function index() {
		$q = $this->input->get('q');
		$answerdate = $this->input->get('d');
		$queryarr = parsequery();
		$requireFolderid = $this->input->get('folderid');
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
		$this->assign('q',$q);
		$this->display('college/myerrorbook');
	}
	/**
	*删除我的错题
	*/
	public function del() {
		$eid = $this->input->post('eid');
		if(is_numeric($eid) && $eid > 0) {
			$errormodel = $this->model('Errorbook');
			$user = Ebh::app()->user->getloginuser();
			$param['eid'] = $eid;
			$param['uid'] = $user['uid'];
			$result = $errormodel->delete($param);
			if($result) {
				echo 'success';
			} else {
				echo 'fail';
			}
		}
	}

	/**
	 * 获取分页html代码
	 *	重写common下的show_page函数
	 * @param int $listcount总记录数
	 * @param int $pagesize分页大小
	 * @return string
	 */
	private function _show_page($listcount, $curpage,$pagesize = 20) {
		//print_r($listcount.$curpage.$pagesize);
		$pagecount = @ceil($listcount / $pagesize);

		if ($curpage > $pagecount) {
			$curpage = $pagecount;
		}
		if ($curpage < 1) {
			$curpage = 1;
		}
		//这里写前台的分页
		$centernum = 10; //中间分页显示链接的个数
		$multipage = '<div class="pages"><div class="listPage">';
		if ($pagecount <= 1) {
			$back = '';
			$next = '';
			$center = '';
		} else {
			$back = '';
			$next = '';
			$center = '';
			if ($curpage == 1) {
				for ($i = 1; $i <= $centernum; $i++) {
					if ($i > $pagecount) {
						break;
					}
					if ($i != $curpage) {
						$center .= '<a >' . $i . '</a>';
					} else {
						$center .= '<a class="none">' . $i . '</a>';
					}
				}
				$next .= '<a  id="next">下一页&gt;&gt;</a>';
			} elseif ($curpage == $pagecount) {
				$back .= '<a  id="next">&lt;&lt;上一页</a>';
				for ($i = $pagecount - $centernum + 1; $i <= $pagecount; $i++) {
					if ($i < 1) {
						$i = 1;
					}
					if ($i != $curpage) {
						$center .= '<a>' . $i . '</a>';
					} else {
						$center .= '<a class="none">' . $i . '</a>';
					}
				}
			} else {
				$back .= '<a  id="next">&lt;&lt;上一页</a>';
				$left = $curpage - floor($centernum / 2);
				$right = $curpage + floor($centernum / 2);
				if ($left < 1) {
					$left = 1;
					$right = $centernum < $pagecount ? $centernum : $pagecount;
				}
				if ($right > $pagecount) {
					$left = $centernum < $pagecount ? ($pagecount - $centernum + 1) : 1;
					$right = $pagecount;
				}
				for ($i = $left; $i <= $right; $i++) {
					if ($i != $curpage) {
						$center .= '<a >' . $i . '</a>';
					} else {
						$center .= '<a class="none">' . $i . '</a>';
					}
				}
				$next .= '<a  id="next">下一页&gt;&gt;</a>';
			}
		}
		$multipage .= $back . $center . $next . '</div></div>';
		$multipage .= '<script type="text/javascript">' . "\n"
				. '$(function(){' . "\n"
				. '$("#gopage").keypress(function(e){' . "\n"
				. 'if (e.which == 13){' . "\n"
				. '$(this).next("#page_go").click()' . "\n"
				. 'cancelBubble(this,e);' . "\n"
				. '}' . "\n"
				. '})' . "\n"
				. '})</script>';
		return $multipage;

	}

	public function getajaxpage(){
		$domain = $this->uri->uri_domain();
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$errormodel = $this->model('Errorbook');
		$schquechapters = $this->model('Schquechapters');
		$chaptersmodel = $this->model('Chapter');
		$queryarr = array();
		$queryarr['pagesize'] = 20;
		$queryarr['page'] = $this->input->post('page');
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['uid'] = $user['uid'];
		$queryarr['folderid'] = $this->input->post('folderid');
		$queryarr['quetype'] = $this->input->post('quetype');
		$queryarr['q'] = $this->input->get('q');
		if($queryarr['q'] == '请输入关键字' OR $queryarr['q'] == 'undefined'){
			unset($queryarr['q']);
		}
		//是否有关联qid
		$chapterid = intval($this->input->post('chapterid'));
		$topchapterid = intval($this->input->post('topchapterid'));
		$secchapterid = intval($this->input->post('secchapterid'));
		//优化根据知识点过滤错题本
		if($chapterid <=0){
			$chapterid = $secchapterid >0 ? $secchapterid : $topchapterid;
		}
		$tmpchapterids = array();
		if($chapterid >0){
			//查出跟chapterid相关的子知识点
			$chapterids = $schquechapters->getcnodesbychapterid($chapterid);
			if(!empty($chapterids)){
				foreach ($chapterids as $item){
					$tmpchapterids[] = $item['chapterid'];
				}
			}
		}
		//有关联知识点则先查出对应的qid
		if(!empty($tmpchapterids)){
			$chapteridres =	$schquechapters->getlist(array('chapterids'=>$tmpchapterids));
		}
		if(!empty($chapteridres)){
			foreach ($chapteridres as $item){
				$qids[] = $item['qid'];
			}
		}
		$queryarr['qids'] = !empty($qids) ? $qids : array();
		$errors = array();
		$count = 0;
		if(!($chapterid>0 && empty($qids))){
			//如果有关联qid则继续过滤
			if($domain == 'lcyhg'){//根据域名过滤（一个学生多个班级）
				$errors = $errormodel->myscherrorbooklist($queryarr,true);
				$count = $errormodel->myscherrorbooklistcount($queryarr,true);
			}else{
				$errors = $errormodel->myscherrorbooklist($queryarr);
				$count = $errormodel->myscherrorbooklistcount($queryarr);
			}
		}
		$exid = array();
		if(!empty($errors)){
			foreach ($errors as $key1 => $value1) {
				$exid[]= $value1['exid'];
			}
			$exid = array_unique($exid);
			$exidstr = implode($exid,',');
			if(!empty($exidstr)){
				$exidname = $errormodel->getexambyexid($exidstr);
				if(!empty($exidname)){
					foreach ($exidname as $e => $name) {
						foreach ($errors as $er => $val) {
							if($name['eid'] == $val['exid']){
								$errors[$er]['etitle'] = $name['title'];
							}
						}
					}
				}
			}
		}
		//获取错题关联的知识点
		if(!empty($errors)){
			foreach ($errors as $k=>$item){
				$theques = is_array($item['ques'][0])?$item['ques'][0]:$item['ques'];
				$chapters = empty($theques['chapters']) ? array() : explode(',', $theques['chapters']);
				//兼容旧版本错题本知识点显示
				if(empty($chapters)){
					$chapters = !empty($theques['chapterid']) ? array($theques['chapterid']) : array();
				}
				$chapterstxt = $chaptersmodel->getchapterpathstr($chapters);
				$theques['chapterstxt'] = $chapterstxt;
				is_array($item['ques'][0]) ? $errors[$k]['ques'][0] = $theques : $errors[$k]['ques'] = $theques;
			}
		}
		
		$pagestr = $this->_show_page($count,$queryarr['page'],$queryarr['pagesize']);
		$context = array('pagesize'=>$queryarr['pagesize'],'errors'=>$errors,'pagestr'=>$pagestr,'roominfo'=>$roominfo);
		$fragment = $this->_display('college/errorbook_fragment',$context);
		$res = array(
			'fragment'=>$fragment
		);
		//var_dump($res);die;
		echo json_encode($res);
	}

	/**
     * 碎片模板 O(∩_∩)O哈哈~
     * @param string $view 模板名称
     */
    private function _display($view,$context) {
        $viewpath = VIEW_PATH.$view.'.php';
        if(!file_exists($viewpath)) {
            echo 'error view not exists:'.$viewpath;
            return;
        }
        ob_start();
        extract($context);
        include $viewpath;
        $outputstr = ob_get_contents();
		@ob_end_clean();
        return $outputstr;
    }
}
