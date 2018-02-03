<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />

<div class="ter_tit">
当前位置 > <a href="<?=geturl('troom/teachingplan')?>">电子教案</a> > 录入教案
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
	<input class="topname" id="title" type="text" value="请输入教案名称" onblur="if($('#title').val()==''){$('#title').val('请输入教案名称').css('color','#666');}" onfocus="if($('#title').val()=='请输入教案名称'){$('#title').val('').css('color','#000');}"/>
  <br />
  <div style="width:760px;height:40px">
  <span class="lefbian" style="margin-left:150px;">编写时间：</span><span id="dateline" class="duantxt nounder"><?=Date('Y-m-d H:i:s')?></span>
  <span class="lefbian">编写人：</span><span id="username" class="duantxt nounder" ><?=$user['realname']?></span>
	</div>					
	<div class="zhumai">
	
	
<?php $c='<h3><span style="background-color:#00d5ff;font-size:16px;">目标　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　</span></h3>
<p>章　节：第　课（章）第　节 第　教时</p>
<p><b>课时安排</b></p>
<p><b><br />
</b></p>
<p><b>教学/复习　内容分析</b></p>
<p><b><br />
</b></p>
<p><b>教学/复习　目标</b></p>
<p><b><br />
</b></p>
<p><b>教学/复习　重点、难点</b></p>
<p><b><br />
</b></p>
<h3><span style="background-color:#00d5ff;font-size:16px;">过程　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　</span></h3>
<p><b>教学用具</b></p>
<p><b><br />
</b></p>
<p><b>教学/复习　方法涉及</b></p>
<p><b><br />
</b></p>
<p><b>教学/复习　过程</b></p>
<p><b><br />
</b></p>
<p><b>板书设计</b></p>
<p><b><br />
</b></p>
<p><b><br />
</b></p>
<h3><span style="background-color:#00d5ff;font-size:16px;">后记　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　</span></h3>
<p><b>课后作业</b></p>
<p><b><br />
</b></p>
<p><b>教学/复习　后记、心得</b></p>
<p><b><br />
</b></p>
<p><b><br />
</b></p>';?>
<?php $editor->xEditor('content','97%','500px',$c); ?>

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
		return ;
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
		//title = title.replace(/\\/g, '\\\\');
		
		var content = UM.getEditor('content').getContent();
		var dateline = datetime_to_unix($("#dateline").html());
		
		
		$.ajax({
			url:"<?=geturl('troom/teachingplan/add')?>",
			type:"post",
			data:{"title":title,"content":content,"dateline":dateline},
			dataType:"text",
			success:function(data){
				if(data=="1"){
					$.showmessage({
						message:'教案保存成功！',
						callback :function(){
                            document.location.href = "<?=geturl('troom/teachingplan/manage')?>";
                        }});
				}
				else
					$.showmessage({message:'教案保存失败！'});
			}
		});
	}
</script>
<?php $this->display('troom/page_footer'); ?>