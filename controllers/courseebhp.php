<?php
/**
 * 课件详情
 */
class CourseebhpController extends CControl {
	
	function view() {

		$cwid = $this->uri->itemid;
		if(!is_numeric($cwid) || $cwid <= 0)
			exit();
		$roominfo = Ebh::app()->room->getcurroom();
		$from = $this->uri->uri_attr(0);	//来源，0或空为全校课程 1 为我的课程 2 为教师课程
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		//课件详情
		$coursedetail = $coursemodel->getcoursedetails($cwid);
		if(!empty($course)) {	//生成课件所在服务器地址
			$serverutil = Ebh::app()->lib('ServerUtil');
			$source = $serverutil->getCourseSource();
			if(!empty($source)) {
				$course['cwsource'] = $source;
			}
		}
		$count = $coursemodel->getexamcount($cwid);
		$this->assign('coursedetail', $coursedetail);
		$this->assign('count', $count);
		//添加课件查看数
		$coursemodel->addviewnum($cwid);
		if(empty($course))
			exit();
		$hasnobtn = $this->uri->uri_attr(0);	//是否不显示开始听课按钮
		if($hasnobtn == 1) {
			$hasnobtn = TRUE;
		} else {
			$hasnobtn = FALSE;
		}
		$this->assign('hasnobtn',$hasnobtn);
		$user = Ebh::app()->user->getloginuser();
        $this->assign('course', $course);
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['cwid'] = $cwid;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
		$this->assign('source',$source);
        $this->assign('attachments', $attachments);
		//课件评论
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($count);
		//$pagestr = $this->_show_page($count,1,10);
		
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		//单个课件下的作业
		$exammodel  = $this->model('exam');
		$param = array('cwid'=>$cwid,'limit'=>'0,100');
		$examlist = $exammodel->getexamonlinelist($param);
		$this->assign('examlist', $examlist);
		//收藏信息
		$favoritemodel = $this->model('Favorite');
		$fparam = array('crid'=>$roominfo['crid'],'cwid'=>$cwid,'uid'=>$user['uid']);
		$myfavorites = $favoritemodel->getcoursefavoritelist($fparam);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		$free = 2;
		$this->assign('free',$free);
		$this->assign('myfavorite',$myfavorite);
		$this->assign('user',$user);
		$this->assign('from',$from);
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);
		$this->assign('roominfo',$roominfo);
		//var_dump( $pagestr);
        $this->display('common/courseebhp');
		}
	//ajax的评论分页
	function getajaxpage(){
		$queryarr['pagesize'] = 10;
        $cwid = $this->input->post('cwid');
		$page = $this->input->post('page');
		if(empty($cwid) || !is_numeric($cwid) || $cwid <= 0) {	//验证cwid是否合法
			exit();
		}
		if(empty($page) || !is_numeric($page) || $page <= 0) {	//验证page是否合法
			exit();
		}
        $queryarr['cwid'] = $cwid;
		$queryarr['page'] = $page;
		$reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = $this->_show_page($count,$queryarr['page'],$queryarr['pagesize']);
		
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		//数据格式化 时间和头像缩略图
		foreach($reviews as &$review){
			$review['dateline'] = date('Y-m-d H:i:s', $review['dateline']);
			if ($review['sex'] == 1){
				if($review['groupid']==5){
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
				}else{
					$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
				}
			}else{
				if($review['groupid']==5){
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
				}else{
					$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
				}
			}
			$face = empty($review['face']) ? $defaulturl : $review['face'];
			$face = getthumb($face, '50_50');			
			$review['face'] =$face; 
		}

		//json输出
		echo json_encode(array("reviews"=>$reviews,'pagestr'=>$pagestr));
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
		//	$gopage = '';
		} else {
			$back = '';
			$next = '';
			$center = '';
//			$gopage = '<input id="gopage" maxpage="' . $pagecount . '" onblur="if($(this).val()>' . $pagecount . '){$(this).val(' .
//					$pagecount . ')}" type="text" size="3" value="" onfocus="this.select();"  onkeyup="this.value=this.value.replace(/\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\D/g,\'\')"><a id="page_go" >跳转</a>';
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
}
?>