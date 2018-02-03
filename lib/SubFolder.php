<?php
/*
子目录
*/
class SubFolder{
	/*
	子目录信息. 各级名称,子目录是否还包含子目录
	*/
	public function getSubFolder($t,$folderid,$needsubsub=null){
		$roominfo = Ebh::app()->room->getcurroom();
		$foldermodel = $t->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		$folderlevel = $folder['folderlevel'];
		$cridarr = Ebh::app()->getConfig()->load('subfolder');
		$needsubfolder = false;
		if(in_array($roominfo['crid'],$cridarr)){
			
			$subfolderlist = $foldermodel->getSubFolder($roominfo['crid'],$folderid);
			//子目录的子目录信息
			if($needsubsub){
				foreach($subfolderlist as $k=>$subfolders){
					$subfolder = $foldermodel->getSubFolder($roominfo['crid'],$subfolders['folderid']);
					if(!empty($subfolder))
						$subfolderlist[$k]['hassub']=1;
				}
			}
			$t->assign('subfolderlist',$subfolderlist);
			$tempfolder = $folder;
			$uparr = array();
			$index = 0;
			while($folderlevel>2){
				$tempfolder = $foldermodel->getfolderbyid($tempfolder['upid']);
				$uparr[$index]['foldername']= $tempfolder['foldername'];
				$uparr[$index]['folderid']= $tempfolder['folderid'];
				$index ++ ;
				$folderlevel = $tempfolder['folderlevel'];
			}
			$needsubfolder = true;
			$t->assign('uparr',$uparr);
		}
		$t->assign('folder',$folder);
		$t->assign('needsubfolder',$needsubfolder);
	}
	
	/*
	各级名称,导出学生学习统计,导出老师上课统计
	*/
	public function getSubFolderNames($folderid){
		$roominfo = Ebh::app()->room->getcurroom();
		$foldermodel = Ebh::app()->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		$folderlevel = $folder['folderlevel'];
		$cridarr = Ebh::app()->getConfig()->load('subfolder');

				
		if(in_array($roominfo['crid'],$cridarr)){
			$tempfolder = $folder;
			// $uparr = array();
			// $index = 0;
			$namestr = '';
			while($folderlevel>2){
				$tempfolder = $foldermodel->getfolderbyid($tempfolder['upid']);
				// $uparr[$index]['foldername']= $tempfolder['foldername'];
				// $uparr[$index]['folderid']= $tempfolder['folderid'];
				// $index ++ ;
				$folderlevel = $tempfolder['folderlevel'];
				$namestr = $tempfolder['foldername'].'--'.$namestr;
			}
			return rtrim($namestr,'--');
		}
	}
}
?>