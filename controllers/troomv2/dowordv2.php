<?php
/**
 * examv2整张试卷导入word上传
 */
class Dowordv2Controller extends CControl {

	public function index() {
		//权限
		$user = Ebh::app()->user->getloginuser();
		if(empty($user))
			exit();
		//路径
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$wordsave = $_UP['wordparser']['savepath'];
		$parserurl = $_UP['wordparser']['postpath'];
		if (!file_exists($wordsave))
            mkdir($wordsave,0777,1);

		if(empty($_FILES)) {
			echo $this->gethtml();
		} else{
			$errormsg = '';
			if(empty($_FILES) || empty($_FILES['wordfile']) || empty($_FILES['wordfile']['tmp_name'])) {
				$errormsg = '错误：请选择要上传的文件';
			} else if(is_uploaded_file($_FILES['wordfile']['tmp_name']) && $this->checkupload($_FILES['wordfile'])) {
				$tmpname = time().'_'.mt_rand().'.docx';
				$filesavepath = $wordsave.$tmpname;
				if(move_uploaded_file($_FILES['wordfile']["tmp_name"], $filesavepath)) {
					$parseresult = $this->postfile($filesavepath,$parserurl,$tmpname);

					$starcheckstr = '{"title":"';	//返回字符必须以这个字符串开头
					if($parseresult == 'error') {
						$errormsg = '错误：服务器繁忙，请稍后再试。';
					} else if(strlen($parseresult) < 10 || strpos($parseresult,$starcheckstr) !== 0) {
						$errormsg = '错误：文档内容有误或格式不正确，请重新上传';
					} else {
						$script = '<!DOCTYPE HTML><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
						$script .= '<script type="text/javascript">var parentframe = window.parent;parentframe.jsondata='.$parseresult.';parentframe.savefromword();</script>';
						$script .= '</head><body></body></html>';
						echo $script;
						$room = Ebh::app()->room->getcurroom();
						$message = "word导入文件全路径".$filesavepath." 导入教师为：".$user['username']." \n网校编号为：".$room['crid']." 网校名为：".$room['crname'];
						log_message($message);
					}
				}
			} else {
				$errormsg = '错误：只允许上传doc和docx格式文件，且文件小于5M';
			}
			if(!empty($errormsg)){
				echo $this->gethtml($errormsg);
			}
		}
	}
	/**
	*检测上传内容是否合法
	*/
	function checkupload($up) {
		$MAX_FILENAME_LENGTH = 260;
		$max_file_size_in_bytes = 5242880;				// 5M
		$allow_extensions = array('doc','docx'); //only allow jpg file extension
		$valid_chars_regex = '.A-Z0-9_-';				// file name allow characters
		
		if (empty($up)) {
			return false;
		} else if (isset($up["error"]) && $up["error"] != 0) {
			return false;
		} else if (!isset($up["tmp_name"]) || !@is_uploaded_file($up["tmp_name"])) {
			return false;
		} else if (!isset($up['name'])) {
			return false;
		}
		$file_size = @filesize($up["tmp_name"]);
		if (!$file_size)
			$file_size = 128;
		if (!$file_size || $file_size > $max_file_size_in_bytes) {
			return false;
		}
		if ($file_size <= 0) {
			return false;
		}
		$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($up['name']));
		if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
			return false;
		}
		$path_info = pathinfo($up['name']);
		$file_extension = $path_info["extension"];
		if(!in_array($file_extension,$allow_extensions))
			return false;
		return true;
	}
	/**
	*提交文件到指定URL并返回结果
	*/
	function postfile($filepath,$url,$filename='tempfile') {
		$curl = curl_init($url);
		$fields = curl_file_create($filepath,'application/msword ',$filename);
		$data = array($filename => $fields);
		curl_setopt($curl, CURLOPT_POST, 1 );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		$rtn= curl_getinfo($curl,CURLINFO_HTTP_CODE);
		$result = curl_exec( $curl );
		if ($error = curl_error($curl) ) {
			   return 'error';
		}
		curl_close($curl);
		return $result;
	}
	/**
	*返回页面html代码
	*/
	function gethtml($errormsg=NULL) {
		$html=<<<myhtml
			<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
			<link rel="stylesheet" href="http://static.ebanhui.com/exam/css/base.css"/>
			<title>导入Word</title>
			<style>
			#loadparent {
			    height: 1024px;
			    width: 1920px;
			    z-index: 1001;
			}
			#loadparent {
				background-color:#DDDDDD;
				filter:alpha(opacity=50);
				opacity:0.5;
			}
			#loadparent {
			    height: 100%;
			    left: 0;
			    position: absolute;
			    top: 0;
			    width: 100%;
			}
			.waikui {
				width:600px;
				height:220px;
				background-color:#eee;
			}
			.waikui .bianju {
				margin:20px 15px 0px;
				float:left;
				display:inline;
			}
			.waikui .tijiaobtn {
				background:url(http://static.ebanhui.com/exam/images/tijiaobtn13.jpg) no-repeat;
				width:78px;
				height:26px;
				position: absolute;
				left:460px;
				top:20px;
				display: inline-block;
				cursor: pointer;
				border:none;
			}
			.siwen {
				color:#505050;
				margin:10px 0;
			}
			.zuoyexia {
				font-size:14px;
				color:#505050;
			}
			.zuoyexia a.word {
				color:#3057ab;
				text-decoration:underline;
			}
			.file {
				font-size: 14px;
				height:24px;
				cursor:pointer;
				width:280px;

			}
			.msgtip {
				color:red;
				height:24px;
			}
			</style>
			<script type="text/javascript">
			function submitform() {
				var wordform = document.getElementById("wordform");
				var load = document.getElementById("loadparent");
				load.style.display = "";
				wordform.submit();
			}
			</script>
			</head>
			<body>
			<div class="waikui" style="position: relative;">
			<div class="bianju">
			<form id="wordform" action="/troomv2/dowordv2.html" method="post" enctype="multipart/form-data">
			  <input type="file" name="wordfile" class="file"/>
			  <input class="tijiaobtn" type="button" value="" onclick="submitform()"/>
			</form>
			  <div class="msgtip">$errormsg</div>
			  <div class="siwen">
			  <h2>说明</h2>
			  <p>1.此处导入后，Word中的题型都会以主观题形式呈现。</p>
			  <p>2.请按照我们的参考格式进行导入，这样导入时候的准确率会更高。</p>
			  <p>3.本系统支持所有版本的Word文件，但推荐使用Word2007或者以后的版本，效率会更高。</p>
			  <p>4.由于Word系统较复杂，且格式较多，对于某些特殊格式的文档，里面内容可能会有所丢失或错误，<br />&nbsp; 导入后还需要您核对内容是否准确。</p>
			  </div>
			<p class="zuoyexia"><span style="font-weight:bold;">作业参考格式下载：</span>　<a href="http://exam.ebanhui.com/static/html/dialog/wordlib/2003.doc" class="word" target="_blank">Word2003版本</a>　<a href="http://exam.ebanhui.com/static/html/dialog/wordlib/2007.docx" class="word" target="_blank">Word2007版本</a></p>
			</div>

			<div id="loadparent" style="display:none">
			<div id="loadimg" style="width:100px;height:100px;margin:0 auto;margin-top:10px;"><img style="margin:0 auto;" title="加载中..." src="http://static.ebanhui.com/exam/images/loading.gif"/>
			</div>
			</div>
			</body>
			</html>
myhtml;
	return $html;
	}
}