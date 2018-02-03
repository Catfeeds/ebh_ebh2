<?php $this->display('troomv2/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />

<div class="ter_tit">
当前位置 > <a href="<?=geturl('troomv2/teachingplan')?>">电子教案</a> > <a href="<?=geturl('troomv2/teachingplan/manage')?>">教案管理</a> > 编辑教案
</div>

<style>
.topname {
	width:430px;
	border:none;
	border-bottom:solid 1px #666;
	height:40px;
	color:#666;
	line-height:40px;
	font-size:16px;
	font-weight:bold;
	text-align:center;
	margin:5px 0 5px 140px;
}
.duantxt {
	width:130px;
	border:none;
	border-bottom:solid 1px #666;
	color:#666;
	height:30px;
	line-height:30px;
	text-align:center;
	margin:5px 0;
	float:left;
}
.lefbian {
	width:70px;
	float:left;
	color:#666;
	margin:5px 0;
	height:30px;
	line-height:30px;
	text-align:right;
}
.zhumai{
	-border:1px solid #ddd;
	padding-top:10px;
	padding-left:10px;
}
.nounder {
	border-bottom:none;
}
</style>

<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
	<input class="topname" id="title" type="text" value="<?=urldecode($tplandetail['title'])?>" />
  <br />
  <div style="width:760px;height:40px">
  <span class="lefbian" style="margin-left:150px;">编写时间：</span><span id="dateline" class="duantxt nounder"><?=Date('Y-m-d H:i:s',$tplandetail['dateline'])?></span>
  <span class="lefbian">编写人：</span><span id="username" class="duantxt nounder" ><?=$tplandetail['realname']?></span>
	</div>
	<div class="zhumai">
	
	<?php $editor->xEditor('content','98%','500px',$tplandetail['content']); ?>

	</div>
	<a class="huangbtn" style="margin:10px 0 0 10px" id="searchbutton" name="savebutton" href="javascript:;" onclick="saveTP()">保存教案</a>
</div>

<script type="text/javascript">
	var leaveflag = 0;
	
	$("input").change(function(){
		leaveflag = 1;
	});
	UM.getEditor('content').addListener("contentChange",function(){
		leaveflag = 1;
	});
	window.onbeforeunload=stoprefresh;
	function stoprefresh() 
	{
		if(leaveflag==1)
			return "不保存就离开的话，你将失去所编辑的内容"; 
		else
			return;
	} 
	
	function datetime_to_unix(datetime){
	    var tmp_datetime = datetime.replace(/:/g,'-');
	    tmp_datetime = tmp_datetime.replace(/ /g,'-');
	    var arr = tmp_datetime.split("-");
	    var now = new Date(Date.UTC(arr[0],arr[1]-1,arr[2],arr[3]-8,arr[4],arr[5]));
	    return parseInt(now.getTime()/1000);
	}
	
	function saveTP()
	{
		leaveflag = 0;
		var title = $("#title").val();
		var content = UM.getEditor('content').getContent();
		var tpid = <?=$tplandetail['tpid']?>;
		$.ajax({
			type:"post",
			data:{"tpid":tpid,"title":title,"content":content},
			dataType:"text",
			success:function(data){
				if(data=="1"){
					$.showmessage({
						message:'教案保存成功！',
						callback :function(){
                            document.location.href = "<?=geturl('troomv2/teachingplan/manage')?>";
                        }});
				}
				else
					$.showmessage({message:'教案保存失败！'});
			}
		});
	}
</script>