<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<style type="text/css">
.kejian {
	width: 784px;
	float:left;
	border: 1px solid #dcdcdc;
	background:white;
}
.kejian .showimg {
	margin-top: 6px;
	margin-left: 8px;
}
.kejian liss {
	width: 748px;
}
.kejian .liss .danke {
	width: 145px;
	float: left;
	margin-top: 8px;
	height: 218px;
}
.kejian .liss .danke .spne {
	text-align: center;
	width: 140px;
	height: 36px;
	overflow: hidden;
	word-wrap: break-word;
	display: block;
	color: #0033ff;
	float:left;
}
.kejian .liss .danke .sds {
	height: 184px;
	width: 145px;
	border: 1px solid #cdcdcd;
	background-image: url(http://static.ebanhui.com/ebh/tpl/2012/images/dise.jpg);
	background-repeat: no-repeat;
	background-position: center center;
	margin-bottom: 8px;
}

.showimg { background-color:#CBCBCB; float:left;}
.showimg img { background-color:#FFFFFF; border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg { background-color:#0087B2;}
.hover .showimg img { border:1px solid #0087B2;}
.showimg .hover{border: 1px solid #0099cc;}
.tabhead th {
	background:#fff;
	color:#18a8f7;
	font-size:16px;
	font-weight:bold;
}
.datatab {
	margin-top:10px;
}
.cqliebiao {
	width: 786px;
	margin-top:15px;
	border: 1px solid #cdcdcd;
	background:#fff;
}
.liess{
	clear:both;
}
.fujianico {
	background: url(http://static.ebanhui.com/ebh/tpl/default/images/attachmen_ico.jpg) no-repeat;
	height: 16px;
	width: 16px;
	float:left;
}
.timingbox{
	float:left;
	margin-left:5px;
}
.kuesr {
	width:20px;
	height:60px;
	position: absolute;
	top:5px;
	right:0px;
}
.kuesr a.toples {
	width:20px;
	height:20px;
	float:left;
	display:block;
	background: url(http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_up.png) no-repeat;
}
.kuesr a.bottomles {
	width:20px;
	height:20px;
	float:left;
	display:block;
	background: url(http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_down.png) no-repeat;
}
.control .manage a.CP_a_fuc {
	background: #18a8f7;
	color: #ffffff;
	display:block;
	margin-right:4px;
	padding:4px 6px;
	margin-top:4px;
	float:left;
	line-height:normal;
}
.control .manage a.CP_a_fuc:hover {
	background: #0d9be9;
	color:#fff;
	text-decoration: none;
}
.label-live{
	float:left; 
	padding:1px 5px;
	height: 18px;
	width: 30px; 
	border: 1px solid #dbdbdb;
    margin-right: 10px;
	margin-left:5px;
	background-color: #18a8f7;
	border-radius: 0.25em;
    color: #fff;
    display: inline;
    text-align: center;
	font-style: normal ;
}
a.fusrets {
    display: block;
    height: 103px;
    left: 0;
    position: absolute;
    top: 0;
    width: 178px;
    z-index: 9;
}
a.fusrets:hover {
    background: url(http://static.ebanhui.com/ebh/tpl/2014/images/kustgd1.png) no-repeat center ;
}
.ettyusr {
    float: left;
    height: 103px;
    margin-right: 10px;
    position: relative;
    width: 178px;
}
.ettyusr img {
	float:left;
	width:178px;
	height:103px;
}
</style>
<script type="text/javascript">
<!--
$(function(){
	$('#searchbutton').click(function(){
		var href = '<?= geturl('troom/classsubject/'.$folder['folderid']) ?>';
		var searchvalue = $("#searchvalue").val();
		if(searchvalue=='请输入课件名称'){
			searchvalue='';
		}
		href=href+"?q="+encodeURIComponent(searchvalue);
		location.href = href;
	});
        
	H.create(new P({
		id : 'sectiondiv',
	    title: '课程目录',
	    padding:2,
	    easy:true,
	    content:$('#sectiondiv')[0]
	}),'common');

	var fid = $('#folderid').val();
	section();
	$("#addsection").click(function(){
		updatesection();
	});

});
function replaceAll(str,find,rp){
	while(true){
		if(str.indexOf(find) == -1){
			break;
		}
		str = str.replace(find,rp);
	}
	return str;
}

function section(){
    var folderid = $('#folderid').val();
	$.ajax({
		url:"<?= geturl('troom/section') ?>",
		type:'post',
		data:{'folderid':folderid},
		dataType:'json',
		success:function(data){
			$('#dnone').css('display',"");
			$('#sectionid').empty();
			$.each(data,function(key,value){
				$('#sectionid').append('<option value="'+value.sid+'">'+value.sname+'</option>');
			});
			try{
			top.resetmain();
			}catch(error){}
		}
	});
}

function edittitle(val){
	var title = $("#"+val+"name").val();
	$('#tr'+val).html('<span class="htit" style="color:#000000; width:auto;"><input class="categoryName" type="text" id="'+val+'title" value="'+title+'" maxlength="50" style="height:22px;line-height:22px;width:220px;margin-top:2px;padding:0px;"></span><input type="button" onclick="saction('+val+');" class="bcun" value="确定"  style="margin-top:4px;"/>&nbsp<input type="button" onclick="editclose(\''+title+'\',\''+val+'\')" class="bcun" value="取消" /><div></div>');
}
function editclose(title,val){
	$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+val+')">编辑</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+val+')">删除</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+val+')">向上</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+val+')">向下</a></div></span><div></div>');
}
//编辑章节
function saction(val){
	var title =$('#'+val+'title').val();
	$.ajax({
		url:"<?= geturl('troom/section/edit') ?>",
		type:'post',
		data:{'sid':val,'title':title},
		dataType:'json',
		success:function(data){
			$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+val+')">编辑</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+val+')">删除</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+val+')">向上</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+val+')">向下</a></div></span><div></div>');
			$("#sname").val("");
		}
	});
}
//删除目录
function delsction(val){
	if (!confirm("确认要删除该目录？")) {
		return false;
	}
	$.ajax({
		url:"<?= geturl('troom/section/del') ?>",
		type:'post',
		data:{'sid':val},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				$("#tr"+data.sid).html('');
				updatesection();
				$("#sname").val("");
				section()
			}
		}
	});
}
//添加章节
function addsction(val){
	var sname = $('#'+val).val();
	if (sname.length>50 || sname.length<1) {
		$(".SG_txtc").html('<font color="red">1-50个字符，包括中文,字母,数字</font>');
		return false;
	};
        var folderid = $("#folderid").val();
	$.ajax({
		url:"<?= geturl('troom/section/add') ?>",
		type:'post',
		data:{'sname':sname,'folderid':folderid},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				$("#tsection").append('<li class="" id="tr'+data.sid+'"><span class="htit" style="color:#000000" id="'+data.sid+'catitle"><input type="hidden" id="'+data.sid+'name" value="'+data.sname+'" />'+data.sname+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+data.sid+')">编辑</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+data.sid+')">删除</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+data.sid+')">向上</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+data.sid+')">向下</a></div></span><div></div></li>');
				$("#sname").val("");
				section();
			}
		}
	});
}

function moveup(val){
	if($("#tr"+val).prev().size()==0){
		return;
	}
	$.ajax({
		url:"<?= geturl('troom/section/moveup') ?>",
		type:'post',
		data:{'sid':val},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				updatesection();
				$("#sname").val("");
			}
		}
	});

}

function movedown(val){
	if($("#tr"+val).next().size()==0){
		return;
	}
        var folderid = $("#folderid").val();
	$.ajax({
		url:"<?= geturl('troom/section/movedown') ?>",
		type:'post',
		data:{'sid':val},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				updatesection();
				$("#sname").val("");
			}
		}
	});

}

var updatesection = function(){
    var folderid = $("#folderid").val();
	$.ajax({
		url:"<?= geturl('troom/section') ?>",
		type:'post',
		data:{'folderid':folderid},
		dataType:'json',
		success:function(data){
			var objhtml='<div style="width:520px;">'
				objhtml+='<div id="categoryBody" style="width:485px">'
				objhtml+='<div id="categoryHead">'
				objhtml+='<table>'
				objhtml+='<tbody>'
				objhtml+='<tr>'
				objhtml+='<td>'
				objhtml+='<input class="categoryName" style="height:22px;padding:0px;" type="text" name="sname" id="sname" maxlength="50">'
				objhtml+='</td>'
				objhtml+='<td width="80">'
				objhtml+='<a class="CJsub" href="javascript:void(0);" id="ctitle" onclick="addsction(\'sname\');">'
				objhtml+='<cite>创建目录</cite>'
				objhtml+='</a>'
				objhtml+='</td>'
				objhtml+='<td>'
				objhtml+='<span class="SG_txtc" style="margin-left:5px;width:240px;display:block;color:#999;">请用中文,英文或数字.1-50个字符!</span>'
				objhtml+='</td>'
				objhtml+='</tr>'
				objhtml+='</tbody>'
				objhtml+='</table>'
				objhtml+='<div id="errTips"></div>'
				objhtml+='</div>'
				objhtml+='<form name="form" method="post">'
				objhtml+='<div id="categoryList">'
				objhtml+='<ul class="clearfix" id="tsection">'
				$.each(data,function(k,v){
					objhtml+='<li id="tr'+v.sid+'">'
					objhtml+='<span class="htit" id="'+v.sid+'catitle" ><input type="hidden" id="'+v.sid+'name" value="'+v.sname+'" />'+v.sname+'</span>'
					objhtml+='<span class="control" STYLE="FLOAT:RIGHT">'
					objhtml+='<div class="manage">'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+v.sid+')">'
					objhtml+='编辑</a>'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+v.sid+')">'
					objhtml+='删除</a>'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+v.sid+')">'
					objhtml+='向上</a>'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+v.sid+')">'
					objhtml+='向下</a>'
					objhtml+='</div>'
					objhtml+='</span>'
					objhtml+='</li>'
				});
				objhtml+='</ul>'
				objhtml+='<div class="SG_j_linedot"></div>'
				objhtml+='</div>'
				objhtml+='</form>'
				objhtml+='</div>'
				objhtml+='</div>'
				$("#sectiondiv").html(objhtml);
				H.get('sectiondiv').exec('show');
			return;
		}
	});
}
//-->
</script>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
	<div class="ter_tit" style="height:auto;">
		<div style="width:570px; line-height:26px; height:26px; padding:7px 0;">当前位置 > <a href="<?= geturl('troom/classsubject') ?>" ?>课程管理</a> > <a href="<?= geturl('troom/classsubject/courses') ?>">班级课程</a> > 
			<?php if(!empty($uparr)){
				$upfoldercount = count($uparr);
				foreach($uparr as $k=>$upfolder){
				$index = $upfoldercount-$k-1;
			?>
			<a href="<?=geturl('troom/classsubject/'.$uparr[$index]['folderid'])?>"><?=$uparr[$index]['foldername']?></a> > 
			<?php }}?>
			<?= $folder['foldername'] ?></div>
			<div class="diles">
			<?php
				$search = $this->input->get('q');
				if(!empty($search)){
					$stylestr="style='color:#000;'";
				}else{
					$stylestr = "";
				}
			?>
	<input name="search" <?=$stylestr?> class="newsou" id="searchvalue" onblur="if($('#searchvalue').val()==''){$('#searchvalue').val('请输入课件名称').css('color','#d2d2d2');}" onfocus="if($('#searchvalue').val()=='请输入课件名称'){$('#searchvalue').val('').css('color','#000');}" value="<?= !empty($search) ? $search : '请输入课件名称' ?>" type="text" />
	<input id="searchbutton" type="button" class="soulico" value="">
</div>
		</div>
	<div class="lefrig" style="float:left;margin-top:15px;width:788px;">
<div id='sectiondiv' style="display: none;"></div>
<input type="hidden" id="folderid" value="<?= $folder['folderid']?> "/>
	<div class="annuato tiezi_search dbbtn" style="position: relative;background:#fff; margin-top:0px;">
<div class="tiezitool">

	<?php $search = $this->input->get('q');?>
	<?php if(empty($sectionlist) && $needsubfolder && empty($search)){?>
	<a class="mulubgbtn hongbtn" style="margin-right:10px;" href="<?=geturl('troom/folder/add/'.$folder['folderid'])?>">添加目录</a>
	<?php }?>
	
	<!-- //判断是否有直播权限 -->
	<?php if($haslive){?>
	<a class="<?=$live['classname']?>" href="<?=str_replace('[folderid]',$folder['folderid'],$live['url'])?>"><?=(isset($live['modulename']) ? $live['modulename'] : '')?></a>
	<?php }?>
	
	<?php if(empty($subfolderlist)){?>
	<a class="chuanbgbtn hongbtn marrig" href="<?= geturl('troom/classcourse/add-0-0-0-'.$folder['folderid'].'-course')?>">发布课件</a><!--
	<a class="chuanbgbtn hongbtn marrig" href="<?= geturl('troom/classcourse/addmulti-0-0-0-'.$folder['folderid'])?>">批量上传</a>-->
	<input class="mulubgbtn hongbtn" type="button" id="addsection" value="课程目录" />
	<?php }?>
</div>
</div>
	<?php if(!empty($subfolderlist)) { ?>
<div class="kejian">
	<ul class="liss">
        <?php foreach($subfolderlist as $subfolder){ ?>
	<li class="danke" style="margin-left:10px; _margin-left:2px;list-style: none;">
	<div class="showimg"><a href="<?=geturl('troom/classsubject/'.$subfolder['folderid'])?>" title="<?=$subfolder['foldername']?>"><img src="<?= empty($subfolder['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $subfolder['img'] ?>" width="114" height="159" border="0" /></a></div>
	<span class="spne"><a href="<?= geturl('troom/classsubject/'.$subfolder['folderid']) ?>" style="text-decoration: none;" title="<?= $subfolder['foldername'] ?>"><?= shortstr($subfolder['foldername'],16,'') ?>(<?= $subfolder['coursewarenum'] ?>)</a></span>
	</li>
        <?php } ?>

	</ul>
	</div>
<?php }?>
	<?php if(empty($subfolderlist)){?>
	
		<?php if(!empty($sectionlist)) { ?>
                                <?php foreach($sectionlist as $k=>$section) { ?>
		<table width="100%" class="datatab" id="tb<?=$k?>">
			<thead class="tabhead">
				<tr>
					<th>
					<a href="javascript:void(0)" style="color:#18a8f7;text-decoration:none" onclick="showcws('<?=$k?>')"><?=$section[0]['sname']?>(<?=$section[0]['sectioncount']?>)</a>
					</th>
				</tr>
			</thead>
			<?php 
			$mediatype = array('flv','mp4','avi','mpeg','mpg','rmvb','rm','mov');
			$emptylogo = true;
			$datenow = date('Y-m-d');
				foreach($section as $cw) { 
					$arr = explode('.',$cw['cwurl']);
					$type = $arr[count($arr)-1];
					if($type != 'flv' && $cw['ism3u8'] == 1)
						$type = 'flv';
					if($type == 'mp3')
						$type = 'flv';
					if($type == 'mov' && $cw['ism3u8'] == 1)
						$type = 'flv';
					
					//头像处理 eker 2016年1月28日16:40:55
					$base_url ='http://static.ebanhui.com/ebh/tpl/default/images/'; 
					$defaulturl = ($cw['sex'] == 1) ? $base_url."t_woman.jpg" : $base_url."t_man.jpg";
					$face = empty($cw['face']) ? $defaulturl : $cw['face'];
					$face = getthumb($face,'50_50');
					
					//直播与普通课件 eker
					$cwtype = ($cw['islive'] == 1 )? 'live' : 'course';
					
					$arr = explode('.',$cw['cwurl']);
					
					$isVideotype = in_array($type,$mediatype) || $cw['islive'];
					// $target=(empty($cw['cwurl']) || $isVideotype) ? '_blank' : '_blank';
					$target = '_blank';
					$deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/'.($isVideotype?($cw['islive']?'livelogo.jpg':'defaultcwimggray.png'):'kustgd2.png');
					if($isVideotype){
						$playimg = 'kustgd2';
					}elseif(strstr($type,'ppt')){
						$playimg = 'ppt';
					}elseif(strstr($type,'doc')){
						$playimg = 'doc';
					}elseif($type == 'rar' || $type == 'zip' || $type == '7z'){
						$playimg = 'rar';
					}elseif($type == 'mp3'){
						$playimg = 'mp3';
					}else{
						$playimg = 'attach';
					}
					
					if(!empty($cw['logo']) && $isVideotype){
						$logo = $cw['logo'];
						$emptylogo = false;
					}
					else{
						$logo = $deflogo;
					}
					$date = date('Y-m-d',$cw['dateline']);

				?>
			<tbody>
				<tr>
					<td>
					<div style="float:left;margin-right:15px;margin-left:18px">
						<img style="width:50px;height:50px;" src="<?=$face?>">
					</div>
					<div class="ettyusr">
						<a class="fusrets" style="color:<?= $date==$datenow?'red':'#666'?>" target="<?= (empty($cw['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= (empty($cw['cwurl']) || $type == 'flv') ? geturl('troom/course/'.$cw['cwid']) : geturl('troom/classcourse/'.$cw['cwid']) ?>" title="<?=$cw['title']?>">
							<img src="<?='http://static.ebanhui.com/ebh/tpl/2014/images/'.$playimg.'.png'?>"/>
						</a>
						<img src="<?=$logo?>" />
					</div>
					<div style="float:left;width:500px;position: relative;">
					<?php if(count($section)>1){?>
					<div class="kuesr" >
					<a href="javascript:void(0)" onclick="moveupcw(<?=$cw['cwid']?>)" title="上移" class="toples"></a>
					<a href="javascript:void(0)" onclick="movedowncw(<?=$cw['cwid']?>)" title="下移"  class="bottomles"></a>
					</div>
					<?php }?>
					<?php if($cw['attachmentnum'] > 0 ) { ?>
						<i class="fujianico" title="此课件包含附件"></i>
					<?php }  ?>
					<?php if($cwtype=='live'){?>
					<i class="label-live" title="直播课件">直播</i>
					<?php }?>
					<h2 style="font-size:14px;font-weight:bold;height:25px">
					
					<a style="color:<?= $date==$datenow?'red':'#666'?>;text-decoration:none" target="<?= (empty($cw['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= (empty($cw['cwurl']) || $type == 'flv') ? geturl('troom/course/'.$cw['cwid']) : geturl('troom/classcourse/'.$cw['cwid']) ?>"><?=$cw['title']?></a>
					</h2>

					<p style="line-height:2;height:24px;float:left;width:490px;"><?=$cw['realname']?>  <?=timetostr($cw['dateline'])?> 发布 <?=!empty($cw['viewnum'])?'&nbsp; 人气:'.$cw['viewnum']:''?> <?=!empty($cw['reviewnum'])?'&nbsp; 评论:'.$cw['reviewnum']:''?></p>
					<?php if(!empty($roominfo['checktype'])){
						if($cw['status'] == 0){?>
							<p style="float:left;width:100px;color:blue">未审核</p>
						<?php }elseif($cw['status'] == -2){?>
							<p style="float:left;width:100px;color:red"><span style="color:red;cursor:pointer;" onclick="checkdetail(<?=$cw['cwid']?>)">审核未通过</span></p>
						<?php }?>
					<?php }?>
					<p style="line-height:2;color:#999;width:480px;float:left;"><?=$cw['summary']?></p>
					<span style="width:480px;float:left;color:red"><?=!empty($cw['submitat'])?'开课时间：'.Date('Y-m-d H:i',$cw['submitat']):''?> <?=!empty($cw['submitat'])&&!empty($cw['endat'])?'&nbsp;':''?> <?=!empty($cw['endat'])?'截止时间：'.Date('Y-m-d H:i',$cw['endat']):''?></span>
		</div>
		
		<?php if($cw['uid'] == $uid) { ?>
			<div style="margin-left:<?=$roominfo['isschool']==7?'415':($roominfo['isschool']==3?'365':'435')?>px;float:left;display:inline;width:100%;" cwid="<?=$cw['cwid']?>">
				<?php if(!empty($cw['attachmentnum'])) { ?>
					 <a class="previewBtn" href="<?= geturl('troom/classattachlist-0-0-0-'.$cw['cwid'])?>">附件管理</a>
				<?php } else { ?>
					 <a class="previewBtn" href="<?= geturl('troom/classcourse/upattach-0-0-0-'.$cw['cwid']) ?>">上传附件</a>
				<?php } ?>
			<input type="button" class="previewBtn" style="cursor:pointer;vertical-align: middle;float:left;margin-right: 4px;font-weight:100;" onclick="window.open('http://exam.ebanhui.com/enew/<?=$roominfo['crid']?>/0/<?=$folderid?>/<?=$cw['cwid']?>.html','_blank')" value="布置作业" />
			<input type="button" class="replyBtn" style="float:left;margin-right: 4px;cursor:pointer;vertical-align: middle;font-weight:100;" onclick="location.href='<?= geturl('troom/classcourse/edit-0-0-0-'.$cw['cwid']."-".$cwtype)?>'" value="修改" />
			<?php if($roominfo['isschool']!=7){?>
			<input type="button" class="replyBtn" style="float:left;margin-right: 4px;cursor:pointer;vertical-align: middle;font-weight:100;"  onclick="delkj(<?= $cw['cwid'] ?>,'<?= str_replace('\'','\\\'',$cw['title']) ?>')" value="删除" />
			<?php }?>
			<?php if($cw['islive'] != 1) { ?>
			<input type="button" class="replyBtn settiming" style="float:left;margin-right: 4px;cursor:pointer;vertical-align:middle;font-weight:100;width:85px" value="设置定时发布" submitat="<?=!empty($cw['submitat'])?Date('Y-m-d H:i',$cw['submitat']):''?>" endat="<?=!empty($cw['endat'])?Date('Y-m-d H:i',$cw['endat']):''?>"/>
			<?php } ?>
			<?php if(($roominfo['isschool']==7 || $roominfo['isschool']==3) && $type=='flv'){?>
			<input type="button" class="replyBtn" style="float:left;margin-right: 4px;cursor:pointer;vertical-align:middle;font-weight:100;width:67px" onclick="location.href='<?= geturl('troom/classcourse/jk-0-0-0-'.$cw['cwid']) ?>'" value="学习监控">
			<?php }?>
			</div>
		<?php } ?>
					</td>
				</tr>
	
			</tbody>
			<?php }}
			}elseif(empty($onlinelist)){
			?>
			<div style="padding:20px 0 20px 160px; font-size:14px;background:white;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/stuhope.jpg" /></div>
			<?php }
			?>
		</table>
		<div id="timingdiv" class="timingdiv" style="position:absolute;z-index:999;border:1px solid #333;left:500px;background:white;display:none;width:255px;">
			<div class="timingbox" >
			<span style="">开课时间：</span><input type="text" id="submitat" readonly="readonly" style="text-indent:15px;height:22px;line-height:22px;border:1px solid #B3DDF4;margin:5px;display:inline;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'%y-%M-%d %H:%m:%s'});"/>
			</div>
			<div class="timingbox" >
			<span>截止时间：</span><input type="text" id="endat" readonly="readonly" style="text-indent:15px;height:22px;line-height:22px;border:1px solid #B3DDF4;margin:5px;display:inline;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'#F{$dp.$D(\'submitat\',{H:1})||\'%y-%M-%d {%H+1}:%m:%s\'}'});"/>
			</div>
			<input type="button" style="cursor:pointer;width:40px;height:32px;line-height:32px;margin-left:5px;border:medium none;float:left" onclick="settime()" value="确定"/>
			<span style="margin-left:5px;color:#666;float:left;width:190px">学生在此时间段内才能学习该课件
			</span>
		</div>
	<?php }?>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery.confirm.js"></script>
	<script type="text/javascript">
		function delkj(cwid,title){
			$.confirm("确认删除课件[ " + title +" ]吗？",function(){
				var url = "/troom/classcourse/del.html";
                                $.ajax({
                                    type: "POST",
                                    url: url,
                                    data: {'cwid':cwid},
                                    dataType:"json",
                                    success: function(data){
                                      if(data.status == 1) {
                                           $.showmessage({
                                               img : 'success',
                                               message:'课件删除成功',
                                               title:'课件删除成功',
                                               callback :function(){
                                                   location.reload();
                                               }
                                          });
                                      } else {
                                          $.showmessage({
                                               img : 'error',
                                               message:'课件删除失败',
                                               title:'课件删除失败'
                                          });
                                      }
                                    }
                                 }); 
			});
		
		}
		function showcws(tbid){
			if($('#tb'+tbid+' tbody').css('display')=='none')
				$('#tb'+tbid+' tbody').show();
			else
				$('#tb'+tbid+' tbody').hide();
		}
		var showtd = false;
		var currenttimingbtn;
		var currentcw ;
		$('.settiming').click(function(e){
			// var offset = this.offset();
			$('#timingdiv').css('top',e.clientY+20);
			$('#submitat').val($(this).attr('submitat'));
			$('#endat').val($(this).attr('endat'));
			$('#timingdiv').show();
			showtd = true;
			currenttimingbtn = $(this);
			
		});
		
		$('body').click(function(e){
			obj = e.srcElement ? e.srcElement : e.target;
			if(obj.parentNode == $('#timingdiv')[0] || obj == $('#timingdiv')[0])
				;
			else if(showtd == false){
				$('#timingdiv').hide();
			}
			showtd = false;
		});
		function settime(){
			var submitat = $('#submitat').val();
			var endat = $('#endat').val();
			var curcwid = currenttimingbtn.parent().attr('cwid');
			// alert(submitat);
			// return;
			$.ajax({
				type:'post',
				url:'/troom/classsubject/setcwtiming.html',
				data : {submitat:submitat,endat:endat,cwid:curcwid},
				success:function(data){
					// if(data!=0){
						// alert('设置成功');
						location.reload();
					// }
				}
			});
		}
		$('.dbbtn').dblclick(function(){
			location.href="<?= geturl('troom/classcourse/addmulti-0-0-0-'.$folder['folderid'])?>";
		});
		
		
function moveupcw(cwid){
	
	$.ajax({
		url:"<?= geturl('troom/classsubject/moveup') ?>",
		type:'post',
		data:{'cwid':cwid},
		dataType:'json',
		success:function(data){
			if(data==1){
				location.reload(true);
			}else{
				alert('已经在顶部,操作取消');
			}
		}
	});

}

function movedowncw(cwid){
	$.ajax({
		url:"<?= geturl('troom/classsubject/movedown') ?>",
		type:'post',
		data:{'cwid':cwid},
		dataType:'json',
		success:function(data){
			if(data==1){
				location.reload(true);
			}else{
				alert('已经在底部,操作取消');
			}
		}
	});

}

// $(".datatab tr").mouseover(function(){
	// $('.kuesr').hide();
	// $(this).find('.kuesr').show();
// });
	function checkdetail(toid) {
		var button = new xButton();
		button.add({
			value:"关闭",
			callback:function(){
				H.get('dialogremark').exec('close');
				return false;
			},
			autofocus:true
		});
		if(!H.get('dialogremark')){
			H.create(new P({
				id : 'dialogremark',
				title: '审核详情',
				easy:true,
				width:400,
				padding:5,
				content:$('#dialogremark')[0],
				button:button
			}),'common');
		}

		$.post("<?=geturl('troom/classsubject/getcheckdetail')?>",{toid:toid},function(data){
			if(data != null && data != undefined && data.code == 1){
				$("#teach_status").html(data.teach_status);
				$("#teach_dateline").html(data.teach_dateline);
				$("#teach_remark").html(data.teach_remark);
				H.get('dialogremark').exec('show');
			}
		},'json');

	}
	</script>
	<div style="margin-top:20px;"><?= $page ?></div>
</div>

<!--备注信息-->
<div id="dialogremark" style="display:none;height:160px;">
	<div style="height:160px;width:350px;padding-left:50px;">
	    <div class="mt15">
	    	<span>审核结果：</span>
	    	<span id="teach_status"></span>
	    </div>
	    <div class="mt15">
	    	<span style="vertical-align:top;">审核时间：</span>
	        <span id="teach_dateline"></span>
	    </div>
	    <div class="mt15">
	    	<span style="vertical-align:top;">备注信息：</span>
	        <span id="teach_remark"></span>
	    </div>
	</div>
</div>
<?php $this->display('troom/page_footer'); ?>