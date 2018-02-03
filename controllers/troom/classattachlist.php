<?php
/**
 * 学校教师后台附件管理控制器类 of attachlist
 */
class ClassattachlistController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
		$cwid = $this->uri->uri_attr(0);
		if(!is_numeric($cwid) || $cwid <= 0)
			$cwid = 0;
		$coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
        $this->assign('course', $course);

        $attmodel = $this->model('Attachment');
		$queryarr['cwid'] = $cwid;
        $atts = $attmodel->getlistwithcourse($queryarr);
        $attlist = array();
        foreach ($atts as $att) {
            $att['csize'] = $this->getsize($att['size']);
            if(isset($attlist[$att['cwid']])) {
                $attlist[$att['cwid']][] = $att;
            } else {
                $attlist[$att['cwid']] = array();
                $attlist[$att['cwid']][] = $att;
            }
        }
        $count = $attmodel->getlistcountwithcourse($queryarr);
        $pagestr = show_page($count);
		$serverutil = Ebh::app()->lib('ServerUtil');
		$source = $serverutil->getCourseSource();
		$this->assign('source',$source);
        $this->assign('attlist', $attlist);
        $this->assign('pagestr', $pagestr);
        $this->display('troom/classattachlist');
    }
    /**
     * 根据给定的字节大小返回可能性更好的文件大小
     * @param int $bsize
     * @return string
     */
    private function getsize($bsize){
	$size = "0字节";
	if (!empty($bsize))
	{
		$gsize = $bsize / (1024 * 1024 * 1024);
		$msize = $bsize / (1024 * 1024);
		$ksize = $bsize / 1024;
		if ($gsize > 1)
		{
			$size = round($gsize,2) . "G";
		}
		else if($msize > 1)
		{
			$size = round($msize,2) . "M";
		}
		else if($ksize > 1)
		{

			$size = round($ksize,0) . "K";
		}
		else
		{
			$size = $bsize . "字节";
		}
	}
	return $size;
}
}
