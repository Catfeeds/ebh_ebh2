<?php

/**
 * 测试生成作业的一些信息，包括当前登录用户的key等
 */
class TesteController extends CControl {
	public function index() {
		$auth = "ddb2iS7ObaKw25dM6vzsp0LqxE2eYd4Mh8fS4igEymwNMVrRLy1v+daAdjoPtkCI76kaTTLLAhzLNvZFq1Ml1K/6FA";
		$aaa = authcode($auth,"DECODE");
		echo "auth:$auth<br />";
		echo "aaa:$aaa";
		echo "<br />";
	}
}