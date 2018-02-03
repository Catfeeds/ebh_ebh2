<?php

/**
 * 资料下载
 */
class AttachmentController extends CControl {
	private $check = 1;
    public function __construct() {
        parent::__construct();
        $check = true;
		$this->check = $check;
		$this->assign('check',$check);
    }
	
	public function index(){
		$requireFolderid = $this->input->get('folderid');
		if(!is_numeric($requireFolderid) || $requireFolderid < 0){
			echo '课程不存在,请刷新页面重试';
            exit();
		}
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
		$q = $this->input->get('q');
		$queryarr = parsequery();
		$queryarr['folderid'] = $folderid;
		$attmodel = $this->model('attachment');
		$attlist = $attmodel->getAttachByFolderid($queryarr);
		EBH::app()->helper('fileico');
		foreach ($attlist as $k=>$att) {
            $attlist[$k]['csize'] = $this->getsize($att['size']);
            $attlist[$k]['ico'] = format_ico($att['suffix']);
		}
		$this->assign('attlist',$attlist);
		
		$serverutil = Ebh::app()->lib('ServerUtil');
		$source = $serverutil->getCourseSource();
		$this->assign('source',$source);
		 $this->assign('notop', 1);
        $this->assign('q', $q);
		
		
		
		$this->display('jingpin/attachment');
	}
	
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