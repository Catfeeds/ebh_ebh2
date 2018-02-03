<?php $this->display('troomv2/page_header');?>
<style>
 	.lefrig .work_mes .workBtn {display:block;float:right;width:100px;height:32px;line-height:32px;text-align:center;color:#FFFFFF;background:#18a8f7;text-decoration:none;cursor:pointer;border:none;font-size: 14px;font-weight: bold;}
 	.lefrig .work_mes .workBtn:hover{background:#0d9be9;color:#fff;text-decoration: none;font-size: 14px;font-weight: bold;}
</style>
<div class="ter_tit">
当前位置 > <a href="<?= geturl('troomv2/online')  ?>">在线直播</a> > 所有直播
<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="title"  class="newsou" <?=$stylestr?> id="title" value="<?=empty($q)?'':$q?>" type="text" />
	<input id="ser" onclick="_search()" type="button" class="soulico" value="">
</div>
</div>

</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;">
<div class="work_mes">
	<ul>
		<li class="workcurrent"><a href="<?= geturl('troomv2/online/my') ?>"><span>所有直播</span></a></li>
		<li><a href="<?= geturl('troomv2/online/mycourse')  ?>"><span>我的直播</span></a></li>
		<li><a href="<?= geturl('troomv2/online/add')?>"><span>添加直播</span></a></li>

	</ul>

</div>
    <table class="datatab" width="100%" STYLE="border:none;">
	   <thead class="tabheads">
	   <tr style="color:#666;border-bottom:1px solid #efefef;">
       <th style="width:33%;padding-left:10px;text-align:left; ">课程名称</th> 
       <th style="width:25%; text-align:left; ">直播时间</th> 
       <th style="width:10%; text-align:left; ">直播时长</th> 
       <th style="width:12%;text-align:left; ">主讲</th> 
       <th style="width:20%;text-align:left; ">操作</th> 
		</tr>
	</table>			
	<table  width="100%" style="border-bottom:1px solid #efefef;">
	<?php foreach ($courseList as $value) {?>
		<tr style="border-bottom:1px solid #efefef;" onmouseout="this.bgColor='#ffffff'"onmouseover="this.bgColor='#f2f7ff'">
	      <td style=" height: 35px;"><a  href="/troomv2/online/edit.html?op=view&id=<?=$value['id']?>" style="padding:5px 10px 5px;width:52%;color:blue; cursor: pointer;font-size:12px;" title="$value['title']"><?=$value['title']?></a></td> 
			<?php if(time()>($value['cdate'])+$value['ctime']*60){?>
	       		<td style="padding:5px 0px;width:25%;text-align:left; "><span  style="color:red;"><?=date('Y-m-d H:i:s',$value['cdate'])?>（已过期）</span></td>
		   	<?php }else if((time()<($value['cdate']+$value['ctime']*60))&&(time()>($value['cdate']-$value['ctime']*60))){?>
		    	<td style="padding:5px 0px;width:25%;text-align:left; "><span style="color:green;">（正在直播）</span></td> 
			<?php }else{?>
				<td style="padding:5px 0px;width:25%;text-align:left; "><?=date('Y-m-d H:i:s',$value['cdate'])?></td>
			<?php }?>
		   <td style="padding:5px 0px;width:10%;text-align:left;  "><?=$value['ctime']?> 分钟</td> 
		   <td style="padding:5px 0px;width:12%;text-align:left;  "><?=$value['tname']?></td> 
		   <td style="text-align:left;width:20%;" ><a href="/troomv2/online/edit.html?op=view&pos=all&id=<?=$value['id']?>" class="btnsuo" >查看</a>
		   <?php if($user['uid']==$value['tid']){?>
		   	<a href="javascript:" onclick="return degroup('<?=$value["id"]?>','<?=$value["title"]?>')" style="margin-left:0;margin-right:5px;" class="btnshan">删除</a>
		   		<?php if(time()<=($value['cdate'])+$value['ctime']*60){?>
		   			<a href="/troomv2/online/edit.html?pos=all&id=<?=$value['id']?>" class="workBtn" style="margin:0;">修改</a>
		   		<?php }?>
		   <?php }?>
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
			url:"/troomv2/online/delete.html",
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
function _search(){
	var q = $("#title").val();
	if(q=='请输入关键字'){
		q='';
	}	
	location.href='/troomv2/online.html?q='+q;
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