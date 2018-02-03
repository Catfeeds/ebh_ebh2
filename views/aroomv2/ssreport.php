<?php $this->display('aroomv2/page_header')?>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<script src="http://static.ebanhui.com/ebh/js/jquery/jquery.fileDownload.js?version=20150307001"></script>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<style>
	a.btnx {
		background: #f57b24;
		height: 20px;
		line-height: 20px;
		width: 82px;
		border: solid 1px #e86b12;
		color: #fff;
		cursor: pointer;
		margin-top: 9px;
		margin-left:15px;
		text-align: center;
		text-decoration: none;
		display: block; 
	}
	a.btnx:hover {
		background:#e86b12;
	}
	.float_left{
		float: left;
	}
	.float_right{
		float: right;
	}
	.datainput{
		border: 1px solid #9EB7CB;
		height: 20px;
		line-height: 20px;
		padding-left: 5px;
		text-align: center;
		width:90px;
	}
	.searchbtnx {
		float:right;
		padding-right: 15px;
	}
	.tabhead th{
		font-weight:normal;
	}
</style>

	<div class="ter_tit">
        当前位置 > <a href="/aroomv2/report.html">统计分析</a> > <a href="/aroomv2/student/viewnav.html">学生查看</a> > 导出学生学习记录
    </div>
	<div class="expstuleareco mt10">
		<div class="expstuleareco_top">
			<div class="expstuleareco_top_l fl">
				<div class="fl">
                    <span style="font-size:14px; color:#333;">时间段：</span>
                    <input id="starttime" class="readonly inp" readonly="readonly" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'endtime\',{d:-1})||\'<?=Date('Y-m-d',SYSTIME-86400)?>\'}'});" value="<?=empty($starttime_str)?'':$starttime_str?>"/>
                    <span style="font-size:14px; color:#333;">到</span>
					<input id="endtime" class="readonly inp" readonly="readonly" type="text"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'starttime\',{d:1})}',maxDate:'<?=Date('Y-m-d',SYSTIME)?>'});" value="<?=empty($endtime_str)?'':$endtime_str?>"/>
                </div>
                <div class=" fl" style="margin:0 0 0 8px;"><a href="javascript:void(0)" onclick="dosearch()" class="workBtns workBtns-1">确 定</a></div>
            </div>
            <div class="expstuleareco_top_r fr ml25" style="line-height:32px;"><a class="" href="javascript:void(0)" onclick="doexport($(this).attr('requesturl'))" requesturl = "/aroomv2/report/outexcelByJava.html?classid=<?=$classid?>&starttime=<?=$starttime_str?>&endtime=<?=$endtime_str?>&outType=exportstu"> 导出excel</a></div>
            <div class="expstuleareco_top_r fr ml25" style="line-height:32px;"><a class="" href="javascript:void(0)" onclick="donexport($(this).attr('requesturl'))" requesturl = "/aroomv2/report/outexcelByJava.html?starttime=<?=$starttime_str?>&endtime=<?=$endtime_str?>&outType=exportclass"> 按班级导出excel</a></div>
        </div>
        <div class="clear"></div>

<div class="expstuleareco_bottom ">
<table class="datatab" width="100%">
<thead class="tabhead">
<tr style="">
<th>学生账号</th>
<th>姓名</th>
<th>班级</th>
<th>课程</th>
<th>学习时间</th>
<th>学习次数</th>
</tr>
</thead>
<tbody>

	<?php if(!empty($studylist)){
		$lastusername = '';
		$timesum = 0;
		$countsum = 0;
		foreach($studylist as $k=>$sl){
			$timesum += $sl['stime'];
			$countsum += $sl['scount'];
			if($k==(count($studylist)-1))
				$endflag = 1;
			if($sl['username'] != $lastusername){
				$lastusername = $sl['username'];
				
	?>
		
		<tr>
		<td width="100px" style="border-bottom:none;"><a href="javascript:void(0)" onclick="showlog_dialog(<?=$sl['uid']?>)"><?=!empty($sl['username'])?$sl['username']:''?></a></td>
		<td width="100px" style="border-bottom:none;"><a href="javascript:void(0)" onclick="showlog_dialog(<?=$sl['uid']?>)"><?=!empty($sl['realname'])?$sl['realname']:''?></a></td>
		<td width="100px" style="border-bottom:none;"><?=!empty($sl['classname'])?$sl['classname']:''?></td>
		<?php if(!empty($sl['tag'])){?>
			<td width="200px" style="border-bottom:none;"><span><?=!empty($sl['foldername'])?$sl['foldername']:''?></span></td>
		<?php }else{?>
			<td width="200px" style="border-bottom:none;"><a href="javascript:void(0)" onclick="showlog_dialog(<?=$sl['uid']?>,<?=$sl['folderid']?>)"><?=!empty($sl['foldername'])?$sl['foldername']:''?></a></td>
		<?php }?>
		<td width="120px" style="border-bottom:none;"><?=!empty($sl['stime'])?secondToStr($sl['stime']):'0秒'?></td>
		<td width="80px" style="border-bottom:none;"><?=!empty($sl['scount'])?$sl['scount']:'0'?></td>
		</tr>
	<?php }else{
	?>
		<tr >
		<td width="100px" style="border-top:none;border-bottom:none;"></td>
		<td width="100px" style="border-top:none;border-bottom:none;"></td>
		<td width="100px" style="border-top:none;border-bottom:none;"></td>
		<td width="200px" style="border-top:none;border-bottom:none;"><a href="javascript:void(0)" onclick="showlog_dialog(<?=$sl['uid']?>,<?=$sl['folderid']?>)"><?=!empty($sl['foldername'])?$sl['foldername']:''?></a></td>
		<td width="120px" style="border-top:none;border-bottom:none;"><?=!empty($sl['stime'])?secondToStr($sl['stime']):'0秒'?></td>
		<td width="80px" style="border-top:none;border-bottom:none;"><?=!empty($sl['scount'])?$sl['scount']:'0'?></td>
		</tr>
	<?php }if(empty($studylist[$k+1]) || $sl['username']!=$studylist[$k+1]['username'] ){
		?>
		<tr>
		<td colspan="3" style="border-top:none;"></td>
		<td style="border-top:none;">总计:</td>
		<td style="border-top:none;" ><?=!empty($timesum)?secondToStr($timesum):'0秒'?></td>
		<td style="border-top:none;"><?=$countsum?></td>
		</tr>
	<?php
		$timesum = 0;
		$countsum = 0;
		}
	}?>
	
	<?php }else{?>

	<tr><td colspan="6" align="center">暂无记录</td></tr>
	<?php }?>

</tbody>
</table>
<?=$pagestr?>
</div>

<!--添加班级-->
<div id="sgrade" style="display:none;height:90px">
<div class="addclass">
	<?php if(!in_array($roominfo['isschool'],array(1,2)) && !empty($roominfo['grade'])){?>
	<div class="xznj mt15" id="class_add_grade">
		<span style="display: inline;vertical-align: middle;float: left;padding-left: 16px;">年　　级：</span>
		<div style="width:70px; float:left;"><label style=" "><input style="width:26px;" type="radio" value="0" name="grade_add" checked=""/>不选</label></div>
		<?php if($roominfo['grade']==1){
				$gradearr = array('一年级','二年级','三年级','四年级','五年级','六年级');
				for($i=1;$i<7;$i++){
					if($i!=4)
						echo '<div style="width:70px; float:left;"><label style=" "><input style="width:26px;" type="radio" value="'.$i.'" name="grade_add" />'.$gradearr[$i-1].'</label></div>';
					else
						echo '<div style="width:70px; float:left;" class="pads"><label style=" "><input style="width:26px;" type="radio" value="'.$i.'" name="grade_add" />'.$gradearr[$i-1].'</label></div>';
				}
			}elseif($roominfo['grade']==7){
				$gradearr = array('初一','初二','初三');
				for($i=7;$i<10;$i++){
					echo '<div style="width:70px; float:left;"><label style=""><input style="width:26px;" type="radio" value="'.$i.'" name="grade_add" />'.$gradearr[$i-7].'</label></div>';
				}
			}elseif($roominfo['grade']==10){
				$gradearr = array('高一','高二','高三');
				for($i=10;$i<13;$i++){
					echo '<div style="width:70px; float:left;"><label style=" "><input style="width:26px;" type="radio" value="'.$i.'" name="grade_add" />'.$gradearr[$i-10].'</label></div>';
				}
			}
		?>
		
	</div>
	<?php }?>
</div>
</div>

<id id="export"></id>
<script>
	function dosearch(){
		var starttime = $("#starttime").val();
		var endtime = $("#endtime").val();
		var url = "/aroomv2/report/ssreport-1-0-0-<?=!empty($classid)?$classid:0?>.html?starttime="+starttime+"&endtime="+endtime;
		location.href = url;
	}

	function showlog_dialog(uid,folderid){
		var starttime = $("#starttime").val();
		var endtime = $("#endtime").val();
		if(typeof folderid != "undefined"){
			if(folderid == 0){
				return;
			}
			var url = "/aroom/astulog/astuloglist_fordialog-1-0-0-"+uid+"-"+folderid+".html?starttime="+starttime+"&endtime="+endtime;
		}else{
			var url = "/aroom/astulog/astuloglist_fordialog-1-0-0-"+uid+".html?starttime="+starttime+"&endtime="+endtime;
		}
			if(parent.window.H.get('slogDialog')){
				parent.window.H.get('slogDialog').exec('show');
				$("#logframe",parent.window.document.body).attr("src",url);
			}else{
				parent.window.createDialog(url);
			}
	}

	function doexport(url){
		new window.exportTools(url).run();
	}
	//选择年级弹框
	function donexport(url){
		if($('#sgrade input[name=grade_add]').length == 0){
			doexport(url);
		}else{
			var button = new xButton();
			button.add({
				value:"确定",
				callback:function(){
					var grade = $('input[name=grade_add]:checked').val();
					url+= '&grade='+grade;
					doexport(url);
					return false;
				},
				autofocus:true
			});

			button.add({
				value:"取消",
				callback:function(){
					H.get('dsgrade').exec('close');
					return false;
				}
			});
			if(!H.get('dsgrade')){
				H.create(new P({
					id : 'dsgrade',
					title: '选择班级',
					easy:true,
					width:400,
					padding:5,
					content:$('#sgrade')[0],
					button:button
				}),'common');
			}
			H.get('dsgrade').exec('show');
		}
	}

	var exportTools = function(url){
	this.url = url;
	this.url = url;
	this.init();
}
exportTools.loadModal = function(off_on){
	if(off_on){
		if(H.get('loadDialog')){
			H.get('loadDialog').exec('setContent','正在为您导出，请耐心等待').exec('show');
		}else{
			H.create(new P({
				content:'正在为您导出，请耐心等待',
				id:'loadDialog',
				easy:true,
				padding:20
			}),'common').exec('show');
		}
	}else{
		H.get('loadDialog').exec('setContent','导出成功').exec('close',500);
	}
};
exportTools.delcookie = function(name){
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=exportTools.getcookie(name);
    if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
exportTools.getcookie = function(name){
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
    if(arr != null){
        return unescape(arr[2]);
    }else{
        return "";
    }
}
exportTools.prototype = {
	init:function(){
	},
	setUrl:function(url){
		this.url = url;
	},
	run:function(){
		this.doexport();
	},
	setSuccessCallback:function(sCallback){
		this.successCallback = sCallback;
	},
	setPrepareCallback:function(pCallback){
		this.prepareCallback = pCallback;
	},
	doexport:function (){
		var me = this;
		var tag = new Date().getTime();
		this.requrl = this.url+"&tag="+tag;
		this.prepareCallback(this.requrl);
		$.fileDownload(this.requrl,{
			'successCallback':me.successCallback,
			'cookieName':'ebh_export',
			'cookieValue':tag
		});
	},
	successCallback:function(url){
		exportTools.loadModal(0);
		exportTools.delcookie('ebh_export');
		var starttime = $("#starttime").val();
		var endtime = $("#endtime").val();
		var url = "/aroomv2/report/ssreport.html?starttime="+starttime+"&endtime="+endtime;
		location.href = url;
	},
	prepareCallback:function(url){
		exportTools.loadModal(1);
	}

}
</script>
<?php $this->display('aroomv2/page_footer')?>
