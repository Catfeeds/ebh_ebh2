<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style type="text/css">
.kejian {
	width: 748px;
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
        
        $('#sectiondiv').dialog({
		autoOpen: false,
		bgiframe: true,
		width: 530,
		height:400,
		resizable:false,
		draggable:false,
		type:'post',
		position:['center',100],
		title:'课程目录',
		modal: true//模式对话框
	})
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
				$('#sectiondiv').dialog("open");
			return;
		}
	});
}
//-->
</script>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
	<div class="ter_tit">
		当前位置 > <a href="<?= geturl('troom/classsubject') ?>" ?>课程管理</a> > <a href="<?= geturl('troom/classsubject/courses') ?>">班级课程</a> > 
			<?php if(!empty($uparr)){
				$upfoldercount = count($uparr);
				foreach($uparr as $k=>$upfolder){
				$index = $upfoldercount-$k-1;
			?>
			<a href="<?=geturl('troom/classsubject/'.$uparr[$index]['folderid'])?>"><?=$uparr[$index]['foldername']?></a> > 
			<?php }}?>
			<?= $folder['foldername'] ?>
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
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
<div id='sectiondiv' style="display: none;"></div>
<input type="hidden" id="folderid" value="<?= $folder['folderid']?> "/>
	<div class="annuato tiezi_search" style="line-height:28px;padding-left:20px;position: relative;border:none;">
<div class="tiezitool">
	<?php $search = $this->input->get('q');?>
	<?php if(empty($sectionlist) && $needsubfolder && empty($search)){?>
	<a class="mulubgbtn hongbtn" style="margin-right:10px;" href="<?=geturl('troom/folder/add/'.$folder['folderid'])?>">添加目录</a>
	<?php }?>
	<?php if(empty($subfolderlist)){?>
	<a class="chuanbgbtn hongbtn marrig" href="<?= geturl('troom/classcourse/add-0-0-0-'.$folder['folderid'])?>">上传课件</a>
	<a class="chuanbgbtn hongbtn marrig" href="<?= geturl('troom/classcourse/addmulti-0-0-0-'.$folder['folderid'])?>">批量上传</a>
	<input class="mulubgbtn hongbtn" type="button" id="addsection" value="课程目录" />
	<?php }?>
</div>
</div>
	<?php if(!empty($subfolderlist)) { ?>
<div class="kejian">
	<ul class="liss">
        <?php foreach($subfolderlist as $subfolder){ ?>
	<li class="danke" style="margin-left:4px; _margin-left:2px;list-style: none;">
	<div class="showimg"><a href="<?=geturl('troom/classsubject/'.$subfolder['folderid'])?>" title="<?=$subfolder['foldername']?>"><img src="<?= empty($subfolder['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $subfolder['img'] ?>" width="114" height="159" border="0" /></a></div>
	<span class="spne"><a href="<?= geturl('troom/classsubject/'.$subfolder['folderid']) ?>" style="text-decoration: none;" title="<?= $subfolder['foldername'] ?>"><?= ssubstrch($subfolder['foldername'],0,20) ?>(<?= $subfolder['coursewarenum'] ?>)</a></span>
	</li>
        <?php } ?>

	</ul>
	</div>
<?php }?>
	<?php if(empty($subfolderlist)){?>
		<table width="100%" class="datatab" style="border:none;">
			<tbody class="tabhead">
			<tr>
			<th width="18%">所属目录</th>
			<th width="25%">课件名称</th>
			<th width="12%">上传日期</th>
			<th width="12%">所属教师</th>
			<th width="33%" style="text-align:center">修改操作</th>
			</tr>
			</tbody>
			<tbody>
		  	
  			  	<script type="text/javascript">
					function ablank(url){
						window.open(url);
					}
					
				</script>
				
			
                            <?php if(!empty($sectionlist)) { ?>
                                <?php foreach($sectionlist as $section) { 
                                    foreach($section as $ckey=>$course) {
                                    ?>
				  <tr>
				  
                                        <?php if($ckey == 0) { ?>
						<td rowspan="<?= count($section) ?>"><?= $course['sname'] ?></td>
                                        <?php } ?>
					
					
				    <td>
					<?php $arr = explode('.',$course['cwurl']);
							$type = $arr[count($arr)-1]; 
							if($type != 'flv' && $course['ism3u8'] == 1)
								$type = 'flv';
					?>
                                        <?php if(!empty($course['attachmentnum'])) { ?>
					    		<img alt="此课件包含附件"  src="http://static.ebanhui.com/ebh/tpl/default/images/fujian.gif"/>(<?= $course['attachmentnum'] ?>)
                                        <?php } ?>
				    	<a target="<?= (empty($course['cwurl']) || in_array($type,array('flv','mp4','avi','mp3','mpeg','mpg','rmvb','rm','mov'))) ? '_blank' : '' ?>" href="<?= ($type == 'flv') ? geturl('troom/course/'.$course['cwid']) : geturl('troom/classcourse/'.$course['cwid']) ?>"><?= $course['title'] ?></a>
				    </td>
				    <td><?= date('Y-m-d',$course['dateline']) ?></td>
				    <td>
					 	 <?= $course['realname'] ?>
				    </td>
				    <td>
					
                                                <?php if($course['uid'] == $uid) { ?>
	
						
                                                        <?php if(!empty($course['attachmentnum'])) { ?>
					 			<a class="previewBtn" href="<?= geturl('troom/classattachlist-0-0-0-'.$course['cwid'])?>">附件管理</a>
                                                        <?php } else { ?>
					 			<a class="previewBtn" href="<?= geturl('troom/classcourse/upattach-0-0-0-'.$course['cwid']) ?>">上传附件</a>
					 		<?php } ?>
	<input type="button" class="previewBtn" style="cursor:pointer;vertical-align: middle;font-weight:100;" onclick="window.open('http://exam.ebanhui.com/enew/<?=$roominfo['crid']?>/0/<?=$folderid?>/<?=$course['cwid']?>.html','_blank')" value="布置作业" />
					    		<input type="button" class="replyBtn" style="cursor:pointer;vertical-align: middle;font-weight:100;" onclick="location.href='<?= geturl('troom/classcourse/edit-0-0-0-'.$course['cwid'])?>'" value="修改" />
				    		<input type="button" class="replyBtn" style="cursor:pointer;vertical-align: middle;font-weight:100;"  onclick="delkj(<?= $course['cwid'] ?>,'<?= $course['title'] ?>')" value="删除" />

				    	
							
                                                <?php } ?>
					</td>
				    
				  </tr>
                                    <?php } ?>
                                <?php } ?>
	
                            <?php } else { ?>

		  		<tr>
		  			<td colspan="7" align="center" width="100%" >暂无记录</td>
		  		</tr>
                            <?php } ?>

		</tbody>
	</table>
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
	</script>
	<div style="margin-top:20px;"><?= $page ?></div>
</div>
<?php $this->display('troom/page_footer'); ?>