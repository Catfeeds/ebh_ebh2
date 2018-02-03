<?php
class ChaptergatherController extends CControl {

	private $crid = 0;//模板所在的学校编号
	private $newcount = 100;//排序数
	private $db = null;//数据库
	public function __construct() {
		parent::__construct();
		Ebh::app()->room->checkRoomControl();

		$this->db = Ebh::app()->getDb();
		$chaptertemplate = Ebh::app()->getConfig()->load('chaptertemplate');
		$crid = $chaptertemplate['crid'];//模板的学校编号
		if (empty($crid)) {
			echo '未设置模板学校编号';
			exit;
		}
		$this->crid = $crid;
		$roominfo = Ebh::app()->room->getcurroom();
		if ($crid != $roominfo['crid']){
			echo '没有权限';
			exit;
		}
	}

	public function index() {
		echo 'gather';
	}

/*	public function getversion() {
		//抓取页面
		$contents = file_get_contents('http://sx.zxxk.com/s-channel-12.html');
		$contents = mb_convert_encoding($contents, 'UTF-8', 'gb2312');
		$contents = str_replace("\r\n", '', $contents); //清除换行符
		$contents = str_replace("\n", '', $contents); //清除换行符
		$contents = str_replace("\t", '', $contents); //清除制表符

		$pattern = '/SubItemchannel_12.*SubItemclass_5585/';
		preg_match($pattern, $contents, $matches);
		$contents = $matches[0];

		preg_match_all('/<a href=\"\/s-class-(\d+)\.html\" class=\" nodewidthlevel_2\" title=\"(.*?)" >/', $contents, $out, PREG_SET_ORDER);

		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

		foreach ($out as $value) {
			echo $value[1] . ' ' . $value[2] . '<br>';
			$chapterid = $this->db->insert('ebh_schchapters', array('chaptername'=>$value[2], 'level'=>1));
			$this->db->update('ebh_schchapters',array('chapterpath'=>'/'.$chapterid),'chapterid='.$chapterid);
		}

	}*/

	/**
	 * 获取所有知识点信息
	 */
	public function getchapter() {
		$crid = $this->crid;

		$versionname = $this->input->post('versionname');
		$versionname = trim($versionname);
		$pname = $this->input->post('pname');
		$classid = $this->input->post('classid');
		$type = $this->input->post('type');
		$versionname = empty($versionname) ? '' : $versionname;

		echo <<<EOD
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>知识点采集</title>
</head>
<body>
	<div>
		<form name="form1" id="form1" action='' method="post">
			<table>
				<tr>
					<td colspan="4">说明：<br />
					版本名称,如：人教版<br />
					一级分类名称,如：七年级上语文。<br />
					原classid,链接中的classid,如：http://yw.zxxk.com/s-class-614.html，则填写614。<br />
					学科类型,两位英文字母(yw语文 sx数学 yy英语 wl物理 hx化学 sw生物 zz政治 ls历史 dl地理 kx科学)。<br /><br /><br />
					</td>
				</tr>
				<tr>
					<td colspan="4">版本名称：<input type="text" name="versionname" value="{$versionname}" /></td>
				</tr>
				<tr>
					<td>序号：</td>
					<td>一级分类名称：</td>
					<td>原classid：</td>
					<td>学科类型：</td>
				<tr>
					<td>1</td>
					<td><input type="text" name="pname[]" value="" size=40 /></td>
					<td><input type="text" name="classid[]" value="" /></td>
					<td><input type="text" name="type[]" value="" /></td>
				</tr>
				<tr>
					<td>2</td>
					<td><input type="text" name="pname[]" value="" size=40 /></td>
					<td><input type="text" name="classid[]" value="" /></td>
					<td><input type="text" name="type[]" value="" /></td>
				</tr>
				<tr>
					<td>3</td>
					<td><input type="text" name="pname[]" value="" size=40 /></td>
					<td><input type="text" name="classid[]" value="" /></td>
					<td><input type="text" name="type[]" value="" /></td>
				</tr>
				<tr>
					<td>4</td>
					<td><input type="text" name="pname[]" value="" size=40 /></td>
					<td><input type="text" name="classid[]" value="" /></td>
					<td><input type="text" name="type[]" value="" /></td>
				</tr>
				<tr>
					<td>5</td>
					<td><input type="text" name="pname[]" value="" size=40 /></td>
					<td><input type="text" name="classid[]" value="" /></td>
					<td><input type="text" name="type[]" value="" /></td>
				</tr>
				<tr>
					<td>6</td>
					<td><input type="text" name="pname[]" value="" size=40 /></td>
					<td><input type="text" name="classid[]" value="" /></td>
					<td><input type="text" name="type[]" value="" /></td>
				</tr>
				<tr>
					<td>7</td>
					<td><input type="text" name="pname[]" value="" size=40 /></td>
					<td><input type="text" name="classid[]" value="" /></td>
					<td><input type="text" name="type[]" value="" /></td>
				</tr>
				<tr>
					<td>8</td>
					<td><input type="text" name="pname[]" value="" size=40 /></td>
					<td><input type="text" name="classid[]" value="" /></td>
					<td><input type="text" name="type[]" value="" /></td>
				</tr>
				<tr>
					<td>9</td>
					<td><input type="text" name="pname[]" value="" size=40 /></td>
					<td><input type="text" name="classid[]" value="" /></td>
					<td><input type="text" name="type[]" value="" /></td>
				</tr>
				<tr>
					<td>10</td>
					<td><input type="text" name="pname[]" value="" size=40 /></td>
					<td><input type="text" name="classid[]" value="" /></td>
					<td><input type="text" name="type[]" value="" /></td>
				</tr>
				<tr>
					<td><input type="submit" value="采集" /></td>
				</tr>
			</table>
		</form>
	</div>
EOD;

		if (empty($versionname)) {
			echo '请填写版本名称！';
			exit;
		}
		if (empty($pname)) {
			echo '请填写需要采集的知识点！';
			exit;
		}
		$pidarr = array();
		foreach($pname as $key => $value) {
			if (!empty($pname[$key]) ){

				if ((empty($classid[$key]) || empty($type[$key])) || !in_array($type[$key], array('yw','sx','yy','wl','hx','sw','zz','ls','dl','kx'))){
					echo '请正确填写原classid和学科类型。';
					exit;
				}
				else {
					$pidarr[] = array('classid'=>intval($classid[$key]), 'pname'=>$pname[$key], 'type'=>$type[$key]);
				}
			}
		}


		$url = '';

		if (!empty($versionname)) {
			$version = $this->db->query("SELECT chapterid FROM ebh_schchapters WHERE crid={$crid} AND level=1 AND chaptername='{$versionname}'")->row_array();
			if (empty($version)){
				$maxdisplayorder = $this->model('mychapter')->getmaxdisplayorder(array('crid' => $crid, 'level' => 1));
				$maxdisplayorder = empty($maxdisplayorder) ? 1 : ($maxdisplayorder+1);//排序加1

				$versionid = $this->db->insert('ebh_schchapters', array('pid'=>0,'chaptername'=>$versionname, 'level'=>1, 'crid'=>$crid, 'displayorder'=>$maxdisplayorder,));
				$this->db->update('ebh_schchapters',array('chapterpath'=>'/'.$versionid),'chapterid='.$versionid);
			}
			else {
				$versionid = $version['chapterid'];
				$newcount = $this->db->query('SELECT max(displayorder) maxorder FROM ebh_schchapters WHERE crid='.$crid.' AND chapterpath like \'/'.$versionid.'/%\'')->row_array();
				if (!empty($newcount))
					$this->newcount = $newcount['maxorder'];
			}
		}

		if (empty($versionid) || empty($pidarr)){
			exit;
		}

		echo '<fieldset style="height:200px;overflow-y:auto"><legend>采集记录：</legend>采集开始---------------------------------------';
		foreach ($pidarr as $value) {
			$classid = $value['classid'];
			$plevel = 2;
			$this->newcount++;
			$pid = $this->db->insert('ebh_schchapters', array('chaptername'=>$value['pname'], 'pid'=>$versionid, 'level'=>$plevel, 'crid'=>$crid, 'displayorder'=>$this->newcount));
			$ppath = '/'.$versionid.'/' . $pid;
			$this->db->update('ebh_schchapters',array('chapterpath'=>$ppath),'chapterid='.$pid);
			echo '<br>'.$value['classid'] . ':' . $value['pname'] . ':2<br>';

			if ($value['type'] == 'yw') {
				$url = 'http://yw.zxxk.com/Ajax/GetTreeNode.ashx?id=class_' . $value['classid'] . '&channelid=0';
				$this->_getYwChildChapter($classid, $pid, $plevel, $ppath, $url);

			} else {
				$url = 'http://' . $value['type'] . '.zxxk.com/GetTreeNode.aspx/GetTreeNodeList';
				$this->_getChildChapter($classid, $pid, $plevel, $ppath, $url);
			}
		}
		echo '采集结束---------------------------------------</filedset>';
	}


	/**
	 * 递归获取子知识点
	 * @param  integer $classid [description]
	 * @param  integer $pid     [description]
	 * @param  integer $plevel  [description]
	 * @param  string  $ppath   [description]
	 * @param  [type]  $url     [description]
	 * @return [type]           [description]
	 */
	public function _getChildChapter($classid = 0, $pid = 0, $plevel = 1, $ppath = '', $url) {
		$crid = $this->crid;
		$chapterlist = $this->_getChapterList($classid, $plevel, $url);
		if (!empty($chapterlist)) {
			foreach ($chapterlist as $value) {
				echo $value['NodeDataId'] . ':' . $value['NodeName'] . ':' . ($plevel+1) . '<br>';

				//插入数据库
				$this->newcount++;
				$chapterid = $this->db->insert('ebh_schchapters', array('chaptername'=>$value['NodeName'], 'pid'=>$pid, 'level'=>$plevel+1, 'crid'=>$crid, 'displayorder'=>$this->newcount));
				$this->db->update('ebh_schchapters',array('chapterpath'=>$ppath.'/'.$chapterid),'chapterid='.$chapterid);

				//如果有子知识点，递归调用
				if ($value['IsExistsChild']) {
					$this->_getChildChapter($value['NodeDataId'], $chapterid, $plevel+1, $ppath.'/'.$chapterid, $url);
				}
			}
		}


	}

	/**
	 * [_getChapterList description]
	 * @param  [type] $classid [description]
	 * @param  [type] $level   [description]
	 * @return [type]          [description]
	 */
	private function _getChapterList($classid, $level, $url) {
		usleep(100000);//延时0.1秒
		if ($level<3) {
			$data = array('ChannelID'=>'0','ClassID'=>strval($classid),'CharterID'=>'0','SpecialID'=>'0','Level'=>strval($level),'UserKeyWords'=>'','ChannelClassID'=>'0','PageType'=>0);
		}
		else {
			$data = array('ChannelID'=>'0','ClassID'=>'0','CharterID'=>strval($classid),'SpecialID'=>'0','Level'=>strval($level),'UserKeyWords'=>'','ChannelClassID'=>'0','PageType'=>0);
		}
		$res = $this->_curl_post($url, $data);

		if ($res !== FALSE) {
			$res = mb_convert_encoding($res, 'UTF-8', 'gb2312');
			$res = str_replace('{"d":["OK","', '', $res);
			$res = str_replace('","class"]}', '', $res);
			$res = str_replace('","chapter"]}', '', $res);
			$res = str_replace('","node"]}', '', $res);

			$res = stripslashes($res);
			$res = json_decode($res, true);
			return $res;
		}
		else {
			return FALSE;
		}
	}

	private function _curl_post($url, $data=array()) {
		$data_string = json_encode($data);
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
             'Content-Type: application/json; charset=utf-8',
             'Content-Length: ' . strlen($data_string))
         );
	    //curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    //curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
		//curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
		//curl_setopt($ch, CURLOPT_TIMEOUT, 30);

	    $output = curl_exec($ch);

	    if($output === false){
		   log_message("cUrl Error:" . curl_error($ch) );
		}
	    curl_close($ch);

	    return $output;

	}

	private function _curl_get($url) {
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	    $output = curl_exec($ch);

	    if($output === false){
		   log_message("cUrl Error:" . curl_error($ch) );
		}
	    curl_close($ch);

	    return $output;
	}

	public function _getYwChildChapter($classid = 0, $pid = 0, $plevel = 1, $ppath = '', $url) {
		$crid = $this->crid;
		$chapterlist = $this->_getYwChapterList($url);
		if (!empty($chapterlist)) {
			foreach ($chapterlist as $value) {
				echo $value['DataID'] . ':' . $value['NodeName'] . ':' . ($plevel+1) . '<br>';

				//插入数据库
				$this->newcount++;
				$chapterid = $this->db->insert('ebh_schchapters', array('chaptername'=>$value['NodeName'], 'pid'=>$pid, 'level'=>$plevel+1, 'crid'=>$crid, 'displayorder'=>$this->newcount));
				$this->db->update('ebh_schchapters',array('chapterpath'=>$ppath.'/'.$chapterid),'chapterid='.$chapterid);

				//如果有子知识点，递归调用
				if ($value['IsOpen'] === false) {

					$url = 'http://yw.zxxk.com/Ajax/GetTreeNode.ashx?id=chapter_' . $value['DataID'] . '&channelid=0';
					$this->_getYwChildChapter($value['DataID'], $chapterid, $plevel+1, $ppath.'/'.$chapterid, $url);
				}
			}
		}


	}

	private function _getYwChapterList($url) {

		$res = $this->_curl_get($url);

		if ($res !== FALSE) {
			$res = json_decode($res, true);
			$res = $res['Result'];
			return $res;
		}
		else {
			return FALSE;
		}
	}

}