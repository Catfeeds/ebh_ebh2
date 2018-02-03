<?php
/*
flv课件笔记
*/
class FlashnoteController extends CControl{
	public function __construct(){
		parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
        if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
	}
	public function index(){
		if(empty($GLOBALS['HTTP_RAW_POST_DATA']))
			exit;
		$filename= SYSTIME.'.jpg';
		$binstr =  $GLOBALS['HTTP_RAW_POST_DATA'];
		
		$imagesizehex = unpack('H*',substr($binstr,0,4));
		$imagesize = hexdec($imagesizehex[1]);
		$image = substr($binstr,4,$imagesize);
		$text = substr($binstr,4+$imagesize);
		if(empty($text))
			$text = '';
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		
		// $pos = strrpos($binstr,'[size]',strlen($binstr)-12);
		// $textsize = intval(str_replace('[size]','',substr($binstr,$pos)));
		// $content = substr($binstr,($pos-$textsize),$textsize);
		
		$destination_folder = $_UP['fnote']['savepath'];
		$time_folder = Date('Y/m/d/',SYSTIME);
		$this->create_folders($destination_folder.$time_folder);
		$savepath = $destination_folder.$time_folder.$filename;
		$showpath = $_UP['fnote']['showpath'].$time_folder.$filename;
		
		if(file_exists($savepath)){//重名更换
			$savepath = str_replace('.jpg','x'.random(4).'.jpg',$savepath);
			$showpath = str_replace('.jpg','x'.random(4).'.jpg',$showpath);
		}
		
		$cwid = $this->input->get('cwid');
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$notemodel = $this->model('note');
		
		$param['uid'] = $user['uid'];
		$param['cwid'] = $cwid;
		$mynote = $notemodel->getFlashNoteBycwid($param);
		
		$param['crid'] = $roominfo['crid'];
		$param['ftext'] = $text;
		$param['fimage'] = $showpath;
		$param['cwid'] = $cwid;
		$param['crid'] = $roominfo['crid'];
		
		//保存图片
		$file = fopen($savepath,"w") or exit(0);
		fwrite($file,$image);
		fclose($file);
		if(empty($mynote)){//新增笔记
			$res = $notemodel->addFlashNote($param);
		}else{//修改笔记
			$lastfile = $mynote['fimage'];
			$farr = explode('/',$lastfile);
			$lastfilename = end($farr);
			$oldpath = $_UP['fnote']['savepath'].$time_folder.$lastfilename;
			if(file_exists($oldpath)){//删除原有图片
				unlink($oldpath);
			}else{
				
			}
			$res = $notemodel->editFlashNote($param);
		}
		if($res !== false)
			echo 1;
		else
			echo 0;
	}
	
	/*
	获取笔记内容
	*/
	public function getNoteDetail(){
		$cwid = $this->input->get('cwid');
		$user = Ebh::app()->user->getloginuser();
		if(empty($cwid) || empty($user)){
			echo 0;exit;
		}
		$param['uid'] = $user['uid'];
		$param['cwid'] = $cwid;
		$notemodel = $this->model('note');
		$mynote = $notemodel->getFlashNoteBycwid($param);
		if(!empty($mynote))
			echo json_encode(array('image'=>$mynote['fimage'],'text'=>$mynote['ftext']));
		else
			echo 0;
	}
	
	
	private function create_folders($dir){ 
       return is_dir($dir) or ($this->create_folders(dirname($dir)) and mkdir($dir, 0777)); 
	}
	
}
?>