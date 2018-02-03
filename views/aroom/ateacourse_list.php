<?php $this->display('aroom/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style>
.kejian {
	width: 786px;
	float:left;
	border: 1px solid #dcdcdc;
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

.lefrig a.tfanhui:hover {
	padding:0;
}
</style>

<SCRIPT LANGUAGE="JavaScript">
<!--
$(function(){
	$('#searchbutton').click(function(){
		var href = '<?=geturl('aroom/ateacourse/course/courselist-0-0-0-'.$folderid.'-'.$uid)?>';
		var searchvalue = $("#searchvalue").val();
		if(searchvalue=='请输入课件名称'){
			searchvalue='';
		}
		searchvalue = searchvalue.replace(/,/g,"");
		searchvalue = searchvalue.replace(/\'/g,"");
		searchvalue = searchvalue.replace(/\"/g,"");
		searchvalue = searchvalue.replace(/\//g,"");
		searchvalue = searchvalue.replace(/%/g,"");
		searchvalue = searchvalue.replace(/_/g,"");
		searchvalue = searchvalue.replace(/#/g,"");
		searchvalue = searchvalue.replace(/\?/g,"");
		searchvalue = searchvalue.replace(/\\/g,"");
		// href=href.replace('searchvalue',encodeURIComponent(searchvalue));
		href+='?q='+searchvalue
		location.href = href;
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
function delkj(cwid,title){
	$.confirm("确认删除课件[ " + title +" ]吗？",function(){
		var url = "/aroom/ateacourse/del.html";
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
				}else{
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
//-->
</SCRIPT>

<div class="ter_tit">
	当前位置 > <a href="<?=geturl('aroom/ateacourse/course/'.$uid)?>">该教师课件查看</a> > 
	<?php if(!empty($uparr)){
				$upfoldercount = count($uparr);
				foreach($uparr as $k=>$upfolder){
				$index = $upfoldercount-$k-1;
			?>
			<a href="<?=geturl('aroom/ateacourse/course/courselist-0-0-0-'.$uparr[$index]['folderid'].'-'.$uid)?>"><?=$uparr[$index]['foldername']?></a> > 
			<?php }}?>
			<?= $folder['foldername'] ?>
</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
<?php if(empty($subfolderlist)){?>
<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;">该教师在此课程共有课件 <span style="color:#0709FE;font-weight:bold"><?=$coursecount?></span> 个
		<a class="tfanhui" style="width:90px;" href="<?=geturl('aroom/ateacourse/course/'.$uid)?>">返回上一层</a></div>
<?php }?>
<?php if(!empty($subfolderlist)) { ?>
<div class="kejian">
	<ul class="liss">
        <?php foreach($subfolderlist as $subfolder){ ?>
	<li class="danke" style="margin-left:4px; _margin-left:2px;list-style: none;">
	<div class="showimg"><a href="<?=geturl('aroom/ateacourse/course/courselist-0-0-0-'.$subfolder['folderid'].'-'.$uid)?>" title="<?=$subfolder['foldername']?>"><img src="<?= empty($subfolder['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $subfolder['img'] ?>" width="114" height="159" border="0" /></a></div>
	<span class="spne"><a href="<?= geturl('aroom/ateacourse/course/courselist-0-0-0-'.$subfolder['folderid'].'-'.$uid) ?>" style="text-decoration: none;" title="<?= $subfolder['foldername'] ?>"><?= ssubstrch($subfolder['foldername'],0,20) ?>(<?= $subfolder['coursewarenum'] ?>)</a></span>
	</li>
        <?php } ?>

	</ul>
	</div>
<?php }?>
<?php if(empty($subfolderlist)){?>
		<table width="100%" class="datatab" style="border:none;">
			<tbody class="tabhead">
			<tr>
			<th>所属目录</th>
			<th>课件名称</th>
			<th>上传日期</th>
			<th>所属教师</th>
			<th>操作</th>
			</tr>
			</tbody>
			<tbody>
			  	
  			  	<script type="text/javascript">
					function ablank(url){
						window.open(url);
					}
					
				</script>
				
			  <?php if(!empty($sectionlist)){
					foreach($sectionlist as $sl){
					$flag = true;
					foreach($sl as $course){
			  ?>
				  <tr>
				  
					<?php if($flag == true){?>
						<td style="width:100px;" rowspan="<?=count($sl)?>"><?=$course['sname']?></td>
					<?php }
					$flag = false;?>
					
				    <td width="200px">
					<?php $arr = explode('.',$course['cwurl']);
							$type = $arr[count($arr)-1]; 
							if($type != 'flv' && $course['ism3u8'] == 1) {
								$type = 'flv';
							}
							if($type == 'mp3')
								$type = 'flv';
							?>
				    	<?php if(!empty($course['attachmentnum'])){?>
					    		<img alt="此课件包含附件"  src="http://static.ebanhui.com/ebh/tpl/default/images/fujian.gif"/>(<?=$course['attachmentnum']?>)
				    	<?php }?>
				    	<a target="<?= (empty($course['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= (empty($course['cwurl']) || $type == 'flv') ? geturl('troom/course/view-1-0-0-'.$course['cwid'].'-'.$uid) : geturl('troom/classcourse/view-1-0-0-'.$course['cwid'].'-'.$uid) ?>"><?=$course['title']?></a>
				    </td>
				    <td><?=Date('Y-m-d',$course['dateline'])?></td>
				    <td>
					 	<?=$course['realname']?>
				    </td>
				    <td>
						<input type="button" class="replyBtn" style="cursor:pointer;vertical-align: middle;font-weight:100;" onclick="delkj(<?=$course['cwid']?>,'<?= str_replace('\'','\\\'',$course['title']) ?>')" value="删除">
					</td>
				  </tr>
				  <?php }}}else{?>
		  		<tr>
		  			<td colspan="7" align="center" width="100%" >暂无记录</td>
		  		</tr>
				<?php }?>
		</tbody>
	</table>
	<?php }?>
	<div style="margin-top:20px;"><?=show_page($coursecount)?></div>
</div>
<?php $this->display('aroom/page_footer')?>