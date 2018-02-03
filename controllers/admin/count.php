<?php 
	/**
	 *后台会员统计控制器
	 *@author zkq
	 */
	class CountController extends CControl{
		/**
		 *后台会员管理->会员统计视图列表
		 */
		public function index(){
			//获取要查询的年份
			$year = intval($this->input->post('year'));
			//如果年份为空则采用当前年
			$year = empty($year)?date('Y'):$year;
			//调用该控制器的getYearSelet()方法,得到年份的<select>控件,供页面年份下拉框用
			$this->assign('yearSelect',$this->getYearSelect($year));
			//调用Member模型获取对应的各个月的开通的会员的统计数组
			$counts = $this->model('member')->getMemberCountGroupByYear($year);
			//分配统计时间
			$this->assign('countsTime',date('Y-m-d H:i:s',time()));
			//分配一年新开通会员总数
			$this->assign('total',array_sum($counts));
			//分配每月开通的会员数组到页面,供页面循环输出使用
			$this->assign('counts',$counts);
			//显示视图
			$this->display('admin/count');
		}
		/**
		 *获取年份的<select>控件
		 *@param int $year
		 *@return String 
		 *注:返回2010到现在年的年份<select>控件
		 */
		public function getYearSelect($year=0){
			$s='<select name="year" id="year">';
			$nowYear = date('Y');
			for($i=$nowYear;$i>2010;$i--){
				if($year==$i){
					$s.='<option value="'.$i.'" selected=selected >'.$i.'</option>';
				}else{
					$s.='<option value="'.$i.'"  >'.$i.'</option>';
				}
				
			}
			$s.='</select>';
			return $s;
		}
	}
?>