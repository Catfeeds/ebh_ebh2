<?php $this->display('troomv2/page_header');?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<style>
	.xuanban {width:482px;height:165px;background:url(http://static.ebanhui.com/static/images/topbgj1203.jpg) no-repeat;border:solid 1px #b1d1e7;padding:10px;}
	.xuanban .rbxht {height:38px;line-height:38px;font-weight:bold;border-bottom:solid 1px #e5e5e5;color:#2f59ab;}
	.xuanban li{color:#646464;height:35px;line-height:35px;font-size:14px;float:left;font-weight:bold;white-space: nowrap;margin-right:23px;display:inline;width:188px;}
	.goxua {float:left;margin-top:10px;_margin-top:6px;margin-right:5px;_margin-right:0px;}
	.bluebtn {
    background:#3bb6fa;
    color: #ffffff;
    display: block;
    height: 27px;
    line-height: 27px;
    text-align: center;
    text-decoration: none;
    width: 78px;
	border:none;
	font-size:12px;
	}
	.bluebtn:hover {
		color: #ffffff;
	    background:#18a8f7;
	}
 	.work_menuss .workBtn {display:block;float:right;width:100px;height:32px;line-height:32px;text-align:center;color:#FFFFFF;background:#18a8f7;text-decoration:none;cursor:pointer;border:none;font-size: 14px;font-weight: bold;}
 	.work_menuss .workBtn:hover{background:#0d9be9;color:#fff;text-decoration: none;font-size: 14px;font-weight: bold;}
</style>
<div class="ter_tit">
	当前位置 > 在线直播 > 编辑直播
</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;">
<div class="work_mes">
	<ul>
		<li <?php if($pos=='my'){echo 'class=workcurrent';}?>><a href="<?= geturl('troomv2/myonline')  ?>"><span>我的直播</span></a></li>
		<!-- <li <?php if($pos=='all'){echo 'class=workcurrent';}?>><a href="<?= geturl('troomv2/myonline/all') ?>"><span>所有直播</span></a></li> -->
		<li><a href="<?= geturl('troomv2/myonline/add')?>"><span>添加直播</span></a></li>

	</ul>
</div>
		<div id='atsrc' style="display: none;"></div>
		<div style="float:left;margin-top:10px;">
<form id="formdata">
	<input type="hidden" name="id" value="<?=$onlinecourseinfo['id']?>" />
	<table class="addteacher_tab" width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<th width=100><label>课程名称：</label></th>
		<td colspan="3">
			<input style="padding-left: 5px;" class="uipt w295" maxlength="25" name="title" id="title" type="text" value="<?=$onlinecourseinfo['title']?>" onblur="teacher(this,'课程名称','title','','n','','','请输入课程名称。')">
			<span class="ts2" id="title_msg">请输入课程名称。</span>
		</td>
	  </tr>
	  
	   <tr>
		<th width=100><label>直播时间：</label></th>
		<td colspan="3">
			<input class="uipt w175" value="<?=date('Y-m-d H:s',$onlinecourseinfo['cdate'])?>" name="cdate" id="cdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'%y-%M-%d %H:%m:%s'});" onblur="teacher(this,'直播时间','cdate','','n','','','请输入课程开始时间，不能早于当前时间。')"/>
			<!-- <input class="uipt w175" name="cdate" id="cdate" type="text" /> -->
			<span class="ts2" id="cdate_msg">请输入课程开始时间，不能早于当前时间。</span>
		</td>

	  </tr>
	     <tr>
		<th width=100><label>直播时长：</label></th>
		<td colspan="3">
			<select id='tselect' class="uipt w175" type="text"  maxlength="100" name="ctime" value="" >
				<option value="10">10分钟</option>
				<option value="20">20分钟</option>
				<option value="30">30分钟</option>
				<option value="40">40分钟</option>
				<option value="45">45分钟</option>
				<option value="50">50分钟</option>
				<option value="60">60分钟</option>
				<option value="80">80分钟</option>
				<option value="90">90分钟</option>
				<option value="100">100分钟</option>
				<option value="120">120分钟</option>
				<option value="150">150分钟</option>
				<option value="180">3小时</option>
				</select>
			<span id="ctime_msg" class="ts2">在线课程的持续直播时长</span>
		</td>
	  </tr>
	  <tr>
		<th width=100><label>主讲老师：</label></th>
		<td colspan="3">
			<input style="padding-left: 5px;" class="uipt w175" maxlength="15" name="tname" id="tname" type="text" value="<?=$onlinecourseinfo['tname']?>" onblur="teacher(this,'主讲老师','tname','','n','','','请输入课程主讲老师，默认为当前登录的老师。')" >
			<span class="ts2" id="tname_msg">请输入课程主讲老师，默认为当前登录的老师。</span>
		</td>
	  </tr>
	  <tr>
		<th width=100><label>助教老师：</label></th>
		<td colspan="3">
			<?=$teacherSelect?>
			<span class="ts2" id="tname_msg">请选择课程助教老师，默认没有助教老师。</span>
		</td>
	  </tr>
	  <!-- === -->
	  <tr>
		<th width=100><label>科目选择：</label></th>
		<td colspan="3">
			<select name="folderid" id="folderid">
				<?php foreach($folderlist as $folder){?>
					<option <?php if($onlinecourseinfo['folderid']==$folder['folderid']){echo 'selected=selected';}?>  title="<?=$folder['foldername']?>" value="<?=$folder['folderid']?>"><?=$folder['foldername']?></option>
				<?php }?>
			</select>
			<span class="ts2" id="tname_msg">请选择直播对应的科目。</span>
		</td>
	  </tr>
	  <tr>
	  <!-- === -->
	  <tr>
		<th width=100><label>最大人数：</label></th>
		<td colspan="3">
			<input style="padding-left: 5px;" class="uipt w175" name="maxnum" id="maxnum" type="text" value="<?=$onlinecourseinfo['maxnum']?>" onblur="teacher(this,'最大人数','maxnum','^[0-9]*$','n',null,'','请输入直播课程允许容纳的最大学生人数。')" >
			<span class="ts2" id="maxnum_msg">请输入直播课程允许容纳的最大学生人数，默认100人。</span>
		</td>
	  </tr>
    <tr>
	 
		<th><label>课程简介：</label></th>
		<td colspan="3">
			<textarea style="padding-left: 5px;border:solid 1px #9EB7CB;resize:none;" name="summary" id="summary" cols="80" rows="5" value="" onblur="teacher(this,'课程简介','summary','','n',10,'','请输入课程简介信息，字数控制在10-250个字符之间。',250)"><?=$onlinecourseinfo['summary']?></textarea>
			<p style="line-height:22px; color:#999999;"id="summary_msg">请输入课程简介信息，字数控制在10-250个字符之间。</p>
		</td>
	  </tr>
	 
	  	<th></th>
		<td colspan="3"><a class="lanbtn" name="" onclick="return beforesubmit()" value="提交" type="submit" />提交</a></td>
	  </tr>
	 </table>
 </form>
 </div>
</div>
<script>
	$(function(){
		$("ul.ulclass li").click(function(){
			$(this).find('input').prop('checked','checked');
		});
	});
	
	function beforesubmit(){
		
		//===检测
		if(!teacher_submit('online')){
			return false;
		}
		$.post("/troomv2/myonline/edit.html",{param:$("#formdata").serialize()},function(message){
				if(message=="1"){
					$.showmessage({
						message:'编辑成功！',
						callback :function(){
                           document.location.href = "/troomv2/myonline.html";
                        }});
				}
				else
					$.showmessage({message:'编辑失败！'});
		});
	}	
	$(function(){
			$('input:gt(1):lt(3)').attr('style','width:295px;');
			$('select').attr('style','width:302px;');
	});	
	$(function(){
		$("#tselect option[value='<?=$onlinecourseinfo['ctime']?>']").attr('selected','selected');
	})
</script>
<?php $this->display('troomv2/page_footer');?>