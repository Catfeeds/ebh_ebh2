<?php
/**
 * 网校学生学习课件详情相关控制器 CourseController
 */
class CourseController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkstudent();
    }
	/**
	*所有课程中搜索课件
	*/
	public function index() {
		$q = $this->input->get('q');
		if(empty($q)) {	//搜索课件
			return;
		}
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
        $this->assign('uid', $user['uid']);
        $folder = array('folderid'=>0,'foldername'=>'搜索课件');
        $this->assign('folder', $folder);
		
        $coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$pagesize = 20;
		$queryarr['pagesize'] = $pagesize;
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        $count = $coursemodel->getfolderseccoursecount($queryarr);
        $pagestr = show_page($count,$pagesize);
        $sectionlist = array();
        foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
		//收藏信息
		
		$this->assign('myfavorite','');
		$this->assign('q',$q);
        $this->assign('sectionlist', $sectionlist);
        $this->assign('pagestr', $pagestr);
		$this->display('myroom/subject_view');
	}
	/**
	*课件详情（课件列表页）
	*/
	public function view() {
		$cwid = $this->uri->itemid;
		if(!is_numeric($cwid) || $cwid <= 0)
			exit();
		$roominfo = Ebh::app()->room->getcurroom();
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		if(empty($course))
			exit();
		$user = Ebh::app()->user->getloginuser();
		$serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
		$source = $serverutil->getCourseSource();
		if(!empty($source))
			$course['cwsource'] = $source;
		//获取课件下的作业记录
		$exammodel = $this->model('Exam');
		$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'limit'=>'0,100');
		$exams = $exammodel->getexamlistbycwid($examparam);
		$this->assign('exams',$exams);
		//获取课件下的附件
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
		//$pagestr = $this->_show_page($count,1,2);
		$pagestr = $this->_show_page($count,$queryarr['page'],$queryarr['pagesize']);
		
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		
		//收藏信息
		$favoritemodel = $this->model('Favorite');
		$fparam = array('crid'=>$roominfo['crid'],'cwid'=>$cwid,'uid'=>$user['uid']);
		$myfavorites = $favoritemodel->getcoursefavoritelist($fparam);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		//添加课件查看数
		$coursemodel->addviewnum($cwid);
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($course['folderid']);
		if($folder['viewnum']==0){
			$viewnum = rand(100,300);
			$foldermodel->updateviewnum($course['folderid'],$viewnum);
		}else{
			$foldermodel->addviewnum($course['folderid']);
		}
		$check = 1;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		}
        $this->assign('course', $course);
		$this->assign('check',$check);
		$this->assign('myfavorite',$myfavorite);
		$this->assign('user',$user);
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);
		$this->assign('roominfo',$roominfo);
        $this->display('myroom/course_view');
	}

	//ajax的评论分页
	function getajaxpage(){
		$queryarr['pagesize'] = 10;
        $queryarr['cwid'] = $this->input->post('cwid');
		$queryarr['page'] = $this->input->post('page');
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