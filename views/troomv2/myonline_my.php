<?php $this->display('troomv2/page_header');?>
<style>
#icategory {
    background: none repeat scroll 0 0 #F7FAFF;
    border-top: 1px solid #E1E7F5;
    padding: 6px 20px;
	_margin-bottom:-5px;
}
#icategory dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
#icategory dd {
    float: left;
    width: 645px;
}
.category_cont1 div a.curr, .price_cont div a:hover, .price_cont div a.curr {
	background: none repeat scroll 0 0 #FF5400;
	color: #FFFFFF;
	text-decoration: none;
}
.category_cont1 div a {
    color: #2C71AE;
    text-decoration: none;
    padding: 2px;
    cursor: pointer;
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
    overflow: hidden;
	padding:0 10px;
}
.key_word {
	padding: 6px 20px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	height:28px;
	border-bottom-color: #cdcdcd;
}
.key_word dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
.pbtns {
    background: url(http://static.ebanhui.com/ebh/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
    border: medium none;
    color: #333333;
    height: 20px;
    vertical-align: middle;
    width: 40px;
	cursor:pointer;
}	

 	.work_menuss .workBtn {display:block;float:right;width:100px;height:32px;line-height:32px;text-align:center;color:#FFFFFF;background:#18a8f7;text-decoration:none;cursor:pointer;border:none;font-size: 14px;font-weight: bold;}
 	.work_menuss .workBtn:hover{background:#0d9be9;color:#fff;text-decoration: none;font-size: 14px;font-weight: bold;}
</style>

<div class="ter_tit">
当前位置 > 在线直播 > 我的直播
		<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
			<input name="title" <?=$stylestr?> class="newsou" id="title" value="<?= $q ?>"/>
			<input id="ser"  onclick="_dosearch()" type="button" class="soulico" value="">
		</div>
</div>

</div>


<div class="lefrig" style="background:#fff;float:left;margin-top:15px;">
<div class="work_mes">
	<ul>
		<li class="workcurrent"><a href="<?= geturl('troomv2/myonline')  ?>"><span>我的直播</span></a></li>
		<!-- <li><a href="<?= geturl('troomv2/myonline/all')  ?>"><span>所有直播</span></a></li> -->
		<li><a href="<?= geturl('troomv2/myonline/add')?>"><span>添加直播</span></a></li>

	</ul>
</div>
    <table class="datatab" width="100%" style="border:none;">
	   <thead class="tabheads">
	   <tr style="color:#666;border-bottom:1px solid #efefef;">
       <th style="width:29%;padding-left:10px;text-align:left; ">课程名称</th>
       <th style="width:16%;padding-left:10px;text-align:left; ">所属科目</th>  
       <th style="width:25%; text-align:left; ">直播时间</th> 
       <th style="width:10%; text-align:left; ">直播时长</th> 
       <th style="width:20%;text-align:left; ">操作</th> 
		</tr>
	</table>			
	<?php $uname = $user['realname'];?>
	<table  width="100%" style="border-bottom:1px solid #efefef;">
	<?php foreach ($courseList as $value) {?>
		<tr onmouseout="this.bgColor='#ffffff'"	onmouseover="this.bgColor='#f2f7ff'" style="border-bottom:1px solid #efefef;">
	      <td style=" height: 35px;width:29%"><a  href="/troomv2/myonline/edit.html?op=view&id=<?=$value['id']?>" style="padding:5px 10px 5px;width:200px;word-wrap: break-word;float:left;color:blue; cursor: pointer;font-size:12px;" title="<?$value['title']?>"><?=$value['title']?></a></td> 
			<td><?=$value['foldername']?></td>
			<?php if(time()>($value['cdate'])+$value['ctime']*60){?>
	       		<td style="padding:5px 0px;width:25%;text-align:left; "><span  style="color:red;"><?=date('Y-m-d H:i:s',$value['cdate'])?>（已过期）</span></td>
		   	<?php }else if((time()<($value['cdate']+$value['ctime']*60))&&(time()>($value['cdate']-$value['ctime']*60))){?>
		    	<td style="padding:5px 0px;width:25%;text-align:left; "><span style="color:green;">（正在直播）</span></td> 
			<?php }else{?>
				<td style="padding:5px 0px;width:25%;text-align:left; "><?=date('Y-m-d H:i:s',$value['cdate'])?></td>
			<?php }?>
		   <td style="padding:5px 0px;width:10%;text-align:left;  "><?=$value['ctime']?> 分钟</td> 
		   <td style="text-align:left;width:20%;" >
		   <!-- <a href="/troomv2/myonline/edit.html?pos=my&op=view&id=<?=$value['id']?>" class="btnsuo" >查看</a> -->
		   <a href="javascript:" onclick="return degroup('<?=$value["id"]?>','<?=$value["title"]?>')" style="margin-left:0;margin-right:5px;" class="btnshan">删除</a>
		   <?php if(time()<=($value['cdate'])+$value['ctime']*60){?>
		   		<a href="/troomv2/myonline/edit.html?pos=my&id=<?=$value['id']?>" class="workBtn" style="margin-right:5px;height: 22px;line-height: 23px;">修改</a>
		   <?php }?>
		   <?php 
		   $ourl = "http://chat.ebh.net/webconf/room.htm?id=".$value['id']."&user=".$uname."&teach=".$uname."&type=t&key=".$key;?>
		   <a target=_blank href="<?=$ourl?>" class="btnsuo">进入</a>
		   </td>
		 
		</tr>
	<?php }?>

	</table>
</div>
<?=$pagestr?>
<script type="text/javascript">
function degroup(id,name) {
	$.confirm("您确定要删除在线直播课程 【" + name + "】 吗？",function(){
		$.ajax({
			url:"/troomv2/myonline/delete.html",
			type:'post',
			data:{'id':id},
			dataType:'text',
			success:function(data){
				if(data>0){
					alert("课程删除成功！");
					document.location.href = document.location.href;
				}else{
					alert("对不起，课程删除失败，请稍后再试或联系我们的客服！");
				}
			}
		});
	});
}
function enter(id) {
	$.ajax({
		url:"/troomv2/myonline/enter.html",
		type:'post',
		data:{'id':id},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				
			}else{
				
			}
		}
	});
}
function _dosearch(){
	var q = $("#title").val();
	if(q=='请输入关键字'){
		q='';
	}		
	location.href='/troomv2/myonline.html?q='+q;
}
var searchtext = "请输入关键字";
$(function() {
initsearch("title",searchtext);
   $("#ser").click(function(){
       var title = $("#title").val();
       if(title == searchtext) 
           title = "";
      
   });
   });
</script>
</body>
</html>