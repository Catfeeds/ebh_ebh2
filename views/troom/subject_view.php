<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">
<!--
$(function(){
	$('#searchbutton').click(function(){
		var href = '<?= geturl('troom/subject/'.$folder['folderid']) ?>';
		var searchvalue = $("#searchvalue").val();
		if(searchvalue=='请输入课件名称'){
			searchvalue='';
		}
		href=href+"?q="+encodeURIComponent(searchvalue);
		location.href = href;
	});
    H.create(new P({
    	id:'sectiondiv',
    	title:'课程目录',
    	easy:true,
    	padding:5,
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
			top.resetmain();
		}
	});
}

function edittitle(val){
	var title = $("#"+val+"name").val();
	$('#tr'+val).html('<span class="htit" style="color:#000000; width:auto;"><input class="categoryName" type="text" id="'+val+'title" value="'+title+'" maxlength="50" style="height:22px;line-height:22px;width:220px;margin-top:2px;padding:0px;"></span><input type="button" onclick="saction('+val+');" class="bcun" value="确定"  style="margin-top:4px;"/>&nbsp<input type="button" onclick="editclose(\''+title+'\',\''+val+'\')" class="bcun" value="取消" /><div></div>');
}
function editclose(title,val){
	$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+val+')">[<cite>编辑</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+val+')">[<cite>删除</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+val+')">[<cite>向上</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+val+')">[<cite>向下</cite>]</a></div></span><div></div>');
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
			$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+val+')">[<cite>编辑</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+val+')">[<cite>删除</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+val+')">[<cite>向上</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+val+')">[<cite>向下</cite>]</a></div></span><div></div>');
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
				$("#tsection").append('<li class="" id="tr'+data.sid+'"><span class="htit" style="color:#000000" id="'+data.sid+'catitle"><input type="hidden" id="'+data.sid+'name" value="'+data.sname+'" />'+data.sname+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+data.sid+')">[<cite>编辑</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+data.sid+')">[<cite>删除</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+data.sid+')">[<cite>向上</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+data.sid+')">[<cite>向下</cite>]</a></div></span><div></div></li>');
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
					objhtml+='[<cite>编辑</cite>]</a>'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+v.sid+')">'
					objhtml+='[<cite>删除</cite>]</a>'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+v.sid+')">'
					objhtml+='[<cite>向上</cite>]</a>'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+v.sid+')">'
					objhtml+='[<cite>向下</cite>]</a>'
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
	<div class="ter_tit">
		当前位置 > <a href="<?= geturl('troom/subject') ?>">课程列表</a> > <?= $folder['foldername'] ?>
		</div>
	<div class="lefrig">
<div id='sectiondiv' style="display: none;"></div>
<input type="hidden" id="folderid" value="<?= $folder['folderid']?> "/>
	<div class="annuato tiezi_search" style="line-height:28px;padding-left:20px;position: relative;width:720px;">
<div class="tiezitool">
	<a class="chuanbgbtn hongbtn marrig" href="<?= geturl('troom/course/add-0-0-0-'.$folder['folderid'])?>">上传课件</a>
	<input class="mulubgbtn hongbtn" type="button" id="addsection" value="课程目录" />
</div><?php $search = $this->input->get('q');?>
<input type="text" name="search" value="<?= isset($search) ? $search : '请输入课件名称' ?>" onblur="if($('#searchvalue').val()==''){$('#searchvalue').val('请输入课件名称').css('color','#666');}" onfocus="if($('#searchvalue').val()=='请输入课件名称'){$('#searchvalue').val('').css('color','#000');}" id="searchvalue" style="width:200px;height:20px;float:left;color:#666;padding-left:5px;">
<a id="searchbutton" class="souhuang" >搜 索</a>
</div>
<div class="workol">
	<div class="work_menuss">
		<ul>
<li class="workcurrent"><a href="<?= geturl('troom/subject/'.$folder['folderid'])?>"><span>所有课件</span></a></li>
</ul>
</div>
</div>
		<table width="100%" class="datatab">
			<tbody class="tabhead">
			<tr>
			<th>所属目录</th>
			<th>课件名称</th>
			<th>上传日期</th>
			<th>所属教师</th>
			<th colspan="3">修改操作</th>
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
						<td style="width:100px;" rowspan="<?= count($section) ?>"><?= $course['sname'] ?></td>
                                        <?php } ?>
		
					
				    <td width="200px">
					<?php $arr = explode('.',$course['cwurl']);
							$type = $arr[count($arr)-1]; ?>
                                        <?php if(!empty($course['attachmentnum'])) { ?>
					    		<img alt="此课件包含附件"  src="http://static.ebanhui.com/ebh/tpl/default/images/fujian.gif"/>(<?= $course['attachmentnum'] ?>)
                                        <?php } ?>
				    	<a target="<?= (empty($course['cwurl']) || $type == 'flv') ? '_blank' : '' ?>"  href="<?= (empty($course['cwurl']) || $type == 'flv') ? geturl('troom/course/'.$course['cwid']) : geturl('troom/classcourse/'.$course['cwid']) ?>"><?= $course['title'] ?></a>
				    </td>
				    <td><?= date('Y-m-d',$course['dateline']) ?></td>
				    <td>
					 	 <?= $course['realname'] ?>
				    </td>
				    <td width="255px">
						
                                                <?php if($course['uid'] == $uid) { ?>
				    	<div class="fujian">
						
                                                        <?php if(!empty($course['attachmentnum'])) { ?>
					 			<a class="previewBtn" onclick="location.href='<?= geturl('troom/attachlist-0-0-0-'.$course['cwid']) ?>'">附件管理</a>
                                                        <?php } else { ?>
                                
					 			<a class="previewBtn" href="<?= geturl('troom/course/upattach-0-0-0-'.$course['cwid'])?>">上传附件</a>
					 		<?php } ?>
                            <input type="button" style="cursor:pointer;" class="btnjia" onclick="ablank('http://exam.ebanhui.com/new/<?= $roominfo['crid']?>/<?= $course['cwid']?>.html');" value="录入作业">
							<input type="button" class="replyBtn" style="cursor:pointer;vertical-align: middle;font-weight:100;" onclick="location.href='<?= geturl('troom/course/edit-0-0-0-'.$course['cwid'])?>'" value="修改" />
				    		<input type="button" class="replyBtn" style="cursor:pointer;vertical-align: middle;font-weight:100;"  onclick="delkj(<?= $course['cwid'] ?>,'<?= $course['title'] ?>')" value="删除" />
				    		
				    	</div>	
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
	<script type="text/javascript">
		function delkj(cwid,title){
			$.confirm("确认删除课件[ " + title +" ]吗？",function(){
				var url = "/troom/course/del.html";
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
	<div style="margin-top:20px;"><?= $pagestr ?></div>
</div>
<?php $this->display('troom/page_footer'); ?>