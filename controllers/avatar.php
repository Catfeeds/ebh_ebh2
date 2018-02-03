<?php
/**
* 头像修改控制器类
*/
class AvatarController extends CControl {
    public function __construct() {
        parent::__construct();
        $user = Ebh::app()->user->getloginuser();
        if(empty($user)) {
            exit();
        }
    }
    public function index() {
        $user = Ebh::app()->user->getloginuser();
        if (!empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            $up_type = 'avatar';
            $savepath = 'uploads/';
            $showpath = 'uploads/';
            if(!empty($_UP[$up_type]['savepath'])){
                $savepath = $_UP[$up_type]['savepath'];
            }
            if(!empty($_UP[$up_type]['showpath'])){
                $showpath = $_UP[$up_type]['showpath'];
            }
            $filename = SYSTIME.'.jpg';
            $filename_120 = SYSTIME.'_120_120.jpg';
            $folderpath = $this->getFolder($savepath);
            $destsavepath = $savepath.$folderpath.$filename;
            $destshowpath = $showpath.$folderpath.$filename;
            file_put_contents($destsavepath,$GLOBALS['HTTP_RAW_POST_DATA']);
            Ebh::app()->helper('image');
            @copy($destsavepath, $savepath.$folderpath.$filename_120);
            $usermodel = $this->model('user');
            $param = array('face'=>$destshowpath);
            $result = $usermodel->update($param,$user['uid']);
            thumb($destsavepath, '78_78' ,100);
            thumb($destsavepath, '50_50' ,100);
            thumb($destsavepath, '40_40' ,100);
            if($result !== FALSE){
                echo 1;
				$credit = $this->model('credit');
				$credit->addCreditlog(array('ruleid'=>2));
			}
            else
                echo 0;
        }
    }
    /**
     * 按照日期自动创建存储文件夹
     * @return string
     */
    private function getFolder($savepath)
    {
        $pathStr = $savepath;
        //以天存档
        $yearpath = Date('Y', SYSTIME) . "/";
        $monthpath = $yearpath . Date('m', SYSTIME) . "/";
        $dayspath = $monthpath . Date('d', SYSTIME) . "/";
        if (!file_exists($pathStr))
            mkdir($pathStr);
        if (!file_exists($pathStr . $yearpath))
            mkdir($pathStr . $yearpath);
        if (!file_exists($pathStr . $monthpath))
            mkdir($pathStr . $monthpath);
        if (!file_exists($pathStr . $dayspath))
            mkdir($pathStr . $dayspath);
        return ltrim($dayspath, '.');
    }
}
