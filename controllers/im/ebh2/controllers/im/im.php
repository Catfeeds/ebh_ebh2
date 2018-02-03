<?php
class ImController extends CControl{
    private $user = null;
    public function __construct(){
        parent::__construct();
        $this->user = Ebh::app()->user->getloginuser();
        if(empty($this->user)){
            header('location:/login.html?returnurl='.$_SERVER['REQUEST_URI']);
            exit;
        }
        $this->assign('user',$this->user);
    }

    public function index(){

        $input = EBH::app()->getInput();
        $auth = $input->cookie('auth');

        $this->assign('auth',$auth);
        $this->display('im/index');
    }

    public function room(){
        $this->display('im/room');
    }
}