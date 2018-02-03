<?php $this->display('troom/page_header');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<style>
	.xuanban {width:482px;height:165px;background:url(http://static.ebanhui.com/static/images/topbgj1203.jpg) no-repeat;border:solid 1px #b1d1e7;padding:10px;overflow-y: auto;}
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
 	.lefrig .work_mes .workBtn {display:block;float:right;width:100px;height:32px;line-height:32px;text-align:center;color:#FFFFFF;background:#18a8f7;text-decoration:none;cursor:pointer;border:none;font-size: 14px;font-weight: bold;}
 	.lefrig .work_mes .workBtn:hover{background:#0d9be9;color:#fff;text-decoration: none;font-size: 14px;font-weight: bold;}
</style>
<div class="ter_tit">
	当前位置 > <a href="<?= geturl('troom/tools')  ?>">应用工具</a> > <a href="<?= geturl('troom/slock')  ?>">学生锁屏</a> > 查看锁屏
</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;">
<div class="work_mes">
	<ul>
		<li><a href="<?= geturl('troom/slock')  ?>"><span>我的锁屏</span></a></li>
		<li><a href="<?= geturl('troom/slock/add')?>"><span>添加锁屏</span></a></li>
	</ul>
</div>
		<div id='atsrc' style="display: none;"></div>
		<div style="float:left;margin-top:10px;">
<form id="formdata">
	<input type="hidden" name="action" value="onlinecourse" />
	<table class="addteacher_tab" width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<th width=100><label>锁屏说明：</label></th>
		<td colspan="3">
			<input style="padding-left: 5px;" class="uipt w295" maxlength="25" name="title" id="title" type="text" value="<?=$slock['title']?>" onblur="teacher(this,'锁屏说明','title','','n','','','请输入锁屏说明。')">
			<span class="ts2" id="title_msg">请输入锁屏说明。</span>
		</td>
	  </tr>
	  
	   <tr>
		<th width=100><label>开始时间：</label></th>
		<td colspan="3">
			<input class="uipt w175" name="cdate" id="cdate" type="text" value="<?=date('Y-m-d H:i',$slock['startdate'])?>" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'%y-%M-%d %H:%m:%s'});" onblur="teacher(this,'锁屏开始时间','cdate','','n','','','请输入锁屏开始时间，不能早于当前时间。')"/>
			<span class="ts2" id="cdate_msg">请输入锁屏开始时间，不能早于当前时间。</span>
		</td>
	  </tr>
	     <tr>
		<th width=100><label>锁屏时长：</label></th>
		<td colspan="3">
			<?php
				$curduration = ($slock['enddate'] - $slock['startdate'])/60;
			 	$curduration = intval($curduration);
			?>
			<select id="duration" class="uipt w175" type="text"  maxlength="100" name="ctime" value="" >
				<option value="<?=$curduration?>"><?=$curduration?>分钟</option>
			</select>
			<span id="ctime_msg" class="ts2">锁屏持续时长</span>
		</td>
	  </tr>

	   <tr>
		<th width=100><label>结束时间：</label></th>
		<td colspan="3">
			<input class="uipt w175" name="enddate" id="enddate" type="text" value="<?=date('Y-m-d H:i',$slock['enddate'])?>" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'%y-%M-%d %H:%m:%s'});" onblur="teacher(this,'锁屏结束时间','enddate','','n','','','请输入锁屏开始时间，不能早于当前时间。')"/>
			<span class="ts2" id="enddate_msg">请输入锁屏结束时间，不能早于当前时间。</span>
		</td>
	  </tr>
		  <tr>
		<th><label>对象选择：</label></th>
		<td style="padding-top:14px">
            	<div id="xuanban" class="xuanban" style="background:#fff;">
					<h2 class="rbxht">
						<span style="float:left" id="gradetip" class="gradetip">请选择锁屏的<?=($flag==1)?'年':'班'?>级</span>
						<?php if(!empty($grades)){?>
							<a href="javascript:" class="bluebtn gradebtn" style="float:left;margin-left:200px;">按<?=($flag==1)?'班':'年'?>级锁屏</a> 
						<?php }?>
					</h2>
					<ul class="ulclass" style="<?=($flag==1)?'display:none;':''?>" >
						<?php foreach ($classes as $class) {?>
							<li style="cursor:pointer;"><input class="goxua"  type="checkbox" <?=!empty($class['checked'])?'checked=checked':''?> name="classes[]" title="<?=$class['classname']?>" value="<?=$class['classid']?>:<?=$class['grade']?>:<?=$class['district']?>"><span><?=$class['classname']?></span></li>
						<?php }?>
					</ul>
					<?php if(!empty($grades)){?>
					<ul class="ulgrade" style="<?=($flag==0)?'display:none;':''?>">
						<?php foreach ($grades as $grade) {?>
							<li style="cursor:pointer;"><input class="mygrade" type="checkbox" <?=!empty($grade['checked'])?'checked=checked':''?> name="grades[]" title="<?=$grade['gradename']?>" value="<?=$grade['grade']?>:<?=$grade['district']?>"><span><?=$grade['gradename']?></span></li>
						<?php }?>
					</ul>
					<?php }?>
					<input type="hidden" name='flag' id='flag' value="<?=$flag?>" />
					<input type="hidden" name='lockid' id='lockid' value="<?=$slock['lockid']?>" />
				</div>
        </td>
	  </tr>
	  <tr>
	  	<th></th>
		<td colspan="3"><a href="javascript:history.back()" class="lanbtn" name=""  value="返回" type="submit" />返回</a></td>
	  </tr>
	 </table>
 </form>
</div>
</div>
<script>
$(function(){
	$(':input').attr('disabled','disabled');
	$('input:gt(1):lt(2)').attr('style','width:295px;');
	$('select').attr('style','width:302px;');
})
</script>
<?php $this->display('troom/page_footer');?>