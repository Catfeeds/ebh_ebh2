<?php
	class ClassroomMenueController extends CControl{
		public function getCrList(){
			$postwhere = (array)json_decode($this->input->post('where'));
			if(is_array($where)&&count($where)>0){
				$where = $postwhere;
			}else{
				$where = array('status'=>1,'limit'=>'0,1000');
			}
			$classroom = $this->model('classroom')->getroomlist($where);
			$selected = $this->input->post('checked');
			$html='';
			foreach ($classroom as $value) {
				if((int)$value['crid']==$selected){
					$html.= '<option value="'.$value['crid'].'"'.' selected=selected >'.$value['crname'].'</option>';
				}else{
					$html.= '<option value="'.$value['crid'].'">'.$value['crname'].'</option>';
				}
			}
			echo $html;
		}
	}
?>