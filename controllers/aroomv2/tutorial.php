<?php
/**
 * 新手指引控制器
 */
class TutorialController extends CControl {

	/**
	 * 引导页
	 */
	public function index() {
		$this->display('aroomv2/tutorial');
	}

	/**
	 * 教师管理指引
	 */
	public function step1() {
		$this->display('aroomv2/tutorial_step1');
	}

	/**
	 * 班级管理指引
	 */
	public function step2() {
		$this->display('aroomv2/tutorial_step2');
	}

	/**
	 * 学生管理指引
	 */
	public function step3() {
		$this->display('aroomv2/tutorial_step3');
	}

	/**
	 * 课程管理指引
	 */
	public function step4() {
		$this->display('aroomv2/tutorial_step4');
	}

	/**
	 * 开始上课指引
	 */
	public function step5() {
		$this->display('aroomv2/tutorial_step5');
	}
}