<?php
class YyxzController extends CControl{
	/**
	 * 网校运营须知
	 */
	public function index(){
		$seoInfo['title'] = '精品课堂——为你网罗所有好课';
		$seoInfo['keyword'] = '在线教育，精品课，公共课，公开课，免费网校，课程资源，升学课堂，学前教育，小学课程，初中课程，高中课程，兴趣特长，职业培训，互联网教育，免费课程';
		$seoInfo['description'] = '精品课堂是e板会网络学校平台从各个知名网校中选取的优秀课程，它可以帮助学生在互联网平台上更方便的寻找适合自己的精品课程进行学习。也可以为想开网校的个人、机构、学校提供丰富的教学资源，免除了生产课程的成本和时间精力，真正实现人人当校长的梦想。';
		$this->assign('seoInfo', $seoInfo);
		$this->display('common/yyxz');
	}
}