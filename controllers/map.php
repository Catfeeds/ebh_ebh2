<?php 
	class MapController extends CControl{
		
		public function index(){
			$roominfo = Ebh::app()->room->getcurroom();
			$this->assign('room', $roominfo);
			$this->display('common/map');
		}

		public function setmap(){
			$roominfo = Ebh::app()->room->getcurroom();
			$this->assign('myroom', $roominfo);
			$this->display('common/setmap');
		}

	/**
     * 修改教室信息
     */
    public function upinfo() {
    	$user = EBH::app()->user->getloginuser();
    	if (empty($user) || $user['groupid'] != 5) {
			$room = $this->getcurroom();
			$troomurl = gettroomurl($room['crid']);
            $url = geturl('login') . '?returnurl=' . $troomurl;
            header("Location: $url");
            exit();
        }
        $room = EBH::app()->room->getcurroom();
        if (empty($room)) {
            $url = geturl('');
            header("Location: $url");
            exit();
        }
		if($room['uid'] == $user['uid']) {	//当前用户为所有者，则表示有管理权限
			$this->_checkadmin = 1;
		} else {
			echo '不是网校管理者';exit;
		}
		/*if(!empty($room['upid'])) {	//如果当前用户为平台的父级平台的所有者，则具有查看权限。
			$roommodel = $this->model('Classroom');
			$haspower = $roommodel->checkcontrolteacher($user['uid'],$room['crid']);
			if($haspower) {
				$this->_checkadmin = 2;
			} else {
				echo '无权限';exit;
			}
		}*/
        if($this->input->post() !== NULL) {
            $param = array();
            $lng = $this->input->post('lng');   //经度
            if($lng !== NULL) {
                $param['lng'] = $lng;
            }
            $lat = $this->input->post('lat');   //纬度
            if($lat !== NULL) {
                $param['lat'] = $lat;
            }
            $message = $this->input->post('message');   //详细介绍
            if(!empty($param)) {
                $roominfo = Ebh::app()->room->getcurroom();
                $roommodel = $this->model('Classroom');
                $param['crid'] = $roominfo['crid'];
                $result = $roommodel->editclassroom($param);
                if($result !== FALSE) {
                    echo 'success';
                } else {
                    echo 'fail';
                }
            }
            else {
                echo 'fail';
            }
        } else {
            echo 'fail';
        }
    }
	}
?>