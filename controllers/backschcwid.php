<?
class BackschcwidController extends CControl {

    public function index() {
    	$ip = $this->input->getip();
    	$allowIps = Ebh::app()->getConfig()->load('allowservers');
    	if (!empty($allowIps) && !in_array($ip, $allowIps)) {	//不在列表内的IP 不允许上传
			exit(0);
		}
		$schcourseware = $this->model('schcourseware');
		$html = '';
		if(!empty($_POST) && !empty($_POST['html'])) {
			$html = $this->lib_replace_end_tag($_POST['html']);
		}
		$param = array(
			'uid'		=>0,
			'cwsize'	=>0,
			'cwname'	=>'default.jpg',
			'cwsource'	=>'http://www.ebanhui.com/',
			'cwurl'		=>'default',
			'type'		=>1,
			'html'		=>$html,
			'dateline'	=>SYSTIME
		);
		$cwid = $schcourseware->insert($param);
		echo $cwid;
    }


// 替换HTML尾标签,为过滤服务
	public function lib_replace_end_tag($str) {
		if (empty($str)) 
			return false;
		$str = stripslashes($str);
		$str = str_ireplace("<SCRIPT>", "", $str);
		$str = str_ireplace("</SCRIPT>", "", $str);
		$str = str_ireplace("<script>", "", $str);
		$str = str_ireplace("</script>", "", $str);
		$str = str_ireplace("select","<b>select</b>",$str);
		$str = str_ireplace("join","<b>join</b>",$str);
		$str = str_ireplace("union","<b>union</b>",$str);
		$str = str_ireplace("where","<b>where</b>",$str);
		$str = str_ireplace("insert","<b>insert</b>",$str);
		$str = str_ireplace("delete","<b>delete</b>",$str);
		$str = str_ireplace("update","<b>update</b>",$str);
		$str = str_ireplace("like","<b>like</b>",$str);
		$str = str_ireplace("drop","<b>drop</b>",$str);
		$str = str_ireplace("create","<b>create</b>",$str);
		$str = str_ireplace("modify","<b>modify</b>",$str);
		$str = str_ireplace("rename","<b>rename</b>",$str);
		$str = str_ireplace("alter","<b>alter</b>",$str);
		$str = str_ireplace("cas","<b>cas</b>",$str);
		return $str;
	}


 }
