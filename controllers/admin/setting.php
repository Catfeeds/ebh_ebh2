<?php
class SettingController extends AdminControl{
	public function index(){
		$this->base();
		$this->credit();
		$this->display('admin/setting');
	}
	private function base(){
	}
	private function credit(){
		$creditlist = $this->model('credit')->getCreditRuleList();
		$this->assign('creditlist',$creditlist);
	}
	
	public function saveCreditRule(){
		$creditmodel = $this->model('credit');
		$creditlist = $creditmodel->getCreditRuleList();
		$postcreditrule = $this->input->post('creditrule');
		$res0 = $res1 = $res2 = 0;
		foreach ($creditlist as $rule){
			if(empty($postcreditrule[$rule['ruleid']])){
				$res0 = $creditmodel->delete($rule['ruleid']);
			}
		}
		foreach($postcreditrule as $ruleid=>$rule){
			
			$param = $rule;
			$param['ruleid'] = $ruleid;
			$res1 = $creditmodel->update($param);
		}
		$newcreditrule = $this->input->post('newcreditrule');
		if(!empty($newcreditrule)){
			foreach($newcreditrule as $rule) {
				$setarr = $rule;
				$res2 = $creditmodel->insert($setarr);
			}
		}
		if($res0 !== false && $res1 !== false && $res2 !== false)
			$this->widget('note_widget',array('note'=>'操作成功','returnurl'=>'/admin/setting.html'));
	}
}
?>