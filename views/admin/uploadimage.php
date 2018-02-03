<?php
/**
 * 上传图片
 */
$uptypes = array('image/jpg', //上传文件类型列表
    'image/jpeg', 'image/png', 'image/pjpeg', 'image/gif',
    'application/x-shockwave-flash', 'image/x-png');
$max_file_size = 5002400; //上传文件大小限制, 单位BYTE 最大5m左右

$destination_folder = getdirurl();

//$sortpath = "/" . ltrim($destination_folder, S_ROOT);
$sortpath = '/'.substr($destination_folder,strlen(S_ROOT));
$path = "../upload/thumb/";
$watermark = 1; //是否附加水印(1为加水印,其他为不加水印);
$watertype = 2; //水印类型(1为文字,2为图片)
$waterposition = 4; //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);
$waterstring = "www.ebanhui.com"; //水印字符串
$waterimg = "images/waterimg1.png"; //水印图片
$waterimg2 = "images/waterimg2.png"; //水印图片
$imgpreview = 2; //是否生成预览图(1为生成,其他为不生成);
$imgpreviewsize = 1 / 2; //缩略图比例
$initheight = 400; // 生成图片的高
$initwidth = 400; // 生成图片的宽
?>
<html>
<head>
<title>上传图片</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SC['charset'];?>">
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
<script language="javascript" type="text/javascript" src="/include/jquery/jquery-1.4.2.min.js"></script>
<script>
 function returnvalue()
 { 
      var url=$("#obj").attr('class');
      var sortpath=$("#objpath").attr('class');
      var image2=$("#image2",parent.document).attr('class');
     // parent.document.getElementById('imageid').src=url;
     if(image2==2) //2是一个页面有2个上传
     {
         $("#showdel2",parent.document).show();
         $("#image2",parent.document).attr("src",url);
         $("#txtpath2",parent.document).val(sortpath);
         $("#image2",parent.document).attr('class',"");
         //$("#txtpath2",parent.document).attr("disabled",true);
     }
     else
     {
         var showdel=window.parent.showdel; //得到父级的js变量
         var imageid=window.parent.imageid;
         var txtpath=window.parent.txtpath;
         $("#"+showdel+"",parent.document).show();
         $("#"+imageid+"",parent.document).attr("src",url);
         $("#"+txtpath+"",parent.document).val(sortpath);
          //$("#txtpath",parent.document).attr("disabled",true);
     }
      window.parent.closedialog();
      $('.ui-dialog',parent.document).hide();
      //window.parent.location.reload();
      //清空提示
      $("#obj").empty();  
      $("#objpath").empty();
      $("#font").empty();
 }
</script>
</head>
<body>
<center><form action="#getsitecpurl()#?action=uploadimage" enctype="multipart/form-data" method="post" name="upform"><br />

<b>上传文件</b><br /><br />
<input name="upfile" type="file" style="width:200;border:1 solid #9a9999; font-size:9pt; background-color:#ffffff" size="17">
<input type="submit" value="确定" style="width:40;border:1 solid #9a9999; font-size:9pt; background-color:#ffffff" size="17"><br><br>
允许上传的文件类型为:jpg|jpeg|png|pjpeg|gif|x-png|swf <br>
<?php
//if ($_SGLOBAL['ebh_grouptype']=='staff')
//{
//   echo "<input type='checkbox' name='ckbox' value='1' checked='checked'>原图加水印(管理员才有权限修改)</input>"; 
//}else
//{
//    echo "<input type='checkbox' name='ckbox' value='1' onclick='return false;'  checked='checked'>原图加水印(管理员才有权限修改)</input>";  
//}
?>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //是否存在文件
    if (!is_uploaded_file($_FILES["upfile"]['tmp_name'])) {
        echo "<font color='red'>文件不存在！</font>";
        exit;
    }

    $file = $_FILES["upfile"];
    //检查文件大小
    if ($max_file_size < $file["size"]) {
        echo "<font color='red'>图片太大！图片需在500kb以内。</font>";
        exit;
    }
    //检查文件类型
    if (!in_array($file["type"], $uptypes)) {
        echo "<font color='red'>不支持该类型图片！</font>";
        exit;
    }
    //
    //    if(!file_exists($destination_folder))
    //    mkdir($destination_folder);
    //    if(!file_exists($path))
    //    mkdir($path);
    //    $destination_folder=$path;
    $filename = $file["tmp_name"];
    $image_size = getimagesize($filename);
    $initwidth = $image_size[0]; //等于本身图片大小
    $initheight = $image_size[1]; //等于本身图片大小
    $pinfo = pathinfo($file["name"]);
    $imagetype = $pinfo['extension'];
    $now = time();
    // $ftype=$pinfo['extension'];
    //$destination = $destination_folder . $now . '_waterimg'.'.' . $imagetype; //加水印的图片
     $p=$_GET['w'];
     if($p==1) //当本页面要加水印时加_w
     {
         $destination = $destination_folder . $now .'_w'.'.' . $imagetype; //要加水印的图片
         $dpath= $sortpath . $now .'_w'.'.' . $imagetype; //加水印的图片
     }else
     {
         $destination =$destination_folder . $now .'.' . $imagetype; //完整图片url 原图 
         $dpath= $sortpath . $now .'.' . $imagetype; //原图 
     }
    $soureimg = $destination_folder . $now .'.' . $imagetype; //完整图片url 原图 
    $sourepath = $sortpath . $now .'.' . $imagetype; //原图 
    if (file_exists($destination) && $overwrite != true) {
        echo "<font color='red'>同名文件已经存在了！</a>";
        exit;
    }
     if (!copy($filename, $soureimg)) {
        echo "<font color='red'>移动文件出错！</a>";
        exit;
    }
    
    if (!move_uploaded_file($filename, $destination)) {
        echo "<font color='red'>移动文件出错！</a>";
        exit;
    }
    createThumb($destination, 'gift');
    $pinfo = pathinfo($destination);
    $fname = $pinfo['basename'];
    echo " <font color=red id='obj' class=\"" . $dpath . "\" >已经成功上传</font><br><font id='font'>文件名:</font> <font id='objpath' class=\"" .
        $dpath . "\" color=blue>" . $destination_folder . $fname . "</font>";
    echo '<script>';
    echo 'if(typeof(parent.imgcallback)!="undefined"){';
    echo 'parent.imgcallback("' . $sourepath . '");';
    echo '}';
    echo '</script>';
   
    addwaterimg($p, 2, $destination,$_SCONFIG['watermarkfile'],'',$waterstring,$_SCONFIG['watermarkstatus']);  //加水印方法
    echo '<script>returnvalue(); </script>';
    if ($imgpreview == 1) {
        echo "<br>图片预览:<br>";
        echo "<a href=\"" . $destination . "\" target='_blank'><img  id='imageid' src=\"" .
            $destination . "\" style='width:100px;height:100px' width=" . ($image_size[0] *
            $imgpreviewsize) . " height=" . ($image_size[1] * $imgpreviewsize);
        echo " alt=\"图片预览:\r文件名:" . $destination . "\r上传时间:\" class=\"" . $sourepath . "\" border='0'></a>";
    }
}
function getdirurl() {
	$timestamp=time();
	$destination_folder = S_ROOT."attachments/";
//以天存档
    $yearpath=Date('Y', $timestamp)."/";
    $monthpath=$yearpath.Date('m', $timestamp)."/";
    $dayspath = $monthpath.Date('d', $timestamp)."/";
	if(!file_exists($destination_folder))
    mkdir($destination_folder);
	if(!file_exists($destination_folder.$yearpath))
    mkdir($destination_folder.$yearpath);
   	if(!file_exists($destination_folder.$monthpath))
    mkdir($destination_folder.$monthpath);
   	if(!file_exists($destination_folder.$dayspath))
    mkdir($destination_folder.$dayspath);
	return  $destination_folder.ltrim($dayspath,'.');
	
}
?>
</center>
</body>
</html>