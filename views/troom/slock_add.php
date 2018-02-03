<?php $this->display('troom/page_header');?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js?version=20150506001"></script>
<style>
	.xuanban {width:482px;height:165px;background:url(http://static.ebanhui.com/static/images/topbgj1203.jpg) no-repeat;border:solid 1px #b1d1e7;padding:10px;overflow-y: auto;}
	.xuanban .rbxht {height:38px;line-height:38px;font-weight:bold;border-bottom:solid 1px #e5e5e5;color:#2f59ab;}
	.xuanban li{color:#646464;height:35px;line-height:35px;font-size:14px;float:left;font-weight:bold;white-space: nowrap;margin-right:23px;display:inline;width:188px;}
	.goxua,.mygrade{float:left;margin-top:10px;_margin-top:6px;margin-right:5px;_margin-right:0px;}
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
	当前位置 > <a href="<?= geturl('troom/tools')  ?>">应用工具</a> > <a href="<?= geturl('troom/slock')  ?>">学生锁屏</a> > 添加锁屏
</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;">
<div class="work_mes">
	<ul>
		<li><a href="<?= geturl('troom/slock')  ?>"><span>我的锁屏</span></a></li>
		<li class="workcurrent"><a href="<?= geturl('troom/slock/add')?>"><span>添加锁屏</span></a></li>
		
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
			<input style="padding-left: 5px;" class="uipt w295" maxlength="25" name="title" id="title" type="text" value="" onblur="teacher(this,'锁屏说明','title','','n','','','请输入锁屏说明。')">
			<span class="ts2" id="title_msg">请输入锁屏说明。</span>
		</td>
	  </tr>
	  
	   <tr>
		<th width=100><label>开始时间：</label></th>
		<td colspan="3">
			<input class="uipt w175" name="cdate" id="cdate" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'%y-%M-%d %H:%m:%s'});" onblur="teacher(this,'锁屏开始时间','cdate','','n','','','请输入锁屏开始时间，不能早于当前时间。');checkdate();"/>
			<span class="ts2" id="cdate_msg">请输入锁屏开始时间，不能早于当前时间。</span>
		</td>
	  </tr>
	     <tr>
		<th width=100><label>锁屏时长：</label></th>
		<td colspan="3">
			<select id="duration" class="uipt w175" type="text"  maxlength="100" name="ctime" value="" >
				<option value="0">请选择</option>
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
				</select>
			<span id="ctime_msg" class="ts2">锁屏持续时长</span>
		</td>
	  </tr>

	   <tr>
		<th width=100><label>结束时间：</label></th>
		<td colspan="3">
			<input class="uipt w175" name="enddate" id="enddate" type="text" value="" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'#F{$dp.$D(\'cdate\',{m:5})||\'%y-%M-%d {%H}:{%m+5}:%s\'}'});" onblur="teacher(this,'锁屏结束时间','enddate','','n','','','请输入锁屏开始时间，不能早于当前时间。');checkdate();"/>
			<span class="ts2" id="enddate_msg">请输入锁屏结束时间，不能早于当前时间。</span>
		</td>
	  </tr>
		  <tr>
		<th><label>对象选择：</label></th>
		<td style="padding-top:14px">
            	<div id="xuanban" class="xuanban" style="background:#fff;">
					<h2 class="rbxht">
						<span style="float:left" id="gradetip" class="gradetip">请选择锁屏的班级</span>
						<?php if(!empty($grades)){?>
							<a href="javascript:" class="bluebtn gradebtn" style="float:left;margin-left:200px;">按年级锁屏</a> 
						<?php }?>
					</h2>
					<ul class="ulclass">
						<?php foreach ($classes as $class) {?>
							<li><input class="goxua"  type="checkbox" name="classes[]" title="<?=$class['classname']?>" value="<?=$class['classid']?>:<?=$class['grade']?>:<?=$class['district']?>"><span  style="cursor:pointer;"><?=$class['classname']?></span></li>
						<?php }?>
					</ul>
					<?php if(!empty($grades)){?>
					<ul class="ulgrade" style="display:none;">
						<?php foreach ($grades as $grade) {?>
							<li><input class="mygrade" type="checkbox" name="grades[]" title="<?=$grade['gradename']?>" value="<?=$grade['grade']?>:<?=$grade['district']?>"><span  style="cursor:pointer;"><?=$grade['gradename']?></span></li>
						<?php }?>
					</ul>
					<?php }?>
					<input type="hidden" name='flag' id='flag' value='0' />
				</div>
        </td>
	  </tr>
	  <tr>
	  	<th></th>
		<td colspan="3"><a class="lanbtn" name="" onclick="return beforesubmit()" value="提交" type="submit" />提交</a></td>
	  </tr>
	 </table>
 </form>
</div>
</div>
<script>
	$('.rbxht a').click(function(){
		$('.ulclass').toggle();
		$('.ulgrade').toggle();
		if($('#flag').val()==1){
			$('#flag').val(0);
			$('#gradetip').html('请选择锁屏的班级');
			$(this).html("按年级锁屏");
		}else{
			$('#flag').val(1);
			$('#gradetip').html('请选择锁屏的年级');
			$(this).html("按班级锁屏");
		}
	});

	var issubmiting = false;
	function beforesubmit(){
		if(issubmiting){
			return;
		}
		issubmiting = true;
		if(!$("#title").val()){
			$("#title").val(getDefaultTitle());
		}
		//===检测
		if(!slock_submit('online')){
			var issubmiting = false;
			return false;
		}
		var len1 = $('ul.ulclass:visible :checkbox:checked').length;
		var len2 = $('ul.ulgrade:visible :checkbox:checked').length;
		if((len1==0)&&len2==0){
			alert('请选择锁屏对象');
			return false;
		}
		$.post("/troom/slock/add.html",{param:$("#formdata").serialize()},function(res){
				if(res.status == 0){
					$.showmessage({
						message:res.msg,
						callback :function(){
                            document.location.href = "/troom/slock.html";
                        }});
				}
				else{
					$.showmessage({message:res.msg});
					issubmiting = false;
				}
		},"json");
	}

	$("#duration").on('change',function(){
		var me = this;
		if(!$("#cdate").val()){
			$("#cdate").val(makeTime());
			var timestamp = Date.parse(new Date());
		}else{
			var timestamp = strtotime($("#cdate").val()+':00')*1000;
		}
		var duration = 60*$(me).val()*1000;
		$("#enddate").val(makeTime(duration+timestamp));
	});

	$(function(){
			$('input:gt(1):lt(2)').attr('style','width:295px;');
			$('select').attr('style','width:302px;');
	});	

	function strtotime(str){
		var new_str = str.replace(/:/g,'-');
		new_str = new_str.replace(/ /g,'-');
		var arr = new_str.split("-");
		var systime = new Date(Date.UTC(arr[0],arr[1]-1,arr[2],arr[3]-8,arr[4],arr[5]));
		return systime.getTime()/1000;
	}

	function makeTime(timestamp)
    { 
    	if(timestamp){
        	var now = new Date(timestamp);
    	}else{
    		var now = new Date();
    	}
       
        var year = now.getFullYear();       //年
        var month = now.getMonth() + 1;     //月
        var day = now.getDate();            //日
       
        var hh = now.getHours();            //时
        var mm = now.getMinutes();          //分
       
        var clock = year + "-";
       
        if(month < 10)
            clock += "0";
       
        clock += month + "-";
       
        if(day < 10)
            clock += "0";
           
        clock += day + " ";
       
        if(hh < 10)
            clock += "0";
           
        clock += hh + ":";
        if (mm < 10) clock += '0'; 
        clock += mm; 
        return(clock); 
    }

function slock_submit(type,param)
{
	var bein_ids = new Array();
	var bedo = new Array();
	var bsubmit = true;
	if(type == 'online'){
		
		bein_ids[0] = 'title';
		bedo[0] = teacher('title','锁屏说明','title','','n','','','请输入锁屏说明。');
		bein_ids[1] = 'cdate';
		bedo[1] = teacher('cdate','开始时间','cdate','','n','','','请输入锁屏开始时间，不能早于当前时间。');
		bein_ids[2] = 'enddate';
		bedo[2] = teacher('enddate','结束时间','enddate','','n','','','请输入锁屏结束时间，不能早于当前时间。');
	}
	var j = 0;
		for(j = 0; j < bein_ids.length; j ++){
			var tmp = $("#"+bein_ids[j]+"_msg").html();
			if(tmp != null && tmp.match(/^</)){	//提示信息中如果包含了html标签，那么就是错误的
				bsubmit = false;
				break;
		}	
	}
	return bsubmit;
}
$("li span").on('click',function(){
	$(this).parent().find('input').click();
});

function checkdate(){
	var cdate = strtotime($("#cdate").val()+':00');
	var enddate = strtotime($("#enddate").val()+':00');
	if(cdate > enddate){
		var endval = $("#enddate").val();
		$("#enddate").val($("#cdate").val());
		$("#cdate").val(endval);
	}
	var duration = Math.abs((enddate-cdate)/60);
	if(isNaN(duration)){
		$("#duration").val(0);
		return ;
	}
	if($("#duration option[value="+duration+"]").length){
		$("#duration").val(duration);
		return;
	}
	if($("#tmpoption").length){
		$("#tmpoption").val(duration);
		$("#tmpoption").html(duration+"分钟");
	}else{
		var _html = '<option id="tmpoption" value="'+duration+'">'+duration+'分钟</option>';
		$("#duration").append(_html).val(duration);
	}
	$("#duration").val(duration);
}

function getDefaultTitle(){
	if($("#flag").val() == 0){
		var $checkedTarget = $("#xuanban input[name='classes[]']:checked");
	}else{
		var $checkedTarget = $("#xuanban input[name='grades[]']:checked");
	}
	var len = $checkedTarget.length;
	var nameElements = new Array();
	var cdate = strtotime($("#cdate").val()+':00');
	var enddate = strtotime($("#enddate").val()+':00');
	var duration = Math.abs((enddate-cdate)/60);
	if(isNaN(duration)){
		duration = 0;
	}
	nameElements.push('['+duration+'分钟]');
	for(var i =0;i<len;i++){
		nameElements.push($checkedTarget[i].title);
	}
	return nameElements.join('_')
}
</script>
<?php $this->display('troom/page_footer');?>