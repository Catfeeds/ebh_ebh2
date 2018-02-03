<?php
include S_ROOT.'config/upconfig.php';
$uptypes=array(//'image/jpg', //上传文件类型列表
//'image/jpeg',
//'image/png',
//'image/pjpeg',
//'image/gif',
//'image/bmp',
'text/plain',
//'application/x-shockwave-flash',
//'image/x-png',
'application/msword',
'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
'application/vnd.ms-excel',
'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
'application/vnd.ms-powerpoint',
'application/vnd.openxmlformats-officedocument.presentationml.presentation',
'application/x-zip-compressed', //jar
'application/x-rar-compressed',
'application/x-rar', //rar
'application/octet-stream',//zip,rar,jar 
'application/kswps',
'application/kset',
//'avi','text/plain','flv','video/x-flv'
);
$max_file_size=5002400*100;   //上传文件大小限制, 单位BYTE 最大5m左右 
$destination_folder=$_UP['tplanatt']['savepath']; //上传文件路径
$sortpath = $_UP['tplanatt']['showpath'];

?>
<html>
<head>
<title>上传附件</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<base target="_self" />
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<style type="text/css">
body,td{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:#FCFDFD;color:#666666;margin-left:20px;}
strong{font-size:12px;}
aink{color:#0066CC;}
a:hover{color:#FF6600;}
aisited{color:#003366;}
a:active{color:#9DCC00;}
</style>
<script language="javascript" type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script>
function returnvalue(returns)
{
	
	window.parent.attachupload(returns);
	//window.parent.location = window.parent.location.href;

}
</script>
</head>
<body>
<center><form action="" enctype="multipart/form-data" method="post" name="upform"><br />
<b>上传文件</b><br /><br />
<input name="upfile" type="file" style="width:200;border:1 solid #9a9999; font-size:9pt; background-color:#ffffff" size="17">
<input type="submit" value="确定" style="width:40;border:1 solid #9a9999; font-size:9pt; background-color:#ffffff" size="17"><br><br>
允许上传的文件类型为:txt|zip|doc|ppt|excel|rar|...<br>

</form>

<?php
///////////////////////////
//$dir
function create_folders($dir){ 
       return is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir, 0777)); 
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//是否存在文件
	if (!is_uploaded_file($_FILES["upfile"]['tmp_name']))
	{
		echo "<font color='red'>文件不存在！</font>";
		exit;
	}
	
	$file = $_FILES["upfile"];
	//检查文件大小
	if($max_file_size < $file["size"])
	{
		echo "<font color='red'>文件太大！图片需在5M以内。</font>";
		exit;
	}
	//检查文件类型
	if(!in_array($file["type"], $uptypes))
	{
		//echo $file["type"];
		echo "<font color='red'>格式不对！</font>";
		exit;
	}
	
	$filename=$file["tmp_name"];
	$pinfo=pathinfo($file["name"]);//这个关键
	$originalname=$file["name"];
	$type=$pinfo['extension']; //这个关键后缀名
	
	$time_folder = Date('Y/m/d/',time());
	// mkdir($destination_folder.$time_folder,0777,true);
	create_folders($destination_folder.$time_folder);
	$destination = $destination_folder.$time_folder.time().".".$type;    //完整文件url
	
	$attrurl=$time_folder.time().'.' . $type;	//不包括配置的目录
	if (file_exists($destination) && $overwrite != true)
	{
		echo "<font color='red'>同名文件已经存在了！</a>";
		exit;
	}
	
	if(!move_uploaded_file ($filename, $destination))
	{
		
		echo "<font color='red'>移动文件出错！</a>";
		exit;
	}
	
	$pinfo=pathinfo($destination);
	$fname=$pinfo['basename'];
	//echo " <font color=red id='obj' class=\"".$attrurl."\" >已经成功上传</font><br><font id='font'>文件名:</font> <font id='objpath' class=\"".$attrurl."\" color=blue>".$destination."</font>";
	
	$returns = $attrurl.'|'.$originalname;
	//echo '<script>alert("'.$returns.'"); </script>';
	echo '<script>returnvalue("'.$returns.'"); </script>';
}
?>
</center>
</body>
</html>