<?php $this->display('troom/page_header');?>
<style>
 	.work_menuss .workBtn {display:block;float:right;width:100px;height:32px;line-height:32px;text-align:center;color:#FFFFFF;background:#18a8f7;text-decoration:none;cursor:pointer;border:none;font-size: 14px;font-weight: bold;}
 	.work_menuss .workBtn:hover{background:#0d9be9;color:#fff;text-decoration: none;font-size: 14px;font-weight: bold;}
</style>
<div class="ter_tit">
当前位置 > 在线直播 > 所有直播
</div>
<div class="work_menuss">
	<ul>
		<li><a href="<?= geturl('troom/myonline')  ?>"><span>我的直播</span></a></li>
		<li class="workcurrent"><a href="<?= geturl('troom/myonline/all') ?>"><span>所有直播</span></a></li>
		<li><a href="<?= geturl('troom/myonline/add')?>"><span>添加直播</span></a></li>

	</ul>
</div>
<div class="annotate">
	<div class="tiezi_search" style="height:30px;">
			<label style="float:left;width:65px;padding-left:20px;">关键字：</label><input id="title" name="uname" type="text"  value="<?=empty($q)?'':$q?>" style="width:300px;float:left;"/>

			<a  class="souhuang" id="ser" onclick="_search()">搜 索</a>
		
			</div>
	</div>
</div>
<div class="lefrig" style="margin-top:10px;">
    <table class="datatab" width="100%">
	   <thead class="tabheads">
	   <tr style="color:#666;border-bottom:1px solid #efefef;">
       <th style="width:17%;padding-left:10px;text-align:left; ">课程名称</th>
       <th style="width:16%;padding-left:10px;text-align:left; ">所属科目</th>  
       <th style="width:25%; text-align:left; ">直播时间</th> 
       <th style="width:10%; text-align:left; ">直播时长</th> 
       <th style="width:12%;text-align:left; ">主讲</th> 
       <th style="width:20%;text-align:left; ">操作</th> 
		</tr>
	</table>			
	<table  width="100%" style="border-bottom:1px solid #efefef;">
	<?php foreach ($courseList as $value) {?>
		<tr style="border-bottom:1px solid #efefef;" onmouseout="this.bgColor='#ffffff'"onmouseover="this.bgColor='#f2f7ff'">
	       <td style=" height: 35px;width:138px"><a  href="/troom/myonline/edit.html?op=view&id=<?=$value['id']?>" style="padding:5px 10px 5px;width:52%;color:blue; cursor: pointer;font-size:12px;" title="$value['title']"><?=$value['title']?></a></td> 
			<td><?=$value['foldername']?></td>
			<?php if(time()>($value['cdate'])+$value['ctime']*60){?>
	       		<td style="padding:5px 0px;width:25%;text-align:left; "><span  style="color:red;"><?=date('Y-m-d H:i:s',$value['cdate'])?>（已过期）</span></td>
		   	<?php }else if((time()<($value['cdate']+$value['ctime']*60))&&(time()>($value['cdate']-$value['ctime']*60))){?>
		    	<td style="padding:5px 0px;width:25%;text-align:left; "><span style="color:green;">（正在直播）</span></td> 
			<?php }else{?>
				<td style="padding:5px 0px;width:25%;text-align:left; "><?=date('Y-m-d H:i:s',$value['cdate'])?></td>
			<?php }?>
		   <td style="padding:5px 0px;width:10%;text-align:left;  "><?=$value['ctime']?> 分钟</td> 
		   <td style="padding:5px 0px;width:12%;text-align:left;  "><?=$value['tname']?></td> 
		   <td style="text-align:left;width:20%;" >
		   	<!-- <a href="/troom/myonline/edit.html?op=view&pos=all&id=<?=$value['id']?>" class="btnsuo" >查看</a> -->
		   <?php if($user['uid']==$value['tid']){?>
		   	<a href="javascript:" onclick="return degroup('<?=$value["id"]?>','<?=$value["title"]?>')" style="margin-left:0;margin-right:5px;" class="btnshan">删除</a>
		   		<?php if(time()<=($value['cdate'])+$value['ctime']*60){?>
		   			<a href="/troom/myonline/edit.html?pos=all&id=<?=$value['id']?>" class="workBtn" style="margin-right:5px;">修改</a>
		   		<?php }?>
		   <?php }?>
		   <a href="javascript:void(0)" onclick="return enter(<?=$value['id']?>)" class="btnsuo">进入</a>
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
			url:"/troom/myonline/delete.html",
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
		url:"/troom/myonline/enter.html",
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
function _search(){
	var q = $("#title").val();
	if(q=='请输入关键字'){
		q='';
	}	
	location.href='/troom/myonline/all.html?q='+q;
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